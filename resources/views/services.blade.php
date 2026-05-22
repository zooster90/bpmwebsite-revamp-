@extends('layouts.app')

@section('title', 'Our Services | Builtech Project Management')
@section('description', 'Builtech offers end-to-end construction services including project management, building & civil works, industrial buildings, maintenance, property development and safety training.')

@push('styles')
<style>
    .services-hero {
        position: relative;
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--white);
        padding: 160px 5% 100px;
        background: #000;
        overflow: hidden;
        border-bottom: 3px solid var(--gold);
    }
    .services-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=1920') center/cover no-repeat;
        opacity: 0.45;
        animation: slowZoom 20s infinite alternate ease-in-out;
    }
    .services-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(10,25,47,0.96) 0%, rgba(10,25,47,0.65) 100%);
    }
    @keyframes slowZoom { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

    .services-hero-inner { position: relative; z-index: 2; max-width: 820px; }

    /* Service Cards */
    .service-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    .service-card {
        background: var(--white);
        padding: 3rem 2.5rem;
        border-radius: 12px;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .service-card::after {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 4px;
        background: var(--gold);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s var(--ease);
    }
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        border-color: var(--border-gold);
    }
    .service-card:hover::after { transform: scaleX(1); }

    .service-icon {
        width: 80px; height: 80px;
        background: rgba(197,160,89,0.07);
        color: var(--gold);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.8rem;
        font-size: 2rem;
        transition: var(--transition);
        border: 1px solid rgba(197,160,89,0.15);
    }
    .service-card:hover .service-icon {
        background: var(--gold);
        color: var(--white);
        transform: rotateY(180deg);
    }
    .service-card h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 0.8rem;
        text-transform: uppercase;
    }
    .service-card p {
        font-size: 0.97rem;
        color: var(--text-muted);
        line-height: 1.8;
    }

    /* Process Section */
    .process-section {
        background: linear-gradient(135deg, #0a1f38 0%, #0d1218 100%);
        color: var(--white);
        position: relative;
        overflow: hidden;
    }
    .process-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(197,160,89,0.04) 1px, transparent 0);
        background-size: 40px 40px;
    }
    .process-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 2.5rem;
        margin-top: 3.5rem;
    }
    .process-item { text-align: center; }
    .process-step {
        width: 80px; height: 80px;
        border: 2px solid rgba(197,160,89,0.5);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
        font-family: 'Oswald', sans-serif;
        color: var(--gold);
        font-weight: 700;
        font-size: 1.5rem;
        background: #0a1f38;
        transition: var(--transition);
    }
    .process-item:hover .process-step {
        background: var(--gold);
        color: var(--white);
        border-color: var(--gold);
        box-shadow: 0 0 0 10px rgba(197,160,89,0.12);
    }
    .process-item h4 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
    }
    .process-item p {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.62);
        line-height: 1.75;
    }

    /* Why Builtech */
    .why-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .why-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        transition: var(--transition);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }
    .why-card:hover { transform: translateY(-5px); border-color: var(--border-gold); box-shadow: var(--shadow-md); }
    .why-card .why-icon {
        width: 48px; height: 48px; flex-shrink: 0;
        background: rgba(197,160,89,0.08);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: var(--gold); font-size: 1.2rem;
    }
    .why-card h4 { font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.3rem; }
    .why-card p { font-size: 0.9rem; color: var(--text-muted); line-height: 1.7; margin: 0; }
</style>
@endpush

