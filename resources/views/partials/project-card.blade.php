@php
    $statusColorClass = 'pill-completed';
    $statusRaw = strtolower($project->status ?? 'completed');
    if (in_array($statusRaw, ['ongoing', 'active', 'in progress'])) {
        $statusColorClass = 'pill-ongoing';
        $displayStatus = 'ONGOING';
    } elseif (in_array($statusRaw, ['coming soon', 'pending', 'upcoming'])) {
        $statusColorClass = 'pill-coming-soon';
        $displayStatus = 'COMING SOON';
    } else {
        $displayStatus = 'COMPLETED';
    }

    $imgUrl = asset('images/placeholder.jpg');
    // Prefer the small 'card' WebP conversion (800px) over the 1920px original
    // for grid display. Falls back to display_image if no media conversion.
    if (method_exists($project, 'hasMedia') && $project->hasMedia('cover_image')) {
        $cardUrl = $project->getFirstMediaUrl('cover_image', 'card');
        $imgUrl  = $cardUrl ?: $project->getFirstMediaUrl('cover_image');
    } elseif ($project->display_image) {
        $imgUrl = $project->display_image;
    }

    // Count gallery images if available
    $photoCount = method_exists($project, 'getMedia') ? $project->getMedia('gallery')->count() : 0;
@endphp

<a href="{{ route('projects.show', $project->slug) }}" class="bt-project-card" style="display:flex; flex-direction:column;">

    {{-- Image area --}}
    <div style="position:relative; height:280px; overflow:hidden; background:#0d1925; flex-shrink:0;">
        <img src="{{ $imgUrl }}"
             alt="{{ $project->title ?? $project->name }}"
             loading="lazy"
             decoding="async"
             width="800"
             height="600"
             style="width:100%; height:100%; object-fit:cover; object-position:center; transition:transform 1.2s ease; image-rendering:-webkit-optimize-contrast;">

        {{-- Year badge --}}
        <div class="bt-year-badge">{{ $project->year ?? date('Y') }}</div>

        {{-- Status pill --}}
        <div style="position:absolute; top:1rem; right:1rem;">
            <span class="bt-status-pill {{ $statusColorClass }}" style="font-size:0.62rem;">
                <i class="fas fa-circle" style="font-size:5px;"></i> {{ $displayStatus }}
            </span>
        </div>

        {{-- "View Photos" hover overlay --}}
        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(10,25,47,0.92) 0%, rgba(10,25,47,0.2) 50%, transparent 100%); opacity:0; transition:opacity 0.4s ease; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; padding:1.5rem 1rem;" class="project-photo-overlay">
            <div style="display:flex; align-items:center; gap:10px; background:var(--gold); color:white; padding:10px 22px; border-radius:50px; font-size:0.78rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; margin-bottom:0.5rem;">
                <i class="fas fa-images" style="font-size:0.9rem;"></i>
                View Project Details
                @if($photoCount > 0)
                    &nbsp;<span style="background:rgba(255,255,255,0.25); border-radius:50px; padding:2px 8px; font-size:0.65rem;">{{ $photoCount }}+ Photos</span>
                @endif
            </div>
            <span style="color:rgba(255,255,255,0.5); font-size:0.7rem; letter-spacing:0.1em;">Click to explore</span>
        </div>
    </div>

    {{-- Info section --}}
    <div class="bt-project-info" style="flex:1; display:flex; flex-direction:column;">
        <span class="bt-project-cat" style="color: var(--gold) !important;">{{ $project->category?->name ?? 'General Construction' }}</span>
        <h3 class="bt-project-title" style="flex:1;">{{ $project->title ?? $project->name }}</h3>

        {{-- 🌟 MOBILE META FIX: Flex-wrap and gap ensure location and award never overlap 🌟 --}}
        <div style="display:flex; flex-wrap:wrap; align-items:center; gap:6px 12px; margin-top:auto; padding-top:0.75rem; border-top:1px solid rgba(255,255,255,0.1);">
            <div class="bt-project-meta" style="display:flex; align-items:center; gap:6px;">
                <i class="fas fa-map-marker-alt" style="color:var(--gold);"></i>
                <span style="font-size:0.8rem; color:rgba(255,255,255,0.9);">{{ $project->location ?? 'Malaysia' }}</span>
            </div>

            @if($project->award)
                <div class="bt-project-meta" style="display:flex; align-items:center; gap:6px; background:rgba(197,160,89,0.1); border:1px solid rgba(197,160,89,0.25); padding:2px 10px; border-radius:50px;">
                    <i class="fas fa-award" style="color:var(--gold);"></i>
                    <span style="font-size:0.75rem; font-weight:700; color:var(--gold);">{{ $project->award }}</span>
                </div>
            @endif
        </div>

        {{-- Bottom CTA bar --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:1rem; padding-top:0.75rem; border-top:1px solid rgba(255,255,255,0.1);">
            <span style="font-size:0.72rem; font-weight:800; color:var(--gold); text-transform:uppercase; letter-spacing:0.15em; display:flex; align-items:center; gap:6px;">
                <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i> View Full Details
            </span>
            @if($photoCount > 0)
                <span style="font-size:0.68rem; font-weight:700; color:rgba(255,255,255,0.7); display:flex; align-items:center; gap:5px;">
                    <i class="fas fa-images" style="color:var(--gold);"></i> {{ $photoCount }} Photos
                </span>
            @endif
        </div>
    </div>
</a>

<style>
    .bt-project-card:hover .project-photo-overlay { opacity: 1 !important; }
    .bt-project-card:hover img { transform: scale(1.07); }
</style>
