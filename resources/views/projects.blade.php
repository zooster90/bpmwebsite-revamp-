@extends('layouts.app')

@section('title', 'Project Portfolio | Builtech — Malaysia Grade G7 Engineering Landmarks')
@section('description', 'Explore Builtech\'s engineering portfolio — completed industrial, commercial and civil construction landmarks across Malaysia. CIDB Grade G7 contractor since 1996.')

@push('styles')
<style>
/* ── HERO ── */
.projects-hero {
    position: relative; min-height: 58vh;
    background: var(--navy);
    display: flex; align-items: flex-end;
    overflow: hidden; padding: 160px 5% 80px;
}
.projects-hero::before {
    content: ''; position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000') center/cover;
    opacity: 0.14; filter: grayscale(50%);
    animation: heroZoom 22s alternate infinite ease-in-out;
}
.projects-hero::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(10,20,35,0.97) 0%, rgba(26,36,47,0.85) 100%);
}
@keyframes heroZoom { 0%{transform:scale(1)} 100%{transform:scale(1.07)} }

/* ── FILTER BAR ── */
.filter-bar {
    background: white; border-radius: 12px;
    box-shadow: 0 15px 40px rgba(10,25,47,0.1);
    border: 1px solid rgba(197,160,89,0.12);
    margin: -44px auto 60px;
    max-width: 1100px; position: relative; z-index: 40;
    display: flex; align-items: center; overflow: hidden;
}
.filter-form {
    width: 100%; display: flex; flex-wrap: wrap; align-items: center;
}
.filter-group {
    flex: 1; display: flex; align-items: center;
    padding: 0 20px; gap: 12px;
    border-right: 1px solid #f3f4f6;
    min-width: 200px;
}
.filter-group:last-of-type { border-right: none; }
.filter-group i { color: var(--gold); font-size: 0.9rem; flex-shrink: 0; }
.filter-field {
    width: 100%; border: none; background: transparent;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.95rem; font-weight: 500;
    color: var(--navy); padding: 18px 0; outline: none;
    -webkit-appearance: none;
}
.filter-field::placeholder { color: var(--text-muted); }
.filter-select {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23C5A059' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 8px center;
    background-size: 12px; padding-right: 28px;
}
.filter-btn-wrap { padding: 8px; flex-shrink: 0; }

/* ── STATUS HEADER ── */
.status-header {
    display: flex; align-items: center; gap: 1.5rem;
    margin-bottom: 2rem;
}
.status-header h2 {
    font-family: 'Oswald', sans-serif; font-size: 1.5rem; font-weight: 700;
    color: var(--navy); text-transform: uppercase;
    letter-spacing: 0.08em; margin: 0;
}
.status-divider { height: 1px; flex: 1; background: linear-gradient(to right, rgba(197,160,89,0.3), transparent); min-width: 20px; }
.status-count {
    font-size: 0.7rem; font-weight: 800; color: var(--gold);
    text-transform: uppercase; letter-spacing: 0.2em; white-space: nowrap;
    background: rgba(197,160,89,0.08); padding: 4px 12px;
    border-radius: 50px; border: 1px solid rgba(197,160,89,0.2);
    flex-shrink: 0;
}

/* ── PHOTO GRID (Image 2 style) ── */
.photo-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

/* ── PHOTO CARD ── */
.photo-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    display: block;
    text-decoration: none;
    background: #0d1925;
    aspect-ratio: 3 / 4;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    transition: all 0.5s ease;
}
.photo-card img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.8s ease, filter 0.5s ease;
    filter: brightness(0.9);
}
.photo-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
.photo-card:hover img { transform: scale(1.07); filter: brightness(0.45); }

