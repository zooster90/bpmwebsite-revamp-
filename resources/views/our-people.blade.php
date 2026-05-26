@extends('layouts.app')

@section('title', 'Our People | Builtech Project Teams')
@section('description', 'Meet the specialized project teams and corporate workforce behind Builtech\'s Grade G7 engineering excellence in Malaysia.')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" />
<style>
    /* ═══════════════════════════════════════════════════════
       OUR PEOPLE - EMINENCE EDITION
       The human capital behind Malaysia's landmarks
       ═══════════════════════════════════════════════════════ */
    
    /* 1. People Hero */
    .bt-people-hero {
        min-height: 60vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--navy);
        overflow: hidden;
        padding: 160px 5% 90px;
    }
    .bt-people-hero::before {
        content: ''; position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2000') center/cover no-repeat;
        opacity: 0.25;
        mix-blend-mode: luminosity;
        animation: slowZoom 25s infinite alternate ease-in-out;
    }
    
    .bt-people-hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 900px;
        padding: 0 5%;
    }

    .bt-hero-badge {
        font-family: 'Montserrat', sans-serif;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 0.4em;
        font-size: 0.72rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        display: block;
    }

    /* 2. Sub-Navigation (Sticky) */
    .bt-ppl-nav-wrap {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(15px);
        border-bottom: 1px solid #F1F1F1;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }
    .bt-ppl-nav {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        padding: 0 5%;
    }
    .bt-ppl-nav a {
        padding: 1.5rem 2rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        letter-spacing: 0.15em;
        font-size: 0.75rem;
        transition: var(--transition);
        position: relative;
        text-decoration: none;
    }
    .bt-ppl-nav a:hover, .bt-ppl-nav a.active { color: var(--gold); }
    .bt-ppl-nav a::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 3px;
        background: var(--gold); transition: width 0.4s var(--ease);
    }
    .bt-ppl-nav a:hover::after, .bt-ppl-nav a.active::after { width: 100%; }

    /* 3. Team Cards — Full Image Display + HD Lightbox */
    .bt-team-card {
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.03);
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }
    .bt-team-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); border-color: rgba(197,160,89,0.3); }
    .bt-team-img-wrap {
        height: 340px;
        overflow: hidden;
        position: relative;
        background: #f8fafc;
    }
    .bt-team-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 20%; /* Keep faces visible */
        transition: transform 1s ease;
    }
    .bt-team-card:hover img {
        transform: scale(1.05);
    }
    /* HD expand overlay */
    .bt-team-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(10,25,47,0.85) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        padding: 1.5rem 1.2rem;
    }
    .bt-team-card:hover .bt-team-overlay { opacity: 1; }
    .bt-team-overlay-expand {
        width: 38px; height: 38px;
        background: var(--gold);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 0.85rem;
        flex-shrink: 0;
    }
    .bt-team-overlay-label {
        font-size: 0.7rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.15em;
        color: rgba(255,255,255,0.8);
    }
    
    .bt-team-info {
        padding: 1.5rem;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        border-top: 1px solid rgba(0,0,0,0.03);
    }
    .bt-team-info h4 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--navy);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin: 0; line-height: 1.2;
    }
    .bt-team-info-icon {
        color: var(--gold); font-size: 1rem; flex-shrink: 0;
    }

    /* 4. Governance & Training Grid */
    .bt-feat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }
    .bt-feat-card {
        background: #fff;
        padding: 3rem 2rem;
        border-radius: 14px;
        text-align: center;
        border: 1px solid var(--border);
        transition: var(--transition);
        cursor: pointer;
        box-shadow: var(--shadow-sm);
    }
    .bt-feat-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-lg); border-color: var(--gold); }
    .bt-feat-icon {
        width: 70px; height: 70px; background: rgba(197,160,89,0.08); color: var(--gold);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem; font-size: 1.8rem; transition: var(--transition);
    }
    .bt-feat-card:hover .bt-feat-icon { background: var(--gold); color: #fff; transform: scale(1.1) rotate(10deg); }
    .bt-feat-card h3 { font-family: 'Oswald', sans-serif; font-weight: 700; font-size: 1rem; text-transform: uppercase; color: var(--navy); margin-bottom: 0.75rem; }
    .bt-feat-card p { font-size: 0.9rem; color: var(--text-muted); line-height: 1.7; margin:0; }

    /* 5. Full Modal */
    .bt-modal {
        display: none; position: fixed; z-index: 10000; inset: 0;
        background: rgba(10, 25, 47, 0.98); backdrop-filter: blur(20px);
        align-items: center; justify-content: center; padding: 3rem;
    }
    .bt-modal.open { display: flex; }
    .bt-modal-content {
        background: #fff; max-width: 1200px; width: 100%; border-radius: 8px;
        display: flex; flex-direction: column; max-height: 90vh;
    }
    .bt-modal-header { padding: 2rem 3rem; border-bottom: 1px solid #F1F1F1; display: flex; justify-content: space-between; align-items: center; }
    .bt-modal-title { font-family: var(--bt-font-display); font-weight: 900; text-transform: uppercase; color: var(--bt-navy); font-size: 1.5rem; }
    .bt-modal-close { font-size: 2rem; color: var(--bt-text-muted); cursor: pointer; transition: color 0.3s; }
    .bt-modal-close:hover { color: var(--bt-gold); }
    .bt-modal-body { padding: 3rem; overflow-y: auto; }
    
    .bt-gallery-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;
    }
    .bt-gallery-img { aspect-ratio: 4/3; border-radius: 4px; overflow: hidden; cursor: pointer; border: 1px solid #F1F1F1; transition: all 0.4s; }
    .bt-gallery-img:hover { border-color: var(--bt-gold); transform: scale(1.02); }
    .bt-gallery-img img { width: 100%; height: 100%; object-fit: cover; }

    @media (max-width: 1200px) {
        .bt-feat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .bt-ppl-nav a { padding: 1rem 1rem; font-size: 0.65rem; }
        .bt-feat-grid { grid-template-columns: 1fr; }
        .bt-modal { padding: 1rem; }
        .bt-modal-header { padding: 1.5rem; }
        .bt-modal-body { padding: 1.5rem; }
    }
</style>
@endpush

@section('content')
<div class="bt-wrapper">
    
    <header class="bt-people-hero">
        <div class="bt-people-hero-content reveal">
            <span class="bt-hero-badge">The Human Capital</span>
            <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(3rem,7vw,6rem); font-weight:700; color:white; text-transform:uppercase; line-height:1.0; margin-bottom:1rem;">
                Our <span style="color:var(--gold);">People.</span>
            </h1>
            <p style="font-size:1.05rem; color:rgba(255,255,255,0.65); max-width:560px; line-height:1.85; margin:0 auto;">Equipped with elite technical skills and supported by world-class field systems.</p>
        </div>
    </header>

    <!-- 2. STICKY NAV -->
    <div class="bt-ppl-nav-wrap">
        <nav class="bt-ppl-nav">
            <a href="{{ route('story') }}">Our Story</a>
            <a href="{{ route('corporate') }}">Governance</a>
            <a href="{{ route('sustainability') }}">Sustainability</a>
            <a href="{{ route('our-people') }}" class="active">Our People</a>
        </nav>
    </div>

    {{-- 3. TEAM GRID --}}
    <section style="background:white; padding:80px 0 100px;">
        <div class="bt-container">
            <div style="margin-bottom:3rem;" class="reveal">
                <span class="section-label">Force Multiplication</span>
                <h2 style="font-family:'Oswald',sans-serif; font-size:clamp(2rem,4vw,3.5rem); font-weight:700; color:var(--navy); text-transform:uppercase; margin-bottom:1rem;">
                    Corporate <span style="color:var(--gold);">Project Teams.</span>
                </h2>
                <p style="font-size:1rem; color:var(--text-muted); max-width:680px; line-height:1.85;">Our workforce operates through specialised project units, ensuring dedicated expertise for every industrial and healthcare environment. Click any photo to view it in full HD.</p>
            </div>

            {{-- 3-col grid: more professional display ratio --}}
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(350px, 1fr)); gap:2.5rem;">
                @php
                    $teams = \App\Models\OurPeople::with('media')->where('is_active', true)->orderBy('sort_order', 'asc')->get();
                @endphp

                @foreach($teams as $index => $t)
                    @php
                        $imgSrc = $t->displayImage ?: asset('img/logo.png');
                    @endphp
                    <div class="reveal" data-delay="{{ ($index % 4) * 80 }}">
                        <div class="bt-team-card">
                            {{-- Wrap in glightbox anchor for HD full-screen view --}}
                            <a href="{{ $imgSrc }}"
                               class="glightbox"
                               data-gallery="team-photos"
                               data-title="{{ $t->title }}"
                               data-description="{{ $t->department }}"
                               style="display:block; text-decoration:none;">
                                <div class="bt-team-img-wrap">
                                    <img src="{{ $imgSrc }}"
                                         alt="{{ $t->title }} — Builtech Project Management"
                                         loading="lazy"
                                         decoding="async"
                                         width="600"
                                         height="800">
                                    {{-- HD overlay with expand button --}}
                                    <div class="bt-team-overlay">
                                        <span class="bt-team-overlay-label">{{ $t->department }}</span>
                                        <span class="bt-team-overlay-expand">
                                            <i class="fas fa-expand-alt"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <div class="bt-team-info">
                                <h4>{{ $t->title }}</h4>
                                <span class="bt-team-info-icon"><i class="fas fa-users"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- HD hint --}}
            <p style="text-align:center; margin-top:2rem; font-size:0.8rem; color:var(--text-muted);">
                <i class="fas fa-search-plus" style="color:var(--gold); margin-right:6px;"></i>
                Click any photo to view the full team in HD
            </p>
        </div>
    </section>

    <!-- 4. GOVERNANCE & QUALITY GALLERIES -->
    <section class="bt-section bg-[#FBFBFA]">
        <div class="bt-container">
            <div class="max-w-3xl mb-24 reveal">
                <span class="bt-badge border-navy/10 text-navy bg-navy/5 mb-8">On-Site Standards</span>
                <h2 class="bt-title text-6xl text-navy">Governance <br><span class="bt-serif text-gold">& Safety.</span></h2>
                <p class="text-xl text-gray-400 font-light mt-8">We invest heavily in the continuous development and safety of our people through rigorous daily protocols and professional training.</p>
            </div>

            <div class="bt-feat-grid">
                {{-- Category 1 --}}
                <div class="reveal" data-delay="0">
                    <div class="bt-feat-card" onclick="openPplModal('site-coord')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-users-gear"></i></div>
                        <h3>Site Coordination</h3>
                        <p>High-level tactical alignment on site milestones.</p>
                    </div>
                </div>
                {{-- Category 2 --}}
                <div class="reveal" data-delay="100">
                    <div class="bt-feat-card" onclick="openPplModal('toolbox')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                        <h3>Tool Box Meeting</h3>
                        <p>Daily safety briefings and risk assessments.</p>
                    </div>
                </div>
                {{-- Category 3 --}}
                <div class="reveal" data-delay="200">
                    <div class="bt-feat-card" onclick="openPplModal('vector')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-bug-slash"></i></div>
                        <h3>Vector Control</h3>
                        <p>Strict hygiene and scheduled anti-larvae fogging.</p>
                    </div>
                </div>
                {{-- Category 4 --}}
                <div class="reveal" data-delay="300">
                    <div class="bt-feat-card" onclick="openPplModal('gotong')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-hands-holding"></i></div>
                        <h3>Gotong Royong</h3>
                        <p>Community clean-ups and environmental care.</p>
                    </div>
                </div>
                {{-- Category 5 --}}
                <div class="reveal" data-delay="0">
                    <div class="bt-feat-card" onclick="openPplModal('mgmt')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                        <h3>Management Training</h3>
                        <p>Executive leadership and development programmes.</p>
                    </div>
                </div>
                {{-- Category 6 --}}
                <div class="reveal" data-delay="100">
                    <div class="bt-feat-card" onclick="openPplModal('conquas')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-award"></i></div>
                        <h3>CONQUAS / QLASSIC</h3>
                        <p>Elite national quality benchmark training.</p>
                    </div>
                </div>
                {{-- Category 7 --}}
                <div class="reveal" data-delay="200">
                    <div class="bt-feat-card" onclick="openPplModal('first-aid')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-house-medical-circle-check"></i></div>
                        <h3>First Aid Readiness</h3>
                        <p>Comprehensive CPR and emergency certifications.</p>
                    </div>
                </div>
                {{-- Category 8 --}}
                <div class="reveal" data-delay="300">
                    <div class="bt-feat-card" onclick="openPplModal('workout')">
                        <div class="bt-feat-icon"><i class="fa-solid fa-dumbbell"></i></div>
                        <h3>Site Workout</h3>
                        <p>Morning exercise and technical upskilling drills.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FINAL CTA -->
    <section style="background:var(--navy); padding:100px 5%; position:relative; overflow:hidden;">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(var(--gold) 1px, transparent 0); background-size: 40px 40px;"></div>
        <div class="bt-container relative z-10 text-center reveal">
            <span class="section-label">Join Our Team</span>
            <h2 style="font-family:'Oswald',sans-serif; font-size:clamp(2.5rem,5vw,4rem); font-weight:700; color:white; text-transform:uppercase; margin-bottom:1rem; line-height:1.1;">
                Build Your Career <br><span style="color:var(--gold);">With Builtech.</span>
            </h2>
            <p style="font-size:1.05rem; color:rgba(255,255,255,0.65); max-width:560px; margin:0 auto 2.5rem; line-height:1.85;">
                We are always looking for technical pioneers to join our {{ date('Y') - 1996 }}-year legacy of engineering excellence.
            </p>
            <a href="{{ route('careers') }}" class="btn-primary">
                <i class="fas fa-briefcase" style="margin-right:8px;"></i> View Career Openings
            </a>
        </div>
    </section>
