@extends('layouts.app')

@section('title', 'About Us | Builtech Project Management')
@section('description', 'Builtech Project Management Sdn. Bhd. — established 1996, CIDB Grade G7 certified contractor delivering engineering excellence across Malaysia.')

@push('styles')
<style>
    .about-hero {
        position: relative;
        min-height: 56vh;
        padding: 160px 5% 90px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: var(--navy);
    }
    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920') center/cover no-repeat;
        opacity: 0.12;
        filter: grayscale(100%);
        animation: heroZoom 18s infinite alternate ease-in-out;
    }
    .about-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(26,36,47,0.97) 0%, rgba(20,32,52,0.88) 100%);
    }
    @keyframes heroZoom { 0% { transform: scale(1); } 100% { transform: scale(1.06); } }

    .pillar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: -80px;
        position: relative;
        z-index: 20;
        padding: 0 5%;
        max-width: 1320px;
        margin-left: auto;
        margin-right: auto;
    }
    .pillar-card {
        background: white;
        padding: 3rem 2.5rem;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        border-radius: 16px;
        border: 1px solid var(--border);
        transition: var(--transition);
        text-align: left;
        position: relative;
        overflow: hidden;
    }
    .pillar-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gold), rgba(197,160,89,0.3));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease;
    }
    .pillar-card:hover::before { transform: scaleX(1); }
    .pillar-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 70px rgba(0,0,0,0.13);
        border-color: var(--border-gold);
    }
    .pillar-card .pillar-icon {
        width: 64px; height: 64px;
        background: rgba(197,160,89,0.1);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }
    .pillar-card:hover .pillar-icon { background: var(--gold); }
    .pillar-card .pillar-icon i { font-size: 1.5rem; color: var(--gold); transition: color 0.3s; }
    .pillar-card:hover .pillar-icon i { color: white; }
    .pillar-card h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--navy);
        margin-bottom: 1rem;
        letter-spacing: 0.05em;
    }
    .pillar-card p {
        font-size: 0.97rem;
        color: var(--text-muted);
        line-height: 1.85;
        margin: 0;
    }
    .pillar-card .pillar-tag {
        display: inline-block;
        margin-top: 1.5rem;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.25em;
        color: var(--gold);
        border-top: 1px solid rgba(197,160,89,0.25);
        padding-top: 1rem;
        width: 100%;
    }

    .statement-grid, .commitment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.8rem;
        margin-top: 3rem;
    }
    .statement-item, .commitment-item {
        padding: 2.5rem 2rem;
        border: 1px solid var(--border);
        border-radius: 12px;
        transition: var(--transition);
        background: white;
    }
    .statement-item:hover, .commitment-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        border-color: var(--border-gold);
    }
    .statement-item h4, .commitment-item h4 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .statement-item p, .commitment-item p {
        font-size: 0.97rem;
        color: var(--text-muted);
        line-height: 1.8;
    }

    .about-intro-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5rem;
        align-items: center;
    }
    @media (max-width: 900px) {
        .about-intro-grid { grid-template-columns: 1fr; gap: 2.5rem; }
        .pillar-grid { margin-top: -40px; }
    }

    .cert-section { background: var(--navy); padding: 100px 5%; text-align: center; }
    .cert-flex { display: flex; justify-content: center; flex-wrap: wrap; gap: 2.5rem; margin-top: 3rem; }
    .cert-box {
        flex: 0 1 220px;
        background: rgba(255,255,255,0.04);
        padding: 2.5rem 1.5rem;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.07);
        transition: var(--transition);
        text-align: center;
    }
    .cert-box:hover { transform: translateY(-6px); border-color: var(--gold); background: rgba(197,160,89,0.06); }
    .cert-box img {
        height: 72px; margin-bottom: 1.2rem; object-fit: contain;
        background: white; padding: 8px; border-radius: 6px;
        width: auto; display: block; margin-left: auto; margin-right: auto;
    }
    .cert-box .cert-name {
        font-family: 'Oswald', sans-serif;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        color: var(--gold);
        text-transform: uppercase;
        display: block;
        margin-bottom: 0.3rem;
    }
    .cert-box .cert-id { font-size: 0.8rem; color: rgba(255,255,255,0.5); display: block; }

    .about-objective-list { list-style: none; padding: 0; margin-top: 1.5rem; }
    .about-objective-list li {
        display: flex; align-items: flex-start; gap: 0.75rem;
        padding: 0.75rem 0; border-bottom: 1px solid var(--border);
        font-size: 0.97rem; color: var(--text-body); line-height: 1.75;
    }
    .about-objective-list li:last-child { border-bottom: none; }
    .about-objective-list li i { color: var(--gold); margin-top: 4px; flex-shrink: 0; font-size: 0.8rem; }
