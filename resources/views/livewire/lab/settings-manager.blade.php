<div>
    {{-- ======================== PAGE HEADER ======================== --}}
    {{-- ======================== PAGE HEADER ======================== --}}
    <div class="page-header py-4 border-0">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title d-flex align-items-center">
                <i class="feather-settings text-dark me-3" style="font-size: 2.5rem;"></i>
                <h2 class="text-dark fw-bold mb-0">Account Settings</h2>
            </div>
        </div>
        <div class="page-header-right d-none d-md-block">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('lab.dashboard') }}" wire:navigate class="text-muted">Home</a></li>
                <li class="breadcrumb-item text-muted">/ Account Settings</li>
            </ul>
        </div>
    </div>

    {{-- ======================== MAIN CONTENT ======================== --}}
    <div class="main-content">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 0;">
            <div class="settings-main-header">
                Settings
            </div>
            <div class="row g-0">
                {{-- Sidebar --}}
                <div class="col-md-3 border-end bg-white">
                    <div class="py-3">
                        @role('lab_admin|super_admin')
                        <button wire:click="$set('activeTab', 'general')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'general' ? 'active' : '' }}">
                            <i class="feather-settings"></i> Basic Setup
                        </button>
                        <button wire:click="$set('activeTab', 'profile')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'profile' ? 'active' : '' }}">
                            <i class="feather-home"></i> Lab Profile
                        </button>
                        <button wire:click="$set('activeTab', 'invoice')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'invoice' ? 'active' : '' }}">
                            <i class="feather-file-text"></i> Billing Rules
                        </button>
                        <button wire:click="$set('activeTab', 'template')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'template' ? 'active' : '' }}">
                            <i class="feather-layout"></i> Print Designs
                        </button>
                        <button wire:click="$set('activeTab', 'pdf')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'pdf' ? 'active' : '' }}">
                            <i class="feather-printer"></i> Letterpad Setup
                        </button>
                        <button wire:click="$set('activeTab', 'signatures')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'signatures' ? 'active' : '' }}">
                            <i class="feather-edit-3"></i> E-Signatures
                        </button>
                        <button wire:click="$set('activeTab', 'barcode')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'barcode' ? 'active' : '' }}">
                            <i class="feather-maximize"></i> Barcode Label
                        </button>
                        @endrole

                        @can('view staff_roles')
                        <button wire:click="$set('activeTab', 'staff')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'staff' ? 'active' : '' }}">
                            <i class="feather-users"></i> Staff Access
                        </button>
                        @endcan

                        @role('lab_admin|super_admin')
                        @if(\App\Models\Configuration::getFor('restrict_branch_access', '1') === '1')
                        <button wire:click="$set('activeTab', 'branch')" class="settings-sidebar-link w-100 border-0 {{ $activeTab === 'branch' ? 'active' : '' }}">
                            <i class="feather-git-merge"></i> Branch Control
                        </button>
                        @endif
                        @endrole
                    </div>
                </div>

                {{-- Content Area --}}
                <div class="col-md-9 bg-white">
                    <div class="p-4" style="min-height: 600px;">

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- TAB 0: GENERAL SETTINGS --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        @if($activeTab === 'general')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="settings-section-header d-flex align-items-center gap-3">
                            <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                                <i class="feather-user-check"></i>
                            </div>
                            <span class="fs-15 fw-bold">Patient Registration Rules</span>
                        </div>
                        <div class="card-body p-4">
                            @if($patientSettingsSaved)
                                <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                                    <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Configuration saved successfully!</span>
                                </div>
                            @endif

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-13 mb-2">Patient ID Prefix</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-user"></i></div>
                                        <input type="text" class="form-control" wire:model.live.debounce.500ms="patient_id_prefix" placeholder="e.g. PAT, REG, PT">
                                    </div>
                                    <div class="fs-12 text-muted mt-2">Example: <strong>{{ $patient_id_prefix }}</strong>00001</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-13 mb-2">ID Padding Length</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-hash"></i></div>
                                        <select class="form-control form-select" wire:model.live="patient_id_digits">
                                            <option value="4">4 Digits (Standard)</option>
                                            <option value="5">5 Digits (Medium Lab)</option>
                                            <option value="6">6 Digits (Large Lab)</option>
                                            <option value="8">8 Digits (Maximum)</option>
                                        </select>
                                    </div>
                                    <div class="fs-12 text-muted mt-2">Total digits including leading zeros.</div>
                                </div>
                            </div>

                            @can('edit settings')
                            <div class="mt-4 pt-3 text-start">
                                <button wire:click="savePatientSettings" class="settings-save-btn">
                                    <i class="feather-check"></i> Save Patient Rules
                                </button>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="settings-section-header bg-dark">
                            <i class="feather-eye me-2"></i> ID Preview
                        </div>
                        <div class="card-body text-center py-5 d-flex flex-column justify-content-center">
                            <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Sample Patient ID:</div>
                            <div class="display-5 fw-bold text-primary py-3 px-3 rounded-3 border bg-light font-monospace" style="letter-spacing:1px;">
                                {{ $this->patientIdPreview }}
                            </div>
                            <div class="mt-4">
                                <div class="fs-11 text-muted px-3 text-start">
                                    <p class="mb-0"><i class="feather-info me-1"></i> This pattern will be used for all patient records. Existing IDs will also reflect this change.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if($activeTab === 'profile')
            <div class="row g-4">
                {{-- Contact Details --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="settings-section-header d-flex align-items-center gap-3">
                            <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                                <i class="feather-info"></i>
                            </div>
                            <span class="fs-15 fw-bold">Laboratory Profile Information</span>
                        </div>
                        <div class="card-body p-4">
                            @if($profileSaved)
                                <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                                    <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Profile updated successfully!</span>
                                </div>
                            @endif

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-12 mb-2">Laboratory Name <span class="text-danger">*</span></label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-home"></i></div>
                                        <input type="text" class="form-control" wire:model="lab_name" placeholder="e.g. Sahani Pathology Lab">
                                    </div>
                                    @error('lab_name') <span class="text-danger fs-11 mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-12 mb-2">Brand Tagline</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-tag"></i></div>
                                        <input type="text" class="form-control" wire:model="lab_tagline" placeholder="e.g. Trusted Diagnostics Since 2010">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-12 mb-2">Official Email</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-mail"></i></div>
                                        <input type="email" class="form-control" wire:model="lab_email" placeholder="lab@example.com">
                                    </div>
                                    @error('lab_email') <span class="text-danger fs-11 mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-12 mb-2">Contact Number</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-phone"></i></div>
                                        <input type="text" class="form-control" wire:model="lab_phone" placeholder="+91 9876543210">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-12 mb-2">Website</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-globe"></i></div>
                                        <input type="url" class="form-control" wire:model="lab_website" placeholder="https://www.example.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bolder text-dark fs-12 mb-2">GST / Tax Number</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-hash"></i></div>
                                        <input type="text" class="form-control" wire:model="lab_gst_number" placeholder="e.g. 22AAAAA0000A1Z5">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bolder text-dark fs-12 mb-2">Full Address</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-map-pin"></i></div>
                                        <textarea class="form-control" wire:model="lab_address" rows="3" placeholder="Street, City, State, PIN"></textarea>
                                    </div>
                                </div>
                            </div>

                            @can('edit settings')
                            <div class="mt-4 pt-3 text-start">
                                <button wire:click="saveProfile" class="settings-save-btn">
                                    <i class="feather-check"></i> Save
                                </button>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Logo & Branding --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="settings-section-header bg-secondary">
                            <i class="feather-image me-2"></i> Lab Branding
                        </div>
                        <div class="card-body p-4 text-center">
                            <div class="p-4 rounded-4 bg-light mb-4 text-center border-dashed border-2">
                                @if($lab_logo)
                                    <img src="{{ secure_storage_url($lab_logo) }}" alt="Lab Logo" class="img-fluid rounded shadow-sm mb-3" style="max-height:100px;">
                                @else
                                    <div class="avatar-text avatar-xl mx-auto rounded-circle bg-white shadow-sm mb-3" style="width:80px; height:80px; line-height:80px;">
                                        <i class="feather-image text-muted fs-1"></i>
                                    </div>
                                @endif
                                
                                @if($new_logo)
                                    <div class="mb-3">
                                        <div class="badge bg-primary px-3 py-2 rounded-pill mb-2">New Logo Preview</div>
                                        <img src="{{ $new_logo->temporaryUrl() }}" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height:100px;">
                                    </div>
                                @endif

                                <label class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold cursor-pointer">
                                    Change Logo <input type="file" wire:model="new_logo" accept="image/*" hidden>
                                </label>
                                <div class="fs-11 text-muted mt-3">Used in Sidebar & Invoices (Max 2MB)</div>
                            </div>

                            <div class="p-4 rounded-4 bg-light text-center border-dashed border-2">
                                <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                    @if($lab_favicon)
                                        <img src="{{ secure_storage_url($lab_favicon) }}" alt="Favicon" class="rounded-3 shadow-sm p-1 bg-white" style="height:48px;width:48px;object-fit:contain;">
                                    @endif
                                    @if($new_favicon)
                                        <i class="feather-arrow-right text-muted"></i>
                                        <img src="{{ $new_favicon->temporaryUrl() }}" alt="Preview" class="rounded-3 shadow-sm p-1 bg-white border border-primary" style="height:48px;width:48px;">
                                    @endif
                                </div>
                                <label class="btn btn-outline-info btn-sm rounded-pill px-4 fw-bold cursor-pointer">
                                    Update Favicon <input type="file" wire:model="new_favicon" accept="image/*" hidden>
                                </label>
                                <div class="fs-11 text-muted mt-3">Browser tab icon (Square, Max 1MB)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- TAB 2: INVOICE SETTINGS --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        @if($activeTab === 'invoice')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="settings-section-header d-flex align-items-center gap-3">
                            <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                                <i class="feather-file-text"></i>
                            </div>
                            <span class="fs-15 fw-bold">Invoice Numbering & Financials</span>
                        </div>
                        <div class="card-body p-4">
                            @if($invoiceSaved)
                                <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                                    <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Billing rules updated successfully!</span>
                                </div>
                            @endif

                            <div class="mb-4">
                                <h6 class="fw-bolder text-dark mb-3">Numbering Pattern</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark fs-12 mb-2">Invoice Prefix <span class="text-danger">*</span></label>
                                        <div class="settings-input-group">
                                            <div class="settings-input-icon"><i class="feather-type"></i></div>
                                            <input type="text" class="form-control" wire:model.live.debounce.500ms="invoice_prefix" placeholder="e.g. INV, BILL, LAB">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark fs-12 mb-2">Pattern Separator</label>
                                        <div class="settings-input-group">
                                            <div class="settings-input-icon"><i class="feather-minus"></i></div>
                                            <select class="form-control form-select" wire:model.live="invoice_separator">
                                                <option value="-">Dash ( - )</option>
                                                <option value="/">Slash ( / )</option>
                                                <option value="">None ( No Separator )</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark fs-12 mb-2">Dynamic Date Tag</label>
                                        <div class="settings-input-group">
                                            <div class="settings-input-icon"><i class="feather-calendar"></i></div>
                                            <select class="form-control form-select" wire:model.live="invoice_date_format">
                                                <option value="ym">YYMM ({{ date('ym') }})</option>
                                                <option value="ymd">YYMMDD ({{ date('ymd') }})</option>
                                                <option value="Ymd">YYYYMMDD ({{ date('Ymd') }})</option>
                                                <option value="Y">YYYY ({{ date('Y') }})</option>
                                                <option value="none">No Date Tag</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark fs-12 mb-2">Counter Digits</label>
                                        <div class="settings-input-group">
                                            <div class="settings-input-icon"><i class="feather-hash"></i></div>
                                            <select class="form-control form-select" wire:model.live="invoice_counter_digits">
                                                <option value="2">2 digits (01)</option>
                                                <option value="3">3 digits (001)</option>
                                                <option value="4">4 digits (0001)</option>
                                                <option value="5">5 digits (00001)</option>
                                                <option value="6">6 digits (000001)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark fs-12 mb-2">Counter Reset</label>
                                        <div class="settings-input-group">
                                            <div class="settings-input-icon"><i class="feather-refresh-cw"></i></div>
                                            <select class="form-control form-select" wire:model.live="invoice_counter_reset">
                                                <option value="daily">Daily Reset</option>
                                                <option value="monthly">Monthly Reset</option>
                                                <option value="yearly">Yearly Reset</option>
                                                <option value="never">Continuous (No Reset)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="mb-4">
                                <h6 class="fw-bolder text-dark mb-3">Financial & Commission Rules</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark fs-12 mb-2">Doctor Commission Basis</label>
                                        <div class="settings-input-group">
                                            <div class="settings-input-icon"><i class="feather-user"></i></div>
                                            <select class="form-control form-select" wire:model.live="commission_basis_doctor">
                                                <option value="gross">Gross Revenue (% of Total Bill)</option>
                                                <option value="profit">Net Profit (% of Bill minus B2B Cost)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark fs-12 mb-2">Agent Commission Basis</label>
                                        <div class="settings-input-group">
                                            <div class="settings-input-icon"><i class="feather-briefcase"></i></div>
                                            <select class="form-control form-select" wire:model.live="commission_basis_agent">
                                                <option value="gross">Gross Revenue (% of Total Bill)</option>
                                                <option value="profit">Net Profit (% of Bill minus B2B Cost)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between p-3 border rounded-4 bg-light">
                                            <div class="pe-3">
                                                <h6 class="fw-bold mb-1 text-dark">Prevent Billing Below B2B Cost</h6>
                                                <p class="fs-11 text-muted mb-0">Blocks bill creation if discount makes revenue less than B2B cost.</p>
                                            </div>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" wire:model.live="restrict_billing_below_b2b" style="width:2.5em;height:1.3em;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @can('edit settings')
                            <div class="mt-4 pt-3 text-start">
                                <button wire:click="saveInvoiceSettings" class="settings-save-btn">
                                    <i class="feather-check"></i> Save Billing Rules
                                </button>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Live Preview --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-sticky" style="top: 100px;">
                        <div class="card-header bg-dark py-4 text-center border-0">
                            <h6 class="card-title mb-0 fs-11 text-white text-uppercase ls-1 fw-bold opacity-75">Live Invoice Pattern</h6>
                        </div>
                        <div class="card-body text-center py-5 px-4 bg-white">
                            <div class="display-6 fw-bolder text-primary mb-3 font-monospace" style="letter-spacing:2px;">
                                {{ $this->invoicePreview }}
                            </div>
                            <p class="text-muted fs-12 mb-4 px-3">This is exactly how your patients will see the bill numbers on their receipts.</p>
                            
                            <div class="list-group list-group-flush border rounded-4 overflow-hidden shadow-sm">
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light bg-opacity-50">
                                    <span class="fs-11 fw-bold text-muted text-uppercase">Prefix</span>
                                    <span class="badge bg-white text-dark border shadow-sm px-3 py-2 fs-13 fw-bolder">{{ $invoice_prefix }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <span class="fs-11 fw-bold text-muted text-uppercase">Date Tag</span>
                                    <span class="badge bg-white text-dark border shadow-sm px-3 py-2 fs-13 fw-bolder text-uppercase">{{ $invoice_date_format }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light bg-opacity-50">
                                    <span class="fs-11 fw-bold text-muted text-uppercase">Padding</span>
                                    <span class="badge bg-white text-dark border shadow-sm px-3 py-2 fs-13 fw-bolder">{{ $invoice_counter_digits }} Digits</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0 py-4 text-center">
                            <p class="fs-11 text-muted mb-0"><i class="feather-info me-1"></i> Pattern changes apply to new bills only.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- TAB 3: BILL TEMPLATES --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        @if($activeTab === 'template')
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="settings-section-header d-flex align-items-center gap-3">
                    <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                        <i class="feather-layout"></i>
                    </div>
                    <span class="fs-15 fw-bold">Report & Bill Designs</span>
                </div>
                <div class="card-body p-4">
                    @if($templateSaved)
                        <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                            <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Success! Your print preference has been updated.</span>
                        </div>
                    @endif

                    <div class="row g-4">
                        @php
                            $templates = [
                                'classic' => [
                                    'name' => 'Standard Classic', 
                                    'icon' => 'feather-file-text', 
                                    'color' => '#0d6efd', 
                                    'desc' => 'Best for formal medical reports. Includes standard header, detailed test tables, and signatory footer.'
                                ],
                                'pro' => [
                                    'name' => 'Modern Pro', 
                                    'icon' => 'feather-shield', 
                                    'color' => '#1e293b', 
                                    'desc' => 'Premium Black & White aesthetic. Features clean lines, QR code support, and high-density test formatting.'
                                ],
                                'thermal' => [
                                    'name' => 'Fast Thermal', 
                                    'icon' => 'feather-zap', 
                                    'color' => '#6366f1', 
                                    'desc' => 'Optimized for 80mm printers. A compact receipt-style format for quick billing and collections.'
                                ],
                            ];
                        @endphp

                        @foreach($templates as $key => $tpl)
                            <div class="col-md-4">
                                <div wire:click="$set('bill_template', '{{ $key }}')"
                                     class="card h-100 border-2 transition-all hover-lift {{ $bill_template === $key ? 'shadow-lg border-primary' : 'border-light-subtle' }}"
                                     style="cursor:pointer; border-radius: 20px; overflow: hidden;">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar-text avatar-xl mx-auto mb-4 rounded-circle shadow-sm" style="background:{{ $tpl['color'] }}15; width: 70px; height: 70px; line-height: 70px;">
                                            <i class="{{ $tpl['icon'] }}" style="font-size:32px;color:{{ $tpl['color'] }};"></i>
                                        </div>
                                        <h5 class="fw-bolder mb-2 text-dark">{{ $tpl['name'] }}</h5>
                                        <p class="fs-13 text-muted mb-4 px-2">{{ $tpl['desc'] }}</p>
                                        
                                        <div class="mt-auto">
                                            @if($bill_template === $key)
                                                <div class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm">
                                                    <i class="feather-check-circle me-1"></i> Active
                                                </div>
                                            @else
                                                <div class="btn btn-light border-0 w-100 py-2 rounded-pill fw-bold text-dark">
                                                    Select
                                                </div>
                                            @endif
                                            
                                            <div class="mt-3">
                                                <a href="{{ route('lab.settings.invoice.preview', $key) }}" target="_blank" onclick="event.stopPropagation()" class="text-primary fw-bold fs-12 text-decoration-none">
                                                    <i class="feather-eye me-1"></i> Preview Live Format
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @can('edit settings')
                    <div class="mt-4 pt-3 text-start">
                        <button wire:click="saveTemplate" class="settings-save-btn">
                            <i class="feather-check"></i> Save Template Preference
                        </button>
                    </div>
                    @endcan
                </div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- TAB 4: PDF HEADER / FOOTER --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        @if($activeTab === 'pdf')
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="settings-section-header d-flex align-items-center gap-3">
                    <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                        <i class="feather-printer"></i>
                    </div>
                    <span class="fs-15 fw-bold">Letterhead & PDF Configuration</span>
                </div>
                <div class="card-body p-4">
                    @if($pdfSaved)
                        <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                            <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Letterhead settings saved successfully!</span>
                        </div>
                    @endif

                    {{-- Visibility Switches --}}
                    <div class="row g-4 mb-5">
                        <div class="col-lg-6">
                            <div class="p-4 rounded-4 bg-light border-0 shadow-sm h-100">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="pe-3">
                                        <h6 class="fw-bolder mb-1 text-dark">Default Header Visibility</h6>
                                        <p class="fs-12 text-muted mb-0">Toggle Lab Name, Logo, and Address details on the PDF top section.</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.live="pdf_show_header" style="width:3.5em;height:1.75em;">
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-3">
                                        <h6 class="fw-bolder mb-1 text-dark">Default Footer Visibility</h6>
                                        <p class="fs-12 text-muted mb-0">Toggle the disclaimer, thank you message, and website at the PDF bottom.</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.live="pdf_show_footer" style="width:3.5em;height:1.75em;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-4 rounded-4 bg-light border-0 shadow-sm h-100">
                                <h6 class="fw-bolder mb-3 text-dark">PDF Background Mode</h6>
                                <p class="fs-12 text-muted mb-3">Choose how you want to upload your stationery.</p>
                                <div class="d-flex gap-3">
                                    <div class="form-check custom-radio">
                                        <input class="form-check-input" type="radio" wire:model.live="pdf_background_mode" name="bg_mode" id="bg_hf" value="header_footer">
                                        <label class="form-check-label fw-bold" for="bg_hf">Separate Header & Footer</label>
                                    </div>
                                    <div class="form-check custom-radio">
                                        <input class="form-check-input" type="radio" wire:model.live="pdf_background_mode" name="bg_mode" id="bg_lh" value="letterhead">
                                        <label class="form-check-label fw-bold" for="bg_lh">Full Page Letterhead</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        {{-- Custom Images --}}
                        <div class="col-lg-12">
                            <h6 class="fw-bolder text-dark mb-4 ms-1">High-Resolution Branding Images</h6>
                            
                            @if($pdf_background_mode === 'header_footer')
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="card border border-light-subtle rounded-4 h-100 bg-white">
                                        <div class="card-body p-4">
                                            <label class="form-label fw-bolder text-dark fs-13 mb-3"><i class="feather-image text-primary me-2"></i>Custom Letterhead Header</label>
                                            <div class="p-4 bg-light rounded-4 text-center border-dashed border-2 mb-3">
                                                @if($pdf_header_image)
                                                    <img src="{{ secure_storage_url($pdf_header_image) }}" alt="Header" class="img-fluid rounded shadow-sm mb-3" style="max-height:100px;">
                                                    <div>
                                                        <button wire:click="removeHeaderImage" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Remove Image</button>
                                                    </div>
                                                @elseif($new_header_image)
                                                    <img src="{{ $new_header_image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded shadow-sm mb-3" style="max-height:100px;">
                                                    <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">New Header Ready</div>
                                                @else
                                                    <div class="py-4">
                                                        <i class="feather-upload-cloud text-muted fs-1 mb-2"></i>
                                                        <p class="text-muted fs-12 mb-0">Upload a 1200x300px image of your letterhead</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" wire:model="new_header_image" accept="image/*" class="form-control form-control-lg border-light rounded-3 fs-13">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border border-light-subtle rounded-4 h-100 bg-white">
                                        <div class="card-body p-4">
                                            <label class="form-label fw-bolder text-dark fs-13 mb-3"><i class="feather-image text-primary me-2"></i>Custom Letterhead Footer</label>
                                            <div class="p-4 bg-light rounded-4 text-center border-dashed border-2 mb-3">
                                                @if($pdf_footer_image)
                                                    <img src="{{ secure_storage_url($pdf_footer_image) }}" alt="Footer" class="img-fluid rounded shadow-sm mb-3" style="max-height:80px;">
                                                    <div>
                                                        <button wire:click="removeFooterImage" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Remove Image</button>
                                                    </div>
                                                @elseif($new_footer_image)
                                                    <img src="{{ $new_footer_image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded shadow-sm mb-3" style="max-height:80px;">
                                                    <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">New Footer Ready</div>
                                                @else
                                                    <div class="py-4">
                                                        <i class="feather-upload-cloud text-muted fs-1 mb-2"></i>
                                                        <p class="text-muted fs-12 mb-0">Upload a 1200x150px footer image</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" wire:model="new_footer_image" accept="image/*" class="form-control form-control-lg border-light rounded-3 fs-13">
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @elseif($pdf_background_mode === 'letterhead')
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div class="card border border-light-subtle rounded-4 h-100 bg-white">
                                        <div class="card-body p-4">
                                            <label class="form-label fw-bolder text-dark fs-13 mb-3"><i class="feather-image text-primary me-2"></i>Full Page Letterhead (A4 Background)</label>
                                            <div class="p-4 bg-light rounded-4 text-center border-dashed border-2 mb-3">
                                                @if($pdf_letterhead_image)
                                                    <img src="{{ secure_storage_url($pdf_letterhead_image) }}" alt="Letterhead" class="img-fluid rounded shadow-sm mb-3" style="max-height:200px;">
                                                    <div>
                                                        <button wire:click="removeLetterheadImage" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Remove Image</button>
                                                    </div>
                                                @elseif($new_letterhead_image)
                                                    <img src="{{ $new_letterhead_image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded shadow-sm mb-3" style="max-height:200px;">
                                                    <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">New Letterhead Ready</div>
                                                @else
                                                    <div class="py-4">
                                                        <i class="feather-upload-cloud text-muted fs-1 mb-2"></i>
                                                        <p class="text-muted fs-12 mb-0">Upload a full A4 image (approx 794x1122px or 2480x3508px for high res) as your background letterhead</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" wire:model="new_letterhead_image" accept="image/*" class="form-control form-control-lg border-light rounded-3 fs-13">
                                            <small class="text-muted mt-2 d-block">Note: If you use a full letterhead, the report text will be printed in the center. Adjust the Top & Bottom Margins below to prevent overlapping with your pre-printed header and footer graphics.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Layout & Margins --}}
                            <div class="row g-4 mt-2">
                                <div class="col-12">
                                    <div class="card border border-light-subtle rounded-4 bg-white shadow-sm">
                                        <div class="card-body p-4">
                                            <h6 class="fw-bolder mb-3"><i class="feather-layout text-primary me-2"></i>Page Margins (in pixels)</h6>
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-13 text-muted">Top Margin</label>
                                                    <input type="number" wire:model="pdf_margin_top" class="form-control" placeholder="e.g. 310">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-13 text-muted">Bottom Margin</label>
                                                    <input type="number" wire:model="pdf_margin_bottom" class="form-control" placeholder="e.g. 255">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-13 text-muted">Left Margin</label>
                                                    <input type="number" wire:model="pdf_margin_left" class="form-control" placeholder="e.g. 25">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-13 text-muted">Right Margin</label>
                                                    <input type="number" wire:model="pdf_margin_right" class="form-control" placeholder="e.g. 25">
                                                </div>
                                            </div>
                                            <small class="text-muted mt-3 d-block"><i class="feather-info me-1"></i> Adjust these margins to prevent your report text from overlapping with your uploaded letterhead/header/footer designs.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('edit settings')
                        <div class="mt-4 mb-4 pt-3 border-top text-start">
                            <button wire:click="savePdfSettings" class="settings-save-btn">
                                <i class="feather-check"></i> Save Letterhead Settings
                            </button>
                        </div>
                        @endcan

                        {{-- Instructions --}}
                        <div class="col-12 mt-5">
                            <div class="p-4 rounded-4" style="background:rgba(var(--bs-primary-rgb), 0.03); border: 1px solid rgba(var(--bs-primary-rgb), 0.1);">
                                <h6 class="fw-bolder text-primary mb-4 d-flex align-items-center">
                                    <i class="feather-info me-2 fs-5"></i> Understanding Your PDF Export Options
                                </h6>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded-4 bg-white p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-text bg-soft-success text-success rounded-3 me-3" style="width:35px; height:35px; line-height:35px;">
                                                    <i class="feather-file-plus"></i>
                                                </div>
                                                <h6 class="fw-bolder mb-0 text-dark">Full Branding</h6>
                                            </div>
                                            <p class="fs-12 text-muted mb-0">Default option. Includes everything: Logo, Name, Address, and Footer. Best for direct digital sharing via WhatsApp or Email.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded-4 bg-white p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-text bg-soft-warning text-warning rounded-3 me-3" style="width:35px; height:35px; line-height:35px;">
                                                    <i class="feather-file-minus"></i>
                                                </div>
                                                <h6 class="fw-bolder mb-0 text-dark">Minimalist (No Header)</h6>
                                            </div>
                                            <p class="fs-12 text-muted mb-0">Removes the top branding block. Ideal for <strong>pre-printed letterheads</strong> where your lab info is already on the paper.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded-4 bg-white p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-text bg-soft-primary text-primary rounded-3 me-3" style="width:35px; height:35px; line-height:35px;">
                                                    <i class="feather-image"></i>
                                                </div>
                                                <h6 class="fw-bolder mb-0 text-dark">Custom Overlay</h6>
                                            </div>
                                            <p class="fs-12 text-muted mb-0">Upload a single high-quality image of your full letterhead. It will be used as a backdrop for all your clinical reports.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- TAB: SIGNATURES --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        @if($activeTab === 'signatures')
            <div class="row g-4">
                {{-- Global Settings & Mode --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="settings-section-header">
                            <i class="feather-edit-3 me-2"></i> Signature Display Strategy
                        </div>
                        <div class="card-body p-4">
                            @if($signaturesSaved)
                                <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                                    <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Signature settings saved successfully!</span>
                                </div>
                            @endif

                            <div class="row g-4 align-items-center">
                                <div class="col-md-7">
                                    <div class="d-flex gap-3">
                                        <div wire:click="$set('report_signature_mode', 'global_bottom')" 
                                             class="flex-fill p-3 rounded-4 border-2 cursor-pointer transition-all {{ $report_signature_mode === 'global_bottom' ? 'border-primary bg-soft-primary' : 'border-light bg-light' }}"
                                             style="border-style: solid;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-text avatar-md rounded-circle {{ $report_signature_mode === 'global_bottom' ? 'bg-primary text-white' : 'bg-white text-muted border' }}">
                                                    <i class="feather-align-center"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold fs-13 {{ $report_signature_mode === 'global_bottom' ? 'text-primary' : 'text-dark' }}">Global Bottom</div>
                                                    <div class="fs-10 text-muted">Fixed at end of report</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="$set('report_signature_mode', 'per_department')" 
                                             class="flex-fill p-3 rounded-4 border-2 cursor-pointer transition-all {{ $report_signature_mode === 'per_department' ? 'border-primary bg-soft-primary' : 'border-light bg-light' }}"
                                             style="border-style: solid;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-text avatar-md rounded-circle {{ $report_signature_mode === 'per_department' ? 'bg-primary text-white' : 'bg-white text-muted border' }}">
                                                    <i class="feather-layers"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold fs-13 {{ $report_signature_mode === 'per_department' ? 'text-primary' : 'text-dark' }}">Per Department</div>
                                                    <div class="fs-10 text-muted">After each section</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="alert alert-soft-info border-0 shadow-none mb-0 fs-11 py-3 px-4 rounded-4">
                                        <i class="feather-info me-2"></i>
                                        <strong>Pro Tip:</strong> Global mode uses the 3 fixed signatures below. Department mode uses signatures defined in each department's own settings.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Global Signatures (For Bottom Mode) --}}
                <div class="col-12">
                    <div class="settings-section-header bg-dark mb-4">
                        <i class="feather-globe me-2"></i> Global Signatories (Fixed Bottom)
                    </div>
                    <div class="row g-4">
                        {{-- Slot 1 --}}
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                <div class="card-body p-4 text-center">
                                    <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Signatory Slot 1</div>
                                    <div class="position-relative mb-4 mx-auto" style="width: 140px; height: 90px; border: 2px dashed #e5e7eb; border-radius: 12px; background: #f9fafb; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        @if($new_signature_image)
                                            <img src="{{ $new_signature_image->temporaryUrl() }}" class="w-100 h-100 object-fit-contain">
                                        @elseif($signature_image)
                                            <img src="{{ secure_storage_url($signature_image) }}" class="w-100 h-100 object-fit-contain">
                                        @else
                                            <i class="feather-upload-cloud fs-4 text-muted"></i>
                                        @endif
                                        <input type="file" wire:model="new_signature_image" class="position-absolute opacity-0 w-100 h-100 cursor-pointer">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 fw-bold text-center fs-14 bg-transparent" wire:model="authorized_signatory_name" placeholder="Full Name">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 text-center fs-12 text-muted bg-transparent" wire:model="authorized_signatory_designation" placeholder="Medical Designation">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Slot 2 --}}
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                <div class="card-body p-4 text-center">
                                    <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Signatory Slot 2</div>
                                    <div class="position-relative mb-4 mx-auto" style="width: 140px; height: 90px; border: 2px dashed #e5e7eb; border-radius: 12px; background: #f9fafb; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        @if($new_global_sig_2)
                                            <img src="{{ $new_global_sig_2->temporaryUrl() }}" class="w-100 h-100 object-fit-contain">
                                        @elseif($global_sig_2_path)
                                            <img src="{{ secure_storage_url($global_sig_2_path) }}" class="w-100 h-100 object-fit-contain">
                                        @else
                                            <i class="feather-upload-cloud fs-4 text-muted"></i>
                                        @endif
                                        <input type="file" wire:model="new_global_sig_2" class="position-absolute opacity-0 w-100 h-100 cursor-pointer">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 fw-bold text-center fs-14 bg-transparent" wire:model="global_sig_2_name" placeholder="Full Name">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 text-center fs-12 text-muted bg-transparent" wire:model="global_sig_2_desig" placeholder="Medical Designation">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Slot 3 --}}
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                <div class="card-body p-4 text-center">
                                    <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Signatory Slot 3</div>
                                    <div class="position-relative mb-4 mx-auto" style="width: 140px; height: 90px; border: 2px dashed #e5e7eb; border-radius: 12px; background: #f9fafb; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        @if($new_global_sig_3)
                                            <img src="{{ $new_global_sig_3->temporaryUrl() }}" class="w-100 h-100 object-fit-contain">
                                        @elseif($global_sig_3_path)
                                            <img src="{{ secure_storage_url($global_sig_3_path) }}" class="w-100 h-100 object-fit-contain">
                                        @else
                                            <i class="feather-upload-cloud fs-4 text-muted"></i>
                                        @endif
                                        <input type="file" wire:model="new_global_sig_3" class="position-absolute opacity-0 w-100 h-100 cursor-pointer">
                                    </div>
                                    <div class="mb-3">
                                     {{-- Department Signatures --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="settings-section-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle">
                            <i class="feather-layers"></i>
                        </div>
                        <span class="fs-15 fw-bold">Department-Specific Signatures</span>
                    </div>
                    <div style="width: 280px;">
                        <div class="settings-input-group border-0 bg-white bg-opacity-20">
                            <div class="settings-input-icon bg-transparent border-0 text-white opacity-75" style="width: 40px;"><i class="feather-search fs-12"></i></div>
                            <select class="form-control form-select border-0 bg-transparent text-white fw-bold fs-12 cursor-pointer ps-0" wire:model.live="selected_dept_id">
                                <option value="" class="text-dark">Select Department...</option>
                                @foreach(\App\Models\Department::forCompany(auth()->user()->company_id)->get() as $dept)
                                    <option value="{{ $dept->id }}" class="text-dark">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(!$selected_dept_id)
                        <div class="text-center py-5">
                            <div class="avatar-text avatar-xl bg-light text-muted mx-auto mb-4 rounded-circle shadow-sm" style="width: 80px; height: 80px; line-height: 80px;">
                                <i class="feather-search" style="font-size: 2.5rem; opacity: 0.3;"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">No Department Selected</h4>
                            <p class="text-muted fs-14 mb-0 mx-auto" style="max-width: 400px;">Choose a clinical department from the dropdown above to manage its specific reporting signatures.</p>
                        </div>
                    @else
                                <div class="row g-4">
                                    {{-- Slot 1 --}}
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-light">
                                            <div class="card-body p-4 text-center">
                                                <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Dept Signatory 1</div>
                                                <div class="position-relative mb-4 mx-auto" style="width: 140px; height: 90px; border: 2px dashed #cbd5e1; border-radius: 12px; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                    @if($new_dept_sig_1)
                                                        <img src="{{ $new_dept_sig_1->temporaryUrl() }}" class="w-100 h-100 object-fit-contain">
                                                    @elseif($dept_sig_1_path)
                                                        <img src="{{ secure_storage_url($dept_sig_1_path) }}" class="w-100 h-100 object-fit-contain">
                                                    @else
                                                        <i class="feather-upload-cloud fs-4 text-muted"></i>
                                                    @endif
                                                    <input type="file" wire:model="new_dept_sig_1" class="position-absolute opacity-0 w-100 h-100 cursor-pointer">
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 fw-bold text-center fs-14 bg-transparent" wire:model="dept_sig_1_name" placeholder="Full Name">
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 text-center fs-12 text-muted bg-transparent" wire:model="dept_sig_1_desig" placeholder="Designation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Slot 2 --}}
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-light">
                                            <div class="card-body p-4 text-center">
                                                <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Dept Signatory 2</div>
                                                <div class="position-relative mb-4 mx-auto" style="width: 140px; height: 90px; border: 2px dashed #cbd5e1; border-radius: 12px; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                    @if($new_dept_sig_2)
                                                        <img src="{{ $new_dept_sig_2->temporaryUrl() }}" class="w-100 h-100 object-fit-contain">
                                                    @elseif($dept_sig_2_path)
                                                        <img src="{{ secure_storage_url($dept_sig_2_path) }}" class="w-100 h-100 object-fit-contain">
                                                    @else
                                                        <i class="feather-upload-cloud fs-4 text-muted"></i>
                                                    @endif
                                                    <input type="file" wire:model="new_dept_sig_2" class="position-absolute opacity-0 w-100 h-100 cursor-pointer">
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 fw-bold text-center fs-14 bg-transparent" wire:model="dept_sig_2_name" placeholder="Full Name">
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 text-center fs-12 text-muted bg-transparent" wire:model="dept_sig_2_desig" placeholder="Designation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Slot 3 --}}
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-light">
                                            <div class="card-body p-4 text-center">
                                                <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Dept Signatory 3</div>
                                                <div class="position-relative mb-4 mx-auto" style="width: 140px; height: 90px; border: 2px dashed #cbd5e1; border-radius: 12px; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                    @if($new_dept_sig_3)
                                                        <img src="{{ $new_dept_sig_3->temporaryUrl() }}" class="w-100 h-100 object-fit-contain">
                                                    @elseif($dept_sig_3_path)
                                                        <img src="{{ secure_storage_url($dept_sig_3_path) }}" class="w-100 h-100 object-fit-contain">
                                                    @else
                                                        <i class="feather-upload-cloud fs-4 text-muted"></i>
                                                    @endif
                                                    <input type="file" wire:model="new_dept_sig_3" class="position-absolute opacity-0 w-100 h-100 cursor-pointer">
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 fw-bold text-center fs-14 bg-transparent" wire:model="dept_sig_3_name" placeholder="Full Name">
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 text-center fs-12 text-muted bg-transparent" wire:model="dept_sig_3_desig" placeholder="Designation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action Bar --}}
                <div class="col-12 mt-4">
                    <div class="card bg-dark border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
                            <div class="d-flex align-items-center gap-4">
                                <div class="avatar-text avatar-lg bg-primary bg-opacity-20 text-primary rounded-circle shadow-sm d-none d-sm-flex" style="width: 60px; height: 60px; line-height: 60px;">
                                    <i class="feather-shield fs-3"></i>
                                </div>
                                <div class="text-center text-md-start">
                                    <h5 class="fw-bold text-white mb-2">Finalize Signature Configuration</h5>
                                    <p class="fs-13 text-white-50 mb-0">Changes will be reflected in all new and re-printed clinical reports instantly.</p>
                                </div>
                            </div>
                            <button wire:click="saveSignatures" class="settings-save-btn m-0 shadow-lg py-3 px-5 fs-15 border-0" style="min-width: 300px;">
                                <span wire:loading.remove wire:target="saveSignatures"><i class="feather-check-circle me-2"></i>Publish All Changes</span>
                                <span wire:loading wire:target="saveSignatures"><span class="spinner-border spinner-border-sm me-2"></span>Publishing...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- TAB 5: BARCODE SETTINGS --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        @if($activeTab === 'barcode')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="settings-section-header d-flex align-items-center gap-3">
                            <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                                <i class="feather-maximize"></i>
                            </div>
                            <span class="fs-15 fw-bold">Barcode Label Pattern</span>
                        </div>
                        <div class="card-body p-4">
                            @if($barcodeSaved)
                                <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                                    <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Barcode settings saved!</span>
                                </div>
                            @endif

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark fs-12 mb-2">Barcode Prefix <span class="text-danger">*</span></label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-maximize"></i></div>
                                        <input type="text" class="form-control" wire:model.live.debounce.500ms="barcode_prefix" placeholder="e.g. BC, LAB, UID">
                                    </div>
                                    <div class="fs-11 text-muted mt-2">Text at the start of barcode. Default: LAB</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark fs-12 mb-2">Date Format</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-calendar"></i></div>
                                        <select class="form-control form-select" wire:model.live="barcode_date_format">
                                            <option value="ym">YYMM ({{ date('ym') }})</option>
                                            <option value="ymd">YYMMDD ({{ date('ymd') }})</option>
                                            <option value="Ymd">YYYYMMDD ({{ date('Ymd') }})</option>
                                            <option value="Y">YYYY ({{ date('Y') }})</option>
                                            <option value="none">No Date</option>
                                        </select>
                                    </div>
                                    <div class="fs-11 text-muted mt-2">Included after prefix</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark fs-12 mb-2">Counter Digits</label>
                                    <div class="settings-input-group">
                                        <div class="settings-input-icon"><i class="feather-hash"></i></div>
                                        <select class="form-control form-select" wire:model.live="barcode_counter_digits">
                                            <option value="4">4 digits (0001)</option>
                                            <option value="5">5 digits (00001)</option>
                                            <option value="6">6 digits (000001)</option>
                                            <option value="8">8 digits (00000001)</option>
                                            <option value="10">10 digits (0000000001)</option>
                                        </select>
                                    </div>
                                    <div class="fs-11 text-muted mt-2">Length of the unique serial number</div>
                                </div>
                            </div>

                            @can('edit settings')
                            <div class="mt-4 pt-3 text-start">
                                <button wire:click="saveBarcodeSettings" class="settings-save-btn">
                                    <i class="feather-check"></i> Save Barcode Settings
                                </button>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Live Preview --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="settings-section-header bg-dark">
                            <i class="feather-eye me-2"></i> Barcode Preview
                        </div>
                        <div class="card-body text-center py-5 d-flex flex-column justify-content-center">
                            <div class="fs-10 fw-bold text-muted text-uppercase mb-3">Sample Barcode ID:</div>
                            <div class="display-6 fw-bold text-dark py-3 px-3 rounded-3 border bg-light font-monospace" style="letter-spacing:1px;">
                                {{ $this->barcodePreview }}
                            </div>
                            <div class="mt-4">
                                <div class="fs-11 text-muted px-3 text-start">
                                    <p class="mb-0"><i class="feather-info me-1"></i> This ID is unique for every invoice and is printed on all sample stickers associated with the bill.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($activeTab === 'staff')
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="settings-section-header d-flex align-items-center gap-3">
                    <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                        <i class="feather-users"></i>
                    </div>
                    <span class="fs-15 fw-bold">Staff & Role Permissions</span>
                </div>
                <div class="card-body p-0">
                    @livewire('lab.staff-role-manager')
                </div>
            </div>
        @endif

        @if($activeTab === 'branch')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="settings-section-header d-flex align-items-center gap-3">
                            <div class="avatar-text avatar-sm bg-white bg-opacity-25 text-white rounded-circle shadow-sm">
                                <i class="feather-git-merge"></i>
                            </div>
                            <span class="fs-15 fw-bold">Global Data Sharing Policies</span>
                        </div>
                        <div class="card-body p-4">
                            @if($branchControlsSaved)
                                <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 d-flex align-items-center gap-3">
                                    <i class="feather-check-circle fs-4"></i> <span class="fw-bold">Branch sharing policy saved successfully!</span>
                                </div>
                            @endif

                            <div class="list-group list-group-flush border-0">
                                {{-- Share Patients --}}
                                <div class="list-group-item px-0 py-4 border-light d-flex justify-content-between align-items-center">
                                    <div class="pe-3">
                                        <div class="fw-bold text-dark fs-14 mb-1"><i class="feather-users me-2 text-primary"></i>Share Patient Registry</div>
                                        <div class="fs-12 text-muted">If ON, sub-branches can search and bill any patient registered in the main database.</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="branch_share_patients" style="width: 3em; height: 1.5em;">
                                    </div>
                                </div>

                                {{-- Share Doctors --}}
                                <div class="list-group-item px-0 py-4 border-light d-flex justify-content-between align-items-center">
                                    <div class="pe-3">
                                        <div class="fw-bold text-dark fs-14 mb-1"><i class="feather-user-plus me-2 text-info"></i>Share Referral Doctors</div>
                                        <div class="fs-12 text-muted">If ON, sub-branches can select referral doctors from the global company list.</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="branch_share_doctors" style="width: 3em; height: 1.5em;">
                                    </div>
                                </div>

                                {{-- Share Agents --}}
                                <div class="list-group-item px-0 py-4 border-light d-flex justify-content-between align-items-center">
                                    <div class="pe-3">
                                        <div class="fw-bold text-dark fs-14 mb-1"><i class="feather-briefcase me-2 text-warning"></i>Share Referral Agents</div>
                                        <div class="fs-12 text-muted">If ON, sub-branches can use global agents. If OFF, agents are strictly siloed.</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="branch_share_agents" style="width: 3em; height: 1.5em;">
                                    </div>
                                </div>

                                {{-- Share Lab Tests --}}
                                <div class="list-group-item px-0 py-4 border-light d-flex justify-content-between align-items-center border-bottom-0">
                                    <div class="pe-3">
                                        <div class="fw-bold text-dark fs-14 mb-1"><i class="feather-activity me-2 text-danger"></i>Share Lab Test Catalog</div>
                                        <div class="fs-12 text-muted">If ON, sub-branches use the company's master lab test templates and pricing.</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="branch_share_tests" style="width: 3em; height: 1.5em;">
                                    </div>
                                </div>
                            </div>

                            @can('edit settings')
                            <div class="mt-4 pt-3 text-start">
                                <button wire:click="saveBranchControls" class="settings-save-btn">
                                    <i class="feather-check"></i> Save Data Policies
                                </button>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                        <div class="settings-section-header bg-dark">
                            <i class="feather-shield me-2"></i> Security Info
                        </div>
                        <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center">
                            <div class="avatar-text avatar-xl bg-primary text-white rounded-circle shadow-sm mb-4">
                                <i class="feather-lock"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-3">Data Siloing</h5>
                            <p class="fs-13 text-muted px-2">
                                Turning off sharing toggles will strictly isolate the sub-branch records.
                            </p>
                            <div class="alert alert-soft-warning border-0 rounded-4 mt-3 text-start">
                                <i class="feather-alert-triangle me-2"></i> <span class="fs-11 fw-bold">Warning:</span>
                                <p class="fs-11 mb-0 mt-1 opacity-75">Existing data will not be deleted, but will become invisible to other branches instantly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
