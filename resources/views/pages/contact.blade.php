<x-landing-layout>
    <x-slot name="title">Contact SWS Pathology - Support & Enterprise Sales</x-slot>

    <div class="text-[#18181b] font-sans overflow-hidden">

        <!-- Hero Section -->
        <section class="pt-32 pb-20 relative overflow-hidden bg-[#eaf0ee]/30 border-b border-[#C70000]/10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/10 blur-[120px] rounded-full z-[-1] pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white border border-[#C70000]/10 text-[#C70000] text-[10px] font-bold uppercase tracking-widest mb-6">Global Support</span>
                
                <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight mb-8">
                    Connect With Our <span class="text-brand-600 italic font-serif">Core HUB</span>
                </h1>
                
                <p class="text-lg md:text-xl text-[#18181b]/80 max-w-2xl mx-auto leading-relaxed font-semibold">
                    Whether you're a single clinic or a multi-branch diagnostic group, our experts are ready to calibrate your digital future.
                </p>
            </div>
        </section>

        <!-- Contact Grid (Form + Info) -->
        <section class="py-24 bg-white/30 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-20 items-stretch">
                
                <!-- Info Side -->
                <div class="space-y-12 flex flex-col justify-between reveal-left">
                    <div class="space-y-6">
                        <span class="text-xs font-bold text-[#C70000] uppercase tracking-widest block">Get In Touch</span>
                        <h3 class="font-serif text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                            Where Innovation <br />
                            <span class="text-brand-600 italic">Meets Diagnostics.</span>
                        </h3>
                        <p class="text-md md:text-lg text-[#18181b]/85 leading-relaxed font-semibold">
                            Our LIS support and engineering teams are dedicated to ensuring your lab runs with 100% uptime and zero friction.
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-6">
                        <!-- Tech Support -->
                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2.2rem] border border-[#C70000]/10 shadow-sm transition-all duration-300 hover:border-brand-500/30">
                            <div class="w-10 h-10 rounded-2xl bg-brand-50/50 border border-brand-200/50 text-brand-700 flex items-center justify-center mb-6"><i class="feather-headphones"></i></div>
                            <h5 class="font-bold text-lg text-[#18181b] mb-2">Global Support</h5>
                            <p class="text-xs text-[#18181b]/80 font-semibold mb-4">Available 24/7 for critical LIS emergencies.</p>
                            <p class="text-brand-700 font-bold text-sm">support@swspathology.com</p>
                        </div>
                        <!-- Sales -->
                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2.2rem] border border-[#C70000]/10 shadow-sm transition-all duration-300 hover:border-brand-500/30">
                            <div class="w-10 h-10 rounded-2xl bg-brand-50/50 border border-brand-200/50 text-brand-700 flex items-center justify-center mb-6"><i class="feather-briefcase"></i></div>
                            <h5 class="font-bold text-lg text-[#18181b] mb-2">Enterprise Sales</h5>
                            <p class="text-xs text-[#18181b]/80 font-semibold mb-4">Custom deployment & hospital pricing.</p>
                            <p class="text-brand-700 font-bold text-sm">sales@swspathology.com</p>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-[#C70000]/10">
                        <p class="text-[10px] font-bold text-[#C70000]/80 uppercase tracking-widest mb-4">Social Channels</p>
                        <div class="flex gap-4">
                            @foreach(['feather-linkedin', 'feather-twitter', 'feather-facebook', 'feather-instagram'] as $icon)
                                <a href="#" class="w-10 h-10 rounded-full bg-white border border-[#C70000]/15 flex items-center justify-center text-[#18181b]/70 hover:bg-[#C70000] hover:text-white hover:border-[#C70000] transition-all duration-300 hover:-translate-y-1">
                                    <i class="{{ $icon }} text-sm"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Side -->
                <div class="reveal-right">
                    <div class="bg-white/80 backdrop-blur-xl p-10 md:p-12 rounded-[2.5rem] border border-[#C70000]/15 shadow-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-linear-to-br from-brand-600/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <h3 class="font-serif text-3xl font-extrabold text-[#18181b] mb-8 leading-tight">
                            Initiate <span class="text-brand-600 italic">Consultation</span>
                        </h3>
                        
                        <form class="space-y-6 relative z-10">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-[#C70000]/80 uppercase tracking-widest ml-1">Your Full Name</label>
                                    <input type="text" class="block w-full px-5 py-4 bg-[#ffffff] border border-[#C70000]/15 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all font-semibold text-sm text-[#18181b]" placeholder="Rahul Verma" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-[#C70000]/80 uppercase tracking-widest ml-1">Clinic / Lab Name</label>
                                    <input type="text" class="block w-full px-5 py-4 bg-[#ffffff] border border-[#C70000]/15 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all font-semibold text-sm text-[#18181b]" placeholder="City Lab X" required>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-[#C70000]/80 uppercase tracking-widest ml-1">Official Email Address</label>
                                <input type="email" class="block w-full px-5 py-4 bg-[#ffffff] border border-[#C70000]/15 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all font-semibold text-sm text-[#18181b]" placeholder="rahul@citylab.com" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-[#C70000]/80 uppercase tracking-widest ml-1">Brief Description of Needs</label>
                                <textarea rows="4" class="block w-full px-5 py-4 bg-[#ffffff] border border-[#C70000]/15 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all font-semibold text-sm text-[#18181b] resize-none" placeholder="We need auto-analyzer sync and WhatsApp reporting..."></textarea>
                            </div>

                            <button type="button" class="w-full bg-[#C70000] text-white font-bold py-5 rounded-full shadow-lg shadow-red-900/10 hover:bg-[#b91c1c] hover:-translate-y-1 active:scale-95 transition-all overflow-hidden group relative">
                                Signal Our HUB <i class="feather-send ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
            </div>
        </section>

        <!-- Location Nodes Strip -->
        <section class="py-24 bg-[#eaf0ee]/30 border-t border-[#C70000]/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center opacity-75">
                    <div>
                        <p class="text-2xl font-serif text-[#18181b] font-bold italic">Silicon Valley</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#C70000]/80 mt-1">Tech Center</p>
                    </div>
                    <div>
                        <p class="text-2xl font-serif text-[#18181b] font-bold italic">London</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#C70000]/80 mt-1">Euro Node</p>
                    </div>
                    <div>
                        <p class="text-2xl font-serif text-[#18181b] font-bold italic">Singapore</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#C70000]/80 mt-1">APAC Node</p>
                    </div>
                    <div>
                        <p class="text-2xl font-serif text-[#18181b] font-bold italic">New Delhi</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#C70000]/80 mt-1">Global Sales</p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-landing-layout>
