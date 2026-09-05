<?php

namespace App\Livewire\Lab;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\TestReport;
use App\Models\ReportResult;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ResultEntryManager extends Component
{
    public $invoice;
    public $testReport;
    public $comments;
    public $report_date;
    
    public $results = [];
    public $highlights = [];
    public $flags = []; 
    public $parametersList = [];
    public $selectedTests = []; // For selective printing from here
    public $testComments = []; // Comments per invoice item (test)
    
    public $cultureData = [];
    public $cultureAntibiotics = [];
    public $cultureTestsList = [];

    public function mount($id)
    {
        $this->authorize('view reports');
        $this->invoice = Invoice::where('company_id', auth()->user()->company_id)
            ->with(['patient.patientProfile', 'items.labTest', 'testReport.results', 'testReport.cultureResults.antibiotics'])
            ->findOrFail($id);
        
        $this->testReport = $this->invoice->testReport;
        $this->comments = $this->testReport ? $this->testReport->comments : '';
        $this->report_date = $this->testReport && $this->testReport->approved_at 
            ? $this->testReport->approved_at->format('Y-m-d\TH:i') 
            : ($this->invoice->expected_report_time ? $this->invoice->expected_report_time->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i'));
        
        $this->initializeResultsData();
    }

    private function initializeResultsData()
    {
        $patient = $this->invoice->patient;
        $profile = $patient->patientProfile;
        $gender = strtolower($profile->gender ?? 'male');
        
        // Calculate/retrieve age for precise matching
        $ageDays = 0; $ageMonths = 0; $ageYears = 0;
        
        if ($profile && $profile->dob) {
            $dob = $profile->dob;
            $ageDays = now()->diffInDays($dob);
            $ageMonths = now()->diffInMonths($dob);
            $ageYears = now()->diffInYears($dob);
        } else {
            // Fallback to manual age fields
            $ageYears = (int)($profile->age ?? 0);
            $type = $profile->age_type ?? 'Years';
            if ($type === 'Months') {
                $ageMonths = $ageYears; // age field holds months
                $ageDays = $ageMonths * 30;
                $ageYears = 0;
            } elseif ($type === 'Days') {
                $ageDays = $ageYears; // age field holds days
                $ageMonths = 0; $ageYears = 0;
            } else {
                $ageMonths = $ageYears * 12;
                $ageDays = $ageYears * 365;
            }
        }

        $existingResultsMap = [];
        if ($this->testReport && $this->testReport->results) {
            foreach ($this->testReport->results as $r) {
                // Key format: invoice_item_id _ lab_test_id _ param_name_md5
                $key = ($r->invoice_item_id ?? '0') . '_' . $r->lab_test_id . '_' . md5($r->parameter_name);
                $existingResultsMap[$key] = $r;
            }
        }

        $existingCultureResultsMap = [];
        if ($this->testReport && $this->testReport->cultureResults) {
            foreach ($this->testReport->cultureResults as $cr) {
                $key = ($cr->invoice_item_id ?? '0') . '_' . $cr->lab_test_id;
                $existingCultureResultsMap[$key] = $cr;
            }
        }

        foreach ($this->invoice->items as $item) {
            // Determine if report_comments is JSON (new granular format) or plain text (legacy)
            $rawComments = $item->report_comments ?? '';
            $decodedComments = json_decode($rawComments, true);
            $isJson = (json_last_error() === JSON_ERROR_NONE && is_array($decodedComments));

            // Handle Packages vs Single Tests
            $testsToProcess = [];
            if ($item->labTest) {
                if ($item->labTest->is_package && !empty($item->labTest->linked_test_ids)) {
                    $testsToProcess = \App\Models\LabTest::whereIn('id', $item->labTest->linked_test_ids)->get();
                } else {
                    $testsToProcess = collect([$item->labTest]);
                }
            }

            foreach ($testsToProcess as $test) {
                // Load specific comment for this test in this invoice item
                $commentKey = $item->id . '_' . $test->id;
                $testComment = '';
                if ($isJson) {
                    $testComment = $decodedComments[$test->id] ?? '';
                } else {
                    // Legacy fallback: show the same comment for all tests in the item if it's not JSON
                    $testComment = $rawComments;
                }

                // Fallback: if comment is empty, check other items in this invoice for this test
                if (empty(trim($testComment))) {
                    foreach ($this->invoice->items as $otherItem) {
                        if ($otherItem->id == $item->id) continue;
                        $otherDecoded = json_decode($otherItem->report_comments ?? '', true);
                        if (is_array($otherDecoded) && !empty($otherDecoded[$test->id])) {
                            $testComment = $otherDecoded[$test->id];
                            break;
                        }
                    }
                }
                $this->testComments[$commentKey] = $testComment;

                if ($test->is_culture) {
                    $key = $item->id . '_' . $test->id;
                    $this->cultureTestsList[$key] = [
                        'key' => $key,
                        'lab_test_id' => $test->id,
                        'invoice_item_id' => $item->id,
                        'department' => $test->department,
                        'test_name' => $test->name,
                        'is_culture' => true,
                    ];
                    
                    $cr = $existingCultureResultsMap[$key] ?? null;
                    // Fallback matching if invoice items were updated or invoice_item_id was null/orphaned
                    if (!$cr && $this->testReport && $this->testReport->cultureResults) {
                        $nullCultureKey = '0_' . $test->id;
                        if (isset($existingCultureResultsMap[$nullCultureKey])) {
                            $cr = $existingCultureResultsMap[$nullCultureKey];
                        } else {
                            $otherItemIds = $this->invoice->items->pluck('id')->reject(fn($id) => $id == $item->id)->toArray();
                            $cr = $this->testReport->cultureResults->first(function ($c) use ($test, $otherItemIds) {
                                return $c->lab_test_id == $test->id && !in_array($c->invoice_item_id, $otherItemIds);
                            });
                        }
                    }

                    if ($cr) {
                        $this->cultureData[$key] = [
                            'specimen' => $cr->specimen,
                            'growth_status' => $cr->growth_status,
                            'incubation_period' => $cr->incubation_period,
                            'organism_name' => $cr->organism_name,
                            'colony_count' => $cr->colony_count,
                            'remarks' => $cr->remarks,
                        ];
                        $this->cultureAntibiotics[$key] = [];
                        foreach ($cr->antibiotics as $ab) {
                            $this->cultureAntibiotics[$key][] = [
                                'antibiotic_name' => $ab->antibiotic_name,
                                'sensitivity' => $ab->sensitivity,
                                'mic_value' => $ab->mic_value,
                            ];
                        }
                    } else {
                        $this->cultureData[$key] = [
                            'specimen' => $test->sample_type ?? '',
                            'growth_status' => '',
                            'incubation_period' => '',
                            'organism_name' => '',
                            'colony_count' => '',
                            'remarks' => '',
                        ];
                        
                        // Default common antibiotics
                        $defaultAntibiotics = [
                            'Amikacin', 'Amoxicillin-Clavulanic acid', 'Ampicillin', 'Cefepime', 
                            'Cefotaxime', 'Ceftazidime', 'Ceftriaxone', 'Ciprofloxacin', 
                            'Gentamicin', 'Imipenem', 'Levofloxacin', 'Linezolid', 
                            'Meropenem', 'Nitrofurantoin', 'Piperacillin-Tazobactam', 'Trimethoprim-Sulfamethoxazole', 'Vancomycin'
                        ];
                        
                        $this->cultureAntibiotics[$key] = [];
                        foreach ($defaultAntibiotics as $abName) {
                            $this->cultureAntibiotics[$key][] = [
                                'antibiotic_name' => $abName,
                                'sensitivity' => '',
                                'mic_value' => '',
                            ];
                        }
                    }
                    continue; // Skip normal parameters
                }

                if ($test->parameters) {
                    foreach ($test->parameters as $param) {
                        $paramName = is_array($param) ? ($param['name'] ?? 'Unknown') : $param;
                        $paramType = is_array($param) ? ($param['type'] ?? 'parameter') : 'parameter';
                        $key = $item->id . '_' . $test->id . '_' . md5($paramName . ($paramType === 'sub_header' ? '_hdr' : ''));

                        // Sub-header: add as a heading row, no result input needed
                        if ($paramType === 'sub_header') {
                            $this->parametersList[$key] = [
                                'key'            => $key,
                                'lab_test_id'    => $test->id,
                                'invoice_item_id'=> $item->id,
                                'name'           => $paramName,
                                'is_sub_header'  => true,
                                'unit'           => '',
                                'ref_range'      => '',
                                'method'         => '',
                                'short_code'     => '',
                                'input_type'     => 'text',
                                'options'        => [],
                                'formula'        => '',
                                'department'     => $test->department,
                                'test_name'      => $test->name,
                                'matched_range_details' => [],
                            ];
                            // No result/highlight/flag entry needed for sub-headers
                            continue;
                        }
                        
                        // NEW: Smart Range Matching
                        $matchedRange = $this->findMatchingRange($param, $gender, $ageDays, $ageMonths, $ageYears);
                        $refText = $matchedRange['display_range'] ?? $matchedRange['normal_value'] ?? '';
                        
                        // Fallback for old data structure if needed
                        if (empty($refText)) {
                            if ($gender === 'female') $refText = $param['female_range'] ?? $param['general_range'] ?? '';
                            else $refText = $param['male_range'] ?? $param['general_range'] ?? '';
                        }

                        $foundResult = $existingResultsMap[$key] ?? null;

                        // Fallback matching if invoice was edited and invoice_item_id is null/orphaned
                        if (!$foundResult && $this->testReport && $this->testReport->results) {
                            $paramHash = md5($paramName . ($paramType === 'sub_header' ? '_hdr' : ''));
                            $nullKey = '0_' . $test->id . '_' . $paramHash;
                            if (isset($existingResultsMap[$nullKey])) {
                                $foundResult = $existingResultsMap[$nullKey];
                            } else {
                                $otherItemIds = $this->invoice->items->pluck('id')->reject(fn($id) => $id == $item->id)->toArray();
                                $foundResult = $this->testReport->results->first(function ($r) use ($test, $paramName, $otherItemIds) {
                                    return $r->lab_test_id == $test->id 
                                        && $r->parameter_name === $paramName 
                                        && !in_array($r->invoice_item_id, $otherItemIds);
                                });
                            }
                        }

                        $this->results[$key] = $foundResult ? $foundResult->result_value : '';
                        $this->highlights[$key] = $foundResult ? $foundResult->is_highlighted : false;
                        $this->flags[$key] = ($foundResult && in_array($foundResult->status, ['High', 'Low'])) 
                            ? substr($foundResult->status, 0, 1) 
                            : '';
                        
                        $this->parametersList[$key] = [
                            'key'            => $key,
                            'lab_test_id'    => $test->id,
                            'invoice_item_id'=> $item->id,
                            'name'           => $paramName,
                            'is_sub_header'  => false,
                            'short_code'     => $param['short_code'] ?? '',
                            'unit'           => is_array($param) ? ($param['unit'] ?? '') : '',
                            'input_type'     => $param['input_type'] ?? 'numeric',
                            'options'        => $param['options'] ?? [],
                            'formula'        => $param['formula'] ?? '',
                            'method'         => $param['method'] ?? '',
                            'ref_range'      => $refText,
                            'matched_range_details' => $matchedRange,
                            'department'     => $test->department,
                            'test_name'      => $test->name,
                        ];
                    }
                }
            }
        }

        // Reorder parametersList to match saved results order if report results exist
        if ($this->testReport && $this->testReport->results && $this->testReport->results->isNotEmpty()) {
            $sortedList = [];
            foreach ($this->testReport->results as $r) {
                foreach ($this->parametersList as $k => $paramObj) {
                    if ($paramObj['lab_test_id'] == $r->lab_test_id && $paramObj['name'] === $r->parameter_name && !isset($sortedList[$k])) {
                        $sortedList[$k] = $paramObj;
                        break;
                    }
                }
            }
            foreach ($this->parametersList as $k => $paramObj) {
                if (!isset($sortedList[$k])) {
                    $sortedList[$k] = $paramObj;
                }
            }
            $this->parametersList = $sortedList;
        }

        // Auto-select all item IDs by default so user can print directly without manual selection
        if (empty($this->selectedTests)) {
            $this->selectedTests = $this->invoice->items->pluck('id')->map(fn($id) => (string)$id)->toArray();
        }

        // Auto-evaluate ranges on mount
        $this->autoEvaluateRanges();

        // Auto-check completed status on mount
        $this->checkAndMarkTestCompleted();
    }

    private function findMatchingRange($param, $patientGender, $days, $months, $years)
    {
        if (!isset($param['ranges']) || !is_array($param['ranges'])) return null;

        // 1. Try exact match (Gender + Age)
        foreach ($param['ranges'] as $range) {
            $rGender = strtolower($range['gender'] ?? 'both');
            if ($rGender !== 'both' && $rGender !== $patientGender) continue;

            $unit = $range['age_unit'] ?? 'Years';
            $val = ($unit === 'Days') ? $days : (($unit === 'Months') ? $months : $years);
            
            if ($val >= ($range['age_min'] ?? 0) && $val <= ($range['age_max'] ?? 150)) {
                return $range;
            }
        }

        // 2. Fallback 1: Try matching Gender only (widening age range)
        foreach ($param['ranges'] as $range) {
            $rGender = strtolower($range['gender'] ?? 'both');
            if ($rGender === $patientGender) return $range;
        }

        // 3. Fallback 2: Try matching 'Both' gender
        foreach ($param['ranges'] as $range) {
            if (strtolower($range['gender'] ?? '') === 'both') return $range;
        }

        // 4. Fallback 3: Return the first range available if any
        return count($param['ranges']) > 0 ? $param['ranges'][0] : null;
    }

    public function updatedResults($value, $key)
    {
        $this->autoCalculateFormulas();
        $this->autoEvaluateRanges();
        $this->checkAndMarkTestCompleted();
    }

    public function updatedCultureData($value, $key)
    {
        $this->checkAndMarkTestCompleted();
    }

    public function updatedCultureAntibiotics($value, $key)
    {
        $this->checkAndMarkTestCompleted();
    }

    private function checkAndMarkTestCompleted()
    {
        $itemParams = [];
        foreach ($this->parametersList as $k => $p) {
            // Skip sub-headers / section headings
            if (!empty($p['is_sub_header'])) {
                continue;
            }
            $itemId = $p['invoice_item_id'];
            $itemParams[$itemId][] = $k;
        }

        // Add culture tests to items tracking
        foreach ($this->cultureTestsList as $k => $p) {
            $itemId = $p['invoice_item_id'];
            $itemParams[$itemId][] = 'CULTURE_' . $k;
        }

        $itemsUpdated = false;
        foreach ($itemParams as $itemId => $keys) {
            $allFilled = true;
            foreach ($keys as $k) {
                if (str_starts_with($k, 'CULTURE_')) {
                    $cultureKey = substr($k, 8);
                    $cData = $this->cultureData[$cultureKey] ?? [];
                    $growth = $cData['growth_status'] ?? '';
                    
                    if (empty(trim($cData['specimen'] ?? '')) || empty(trim($growth))) {
                        $allFilled = false;
                        break;
                    }
                    
                    if (!in_array($growth, ['No Growth', 'Sterile']) && empty(trim($cData['organism_name'] ?? ''))) {
                        $allFilled = false;
                        break;
                    }
                } else {
                    $val = $this->results[$k] ?? '';
                    if (trim((string)$val) === '') {
                        $allFilled = false;
                        break;
                    }
                }
            }

            $item = $this->invoice->items->where('id', $itemId)->first();
            if ($item) {
                if ($allFilled && $item->status !== 'Completed') {
                    $item->update(['status' => 'Completed']);
                    $itemsUpdated = true;
                } elseif (!$allFilled && $item->status === 'Completed') {
                    $item->update(['status' => 'Pending']);
                    $itemsUpdated = true;
                }
            }
        }
        
        if ($itemsUpdated) {
            $this->invoice->load('items');
        }
    }

    private function autoCalculateFormulas()
    {
        // Group parameters by invoice_item_id to isolate calculation scope
        $groupedParams = [];
        foreach ($this->parametersList as $k => $p) {
            $itemId = $p['invoice_item_id'];
            $groupedParams[$itemId][$k] = $p;
        }

        $expressionLanguage = new ExpressionLanguage();

        foreach ($groupedParams as $itemId => $params) {
            // 1. Build a local code-to-value map for this test
            $localCodeMap = [];
            foreach ($params as $k => $p) {
                if (!empty($p['short_code'])) {
                    $localCodeMap[strtoupper($p['short_code'])] = (float)($this->results[$k] ?: 0);
                }
            }

            // 2. Process all calculated parameters for this test
            foreach ($params as $k => $p) {
                if ($p['input_type'] === 'calculated' && !empty($p['formula'])) {
                    $formula = strtoupper($p['formula']);
                    
                    // Clean up formula for ExpressionLanguage by removing braces {CODE} -> CODE
                    $formula = preg_replace('/\{([A-Z0-9_]+)\}/', '$1', $formula);
                    
                    try {
                        // Ensure formula is not empty
                        if (!empty(trim($formula))) {
                            // The expression language handles Division by Zero internally (throws exception)
                            $result = $expressionLanguage->evaluate($formula, $localCodeMap);
                            
                            if ($result !== false && is_numeric($result)) {
                                // Prevent saving INF or NAN
                                if (!is_infinite($result) && !is_nan($result)) {
                                    $this->results[$k] = round($result, 2);
                                }
                            }
                        }
                    } catch (\Throwable $e) {
                         Log::warning("Formula error for {$p['name']}: " . $e->getMessage());
                    }
                }
            }
        }
    }

    private function autoEvaluateRanges()
    {
        foreach ($this->results as $key => $val) {
            $trimmedVal = trim((string)$val);
            if ($trimmedVal === '') {
                $this->flags[$key] = '';
                $this->highlights[$key] = false;
                continue;
            }
            
            if (!isset($this->parametersList[$key])) {
                continue;
            }

            $param = $this->parametersList[$key];
            if (!empty($param['is_sub_header'])) {
                $this->flags[$key] = '';
                $this->highlights[$key] = false;
                continue;
            }

            $range = $param['matched_range_details'] ?? null;
            $inputType = $param['input_type'] ?? 'numeric';
            $refText = trim($param['ref_range'] ?? ($range['display_range'] ?? ($range['normal_value'] ?? '')));

            $isAbnormal = false;
            $flag = '';

            // 1. Titer Evaluation (Widal, ANA, Serology titers e.g. 1:20, 1:40 vs <= 1:80)
            $titerResult = $this->evaluateTiter($trimmedVal, $refText, $param['name'] ?? '', $range);
            if ($titerResult !== null) {
                $isAbnormal = $titerResult['isAbnormal'];
                $flag = $titerResult['flag'];
            } elseif (is_numeric($trimmedVal) && ($inputType === 'numeric' || $inputType === 'calculated')) {
                // 2. Numeric / Calculated Check
                $numVal = (float)$trimmedVal;
                if ($range && is_numeric($range['min_val'] ?? null) && is_numeric($range['max_val'] ?? null)) {
                    if ($numVal < (float)$range['min_val']) {
                        $isAbnormal = true;
                        $flag = 'L';
                    } elseif ($numVal > (float)$range['max_val']) {
                        $isAbnormal = true;
                        $flag = 'H';
                    }
                } elseif (preg_match('/^(<=?|<|>=?|>)\s*([0-9\.]+)/', $refText, $ineqMatches)) {
                    $op = $ineqMatches[1];
                    $threshold = (float)$ineqMatches[2];
                    if ($op === '<' && $numVal >= $threshold) { $isAbnormal = true; $flag = 'H'; }
                    elseif ($op === '<=' && $numVal > $threshold) { $isAbnormal = true; $flag = 'H'; }
                    elseif ($op === '>' && $numVal <= $threshold) { $isAbnormal = true; $flag = 'L'; }
                    elseif ($op === '>=' && $numVal < $threshold) { $isAbnormal = true; $flag = 'L'; }
                }
            } else {
                // 3. Qualitative / Text Check
                $lowerVal = strtolower($trimmedVal);
                $lowerRef = strtolower($refText);

                // Standard clinical normal terms
                $knownNormalWords = [
                    'negative', 'non-reactive', 'non reactive', 'nonreactive',
                    'not detected', 'nil', 'absent', 'normal', 'clear',
                    'sterile', 'no growth', 'unreactive', 'within normal limits', '-'
                ];
                
                // Standard clinical abnormal terms
                $knownAbnormalWords = [
                    'positive', 'reactive', 'detected', 'present',
                    'abnormal', 'growth', 'trace', '1+', '2+', '3+', '4+'
                ];

                if (in_array($lowerVal, $knownNormalWords)) {
                    $isAbnormal = false;
                    $flag = '';
                } elseif (in_array($lowerVal, $knownAbnormalWords)) {
                    $isAbnormal = true;
                    $flag = 'Abn';
                } elseif (!empty($lowerRef)) {
                    // If not standard keyword, compare directly with reference text
                    if ($lowerVal !== $lowerRef) {
                        $isAbnormal = true;
                        $flag = 'Abn';
                    }
                }
            }

            $this->flags[$key] = $flag;
            $this->highlights[$key] = $isAbnormal;
        }
    }

    private function evaluateTiter($val, $refText, $paramName = '', $range = null)
    {
        $trimmedVal = trim((string)$val);
        $lowerVal = strtolower($trimmedVal);

        $knownNormalWords = [
            'negative', 'non-reactive', 'non reactive', 'nonreactive',
            'not detected', 'nil', 'absent', 'normal', 'clear',
            'sterile', 'no growth', 'unreactive', 'within normal limits', '-'
        ];
        $knownAbnormalWords = [
            'positive', 'reactive', 'detected', 'present',
            'abnormal', 'growth', 'trace', '1+', '2+', '3+', '4+'
        ];

        // Check if result is a titer (e.g. 1:20, 1:40, 1:80, 1:160, < 1:20, > 1:320, 1/80)
        $isValTiter = (bool)preg_match('/^(<=?|<|>=?|>)?\s*1\s*[:\/]\s*(\d+)$/i', $trimmedVal, $valMatches);

        // Check if reference contains a titer (e.g. <= 1:80, < 1:80, Negative (< 1:80), 1:80, <=1:160)
        $combinedRef = trim($refText . ' ' . ($range['display_range'] ?? '') . ' ' . ($range['normal_value'] ?? ''));
        $isRefTiter = (bool)preg_match('/(<=?|<|>=?|>|up\s*to\s*)?\s*1\s*[:\/]\s*(\d+)/i', $combinedRef, $refMatches);

        // Fallback: If ref doesn't have a titer, but param is Widal / Typhi
        if (!$isRefTiter && $isValTiter && preg_match('/(widal|typhi|paratyphi|\bTO\b|\bTH\b|\bAO\b|\bBH\b)/i', $paramName)) {
            $isRefTiter = true;
            $refMatches = [0, '<=', 80];
        }

        if ($isRefTiter) {
            // If value is a known normal word (e.g. "Negative", "Nil")
            if (in_array($lowerVal, $knownNormalWords)) {
                return ['isAbnormal' => false, 'flag' => ''];
            }
            // If value is a known abnormal word (e.g. "Positive")
            if (in_array($lowerVal, $knownAbnormalWords)) {
                return ['isAbnormal' => true, 'flag' => 'Abn'];
            }

            if ($isValTiter) {
                $valOp = $valMatches[1] ?? '';
                $valDenom = (int)$valMatches[2];

                $refOp = strtolower(trim($refMatches[1] ?? ''));
                $refDenom = (int)$refMatches[2];

                // If no operator is specified in ref, default to '<=' (standard serological normal threshold)
                if ($refOp === '' || $refOp === 'up to') {
                    $refOp = '<=';
                }

                $isAbnormal = false;
                if ($refOp === '<=') {
                    if ($valOp === '>') {
                        $isAbnormal = ($valDenom >= $refDenom);
                    } elseif ($valOp === '<') {
                        $isAbnormal = false;
                    } else {
                        $isAbnormal = ($valDenom > $refDenom);
                    }
                } elseif ($refOp === '<') {
                    if ($valOp === '>') {
                        $isAbnormal = true;
                    } elseif ($valOp === '<') {
                        $isAbnormal = ($valDenom > $refDenom);
                    } else {
                        $isAbnormal = ($valDenom >= $refDenom);
                    }
                } elseif ($refOp === '>=') {
                    $isAbnormal = ($valDenom < $refDenom);
                } elseif ($refOp === '>') {
                    $isAbnormal = ($valDenom <= $refDenom);
                }

                return [
                    'isAbnormal' => $isAbnormal,
                    'flag' => $isAbnormal ? 'Abn' : ''
                ];
            }
        }

        return null; // Not a titer test, proceed with normal logic
    }

    public function toggleHighlight($key)
    {
        $this->highlights[$key] = !($this->highlights[$key] ?? false);
    }

    public function saveReport($status = 'Draft')
    {
        $this->authorize('edit reports');

        $this->checkAndMarkTestCompleted();

        $targetStatus = $status;
        $canApprove = true;

        // Validation: Block approval if any results are missing
        if ($status === 'Approved') {
            $missingParams = [];
            foreach ($this->parametersList as $key => $details) {
                // Skip sub-headings from missing results validation
                if (!empty($details['is_sub_header'])) {
                    continue;
                }

                $val = $this->results[$key] ?? '';
                if (trim((string)$val) === '') {
                    $missingParams[] = $details['name'] . " (" . $details['test_name'] . ")";
                }
            }

            foreach ($this->cultureTestsList as $key => $details) {
                $cData = $this->cultureData[$key] ?? [];
                $growth = $cData['growth_status'] ?? '';
                if (empty(trim($cData['specimen'] ?? '')) || empty(trim($growth))) {
                    $missingParams[] = $details['test_name'] . " (Culture Data Missing)";
                } elseif (!in_array($growth, ['No Growth', 'Sterile']) && empty(trim($cData['organism_name'] ?? ''))) {
                    $missingParams[] = $details['test_name'] . " (Organism Name Missing)";
                }
            }

            if (!empty($missingParams)) {
                $canApprove = false;
                $msg = "Cannot approve report. The following results are missing: " . implode(', ', array_slice($missingParams, 0, 3));
                if (count($missingParams) > 3) $msg .= " and " . (count($missingParams) - 3) . " more.";
                
                $this->dispatch('notify', ['type' => 'error', 'message' => $msg]);
                session()->flash('error', $msg);
            } else {
                // All parameters are present, ensure all items are marked Completed
                foreach ($this->invoice->items as $invItem) {
                    if ($invItem->status !== 'Completed') {
                        $invItem->update(['status' => 'Completed']);
                    }
                }
                $this->invoice->load('items');
            }

            if (!$canApprove) {
                $targetStatus = 'Draft'; // Downgrade to Draft so it still saves the progress
            }
        }

        if ($targetStatus === 'Approved') {
            $approvalTime = now();
            $this->report_date = $approvalTime->format('Y-m-d\TH:i');
            $this->invoice->update(['expected_report_time' => $approvalTime]);
            $apprDate = $approvalTime;
        } else {
            // Update expected_report_time on invoice for drafts if report_date is set
            if ($this->report_date) {
                $this->invoice->update(['expected_report_time' => $this->report_date]);
            }
            $apprDate = $this->report_date ?: now();
        }

        if (!$this->testReport) {
            $this->testReport = TestReport::create([
                'company_id' => $this->invoice->company_id,
                'invoice_id' => $this->invoice->id,
                'patient_id' => $this->invoice->patient_id,
                'status' => $targetStatus,
                'comments' => $this->comments,
                'approved_by' => $targetStatus === 'Approved' ? auth()->id() : null,
                'approved_at' => $targetStatus === 'Approved' ? $apprDate : null,
            ]);
        } else {
            $this->testReport->update([
                'status' => $targetStatus,
                'comments' => $this->comments,
                'approved_by' => $targetStatus === 'Approved' ? auth()->id() : $this->testReport->approved_by,
                'approved_at' => $targetStatus === 'Approved' ? $apprDate : $this->testReport->approved_at,
            ]);
        }

        // Save Results in exact reordered sequence
        ReportResult::where('test_report_id', $this->testReport->id)->delete();
        foreach ($this->parametersList as $key => $details) {

            // Sub-header: save as blank result + blank range so report treats it as a section heading
            if (!empty($details['is_sub_header'])) {
                ReportResult::create([
                    'test_report_id'  => $this->testReport->id,
                    'invoice_item_id' => $details['invoice_item_id'],
                    'lab_test_id'     => $details['lab_test_id'],
                    'parameter_name'  => $details['name'],
                    'result_value'    => null,
                    'status'          => 'Normal',
                    'is_highlighted'  => false,
                    'reference_range' => null,
                    'unit'            => null,
                    'method'          => null,
                ]);
                continue;
            }

            $val = $this->results[$key] ?? '';
            $highlight = $this->highlights[$key] ?? false;

            // Determine textual status based on flags
            $flag = $this->flags[$key] ?? '';
            $stat = 'Normal';
            if ($flag === 'H') $stat = 'High';
            if ($flag === 'L') $stat = 'Low';

            ReportResult::create([
                'test_report_id'  => $this->testReport->id,
                'invoice_item_id' => $details['invoice_item_id'],
                'lab_test_id'     => $details['lab_test_id'],
                'parameter_name'  => $details['name'],
                'result_value'    => $val,
                'status'          => $stat,
                'is_highlighted'  => $highlight,
                'reference_range' => $details['ref_range'],
                'unit'            => $details['unit'],
                'method'          => $details['method'] ?? null,
            ]);
        }

        // Save Culture Results
        foreach ($this->cultureTestsList as $key => $details) {
            $cData = $this->cultureData[$key] ?? [];
            
            $cultureResult = \App\Models\CultureResult::updateOrCreate(
                [
                    'test_report_id' => $this->testReport->id,
                    'invoice_item_id' => $details['invoice_item_id'],
                    'lab_test_id' => $details['lab_test_id'],
                ],
                [
                    'specimen' => $cData['specimen'] ?? null,
                    'growth_status' => $cData['growth_status'] ?? null,
                    'incubation_period' => $cData['incubation_period'] ?? null,
                    'organism_name' => $cData['organism_name'] ?? null,
                    'colony_count' => $cData['colony_count'] ?? null,
                    'remarks' => $cData['remarks'] ?? null,
                ]
            );

            // Sync Antibiotics
            $cultureResult->antibiotics()->delete(); // Clear old
            $abs = $this->cultureAntibiotics[$key] ?? [];
            foreach ($abs as $ab) {
                // Only save antibiotic if a sensitivity was selected OR if they provided an MIC value
                if (!empty(trim($ab['antibiotic_name'] ?? '')) && (!empty(trim($ab['sensitivity'] ?? '')) || !empty(trim($ab['mic_value'] ?? '')))) {
                    $cultureResult->antibiotics()->create([
                        'antibiotic_name' => $ab['antibiotic_name'],
                        'sensitivity' => $ab['sensitivity'] ?? null,
                        'mic_value' => $ab['mic_value'] ?? null,
                    ]);
                }
            }
        }

        // Save Test Level Comments (Granular for packages)
        foreach ($this->invoice->items as $item) {
            $itemComments = [];
            $hasGranular = false;
            
            // Collect all comments belonging to this item
            foreach ($this->testComments as $key => $comment) {
                if (str_starts_with($key, $item->id . '_')) {
                    $testId = substr($key, strlen($item->id . '_'));
                    $itemComments[$testId] = $comment;
                    $hasGranular = true;
                }
            }
            
            if ($hasGranular) {
                // If it's a single test (not package) AND only one comment exists, store as plain text for backward compatibility
                if (!$item->labTest->is_package && count($itemComments) === 1) {
                    $item->update(['report_comments' => reset($itemComments)]);
                } else {
                    // Store as JSON for packages or multiple entries
                    $item->update(['report_comments' => json_encode($itemComments)]);
                }
            }
        }

        if ($status === 'Approved' && !$canApprove) {
            // Data is saved as Draft, but approval failed (error message already flashed).
            return;
        }

        if ($targetStatus === 'Approved') {
            $this->invoice->update(['sample_status' => 'Ready']);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Report Approved Successfully and ready for printing.']);
            session()->flash('success', 'Report Approved Successfully and ready for printing.');

            // Pre-generate PDF for R2 offloading
            try {
                $pdfService = new \App\Services\PdfStorageService();
                $pdfService->storeReportPdf($this->testReport);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to pre-generate PDF: " . $e->getMessage());
            }

            return redirect()->route('lab.reports');
        } else {
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Draft Saved Successfully.']);
            session()->flash('success', 'Draft Saved Successfully.');
        }
    }

    public function toggleTestStatus($itemId)
    {
        $this->authorize('edit reports');
        $item = \App\Models\InvoiceItem::findOrFail($itemId);
        $newStatus = $item->status === 'Completed' ? 'Pending' : 'Completed';
        $item->update(['status' => $newStatus]);
        
        // Refresh invoice to get updated status
        $this->invoice->load('items');
        
        $this->dispatch('notify', ['type' => 'success', 'message' => "Test status updated to {$newStatus}."]);
        session()->flash('success', "Test status updated to {$newStatus}.");
    }

    public function printSelected($withHeader = 1)
    {
        $testIds = $this->selectedTests;
        if (empty($testIds)) {
            // Auto-select completed test items or all test items if none checked
            $testIds = $this->invoice->items->where('status', 'Completed')->pluck('id')->toArray();
            if (empty($testIds)) {
                $testIds = $this->invoice->items->pluck('id')->toArray();
            }
        }

        if (empty($testIds)) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'No test results available to print.']);
            session()->flash('error', 'No test results available to print.');
            return;
        }

        // Save as Draft before printing to ensure TestReport exists (prevents 404) and includes the latest results
        $this->saveReport('Draft');

        // Printing proceeds regardless of image presence to allow for physical letterhead space
        $idsString = is_array($testIds) ? implode(',', $testIds) : $testIds;
        $url = route('lab.reports.print', ['id' => $this->invoice->id, 'template' => 'new'])
             . '?tests=' . $idsString
             . '&header=' . ($withHeader ? '1' : '0');
        
        $this->dispatch('open-new-tab', ['url' => $url]);
    }

    public function addCultureAntibiotic($key)
    {
        $this->cultureAntibiotics[$key][] = ['antibiotic_name' => '', 'sensitivity' => '', 'mic_value' => ''];
    }

    public function removeCultureAntibiotic($key, $index)
    {
        unset($this->cultureAntibiotics[$key][$index]);
        $this->cultureAntibiotics[$key] = array_values($this->cultureAntibiotics[$key]);
    }

    public function moveParameterUp($key)
    {
        $keys = array_keys($this->parametersList);
        $index = array_search($key, $keys);

        if ($index !== false && $index > 0) {
            $prevKey = $keys[$index - 1];
            if (isset($this->parametersList[$key]) && isset($this->parametersList[$prevKey]) &&
                $this->parametersList[$key]['invoice_item_id'] === $this->parametersList[$prevKey]['invoice_item_id'] &&
                $this->parametersList[$key]['lab_test_id'] === $this->parametersList[$prevKey]['lab_test_id']) {
                
                $keys[$index] = $prevKey;
                $keys[$index - 1] = $key;

                $reordered = [];
                foreach ($keys as $k) {
                    $reordered[$k] = $this->parametersList[$k];
                }
                $this->parametersList = $reordered;
            }
        }
    }

    public function moveParameterDown($key)
    {
        $keys = array_keys($this->parametersList);
        $index = array_search($key, $keys);

        if ($index !== false && $index < count($keys) - 1) {
            $nextKey = $keys[$index + 1];
            if (isset($this->parametersList[$key]) && isset($this->parametersList[$nextKey]) &&
                $this->parametersList[$key]['invoice_item_id'] === $this->parametersList[$nextKey]['invoice_item_id'] &&
                $this->parametersList[$key]['lab_test_id'] === $this->parametersList[$nextKey]['lab_test_id']) {
                
                $keys[$index] = $nextKey;
                $keys[$index + 1] = $key;

                $reordered = [];
                foreach ($keys as $k) {
                    $reordered[$k] = $this->parametersList[$k];
                }
                $this->parametersList = $reordered;
            }
        }
    }

    public function reorderParameters($fromKey, $toKey)
    {
        if (!isset($this->parametersList[$fromKey]) || !isset($this->parametersList[$toKey])) return;

        $keys = array_keys($this->parametersList);
        $fromIndex = array_search($fromKey, $keys);
        $toIndex = array_search($toKey, $keys);

        if ($fromIndex !== false && $toIndex !== false && $fromIndex !== $toIndex) {
            if ($this->parametersList[$fromKey]['invoice_item_id'] === $this->parametersList[$toKey]['invoice_item_id'] &&
                $this->parametersList[$fromKey]['lab_test_id'] === $this->parametersList[$toKey]['lab_test_id']) {
                
                $movedKey = array_splice($keys, $fromIndex, 1)[0];
                array_splice($keys, $toIndex, 0, [$movedKey]);

                $reordered = [];
                foreach ($keys as $k) {
                    $reordered[$k] = $this->parametersList[$k];
                }
                $this->parametersList = $reordered;
            }
        }
    }

    public function render()
    {
        $allItems = collect($this->parametersList)->merge(collect($this->cultureTestsList));

        // Group parameters by Department -> Invoice Item (Bill Line) -> Lab Test (Actual Test Name)
        $groupedParams = $allItems->groupBy('department')->map(function ($items) {
            return collect($items)->groupBy('invoice_item_id')->map(function ($testGroup) {
                return collect($testGroup)->groupBy('lab_test_id');
            });
        });

        return view('livewire.lab.result-entry-manager', [
            'groupedParams' => $groupedParams
        ])->layout('layouts.app');
    }
}
