@php
    $features = \App\Models\LandingFeature::active()->get();
    $colors = [
        'primary' => ['bg' => 'bg-brand-500', 'light' => 'bg-brand-50/50', 'text' => 'text-brand-700', 'shadow' => 'shadow-brand-500/20'],
        'success' => ['bg' => 'bg-emerald-500', 'light' => 'bg-emerald-50/50', 'text' => 'text-emerald-700', 'shadow' => 'shadow-emerald-500/20'],
        'info' => ['bg' => 'bg-teal-500', 'light' => 'bg-teal-50/50', 'text' => 'text-teal-700', 'shadow' => 'shadow-teal-500/20'],
        'warning' => ['bg' => 'bg-amber-500', 'light' => 'bg-amber-50/50', 'text' => 'text-amber-700', 'shadow' => 'shadow-amber-500/20'],
        'danger' => ['bg' => 'bg-rose-500', 'light' => 'bg-rose-50/50', 'text' => 'text-rose-700', 'shadow' => 'shadow-rose-500/20'],
        'purple' => ['bg' => 'bg-purple-500', 'light' => 'bg-purple-50/50', 'text' => 'text-purple-700', 'shadow' => 'shadow-purple-500/20'],
        'teal' => ['bg' => 'bg-teal-500', 'light' => 'bg-teal-50/50', 'text' => 'text-teal-700', 'shadow' => 'shadow-teal-500/20'],
        'dark' => ['bg' => 'bg-zinc-800', 'light' => 'bg-[#eaf0ee]/50', 'text' => 'text-zinc-850', 'shadow' => 'shadow-zinc-800/20'],
    ];
@endphp

