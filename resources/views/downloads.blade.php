@extends('layouts.app')
@section('title', 'Document Center | Builtech Downloads')
@section('description', 'Access Builtech corporate credentials, safety policies, quality certifications, and vendor registration forms.')

@push('styles')
<style>
    :root {
        --white: #ffffff;
        --off-white: #fcfbf8;
        --gold: #c5a059;
        --navy: #1a242f; 
        --text-main: #34495e;
        --text-light: #7f8c8d;
        --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        --shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    /* --- PAGE HEADER --- */
    .dl-header {
        background: linear-gradient(rgba(26, 36, 47, 0.9), rgba(26, 36, 47, 0.9)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920');
        background-size: cover; background-position: center;
        padding: 100px 5%; text-align: center; color: white;
    }
    .dl-header h1 { font-family: 'Oswald'; font-size: 3.5rem; letter-spacing: 5px; text-transform: uppercase; }
    .dl-header p { color: var(--gold); font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px; }

    /* --- DOWNLOADS CONTENT --- */
    .dl-container { max-width: 1200px; margin: -50px auto 100px; padding: 0 20px; position: relative; z-index: 10; }
    
    .dl-section { margin-bottom: 60px; }
    .dl-section-title { 
        font-family: 'Oswald'; font-size: 1.8rem; color: var(--navy); 
        margin-bottom: 30px; border-left: 5px solid var(--gold); padding-left: 15px;
        text-transform: uppercase; letter-spacing: 2px;
    }

    .dl-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }

    .dl-card {
        background: var(--white); padding: 30px; border-radius: 12px;
        box-shadow: var(--shadow); transition: var(--transition);
        display: flex; align-items: center; gap: 20px; text-decoration: none; border: 1px solid transparent;
    }
    .dl-card:hover { transform: translateY(-5px); border-color: var(--gold); box-shadow: 0 15px 35px rgba(197, 160, 89, 0.15); }

    .dl-icon { font-size: 2.5rem; color: #e74c3c; /* PDF Red */ }
    .dl-info h3 { font-family: 'Oswald'; font-size: 1.1rem; color: var(--navy); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
    .dl-info p { font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 700; }
    .dl-btn { margin-left: auto; color: var(--gold); font-size: 1.2rem; transition: 0.3s; }
    .dl-card:hover .dl-btn { color: var(--navy); transform: scale(1.2); }

    @media (max-width: 768px) {
        .dl-header h1 { font-size: 2.5rem; }
        .dl-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

    <header class="dl-header">
        <p>Resources & Compliance</p>
        <h1>Document Center</h1>
    </header>

    <main class="dl-container">
        
        <section class="dl-section reveal">
            <h2 class="dl-section-title">Corporate Credentials</h2>
            <div class="dl-grid">
                <a href="{{ asset('assets/builtech-profile.pdf') }}" class="dl-card" download>
                    <div class="dl-icon"><i class="fas fa-file-pdf"></i></div>
                    <div class="dl-info">
                        <h3>Company Profile</h3>
                        <p>PDF • 4.5 MB</p>
                    </div>
                    <div class="dl-btn"><i class="fas fa-download"></i></div>
                </a>
                <a href="{{ asset('assets/cidb-g7-cert.pdf') }}" class="dl-card" download>
                    <div class="dl-icon"><i class="fas fa-file-pdf"></i></div>
                    <div class="dl-info">
                        <h3>CIDB G7 License</h3>
                        <p>PDF • 1.2 MB</p>
                    </div>
                    <div class="dl-btn"><i class="fas fa-download"></i></div>
                </a>
                <a href="{{ asset('assets/iso-certificates.pdf') }}" class="dl-card" download>
                    <div class="dl-icon"><i class="fas fa-file-pdf"></i></div>
                    <div class="dl-info">
                        <h3>ISO Certifications</h3>
                        <p>PDF • 2.8 MB</p>
                    </div>
                    <div class="dl-btn"><i class="fas fa-download"></i></div>
                </a>
            </div>
        </section>

        <section class="dl-section reveal">
            <h2 class="dl-section-title">Safety & Quality Policies</h2>
            <div class="dl-grid">
                <a href="{{ asset('assets/safety-policy.pdf') }}" class="dl-card" download>
                    <div class="dl-icon" style="color: #27ae60;"><i class="fas fa-shield-alt"></i></div>
                    <div class="dl-info">
                        <h3>OHS Policy</h3>
                        <p>PDF • 0.8 MB</p>
                    </div>
                    <div class="dl-btn"><i class="fas fa-download"></i></div>
                </a>
                <a href="{{ asset('assets/environmental-policy.pdf') }}" class="dl-card" download>
                    <div class="dl-icon" style="color: #27ae60;"><i class="fas fa-leaf"></i></div>
                    <div class="dl-info">
                        <h3>Environmental Policy</h3>
                        <p>PDF • 0.9 MB</p>
                    </div>
                    <div class="dl-btn"><i class="fas fa-download"></i></div>
                </a>
            </div>
        </section>

        <section class="dl-section reveal">
            <h2 class="dl-section-title">Vendor & Careers</h2>
            <div class="dl-grid">
                <a href="{{ asset('assets/vendor-registration.pdf') }}" class="dl-card" download>
                    <div class="dl-icon" style="color: #2980b9;"><i class="fas fa-file-contract"></i></div>
                    <div class="dl-info">
                        <h3>Vendor Registration</h3>
                        <p>DOCX • 1.1 MB</p>
                    </div>
                    <div class="dl-btn"><i class="fas fa-download"></i></div>
                </a>
                <a href="{{ asset('assets/internship-form.pdf') }}" class="dl-card" download>
                    <div class="dl-icon" style="color: #2980b9;"><i class="fas fa-user-graduate"></i></div>
                    <div class="dl-info">
                        <h3>Internship Application</h3>
                        <p>PDF • 1.5 MB</p>
                    </div>
                    <div class="dl-btn"><i class="fas fa-download"></i></div>
                </a>
            </div>
        </section>

    </main>

@endsection

@push('scripts')
<script>
    // Reveal Observer is in layouts.app
</script>
@endpush
