<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lab Report - {{ $invoice->invoice_number }}</title>

    @php
        // ── Resolve image paths ──
        $headerImgSrc = $settings['pdf_header_image'] ?? null;
        $footerImgSrc = $settings['pdf_footer_image'] ?? null;

        $sigImgSrc = !empty($settings['global_sig_1_path'])
            ? $settings['global_sig_1_path']
            : null;

        // ── Margins from Settings ──
        $marginTop    = ($settings['pdf_margin_top'] ?? 310) . 'px';
        $marginBottom = ($settings['pdf_margin_bottom'] ?? 255) . 'px';
        $marginLeft   = ($settings['pdf_margin_left'] ?? 25) . 'px';
        $marginRight  = ($settings['pdf_margin_right'] ?? 25) . 'px';
        $headerHeight = ($settings['pdf_header_height'] ?? 200) . 'px';
        $footerHeight = ($settings['pdf_footer_height'] ?? 180) . 'px';
        
        $fontSize     = ($settings['pdf_font_size'] ?? 13) . 'px';
        $fontFamily   = $settings['pdf_font_family'] ?? 'Helvetica, Arial, sans-serif';
        $verticalSpacing = ($settings['pdf_vertical_spacing'] ?? 5) . 'px';
        $signatureOffset = ($settings['pdf_signature_offset'] ?? 185) . 'px';
    @endphp

    <style>
        /* ── RESET ── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: {{ $fontFamily }};
            font-size: {{ $fontSize }};
            color: #1a1a1a;
            background: #fff;
            line-height: 1.45;
            margin: {{ $marginTop }} {{ $marginRight }} {{ $marginBottom }} {{ $marginLeft }};
        }

        /* ══════════════════════════════════════════════
           FIXED HEADER
           ══════════════════════════════════════════════ */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: {{ $marginTop }};
            overflow: hidden;
        }

        .header-logo-container {
            width: 100%;
            height: {{ $headerHeight }};
            display: block;
            overflow: hidden;
            text-align: center;
            padding: 0;
        }

        .header-banner {
            width: 100% !important;
            min-width: 100% !important;
            display: block;
        }

        /* ── PATIENT INFO BOX ── */
        .patient-box {
            position: absolute;
            bottom: 0;
            left: {{ $marginLeft }};
            right: {{ $marginRight }};
            border: 1px solid #1a1a1a !important;
            margin: 0;
            padding: 8px 10px;
            font-size: 10.5px;
            display: block;
            border-radius: 2px;
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-table td {
            padding: 0.5px 2px;
            vertical-align: top;
            line-height: 1.1;
        }

        .patient-table .lbl {
            font-weight: 700;
            color: #1a1a1a;
            width: 14%;
            white-space: nowrap;
        }

        .patient-table .val {
            color: #1a1a1a;
            width: 28%;
        }

        .patient-table .qr-cell {
            text-align: center;
            vertical-align: middle;
            width: 12%;
        }

        .qr-code {
            width: 55px;
            height: 55px;
            display: block;
            margin: 0 auto;
        }

        .barcode {
            margin-top: 5px;
            text-align: center;
        }

        .barcode-img {
            width: 100px;
            height: 30px;
        }

        /* ══════════════════════════════════════════════
           FIXED FOOTER
           ══════════════════════════════════════════════ */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height:
                {{ $footerHeight }}
            ;
        }

        /* Signature Table */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .sig-checked {
            width: 55%;
            text-align: left;
            vertical-align: bottom;
            font-weight: 700;
            font-size: 11px;
            padding-left: 35px;
            padding-bottom: 8px;
        }

        .sig-doctor {
            width: 45%;
            text-align: center;
            vertical-align: bottom;
            padding-right: 35px;
            padding-bottom: 2px;
            line-height: 1.2; /* Tighten line height to prevent overlap */
        }

        .sign-img {
            max-height: 55px;
            margin-bottom: 2px;
        }

        .doc-name {
            font-weight: 700;
            font-size: 11px;
            display: block;
            margin-bottom: 0px;
        }

        .doc-desig {
            font-size: 10px;
            color: #333;
            display: block;
            margin-top: 0px;
        }

        .footer-banner {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100% !important;
            min-width: 100% !important;
            display: block;
        }

        /* ── Multi-Signature Row ── */
        .sig-container {
            position: absolute;
            bottom: {{ $signatureOffset }};
            left: {{ $marginLeft }};
            right: {{ $marginRight }};
            margin: 0;
        }

        .multi-sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .multi-sig-table td {
            text-align: center;
            vertical-align: bottom;
            font-size: 10px;
            padding: 0 15px 5px;
        }

        /* ══════════════════════════════════════════════
           SECTION TITLES
           ══════════════════════════════════════════════ */
        .dept-title {
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin: 10px 0 2px;
            color: #1a1a1a;
        }

        .test-title {
            text-align: center;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 2px;
            color: #1a1a1a;
        }

        .method-line {
            text-align: center;
            font-size: 9px;
            color: #555;
            font-style: italic;
            margin-bottom: 5px;
        }

        /* ── Barcode Area ── */
        .barcode-area {
            text-align: right;
            margin-bottom: 4px;
            position: relative;
        }

        .barcode-area img {
            height: 45px;
        }

        /* ══════════════════════════════════════════════
           MINIMALIST RESULT TABLE
           ══════════════════════════════════════════════ */
        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 10px;
        }

        .result-table tr {
            page-break-inside: avoid;
        }

        .result-table thead th {
            border-top: 1.5px solid #333;
            border-bottom: 1.5px solid #333;
            padding: 6px 6px;
            text-align: left;
            font-weight: 700;
            font-size: 10.5px;
            text-transform: uppercase;
            color: #000;
            background: #fbfbfb;
        }

        .result-table tbody td {
            padding: {{ $verticalSpacing }} 6px;
            vertical-align: top;
            border-bottom: 0.5px solid #eee;
        }

        /* Explicitly remove vertical lines */
        .result-table, .result-table th, .result-table td {
            border-left: none !important;
            border-right: none !important;
        }

        .result-table tr:last-child td {
            border-bottom: 1.5px solid #333;
        }

        /* Sub-header rows (section dividers like "TOTAL COUNT") */
        .result-table .sub-hdr td {
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            padding: 3px 6px 1px;
            color: #1a1a1a;
            border-bottom: none;
        }

        /* Indented parameter rows under sub-headers */
        .result-table .param-indent td:first-child {
            padding-left: 28px;
        }

        /* ── Flag & Abnormal Colors ── */
        .flag-H {
            color: #cc0000;
            font-weight: 700;
        }

        .flag-L {
            color: #0055aa;
            font-weight: 700;
        }

        .result-bold {
            font-weight: 700;
        }

        /* ══════════════════════════════════════════════
           INTERPRETATION & REMARKS BLOCKS
           ══════════════════════════════════════════════ */
        .interp-block {
            margin: 15px 0 10px;
            padding: 4px 0;
            font-size: 10px;
            line-height: 1.5;
            page-break-inside: avoid;
        }

        .interp-label {
            font-weight: 700;
            font-size: 10px;
            margin-bottom: 3px;
            color: #1a1a1a;
        }

        .interp-content {
            margin-left: 0;
            padding-left: 0;
        }

        /* Render HTML interpretation tables cleanly */
        .interp-content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-size: 10px;
        }

        .interp-content table th {
            background: #f0f0f0;
            border: 1px solid #bbb;
            padding: 3px 6px;
            font-weight: 700;
            text-align: left;
            font-size: 10px;
        }

        .interp-content table td {
            border: 1px solid #bbb;
            padding: 3px 6px;
            font-size: 10px;
        }

        .interp-content table tr {
            page-break-inside: avoid;
        }

        .interp-content table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .interp-content p {
            margin: 3px 0;
            font-size: 10px;
            color: #444;
        }

        .interp-content ul,
        .interp-content ol {
            margin: 3px 0 3px 15px;
            font-size: 10px;
        }

        .interp-content li {
            margin-bottom: 2px;
        }

        .interp-content strong {
            color: #1a1a1a;
        }

        /* Remarks block (from result entry) */
        .remarks-block {
            margin: 20px 0 10px;
            padding: 10px 0;
            font-size: 10px;
            line-height: 1.5;
            border-top: 1px dashed #ccc;
            page-break-inside: avoid;
        }

        .remarks-block table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-size: 10px;
        }

        .remarks-block table th {
            border: 1px solid #bbb;
            padding: 3px 6px;
            font-weight: 700;
            text-align: left;
        }

        .remarks-block table td {
            border: 1px solid #bbb;
            padding: 3px 6px;
        }

        .doctor-comments {
            margin: 25px 0 10px;
            padding: 10px 0;
            border-top: 1.5px solid #eee;
        }

        /* ══════════════════════════════════════════════
           MISC
           ══════════════════════════════════════════════ */
        .watermark {
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1000;
            opacity: 0.08;
        }

        .watermark img {
            width: 280px;
        }

        .page-break {
            page-break-after: always;
        }

        .end-of-report {
            text-align: center;
            font-weight: 700;
            font-size: 10px;
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px dashed #333;
            width: 180px;
            margin-left: auto;
            margin-right: auto;
            color: #555;
        }

        /* Doctor Comments Block */
        .doctor-comments {
            margin-top: 15px;
            padding: 6px 0;
            border-top: 1px dashed #ccc;
            font-size: 10px;
        }
    </style>
