<?php

use App\Models\Company;
use App\Models\Department;
use App\Models\GlobalTest;
use App\Models\LabTest;
use App\Services\LabTestService;

test('creating a new lab imports all global tests into that lab', function () {
    $company = Company::create([
        'name' => 'Import Test Lab',
        'email' => 'import-test-' . uniqid() . '@example.com',
        'phone' => '9999999999',
        'status' => 'active',
    ]);

    $department = Department::create([
        'company_id' => null,
        'name' => 'System Department',
        'is_active' => true,
        'is_system' => true,
    ]);

    $globalTest = GlobalTest::create([
        'name' => 'Imported Test ' . uniqid(),
        'test_code' => 'IMP' . rand(1000, 9999),
        'department_id' => $department->id,
        'mrp' => 150,
        'default_parameters' => [],
        'is_active' => true,
    ]);

    $service = new LabTestService();
    $importedCount = $service->importAllGlobalTests($company->id);

    expect($importedCount)->toBe(1);
    expect(LabTest::where('company_id', $company->id)->count())->toBe(1);
    expect(LabTest::where('company_id', $company->id)->first()->global_test_id)->toBe($globalTest->id);
});
