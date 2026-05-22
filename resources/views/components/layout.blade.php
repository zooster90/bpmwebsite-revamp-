@props(['title' => 'Builtech Project Management Sdn. Bhd.', 'description' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @if($description)
    <meta name="description" content="{{ $description }}">
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Social Preview --}}
    <meta property="og:title" content="{{ $title }}">
    @if($description)
    <meta property="og:description" content="{{ $description }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Builtech Project Management">
    <meta property="og:locale" content="en_MY">
    @if(isset($ogImage) && $ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $title }} — Builtech Engineering Malaysia">
    @else
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    @endif

    {{-- Twitter / X Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    @if($description)
    <meta name="twitter:description" content="{{ $description }}">
    @endif
    @if(isset($ogImage) && $ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
    @else
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    @endif

    {{-- Fonts: Standard Corporate (Montserrat + Outfit) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Icon Libraries --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />

    @stack('styles')

    {{-- AOS Animation Library --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- ============================================== --}}
    {{-- [SENIOR FIX] Global Design System & Variables --}}
    {{-- ============================================== --}}
    <style>
        [x-cloak] { display: none !important; }
        
        :root {
            /* Bright & Gold Premium Theme Tokens */
            --color-gold: #c5a059;
            --color-gold-hover: #b38f4d;
            --color-navy: #1a242f;
            --color-bright-base: #ffffff;
            --color-bright-off: #fafaf9;
            --color-bright-warm: #f4eee0;
            --font-body: 'Montserrat', sans-serif;
            --font-heading: 'Outfit', sans-serif;
            --nav-height: 80px;
        }

        body { 
            font-family: var(--font-body); 
            color: var(--color-navy);
            background-color: var(--color-bright-base);
            -webkit-font-smoothing: antialiased;
        }

        .font-heading { font-family: var(--font-heading); }
        
        /* 强制统一的 Container */
        .container-tidy { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }

        /* 防止 Fixed Navbar 导致的内容塌陷 */
        main { display: block; width: 100%; position: relative; overflow: hidden; }

        /* 隔离 Back to top 按钮 */
        .back-to-top-wrapper { position: fixed; bottom: 2rem; right: 2rem; z-index: 50; pointer-events: none; }
        .back-to-top-wrapper button { pointer-events: auto; }

        /* ── Image Copyright Watermark & Security Shield ── */
        .img-copyright-wrapper { 
            position: relative; 
            display: inline-block; 
            max-width: 100%; 
            overflow: hidden;
            user-select: none;
            -webkit-user-select: none;
        }
        
        /* Transparent CSS Click-Shield: Blocks right-clicking and dragging */
        .img-copyright-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: transparent;
            z-index: 5;
            pointer-events: auto;
        }

        .img-copyright-wrapper img {
            user-drag: none;
            -webkit-user-drag: none;
            pointer-events: none;
        }

        /* Gold-Branded Premium Watermark Badge */
        .img-copyright-wrapper::after {
            content: "© BUILTECH • WE BUILD TO LAST";
            position: absolute;
            bottom: 12px;
            right: 12px;
            color: #ffffff;
            font-family: var(--font-heading);
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            background: rgba(26, 36, 47, 0.9);
            border: 1px solid rgba(197, 160, 89, 0.5);
            padding: 5px 12px;
            border-radius: 50px;
            pointer-events: none;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 10;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .img-copyright-wrapper:hover::after {
            background: rgba(197, 160, 89, 0.95);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 6px 20px rgba(197, 160, 89, 0.4);
            transform: translateY(-2px);
        }
    </style>

    {{-- Alpine.js Engine with Plugins --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Schema: LocalBusiness --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Builtech Project Management Sdn. Bhd.',
        'description' => 'CIDB Grade G7 contractor with 30+ years delivering quality construction across Malaysia.',
        'url' => url('/'),
        'telephone' => '+604-659 3399',
        'email' => 'contact@builtech.com.my',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '17H, Level 1-Level 3, Lebuhraya Batu Lanchang',
            'addressLocality' => 'Jelutong, Penang',
            'postalCode' => '11600',
            'addressCountry' => 'MY'
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- Page-specific head content (Schema.org, etc.) --}}
    @stack('head')
</head>

<body class="bg-white overflow-x-hidden">

    <x-navbar />

    <main>
        {{ $slot }}
    </main>

    <x-footer />

    {{-- Back to Top (Uses CSS Variables) --}}
    <div class="back-to-top-wrapper" x-data="{ showTop: false }" @scroll.window="showTop = (window.scrollY > 400)">
        <button x-show="showTop" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-10"
                x-transition:enter-end="opacity-100 translate-y-0"
                @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="w-12 h-12 shadow-2xl flex items-center justify-center hover:-translate-y-1 transition-all focus:outline-none border border-white/20"
                style="background-color: var(--color-gold); color: white;"
                aria-label="Scroll to top">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
        </button>
    </div>

    @stack('scripts')
    
    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });

            // Automatically apply AOS to content elements for one-shot scroll animation
            const animateElements = document.querySelectorAll('main h1, main h2, main h3, main p, main .card, main .glass-card, main img');
            animateElements.forEach((el, index) => {
                if (!el.classList.contains('reveal') && !el.closest('.reveal') && !el.closest('.hero')) {
                    if (!el.hasAttribute('data-aos')) {
                        el.setAttribute('data-aos', 'fade-up');
                        el.setAttribute('data-aos-delay', (index % 4) * 100);
                    }
                }
            });

            // Automatically wrap large images for copyright watermark
            document.querySelectorAll('main img').forEach(img => {
                // Ignore small images, icons, logos
                if (img.closest('header') || img.closest('nav') || img.closest('.iso-strip') || img.closest('.stat-item') || img.clientWidth < 150) return;
                
                if (!img.closest('.img-copyright-wrapper')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'img-copyright-wrapper';
                    const displayStyle = window.getComputedStyle(img).display;
                    wrapper.style.display = (displayStyle === 'inline' || displayStyle === 'inline-block') ? 'inline-block' : 'block';
                    
                    if (img.parentElement && img.parentElement.tagName !== 'PICTURE') {
                        img.parentNode.insertBefore(wrapper, img);
                        wrapper.appendChild(img);
                    }
                }
            });
            
            // Refresh AOS after DOM changes
            setTimeout(() => AOS.refresh(), 500);
        });
    </script>
</body>
</html>