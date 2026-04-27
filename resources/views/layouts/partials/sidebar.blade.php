<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            @php
                $dashboardRoute = route('lab.dashboard'); // Default
                if (auth()->user()->hasRole('super_admin')) {
                    $dashboardRoute = route('admin.dashboard');
                } elseif (auth()->user()->patientProfile) {
                    $dashboardRoute = route('portal.dashboard');
                } elseif (auth()->user()->hasAnyRole(['doctor', 'agent', 'collection_center'])) {
                    $dashboardRoute = route('partner.dashboard');
                }
            @endphp
            <a href="{{ $dashboardRoute }}" wire:navigate class="b-brand">
                @php
                    $logoPath = null;
                    $faviconPath = null;

                    // 1. Check for Lab-specific branding
                    if (auth()->user()->company) {
                        if (auth()->user()->company->logo) {
                            $logoPath = secure_storage_url(auth()->user()->company->logo);
                        }
                        
                        $labFavicon = \App\Models\Configuration::getFor('lab_favicon');
                        if ($labFavicon) {
                            $faviconPath = secure_storage_url($labFavicon);
                        }
                    }

                    // 2. Fallback to Site-wide branding (Superadmin)
                    if (!$logoPath) {
                        $siteLogo = \App\Models\SiteSetting::get('site_logo');
                        if ($siteLogo) {
                            $logoPath = secure_storage_url($siteLogo);
                        }
                    }

                    if (!$faviconPath) {
                        $siteFavicon = \App\Models\SiteSetting::get('site_favicon');
                        if ($siteFavicon) {
                            $faviconPath = secure_storage_url($siteFavicon);
                        } else {
                            // Ultimate fallback
                            $faviconPath = asset('assets/images/icon.webp');
                        }
                    }
                @endphp

                @if($logoPath)
                    <img src="{{ $logoPath }}" alt="Logo" height="50px" class="logo logo-lg" style="object-fit: contain;" />
                @else
                    <img src="{{ asset('assets/images/icon.webp') }}" alt="Logo" height="50px" class="logo logo-lg" />
                @endif

                <img src="{{ $faviconPath }}" alt="Logo" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">

                @role('super_admin')
                    <li class="nxl-item nxl-caption">
                        <label>Main Cabinet</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Master Catalog</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.global-tests') ? 'active' : '' }}">
                        <a href="{{ route('admin.global-tests') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-layers"></i></span>
                            <span class="nxl-mtext">Global Tests</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.departments') ? 'active' : '' }}">
                        <a href="{{ route('admin.departments') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-grid"></i></span>
                            <span class="nxl-mtext">System Departments</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Business & Finance</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.plans') ? 'active' : '' }}">
                        <a href="{{ route('admin.plans') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-credit-card"></i></span>
                            <span class="nxl-mtext">Pricing Plans</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.labs') ? 'active' : '' }}">
                        <a href="{{ route('admin.labs') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-dollar-sign"></i></span>
                            <span class="nxl-mtext">Labs</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.sales-agents') ? 'active' : '' }}">
                        <a href="{{ route('admin.sales-agents') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">Sales Agents</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Website CMS</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.site-settings') ? 'active' : '' }}">
                        <a href="{{ route('admin.site-settings') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-globe"></i></span>
                            <span class="nxl-mtext">Site Settings</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.landing-content') ? 'active' : '' }}">
                        <a href="{{ route('admin.landing-content') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-layout"></i></span>
                            <span class="nxl-mtext">Landing Content</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.enquiries') ? 'active' : '' }}">
                        <a href="{{ route('admin.enquiries') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-inbox"></i></span>
                            <span class="nxl-mtext">Enquiries</span>
                            @php $newEnquiries = \App\Models\Enquiry::new()->count(); @endphp
                            @if($newEnquiries > 0)
                                <span class="badge bg-danger rounded-pill ms-auto">{{ $newEnquiries }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}">
                        <a href="{{ route('admin.audit-logs') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-shield"></i></span>
                            <span class="nxl-mtext">Global Audit Logs</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.system-logs') ? 'active' : '' }}">
                        <a href="{{ route('admin.system-logs') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-terminal"></i></span>
                            <span class="nxl-mtext">System Log Monitor</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('admin.maintenance') ? 'active' : '' }}">
                        <a href="{{ route('admin.maintenance') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-zap"></i></span>
                            <span class="nxl-mtext">System Maintenance</span>
                        </a>
                    </li>
                    @if(config('features.support_tickets', true))
                    <li class="nxl-item {{ request()->routeIs('admin.support') ? 'active' : '' }}">
                        <a href="{{ route('admin.support') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-help-circle"></i></span>
                            <span class="nxl-mtext">System Support</span>
                        </a>
                    </li>
                    @endif
                @endrole

                @if(auth()->user()->hasAnyRole(['lab_admin', 'staff', 'branch_admin']))
                    <li class="nxl-item nxl-caption">
                        <label>Main</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('lab.dashboard') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Sales & Operations</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.pos') ? 'active' : '' }}">
                        <a href="{{ route('lab.pos') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                            <span class="nxl-mtext">New Bill (POS)</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.invoices') || request()->routeIs('lab.invoice.edit') ? 'active' : '' }}">
                        <a href="{{ route('lab.invoices') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-file-text"></i></span>
                            <span class="nxl-mtext">All Invoices</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.reports') || request()->routeIs('lab.reports.entry') ? 'active' : '' }}">
                        <a href="{{ route('lab.reports') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-clipboard"></i></span>
                            <span class="nxl-mtext">Test Reports</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Lab Management</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.departments') ? 'active' : '' }}">
                        <a href="{{ route('lab.departments') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-grid"></i></span>
                            <span class="nxl-mtext">Departments</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.tests') ? 'active' : '' }}">
                        <a href="{{ route('lab.tests') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-activity"></i></span>
                            <span class="nxl-mtext">Test Catalog</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.packages') ? 'active' : '' }}">
                        <a href="{{ route('lab.packages') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-package"></i></span>
                            <span class="nxl-mtext">Test Packages</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Network</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.branches') ? 'active' : '' }}">
                        <a href="{{ route('lab.branches') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-home"></i></span>
                            <span class="nxl-mtext">Main Branches</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.collection.centers') ? 'active' : '' }}">
                        <a href="{{ route('lab.collection.centers') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-map"></i></span>
                            <span class="nxl-mtext">Collection Centers</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Relationships</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.patients') ? 'active' : '' }}">
                        <a href="{{ route('lab.patients') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">Patients</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.doctors') ? 'active' : '' }}">
                        <a href="{{ route('lab.doctors') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-user-check"></i></span>
                            <span class="nxl-mtext">Referring Doctors</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.agents') ? 'active' : '' }}">
                        <a href="{{ route('lab.agents') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                            <span class="nxl-mtext">Referral Agents</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Finance & Marketing</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.settlements') ? 'active' : '' }}">
                        <a href="{{ route('lab.settlements') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-dollar-sign"></i></span>
                            <span class="nxl-mtext">Settlements</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.payment.modes') ? 'active' : '' }}">
                        <a href="{{ route('lab.payment.modes') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-credit-card"></i></span>
                            <span class="nxl-mtext">Payment Modes</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.marketing') ? 'active' : '' }}">
                        <a href="{{ route('lab.marketing') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-gift"></i></span>
                            <span class="nxl-mtext">Offers & Memberships</span>
                        </a>
                    </li>

                    @if(config('features.inventory', true))
                    <li class="nxl-item nxl-caption">
                        <label>Inventory & Assets</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.inventory.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('lab.inventory.dashboard') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-pie-chart"></i></span>
                            <span class="nxl-mtext">Analytics Dashboard</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.inventory.items') ? 'active' : '' }}">
                        <a href="{{ route('lab.inventory.items') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-list"></i></span>
                            <span class="nxl-mtext">Items Master</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.inventory.suppliers') ? 'active' : '' }}">
                        <a href="{{ route('lab.inventory.suppliers') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-truck"></i></span>
                            <span class="nxl-mtext">Suppliers</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.inventory.purchase') ? 'active' : '' }}">
                        <a href="{{ route('lab.inventory.purchase') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-download"></i></span>
                            <span class="nxl-mtext">Receive Stock</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.inventory.issuance') ? 'active' : '' }}">
                        <a href="{{ route('lab.inventory.issuance') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-external-link"></i></span>
                            <span class="nxl-mtext">Staff Issuance</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.inventory.stock') ? 'active' : '' }}">
                        <a href="{{ route('lab.inventory.stock') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-database"></i></span>
                            <span class="nxl-mtext">Current Stock</span>
                        </a>
                    </li>
                    @endif

                    <li class="nxl-item nxl-caption">
                        <label>Settings & Account</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.audit-logs') ? 'active' : '' }}">
                        <a href="{{ route('lab.audit-logs') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-shield"></i></span>
                            <span class="nxl-mtext">Audit Logs</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.settings') ? 'active' : '' }}">
                        <a href="{{ route('lab.settings') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-settings"></i></span>
                            <span class="nxl-mtext">Lab Settings</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.profile') ? 'active' : '' }}">
                        <a href="{{ route('lab.profile') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">My Profile</span>
                        </a>
                    </li>
                    @if(config('features.support_tickets', true))
                    <li class="nxl-item {{ request()->routeIs('lab.support') ? 'active' : '' }}">
                        <a href="{{ route('lab.support') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-help-circle"></i></span>
                            <span class="nxl-mtext">Help & Support</span>
                        </a>
                    </li>
                    @endif
                    <li class="nxl-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-lab" class="d-none">
                            @csrf
                        </form>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form-lab').submit();" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-log-out text-danger"></i></span>
                            <span class="nxl-mtext text-danger">Logout</span>
                        </a>
                    </li>
                @endrole

                @role('branch_admin')
                    <li class="nxl-item nxl-caption">
                        <label>Main</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('lab.dashboard') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Sales & Operations</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.pos') ? 'active' : '' }}">
                        <a href="{{ route('lab.pos') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                            <span class="nxl-mtext">New Bill (POS)</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.invoices') || request()->routeIs('lab.invoice.edit') ? 'active' : '' }}">
                        <a href="{{ route('lab.invoices') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-file-text"></i></span>
                            <span class="nxl-mtext">All Invoices</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.reports') || request()->routeIs('lab.reports.entry') ? 'active' : '' }}">
                        <a href="{{ route('lab.reports') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-clipboard"></i></span>
                            <span class="nxl-mtext">Test Reports</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Relationships</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.patients') ? 'active' : '' }}">
                        <a href="{{ route('lab.patients') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">Patients</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.doctors') ? 'active' : '' }}">
                        <a href="{{ route('lab.doctors') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-user-check"></i></span>
                            <span class="nxl-mtext">Referring Doctors</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.agents') ? 'active' : '' }}">
                        <a href="{{ route('lab.agents') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                            <span class="nxl-mtext">Referral Agents</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Network</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.collection.centers') ? 'active' : '' }}">
                        <a href="{{ route('lab.collection.centers') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-map"></i></span>
                            <span class="nxl-mtext">Collection Centers</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Finance</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.settlements') ? 'active' : '' }}">
                        <a href="{{ route('lab.settlements') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-dollar-sign"></i></span>
                            <span class="nxl-mtext">Settlements</span>
                        </a>
                    </li>

                    <li class="nxl-item nxl-caption">
                        <label>Account</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('lab.profile') ? 'active' : '' }}">
                        <a href="{{ route('lab.profile') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">My Profile</span>
                        </a>
                    </li>
                    @can('view settings')
                    <li class="nxl-item {{ request()->routeIs('lab.settings') ? 'active' : '' }}">
                        <a href="{{ route('lab.settings') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-settings"></i></span>
                            <span class="nxl-mtext">Lab Settings</span>
                        </a>
                    </li>
                    @endcan
                    <li class="nxl-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-branch" class="d-none">
                            @csrf
                        </form>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form-branch').submit();" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-log-out text-danger"></i></span>
                            <span class="nxl-mtext text-danger">Logout</span>
                        </a>
                    </li>
                @endrole

                @if(!auth()->user()->patientProfile && (auth()->user()->hasAnyRole(['doctor', 'agent', 'collection_center']) || auth()->user()->collection_center_id || auth()->user()->doctorProfile || auth()->user()->agentProfile))
                    <li class="nxl-item nxl-caption">
                        <label>Partner Portal</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('partner.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('partner.dashboard') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('partner.patients') ? 'active' : '' }}">
                        <a href="{{ route('partner.patients') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">My Referrals</span>
                        </a>
                    </li>
                    
                    @can('create pos')
                    <li class="nxl-item {{ request()->routeIs('lab.pos') ? 'active' : '' }}">
                        <a href="{{ route('lab.pos') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                            <span class="nxl-mtext">Create Bill (POS)</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('view invoices')
                    @php
                        $isCC = auth()->user()->collection_center_id || auth()->user()->hasRole('collection_center') || collect(auth()->user()->roles->pluck('name'))->contains(fn($r) => str_contains(strtolower($r), 'collection'));
                    @endphp
                    @if(!$isCC)
                    <li class="nxl-item {{ request()->routeIs('lab.invoices') ? 'active' : '' }}">
                        <a href="{{ route('lab.invoices') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-file-text"></i></span>
                            <span class="nxl-mtext">Invoice History</span>
                        </a>
                    </li>
                    @endif
                    @endcan

                    @can('view reports')
                    @php
                        $isCC = auth()->user()->collection_center_id || auth()->user()->hasRole('collection_center') || collect(auth()->user()->roles->pluck('name'))->contains(fn($r) => str_contains(strtolower($r), 'collection'));
                    @endphp
                    @if(!$isCC)
                    <li class="nxl-item {{ request()->routeIs('lab.reports') ? 'active' : '' }}">
                        <a href="{{ route('lab.reports') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-clipboard"></i></span>
                            <span class="nxl-mtext">Test Reports</span>
                        </a>
                    </li>
                    @endif
                    @endcan

                    <li class="nxl-item {{ request()->routeIs('partner.settlements') ? 'active' : '' }}">
                        <a href="{{ route('partner.settlements') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-dollar-sign"></i></span>
                            <span class="nxl-mtext">Settlement History</span>
                        </a>
                    </li>

                    @php
                        $isCC = auth()->user()->collection_center_id || auth()->user()->hasRole('collection_center') || collect(auth()->user()->roles->pluck('name'))->contains(fn($r) => str_contains(strtolower($r), 'collection'));
                    @endphp
                    @if(!$isCC)
                    <li class="nxl-item {{ request()->routeIs('partner.invoices') ? 'active' : '' }}">
                        <a href="{{ route('partner.invoices') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-file-text"></i></span>
                            <span class="nxl-mtext">Invoice History</span>
                        </a>
                    </li>
                    @endif

                    @php
                        $isCC = auth()->user()->collection_center_id || auth()->user()->hasRole('collection_center') || collect(auth()->user()->roles->pluck('name'))->contains(fn($r) => str_contains(strtolower($r), 'collection'));
                    @endphp
                    @if($isCC)
                    <li class="nxl-item nxl-caption">
                        <label>Referral Network</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('partner.doctors') ? 'active' : '' }}">
                        <a href="{{ route('partner.doctors') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-user-check"></i></span>
                            <span class="nxl-mtext">Manage Doctors</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('partner.agents') ? 'active' : '' }}">
                        <a href="{{ route('partner.agents') }}" class="nxl-link" wire:navigate>
                            <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                            <span class="nxl-mtext">Manage Agents</span>
                        </a>
                    </li>
                    @endif

                    <li class="nxl-item nxl-caption">
                        <label>Account Settings</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('partner.profile') ? 'active' : '' }}">
                        <a href="{{ route('partner.profile') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">My Profile</span>
                        </a>
                    </li>
                    @if(config('features.support_tickets', true))
                    <li class="nxl-item {{ request()->routeIs('partner.support') ? 'active' : '' }}">
                        <a href="{{ route('partner.support') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-help-circle"></i></span>
                            <span class="nxl-mtext">Help & Support</span>
                        </a>
                    </li>
                    @endif
                    <li class="nxl-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar" class="d-none">
                            @csrf
                        </form>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-log-out text-danger"></i></span>
                            <span class="nxl-mtext text-danger">Logout</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->patientProfile)
                    <li class="nxl-item nxl-caption">
                        <label>Patient Portal</label>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('portal.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('portal.dashboard') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Overview</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('portal.reports') ? 'active' : '' }}">
                        <a href="{{ route('portal.reports') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-clipboard"></i></span>
                            <span class="nxl-mtext">My Test Reports</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('portal.membership') ? 'active' : '' }}">
                        <a href="{{ route('portal.membership') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-award"></i></span>
                            <span class="nxl-mtext">My Membership</span>
                        </a>
                    </li>
                    <li class="nxl-item {{ request()->routeIs('portal.profile') ? 'active' : '' }}">
                        <a href="{{ route('portal.profile') }}" wire:navigate class="nxl-link">
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">My Profile</span>
                        </a>
                    </li>
                    <li class="nxl-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-patient" class="d-none">
                            @csrf
                        </form>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form-patient').submit();" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-log-out text-danger"></i></span>
                            <span class="nxl-mtext text-danger">Logout</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
    <style>
        /* Increase main menu font size */
        .nxl-navigation .nxl-navbar .nxl-item > .nxl-link .nxl-mtext {
            font-size: 14.5px !important;
            font-weight: 600 !important;
        }
        
        /* Caption/Label styling */
        .nxl-navigation .nxl-navbar .nxl-caption label {
            font-size: 10px !important;
            letter-spacing: 1px !important;
            font-weight: 700 !important;
            color: #64748b !important;
        }
    </style>
</nav>