/* Year badge — top left white pill */
.pc-year {
    position: absolute; top: 12px; left: 12px; z-index: 10;
    background: rgba(255,255,255,0.95);
    color: var(--navy); font-family: 'Montserrat', sans-serif;
    font-size: 0.75rem; font-weight: 800;
    padding: 4px 12px; border-radius: 50px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

/* Status badge — top right */
.pc-status { position: absolute; top: 12px; right: 12px; z-index: 10; }

/* Dark gradient overlay */
.pc-gradient {
    position: absolute; inset: 0; z-index: 5;
    background: linear-gradient(to top, rgba(10,20,35,0.92) 0%, rgba(10,20,35,0.3) 45%, transparent 75%);
    opacity: 0; transition: opacity 0.5s ease;
}
.photo-card:hover .pc-gradient { opacity: 1; }

/* Title + meta — slides up from bottom on hover */
.pc-info {
    position: absolute; bottom: 0; left: 0; right: 0; z-index: 10;
    padding: 1.5rem 1.4rem; transform: translateY(12px); opacity: 0; transition: all 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.photo-card:hover .pc-info { transform: translateY(0); opacity: 1; }

.pc-cat { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; color: var(--gold); margin-bottom: 0.35rem; display: block; }
.pc-title { font-family: 'Oswald', sans-serif; font-size: 1.25rem; font-weight: 700; color: white; text-transform: uppercase; line-height: 1.25; margin-bottom: 0.8rem; }
.pc-location { font-size: 0.75rem; color: rgba(255,255,255,0.7); display: flex; flex-wrap: wrap; align-items: center; gap: 6px 12px; margin-bottom: 1rem; }
.pc-location i { color: var(--gold); font-size: 0.7rem; }
.pc-loc-val { color: rgba(255,255,255,0.85); }
.pc-award-badge { background: rgba(197,160,89,0.15); border: 1px solid rgba(197,160,89,0.3); }
.pc-award-val { color: var(--gold); }

/* Ghost outline CTA */
.pc-cta {
    display: inline-flex; align-items: center; gap: 8px;
    border: 1.5px solid rgba(255,255,255,0.7); color: white;
    background: transparent; padding: 7px 16px; border-radius: 50px;
    font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em;
    transition: all 0.3s ease; animation: ghostPulse 2.5s ease-in-out infinite;
}
.photo-card:hover .pc-cta:hover { background: var(--gold); border-color: var(--gold); animation: none; }

@keyframes ghostPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.25); }
    50%       { box-shadow: 0 0 0 6px rgba(255,255,255,0); }
}

/* Photo count badge */
.pc-photos {
    position: absolute; bottom: 12px; right: 12px; z-index: 10;
    background: rgba(0,0,0,0.4); backdrop-filter: blur(4px);
    color: white; font-size: 0.68rem; font-weight: 700;
    padding: 4px 10px; border-radius: 50px; display: flex; align-items: center; gap: 5px; opacity: 0; transition: opacity 0.4s ease;
}
.photo-card:hover .pc-photos { opacity: 1; }

/* No results */
.no-results { text-align: center; padding: 5rem 2rem; background: white; border-radius: 14px; border: 1px solid var(--border); grid-column: 1 / -1; }

/* Hero stats */
.hero-stats { display: flex; gap: 2.5rem; margin-top: 2.5rem; flex-wrap: wrap; }
.hstat .val { font-family: 'Oswald', sans-serif; font-size: 2.5rem; font-weight: 700; color: white; line-height: 1; }
.hstat .val span { color: #f2cf92 !important; text-shadow: 0 0 15px rgba(242, 207, 146, 0.35); }
.hstat .lbl { font-size: 0.68rem; font-weight: 800; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.2em; display: block; margin-top: 3px; }
.hstat-div { width: 1px; background: rgba(255,255,255,0.1); align-self: stretch; }

/* Results counter */
.results-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.82rem; color: var(--text-muted); font-weight: 600; }
.results-bar a { color: var(--gold); font-weight: 800; text-decoration: none; }
.results-bar a:hover { text-decoration: underline; }

/* Mobile Swipe Hint Indicator */
.mobile-swipe-hint {
    display: none;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px;
    background: rgba(197, 160, 89, 0.1);
    border: 1px solid rgba(197, 160, 89, 0.2);
    border-radius: 50px;
    color: var(--gold);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1.5rem;
    text-align: center;
}