</head>

<body>

    @if(($settings['pdf_background_mode'] ?? 'header_footer') === 'letterhead' && isset($settings['pdf_letterhead_image']) && $settings['pdf_letterhead_image'] && $showHeader)
        <img src="{{ $settings['pdf_letterhead_image'] }}" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: -1000;" alt="Letterhead">
    @endif

    {{-- ══════════════════ WATERMARK ══════════════════ --}}
    @if(($settings['pdf_show_watermark'] ?? false) && !empty($settings['pdf_watermark_image']))
        <div class="watermark">
            <img src="{{ $settings['pdf_watermark_image'] }}">
        </div>
    @endif

    {{-- ══════════════════ FIXED HEADER ══════════════════ --}}
    <header>
        <div class="header-logo-container">
            @if($headerImgSrc && $showHeader && ($settings['pdf_background_mode'] ?? 'header_footer') === 'header_footer')
                <img class="header-banner" src="{{ $headerImgSrc }}" alt="Header">
            @endif
        </div>

        {{-- Patient Info Box — always visible --}}
        <div class="patient-box" style="margin-top: 0; clear: both;">
            <table class="patient-table">
                <tr>
                    <td class="lbl">Name</td>
                    <td class="val">: {{ $patient->name }}</td>
                    <td class="lbl">Report ID</td>
                    <td class="val">: {{ $invoice->invoice_number }}</td>
                    <td rowspan="4" class="qr-cell">
                        @if(isset($qrCodeUri))
                             <img src="{{ $qrCodeUri }}" class="qr-code">
                        @elseif(file_exists(public_path('assets/images/qr-code.png')))
                             <img src="{{ public_path('assets/images/qr-code.png') }}" class="qr-code">
                        @endif

                        @if(isset($barcodeUri))
                            <div class="barcode">
                                <img src="{{ $barcodeUri }}" class="barcode-img">
                                <div style="font-size: 8px; margin-top: 1px; font-weight: bold;">{{ $invoice->invoice_number }}</div>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Age/Gender</td>
                    <td class="val">: {{ $profile->age ?? '--' }} {{ $profile->age_type ?? 'Y' }} /
                        {{ $profile->gender ?? '--' }}</td>
                    <td class="lbl">Collection Date</td>
                    <td class="val">:
                        {{ $invoice->sample_received_at ? $invoice->sample_received_at->format('d/m/Y h:i A') : ($invoice->sample_collected_at ? $invoice->sample_collected_at->format('d/m/Y h:i A') : $invoice->created_at->format('d/m/Y h:i A')) }}
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Referred By</td>
                    <td class="val">: {{ $invoice->doctor ? $invoice->doctor->name : 'SELF' }}</td>
                    <td class="lbl">Report Date</td>
                    <td class="val">:
                        {{ $report->approved_at ? $report->approved_at->format('d/m/Y h:i A') : ($invoice->expected_report_time ? $invoice->expected_report_time->format('d/m/Y h:i A') : now()->format('d/m/Y h:i A')) }}
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Patient ID</td>
                    <td class="val">: {{ $patient->formatted_id ?? $patient->id }}</td>
                    <td class="lbl"></td>
                    <td class="val"></td>
                </tr>
            </table>
        </div>
    </header>

    {{-- ══════════════════ FIXED FOOTER ══════════════════ --}}
    <footer>
        <div class="sig-container">
            {{-- ── Signature Section ── --}}
            @php $sigMode = $settings['report_signature_mode'] ?? 'global_bottom'; @endphp
            @if($sigMode === 'per_department')
                {{-- Global footer sigs hidden, shown per department in body --}}
            @elseif(($sigMode === 'global_bottom' || $sigMode === '') && empty($settings['global_sig_2_name']) && empty($settings['global_sig_3_name']))
                <table class="sig-table">
                    <tr>
                        <td class="sig-checked"></td>
                        <td class="sig-doctor">
                            @if($sigImgSrc)
                                <img class="sign-img" src="{{ $sigImgSrc }}"><br>
                            @endif
                            @if(!empty($settings['global_sig_1_name']))
                                <span class="doc-name">{{ $settings['global_sig_1_name'] }}</span>
                                @if(!empty($settings['global_sig_1_desig']))
                                    <span class="doc-desig">{!! nl2br(e($settings['global_sig_1_desig'])) !!}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            @else
                {{-- Multi Signatory Layout --}}
                <table class="multi-sig-table">
                    <tr>
                        <td style="width: 33%; text-align: left; vertical-align: bottom; padding-left: 35px;">
                            @if(!empty($settings['global_sig_2_name']))
                                @if(!empty($settings['global_sig_2_path']))
                                    <img class="sign-img" src="{{ $settings['global_sig_2_path'] }}"><br>
                                @endif
                                <span class="doc-name">{{ $settings['global_sig_2_name'] }}</span>
                                @if(!empty($settings['global_sig_2_desig']))
                                    <span class="doc-desig">{!! nl2br(e($settings['global_sig_2_desig'])) !!}</span>
                                @endif
                            @endif
                        </td>
                        <td style="width: 34%; text-align: center; vertical-align: bottom;">
                            @if(!empty($settings['global_sig_3_name']))
                                @if(!empty($settings['global_sig_3_path']))
                                    <img class="sign-img" src="{{ $settings['global_sig_3_path'] }}"><br>
                                @endif
                                <span class="doc-name">{{ $settings['global_sig_3_name'] }}</span>
                                @if(!empty($settings['global_sig_3_desig']))
                                    <span class="doc-desig">{!! nl2br(e($settings['global_sig_3_desig'])) !!}</span>
                                @endif
                            @endif
                        </td>
                        <td style="width: 33%; text-align: right; vertical-align: bottom; padding-right: 35px;">
                            @if(!empty($settings['global_sig_1_name']))
                                @if($sigImgSrc)
                                    <img class="sign-img" src="{{ $sigImgSrc }}"><br>
                                @endif
                                <span class="doc-name">{{ $settings['global_sig_1_name'] }}</span>
                                @if(!empty($settings['global_sig_1_desig']))
                                    <span class="doc-desig">{!! nl2br(e($settings['global_sig_1_desig'])) !!}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            @endif
        </div>

        <img class="footer-banner" src="{{ $footerImgSrc }}" alt="Footer"
            style="{{ ($showHeader && ($showFooter ?? true)) ? '' : 'visibility: hidden;' }}">
    </footer>

    {{-- ══════════════════ BODY CONTENT ══════════════════ --}}
    @php $testIndex = 0; @endphp

    @foreach($groupedResults as $deptId => $data)
        @php
            $dept = $data['department'];
            $tests = $data['tests'];
            $deptName = $dept ? $dept->name : 'General';
        @endphp

        @foreach($tests as $testId => $testData)
            @php
                $testName = $testData['name'];
                $labTest = $testData['labTest'];
                $results = $testData['results'];
            @endphp

            {{-- Page break before each test --}}
            @if($testIndex > 0)
                <div style="page-break-after: always;"></div>
            @endif

            {{-- ── Department & Test Title ── --}}
            <div class="dept-title">{{ strtoupper($deptName) }}</div>
            <div class="test-title" style="margin-bottom: 12px; font-size: 11.5px;">{{ strtoupper($testName) }}</div>

            {{-- ── Method (from LabTest master) ── --}}
            @if(($settings['pdf_show_method'] ?? true) && $labTest && $labTest->method)
                <div class="method-line">Method: {{ $labTest->method }}</div>
            @endif



            @if($testData['cultureResult'])
                @php $cr = $testData['cultureResult']; @endphp
                {{-- ── Culture Results Layout ── --}}
                <table class="result-table" style="margin-bottom:15px; width:100%;">
                    <tbody>
                        <tr>
                            <td style="width:25%; font-weight:700; border-bottom: none !important;">Specimen</td>
                            <td style="width:75%; border-bottom: none !important;">: {{ $cr->specimen }}</td>
                        </tr>
                        @if($cr->growth_status)
                        <tr>
                            <td style="font-weight:700; border-bottom: none !important;">Result</td>
                            <td style="font-weight:700; border-bottom: none !important;">: {{ $cr->growth_status }}</td>
                        </tr>
                        @endif
                        @if($cr->incubation_period)
                        <tr>
                            <td style="font-weight:700; border-bottom: none !important;">Incubation Period</td>
                            <td style="border-bottom: none !important;">: {{ $cr->incubation_period }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="font-weight:700; border-bottom: none !important;">Organism Isolated</td>
                            <td style="font-weight:700; color:#b00; border-bottom: none !important;">: {{ $cr->organism_name }}</td>
                        </tr>
                        @if($cr->colony_count)
                        <tr>
                            <td style="font-weight:700; border-bottom: none !important;">Colony Count</td>
                            <td style="border-bottom: none !important;">: {{ $cr->colony_count }}</td>
                        </tr>
                        @endif
                        @if($cr->remarks)
                        <tr>
                            <td style="font-weight:700; border-bottom: none !important;">Remarks</td>
                            <td style="border-bottom: none !important;">: {{ $cr->remarks }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                @if($cr->antibiotics && $cr->antibiotics->count() > 0)
                    <div style="font-weight:700; font-size:11px; margin-bottom:5px; text-decoration:underline;">ANTIBIOTIC SUSCEPTIBILITY</div>
                    <table class="result-table">
                        <thead>
                            <tr>
                                <th style="width:40%">Antibiotic Name</th>
                                <th style="width:30%">Sensitivity</th>
                                <th style="width:30%">MIC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cr->antibiotics as $ab)
                                <tr>
                                    <td>{{ $ab->antibiotic_name }}</td>
                                    @php
                                        $sens = strtoupper(substr($ab->sensitivity ?? '', 0, 1));
                                        $sColor = $sens === 'S' ? '#007700' : ($sens === 'R' ? '#cc0000' : '#888');
                                    @endphp
                                    <td style="color: {{ $sColor }}; font-weight:700;">
                                        {{ $ab->sensitivity }}
                                    </td>
                                    <td>{{ $ab->mic_value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @else
            {{-- ── Results Table ── --}}
            <table class="result-table">
                <thead>
                    <tr>
                        <th style="width:40%">Test Description</th>
                        <th style="width:15%">Result</th>
                        <th style="width:8%">Flag</th>
                        <th style="width:22%">Ref. Range</th>
                        <th style="width:15%">Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @php $hasSubHeaders = false; @endphp

                    @foreach($results as $r)
                        @php
                            // Detect sub-header: no result value AND no reference range
                            $isSubHeader = (is_null($r->result_value) || trim($r->result_value) === '')
                                && (is_null($r->reference_range) || trim($r->reference_range) === '');

                            // Determine flag
                            $flag = null;
                            if ($r->is_highlighted && $r->status) {
                                $rawFlag = strtoupper(trim($r->status));
                                if (in_array($rawFlag, ['H', 'HIGH'])) {
                                    $flag = 'H';
                                } elseif (in_array($rawFlag, ['L', 'LOW'])) {
                                    $flag = 'L';
                                } else {
                                    $flag = '*';
                                }
                            }
                            $isAbnormal = $r->is_highlighted;
                        @endphp

                        @if($isSubHeader)
                            {{-- ── Sub-Header Row ── --}}
                            @php $hasSubHeaders = true; @endphp
                            <tr class="sub-hdr">
                                <td colspan="5">{{ strtoupper($r->parameter_name) }}</td>
                            </tr>
                        @else
                            {{-- ── Parameter Row ── --}}
                            <tr class="{{ $hasSubHeaders ? 'param-indent' : '' }}">
                                <td class="{{ $isAbnormal ? 'result-bold' : '' }}">
                                    {{ strtoupper($r->parameter_name) }}
                                    @if($r->method)
                                        <div style="font-size: 8px; font-weight: normal; font-style: italic; color: #555; margin-top: 2px;">
                                            (Method: {{ $r->method }})
                                        </div>
                                    @endif
                                </td>
                                <td
                                    class="{{ $isAbnormal ? ($flag === 'H' ? 'flag-H' : ($flag === 'L' ? 'flag-L' : 'result-bold')) : 'result-bold' }}">
                                    {{ $r->result_value }}
                                </td>
                                <td class="{{ $flag ? 'flag-' . $flag : '' }}">
                                    {{ $flag }}
                                </td>
                                <td class="{{ $isAbnormal ? 'result-bold' : '' }}" style="width: 22%; font-size: 8.5px; line-height: 1.2; vertical-align: middle;">
                                    @php
                                        $displayRange = $r->reference_range;
                                        
                                        // Backup: If range is empty, try to show the full master range list
                                        if (empty(trim($displayRange)) && !empty($r->lab_test_id) && $r->labTest && isset($r->labTest->parameters) && is_array($r->labTest->parameters)) {
                                            $masterParam = collect($r->labTest->parameters)->first(function($p) use ($r) {
                                                $pName = is_array($p) ? ($p['name'] ?? '') : $p;
                                                return $pName === $r->parameter_name;
                                            });

                                            if ($masterParam && isset($masterParam['ranges']) && is_array($masterParam['ranges'])) {
                                                $ranges = collect($masterParam['ranges']);
                                                
                                                if ($ranges->count() > 1) {
                                                    // Try to find M/F explicitly
                                                    $maleRange = $ranges->firstWhere('gender', 'Male');
                                                    $femaleRange = $ranges->firstWhere('gender', 'Female');

                                                    if ($maleRange && $femaleRange) {
                                                        $displayRange = "M: " . ($maleRange['display_range'] ?? '') . "<br>F: " . ($femaleRange['display_range'] ?? '');
                                                    } else {
                                                        // Just join all unique display ranges
                                                        $displayRange = $ranges->pluck('display_range')->unique()->filter()->implode('<br>');
                                                    }
                                                } else {
                                                    $displayRange = $ranges->first()['display_range'] ?? ($ranges->first()['normal_value'] ?? '');
                                                }
                                            }
                                        }
                                    @endphp
                                    {!! $displayRange !!}
                                </td>
                                <td class="{{ $isAbnormal ? 'result-bold' : '' }}" style="width: 15%;">
                                    {{ $r->unit }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @endif

            {{-- ── Method (per-result level, if different from test master) ── --}}
            @if($results && $results->count() > 0 && $results->first()->method && $labTest && $results->first()->method !== $labTest->method)
                <p style="font-size:9px; color:#555; font-style:italic; margin-bottom:5px;">
                    <strong>Method:</strong> {{ $results->first()->method }}
                </p>
            @endif

            {{-- ── Default Interpretation (from LabTest master — stored as HTML) ── --}}
            @if($labTest && $labTest->interpretation)
                <div class="interp-block">
                    <div class="interp-label">Interpretation:</div>
                    <div class="interp-content">
                        {!! $labTest->interpretation !!}
                    </div>
                </div>
            @endif

            {{-- ── Description / Note (from LabTest master — plain text) ── --}}
            @if($labTest && $labTest->description)
                <div class="interp-block" style="color:#555;">
                    <div class="interp-label" style="color:#333;">Note:</div>
                    <div class="interp-content">
                        {!! nl2br(e($labTest->description)) !!}
                    </div>
                </div>
            @endif

            {{-- ── Result Entry Remarks (Granular per test) ── --}}
            @if(!empty($testData['remark']))
                <div class="remarks-block">
                    <div class="interp-label">Remarks:</div>
                    <div class="interp-content">
                        {!! $testData['remark'] !!}
                    </div>
                </div>
            @endif

            {{-- ── Per-Department Signatures (if mode is per_department) ── --}}
            @if($settings['report_signature_mode'] === 'per_department' && $dept)
                @if(isset($dept->sig_1_path) && $dept->sig_1_path)
                    <table class="multi-sig-table" style="margin-top:12px;">
                        <tr>
                            <td style="width: 33%; text-align: left; vertical-align: bottom; padding-left: 35px;">
                                @if(isset($dept->sig_2_name) && $dept->sig_2_name)
                                    @if(isset($dept->sig_2_path) && $dept->sig_2_path)
                                        <img style="max-height:40px;" src="{{ storage_base64($dept->sig_2_path) }}"><br>
                                    @endif
                                    <span class="doc-name">{{ $dept->sig_2_name ?? '' }}</span>
                                    @if(isset($dept->sig_2_desig) && $dept->sig_2_desig)
                                        <span class="doc-desig">{!! nl2br(e($dept->sig_2_desig ?? '')) !!}</span>
                                    @endif
                                @endif
                            </td>
                            <td style="width: 34%; text-align: center; vertical-align: bottom;">
                                @if(isset($dept->sig_3_name) && $dept->sig_3_name)
                                    @if(isset($dept->sig_3_path) && $dept->sig_3_path)
                                        <img style="max-height:40px;" src="{{ storage_base64($dept->sig_3_path) }}"><br>
                                    @endif
                                    <span class="doc-name">{{ $dept->sig_3_name ?? '' }}</span>
                                    @if(isset($dept->sig_3_desig) && $dept->sig_3_desig)
                                        <span class="doc-desig">{!! nl2br(e($dept->sig_3_desig ?? '')) !!}</span>
                                    @endif
                                @endif
                            </td>
                            <td style="width: 33%; text-align: right; vertical-align: bottom; padding-right: 35px;">
                                @if(isset($dept->sig_1_name) && $dept->sig_1_name)
                                    @if(isset($dept->sig_1_path) && $dept->sig_1_path)
                                        <img style="max-height:40px;" src="{{ storage_base64($dept->sig_1_path) }}"><br>
                                    @endif
                                    <span class="doc-name">{{ $dept->sig_1_name ?? '' }}</span>
                                    @if(isset($dept->sig_1_desig) && $dept->sig_1_desig)
                                        <span class="doc-desig">{!! nl2br(e($dept->sig_1_desig ?? '')) !!}</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                @endif
            @endif

            @php $testIndex++; @endphp
        @endforeach
    @endforeach

    {{-- ── Global Report Comments ── --}}
    @if($report->comments)
        <div class="doctor-comments">
            <div class="interp-label">Doctor's Comments / Interpretation:</div>
            <div class="interp-content">
                {!! $report->comments !!}
            </div>
        </div>
    @endif

    {{-- ── End of Report ── --}}
    <div class="end-of-report">*** End of Report ***</div>

</body>

</html>