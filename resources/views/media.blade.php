@extends('layouts.app')
@section('title', 'Press & Media | Builtech in the News')
@section('description', 'Explore Builtech media coverage and press mentions. Documenting our growth and achievements in the construction industry through leading publications.')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" />
<style>
    :root {
        --white: #ffffff;
        --off-white: #fcfbf8;
        --champagne: #f4eee0;
        --gold: #c5a059;
        --gold-dark: #a68546;
        --navy: #1a242f;
        --text-main: #34495e;
        --text-light: #7f8c8d;
        --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        --shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    }

    /* --- HERO --- */
    .media-hero {
        min-height: 52vh;
        background: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
        padding: 160px 5% 90px;
    }

    .media-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://images.unsplash.com/photo-1585829365234-754eb4506119?q=80&w=2000') center/cover;
        opacity: 0.2;
        mix-blend-mode: luminosity;
    }

    .media-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(26, 36, 47, 0.9), rgba(26, 36, 47, 0.6));
    }

    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 20px;
        border: 1px solid var(--gold);
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 0.25em;
        font-weight: 800;
        font-size: 0.72rem;
        margin-bottom: 1.5rem;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
    }

    .hero-title {
        font-family: 'Oswald', sans-serif;
        font-size: clamp(3rem, 6vw, 5rem);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        line-height: 1.05;
        margin-bottom: 1rem;
    }

    .hero-content { position: relative; z-index: 10; max-width: 800px; padding: 0 20px; }

    /* --- GALLERY --- */

    .media-section { padding: 100px 5%; }
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2rem;
    }

    .media-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
    }

    .media-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 40px 80px rgba(0,0,0,0.1);
        border-color: var(--gold-light);
    }

    .media-image-wrapper {
        position: relative;
        height: 380px;
        overflow: hidden;
        background: #0d1925; /* dark letterbox for portrait press images */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .media-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* fill the area so it's readable */
        object-position: top; /* start reading from the top headline */
        transition: transform 0.7s ease, filter 0.3s ease;
        image-rendering: -webkit-optimize-contrast;
        filter: brightness(1.0) contrast(1.04) saturate(1.06);
    }

    .media-card:hover .media-image { transform: scale(1.04); filter: brightness(1.06) contrast(1.08) saturate(1.1); }

    .media-overlay {
        position: absolute;
        inset: 0;
        background: rgba(26, 36, 47, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
    }

    .media-card:hover .media-overlay { opacity: 1; }

    .btn-zoom {
        width: 60px;
        height: 60px;
        background: var(--gold);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 10px 20px rgba(197, 160, 89, 0.4);
    }

    .media-info {
        padding: 32px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .media-publication {
        color: var(--gold);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 0.72rem;
        margin-bottom: 0.6rem;
        display: block;
        font-family: 'Montserrat', sans-serif;
    }
    .media-headline {
        font-family: 'Oswald', sans-serif;
        font-size: 1.35rem;
        color: var(--navy);
        line-height: 1.3;
        margin-bottom: 0.8rem;
        text-transform: uppercase;
    }
    .media-date {
        margin-top: auto;
        color: var(--text-muted);
        font-size: 0.88rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* --- FILTER --- */
    .year-filter {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 60px;
    }

    .year-btn {
        padding: 10px 28px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 700;
        font-size: 0.8rem;
        transition: var(--transition);
        border: 1px solid var(--border);
        background: white;
        color: var(--text-muted);
        cursor: pointer;
    }

    .year-btn:hover, .year-btn.active {
        background: var(--navy);
        color: white;
        border-color: var(--navy);
        box-shadow: 0 10px 20px rgba(26, 36, 47, 0.1);
    }

    /* --- MODAL --- */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(10, 31, 56, 0.95);
        backdrop-filter: blur(15px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .modal-content {
        max-width: 90vw;
        max-height: 85vh;
        position: relative;
    }

    .modal-content img {
        width: 100%;
        height: auto;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 50px 100px rgba(0,0,0,0.5);
    }

    .modal-close {
        position: absolute;
        top: -60px;
        right: 0;
        color: white;
        font-size: 2.5rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .modal-close:hover { color: var(--gold); transform: rotate(90deg); }

    /* --- REVEAL --- */
    .reveal { opacity: 0; transform: translateY(40px); transition: 1s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }

    @media (max-width: 768px) {
        .media-grid { grid-template-columns: 1fr; }
        .media-section { padding: 60px 0; }
    }
</style>
@endpush

@section('content')

<section class="media-hero">
    <div class="hero-content reveal">
        <span class="hero-tag"><i class="fas fa-newspaper"></i> News &amp; Media</span>
        <h1 class="hero-title">Press <span style="color:var(--gold);">Coverage</span></h1>
        <p style="color:rgba(255,255,255,0.72); font-size:1.05rem; margin-top:1rem; max-width:560px; line-height:1.85; font-family:'Montserrat',sans-serif;">
            Showcasing our project milestones and expert insights as featured in leading regional publications.
        </p>
    </div>
</section>

<div class="bt-container">
    <section class="media-section">
        
        {{-- Year Filter --}}
        <div style="text-align:center; margin-bottom:3.5rem;">
            <div class="year-filter reveal">
                <button class="year-btn active" onclick="filterByYear('all', this)">All Years</button>
            @foreach($years as $year)
                <button class="year-btn" onclick="filterByYear('{{ $year }}', this)">{{ $year }}</button>
            @endforeach
            </div>
        </div>

        <div class="media-grid">
            @forelse($coverages as $item)
                <div class="media-card reveal year-{{ $item->published_date->format('Y') }}">
                    <div class="media-image-wrapper">
                        <a href="{{ $item->display_image }}"
                           class="glightbox"
                           data-gallery="media-press"
                           data-title="{{ $item->headline }}"
                           data-description="{{ $item->publication }} &middot; {{ $item->published_date->format('d M Y') }}"
                           style="display:block; width:100%; height:100%;">
                            <img src="{{ $item->display_image }}" alt="{{ $item->headline }}" class="media-image" loading="lazy">
                            <div class="media-overlay">
                                <div class="btn-zoom"><i class="fas fa-expand-alt"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="media-info">
                        <span class="media-publication">{{ $item->publication }}</span>
                        <h3 class="media-headline">{{ $item->headline }}</h3>
                        <div class="media-date">
                            <i class="far fa-calendar-alt text-gold"></i>
                            {{ $item->published_date->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-40 text-center reveal">
                    <i class="far fa-newspaper text-6xl mb-6 opacity-20 text-navy"></i>
                    <h3 class="text-2xl font-heading font-bold text-navy">No Press Coverage Found</h3>
                </div>
            @endforelse
        </div>
    </section>
</div>

{{-- Lightbox --}}
<div class="modal-backdrop" id="lightboxModal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeLightbox()"><i class="fas fa-times"></i></span>
        <img id="lightboxImg" src="" alt="Press Preview">
    </div>
</div>

@endsection

@push('scripts')
<script>
    function filterByYear(year, btn) {
        document.querySelectorAll('.year-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const cards = document.querySelectorAll('.media-card');
        cards.forEach(card => {
            if (year === 'all' || card.classList.contains('year-' + year)) {
                card.style.display = 'flex';
                card.classList.add('active'); // Trigger reveal again
            } else {
                card.style.display = 'none';
            }
        });
    }

    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        const modal = document.getElementById('lightboxModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.getElementById('lightboxModal').addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // GLightbox — HD press photo viewer
        GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            openEffect: 'zoom',
            closeEffect: 'fade',
        });
    });
</script>
@endpush
