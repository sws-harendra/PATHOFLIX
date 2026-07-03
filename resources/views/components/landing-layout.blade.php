<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? \App\Models\SiteSetting::get('meta_title', 'SWS Pathology - Advanced Diagnostic Solutions') }}
    </title>
    <meta name="description"
        content="{{ \App\Models\SiteSetting::get('meta_description', 'Leading pathology management platform') }}">
    @php
        $siteFavicon = \App\Models\SiteSetting::get('site_favicon');
    @endphp
    <link rel="shortcut icon" type="image/x-icon" href="{{ $siteFavicon ? secure_storage_url($siteFavicon) : asset('assets/images/icon.webp') }}" />

    <!-- Fonts: Outfit for display, Inter for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital,wght@0,400;1,400&family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Feather Icons (same as dashboard) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}" />

    <!-- Tailwind Play CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    @php
        $brandColor = \App\Models\SiteSetting::get('primary_color', '#C70000');
        $siteName = \App\Models\SiteSetting::get('site_name', 'SWS Pathology');
    @endphp

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-display: 'Outfit', sans-serif;
            --font-serif: 'Instrument Serif', serif;

            --color-brand-50: color-mix(in srgb, {{ $brandColor }} 10%, white);
            --color-brand-100: color-mix(in srgb, {{ $brandColor }} 20%, white);
            --color-brand-200: color-mix(in srgb, {{ $brandColor }} 40%, white);
            --color-brand-300: color-mix(in srgb, {{ $brandColor }} 60%, white);
            --color-brand-400: color-mix(in srgb, {{ $brandColor }} 80%, white);
            --color-brand-500: {{ $brandColor }};
            --color-brand-600: color-mix(in srgb, {{ $brandColor }} 90%, black);
            --color-brand-700: color-mix(in srgb, {{ $brandColor }} 75%, black);
            --color-brand-800: color-mix(in srgb, {{ $brandColor }} 60%, black);
            --color-brand-900: color-mix(in srgb, {{ $brandColor }} 45%, black);
            --color-brand-950: color-mix(in srgb, {{ $brandColor }} 30%, black);

            --color-accent: var(--color-brand-600);

            --animate-float: float 6s ease-in-out infinite;
            --animate-float-slow: floatSlow 8s ease-in-out infinite;
            --animate-float-fast: floatFast 5s ease-in-out infinite;
            --animate-scale-bg: scaleBg 30s ease-in-out infinite alternate;
            --animate-gradient-drift-1: gradientDrift1 18s ease-in-out infinite;
            --animate-gradient-drift-2: gradientDrift2 24s ease-in-out infinite alternate;
            --animate-draw-line: drawLine 1.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            --animate-fade-in-up: fadeInUp 0.8s ease-out forwards;
            --animate-shimmer: shimmer 2.5s linear infinite;
            --animate-pulse-soft: pulseSoft 3s ease-in-out infinite;
            --animate-slide-in-left: slideInLeft 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            --animate-slide-in-right: slideInRight 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            --animate-scale-in: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            --animate-count-up: countUp 2s ease-out forwards;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(1deg); }
        }
        @keyframes floatFast {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(-1deg); }
        }
        @keyframes scaleBg {
            0% { transform: scale(1) translate(0px, 0px); }
            100% { transform: scale(1.08) translate(10px, -5px); }
        }
        @keyframes gradientDrift1 {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.15); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        @keyframes gradientDrift2 {
            0%, 100% { transform: translate(0px, 0px) scale(1.1); }
            50% { transform: translate(-40px, 30px) scale(0.9); }
        }
        @keyframes drawLine {
            to { stroke-dashoffset: 0; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes pulseSoft {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-60px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(60px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes borderGlow {
            0%, 100% { border-color: oklch(0.58 0.18 220 / 0.2); }
            50% { border-color: oklch(0.58 0.18 220 / 0.5); }
        }

        /* Utility Classes */
        .glass {
            @apply bg-white/60 backdrop-blur-xl border border-white/30 shadow-xl;
        }
        .glass-dark {
            @apply bg-zinc-900/60 backdrop-blur-xl border border-white/10 shadow-2xl;
        }
        .bg-grid {
            background-size: 50px 50px;
            background-image:
                linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
        }
        .gradient-text {
            @apply text-transparent bg-clip-text;
            background-image: linear-gradient(135deg, oklch(0.58 0.18 220) 0%, oklch(0.50 0.16 280) 100%);
        }
        .gradient-border {
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, oklch(0.58 0.18 220), oklch(0.50 0.16 280)) border-box;
            border: 2px solid transparent;
        }
        .hover-lift {
            @apply transition-all duration-500;
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px -12px rgba(0,0,0,0.15);
        }
        .shimmer-bg {
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.1) 50%, transparent 100%);
            background-size: 200% 100%;
        }

        /* Scroll-reveal classes */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.revealed { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-left.revealed { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-right.revealed { opacity: 1; transform: translateX(0); }
        .reveal-scale { opacity: 0; transform: scale(0.9); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-scale.revealed { opacity: 1; transform: scale(1); }

        /* Stagger delays */
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }
        .delay-6 { transition-delay: 0.6s; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #ffffff;
        }
        ::-webkit-scrollbar-thumb {
            background: #C70000;
            border-radius: 10px;
            border: 2px solid #ffffff;
        }

        /* Navbar Hover Underline Effect */
        .nav-link-underline {
            position: relative;
            padding-bottom: 2px;
        }
        .nav-link-underline::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--color-brand-600);
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .nav-link-underline:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        body {
            @apply bg-[#ffffff] text-[#18181b] font-sans antialiased;
        }

        /* Smooth section transitions */
        section {
            @apply relative;
        }

        .scroll-frame {
            will-change: transform, opacity;
            transform-origin: center center;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease-out;
        }
    </style>

    @livewireStyles
</head>

<body class="antialiased selection:bg-brand-500 selection:text-white relative">
    <!-- Light Noise Texture Overlay -->
    <div class="fixed inset-0 z-[9999] pointer-events-none opacity-[0.018] mix-blend-multiply" style="background-image: url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E&quot;);"></div>

    <!-- Global Living Background (Slowly Drifting Color Gradients) -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none bg-[#ffffff]">
        <!-- Blob 1: Premium Forest Teal -->
        <div class="absolute -top-[15%] -left-[15%] w-[70vw] h-[70vw] rounded-full bg-[#C70000]/20 blur-[130px] animate-gradient-drift-1"></div>
        <!-- Blob 2: Deep Indigo-Violet -->
        <div class="absolute bottom-[5%] -right-[10%] w-[60vw] h-[60vw] rounded-full bg-indigo-500/16 blur-[140px] animate-gradient-drift-2"></div>
        <!-- Blob 3: Warm Amber (adds premium warmth, avoids plain light-gray/white coldness) -->
        <div class="absolute top-[35%] right-[5%] w-[50vw] h-[50vw] rounded-full bg-amber-500/12 blur-[120px] animate-gradient-drift-1"></div>
        <!-- Blob 4: Soft Emerald -->
        <div class="absolute -bottom-[10%] left-[10%] w-[65vw] h-[65vw] rounded-full bg-red-500/14 blur-[130px] animate-gradient-drift-2"></div>

        <!-- Light Falling Snow Particles -->
        <canvas id="bg-particles" class="absolute inset-0 w-full h-full opacity-75"></canvas>
    </div>

    <!-- Navbar -->
    <x-landing.navbar />

    <!-- Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-landing.footer />

    @livewireScripts

    <!-- Scroll Reveal Animation Engine -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
                observer.observe(el);
            });

            // Falling particles engine (Light Snow/SaaS Sparkles)
            const canvas = document.getElementById('bg-particles');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                let width = canvas.width = window.innerWidth;
                let height = canvas.height = window.innerHeight;

                window.addEventListener('resize', () => {
                    width = canvas.width = window.innerWidth;
                    height = canvas.height = window.innerHeight;
                });

                const particles = [];
                const particleCount = 45;

                for (let i = 0; i < particleCount; i++) {
                    particles.push({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        radius: Math.random() * 2.5 + 1.0,
                        opacity: Math.random() * 0.28 + 0.08,
                        speed: Math.random() * 0.35 + 0.15
                    });
                }

                let angle = 0;
                function draw() {
                    ctx.clearRect(0, 0, width, height);
                    angle += 0.003;

                    for (let i = 0; i < particleCount; i++) {
                        const p = particles[i];
                        ctx.beginPath();
                        ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2, true);
                        ctx.fillStyle = `rgba(220, 38, 38, ${p.opacity})`;
                        ctx.fill();

                        p.y += p.speed;
                        p.x += Math.sin(angle) * 0.3;

                        if (p.y > height) {
                            particles[i] = {
                                x: Math.random() * width,
                                y: -10,
                                radius: p.radius,
                                opacity: p.opacity,
                                speed: p.speed
                            };
                        }
                    }
                    requestAnimationFrame(draw);
                }
                draw();
            }

            // Scroll driven framing effect
            const scrollFrames = document.querySelectorAll('.scroll-frame');
            
            function handleScrollFrame() {
                const viewportHeight = window.innerHeight;
                scrollFrames.forEach(frame => {
                    const rect = frame.getBoundingClientRect();
                    const elementHeight = rect.height;
                    const elementTop = rect.top;
                    const elementBottom = rect.bottom;
                    
                    if (elementTop < viewportHeight && elementBottom > 0) {
                        const distFromCenter = Math.abs((elementTop + elementHeight / 2) - viewportHeight / 2);
                        const centerRatio = Math.max(0, 1 - (distFromCenter / (viewportHeight / 1.1)));
                        
                        // Scale smoothly from 0.94 to 1.0 based on viewport center proximity
                        const scale = 0.94 + (0.06 * centerRatio);
                        const opacity = 0.88 + (0.12 * centerRatio);
                        
                        frame.style.transform = `scale(${scale})`;
                        frame.style.opacity = `${opacity}`;
                    }
                });
            }
            
            if (scrollFrames.length > 0) {
                window.addEventListener('scroll', handleScrollFrame);
                // Initial run
                handleScrollFrame();
            }
        });
    </script>
</body>

</html>