<div>
    <style>
        .pos-container {
            background: #f4f6f9;
            min-height: 100vh;
            padding-bottom: 100px; /* Space for fixed bottom buttons if any, or just breathing room */
        }
        .pos-card {
            background: #fff;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-radius: 4px;
            overflow: hidden;
        }
        .pos-header {
            padding: 12px 15px;
            color: #fff;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 15px;
        }
        .bg-blue { background-color: #007bff !important; }
        .bg-green { background-color: #C70000 !important; }
        .bg-red { background-color: #dc3545 !important; }
        
        .btn-create {
            background: #f39c12;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-create:hover { background: #e67e22; color: #fff; }

        .form-label {
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 6px;
            color: #444;
            display: block;
        }
        .form-control-pos, .form-select-pos {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 8px 12px;
            font-size: 14px;
            height: 42px !important;
            width: 100%;
            display: block;
            line-height: 1.5;
        }
        .form-control-pos:focus, .form-select-pos:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }

        .search-dropdown {
            max-height: 250px;
            overflow-y: auto;
            z-index: 1060;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border: 1px solid #ddd;
            background: #fff;
            width: 100%;
        }
        .search-dropdown .list-group-item {
            padding: 10px 15px;
            cursor: pointer;
            font-size: 13px;
        }
        .search-dropdown .list-group-item:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }

        .test-list {
            max-height: 450px;
            overflow-y: auto;
        }
        .test-item {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            cursor: pointer;
        }
        .test-item:hover { background: #fcfcfc; }

        .table-pos thead th {
            background: #0d6efd !important;
            color: #fff !important;
            font-size: 15px !important;
            text-transform: uppercase;
            font-weight: 800 !important;
            padding: 15px 10px !important;
            border: 1px solid #0056b3 !important;
        }
        .table-pos tbody td {
            font-size: 18px !important;
            font-weight: 700 !important;
            padding: 15px 10px !important;
            color: #1a1d29 !important;
            vertical-align: middle;
        }

        .card-header {
            padding: 15px 20px !important;
            font-size: 15px;
            color: #333;
        }

        .receipt-row { 
            display: flex; 
            align-items: center; 
            justify-content: space-between;
            padding: 15px 0; 
            border-bottom: 1px dashed #ddd; 
        }
        .receipt-label { 
            font-size: 18px !important; 
            font-weight: 800 !important; 
            flex: 1; 
            color: #333;
        }
        .receipt-total {
            font-size: 20px;
            font-weight: 800;
            color: #000;
            margin-top: 15px;
            padding-top: 10px;
        }

        .bottom-actions {
            display: flex;
            gap: 20px;
            padding: 25px;
            background: #fff;
            border-top: 2px solid #eee;
            margin-top: 30px;
        }
        .btn-action {
            flex: 1;
            padding: 14px;
            font-weight: 700;
            font-size: 16px;
            border: none;
            text-transform: uppercase;
            border-radius: 6px;
        }
        .btn-save { background: #007bff; color: #fff; }
        .btn-cancel { background: #dc3545; color: #fff; }
        
        .input-group-text-pos {
            background: #e9ecef;
            border: 1px solid #ced4da;
            padding: 0 12px;
            display: flex;
            align-items: center;
            font-size: 13px;
            font-weight: 600;
            color: #495057;
        }

        /* Hide Spinners */
        input[type=number].no-spinners::-webkit-inner-spin-button, 
        input[type=number].no-spinners::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number].no-spinners {
            -moz-appearance: textfield;
        }
        /* Dark Mode Overrides */
        .app-skin-dark .pos-container {
            background: #1a1d29;
        }
        .app-skin-dark .pos-card {
            background: #232734;
            border-color: #31374a;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .app-skin-dark .form-label {
            color: #aeb4c5;
        }
        .app-skin-dark .form-control-pos, 
        .app-skin-dark .form-select-pos {
            background-color: #2b303f;
            border-color: #3e445a;
            color: #fff;
        }
        .app-skin-dark .form-control-pos:focus, 
        .app-skin-dark .form-select-pos:focus {
            background-color: #2b303f;
            border-color: #007bff;
            color: #fff;
        }
        .app-skin-dark .table-pos thead th {
            background: #2b303f;
            color: #aeb4c5;
            border-bottom-color: #3e445a;
        }
        .app-skin-dark .table-pos tbody td {
            color: #fff;
            border-bottom-color: #31374a;
        }
        .app-skin-dark .test-item {
            border-bottom-color: #31374a;
            color: #fff;
        }
        .app-skin-dark .test-item:hover {
            background: #2b303f;
        }
        .app-skin-dark .search-dropdown {
            background: #232734;
            border-color: #3e445a;
        }
        .app-skin-dark .search-dropdown .list-group-item {
            background: #232734;
            color: #fff;
            border-bottom-color: #31374a;
        }
        .app-skin-dark .search-dropdown .list-group-item:hover {
            background: #2b303f;
        }
        .app-skin-dark .receipt-row {
            border-bottom-color: #31374a;
        }
        .app-skin-dark .receipt-label {
            color: #aeb4c5;
        }
        .app-skin-dark .receipt-total {
            color: #fff;
            border-top-color: #3e445a;
        }
        .app-skin-dark .bottom-actions {
            background: #232734;
            border-top-color: #3e445a;
        }
        .app-skin-dark .input-group-text-pos {
            background: #3e445a;
            border-color: #3e445a;
            color: #fff;
        }
        .app-skin-dark .bg-light {
            background-color: #2b303f !important;
            color: #fff !important;
        }
        .app-skin-dark .card-header {
            background-color: #2b303f !important;
            color: #fff !important;
            border-bottom-color: #3e445a !important;
        }
        .app-skin-dark .breadcrumb-item a {
            color: #aeb4c5;
        }
        .app-skin-dark .breadcrumb-item.active {
            color: #fff;
        }
        .app-skin-dark .text-muted {
            color: #aeb4c5 !important;
        }
        .app-skin-dark .text-dark {
            color: #fff !important;
        }
        .app-skin-dark .badge.bg-white {
            background-color: #3e445a !important;
            color: #fff !important;
        }
        .app-skin-dark input.form-control-pos:read-only {
            background-color: #1a1d29;
            color: #007bff;
        }
    </style>

    <div class="pos-container">
        {{-- Flash Messages --}}
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="container-fluid pt-4">
            {{-- PAGE TITLE --}}
            <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                <h4 class="mb-0 fw-bold"><i class="feather-file-text me-2 text-primary"></i>Invoices</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Groups</li>
                        <li class="breadcrumb-item active">Create invoice</li>
                    </ol>
                </nav>
            </div>

            {{-- 1. PATIENT INFO SECTION --}}
            <div class="pos-card mx-2">
                <div class="pos-header bg-blue">
                    <span><i class="feather-user me-2"></i>Patient Info</span>
                    <button wire:click="$set('isPatientModalOpen', true)" class="btn-create">
                        <i class="feather-plus-circle me-1"></i>Create Patient ?
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        {{-- Row 1 --}}
                        <div class="col-md-3">
                            <label class="form-label">Search Patient</label>
                            <div class="position-relative" x-data="{ open: false }" @click.away="open = false">
                                <input type="text" class="form-control-pos" 
                                    wire:model.live.debounce.300ms="patientSearch"
                                    @focus="open = true; $wire.set('activeSearchField', 'patient')"
                                    placeholder="Search by Name/Phone">
                                <div x-show="open" class="search-dropdown position-absolute">
                                    @forelse($patients as $pt)
                                        <div wire:click="selectPatient({{ $pt->id }})" @click="open = false" class="list-group-item">
                                            <div class="fw-bold">{{ $pt->name }}</div>
                                            <div class="text-muted fs-12">{{ $pt->phone }}</div>
                                        </div>
                                    @empty
                                        <div class="list-group-item text-muted">No patients found</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Name</label>
                            <div class="d-flex">
                                <select class="form-select-pos rounded-0 rounded-start bg-light px-1 text-center" style="max-width: 75px; border-right:0;" wire:model="patient_title">
                                    <option value="">-</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Master">Master</option>
                                    <option value="Baby">Baby</option>
                                    <option value="B/O">B/O</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Prof.">Prof.</option>
                                    <option value="Smt.">Smt.</option>
                                    <option value="Sri">Sri</option>
                                </select>
                                <input type="text" class="form-control-pos rounded-0 rounded-end" wire:model="patient_name" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Age</label>
                            <div class="d-flex">
                                <input type="number" class="form-control-pos rounded-0 rounded-start" style="border-right:0;" wire:model="patient_age">
                                <select class="form-select-pos rounded-0 rounded-end" style="max-width: 100px;" wire:model="patient_age_unit">
                                    <option value="">-</option>
                                    <option value="Years">Year</option>
                                    <option value="Months">Month</option>
                                    <option value="Days">Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control-pos" wire:model="patient_phone">
                        </div>

                        {{-- Row 2 --}}
                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control-pos" wire:model="patient_email" placeholder="example@mail.com">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select-pos" wire:model="patient_gender">
                                <option value="">-</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Referred by</label>
                            <div class="position-relative" x-data="{ open: false }" @click.away="open = false">
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control-pos flex-grow-1" 
                                        wire:model.live.debounce.300ms="doctorSearch"
                                        @focus="open = true; $wire.set('activeSearchField', 'doctor')"
                                        placeholder="Search Doctor">
                                    <button wire:click="$set('isDoctorModalOpen', true)" class="btn-create flex-shrink-0">
                                        Create ?
                                    </button>
                                </div>
                                <div x-show="open" class="search-dropdown position-absolute w-100 mt-1" style="z-index: 10;">
                                    <div wire:click="clearDoctor(); open = false; $wire.set('doctorSearch', '')" class="list-group-item text-muted">Clear Selection</div>
                                    @foreach(\App\Models\User::role('doctor')->where('company_id', auth()->user()->company_id)->where('name', 'ilike', "%{$doctorSearch}%")->get() as $doc)
                                        <div wire:click="selectDoctor({{ $doc->id }}); open = false" class="list-group-item">
                                            <div class="fw-bold">{{ $doc->name }}</div>
                                            <div class="text-muted fs-12">{{ $doc->phone }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Select Agent</label>
                            <div class="position-relative" x-data="{ open: false }" @click.away="open = false">
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control-pos flex-grow-1" 
                                        wire:model.live.debounce.300ms="agentSearch"
                                        @focus="open = true; $wire.set('activeSearchField', 'agent')"
                                        placeholder="Search Agent">
                                    <button wire:click="$set('isAgentModalOpen', true)" class="btn-create flex-shrink-0">
                                        Create ?
                                    </button>
                                </div>
                                <div x-show="open" class="search-dropdown position-absolute w-100 mt-1" style="z-index: 10;">
                                    <div wire:click="clearAgent(); open = false; $wire.set('agentSearch', '')" class="list-group-item text-muted">Clear Selection</div>
                                    @foreach(\App\Models\User::role('agent')->where('company_id', auth()->user()->company_id)->where('name', 'ilike', "%{$agentSearch}%")->get() as $agt)
                                        <div wire:click="selectAgent({{ $agt->id }}); open = false" class="list-group-item">
                                            <div class="fw-bold">{{ $agt->name }}</div>
                                            <div class="text-muted fs-12">{{ $agt->phone }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Row 3 --}}
                        <div class="col-md-3">
                            <label class="form-label">Collection At</label>
                            <select class="form-select-pos" wire:model="collection_type">
                                <option>Center</option>
                                <option>Home Collection</option>
                                <option>Hospital</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Bill No.</label>
                            <input type="text" class="form-control-pos bg-light fw-bold text-primary" wire:model="bill_no" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Barcode No.</label>
                            <div class="d-flex">
                                <div class="input-group-text-pos rounded-start"><i class="feather-bar-chart-2"></i></div>
                                <input type="text" class="form-control-pos rounded-0 rounded-end" wire:model="barcode_no">
                            </div>
                        </div>

                        {{-- Row 4 --}}
                        <div class="col-md-3">
                            <label class="form-label">Sample Received</label>
                            <input type="datetime-local" class="form-control-pos" wire:model="sample_received_at">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Report Date & Time</label>
                            <input type="datetime-local" class="form-control-pos" wire:model="expected_report_at">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-0">
                <div class="col-md-8 px-2">
                    {{-- 2. PACKAGE --}}
                    <div class="pos-card">
                        <div class="pos-header bg-green">
                            <span><i class="feather-package me-2"></i>Package</span>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select-pos" wire:change="addTestToCart($event.target.value)">
                                <option value="">Select Package</option>
                                @foreach(\App\Models\LabTest::where('is_package', true)->get() as $pkg)
                                    <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 3. TESTS --}}
                    <div class="pos-card">
                        <div class="pos-header bg-red">
                            <span><i class="feather-activity me-2"></i>Tests</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="position-relative mb-3">
                                <input type="text" class="form-control-pos ps-5" 
                                    wire:model.live.debounce.300ms="testSearch" 
                                    @focus="$wire.set('activeSearchField', 'test')"
                                    placeholder="Search test by name or code...">
                                <i class="feather-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                            
                            <div class="test-list border rounded">
                                @foreach($tests as $test)
                                    @if(!$test->is_package)
                                    <div class="test-item" wire:click="addTestToCart({{ $test->id }})">
                                        <input type="checkbox" style="width:18px; height:18px; pointer-events: none;" 
                                            {{ collect($cart)->contains('id', $test->id) ? 'checked' : '' }}>
                                        <div class="flex-grow-1 fw-600">{{ $test->name }}</div>
                                        <div class="text-success fw-bold">₹ {{ number_format($test->mrp, 2) }}</div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 px-2">
                    {{-- 4. SELECT COLLECTION CENTER --}}
                    <div class="pos-card">
                        <div class="pos-header bg-blue">
                            <span><i class="feather-map-pin me-2"></i>Select Collection Center</span>
                        </div>
                        <div class="card-body p-3">
                            <select class="form-select-pos" wire:model="collection_center_id">
                                <option value="">Select Collection Center</option>
                                @foreach(\App\Models\CollectionCenter::all() as $cc)
                                    <option value="{{ $cc->id }}">{{ $cc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 5. SELECTED TEST --}}
                    <div class="pos-card">
                        <div class="pos-header bg-red">
                            <span><i class="feather-shopping-cart me-2"></i>Selected Test</span>
                        </div>
                        <div class="card-body p-0" style="max-height: 380px; overflow-y: auto;">
                            <table class="table table-pos mb-0">
                                <thead class="position-sticky top-0" style="z-index: 5;">
                                    <tr>
                                        <th>Test Name</th>
                                        <th style="width: 120px;">Price</th>
                                        <th style="width: 80px;">Disc.</th>
                                        <th style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cart as $index => $item)
                                        <tr wire:key="cart-item-{{ $index }}">
                                            <td class="small fw-500">{{ $item['name'] }}</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm text-end no-spinners" 
                                                    style="height: 34px; font-weight: bold; width: 100%;"
                                                    wire:model.live="cart.{{ $index }}.price" wire:change="calculateTotals">
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $mrp = (float)($item['mrp'] ?? 0);
                                                    $price = (float)($item['price'] ?? 0);
                                                    $disc = $mrp > 0 ? round((($mrp - $price) / $mrp) * 100) : 0;
                                                @endphp
                                                <span class="badge bg-soft-info text-info">{{ $disc }}%</span>
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="removeFromCart({{ $index }})" class="btn btn-sm btn-outline-danger p-1 px-2">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center p-4 text-muted">No tests selected</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 6. RECEIPT & PAYMENTS --}}
            <div class="row g-0 mb-5">
                <div class="col-md-6 px-2">
                    <div class="pos-card h-100 mb-0">
                        <div class="card-header bg-light fw-bold py-3">Receipt Summary</div>
                        <div class="card-body p-4">
                            <div class="receipt-row">
                                <span class="receipt-label">Subtotal (MRP)</span>
                                <div class="d-flex align-items-center bg-light border rounded px-3 py-3" style="width: 280px;">
                                    <span class="fw-bold fs-18 me-auto">{{ number_format($subtotal, 2) }}</span>
                                    <span class="small text-muted fw-bold">INR</span>
                                </div>
                            </div>
                            @php
                                $item_discount = $subtotal - collect($cart)->sum(fn($item) => (float) ($item['price'] ?? 0));
                            @endphp
                            @if($item_discount > 0)
                            <div class="receipt-row">
                                <span class="receipt-label text-danger">Item Discount</span>
                                <div class="d-flex align-items-center bg-soft-danger border border-danger border-opacity-25 rounded px-3 py-3" style="width: 280px;">
                                    <span class="fw-bold fs-18 text-danger me-auto">- {{ number_format($item_discount, 2) }}</span>
                                    <span class="small text-danger fw-bold">INR</span>
                                </div>
                            </div>
                            @endif
                            <div class="receipt-row">
                                <span class="receipt-label">Membership</span>
                                <select class="form-select fw-bold fs-18" style="width: 280px; height: 50px;" wire:model.live="selectedMembershipId">
                                    <option value="">Select contract</option>
                                    @foreach(\App\Models\Membership::all() as $mem)
                                        <option value="{{ $mem->id }}">{{ $mem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($membership_fee > 0)
                            <div class="receipt-row">
                                <span class="receipt-label text-primary">Membership Fee</span>
                                <div class="d-flex align-items-center bg-soft-primary border border-primary border-opacity-25 rounded px-3 py-3" style="width: 280px;">
                                    <span class="fw-bold fs-18 text-primary me-auto">+ {{ number_format($membership_fee, 2) }}</span>
                                    <span class="small text-primary fw-bold">INR</span>
                                </div>
                            </div>
                            @endif
                            <div class="receipt-row">
                                <span class="receipt-label">Membership Discount</span>
                                <div class="d-flex align-items-center bg-light border rounded px-3 py-2" style="width: 280px; height: 50px;">
                                    <span class="fw-bold fs-18 text-success me-auto">- {{ number_format($membership_discount_amt, 2) }}</span>
                                    <span class="small text-muted fw-bold">INR</span>
                                </div>
                            </div>
                            <div class="receipt-row border-bottom-0 pb-0">
                                <span class="receipt-label">Additional Discount</span>
                                <div class="d-flex gap-0" style="width: 280px;">
                                    <input type="number" class="form-control-pos rounded-0 rounded-start border-end-0 fw-bold fs-18 text-end" 
                                        style="height: 50px;" wire:model.live.debounce.300ms="manual_discount_input" placeholder="0">
                                    <select class="form-select-pos rounded-0 rounded-end bg-light fw-bold text-center px-1" 
                                        style="width: 90px; height: 50px;" wire:model.live="manual_discount_type">
                                        <option value="flat">INR</option>
                                        <option value="percent">%</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="receipt-total border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-16">Total Payable</span>
                                    <span class="text-dark fw-bold">{{ number_format($net_payable, 2) }} <small class="fs-12">INR</small></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-success fs-14 mt-2">
                                    <span>Total Paid</span>
                                    <span>{{ number_format(collect($payments)->sum(fn($p) => (float)($p['amount'] ?? 0)), 2) }} <small class="fs-12">INR</small></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-danger fs-15 mt-1 pt-2 border-top">
                                    <span class="fw-bold">Due Amount</span>
                                    <span class="fw-bold">{{ number_format($due_amount, 2) }} <small class="fs-12">INR</small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 px-2">
                    <div class="pos-card h-100 mb-0">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                            <span class="fw-bold">Payments</span>
                            <button wire:click="addPaymentRow" class="btn btn-sm btn-success px-3">
                                <i class="feather-plus me-1"></i> Payment
                            </button>
                        </div>
                        <div class="card-body p-4">
                            <button class="btn-create mb-4 w-100" style="background: #f39c12; height: 45px;" wire:click="$set('isPaymentModeModalOpen', true)">
                                <i class="feather-credit-card me-2"></i>Create Payment method
                            </button>
                            
                            <div class="table-responsive">
                                <table class="table table-pos border rounded">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($payments as $index => $pay)
                                            <tr wire:key="payment-row-{{ $index }}">
                                                <td><input type="date" class="form-control form-control-sm bg-light border-0" value="{{ date('Y-m-d') }}" readonly></td>
                                                <td><input type="number" class="form-control form-control-sm fw-bold" wire:model.live="payments.{{ $index }}.amount"></td>
                                                <td>
                                                    <select class="form-select form-select-sm" wire:model="payments.{{ $index }}.mode_id">
                                                        <option value="">Select Mode</option>
                                                        @foreach(\App\Models\PaymentMode::all() as $mode)
                                                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button wire:click="removePaymentRow({{ $index }})" class="btn btn-sm btn-soft-danger rounded-circle">
                                                        <i class="feather-x"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTTOM ACTIONS --}}
        <div class="bottom-actions container-fluid">
            <button wire:click="generateBill" class="btn-action btn-save shadow-sm">
                <i class="feather-check-circle me-2"></i>Complete & Save Invoice
            </button>
            <button wire:click="clearPatient" class="btn-action btn-cancel shadow-sm">
                <i class="feather-trash-2 me-2"></i>Cancel & Clear
            </button>
        </div>

        {{-- Include Modals --}}
        @include('livewire.lab.pos-modals')
    </div>
</div>
