@extends('layouts.app')
@section('title', 'Careers | Join Builtech — Malaysia Grade G7 Engineering Team')
@section('description', 'Explore career opportunities at Builtech Project Management Sdn. Bhd. Join Malaysia\'s leading CIDB Grade G7 contractor based in Penang.')

@push('styles')
<style>
/* ── CAREERS PAGE ── */
.careers-hero {
    position: relative; min-height: 60vh;
    display: flex; align-items: flex-end;
    background: var(--navy); overflow: hidden;
    padding: 160px 5% 80px;
}
.careers-hero::before {
    content: ''; position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1920') center/cover;
    opacity: 0.18; filter: grayscale(60%);
    animation: heroZoom 22s alternate infinite ease-in-out;
}
.careers-hero::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(10,25,47,0.97) 0%, rgba(26,36,47,0.82) 100%);
}
@keyframes heroZoom { 0%{transform:scale(1)} 100%{transform:scale(1.07)} }

/* Job Cards */
.job-card {
    background: white; border-radius: 14px;
    border: 1px solid var(--border);
    padding: 2.2rem 2.5rem;
    transition: var(--transition);
    position: relative; overflow: hidden;
    display: flex; flex-direction: column;
    box-shadow: var(--shadow-sm);
}
.job-card::before {
    content: ''; position: absolute;
    top: 0; left: 0; width: 4px; height: 0;
    background: var(--gold);
    transition: height 0.5s ease;
}
.job-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,0.09); border-color: var(--border-gold); }
.job-card:hover::before { height: 100%; }

.job-dept {
    font-size: 0.7rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.2em;
    color: var(--gold); margin-bottom: 0.5rem;
    display: flex; align-items: center; gap: 6px;
}
.job-title {
    font-family: 'Oswald', sans-serif;
    font-size: 1.5rem; font-weight: 700;
    color: var(--navy); text-transform: uppercase;
    margin-bottom: 1rem; line-height: 1.2;
}
.job-meta { display: flex; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 1.5rem; }
.job-tag {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.75rem; font-weight: 700;
    color: var(--navy); background: var(--off-white);
    padding: 5px 12px; border-radius: 50px;
    border: 1px solid var(--border);
}
.job-tag.urgent {
    background: rgba(220,38,38,0.06);
    color: #dc2626; border-color: rgba(220,38,38,0.15);
}
.job-desc {
    font-size: 0.95rem; color: var(--text-muted);
    line-height: 1.75; flex-grow: 1; margin-bottom: 1.8rem;
}

/* Benefit Cards */
.benefit-card {
    background: white; border-radius: 12px;
    border: 1px solid var(--border);
    padding: 2rem; transition: var(--transition);
    display: flex; align-items: flex-start; gap: 1.2rem;
    box-shadow: var(--shadow-sm);
}
.benefit-card:hover { transform: translateY(-5px); border-color: var(--border-gold); box-shadow: var(--shadow-md); }
.benefit-icon {
    width: 52px; height: 52px; flex-shrink: 0;
    background: rgba(197,160,89,0.08);
    border-radius: 12px; display: flex;
    align-items: center; justify-content: center;
    color: var(--gold); font-size: 1.3rem;
    border: 1px solid rgba(197,160,89,0.15);
    transition: var(--transition);
}
.benefit-card:hover .benefit-icon { background: var(--gold); color: white; }

