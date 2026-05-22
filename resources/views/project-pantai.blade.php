@extends('layouts.app')
@section('title', 'Builtech | Project Pantai')

@push('styles')
<style>

        :root {
            --navy: #1a242f;
            --gold: #c5a059;
            --gold-light: #dfc8a0;
            --white: #ffffff;
            --off-white: #fcfbf8;
            --text-muted: #7f8c8d;
        }

        body { font-family: 'Montserrat', sans-serif; background-color: var(--off-white); margin: 0; color: #333; line-height: 1.6; overflow-x: hidden; }
        
        /* Navigation */
        .navbar { 
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

        /* Logo Visibility Fix */
        .logo img { 
            height: 35px; 
            filter: brightness(0) invert(1); 
            transition: 0.3s;
        }

        .back-btn { color: var(--white); text-decoration: none; font-size: 0.75rem; font-weight: 700; letter-spacing: 2px; transition: 0.4s; display: flex; align-items: center; text-transform: uppercase; }
        .back-btn:hover { color: var(--gold); transform: translateX(-5px); }

        /* Hero Section */
        .project-hero { 
            background: linear-gradient(rgba(26, 36, 47, 0.75), rgba(26, 36, 47, 0.9)), url('/img/images/PHP 1A - Pantai Hospital Phase 1A-20260126T045008Z-1-001/PHP 1A - Pantai Hospital Phase 1A/WhatsApp Image 2025-08-26 at 2.08.44 PM.jpeg');
            background-size: cover; background-position: center; height: 60vh; 
            display: flex; flex-direction: column; justify-content: center; align-items: center; color: var(--white); text-align: center;
        }
        .project-hero h1 { font-family: 'Oswald', sans-serif; font-size: clamp(2.5rem, 5vw, 4rem); letter-spacing: 4px; margin: 10px 0; text-transform: uppercase; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
        .project-hero p { color: var(--gold); font-weight: 600; letter-spacing: 4px; font-size: 0.9rem; }

        /* Main Content Container */
        .container { max-width: 1200px; margin: -80px auto 80px; background: var(--white); padding: 60px; box-shadow: 0 30px 60px rgba(0,0,0,0.12); position: relative; border-radius: 2px; }
        
        .detail-grid { display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 60px; }
        
        .project-description h3 { font-family: 'Oswald', sans-serif; font-size: 2rem; color: var(--navy); border-left: 5px solid var(--gold); padding-left: 20px; margin-bottom: 25px; letter-spacing: 1px; }
        .project-description p { margin-bottom: 20px; text-align: justify; font-size: 0.95rem; color: #555; }

        /* Technical Specs Table */
        .project-specs { background: #fbfbfb; padding: 30px; border: 1px solid #eee; height: fit-content; }
        .specs-table { width: 100%; border-collapse: collapse; }
        .specs-table td { padding: 18px 10px; border-bottom: 1px solid #eee; font-size: 0.85rem; }
        .specs-table .label { font-weight: 700; color: var(--gold); text-transform: uppercase; font-size: 0.7rem; width: 35%; letter-spacing: 1px; }

        /* High-level Highlights */
        .highlights { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 40px 0; }
        .highlight-item { background: var(--white); padding: 30px 20px; border: 1px solid #eee; transition: 0.4s; position: relative; overflow: hidden; text-align: center; }
        .highlight-item::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--gold); transform: scaleX(0); transition: 0.4s; transform-origin: left; }
        .highlight-item:hover::after { transform: scaleX(1); }
        .highlight-item i { font-size: 2.2rem; color: var(--gold); margin-bottom: 20px; display: block; }
        .highlight-item h4 { font-family: 'Oswald', sans-serif; font-size: 1.1rem; margin: 10px 0; color: var(--navy); text-transform: uppercase; }
        .highlight-item p { font-size: 0.8rem; color: var(--text-muted); margin: 0; }

        /* Professional Gallery */
        .gallery-header { margin-top: 60px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 30px; }
        .gallery-header h3 { font-family: 'Oswald', sans-serif; font-size: 1.8rem; text-transform: uppercase; margin: 0; }
        
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .gallery-item { position: relative; overflow: hidden; border-radius: 2px; background: #000; height: 350px; }
        .gallery-img { width: 100%; height: 100%; object-fit: cover; transition: 0.6s cubic-bezier(0.165, 0.84, 0.44, 1); cursor: pointer; display: block; opacity: 0.9; }
        .gallery-item:hover .gallery-img { transform: scale(1.08); opacity: 1; filter: brightness(1.1); }
        .gallery-caption { position: absolute; bottom: 0; left: 0; width: 100%; padding: 20px; background: linear-gradient(transparent, rgba(26, 36, 47, 0.95)); color: white; font-size: 0.7rem; font-weight: 600; letter-spacing: 1px; opacity: 0; transition: 0.4s; pointer-events: none; }
        .gallery-item:hover .gallery-caption { opacity: 1; transform: translateY(0); }

        footer { background: var(--navy); color: var(--white); padding: 60px 0; text-align: center; margin-top: 0; }
        footer p { font-size: 0.75rem; letter-spacing: 2px; margin: 5px 0; opacity: 0.8; }

        @media (max-width: 992px) {
            .detail-grid { grid-template-columns: 1fr; }
            .container { margin: -40px 20px 40px; padding: 30px; }
            .gallery-grid { grid-template-columns: 1fr; }
            .highlights { grid-template-columns: 1fr; }
            .project-hero h1 { font-size: 2.5rem; }
        }
    
</style>
@endpush

@section('content')


    

    <header class="project-hero">
        <div data-aos="fade-up">
            <p>HEALTHCARE INFRASTRUCTURE SPECIALIST</p>
            <h1>PANTAI HOSPITAL EXTENSION</h1>
        </div>
    </header>

    <div class="container">
        <div class="detail-grid">
            <div class="project-description" data-aos="fade-right">
                <h3>PROJECT OVERVIEW</h3>
                <p>
                    As the main contractor for the Pantai Hospital expansion project (PHP 1A & 1B), Builtech Project Management Sdn Bhd was responsible for executing complex structural and finishing works. The project involved the construction of new inpatient wards, medical suites, and significant infrastructure upgrades to the existing hospital facility.
                </p>
                <p>
                    <b>The Medical Challenge:</b> Our core objective was executing heavy structural extension within an <b>active hospital environment</b>. This required rigorous adherence to infection control, noise mitigation, and zero-disruption protocols to ensure life-saving medical operations continued safely alongside construction.
                </p>
                
                <div class="highlights">
                    <div class="highlight-item" data-aos="zoom-in" data-aos-delay="100">
                        <i class="fas fa-microscope"></i>
                        <h4>Clinical Grade</h4>
                        <p>Specialized finishes meeting MOH sterile standards.</p>
                    </div>
                    <div class="highlight-item" data-aos="zoom-in" data-aos-delay="200">
                        <i class="fas fa-shield-virus"></i>
                        <h4>Active Safety</h4>
                        <p>Advanced dust & HEPA filtration during construction.</p>
                    </div>
                    <div class="highlight-item" data-aos="zoom-in" data-aos-delay="300">
                        <i class="fas fa-check-double"></i>
                        <h4>Quality Assured</h4>
                        <p>High QLASSIC rating for medical infrastructure.</p>
                    </div>
                </div>
            </div>

           
        </div>

        <div class="gallery-header" data-aos="fade-up">
            <h3>Construction Milestones</h3>
            <span style="font-size: 0.7rem; letter-spacing: 1px; color: var(--gold); font-weight: 700; text-transform: uppercase;">Phases 1A & 1B</span>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item" data-aos="fade-up" data-aos-delay="100">
                <img src="/img/images/PHP 1A - Pantai Hospital Phase 1A-20260126T045008Z-1-001/PHP 1A - Pantai Hospital Phase 1A/WhatsApp Image 2025-08-26 at 2.08.44 PM.jpeg" class="gallery-img" alt="Phase 1A Exterior">
                <div class="gallery-caption">PHASE 1A: MAIN STRUCTURAL EXTENSION</div>
            </div>
            
            <div class="gallery-item" data-aos="fade-up" data-aos-delay="200">
                <img src="/img/images/PHP 1A - Pantai Hospital Phase 1A-20260126T045008Z-1-001/PHP 1A - Pantai Hospital Phase 1A/WhatsApp Image 2025-08-26 at 2.08.46 PM (2).jpeg" class="gallery-img" alt="Structural Works">
                <div class="gallery-caption">PHASE 1A: CIVIL & STRUCTURAL REINFORCEMENT</div>
            </div>
            
            <div class="gallery-item" data-aos="fade-up" data-aos-delay="300">
                <img src="/img/images/ChatGPT Image Jan 29, 2026, 02_03_17 PM (1).png" class="gallery-img" alt="Phase 1B Site Progress">
                <div class="gallery-caption">PHASE 1B: MEDICAL SUITES & INTERNAL FIT-OUT</div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 60px;" data-aos="fade-up">
            <a href="/projects" style="text-decoration: none; color: var(--navy); font-weight: 700; font-size: 0.75rem; letter-spacing: 2px; border-bottom: 2px solid var(--gold); padding-bottom: 5px; transition: 0.3s;">
                EXPLORE ALL TRACK RECORDS <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
            </a>
        </div>
    </div>

    

    
    

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
        AOS.init({ duration: 1000, once: true });
    </script>

@endpush
