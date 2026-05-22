@php
    $rawStatus  = strtolower(trim($project->status ?? 'completed'));

    if (in_array($rawStatus, ['active', 'ongoing', 'in progress'])) {
        $dotClass   = 'bg-yellow-400';
        $statusText = 'Ongoing';
    } elseif (in_array($rawStatus, ['pending', 'upcoming', 'soon', 'coming soon'])) {
        $dotClass   = 'bg-blue-400';
        $statusText = 'Coming Soon';
    } else {
        $dotClass   = 'bg-green-400';
        $statusText = 'Completed';
    }

    $delay = ($index % 6) * 0.08;
@endphp

@once
<style>
/* Immersive Reveal Project Card */
.project-reveal-card {
    display: block;
    width: 100%;
    text-decoration: none;
    animation: revealFadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
}

@keyframes revealFadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

.project-reveal-card__inner {
    position: relative;
    width: 100%;
    /* Maintain a tall gallery aspect ratio (4:5 is excellent for architecture) */
    aspect-ratio: 4 / 5;
    border-radius: 1.25rem;
    overflow: hidden;
    background: #0f172a;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transform: translateZ(0); /* Hardware acceleration */
}

.project-reveal-card__figure {
    margin: 0;
    width: 100%;
    height: 100%;
    position: relative;
}

.project-reveal-card__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Expensive cubic-bezier curve for zoom */
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

.project-reveal-card:hover .project-reveal-card__img {
    transform: scale(1.1);
}

/* Cinematic Glint Shine */
.project-reveal-card__inner::after {
    content: "";
    position: absolute;
    top: 0; left: -100%;
    width: 50%; height: 100%;
    background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
    transform: skewX(-25deg);
    transition: 0.75s;
    z-index: 5;
}
.project-reveal-card:hover .project-reveal-card__inner::after {
    left: 150%;
}

/* Year Badge (Top Right) */
.project-reveal-year {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    background: #ffffff;
    color: #0f172a;
    font-size: 0.8rem;
    font-weight: 800;
    padding: 0.4rem 0.8rem;
    border-radius: 0.5rem;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    font-family: 'Inter', sans-serif;
}

/* Overlay Glassmorphism */
.project-reveal-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    /* Strong Gradient backdrop */
    background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.6) 60%, transparent 100%);
    /* Glassmorphism blur */
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    
    padding: 3rem 1.5rem 1.5rem 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    
    /* Animation defaults */
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.project-reveal-card:hover .project-reveal-overlay {
    opacity: 1;
    transform: translateY(0);
}

/* Always show overlay on devices without hover (mobile/tablets) */
@media (hover: none) {
    .project-reveal-overlay {
        opacity: 1;
        transform: translateY(0);
        padding: 2.5rem 1.25rem 1.25rem 1.25rem;
    }
}

/* Category Gold Bar */
.project-reveal-category {
    display: inline-block;
    background: linear-gradient(90deg, #cba358, #deb873);
    color: #ffffff;
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    padding: 0.4rem 1rem;
    border-radius: 4px;
    margin-bottom: 0.75rem;
    align-self: flex-start;
    box-shadow: 0 2px 8px rgba(203, 163, 88, 0.4);
}

.project-reveal-title {
    color: #ffffff;
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 0.75rem;
    font-family: 'Outfit', 'Inter', sans-serif;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.project-reveal-meta {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    margin-bottom: 1.25rem;
}

.project-reveal-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #e2e8f0;
    font-size: 0.85rem;
    font-family: 'Inter', sans-serif;
}

.project-reveal-meta-icon {
    color: #cba358;
    flex-shrink: 0;
}

/* Status Pill */
.project-reveal-status {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.85rem;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    align-self: flex-start;
    font-family: 'Inter', sans-serif;
}

.project-reveal-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}
</style>
@endonce

<a href="{{ route('projects.show', $project->slug) }}" class="project-reveal-card" style="animation-delay: {{ $delay }}s;">
    <article class="project-reveal-card__inner">
        <figure class="project-reveal-card__figure">
            {{-- Background Image --}}
            <img src="{{ $project->cover_image ?? $project->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $project->name }}" loading="lazy" class="project-reveal-card__img">
            
            {{-- Year Badge (Top Right) --}}
            @if(!empty($project->year))
            <div class="project-reveal-year">
                {{ $project->year }}
            </div>
            @endif

            {{-- Hover Glassmorphism Overlay --}}
            <figcaption class="project-reveal-overlay">
                {{-- Category Gold Bar --}}
                <div class="project-reveal-category">
                    {{ strtoupper($project->category?->name ?? 'GENERAL') }}
                </div>
                
                {{-- Project Title --}}
                <h3 class="project-reveal-title">{{ $project->name }}</h3>
                
                {{-- Metadata List --}}
                <div class="project-reveal-meta">
                    @if(!empty($project->location))
                    <div class="project-reveal-meta-item">
                        <svg class="w-4 h-4 project-reveal-meta-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        <span class="truncate">{{ $project->location }}</span>
                    </div>
                    @endif
                    @if(!empty($project->award))
                    <div class="project-reveal-meta-item">
                        <svg class="w-4 h-4 project-reveal-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        <span class="truncate">{{ $project->award }}</span>
                    </div>
                    @endif
                </div>
                
                {{-- Status Pill --}}
                <div class="project-reveal-status">
                    <span class="project-reveal-dot {{ $dotClass }}"></span>
                    {{ strtoupper($statusText) }}
                </div>
            </figcaption>
        </figure>
    </article>
</a>
@once
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.project-reveal-card');
        cards.forEach(card => {
            const inner = card.querySelector('.project-reveal-card__inner');
            
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // Max rotation of 10 degrees for a premium 3D feel
                const rotateX = ((y - centerY) / centerY) * -10;
                const rotateY = ((x - centerX) / centerX) * 10;
                
                inner.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
                inner.style.transition = 'transform 0.1s ease-out';
            });
            
            card.addEventListener('mouseleave', () => {
                inner.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
                inner.style.transition = 'transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1)';
            });
        });
    });
</script>
@endonce
