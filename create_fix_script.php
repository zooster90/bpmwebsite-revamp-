<?php
$content = <<<'BLADE'
@extends('layouts.app')
@section('title', 'Builtech | Engineering Excellence Since 1996')
@section('meta_description', 'Builtech Project Management - CIDB Grade G7 Engineering & Construction Excellence since 1996.')

@push('styles')
<style>
/* Modern Design System overrides for Homepage */
.hero-split {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    padding-top: 100px; /* navbar offset */
    background: #001F3F; /* Navy */
    color: white;
}
@media(min-width: 1024px) {
    .hero-split {
        flex-direction: row;
        align-items: center;
        padding-top: 0;
    }
}
.hero-left {
    flex: 1;
    padding: 4rem 5%;
    z-index: 10;
}
@media(min-width: 1024px) {
    .hero-left { padding: 8rem 5% 8rem 10%; }
}
.hero-right {
    flex: 1;
    position: relative;
    min-height: 50vh;
}
@media(min-width: 1024px) {
    .hero-right { min-height: 100vh; }
}
.hero-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-bottom-left-radius: 60px;
}
@media(min-width: 1024px) {
    .hero-img { border-bottom-left-radius: 120px; border-top-left-radius: 0; }
}

/* Modern Tagline & Heading */
.m-tagline {
    color: #C5A059;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-size: 0.9rem;
    display: inline-block;
    margin-bottom: 20px;
    border-bottom: 2px solid #C5A059;
    padding-bottom: 5px;
}
.m-heading {
    font-family: 'Oswald', sans-serif;
    font-size: clamp(3rem, 6vw, 5.5rem);
    line-height: 1.1;
    margin-bottom: 30px;
    font-weight: 700;
    color: white;
}
.m-heading span {
    color: #C5A059;
}
.m-desc {
    color: rgba(255,255,255,0.8);
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 40px;
    max-width: 600px;
}

