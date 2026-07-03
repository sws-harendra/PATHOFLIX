@php
    $aboutTitle = \App\Models\SiteSetting::get('about_title', 'Precision in Every Diagnostic Pulse');
    $aboutDesc = \App\Models\SiteSetting::get('about_description', 'SWS Pathology emerged from a collaboration between veteran pathologists and software engineers to bridge the gap between clinical accuracy and digital efficiency.');
    $aboutImage = \App\Models\SiteSetting::get('about_image');
    $statLabs = \App\Models\SiteSetting::get('about_stat_labs', '500+');
    $statLabsLabel = \App\Models\SiteSetting::get('about_stat_labs_label', 'Labs Integrated');
    $statUptime = \App\Models\SiteSetting::get('about_stat_uptime', '99.9%');
    $statUptimeLabel = \App\Models\SiteSetting::get('about_stat_uptime_label', 'Uptime SLA');
    $statReports = \App\Models\SiteSetting::get('about_stat_reports', '1M+');
    $statReportsLabel = \App\Models\SiteSetting::get('about_stat_reports_label', 'Reports Monthly');
@endphp

<x-landing-layout>
    <x-slot name="title">About Us - {{ \App\Models\SiteSetting::get('site_name', 'SWS Pathology') }}</x-slot>

    <div class="text-[#18181b] font-sans overflow-hidden">

        <!-- Hero Section -->
        <section class="pt-32 pb-20 relative overflow-hidden bg-[#eaf0ee]/30 border-b border-[#C70000]/10">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div class="absolute top-0 left-1/2 w-[800px] h-[600px] bg-brand-400/10 blur-[150px] rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-red-400/5 blur-[150px] rounded-full translate-y-1/4"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center reveal">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-[#C70000]/10 shadow-sm text-brand-700 text-xs font-bold uppercase tracking-widest mb-8">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span> Our Story
                </span>
                
                <h1 class="font-serif text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-8 text-[#18181b] leading-[1.1]">
                    {!! str_replace(
                        ['Precision', 'Diagnostic'],
                        [
                            '<span class="text-brand-600 italic font-serif">Precision</span>',
                            '<span class="text-brand-600 italic font-serif">Diagnostic</span>'
                        ],
                        e($aboutTitle)
                    ) !!}
                </h1>
                
                <p class="text-lg md:text-xl text-[#18181b]/80 max-w-2xl mx-auto leading-relaxed font-semibold">
                    We're building the nervous system for the next generation of diagnostic medicine, making healthcare faster, safer, and smarter.
                </p>
            </div>
        </section>

        <!-- Our Experts Heritage Section -->
        <section class="py-24 bg-white/30 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-16 items-center">
                
                <div class="lg:col-span-5 reveal-left">
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-brand-100 to-red-50 blur-2xl rounded-[3.5rem] opacity-70"></div>
                        
                        <div class="relative rounded-[2.5rem] bg-white aspect-[4/5] overflow-hidden border border-[#C70000]/15 shadow-2xl p-2.5">
                            @if($aboutImage && \Illuminate\Support\Facades\Storage::exists($aboutImage))
                                <img src="{{ secure_storage_url($aboutImage) }}" class="w-full h-full object-cover rounded-3xl">
                            @else
                                <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=1200" class="w-full h-full object-cover rounded-3xl" alt="Our Medical Team">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/60 via-zinc-900/0 to-transparent"></div>
                            
                            <div class="absolute bottom-8 left-8 right-8 bg-white/90 backdrop-blur-md p-5 rounded-2xl border border-white shadow-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-brand-50 border border-brand-200/50 flex items-center justify-center text-brand-700">
                                        <i class="feather-award text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-zinc-900">Founded 2024</div>
                                        <div class="text-xs text-zinc-500 font-medium">Reimagining Pathology</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 reveal-right lg:pl-8">
                    <span class="text-xs font-bold text-[#C70000] uppercase tracking-widest mb-4 block">Heritage</span>
                    <h3 class="font-serif text-4xl md:text-5xl font-extrabold mb-8 tracking-tight text-[#18181b]">
                        Built by <span class="text-brand-600 italic font-serif">Experts</span>,<br>for Professionals.
                    </h3>
                    <p class="text-md md:text-lg text-[#18181b]/80 mb-12 leading-relaxed font-semibold">
                        {{ $aboutDesc }}
                    </p>

                    <div class="grid grid-cols-3 gap-6 pt-8 border-t border-[#C70000]/10">
                        @foreach([
                            ['value' => $statLabs, 'label' => $statLabsLabel],
                            ['value' => $statUptime, 'label' => $statUptimeLabel],
                            ['value' => $statReports, 'label' => $statReportsLabel],
                        ] as $stat)
                            <div>
                                <p class="text-4xl font-extrabold text-[#18181b] font-display mb-2">{{ $stat['value'] }}</p>
                                <p class="text-[10px] font-bold text-[#C70000] uppercase tracking-wider">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Pillars / Values -->
        <section class="py-24 bg-[#eaf0ee]/20 border-y border-[#C70000]/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 reveal">
                    <span class="text-xs font-bold text-brand-600 uppercase tracking-widest mb-3 block">Our Values</span>
                    <h3 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-[#18181b]">
                        Our Core <span class="text-brand-600 italic">Pillars</span>
                    </h3>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach([
                        ['icon' => 'feather-target', 'title' => 'Absolute Precision', 'desc' => 'Every data point is verified through multi-layer integrity checks before being transmitted to clinical reports.', 'color' => 'brand'],
                        ['icon' => 'feather-zap', 'title' => 'Deep Innovation', 'desc' => 'We continuously push the boundaries of what a Diagnostic OS can achieve with automation and smart analytics.', 'color' => 'emerald'],
                        ['icon' => 'feather-heart', 'title' => 'Human Empathy', 'desc' => 'Designed with a deep understanding of the high-pressure environment of diagnostics and patient care.', 'color' => 'teal'],
                    ] as $i => $value)
                        <div class="reveal delay-{{ $i + 1 }} group bg-white/80 backdrop-blur-sm rounded-[2.2rem] p-10 border border-[#C70000]/10 shadow-sm hover:shadow-xl hover:border-brand-500/20 transition-all duration-500 hover:-translate-y-1">
                            <div class="w-14 h-14 rounded-2xl bg-brand-50/50 border border-brand-200/50 text-brand-700 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $value['icon'] }} text-2xl"></i>
                            </div>
                            <h5 class="text-xl font-bold text-[#18181b] mb-3">{{ $value['title'] }}</h5>
                            <p class="text-sm text-[#18181b]/80 leading-relaxed font-semibold">{{ $value['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Timeline Section -->
        <section class="py-24 bg-[#0f172a] relative overflow-hidden shadow-[inset_0_4px_24px_rgba(0,0,0,0.15)] text-[#ffffff]">
            <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-20 reveal">
                    <h3 class="font-serif text-4xl sm:text-5xl text-white">The Road to <span class="text-brand-400">2026</span></h3>
                </div>
                
                <div class="relative">
                    <div class="hidden md:block absolute top-6 left-[10%] right-[10%] h-0.5 bg-gradient-to-r from-red-900 via-brand-500/50 to-red-900 z-0"></div>
                    
                    <div class="grid md:grid-cols-4 gap-12 text-center relative z-10">
                        @foreach([
                            ['date' => 'Mar 2024', 'title' => 'Platform Launch', 'desc' => 'Core LIS engine goes live'],
                            ['date' => 'Aug 2024', 'title' => '100 Lab Milestone', 'desc' => '100 diagnostic centers onboarded'],
                            ['date' => 'Feb 2025', 'title' => 'Partner Portal', 'desc' => 'Doctor & Agent referral system'],
                            ['date' => 'Current', 'title' => 'Scale Unbound', 'desc' => 'Multi-branch, multi-city expansion'],
                        ] as $i => $milestone)
                            <div class="reveal delay-{{ $i + 1 }} group">
                                <div class="w-12 h-12 mx-auto bg-red-950 border-4 border-red-900 rounded-full flex items-center justify-center mb-6 relative group-hover:scale-110 transition-transform duration-300">
                                    <div class="w-3 h-3 rounded-full bg-brand-400 shadow-[0_0_15px_rgba(99,102,241,0.5)]"></div>
                                </div>
                                <span class="text-[11px] font-bold text-brand-400 uppercase tracking-widest block mb-2">{{ $milestone['date'] }}</span>
                                <p class="font-bold text-lg text-white mb-2">{{ $milestone['title'] }}</p>
                                <p class="text-sm text-[#ffffff]/80 font-medium">{{ $milestone['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="py-32 relative overflow-hidden bg-white/30">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-brand-50/50 blur-[120px] rounded-full pointer-events-none"></div>
            
            <div class="max-w-3xl mx-auto px-4 text-center relative z-10 reveal">
                <h2 class="font-serif text-5xl md:text-6xl font-extrabold mb-8 tracking-tight text-[#18181b]">
                    Ready to <span class="text-brand-600 italic">Modernize?</span>
                </h2>
                <p class="text-[#18181b]/80 mb-12 text-lg md:text-xl font-semibold">Join the growing network of modern diagnostic labs experiencing zero downtime and automated workflows.</p>
                
                <a href="{{ route('enquiry') }}" class="inline-flex justify-center items-center gap-2 px-10 py-5 bg-[#C70000] text-white hover:bg-[#b91c1c] rounded-full font-bold text-lg shadow-xl shadow-red-900/10 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                    Request a Demo <i class="feather-arrow-right"></i>
                </a>
            </div>
        </section>

    </div>
</x-landing-layout>