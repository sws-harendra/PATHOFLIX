<div>
    {{-- ======================== PAGE HEADER ======================== --}}
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="text-dark fw-bold">Lab Reports</h5>
            </div>
            <ul class="breadcrumb d-none d-md-flex ms-3">
                <li class="breadcrumb-item"><a href="{{ route('lab.dashboard') }}" wire:navigate class="text-muted">Home</a></li>
                <li class="breadcrumb-item text-primary fw-medium">Reports</li>
            </ul>
        </div>
    </div>

    {{-- ======================== MAIN CONTENT ======================== --}}
    <div class="main-content">
        <div class="card mb-4" style="overflow: visible !important;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0"><i class="feather-flask me-2 text-primary"></i>Test Results & Reports</h6>
            </div>
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3">
                        <i class="feather-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3">
                        <i class="feather-alert-octagon me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                {{-- Filters --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="input-group search-group shadow-sm">
                            <span class="input-group-text">
                                <i class="feather-search text-primary"></i>
                            </span>
                            <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Search by Invoice, Patient Name, Phone...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" wire:model.live="statusFilter">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending Entry</option>
                            <option value="draft">Draft (Saved)</option>
                            <option value="approved">Approved</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" wire:model.live="dateRange">
                            <option value="all">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="custom">Custom Date</option>
                        </select>
                    </div>
                </div>

                {{-- Row 2 Filters --}}
                <div class="row g-3 mb-4">
                    @if($dateRange === 'custom')
                        <div class="col-md-2">
                            <input type="date" class="form-control" wire:model.live="filterDateFrom">
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" wire:model.live="filterDateTo">
                        </div>
                    @endif
                    <div class="col-md-3">
                        <select class="form-select" wire:model.live="filterDoctor">
                            <option value="">All Doctors</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->user_id }}">{{ $doc->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" wire:model.live="filterAgent">
                            <option value="">All Agents</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->user_id }}">{{ $agent->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" wire:model.live="filterCC">
                            <option value="">All Centers</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}">{{ $center->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Reports Table --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:140px;">Invoice & Br.</th>
                                <th>Patient Info</th>
                                <th>Doctor / Agent</th>
                                <th>Center</th>
                                <th>Test List</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary">{{ $invoice->invoice_number }}</div>
                                        <div class="fs-11 fw-bold text-dark mb-1">{{ $invoice->barcode }}</div>
                                        <div class="fs-10 text-muted">{{ $invoice->created_at->format('d/m/y h:i A') }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold fs-13">{{ $invoice->patient->name }}</div>
                                        <div class="badge bg-soft-info text-info fs-10 fw-bold px-2 py-1 mb-1">{{ $invoice->patient->formatted_id }}</div>
                                        <div class="fs-10 text-muted">
                                            {{ $invoice->patient->patientProfile->age ?? '--' }} {{ $invoice->patient->patientProfile->age_type ?? 'Y' }} | {{ $invoice->patient->patientProfile->gender ?? '--' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fs-11">
                                            <div class="fw-semibold text-dark"><i class="feather-user me-1 fs-10"></i>{{ $invoice->doctor->name ?? 'Self' }}</div>
                                            @if($invoice->agent)
                                                <div class="text-muted"><i class="feather-user-check me-1 fs-10"></i>{{ $invoice->agent->name }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge bg-light text-dark fw-normal fs-10">{{ $invoice->collectionCenter->name ?? 'Main Lab' }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($invoice->items as $item)
                                                @if($item->lab_test_id)
                                                    @php
                                                        $isComplete = $item->status === 'Completed';
                                                    @endphp
                                                    <div class="form-check form-check-inline m-0 p-0">
                                                        <input class="form-check-input ms-0 me-1" type="checkbox" 
                                                            wire:model.live="selectedTests" 
                                                            value="{{ $item->id }}"
                                                            {{ !$isComplete ? 'disabled' : '' }}>
                                                        <span class="badge {{ $isComplete ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} border fs-9 fw-normal" title="{{ $isComplete ? 'Result Entered' : 'Pending' }}">
                                                            {{ $item->labTest->name }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @if(!$invoice->testReport)
                                            <span class="badge bg-soft-warning text-warning fs-10"><i class="feather-clock me-1"></i> Pending Entry</span>
                                        @elseif($invoice->testReport->status === 'Draft')
                                            <span class="badge bg-soft-info text-info fs-10"><i class="feather-edit-2 me-1"></i> Draft</span>
                                        @elseif($invoice->testReport->status === 'Approved')
                                            <span class="badge bg-soft-success text-success fs-10"><i class="feather-check-circle me-1"></i> Approved</span>
                                        @endif
                                    </td>
                                     <td class="text-end">
                                         <div class="d-flex justify-content-end gap-1">
                                             @can('edit reports')
                                                 <a href="{{ route('lab.reports.entry', $invoice->id) }}" class="btn btn-sm btn-soft-primary py-1 px-2" title="Enter / Edit Results">
                                                     <i class="feather-edit fs-12"></i>
                                                 </a>
                                             @endcan
                                             @can('edit invoices')
                                                 <a href="{{ route('lab.invoice.edit', $invoice->id) }}" wire:navigate class="btn btn-sm btn-soft-warning py-1 px-2" title="Modify Invoice">
                                                     <i class="feather-edit-3 fs-12"></i>
                                                 </a>
                                             @endcan

                                             @if($invoice->testReport)
                                             {{-- Reorder & Print Button --}}
                                             <button type="button"
                                                 class="btn btn-sm btn-soft-info py-1 px-2"
                                                 title="Reorder Tests & Print"
                                                 onclick="openReorderModal({{ $invoice->id }}, {{ $invoice->items->where('lab_test_id', '!=', null)->values()->toJson() }})">
                                                 <i class="feather-shuffle fs-12"></i>
                                             </button>

                                             <div class="dropdown {{ $loop->remaining < 2 ? 'dropup' : '' }}">
                                                 <button class="btn btn-sm {{ ($invoice->testReport->status === 'Approved') ? 'btn-success' : 'btn-outline-primary' }} dropdown-toggle fs-11" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                                     <i class="feather-printer me-1"></i> Print
                                                 </button>
                                                 <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                     <li class="dropdown-header fw-bold fs-10 text-uppercase text-muted px-3">Print All Tests</li>
                                                     <li><button type="button" class="dropdown-item fs-12 text-primary" wire:click="printReport({{ $invoice->id }}, 1)"><i class="feather-file-text me-2"></i> With Header</button></li>
                                                     <li><button type="button" class="dropdown-item fs-12 text-secondary" wire:click="printReport({{ $invoice->id }}, 0)"><i class="feather-file me-2"></i> Without Header</button></li>
                                                     <li><hr class="dropdown-divider"></li>
                                                     <li class="dropdown-header fw-bold fs-10 text-uppercase text-muted px-3">Print Selected Tests</li>
                                                     <li><button type="button" class="dropdown-item fs-12 text-success fw-bold" wire:click="printSelected({{ $invoice->id }}, 1)"><i class="feather-check-square me-2"></i> With Header</button></li>
                                                     <li><button type="button" class="dropdown-item fs-12 text-dark" wire:click="printSelected({{ $invoice->id }}, 0)"><i class="feather-check-square me-2"></i> Without Header</button></li>
                                                 </ul>
                                             </div>
                                             @endif

                                            {{-- WhatsApp Share --}}
                                            <div class="dropdown {{ $loop->remaining < 2 ? 'dropup' : '' }}">
                                                <button class="btn btn-sm btn-outline-success dropdown-toggle fs-11 px-2" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" @if(!$invoice->patient->phone) disabled title="Phone missing" @endif>
                                                    <i class="bi bi-whatsapp"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-1">
                                                    <li><a class="dropdown-item fs-11 rounded-2 py-2" href="{{ $invoice->getWhatsappLink('invoice') }}" target="_blank"><i class="feather-file-text me-2 text-success"></i> Share Invoice</a></li>
                                                    @if($invoice->testReport && $invoice->testReport->status === 'Approved')
                                                        <li><a class="dropdown-item fs-11 rounded-2 py-2" href="{{ $invoice->getWhatsappLink('report') }}" target="_blank"><i class="feather-check-circle me-2 text-success"></i> Share Report</a></li>
                                                    @else
                                                        <li><a class="dropdown-item fs-11 rounded-2 py-2 disabled text-muted" href="javascript:void(0)"><i class="feather-clock me-2"></i> Report Pending</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="avatar-text avatar-xl rounded-circle bg-soft-secondary mx-auto mb-3">
                                            <i class="feather-file-text fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold">No Records Found</h6>
                                        <p class="text-muted fs-12">Try adjusting your filters.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="d-flex justify-content-between align-items-center px-0 py-3 mt-3 border-top bg-white">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-11 text-muted">Show</span>
                        <select class="form-select form-select-sm fw-bold" wire:model.live="perPage" style="width:70px;">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="fs-11 text-muted">
                            of <strong>{{ $invoices->total() }}</strong> reports
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
                                    <li class="page-item disabled"><span class="page-link border-0 bg-transparent"><i class="feather-chevron-left fs-12"></i></span></li>
                                @else
                                    <li class="page-item"><button wire:click="previousPage" class="page-link border-0 bg-transparent"><i class="feather-chevron-left fs-12"></i></button></li>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $currentPage = $invoices->currentPage();
                                    $lastPage = $invoices->lastPage();
                                    $start = max(1, $currentPage - 2);
                                    $end = min($lastPage, $currentPage + 2);
                                @endphp

                                @if($start > 1)
                                    <li class="page-item"><button wire:click="gotoPage(1)" class="page-link border rounded-2 fs-11 fw-bold" style="min-width:32px;">1</button></li>
                                    @if($start > 2)
                                        <li class="page-item disabled"><span class="page-link border-0 bg-transparent fs-11">…</span></li>
                                    @endif
                                @endif

                                @for($p = $start; $p <= $end; $p++)
                                    <li class="page-item {{ $p == $currentPage ? 'active' : '' }}">
                                        <button wire:click="gotoPage({{ $p }})" class="page-link border rounded-2 fs-11 fw-bold {{ $p == $currentPage ? 'bg-primary text-white border-primary' : '' }}" style="min-width:32px;">{{ $p }}</button>
                                    </li>
                                @endfor

                                @if($end < $lastPage)
                                    @if($end < $lastPage - 1)
                                        <li class="page-item disabled"><span class="page-link border-0 bg-transparent fs-11">…</span></li>
                                    @endif
                                    <li class="page-item"><button wire:click="gotoPage({{ $lastPage }})" class="page-link border rounded-2 fs-11 fw-bold" style="min-width:32px;">{{ $lastPage }}</button></li>
                                @endif

                                {{-- Next --}}
                                @if ($invoices->hasMorePages())
                                    <li class="page-item"><button wire:click="nextPage" class="page-link border-0 bg-transparent"><i class="feather-chevron-right fs-12"></i></button></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link border-0 bg-transparent"><i class="feather-chevron-right fs-12"></i></span></li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- ======================== REORDER & PRINT MODAL ======================== --}}
    <div class="modal fade" id="reorderPrintModal" tabindex="-1" aria-labelledby="reorderPrintModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%);">
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-1" id="reorderPrintModalLabel">
                            <i class="feather-shuffle me-2"></i>Reorder Tests & Print
                        </h5>
                        <p class="text-white-50 fs-11 mb-0">Tests ko drag & drop karke kram (order) set karein.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    {{-- Info Banner --}}
                    <div class="px-4 py-2 bg-soft-info border-bottom d-flex align-items-center gap-2" style="background: #e8f4fd !important;">
                        <i class="feather-info text-info fs-14"></i>
                        <span class="fs-12 text-info fw-medium">
                            Drag <i class="feather-move fs-11"></i> karke tests ko reorder karein. Report aapke lab ki Print Setting (Continuous) ke anusar print hogi.
                        </span>
                    </div>

                    {{-- Sortable Test List --}}
                    <div class="p-3">
                        <div id="reorderTestList" class="d-flex flex-column gap-2">
                            {{-- Items injected by JS --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light d-flex justify-content-between align-items-center py-2 px-3">
                    <div class="fs-11 text-muted">
                        <i class="feather-info me-1"></i>
                        Sirf is baar ki print ke liye kram set hoga.
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary fs-11" data-bs-dismiss="modal">
                            <i class="feather-x me-1"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary fs-11 fw-bold" onclick="printReordered(0)">
                            <i class="feather-file me-1"></i> Without Header
                        </button>
                        <button type="button" class="btn btn-sm btn-primary fs-11 fw-bold" onclick="printReordered(1)">
                            <i class="feather-printer me-1"></i> With Header
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ── Drag & Drop Styles ── */
        .reorder-item {
            background: #fff;
            border: 1.5px solid #e0e6ed;
            border-radius: 8px;
            padding: 10px 14px;
            cursor: grab;
            transition: all 0.2s ease;
            user-select: none;
        }
        .reorder-item:hover {
            border-color: #4361ee;
            box-shadow: 0 3px 10px rgba(67,97,238,0.12);
        }
        .reorder-item.dragging {
            opacity: 0.4;
            cursor: grabbing;
        }
        .reorder-item.drag-over {
            border-color: #4361ee;
            background: #f0f3ff;
            transform: scale(1.01);
        }
        .reorder-item .drag-handle {
            color: #adb5bd;
            cursor: grab;
            font-size: 16px;
            line-height: 1;
        }
        .reorder-item .drag-handle:hover {
            color: #4361ee;
        }
    </style>

    <script>
        // ─── State ───────────────────────────────────────────────
        let _reorderInvoiceId = null;
        let _reorderItems = [];
        let _dragSrcIndex = null;

        // ─── Open Modal ──────────────────────────────────────────
        function openReorderModal(invoiceId, items) {
            _reorderInvoiceId = invoiceId;
            // Filter only lab test items, keep all (completed or not)
            _reorderItems = items
                .filter(i => i.lab_test_id !== null)
                .map(i => {
                    const paramCount = i.lab_test ? (i.lab_test.parameters ? (Array.isArray(i.lab_test.parameters) ? i.lab_test.parameters.length : Object.keys(i.lab_test.parameters).length) : 0) : 0;
                    return {
                        id: i.id,
                        name: i.lab_test ? i.lab_test.name : (i.item_name || ('Test #' + i.id)),
                        status: i.status,
                        paramCount: paramCount,
                    };
                });

            renderReorderList();

            var modal = new bootstrap.Modal(document.getElementById('reorderPrintModal'));
            modal.show();
        }

        // ─── Render the draggable list ────────────────────────────
        function renderReorderList() {
            const container = document.getElementById('reorderTestList');
            container.innerHTML = '';

            _reorderItems.forEach((item, index) => {
                const isCompleted = item.status === 'Completed';
                const div = document.createElement('div');
                div.className = 'reorder-item d-flex align-items-center gap-3';
                div.setAttribute('draggable', 'true');
                div.dataset.index = index;

                div.innerHTML = `
                    <div class="drag-handle" title="Drag to reorder">
                        <i class="feather-move"></i>
                    </div>
                    <div class="fw-bold fs-12 text-dark" style="flex: 1; min-width: 0;">
                        <span class="badge bg-light text-dark border me-2 fs-11" style="font-weight:600;">#${index + 1}</span>
                        ${item.name}
                        ${!isCompleted ? '<span class="badge bg-warning text-dark fs-9 ms-2">Pending</span>' : ''}
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        ${item.paramCount > 0 ? `<span class="badge bg-light text-muted border fs-10">${item.paramCount} params</span>` : ''}
                    </div>
                `;

                // Drag events
                div.addEventListener('dragstart', onDragStart);
                div.addEventListener('dragend', onDragEnd);
                div.addEventListener('dragover', onDragOver);
                div.addEventListener('drop', onDrop);
                div.addEventListener('dragenter', onDragEnter);
                div.addEventListener('dragleave', onDragLeave);

                container.appendChild(div);
            });
        }

        // ─── Drag Events ─────────────────────────────────────────
        function onDragStart(e) {
            _dragSrcIndex = parseInt(this.dataset.index);
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', _dragSrcIndex);
        }

        function onDragEnd(e) {
            this.classList.remove('dragging');
            document.querySelectorAll('.reorder-item').forEach(el => {
                el.classList.remove('drag-over');
            });
        }

        function onDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        }

        function onDragEnter(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        }

        function onDragLeave(e) {
            this.classList.remove('drag-over');
        }

        function onDrop(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            const targetIndex = parseInt(this.dataset.index);

            if (_dragSrcIndex === null || _dragSrcIndex === targetIndex) return;

            // Reorder
            const moved = _reorderItems.splice(_dragSrcIndex, 1)[0];
            _reorderItems.splice(targetIndex, 0, moved);
            _dragSrcIndex = null;

            renderReorderList();
        }

        // ─── Print Reordered ─────────────────────────────────────
        function printReordered(withHeader) {
            if (!_reorderInvoiceId || _reorderItems.length === 0) return;

            // Prioritize completed tests; fallback to all items if none explicitly marked Completed
            let targetItems = _reorderItems.filter(i => i.status === 'Completed');
            if (targetItems.length === 0) {
                targetItems = _reorderItems;
            }

            if (targetItems.length === 0) {
                alert('Koi test nahi mila print karne ke liye.');
                return;
            }

            const idsString = targetItems.map(i => i.id).join(',');

            const baseUrl = `{{ route('lab.reports.print', ['id' => '__ID__', 'template' => 'new']) }}`
                .replace('__ID__', _reorderInvoiceId);

            // Reorder print strictly honors the user's setting (continuous) without artificial breaks
            let url = baseUrl + '?tests=' + idsString + '&header=' + withHeader;
            window.open(url, '_blank');

            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('reorderPrintModal'));
            if (modal) modal.hide();
        }
    </script>

</div>