/* Buttons */
.btn-group {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.btn-solid {
    background: #C5A059;
    color: white;
    padding: 15px 35px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}
.btn-solid:hover {
    background: #a68546;
    transform: translateY(-3px);
}
.btn-outline-light {
    border: 2px solid rgba(255,255,255,0.3);
    color: white;
    padding: 15px 35px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}
.btn-outline-light:hover {
    border-color: white;
    background: rgba(255,255,255,0.1);
    transform: translateY(-3px);
}

/* About Section */
.about-section {
    padding: 100px 5%;
    background: white;
}
.about-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 60px;
    max-width: 1300px;
    margin: 0 auto;
    align-items: center;
}
@media(min-width: 1024px) {
    .about-grid { grid-template-columns: 1fr 1fr; }
}
.dark-heading {
    font-family: 'Oswald', sans-serif;
    font-size: clamp(2.5rem, 4vw, 3.5rem);
    color: #001F3F;
    line-height: 1.2;
    margin-bottom: 30px;
}
.feature-list {
    list-style: none;
    padding: 0;
    margin: 30px 0 40px;
}
.feature-list li {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
    color: #4a5568;
    font-size: 1.05rem;
    font-weight: 500;
}
.feature-list li i {
    color: #C5A059;
    background: rgba(197,160,89,0.1);
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 0.9rem;
}
.about-collage {
    position: relative;
    padding-bottom: 50px;
}
.about-collage-main {
    width: 85%;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
.about-collage-sub {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 50%;
    border-radius: 20px;
    border: 10px solid white;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* Services Section */
.services-section {
    padding: 100px 5%;
    background: #F8F6F2; /* Very light beige/grey */
}
.services-header {
    text-align: center;
    margin-bottom: 60px;
}
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    max-width: 1300px;
    margin: 0 auto;
}
.service-card {
    background: white;
    padding: 50px 40px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    transition: all 0.4s ease;
    border-bottom: 4px solid transparent;
}
.service-card:hover {
    transform: translateY(-10px);
    border-bottom-color: #C5A059;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}
.service-icon {
    width: 70px;
    height: 70px;
    background: #001F3F;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    border-radius: 16px;
    margin-bottom: 30px;
    transition: all 0.4s ease;
}
.service-card:hover .service-icon {
    background: #C5A059;
}
.service-title {
    font-family: 'Oswald', sans-serif;
    font-size: 1.5rem;
    color: #001F3F;
    margin-bottom: 15px;
}
.service-desc {
    color: #718096;
    line-height: 1.7;
    margin-bottom: 30px;
}
.service-link {
    color: #001F3F;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
}
.service-card:hover .service-link {
    color: #C5A059;
}

/* Projects/News Cards */
.projects-section {
    padding: 100px 5%;
    background: white;
}
.project-card-modern {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    transition: all 0.4s ease;
    display: block;
    text-decoration: none;
    color: inherit;
}
.project-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}
.project-card-img {
    height: 250px;
    width: 100%;
    object-fit: cover;
}
.project-card-content {
    padding: 30px;
}
.project-card-tag {
    color: #C5A059;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
    display: block;
}
.project-card-title {
    font-family: 'Oswald', sans-serif;
    font-size: 1.4rem;
    color: #001F3F;
    margin-bottom: 15px;
    line-height: 1.3;
}
.project-card-desc {
    color: #718096;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Reveal Animations */
.reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
.reveal.active { opacity: 1; transform: translateY(0); }
</style>
@endpush

@section('content')

{{-- 1. HERO SECTION --}}
<section class="hero-split">
    <div class="hero-left">
        <span class="m-tagline reveal active">Engineering Excellence</span>
        <h1 class="m-heading reveal active" style="transition-delay: 0.1s">
            We Build Something<br>
            <span>New & Consistent.</span>
        </h1>
        <p class="m-desc reveal active" style="transition-delay: 0.2s">
            Delivering engineering excellence and unlimited construction capacity for Malaysia's most complex industrial and commercial landmarks since 1996.
        </p>
        <div class="btn-group reveal active" style="transition-delay: 0.3s">
            <a href="{{ route('projects.index') }}" class="btn-solid">Our Portfolio</a>
            <a href="{{ route('services') }}" class="btn-outline-light">Core Services</a>
        </div>
    </div>
    <div class="hero-right">
        <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1920" alt="Construction Worker" class="hero-img">
    </div>
</section>

{{-- 2. ABOUT/WELCOME SECTION --}}
<section class="about-section">
    <div class="about-grid">
        <div class="reveal">
            <span class="m-tagline">About Builtech</span>
            <h2 class="dark-heading">Welcome To Construction<br>Real Solution.</h2>
            <p style="color: #718096; font-size: 1.1rem; line-height: 1.8; margin-bottom: 20px;">
                Founded on the principles of engineering integrity, our journey has been defined by precision. We have evolved into a CIDB G7 institutional partner specializing in high-stakes environments.
            </p>
            
            <ul class="feature-list">
                <li><i class="fas fa-check"></i> Unlimited Tender Capacity (Grade G7)</li>
                <li><i class="fas fa-check"></i> Triple ISO Certified Management Systems</li>
                <li><i class="fas fa-check"></i> Specialist in Healthcare & Industrial</li>
                <li><i class="fas fa-check"></i> Strict CONQUAS & Safety Standards</li>
            </ul>

            <a href="{{ route('about') }}" class="btn-solid" style="background: #001F3F;">Read More</a>
        </div>
        
        <div class="about-collage reveal" style="transition-delay: 0.2s">
            <img src="{{ asset('images/photo-1517089596392-fb9a9033e05b.avif') }}" alt="Building Construction" class="about-collage-main">
            <img src="{{ asset('images/fogging 3.jpg') }}" alt="Site Work" class="about-collage-sub">
        </div>
    </div>
</section>

{{-- 3. SERVICES SECTION --}}
<section class="services-section">
    <div class="container">
        <div class="services-header reveal">
            <span class="m-tagline">What We Do</span>
            <h2 class="dark-heading">We Provide Core Services</h2>
            <p style="color: #718096; max-width: 600px; margin: 0 auto;">From strategic management to structural execution — comprehensive engineering services for Malaysia's developments.</p>
        </div>

        <div class="services-grid">
            <div class="service-card reveal">
                <div class="service-icon"><i class="fas fa-tasks"></i></div>
                <h3 class="service-title">Project Management</h3>
                <p class="service-desc">Full oversight ensuring timeline adherence, strict cost control, and premium quality assurance from inception to completion.</p>
                <a href="{{ route('services') }}" class="service-link">Get Started <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="service-card reveal" style="transition-delay: 0.1s">
                <div class="service-icon"><i class="fas fa-city"></i></div>
                <h3 class="service-title">Building & Civil</h3>
                <p class="service-desc">High-rise residential developments, commercial complexes, and specialized civil engineering infrastructure.</p>
                <a href="{{ route('services') }}" class="service-link">Get Started <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card reveal" style="transition-delay: 0.2s">
                <div class="service-icon"><i class="fas fa-industry"></i></div>
                <h3 class="service-title">Industrial Building</h3>
                <p class="service-desc">Specialized construction of factories and plants, optimized for operational flow and international safety standards.</p>
                <a href="{{ route('services') }}" class="service-link">Get Started <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- 4. PROJECTS SECTION --}}
