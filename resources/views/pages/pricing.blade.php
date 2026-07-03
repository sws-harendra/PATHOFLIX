@php
    $plans = \App\Models\Plan::landing()->get();
    $faqs = \App\Models\LandingFaq::active()->where('category', 'pricing')->get();
@endphp

<x-landing-layout>
    <x-slot name="title">Pricing - {{ \App\Models\SiteSetting::get('site_name', 'SWS Pathology') }}</x-slot>

    <div class="text-[#18181b] font-sans overflow-hidden">

        <!-- Hero Section -->
        <section class="pt-32 pb-20 relative overflow-hidden bg-[#eaf0ee]/30 border-b border-[#C70000]/10">
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-brand-500/10 blur-[200px] rounded-full z-0 pointer-events-none"></div>
            <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-red-500/5 blur-[150px] rounded-full z-0 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white border border-[#C70000]/10 text-[#C70000] text-[11px] font-bold uppercase tracking-wider mb-6">Scale with Confidence</span>
                <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight mb-8">
                    Choose Your <span class="text-brand-600 italic font-serif">Growth Plan</span>
                </h1>
                <p class="text-lg md:text-xl text-[#18181b]/80 max-w-2xl mx-auto leading-relaxed font-semibold">
                    Predictable pricing for every stage of your laboratory's growth. No hidden fees.
                </p>
            </div>
        </section>

        <!-- Plan Cards Redesign -->
        @if($plans->count())
            <section class="py-24 bg-white/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-{{ min($plans->count(), 3) }} gap-8 max-w-5xl mx-auto items-stretch">
                        @foreach($plans as $i => $plan)
                            @php $isPopular = $plan->landing_badge !== null; @endphp
                            <div class="reveal delay-{{ $i + 1 }} relative {{ $isPopular ? 'lg:scale-105 z-10' : '' }}">
                                @if($isPopular)
                                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-brand-600 to-red-600 text-[10px] font-bold uppercase tracking-wider px-5 py-1.5 rounded-full text-white shadow-lg shadow-brand-500/25 z-20">
                                        {{ $plan->landing_badge }}
                                    </div>
                                @endif
                                <div class="{{ $isPopular ? 'bg-[#C70000] text-white ring-1 ring-white/10 shadow-2xl' : 'bg-white border border-[#C70000]/10 hover:border-brand-500/30' }} rounded-[2.2rem] p-10 flex flex-col h-full transition-all duration-500 hover:-translate-y-1 shadow-sm hover:shadow-xl">
                                    <div class="mb-8">
                                        <h5 class="text-xs font-bold {{ $isPopular ? 'text-brand-300' : 'text-[#C70000]/70' }} uppercase tracking-widest mb-4">
                                            {{ $plan->name }}
                                        </h5>
                                        <div class="text-5xl font-black font-display {{ $isPopular ? 'text-white' : 'text-[#18181b]' }}">
                                            @if($plan->price == 0) Free <span class="text-xs font-bold uppercase tracking-wider {{ $isPopular ? 'text-brand-300' : 'text-[#C70000]/70' }}">forever</span>
                                            @else ₹{{ number_format($plan->price) }}<span class="text-xs font-bold uppercase tracking-wider {{ $isPopular ? 'text-brand-300' : 'text-[#C70000]/70' }}">/mo</span>
                                            @endif
                                        </div>
                                        @if($plan->landing_subtitle)
                                            <p class="text-sm {{ $isPopular ? 'text-red-100' : 'text-[#18181b]/80' }} mt-2 font-medium">
                                                {{ $plan->landing_subtitle }}
                                            </p>
                                        @endif
                                    </div>

                                    @if($plan->landing_features)
                                        <ul class="space-y-4 mb-10 flex-1">
                                            @foreach($plan->landing_features as $feat)
                                                <li class="flex items-center gap-3 text-sm font-semibold {{ $isPopular ? 'text-red-50' : 'text-[#18181b]/95' }}">
                                                    <div class="w-5 h-5 rounded-full {{ $isPopular ? 'bg-white/10 text-white' : 'bg-brand-50 border border-brand-200 text-brand-600' }} flex items-center justify-center shrink-0">
                                                        <i class="feather-check text-[10px] stroke-[3]"></i>
                                                    </div>
                                                    {{ $feat }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <a href="#contact" class="block w-full py-4 text-center rounded-full font-bold text-sm transition-all duration-300 {{ $isPopular ? 'bg-white text-[#C70000] hover:bg-red-50' : 'bg-[#C70000] text-white hover:bg-[#b91c1c]' }} hover:-translate-y-0.5 active:scale-95 shadow-md">
                                        {{ $plan->landing_cta_text ?? 'Contact Us' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Pricing FAQs Redesign -->
        @if($faqs->count())
            <section class="py-24 bg-[#eaf0ee]/30 border-y border-[#C70000]/10">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16 reveal">
                        <span class="text-xs font-bold text-[#C70000] uppercase tracking-widest mb-3 block">Got Questions?</span>
                        <h3 class="font-serif text-4xl sm:text-5xl text-[#18181b]">
                            Pricing <span class="text-brand-600 italic">Questions</span>
                        </h3>
                    </div>
                    <div class="space-y-4" x-data="{ active: null }">
                        @foreach($faqs as $faq)
                            <div class="reveal bg-white/80 backdrop-blur-sm rounded-[1.8rem] border border-[#C70000]/10 overflow-hidden transition-all duration-300 hover:border-brand-500/20">
                                <button @click="active = active === {{ $faq->id }} ? null : {{ $faq->id }}" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                                    <span class="font-bold text-[#18181b] pr-4">{{ $faq->question }}</span>
                                    <div class="w-8 h-8 rounded-full bg-brand-50/50 border border-brand-200/50 flex items-center justify-center shrink-0 transition-transform duration-300" :class="active === {{ $faq->id }} ? 'rotate-180 bg-brand-50 text-brand-600' : 'text-zinc-400'">
                                        <i class="feather-chevron-down text-sm"></i>
                                    </div>
                                </button>
                                <div x-show="active === {{ $faq->id }}" x-collapse>
                                    <div class="px-6 pb-6 text-sm text-[#18181b]/80 leading-relaxed font-medium border-t border-[#C70000]/5 pt-4">{{ $faq->answer }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Final CTA Banner -->
        <section class="py-28 bg-[#C70000] text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-white/10 blur-[120px] rounded-full"></div>
            </div>
            
            <div class="relative z-10 reveal max-w-3xl mx-auto px-4">
                <h2 class="font-serif text-5xl md:text-6xl text-white mb-6">Upgrade Your <span class="text-red-200">Diagnostic Intelligence</span></h2>
                <p class="text-red-100 max-w-2xl mx-auto mb-12 text-lg md:text-xl font-medium">Start your free trial today. No credit card required.</p>
                <a href="#contact" class="inline-block px-10 py-5 bg-white text-[#C70000] rounded-full font-bold text-lg shadow-2xl transition-transform hover:-translate-y-1 active:scale-95">
                    Contact Sales
                </a>
            </div>
        </section>

    </div>
</x-landing-layout>