/* Process Steps */
.process-section {
    background: linear-gradient(135deg, #0a1f38 0%, #0d1218 100%);
    position: relative; overflow: hidden;
}
.process-section::before {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(rgba(197,160,89,0.04) 1px, transparent 0);
    background-size: 40px 40px;
}
.process-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2.5rem; margin-top: 3.5rem;
}
.process-step-circle {
    width: 72px; height: 72px;
    border: 2px solid rgba(197,160,89,0.4);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    font-family: 'Oswald', sans-serif;
    color: var(--gold); font-weight: 700; font-size: 1.4rem;
    background: rgba(10,31,56,0.8); transition: var(--transition);
}
.process-item:hover .process-step-circle {
    background: var(--gold); color: white;
    border-color: var(--gold);
    box-shadow: 0 0 0 10px rgba(197,160,89,0.1);
}
.process-item { text-align: center; }
.process-item h4 {
    font-family: 'Oswald', sans-serif; font-size: 1.15rem;
    font-weight: 700; color: white; margin-bottom: 0.6rem;
    text-transform: uppercase;
}
.process-item p { font-size: 0.92rem; color: rgba(255,255,255,0.6); line-height: 1.75; }

/* Form */
.apply-card {
    background: white; border-radius: 20px;
    padding: 3.5rem; box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    max-width: 900px; margin: 0 auto;
}
.field-wrap { margin-bottom: 1.8rem; }
.field-wrap label {
    display: block; font-size: 0.72rem; font-weight: 800;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 0.2em; margin-bottom: 0.5rem;
}
.field-wrap input, .field-wrap textarea, .field-wrap select {
    width: 100%; padding: 1rem 1.1rem;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.97rem; color: var(--navy);
    background: #fafafa; transition: all 0.3s; outline: none;
}
.field-wrap input:focus, .field-wrap textarea:focus, .field-wrap select:focus {
    border-color: var(--gold); background: white;
    box-shadow: 0 0 0 4px rgba(197,160,89,0.12);
}
.field-wrap textarea { min-height: 120px; resize: vertical; }

.upload-zone {
    border: 2px dashed #d1c4a0; background: #fffdf8;
    border-radius: 12px; padding: 2.5rem 2rem;
    text-align: center; cursor: pointer;
    position: relative; transition: var(--transition);
}
.upload-zone:hover { border-color: var(--gold); background: rgba(197,160,89,0.04); }
.upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

/* Stats overlap */
.career-stats {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 1.5rem; margin: -55px auto 0;
    max-width: 1320px; padding: 0 5%;
    position: relative; z-index: 30;
}
.career-stat-box {
    background: white; border-radius: 14px;
    padding: 1.8rem; text-align: center;
    box-shadow: var(--shadow-lg); border: 1px solid var(--border);
}
.career-stat-box .val {
    font-family: 'Oswald', sans-serif;
    font-size: 2.5rem; font-weight: 700;
    color: var(--navy); line-height: 1; display: block;
}
.career-stat-box .val span { color: var(--gold); }
.career-stat-box .lbl {
    font-size: 0.7rem; font-weight: 800;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 0.2em; display: block; margin-top: 0.4rem;
}

@media (max-width: 1024px) {
    .career-stats { grid-template-columns: 1fr; margin-top: 0; }
}
@media (max-width: 768px) {
    .apply-card { padding: 2rem; }
    .careers-hero { padding: 120px 5% 60px; }
}

/* ── FORM MODAL ── */
.modal-backdrop {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(10, 25, 47, 0.75);
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    display: flex; align-items: center; justify-content: center;
    padding: 1.5rem;
}
.modal-container {
    background: white; width: 100%; max-width: 850px;
    max-height: 90vh; border-radius: 20px;
    border: 1px solid var(--border-gold);
    position: relative; overflow: hidden;
    box-shadow: 0 25px 60px -15px rgba(10, 25, 47, 0.35);
    display: flex; flex-direction: column;
}
.modal-header {
    position: sticky; top: 0; background: white;
    padding: 2rem 2.5rem 1rem; border-bottom: 1px solid var(--border);
    z-index: 10; display: flex; justify-content: space-between; align-items: flex-start;
}
.modal-body {
    padding: 1.5rem 2.5rem 2.5rem; overflow-y: auto;
}
.modal-close-btn {
    background: var(--off-white); color: var(--navy);
    border: 1px solid var(--border); width: 40px; height: 40px;
    border-radius: 50%; display: inline-flex; align-items: center;
    justify-content: center; font-size: 1.1rem; cursor: pointer;
    transition: var(--transition);
}
.modal-close-btn:hover {
    background: #dc2626; color: white; border-color: #dc2626;
    transform: rotate(90deg);
}