@section('content')
<div class="bt-wrapper">

    {{-- ── HERO ── --}}
    <header class="services-hero">
        <div class="services-hero-inner reveal">
            <span class="section-label" style="justify-content:center; color:var(--gold);">Excellence in Execution</span>
            <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(3rem,6vw,5.5rem); text-transform:uppercase; line-height:1.05; letter-spacing:2px; font-weight:700; margin-bottom:1rem; color:white; text-shadow:0 2px 16px rgba(0,0,0,0.5);">
                Our <span style="color:var(--gold);">Services</span>
            </h1>
            <p style="font-size:1.05rem; color:rgba(255,255,255,0.85); max-width:600px; margin:0 auto; line-height:1.85; text-shadow:0 1px 8px rgba(0,0,0,0.4);">
                From strategic project management to high-value property development — we combine the agility of a specialist firm with the rigour of an ISO-certified corporation.
            </p>
        </div>
    </header>

    {{-- ── SERVICES GRID ── --}}
    <section class="bt-section" style="background:white;">
        <div class="bt-container">
            <div class="section-header-center reveal">
                <span class="section-label">Our Expertise</span>
                <h2 class="section-title">End-to-End Construction Solutions</h2>
                <p class="section-desc">
                    Builtech offers a comprehensive range of services from strategic project management to high-value property development. We combine the agility of a specialised firm with the rigorous quality procedures of an ISO-certified corporation.
                </p>
            </div>
            <div class="service-grid">
                @foreach($services as $idx => $service)
                    @php $stagger = ($idx % 3) + 1; @endphp
                    <a href="{{ route('services.show', $service->slug) }}" class="service-card reveal stagger-{{ $stagger }}" style="text-decoration:none;">
                        <div class="service-icon"><i class="{{ $service->icon_class }}"></i></div>
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->short_description }}</p>
                        <div style="margin-top:auto; padding-top:1.5rem; font-size:0.8rem; font-weight:800; color:var(--gold); text-transform:uppercase; letter-spacing:0.1em; display:flex; align-items:center; gap:6px;">
                            Learn More <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── WHY BUILTECH ── --}}
    <section class="bt-section" style="background:var(--off-white);">
        <div class="bt-container">
            <div class="section-header-center reveal">
                <span class="section-label">Our Advantage</span>
                <h2 class="section-title">Why Choose Builtech?</h2>
                <p class="section-desc">Three decades of engineering discipline, international certification, and a zero-compromise commitment to quality set us apart.</p>
            </div>
            <div class="why-grid">
                <div class="why-card reveal stagger-1">
                    <div class="why-icon"><i class="fas fa-certificate"></i></div>
                    <div>
                        <h4>CIDB Grade G7 Certified</h4>
                        <p>The highest contractor grade in Malaysia, authorising unlimited construction capacity for any scale of project.</p>
                    </div>
                </div>
                <div class="why-card reveal stagger-2">
                    <div class="why-icon"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <h4>Triple ISO Certified</h4>
                        <p>ISO 9001, ISO 45001, and ISO 14001 — certified across quality, safety, and environmental management systems.</p>
                    </div>
                </div>
                <div class="why-card reveal stagger-3">
                    <div class="why-icon"><i class="fas fa-star"></i></div>
                    <div>
                        <h4>82% QLASSIC Score</h4>
                        <p>Achieving 82% on CIDB Malaysia QLASSIC quality assessment — above industry benchmark — on 26 December 2024.</p>
                    </div>
                </div>
                <div class="why-card reveal stagger-1">
                    <div class="why-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <h4>Since 1996</h4>
                        <p>Nearly 30 years of continuous operation, building trust with clients across Penang and throughout Malaysia.</p>
                    </div>
                </div>
                <div class="why-card reveal stagger-2">
                    <div class="why-icon"><i class="fas fa-hard-hat"></i></div>
                    <div>
                        <h4>5-Star CIDB SCORE Rating</h4>
                        <p>Awarded 5-Star CIDB SCORE Safety Rating and 4-Star SHASSIC rating, affirming our exemplary site safety standards.</p>
                    </div>
                </div>
                <div class="why-card reveal stagger-3">
                    <div class="why-icon"><i class="fas fa-users"></i></div>
                    <div>
                        <h4>Expert Project Teams</h4>
                        <p>Strong, skilled teams equipped with the latest technologies and construction practices for superior results.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── HOW WE DELIVER ── --}}
    <section class="process-section bt-section">
        <div class="bt-container">
            <div class="text-center reveal">
                <span class="section-label" style="justify-content:center;">Our Workflow</span>
                <h2 class="section-title section-title--white">How We Deliver Results</h2>
                <p style="font-size:1rem; color:rgba(255,255,255,0.6); max-width:600px; margin:1rem auto 0; line-height:1.8;">
                    A proven four-stage methodology ensuring every project is delivered on time, on budget, and to the highest quality standards.
                </p>
            </div>
            <div class="process-grid">
                <div class="process-item reveal stagger-1">
                    <div class="process-step">01</div>
                    <h4>Consultation</h4>
                    <p>Understanding your vision, project scope, and feasibility requirements to craft the right solution.</p>
                </div>
                <div class="process-item reveal stagger-2">
                    <div class="process-step">02</div>
                    <h4>Planning</h4>
                    <p>Strategic resource allocation, risk management framework, and timeline development for maximum efficiency.</p>
                </div>
                <div class="process-item reveal stagger-3">
                    <div class="process-step">03</div>
                    <h4>Execution</h4>
                    <p>Precision construction with real-time monitoring, quality checks, and strict EHS protocols at every stage.</p>
                </div>
                <div class="process-item reveal stagger-4">
                    <div class="process-step">04</div>
                    <h4>Handover</h4>
                    <p>Comprehensive quality audit, CONQUAS/QLASSIC verification, and seamless transition to full operation.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="bt-section" style="background:white; text-align:center;">
        <div class="bt-container reveal" style="max-width:800px;">
            <span class="section-label">Get Started</span>
            <h2 class="section-title">Ready to Discuss Your <span style="color:var(--gold);">Project?</span></h2>
            <p style="font-size:1.05rem; color:var(--text-muted); line-height:1.85; margin-bottom:2.5rem;">
                Contact our engineering team today. We provide expert consultation and a detailed project proposal tailored to your requirements.
            </p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <a href="{{ route('contact') }}" class="btn-primary"><i class="fas fa-envelope"></i> Contact Us Now</a>
                <a href="{{ route('projects.index') }}" class="btn-primary btn-navy"><i class="fas fa-folder-open"></i> See Our Portfolio</a>
            </div>
        </div>
    </section>

</div>
@endsection