<section class="projects-section">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; flex-wrap: wrap; gap: 20px;">
            <div class="reveal">
                <span class="m-tagline">Our Masterpieces</span>
                <h2 class="dark-heading" style="margin-bottom: 0;">Flagship Developments</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="btn-solid reveal" style="background: #001F3F;">See All</a>
        </div>

        <div class="services-grid">
            @forelse($featuredProjects as $idx => $p)
            <a href="{{ route('projects.show', $p->slug) }}" class="project-card-modern reveal" style="transition-delay: {{ $idx * 0.1 }}s">
                <img src="{{ $p->display_image }}" alt="{{ $p->name }}" class="project-card-img" loading="lazy">
                <div class="project-card-content">
                    <span class="project-card-tag">{{ $p->location ?? 'Penang, Malaysia' }}</span>
                    <h3 class="project-card-title">{{ $p->name }}</h3>
                    <p class="project-card-desc">{{ Str::limit(strip_tags($p->description), 100) }}</p>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #999;">Projects coming soon</div>
            @endforelse
        </div>
    </div>
</section>

{{-- 5. MEDIA/NEWS SECTION --}}
<section class="projects-section bg-off-white">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; flex-wrap: wrap; gap: 20px;">
            <div class="reveal">
                <span class="m-tagline">Updates</span>
                <h2 class="dark-heading" style="margin-bottom: 0;">Latest News and Stories</h2>
            </div>
            <a href="{{ route('media') }}" class="btn-solid reveal" style="background: #C5A059;">See All</a>
        </div>

        <div class="services-grid">
            @forelse($latestMedia as $idx => $m)
            <a href="{{ $m->external_url ?? '#' }}" target="_blank" class="project-card-modern reveal" style="transition-delay: {{ $idx * 0.1 }}s">
                <img src="{{ $m->image_url ?? $m->getFirstMediaUrl('press_image') ?: asset('images/placeholder.jpg') }}" alt="Media" class="project-card-img" loading="lazy" onerror="this.src='https://placehold.co/600x250/001f3f/c5a059?text=Builtech+Media'">
                <div class="project-card-content">
                    <span class="project-card-tag" style="color: #001F3F;">{{ $m->publisher ?? $m->publication ?? 'Media' }}</span>
                    <h3 class="project-card-title">{{ $m->title ?? $m->headline ?? '' }}</h3>
                    <p class="project-card-desc">{{ optional($m->published_date)->format('M d, Y') }}</p>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #999;">No media records yet.</div>
            @endforelse
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Simple reveal animation
    document.addEventListener("DOMContentLoaded", function() {
        const reveals = document.querySelectorAll(".reveal");
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                }
            });
        }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });
        
        reveals.forEach(el => observer.observe(el));
    });
</script>
@endpush
@endsection
BLADE;
file_put_contents('c:/Users/built/Herd/builtech-app/fix_welcome_design.php', $content);
