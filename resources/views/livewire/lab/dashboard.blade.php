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
        /* Ranking styles */
        /* Legacy Style Cards */
        .rank-card {
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            height: 100%;
            border: 1px solid #dee2e6;
            overflow: hidden;
        }
        .rank-header-legacy {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .rank-header-legacy.bg-green { background: #28a745; }
        .rank-header-legacy.bg-red { background: #dc3545; }
        
        .rank-title-legacy { font-weight: 600; font-size: 14px; margin: 0; }
        .rank-controls { display: flex; gap: 10px; font-size: 14px; }
        
        .card-filter-area {
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .card-date-input {
            width: 100%;
            border: 1px solid #dee2e6;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 3px;
        }

        .chart-container-donut {
            position: relative;
            height: 140px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .legend-list-legacy {
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .legend-item-legacy {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 600;
            color: #333;
        }
        .legend-square {
            width: 30px;
            height: 10px;
            border-radius: 1px;
            flex-shrink: 0;
        }

        /* Status Bars */
        .status-bar {
            border-radius: 4px;
            padding: 10px 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }
        .status-content {
            background: white;
            padding: 15px;
            text-align: center;
            color: #dc3545;
            font-size: 13px;
            border: 1px solid #dee2e6;
            border-top: none;
        }

        /* Dark Mode Overrides */
        html.app-skin-dark .rank-card,
        html.app-skin-dark .status-content {
            background-color: #1a1a2e !important;
            border-color: #2a2a40;
        }
        html.app-skin-dark .legend-item-legacy {
            color: #94a3b8 !important;
        }
        html.app-skin-dark .card-filter-area {
            border-bottom-color: #2a2a40;
        }
        html.app-skin-dark .card-date-input {
            background-color: #2a2a40;
            border-color: #3a3a55;
            color: #e2e8f0;
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

        {{-- Legacy Style Rankings --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-3">
                <div class="rank-card">
                    <div class="rank-header-legacy">
                        <span class="rank-title-legacy">Best income packages</span>
                        <div class="rank-controls"><i class="feather-minus"></i> <i class="feather-x"></i></div>
                    </div>
                    <div class="card-filter-area">
                        <input type="text" class="card-date-input" value="{{ $fromDate }} - {{ $toDate }}" readonly>
                    </div>
                    <div class="legend-list-legacy">
                        @php $colors = ['#00cfd5', '#ff6b6b', '#7e67f8', '#2ecc71', '#f39c12']; @endphp
                        @foreach($topPackages->take(5) as $index => $pkg)
                            <div class="legend-item-legacy">
                                <div class="legend-square" style="background: {{ $colors[$index % 5] }}"></div>
                                <span class="text-uppercase">{{ $pkg->test_name }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="chart-container-donut" wire:ignore>
                        <canvas id="pkgDonutChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="rank-card">
                    <div class="rank-header-legacy">
                        <span class="rank-title-legacy">Best income tests</span>
                        <div class="rank-controls"><i class="feather-minus"></i> <i class="feather-x"></i></div>
                    </div>
                    <div class="card-filter-area">
                        <input type="text" class="card-date-input" value="{{ $fromDate }} - {{ $toDate }}" readonly>
                    </div>
                    <div class="legend-list-legacy">
                        @php $colors = ['#00cfd5', '#ff6b6b', '#7e67f8', '#2ecc71', '#f39c12']; @endphp
                        @foreach($topPackages->take(5) as $index => $pkg)
                            <div class="legend-item-legacy">
                                <div class="legend-square" style="background: {{ $colors[$index % 5] }}"></div>
                                <span class="text-uppercase">{{ $pkg->test_name }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="chart-container-donut" wire:ignore>
                        <canvas id="docDonutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="rank-card">
                    <div class="rank-header-legacy">
                        <span class="rank-title-legacy">Top Collection Center</span>
                        <div class="rank-controls"><i class="feather-minus"></i> <i class="feather-x"></i></div>
                    </div>
                    <div class="card-filter-area">
                        <input type="text" class="card-date-input" value="{{ $fromDate }} - {{ $toDate }}" readonly>
                    </div>
                    <div class="legend-list-legacy">
                        @php $colors = ['#00cfd5', '#ff6b6b', '#7e67f8', '#2ecc71', '#f39c12']; @endphp
                        @foreach($topCCs->take(5) as $index => $cc)
                            <div class="legend-item-legacy">
                                <div class="legend-square" style="background: {{ $colors[$index % 5] }}"></div>
                                <span class="text-uppercase">{{ $cc->collectionCenter->name ?? 'In-House' }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="chart-container-donut" wire:ignore>
                        <canvas id="ccDonutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="rank-card">
                    <div class="rank-header-legacy">
                        <span class="rank-title-legacy">Top Refered Docter</span>
                        <div class="rank-controls"><i class="feather-minus"></i> <i class="feather-x"></i></div>
                    </div>
                    <div class="card-filter-area">
                        <input type="text" class="card-date-input" value="{{ $fromDate }} - {{ $toDate }}" readonly>
                    </div>
                    <div class="legend-list-legacy">
                        @php $colors = ['#00cfd5', '#ff6b6b', '#7e67f8', '#2ecc71', '#f39c12']; @endphp
                        @foreach($topDoctors->take(5) as $index => $doc)
                            <div class="legend-item-legacy">
                                <div class="legend-square" style="background: {{ $colors[$index % 5] }}"></div>
                                <span class="text-uppercase">{{ $doc->doctor->name ?? 'Doctor' }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="chart-container-donut" wire:ignore>
                        <canvas id="extraDonutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 4: Status Bars --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="status-bar bg-green">
                    <span><i class="feather-wifi me-2"></i> Online admins ( 0 )</span>
                    <div class="rank-controls"><i class="feather-minus"></i> <i class="feather-x"></i></div>
                </div>
                <div class="status-content">No users online</div>
            </div>
            <div class="col-md-6">
                <div class="status-bar bg-green">
                    <span>Online patients ( 0 )</span>
                    <div class="rank-controls"><i class="feather-minus"></i> <i class="feather-x"></i></div>
                </div>
                <div class="status-content">No patients online</div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="status-bar bg-red">
                    <span><i class="feather-bell me-2"></i> Today scheduled home visits ( 0 )</span>
                    <div class="rank-controls"><i class="feather-minus"></i> <i class="feather-x"></i></div>
                </div>
                <div class="status-content">No home visits scheduled</div>
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
                            borderColor: '#3b82f6',
                            backgroundColor: isDark ? 'rgba(59, 130, 246, 0.1)' : 'rgba(59, 130, 246, 0.05)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#fff',
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Due',
                            data: [{{ implode(',', array_map(fn() => rand(1000, 5000), $chartLabels)) }}],
                            borderColor: '#ef4444',
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
                            backgroundColor: isDark ? '#1e293b' : '#fff',
                            titleColor: isDark ? '#fff' : '#1e293b',
                            bodyColor: isDark ? '#94a3b8' : '#475569',
                            borderColor: isDark ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: gridColor, drawBorder: false },
                            ticks: { color: textColor, padding: 10 }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: textColor, padding: 10 }
                        }
                    }
                }
            });

            // Initialize Donut Charts
            const donutOptions = {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#fff',
                        bodyColor: isDark ? '#f8fafc' : '#1e293b',
                        padding: 12,
                        displayColors: true
                    }
                }
            };

            const donutColors = ['#00cfd5', '#ff6b6b', '#7e67f8', '#2ecc71', '#f39c12'];

            // Best income packages
            new Chart(document.getElementById('pkgDonutChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($topPackages->take(5)->pluck('test_name')),
                    datasets: [{
                        data: @json($topPackages->take(5)->pluck('total_income')),
                        backgroundColor: donutColors,
                        borderWidth: 0
                    }]
                },
                options: donutOptions
            });

            // Best income tests
            new Chart(document.getElementById('docDonutChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($topPackages->take(5)->pluck('test_name')),
                    datasets: [{
                        data: @json($topPackages->take(5)->pluck('total_income')),
                        backgroundColor: donutColors,
                        borderWidth: 0
                    }]
                },
                options: donutOptions
            });

            // Top Collection Center
            new Chart(document.getElementById('ccDonutChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($topCCs->take(5)->map(fn($c) => $c->collectionCenter->name ?? 'In-House')),
                    datasets: [{
                        data: @json($topCCs->take(5)->pluck('total_income')),
                        backgroundColor: donutColors,
                        borderWidth: 0
                    }]
                },
                options: donutOptions
            });

            // Top Refered Docter
            new Chart(document.getElementById('extraDonutChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($topDoctors->take(5)->map(fn($d) => $d->doctor->name ?? 'Doctor')),
                    datasets: [{
                        data: @json($topDoctors->take(5)->pluck('total_income')),
                        backgroundColor: donutColors,
                        borderWidth: 0
                    }]
                },
                options: donutOptions
            });
        }

        // Initial call
        setTimeout(initDashboardCharts, 500);
    </script>
</div>