</div>

{{-- GALLERY MODAL --}}
<div id="ppl-gallery-modal" class="bt-modal">
    <div class="bt-modal-content">
        <div class="bt-modal-header">
            <h3 class="bt-modal-title" id="modal-cat-title">Gallery</h3>
            <div class="bt-modal-close" onclick="closePplModal()">&times;</div>
        </div>
        <div class="bt-modal-body">
            <div id="modal-gallery-grid" class="bt-gallery-grid"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const pplGalleries = {
        'site-coord': {
            title: 'Site Coordination',
            photos: ['site_coordination_meeting1.jpg', 'site_coordination_meeting2.jpg', 'site_coordination_meeting3.jpg']
        },
        'toolbox': {
            title: 'Tool Box Meetings',
            photos: ['TooBoxMeeting1.jpg', 'TooBoxMeeting2.jpg', 'TooBoxMeeting3.jpg']
        },
        'vector': {
            title: 'Vector Control',
            photos: ['fogging 1.jpg', 'fogging 3.jpg']
        },
        'gotong': {
            title: 'Gotong Royong',
            photos: ['gt1.jpg', 'gt2.jpg', 'gt3.jpg', 'gotong royong 2.jpg']
        },
        'mgmt': {
            title: 'Management Training',
            photos: ['IMG_0225a.jpg', 'IMG_0229a.jpg', 'IMG_0232a.jpg', 'PICT2616a.jpg', 'PICT2628a.jpg', 'PICT3989a.jpg', 'PICT3994a.jpg', 'PICT4003a.jpg']
        },
        'conquas': {
            title: 'CONQUAS / QLASSIC',
            photos: ['z 004a.jpg', 'z 153a.jpg', 'q2.jpg', 'q7.jpg', 'qlassic.jpg', 'PICT4970a.jpg', 'PICT4974a.jpg', 'PICT4977a.jpg']
        },
        'workout': {
            title: 'Site Workout & Upskilling',
            photos: ['workout1.jpg', 'workout2.jpg', 'workout3.jpg', 'workout4.jpg', 'workout5.jpg', 'workout6.jpg', 'workout7.jpg', 'workout8.jpg', 'workout9.jpg', 'workout10.jpg', 'workout11.jpg', 'workout12.jpg']
        },
        'first-aid': {
            title: 'First Aid Readiness',
            photos: ['PICT0307a.jpg', 'PICT0309a.jpg', 'PICT0311a.jpg', 'PICT0312a.jpg', 'PICT0318a.jpg']
        },
        'in-house': {
            title: 'In-House Training',
            photos: ['PICT1095a.jpg', 'PICT1096a.jpg']
        }
    };

    function openPplModal(key) {
        const gallery = pplGalleries[key];
        if (!gallery) return;

        document.getElementById('modal-cat-title').innerText = gallery.title;
        const grid = document.getElementById('modal-gallery-grid');
        grid.innerHTML = '';

        gallery.photos.forEach(imgName => {
            const wrapper = document.createElement('div');
            wrapper.className = 'bt-gallery-img';
            wrapper.onclick = () => openGlobalLightbox(`/img/images/${imgName}`);
            
            const img = document.createElement('img');
            img.src = `/img/images/${imgName}`;
            img.alt = gallery.title;
            img.loading = 'lazy';
            
            wrapper.appendChild(img);
            grid.appendChild(wrapper);
        });

        document.getElementById('ppl-gallery-modal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closePplModal() {
        document.getElementById('ppl-gallery-modal').classList.remove('open');
        document.body.style.overflow = '';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('ppl-gallery-modal');
        if (event.target == modal) closePplModal();
    }

    // ── Fix governance gallery images to show full (contain) ──
    document.querySelectorAll('.bt-gallery-img img').forEach(img => {
        img.style.objectFit = 'cover';
        img.style.background = '#f8fafc';
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
<script>
    // GLightbox for HD team photos
    const teamLightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: false,
        svg: {
            close: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#fff" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
        },
        openEffect: 'zoom',
        closeEffect: 'fade',
    });
</script>
@endpush