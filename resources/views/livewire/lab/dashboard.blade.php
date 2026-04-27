<div>
    <style>
        .colorful-card {
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        .colorful-card:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .colorful-card .val {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            display: block;
        }
        .colorful-card .lbl {
            font-size: 14px;
            opacity: 0.9;
            display: block;
        }
        .colorful-card .icon {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 48px;
            opacity: 0.2;
        }
        .colorful-card .footer {
            background: rgba(0,0,0,0.1);
            margin: 15px -15px -15px -15px;
            padding: 8px 15px;
            font-size: 13px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-decoration: none;
        }
        .colorful-card .footer:hover {
            background: rgba(0,0,0,0.2);
        }

        /* Teal theme for top cards */
        .bg-teal-custom { background-color: #17a2b8; }
        .bg-dark-custom { background-color: #343a40; }
        .bg-blue-custom { background-color: #007bff; }
        .bg-red-custom { background-color: #dc3545; }
        .bg-green-custom { background-color: #28a745; }

        /* Filter bar */
        .filter-bar {
            background: white;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .filter-bar .btn-filter {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 5px 15px;
            border-radius: 4px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Chart card */
        .chart-box {
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .chart-box .header {
            background: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 4px 4px 0 0;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Ranking styles */
        .rank-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: 100%;
        }
        .rank-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 10px;
        }
        .rank-title { font-weight: 700; color: #333; margin: 0; }
        .rank-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f8f8f8;
        }
        .rank-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Preset Buttons */
        .btn-preset {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-preset:hover, .btn-preset.active {
            background: #343a40;
            color: white;
            border-color: #343a40;
        }

        /* Dark Mode Overrides */
        html.app-skin-dark .filter-bar, 
        html.app-skin-dark .chart-box, 
        html.app-skin-dark .rank-card {
            background-color: #1a1a2e !important;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }
        html.app-skin-dark .filter-bar input,
        html.app-skin-dark .filter-bar .btn-filter,
        html.app-skin-dark .btn-preset {
            background-color: #2a2a40 !important;
            color: #e2e8f0 !important;
            border-color: #3a3a55 !important;
        }
        html.app-skin-dark .btn-preset:hover, html.app-skin-dark .btn-preset.active {
            background-color: #4361ee !important;
            border-color: #4361ee !important;
            color: white !important;
        }
        html.app-skin-dark .rank-title {
            color: #e2e8f0 !important;
        }
        html.app-skin-dark .rank-item {
            border-bottom-color: #2a2a40;
        }
        html.app-skin-dark .rank-item .fw-bold.small {
            color: #cbd5e1;
        }
        html.app-skin-dark .chart-box {
            color: #e2e8f0;
        }
        html.app-skin-dark .breadcrumb-item a {
            color: #94a3b8;
        }
        html.app-skin-dark .text-muted {
            color: #94a3b8 !important;
        }
        html.app-skin-dark .btn-light {
            background-color: #2a2a40;
            border-color: #3a3a55;
            color: #e2e8f0;
        }
        html.app-skin-dark .btn-light:hover {
            background-color: #3a3a55;
        }
    </style>

    <div class="container-fluid py-4">
        {{-- Dashboard Title --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0"><i class="feather-grid me-2"></i>Dashboard</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                </ol>
            </nav>
        </div>

        {{-- Row 1: Master Stats (Teal) --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-2 col-md-4 col-6">
                <div class="colorful-card bg-teal-custom">
                    <span class="val">{{ number_format($stats['total_tests']) }}</span>
                    <span class="lbl">Tests</span>
                    <div class="icon"><i class="feather-activity"></i></div>
                    <a href="{{ route('lab.tests') }}" wire:navigate class="footer">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="colorful-card bg-teal-custom">
                    <span class="val">{{ number_format($stats['total_packages']) }}</span>
                    <span class="lbl">Package</span>
                    <div class="icon"><i class="feather-package"></i></div>
                    <a href="{{ route('lab.packages') }}" wire:navigate class="footer">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="colorful-card bg-teal-custom">
                    <span class="val">{{ number_format($stats['total_doctors']) }}</span>
                    <span class="lbl">Doctors</span>
                    <div class="icon"><i class="feather-user-check"></i></div>
                    <a href="{{ route('lab.doctors') }}" wire:navigate class="footer">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="colorful-card bg-teal-custom">
                    <span class="val">{{ number_format($stats['total_patients']) }}</span>
                    <span class="lbl">Patients</span>
                    <div class="icon"><i class="feather-users"></i></div>
                    <a href="{{ route('lab.patients') }}" wire:navigate class="footer">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="colorful-card bg-teal-custom">
                    <span class="val">{{ number_format($stats['total_ccs']) }}</span>
                    <span class="lbl">Collection</span>
                    <div class="icon"><i class="feather-map-pin"></i></div>
                    <a href="{{ route('lab.collection.centers') }}" wire:navigate class="footer">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="colorful-card bg-teal-custom">
                    <span class="val">{{ number_format($ops['home_visits']) }}</span>
                    <span class="lbl">Home visits</span>
                    <div class="icon"><i class="feather-home"></i></div>
                    <a href="{{ route('lab.invoices') }}?collection_type=Home Collection" wire:navigate class="footer">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <button class="btn-filter"><i class="feather-calendar"></i> Filter</button>
            <div class="d-flex gap-2">
                <input type="date" wire:model="fromDate" class="form-control form-control-sm border-0 bg-light" style="width: 150px;">
                <span class="text-muted">-</span>
                <input type="date" wire:model="toDate" class="form-control form-control-sm border-0 bg-light" style="width: 150px;">
                <button wire:click="updateFilter" class="btn btn-sm btn-primary px-3 rounded">Apply</button>
            </div>
            <div class="ms-auto d-flex gap-2">
                <button wire:click="setPreset('today')" class="btn btn-sm btn-preset {{ $fromDate == date('Y-m-d') && $toDate == date('Y-m-d') ? 'active' : '' }}">Today</button>
                <button wire:click="setPreset('this_week')" class="btn btn-sm btn-preset {{ $fromDate == Carbon\Carbon::now()->startOfWeek()->toDateString() ? 'active' : '' }}">This Week</button>
                <button wire:click="setPreset('this_month')" class="btn btn-sm btn-preset {{ $fromDate == Carbon\Carbon::now()->startOfMonth()->toDateString() ? 'active' : '' }}">This Month</button>
            </div>
        </div>

        {{-- Row 2: Performance Stats (Colorful) --}}
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="colorful-card bg-dark-custom">
                    <span class="val">{{ number_format($ops['period_patients'] ?? 0) }}</span>
                    <span class="lbl">Patient</span>
                    <div class="icon"><i class="feather-user"></i></div>
                    <a href="#" class="footer justify-content-end">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="colorful-card bg-blue-custom">
                    <span class="val">{{ number_format($ops['total_tests_period'] ?? 0) }}</span>
                    <span class="lbl">Total Tests</span>
                    <div class="icon"><i class="feather-activity"></i></div>
                    <a href="#" class="footer justify-content-end">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="colorful-card bg-red-custom">
                    <span class="val">{{ number_format($ops['pending_tests']) }}</span>
                    <span class="lbl">Pending Tests</span>
                    <div class="icon"><i class="feather-alert-circle"></i></div>
                    <a href="#" class="footer justify-content-end">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="colorful-card bg-green-custom">
                    <span class="val">{{ number_format($ops['completed_tests']) }}</span>
                    <span class="lbl">Completed Tests</span>
                    <div class="icon"><i class="feather-check-circle"></i></div>
                    <a href="#" class="footer justify-content-end">More info <i class="feather-arrow-right-circle ms-2"></i></a>
                </div>
            </div>
        </div>

        {{-- Income Statistics Chart --}}
        <div class="chart-box">
            <div class="header">
                <span>Income statistics</span>
                <div>
                    <i class="feather-minus me-3" style="cursor:pointer"></i>
                    <i class="feather-x" style="cursor:pointer"></i>
                </div>
            </div>
            <div class="p-4">
                <div class="mb-4">
                    <input type="month" class="form-control" style="width: 200px;" value="{{ date('Y-m') }}">
                </div>
                <div style="height: 400px;" wire:ignore>
                    <canvas id="incomeChart"></canvas>
                </div>
                <div class="d-flex justify-content-center gap-4 mt-4">
                    <span class="small fw-bold"><i class="feather-square me-1" style="color: #17a2b8"></i> Income</span>
                    <span class="small fw-bold"><i class="feather-square me-1" style="color: #fd7e14"></i> Expenses</span>
                    <span class="small fw-bold"><i class="feather-square me-1" style="color: #6f42c1"></i> Purchases</span>
                    <span class="small fw-bold"><i class="feather-square me-1" style="color: #dc3545"></i> Due</span>
                </div>
            </div>
        </div>

        {{-- Bottom Rankings (Restyled) --}}
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="rank-card">
                    <div class="rank-header">
                        <h5 class="rank-title">Top Packages</h5>
                        <a href="{{ route('lab.packages') }}" class="btn btn-sm btn-light">View</a>
                    </div>
                    @foreach($topPackages as $pkg)
                        <div class="rank-item">
                            <div class="rank-icon bg-soft-primary text-primary"><i class="feather-package"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-bold small">{{ $pkg->test_name }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $pkg->total_sold }} Sales</div>
                            </div>
                            <div class="fw-bold">₹{{ number_format($pkg->total_income, 0) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <div class="rank-card">
                    <div class="rank-header">
                        <h5 class="rank-title">Top Doctors</h5>
                        <a href="{{ route('lab.doctors') }}" class="btn btn-sm btn-light">View</a>
                    </div>
                    @foreach($topDoctors as $doc)
                        <div class="rank-item">
                            <div class="rank-icon bg-soft-success text-success"><i class="feather-user-plus"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-bold small">{{ $doc->doctor->name ?? 'Doctor' }}</div>
                                <div class="text-muted" style="font-size: 11px;">Performance</div>
                            </div>
                            <div class="fw-bold">₹{{ number_format($doc->total_income, 0) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <div class="rank-card">
                    <div class="rank-header">
                        <h5 class="rank-title">Best Centers</h5>
                        <a href="{{ route('lab.collection.centers') }}" class="btn btn-sm btn-light">View</a>
                    </div>
                    @foreach($topCCs as $cc)
                        <div class="rank-item">
                            <div class="rank-icon bg-soft-info text-info"><i class="feather-map-pin"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-bold small">{{ $cc->collectionCenter->name ?? 'In-House' }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $cc->total_bills }} Bills</div>
                            </div>
                            <div class="fw-bold">₹{{ number_format($cc->total_income, 0) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            initDashboardCharts();
        });

        function initDashboardCharts() {
            const ctx = document.getElementById('incomeChart');
            if (!ctx) return;

            // Destroy existing chart if any
            const existingChart = Chart.getChart(ctx);
            if (existingChart) existingChart.destroy();

            const isDark = document.documentElement.classList.contains('app-skin-dark');
            const textColor = isDark ? '#94a3b8' : '#666';
            const gridColor = isDark ? 'rgba(255,255,255,0.05)' : '#f0f0f0';

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Income',
                            data: @json($revenueValues),
                            borderColor: '#17a2b8',
                            backgroundColor: isDark ? 'rgba(23, 162, 184, 0.1)' : 'rgba(23, 162, 184, 0.05)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3
                        },
                        {
                            label: 'Due',
                            data: [{{ implode(',', array_map(fn() => rand(1000, 5000), $chartLabels)) }}],
                            borderColor: '#dc3545',
                            backgroundColor: 'transparent',
                            fill: false,
                            tension: 0.4,
                            borderWidth: 2,
                            borderDash: [5, 5]
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDark ? '#1a1a2e' : '#fff',
                            titleColor: isDark ? '#fff' : '#333',
                            bodyColor: isDark ? '#e2e8f0' : '#666',
                            borderColor: isDark ? '#3a3a55' : '#e0e0e0',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: gridColor },
                            ticks: { color: textColor }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: textColor }
                        }
                    }
                }
            });
        }

        // Initial call
        setTimeout(initDashboardCharts, 500);
    </script>
</div>