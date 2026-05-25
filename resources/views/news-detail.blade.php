@extends('layouts.app')

@section('title', $article->title . ' | The Builtech Journal')
@section('description', Str::limit(strip_tags($article->excerpt ?? $article->content), 160))

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════
       PREMIUM EDITORIAL REDESIGN (News Detail)
       ═══════════════════════════════════════════════════════ */
    
    .bt-article-header {
        padding: clamp(120px, 15vw, 200px) 0 80px;
        background: #fff;
        position: relative;
        overflow: hidden;
    }
    .bt-article-header::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 70% 30%, rgba(197,160,89,0.05) 0%, transparent 70%);
    }

    .bt-article-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 5%;
    }

    .bt-article-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: var(--bt-gold);
        margin-bottom: 2.5rem;
    }
    .bt-article-meta span.sep { width: 4px; height: 4px; background: var(--bt-navy); border-radius: 50%; opacity: 0.2; }

    .bt-article-title {
        font-size: clamp(3rem, 6vw, 5.5rem);
        line-height: 0.95;
        color: var(--bt-navy);
        margin-bottom: 3rem;
    }

    .bt-article-hero {
        width: 100%;
        aspect-ratio: 21/10;
        object-fit: cover;
        border-radius: 2px;
        box-shadow: var(--bt-shadow-lg);
        margin-bottom: 6rem;
    }

    .bt-article-body {
        font-size: 1.25rem;
        line-height: 1.8;
        color: var(--bt-text);
        font-weight: 400;
    }
    .bt-article-body p { margin-bottom: 2.5rem; }
    
    /* Drop Cap */
    .bt-article-body p:first-of-type::first-letter {
        float: left;
        font-family: var(--bt-font-display);
        font-size: 6rem;
        line-height: 0.8;
        padding-top: 10px;
        padding-right: 15px;
        color: var(--bt-gold);
        font-weight: 900;
    }

    .bt-article-body h2 {
        font-family: var(--bt-font-display);
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--bt-navy);
        margin: 5rem 0 2rem;
        line-height: 1.1;
    }

    .bt-article-body blockquote {
        border-left: 5px solid var(--bt-gold);
        padding: 3rem;
        background: #FBFBFA;
        font-family: var(--bt-font-serif);
        font-style: italic;
        font-size: 2rem;
        color: var(--bt-navy);
        margin: 4rem 0;
        line-height: 1.4;
    }

    .bt-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 5rem;
    }
    .bt-gallery-item {
        aspect-ratio: 1/1;
        object-fit: cover;
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.5s var(--bt-ease);
    }
    .bt-gallery-item:hover { transform: scale(1.03); box-shadow: var(--bt-shadow-lg); }

    .bt-article-footer {
        margin-top: 8rem;
        padding-top: 4rem;
        border-top: 1px solid #f1f1f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 768px) {
        .bt-article-title { font-size: 3rem; }
        .bt-article-hero { aspect-ratio: 16/9; }
        .bt-article-body { font-size: 1.1rem; }
        .bt-article-body blockquote { font-size: 1.5rem; padding: 2rem; }
        .bt-article-footer { flex-direction: column; gap: 2rem; align-items: flex-start; }
    }
</style>
@endpush

@php
    $img = $article->display_image;
    $date = $article->published_date ? $article->published_date->format('F d, Y') : ($article->created_at ? $article->created_at->format('F d, Y') : '');
@endphp

@section('content')
<div class="bt-wrapper bg-white">
    
    <!-- HEADER -->
    <header class="bt-article-header">
        <div class="bt-article-container reveal">
            <div class="bt-article-meta">
                <span>{{ $article->category?->name ?? 'Journal' }}</span>
                <span class="sep"></span>
                <span style="color:var(--bt-text-muted)">{{ $date }}</span>
            </div>
            <h1 class="bt-article-title bt-title">{{ $article->title }}</h1>
            
            @if($article->author)
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-off-white flex items-center justify-center text-navy">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-navy">By {{ $article->author }}</span>
                </div>
            @endif
        </div>
    </header>

    <!-- CONTENT -->
    <main class="bt-article-container pb-32">
        
        @if($img)
            <img src="{{ $img }}" alt="{{ $article->title }}" class="bt-article-hero reveal" onclick="openGlobalLightbox(this.src)">
        @endif

        <div class="bt-article-body reveal delay-200">
            {!! $article->content !!}
        </div>

        <!-- GALLERY -->
        @php
            $galleryItems = is_array($article->gallery_uploads) ? array_filter($article->gallery_uploads) : [];
        @endphp
        @if(count($galleryItems) > 0)
            <section class="mt-24 reveal">
                <h3 class="bt-title text-3xl text-navy mb-10 pb-4 border-b border-gray-100">Project Imagery</h3>
                <div class="bt-gallery-grid">
                    @foreach($galleryItems as $photo)
                        <img src="{{ cdn_rewrite(asset('storage/' . ltrim($photo, '/'))) }}"
                             alt="Gallery Item"
                             class="bt-gallery-item"
                             onclick="openGlobalLightbox(this.src)">
                    @endforeach
                </div>
            </section>
        @endif

        <!-- FOOTER ACTION -->
        <footer class="bt-article-footer reveal">
            <a href="{{ route('news.index') }}" class="bt-btn bt-btn-outline !border-navy/10 !text-navy hover:!bg-navy hover:!text-white">
                <i class="fa-solid fa-arrow-left-long mr-3"></i> Return to Journal
            </a>
            <div class="flex gap-4">
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="w-12 h-12 rounded-full border border-gray-100 flex items-center justify-center text-navy hover:bg-gold hover:text-white hover:border-gold transition-all">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" class="w-12 h-12 rounded-full border border-gray-100 flex items-center justify-center text-navy hover:bg-gold hover:text-white hover:border-gold transition-all">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </div>
        </footer>
    </main>

</div>
@endsection