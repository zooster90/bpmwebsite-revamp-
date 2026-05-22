@extends('layouts.app')

@section('title', 'Our Story | The Engineering Legacy Since 1996 | Builtech')
@section('description', 'Discover the engineering legacy of Builtech Project Management. From our 1996 genesis to CIDB Grade G7 authority, we build with precision and integrity — We Built To Last.')

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════
       STORY PAGE - EMINENCE EDITION
       A cinematic journey through 30 years of excellence
       ═══════════════════════════════════════════════════════ */
    
    /* 1. Cinematic Story Hero */
    .bt-story-hero {
        height: 100vh;
        min-height: 850px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bt-navy);
        overflow: hidden;
    }
    .bt-story-hero::before {
        content: ''; position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000') center/cover no-repeat;
        opacity: 0.3;
        mix-blend-mode: luminosity;
        animation: slowZoom 20s infinite alternate ease-in-out;
    }
    @keyframes slowZoom { from { transform: scale(1); } to { transform: scale(1.1); } }
    
    .bt-story-hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 1000px;
        padding: 0 5%;
    }

    .bt-shine-title {
        font-family: var(--bt-font-display);
        font-size: clamp(4rem, 10vw, 8.5rem);
        font-weight: 900;
        line-height: 0.85;
        letter-spacing: -0.04em;
        text-transform: uppercase;
        margin-bottom: 2rem;
        
        /* Gold Shine Effect */
        background: linear-gradient(to right, #C5A059 20%, #F8E4B7 40%, #F8E4B7 60%, #C5A059 80%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shine-gold 4s linear infinite;
    }

    @keyframes shine-gold {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    /* 2. Authority Bento Strip */
    .bt-auth-strip {
        margin-top: -80px;
        position: relative;
        z-index: 50;
    }
    .bt-auth-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background: #fff;
        border-radius: 4px;
        box-shadow: var(--bt-shadow-lg);
        overflow: hidden;
    }
    .bt-auth-item {
        padding: 4rem 2rem;
        text-align: center;
        border-right: 1px solid #F1F1F1;
        transition: all 0.5s var(--bt-ease);
    }
    .bt-auth-item:last-child { border-right: none; }
    .bt-auth-item:hover { background: #FBFBFA; transform: translateY(-5px); }
    .bt-auth-item i { font-size: 2.5rem; color: var(--bt-gold); margin-bottom: 1.5rem; }
    .bt-auth-item h4 { font-family: var(--bt-font-display); font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--bt-navy); }
    .bt-auth-item p { font-size: 0.75rem; color: var(--bt-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.5rem; }

    /* 3. Layered Genesis */
    .layered-genesis {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 8rem;
        align-items: center;
    }
    .genesis-media {
        position: relative;
    }
    .genesis-main-img {
        width: 100%;
        border-radius: 4px;
        box-shadow: 30px 30px 0 var(--bt-gold);
    }
    .genesis-year-badge {
        position: absolute;
        bottom: -30px;
        left: -30px;
        background: var(--bt-navy);
        color: #fff;
        padding: 3rem;
        border-radius: 4px;
        text-align: center;
        box-shadow: var(--bt-shadow-lg);
    }

    /* 4. DNA Cards */
    .bt-dna-card {
        background: #fff;
        border: 1px solid #f1f1f1;
        border-radius: 8px;
        padding: 5rem;
        margin-bottom: 3rem;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 6rem;
        transition: all 0.6s var(--bt-ease);
        position: relative;
        overflow: hidden;
    }
    .bt-dna-card::before {
        content: ''; position: absolute; left: 0; top: 0; width: 4px; height: 100%;
        background: var(--bt-gold); transform: scaleY(0); transition: transform 0.6s var(--bt-ease);
        transform-origin: top;
    }
    .bt-dna-card:hover { transform: translateY(-10px); box-shadow: var(--bt-shadow-lg); }
    .bt-dna-card:hover::before { transform: scaleY(1); }
    
    .dna-list { list-style: none; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; }
    .dna-list li { position: relative; padding-left: 2rem; color: var(--bt-text-muted); font-size: 1.1rem; line-height: 1.6; }
    .dna-list li::before { content: '→'; position: absolute; left: 0; color: var(--bt-gold); font-weight: 900; }
    .dna-list b { display: block; color: var(--bt-navy); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; margin-bottom: 0.5rem; }

    /* 5. Culture Gallery */
    .culture-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
    .culture-img-wrapper {
        aspect-ratio: 1/1;
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
    }
    .culture-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 1s var(--bt-ease); }
    .culture-img-wrapper:hover img { transform: scale(1.1); }
    .culture-img-wrapper::after {
        content: '+'; position: absolute; inset: 0; background: rgba(197,160,89,0.4);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 3rem; font-weight: 300; opacity: 0; transition: opacity 0.4s;
    }
    .culture-img-wrapper:hover::after { opacity: 1; }

    @media (max-width: 1024px) {
        .bt-auth-grid { grid-template-columns: repeat(2, 1fr); }
        .layered-genesis { grid-template-columns: 1fr; gap: 6rem; }
        .bt-dna-card { grid-template-columns: 1fr; gap: 3rem; padding: 3rem; }
        .dna-list { grid-template-columns: 1fr; gap: 2rem; }
        .culture-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
<div class="bt-wrapper">
    
    <!-- 1. CINEMATIC HERO -->
    <header class="bt-story-hero">
        <div class="bt-story-hero-content reveal">
            <span class="bt-badge border-gold/40 text-gold bg-gold/10 mb-8 px-8 py-3">Established 1996</span>
            <h1 class="bt-shine-title">The Engineering <br>Legacy.</h1>
            <div class="w-24 h-1 bg-gold mx-auto mb-10"></div>
            <p class="text-2xl text-white/70 font-light tracking-[0.4em] uppercase">Precision &bull; Integrity &bull; Sustainability</p>
        </div>
        
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 text-white/30 reveal delay-1000">
            <span class="text-[9px] uppercase tracking-[0.5em] font-black">Scroll Narrative</span>
            <div class="w-[1px] h-20 bg-gradient-to-b from-white/40 to-transparent"></div>
        </div>
    </header>

    <!-- 2. AUTHORITY STRIP -->
    <div class="bt-container bt-auth-strip">
        <div class="bt-auth-grid reveal">
            <div class="bt-auth-item">
                <i class="fa-solid fa-certificate"></i>
                <h4>Grade G7 Authority</h4>
                <p>Unlimited Tender Capacity</p>
            </div>
            <div class="bt-auth-item">
                <i class="fa-solid fa-microscope"></i>
                <h4>Specialist Builders</h4>
                <p>Healthcare & Industrial</p>
            </div>
            <div class="bt-auth-item">
                <i class="fa-solid fa-shield-check"></i>
                <h4>Triple ISO Core</h4>
                <p>Quality • Safety • Eco</p>
            </div>
            <div class="bt-auth-item">
                <i class="fa-solid fa-brain-circuit"></i>
                <h4>Engineering Logic</h4>
                <p>Logic Over Convenience</p>
            </div>
        </div>
    </div>

    <!-- 3. GENESIS STORY -->
    <section class="bt-section py-64">
        <div class="bt-container">
            <div class="layered-genesis">
                <div class="reveal">
                    <span class="bt-badge !bg-navy/5 !text-navy !border-navy/10 mb-8">Our Philosophy</span>
                    <img src="{{ asset('img/webuiltolast.png') }}" alt="We Built To Last" style="max-width: 320px; margin-bottom: 2.5rem; filter: brightness(0) invert(0.1);">
                    <p class="text-2xl text-navy font-bold leading-relaxed mb-10 border-l-4 border-gold pl-10">
                        BUILTECH PROJECT MANAGEMENT SDN BHD, established in 1996, stands as a premier CIDB Grade G7 institutional partner specializing in high-stakes environments.
                    </p>
                    <p class="text-xl text-gray-400 font-light leading-relaxed mb-8">
                        Founded on the principles of engineering integrity, our journey has been defined by precision. We have evolved into specialists for high-tech factories, specialist hospitals, and urban commercial developments.
                    </p>
                    <p class="text-xl text-gray-400 font-light leading-relaxed mb-12">
                        Driven by our mission 'We Built to Last', we emphasize precision of workmanship and quality, adopting elite CONQUAS standards. We cultivate a working culture that values Logic over Convenience.
                    </p>
                    <div class="flex gap-10">
                        <div class="text-center">
                            <div class="text-4xl font-display font-black text-navy mb-1"><span class="counter" data-target="{{ date('Y') - 1996 }}">0</span>+</div>
                            <div class="text-[9px] font-black uppercase tracking-widest text-gold">Years of Legacy</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-display font-black text-navy mb-1">G7</div>
                            <div class="text-[9px] font-black uppercase tracking-widest text-gold">Highest Grade</div>
                        </div>
                    </div>
                </div>
                <div class="genesis-media reveal delay-200">
                    <img src="{{ asset('img/images/retro_6_grid_collage.jpg') }}" alt="Legacy Collage" class="genesis-main-img">
                    <div class="genesis-year-badge">
                        <div class="text-6xl font-display font-black text-gold mb-1">1996</div>
                        <div class="text-[10px] font-black uppercase tracking-[0.3em]">The Genesis</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. OPERATIONAL DNA -->
    <section class="bt-section py-48 bg-[#FBFBFA]">
        <div class="bt-container">
            <div class="max-w-3xl mb-24 reveal">
                <span class="bt-badge border-navy/10 text-navy bg-navy/5 mb-8">Operational Authority</span>
                <h2 class="bt-title text-6xl text-navy">The Builtech <span class="bt-serif text-gold">DNA.</span></h2>
            </div>

            <div class="bt-dna-card reveal">
                <div class="dna-type">
                    <span class="text-gold font-black uppercase tracking-widest text-[10px] mb-4 block">Execution Strategy</span>
                    <h3 class="bt-title text-5xl text-navy">The Ways</h3>
                </div>
                <ul class="dna-list">
                    <li><b>Quality Management</b>ISO 9001 Systems across all project lifecycles.</li>
                    <li><b>Safety First</b>Rigorous ISO 45001 health and safety management.</li>
                    <li><b>Environmental</b>ISO 14001 standards for green working environments.</li>
                    <li><b>Efficiency</b>Optimising 5M resources for high effectiveness.</li>
                </ul>
            </div>

            <div class="bt-dna-card reveal">
                <div class="dna-type">
                    <span class="text-gold font-black uppercase tracking-widest text-[10px] mb-4 block">Internal Standards</span>
                    <h3 class="bt-title text-5xl text-navy">The Culture</h3>
                </div>
                <ul class="dna-list">
                    <li><b>Financial Ethics</b>Written Variation Orders are mandatory for project transparency.</li>
                    <li><b>Intelligence</b>Relentless R&D and "Lesson Learned" application.</li>
                    <li><b>Integrity</b>Demonstrating strong ethical standards in all dealings.</li>
                    <li><b>Growth</b>Commitment to continuous training and workforce improvement.</li>
                </ul>
            </div>

            <div class="bt-dna-card reveal">
                <div class="dna-type">
                    <span class="text-gold font-black uppercase tracking-widest text-[10px] mb-4 block">Foundational Values</span>
                    <h3 class="bt-title text-5xl text-navy">The Beliefs</h3>
                </div>
                <ul class="dna-list">
                    <li><b>Excellence</b>Execute key processes to exceed client expectations.</li>
                    <li><b>Sustainment</b>Proactively sustain green environments for future generations.</li>
                    <li><b>Engineering Logic</b>Stability is the highest form of architectural beauty.</li>
                    <li><b>Wellbeing</b>Providing a safe and clinical-grade healthy environment.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 5. PEOPLE & CULTURE -->
    <section class="bt-section py-64 bg-navy relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(var(--bt-gold) 1px, transparent 0); background-size: 40px 40px;"></div>
        
        <div class="bt-container relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-32 items-center">
                <div class="reveal">
                    <span class="bt-badge border-white/20 text-white bg-white/5 mb-10">People & Synergy</span>
                    <div class="bt-serif text-5xl md:text-6xl text-gold mb-12 leading-tight">"We learn together, we share together, and we grow together."</div>
                    <p class="text-2xl text-white/60 font-light leading-relaxed mb-16">
                        At Builtech, our technical workforce is our greatest asset. We foster a sense of belonging through incentive trips and staff development — because a happy team builds better landmarks.
                    </p>
                    <a href="{{ route('our-people') }}" class="bt-btn bt-btn-primary !px-12">Meet Our People</a>
                </div>
                <div class="culture-grid reveal delay-200">
                    @php
                        $galleryImages = [
                            'img/images/ChatGPT Image Jan 30, 2026, 04_43_19 PM.png',
                            'img/images/ChatGPT Image Jan 30, 2026, 04_43_58 PM.png',
                            'img/images/ChatGPT Image Jan 30, 2026, 04_46_00 PM.png',
                            'img/images/site_coordination_meeting3.jpg',
                            'img/images/TooBoxMeeting1.jpg',
                            'img/images/fogging 3.jpg',
                        ];
                    @endphp
                    @foreach($galleryImages as $img)
                        <div class="culture-img-wrapper" onclick="openGlobalLightbox('{{ asset($img) }}')">
                            <img src="{{ asset($img) }}" alt="Culture Image">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    const target = entry.target;
                    const end = parseInt(target.getAttribute('data-target'));
                    let current = 0;
                    const duration = 2000;
                    const step = end / (duration / 16);
                    
                    const timer = setInterval(() => {
                        current += step;
                        if(current >= end) {
                            target.innerText = end;
                            clearInterval(timer);
                        } else {
                            target.innerText = Math.floor(current);
                        }
                    }, 16);
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => observer.observe(c));
    });
</script>
@endpush