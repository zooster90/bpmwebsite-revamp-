@php
    $statusRaw = strtolower($project->status ?? 'completed');
    if (in_array($statusRaw, ['ongoing','active','in progress'])) {
        $statusClass = 'pill-ongoing'; $statusLabel = 'ONGOING';
    } elseif (in_array($statusRaw, ['coming soon','pending','upcoming'])) {
        $statusClass = 'pill-coming-soon'; $statusLabel = 'COMING SOON';
    } else {
        $statusClass = 'pill-completed'; $statusLabel = 'COMPLETED';
    }
    $imgUrl     = $project->display_image ?: asset('images/placeholder.jpg');
    $photoCount = method_exists($project, 'getMedia') ? $project->getMedia('gallery')->count() : 0;
@endphp

<a href="{{ route('projects.show', $project->slug) }}"
   class="photo-card reveal"
   data-delay="{{ ($idx ?? 0) * 60 }}"
   aria-label="{{ $project->title ?: $project->name }} — View Project Details">

    {{-- Photo --}}
    <img src="{{ $imgUrl }}"
         alt="{{ ($project->title ?: $project->name) }} — Builtech Engineering Malaysia"
         loading="lazy">

    {{-- Year pill — top left --}}
    <div class="pc-year">{{ $project->year ?: date('Y') }}</div>

    {{-- Status pill — top right --}}
    <div class="pc-status">
        <span class="bt-status-pill {{ $statusClass }}" style="font-size:0.6rem; padding:4px 10px;">
            <i class="fas fa-circle" style="font-size:4px;"></i> {{ $statusLabel }}
        </span>
    </div>

    {{-- Photo count — bottom right --}}
    @if($photoCount > 0)
    <div class="pc-photos">
        <i class="fas fa-images" style="color:var(--gold);"></i> {{ $photoCount }}
    </div>
    @endif

    {{-- Dark gradient overlay --}}
    <div class="pc-gradient"></div>

    {{-- Info panel — slides up on hover --}}
    <div class="pc-info">
        <span class="pc-cat" style="color: var(--gold) !important;">{{ $project->category?->name ?: 'General Construction' }}</span>
        <h3 class="pc-title">{{ $project->title ?: $project->name }}</h3>
        
        {{-- 🌟 MOBILE LOCATION & AWARD FIX: Flex-wrap and gap ensure they never overlap or squish 🌟 --}}
        <div class="pc-location" style="display:flex; flex-wrap:wrap; align-items:center; gap:6px 12px; margin-bottom:1rem;">
            <div style="display:flex; align-items:center; gap:6px;">
                <i class="fas fa-map-marker-alt" style="color:var(--gold); font-size:0.75rem;"></i>
                <span class="pc-loc-val" style="font-size:0.78rem; color:#ffffff !important;">{{ !empty(trim($project->location ?? '')) ? $project->location : 'Malaysia' }}</span>
            </div>
            @if($project->award)
                <div class="pc-award-badge" style="display:flex; align-items:center; gap:6px; padding:2px 10px; border-radius:50px; border: 1px solid rgba(197, 160, 89, 0.8) !important; background: rgba(10, 25, 47, 0.6) !important;">
                    <i class="fas fa-award" style="color:var(--gold); font-size:0.75rem;"></i>
                    <span class="pc-award-val" style="font-size:0.72rem; font-weight:700; color:var(--gold) !important;">{{ $project->award }}</span>
                </div>
            @endif
        </div>

        <div class="pc-cta">
            View Details <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i>
        </div>
    </div>

</a>