</style>
@endpush

@section('content')
<div class="bt-wrapper">

    {{-- ── HERO ── --}}
    <header class="about-hero">
        <div class="bt-container relative z-10 reveal">
            <span class="section-label">Established 1996</span>
            <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(2.8rem,5.5vw,5rem); font-weight:700; color:white; text-transform:uppercase; line-height:1.05; margin-bottom:1rem;">
                About <span style="color:var(--gold);">Builtech</span>
            </h1>
            <p style="font-size:1.05rem; color:rgba(255,255,255,0.72); max-width:580px; line-height:1.85; font-family:'Montserrat',sans-serif;">
                Stability &bull; Quality &bull; Excellence — delivering engineering precision across Malaysia since 1996.
            </p>
        </div>
    </header>

    {{-- ── VISION & MISSION OVERLAP ── --}}
    <div style="margin-top:-80px; position:relative; z-index:20; padding-bottom:80px;">
        <div class="pillar-grid reveal">
            <div class="pillar-card stagger-1">
                <div class="pillar-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Our Vision</h3>
                <p>To be an excellent builder that delivers outstanding built environments — creating spaces where communities thrive and legacies endure.</p>
                <span class="pillar-tag"><i class="fas fa-star" style="margin-right:6px;"></i> Engineering Excellence Since 1996</span>
            </div>
            <div class="pillar-card stagger-2">
                <div class="pillar-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Our Mission</h3>
                <p>We are committed to deliver quality products through stringent quality control at highest integrity, achieving cost-effectiveness across every project. At Builtech, we truly <strong style="color:var(--navy);">Build To Last.</strong></p>
                <span class="pillar-tag"><i class="fas fa-shield-halved" style="margin-right:6px;"></i> ISO 9001 &middot; ISO 45001 &middot; ISO 14001</span>
            </div>
        </div>
    </div>

    {{-- ── ABOUT US OVERVIEW ── --}}
    <section style="padding:100px 5%; background:var(--off-white);">
        <div class="bt-container">
            <div class="about-intro-grid">
                <div class="reveal">
                    <span class="section-label">Who We Are</span>
                    <h2 class="section-title">Malaysia's Premier <span style="color:var(--gold);">Grade G7</span> Contractor</h2>
                    <p style="font-size:1rem; color:var(--text-body); line-height:1.85; margin-bottom:1.2rem;">
                        BUILTECH PROJECT MANAGEMENT SDN BHD (Builtech), a company specializes in construction and project management, established in year 1996. We offer a whole range of services from project management, building and civil construction, industrial building, maintenance, property development, consultation consulting, to safety and health training and building materials supply and trading. Our specialties cover building, infrastructure and civil, mechanical and electrical works, providing overall solution in all these areas of facilities services with the well coordination of works.
                    </p>
                    <p style="font-size:1rem; color:var(--text-body); line-height:1.85; margin-bottom:1.5rem;">
                        Since starting up of business, over the years, we learn and adopt new knowledge, skills and technologies, research for good construction practices and techniques, better monitor our work progress, cost controls and operations at site. Today, we are certified under ISO 9001, ISO 45001, and ISO 14001 management systems. We have successfully built strong project teams equipping with the competencies to deliver quality product with great workmanship and value added services. With our mission 'We Built to Last', we emphasizes on precision of workmanship and quality, adopting CONQUAS standards. We cultivate the working culture that values good business relationships, hands on attitude, caring and servicing mindset. We deliver our service at highest business ethics and integrity.
                    </p>
                    <a href="{{ route('contact') }}" class="btn-primary btn-attention">
                        <i class="fas fa-handshake"></i> Partner With Us
                    </a>
                </div>
                <div class="reveal delay-200">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.2rem;">
                        @php
                            $metrics = [
                                ['icon'=>'fa-calendar','prefix'=>'','val'=>date('Y')-1996,'unit'=>'+','label'=>'Years of Excellence'],
                                ['icon'=>'fa-award','prefix'=>'G','val'=>'7','unit'=>'','label'=>'CIDB Grade Certified'],
                                ['icon'=>'fa-check-circle','prefix'=>'','val'=>'100','unit'=>'+','label'=>'Projects Delivered'],
                                ['icon'=>'fa-shield-alt','prefix'=>'','val'=>'3','unit'=>'','label'=>'ISO Certifications'],
                            ];
                        @endphp
                        @foreach($metrics as $m)
                        <div style="background:white; border:1px solid var(--border); border-radius:12px; padding:2rem 1.5rem; text-align:center; box-shadow:var(--shadow-sm); transition:var(--transition);" onmouseenter="this.style.transform='translateY(-6px)'" onmouseleave="this.style.transform=''">
                            <i class="fas {{ $m['icon'] }}" style="color:var(--gold); font-size:1.5rem; margin-bottom:0.75rem; display:block;"></i>
                            <span style="font-family:'Oswald',sans-serif; font-size:2.2rem; font-weight:700; color:var(--navy); line-height:1; display:block;">
                                {{ $m['prefix'] }}<span class="counter" data-target="{{ $m['val'] }}">0</span>{{ $m['unit'] }}
                            </span>
                            <span style="font-size:0.75rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em; margin-top:0.4rem; display:block;">{{ $m['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CORPORATE STATEMENTS ── --}}
    <section style="padding:100px 5%; background:white;">
        <div class="bt-container">
            <div class="text-center reveal" style="max-width:760px; margin:0 auto 3rem;">
                <span class="section-label">Guiding Principles</span>
                <h2 class="section-title">Corporate Statements</h2>
                <p class="section-desc" style="margin:0 auto;">Our business practices are founded on four inviolable corporate values that guide every decision, every project, and every relationship.</p>
            </div>
            <div class="statement-grid reveal">
                <div class="statement-item stagger-1">
                    <h4><i class="fas fa-check-circle"></i> Ethics</h4>
                    <p>All dealings are conducted with transparency, honesty, and full compliance with Malaysian Law and CIDB regulations. We embrace a corporate culture of high business ethics and integrity.</p>
                </div>
                <div class="statement-item stagger-2">
                    <h4><i class="fas fa-award"></i> Quality</h4>
                    <p>Maintaining high CONQUAS and QLASSIC standards through meticulous site inspections, quality control, and professional craftsmanship on every project handover.</p>
                </div>
                <div class="statement-item stagger-3">
                    <h4><i class="fas fa-hard-hat"></i> Safety</h4>
                    <p>Committed to a zero-accident workplace by adhering to strict ISO 45001:2018 occupational health and safety protocols. Our workers and the public's safety is paramount.</p>
                </div>
                <div class="statement-item stagger-4">
                    <h4><i class="fas fa-seedling"></i> Environment</h4>
                    <p>Protecting our ecosystem through sustainable waste management and energy-efficient construction processes, ensuring a green and sustainable environment for future generations.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── OPERATIONAL EXCELLENCE ── --}}
    <section style="padding:100px 5%; background:var(--off-white);">
        <div class="bt-container">
            <div class="text-center reveal" style="max-width:760px; margin:0 auto 3rem;">
                <span class="section-label">Our Commitment</span>
                <h2 class="section-title">Operational Excellence</h2>
                <p class="section-desc" style="margin:0 auto;">Six pillars of operational commitment that define how Builtech delivers results and maintains its reputation as Malaysia's most trusted Grade G7 contractor.</p>
            </div>
            <div class="commitment-grid reveal">
                <div class="commitment-item stagger-1">
                    <h4><i class="fas fa-users"></i> Our Team</h4>
                    <p>Strong project teams utilising the latest technologies, good construction practices and techniques. Employees are viewed as family members, with emphasis on work-life balance and continuous growth.</p>
                </div>
                <div class="commitment-item stagger-2">
                    <h4><i class="fas fa-leaf"></i> Sustainability</h4>
                    <p>Control of site safety, health, and environment aspects to ensure workers' and public's safety with well-sustained green environment practices on every active site.</p>
                </div>
                <div class="commitment-item stagger-3">
                    <h4><i class="fas fa-handshake"></i> Relationships</h4>
                    <p>Emphasis on win-win situations with stakeholders, forming partnerships with valued subcontractors, and embracing a corporate culture of high business ethics and integrity.</p>
                </div>
                <div class="commitment-item stagger-4">
                    <h4><i class="fas fa-chart-line"></i> Quality &amp; Growth</h4>
                    <p>Monitoring and evaluation of construction materials and worker competencies; research for better methodologies; meeting CONQUAS standards, improving continuously.</p>
                </div>
                <div class="commitment-item stagger-5">
                    <h4><i class="fas fa-heart"></i> Community</h4>
                    <p>Contribution through Corporate Social Responsibility sponsorship and community service annually, ensuring Builtech gives back to the communities in which we operate.</p>
                </div>
                <div class="commitment-item stagger-5">
                    <h4><i class="fas fa-clock"></i> Delivery</h4>
                    <p>Delivering all projects on time with effective cost management. Providing quick response to customer requirements and meeting all contractual, regulatory, and statutory obligations.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CERTIFICATIONS ── --}}
    <section class="cert-section">
        <div class="bt-container reveal">
            <span class="section-label" style="color:var(--gold);">Accreditations</span>
            <h2 class="section-title section-title--white" style="margin-bottom:0.5rem;">Quality <span style="color:var(--gold);">Assured</span></h2>
            <p style="font-size:1rem; color:rgba(255,255,255,0.65); max-width:600px; margin:1rem auto 0; line-height:1.8;">
                Certified under three international management systems, covering provision of project management and construction services for building and civil engineering works.
            </p>
            <div class="cert-flex">
                <div class="cert-box">
                    <img src="{{ asset('img/images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg') }}" alt="ISO 9001:2015 Certification">
                    <span class="cert-name" style="color: var(--gold) !important;">ISO 9001:2015</span>
                    <span class="cert-id" style="color: rgba(255,255,255,0.5) !important;">MY10/00630.01</span>
                    <span class="cert-id" style="color:rgba(255,255,255,0.4) !important; font-size:0.72rem; margin-top:4px;">Quality Management</span>
                </div>
                <div class="cert-box">
                    <img src="{{ asset('img/images/SGS_ISO 45001 DSM Mark_TCL_LR.jpg') }}" alt="ISO 45001:2018 Certification">
                    <span class="cert-name" style="color: var(--gold) !important;">ISO 45001:2018</span>
                    <span class="cert-id" style="color: rgba(255,255,255,0.5) !important;">MY10/00630.03</span>
                    <span class="cert-id" style="color:rgba(255,255,255,0.4) !important; font-size:0.72rem; margin-top:4px;">Safety &amp; Health</span>
                </div>
                <div class="cert-box">
                    <img src="{{ asset('img/images/ISO_14001_Latest.jpg') }}" alt="ISO 14001:2015 Certification">
                    <span class="cert-name" style="color: var(--gold) !important;">ISO 14001:2015</span>
                    <span class="cert-id" style="color: rgba(255,255,255,0.5) !important;">MY21/00000.01</span>
                    <span class="cert-id" style="color:rgba(255,255,255,0.4) !important; font-size:0.72rem; margin-top:4px;">Environmental Mgmt</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section style="padding:100px 5%; background:white; text-align:center;">
        <div class="bt-container reveal" style="max-width:800px;">
            <span class="section-label">Next Step</span>
            <h2 class="section-title">Ready to Build Your <span style="color:var(--gold);">Legacy?</span></h2>
            <p style="font-size:1.05rem; color:var(--text-muted); line-height:1.85; margin-bottom:2.5rem;">
                Partner with Builtech for unparalleled engineering precision, transparent project management, and uncompromised safety standards across Malaysia.
            </p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <a href="{{ route('contact') }}" class="btn-primary"><i class="fas fa-envelope"></i> Contact Our Team</a>
                <a href="{{ route('projects.index') }}" class="btn-primary btn-navy"><i class="fas fa-briefcase"></i> View Our Portfolio</a>
            </div>
        </div>
    </section>

</div>
@endsection