@media (max-width: 768px) {
    .modal-backdrop { padding: 0; align-items: flex-end; }
    .modal-container { max-height: 92vh; border-radius: 24px 24px 0 0; }
    .modal-header { padding: 1.5rem 1.5rem 0.8rem; }
    .modal-body { padding: 1rem 1.5rem 2.5rem; }
    .modal-body .form-grid { grid-template-columns: 1fr !important; gap: 0rem !important; }
}
</style>
@endpush

@section('content')
<div class="bt-wrapper" x-data="{ showForm: {{ ($errors->any() || session('success')) ? 'true' : 'false' }}, selectedJob: '' }">

    {{-- ── HERO ── --}}
    <header class="careers-hero">
        <div class="bt-container relative z-10 reveal">
            <span class="section-label"><i class="fas fa-hard-hat" style="margin-right:8px;"></i>We Are Hiring</span>
            <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(3rem,6vw,5.5rem); font-weight:700; color:white; text-transform:uppercase; line-height:1.05; letter-spacing:1px; margin-bottom:1rem;">
                Build Your Career<br><span style="color:var(--gold);">With Builtech.</span>
            </h1>
            <p style="font-size:1.05rem; color:rgba(255,255,255,0.72); max-width:560px; line-height:1.85; margin-bottom:2rem;">
                Join Malaysia's leading CIDB Grade G7 engineering firm. We invest in people who are passionate about constructing excellence — from site to boardroom.
            </p>
            <div style="display:flex; flex-wrap:wrap; gap:1rem; align-items:center;">
                <a href="#open-positions" class="btn-primary"><i class="fas fa-search"></i> View Open Roles</a>
                <a href="#apply-now" @click.prevent="showForm=true"
                   class="btn-primary btn-outline-white btn-attention"><i class="fas fa-paper-plane"></i> Submit Application</a>
            </div>
        </div>
    </header>

    {{-- ── STATS OVERLAP ── --}}
    <div class="career-stats">
        @php $yrs = date('Y') - 1996; @endphp
        <div class="career-stat-box reveal stagger-1">
            <span class="val"><span class="counter" data-target="{{ $yrs }}">0</span><span>+</span></span>
            <span class="lbl">Years in Operation</span>
        </div>
        <div class="career-stat-box reveal stagger-2">
            <span class="val">G<span class="counter" data-target="7">0</span></span>
            <span class="lbl">CIDB Highest Grade</span>
        </div>
        <div class="career-stat-box reveal stagger-3">
            <span class="val"><span class="counter" data-target="{{ count($jobs ?? []) }}">0</span><span>+</span></span>
            <span class="lbl">Active Openings</span>
        </div>
    </div>

    {{-- ── OPEN POSITIONS ── --}}
    <section id="open-positions" class="bt-section" style="background:var(--off-white);">
        <div class="bt-container">
            <div class="section-header-left reveal" style="margin-bottom:3.5rem;">
                <span class="section-label">Career Opportunities</span>
                <h2 class="section-title" style="text-align:left;">Current <span style="color:var(--gold);">Openings</span></h2>
                <p class="section-desc" style="text-align:left; margin:0; max-width:580px;">
                    Browse our active roles below. Click <strong>Apply Now</strong> on any position to pre-fill the application form, or submit a general inquiry at the bottom of this page.
                </p>
            </div>

            @if(count($jobs ?? []) > 0)
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(340px,1fr)); gap:2rem;">
                @foreach($jobs as $job)
                <div class="job-card reveal" data-delay="{{ $loop->index * 80 }}">
                    <div class="job-dept"><i class="fas fa-layer-group"></i> {{ $job->department ?? 'Engineering' }}</div>
                    <h3 class="job-title">{{ $job->title }}</h3>
                    <div class="job-meta">
                        <span class="job-tag"><i class="fas fa-map-marker-alt" style="color:var(--gold);"></i> {{ $job->location ?? 'Penang, Malaysia' }}</span>
                        <span class="job-tag"><i class="fas fa-briefcase" style="color:var(--gold);"></i> {{ $job->type ?? 'Full-Time' }}</span>
                        @if($job->closing_date)
                            <span class="job-tag urgent"><i class="fas fa-clock"></i> Closes {{ \Carbon\Carbon::parse($job->closing_date)->format('d M Y') }}</span>
                        @endif
                    </div>
                    @if($job->description)
                        <p class="job-desc">{{ Str::limit($job->description, 180) }}</p>
                    @endif
                    <button
                        @click="selectedJob='{{ addslashes($job->title) }}'; showForm=true; $nextTick(()=>{ document.getElementById('pos_input').value='{{ addslashes($job->title) }}'; document.getElementById('job_id_input').value='{{ $job->id }}'; })"
                        class="btn-primary" style="width:100%; justify-content:center; margin-top:auto;">
                        Apply Now <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
                    </button>
                </div>
                @endforeach
            </div>
            @else
            <div class="reveal" style="background:white; border-radius:16px; padding:5rem 3rem; text-align:center; border:1px dashed rgba(197,160,89,0.4);">
                <i class="fas fa-briefcase" style="font-size:3rem; color:var(--gold); opacity:0.5; display:block; margin-bottom:1.5rem;"></i>
                <h3 style="font-family:'Oswald',sans-serif; font-size:1.8rem; color:var(--navy); text-transform:uppercase; margin-bottom:1rem;">All Positions Currently Filled</h3>
                <p style="color:var(--text-muted); max-width:500px; margin:0 auto 2rem; line-height:1.8;">We are always on the lookout for exceptional talent. Submit a general application and our HR team will be in touch for future openings.</p>
                <button @click="showForm=true" class="btn-primary">
                    <i class="fas fa-envelope"></i> Submit General Application
                </button>
            </div>
            @endif
        </div>
    </section>

    {{-- ── WHY JOIN BUILTECH ── --}}
    <section class="bt-section" style="background:white;">
        <div class="bt-container">
            <div class="section-header-center reveal" style="margin-bottom:4rem;">
                <span class="section-label">Our Promise to You</span>
                <h2 class="section-title">Why Build Your Career <span style="color:var(--gold);">Here?</span></h2>
                <p class="section-desc">We believe great engineering starts with great people. Builtech offers a workplace where ambition meets opportunity.</p>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:1.5rem;">
                @foreach([
                    ['fas fa-chart-line','Career Progression','Clear promotion paths, annual performance reviews, and leadership development programmes to fast-track your growth.'],
                    ['fas fa-hard-hat','G7-Scale Projects','Work on Malaysia\'s most complex commercial and industrial projects, gaining experience that is unmatched in the industry.'],
                    ['fas fa-graduation-cap','Training & Certification','Full sponsorship for CIDB, safety certifications, BIM training, and professional membership fees.'],
                    ['fas fa-heart-pulse','Comprehensive Benefits','Medical, dental, and hospitalisation coverage for you and your dependants, plus annual leave and public holidays.'],
                    ['fas fa-users','Collaborative Culture','A team-first environment built on mutual respect, open communication, and shared accountability.'],
                    ['fas fa-shield-halved','Job Stability','30 years of continuous operation with a strong project pipeline means long-term, secure employment.'],
                ] as [$icon, $title, $desc])
                <div class="benefit-card reveal">
                    <div class="benefit-icon"><i class="{{ $icon }}"></i></div>
                    <div>
                        <h4 style="font-family:'Oswald',sans-serif; font-size:1.1rem; font-weight:700; color:var(--navy); text-transform:uppercase; margin-bottom:0.4rem;">{{ $title }}</h4>
                        <p style="font-size:0.92rem; color:var(--text-muted); line-height:1.75; margin:0;">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── APPLICATION PROCESS ── --}}
    <section class="process-section bt-section">
        <div class="bt-container">
            <div class="text-center reveal">
                <span class="section-label" style="justify-content:center;">Our Hiring Process</span>
                <h2 class="section-title section-title--white">What Happens <span style="color:var(--gold);">After You Apply?</span></h2>
                <p style="font-size:1rem; color:rgba(255,255,255,0.6); max-width:600px; margin:1rem auto 0; line-height:1.8;">
                    A transparent, respectful, and efficient process — from submission to offer.
                </p>
            </div>
            <div class="process-grid">
                @foreach([
                    ['01','Application Review','Our HR team reviews every submission within 5 business days and shortlists candidates based on qualifications and fit.'],
                    ['02','Initial Interview','A structured phone or video call with HR to assess your background, expectations, and communication skills.'],
                    ['03','Technical Assessment','A face-to-face interview with the department head to evaluate your technical knowledge and problem-solving ability.'],
                    ['04','Offer & Onboarding','Successful candidates receive a formal offer. Our team guides you through onboarding for a smooth first day.'],
                ] as [$num, $title, $desc])
                <div class="process-item reveal stagger-{{ $loop->index + 1 }}">
                    <div class="process-step-circle">{{ $num }}</div>
                    <h4>{{ $title }}</h4>
                    <p>{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── APPLICATION FORM MODAL ── --}}
    <div 
        id="apply-now" 
        class="modal-backdrop" 
        x-show="showForm" 
        x-effect="document.body.style.overflow = showForm ? 'hidden' : ''"
        style="display:none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div 
            class="modal-container"
            x-show="showForm"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-12 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 scale-95"
            @click.away="showForm = false"
        >
            <!-- Modal Header -->
            <div class="modal-header">
                <div>
                    <span class="section-label" style="margin-bottom:0.25rem;"><i class="fas fa-id-card-clip" style="margin-right:6px;"></i>Application Form</span>
                    <h2 style="font-family:'Oswald',sans-serif; font-size:1.8rem; font-weight:700; color:var(--navy); text-transform:uppercase; margin:0;">
                        Submit Your <span style="color:var(--gold);">Application</span>
                    </h2>
                </div>
                <button type="button" class="modal-close-btn" @click="showForm = false" aria-label="Close form">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p style="font-size:0.95rem; color:var(--text-muted); line-height:1.6; margin-bottom:2rem; margin-top:0;">
                    Please fill in all required fields accurately. Our HR team reviews every application and will contact you within 5 business days.
                </p>

                @if(session('success'))
                    <div style="background:rgba(56,161,105,0.1); border:1px solid rgba(56,161,105,0.3); border-radius:10px; padding:1.2rem 1.5rem; margin-bottom:2rem; display:flex; align-items:center; gap:12px;">
                        <i class="fas fa-check-circle" style="color:#38a169; font-size:1.4rem;"></i>
                        <p style="color:#276749; font-weight:700; margin:0;">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div style="background:rgba(220,38,38,0.08); border:1px solid rgba(220,38,38,0.2); border-radius:10px; padding:1.2rem 1.5rem; margin-bottom:2rem;">
                        <p style="color:#dc2626; font-weight:700; margin:0 0 0.5rem;"><i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>Please correct the following:</p>
                        <ul style="margin:0; padding-left:1.2rem; color:#dc2626; font-size:0.9rem;">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('careers.apply') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="hidden"><input type="text" name="fax_number"></div>
                    <input type="hidden" name="job_opening_id" id="job_id_input" value="">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;" class="form-grid">
                        <div class="field-wrap">
                            <label for="name_input">Full Name <span style="color:#e53e3e;">*</span></label>
                            <input type="text" id="name_input" name="name" placeholder="e.g. Ahmad bin Ali" required value="{{ old('name') }}">
                        </div>
                        <div class="field-wrap">
                            <label for="email_input">Email Address <span style="color:#e53e3e;">*</span></label>
                            <input type="email" id="email_input" name="email" placeholder="you@example.com" required value="{{ old('email') }}">
                        </div>
                        <div class="field-wrap">
                            <label for="pos_input">Position Applied For <span style="color:#e53e3e;">*</span></label>
                            <input type="text" id="pos_input" name="position" placeholder="e.g. Site Engineer" required value="{{ old('position') }}">
                        </div>
                        <div class="field-wrap">
                            <label for="phone_input">Contact Number <span style="color:#e53e3e;">*</span></label>
                            <input type="tel" id="phone_input" name="phone" placeholder="+60 12-345 6789" required value="{{ old('phone') }}">
                        </div>
                        <div class="field-wrap">
                            <label>Expected Monthly Salary (RM)</label>
                            <input type="text" name="expected_salary" placeholder="e.g. RM 5,000 – RM 7,000" value="{{ old('expected_salary') }}">
                        </div>
                        <div class="field-wrap">
                            <label>Earliest Available Date</label>
                            <input type="text" name="availability" placeholder="e.g. Immediate / 2 Weeks Notice" value="{{ old('availability') }}">
                        </div>
                    </div>

                    <div class="field-wrap">
                        <label>Cover Letter / Why should we hire you?</label>
                        <textarea name="cover_letter" placeholder="Briefly describe your relevant experience, key achievements, and what value you bring to Builtech...">{{ old('cover_letter') }}</textarea>
                    </div>

                    <div class="field-wrap">
                        <label>Resume / CV <span style="color:#e53e3e;">*</span></label>
                        <div class="upload-zone">
                            <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                                onchange="document.getElementById('upload-fn').textContent = this.files[0]?.name || 'Click or drag your CV here'">
                            <i class="fas fa-cloud-arrow-up" style="font-size:2rem; color:var(--gold); display:block; margin-bottom:0.75rem;"></i>
                            <p id="upload-fn" style="font-size:1rem; font-weight:700; color:var(--navy); margin:0 0 0.25rem;">Click or drag your CV here</p>
                            <span style="font-size:0.78rem; color:var(--text-muted);">PDF, DOC, DOCX — Max 5 MB</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:1.2rem; font-size:0.95rem;">
                        <i class="fas fa-paper-plane"></i> Submit Application to HR
                    </button>
                    <p style="font-size:0.8rem; color:var(--text-muted); text-align:center; margin-top:1rem; margin-bottom:0;">
                        <i class="fas fa-lock" style="color:var(--gold); margin-right:4px;"></i>
                        Your information is handled in strict confidence in accordance with PDPA (Malaysia).
                    </p>
                </form>
            </div>
        </div>
    </div>

    {{-- ── FALLBACK CTA if form not shown ── --}}
    <section class="bt-section" style="background:white; text-align:center;" x-show="!showForm">
        <div class="bt-container reveal" style="max-width:700px;">
            <span class="section-label" style="justify-content:center;">Ready to Apply?</span>
            <h2 class="section-title">Don't See a Suitable <span style="color:var(--gold);">Role?</span></h2>
            <p style="font-size:1.05rem; color:var(--text-muted); line-height:1.85; margin-bottom:2rem;">
                We are always interested in exceptional talent. Submit a general application and we will keep your profile on file for upcoming positions.
            </p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <button @click="showForm=true" class="btn-primary">
                    <i class="fas fa-file-arrow-up"></i> Submit General Application
                </button>
                <a href="{{ route('contact') }}" class="btn-primary btn-navy">
                    <i class="fas fa-phone-alt"></i> Contact HR Directly
                </a>
            </div>
            <p style="margin-top:1.5rem; font-size:0.9rem; color:var(--text-muted);">
                Or email us directly: <a href="mailto:hr@builtech.com.my" style="color:var(--gold); font-weight:700;">hr@builtech.com.my</a>
            </p>
        </div>
    </section>

</div>
@endsection