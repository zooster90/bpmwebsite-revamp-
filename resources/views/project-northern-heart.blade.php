@extends('layouts.app')
@section('title', 'Builtech | Project Northern Heart')

@push('styles')
<style>

        :root {
            --white: #ffffff;
            --off-white: #fcfcfc;
            --navy: #0a2540; 
            --gold: #c5a059;
            --gold-soft: #d4af37;
            --text-main: #1a1a1a;
            --text-light: #5e5e5e;
            --transition-smooth: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* --- SCROLL FIXES --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html {
            scroll-behavior: smooth;
            height: auto;
        }

        body { 
            font-family: 'Montserrat', sans-serif; 
            color: var(--text-main); 
            background: var(--white); 
            line-height: 1.8; 
            overflow-x: hidden; 
            overflow-y: auto; 
            width: 100%;
            -webkit-font-smoothing: antialiased;
        }

        /* --- NAVIGATION --- */
        .navbar {
            padding: 30px 5%; background: transparent;
            position: fixed; width: 100%; top: 0; z-index: 1100;
            display: flex; justify-content: space-between; align-items: center;
            transition: var(--transition-smooth);
        }
        .navbar.scrolled { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); padding: 15px 5%; border-bottom: 1px solid rgba(0,0,0,0.05); }
        
        .logo-img { 
            height: 40px; 
            transition: filter 0.3s ease; 
            filter: brightness(0) invert(1); 
        }
        
        .nav-links { display: flex; gap: 30px; }
        .nav-link { text-decoration: none; color: var(--white); font-size: 0.7rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; transition: 0.3s; }
        .navbar.scrolled .nav-link { color: var(--navy); }
        .nav-link:hover { color: var(--gold) !important; }

        /* --- HERO --- */
        .project-hero { 
            height: 100vh; 
            position: relative; 
            overflow: hidden; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .hero-bg {
            position: absolute; inset: 0;
            background-color: var(--navy);
            background-image: url('/img/images/drive-download-20260130T054033Z-3-001/Northern hospital outer.jpg');
            background-size: cover; background-position: center; z-index: -1;
            transform: scale(1.1); transition: 8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform;
        }
        .project-hero.active .hero-bg { transform: scale(1); }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(8,10,15,0.3), rgba(10,37,64,0.9)); }
        .hero-title-wrap { text-align: center; color: white; z-index: 10; padding: 0 20px; }
        .hero-title-wrap span { font-size: 0.8rem; letter-spacing: 8px; text-transform: uppercase; display: block; margin-bottom: 20px; color: var(--gold); font-weight: 600; }
        .hero-title-wrap h1 { font-family: 'Oswald'; font-size: clamp(2.5rem, 8vw, 6rem); font-weight: 700; text-transform: uppercase; line-height: 1.1; letter-spacing: -2px; }

        /* --- INFO GRID --- */
        .info-grid { padding: 120px 8%; display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 60px; background: var(--off-white); }
        .section-tag { font-family: 'Oswald'; font-size: 0.75rem; color: var(--gold); letter-spacing: 4px; text-transform: uppercase; margin-bottom: 20px; display: block; }
        .narrative-text h2 { font-family: 'Cormorant Garamond', serif; font-size: clamp(2.5rem, 5vw, 3.8rem); font-weight: 300; font-style: italic; color: var(--navy); line-height: 1.1; margin-bottom: 40px; }
        .narrative-text p { font-size: 1.05rem; color: var(--text-light); margin-bottom: 25px; }

        .spec-container { background: var(--white); padding: 40px; border-top: 4px solid var(--gold); box-shadow: 0 20px 50px rgba(0,0,0,0.05); border-radius: 4px; }
        .spec-item { border-bottom: 1px solid #f0f0f0; padding: 18px 0; display: flex; justify-content: space-between; align-items: center; }
        .spec-item:last-child { border: none; }
        .spec-label { font-size: 0.65rem; letter-spacing: 1px; text-transform: uppercase; color: var(--text-light); font-weight: 700; }
        .spec-value { font-family: 'Oswald'; font-size: 0.85rem; text-transform: uppercase; color: var(--navy); letter-spacing: 1px; }

        /* --- STATS --- */
        .engineering-stats { background: var(--navy); padding: 100px 8%; color: white; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; text-align: center; }
        .stat-card h5 { font-family: 'Oswald'; font-size: 4.5rem; color: var(--gold); margin-bottom: 5px; font-weight: 700; }
        .stat-card p { letter-spacing: 3px; text-transform: uppercase; font-size: 0.7rem; opacity: 0.8; }

        /* --- GALLERY --- */
        .details-gallery { padding: 120px 8%; background: var(--white); }
        .detail-main-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin: 50px 0; }
        .detail-sub-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        
        .gallery-item { position: relative; overflow: hidden; background: #111; border-radius: 4px; }
        .gallery-item.tall { height: 650px; }
        .gallery-item.short { height: 350px; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 1.5s var(--transition-smooth); opacity: 0.9; }
        .gallery-item:hover img { transform: scale(1.08); opacity: 1; }
        
        .img-caption { 
            position: absolute; bottom: 0; left: 0; right: 0; color: white; 
            font-family: 'Oswald'; font-size: 0.7rem; letter-spacing: 2px; 
            text-transform: uppercase; z-index: 5; background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 40px 25px 20px;
        }

        /* --- TECH FOCUS --- */
        .tech-focus { background: var(--off-white); padding: 100px 8%; }
        .tech-card-wrapper { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        .tech-card { background: var(--white); border: 1px solid #eee; padding: 50px; border-radius: 8px; transition: 0.4s; }
        .tech-card:hover { transform: translateY(-10px); border-color: var(--gold); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
        .tech-card i { font-size: 2.5rem; color: var(--gold); margin-bottom: 30px; }
        .tech-card h4 { font-family: 'Oswald'; margin-bottom: 15px; letter-spacing: 2px; text-transform: uppercase; font-size: 1.2rem; }

        /* --- CTA --- */
        .footer-cta { padding: 150px 8%; text-align: center; background: var(--navy); color: white; position: relative; }
        .footer-cta h3 { font-family: 'Cormorant Garamond', serif; font-size: clamp(2.5rem, 5vw, 4rem); font-style: italic; margin-bottom: 50px; font-weight: 300; }
        .btn-premium {
            padding: 20px 50px; border: 1px solid var(--gold); text-decoration: none; color: var(--gold);
            font-size: 0.8rem; letter-spacing: 4px; text-transform: uppercase; font-weight: 700;
            transition: 0.4s; display: inline-block; border-radius: 2px;
        }
        .btn-premium:hover { background: var(--gold); color: white; }

        footer { background: #000; color: #666; padding: 80px 8%; text-align: center; border-top: 1px solid #111; }

        @media (max-width: 1024px) {
            .info-grid { grid-template-columns: 1fr; padding-top: 150px; }
            .detail-main-grid { grid-template-columns: 1fr; }
            .detail-sub-grid-4 { grid-template-columns: 1fr 1fr; }
            .gallery-item.tall { height: 450px; }
        }
    
</style>
@endpush

@section('content')


    

    <header class="project-hero" id="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-title-wrap" data-aos="zoom-out">
            <span>Engineering Healthcare Excellence</span>
            <h1>Northern Heart<br>Hospital</h1>
        </div>
    </header>

    <main>
        <section class="info-grid">
            <div class="narrative-text" data-aos="fade-up">
                <span class="section-tag">Overview</span>
                <h2>Pioneering Cardiac <br>Care Infrastructure.</h2>
                <p>The Northern Heart Hospital represents a pinnacle in specialized medical facility construction. Builtech’s mandate as the Main Building Works partner was to ensure the highest degree of structural stability and precision for life-saving operations.</p>
                <p>Beyond traditional construction, the project demanded rigorous adherence to <b>Class 1 Medical Standards</b>, integrating heavy radiation shielding, vibration mitigation for sensitive imaging equipment, and ultra-reliable utility redundancies.</p>
            </div>
            
            
        </section>

        

        <section class="engineering-stats">
            <div class="stat-card" data-aos="fade-up">
                <h5 class="counter" data-target="100">0</h5>
                <p>Clinical Compliance %</p>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <h5 class="counter" data-target="750000">0</h5>
                <p>Safe Man Hours</p>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <h5 class="counter" data-target="0">0</h5>
                <p>LTI Incidents Recorded</p>
            </div>
        </section>

        <section class="details-gallery">
            <span class="section-tag" style="text-align: center; display: block;">Engineering Portfolio</span>
            
            <div class="detail-main-grid">
                <div class="gallery-item tall" data-aos="fade-up">
                    <img src="/img/images/drive-download-20260130T054033Z-3-001/Northern hospital outer.jpg" alt="Main Facade" onerror="this.src='https://placehold.co/800x1200?text=Facade+View'">
                    <span class="img-caption">Structural Envelope & Facade</span>
                </div>
                <div class="gallery-item tall" data-aos="fade-up" data-aos-delay="200">
                    <img src="/img/images/drive-download-20260130T054033Z-3-001/Northern hospital outer2.jpg" alt="Aerial View" onerror="this.src='https://placehold.co/800x1200?text=Aerial+View'">
                    <span class="img-caption">Site Logistics & Urban Integration</span>
                </div>
            </div>

            <div class="detail-sub-grid-4">
                <div class="gallery-item short" data-aos="fade-up">
                    <img src="/img/images/drive-download-20260130T054033Z-3-001/CT scan.jpg" alt="CT scan" onerror="this.src='https://placehold.co/600x400?text=Diagnostic+Suite'">
                    <span class="img-caption">Diagnostic Imaging Suite</span>
                </div>
                <div class="gallery-item short" data-aos="fade-up" data-aos-delay="100">
                    <img src="/img/images/drive-download-20260130T054033Z-3-001/Operation Thetre.png" alt="Operation Theatre" onerror="this.src='https://placehold.co/600x400?text=Operating+Theatre'">
                    <span class="img-caption">Class 100 Sterile OT</span>
                </div>
                <div class="gallery-item short" data-aos="fade-up" data-aos-delay="200">
                    <img src="/img/images/drive-download-20260130T054033Z-3-001/Pharmacy.jpg" alt="Pharmacy" onerror="this.src='https://placehold.co/600x400?text=Pharmacy+Cold+Chain'">
                    <span class="img-caption">Pharmacy & Cold Chain</span>
                </div>
                <div class="gallery-item short" data-aos="fade-up" data-aos-delay="300">
                    <img src="/img/images/drive-download-20260130T054033Z-3-001/ward.jpg" alt="Ward" onerror="this.src='https://placehold.co/600x400?text=Inpatient+Ward'">
                    <span class="img-caption">Inpatient Infrastructure</span>
                </div>
            </div>
        </section>

        

        <section class="tech-focus">
            <div class="tech-card-wrapper">
                <div class="tech-card" data-aos="fade-up">
                    <i class="fa-solid fa-microscope"></i>
                    <h4>Medical Precision</h4>
                    <p>Execution of vibration-controlled structural slabs to accommodate high-precision cardiac imaging and MRI technologies.</p>
                </div>
                <div class="tech-card" data-aos="fade-up" data-aos-delay="200">
                    <i class="fa-solid fa-bolt"></i>
                    <h4>Critical Resilience</h4>
                    <p>Installation of redundant power and gas systems ensuring 100% uptime for life-critical operating theaters.</p>
                </div>
            </div>
        </section>

        <section class="footer-cta" data-aos="fade-up">
            <h3>Constructing the <br>Future of Healthcare.</h3>
            <a href="/contact" class="btn-premium">Partner with our Experts</a>
        </section>
    </main>

    

    
    

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
        // AOS initialization
        AOS.init({ duration: 1000, once: true, offset: 100 });

        // Hero zoom effect on load
        window.addEventListener('load', () => { 
            setTimeout(() => {
                document.getElementById('hero').classList.add('active'); 
            }, 100);
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            const logo = document.getElementById('main-logo');
            if (window.scrollY > 80) {
                nav.classList.add('scrolled');
                logo.style.filter = "none";
            } else {
                nav.classList.remove('scrolled');
                logo.style.filter = "brightness(0) invert(1)";
            }
        });

        // Number counter logic
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const endValue = parseInt(target.getAttribute('data-target'));
                    let startValue = 0;
                    
                    if(endValue === 0 && !target.closest('.stat-card').innerText.includes('LTI')) {
                        target.innerText = "0";
                        return;
                    }

                    let duration = 2000; 
                    let stepTime = 50;
                    let increment = endValue / (duration / stepTime);

                    let counter = setInterval(() => {
                        startValue += increment;
                        if (startValue >= endValue) {
                            let suffix = target.closest('.stat-card').innerText.includes('%') ? '%' : '';
                            target.innerText = endValue.toLocaleString() + suffix;
                            clearInterval(counter);
                        } else {
                            target.innerText = Math.floor(startValue).toLocaleString();
                        }
                    }, stepTime);
                    counterObserver.unobserve(target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.counter').forEach(count => counterObserver.observe(count));
    </script>

@endpush
