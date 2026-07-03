<div>
    <style>
        .summary-container {
            background: #f4f6f9;
            min-height: 100vh;
            padding-bottom: 50px;
        }
        .summary-card {
            background: #fff;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-radius: 4px;
            /* overflow: hidden; */
        }
        .summary-header {
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
        .bg-orange { background-color: #f39c12 !important; }
        
        .btn-action-pos {
            background: #f39c12;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-action-pos:hover { background: #e67e22; color: #fff; }

        .info-label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: #888;
            margin-bottom: 5px;
            display: block;
        }
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .avatar-box {
            width: 45px;
            height: 45px;
            background: #eef2f7;
            color: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .table-summary thead th {
            background: #f8f9fa;
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            padding: 12px 15px;
            border-bottom: 2px solid #dee2e6;
        }
        .table-summary tbody td {
            padding: 12px 15px;
            font-size: 14px;
            vertical-align: middle;
            color: #444;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
            font-size: 14px;
        }
        .total-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #eee;
        }

        /* Dark Mode Overrides */
        .app-skin-dark .summary-container {
            background: #1a1d29;
        }
        .app-skin-dark .summary-card {
            background: #232734;
            border-color: #31374a;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .app-skin-dark .dropdown-menu {
            background-color: #2b303f;
            border-color: #3e445a;
        }
        .app-skin-dark .dropdown-item {
            color: #fff;
        }
        .app-skin-dark .dropdown-item:hover {
            background-color: #3e445a;
            color: #fff;
        }
        .app-skin-dark .dropdown-divider {
            border-top-color: #3e445a;
        }
        .app-skin-dark .info-value,
        .app-skin-dark .text-dark,
        .app-skin-dark h4,
        .app-skin-dark h5 {
            color: #fff !important;
        }
        .app-skin-dark .text-muted {
            color: #aeb4c5 !important;
        }
        .app-skin-dark .table-summary thead th {
            background: #2b303f;
            color: #aeb4c5;
            border-bottom-color: #3e445a;
        }
        .app-skin-dark .table-summary tbody td {
            color: #fff;
            border-bottom-color: #31374a;
        }
        .app-skin-dark .summary-row {
            border-bottom-color: #31374a;
        }
        .app-skin-dark .total-box {
            background: #2b303f;
            border-color: #3e445a;
        }
        .app-skin-dark .bg-light {
            background-color: #3e445a !important;
            color: #fff !important;
        }
        .app-skin-dark .border-top,
        .app-skin-dark .border-bottom {
            border-color: #31374a !important;
        }
        .app-skin-dark .avatar-box {
            background: #3e445a;
            border-color: #4e556a;
            color: #007bff;
        }
    </style>

    <div class="summary-container">
        <div class="container-fluid pt-4">
            {{-- PAGE HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                <div>
                    <h4 class="mb-0 fw-bold text-dark">Bill Summary</h4>
                    <div class="text-muted small mt-1">
                        <a href="{{ route('lab.dashboard') }}" class="text-decoration-none">Home</a> / 
                        <a href="{{ route('lab.pos') }}" class="text-decoration-none">POS</a> / 
                        <span class="text-primary fw-bold">{{ $invoice->invoice_number }}</span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('lab.pos') }}" wire:navigate class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="feather-plus me-2"></i>New Bill
                    </a>
                </div>
            </div>

            {{-- ACTIONS BAR --}}
            <div class="summary-card mx-2 p-3 bg-white d-flex flex-wrap gap-2 align-items-center">
                <div class="dropdown">
                    <button class="btn btn-outline-primary fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="feather-printer me-2"></i>Print Options
                    </button>
                    <ul class="dropdown-menu shadow border-0">
                        <li><a class="dropdown-item py-2" href="{{ route('lab.invoice.pdf', $invoice->id) }}" target="_blank">Invoice (With Letterhead)</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('lab.invoice.pdf.plain', $invoice->id) }}" target="_blank">Invoice (Plain)</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="{{ route('lab.reports.print', $invoice->id) }}" target="_blank">Print Full Report</a></li>
                    </ul>
                </div>
                <a href="{{ route('lab.invoice.barcode.stickers', $invoice->id) }}" target="_blank" class="btn btn-outline-dark fw-bold">
                    <i class="feather-bar-chart me-2"></i>Print Barcode
                </a>
                <div class="dropdown">
                    <button class="btn btn-outline-success fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp Share
                    </button>
                    <ul class="dropdown-menu shadow border-0">
                        <li><a class="dropdown-item py-2" href="{{ $invoice->getWhatsappLink('invoice') }}" target="_blank">Share Invoice</a></li>
                        <li><a class="dropdown-item py-2" href="{{ $invoice->getWhatsappLink('report') }}" target="_blank">Share Report</a></li>
                    </ul>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('lab.reports.entry', $invoice->id) }}" wire:navigate class="btn-action-pos">
                        <i class="feather-edit-3 me-2"></i>Enter Results
                    </a>
                </div>
            </div>

            <div class="row g-0">
                <div class="col-xl-8 px-2">
                    {{-- PATIENT DETAILS --}}
                    <div class="summary-card">
                        <div class="summary-header bg-blue">
                            <span><i class="feather-user me-2"></i>Patient Information</span>
                            <span class="badge bg-white text-primary px-3">#{{ $invoice->invoice_number }}</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-auto">
                                    <div class="avatar-box">
                                        {{ strtoupper(substr($invoice->patient->name ?? 'P', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="fw-bold mb-1 text-dark">{{ $invoice->patient->name }}</h5>
                                    <div class="d-flex gap-3 text-muted small">
                                        <span><i class="feather-hash me-1"></i>{{ $invoice->patient->formatted_id }}</span>
                                        <span><i class="feather-user me-1"></i>{{ $invoice->patient->patientProfile->age }} {{ $invoice->patient->patientProfile->age_type }} / {{ $invoice->patient->patientProfile->gender }}</span>
                                        <span><i class="feather-phone me-1"></i>{{ $invoice->patient->phone }}</span>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <span class="info-label">Invoice Date</span>
                                    <span class="info-value">{{ $invoice->invoice_date->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>

                            <div class="row g-4 border-top pt-4">
                                <div class="col-md-4">
                                    <span class="info-label">Doctor</span>
                                    <span class="info-value text-primary">{{ $invoice->doctor->name ?? 'Self Walk-in' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="info-label">Branch</span>
                                    <span class="info-value">{{ $invoice->branch->name ?? 'Main Lab' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="info-label">Sample Status</span>
                                    <span class="badge {{ $invoice->status == 'Completed' ? 'bg-success' : 'bg-warning' }} px-3">
                                        {{ $invoice->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TESTS ORDERED --}}
                    <div class="summary-card">
                        <div class="summary-header bg-red">
                            <span><i class="feather-activity me-2"></i>Tests Ordered</span>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-summary mb-0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Test Name</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->items as $item)
                                        <tr>
                                            <td><span class="badge bg-light text-dark border">{{ $item->test_code ?? 'T' }}</span></td>
                                            <td class="fw-bold">
                                                {{ $item->test_name }}
                                                @if($item->is_package)
                                                    <span class="badge bg-soft-info text-info ms-2">Package</span>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold">₹{{ number_format($item->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 px-2">
                    {{-- FINANCIAL SUMMARY --}}
                    <div class="summary-card">
                        <div class="summary-header bg-green">
                            <span><i class="feather-credit-card me-2"></i>Financial Summary</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="summary-row">
                                <span class="text-muted">Subtotal (MRP)</span>
                                <span class="fw-bold">₹{{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            @php
                                $total_discount = $invoice->discount_amount + $invoice->membership_discount_amount + $invoice->voucher_discount_amount;
                            @endphp
                            @if($total_discount > 0)
                                <div class="summary-row text-danger">
                                    <span>Total Discount</span>
                                    <span class="fw-bold">- ₹{{ number_format($total_discount, 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="total-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-muted small">NET PAYABLE</span>
                                    <h4 class="fw-bolder mb-0 text-primary">₹{{ number_format($invoice->total_amount, 2) }}</h4>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-muted small">AMOUNT PAID</span>
                                    <h5 class="fw-bold mb-0 text-success">₹{{ number_format($invoice->paid_amount, 2) }}</h5>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">DUE BALANCE</span>
                                    <h5 class="fw-bolder mb-0 {{ $invoice->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $invoice->due_amount > 0 ? '₹'.number_format($invoice->due_amount, 2) : 'Fully Paid' }}
                                    </h5>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('lab.invoice.edit', $invoice->id) }}" wire:navigate class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                    <i class="feather-edit me-2"></i>Edit Amount / Invoice
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- PAYMENT HISTORY --}}
                    @if($invoice->payments->count() > 0)
                        <div class="summary-card">
                            <div class="summary-header bg-orange">
                                <span><i class="feather-clock me-2"></i>Payment History</span>
                            </div>
                            <div class="card-body p-3">
                                @foreach($invoice->payments as $payment)
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-light last-child-mb-0 last-child-pb-0 last-child-border-0">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $payment->paymentMode->name ?? 'Cash' }}</div>
                                            <div class="text-muted small">{{ $payment->created_at->format('d M, h:i A') }}</div>
                                        </div>
                                        <div class="fw-bold text-success">₹{{ number_format($payment->amount, 2) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
