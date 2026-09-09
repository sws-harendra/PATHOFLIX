<?php

namespace App\Http\Controllers;

use App\Models\TestReport;
use App\Models\Configuration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRGdImagePNG;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ReportPdfController extends Controller
{
    /**
     * Generate and stream the Lab Report PDF.
     */
    public function download(Request $request, $id, $template = 'new')
    {
        return $this->generateReport($request, $id, $template, false);
    }

    /**
     * Publicly stream/download a report via ID (bypass auth)
     */
    public function streamPublicLink($id)
    {
        $report = TestReport::where('invoice_id', $id)->first();
        if ($report && $report->pdf_path && \Illuminate\Support\Facades\Storage::disk('r2')->exists($report->pdf_path)) {
            // Get public URL from R2
            $url = \Illuminate\Support\Facades\Storage::disk('r2')->url($report->pdf_path);
            return redirect($url);
        }

        // If not pre-generated, generate now (and optionally save)
        return $this->generateReport(new Request(['header' => '1']), $id, 'new', true);
    }

    private function generateReport(Request $request, $invoiceId, $template, $isPublic = false)
    {
        // ── R2 Offload Check ────────────────────────────────────────────────
        // If this is a standard full report request, try to serve from R2
        /*
        if ($request->get('header', '1') === '1' && !$request->has('tests')) {
            $report = TestReport::where('invoice_id', $invoiceId)->first();
            if ($report && $report->pdf_path && \Illuminate\Support\Facades\Storage::disk('r2')->exists($report->pdf_path)) {
                return redirect(\Illuminate\Support\Facades\Storage::disk('r2')->url($report->pdf_path));
            }
        }
        */

        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '512M');

        // Load report with invoice_id (which is a string-based ID in this context)
        $report = TestReport::with([
            'invoice.patient.patientProfile',
            'invoice.collectionCenter',
            'invoice.doctor',
            'invoice.items.labTest',
            'results.labTest.dept'
        ])->where('invoice_id', $invoiceId)->firstOrFail();

        // Auth & Isolation check for non-public access
        if (!$isPublic) {
            $user = auth()->user();

            // 1. Company Isolation
            if ($report->invoice->company_id !== $user->company_id) {
                abort(403, 'Unauthorized company access.');
            }

            // 2. Patient Isolation: Patients can only see their own reports
            if ($user->hasRole('patient') && $report->invoice->patient_id !== $user->id) {
                abort(403, 'You are not authorized to view this report.');
            }

            // 3. Branch Isolation: If enabled, staff can only see their branch's reports
            $companyId = $user->company_id;
            $restrictBranch = Configuration::getFor('restrict_branch_access', '1', $companyId) === '1';
            $isGlobalAdmin = $user->hasAnyRole(['lab_admin', 'super_admin']);

            if ($restrictBranch && !$isGlobalAdmin && $report->invoice->branch_id !== $user->branch_id) {
                abort(403, 'You do not have access to reports from this branch.');
            }

            // 4. Partner Isolation: Doctors/Agents/CCs only see their referrals
            if (!$isGlobalAdmin && !$user->hasRole('patient')) {
                $isDoctor = $user->hasRole('doctor') || $user->doctorProfile;
                $isAgent = $user->hasRole('agent') || $user->agentProfile;
                $isCC = $user->hasRole('collection_center') || $user->collection_center_id;

                if ($isDoctor && $report->invoice->referred_by_doctor_id !== $user->id) {
                    abort(403, 'Unauthorized referral access.');
                }
                if ($isAgent && $report->invoice->referred_by_agent_id !== $user->id) {
                    abort(403, 'Unauthorized agent referral access.');
                }
                if ($isCC && $report->invoice->collection_center_id !== $user->collection_center_id) {
                    abort(403, 'Unauthorized collection center access.');
                }
            }
        }

        $companyId = $report->invoice->company_id;
        $showHeader = $request->get('header', '1') === '1';

        $headerImage = Configuration::getFor('pdf_header_image', null, $companyId);
        $footerImage = Configuration::getFor('pdf_footer_image', null, $companyId);
        $letterheadImage = Configuration::getFor('pdf_letterhead_image', null, $companyId);

        // ── Configuration settings ──────────────────────────────────────────
        $settings = [
            'pdf_background_mode' => Configuration::getFor('pdf_background_mode', 'header_footer', $companyId),
            'pdf_letterhead_image' => storage_base64($letterheadImage),
            'pdf_header_image' => storage_base64($headerImage),
            'pdf_footer_image' => storage_base64($footerImage),
            'report_signature_mode' => Configuration::getFor('report_signature_mode', null, $companyId) ?: 'global_bottom',

            'global_sig_1_enabled' => Configuration::getFor('global_sig_1_enabled', '1', $companyId) !== '0',
            'global_sig_1_name' => Configuration::getFor('authorized_signatory_name', null, $companyId) ?: 'Authorized Signatory',
            'global_sig_1_desig' => Configuration::getFor('authorized_signatory_designation', null, $companyId) ?: '',
            'global_sig_1_path' => storage_base64(Configuration::getFor('signature_image', null, $companyId)),

            'global_sig_2_enabled' => Configuration::getFor('global_sig_2_enabled', '1', $companyId) !== '0',
            'global_sig_2_name' => Configuration::getFor('global_sig_2_name', '', $companyId) ?: '',
            'global_sig_2_desig' => Configuration::getFor('global_sig_2_desig', '', $companyId) ?: '',
            'global_sig_2_path' => storage_base64(Configuration::getFor('global_sig_2_path', null, $companyId)),

            'global_sig_3_enabled' => Configuration::getFor('global_sig_3_enabled', '1', $companyId) !== '0',
            'global_sig_3_name' => Configuration::getFor('global_sig_3_name', '', $companyId) ?: '',
            'global_sig_3_desig' => Configuration::getFor('global_sig_3_desig', '', $companyId) ?: '',
            'global_sig_3_path' => storage_base64(Configuration::getFor('global_sig_3_path', null, $companyId)),
            'pdf_font_size' => Configuration::getFor('pdf_font_size', null, $companyId) ?: 13,
            'pdf_font_family' => Configuration::getFor('pdf_font_family', null, $companyId) ?: 'DejaVu Sans',

            // ALWAYS reserve space for physical letterhead (1 inch = ~96px minimum, but user wants settings-driven)
            'pdf_margin_top' => Configuration::getFor('pdf_margin_top', null, $companyId) ?: 320,
            'pdf_margin_bottom' => Configuration::getFor('pdf_margin_bottom', null, $companyId) ?: 280,
            'pdf_margin_left' => Configuration::getFor('pdf_margin_left', null, $companyId) ?: 25,
            'pdf_margin_right' => Configuration::getFor('pdf_margin_right', null, $companyId) ?: 25,

            'pdf_header_height' => Configuration::getFor('pdf_header_height', null, $companyId) ?: 200,
            'pdf_footer_height' => Configuration::getFor('pdf_footer_height', null, $companyId) ?: 180,
            'pdf_header_image' => ($request->get('header', '1') === '1' && $headerImage) ? storage_base64($headerImage) : null,
            'pdf_footer_image' => (Configuration::getFor('pdf_show_footer', '1', $companyId) === '1' && $footerImage) ? storage_base64($footerImage) : null,

            // Visibility
            'pdf_show_header' => Configuration::getFor('pdf_show_header', null, $companyId) !== '0',
            'pdf_show_footer' => Configuration::getFor('pdf_show_footer', null, $companyId) !== '0',
            'pdf_show_watermark' => Configuration::getFor('pdf_show_watermark', null, $companyId) === '1',
            'pdf_watermark_image' => storage_base64(Configuration::getFor('pdf_watermark_image', null, $companyId)),
            'pdf_show_method' => Configuration::getFor('pdf_show_method', '1', $companyId) === '1',
            'pdf_show_interpretation' => Configuration::getFor('pdf_show_interpretation', '1', $companyId) !== '0',
            'pdf_show_notes' => Configuration::getFor('pdf_show_notes', '1', $companyId) !== '0',
            'pdf_abnormal_bold_only_result_flag' => Configuration::getFor('pdf_abnormal_bold_only_result_flag', '0', $companyId) === '1',
            'pdf_vertical_spacing' => Configuration::getFor('pdf_vertical_spacing', 5, $companyId),
            'pdf_signature_offset' => Configuration::getFor('pdf_signature_offset', 185, $companyId),
            'pdf_page_break_mode' => Configuration::getFor('pdf_page_break_mode', 'test', $companyId),
        ];

        // ── Custom Page Breaks & Page Break Mode Override ───────────────────
        $pageBreakIds = null;
        if ($request->has('breaks')) {
            $rawBreaks = trim($request->get('breaks', ''));
            if ($rawBreaks !== '') {
                $pageBreakIds = array_values(array_filter(array_map('trim', explode(',', $rawBreaks))));
                // Only override to custom if page_break_mode is not already continuous / auto_fit, or if explicitly requested
                if (!empty($pageBreakIds) && !in_array($settings['pdf_page_break_mode'] ?? '', ['continuous', 'auto_fit'])) {
                    $settings['pdf_page_break_mode'] = 'custom';
                }
            }
        }

        // Determine final visibility (Setting toggle AND override via URL)
        $showHeaderSetting = (bool) ($settings['pdf_show_header'] ?? true);
        $showFooterSetting = (bool) ($settings['pdf_show_footer'] ?? true);

        $showHeader = $showHeaderSetting && ($request->get('header', '1') === '1');
        $showFooter = $showFooterSetting;

        // ── QR Code Generation ──────────────────────────────────────────────
        $publicUrl = route('public.report.download', ['hash' => base64_encode($report->invoice_id)]);
        $options = new QROptions([
            'version' => 5,
            'outputInterface' => QRGdImagePNG::class,
            'eccLevel' => EccLevel::L,
            'scale' => 4,
            'imageTransparent' => false,
        ]);
        $qrCodeUri = (new QRCode($options))->render($publicUrl);

        // ── Barcode Generation ──────────────────────────────────────────────
        $generator = new BarcodeGeneratorPNG();
        $barcodeBase64 = base64_encode($generator->getBarcode($report->invoice->invoice_number, $generator::TYPE_CODE_128, 2, 40));
        $barcodeUri = 'data:image/png;base64,' . $barcodeBase64;

        // ── Group Results ───────────────────────────────────────────────────
        $results = $report->results;
        $cultureResults = $report->cultureResults->load('labTest', 'antibiotics');
        
        if ($request->has('tests')) {
            $testIds = array_values(array_filter(array_map('trim', explode(',', $request->tests))));
            $results = $results->filter(function ($r) use ($testIds, $report) {
                $itemId = (string)($r->invoice_item_id ?: optional($report->invoice->items->firstWhere('lab_test_id', $r->lab_test_id))->id);
                return in_array($itemId, $testIds);
            });
            $cultureResults = $cultureResults->filter(function ($cr) use ($testIds, $report) {
                $itemId = (string)($cr->invoice_item_id ?: optional($report->invoice->items->firstWhere('lab_test_id', $cr->lab_test_id))->id);
                return in_array($itemId, $testIds);
            });
        }

        $allTests = collect();

        foreach ($results as $r) {
            if (empty($r->lab_test_id)) continue;
            // Group by lab_test_id only to merge results from duplicate invoice items (package + standalone overlap)
            $key = (string) $r->lab_test_id;
            if (!$allTests->has($key)) {
                $itemId = $r->invoice_item_id;
                if (empty($itemId)) {
                    $matchingItem = $report->invoice->items->firstWhere('lab_test_id', $r->lab_test_id);
                    $itemId = $matchingItem ? $matchingItem->id : null;
                }
                $allTests->put($key, [
                    'invoice_item_id' => $itemId,
                    'lab_test_id' => $r->lab_test_id,
                    'labTest' => $r->labTest,
                    'results' => collect(),
                    'cultureResult' => null
                ]);
            }
            // Avoid duplicate parameter rows (same parameter_name for same test)
            $existingParamNames = $allTests[$key]['results']->pluck('parameter_name')->toArray();
            if (!in_array($r->parameter_name, $existingParamNames)) {
                $allTests[$key]['results']->push($r);
            }
        }

        foreach ($cultureResults as $cr) {
            if (empty($cr->lab_test_id)) continue;
            $key = (string) $cr->lab_test_id;
            if (!$allTests->has($key)) {
                $itemId = $cr->invoice_item_id;
                if (empty($itemId)) {
                    $matchingItem = $report->invoice->items->firstWhere('lab_test_id', $cr->lab_test_id);
                    $itemId = $matchingItem ? $matchingItem->id : null;
                }
                $allTests->put($key, [
                    'invoice_item_id' => $itemId,
                    'lab_test_id' => $cr->lab_test_id,
                    'labTest' => $cr->labTest,
                    'results' => collect(),
                    'cultureResult' => $cr
                ]);
            } else {
                $item = $allTests[$key];
                $item['cultureResult'] = $cr;
                $allTests->put($key, $item);
            }
        }

        // ── Ordering & Department Grouping ──────────────────────────────────
        if ($request->has('tests')) {
            $testIds = array_values(array_filter(array_map('trim', explode(',', $request->tests))));
            $testIdOrder = array_flip($testIds);
            // Sort by order specified in ?tests=
            $allTests = $allTests->sortBy(function ($testData) use ($testIdOrder) {
                $itemId = (string)$testData['invoice_item_id'];
                return $testIdOrder[$itemId] ?? 999999;
            });

            // Group contiguous tests by department to strictly preserve the custom sequence
            $groupedResults = collect();
            $chunkIndex = 0;
            $currentDeptId = null;
            $currentChunk = collect();

            foreach ($allTests as $testData) {
                $deptId = $testData['labTest']->department_id ?? 0;
                if ($currentDeptId !== null && $deptId !== $currentDeptId) {
                    $groupedResults->put('group_' . $chunkIndex, [
                        'department' => $currentChunk->first()['labTest']->dept ?? null,
                        'tests' => $this->mapTestsForPdfGroup($currentChunk, $report),
                    ]);
                    $chunkIndex++;
                    $currentChunk = collect();
                }
                $currentDeptId = $deptId;
                $currentChunk->push($testData);
            }

            if ($currentChunk->isNotEmpty()) {
                $groupedResults->put('group_' . $chunkIndex, [
                    'department' => $currentChunk->first()['labTest']->dept ?? null,
                    'tests' => $this->mapTestsForPdfGroup($currentChunk, $report),
                ]);
            }
        } else {
            // Sort by invoice_item_id to preserve the bill/cart insertion order
            $allTests = $allTests->sortBy('invoice_item_id');

            $groupedResults = $allTests->groupBy(function ($testData) {
                return $testData['labTest']->department_id ?? 0;
            })->map(function ($deptGroup) use ($report) {
                return [
                    'department' => $deptGroup->first()['labTest']->dept ?? null,
                    'tests' => $this->mapTestsForPdfGroup($deptGroup, $report),
                ];
            });
        }

        // ── Effective Report Date for Patient Info Box ───────────────────────
        $printedItemIds = $allTests->pluck('invoice_item_id')->filter()->unique()->toArray();
        $customReportedAt = null;

        if (!empty($printedItemIds)) {
            $printedItems = $report->invoice->items->whereIn('id', $printedItemIds);
            if (count($printedItemIds) === 1) {
                // If a single test was printed, show that test's reported_at
                $customReportedAt = $printedItems->first()?->reported_at;
            } else {
                // If multiple tests are printed:
                // Check if all printed items have the same reported_at
                $distinctDates = $printedItems->whereNotNull('reported_at')->map(fn($it) => $it->reported_at->format('Y-m-d H:i'))->unique();
                if ($distinctDates->count() === 1) {
                    $customReportedAt = $printedItems->whereNotNull('reported_at')->first()?->reported_at;
                } else {
                    // Fallback to global approved_at / expected_report_time
                    $customReportedAt = $report->approved_at ?: $report->invoice->expected_report_time;
                }
            }
        }

        $effectiveReportDate = $customReportedAt 
            ?: ($report->approved_at ?: ($report->invoice->expected_report_time ?: now()));

        $viewName = 'pdf.report-' . $template;
        if (!view()->exists($viewName)) {
            $viewName = 'pdf.report-new';
        }

        $pdf = Pdf::loadView($viewName, [
            'report' => $report,
            'reportDate' => $effectiveReportDate,
            'invoice' => $report->invoice,
            'patient' => $report->invoice->patient,
            'profile' => $report->invoice->patient->patientProfile,
            'groupedResults' => $groupedResults,
            'settings' => $settings,
            'company' => $report->invoice->company,
            'showHeader' => $showHeader,
            'showFooter' => $showFooter,
            'qrCodeUri' => $qrCodeUri,
            'barcodeUri' => $barcodeUri,
            'pageBreakIds' => $pageBreakIds,
        ])->setPaper('A4', 'portrait');

        $filename = 'Report_' . str_replace(' ', '_', $report->invoice->patient->name)
            . '_' . $report->invoice->invoice_number . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Stream a "New" report format (legacy support)
     */
    public function generateNew($reportId, Request $request)
    {
        return $this->download($request, $reportId, 'new');
    }

    /**
     * Map test group collection into the standard array format expected by PDF templates
     */
    protected function mapTestsForPdfGroup($deptGroup, $report)
    {
        return $deptGroup->mapWithKeys(function ($testData) use ($report) {
            $itemId = $testData['invoice_item_id'];
            $testId = $testData['lab_test_id'];
            $key = $itemId . '_' . $testId;

            $item = $report->invoice->items->where('id', $itemId)->first() 
                ?: $report->invoice->items->where('lab_test_id', $testId)->first();
            $remark = '';
            $reportedAt = null;
            if ($item) {
                $raw = $item->report_comments;
                $decoded = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $remark = $decoded[$testId] ?? '';
                } else {
                    $remark = $raw;
                }

                if ($item->reported_at) {
                    $reportedAt = $item->reported_at->format('d/m/Y h:i A');
                }
            }

            return [$key => [
                'invoice_item_id' => $itemId,
                'name' => $testData['labTest']->name,
                'labTest' => $testData['labTest'],
                'results' => $testData['results'],
                'cultureResult' => $testData['cultureResult'],
                'remark' => $remark,
                'reported_at' => $reportedAt,
            ]];
        });
    }
}
