@extends('layouts.app')
@section('title', 'Builtech | Project Aston')

@push('styles')
<style>

        :root {
            --navy: #1a242f; 
            --gold: #c5a059;
            --white: #ffffff;
            --off-white: #fcfbf8;
            --text-main: #333333;
            --text-muted: #7f8c8d;
        }

        /* Essential Scroll Fix */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body {
            width: 100%;
            height: auto; /* Allow content to dictate height */
            min-height: 100%;
            overflow-x: hidden; /* Prevent horizontal scroll */
            overflow-y: auto;   /* Force vertical scroll when needed */
            -webkit-overflow-scrolling: touch;
        }

        body { 
            font-family: 'Montserrat', sans-serif; 
            color: var(--text-main); 
            line-height: 1.6; 
            background: var(--off-white); 
        }

        /* --- NAVIGATION --- */
        header {
            background: var(--navy);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
        .logo img { 
            height: 35px; 
            filter: brightness(0) invert(1); 
            transition: 0.3s ease;
        }

        .nav-menu a { 
            text-decoration: none; color: var(--white); 
            font-weight: 600; font-size: 0.75rem; text-transform: uppercase; 
            letter-spacing: 2px; margin-left: 30px; transition: 0.3s;
        }
        .nav-menu a:hover { color: var(--gold); }

        /* --- HERO SECTION --- */
        .hero-banner {
            height: 65vh;
            background: linear-gradient(rgba(26, 36, 47, 0.6), rgba(26, 36, 47, 0.8)), url('/img/images/Aston Acasia 6.jpeg') center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
        }
        .hero-banner h1 { 
            font-family: 'Oswald', sans-serif; 
            font-size: clamp(2.5rem, 6vw, 4rem); 
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 10px; 
        }
        .hero-tag { font-weight: 600; letter-spacing: 5px; text-transform: uppercase; font-size: 0.9rem; color: var(--gold); }

        /* --- CONTENT SECTION --- */
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 100px 5%; 
            position: relative;
            display: block; /* Ensure it behaves as a block for flow */
        }
        
        .project-intro { display: grid; grid-template-columns: 1.6fr 1fr; gap: 60px; align-items: start; }
        
        .content-left h2 { 
            font-family: 'Oswald', sans-serif; font-size: 2.2rem; 
            color: var(--navy); margin-bottom: 30px; 
            border-left: 5px solid var(--gold); padding-left: 20px;
            text-transform: uppercase;
        }
        .content-left p { font-size: 1rem; color: #555; margin-bottom: 25px; text-align: justify; }

        /* --- METRICS GRID --- */
        .metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 40px 0; }
        .metric-item { background: var(--white); padding: 25px; border: 1px solid #eee; text-align: center; transition: 0.3s; }
        .metric-item:hover { border-top: 3px solid var(--gold); transform: translateY(-5px); }
        .metric-item i { color: var(--gold); font-size: 1.8rem; margin-bottom: 15px; display: block; }
        .metric-item span { font-family: 'Oswald', sans-serif; font-size: 1.2rem; display: block; color: var(--navy); }
        .metric-item label { font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; }

        /* --- SPEC BOX --- */
        .spec-box { 
            background: var(--white); 
            padding: 40px; 
            border: 1px solid #eee;
            box-shadow: 0 15px 40px rgba(0,0,0,0.05);
        }
        .spec-box h4 { 
            font-family: 'Oswald', sans-serif; 
            margin-bottom: 25px; text-transform: uppercase; letter-spacing: 2px; font-size: 1.1rem; color: var(--navy);
            border-bottom: 2px solid var(--gold); display: inline-block; padding-bottom: 5px;
        }
        .spec-line { 
            display: flex; justify-content: space-between; 
            padding: 15px 0; border-bottom: 1px solid #f0f0f0; 
        }
        .spec-line:last-child { border-bottom: none; }
        .label { font-weight: 700; font-size: 0.7rem; color: var(--gold); text-transform: uppercase; letter-spacing: 1px; }
        .val { font-weight: 500; font-size: 0.9rem; color: var(--navy); }

        /* --- GALLERY --- */
        .gallery-grid { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px; 
            margin-top: 40px;
        }
        .gallery-item { height: 350px; overflow: hidden; position: relative; border-radius: 2px; background: #000; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.6s cubic-bezier(0.165, 0.84, 0.44, 1); opacity: 0.9; }
        .gallery-item:hover img { transform: scale(1.1); opacity: 1; }

        /* --- CTA --- */
        .cta-strip { 
            background: var(--navy); color: var(--white); 
            padding: 80px 5%; text-align: center; 
        }
        .cta-strip h3 { font-family: 'Oswald', sans-serif; font-size: 2.2rem; margin-bottom: 30px; letter-spacing: 2px; }
        .btn-contact { 
            padding: 18px 45px; background: var(--gold); color: white; 
            text-decoration: none; font-weight: 700; text-transform: uppercase;
            letter-spacing: 2px; transition: 0.3s; display: inline-block; font-size: 0.8rem;
        }
        .btn-contact:hover { background: #a68546; transform: translateY(-3px); }

        footer { 
            background: var(--navy); 
            padding: 60px 5%; 
            text-align: center; 
            color: rgba(255,255,255,0.6); 
            font-size: 0.7rem; 
            letter-spacing: 1px; 
        }

        @media (max-width: 900px) {
            .project-intro { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: 1fr; }
            .metrics { grid-template-columns: 1fr; }
            .hero-banner { height: 50vh; }
        }
    
</style>
@endpush

@section('content')


    <header>
        <div class="logo">
            <a href="/">
                <img src="/img/images/61da7874-55a9-46d1-b71c-32ddac2a7740.png" id="navbar-logo" alt="Builtech" onerror="this.src='https://placehold.co/200x50/1a242f/ffffff?text=BUILTECH'">
            </a>
        </div>
        
    </header>

    <section class="hero-banner">
        <div data-aos="fade-up">
            <p class="hero-tag">High-Rise Residential</p>
            <h1>Aston Acacia</h1>
        </div>
    </section>

    <main class="container">
        <section class="project-intro">
            <div class="content-left" data-aos="fade-right">
                <h2>Project Profile & Management</h2>
                <p>Aston Acacia stands as a prestigious landmark in Bukit Mertajam, redefining urban living with its contemporary architectural design. As the appointed Project Manager for the main building works, <b>Builtech</b> oversaw the comprehensive structural development of two 33-storey towers.</p>
                <p>Our management philosophy centered on <b>Lean Construction</b> principles, ensuring that the 712 residential units and comprehensive podium facilities were delivered with uncompromising structural integrity. We achieved a seamless coordination between multiple sub-contractors and consultants to maintain the project's aggressive timeline.</p>
                
                <div class="metrics">
                    <div class="metric-item" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-layer-group"></i>
                        <span>33 Storeys</span>
                        <label>Dual Tower Height</label>
                    </div>
                    <div class="metric-item" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-shield-alt"></i>
                        <span>Zero LTI</span>
                        <label>Safety Milestone</label>
                    </div>
                    <div class="metric-item" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-check-circle"></i>
                        <span>QLASSIC</span>
                        <label>Quality Standard</label>
                    </div>
                </div>
            </div>
            
           
        </section>

        <h3 style="font-family: 'Oswald', sans-serif; margin: 60px 0 20px; text-transform: uppercase; color: var(--navy);">Construction Progress Gallery</h3>
        <div class="gallery-grid">
            <div class="gallery-item" data-aos="zoom-in"><img src="/img/images/Aston Acasia 2.jpeg" alt="Tower View"></div>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100"><img src="/img/images/Aston Acasia 4.jpeg" alt="Podium Detail"></div>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200"><img src="/img/images/Aston Acasia 3.jpeg" alt="Facade Finishing"></div>
        </div>
    </main>

    <section class="cta-strip">
        <h3 data-aos="fade-up">Ready to Start Your Next Landmark?</h3>
        <a href="/contact" class="btn-contact" data-aos="fade-up" data-aos-delay="200">Consult Our Experts</a>
    </section>

    

    
    

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
        AOS.init({ duration: 1000, once: true });
    </script>

@endpush