@media (max-width: 1024px) {
    .photo-grid { grid-template-columns: repeat(2, 1fr); }
    .filter-bar { flex-direction: column; margin-top: 0; border-radius: 12px; }
    .filter-form { flex-direction: column; }
    .filter-group { width: 100%; border-right: none; border-bottom: 1px solid #f3f4f6; padding: 4px 20px; }
    .filter-btn-wrap { width: 100%; padding: 12px 20px; }
    .filter-btn-wrap button { width: 100%; justify-content: center; }
}
@media (max-width: 640px) {
    .photo-grid { grid-template-columns: 1fr; gap: 28px; }
    
    .photo-card {
        aspect-ratio: auto !important;
        height: auto !important;
        display: flex;
        flex-direction: column;
        background: white !important;
        border: 1px solid rgba(197, 160, 89, 0.15);
        box-shadow: 0 4px 15px rgba(10,25,47,0.04);
        border-radius: 12px;
    }
    
    .photo-card img {
        height: 240px !important;
        width: 100%;
        object-fit: cover;
        filter: brightness(1) !important;
        border-bottom: 1px solid #f1f5f9;
        transition: none !important;
    }
    
    .photo-card:hover {
        transform: translateY(-4px) !important;
    }
    
    .pc-gradient {
        display: none !important;
    }
    
    .pc-info {
        position: static !important;
        opacity: 1 !important;
        transform: none !important;
        padding: 20px !important;
        background: white !important;
        color: var(--navy) !important;
        display: flex !important;
        flex-direction: column !important;
    }
    
    .pc-cat {
        color: var(--gold) !important;
        font-weight: 800 !important;
        margin-bottom: 6px !important;
    }
    
    .pc-title {
        color: var(--navy) !important;
        font-size: 1.35rem !important;
        margin-bottom: 10px !important;
        line-height: 1.25 !important;
    }
    
    .pc-location {
        margin-bottom: 14px !important;
        color: rgba(255,255,255,0.85) !important;
    }
    .pc-loc-val {
        color: rgba(255,255,255,0.85) !important;
    }
    .pc-award-badge {
        background: rgba(197, 160, 89, 0.1) !important;
        border: 1px solid rgba(197, 160, 89, 0.3) !important;
    }
    .pc-award-val {
        color: #a16207 !important;
    }
    
    .pc-cta {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100%;
        border: 1.5px solid var(--gold) !important;
        color: var(--gold) !important;
        background: transparent !important;
        padding: 10px 16px !important;
        border-radius: 50px !important;
        font-size: 0.75rem !important;
        font-weight: 800 !important;
        letter-spacing: 0.1em !important;
        text-transform: uppercase !important;
        box-shadow: none !important;
        animation: none !important;
    }
    .photo-card:hover .pc-cta {
        background: var(--gold) !important;
        color: white !important;
    }
    
    .projects-hero { padding: 140px 5% 60px; }
    .mobile-swipe-hint { display: flex; }
    
    /* 🌟 FIX STATUS HEADER WRAPPING ON MOBILE so [96 PROJECTS] is never cut off 🌟 */
    .status-header { flex-wrap: wrap; gap: 10px; justify-content: space-between; }
    .status-header h2 { font-size: 1.3rem; white-space: normal; flex: 1 1 100%; margin-bottom: 4px; }
    .status-divider { display: none; }
    .status-count { align-self: flex-start; }
}
</style>
@endpush

@section('content')
<div class="bt-wrapper">

    {{-- ── HERO ── --}}
    <header class="projects-hero">
        <div class="bt-container" style="position:relative; z-index:10;">
            <div class="reveal">
                <span class="section-label">Engineering Archive</span>
                <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(2.5rem,6vw,5.5rem); font-weight:700; color:white; text-transform:uppercase; line-height:1.05; margin-bottom:1rem;">
                    Project <span style="color:var(--gold);">Portfolio.</span>
                </h1>
                <p style="font-size:1.05rem; color:rgba(255,255,255,0.68); max-width:540px; line-height:1.85;">
                    A curated record of Malaysia's industrial and commercial landmarks — engineered with precision, built to last generations.
                </p>
                <div class="hero-stats">
                    <div class="hstat">
                        <div class="val">{{ $projects->total() ?? count($projects) }}<span>+</span></div>
                        <span class="lbl">Total Projects</span>
                    </div>
                    <div class="hstat-div"></div>
                    <div class="hstat">
                        <div class="val"><span>G7</span></div>
                        <span class="lbl">CIDB Grade</span>
                    </div>
                    <div class="hstat-div"></div>
                    <div class="hstat">
                        <div class="val">{{ date('Y') - 1996 }}<span>+</span></div>
                        <span class="lbl">Years Active</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ── MAIN ── --}}
    <section style="background:var(--off-white); padding:40px 5% 100px;">
        <div class="bt-container">

            {{-- Filter Bar --}}
            <div class="filter-bar reveal">
                <form action="{{ route('projects.index') }}" method="GET" class="filter-form">
                    <div class="filter-group">
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by project name..." class="filter-field">
                    </div>
                    <div class="filter-group">
                        <i class="fas fa-layer-group"></i>
                        <select name="category" onchange="this.form.submit()" class="filter-field filter-select">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat }}" {{ request('category')==$cat ? 'selected':'' }}>{{ strtoupper($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <i class="fas fa-clock-rotate-left"></i>
                        <select name="status" onchange="this.form.submit()" class="filter-field filter-select">
                            <option value="">All Statuses</option>
                            <option value="completed"   {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                            <option value="ongoing"     {{ request('status')=='ongoing'?'selected':'' }}>Ongoing</option>
                            <option value="coming-soon" {{ request('status')=='coming-soon'?'selected':'' }}>Coming Soon</option>
                        </select>
                    </div>
                    <div class="filter-btn-wrap">
                        <button type="submit" class="btn-primary" style="height:100%; white-space:nowrap; padding:0.9rem 1.8rem; display:flex; align-items:center; gap:8px;">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            {{-- Mobile Swipe Hint --}}
            <div class="mobile-swipe-hint reveal">
                <i class="fa-solid fa-arrows-up-down"></i>
                <span>Scroll vertically to explore landmarks</span>
            </div>

            @php
                $isFiltered  = request()->hasAny(['search','category','status']);
                $allProjects = $projects ?? collect();
            @endphp

            {{-- 🌟 1. FEATURED FLAGSHIP PROJECTS (Show first if not filtered) 🌟 --}}
            @if(!$isFiltered && isset($flagshipProjects) && $flagshipProjects->isNotEmpty())
            <div style="margin-bottom:5rem;">
                <div class="status-header reveal">
                    <h2><i class="fas fa-star text-gold mr-2"></i> Featured Flagship Projects</h2>
                    <div class="status-divider"></div>
                    <span class="status-count">VIP Showcases</span>
                </div>
                
                {{-- Horizontal Scroll for VIP Projects (Mobile & Desktop) --}}
                <div class="flagship-slider-wrapper" style="position: relative;" x-data="{ 
                    scroll(dir) { 
                        $refs.slider.scrollBy({ left: dir * 464, behavior: 'smooth' }); 
                    } 
                }">
                    <!-- Desktop Hidden Navigation Arrows (Appear on hover) -->
                    <button @click="scroll(-1)" class="flagship-nav-btn prev-btn hidden md:flex" aria-label="Previous Project"><i class="fas fa-chevron-left"></i></button>
                    <button @click="scroll(1)" class="flagship-nav-btn next-btn hidden md:flex" aria-label="Next Project"><i class="fas fa-chevron-right"></i></button>

                    <div x-ref="slider" class="photo-grid flagship-grid" style="display:flex; overflow-x:auto; scroll-snap-type:x mandatory; gap:24px; padding-bottom:20px; scrollbar-width:none; -ms-overflow-style:none;">
                        @foreach($flagshipProjects as $idx => $project)
                            <div style="flex:0 0 auto; width:100%; max-width:440px; scroll-snap-align:start;">
                                @include('partials.project-card-v2', ['project' => $project, 'idx' => $idx])
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Mobile scroll hint for flagship --}}
                <div class="mobile-swipe-hint reveal md:hidden" style="display:flex; margin-top:-10px;">
                    <i class="fa-solid fa-arrows-left-right"></i>
                    <span>Swipe to explore Featured Landmarks</span>
                </div>
            </div>
            @endif

            {{-- 🌟 2. RESULTS 🌟 --}}
            @if($allProjects->isNotEmpty())

                @if($isFiltered)
                    {{-- Flat filtered grid --}}
                    <div class="results-bar">
                        <span>Showing <strong>{{ $allProjects->count() }}</strong> project{{ $allProjects->count()!=1?'s':'' }}</span>
                        @if(request()->hasAny(['search','category','status']))
                            <a href="{{ route('projects.index') }}"><i class="fas fa-times" style="margin-right:4px;"></i>Reset View</a>
                        @endif
                    </div>
                    <div class="photo-grid">
                        @foreach($allProjects as $idx => $project)
                            @include('partials.project-card-v2', ['project' => $project, 'idx' => $idx])
                        @endforeach
                    </div>

                @else
                    {{-- Grouped by status --}}
                    @php
                        $statusOrder = [
                            'ongoing'     => 'Ongoing Developments',
                            'completed'   => 'Completed Landmarks',
                            'coming soon' => 'Future Horizons',
                        ];
                        $grouped = $groupedProjects ?? collect();
                    @endphp

                    @foreach($statusOrder as $key => $label)
                        @php $items = $grouped[$key] ?? collect(); @endphp

                        {{-- Only render section if there are projects --}}
                        @if($items->isNotEmpty())
                        <div style="margin-bottom:5rem;">
                            <div class="status-header reveal">
                                @if($key === 'ongoing')
                                    <span style="width:10px; height:10px; border-radius:50%; background:#3182ce; flex-shrink:0; box-shadow:0 0 0 3px rgba(49,130,206,0.2);"></span>
                                @endif
                                <h2>{{ $label }}</h2>
                                <div class="status-divider"></div>
                                <span class="status-count">{{ $items->count() }} Project{{ $items->count()!=1?'s':'' }}</span>
                            </div>
                            <div class="photo-grid">
                                @foreach($items as $idx => $project)
                                    @include('partials.project-card-v2', ['project' => $project, 'idx' => $idx])
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach

                    {{-- Catch-all for statuses not in $statusOrder --}}
                    @if(isset($groupedProjects))
                        @foreach($groupedProjects as $key => $items)
                            @if(!array_key_exists($key, $statusOrder) && $items->isNotEmpty())
                            <div style="margin-bottom:5rem;">
                                <div class="status-header reveal">
                                    <h2>{{ strtoupper($key) }}</h2>
                                    <div class="status-divider"></div>
                                    <span class="status-count">{{ $items->count() }}</span>
                                </div>
                                <div class="photo-grid">
                                    @foreach($items as $idx => $project)
                                        @include('partials.project-card-v2', ['project' => $project, 'idx' => $idx])
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                @endif

                {{-- Pagination --}}
                @if($projects instanceof \Illuminate\Pagination\LengthAwarePaginator && $projects->hasPages())
                    <div style="margin-top:4rem; display:flex; justify-content:center;">
                        {{ $projects->appends(request()->query())->links() }}
                    </div>
                @endif

            @else
                <div class="no-results reveal">
                    <i class="fas fa-folder-open" style="font-size:3rem; color:var(--gold); opacity:0.4; display:block; margin-bottom:1.5rem;"></i>
                    <h3 style="font-family:'Oswald',sans-serif; font-size:1.6rem; color:var(--navy); text-transform:uppercase; margin-bottom:0.8rem;">No Projects Found</h3>
                    <p style="color:var(--text-muted); max-width:400px; margin:0 auto 2rem; line-height:1.75;">Try adjusting your search or filters to find what you are looking for.</p>
                    <a href="{{ route('projects.index') }}" class="btn-primary"><i class="fas fa-times"></i> Clear All Filters</a>
                </div>
            @endif

        </div>
    </section>
</div>

@push('styles')
<style>
    /* Hide native scrollbar for flagship grid but keep it scrollable */
    .flagship-grid::-webkit-scrollbar {
        display: none;
    }
    
    /* Hover wrapper for desktop arrows */
    .flagship-slider-wrapper:hover .flagship-nav-btn {
        opacity: 1;
        pointer-events: auto;
    }

    /* Arrow styling */
    .flagship-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        color: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        z-index: 10;
        cursor: pointer;
        border: 1px solid rgba(197, 160, 89, 0.2);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .flagship-nav-btn:hover {
        background: var(--gold);
        color: #fff;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 25px rgba(197, 160, 89, 0.4);
    }

    .flagship-nav-btn.prev-btn {
        left: -25px;
    }
    .flagship-nav-btn.next-btn {
        right: -25px;
    }
</style>
@endpush

@endsection