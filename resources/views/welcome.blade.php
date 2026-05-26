@extends('layouts.app')

@section('title', 'Builtech | We Built To Last')

@section('meta')
    <meta name="description" content="Grade G7 Engineering & Construction Excellence since 1996. Delivering integrated solutions for industrial and commercial landmarks across Malaysia.">
@endsection

@push('styles')
<style>
    /* ============================================================
       BUILTECH ELITE - INDEX PAGE (FINAL PRECISION REPLICA)
       ============================================================ */
    
    .hero {
        height: 100vh;
        min-height: 700px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        overflow: hidden;
        background: #000;
        z-index: 5;
    }

    .hero-slider {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    .hero-slider .slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transform: scale(1.1);
        transition: opacity 2s cubic-bezier(0.4, 0, 0.2, 1), transform 12s linear;
    }

    .hero-slider .slide.active {
        opacity: 1;
        transform: scale(1);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(17, 24, 39, 0.4) 0%, rgba(17, 24, 39, 0.85) 100%);
        z-index: 2;
    }

    .hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        width: 90%;
        max-width: 1100px;
        padding: clamp(2.5rem, 6vw, 5rem);
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        margin: 0 auto;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.45);
    }

    .main-slogan {
        font-family: "Oswald", sans-serif;
        font-size: clamp(0.9rem, 3vw, 1.4rem);
        color: var(--gold) !important;
        letter-spacing: clamp(4px, 2vw, 10px);
        text-transform: uppercase;
        margin-bottom: 1.8rem;
        font-weight: 600;
        display: block;
    }

    .hero-content h1 img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
        filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.4)) brightness(0) invert(1);
    }

    .sub-slogan {
        font-size: clamp(1rem, 2.8vw, 1.25rem);
        letter-spacing: 0.5px;
        opacity: 0.96;
        max-width: 800px;
        margin: 0 auto;
        color: var(--white);
        line-height: 1.8;
    }

    /* STATS SECTION OVERLAP */
    .big-4-section {
        position: relative;
        z-index: 100;
        margin-top: -6.5rem;
        padding: 0 5%;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        max-width: 1320px;
        margin: 0 auto;
        background: var(--white);
        box-shadow: 0 30px 60px rgba(0,0,0,0.12);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
    }

    @media (max-width: 991px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .big-4-section { margin-top: -4rem; }
    }

    .stat-item {
        text-align: center;
        padding: clamp(3rem, 6vw, 4.5rem) 1.5rem;
        border-right: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        background: #fff;
        transition: var(--transition-premium);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .stat-item:hover { background: #fdfbf7; transform: translateY(-8px); z-index: 2; box-shadow: 0 15px 30px rgba(0,0,0,0.05); }

    .stat-label { color: var(--gold); text-transform: uppercase; font-size: 0.85rem; font-weight: 800; letter-spacing: 2.5px; margin-bottom: 1.2rem; display: block; }
    .stat-value { 
        font-family: "Oswald", sans-serif; 
        font-size: clamp(3.2rem, 8vw, 4.8rem); 
        line-height: 1; 
        font-weight: 700;
        background: linear-gradient(110deg, #c5a059 20%, #e6ca85 40%, #fff6cc 50%, #ffffff 55%, #fff6cc 60%, #e6ca85 70%, #c5a059 90%);
        background-size: 200% auto;
        color: #c5a059;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: goldShine 4s linear infinite;
        filter: drop-shadow(0 2px 8px rgba(197, 160, 89, 0.3));
    }
    .stat-stars { 
        font-size: 2.8rem; 
        line-height: 1;
        display: inline-block;
        background: linear-gradient(110deg, #c5a059 20%, #e6ca85 40%, #fff6cc 50%, #ffffff 55%, #fff6cc 60%, #e6ca85 70%, #c5a059 90%);
        background-size: 200% auto;
        color: #c5a059;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: goldShine 4s linear infinite;
        filter: drop-shadow(0 2px 8px rgba(197, 160, 89, 0.3));
    }
    @keyframes goldShine {
        0% { background-position: 0% center; }
        100% { background-position: 200% center; }
    }
    .stat-desc { color: #64748b; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; margin-top: 1rem; letter-spacing: 0.5px; display: block; }

    /* MANAGEMENT EXCELLENCE */
    .management-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 80px;
        align-items: center;
    }

    @media (max-width: 1024px) {
        .management-grid { grid-template-columns: 1fr; gap: 50px; }
    }

    .management-img { width: 100%; border-radius: 16px; box-shadow: 0 25px 50px rgba(0,0,0,0.1); }
    .management-badge {
        position: absolute;
        bottom: -25px;
        left: -25px;
        background: var(--gold);
        color: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(197, 160, 89, 0.4);
        z-index: 10;
        text-align: center;
    }

    /* ADVANTAGE GRID */
    .advantage-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 80px;
    }
    @media (max-width: 768px) { .advantage-grid { grid-template-columns: 1fr; margin-top: 50px; } }

    .adv-card {
        padding: 40px 35px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        transition: var(--transition-premium);
        border-bottom: 4px solid var(--gold);
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
    }
    .adv-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px rgba(197, 160, 89, 0.15); background: #fdfbf7; }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: rgba(197, 160, 89, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        transition: var(--transition-premium);
    }
    .adv-card:hover .icon-wrapper { transform: scale(1.1) rotate(5deg); background: rgba(197, 160, 89, 0.2); }
    .icon-wrapper i { color: var(--gold); font-size: 1.8rem; }

    /* PORTFOLIO SCROLL */
    .modern-horizontal-scroll {
        display: flex;
        flex-wrap: nowrap;
        gap: 2.5rem;
        overflow-x: auto;
        padding: 30px 5% 70px;
        scroll-snap-type: x mandatory;
        scrollbar-width: none;
        cursor: grab;
    }
    .modern-horizontal-scroll.active {
        cursor: grabbing;
    }
    .modern-horizontal-scroll::-webkit-scrollbar { display: none; }

    .project-card {
        flex: 0 0 auto;
        width: 440px;
        height: 520px;
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.1);
        transition: var(--transition-premium);
        text-decoration: none;
        user-select: none;
        -webkit-user-drag: none;
    }
    .project-card:hover { transform: translateY(-15px); box-shadow: 0 45px 80px rgba(0,0,0,0.25); }

    .project-card img { width: 100%; height: 100%; object-fit: cover; transition: 1.2s cubic-bezier(0.165, 0.84, 0.44, 1); user-select: none; -webkit-user-drag: none; }
    .project-card:hover img { transform: scale(1.1); filter: brightness(0.85); }

    .project-status-tag {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        background: var(--gold);
        color: white;
        padding: 0.65rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 800;
        border-radius: 40px;
        z-index: 5;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .project-info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 6rem 3rem 3rem;
        background: linear-gradient(transparent, rgba(17, 24, 39, 0.98));
        color: white;
    }

    .all-records-card {
        flex: 0 0 auto;
        width: 440px;
        height: 520px;
        background: linear-gradient(135deg, #1a242f 0%, #111827 100%);
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 50px;
        text-decoration: none;
        border: 2px solid rgba(197, 160, 89, 0.2);
        transition: var(--transition-premium);
        color: white !important;
        user-select: none;
        -webkit-user-drag: none;
    }
    .all-records-card:hover { border-color: var(--gold); transform: translateY(-15px); box-shadow: 0 30px 60px rgba(197,160,89,0.15); }

    .slider-progress-container {
        position: absolute;
        bottom: 3.5rem;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 1.2rem;
        z-index: 30;
    }
    .prog-bar { width: 65px; height: 3px; background: rgba(255,255,255,0.25); border-radius: 4px; overflow: hidden; }

    /* TEAM SECTION & CTA (Imported from index.css to ensure flawless rendering) */
    .team-section {
        display: flex;
        flex-wrap: wrap;
        background: var(--navy);
    }

    .team-img-bg {
        flex: 1 1 50%;
        min-height: 400px;
        background: url('{{ asset('img/images/Welcome _ Builtech Project Management_files/22(3).jpg') }}') center/cover no-repeat;
    }

    .team-content {
        flex: 1 1 50%;
        padding: clamp(4rem, 8vw, 8rem) clamp(2rem, 6vw, 6rem);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .final-cta {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
        padding: 100px 5%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-bg-icon {
        position: absolute;
        top: -50px;
        left: -50px;
        font-size: 300px;
        color: rgba(255, 255, 255, 0.08);
        transform: rotate(-15deg);
        z-index: 1;
    }

    /* 📱 MOBILE INTERACTIVE UX ENHANCEMENTS - "一镜到底" (Continuous Cinematic) */
    @media (max-width: 768px) {
        /* Immersive Team Section on Mobile */
        .team-section {
            position: relative;
            flex-direction: column;
            overflow: hidden;
            background: #0f172a;
            min-height: 100vh; /* Full screen cinematic feel */
            display: flex;
        }
        .team-img-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            flex: none;
            z-index: 1;
            /* Subtle parallax/pan animation for mobile */
            animation: mobilePan 25s infinite alternate linear;
            filter: brightness(0.75);
        }
        .team-section::after {
            content: '';
            position: absolute;
            inset: 0;
            /* Seamless gradient from top to bottom to blend with surrounding sections */
            background: linear-gradient(to bottom, rgba(15, 23, 42, 1) 0%, rgba(15, 23, 42, 0.2) 30%, rgba(15, 23, 42, 0.4) 70%, rgba(15, 23, 42, 1) 100%);
            z-index: 2;
            pointer-events: none;
        }
        .team-content {
            flex: 1 1 100%;
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem 1.5rem 6rem;
            text-align: center;
        }
        .team-content h2 { font-size: 2.5rem !important; margin-bottom: 15px !important; text-shadow: 0 4px 20px rgba(0,0,0,0.5); }
        .team-content p { font-size: 1rem; text-align: center; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        .team-content .btn-primary { margin: 0 auto; width: 90%; display: block; box-shadow: 0 10px 30px rgba(197, 160, 89, 0.3); }
    }

    @keyframes mobilePan {
        0% { transform: scale(1.15) translate(0, 0); }
        50% { transform: scale(1.15) translate(-4%, 2%); }
        100% { transform: scale(1.15) translate(4%, -2%); }
    }

    @media (max-width: 768px) {
        .project-card, .all-records-card {
            width: 85vw; /* Show 85% of screen width so the next card peeks out, hinting scroll */
            height: 420px;
        }
        .modern-horizontal-scroll {
            padding: 20px 5% 40px;
            gap: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="bt-wrapper">
    <!-- ========== HERO SECTION ========== -->
    <header class="hero">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1920');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=1920');"></div>
            <div class="slide" style="background-image: url('{{ asset('img/images/Aston Acasia.jpeg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('img/images/Aston Acacia,Bukit Mertajam,Penang.jpg') }}');"></div>
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content reveal">
            <span class="main-slogan">CIDB Grade 7 Certified</span>
            <h1><img src="{{ asset('img/webuiltolast.png') }}" alt="We Built To Last"></h1>
            <p class="sub-slogan">
                Delivering engineering excellence and unlimited construction capacity for Malaysia's most complex industrial and commercial landmarks.
            </p>
            <div style="margin-top: 45px;"><a href="{{ route('services.index') }}" class="btn-primary">OUR EXPERTISE</a></div>
        </div>
        <div class="slider-progress-container" id="progContainer"></div>
    </header>

    <!-- ========== STATS SECTION ========== -->
    <section class="big-4-section">
        <div class="stats-grid">
            <div class="stat-item reveal stagger-1">
                <span class="stat-label">CIDB RATING</span>
                <div class="stat-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span class="stat-desc">GRADE G7</span>
            </div>
            <div class="stat-item reveal stagger-2">
                <span class="stat-label">Market Presence</span>
                <div class="stat-value"><span class="counter" data-target="{{ date('Y') - 1996 }}">0</span>+</div>
                <span class="stat-desc">Years of Excellence</span>
            </div>
            <div class="stat-item reveal stagger-3">
                <span class="stat-label">QLASSIC Quality</span>
                <div class="stat-value"><span class="counter" data-target="82">0</span>%</div>
                <span class="stat-desc">Highest Standards</span>
            </div>
            <div class="stat-item reveal stagger-4">
                <span class="stat-label">EHS COMPLIANCE</span>
                <div class="stat-value"><span class="counter" data-target="83">0</span>%</div>
                <span class="stat-desc">Safety Excellence</span>
            </div>
        </div>
    </section>

    <!-- ========== MANAGEMENT EXCELLENCE ========== -->
    <section class="section-padding bg-white">
        <div class="bt-container" style="max-width: 1320px; margin: 0 auto;">
            <div class="management-grid">
                <div class="reveal">
                    <span class="tagline">Management Excellence</span>
                    <h2 class="heading-main">Integrated Solutions for a Dynamic World.</h2>
                    <p class="desc-text">
                        Builtech Project Management Sdn. Bhd. stands as a premier CIDB Grade 7 contractor. We manage risks, optimize timelines, and ensure every bolt meets international ISO standards.
                    </p>
                    <p class="desc-text" style="margin-top: 20px;">From design-build phases to turnkey handovers, our methodology is rooted in technical superiority.</p>
                </div>

                <div class="reveal" style="position: relative">
                    <img src="{{ asset('img/images/istockphoto-838476004-612x612.jpg') }}" class="management-img" alt="Builtech Construction">
                    <div class="management-badge">
                        <span style="font-family: 'Oswald', sans-serif; font-size: 3rem; display: block; line-height: 1;">100+</span>
                        <span style="font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;">Successful Handovers</span>
                    </div>
                </div>
            </div>

            <div class="advantage-grid reveal">
                <div class="adv-card">
                    <div class="icon-wrapper"><i class="fas fa-shield-alt"></i></div>
                    <h4 style="font-family: 'Oswald', sans-serif; font-size: 1.3rem; margin-bottom: 12px; color: var(--navy); font-weight: 700;">Uncompromising Integrity</h4>
                    <p style="font-size: 0.95rem; color: #64748b; line-height: 1.6;">Absolute transparency ensuring stakeholder trust and complete peace of mind at every project stage.</p>
                </div>
                <div class="adv-card">
                    <div class="icon-wrapper"><i class="fas fa-microchip"></i></div>
                    <h4 style="font-family: 'Oswald', sans-serif; font-size: 1.3rem; margin-bottom: 12px; color: var(--navy); font-weight: 700;">Technical Mastery</h4>
                    <p style="font-size: 0.95rem; color: #64748b; line-height: 1.6;">Advanced engineering protocols and cutting-edge BIM modeling for complex industrial structures.</p>
                </div>
                <div class="adv-card">
                    <div class="icon-wrapper"><i class="fas fa-check-double"></i></div>
                    <h4 style="font-family: 'Oswald', sans-serif; font-size: 1.3rem; margin-bottom: 12px; color: var(--navy); font-weight: 700;">Quality Verified</h4>
                    <p style="font-size: 0.95rem; color: #64748b; line-height: 1.6;">Top-tier QLASSIC and CONQUAS standards verified on every single turnkey project handover.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FLAGSHIP PROJECTS ========== -->
    <section class="section-padding bg-off-white">
        <div class="bt-container text-center" style="margin-bottom: 40px;">
            <span class="tagline reveal">Portfolio</span>
            <h2 class="heading-main reveal">FLAGSHIP LANDMARKS</h2>
            
            <div class="flex items-center justify-center gap-6 mt-8 reveal delay-100">
                <button id="btn-scroll-left" class="cursor-pointer hover:bg-gold/10 p-2 rounded-full transition-colors duration-300" aria-label="Scroll Left">
                    <i class="fa-solid fa-arrow-left-long text-gold text-xl hover:scale-110 transition-transform"></i>
                </button>
                <div class="bg-navy/5 border border-navy/10 px-6 py-3 rounded-full flex items-center gap-3 cursor-grab" id="drag-indicator">
                    <i class="fa-solid fa-hand-pointer text-gold text-lg"></i>
                    <span class="font-bold text-navy text-sm uppercase tracking-widest">Drag or Click Arrows</span>
                </div>
                <button id="btn-scroll-right" class="cursor-pointer hover:bg-gold/10 p-2 rounded-full transition-colors duration-300" aria-label="Scroll Right">
                    <i class="fa-solid fa-arrow-right-long text-gold text-xl hover:scale-110 transition-transform"></i>
                </button>
            </div>
        </div>
        
        <div class="modern-horizontal-scroll scrollbar-none">
            @foreach($flagships as $p)
                <a href="{{ route('projects.show', $p->slug) }}" class="project-card reveal group">
                    <div class="project-status-tag"><i class="fas fa-star" style="margin-right: 6px;"></i> FLAGSHIP</div>
                    
                    <!-- Child-Proof Click Overlay -->
                    <div class="absolute inset-0 z-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" style="background: rgba(17,24,39,0.3);">
                        <span class="bg-gold text-white font-bold text-sm uppercase tracking-widest px-8 py-4 rounded-full shadow-2xl transform translate-y-8 group-hover:translate-y-0 transition-transform duration-500 flex items-center gap-3 border-2 border-white/20">
                            Click To View Details <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>

                    @php
                        $flagshipImg = $p->hasMedia('cover_image')
                            ? ($p->getFirstMediaUrl('cover_image', 'card') ?: $p->getFirstMediaUrl('cover_image'))
                            : $p->display_image;
                    @endphp
                    <img src="{{ $flagshipImg }}" alt="{{ $p->title ?? $p->name }}" loading="lazy" decoding="async" width="800" height="600">
                    <div class="project-info relative z-20">
                        <p style="color:#c5a059; font-size:0.75rem; letter-spacing:2.5px; font-weight:800; text-transform:uppercase;">{{ $p->location }}</p>
                        <h4 style="font-family:'Oswald', sans-serif; font-size:1.8rem; margin-top:8px;">{{ $p->title ?? $p->name }}</h4>
                    </div>
                </a>
            @endforeach
            
            <a href="{{ route('projects.index') }}" class="all-records-card reveal">
                <h3 style="font-family: 'Oswald', sans-serif; font-size: 2.8rem; color: white; line-height: 1.1; margin-bottom: 25px;">VIEW FULL <br />TRACK RECORD</h3>
                <div style="width: 50px; height: 3px; background: var(--gold); margin-bottom: 25px;"></div>
                <p style="color: var(--gold); font-weight: 800; font-size: 1.2rem; letter-spacing: 1.5px; text-transform: uppercase;">{{ date('Y') - 1996 }} Years of Success</p>
            </a>
        </div>
    </section>

    <!-- ========== CURRENT DEVELOPMENTS ========== -->
    @if(isset($ongoingProjects) && count($ongoingProjects) > 0)
    <section class="section-padding bg-white">
        <div class="bt-container text-center" style="margin-bottom: 60px;">
            <span class="tagline reveal">In Progress</span>
            <h2 class="heading-main reveal">CURRENT DEVELOPMENTS</h2>
        </div>
        
        <div class="bt-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($ongoingProjects as $op)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-100 hover:-translate-y-2 transition-transform duration-300 reveal group">
                        <div class="relative h-60 overflow-hidden">
                            <div class="absolute top-4 right-4 bg-gold text-white text-[10px] font-bold px-4 py-2 rounded-full z-10 tracking-[0.2em] uppercase shadow-md">
                                Ongoing
                            </div>
                            @php
                                $opImg = $op->hasMedia('cover_image')
                                    ? ($op->getFirstMediaUrl('cover_image', 'card') ?: $op->getFirstMediaUrl('cover_image'))
                                    : ($op->display_image ?? asset('img/images/placeholder.jpg'));
                            @endphp
                            <img src="{{ $opImg }}" alt="{{ $op->title ?? $op->name }}" loading="lazy" decoding="async" width="800" height="600" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="p-6">
                            <span class="text-gold font-bold text-[10px] uppercase tracking-[0.2em] mb-2 block">{{ $op->category?->name ?? 'Construction' }}</span>
                            <h3 class="font-heading text-lg text-navy font-bold mb-2 leading-tight" style="font-family: 'Oswald', sans-serif;">{{ $op->title ?? $op->name }}</h3>
                            <div class="text-gray-500 text-xs flex items-center gap-2 mt-4 font-medium">
                                <i class="fa-solid fa-map-marker-alt text-gold"></i> {{ $op->location ?? 'Malaysia' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ========== AWARDS & ISO ========== -->
    <section class="section-padding bg-white">
        <div class="bt-container text-center">
            <span class="tagline reveal">Accreditations</span>
            <h2 class="heading-main reveal">CERTIFIED EXCELLENCE</h2>
            
            <div class="iso-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 35px; margin-top: 60px;">
                <div class="iso-card reveal stagger-1" style="background: var(--off-white); padding: 45px; border-radius: 20px; transition: var(--transition-premium); border: 1px solid #eee;">
                    <h3 style="font-family: 'Oswald', sans-serif; font-size: 1.5rem; color: var(--navy); margin-bottom: 25px;">ISO 9001:2015</h3>
                    <div class="iso-img-wrapper"><img src="{{ asset('img/images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg') }}" alt="ISO 9001" style="height: 60px; margin-bottom: 20px;"></div>
                    <h4 style="font-size: 0.8rem; color: #7f8c8d; font-weight: 700; letter-spacing: 1px;">MY10/00630.01</h4>
                </div>
                <div class="iso-card reveal stagger-2" style="background: var(--off-white); padding: 45px; border-radius: 20px; transition: var(--transition-premium); border: 1px solid #eee;">
                    <h3 style="font-family: 'Oswald', sans-serif; font-size: 1.5rem; color: var(--navy); margin-bottom: 25px;">ISO 45001:2018</h3>
                    <div class="iso-img-wrapper"><img src="{{ asset('img/images/SGS_ISO 45001 DSM Mark_TCL_LR.jpg') }}" alt="ISO 45001" style="height: 60px; margin-bottom: 20px;"></div>
                    <h4 style="font-size: 0.8rem; color: #7f8c8d; font-weight: 700; letter-spacing: 1px;">MY10/00630.03</h4>
                </div>
                <div class="iso-card reveal stagger-3" style="background: var(--off-white); padding: 45px; border-radius: 20px; transition: var(--transition-premium); border: 1px solid #eee;">
                    <h3 style="font-family: 'Oswald', sans-serif; font-size: 1.5rem; color: var(--navy); margin-bottom: 25px;">ISO 14001:2015</h3>
                    <div class="iso-img-wrapper"><img src="{{ asset('img/images/ISO_14001_Latest.jpg') }}" alt="ISO 14001" style="height: 60px; margin-bottom: 20px;"></div>
                    <h4 style="font-size: 0.8rem; color: #7f8c8d; font-weight: 700; letter-spacing: 1px;">MY21/00000.01</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CHRONICLES SECTION ========== -->
    <section class="bg-off-white" style="padding: 130px 5% 110px;">
        <div class="bt-container text-center" style="margin-bottom: 60px;">
            <div class="reveal" style="width: 60px; height: 3px; background: var(--gold); margin: 0 auto 25px;"></div>
            <span class="tagline reveal delay-100">Stay Updated</span>
            <h2 class="heading-main reveal delay-200">BUILTECH CHRONICLES</h2>
            <p class="desc-text reveal delay-300" style="font-size: 1.2rem; color: #64748b; max-width: 850px; margin: 0 auto;">
                Explore our latest milestones, project updates, and company achievements in our interactive master archive.
            </p>
        </div>

        @if(isset($latest_news) && count($latest_news) > 0)
        <div class="bt-container">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                @foreach($latest_news as $news)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 reveal border border-gray-100 group">
                        <div class="relative h-64 overflow-hidden">
                            @php
                                $newsImg = $news->hasMedia('news_image')
                                    ? ($news->getFirstMediaUrl('news_image', 'card') ?: $news->getFirstMediaUrl('news_image'))
                                    : $news->display_image;
                            @endphp
                            <img src="{{ $newsImg }}" alt="{{ $news->title }}" loading="lazy" decoding="async" width="800" height="600" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                        <div class="p-8 text-left">
                            <span style="display:block; font-size:0.8rem; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:0.5rem;">
                                {{ $news->published_date ? \Carbon\Carbon::parse($news->published_date)->format('d M Y') : 'Recent Update' }}
                            </span>
                            <h3 style="font-family:'Oswald',sans-serif; font-size:1.3rem; font-weight:700; color:var(--navy); margin-bottom:0.8rem; line-height:1.25;">{{ $news->title }}</h3>
                            <p style="font-size:0.95rem; color:#4b5563; line-height:1.75; margin-bottom:1.2rem;">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                            <a href="{{ route('news.show', $news->slug) }}" style="font-size:0.8rem; font-weight:800; color:var(--navy); text-transform:uppercase; letter-spacing:0.15em; display:inline-flex; align-items:center; gap:8px;" class="hover:text-gold transition-colors">
                                Read Full Article <i class="fa-solid fa-arrow-right" style="font-size:0.65rem; color:var(--gold);"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center reveal">
                <a href="{{ route('news.index') }}" class="btn-primary" style="background: var(--navy); border-radius: 50px;">CLICK TO EXPLORE ARCHIVE</a>
            </div>
        </div>
        @else
        <div class="bt-container text-center reveal">
            <a href="{{ route('news.index') }}" class="btn-primary" style="background: var(--navy); border-radius: 50px;">CLICK TO EXPLORE ARCHIVE</a>
        </div>
        @endif

        @if(isset($latestMedia) && count($latestMedia) > 0)
        <div class="bt-container mt-32">
            <div class="text-center mb-16">
                <div class="reveal" style="width: 60px; height: 3px; background: var(--gold); margin: 0 auto 25px;"></div>
                <span class="tagline reveal">In The Media</span>
                <h2 class="heading-main reveal delay-100">PRESS COVERAGE</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                @foreach($latestMedia as $media)
                <a href="{{ $media->external_url ?? '#' }}" target="_blank" class="bg-white rounded-xl p-8 border border-gray-100 hover:border-gold hover:shadow-xl transition-all duration-300 reveal group block text-left">
                    <span class="text-gold font-bold text-xs uppercase tracking-widest mb-3 block">{{ $media->publication ?? 'Press' }} &bull; {{ $media->published_date ? \Carbon\Carbon::parse($media->published_date)->format('d M Y') : '' }}</span>
                    <h3 class="font-heading text-lg text-navy font-bold mb-4 line-clamp-2 leading-tight" style="font-family: 'Oswald', sans-serif;">{{ $media->headline }}</h3>
                    <p class="text-gray-600 text-sm mb-6 line-clamp-2" style="font-family: 'Montserrat', sans-serif;">{{ $media->excerpt }}</p>
                    <span class="text-navy font-bold text-sm group-hover:text-gold transition-colors inline-flex items-center gap-2 uppercase tracking-wide">PRESS TO READ ARTICLE <i class="fa-solid fa-arrow-right text-xs"></i></span>
                </a>
                @endforeach
            </div>
            <div class="text-center reveal">
                <a href="{{ route('news.index') }}" class="btn-primary" style="background: var(--navy); border-radius: 50px;">CLICK TO VIEW ALL PRESS</a>
            </div>
        </div>
        @endif
    </section>

    <!-- ========== EXPLORE HUB (QUICK LINKS) ========== -->
    <section class="section-padding bg-navy text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(var(--gold) 1px, transparent 0); background-size: 40px 40px;"></div>
        <div class="bt-container relative z-10 text-center mb-16">
            <span class="text-gold font-bold tracking-[3px] uppercase text-xs mb-4 block reveal">Explore Hub</span>
            <h2 class="heading-main reveal delay-100" style="color: white;">Quick <span class="text-gold" style="font-family: 'Oswald', sans-serif;">Navigation</span></h2>
            <p class="text-gray-400 mt-4 max-w-2xl mx-auto reveal delay-200">Access our core corporate portals directly.</p>
        </div>
        <div class="bt-container relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('story') }}" class="group block p-8 rounded-xl bg-white/5 border border-white/10 hover:border-gold hover:bg-white/10 transition-all duration-300 reveal text-center" style="text-decoration:none;">
                    <div class="w-16 h-16 mx-auto bg-white/10 text-gold rounded-full flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform"><i class="fa-solid fa-building-columns"></i></div>
                    <h3 style="font-family:'Oswald',sans-serif; font-size:1.2rem; font-weight:700; color:white; text-transform:uppercase; margin-bottom:0.5rem;">Our Legacy</h3>
                    <span style="font-size:0.75rem; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:0.15em;">Company History &rarr;</span>
                </a>
                <a href="{{ route('sustainability') }}" class="group block p-8 rounded-xl bg-white/5 border border-white/10 hover:border-gold hover:bg-white/10 transition-all duration-300 reveal delay-100 text-center" style="text-decoration:none;">
                    <div class="w-16 h-16 mx-auto bg-white/10 text-gold rounded-full flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform"><i class="fa-solid fa-leaf"></i></div>
                    <h3 style="font-family:'Oswald',sans-serif; font-size:1.2rem; font-weight:700; color:white; text-transform:uppercase; margin-bottom:0.5rem;">Sustainability</h3>
                    <span style="font-size:0.75rem; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:0.15em;">Green Practices &rarr;</span>
                </a>
                <a href="{{ route('careers') }}" class="group block p-8 rounded-xl bg-white/5 border border-white/10 hover:border-gold hover:bg-white/10 transition-all duration-300 reveal delay-200 text-center" style="text-decoration:none;">
                    <div class="w-16 h-16 mx-auto bg-white/10 text-gold rounded-full flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform"><i class="fa-solid fa-briefcase"></i></div>
                    <h3 style="font-family:'Oswald',sans-serif; font-size:1.2rem; font-weight:700; color:white; text-transform:uppercase; margin-bottom:0.5rem;">Careers</h3>
                    <span style="font-size:0.75rem; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:0.15em;">Join Our Team &rarr;</span>
                </a>
                <a href="{{ route('contact') }}" class="group block p-8 rounded-xl bg-white/5 border border-white/10 hover:border-gold hover:bg-white/10 transition-all duration-300 reveal delay-300 text-center" style="text-decoration:none;">
                    <div class="w-16 h-16 mx-auto bg-white/10 text-gold rounded-full flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform"><i class="fa-solid fa-handshake"></i></div>
                    <h3 style="font-family:'Oswald',sans-serif; font-size:1.2rem; font-weight:700; color:white; text-transform:uppercase; margin-bottom:0.5rem;">Contact Us</h3>
                    <span style="font-size:0.75rem; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:0.15em;">Get in Touch &rarr;</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ========== TEAM SECTION ========== -->
    <section class="team-section">
        <div class="team-img-bg"></div>
        <div class="team-content">
            <span class="tagline reveal">Team Unity</span>
            <h2 class="heading-main reveal delay-100" style="color: white; margin-bottom: 25px;">Our People, Our Pride.</h2>
            <p class="desc-text reveal delay-200" style="color: #cbd5e1; line-height: 1.8; margin-bottom: 45px;">
                We believe in building a legacy not just through structures, but through the development of our community and the continuous growth of our expert team.
            </p>
            <div><a href="{{ route('our-people') }}" class="btn-primary reveal delay-300" style="background: var(--gold); color: var(--navy); font-weight: 800; border: none; padding: 1rem 2.5rem; border-radius: 5px;">MEET THE TEAM</a></div>
        </div>
    </section>

    <!-- ========== FINAL CTA ========== -->
    <section class="final-cta" style="padding: 130px 5%; text-align: center; background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);">
        <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 2;">
            <h2 class="heading-main reveal" style="color: white; font-size: clamp(2.5rem, 6vw, 4rem); margin-bottom: 30px;">Ready To Build Your Next Landmark?</h2>
            <p class="desc-text reveal delay-100" style="color: white; font-size: 1.25rem; margin-bottom: 50px; opacity: 0.98;">
                Partner with Builtech for unparalleled engineering precision, transparent project management, and uncompromised safety standards.
            </p>
            <a href="{{ route('contact') }}" class="btn-primary" style="background: var(--navy); color: white; padding: 1.5rem 5rem; font-size: 1.1rem; border-radius: 60px;">CONTACT OUR EXPERTS</a>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== REVEAL ANIMATIONS ==========
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // ========== COUNTER ANIMATION ==========
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
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
        });
        document.querySelectorAll('.counter').forEach(c => counterObserver.observe(c));

        // ========== HERO SLIDER & PROGRESS ==========
        let curSlide = 0;
        const slides = document.querySelectorAll(".slide");
        const prog = document.getElementById("progContainer");
        
        if (slides.length > 0 && prog) {
            slides.forEach((_, i) => {
                let b = document.createElement("div");
                b.className = "prog-bar" + (i === 0 ? " active" : "");
                prog.appendChild(b);
            });

            setInterval(() => {
                slides[curSlide].classList.remove("active");
                prog.children[curSlide].classList.remove("active");
                curSlide = (curSlide + 1) % slides.length;
                slides[curSlide].classList.add("active");
                prog.children[curSlide].classList.add("active");
            }, 6000);
        }

        // ========== BUTTERY SMOOTH HORIZONTAL SCROLL (KINETIC) ==========
        const scrollContainer = document.querySelector('.modern-horizontal-scroll');
        if (scrollContainer) {
            let isDown = false;
            let startX;
            let scrollLeft;
            let isDragging = false;
            
            // Physics variables for Momentum
            let velX = 0;
            let momentumID;
            let prevX = 0;

            const startDrag = (e) => {
                // If touching on mobile, let the OS handle smooth scrolling perfectly!
                if(e.type === 'touchstart') return; 
                
                isDown = true;
                isDragging = false;
                scrollContainer.classList.add('active');
                startX = e.pageX - scrollContainer.offsetLeft;
                scrollLeft = scrollContainer.scrollLeft;
                prevX = e.pageX;
                
                // Disable snap during mouse drag
                scrollContainer.style.scrollSnapType = 'none';
                cancelAnimationFrame(momentumID);
            };

            const endDrag = () => {
                if(!isDown) return;
                isDown = false;
                scrollContainer.classList.remove('active');
                
                // Fire the physics momentum!
                beginMomentum();
            };

            const drag = (e) => {
                if (!isDown) return;
                e.preventDefault();
                isDragging = true;
                
                const x = e.pageX - scrollContainer.offsetLeft;
                // Calculate velocity between frames
                velX = (e.pageX - prevX);
                prevX = e.pageX;
                
                scrollContainer.scrollLeft -= velX * 1.5; 
            };

            const beginMomentum = () => {
                cancelAnimationFrame(momentumID);
                momentumID = requestAnimationFrame(momentumLoop);
            };

            const momentumLoop = () => {
                scrollContainer.scrollLeft -= velX * 1.5;
                velX *= 0.93; // The glide friction (0.93 = very smooth glide)
                if (Math.abs(velX) > 0.5) {
                    momentumID = requestAnimationFrame(momentumLoop);
                } else {
                    // Re-enable snapping when it stops gliding
                    scrollContainer.style.scrollSnapType = 'x mandatory';
                }
            };

            scrollContainer.addEventListener('mousedown', startDrag);
            scrollContainer.addEventListener('mouseleave', endDrag);
            scrollContainer.addEventListener('mouseup', endDrag);
            scrollContainer.addEventListener('mousemove', drag);

            // Prevent link click if we were dragging fast
            scrollContainer.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', (e) => {
                    if (isDragging && Math.abs(velX) > 1) {
                        e.preventDefault();
                    }
                });
            });

            // ========== BUTTON CONTROLS ==========
            const btnLeft = document.getElementById('btn-scroll-left');
            const btnRight = document.getElementById('btn-scroll-right');
            const cardWidth = 460; // Card width + gap

            if(btnLeft && btnRight) {
                btnLeft.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                });
                btnRight.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: cardWidth, behavior: 'smooth' });
                });
            }
        }
    });
</script>
@endpush