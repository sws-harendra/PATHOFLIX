@props(['transparent' => false])

@php
    $siteName = \App\Models\SiteSetting::get('site_name', 'SWS Pathology');
    $siteLogo = \App\Models\SiteSetting::get('site_logo');

    // Matching yoga style navigation items density
    $navLinks = [
        ['label' => 'Home', 'url' => url('/')],
        ['label' => 'About', 'url' => route('about')],
        ['label' => 'Features', 'url' => route('features')],
        ['label' => 'How It Works', 'url' => route('how-it-works')],
        ['label' => 'Pricing', 'url' => route('pricing')],
        ['label' => 'FAQ', 'url' => route('faq')],
        ['label' => 'Contact', 'url' => route('contact')],
    ];
@endphp

<div class="fixed top-0 inset-x-0 z-[100] flex justify-center px-4 pt-4 pointer-events-none">
    <nav x-data="{ open: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 50)"
         :class="scrolled 
             ? 'w-[95%] md:w-[92%] max-w-6xl bg-white/90 backdrop-blur-xl border border-[#0c5f56]/15 rounded-full py-2.5 px-8 shadow-xl shadow-[#0c5f56]/10' 
             : 'w-full max-w-7xl bg-transparent py-4 px-4 md:px-8'" 
         class="pointer-events-auto flex items-center justify-between transition-all duration-700 ease-in-out relative">

        <!-- Logo -->
        <a href="/" class="flex-none flex items-center gap-3 cursor-pointer group z-10 focus:outline-none mr-8">
            @if($siteLogo)
                <div :class="scrolled ? 'w-10 h-10' : 'w-16 h-16'" class="relative flex items-center justify-center transition-all duration-500 z-[110]">
                    <img src="{{ secure_storage_url($siteLogo) }}" alt="{{ $siteName }}"
                         class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-105">
                </div>
            @else
                <div :class="scrolled ? 'w-8 h-8 rounded-lg' : 'w-12 h-12 rounded-xl'"
                     class="bg-gradient-to-tr from-brand-700 to-brand-500 flex items-center justify-center shadow-lg shadow-brand-600/20 group-hover:shadow-brand-600/40 transition-all duration-500 group-hover:-translate-y-0.5">
                    <i class="feather-activity text-white transition-all duration-500" :class="scrolled ? 'text-xs' : 'text-lg'"></i>
                </div>
            @endif
            <span :class="scrolled 
                ? 'text-[10px] sm:text-xs font-bold tracking-tight text-[#0f2d2a]' 
                : 'text-base sm:text-xl font-medium tracking-widest text-[#0f2d2a]'" 
                class="font-display uppercase transition-all duration-500">
                <span>{{ explode(' ', $siteName)[0] ?? 'SWS' }}</span>
                <span class="text-brand-600">
                    {{ implode(' ', array_slice(explode(' ', $siteName), 1)) ?: 'Pathology' }}
                </span>
            </span>
        </a>

        <!-- Navigation Items -->
        <div :class="scrolled ? 'gap-4 lg:gap-6' : 'gap-8 lg:gap-10'" class="hidden md:flex flex-1 justify-center items-center transition-all duration-500">
            @foreach($navLinks as $link)
                @php
                    $isActive = request()->url() === rtrim($link['url'], '/');
                @endphp
                <a href="{{ $link['url'] }}" 
                   :class="scrolled ? 'tracking-[0.12em] text-[10px] sm:text-[11px]' : 'tracking-[0.2em] text-[11px] sm:text-xs'"
                   class="nav-link-underline font-bold uppercase transition-all duration-300
                          {{ $isActive ? 'text-brand-600' : 'text-[#0c5f56]/80 hover:text-[#0f2d2a]' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="flex-none flex items-center gap-3 z-10">
            @auth
                @php
                    $user = auth()->user();
                    $dashboardRoute = 'lab.dashboard';
                    if ($user->hasRole('super_admin')) {
                        $dashboardRoute = 'admin.dashboard';
                    } elseif ($user->patientProfile) {
                        $dashboardRoute = 'portal.dashboard';
                    } elseif ($user->hasAnyRole(['doctor', 'agent', 'collection_center']) || $user->collection_center_id || $user->doctorProfile || $user->agentProfile) {
                        $dashboardRoute = 'partner.dashboard';
                    }
                @endphp
                <a href="{{ route($dashboardRoute) }}"
                   :class="scrolled ? 'py-2 px-5 text-[10px]' : 'py-3 px-6 text-xs'"
                   class="hidden lg:flex uppercase tracking-wider font-bold text-white bg-[#0c5f56] hover:bg-[#094d45] rounded-full transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="hidden lg:flex nav-link-underline text-[11px] sm:text-xs font-bold tracking-[0.2em] uppercase transition-colors text-[#0c5f56]/80 hover:text-[#0f2d2a] mr-4">
                    Log In
                </a>
                <a href="{{ url('/#contact') }}"
                   :class="scrolled ? 'py-2 px-5 text-[10px]' : 'py-3 px-6 text-xs'"
                   class="hidden lg:flex uppercase tracking-wider font-bold text-white bg-[#0c5f56] hover:bg-[#094d45] rounded-full transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95 shadow-md shadow-[#0c5f56]/10">
                    Contact Us
                </a>
            @endauth
            
            <!-- Mobile Menu Trigger -->
            <button @click="open = !open" 
                    :class="scrolled 
                        ? 'text-[#0c5f56] border-[#0c5f56]/15 bg-white/50' 
                        : 'text-[#0c5f56] border-[#0c5f56]/10 bg-white/10'" 
                    class="md:hidden transition-all p-2 rounded-full border shadow-sm backdrop-blur-md focus:outline-none">
                <svg x-show="!open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4" @click.away="open = false"
            :class="scrolled 
                ? 'top-[115%] right-0 left-0 w-full max-w-sm mx-auto rounded-[2rem] border border-[#0c5f56]/15 shadow-2xl' 
                : 'top-full left-0 w-full rounded-b-2xl border-b border-[#0c5f56]/10'"
            class="md:hidden absolute bg-white/95 backdrop-blur-xl overflow-hidden z-40 transition-all duration-300">

            <div class="px-6 py-6 flex flex-col gap-2 max-h-[75vh] overflow-y-auto">
                @foreach($navLinks as $link)
                    @php $isActive = request()->url() === rtrim($link['url'], '/'); @endphp
                    <a href="{{ $link['url'] }}" @click="open = false"
                        class="flex items-center justify-between px-4 py-3 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-[0.2em] transition-all duration-300 {{ $isActive ? 'text-brand-600 bg-brand-50/50' : 'text-[#0f2d2a]/80 hover:bg-[#0c5f56]/5 hover:text-[#0f2d2a]' }}">
                        {{ $link['label'] }}
                        @if($isActive)
                            <i class="feather-chevron-right text-sm text-brand-500"></i>
                        @endif
                    </a>
                @endforeach

                <div class="mt-6 pt-6 border-t border-[#0c5f56]/10 flex flex-col gap-3">
                    @auth
                        @php
                            $user = auth()->user();
                            $dashboardRoute = 'lab.dashboard';
                            if ($user->hasRole('super_admin')) {
                                $dashboardRoute = 'admin.dashboard';
                            } elseif ($user->patientProfile) {
                                $dashboardRoute = 'portal.dashboard';
                            } elseif ($user->hasAnyRole(['doctor', 'agent', 'collection_center']) || $user->collection_center_id || $user->doctorProfile || $user->agentProfile) {
                                $dashboardRoute = 'partner.dashboard';
                            }
                        @endphp
                        <a href="{{ route($dashboardRoute) }}" @click="open = false"
                            class="w-full text-center py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-white bg-[#0c5f56] hover:bg-[#094d45] transition-all">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" @click="open = false"
                            class="w-full text-center py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-[#0f2d2a] border border-[#0c5f56]/20 hover:bg-[#0c5f56]/5 transition-all">
                            Log In
                        </a>
                        <a href="{{ url('/#contact') }}" @click="open = false"
                            class="w-full text-center py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-white bg-[#0c5f56] hover:bg-[#094d45] transition-all shadow-md shadow-teal-900/10">
                            Contact Us
                        </a>
                    @endauth
                </div>
            </div>
        </div>

    </nav>
</div>