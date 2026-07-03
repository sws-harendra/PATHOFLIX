@php
    $heroTitle = \App\Models\SiteSetting::get('hero_title', 'Intelligence for Modern Laboratories');
    $heroSubtitle = \App\Models\SiteSetting::get('hero_subtitle', 'Streamline your diagnostic workflow from collection to automated reporting with our secure cloud ecosystem.');
    $heroCta = \App\Models\SiteSetting::get('hero_cta_text', 'Start Free Trial');
    $heroImage = \App\Models\SiteSetting::get('hero_image');
    $features = \App\Models\LandingFeature::active()->get();
    $testimonials = \App\Models\LandingTestimonial::active()->get();
    $faqs = \App\Models\LandingFaq::active()->take(5)->get();
    $plans = \App\Models\Plan::landing()->get();
@endphp

<x-landing-layout>
    <x-slot name="title">{{ \App\Models\SiteSetting::get('meta_title', 'SWS - Precision Diagnostics') }}</x-slot>

    <div class="text-[#0f2d2a] font-sans relative">

        <!-- Hero Section -->
        <section class="relative min-h-[100svh] flex items-center pt-32 pb-16 overflow-hidden">
            <!-- Background clinical image overlay -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&q=80&w=1600" alt="Clinical Micro Backdrop" class="w-full h-full object-cover opacity-[0.03] animate-scale-bg">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="grid lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 reveal">
                        <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-brand-50/60 border border-brand-200/50 shadow-sm mb-8">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brand-500"></span>
                            </span>
                            <span class="text-xs font-bold text-brand-800 tracking-wide">Next-Gen LIS Platform 2.0</span>
                        </div>

                        @php
                            $words = explode(' ', $heroTitle);
                            $wordCount = count($words);
                            if ($wordCount >= 2) {
                                $mainPart = implode(' ', array_slice($words, 0, $wordCount - 2));
                                $accentPart1 = $words[$wordCount - 2];
                                $accentPart2 = $words[$wordCount - 1];
                                $formattedTitle = e($mainPart) . ' <span class="text-brand-600 italic font-serif">' . e($accentPart1) . '</span>' .
                                    ' <span class="text-brand-600 italic font-serif pr-4 relative inline-block">' . e($accentPart2) . 
                                    '<svg class="absolute w-full h-3.5 -bottom-2.5 left-0 text-brand-500/40 pointer-events-none" viewBox="0 0 200 9" fill="none" preserveAspectRatio="none"><path d="M2.00018 7.37072C50.2989 -0.669527 122.956 -1.68412 198.057 7.37072" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-dasharray="200" stroke-dashoffset="200" class="animate-draw-line" /></svg></span>';
                            } else {
                                $formattedTitle = '<span class="text-brand-600 italic font-serif pr-4 relative inline-block">' . e($heroTitle) . 
                                    '<svg class="absolute w-full h-3.5 -bottom-2.5 left-0 text-brand-500/40 pointer-events-none" viewBox="0 0 200 9" fill="none" preserveAspectRatio="none"><path d="M2.00018 7.37072C50.2989 -0.669527 122.956 -1.68412 198.057 7.37072" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-dasharray="200" stroke-dashoffset="200" class="animate-draw-line" /></svg></span>';
                            }
                        @endphp

                        <h1 class="font-serif text-5xl sm:text-6xl md:text-7xl lg:text-8xl leading-[0.95] tracking-tight mb-8 text-[#0f2d2a]">
                            {!! $formattedTitle !!}
                        </h1>

                        <p class="text-lg md:text-xl text-[#0f2d2a]/80 leading-relaxed mb-10 max-w-xl font-medium">
                            {{ $heroSubtitle }}
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#contact" class="inline-flex justify-center items-center gap-2 px-10 py-5 bg-[#0c5f56] text-white hover:bg-[#094d45] rounded-full font-bold text-md shadow-xl shadow-teal-900/10 hover:shadow-teal-900/25 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                                {{ $heroCta }} <i class="feather-arrow-right"></i>
                            </a>
                            <!-- <a href="{{ route('portal.login') }}" class="inline-flex justify-center items-center gap-2 px-10 py-5 bg-white text-[#0f2d2a] hover:bg-brand-50 rounded-full font-bold text-md border border-[#0c5f56]/15 shadow-sm hover:shadow-md transition-all duration-300 active:scale-95">
                                <i class="feather-download-cloud text-brand-600"></i> Download Report
                            </a> -->
                        </div>
                    </div>

                    <div class="lg:col-span-5 reveal delay-2 relative pt-8 lg:pt-0">
                        <!-- Floating widgets -->
                        <!-- Widget 1: LIS Integrity -->
                        <div class="absolute -top-6 -right-4 bg-white/90 backdrop-blur-md p-4 rounded-2xl border border-emerald-500/20 shadow-xl animate-float-slow z-20 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-250/50 flex items-center justify-center text-emerald-700">
                                <i class="feather-shield text-lg"></i>
                            </div>
                            <div>
                                <div class="text-[9px] font-bold text-[#0c5f56] uppercase tracking-wider">LIS Integrity</div>
                                <div class="text-[#0f2d2a] font-black text-sm">99.98% Accuracy</div>
                            </div>
                        </div>

                        <!-- Widget 2: WhatsApp sent -->
                        <div class="absolute -bottom-6 -left-4 bg-white/90 backdrop-blur-md p-4 rounded-2xl border border-green-500/20 shadow-xl animate-float-fast z-20 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-green-50 border border-green-250/50 flex items-center justify-center text-green-700">
                                <i class="feather-message-circle text-lg"></i>
                            </div>
                            <div>
                                <div class="text-[9px] font-bold text-green-700 uppercase tracking-wider">WhatsApp Delivery</div>
                                <div class="text-[#0f2d2a] font-black text-xs">Report S-7922 Sent</div>
                            </div>
                        </div>

                        <!-- Widget 3: Active machines -->
                        <div class="absolute bottom-12 -right-6 bg-[#0b1f1d] p-3.5 rounded-2xl border border-teal-500/25 shadow-xl animate-float-slow z-20 flex items-center gap-3 text-white">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            <div class="text-[10px] font-bold tracking-wide">3 Analyzers Linked</div>
                        </div>

                        <!-- Main Dashboard Container with Gradient Border -->
                        <div class="absolute -inset-4 bg-gradient-to-tr from-brand-300/20 to-emerald-300/20 blur-3xl rounded-[3.5rem] opacity-75"></div>
                        
                        <div class="relative w-full bg-gradient-to-tr from-brand-500/20 via-emerald-500/20 to-indigo-500/20 p-[1.5px] rounded-[2.5rem] shadow-2xl">
                            <div class="w-full bg-[#f4f7f6]/95 backdrop-blur-2xl rounded-[2.5rem] p-4 overflow-hidden">
                                <!-- Window header -->
                                <div class="flex items-center justify-between border-b border-[#0c5f56]/10 pb-3.5 mb-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-3 h-3 rounded-full bg-rose-500/80"></span>
                                        <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                                        <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                                    </div>
                                    <div class="text-[10px] font-bold text-[#0c5f56] uppercase tracking-wider font-mono">pathoflix-lis-node</div>
                                    <div class="w-4"></div>
                                </div>

                                <!-- Dashboard Stats -->
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="bg-white/85 p-3 rounded-xl border border-[#0c5f56]/5 shadow-sm">
                                        <span class="text-[9px] font-bold text-[#0c5f56]/80 uppercase tracking-widest block">Active Queue</span>
                                        <div class="flex items-baseline gap-1.5 mt-0.5">
                                            <span class="text-xl font-black text-[#0f2d2a]">142</span>
                                            <span class="text-[9px] font-bold text-emerald-600 bg-emerald-100/50 px-1.5 py-0.5 rounded-md animate-pulse">Live</span>
                                        </div>
                                    </div>
                                    <div class="bg-white/85 p-3 rounded-xl border border-[#0c5f56]/5 shadow-sm">
                                        <span class="text-[9px] font-bold text-[#0c5f56]/80 uppercase tracking-widest block">B2B Settlements</span>
                                        <div class="flex items-baseline gap-1.5 mt-0.5">
                                            <span class="text-xl font-black text-[#0f2d2a]">₹1.4M</span>
                                            <span class="text-[9px] font-bold text-indigo-600 bg-indigo-100/50 px-1.5 py-0.5 rounded-md">Paid</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Live queue list -->
                                <div class="space-y-2">
                                    <span class="text-[9px] font-bold text-[#0c5f56] uppercase tracking-widest block mb-2 px-1">Live Analyzer Streams</span>
                                    
                                    <div class="bg-white/95 p-3 rounded-xl border border-[#0c5f56]/5 flex items-center justify-between shadow-sm hover:border-[#0c5f56]/20 transition-colors duration-300">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600"><i class="feather-user"></i></div>
                                            <div>
                                                <div class="text-xs font-bold text-[#0f2d2a]">Aria Chen</div>
                                                <div class="text-[9px] font-bold text-[#0c5f56]/80 font-mono">Sample: S-7922</div>
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-emerald-650 bg-emerald-100/60 border border-emerald-250/55 px-2 py-0.5 rounded-full uppercase tracking-wider">Verified</span>
                                    </div>

                                    <div class="bg-white/95 p-3 rounded-xl border border-[#0c5f56]/5 flex items-center justify-between shadow-sm hover:border-brand-500/20 transition-colors duration-300">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-brand-50 border border-brand-100 flex items-center justify-center text-brand-600"><i class="feather-refresh-cw animate-spin text-xs"></i></div>
                                            <div>
                                                <div class="text-xs font-bold text-[#0f2d2a]">Marcus V.</div>
                                                <div class="text-[9px] font-bold text-[#0c5f56]/80 font-mono">CBC | Sysmex XT</div>
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-indigo-650 bg-indigo-100/60 border border-indigo-250/55 px-2 py-0.5 rounded-full uppercase tracking-wider animate-pulse">Syncing</span>
                                    </div>

                                    <div class="bg-white/95 p-3 rounded-xl border border-[#0c5f56]/5 flex items-center justify-between shadow-sm hover:border-amber-500/20 transition-colors duration-300">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600"><i class="feather-alert-circle"></i></div>
                                            <div>
                                                <div class="text-xs font-bold text-[#0f2d2a]">Priya Sharma</div>
                                                <div class="text-[9px] font-bold text-[#0c5f56]/80 font-mono">T3/T4 | Erba XL</div>
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-amber-650 bg-amber-100/60 border border-amber-250/55 px-2 py-0.5 rounded-full uppercase tracking-wider">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust Stats Strip -->
        <section class="py-12 border-y border-[#0c5f56]/10 bg-transparent relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <p class="text-xs font-bold text-[#0c5f56] uppercase tracking-widest mb-6">Powering 500+ Diagnostic Centers</p>
                <div class="flex flex-wrap justify-center gap-x-16 gap-y-6 opacity-75 grayscale hover:grayscale-0 transition-all duration-500">
                    @foreach(['METROLAB', 'QUANTUM DIAG', 'COREPATH', 'APEXVUE', 'LIFEBLOOM'] as $logo)
                        <span class="text-2xl font-black font-display text-[#0f2d2a] tracking-tighter">{{ $logo }}</span>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-transparent">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach([
                        ['val' => '10M+', 'label' => 'Reports Generated'],
                        ['val' => '99.9%', 'label' => 'System Uptime'],
                        ['val' => '500+', 'label' => 'Active Labs'],
                        ['val' => '0', 'label' => 'Data Breaches'],
                    ] as $stat)
                        <div class="text-center reveal">
                            <div class="text-4xl md:text-5xl font-black text-[#0f2d2a] mb-2 font-display transition-transform hover:scale-105 duration-300 cursor-default">{{ $stat['val'] }}</div>
                            <div class="text-xs font-bold text-[#0c5f56] uppercase tracking-wider">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Problem Solver Block -->
        <section class="py-24 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="bg-white/20 backdrop-blur-md rounded-[3rem] p-10 md:p-16 border border-[#0c5f56]/10 shadow-lg relative overflow-hidden">
                    <div class="grid lg:grid-cols-12 gap-16 items-center relative z-10">
                        <div class="lg:col-span-6">
                            <h2 class="text-4xl md:text-5xl font-serif leading-tight text-[#0f2d2a] mb-6">
                                Tired of <span class="text-[#0f2d2a]/50 line-through">Paper Friction?</span>
                            </h2>
                            <p class="text-md md:text-lg text-[#0f2d2a]/80 leading-relaxed font-semibold mb-8">
                                Legacy systems and manual entries lead to lost samples, delayed reports, and frustrated partners. We fix this by automating clinical logic.
                            </p>
                        </div>
                        <div class="lg:col-span-6 space-y-4">
                            @foreach([
                                ['old' => 'Manual Data Entry', 'new' => 'Auto-synced Machine Results'],
                                ['old' => 'Delayed B2B Settlements', 'new' => 'Real-time Partner Payouts'],
                                ['old' => 'No Patient Tracking', 'new' => 'Automated WhatsApp Tracking'],
                            ] as $item)
                                <div class="flex items-center gap-4 bg-white/75 backdrop-blur-sm p-5 rounded-2xl border border-[#0c5f56]/5 shadow-sm transition-all duration-350 hover:border-[#0c5f56]/20">
                                    <div class="flex-1 text-xs md:text-sm text-[#0f2d2a]/50 line-through font-medium">{{ $item['old'] }}</div>
                                    <i class="feather-arrow-right text-brand-600"></i>
                                    <div class="flex-1 text-xs md:text-sm text-emerald-700 font-bold">{{ $item['new'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-transparent border-y border-[#0c5f56]/5 relative overflow-hidden" id="features">
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                    <span class="text-xs font-bold text-brand-600 uppercase tracking-widest mb-3 block">Operating System</span>
                    <h2 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-[#0f2d2a] mb-4">
                        Everything your lab <span class="text-brand-600 italic">needs.</span>
                    </h2>
                    <p class="text-md md:text-lg text-[#0f2d2a]/80 font-semibold">A comprehensive LIS platform to run your diagnostic business.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 auto-rows-fr">
                    @foreach($features->take(6) as $i => $feature)
                        @php $isLarge = ($i === 0 || $i === 3); @endphp
                        <div class="reveal delay-{{ $i + 1 }} group bg-white/75 backdrop-blur-sm border border-[#0c5f56]/10 p-8 rounded-[2.2rem] hover:border-brand-500/30 hover:shadow-xl transition-all duration-500 hover:-translate-y-1 {{ $isLarge ? 'md:col-span-2' : '' }}">
                            <div class="w-12 h-12 bg-brand-50/80 group-hover:bg-[#0c5f56] rounded-2xl flex items-center justify-center text-brand-700 group-hover:text-white mb-6 transition-all duration-350 border border-brand-200/20 group-hover:scale-110 group-hover:rotate-6">
                                <i class="{{ $feature->icon }} text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[#0f2d2a] mb-3">{{ $feature->title }}</h3>
                            <p class="text-sm text-[#0f2d2a]/80 leading-relaxed font-semibold mb-auto">{{ $feature->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Deep Dives Features -->
        @php
            $deepDives = [
                ['title' => 'Smart Machine Interfacing', 'desc' => 'Connect Cell Counters, Biochemistry analyzers directly to the cloud. Zero manual typing. Results sync instantly.', 'img' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&q=80&w=1200'],
                ['title' => 'Automated Smart Reporting', 'desc' => 'Generate beautiful, QR-coded PDF reports. Auto-highlight abnormal values based on patient age and gender.', 'img' => 'https://images.unsplash.com/photo-1584432810601-6c7f27d2362b?auto=format&fit=crop&q=80&w=1200'],
                ['title' => 'B2B Franchise Portal', 'desc' => 'Give collection centers a dedicated dashboard. Track wallet balances and sample statuses in real-time.', 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1200'],
                ['title' => 'Reagent & Inventory Tracking', 'desc' => 'Never run out of essential kits. Predictive alerts tell you exactly when to reorder.', 'img' => 'https://images.unsplash.com/photo-1583324113626-70df0f4deaab?auto=format&fit=crop&q=80&w=1200'],
            ];
        @endphp

        @foreach($deepDives as $index => $dive)
            <section class="py-24 border-b border-[#0c5f56]/10 relative overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 relative z-10">
                    <div class="grid lg:grid-cols-12 gap-16 items-center">
                        <div class="lg:col-span-6 {{ $index % 2 == 1 ? 'lg:order-2' : '' }} reveal">
                            <span class="text-brand-600 text-xs font-bold tracking-widest uppercase mb-2 block">Feature {{ $index + 1 }}</span>
                            <h3 class="text-3xl md:text-4xl font-serif text-[#0f2d2a] mb-6 leading-tight">
                                {{ $dive['title'] }}
                            </h3>
                            <p class="text-md md:text-lg text-[#0f2d2a]/80 leading-relaxed font-semibold mb-8">
                                {{ $dive['desc'] }}
                            </p>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3 text-sm font-semibold text-[#0f2d2a]/95">
                                    <span class="w-6 h-6 rounded-full bg-brand-50 border border-brand-200/50 flex items-center justify-center text-brand-600">
                                        <i class="feather-check text-xs"></i>
                                    </span>
                                    Cloud Synced Real-time
                                </li>
                                <li class="flex items-center gap-3 text-sm font-semibold text-[#0f2d2a]/95">
                                    <span class="w-6 h-6 rounded-full bg-brand-50 border border-brand-200/50 flex items-center justify-center text-brand-600">
                                        <i class="feather-check text-xs"></i>
                                    </span>
                                    Instant Dashboard Alerts
                                </li>
                            </ul>
                        </div>
                        <div class="lg:col-span-6 relative {{ $index % 2 == 1 ? 'lg:order-1' : '' }} reveal delay-2">
                            <div class="absolute -inset-4 bg-gradient-to-tr from-brand-300/10 to-teal-300/10 blur-2xl rounded-3xl opacity-60"></div>
                            
                            <div class="bg-gradient-to-tr from-brand-500/15 via-emerald-500/15 to-indigo-500/15 p-[1.5px] rounded-3xl shadow-2xl">
                                <div class="aspect-video bg-white/75 backdrop-blur-xl rounded-3xl p-2">
                                    <img src="{{ $dive['img'] }}" alt="{{ $dive['title'] }} Mockup" class="w-full h-full object-cover rounded-2xl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        <!-- Process Workflow Steps -->
        <section class="py-24 bg-transparent relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <span class="text-xs font-bold text-[#0c5f56] uppercase tracking-widest mb-3 block">Simple Steps</span>
                <h2 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-[#0f2d2a] mb-16">Four Steps to Automation</h2>
                <div class="grid md:grid-cols-4 gap-8">
                    @foreach(['Register Patient', 'Process Sample', 'Verify Results', 'Auto-Deliver WhatsApp'] as $i => $step)
                        <div class="relative z-10 bg-white/80 backdrop-blur-sm p-8 rounded-3xl border border-[#0c5f56]/10 text-center shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-12 h-12 mx-auto bg-brand-50 border border-brand-200 text-brand-700 rounded-full flex items-center justify-center font-bold text-lg mb-6 transition-transform hover:scale-110 duration-300">{{ $i + 1 }}</div>
                            <h5 class="font-bold text-[#0f2d2a]">{{ $step }}</h5>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Integrations Strip -->
        <section class="py-20 border-b border-[#0c5f56]/10 bg-transparent">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-2xl font-bold text-[#0f2d2a] mb-10 font-display">Seamlessly Connects With</h2>
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach(['WhatsApp API', 'Razorpay', 'Stripe', 'Sysmex Analyzers', 'Erba Analyzers', 'AWS Cloud'] as $tech)
                        <div class="px-6 py-3 bg-white/80 backdrop-blur-sm rounded-full border border-[#0c5f56]/10 text-xs md:text-sm font-bold text-[#0f2d2a] shadow-sm hover:border-brand-500/30 transition-all duration-300 hover:-translate-y-0.5 cursor-default">{{ $tech }}</div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Security Block -->
        <section class="py-20 bg-transparent border-b border-[#0c5f56]/15">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div class="p-8 bg-white/80 backdrop-blur-sm rounded-[2.2rem] border border-[#0c5f56]/10 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <i class="feather-lock text-3xl text-brand-600 mb-4 block group-hover:scale-110 transition-transform"></i>
                        <h4 class="text-lg font-bold text-[#0f2d2a] mb-2 font-display">AES-256 Encryption</h4>
                        <p class="text-sm text-[#0f2d2a]/85 font-semibold">Bank-grade security for patient data.</p>
                    </div>
                    <div class="p-8 bg-white/80 backdrop-blur-sm rounded-[2.2rem] border border-[#0c5f56]/10 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <i class="feather-shield text-3xl text-brand-600 mb-4 block group-hover:scale-110 transition-transform"></i>
                        <h4 class="text-lg font-bold text-[#0f2d2a] mb-2 font-display">HIPAA Ready</h4>
                        <p class="text-sm text-[#0f2d2a]/85 font-semibold">Built for healthcare privacy standards.</p>
                    </div>
                    <div class="p-8 bg-white/80 backdrop-blur-sm rounded-[2.2rem] border border-[#0c5f56]/10 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <i class="feather-server text-3xl text-brand-600 mb-4 block group-hover:scale-110 transition-transform"></i>
                        <h4 class="text-lg font-bold text-[#0f2d2a] mb-2 font-display">Automated Backups</h4>
                        <p class="text-sm text-[#0f2d2a]/85 font-semibold">Hourly cloud backups ensure zero data loss.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        @if($testimonials->count())
        <section class="py-24 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <h2 class="text-center font-serif text-4xl sm:text-5xl lg:text-6xl text-[#0f2d2a] mb-16">Trusted by Professionals</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($testimonials->take(3) as $testimonial)
                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2.2rem] border border-[#0c5f56]/10 shadow-sm flex flex-col hover:border-brand-500/30 transition-all duration-300 hover:-translate-y-1">
                            <p class="text-[#0f2d2a]/95 italic mb-8 leading-relaxed flex-1 font-semibold">"{{ $testimonial->quote }}"</p>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-brand-50 border border-brand-200 text-brand-850 flex items-center justify-center font-bold">
                                    {{ substr($testimonial->author_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-[#0f2d2a] text-sm">{{ $testimonial->author_name }}</p>
                                    <p class="text-xs text-[#0c5f56]/80 font-bold uppercase tracking-wider">{{ $testimonial->author_role }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Pricing Plans -->
        @if($plans->count())
        <section class="py-24 bg-transparent border-y border-[#0c5f56]/10 relative overflow-hidden" id="pricing">
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="text-center mb-16 max-w-2xl mx-auto">
                    <span class="text-xs font-bold text-[#0c5f56] uppercase tracking-widest mb-3 block">Simple Options</span>
                    <h2 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-[#0f2d2a] mb-4">Transparent Pricing</h2>
                    <p class="text-md md:text-lg text-[#0f2d2a]/80 font-semibold">Simple plans designed to scale with your laboratory's growth.</p>
                </div>
                <div class="grid lg:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
                    @foreach($plans as $plan)
                        @php $isPopular = $plan->landing_badge !== null; @endphp
                        <div class="bg-white/80 backdrop-blur-xs border {{ $isPopular ? 'border-[#0c5f56] shadow-xl shadow-teal-900/10' : 'border-[#0c5f56]/10 shadow-sm' }} rounded-[2.2rem] p-8 flex flex-col relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
                            @if($isPopular)
                                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-brand-600 to-emerald-600"></div>
                                <div class="absolute top-6 right-6 bg-brand-50 border border-brand-200 text-brand-850 text-xs font-bold px-3.5 py-1 rounded-full animate-pulse-soft">
                                    {{ $plan->landing_badge }}
                                </div>
                            @endif

                            <div class="mb-8">
                                <h5 class="text-xs font-bold uppercase tracking-widest mb-4 {{ $isPopular ? 'text-brand-700' : 'text-[#0c5f56]/80' }}">{{ $plan->name }}</h5>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-5xl font-black font-display text-[#0f2d2a]">
                                        @if($plan->price == 0) Free @else ₹{{ number_format($plan->price) }} @endif
                                    </span>
                                    @if($plan->price > 0)<span class="text-xs font-bold text-[#0c5f56]/80 uppercase tracking-widest">/month</span>@endif
                                </div>
                            </div>

                            @if($plan->landing_features)
                                <ul class="space-y-4 mb-8 flex-1">
                                    @foreach($plan->landing_features as $feat)
                                        <li class="flex items-start gap-3 text-sm text-[#0f2d2a]/95 font-semibold">
                                            <div class="mt-0.5 w-5 h-5 rounded-full bg-brand-50 border border-brand-200 text-brand-600 flex items-center justify-center shrink-0">
                                                <i class="feather-check text-[10px] stroke-[3]"></i>
                                            </div>
                                            {{ $feat }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <a href="#contact" class="block w-full py-4 text-center rounded-full font-bold text-sm transition-all duration-300 {{ $isPopular ? 'bg-[#0c5f56] text-white shadow-lg hover:bg-[#094d45]' : 'bg-brand-50 text-brand-850 border border-brand-200 hover:bg-brand-100' }} hover:-translate-y-0.5 active:scale-95">
                                {{ $plan->landing_cta_text ?? 'Contact Us' }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- FAQs Section -->
        @if($faqs->count())
        <section class="py-24 bg-transparent">
            <div class="max-w-3xl mx-auto px-4">
                <span class="text-xs font-bold text-[#0c5f56] uppercase tracking-widest mb-3 block text-center">Got Questions?</span>
                <h2 class="text-center font-serif text-4xl sm:text-5xl lg:text-6xl text-[#0f2d2a] mb-12">FAQs</h2>
                <div class="space-y-4" x-data="{ active: null }">
                    @foreach($faqs as $faq)
                        <div class="reveal bg-white/80 backdrop-blur-sm rounded-[1.8rem] border border-[#0c5f56]/10 overflow-hidden transition-all duration-300 hover:border-brand-500/20">
                            <button @click="active = active === {{ $faq->id }} ? null : {{ $faq->id }}" class="w-full flex justify-between p-6 text-left focus:outline-none">
                                <span class="font-bold text-[#0f2d2a] pr-4">{{ $faq->question }}</span>
                                <div class="w-8 h-8 rounded-full bg-brand-50/50 border border-brand-200/50 flex items-center justify-center shrink-0 transition-transform duration-300" :class="active === {{ $faq->id }} ? 'rotate-180 bg-brand-50 text-brand-600' : 'text-zinc-400'">
                                    <i class="feather-chevron-down text-sm"></i>
                                </div>
                            </button>
                            <div x-show="active === {{ $faq->id }}" x-collapse>
                                <div class="px-6 pb-6 text-sm text-[#0f2d2a]/80 leading-relaxed font-semibold border-t border-[#0c5f56]/5 pt-4">{{ $faq->answer }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Contact Form -->
        <section class="py-24 bg-transparent relative overflow-hidden" id="contact">
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="bg-white/80 backdrop-blur-xl rounded-[3rem] border border-[#0c5f56]/15 p-8 md:p-12 shadow-2xl">
                    <div class="grid lg:grid-cols-12 gap-16">
                        <div class="lg:col-span-5 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-brand-600 uppercase tracking-widest mb-3 block">Get In Touch</span>
                                <h2 class="text-4xl font-serif text-[#0f2d2a] mb-6">Let's talk about your lab.</h2>
                                <p class="text-[#0f2d2a]/80 mb-10 leading-relaxed font-semibold">Whether you process 50 or 5000 samples a day, we have a solution tailored for you. Drop us a line and our LIS experts will get back to you.</p>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-brand-600 border border-[#0c5f56]/10 shadow-sm"><i class="feather-mail"></i></div>
                                    <div>
                                        <p class="text-xs font-bold text-[#0c5f56]/80 uppercase tracking-wider">Email Us</p>
                                        <p class="text-sm text-[#0f2d2a] font-bold">support@zytrixon.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-brand-600 border border-[#0c5f56]/10 shadow-sm"><i class="feather-phone"></i></div>
                                    <div>
                                        <p class="text-xs font-bold text-[#0c5f56]/80 uppercase tracking-wider">Call Us</p>
                                        <p class="text-sm text-[#0f2d2a] font-bold">+91 98765 43210</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-7 bg-white/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-[#0c5f56]/10 shadow-inner">
                            <form action="{{ route('contact.submit') ?? '#' }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-[#0c5f56]/80 uppercase tracking-wider mb-2">First Name</label>
                                        <input type="text" name="first_name" class="w-full bg-[#f4f7f6] border border-[#0c5f56]/15 rounded-2xl px-4 py-3.5 text-zinc-900 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-semibold text-sm text-[#0f2d2a]" placeholder="Rahul" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#0c5f56]/80 uppercase tracking-wider mb-2">Last Name</label>
                                        <input type="text" name="last_name" class="w-full bg-[#f4f7f6] border border-[#0c5f56]/15 rounded-2xl px-4 py-3.5 text-zinc-900 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-semibold text-sm text-[#0f2d2a]" placeholder="Verma" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#0c5f56]/80 uppercase tracking-wider mb-2">Lab Name</label>
                                    <input type="text" name="lab_name" class="w-full bg-[#f4f7f6] border border-[#0c5f56]/15 rounded-2xl px-4 py-3.5 text-zinc-900 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-semibold text-sm text-[#0f2d2a]" placeholder="City Diagnostics" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#0c5f56]/80 uppercase tracking-wider mb-2">Email</label>
                                    <input type="email" name="email" class="w-full bg-[#f4f7f6] border border-[#0c5f56]/15 rounded-2xl px-4 py-3.5 text-zinc-900 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-semibold text-sm text-[#0f2d2a]" placeholder="rahul@example.com" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#0c5f56]/80 uppercase tracking-wider mb-2">Message</label>
                                    <textarea name="message" rows="4" class="w-full bg-[#f4f7f6] border border-[#0c5f56]/15 rounded-2xl px-4 py-3.5 text-zinc-900 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all resize-none font-semibold text-sm text-[#0f2d2a]" placeholder="Tell us about your requirements..." required></textarea>
                                </div>
                                <button type="submit" class="w-full py-4 bg-[#0c5f56] hover:bg-[#094d45] text-white rounded-full font-bold shadow-lg shadow-teal-900/10 transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Banner -->
        <section class="py-32 relative overflow-hidden bg-[#0c5f56]">
            <!-- Subtle background mesh -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-white/10 blur-[120px] rounded-full pointer-events-none"></div>
            </div>
            <div class="max-w-4xl mx-auto px-4 relative z-10 text-center reveal">
                <h2 class="font-serif text-5xl md:text-6xl font-extrabold text-white mb-6 tracking-tight">Ready to Modernize?</h2>
                <p class="text-xl text-teal-100 mb-12 max-w-2xl mx-auto font-medium">Join top laboratories automating their workflow, reducing errors, and scaling revenue.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#contact" class="inline-flex justify-center items-center px-10 py-5 bg-white text-[#0c5f56] rounded-full font-bold text-lg shadow-2xl transition-transform hover:-translate-y-1">
                        Get Started Today
                    </a>
                    <a href="#contact" class="inline-flex justify-center items-center px-10 py-5 bg-[#094d45] hover:bg-[#073d36] text-white rounded-full font-bold text-lg border border-teal-500/30 transition-all">
                        Request a Demo
                    </a>
                </div>
            </div>
        </section>

    </div>
</x-landing-layout>