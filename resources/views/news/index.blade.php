@extends('layouts.app')

@section('title', 'Corporate Journal | Official Records | Builtech Official')

@section('meta')
    <meta name="description" content="Explore Builtech's official corporate journal and milestones – documenting our timeline of engineering precision and strategic excellence.">
@endsection

@push('styles')
<style>
    /* ============================================================
       BUILTECH ELITE - NEWS JOURNAL (TIMELINE REPLICA)
       ============================================================ */
    
    .main-header { 
        padding-top: 200px; 
        padding-bottom: 140px;
        background-color: var(--navy);
        position: relative; 
        overflow: hidden;
        border-bottom: 4px solid var(--gold);
    }
    .main-header::before {
        content: ''; 
        position: absolute; 
        inset: 0;
        background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070') center/cover no-repeat;
        opacity: 0.15;
        filter: grayscale(100%);
    }
    .main-header::after {
        content: ''; 
        position: absolute; 
        inset: 0;
        background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 40px 40px;
        z-index: 1;
    }

    .timeline-container {
        max-width: 900px;
        margin: 80px auto 120px;
        padding: 0 24px;
        position: relative;
        width: 100%;
    }

    .timeline-spine {
        position: relative;
        margin-left: 15px;
        padding-left: 35px;
        padding-bottom: 40px;
    }
    .timeline-spine::before {
        content: ''; 
        position: absolute; 
        left: 0; 
        top: 0; 
        bottom: 0; 
        width: 2px;
        background: linear-gradient(to bottom, #cbd5e1 0%, #cbd5e1 85%, transparent 100%);
    }
    @media (min-width: 768px) {
        .timeline-spine { margin-left: 50px; padding-left: 60px; }
    }

    .feed-post {
        background: var(--white);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-left: 4px solid transparent; 
        border-radius: 12px;
        margin-bottom: 60px;
        padding: 40px;
        box-shadow: 0 4px 20px -5px rgba(0,0,0,0.02);
        position: relative;
        transition: var(--transition-premium);
    }
    .feed-post:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px -10px rgba(10,31,56,0.08);
        border-left-color: var(--gold);
    }

    .timeline-dot {
        position: absolute;
        width: 18px; 
        height: 18px;
        background: var(--off-white);
        border: 4px solid var(--navy);
        border-radius: 50%;
        left: -44px; 
        top: 45px;
        box-shadow: 0 0 0 6px var(--off-white);
        z-index: 10;
        transition: var(--transition-premium);
    }
    .feed-post:hover .timeline-dot {
        background: var(--gold); 
        border-color: var(--gold); 
        box-shadow: 0 0 0 6px rgba(197, 160, 89, 0.1);
    }
    @media (min-width: 768px) {
        .timeline-dot { left: -69px; }
    }

    .post-tag {
        font-size: 0.7rem; 
        font-weight: 700; 
        text-transform: uppercase;
        color: var(--navy); 
        background: #f1f5f9;
        padding: 6px 12px; 
        border-radius: 4px; 
        letter-spacing: 1px;
        display: inline-flex; 
        align-items: center; 
        gap: 6px;
    }
    .post-date {
        font-family: 'Oswald', sans-serif; 
        font-size: 1.1rem;
        color: var(--gold-dark); 
        font-weight: 500; 
        letter-spacing: 0.5px;
    }

    .post-title {
        font-size: 1.5rem; 
        font-weight: 800; 
        color: var(--navy); 
        line-height: 1.4; 
        margin: 1rem 0; 
        letter-spacing: -0.01em;
    }
    .post-title a { color: inherit; text-decoration: none; }
    .post-title a:hover { color: var(--gold); }

    .post-remarks {
        font-size: 1rem; 
        color: #475569; 
        line-height: 1.7; 
        margin-bottom: 24px;
    }
</style>
@endpush

@section('content')
<div class="bt-wrapper">
    <header class="main-header">
        <div class="bt-container relative z-10 text-center">
            <div class="reveal">
                <div class="inline-flex items-center gap-4 mb-6 justify-center">
                    <span class="h-[2px] w-10 bg-[var(--gold)]"></span>
                    <span class="tagline" style="color: white; margin-bottom: 0;">Transparency & Legacy</span>
                    <span class="h-[2px] w-10 bg-[var(--gold)]"></span>
                </div>
                <h1 class="heading-main" style="color: white; font-size: clamp(3rem, 5vw, 5rem); line-height: 1.1;">
                    CORPORATE <span style="color: var(--gold);">JOURNAL</span>
                </h1>
                <p class="desc-text" style="color: rgba(255,255,255,0.7); max-width: 600px; margin: 2rem auto;">
                    Documenting our timeline of engineering precision, strategic milestones, and sustainable development across the region.
                </p>
            </div>
        </div>
    </header>

    <div class="timeline-container">
        <div class="timeline-spine">
            @foreach($news as $index => $article)
            <article class="feed-post reveal stagger-{{ ($index % 3) + 1 }}">
                <div class="timeline-dot"></div>
                <div class="flex justify-between items-start flex-wrap gap-4">
                    <span class="post-tag">
                        <i class="fas fa-newspaper" style="color: var(--gold);"></i>
                        {{ $article->category?->name ?? 'News' }}
                    </span>
                    <span class="post-date">{{ $article->published_date->format('M d, Y') }}</span>
                </div>
                
                <h3 class="post-title">
                    <a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a>
                </h3>
                
                <p class="post-remarks">
                    {{ Str::limit(strip_tags($article->content), 200) }}
                </p>

                @if($article->image_url || $article->news_image_upload || $article->hasMedia('news_image'))
                <div style="border-radius: 12px; overflow: hidden; margin-top: 2rem; border: 1px solid rgba(0,0,0,0.05);">
                    <img src="{{ $article->display_image }}" alt="{{ $article->title }}" style="width: 100%; height: auto; display: block;">
                </div>
                @endif

                <div class="mt-8">
                    <a href="{{ route('news.show', $article->slug) }}" class="text-btn" style="color: var(--navy); font-size: 0.8rem; font-weight: 800; letter-spacing: 1px; display: inline-flex; align-items: center; gap: 0.5rem;">
                        READ FULL ENTRY <i class="fas fa-arrow-right" style="color: var(--gold);"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-20 flex justify-center reveal">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
