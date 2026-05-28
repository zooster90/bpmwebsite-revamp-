@extends('layouts.app')

@section('title', 'Staff Activities & Culture | Builtech Engineering')
@section('description', 'Experience the vibrant atmosphere, elite engineering synergy, and team unity at Builtech. Discover how we build excellence through continuous training, festive celebrations, and community CSR.')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" />
<style>
    /* ═══════════════════════════════════════════════════════
       BUILTECH CULTURE & STAFF ACTIVITIES — 2026 WORLD-CLASS EDITION
       ═══════════════════════════════════════════════════════ */

    :root {
        --gold: #c5a059;
        --gold-light: #f2cf92;
        --navy: #0f172a;
        --navy-light: #1e293b;
        --surface: #f8fafc;
        --border: #e2e8f0;
    }

    [x-cloak] { 
        display: none !important; 
    }

    /* ── Hero Section ── */
    .culture-hero {
        position: relative;
        padding: 220px 5% 160px;
        background: linear-gradient(180deg, #090e1a 0%, var(--navy) 100%);
        overflow: hidden;
        text-align: center;
    }
    .culture-hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2000') center/cover no-repeat;
        opacity: 0.18; filter: grayscale(0.5) contrast(1.1);
    }
    .culture-hero-badge {
        display: inline-block; background: rgba(242, 207, 146, 0.1); border: 1px solid rgba(242, 207, 146, 0.3);
        color: var(--gold-light); padding: 8px 24px; border-radius: 50px; font-family: var(--bt-font-display, 'Oswald', sans-serif);
        font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.3em; margin-bottom: 1.5rem;
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    }
    .culture-hero-title {
        font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: clamp(3.5rem, 8vw, 6.5rem); font-weight: 800;
        color: #ffffff; text-transform: uppercase; line-height: 1.05; margin-bottom: 1.5rem; letter-spacing: -0.02em;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.65);
    }
    .culture-hero-title span { 
        color: transparent !important;
        background: linear-gradient(to right, var(--gold-light), var(--gold));
        -webkit-background-clip: text;
        background-clip: text;
        text-shadow: none;
    }
    .culture-hero-desc { 
        color: rgba(255, 255, 255, 0.85) !important; 
        font-size: 1.15rem; max-width: 700px; margin: 0 auto; line-height: 1.85; 
        font-weight: 500;
    }

    /* ── Dual Perspective Culture Pillars ── */
    .culture-pillars-section { padding: 6rem 0; background: #ffffff; border-bottom: 1px solid var(--border); }
    .pillar-card {
        background: #ffffff; border: 1px solid var(--border); border-radius: 24px; padding: 3.5rem 2.5rem;
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1); position: relative; overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
    }
    .pillar-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--gold-light), var(--gold));
        transform: scaleX(0); transition: transform 0.5s ease; transform-origin: left;
    }
    .pillar-card:hover::before { transform: scaleX(1); }
    .pillar-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08); border-color: rgba(197, 160, 89, 0.3); }
    .pillar-icon {
        width: 76px; height: 76px; border-radius: 20px; background: rgba(197, 160, 89, 0.08); color: var(--gold);
        display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin-bottom: 2rem; transition: all 0.5s ease;
    }
    .pillar-card:hover .pillar-icon { transform: scale(1.1) rotate(5deg); background: var(--gold); color: #ffffff; box-shadow: 0 10px 20px rgba(197, 160, 89, 0.2); }
    .pillar-title { font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: 1.5rem; font-weight: 700; color: var(--navy); text-transform: uppercase; margin-bottom: 1rem; }
    .pillar-desc { color: #475569; font-size: 0.95rem; line-height: 1.75; margin: 0; font-weight: 500; }

    /* ═══════════════════════════════════════════════════
       2026 MASTER FILTER COMMAND BAR — PREMIUM REDESIGN
       ═══════════════════════════════════════════════════ */

    .master-filter-container {
        position: sticky; top: 80px; z-index: 900;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(32px) saturate(180%);
        -webkit-backdrop-filter: blur(32px) saturate(180%);
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset, 0 8px 32px rgba(0,0,0,0.05);
        transition: box-shadow 0.3s ease;
    }

    /* ── Top Nav: Floating Segmented Control ── */
    .filter-bar-inner {
        display: flex; align-items: center; justify-content: center;
        gap: 2px; padding: 12px 1.5rem;
        max-width: 1440px; margin: 0 auto;
    }
    .filter-bar-track {
        display: flex; align-items: center; gap: 2px;
        background: #f1f5f9; border-radius: 14px;
        padding: 4px; position: relative;
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04) inset;
        flex-wrap: wrap; justify-content: center;
    }
    .filter-cat-item { position: relative; flex-shrink: 0; }

    .filter-pill {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 8px 18px; border-radius: 10px;
        background: transparent; border: none;
        font-family: var(--bt-font-display, 'Oswald', sans-serif);
        font-size: 0.78rem; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.08em;
        cursor: pointer; white-space: nowrap; position: relative;
        transition: color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        -webkit-user-select: none; user-select: none;
    }
    .filter-pill .pill-emoji { font-size: 1rem; line-height: 1; }
    .filter-pill .pill-chevron {
        font-size: 0.55rem; opacity: 0.4;
        transition: transform 0.25s ease, opacity 0.25s ease;
        margin-left: 2px;
    }
    .filter-pill:hover { color: var(--navy); }
    .filter-pill:hover .pill-chevron { opacity: 0.8; }
    .filter-pill.active {
        background: var(--navy);
        color: var(--gold);
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18), 0 1px 3px rgba(15,23,42,0.12);
    }
    .filter-pill.active .pill-chevron { opacity: 1; color: var(--gold); transform: rotate(180deg); }
    .filter-cat-item:hover .pill-chevron { transform: rotate(180deg); opacity: 1; }

    /* ── Dropdown Panels (refined glass) ── */
    .filter-dropdown {
        position: absolute; top: calc(100% + 10px); left: 50%;
        transform: translateX(-50%) translateY(-8px) scale(0.97);
        min-width: 240px;
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 18px;
        box-shadow: 0 24px 64px -12px rgba(0,0,0,0.18), 0 0 0 1px rgba(255,255,255,0.5) inset;
        z-index: 9999; opacity: 0; pointer-events: none;
        transition: all 0.22s cubic-bezier(0.22, 1, 0.36, 1);
        padding: 0.6rem 0; transform-origin: top center;
    }
    .filter-dropdown::before {
        content: ''; position: absolute; top: -15px; left: 0; right: 0;
        height: 15px; background: transparent; z-index: -1;
    }
    .filter-dropdown.is-open {
        opacity: 1; pointer-events: auto;
        transform: translateX(-50%) translateY(0) scale(1);
    }
    .pill-chevron.chevron-open {
        transform: rotate(180deg) !important;
        opacity: 1 !important;
    }
    .dropdown-header {
        padding: 0.6rem 1.25rem 0.35rem; font-size: 0.6rem; font-weight: 900;
        color: #94a3b8; text-transform: uppercase; letter-spacing: 0.25em;
    }
    .dropdown-item {
        display: flex; align-items: center; gap: 10px;
        padding: 0.6rem 1.25rem; font-size: 0.82rem; font-weight: 600;
        color: #475569; cursor: pointer; transition: all 0.15s ease;
        background: none; border: none; width: 100%; text-align: left;
        border-radius: 0;
    }
    .dropdown-item:hover { color: var(--navy); background: rgba(241,245,249,0.8); padding-left: 1.5rem; }
    .dropdown-item.active { color: var(--navy); background: rgba(197,160,89,0.08); font-weight: 700; }
    .dropdown-item .sub-emoji { font-size: 1rem; flex-shrink: 0; width: 22px; text-align: center; }
    .dropdown-all-item {
        display: flex; align-items: center; gap: 8px;
        padding: 0.6rem 1.25rem; font-size: 0.72rem; font-weight: 800;
        color: var(--gold); cursor: pointer; background: rgba(197,160,89,0.04);
        border: none; border-bottom: 1px solid rgba(226,232,240,0.6);
        width: 100%; text-align: left; text-transform: uppercase; letter-spacing: 0.12em;
        transition: all 0.15s ease; margin-bottom: 0.3rem;
    }
    .dropdown-all-item:hover { background: rgba(197,160,89,0.1); color: #a07830; padding-left: 1.5rem; }

    /* ── Floating Sub-Filter Pill (2026 Design) ── */
    .sub-filter-bar {
        display: flex; justify-content: center;
        padding: 1.5rem 1rem 0; margin-bottom: -1rem;
        pointer-events: none; z-index: 800; position: relative;
    }
    .sub-filter-inner {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(24px) saturate(180%); -webkit-backdrop-filter: blur(24px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 100px; padding: 6px;
        box-shadow: 0 10px 30px -10px rgba(15,23,42,0.1), 0 4px 12px -5px rgba(15,23,42,0.05);
        pointer-events: auto;
    }

    /* Active Sub-Cat */
    .ctx-label { display: flex; align-items: center; padding: 0 4px 0 8px; }
    .cmd-chip-sub {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f1f5f9; border: 1px solid #e2e8f0;
        border-radius: 20px; padding: 6px 14px; color: var(--navy);
        font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;
    }
    .cmd-clear-inline {
        color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        width: 18px; height: 18px; transition: all 0.2s; cursor: pointer; border: none; background: transparent;
    }
    .cmd-clear-inline:hover { background: #fee2e2; color: #ef4444; }

    /* Year Timeline Strip */
    .year-timeline { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 4px; padding: 0 4px; }
    .year-timeline::-webkit-scrollbar { display: none; }
    .yr-btn {
        padding: 6px 14px; border-radius: 20px; border: none; background: transparent;
        font-family: var(--bt-font-display, 'Oswald', sans-serif);
        font-size: 0.75rem; font-weight: 600; color: #64748b;
        cursor: pointer; white-space: nowrap; flex-shrink: 0; transition: all 0.25s ease;
    }
    .yr-btn:hover { background: rgba(241,245,249,0.8); color: var(--navy); }
    .yr-btn.active { background: var(--navy); color: var(--gold); font-weight: 800; box-shadow: 0 4px 12px rgba(15,23,42,0.15); }

    /* Search Zone */
    .search-zone { display: flex; align-items: center; gap: 8px; padding-right: 6px; }
    .search-input-wrap { position: relative; display: flex; align-items: center; }
    .search-input-wrap .s-icon { position: absolute; left: 14px; color: #94a3b8; font-size: 0.85rem; pointer-events: none; z-index: 2; }
    .search-input {
        width: 130px; padding: 8px 12px 8px 36px; background: transparent; border: 1px solid transparent; border-radius: 50px;
        font-size: 0.8rem; outline: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .search-input::placeholder { color: #94a3b8; }
    .search-input:focus { width: 180px; background: #f8fafc; border-color: #e2e8f0; }
    .count-badge {
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--gold); color: white; border-radius: 50px; padding: 0 12px; height: 30px;
        font-size: 0.7rem; font-weight: 900; font-family: var(--bt-font-display, 'Oswald', sans-serif);
        box-shadow: 0 4px 10px rgba(197,160,89,0.3);
    }

    @media (max-width: 1024px) {
        .sub-filter-inner { border-radius: 24px; padding: 12px; flex-wrap: wrap; justify-content: center; }
        .year-timeline { border: none; max-width: 100%; order: 3; padding: 4px 0; }
        .search-zone { padding-right: 0; }
    }
    @media (max-width: 768px) {
        .filter-bar-track { padding: 3px; }
        .filter-pill { padding: 7px 13px; font-size: 0.72rem; }
        .filter-bar-inner { padding: 10px 0.75rem; }
    }

    /* ── Event Cards Grid ── */
    .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 2.5rem; padding: 2rem 0 6rem; }
    .event-card {
        background: #ffffff; border: 1px solid var(--border); border-radius: 20px; overflow: hidden;
        display: flex; flex-direction: column; transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1); box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        position: relative;
    }
    .event-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1); border-color: rgba(197, 160, 89, 0.4); }
    .event-img-wrapper { height: 260px; position: relative; overflow: hidden; background: var(--navy); }
    .event-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
    .event-card:hover .event-img { transform: scale(1.08); }
    .event-category-badge {
        position: absolute; top: 1.25rem; left: 1.25rem; background: rgba(15, 23, 42, 0.85); color: var(--gold); padding: 6px 16px;
        border: 1px solid rgba(197, 160, 89, 0.4); border-radius: 50px; font-family: var(--bt-font-display, 'Oswald', sans-serif);
        font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; z-index: 10;
        backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .event-content { padding: 2.5rem 2rem 2rem; display: flex; flex-direction: column; flex: 1; }
    .event-title { font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: 1.5rem; font-weight: 800; color: var(--navy); line-height: 1.3; margin-bottom: 1rem; transition: color 0.3s ease; }
    .event-card:hover .event-title { color: var(--gold); }
    .event-desc { color: #475569; font-weight: 500; font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem; flex: 1; }
    
    .event-footer {
        border-top: 1px solid var(--surface); padding-top: 1.25rem; margin-top: auto; display: flex;
        justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 800;
        color: var(--navy); text-transform: uppercase; letter-spacing: 0.08em;
    }
    .footer-col { display: flex; align-items: center; gap: 8px; }
    .footer-col i { color: var(--gold); font-size: 1.1rem; }

    /* ── Curated Sectioned Hub Styling ── */
    .curated-section { margin-bottom: 6rem; padding: 3rem 0; border-bottom: 1px solid var(--border); }
    .curated-section:last-of-type { border-bottom: none; }
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem; }

    /* ── Horizontal scroll row for curated category sections ────── */
    .curated-row { position: relative; }
    .curated-track {
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: 100%;
        gap: 2rem;
        overflow-x: auto;
        overflow-y: visible;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        scrollbar-width: none;            /* Firefox */
        -ms-overflow-style: none;         /* IE/Edge legacy */
        padding-bottom: 0.5rem;           /* room for card shadow */
    }
    .curated-track::-webkit-scrollbar { display: none; }   /* Webkit */
    .curated-track > .event-card { scroll-snap-align: start; }

    @media (min-width: 768px) {
        .curated-track { grid-auto-columns: calc((100% - 4rem) / 3); }
    }

    .curated-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--gold);
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(40, 30, 20, 0.18);
        transition: opacity 0.22s ease, transform 0.22s ease, background 0.22s ease;
        opacity: 0.92;
    }
    .curated-arrow:hover { background: var(--bt-gold-hover, #b08d47); transform: translateY(-50%) scale(1.06); opacity: 1; }
    .curated-arrow:disabled { opacity: 0.25; cursor: not-allowed; pointer-events: none; }
    .curated-arrow--left  { left: -16px; }
    .curated-arrow--right { right: -16px; }
    @media (max-width: 640px) {
        .curated-arrow { display: none; }   /* mobile users just swipe */
    }
    .section-header-title { font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: 2rem; font-weight: 700; color: var(--navy); text-transform: uppercase; display: flex; align-items: center; gap: 12px; }
    .section-header-title span { color: var(--gold); font-size: 2.4rem; }
    .section-header-meta { font-size: 0.75rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; margin-top: 4px; }

    /* ── Cinematic Category Banner ── */
    .category-hero-banner {
        background: linear-gradient(135deg, var(--navy) 0%, #1e293b 100%); border-radius: 20px; margin-bottom: 3rem;
        padding: 3rem 3.5rem; position: relative; overflow: hidden; border: 1px solid rgba(197, 160, 89, 0.15); box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    }
    .category-hero-banner::before {
        content: ''; position: absolute; top: -50%; right: -10%; width: 400px; height: 400px; border-radius: 50%;
        background: radial-gradient(circle, rgba(197, 160, 89, 0.08) 0%, transparent 70%); pointer-events: none;
    }
    .category-hero-banner::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0;
        height: 1px; background: linear-gradient(90deg, transparent, rgba(197, 160, 89, 0.4), transparent);
    }
    .cat-banner-eyebrow {
        font-size: 0.7rem; font-weight: 900; color: var(--gold);
        text-transform: uppercase; letter-spacing: 0.35em; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;
    }
    .cat-banner-eyebrow::after { content: ''; flex: 1; max-width: 60px; height: 1px; background: var(--gold); opacity: 0.5; }
    .cat-banner-title {
        font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800;
        color: #ffffff; text-transform: uppercase; line-height: 1.1; margin-bottom: 1rem;
    }
    .cat-banner-title em { color: var(--gold); font-style: normal; }
    .cat-banner-desc { color: rgba(255,255,255,0.55); font-size: 0.95rem; line-height: 1.7; max-width: 600px; }
    .cat-banner-icon { position: absolute; right: 3rem; top: 50%; transform: translateY(-50%); font-size: clamp(4rem, 8vw, 7rem); opacity: 0.06; pointer-events: none; filter: grayscale(1); }

    /* ── Staggered Card Enter Animation ── */
    @keyframes cardEnter {
        from { opacity: 0; transform: translateY(24px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .events-grid .event-card { animation: cardEnter 0.5s cubic-bezier(0.165,0.84,0.44,1) both; }
    .events-grid .event-card:nth-child(2) { animation-delay: 0.05s; }
    .events-grid .event-card:nth-child(3) { animation-delay: 0.1s; }
    .events-grid .event-card:nth-child(4) { animation-delay: 0.15s; }
    .events-grid .event-card:nth-child(5) { animation-delay: 0.2s; }
    .events-grid .event-card:nth-child(6) { animation-delay: 0.25s; }
    .events-grid .event-card:nth-child(n+7) { animation-delay: 0.3s; }

    .gallery-overlay {
        position: absolute; inset: 0; background: rgba(15, 23, 42, 0.6); display: flex; flex-direction: column;
        align-items: center; justify-content: center; opacity: 0; transition: all 0.4s ease; z-index: 5; pointer-events: none;
    }
    .event-card:hover .gallery-overlay, .intern-card:hover .gallery-overlay, .year-card:hover .gallery-overlay { opacity: 1; backdrop-filter: blur(4px); }

    /* ── Internship Cohort & Year Cards ── */
    .intern-card { background: #ffffff; border: 1px solid var(--border); border-radius: 20px; overflow: hidden; transition: all 0.5s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
    .intern-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1); border-color: rgba(197, 160, 89, 0.4); }
    .year-card { background: #ffffff; border: 1px solid var(--border); border-radius: 20px; overflow: hidden; transition: all 0.5s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.02); cursor: pointer; text-align: center; padding: 4rem 2rem; position: relative; }
    .year-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1); border-color: rgba(197, 160, 89, 0.4); }
    .year-title { font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: 4.5rem; font-weight: 800; color: var(--navy); margin-bottom: 0.5rem; transition: color 0.3s ease; line-height: 1; }
    .year-card:hover .year-title { color: var(--gold); }
    .year-subtitle { color: #64748b; font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.2em; }

    /* Utility Empty State */
    .empty-state-wrapper { text-align: center; padding: 6rem 1rem; }
    .empty-state-icon { font-size: 5rem; color: rgba(197, 160, 89, 0.3); margin-bottom: 1.5rem; }
    .empty-state-title { font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: 2rem; color: var(--navy); font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem; }
    .empty-state-desc { color: #64748b; font-size: 1rem; max-width: 400px; margin: 0 auto; line-height: 1.6; }

    /* Add reveal animation classes dynamically missing from original code */
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
</style>
@endpush

@section('content')
<div class="bt-wrapper bg-slate-50/50" x-data="cultureHub({ activeCategory: '{{ $category ?? 'all' }}' })">
    
    {{-- ── 1. BREATHTAKING HERO SECTION ── --}}
    <header class="culture-hero">
        <div class="culture-hero-bg"></div>
        <div class="relative z-10 reveal">
            <span class="culture-hero-badge">Builtech People &amp; Culture</span>
            <h1 class="culture-hero-title">Staff <br><span>Activities.</span></h1>
            <p class="culture-hero-desc">Discover the vibrant atmosphere, elite engineering synergy, and collective achievements behind Malaysia's premier Grade G7 contractor team.</p>
        </div>
    </header>

    {{-- ── 2. DUAL PERSPECTIVE CULTURE PILLARS ── --}}
    <section class="culture-pillars-section">
        <div class="bt-container">
            <div class="text-center mb-16 reveal">
                <span class="text-gold font-bold uppercase tracking-[0.3em] text-xs block mb-3">Our Core Philosophy</span>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-navy uppercase">Building Excellence Through <span class="text-gold">Our People</span></h2>
                <p class="text-slate-500 max-w-2xl mx-auto mt-4">Whether you are a prospective client seeking a reliable engineering partner or an ambitious professional looking for a thriving workplace, our culture reflects absolute commitment, safety, and camaraderie.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="pillar-card reveal" data-delay="100">
                    <div class="pillar-icon"><i class="fa-solid fa-helmet-safety"></i></div>
                    <h3 class="pillar-title">Professional Mastery</h3>
                    <p class="pillar-desc">Continuous CIDB G7 safety audits, technical upskilling, and rigorous site management training. We ensure our workforce remains at the absolute cutting edge of industrial construction standards.</p>
                </div>
                <div class="pillar-card reveal" data-delay="200">
                    <div class="pillar-icon"><i class="fa-solid fa-champagne-glasses"></i></div>
                    <h3 class="pillar-title">Vibrant Atmosphere</h3>
                    <p class="pillar-desc">From festive gala dinners and team-building expeditions to after-work sports and cultural celebrations, we foster genuine family camaraderie and celebrate every milestone together.</p>
                </div>
                <div class="pillar-card reveal" data-delay="300">
                    <div class="pillar-icon"><i class="fa-solid fa-user-graduate"></i></div>
                    <h3 class="pillar-title">Nurturing Talent</h3>
                    <p class="pillar-desc">Our structured internship cohorts and community CSR initiatives empower the next generation of engineers, providing hands-on mentorship in managing multi-million Ringgit landmarks.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── 3. MASTER STICKY CONTROL PANEL ── --}}
    <div class="master-filter-container">

        {{-- ═══ TOP: FLOATING SEGMENTED NAV ═══ --}}
        <div class="filter-bar-inner" @click.away="openDropdown = null">
            <div class="filter-bar-track">

                {{-- ALL HUB --}}
                <div class="filter-cat-item">
                    <button @click="setCategory('all'); openDropdown = null" @mouseenter="openDropdown = null" :class="{ 'active': activeCat === 'all' }" class="filter-pill" aria-label="View All Hubs">
                        <i class="fa-solid fa-layer-group pill-emoji" style="font-size:0.9rem;"></i> All Hub
                    </button>
                </div>

                {{-- TEAM BUILDING --}}
                @if(isset($latestPerCategory['tb']) && $latestPerCategory['tb']->isNotEmpty())
                <div class="filter-cat-item">
                    <button @click="setCategory('tb'); openDropdown = null" @mouseenter="openDropdown = null" :class="{ 'active': activeCat === 'tb' }" class="filter-pill" aria-label="Team Building">
                        <span class="pill-emoji">👥</span> Team Building
                    </button>
                </div>
                @endif

                {{-- TRAINING --}}
                @if(isset($latestPerCategory['work']) && $latestPerCategory['work']->isNotEmpty())
                <div class="filter-cat-item" @mouseenter="handleMouseEnter('work')" @mouseleave="handleMouseLeave()">
                    <button @click="toggleDropdown('work')" :class="{ 'active': activeCat === 'work' }" class="filter-pill" :aria-expanded="openDropdown === 'work'">
                        <span class="pill-emoji">🏗️</span> Training <i class="fa-solid fa-chevron-down pill-chevron" :class="{ 'chevron-open': openDropdown === 'work' }"></i>
                    </button>
                    <div class="filter-dropdown" :class="{ 'is-open': openDropdown === 'work' }">
                        <div class="dropdown-header">Training Type</div>
                        <button class="dropdown-all-item" @click="setCategory('work'); setSubCat('all');"><i class="fa-solid fa-star"></i> All Training</button>
                        <button x-cloak x-show="hasSubCat('work', 'safety')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='safety' }" @click="setCategory('work'); setSubCat('safety');"><span class="sub-emoji">⛑️</span> Safety & HSE</button>
                        <button x-cloak x-show="hasSubCat('work', 'seminar')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='seminar' }" @click="setCategory('work'); setSubCat('seminar');"><span class="sub-emoji">📚</span> Seminars & Courses</button>
                        <button x-cloak x-show="hasSubCat('work', 'training')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='training' }" @click="setCategory('work'); setSubCat('training');"><span class="sub-emoji">🖥️</span> Internal Training</button>
                        <button x-cloak x-show="hasSubCat('work', 'talk')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='talk' }" @click="setCategory('work'); setSubCat('talk');"><span class="sub-emoji">🎤</span> Talks & Sharing</button>
                        <button x-cloak x-show="hasSubCat('work', 'audit')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='audit' }" @click="setCategory('work'); setSubCat('audit');"><span class="sub-emoji">📋</span> Audits & Inspections</button>
                        <button x-cloak x-show="hasSubCat('work', 'certification')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='certification' }" @click="setCategory('work'); setSubCat('certification');"><span class="sub-emoji">📜</span> Certifications</button>
                        <button x-cloak x-show="hasSubCat('work', 'sports')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='sports' }" @click="setCategory('work'); setSubCat('sports');"><span class="sub-emoji">🏆</span> Sports Tournaments</button>
                        <button x-cloak x-show="hasSubCat('work', 'award')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='award' }" @click="setCategory('work'); setSubCat('award');"><span class="sub-emoji">🏅</span> Awards</button>
                        <button x-cloak x-show="hasSubCat('work', 'other_work')" class="dropdown-item" :class="{ active: activeCat==='work' && activeSubCat==='other_work' }" @click="setCategory('work'); setSubCat('other_work');"><span class="sub-emoji">📂</span> Others</button>
                    </div>
                </div>
                @endif

                {{-- TRIPS --}}
                @if(isset($latestPerCategory['trip']) && $latestPerCategory['trip']->isNotEmpty())
                <div class="filter-cat-item">
                    <button @click="setCategory('trip'); setSubCat('company_trip'); openDropdown = null" @mouseenter="openDropdown = null" :class="{ 'active': activeCat === 'trip' }" class="filter-pill">
                        <span class="pill-emoji">✈️</span> Company Trip
                    </button>
                </div>
                @endif

                {{-- CSR --}}
                @if(isset($latestPerCategory['csr']) && $latestPerCategory['csr']->isNotEmpty())
                <div class="filter-cat-item" @mouseenter="handleMouseEnter('csr')" @mouseleave="handleMouseLeave()">
                    <button @click="toggleDropdown('csr')" :class="{ 'active': activeCat === 'csr' }" class="filter-pill" :aria-expanded="openDropdown === 'csr'">
                        <span class="pill-emoji">🤝</span> CSR <i class="fa-solid fa-chevron-down pill-chevron" :class="{ 'chevron-open': openDropdown === 'csr' }"></i>
                    </button>
                    <div class="filter-dropdown" :class="{ 'is-open': openDropdown === 'csr' }">
                        <div class="dropdown-header">CSR Programme</div>
                        <button class="dropdown-all-item" @click="setCategory('csr'); setSubCat('all');"><i class="fa-solid fa-star"></i> All CSR Activities</button>
                        <button x-cloak x-show="hasSubCat('csr', 'charity')" class="dropdown-item" :class="{ active: activeCat==='csr' && activeSubCat==='charity' }" @click="setCategory('csr'); setSubCat('charity');"><span class="sub-emoji">❤️</span> Charity & Donation</button>
                        <button x-cloak x-show="hasSubCat('csr', 'community')" class="dropdown-item" :class="{ active: activeCat==='csr' && activeSubCat==='community' }" @click="setCategory('csr'); setSubCat('community');"><span class="sub-emoji">🏘️</span> Community Service</button>
                        <button x-cloak x-show="hasSubCat('csr', 'education')" class="dropdown-item" :class="{ active: activeCat==='csr' && activeSubCat==='education' }" @click="setCategory('csr'); setSubCat('education');"><span class="sub-emoji">📖</span> Education Support</button>
                        <button x-cloak x-show="hasSubCat('csr', 'environment')" class="dropdown-item" :class="{ active: activeCat==='csr' && activeSubCat==='environment' }" @click="setCategory('csr'); setSubCat('environment');"><span class="sub-emoji">🌱</span> Environmental</button>
                    </div>
                </div>
                @endif

                {{-- FESTIVE --}}
                @if(isset($latestPerCategory['festive']) && $latestPerCategory['festive']->isNotEmpty())
                <div class="filter-cat-item" @mouseenter="handleMouseEnter('festive')" @mouseleave="handleMouseLeave()">
                    <button @click="toggleDropdown('festive')" :class="{ 'active': activeCat === 'festive' }" class="filter-pill" :aria-expanded="openDropdown === 'festive'">
                        <span class="pill-emoji">🎊</span> Festive <i class="fa-solid fa-chevron-down pill-chevron" :class="{ 'chevron-open': openDropdown === 'festive' }"></i>
                    </button>
                    <div class="filter-dropdown" :class="{ 'is-open': openDropdown === 'festive' }">
                        <div class="dropdown-header">Select Occasion</div>
                        <button class="dropdown-all-item" @click="setCategory('festive'); setSubCat('all');"><i class="fa-solid fa-star"></i> All Festive Events</button>
                        <button x-cloak x-show="hasSubCat('festive', 'annual_dinner')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='annual_dinner' }" @click="setCategory('festive'); setSubCat('annual_dinner');"><span class="sub-emoji">🍽️</span> Annual Dinner</button>
                        <button x-cloak x-show="hasSubCat('festive', 'cny')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='cny' }" @click="setCategory('festive'); setSubCat('cny');"><span class="sub-emoji">🧧</span> Chinese New Year</button>
                        <button x-cloak x-show="hasSubCat('festive', 'raya')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='raya' }" @click="setCategory('festive'); setSubCat('raya');"><span class="sub-emoji">🌙</span> Hari Raya</button>
                        <button x-cloak x-show="hasSubCat('festive', 'mid_autumn')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='mid_autumn' }" @click="setCategory('festive'); setSubCat('mid_autumn');"><span class="sub-emoji">🏮</span> Mid-Autumn</button>
                        <button x-cloak x-show="hasSubCat('festive', 'dumpling')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='dumpling' }" @click="setCategory('festive'); setSubCat('dumpling');"><span class="sub-emoji">🥟</span> Dumpling Festival</button>
                        <button x-cloak x-show="hasSubCat('festive', 'durian')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='durian' }" @click="setCategory('festive'); setSubCat('durian');"><span class="sub-emoji">🍑</span> Durian Party</button>
                        <button x-cloak x-show="hasSubCat('festive', 'christmas')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='christmas' }" @click="setCategory('festive'); setSubCat('christmas');"><span class="sub-emoji">🎄</span> Christmas</button>
                        <button x-cloak x-show="hasSubCat('festive', 'birthday')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='birthday' }" @click="setCategory('festive'); setSubCat('birthday');"><span class="sub-emoji">🎂</span> Birthdays</button>
                        <button x-cloak x-show="hasSubCat('festive', 'solstice')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='solstice' }" @click="setCategory('festive'); setSubCat('solstice');"><span class="sub-emoji">❄️</span> Winter Solstice</button>
                        <button x-cloak x-show="hasSubCat('festive', 'others')" class="dropdown-item" :class="{ active: activeCat==='festive' && activeSubCat==='others' }" @click="setCategory('festive'); setSubCat('others');"><span class="sub-emoji">🎉</span> Others</button>
                    </div>
                </div>
                @endif

                {{-- EVENTS --}}
                @if(isset($latestPerCategory['event']) && $latestPerCategory['event']->isNotEmpty())
                <div class="filter-cat-item" @mouseenter="handleMouseEnter('event')" @mouseleave="handleMouseLeave()">
                    <button @click="toggleDropdown('event')" :class="{ 'active': activeCat === 'event' }" class="filter-pill" :aria-expanded="openDropdown === 'event'">
                        <span class="pill-emoji">📸</span> Events <i class="fa-solid fa-chevron-down pill-chevron" :class="{ 'chevron-open': openDropdown === 'event' }"></i>
                    </button>
                    <div class="filter-dropdown" :class="{ 'is-open': openDropdown === 'event' }">
                        <div class="dropdown-header">Event Type</div>
                        <button class="dropdown-all-item" @click="setCategory('event'); setSubCat('all');"><i class="fa-solid fa-star"></i> All Events</button>
                        <button x-cloak x-show="hasSubCat('event', 'sponsorship')" class="dropdown-item" :class="{ active: activeCat==='event' && activeSubCat==='sponsorship' }" @click="setCategory('event'); setSubCat('sponsorship');"><span class="sub-emoji">💰</span> Sponsorship</button>
                        <button x-cloak x-show="hasSubCat('event', 'award')" class="dropdown-item" :class="{ active: activeCat==='event' && activeSubCat==='award' }" @click="setCategory('event'); setSubCat('award');"><span class="sub-emoji">🏅</span> Awards Ceremony</button>
                        <button x-cloak x-show="hasSubCat('event', 'conference')" class="dropdown-item" :class="{ active: activeCat==='event' && activeSubCat==='conference' }" @click="setCategory('event'); setSubCat('conference');"><span class="sub-emoji">🎤</span> Conference</button>
                        <button x-cloak x-show="hasSubCat('event', 'exhibition')" class="dropdown-item" :class="{ active: activeCat==='event' && activeSubCat==='exhibition' }" @click="setCategory('event'); setSubCat('exhibition');"><span class="sub-emoji">🎪</span> Exhibition</button>
                    </div>
                </div>
                @endif

                {{-- INTERNSHIP --}}
                @if(isset($latestPerCategory['intern']) && $latestPerCategory['intern']->isNotEmpty())
                <div class="filter-cat-item">
                    <button @click="setCategory('intern'); openDropdown = null" @mouseenter="openDropdown = null" :class="{ 'active': activeCat === 'intern' }" class="filter-pill">
                        <span class="pill-emoji">🎓</span> Internship
                    </button>
                </div>
                @endif

            </div>{{-- end .filter-bar-track --}}
        </div>{{-- end .filter-bar-inner --}}

        {{-- ═══ BOTTOM: FLOATING PILL TOOLBAR (2026 DESIGN) ═══ --}}
        <div class="sub-filter-bar" x-cloak x-show="activeCat !== 'all'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="sub-filter-inner">

                {{-- ── Active Sub-Category Chip ── --}}
                <div class="ctx-label" x-cloak x-show="activeSubCat !== 'all'">
                    <span class="cmd-chip-sub">
                        <span x-text="getSubCatLabel()"></span>
                        <button @click="activeSubCat = 'all'" class="cmd-clear-inline" title="Clear Sub-category" aria-label="Clear filter">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </span>
                </div>
                
                <div x-cloak x-show="activeSubCat !== 'all'" style="width:1px; height:24px; background:rgba(226,232,240,0.8); margin:0 4px;"></div>

                {{-- ── Year Timeline Strip ── --}}
                <div class="year-timeline" x-cloak x-show="activeCat !== 'all' && activeCat !== 'intern' && getYearsForActiveCategory().length > 0">
                    <button @click="activeYear = 'all'"
                            :class="{ 'active': activeYear === 'all' }"
                            class="yr-btn">
                        ALL
                    </button>
                    <template x-for="(year, index) in getYearsForActiveCategory()" :key="year">
                        <button x-show="index < 4 || showAllYears || activeYear === year" 
                                @click="activeYear = year"
                                :class="{ 'active': activeYear === year }"
                                class="yr-btn"
                                x-text="year">
                        </button>
                    </template>
                    <button x-cloak x-show="getYearsForActiveCategory().length > 4" 
                            @click="showAllYears = !showAllYears" 
                            class="yr-btn" 
                            style="font-size: 0.65rem; font-weight: 800; padding: 6px 8px; margin-left: 2px; color: var(--gold);">
                        <span x-text="showAllYears ? 'LESS ▴' : 'OLDER ▾'"></span>
                    </button>
                </div>

                <div x-cloak x-show="activeCat !== 'all' && activeCat !== 'intern' && getYearsForActiveCategory().length > 0" style="width:1px; height:24px; background:rgba(226,232,240,0.8); margin:0 4px;"></div>

                {{-- ── Search Zone ── --}}
                <div class="search-zone">
                    <div class="search-input-wrap">
                        <i class="fa-solid fa-magnifying-glass s-icon"></i>
                        <input type="text"
                               x-model="searchQuery"
                               placeholder="Search..."
                               class="search-input"
                               id="hub-search-input"
                               @keydown.escape="searchQuery = ''"
                               x-ref="searchInput">
                    </div>
                    <button x-cloak x-show="searchQuery.trim() !== ''" @click="searchQuery = ''" class="cmd-clear-inline mr-1" aria-label="Clear Search">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <div class="count-badge" title="Matching Records">
                        <span x-text="filteredCount"></span>
                    </div>
                    {{-- Reset-everything button: visible only when at least one filter is active --}}
                    <button x-cloak
                            x-show="activeCat !== 'all' || activeSubCat !== 'all' || activeYear !== 'all' || searchQuery.trim() !== ''"
                            x-transition.opacity
                            @click="resetAllFilters()"
                            class="cmd-clear-inline ml-2"
                            title="Reset all filters"
                            aria-label="Reset all filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                </div>

            </div>
        </div>

    </div>{{-- end .master-filter-container --}}

    {{-- ── 4. DYNAMIC EVENTS SHOWCASE ── --}}
    <section class="bt-container min-h-[500px] py-16">
        
        {{-- ALERTS: Empty State --}}
        <div x-cloak x-show="filteredCount === 0" class="empty-state-wrapper reveal">
            <i class="fa-solid fa-box-open empty-state-icon"></i>
            <h3 class="empty-state-title">No Records Found</h3>
            <p class="empty-state-desc">We couldn't find any activities matching your current filters or search query. Try clearing your filters to see more results.</p>
            <button @click="setCategory('all')" class="mt-6 bt-btn bt-btn-primary px-8 py-3 rounded-full uppercase tracking-widest text-xs font-bold inline-flex items-center gap-2">
                <i class="fa-solid fa-rotate-left"></i> Reset View
            </button>
        </div>

        {{-- VIEW A: CURATED CATEGORY HUB (Shown when activeCat === 'all' & searchQuery === '') --}}
        <div x-cloak x-show="activeCat === 'all' && searchQuery.trim() === '' && filteredCount > 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            @php
            $catMoods = [
                'tb'      => ['tagline' => 'Where bonds are forged beyond the boardroom.', 'color' => '#f59e0b'],
                'work'    => ['tagline' => 'Sharpening excellence through relentless learning.', 'color' => '#3b82f6'],
                'trip'    => ['tagline' => 'Adventures that unite us as one team.', 'color' => '#10b981'],
                'csr'     => ['tagline' => 'Giving back to the communities we serve.', 'color' => '#ef4444'],
                'festive' => ['tagline' => 'Celebrating the spirit of togetherness.', 'color' => '#8b5cf6'],
                'event'   => ['tagline' => 'Milestones that define our legacy.', 'color' => '#c5a059'],
                'intern'  => ['tagline' => 'Nurturing the next generation of engineers.', 'color' => '#06b6d4'],
            ];
            @endphp
            
            @if(isset($categoryConfig) && is_array($categoryConfig))
                @foreach($categoryConfig as $catKey => $cat)
                    @php
                        $previewItems = $latestPerCategory[$catKey] ?? collect();
                        $mood = $catMoods[$catKey] ?? ['tagline' => 'Building excellence together.', 'color' => '#c5a059'];
                    @endphp
                    @if($previewItems->isNotEmpty())
                        <div class="curated-section reveal">
                            <div class="section-header">
                                <div>
                                    <h2 class="section-header-title"><span>{{ $cat['icon'] }}</span> {{ $cat['label'] }}</h2>
                                    <p class="section-header-meta" style="color: {{ $mood['color'] }}; opacity: 0.85;">{{ $mood['tagline'] }}</p>
                                </div>
                                <button @click="setCategory('{{ $catKey }}')" class="bt-btn bg-white border border-slate-200 text-navy hover:bg-navy hover:border-navy hover:text-gold inline-flex items-center gap-2 px-6 py-2.5 rounded-full font-bold uppercase tracking-widest text-xs transition-all duration-300 group shadow-sm hover:shadow-md">
                                    View Full Archive <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                                </button>
                            </div>

                            {{-- Netflix-style horizontal scroll row. Cards keep ~33% width on
                                 desktop and stay visible; arrows slide by one viewport width.
                                 'View Full Archive' button (top-right) still exists for full grid. --}}
                            <div class="curated-row" data-curated-row>
                                <button type="button"
                                        class="curated-arrow curated-arrow--left"
                                        aria-label="Scroll left"
                                        data-curated-prev
                                        x-cloak
                                        x-show="false"
                                        x-init="$el.style.display = ''">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                                <div class="curated-track" data-curated-track>
                                @foreach($previewItems as $event)
                                    @php
                                        $dateStr = $event->event_date ? $event->event_date->format('d/m/Y') : ($event->year ? '15/06/' . $event->year : '12/02/2026');

                                        $lightboxImage = $event->hasMedia('culture_image')
                                            ? $event->getFirstMediaUrl('culture_image')
                                            : ($event->displayImage ?? '#');

                                        // Video resolution: uploaded MP4 (R2) takes priority over external URL.
                                        $videoUrl  = null;
                                        $videoType = null;
                                        if (! empty($event->video_upload)) {
                                            $videoUrl  = \Illuminate\Support\Facades\Storage::disk('public')->url($event->video_upload);
                                            $videoType = 'video';
                                        } elseif (! empty($event->video_url)) {
                                            $videoUrl  = $event->video_url;
                                            // glightbox auto-detects YouTube / Vimeo from URL
                                        }
                                        $hasVideo  = $videoUrl !== null;
                                        $mainHref  = $hasVideo ? $videoUrl : $lightboxImage;
                                    @endphp
                                    <article class="event-card reveal">
                                        <div class="event-img-wrapper">
                                            <span class="event-category-badge">{{ $cat['icon'] }} {{ $cat['label'] }}</span>
                                            <a href="{{ $mainHref }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}" @if($videoType) data-type="{{ $videoType }}" @endif>
                                                <div class="gallery-overlay">
                                                    @if($hasVideo)
                                                        <i class="fa-solid fa-circle-play text-5xl text-white mb-2"></i>
                                                        <span class="text-white font-bold tracking-widest text-xs uppercase mt-2">Play Video</span>
                                                    @else
                                                        <i class="fa-solid fa-expand text-3xl text-white mb-2"></i>
                                                        <span class="text-white font-bold tracking-widest text-xs uppercase mt-2">Open Gallery</span>
                                                    @endif
                                                </div>
                                                <img src="{{ $event->displayImage ?? '#' }}" alt="{{ $event->title }}" class="event-img" loading="lazy" decoding="async" width="800" height="600">
                                            </a>
                                            <div class="hidden" style="display:none;">
                                                {{-- If the card opened a video, also surface the cover photo inside the lightbox gallery --}}
                                                @if($hasVideo && $lightboxImage !== '#')
                                                    <a href="{{ $lightboxImage }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}"></a>
                                                @endif
                                                @foreach($event->getMedia('gallery') as $media)
                                                    <a href="{{ $media->getUrl() }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}"></a>
                                                @endforeach
                                                @if(is_array($event->gallery_uploads))
                                                    @foreach($event->gallery_uploads as $path)
                                                        <a href="{{ cdn_rewrite(asset('storage/' . ltrim($path, '/'))) }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}"></a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="event-content">
                                            <h3 class="event-title">{{ $event->title }}</h3>
                                            <p class="event-desc">{{ Str::limit($event->description ?: 'Building engineering excellence and team unity across Builtech operations.', 110) }}</p>
                                            <div class="event-footer">
                                                <div class="footer-col"><i class="fa-solid fa-map-pin"></i><span>{{ $event->location ?? 'Penang, Malaysia' }}</span></div>
                                                <div class="footer-col"><i class="fa-solid fa-calendar-days"></i><span>{{ $dateStr }}</span></div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                                </div> {{-- /.curated-track --}}
                                <button type="button"
                                        class="curated-arrow curated-arrow--right"
                                        aria-label="Scroll right"
                                        data-curated-next>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div> {{-- /.curated-row --}}
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        {{-- VIEW B: STANDARD EVENTS GRID (Shown when activeCat !== 'all' & activeCat !== 'intern', OR when searching) --}}
        <div x-cloak x-show="((activeCat !== 'all' && activeCat !== 'intern') || (activeCat === 'all' && searchQuery.trim() !== '')) && filteredCount > 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="events-grid">
                @if(isset($allEvents))
                    @forelse($allEvents as $event)
                        @php
                            $catKey = $event->normalized_category ?? 'event';
                            $catData = $categoryConfig[$catKey] ?? ['label' => ucfirst($catKey), 'icon' => '📸'];
                            $dateStr = $event->event_date ? $event->event_date->format('d/m/Y') : ($event->year ? '15/06/' . $event->year : '12/02/2026');
                            $lightboxImage = $event->hasMedia('culture_image')
                                ? $event->getFirstMediaUrl('culture_image')
                                : ($event->displayImage ?? '#');

                            // Video resolution: uploaded MP4 (R2) takes priority over external URL.
                            $videoUrl  = null;
                            $videoType = null;
                            if (! empty($event->video_upload)) {
                                $videoUrl  = \Illuminate\Support\Facades\Storage::disk('public')->url($event->video_upload);
                                $videoType = 'video';
                            } elseif (! empty($event->video_url)) {
                                $videoUrl  = $event->video_url;
                            }
                            $hasVideo = $videoUrl !== null;
                            $mainHref = $hasVideo ? $videoUrl : $lightboxImage;
                        @endphp
                        <article class="event-card reveal"
                                 data-category="{{ $catKey }}"
                                 data-subcategory="{{ strtolower(trim($event->subCategory?->slug ?? '')) }}"
                                 data-title="{{ strtolower($event->title ?? '') }}"
                                 data-location="{{ strtolower($event->location ?? 'penang') }}"
                                 data-year="{{ $event->year ?? ($event->event_date ? $event->event_date->format('Y') : '') }}">

                            <div class="event-img-wrapper">
                                <span class="event-category-badge">{{ $catData['icon'] }} {{ $catData['label'] }}</span>
                                @if($hasVideo)
                                    <span class="event-category-badge" style="top: auto; bottom: 14px; right: 14px; left: auto; background: rgba(0,0,0,0.78); color: #fff;"><i class="fa-solid fa-circle-play"></i> Video</span>
                                @endif
                                <a href="{{ $mainHref }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}" @if($videoType) data-type="{{ $videoType }}" @endif>
                                    <div class="gallery-overlay">
                                        @if($hasVideo)
                                            <i class="fa-solid fa-circle-play text-5xl text-white mb-2"></i>
                                            <span class="text-white font-bold tracking-widest text-xs uppercase mt-2">Play Video</span>
                                        @else
                                            <i class="fa-solid fa-images text-4xl text-white mb-2"></i>
                                            <span class="text-white font-bold tracking-widest text-xs uppercase mt-2">View Photo</span>
                                        @endif
                                    </div>
                                    <img src="{{ $event->displayImage ?? '#' }}" alt="{{ $event->title }}" class="event-img" loading="lazy" decoding="async" width="800" height="600">
                                </a>
                                <div class="hidden" style="display:none;">
                                    {{-- If the card opened a video, also surface the cover photo + gallery inside the lightbox --}}
                                    @if($hasVideo && $lightboxImage !== '#')
                                        <a href="{{ $lightboxImage }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}"></a>
                                    @endif
                                    @foreach($event->getMedia('gallery') as $media)
                                        <a href="{{ $media->getUrl() }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}"></a>
                                    @endforeach
                                    @if(is_array($event->gallery_uploads))
                                        @foreach($event->gallery_uploads as $path)
                                            <a href="{{ cdn_rewrite(asset('storage/' . ltrim($path, '/'))) }}" class="glightbox" data-gallery="event-{{ $event->id }}" data-title="{{ $event->title }}"></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="event-content">
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <p class="event-desc">{{ Str::limit($event->description ?: 'Building engineering excellence and team unity across Builtech operations.', 120) }}</p>
                                <div class="event-footer">
                                    <div class="footer-col"><i class="fa-solid fa-map-pin"></i><span>{{ $event->location ?? 'Penang, Malaysia' }}</span></div>
                                    <div class="footer-col"><i class="fa-solid fa-calendar-days"></i><span>{{ $dateStr }}</span></div>
                                </div>
                            </div>
                        </article>
                    @empty
                    @endforelse
                @endif
            </div>
        </div>

        {{-- VIEW C: INTERNSHIP COHORT VIEW (Shown when activeCat === 'intern') --}}
        <div x-cloak x-show="activeCat === 'intern' && filteredCount > 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            @if(isset($internsByYear) && $internsByYear->isNotEmpty())
                
                {{-- STEP 1: YEARS GRID --}}
                <div x-show="!activeInternYear && searchQuery.trim() === ''" x-transition:enter="transition ease-out duration-400 delay-100">
                    {{-- Cinematic Intern Hero --}}
                    <div class="category-hero-banner mt-8 mb-16" style="background: linear-gradient(135deg, rgba(15,23,42,0.85) 0%, rgba(30,41,59,0.95) 100%), url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2000') center/cover no-repeat; background-blend-mode: overlay;">
                        <div class="cat-banner-eyebrow"><span>🎓</span> Internship Programme</div>
                        <h2 class="cat-banner-title">Nurturing the <em>Next Generation</em></h2>
                        <p class="cat-banner-desc">Every cohort that passes through Builtech leaves with more than a resume line — they leave with real-world mastery, mentors, and a network that lasts a lifetime. Select a year to explore a cohort's journey.</p>
                        <div class="cat-banner-icon">🎓</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 pb-12">
                        @foreach($internsByYear->keys() as $year)
                            @php
                                // Real interns = any record with intern_name set
                                // (regardless of whether admin has tagged it Site or
                                // Office yet). Records without intern_name are cohort
                                // group photos (e.g. Internship Farewell) and don't
                                // count. This stays backwards-compatible with every
                                // existing intern record from before intern_type was
                                // introduced.
                                $yearActualCount = $internsByYear[$year]
                                    ->filter(fn ($e) => filled($e->intern_name))
                                    ->count();
                            @endphp
                            <div class="year-card reveal" @click="activeInternYear = '{{ $year }}'; window.scrollTo({ top: document.querySelector('.master-filter-container').offsetTop - 20, behavior: 'smooth' });">
                                <div class="gallery-overlay">
                                    <i class="fa-solid fa-folder-open text-4xl text-white mb-2"></i>
                                    <span class="text-white font-bold tracking-widest text-xs uppercase mt-2">View Cohort</span>
                                </div>
                                <h3 class="year-title">{{ $year }}</h3>
                                <p class="year-subtitle">Internship</p>
                                <div class="mt-8 inline-block bg-navy text-gold text-xs font-bold px-5 py-2.5 rounded-full uppercase tracking-widest shadow-md">
                                    {{ $yearActualCount }} Intern{{ $yearActualCount === 1 ? '' : 's' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 2: SPECIFIC COHORT GRID --}}
                @foreach($internsByYear as $year => $cohort)
                    <div x-cloak x-show="activeInternYear === '{{ $year }}' || (searchQuery.trim() !== '' && filteredCount > 0)" x-transition:enter="transition ease-out duration-300" class="mb-24 intern-cohort-wrapper pt-8" data-title="{{ strtolower($year) }}">
                        
                        <div class="mb-10" x-show="searchQuery.trim() === ''">
                            <button @click="activeInternYear = null" class="bt-btn bg-white border border-slate-200 text-slate-600 hover:border-gold hover:text-gold inline-flex items-center gap-2 px-6 py-2 rounded-full font-bold uppercase tracking-widest text-xs transition shadow-sm">
                                <i class="fa-solid fa-arrow-left"></i> Back to Cohort Years
                            </button>
                        </div>

                        @php
                            // Backward-compatible split:
                            //   - "Real intern"  = any record with intern_name set,
                            //     even if intern_type hasn't been tagged yet.
                            //   - "Cohort highlight" = no intern_name (group photo /
                            //     farewell / event card).
                            //   - intern_type only decides which sub-section a real
                            //     intern appears in: Site / Office / Untagged.
                            // This guarantees that every existing intern record from
                            // before intern_type was introduced keeps showing up and
                            // counting properly while admins gradually tag each one.
                            $cohortHighlight = $cohort->filter(fn ($e) => empty($e->intern_name));
                            $realInterns     = $cohort->filter(fn ($e) => filled($e->intern_name));
                            $siteInterns     = $realInterns->filter(fn ($e) => $e->intern_type === 'site');
                            $officeInterns   = $realInterns->filter(fn ($e) => $e->intern_type === 'office');
                            $untaggedInterns = $realInterns->filter(fn ($e) => empty($e->intern_type));
                            $actualCount     = $realInterns->count();
                        @endphp

                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-12 border-b border-border pb-8">
                            <span class="font-heading text-6xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-b from-gold/30 to-gold/5">{{ $year }}</span>
                            <div class="flex-1">
                                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gold block mb-1">Internship Cohort</span>
                                <h2 class="font-heading text-2xl md:text-3xl font-bold text-navy uppercase">{{ $year }} Programme</h2>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($siteInterns->isNotEmpty())
                                    <div class="bg-white border border-amber-200 rounded-2xl px-5 py-3 text-center shadow-sm">
                                        <span class="font-heading text-xl font-bold text-navy block leading-none">{{ $siteInterns->count() }}</span>
                                        <span class="text-[0.6rem] font-bold uppercase tracking-widest text-amber-600 mt-1 block">Site</span>
                                    </div>
                                @endif
                                @if($officeInterns->isNotEmpty())
                                    <div class="bg-white border border-sky-200 rounded-2xl px-5 py-3 text-center shadow-sm">
                                        <span class="font-heading text-xl font-bold text-navy block leading-none">{{ $officeInterns->count() }}</span>
                                        <span class="text-[0.6rem] font-bold uppercase tracking-widest text-sky-600 mt-1 block">Office</span>
                                    </div>
                                @endif
                                <div class="bg-surface border border-border rounded-2xl px-6 py-3 text-center shadow-sm">
                                    <span class="font-heading text-2xl font-bold text-navy block leading-none">{{ $actualCount }}</span>
                                    <span class="text-[0.6rem] font-bold uppercase tracking-widest text-slate-500 mt-1 block">Total Interns</span>
                                </div>
                            </div>
                        </div>

                        {{-- ── COHORT HIGHLIGHTS (group photos / farewell etc) ── --}}
                        @if($cohortHighlight->isNotEmpty())
                            <div class="mb-14">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="flex items-center gap-3 bg-gold/10 border border-gold/25 rounded-full px-5 py-2">
                                        <i class="fa-solid fa-camera text-gold"></i>
                                        <h3 class="font-heading text-sm font-bold text-navy uppercase tracking-[0.2em]">Cohort Highlights</h3>
                                    </div>
                                    <div class="flex-1 h-px bg-gradient-to-r from-gold/30 to-transparent"></div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                                    @foreach($cohortHighlight as $intern)
                                        @include('partials.intern-card', ['intern' => $intern, 'year' => $year])
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── SITE INTERNS ── --}}
                        @if($siteInterns->isNotEmpty())
                            <div class="mb-14">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 rounded-full px-5 py-2">
                                        <i class="fa-solid fa-helmet-safety text-amber-600"></i>
                                        <h3 class="font-heading text-sm font-bold text-amber-900 uppercase tracking-[0.2em]">Site Interns <span class="text-amber-500 ml-1">· {{ $siteInterns->count() }}</span></h3>
                                    </div>
                                    <div class="flex-1 h-px bg-gradient-to-r from-amber-200 to-transparent"></div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                                    @foreach($siteInterns as $intern)
                                        @include('partials.intern-card', ['intern' => $intern, 'year' => $year])
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── OFFICE INTERNS ── --}}
                        @if($officeInterns->isNotEmpty())
                            <div class="mb-14">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="flex items-center gap-3 bg-sky-50 border border-sky-200 rounded-full px-5 py-2">
                                        <i class="fa-solid fa-building text-sky-600"></i>
                                        <h3 class="font-heading text-sm font-bold text-sky-900 uppercase tracking-[0.2em]">Office Interns <span class="text-sky-500 ml-1">· {{ $officeInterns->count() }}</span></h3>
                                    </div>
                                    <div class="flex-1 h-px bg-gradient-to-r from-sky-200 to-transparent"></div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                                    @foreach($officeInterns as $intern)
                                        @include('partials.intern-card', ['intern' => $intern, 'year' => $year])
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── UNTAGGED INTERNS (legacy records) ──
                             Shows real intern records that haven't been tagged Site
                             or Office yet. Lets the count stay accurate today while
                             editors gradually go through each record and pick the
                             type. Once everything is tagged this section disappears. --}}
                        @if($untaggedInterns->isNotEmpty())
                            <div class="mb-14">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="flex items-center gap-3 bg-slate-100 border border-slate-300 rounded-full px-5 py-2">
                                        <i class="fa-solid fa-user-graduate text-slate-600"></i>
                                        <h3 class="font-heading text-sm font-bold text-slate-700 uppercase tracking-[0.2em]">All Interns <span class="text-slate-500 ml-1">· {{ $untaggedInterns->count() }}</span></h3>
                                    </div>
                                    <div class="flex-1 h-px bg-gradient-to-r from-slate-300 to-transparent"></div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                                    @foreach($untaggedInterns as $intern)
                                        @include('partials.intern-card', ['intern' => $intern, 'year' => $year])
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── Empty state (year truly has no records) ── --}}
                        @if($actualCount === 0 && $cohortHighlight->isEmpty())
                            <div class="text-center py-16 bg-surface rounded-2xl border border-dashed border-border">
                                <i class="fa-solid fa-user-graduate text-gold/40 text-5xl mb-4"></i>
                                <p class="text-slate-500 font-semibold">No interns recorded for {{ $year }} yet.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- ── 5. FINAL CALL TO ACTION ── --}}
    <section class="bg-navy py-24 relative overflow-hidden mt-12">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(197,160,89,0.12),transparent_70%)]"></div>
        {{-- Animated noise texture for depth --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'n\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23n)\'/%3E%3C/svg%3E'); background-size: 200px;"></div>
        <div class="bt-container relative z-10 text-center reveal">
            <div class="inline-flex items-center gap-3 bg-gold/10 border border-gold/25 rounded-full px-5 py-2 mb-6">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                <span class="text-gold font-bold uppercase tracking-[0.3em] text-xs">We Are Hiring</span>
            </div>
            <h2 class="font-heading text-4xl md:text-5xl font-bold text-white uppercase mb-6">Build Your Future <br><span class="text-gold">With Mastery.</span></h2>
            <p class="text-slate-400 max-w-2xl mx-auto mb-10 text-lg leading-relaxed">We are always looking for visionary engineers, project managers, and dynamic specialists to build the future of Malaysia with Builtech.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('careers') ?? '#' }}" class="bt-btn bt-btn-primary inline-flex items-center gap-3 px-8 py-4 rounded-full font-bold uppercase tracking-widest text-sm transition hover:-translate-y-1 hover:shadow-[0_10px_20px_rgba(197,160,89,0.3)]">
                    <i class="fas fa-briefcase"></i> Explore Career Openings
                </a>
                <a href="{{ route('contact') ?? '#' }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-full font-bold uppercase tracking-widest text-sm border border-white/20 text-white/70 hover:text-white hover:border-white/50 transition-all duration-300">
                    <i class="fa-regular fa-envelope"></i> Get in Touch
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
<script>
    /* ── Netflix-style horizontal scroller for the curated category rows ── */
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-curated-row]').forEach((row) => {
            const track = row.querySelector('[data-curated-track]');
            const prev  = row.querySelector('[data-curated-prev]');
            const next  = row.querySelector('[data-curated-next]');
            if (!track) return;

            const step = () => track.clientWidth * 0.92;  // scroll one viewport at a time
            const update = () => {
                const max = track.scrollWidth - track.clientWidth - 2;  // 2px slack
                if (prev) prev.disabled = track.scrollLeft <= 2;
                if (next) next.disabled = track.scrollLeft >= max;
                // Hide arrows entirely if everything already fits
                const fits = track.scrollWidth <= track.clientWidth + 4;
                if (prev) prev.style.visibility = fits ? 'hidden' : '';
                if (next) next.style.visibility = fits ? 'hidden' : '';
            };

            prev?.addEventListener('click', () => track.scrollBy({ left: -step(), behavior: 'smooth' }));
            next?.addEventListener('click', () => track.scrollBy({ left:  step(), behavior: 'smooth' }));
            track.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update);
            update();
        });
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('cultureHub', (config) => ({
            activeCat: config.activeCategory || 'all',
            activeSubCat: 'all',
            activeYear: 'all',
            activeInternYear: null,
            searchQuery: '',
            filteredCount: 1, // Initialize > 0 to prevent FOUC flash of empty state
            subCatsMap: @json($subCategoriesByCategory ?? []),
            showAllYears: false,
            openDropdown: null,
            closeTimeout: null, // Track timeout for delayed mouseleave closing

            hasSubCat(category, subCategoryKey) {
                if (!this.subCatsMap || !this.subCatsMap[category]) return false;
                return this.subCatsMap[category].includes(subCategoryKey);
            },

            // ────────────────────────────────────────────────────────────
            //  Lifecycle
            // ────────────────────────────────────────────────────────────
            init() {
                // First paint: run filter once the DOM has the event-cards.
                this.$nextTick(() => { this.updateFilter(); });

                // Single watcher per piece of state — the previous chain double-set
                // sub/year on activeCat change because setCategory already did the
                // reset. Now: state changes -> updateFilter, nothing more.
                this.$watch('activeCat',    () => this.updateFilter());
                this.$watch('activeSubCat', () => this.updateFilter());
                this.$watch('activeYear',   () => this.updateFilter());

                // Search: debounce so we don't query the DOM on every keystroke.
                let searchTimer = null;
                this.$watch('searchQuery', () => {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => this.updateFilter(), 220);
                });

                // Keyboard shortcut: '/' focuses the search input
                document.addEventListener('keydown', (e) => {
                    const tag = document.activeElement?.tagName;
                    if (e.key === '/' && tag !== 'INPUT' && tag !== 'TEXTAREA') {
                        e.preventDefault();
                        this.$refs.searchInput?.focus();
                    }
                    // Esc closes any open dropdown
                    if (e.key === 'Escape' && this.openDropdown) {
                        this.openDropdown = null;
                    }
                });

                // Click outside any dropdown closes it (more intuitive than
                // requiring a second click on the pill).
                document.addEventListener('click', (e) => {
                    if (!this.openDropdown) return;
                    if (!e.target.closest('.dropdown-wrapper, .filter-pill')) {
                        this.openDropdown = null;
                    }
                });
            },

            // ────────────────────────────────────────────────────────────
            //  Dropdown control
            // ────────────────────────────────────────────────────────────
            handleMouseEnter(menu) {
                clearTimeout(this.closeTimeout);
                this.openDropdown = menu;
            },

            handleMouseLeave() {
                this.closeTimeout = setTimeout(() => {
                    this.openDropdown = null;
                }, 150);
            },

            // Click the pill: open this dropdown AND switch to that category,
            // but don't close the dropdown — that was the old bug. Second click
            // on the same pill toggles the dropdown back closed.
            toggleDropdown(menu) {
                if (this.openDropdown === menu) {
                    this.openDropdown = null;
                    return;
                }
                this._switchCategory(menu);
                this.openDropdown = menu;
            },

            // ────────────────────────────────────────────────────────────
            //  Category / sub-category / reset
            // ────────────────────────────────────────────────────────────
            // Internal — change category state WITHOUT touching the dropdown
            // or scrolling. Shared by toggleDropdown (keeps dropdown open) and
            // setCategory (closes + scrolls).
            _switchCategory(cat) {
                this.activeCat        = cat;
                this.activeSubCat     = 'all';
                this.activeYear       = 'all';
                this.activeInternYear = null;
                this.searchQuery      = '';
            },

            // Public — used by flat pills (All Hub, Team Building, Internship,
            // Trips, and the empty-state "browse all" CTA).
            setCategory(cat) {
                this._switchCategory(cat);
                this.openDropdown = null;
                this._scrollToFilters();
            },

            setSubCat(sub) {
                this.activeSubCat = sub;
                this.activeYear   = 'all';
                this.openDropdown = null;
                this._scrollToFilters();
            },

            // Clear every filter at once — used by the "Reset" button.
            resetAllFilters() {
                this._switchCategory('all');
                this.openDropdown = null;
            },

            _scrollToFilters() {
                const el = document.querySelector('.master-filter-container');
                if (!el) return;
                window.scrollTo({ top: el.offsetTop - 10, behavior: 'smooth' });
            },

            getCatLabel() {
                const labels = {
                    'festive': 'Festive', 'tb': 'Team Building', 'work': 'Training',
                    'trip': 'Trips', 'csr': 'CSR', 'event': 'Events', 'intern': 'Internship'
                };
                return labels[this.activeCat] || this.activeCat;
            },

            getSubCatLabel() {
                const labels = {
                    'annual_dinner': 'Annual Dinner', 'cny': 'Chinese New Year', 'raya': 'Hari Raya',
                    'mid_autumn': 'Mid-Autumn', 'dumpling': 'Dumpling Festival', 'durian': 'Durian Party',
                    'christmas': 'Christmas', 'birthday': 'Birthdays', 'solstice': 'Winter Solstice', 'others': 'Others',
                    'safety': 'Safety & HSE', 'seminar': 'Seminars & Courses', 'training': 'Internal Training',
                    'talk': 'Talks & Sharing', 'audit': 'Audits & Inspections', 'certification': 'Certifications',
                    'sports': 'Sports Tournaments', 'award': 'Awards', 'other_work': 'Others',
                    'company_trip': 'Company Trip',
                    'charity': 'Charity & Donation', 'community': 'Community Service', 'education': 'Education Support', 'environment': 'Environmental',
                    'sponsorship': 'Sponsorship', 'conference': 'Conference', 'exhibition': 'Exhibition',
                };
                return labels[this.activeSubCat] || this.activeSubCat.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            },

            getYearsForActiveCategory() {
                if (this.activeCat === 'all' || this.activeCat === 'intern') return [];
                
                const years = new Set();
                const cards = document.querySelectorAll('.events-grid .event-card');
                cards.forEach(card => {
                    const cat = card.getAttribute('data-category') || '';
                    const subcat = card.getAttribute('data-subcategory') || '';
                    const year = card.getAttribute('data-year') || '';
                    
                    const matchesCat = (cat === this.activeCat);
                    const matchesSubCat = (this.activeSubCat === 'all' || subcat === this.activeSubCat.toLowerCase());
                    
                    if (matchesCat && matchesSubCat && year) {
                        years.add(year);
                    }
                });
                return Array.from(years).sort((a, b) => b - a);
            },

            updateFilter() {
                let count = 0;
                const query = this.searchQuery.toLowerCase().trim();
                const cards = document.querySelectorAll('.events-grid .event-card');

                if (this.activeCat === 'intern') {
                    const internCards = document.querySelectorAll('.intern-item');
                    internCards.forEach(card => {
                        const title = card.getAttribute('data-title') || '';
                        const uni = card.getAttribute('data-uni') || '';
                        if (!query || title.includes(query) || uni.includes(query)) {
                            card.style.display = 'flex';
                            count++;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    this.filteredCount = count;
                    return;
                }

                if (this.activeCat === 'all' && !query) {
                    const previewCards = document.querySelectorAll('.curated-section .event-card');
                    this.filteredCount = previewCards.length > 0 ? previewCards.length : 0;
                    return;
                }

                cards.forEach(card => {
                    const cat = card.getAttribute('data-category') || '';
                    const subcat = card.getAttribute('data-subcategory') || '';
                    const title = card.getAttribute('data-title') || '';
                    const loc = card.getAttribute('data-location') || '';
                    const year = card.getAttribute('data-year') || '';

                    const matchesCat = (this.activeCat === 'all' || cat === this.activeCat);
                    const matchesSubCat = (this.activeSubCat === 'all' || subcat === this.activeSubCat.toLowerCase());
                    const matchesYear = (this.activeYear === 'all' || year === this.activeYear);
                    const matchesQuery = !query || title.includes(query) || loc.includes(query) || year.includes(query);

                    if (matchesCat && matchesSubCat && matchesYear && matchesQuery) {
                        card.style.display = 'flex';
                        count++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                this.filteredCount = count;
                
                // Trigger intersection observer on newly shown elements
                setTimeout(() => {
                    document.querySelectorAll('.reveal').forEach(el => {
                        if (el.getBoundingClientRect().top < window.innerHeight) {
                            el.classList.add('active');
                        }
                    });
                }, 50);
            }
        }));
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Each event has its own gallery group via data-gallery="event-{id}"
        // GLightbox automatically groups by data-gallery attribute.
        // DO NOT use a shared gallery name — that mixes photos across different events.
        const lightbox = GLightbox({ 
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true,
            openEffect: 'fade',
            closeEffect: 'fade',
            slideEffect: 'slide',
            moreLength: 0,
            svg: {
                close: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>'
            }
        });
        
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.05
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { 
                if (entry.isIntersecting) {
                    entry.target.classList.add('active'); 
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
</script>
@endpush