<x-landing-layout>
    <x-slot name="title">Features - {{ \App\Models\SiteSetting::get('site_name', 'SWS Pathology') }}</x-slot>

    <div class="text-[#0f2d2a] font-sans overflow-hidden">

        <!-- Hero Section -->
        <section class="pt-32 pb-24 relative overflow-hidden bg-[#eaf0ee]/30 border-b border-[#0c5f56]/10">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-emerald-400/10 blur-[150px] rounded-full translate-x-1/4 -translate-y-1/4"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-brand-400/10 blur-[150px] rounded-full -translate-x-1/4 translate-y-1/4"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 shadow-sm text-emerald-700 text-xs font-bold uppercase tracking-widest mb-8">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Cutting-Edge LIS
                </span>
                
                <h1 class="font-serif text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 text-[#0f2d2a] leading-[1.1]">
                    Engineered for <br class="hidden md:block" />
                    <span class="text-brand-600 italic font-serif">Diagnostic Precision</span>
                </h1>
                
                <p class="text-lg md:text-xl text-[#0f2d2a]/80 max-w-2xl mx-auto leading-relaxed font-semibold mb-10">
                    The most comprehensive suite of laboratory intelligence tools, designed to automate your workflow from sample collection to final report.
                </p>

                <div class="w-full max-w-5xl mx-auto rounded-[2.5rem] border border-[#0c5f56]/15 shadow-2xl overflow-hidden bg-white p-3">
                     <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&q=80&w=1200" alt="Lab Workstation" class="w-full h-[400px] object-cover rounded-3xl opacity-90 hover:opacity-100 transition-opacity duration-500">
                </div>
            </div>
        </section>

        <!-- Automation Spotlight Section -->
        @if($features->count() > 0)
            <section class="py-24 bg-white/30 relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">
                    
                    <div class="reveal-left">
                        <span class="inline-flex items-center gap-2 mb-4 text-brand-700 font-bold uppercase tracking-widest text-xs">
                            <i class="feather-cpu"></i> Automation Core
                        </span>
                        
                        <h3 class="font-serif text-4xl md:text-5xl font-extrabold mb-6 tracking-tight text-[#0f2d2a] leading-tight">
                            {{ $features->first()->title }}
                        </h3>
                        
                        <p class="text-md md:text-lg text-[#0f2d2a]/80 mb-10 leading-relaxed font-semibold">
                            {{ $features->first()->description }}
                        </p>
                        
                        <div class="space-y-5">
                            @foreach(['Supports 200+ Analyzer Manufacturers', 'Real-time Hardware Synchronization', 'Zero Manual Data Entry Errors'] as $point)
                                <div class="flex items-center gap-4 group">
                                    <div class="w-10 h-10 rounded-full bg-brand-50 border border-brand-200/50 flex items-center justify-center text-brand-700 group-hover:bg-brand-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                        <i class="feather-check text-sm"></i>
                                    </div>
                                    <span class="text-[#0f2d2a] font-bold text-sm">{{ $point }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="reveal-right">
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-tr from-brand-400/20 to-teal-400/20 blur-2xl rounded-[3.5rem] opacity-70"></div>
                            
                            <div class="relative bg-zinc-950 rounded-[2.2rem] p-6 shadow-2xl border border-zinc-800 ring-1 ring-white/10">
                                <div class="flex items-center gap-2 mb-6 border-b border-zinc-800 pb-4">
                                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                    <div class="ml-4 px-3 py-1 bg-zinc-900 rounded-md text-xs text-zinc-500 font-mono border border-zinc-800">
                                        analyzer-sync-module
                                    </div>
                                </div>
                                
                                <div class="space-y-3">
                                    <div class="text-xs text-zinc-500 uppercase tracking-widest font-bold mb-4">Incoming Data Streams</div>
                                    @foreach(['CBC Complete', 'Lipid Profile', 'Thyroid Panel', 'HbA1c'] as $test)
                                        <div class="flex items-center justify-between bg-zinc-900 border border-zinc-800 rounded-xl p-4 hover:border-brand-500/50 transition-colors cursor-default group">
                                            <div class="flex items-center gap-3">
                                                <i class="feather-activity text-zinc-600 group-hover:text-brand-400 transition-colors"></i>
                                                <span class="text-sm text-zinc-200 font-medium">{{ $test }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                </span>
                                                <span class="text-[10px] text-emerald-400 font-bold bg-emerald-500/10 border border-emerald-500/20 px-2 py-1 rounded-md tracking-wider">
                                                    AUTO-SYNCED
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Grid Matrix Redesign -->
        <section class="py-24 bg-[#eaf0ee]/30 border-t border-[#0c5f56]/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 reveal">
                    <span class="text-xs font-bold text-[#0c5f56] uppercase tracking-widest mb-3 block">Complete Suite</span>
                    <h3 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-[#0f2d2a]">
                        The Full Feature <span class="text-brand-600 italic">Matrix</span>
                    </h3>
                </div>
                
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 auto-rows-fr">
                    @foreach($features as $i => $feature)
                        @php 
                            $c = $colors[$feature->color] ?? $colors['primary']; 
                        @endphp
                        <div class="reveal delay-{{ ($i % 6) + 1 }} group relative bg-white/80 backdrop-blur-sm rounded-[2.2rem] p-8 border border-[#0c5f56]/10 shadow-sm hover:shadow-xl hover:border-brand-500/30 transition-all duration-500 hover:-translate-y-1 flex flex-col">
                            <div class="w-12 h-12 {{ $c['light'] }} rounded-2xl flex items-center justify-center {{ $c['text'] }} mb-6 group-hover:scale-110 transition-transform duration-300 border border-brand-200/20">
                                <i class="{{ $feature->icon }} text-xl"></i>
                            </div>
                            <h5 class="text-xl font-bold text-[#0f2d2a] mb-3">{{ $feature->title }}</h5>
                            <p class="text-sm text-[#0f2d2a]/80 leading-relaxed font-semibold mb-auto">{{ $feature->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-32 bg-[#0c5f56] text-center relative overflow-hidden text-white">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-white/10 blur-[120px] rounded-full"></div>
            </div>
            
            <div class="relative z-10 reveal max-w-3xl mx-auto px-4">
                <h2 class="font-serif text-5xl md:text-6xl font-extrabold text-white mb-6 tracking-tight">
                    Modernize Your <span class="text-teal-200">Lab DNA</span>
                </h2>
                <p class="text-xl text-teal-100 mb-10 font-medium">
                    Stop managing paper. Start managing health outcomes.
                </p>
                
                <a href="#contact" class="inline-flex justify-center items-center gap-2 px-10 py-5 bg-white text-[#0c5f56] rounded-full font-bold text-lg shadow-xl shadow-teal-900/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    Contact Us Today <i class="feather-arrow-right"></i>
                </a>
            </div>
        </section>

    </div>
</x-landing-layout>