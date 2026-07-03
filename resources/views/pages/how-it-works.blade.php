<x-landing-layout>
    <x-slot name="title">How It Works - {{ \App\Models\SiteSetting::get('site_name', 'SWS Pathology') }}</x-slot>

    <div class="text-[#18181b] font-sans overflow-hidden">

        <!-- Hero Section -->
        <section class="pt-32 pb-20 relative overflow-hidden bg-[#eaf0ee]/30 border-b border-[#C70000]/10">
            <div class="absolute top-0 left-1/2 w-[800px] h-[600px] bg-brand-500/10 blur-[200px] rounded-full -translate-x-1/2 z-0 pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white border border-[#C70000]/10 text-[#C70000] text-[11px] font-bold uppercase tracking-wider mb-6">Workflow</span>
                <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight mb-8">
                    From Sample to <span class="text-brand-600 italic font-serif">Report in Minutes</span>
                </h1>
                <p class="text-lg md:text-xl text-[#18181b]/80 max-w-2xl mx-auto leading-relaxed font-semibold">
                    Our streamlined 4-step process eliminates manual bottlenecks and delivers results faster than ever.
                </p>
            </div>
        </section>

        <!-- Steps Redesign -->
        <section class="py-24 bg-white/30">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                @foreach([
                    ['step' => '01', 'title' => 'Patient Registration & Billing', 'desc' => 'Register patients in seconds with our Smart POS. Auto-generate barcoded samples, apply test packages and membership discounts, and create instant invoices with multiple payment options.', 'icon' => 'feather-user-plus', 'color' => 'brand', 'features' => ['Barcode generation', 'Multi-payment options', 'Membership pricing', 'Test packages']],
                    ['step' => '02', 'title' => 'Sample Processing & Entry', 'desc' => 'Track samples through your LIS workflow. Enter results manually or sync directly from cell counters and biochemistry analyzers. Smart reference range flagging alerts pathologists instantly.', 'icon' => 'feather-cpu', 'color' => 'teal', 'features' => ['Sample tracking', 'Analyzer integration', 'Auto reference ranges', 'Quality checks']],
                    ['step' => '03', 'title' => 'Verification & Approval', 'desc' => 'Pathologists review flagged results, add clinical notes, and digitally sign reports with a single click. Multi-level approval workflows ensure quality compliance.', 'icon' => 'feather-check-circle', 'color' => 'emerald', 'features' => ['Digital signatures', 'Multi-level approval', 'Clinical annotations', 'QR verification']],
                    ['step' => '04', 'title' => 'Report Delivery & Follow-up', 'desc' => 'Approved reports are instantly delivered via SMS, WhatsApp, email, or the patient portal. Patients can download verified PDFs with QR authentication.', 'icon' => 'feather-send', 'color' => 'indigo', 'features' => ['WhatsApp delivery', 'SMS notifications', 'Patient portal', 'PDF download']],
                ] as $i => $step)
                    <div class="reveal grid md:grid-cols-2 gap-16 items-center mb-28 {{ $i % 2 !== 0 ? 'md:grid-flow-dense' : '' }}">
                        <div class="{{ $i % 2 !== 0 ? 'md:col-start-2' : '' }}">
                            <div class="flex items-center gap-4 mb-6">
                                <span class="w-12 h-12 bg-brand-50/50 border border-brand-200/50 rounded-2xl flex items-center justify-center text-brand-700 font-display font-bold text-lg">{{ $step['step'] }}</span>
                                <div class="h-px flex-1 bg-[#C70000]/10"></div>
                            </div>
                            <h3 class="font-serif text-3xl md:text-4xl text-[#18181b] mb-4 leading-tight">
                                {{ $step['title'] }}
                            </h3>
                            <p class="text-[#18181b]/80 font-semibold leading-relaxed mb-6">{{ $step['desc'] }}</p>
                            
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($step['features'] as $feat)
                                    <div class="flex items-center gap-2.5 text-sm font-semibold text-[#18181b]/95">
                                        <i class="feather-check text-brand-600"></i>
                                        <span>{{ $feat }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="relative {{ $i % 2 !== 0 ? 'md:col-start-1' : '' }}">
                            <div class="absolute -inset-4 bg-gradient-to-tr from-brand-300/10 to-red-300/10 blur-2xl rounded-[3rem] opacity-60"></div>
                            <div class="bg-white/80 backdrop-blur-sm rounded-[2.5rem] p-10 flex flex-col items-center justify-center min-h-[300px] border border-[#C70000]/10 shadow-lg group hover:shadow-xl transition-shadow duration-500">
                                <div class="w-20 h-20 bg-brand-50/50 border border-brand-200/50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <i class="{{ $step['icon'] }} text-brand-700 text-3xl"></i>
                                </div>
                                <p class="text-xs font-bold text-[#C70000] uppercase tracking-widest">Step {{ $step['step'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Final CTA Banner -->
        <section class="py-28 bg-[#C70000] text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-white/10 blur-[120px] rounded-full"></div>
            </div>
            
            <div class="max-w-3xl mx-auto px-4 reveal relative z-10">
                <h2 class="font-serif text-5xl md:text-6xl text-white mb-6">Ready to <span class="text-red-200">Get Started?</span></h2>
                <p class="text-red-100 mb-10 text-lg md:text-xl font-medium">See how simple it is to transform your lab operations.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#contact" class="px-10 py-5 bg-white text-[#C70000] rounded-full font-bold text-lg shadow-xl shadow-red-900/10 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        Contact Us
                    </a>
                    <a href="{{ route('enquiry') }}" class="px-10 py-5 bg-[#b91c1c] border border-red-500/30 text-white rounded-full font-bold text-lg transition-all duration-300 transform hover:-translate-y-1">
                        Request Demo
                    </a>
                </div>
            </div>
        </section>

    </div>
</x-landing-layout>
