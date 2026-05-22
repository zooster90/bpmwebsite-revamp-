<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="theme-color" content="#001F3F" />

    <title>@yield('title', 'Builtech Project Management | CIDB Grade G7 Contractor')</title>
    <meta name="description" content="@yield('description', 'Grade G7 Engineering & Construction Excellence since 1996. Delivering complex industrial and commercial landmarks across Malaysia.')">
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Open Graph --}}
    <meta property="og:title"       content="@yield('title', 'Builtech Project Management')">
    <meta property="og:description" content="@yield('description', 'CIDB G7 Construction Excellence since 1996.')">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:type"        content="website">
    @if(isset($ogImage) && $ogImage)
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"    content="@yield('title', 'Builtech') — Builtech Engineering Malaysia">
    @else
    <meta property="og:image"       content="{{ asset('img/logo.png') }}">
    @endif

    {{-- Twitter / X Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', 'Builtech Project Management')">
    <meta name="twitter:description" content="@yield('description', 'CIDB G7 Construction Excellence since 1996.')">
    @if(isset($ogImage) && $ogImage)
    <meta name="twitter:image"       content="{{ $ogImage }}">
    @else
    <meta name="twitter:image"       content="{{ asset('img/logo.png') }}">
    @endif

    {{-- Favicons --}}
    <link rel="icon"       type="image/png" sizes="32x32" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon"                           href="{{ asset('img/logo.png') }}">

    {{-- DNS Prefetch for speed --}}
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://maps.googleapis.com">

    {{-- Enterprise SEO: JSON-LD Structured Data --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "Builtech Project Management Sdn. Bhd.",
      "url": "https://www.builtech.com.my",
      "logo": "{{ asset('img/logo.png') }}",
      "foundingDate": "1996",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "17H, Level 1 - Level 3, Lebuhraya Batu Lanchang",
        "addressLocality": "Jelutong",
        "addressRegion": "Penang",
        "postalCode": "11600",
        "addressCountry": "MY"
      },
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+604-6593399",
        "contactType": "customer service"
      }
    }
    </script>

    {{-- Google Fonts — preconnect first, then stylesheet --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Oswald:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>

    {{-- Master CSS (load order: base → design system → fixes) --}}
    <link rel="stylesheet" href="{{ asset('css/builtech.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-design.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-fix.css') }}?v={{ time() }}">

    {{-- Tailwind CDN (utility layer) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              navy:       '#1a242f',
              'navy-dark': '#111827',
              gold:       '#c5a059',
              'gold-dark':'#a68546',
              'off-white':'#fcfbf8'
            },
            fontFamily: {
              heading: ['Oswald', 'sans-serif'],
              body:    ['Montserrat', 'sans-serif']
            }
          }
        }
      }
    </script>

    {{-- Vite (compiled CSS/JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* BUILTECH ELITE - GLOBAL DESIGN SYSTEM */
            --gold: #c5a059;
            --gold-dark: #a68546;
            --gold-light: #dfc8a0;
            --navy: #1a242f;
            --navy-dark: #111827;
            --white: #ffffff;
            --off-white: #fcfbf8;
            --transition-premium: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            
            --bt-font-body: 'Montserrat', sans-serif;
            --bt-font-display: 'Oswald', sans-serif;
        }

        /* 1. CUSTOM PREMIUM SCROLLBAR */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--navy-dark); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold-light); }

        html {
            font-size: 16px; /* Standard base — all typography uses rem relative to this */
        }
        
        body {
            font-family: var(--bt-font-body);
            color: var(--navy-dark); /* Extremely dark color for maximum contrast and legibility */
            font-size: 1.1rem; /* Base paragraph size explicitly enlarged */
            background: var(--white);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.85; /* Slightly increased line height for readability */
            overflow-x: hidden;
        }

        .bt-wrapper { overflow-x: hidden; }
        .bt-container { max-width: 1400px; margin: 0 auto; padding: 0 5%; }
        
        /* Typography */
        .bt-title { font-family: var(--bt-font-display); font-weight: 700; line-height: 1.1; letter-spacing: -0.02em; }
        .bt-serif { font-family: var(--bt-font-serif); font-style: italic; font-weight: 600; }
        .bt-text-gold { color: var(--bt-gold); }
        .bt-text-navy { color: var(--bt-navy); }

        /* Buttons & Badges */
        .bt-btn {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 1rem 2.5rem; border-radius: 4px;
            font-family: var(--bt-font-display); font-weight: 600; font-size: 0.95rem;
            letter-spacing: 0.05em; text-transform: uppercase;
            transition: all 0.4s var(--bt-ease); text-decoration: none;
            position: relative; overflow: hidden; z-index: 10; cursor: pointer;
        }
        .bt-btn-primary { background: var(--bt-gold); color: var(--bt-navy); box-shadow: var(--bt-shadow-gold); border: 1px solid var(--bt-gold); }
        .bt-btn-primary:hover { background: var(--bt-gold-hover); transform: translateY(-2px); box-shadow: 0 15px 40px -5px rgba(197,160,89,0.4); }
        .bt-btn-outline { border: 1px solid rgba(255,255,255,0.3); color: var(--bt-white); backdrop-filter: blur(10px); }
        .bt-btn-outline:hover { background: var(--bt-white); color: var(--bt-navy); }
        
        .bt-badge {
            display: inline-flex; align-items: center; padding: 0.6rem 1.2rem;
            background: rgba(197,160,89,0.1); border: 1px solid rgba(197,160,89,0.3); border-radius: 50px;
            color: var(--bt-gold); font-family: var(--bt-font-display); font-size: 0.8rem;
            font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 2rem;
        }
        .bt-badge i { margin-right: 0.5rem; }

        /* Glassmorphism Components */
        .bt-glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px; padding: 2.5rem;
            transition: transform 0.4s var(--bt-ease), background 0.4s var(--bt-ease);
        }
        .bt-glass-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(197,160,89,0.3);
        }
        .bt-stat-val {
            font-family: var(--bt-font-display); font-size: 3.5rem; font-weight: 700;
            color: var(--bt-white); line-height: 1; margin-bottom: 0.5rem;
        }
        .bt-stat-val span { color: var(--bt-gold); }
        .bt-stat-lbl {
            color: rgba(255,255,255,0.6); font-size: 0.9rem;
            text-transform: uppercase; letter-spacing: 0.1em; font-weight: 500;
        }

        /* Section Architecture */
        .bt-section { padding: 8rem 0; position: relative; }
        .bt-section-header {
            text-align: center; margin-bottom: 5rem; max-width: 800px;
            margin-left: auto; margin-right: auto;
        }
        .bt-section-header h2 {
            font-size: clamp(2.5rem, 4vw, 3.8rem);
            color: var(--bt-navy); margin-bottom: 1.5rem;
            font-family: var(--bt-font-display); font-weight: 700;
        }
        .bt-section-header p {
            font-size: 1.1rem; color: var(--bt-text-muted); line-height: 1.8;
        }

        /* Missing Global Typography Classes */
        .heading-main {
            font-family: var(--bt-font-display);
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 700;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--navy);
            margin-bottom: 1.5rem;
        }
        .tagline {
            display: block;
            color: var(--gold);
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 1rem;
        }
        .desc-text {
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.8;
            max-width: 850px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Bento Grid System */
        .bt-bento {
            display: grid; grid-template-columns: repeat(4, 1fr);
            grid-auto-rows: 320px; gap: 2rem;
        }
        .bt-bento-item {
            border-radius: 24px; position: relative; overflow: hidden;
            background: var(--bt-white); box-shadow: var(--bt-shadow-sm);
            transition: all 0.5s var(--bt-ease);
        }
        .bt-bento-item:hover {
            box-shadow: var(--bt-shadow-lg); transform: translateY(-8px);
        }
        .bt-bento-item.span-2 { grid-column: span 2; }
        .bt-bento-item.span-row-2 { grid-row: span 2; }
        
        .bt-bento-img {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; transition: transform 0.8s var(--bt-ease);
        }
        .bt-bento-item:hover .bt-bento-img { transform: scale(1.05); }
        .bt-bento-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(27,42,74,0.9) 0%, transparent 80%);
        }
        .bt-bento-content {
            position: absolute; inset: 0; padding: 2.5rem;
            display: flex; flex-direction: column; justify-content: flex-end; z-index: 2;
        }
        .bt-bento-item.has-bg .bt-bento-content { color: var(--bt-white); }
        .bt-bento-content h3 {
            font-family: var(--bt-font-display); font-size: 1.8rem;
            margin-bottom: 0.8rem; font-weight: 600;
        }
        .bt-bento-content p {
            font-size: 0.95rem; opacity: 0.85; line-height: 1.6; margin: 0;
        }
        .bt-bento-icon {
            width: 65px; height: 65px; border-radius: 50%;
            background: rgba(197,160,89,0.1); color: var(--bt-gold);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin-bottom: auto;
        }

        /* Project & Listing Components */
        .bt-project-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
        }
        .bt-project-card {
            display: block; position: relative; height: 500px;
            border-radius: 16px; overflow: hidden; text-decoration: none;
            border: 1px solid rgba(0,0,0,0.05); transition: all 0.5s var(--bt-ease);
        }
        .bt-project-card:hover { transform: translateY(-8px); box-shadow: var(--bt-shadow-lg); }
        .bt-project-card img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 1.2s var(--bt-ease), filter 0.8s;
            filter: brightness(0.7);
        }
        .bt-project-card:hover img { transform: scale(1.08); filter: brightness(0.4); }
        .bt-project-info {
            position: absolute; bottom: 0; left: 0; right: 0; padding: 3rem 2.5rem;
            background: linear-gradient(to top, rgba(27,42,74,0.95), transparent);
            transform: translateY(20px); transition: transform 0.5s var(--bt-ease);
        }
        .bt-project-card:hover .bt-project-info { transform: translateY(0); }
        .bt-project-cat {
            color: var(--bt-gold); font-size: 0.85rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: block;
        }
        .bt-project-title {
            color: var(--bt-white); font-family: var(--bt-font-display);
            font-size: 1.8rem; line-height: 1.2; font-weight: 700;
        }
        .bt-year-badge {
            position: absolute; top: 1.5rem; right: 1.5rem;
            background: rgba(255,255,255,0.95); color: var(--bt-navy);
            padding: 4px 12px; border-radius: 50px; font-weight: 800;
            font-size: 0.75rem; z-index: 5; box-shadow: var(--bt-shadow-sm);
        }
        .bt-project-meta {
            color: rgba(255,255,255,0.7); font-size: 0.9rem;
            display: flex; align-items: center; gap: 8px; margin-bottom: 8px;
        }
        .bt-project-meta i { color: var(--bt-gold); font-size: 0.8rem; }
        
        .bt-status-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 50px; font-weight: 700;
            font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em;
            margin-top: 1rem;
        }
        .pill-completed { background: rgba(56, 161, 105, 0.15); color: #2F855A; border: 1px solid rgba(56, 161, 105, 0.2); }
        .pill-ongoing { background: rgba(49, 130, 206, 0.15); color: #2B6CB0; border: 1px solid rgba(49, 130, 206, 0.2); }
        .pill-coming-soon { background: rgba(197, 160, 89, 0.15); color: #A88647; border: 1px solid rgba(197, 160, 89, 0.2); }

        /* Responsive Fixes */
        @media (max-width: 1024px) {
            .bt-bento { grid-template-columns: repeat(2, 1fr); }
            .bt-section { padding: 5rem 0; }
        }
        @media (max-width: 640px) {
            .bt-bento { grid-template-columns: 1fr; }
            .bt-bento-item.span-2 { grid-column: span 1; }
            .bt-project-card { height: 400px; }
        }

        /* Global Reveal Animation System */
        .reveal, .bt-reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 1.2s var(--bt-ease);
            will-change: opacity, transform;
        }
        .reveal.is-visible, .reveal.active, .bt-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Global Interactive Hover Upgrades */
        a { transition: all 0.3s var(--bt-ease); }
        .card, .bt-news-card, .bt-bento-item { transition: all 0.5s var(--bt-ease); }
        .card:hover { transform: translateY(-8px); box-shadow: var(--bt-shadow-lg); }

        /* Global Premium Lightbox Styling */
        .global-lightbox {
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(10, 25, 47, 0.95); 
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            display: none; align-items: center; justify-content: center;
            cursor: pointer; padding: 40px;
            opacity: 0; transition: opacity 0.4s var(--bt-ease);
        }
        .global-lightbox.show { 
            display: flex; 
            opacity: 1; 
        }
        .global-lightbox img {
            max-width: 90%; max-height: 85vh; object-fit: contain;
            border-radius: 12px; box-shadow: var(--bt-shadow-gold);
            transform: scale(0.95); transition: transform 0.4s var(--bt-ease);
        }
        .global-lightbox.show img { transform: scale(1); }
        
        .global-lightbox .lb-close {
            position: absolute; top: 30px; right: 30px; color: var(--bt-white); background: none; border: none;
            font-size: 2.5rem; cursor: pointer; opacity: 0.7; transition: var(--transition); line-height: 1;
        }
        .global-lightbox .lb-close:hover { opacity: 1; color: var(--bt-gold); transform: rotate(90deg); }

        /* Quiet Luxury Design Utilities */
        .bt-glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 30px rgba(10, 25, 47, 0.03);
            transition: all 0.5s var(--bt-ease);
        }
        
        .bt-plaque {
            background: #FFFFFF;
            border: 1px solid #F3F4F6;
            position: relative;
            transition: all 0.6s var(--bt-ease);
        }
        .bt-plaque::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 3px; height: 0;
            background: var(--bt-gold);
            transition: height 0.6s var(--bt-ease);
        }
        .bt-plaque:hover::before { height: 100%; }
        
        .bt-glow {
            position: relative;
        }
        .bt-glow::after {
            content: '';
            position: absolute;
            inset: -20px;
            background: radial-gradient(circle, rgba(197,160,89,0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.8s var(--bt-ease);
            pointer-events: none;
        }
        .bt-glow:hover::after { opacity: 1; }

        .bt-text-gradient {
            background: linear-gradient(135deg, var(--bt-navy) 0%, #1a2a4a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Smooth Scrolling for Anchor Links */
        html { scroll-behavior: smooth; }
    </style>

    {{-- Per-page styles --}}
    @stack('styles')

    {{-- Per-page meta / structured data --}}
    @stack('meta')
</head>
<body class="antialiased bg-white text-navy font-body selection:bg-gold selection:text-white">

    @include('partials.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- ═══════════════════════════════════════════════════════
         GLOBAL PREMIUM LIGHTBOX HTML
         Replaced old inline onclick overlay with clean system
         ═══════════════════════════════════════════════════════ --}}
    <div id="imageOverlay" class="global-lightbox" role="dialog" aria-modal="true">
        <button class="lb-close" aria-label="Close Lightbox">&times;</button>
        <img id="overlayImg" src="" alt="Full-size Preview">
    </div>

    <!-- FAB Removed to prevent overlap with bottom navigation bar -->

    <!-- ── PREMIUM CUSTOM CURSOR SYSTEM REMOVED PER USER REQUEST ── -->

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- ═══════════════════════════════════════════════════════
         GLOBAL SCRIPTS (Reveal Observer, Lightbox, Utilities)
         ═══════════════════════════════════════════════════════ --}}
    <script>
    (function(){
        // ── 1. Global Reveal Observer & Auto-Enhancer ──
        const io = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if(e.isIntersecting){
                    var el = e.target;
                    var delay = parseInt(el.getAttribute('data-delay') || 0);
                    // Slight random delay to ensure extremely fluid staggers
                    setTimeout(function(){
                        el.classList.add('is-visible');
                        el.classList.add('active');
                    }, delay);
                    io.unobserve(el); // Stop observing once revealed for performance
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        function observeReveals(){
            // Auto-Enhance Frontend Pages: Automatically add animation classes to elements that don't have them yet!
            const mainContent = document.getElementById('main-content');
            if(mainContent && !document.querySelector('.bt-hero')) { 
                // Don't auto-enhance the welcome page as it has highly custom animations
                const elementsToAnimate = mainContent.querySelectorAll('h1, h2, h3, p:not(.nav-drop-link), img, .card, table, ul li');
                let delayCounter = 0;
                
                elementsToAnimate.forEach(el => {
                    // Skip if already animated or part of a component that manages its own animations
                    if(!el.classList.contains('reveal') && !el.classList.contains('bt-reveal') && !el.closest('nav')) {
                        el.classList.add('reveal');
                        el.setAttribute('data-delay', (delayCounter % 5) * 100);
                        delayCounter++;
                    }
                });
            }

            // Observe all reveal classes
            document.querySelectorAll('.reveal, .bt-reveal').forEach(function(el){ io.observe(el); });
        }

        // ── 2. Global Premium Lightbox Logic ──
        window.openGlobalLightbox = function(src) {
            const lb = document.getElementById('imageOverlay');
            const img = document.getElementById('overlayImg');
            if (lb && img) {
                img.src = src; 
                lb.classList.add('show'); 
                document.body.style.overflow = 'hidden';
            }
        }

        window.closeGlobalLightbox = function() {
            const lb = document.getElementById('imageOverlay');
            if (lb) { 
                lb.classList.remove('show'); 
                document.body.style.overflow = ''; 
            }
        }

        // ── 4. Global Counter Animation System ──
        const counterObserver = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
                if (entry.isIntersecting) {
                    const target = +entry.target.dataset.target;
                    let count = 0;
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    
                    const update = () => {
                        count += increment;
                        if (count < target) {
                            entry.target.innerText = Math.floor(count);
                            requestAnimationFrame(update);
                        } else {
                            entry.target.innerText = target;
                        }
                    };
                    update();
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        function initCounters() {
            document.querySelectorAll('.counter').forEach(function(c) {
                counterObserver.observe(c);
            });
        }

        function initGlobalScripts(){
            observeReveals();
            initCounters();

            // ── 5. Mobile Haptic Tap Feedback ──
            function triggerHaptics() {
                if ('vibrate' in navigator) {
                    navigator.vibrate(12);
                }
            }
            document.querySelectorAll('.btn-primary, .btn-navy, .btn-outline-gold, .btn-attention, button[type="submit"], #mobileFAB, #backToTop').forEach(function(el) {
                el.addEventListener('click', triggerHaptics, { passive: true });
            });

            // Removed custom magnetic cursor per user request

            const lb = document.getElementById('imageOverlay');
            if(lb) {
                // Close on backdrop click
                lb.addEventListener('click', function(e){
                    if(e.target === lb || e.target.classList.contains('lb-close')) {
                        closeGlobalLightbox();
                    }
                });
                // Close on image click (optional, but good UX)
                document.getElementById('overlayImg')?.addEventListener('click', function(e){
                    e.stopPropagation(); // Prevent closing if clicking the image itself
                });
            }

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeGlobalLightbox();
            });
        }

        if(document.readyState === 'loading'){
            document.addEventListener('DOMContentLoaded', initGlobalScripts);
        } else { 
            initGlobalScripts(); 
        }

        // Re-observe if new content is loaded dynamically
        window.reObserve = observeReveals;

        // ── 3. Back to Top Visibility ──
        window.addEventListener('scroll', function(){
            var btn = document.getElementById('backToTop');
            if(btn) btn.classList.toggle('visible', window.scrollY > 500);
        }, { passive: true });

    })();
    </script>

    @stack('scripts')
</body>
</html>