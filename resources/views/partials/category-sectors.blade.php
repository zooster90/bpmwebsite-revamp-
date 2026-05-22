{{--
    ═══════════════════════════════════════════════════════════════
    PARTIAL: category-sectors.blade.php
    ─────────────────────────────────────────────────────────────
    Displays ALL project categories as premium clickable icon cards
    that navigate to /projects?category=... (filtered projects page).

    Usage:
        @include('partials.category-sectors')
        @include('partials.category-sectors', ['theme' => 'dark'])

    Props:
        $theme  — 'light' (default) | 'dark'   — background theme
    ═══════════════════════════════════════════════════════════════
--}}

@php
    $sectorTheme = $theme ?? 'light';

    /**
     * Master list of ALL project categories.
     * 'key'   → exact value stored in DB (must match ProjectForm options)
     * 'label' → display name shown on the icon card
     * 'short' → compact label shown below icon (2-3 words max)
     * 'icon'  → Font Awesome class (fas fa-...)
     * 'desc'  → short tooltip / sub-label shown on hover
     */
    $sectors = [
        [
            'key'   => 'High Rise',
            'label' => 'High Rise',
            'short' => 'HIGH RISE',
            'icon'  => 'fas fa-city',
            'desc'  => 'Apartments & Condominiums',
        ],
        [
            'key'   => 'Hospital',
            'label' => 'Healthcare',
            'short' => 'HEALTHCARE',
            'icon'  => 'fas fa-hospital-alt',
            'desc'  => 'Hospitals & Clinics',
        ],
        [
            'key'   => 'Commercial Building',
            'label' => 'Commercial',
            'short' => 'COMMERCIAL',
            'icon'  => 'fas fa-store-alt',
            'desc'  => 'Office Towers & Retail',
        ],
        [
            'key'   => 'Hotel',
            'label' => 'Hotel',
            'short' => 'HOTEL',
            'icon'  => 'fas fa-concierge-bell',
            'desc'  => 'Hotels & Hospitality',
        ],
        [
            'key'   => 'Government Building',
            'label' => 'Institution',
            'short' => 'INSTITUTION',
            'icon'  => 'fas fa-landmark',
            'desc'  => 'Government & Public Buildings',
        ],
        [
            'key'   => 'Civil & Infrastructural Works',
            'label' => 'Infrastructure',
            'short' => 'INFRASTRUCTURE',
            'icon'  => 'fas fa-road',
            'desc'  => 'Civil & Infrastructural Works',
        ],
        [
            'key'   => 'Factory (Industrial Building Works)',
            'label' => 'Industrial',
            'short' => 'INDUSTRIAL',
            'icon'  => 'fas fa-industry',
            'desc'  => 'Factories & Warehouses',
        ],
        [
            'key'   => 'Terrace, Semi-D & Bungalow',
            'label' => 'Residential',
            'short' => 'RESIDENTIAL',
            'icon'  => 'fas fa-home',
            'desc'  => 'Terrace, Semi-D & Bungalow',
        ],
        [
            'key'   => 'Interior Design, Furniture & Renovation Works',
            'label' => 'Renovation',
            'short' => 'RENOVATION',
            'icon'  => 'fas fa-paint-roller',
            'desc'  => 'Interior Design & Fit-out',
        ],
    ];

    $isDark      = $sectorTheme === 'dark';
    $sectionBg   = $isDark ? 'background: var(--color-navy, #0a1628);' : 'background: #f9f8f6;';
    $headingClr  = $isDark ? '#ffffff' : '#0a1628';
    $subClr      = $isDark ? 'rgba(255,255,255,0.45)' : '#9ca3af';
    $cardBg      = $isDark ? 'rgba(255,255,255,0.05)' : '#ffffff';
    $cardBorder  = $isDark ? 'rgba(255,255,255,0.08)' : '#e7e5e4';
    $labelClr    = $isDark ? 'rgba(255,255,255,0.75)' : '#374151';
    $descClr     = $isDark ? 'rgba(255,255,255,0.35)' : '#9ca3af';
@endphp

