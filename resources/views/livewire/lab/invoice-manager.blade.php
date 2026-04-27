<div>
    <style>
        .dropdown-menu { border: 1px solid #e0e0e0; box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; z-index: 2000; background: #fff !important; min-width: 160px; }
        .grayscale { filter: grayscale(1); }
        .opacity-50 { opacity: 0.5; }
        .btn-status { border-bottom: 2px solid transparent; }
        .dropdown-item:hover { background-color: #f8f9fa; }
    </style>
    {{-- ======================== PAGE HEADER ======================== --}}
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="text-dark fw-bold">Invoices</h5>
            </div>
            <ul class="breadcrumb d-none d-md-flex ms-3">
                <li class="breadcrumb-item"><a href="{{ route('lab.dashboard') }}" wire:navigate
                        class="text-muted">Home</a></li>
                <li class="breadcrumb-item text-primary fw-medium">Billing</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            @can('create pos')
                <a href="{{ route('lab.pos') }}" wire:navigate class="btn btn-primary"><i class="feather-plus me-1"></i>New Bill</a>
            @endcan
        </div>
    </div>

    {{-- ======================== MAIN CONTENT ======================== --}}
    <div class="main-content">

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="feather-check-circle me-2"></i> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="feather-alert-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ═══════ Stats Cards ═══════ --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card mb-0 shadow-sm border-0">
                    <div class="card-body py-3 d-flex align-items-center gap-3">
                        <div class="avatar-text avatar-lg rounded-3 bg-soft-primary text-primary"><i
                                class="feather-file-text" style="font-size:22px;"></i></div>
                        <div>
                            <div class="fs-10 fw-bold text-muted text-uppercase">Total Bills</div>
                            <div class="fs-4 fw-bold text-dark">{{ number_format($stats['total']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card mb-0 shadow-sm border-0">
                    <div class="card-body py-3 d-flex align-items-center gap-3">
                        <div class="avatar-text avatar-lg rounded-3 bg-soft-success text-success"><i
                                class="feather-calendar" style="font-size:22px;"></i></div>
                        <div>
                            <div class="fs-10 fw-bold text-muted text-uppercase">Today's Collection</div>
                            <div class="fs-4 fw-bold text-success">₹{{ number_format($stats['todayRevenue'], 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card mb-0 shadow-sm border-0"
                    style="background: linear-gradient(135deg, #3b71ca 0%, #1d4ed8 100%);">
                    <div class="card-body py-3 d-flex align-items-center gap-3">
                        <div class="avatar-text avatar-lg rounded-3 bg-white text-primary"><i
                                class="feather-trending-up" style="font-size:22px;"></i></div>
                        <div>
                            <div class="fs-10 fw-bold text-white-50 text-uppercase">Total Revenue</div>
                            <div class="fs-4 fw-bold text-white">₹{{ number_format($stats['totalRevenue'], 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card mb-0 shadow-sm border-0">
                    <div class="card-body py-3 d-flex align-items-center gap-3">
                        <div class="avatar-text avatar-lg rounded-3 bg-soft-danger text-danger"><i
                                class="feather-alert-circle" style="font-size:22px;"></i></div>
                        <div>
                            <div class="fs-10 fw-bold text-muted text-uppercase">Total Outstanding</div>
                            <div class="fs-4 fw-bold text-danger">₹{{ number_format($stats['due'], 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════ Simple Header ═══════ --}}
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body py-3">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="me-auto d-flex align-items-center gap-2">
                        <span class="fs-12 text-muted fw-bold">SHOW</span>
                        <select class="form-select form-select-sm fw-bold border-0 bg-light" wire:model.live="perPage" style="width: 80px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text border-0 bg-light"><i class="feather-search text-primary"></i></span>
                            <input type="text" class="form-control border-0 bg-light" wire:model.live.debounce.300ms="search" placeholder="Search Invoices...">
                        </div>
                        <select class="form-select form-select-sm border-0 bg-light" wire:model.live="filterCC" style="width: 150px;">
                            <option value="">All Centers</option>
                            @foreach($collectionCenters as $cc)
                                <option value="{{ $cc->id }}">{{ $cc->name }}</option>
                            @endforeach
                        </select>
                        <select class="form-select form-select-sm border-0 bg-light" wire:model.live="filterStatus" style="width: 130px;">
                            <option value="">All Payments</option>
                            <option value="Paid">Paid</option>
                            <option value="Partial">Partial</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                        <select class="form-select form-select-sm border-0 bg-light" wire:model.live="filterInvoiceStatus" style="width: 140px;">
                            <option value="">All Active/Cancelled</option>
                            <option value="Active">Active</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                        <input type="date" class="form-control form-control-sm border-0 bg-light" wire:model.live="filterDateFrom" style="width: 130px;">
                        <input type="date" class="form-control form-control-sm border-0 bg-light" wire:model.live="filterDateTo" style="width: 130px;">
                        <button wire:click="clearFilters" class="btn btn-light btn-sm border-0 shadow-sm"><i class="feather-refresh-cw"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════ Invoice Table ═══════ --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0 align-middle">
                        <thead>
                            <tr class="text-uppercase">
                                <th>User</th>
                                <th>Date</th>
                                <th>Bill No</th>
                                <th>Barcode</th>
                                <th>Doctor</th>
                                <th>Agent</th>
                                <th>Center</th>
                                <th>Patient Code</th>
                                <th>Patient</th>
                                <th>Phone</th>
                                <th>Test</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $inv)
                                <tr class="fs-table-main {{ $inv->status === 'Cancelled' ? 'bg-light opacity-75' : '' }}">
                                    <td class="fw-bold fs-table-main">{{ $inv->creator->name ?? 'System' }}</td>
                                    <td>
                                        <div class="fw-bold fs-table-main">{{ $inv->invoice_date->format('d-m-Y') }}</div>
                                        <div class="text-muted fs-table-sub">{{ $inv->invoice_date->format('h:i A') }}</div>
                                    </td>
                                    <td><span class="fw-bold text-primary fs-table-main">{{ $inv->invoice_number }}</span></td>
                                    <td class="text-muted fs-table-sub">{{ $inv->barcode }}</td>
                                    <td class="fw-bold text-dark">{{ $inv->doctor->name ?? '--' }}</td>
                                    <td class="fw-bold text-dark">{{ $inv->agent->name ?? '--' }}</td>
                                    <td>{{ $inv->collectionCenter->name ?? '--' }}</td>
                                    <td><span class="badge bg-secondary fs-table-sub">{{ $inv->patient->formatted_id }}</span></td>
                                    <td class="fw-bold fs-table-main text-dark">{{ $inv->patient->name }}</td>
                                    <td class="fs-table-main">{{ $inv->patient->phone }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0 fw-bold fs-table-sub">
                                            @foreach($inv->items as $item)
                                                <li class="{{ ($item->status ?? 'Pending') === 'Completed' ? 'text-success' : 'text-danger' }}">
                                                    • {{ $item->test_name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="text-end fw-bold fs-table-main">₹{{ number_format($inv->total_amount, 2) }}</td>
                                    <td class="text-center">
                                        @if($inv->payment_status === 'Paid')
                                            <span class="badge bg-success"><i class="feather-check"></i> Paid</span>
                                        @elseif($inv->payment_status === 'Partial')
                                            <span class="badge bg-warning text-dark">Partial</span>
                                        @else
                                            <span class="badge bg-danger text-white"><i class="feather-x"></i> Unpaid</span>
                                        @endif
                                        @if($inv->status === 'Cancelled')
                                            <div class="text-danger small fw-bold mt-1">CANCELLED</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm dropdown-toggle border" type="button" data-bs-toggle="dropdown">
                                                <i class="feather-more-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li><a class="dropdown-item" href="{{ route('lab.invoice.edit', $inv->id) }}" wire:navigate><i class="feather-edit-2 me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="{{ route('lab.pos.summary', $inv->id) }}" wire:navigate><i class="feather-eye me-2"></i>View Summary</a></li>
                                                <li><a class="dropdown-item" href="{{ route('lab.reports.entry', $inv->id) }}" wire:navigate><i class="feather-edit-3 me-2"></i>Enter Results</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="{{ $inv->getWhatsappLink('invoice') }}" target="_blank"><i class="bi bi-whatsapp me-2 text-success"></i>Share WhatsApp</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="15" class="text-center py-4 text-muted">No records found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top bg-light">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-11 text-muted">Show</span>
                        <select class="form-select form-select-sm fw-bold" wire:model.live="perPage"
                            style="width:70px;">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="fs-11 text-muted">
                            of <strong>{{ $invoices->total() }}</strong> invoices
                            @if($invoices->total() > 0)
                                · Showing {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }}
                            @endif
                        </span>
                    </div>

                    @if($invoices->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm mb-0 gap-1">
                                {{-- Previous --}}
                                @if ($invoices->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link border-0 bg-transparent"><i
                                                class="feather-chevron-left fs-12"></i></span></li>
                                @else
                                    <li class="page-item"><button wire:click="previousPage"
                                            class="page-link border-0 bg-transparent"><i
                                                class="feather-chevron-left fs-12"></i></button></li>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $currentPage = $invoices->currentPage();
                                    $lastPage = $invoices->lastPage();
                                    $start = max(1, $currentPage - 2);
                                    $end = min($lastPage, $currentPage + 2);
                                @endphp

                                @if($start > 1)
                                    <li class="page-item"><button wire:click="gotoPage(1)"
                                            class="page-link border rounded-2 fs-11 fw-bold" style="min-width:32px;">1</button>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled"><span
                                                class="page-link border-0 bg-transparent fs-11">…</span></li>
                                    @endif
                                @endif

                                @for($p = $start; $p <= $end; $p++)
                                    <li class="page-item {{ $p == $currentPage ? 'active' : '' }}">
                                        <button wire:click="gotoPage({{ $p }})"
                                            class="page-link border rounded-2 fs-11 fw-bold {{ $p == $currentPage ? 'bg-primary text-white border-primary' : '' }}"
                                            style="min-width:32px;">{{ $p }}</button>
                                    </li>
                                @endfor

                                @if($end < $lastPage)
                                    @if($end < $lastPage - 1)
                                        <li class="page-item disabled"><span
                                                class="page-link border-0 bg-transparent fs-11">…</span></li>
                                    @endif
                                    <li class="page-item"><button wire:click="gotoPage({{ $lastPage }})"
                                            class="page-link border rounded-2 fs-11 fw-bold"
                                            style="min-width:32px;">{{ $lastPage }}</button></li>
                                @endif

                                {{-- Next --}}
                                @if ($invoices->hasMorePages())
                                    <li class="page-item"><button wire:click="nextPage"
                                            class="page-link border-0 bg-transparent"><i
                                                class="feather-chevron-right fs-12"></i></button></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link border-0 bg-transparent"><i
                                                class="feather-chevron-right fs-12"></i></span></li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>