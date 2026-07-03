@props(['transparent' => false])

@php
    $siteName = \App\Models\SiteSetting::get('site_name', 'SWS Pathology');
    $siteLogo = \App\Models\SiteSetting::get('site_logo');

    // Updated Navigation Links with 'Home'
    $navLinks = [
        ['label' => 'Home', 'url' => url('/')],
        ['label' => 'About', 'url' => route('about')],
        ['label' => 'Features', 'url' => route('features')],
        ['label' => 'How It Works', 'url' => route('how-it-works')],
        ['label' => 'Pricing', 'url' => route('pricing')],
        ['label' => 'FAQ', 'url' => route('faq')],
        ['label' => 'Contact', 'url' => route('contact')],
        ['label' => 'Download Report', 'url' => route('portal.login')],
    ];
@endphp

<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)" :class="{
        'bg-[#f4f7f6]/80 backdrop-blur-md shadow-lg shadow-teal-950/5 border-b border-[#0c5f56]/15 py-3': scrolled,
        'bg-transparent py-5': !scrolled && {{ $transparent ? 'true' : 'false' }},
        'bg-[#f4f7f6]/95 backdrop-blur-md border-b border-[#0c5f56]/5 py-4': !scrolled && !{{ $transparent ? 'true' : 'false' }}
     }" class="fixed top-0 w-full z-50 transition-all duration-300 ease-in-out">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">

            <div class="flex-shrink-0 z-50 relative">
                <a href="/" class="flex items-center gap-3 group focus:outline-none">
                    @if($siteLogo)
                        <img src="{{ secure_storage_url($siteLogo) }}" alt="{{ $siteName }}"
                            class="h-10 w-auto transition-transform duration-500 ease-out group-hover:scale-105">
                    @else
                        <div
                            class="w-10 h-10 bg-gradient-to-tr from-brand-700 to-brand-500 rounded-xl flex items-center justify-center shadow-lg shadow-brand-600/20 group-hover:shadow-brand-600/40 transition-all duration-300 group-hover:-translate-y-0.5">
                            <i class="feather-activity text-white text-xl"></i>
                        </div>
                    @endif
                    <span class="font-display font-extrabold text-xl tracking-tight text-[#0f2d2a]">
                        <span>{{ explode(' ', $siteName)[0] ?? 'SWS' }}</span>
                        <span class="text-brand-600">
                            {{ implode(' ', array_slice(explode(' ', $siteName), 1)) ?: 'Pathology' }}
                        </span>
                    </span>
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-6">
                @foreach($navLinks as $link)
                    @php
                        $isActive = request()->url() === rtrim($link['url'], '/');
                    @endphp
                    <a href="{{ $link['url'] }}" class="relative px-1 py-1.5 text-sm font-semibold transition-all duration-300 nav-link-underline group
                                      {{ $isActive ? 'text-brand-700' : 'text-[#0f2d2a]/80 hover:text-brand-700' }}">
                        <span class="relative z-10">{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <div class="hidden lg:flex items-center gap-6">
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
                        class="text-sm font-bold text-white bg-[#0c5f56] hover:bg-[#094d45] px-6 py-2.5 rounded-full shadow-lg shadow-teal-900/10 hover:shadow-teal-900/20 transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-[#0f2d2a]/80 hover:text-brand-700 transition-colors duration-300 nav-link-underline">
                        Log In
                    </a>
                    <a href="{{ url('/#contact') }}"
                        class="text-sm font-bold text-white bg-[#0c5f56] hover:bg-[#094d45] px-6 py-2.5 rounded-full shadow-lg shadow-teal-900/10 hover:shadow-teal-900/20 transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95">
                        Contact Us
                    </a>
                @endauth
            </div>

            <div class="lg:hidden flex items-center z-50 relative">
                <button @click="open = !open"
                    class="relative p-2.5 rounded-full bg-zinc-50 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-brand-500/50"
                    :aria-expanded="open">
                    <svg x-show="!open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" @click.away="open = false"
        class="lg:hidden absolute top-full left-0 w-full bg-[#f4f7f6]/95 backdrop-blur-md border-b border-[#0c5f56]/15 shadow-2xl overflow-hidden rounded-b-2xl">

        <div class="px-6 py-6 flex flex-col gap-2 max-h-[80vh] overflow-y-auto">
            @foreach($navLinks as $link)
                @php $isActive = request()->url() === rtrim($link['url'], '/'); @endphp
                <a href="{{ $link['url'] }}"
                    class="flex items-center justify-between px-4 py-3 rounded-xl text-[15px] font-bold transition-all duration-300 {{ $isActive ? 'text-brand-750 bg-brand-50/50' : 'text-[#0f2d2a]/80 hover:bg-[#0c5f56]/5 hover:text-[#0f2d2a]' }}">
                    {{ $link['label'] }}
                    @if($isActive)
                        <i class="feather-chevron-right text-sm text-brand-500"></i>
                    @endif
                </a>
            @endforeach

            <div class="mt-6 pt-6 border-t border-zinc-100 flex flex-col gap-3">
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
                        class="w-full text-center py-3.5 rounded-xl font-bold text-white bg-[#0c5f56] hover:bg-[#094d45] transition-all">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full text-center py-3.5 rounded-xl font-bold text-[#0f2d2a] border border-[#0c5f56]/20 hover:bg-[#0c5f56]/5 transition-all">
                        Log In
                    </a>
                    <a href="{{ url('/#contact') }}"
                        class="w-full text-center py-3.5 rounded-xl font-bold text-white bg-[#0c5f56] hover:bg-[#094d45] transition-all shadow-md shadow-teal-900/10">
                        Contact Us
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>