{{-- ── TRUSTED BY LEADING INDUSTRIES ─────────────────────────────────── --}}
<section class="category-sectors-section" style="{{ $sectionBg }} padding: 80px 0 90px;">
    <div class="container-tidy" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">

        {{-- Section Header --}}
        <div class="text-center reveal" style="margin-bottom: 56px;">
            <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-bottom: 16px;">
                <span style="width: 4px; height: 4px; border-radius: 50%; background: var(--color-gold, #c9a84c); display: inline-block;"></span>
                <span style="width: 14px; height: 14px; border-radius: 50%; border: 1.5px solid var(--color-gold, #c9a84c); display: inline-block;"></span>
                <span style="width: 4px; height: 4px; border-radius: 50%; background: var(--color-gold, #c9a84c); display: inline-block;"></span>
            </div>
            <p style="font-size: 0.65rem; font-weight: 800; letter-spacing: 0.35em; text-transform: uppercase; color: var(--color-gold, #c9a84c); margin-bottom: 12px;">
                Trusted By Leading Industries
            </p>
            <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 900; color: {{ $headingClr }}; line-height: 1.1; margin: 0 0 12px;">
                Browse Projects <span style="color: var(--color-gold, #c9a84c);">By Sector</span>
            </h2>
            <p style="font-size: 0.9rem; color: {{ $subClr }}; max-width: 440px; margin: 0 auto;">
                Click any sector to explore all related track records.
            </p>
        </div>

        {{-- Category Grid --}}
        <div class="sectors-grid" style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
        ">
            @foreach($sectors as $i => $sector)
            <a
                href="{{ route('projects.index', ['category' => $sector['key']]) }}"
                class="sector-card reveal {{ $i > 0 ? 'delay-' . min($i * 100, 500) : '' }}"
                title="View all {{ $sector['label'] }} projects"
                style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 28px 16px;
                    background: {{ $cardBg }};
                    border: 1.5px solid {{ $cardBorder }};
                    border-radius: 20px;
                    text-decoration: none;
                    cursor: pointer;
                    position: relative;
                    overflow: hidden;
                    transition: all 0.28s cubic-bezier(0.34,1.56,0.64,1);
                    gap: 14px;
                    text-align: center;
                "
                onmouseenter="
                    this.style.transform='translateY(-6px) scale(1.03)';
                    this.style.borderColor='var(--color-gold, #c9a84c)';
                    this.style.boxShadow='0 16px 40px rgba(201,168,76,0.18)';
                    this.querySelector('.sector-icon-wrap').style.background='var(--color-gold, #c9a84c)';
                    this.querySelector('.sector-icon-wrap i').style.color='#fff';
                    this.querySelector('.sector-label').style.color='var(--color-gold, #c9a84c)';
                "
                onmouseleave="
                    this.style.transform='translateY(0) scale(1)';
                    this.style.borderColor='{{ $cardBorder }}';
                    this.style.boxShadow='none';
                    this.querySelector('.sector-icon-wrap').style.background='{{ $isDark ? 'rgba(201,168,76,0.12)' : 'rgba(201,168,76,0.08)' }}';
                    this.querySelector('.sector-icon-wrap i').style.color='var(--color-gold, #c9a84c)';
                    this.querySelector('.sector-label').style.color='{{ $labelClr }}';
                "
            >
                {{-- Icon Bubble --}}
                <div
                    class="sector-icon-wrap"
                    style="
                        width: 60px; height: 60px;
                        border-radius: 16px;
                        background: {{ $isDark ? 'rgba(201,168,76,0.12)' : 'rgba(201,168,76,0.08)' }};
                        display: flex; align-items: center; justify-content: center;
                        flex-shrink: 0;
                        transition: background 0.28s ease;
                    "
                >
                    <i class="{{ $sector['icon'] }}" style="font-size: 1.5rem; color: var(--color-gold, #c9a84c); transition: color 0.28s ease;"></i>
                </div>

                {{-- Label --}}
                <span
                    class="sector-label"
                    style="
                        font-size: 0.6rem;
                        font-weight: 800;
                        letter-spacing: 0.12em;
                        text-transform: uppercase;
                        color: {{ $labelClr }};
                        transition: color 0.28s ease;
                        line-height: 1.3;
                    "
                >{{ $sector['short'] }}</span>

                {{-- Sub-desc --}}
                <span style="
                    font-size: 0.6rem;
                    color: {{ $descClr }};
                    line-height: 1.4;
                    display: block;
                ">{{ $sector['desc'] }}</span>

                {{-- Arrow indicator --}}
                <span style="
                    position: absolute;
                    bottom: 10px; right: 14px;
                    font-size: 0.6rem;
                    color: var(--color-gold, #c9a84c);
                    opacity: 0;
                    transition: opacity 0.2s ease;
                " class="sector-arrow">→</span>
            </a>
            @endforeach
        </div>

        {{-- CTA Link --}}
        <div class="text-center reveal" style="margin-top: 48px;">
            <a href="{{ route('projects.index') }}" style="
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 0.65rem;
                font-weight: 800;
                letter-spacing: 0.25em;
                text-transform: uppercase;
                color: var(--color-gold, #c9a84c);
                text-decoration: none;
                padding: 12px 28px;
                border: 1.5px solid var(--color-gold, #c9a84c);
                border-radius: 100px;
                transition: all 0.25s ease;
            "
            onmouseenter="this.style.background='var(--color-gold, #c9a84c)'; this.style.color='#fff';"
            onmouseleave="this.style.background='transparent'; this.style.color='var(--color-gold, #c9a84c)';"
            >
                VIEW ALL PROJECTS &nbsp;<i class="fas fa-arrow-right" style="font-size: 0.65rem;"></i>
            </a>
        </div>

    </div>
</section>

<style>
/* ── Arrow show on card hover ─ */
.sector-card:hover .sector-arrow {
    opacity: 1 !important;
}

/* ── Mobile responsive ─ */
@media (max-width: 640px) {
    .sectors-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 10px !important;
    }
    .sector-card {
        padding: 18px 8px !important;
    }
    .sector-icon-wrap {
        width: 48px !important;
        height: 48px !important;
    }
}
@media (max-width: 400px) {
    .sectors-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
</style>
