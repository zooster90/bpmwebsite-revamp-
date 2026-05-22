@extends('layouts.app')

@section('title', 'Track Records | We Built to Last')

@section('styles')
<style>
    :root {
        --navy: #0a1f38;
        --navy-light: #162e4a;
        --navy-dark: #061322;
        --gold: #c5a059;
        --gold-light: #d4b881;
        --gold-dark: #a8863e;
        --bg-soft: #fafaf8;
        --white: #ffffff;
        --stone-50: #fafaf9;
        --stone-100: #f5f5f4;
        --stone-200: #e7e5e4;
        --stone-300: #d6d3d1;
        --stone-400: #a8a29e;
        --stone-500: #78716c;
        --stone-600: #57534e;
        --stone-800: #292524;
        --transition-smooth: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-bounce: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--bg-soft);
        color: #2d3748;
        overflow-x: hidden;
    }

    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: radial-gradient(circle, #d6d3d1 0.5px, transparent 0.5px);
        background-size: 28px 28px;
        opacity: 0.35;
        pointer-events: none;
        z-index: 0;
    }

    .font-oswald { font-family: 'Oswald', sans-serif; }

    /* ═══════════════════════════════════════
       HERO
       ═══════════════════════════════════════ */
    .main-header {
        padding: 160px 0 140px;
        background: var(--navy);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    .main-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
        opacity: 0.12;
        filter: grayscale(100%) contrast(1.2);
    }
    .main-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(160deg, rgba(6,19,34,0.97) 0%, rgba(10,31,56,0.88) 40%, rgba(22,46,74,0.75) 100%);
    }

    .hero-deco-line {
        position: absolute;
        width: 1px;
        background: linear-gradient(to bottom, transparent, rgba(197,160,89,0.15), transparent);
        z-index: 1;
    }

    .glass-stats {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .stat-clickable {
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 12px;
        transition: var(--transition-smooth);
    }
    .stat-clickable:hover {
        background: rgba(255,255,255,0.05);
    }

    /* ═══════════════════════════════════════
       FILTER BAR
       ═══════════════════════════════════════ */
    .filter-bar {
        background: var(--white);
        border-radius: 24px;
        box-shadow:
            0 20px 60px rgba(0,0,0,0.06),
            0 1px 3px rgba(0,0,0,0.04),
            0 0 0 1px rgba(197,160,89,0.08);
        padding: 6px;
        margin: -56px auto 0;
        max-width: 1200px;
        position: relative;
        z-index: 30;
    }

    .filter-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-radius: 18px;
        transition: var(--transition-smooth);
    }
    .filter-cell:hover {
        background: var(--stone-50);
    }
    .filter-cell .icon {
        color: var(--gold);
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .filter-divider {
        width: 1px;
        height: 32px;
        background: var(--stone-200);
        flex-shrink: 0;
    }

    .custom-select {
        appearance: none;
        background: transparent;
        border: none;
        width: 100%;
        font-weight: 700;
        font-size: 0.78rem;
        color: var(--navy);
        padding: 8px 32px 8px 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23c5a059' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0 center;
        background-size: 14px;
        cursor: pointer;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }
    .custom-select:focus { outline: none; }

    .search-input {
        width: 100%;
        background: transparent;
        border: none;
        outline: none;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--navy);
        letter-spacing: 0.3px;
    }
    .search-input::placeholder {
        color: var(--stone-400);
        font-weight: 500;
    }

    .active-filters-strip {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        padding: 12px 24px 4px;
    }
    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        transition: var(--transition-smooth);
    }
    .filter-tag:hover { transform: scale(1.05); }
    .filter-tag.tag-gold { background: rgba(197,160,89,0.12); color: var(--gold-dark); }
    .filter-tag.tag-navy { background: rgba(10,31,56,0.06); color: var(--navy); }
    .filter-tag.tag-green { background: rgba(34,197,94,0.08); color: #15803d; }
    .filter-tag.tag-amber { background: rgba(245,158,11,0.08); color: #b45309; }
    .filter-tag.tag-blue { background: rgba(59,130,246,0.08); color: #1d4ed8; }
    .filter-tag .remove { font-size: 0.55rem; opacity: 0.6; }
    .filter-tag:hover .remove { opacity: 1; }

    /* ═══════════════════════════════════════
       RESULTS HEADER
       ═══════════════════════════════════════ */
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        padding-top: 40px;
    }
    .results-count {
        font-size: 0.65rem;
        font-weight: 900;
        color: var(--stone-400);
        text-transform: uppercase;
        letter-spacing: 3px;
    }
    .results-count span { color: var(--navy); font-size: 0.75rem; }
    .reset-btn {
        font-size: 0.65rem;
        color: var(--gold);
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 8px;
        background: none;
        border: none;
        cursor: pointer;
        transition: var(--transition-smooth);
        padding: 8px 16px;
        border-radius: 10px;
    }
    .reset-btn:hover {
        color: var(--navy);
        background: var(--stone-50);
    }

    /* ═══════════════════════════════════════
       GROUP HEADERS
       ═══════════════════════════════════════ */
    .group-section { margin-bottom: 60px; }
    .group-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 32px;
    }
    .group-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .group-icon.icon-ongoing { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .group-icon.icon-completed { background: rgba(34,197,94,0.1); color: #22c55e; }
    .group-icon.icon-coming { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .group-icon.icon-other { background: rgba(168,162,158,0.1); color: var(--stone-500); }

    .group-title {
        font-family: 'Oswald', sans-serif;
        font-size: 1.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
    }
    .group-title.title-ongoing { color: #b45309; }
    .group-title.title-completed { color: #15803d; }
    .group-title.title-coming { color: #1d4ed8; }
    .group-title.title-other { color: var(--stone-500); }

    .group-line { flex: 1; height: 2px; background: var(--stone-200); border-radius: 2px; }
    .group-count {
        font-size: 0.65rem;
        font-weight: 900;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 2px;
        white-space: nowrap;
    }

    /* ═══════════════════════════════════════
       PROJECT CARDS
       ═══════════════════════════════════════ */
    .project-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 24px;
    }
    @media (min-width: 768px) {
        .project-grid { grid-template-columns: repeat(2, 1fr); gap: 28px; }
    }
    @media (min-width: 1024px) {
        .project-grid { grid-template-columns: repeat(3, 1fr); gap: 32px; }
    }

    .project-card {
        position: relative;
        height: 500px;
        border-radius: 24px;
        overflow: hidden;
        background: var(--navy-dark);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: var(--transition-smooth);
        cursor: pointer;
        will-change: transform;
    }
    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(10,31,56,0.15), 0 10px 20px rgba(10,31,56,0.06);
    }

    .project-image-wrap {
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .project-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1s cubic-bezier(0.2, 0, 0.2, 1), opacity 0.5s ease;
        opacity: 0.85;
    }
    .project-card:hover .project-image {
        transform: scale(1.08);
        opacity: 0.6;
    }

    /* Always-visible bottom label */
    .project-bottom-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 60px 28px 24px;
        background: linear-gradient(to top, rgba(6,19,34,0.9) 0%, rgba(6,19,34,0.4) 60%, transparent 100%);
        z-index: 10;
        transition: var(--transition-smooth);
    }
    .project-card:hover .project-bottom-label {
        opacity: 0;
    }
    .project-bottom-label h3 {
        font-family: 'Oswald', sans-serif;
        color: white;
        font-size: 1.3rem;
        font-weight: 600;
        line-height: 1.2;
        letter-spacing: 0.5px;
    }
    .project-bottom-label .bottom-meta {
        color: rgba(255,255,255,0.5);
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .project-bottom-label .bottom-meta i { color: var(--gold); font-size: 0.6rem; }

    /* Full info overlay on hover */
    .project-info-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
            rgba(6, 19, 34, 0.98) 0%,
            rgba(10, 31, 56, 0.7) 55%,
            rgba(10, 31, 56, 0.2) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 36px;
        opacity: 0;
        transform: translateY(16px);
        transition: var(--transition-smooth);
        z-index: 15;
    }
    .project-card:hover .project-info-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    .category-tag {
        display: inline-block;
        background: var(--gold);
        color: white;
        padding: 5px 14px;
        border-radius: 8px;
        font-size: 0.6rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 14px;
        width: fit-content;
    }

    .project-title-overlay {
        color: white;
        font-family: 'Oswald', sans-serif;
        font-size: 1.6rem;
        font-weight: 600;
        line-height: 1.15;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
    }

    .project-meta-line {
        color: rgba(255,255,255,0.75);
        font-size: 0.78rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .project-meta-line i { color: var(--gold); width: 14px; text-align: center; font-size: 0.7rem; }

    .status-pill {
        margin-top: 16px;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(8px);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .pill-completed   { background: rgba(34,197,94,0.12);  color: #86efac; border: 1px solid rgba(34,197,94,0.25); }
    .pill-ongoing     { background: rgba(245,158,11,0.12); color: #fde047; border: 1px solid rgba(245,158,11,0.25); }
    .pill-coming-soon { background: rgba(59,130,246,0.12); color: #bae6fd; border: 1px solid rgba(59,130,246,0.25); }
    .pill-other       { background: rgba(168,162,158,0.12);color: #d6d3d1; border: 1px solid rgba(168,162,158,0.25); }

    .year-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: white;
        color: var(--navy);
        padding: 7px 16px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.82rem;
        font-family: 'Oswald', sans-serif;
        letter-spacing: 0.5px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        z-index: 20;
        transition: var(--transition-smooth);
    }
    .project-card:hover .year-badge {
        background: var(--gold);
        color: white;
        transform: scale(0.92);
    }

    /* ═══════════════════════════════════════
       EMPTY STATE
       ═══════════════════════════════════════ */
    .empty-state {
        text-align: center;
        padding: 100px 20px;
    }
    .empty-icon-ring {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--stone-50);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 32px;
        border: 2px dashed var(--stone-200);
    }
    .empty-state h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 2.5rem;
        color: var(--navy);
        margin-bottom: 12px;
        letter-spacing: 1px;
    }
    .empty-state p {
        color: var(--stone-500);
        font-weight: 500;
        margin-bottom: 32px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }
    .empty-state .cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 36px;
        background: var(--navy);
        color: white;
        border-radius: 16px;
        font-weight: 800;
        font-size: 0.7rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        border: none;
        transition: var(--transition-smooth);
        box-shadow: 0 10px 30px rgba(10,31,56,0.15);
    }
    .empty-state .cta-btn:hover {
        background: var(--gold);
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(197,160,89,0.3);
    }

    /* ═══════════════════════════════════════
       BACK TO TOP
       ═══════════════════════════════════════ */
    #backToTop {
        position: fixed;
        bottom: 36px;
        right: 36px;
        width: 56px;
        height: 56px;
        background: var(--gold);
        color: white;
        border: none;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        box-shadow: 0 12px 30px rgba(197,160,89,0.35);
        opacity: 0;
        visibility: hidden;
        transform: scale(0.8);
        transition: var(--transition-smooth);
        z-index: 9999;
    }
    #backToTop.visible {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }
    #backToTop:hover {
        background: var(--navy);
        box-shadow: 0 12px 30px rgba(10,31,56,0.25);
        transform: scale(1.05) translateY(-2px);
    }

    @media (max-width: 1023px) {
        #backToTop {
            bottom: 92px !important;
            right: 20px !important;
        }
    }

    /* ═══════════════════════════════════════
       ANIMATIONS
       ═══════════════════════════════════════ */
    .fade-in-up {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .fade-in-up.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .stagger-1 { transition-delay: 0.05s; }
    .stagger-2 { transition-delay: 0.1s; }
    .stagger-3 { transition-delay: 0.15s; }
    .stagger-4 { transition-delay: 0.2s; }
    .stagger-5 { transition-delay: 0.25s; }
    .stagger-6 { transition-delay: 0.3s; }

    /* Counter animation */
    @keyframes countPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .count-animate { animation: countPulse 0.4s ease; }

    /* Responsive tweaks */
    @media (max-width: 767px) {
        .main-header { padding: 130px 0 110px; }
        .main-header h1 { font-size: 3.5rem !important; }
        .filter-bar { margin-top: -40px; border-radius: 20px; }
        
        .project-card {
            height: auto !important;
            background: var(--white);
            border: 1px solid var(--stone-200);
        }
        .project-image-wrap {
            height: auto !important;
            display: flex;
            flex-direction: column;
            overflow: visible !important;
            position: relative;
        }
        .project-image {
            height: 240px !important;
            width: 100%;
            object-fit: cover;
            opacity: 1 !important;
        }
        .project-bottom-label {
            display: none !important;
        }
        .project-info-overlay {
            position: static !important;
            opacity: 1 !important;
            transform: none !important;
            background: var(--white) !important;
            padding: 20px 24px 24px !important;
            color: var(--navy) !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .project-title-overlay {
            color: var(--navy) !important;
            margin-top: 4px;
            font-size: 1.25rem !important;
            margin-bottom: 8px !important;
        }
        .project-meta-line {
            color: var(--stone-600) !important;
            margin-bottom: 6px !important;
        }
        .project-meta-line i {
            color: var(--gold) !important;
        }
        .status-pill {
            margin-top: 12px;
        }
        .pill-completed   { background: rgba(34,197,94,0.1) !important;  color: #15803d !important; border: 1px solid rgba(34,197,94,0.2) !important; }
        .pill-ongoing     { background: rgba(245,158,11,0.1) !important; color: #b45309 !important; border: 1px solid rgba(245,158,11,0.2) !important; }
        .pill-coming-soon { background: rgba(59,130,246,0.1) !important; color: #1d4ed8 !important; border: 1px solid rgba(59,130,246,0.2) !important; }
        .pill-other       { background: rgba(168,162,158,0.1) !important;color: var(--stone-600) !important; border: 1px solid rgba(168,162,158,0.2) !important; }
    }
</style>
@endsection


@section('content')

{{-- ══════════════════════════════════════════════════
     HERO
     ══════════════════════════════════════════════════ --}}
<header class="main-header">
    {{-- Decorative vertical lines --}}
    <div class="hero-deco-line" style="left:12%; top:0; bottom:0; height:100%;"></div>
    <div class="hero-deco-line" style="left:88%; top:0; bottom:0; height:100%;"></div>

    <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16 relative z-10 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-16">

            {{-- Left: Title --}}
            <div class="lg:w-1/2 text-center lg:text-left fade-in-up is-visible">
                <div class="inline-flex items-center gap-4 mb-8 justify-center lg:justify-start">
                    <span class="h-[2px] w-10 bg-[var(--gold)]"></span>
                    <span class="text-[10px] font-black uppercase tracking-[5px] text-[var(--gold-light)]">Established 1996</span>
                    <span class="h-[2px] w-10 bg-[var(--gold)]"></span>
                </div>
                <h1 class="font-oswald text-6xl md:text-7xl lg:text-[6.5rem] font-bold text-white leading-[0.88] mb-8 tracking-tighter">
                    PROJECT<br><span class="text-[var(--gold)]">RECORDS</span>
                </h1>
                <p class="text-base md:text-lg text-gray-300/80 max-w-lg mx-auto lg:mx-0 leading-relaxed font-medium">
                    Documenting a legacy of structural integrity, engineering precision, and a commitment to excellence in the Malaysian construction landscape.
                </p>
            </div>

            {{-- Right: Stats --}}
            <div class="lg:w-auto fade-in-up is-visible stagger-2">
                <div class="glass-stats p-8 lg:p-12 flex flex-col sm:flex-row items-center gap-8 sm:gap-14">

                    <div class="text-center">
                        <div id="totalCount" class="text-6xl lg:text-7xl font-oswald font-bold text-[var(--gold)] leading-none">0</div>
                        <p class="uppercase text-[9px] tracking-[4px] mt-4 font-black text-gray-500">Master Portfolio</p>
                    </div>

                    <div class="h-28 w-px bg-white/10 hidden sm:block"></div>

                    <div class="grid grid-cols-1 gap-5 text-center sm:text-left">
                        <div class="stat-clickable" onclick="quickFilterStatus('Completed')">
                            <div class="flex items-center gap-4">
                                <div id="completedCount" class="text-3xl lg:text-4xl font-oswald font-bold text-white leading-none">0</div>
                                <div>
                                    <p class="text-[#86efac] text-[9px] font-black tracking-[3px] uppercase">Completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="stat-clickable" onclick="quickFilterStatus('Ongoing')">
                            <div class="flex items-center gap-4">
                                <div id="ongoingCount" class="text-3xl lg:text-4xl font-oswald font-bold text-white leading-none">0</div>
                                <div>
                                    <p class="text-[#fde047] text-[9px] font-black tracking-[3px] uppercase">Ongoing</p>
                                </div>
                            </div>
                        </div>
                        <div class="stat-clickable" onclick="quickFilterStatus('Coming Soon')">
                            <div class="flex items-center gap-4">
                                <div id="comingSoonCount" class="text-3xl lg:text-4xl font-oswald font-bold text-white leading-none">0</div>
                                <div>
                                    <p class="text-[#bae6fd] text-[9px] font-black tracking-[3px] uppercase">Coming Soon</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


{{-- ══════════════════════════════════════════════════
     FILTER BAR
     ══════════════════════════════════════════════════ --}}
<div class="max-w-[1200px] mx-auto px-6 md:px-12 lg:px-16 relative z-30">
    <div class="filter-bar fade-in-up is-visible stagger-3">
        <form id="filterForm" onsubmit="return false;">
            <div class="grid grid-cols-1 md:grid-cols-12 items-center">

                {{-- Search --}}
                <div class="md:col-span-4 filter-cell border-b md:border-b-0 md:border-r border-stone-100">
                    <i class="fas fa-search icon"></i>
                    <input type="text" id="searchInput"
                           placeholder="Search projects..."
                           class="search-input"
                           autocomplete="off">
                </div>

                {{-- Category --}}
                <div class="md:col-span-3 filter-cell border-b md:border-b-0 md:border-r border-stone-100">
                    <i class="fas fa-layer-group icon"></i>
                    <select id="categorySelect" class="custom-select"></select>
                </div>

                {{-- Status --}}
                <div class="md:col-span-3 filter-cell border-b md:border-b-0 md:border-r border-stone-100">
                    <i class="fas fa-circle-dot icon"></i>
                    <select id="statusSelect" class="custom-select">
                        <option value="all">All Status</option>
                        <option value="Completed">Completed</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Coming Soon">Coming Soon</option>
                    </select>
                </div>

                {{-- Sort --}}
                <div class="md:col-span-2 filter-cell justify-center">
                    <i class="fas fa-arrow-down-wide-short icon"></i>
                    <select id="sortSelect" class="custom-select">
                        <option value="desc">Newest</option>
                        <option value="asc">Oldest</option>
                        <option value="name">A — Z</option>
                    </select>
                </div>
            </div>
        </form>

        {{-- Active filter tags --}}
        <div id="activeFilterTags" class="active-filters-strip" style="display:none;"></div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════
     RESULTS AREA
     ══════════════════════════════════════════════════ --}}
<main class="max-w-[1400px] mx-auto w-full px-6 md:px-12 lg:px-16 pt-10 pb-24 relative z-10">

    {{-- Results header --}}
    <div class="results-header">
        <p id="resultCount" class="results-count">Indexing records...</p>
        <button onclick="resetFilters()" class="reset-btn" id="resetBtn" style="display:none;">
            <i class="fas fa-sync-alt"></i> Reset View
        </button>
    </div>

    {{-- Project container --}}
    <div id="projectContainer"></div>

    {{-- Empty state --}}
    <div id="noResults" class="empty-state" style="display:none;">
        <div class="empty-icon-ring">
            <i class="fas fa-folder-open text-4xl text-stone-300"></i>
        </div>
        <h3>NO MATCHING DATA</h3>
        <p>Refine your search parameters or clear all filters to explore our full portfolio.</p>
        <button onclick="resetFilters()" class="cta-btn">
            <i class="fas fa-th-large"></i> Show All Projects
        </button>
    </div>
</main>


{{-- ══════════════════════════════════════════════════
     BACK TO TOP
     ══════════════════════════════════════════════════ --}}
<button id="backToTop" title="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

@endsection


@section('scripts')
<script>
(function () {
    'use strict';

    /* ─── Category Mapping ─── */
    const CATEGORY_MAP = [
        { regex: /residential|high\s?rise/i,            label: "High Rise" },
        { regex: /healthcare|hospital/i,                 label: "Hospital" },
        { regex: /hotel/i,                               label: "Hotel" },
        { regex: /commercial/i,                          label: "Commercial Building" },
        { regex: /government|public/i,                   label: "Government Building" },
        { regex: /infrastructure|civil/i,                label: "Civil & Infrastructural Works" },
        { regex: /road/i,                                label: "Roadwork" },
        { regex: /factory|industrial/i,                  label: "Factory (Industrial Building Works)" },
        { regex: /terrace|semi-?d|bungalow/i,            label: "Terrace, Semi-D & Bungalow" },
        { regex: /school|education/i,                    label: "School" },
        { regex: /maintenance/i,                         label: "Maintenance" },
        { regex: /interior|renovation|furniture/i,       label: "Interior Design, Furniture & Renovation Works" }
    ];
    const OFFICIAL_CATEGORIES = CATEGORY_MAP.map(m => m.label);

    /* ─── Status normalization ─── */
    function normalizeStatus(raw) {
        var s = String(raw || 'Completed').trim();
        var lower = s.toLowerCase();
        if (lower === 'upcoming') return 'Coming Soon';
        if (lower === 'complete' || lower === 'done') return 'Completed';
        if (lower === 'in progress' || lower === 'ongoing' || lower === 'under construction') return 'Ongoing';
        if (lower === 'coming soon' || lower === 'upcoming') return 'Coming Soon';
        // Capitalise first letter of each word for unknown statuses
        return s.replace(/\w\S*/g, function(t){ return t.charAt(0).toUpperCase() + t.substr(1).toLowerCase(); });
    }

    /* ─── Image helper ─── */
    function getImg(p) {
        var img = p.image_url || p.img || p.images || p.image || p.photo || null;
        if (!img) return 'https://placehold.co/1200x800/0a1f38/c5a059?text=Project';
        if (img.startsWith('http')) return img;
        return '{{ asset("images") }}/' + img.replace(/^\/+/, '');
    }

    /* ─── State ─── */
    var projectsData = [];
    var currentCategory = 'all';
    var currentStatus   = 'all';
    var searchTerm      = '';
    var sortMode        = 'desc';
    var searchTimer     = null;

    /* ─── DOM refs ─── */
    var $container      = document.getElementById('projectContainer');
    var $noResults      = document.getElementById('noResults');
    var $resultCount    = document.getElementById('resultCount');
    var $resetBtn       = document.getElementById('resetBtn');
    var $filterTags     = document.getElementById('activeFilterTags');
    var $searchInput    = document.getElementById('searchInput');
    var $categorySelect = document.getElementById('categorySelect');
    var $statusSelect   = document.getElementById('statusSelect');
    var $sortSelect     = document.getElementById('sortSelect');
    var $backToTop      = document.getElementById('backToTop');

    /* ═══════════════════════════════════════════
       INITIALISE
       ═══════════════════════════════════════════ */
    function init() {
        try {
            var raw = @json($projects);

            projectsData = raw.map(function (p, idx) {
                var dbCat = String(p.category || p.cat || '').trim();
                var matched = 'General Construction';
                for (var i = 0; i < CATEGORY_MAP.length; i++) {
                    if (CATEGORY_MAP[i].regex.test(dbCat)) { matched = CATEGORY_MAP[i].label; break; }
                }
                return {
                    id:       String(p.id || 'p-' + idx),
                    year:     parseInt(p.year || p.completion_year || p.date) || new Date().getFullYear(),
                    title:    String(p.title || p.name || 'Untitled Project').trim(),
                    loc:      String(p.location || p.loc || 'Malaysia').trim(),
                    category: matched,
                    status:   normalizeStatus(p.status),
                    img:      getImg(p),
                    award:    String(p.award || '').trim(),
                    slug:     String(p.slug || p.id || '').trim()
                };
            });

            buildCategorySelect();
            updateStats();
            render();
            bindEvents();
        } catch (err) {
            console.error('Portfolio init error:', err);
        }
    }

    /* ─── Stats with counter animation ─── */
    function animateCount(el, target) {
        var current = parseInt(el.textContent) || 0;
        if (current === target) return;
        var diff = target - current;
        var steps = Math.min(Math.abs(diff), 30);
        var step = 0;
        var interval = setInterval(function () {
            step++;
            var progress = step / steps;
            el.textContent = Math.round(current + diff * progress);
            if (step >= steps) {
                el.textContent = target;
                clearInterval(interval);
                el.classList.add('count-animate');
                setTimeout(function () { el.classList.remove('count-animate'); }, 400);
            }
        }, 25);
    }

    function updateStats() {
        var total = projectsData.length;
        var completed  = projectsData.filter(function(p){ return p.status === 'Completed'; }).length;
        var ongoing    = projectsData.filter(function(p){ return p.status === 'Ongoing'; }).length;
        var comingSoon = projectsData.filter(function(p){ return p.status === 'Coming Soon'; }).length;

        animateCount(document.getElementById('totalCount'), total);
        animateCount(document.getElementById('completedCount'), completed);
        animateCount(document.getElementById('ongoingCount'), ongoing);
        animateCount(document.getElementById('comingSoonCount'), comingSoon);
    }

    /* ─── Category select ─── */
    function buildCategorySelect() {
        var html = '<option value="all">All Project Categories</option>';
        OFFICIAL_CATEGORIES.forEach(function (cat) {
            html += '<option value="' + cat + '">' + cat.toUpperCase() + '</option>';
        });
        $categorySelect.innerHTML = html;
    }

    /* ═══════════════════════════════════════════
       RENDER
       ═══════════════════════════════════════════ */
    function render() {
        // 1. Filter
        var filtered = projectsData.filter(function (p) {
            var matchCat    = currentCategory === 'all' || p.category === currentCategory;
            var matchStatus = currentStatus === 'all'   || p.status === currentStatus;
            var matchSearch = !searchTerm ||
                p.title.toLowerCase().indexOf(searchTerm) !== -1 ||
                p.loc.toLowerCase().indexOf(searchTerm) !== -1 ||
                p.category.toLowerCase().indexOf(searchTerm) !== -1 ||
                String(p.year).indexOf(searchTerm) !== -1;
            return matchCat && matchStatus && matchSearch;
        });

        // 2. Sort
        if (sortMode === 'name') {
            filtered.sort(function(a,b){ return a.title.localeCompare(b.title); });
        } else if (sortMode === 'asc') {
            filtered.sort(function(a,b){ return a.year - b.year; });
        } else {
            filtered.sort(function(a,b){ return b.year - a.year; });
        }

        // 3. Update UI counts
        $resultCount.innerHTML = 'Showing <span>' + filtered.length + '</span> of <span>' + projectsData.length + '</span> projects';
        $noResults.style.display = filtered.length === 0 ? 'block' : 'none';
        $container.style.display = filtered.length === 0 ? 'none' : 'block';

        // 4. Show/hide reset & filter tags
        var isFiltering = currentCategory !== 'all' || currentStatus !== 'all' || searchTerm !== '';
        $resetBtn.style.display = isFiltering ? 'flex' : 'none';
        renderFilterTags();

        // 5. Group by status
        var ongoing    = filtered.filter(function(p){ return p.status === 'Ongoing'; });
        var comingSoon = filtered.filter(function(p){ return p.status === 'Coming Soon'; });
        var completed  = filtered.filter(function(p){ return p.status === 'Completed'; });
        var other      = filtered.filter(function(p){
            return p.status !== 'Ongoing' && p.status !== 'Coming Soon' && p.status !== 'Completed';
        });

        var html = '';
        var gi = 0; // global animation index

        html += buildGroup(ongoing,    'Ongoing Projects',    'ongoing',   'fa-hard-hat', gi);  gi += ongoing.length;
        html += buildGroup(comingSoon, 'Coming Soon',         'coming',    'fa-rocket',   gi);  gi += comingSoon.length;
        html += buildGroup(completed,  'Completed Projects',  'completed', 'fa-trophy',   gi);  gi += completed.length;
        html += buildGroup(other,      'Other Projects',      'other',     'fa-landmark', gi);

        $container.innerHTML = html;

        // 6. Trigger reveal animations
        requestAnimationFrame(function () {
            observeFadeIns();
        });
    }

    function buildGroup(projects, title, type, iconClass, startIdx) {
        if (projects.length === 0) return '';

        var iconColor  = type === 'ongoing' ? 'icon-ongoing' : type === 'completed' ? 'icon-completed' : type === 'coming' ? 'icon-coming' : 'icon-other';
        var titleColor = type === 'ongoing' ? 'title-ongoing' : type === 'completed' ? 'title-completed' : type === 'coming' ? 'title-coming' : 'title-other';

        var h = '';
        h += '<div class="group-section">';
        h += '  <div class="group-header fade-in-up">';
        h += '    <div class="group-icon ' + iconColor + '"><i class="fas ' + iconClass + '"></i></div>';
        h += '    <h2 class="group-title ' + titleColor + '">' + title + '</h2>';
        h += '    <div class="group-line"></div>';
        h += '    <span class="group-count">' + projects.length + ' Record' + (projects.length !== 1 ? 's' : '') + '</span>';
        h += '  </div>';
        h += '  <div class="project-grid">';

        for (var i = 0; i < projects.length; i++) {
            h += buildCard(projects[i], startIdx + i);
        }

        h += '  </div>';
        h += '</div>';
        return h;
    }

    function buildCard(p, idx) {
        var statusClass = 'pill-other';
        if (p.status === 'Completed')   statusClass = 'pill-completed';
        if (p.status === 'Ongoing')     statusClass = 'pill-ongoing';
        if (p.status === 'Coming Soon') statusClass = 'pill-coming-soon';

        var stagger = 'stagger-' + ((idx % 6) + 1);
        var url = '/projects/' + (p.slug || p.id);

        return '' +
        '<a href="' + url + '" class="project-card fade-in-up ' + stagger + '" style="text-decoration:none;">' +
        '  <div class="project-image-wrap">' +
        '    <img src="' + p.img + '" class="project-image" alt="' + escapeHtml(p.title) + '" loading="lazy">' +
        '    <div class="year-badge">' + p.year + '</div>' +
        '    <div class="project-bottom-label">' +
        '      <h3>' + escapeHtml(p.title) + '</h3>' +
        '      <div class="bottom-meta"><i class="fas fa-map-marker-alt"></i> ' + escapeHtml(p.loc) + '</div>' +
        '    </div>' +
        '    <div class="project-info-overlay">' +
        '      <span class="category-tag">' + escapeHtml(p.category) + '</span>' +
        '      <h3 class="project-title-overlay">' + escapeHtml(p.title) + '</h3>' +
        '      <div class="project-meta-line"><i class="fas fa-map-marker-alt"></i><span>' + escapeHtml(p.loc) + '</span></div>' +
               (p.award ? '<div class="project-meta-line"><i class="fas fa-award"></i><span>' + escapeHtml(p.award) + '</span></div>' : '') +
        '      <div><div class="status-pill ' + statusClass + '"><i class="fas fa-circle" style="font-size:5px;"></i> ' + escapeHtml(p.status.toUpperCase()) + '</div></div>' +
        '    </div>' +
        '  </div>' +
        '</a>';
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    /* ─── Filter tags ─── */
    function renderFilterTags() {
        var tags = [];
        if (searchTerm) {
            tags.push({ label: '"' + searchTerm + '"', cls: 'tag-gold', clear: function(){ $searchInput.value = ''; searchTerm = ''; render(); } });
        }
        if (currentCategory !== 'all') {
            tags.push({ label: currentCategory, cls: 'tag-navy', clear: function(){ currentCategory = 'all'; $categorySelect.value = 'all'; render(); } });
        }
        if (currentStatus !== 'all') {
            var statusCls = currentStatus === 'Completed' ? 'tag-green' : currentStatus === 'Ongoing' ? 'tag-amber' : 'tag-blue';
            tags.push({ label: currentStatus, cls: statusCls, clear: function(){ currentStatus = 'all'; $statusSelect.value = 'all'; render(); } });
        }

        if (tags.length === 0) {
            $filterTags.style.display = 'none';
            return;
        }

        $filterTags.style.display = 'flex';
        var html = '<span style="font-size:0.6rem;font-weight:800;color:#a8a29e;text-transform:uppercase;letter-spacing:2px;margin-right:4px;">Active:</span>';
        tags.forEach(function (t) {
            html += '<span class="filter-tag ' + t.cls + '" data-tag="true">' + t.label + ' <i class="fas fa-times remove"></i></span>';
        });
        $filterTags.innerHTML = html;

        // Bind click to remove
        var tagEls = $filterTags.querySelectorAll('[data-tag]');
        tagEls.forEach(function (el, i) {
            el.addEventListener('click', function () {
                tags[i].clear();
            });
        });
    }

    /* ─── Intersection Observer for fade-in ─── */
    var fadeObserver = null;
    function observeFadeIns() {
        if (!('IntersectionObserver' in window)) {
            document.querySelectorAll('.fade-in-up:not(.is-visible)').forEach(function(el){ el.classList.add('is-visible'); });
            return;
        }
        if (fadeObserver) fadeObserver.disconnect();
        fadeObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

        document.querySelectorAll('.fade-in-up:not(.is-visible)').forEach(function (el) {
            fadeObserver.observe(el);
        });
    }

    /* ═══════════════════════════════════════════
       EVENT BINDINGS
       ═══════════════════════════════════════════ */
    function bindEvents() {
        $searchInput.addEventListener('input', function (e) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                searchTerm = e.target.value.toLowerCase().trim();
                render();
            }, 180);
        });

        $categorySelect.addEventListener('change', function () {
            currentCategory = this.value;
            render();
        });

        $statusSelect.addEventListener('change', function () {
            currentStatus = this.value;
            render();
        });

        $sortSelect.addEventListener('change', function () {
            sortMode = this.value;
            render();
        });

        $backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        window.addEventListener('scroll', function () {
            if (window.scrollY > 500) {
                $backToTop.classList.add('visible');
            } else {
                $backToTop.classList.remove('visible');
            }
        }, { passive: true });
    }

    /* ─── Global helpers ─── */
    window.quickFilterStatus = function (s) {
        currentStatus = s;
        $statusSelect.value = s;
        render();
        document.querySelector('.filter-bar').scrollIntoView({ behavior: 'smooth', block: 'center' });
    };

    window.resetFilters = function () {
        currentCategory = 'all';
        currentStatus   = 'all';
        searchTerm      = '';
        sortMode        = 'desc';
        $searchInput.value    = '';
        $categorySelect.value = 'all';
        $statusSelect.value   = 'all';
        $sortSelect.value     = 'desc';
        render();
    };

    /* ─── Boot ─── */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endsection