<div 
    x-data="{ 
        mobileMenuOpen: false, 
        scrolled: false, 
        activeDropdown: null,
        currentPath: window.location.pathname,
        aboutOpen: false,
        mediaOpen: false
    }" 
    @scroll.window="scrolled = (window.scrollY > 50)"
    @keydown.escape.window="mobileMenuOpen = false; activeDropdown = null"
>
<header 
    :class="scrolled ? 'nav-scrolled' : 'nav-transparent'"
    class="navbar-wrapper"
>

<style>
/* ==========================================
   NAVBAR CORE VARIABLES & RESET
   ========================================== */
:root {
    --nav-height: 85px;
    --color-navy: #1a242f;
    --color-gold: #c5a059;
    --color-gold-hover: #b38f4d;
    --font-family: 'Barlow', sans-serif;
}

/* ==========================================
   WRAPPER & POSITIONING
   ========================================== */
.navbar-wrapper { 
    position: fixed; 
    top: 0; left: 0; right: 0; 
    z-index: 1000; 
    height: var(--nav-height); 
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
    font-family: var(--font-family);
}

/* States */
.nav-transparent { 
    background: rgba(255, 255, 255, 0.5); 
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-bottom: 1px solid rgba(26, 36, 47, 0.05); 
}
.nav-scrolled { 
    background: rgba(255, 255, 255, 0.98); 
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    height: 75px; 
    box-shadow: 0 4px 30px rgba(0,0,0,0.05); 
}

/* Container */
.nav-container { 
    max-width: 1280px; 
    margin: 0 auto; 
    padding: 0 1.5rem;
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    height: 100%; 
}

/* ==========================================
   LOGO STYLING
   ========================================== */
.nav-logo img { 
    height: 48px; 
    width: auto; 
    transition: all 0.3s ease; 
}
.nav-scrolled .nav-logo img { 
    height: 42px;
}

/* ==========================================
   DESKTOP NAVIGATION LINKS
   ========================================== */
.nav-desktop { 
    display: flex; 
    align-items: center; 
    gap: 2.5rem; 
}

.nav-link { 
    font-size: 0.7rem; 
    font-weight: 800; 
    letter-spacing: 0.15em; 
    text-transform: uppercase; 
    color: var(--color-navy); 
    text-decoration: none; 
    padding: 10px 0; 
    transition: all 0.3s ease;
    display: flex; 
    align-items: center; 
    gap: 8px;
    position: relative;
    background: transparent;
    border: none;
    cursor: pointer;
    font-family: inherit;
}
.nav-link:hover, .nav-link.active-link { color: var(--color-gold) !important; }

/* Active underline effect */
.nav-link.active-link::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; width: 100%; height: 2px;
    background: var(--color-gold);
}

/* Dropdown chevron */
.nav-link svg { 
    width: 8px; 
    height: 8px; 
    transition: transform 0.3s ease; 
}

/* ==========================================
   CTA BUTTON (Contact Us)
   ========================================== */
.nav-cta { 
    font-size: 0.65rem; 
    font-weight: 800; 
    letter-spacing: 0.2em; 
    text-transform: uppercase; 
    padding: 12px 28px; 
    border-radius: 2px;
    background-color: var(--color-gold); 
    color: white !important; 
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(197, 160, 89, 0.25);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
}
.nav-cta:hover { 
    background-color: var(--color-gold-hover); 
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(197, 160, 89, 0.35);
}

/* ==========================================
   DROPDOWN MENUS (Desktop)
   ========================================== */
.nav-dropdown { 
    position: relative; 
    padding: 20px 0; 
}
.nav-dropdown-menu { 
    position: absolute; 
    top: 90%; left: 50%; 
    transform: translateX(-50%); 
    width: 260px; 
    background: var(--color-navy); 
    padding: 1rem 0; 
    border-top: 3px solid var(--color-gold);
    box-shadow: 0 20px 50px rgba(0,0,0,0.3); 
    z-index: 1100;
    border-radius: 0 0 8px 8px;
}
.nav-dropdown-link { 
    display: block; 
    padding: 0.75rem 2rem; 
    font-size: 0.65rem; 
    font-weight: 700; 
    color: rgba(255,255,255,0.6); 
    text-decoration: none; 
    letter-spacing: 0.1em; 
    text-transform: uppercase; 
    transition: 0.3s; 
    border-left: 3px solid transparent;
}
.nav-dropdown-link:hover, .nav-dropdown-link.active-dropdown { 
    color: white; 
    background: rgba(255,255,255,0.05); 
    border-left-color: var(--color-gold);
    padding-left: 2.5rem;
}

/* ==========================================
   MOBILE TOGGLE (Hamburger)
   ========================================== */
.mobile-toggle { 
    display: none; 
    color: var(--color-navy); 
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    z-index: 1001;
}

/* ==========================================
   MOBILE SIDEBAR OVERLAY & PANEL
   ========================================== */
.mobile-sidebar { 
    position: fixed; 
    inset: 0; 
    z-index: 9999; 
}
.mobile-overlay { 
    position: absolute; 
    inset: 0; 
    background: rgba(26, 36, 47, 0.85); 
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}
.mobile-panel { 
    position: absolute; 
    top: 0; right: 0; 
    width: 100%; 
    max-width: 340px; 
    height: 100%; 
    background: white; 
    display: flex; 
    flex-direction: column; 
    box-shadow: -10px 0 40px rgba(0,0,0,0.2);
}

/* Mobile Panel Header */
.mobile-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}
.mobile-panel-header img {
    height: 32px;
    width: auto;
}
.mobile-close-btn {
    background: none;
    border: none;
    color: var(--color-navy);
    cursor: pointer;
    padding: 4px;
    font-size: 1.5rem;
    line-height: 1;
    transition: color 0.2s;
}
.mobile-close-btn:hover { color: var(--color-gold); }

/* Mobile Links List */
.mobile-links-container {
    overflow-y: auto;
    flex: 1;
    padding: 0;
}

.mobile-link { 
    display: block; 
    font-size: 0.82rem; 
    font-weight: 800; 
    color: var(--color-navy); 
    text-transform: uppercase; 
    letter-spacing: 0.12em; 
    padding: 1.15rem 2rem; 
    border-bottom: 1px solid #f0f0f0; 
    transition: all 0.25s ease;
    text-decoration: none;
    background: transparent;
    border-left: 4px solid transparent;
}
.mobile-link:hover {
    background: #fcfbf8;
    color: var(--color-gold);
    padding-left: 2.5rem;
    border-left-color: var(--color-gold);
}
.active-mobile-link { 
    color: var(--color-gold) !important; 
    border-left-color: var(--color-gold) !important;
    background: #fcfbf8 !important;
    padding-left: calc(2rem - 4px) !important;
}

/* Mobile Submenu Button */
.mobile-submenu-btn {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: left;
}
.mobile-submenu-chevron {
    transition: transform 0.3s ease;
}
.mobile-submenu-chevron.rotated {
    transform: rotate(180deg);
}

/* Mobile Submenu Content */
.mobile-submenu {
    background: #f8f7f4;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.mobile-submenu.open {
    max-height: 400px;
}
.mobile-submenu-link {
    display: block;
    padding: 0.9rem 2.5rem;
    font-size: 0.72rem;
    font-weight: 700;
    color: #666;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    border-bottom: 1px solid #eee;
    transition: all 0.2s;
}
.mobile-submenu-link:hover {
    color: var(--color-gold);
    background: #fff;
    padding-left: 2.8rem;
}

/* Mobile Footer CTA */
.mobile-footer-cta {
    padding: 1.5rem;
    background: #f8f7f4;
    border-top: 1px solid #eee;
}
.mobile-footer-cta .nav-cta {
    width: 100%;
    justify-content: center;
}
.mobile-phone-link {
    display: block;
    text-align: center;
    margin-top: 0.75rem;
    font-size: 0.85rem;
    color: #666;
    text-decoration: none;
    font-weight: 600;
}
.mobile-phone-link:hover { color: var(--color-gold); }

/* ==========================================
   ADVANCED MOBILE BOTTOM NAV
   ========================================== */
.mobile-bottom-nav-wrapper { display: none; }
@media (max-width: 1024px) { .mobile-bottom-nav-wrapper { display: block; } }

.mobile-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 70px;
    background: #ffffff;
    box-shadow: 0 -5px 25px rgba(26, 36, 47, 0.08);
    z-index: 99999;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    padding-bottom: env(safe-area-inset-bottom);
    border-radius: 20px 20px 0 0;
}

.bottom-nav-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.6rem;
    font-weight: 700;
    background: none;
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    padding-top: 5px;
}

.bottom-nav-item i {
    font-size: 1.1rem;
    margin-bottom: 4px;
    transition: all 0.3s ease;
    z-index: 2;
}

/* Active State Bubble */
.bottom-nav-item.active {
    color: var(--color-gold);
}
.bottom-nav-item.active i {
    color: var(--color-gold);
}

.desktop-back-btn {
    position: fixed;
    top: 120px;
    left: 1.5rem;
    z-index: 990;
    display: flex;
    align-items: center;
    gap: 8px;
    background: white;
    color: var(--color-navy);
    padding: 10px 18px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border: 1px solid rgba(26, 36, 47, 0.1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    cursor: pointer;
    transition: all 0.3s ease;
}
.desktop-back-btn:hover {
    background: var(--color-gold);
    color: white;
    border-color: var(--color-gold);
    transform: translateX(-5px);
}

/* ==========================================
   RESPONSIVE BREAKPOINTS
   ========================================== */
@media (max-width: 1024px) { 
    .nav-desktop { display: none; } 
    /* Show mobile toggle in header as a fallback */
    .mobile-toggle { display: block !important; } 
    .desktop-back-btn { display: none !important; }
}

/* Prevent flash of unstyled content */
[x-cloak] { display: none !important; }
</style>


<!-- ================================ -->
<!-- NAVBAR CONTENT START -->
<!-- ================================ -->

<div class="nav-container">
    
    <!-- Logo -->
    <a href="/" class="nav-logo" aria-label="Builtech Home">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Builtech Project Management">
    </a>

    <!-- Desktop Navigation -->
    <nav class="nav-desktop" aria-label="Main navigation">
        
        <!-- Home -->
        <a href="/" class="nav-link" :class="currentPath === '/' || currentPath === '/index.html' ? 'active-link' : ''">Home</a>

        <!-- About Us Dropdown -->
        <div class="nav-dropdown" 
             @mouseenter="activeDropdown = 'about'" 
             @mouseleave="activeDropdown = null">
            <button class="nav-link" 
                    :class="(currentPath.includes('/about') || currentPath.includes('/our-people') || currentPath.includes('/corporate')) ? 'active-link' : ''">
                About Us 
                <svg :style="activeDropdown === 'about' ? 'transform: rotate(180deg)' : ''" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                     stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <div x-show="activeDropdown === 'about'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 x-cloak 
                 class="nav-dropdown-menu">
                <a href="/about" class="nav-dropdown-link" :class="currentPath.includes('/about') ? 'active-dropdown' : ''">Brand Story</a>
                <a href="/our-people" class="nav-dropdown-link" :class="currentPath.includes('/our-people') ? 'active-dropdown' : ''">Our People</a>
                <a href="/corporate" class="nav-dropdown-link" :class="currentPath.includes('/corporate') ? 'active-dropdown' : ''">Corporate Governance</a>
            </div>
        </div>

        <!-- Services -->
        <a href="/services" class="nav-link" :class="currentPath.includes('/services') ? 'active-link' : ''">Services</a>
        
        <!-- Projects -->
        <a href="/projects" class="nav-link" :class="currentPath.includes('/projects') ? 'active-link' : ''">Projects</a>

        <!-- Media & Awards Dropdown -->
        <div class="nav-dropdown" 
             @mouseenter="activeDropdown = 'media'" 
             @mouseleave="activeDropdown = null">
            <button class="nav-link" 
                    :class="(currentPath.includes('/news') || currentPath.includes('/awards') || currentPath.includes('/culture')) ? 'active-link' : ''">
                Media & Awards 
                <svg :style="activeDropdown === 'media' ? 'transform: rotate(180deg)' : ''" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                     stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <div x-show="activeDropdown === 'media'" 
                 x-transition 
                 x-cloak 
                 class="nav-dropdown-menu">
                <a href="/media" class="nav-dropdown-link" :class="currentPath.includes('/media') ? 'active-dropdown' : ''">Media Center</a>
                <a href="/news" class="nav-dropdown-link" :class="currentPath.includes('/news') ? 'active-dropdown' : ''">News & Updates</a>
                <a href="/awards" class="nav-dropdown-link" :class="currentPath.includes('/awards') ? 'active-dropdown' : ''">Awards & Honors</a>
                <a href="/culture" class="nav-dropdown-link" :class="currentPath.includes('/culture') ? 'active-dropdown' : ''">Culture & Activities</a>
            </div>
        </div>

        <!-- Careers -->
        <a href="/careers" class="nav-link" :class="currentPath.includes('/careers') ? 'active-link' : ''">Careers</a>

        <!-- Contact Us CTA -->
        <a href="/contact" class="nav-cta">Contact Us</a>
        
    </nav>

    <!-- Mobile Hamburger Toggle -->
    <button @click="mobileMenuOpen = true" 
            class="mobile-toggle focus:outline-none" 
            aria-label="Open navigation menu">
        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
            <path d="M4 8h16M4 16h16"/>
        </svg>
    </button>
    
</div>
</header>

<!-- Desktop Back Button (Only show if not on home page) -->
<template x-if="currentPath !== '/' && currentPath !== '/index.html'">
    <button @click="window.history.length > 1 ? window.history.back() : window.location.href='/'" class="desktop-back-btn">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</template>

<!-- Advanced Mobile Bottom Navigation -->
<div class="mobile-bottom-nav-wrapper">
    <nav class="mobile-bottom-nav">
        <!-- Back -->
        <button @click="window.history.length > 1 ? window.history.back() : window.location.href='/'" class="bottom-nav-item">
            <i class="fas fa-chevron-left"></i>
            <span style="z-index: 2;">Back</span>
        </button>
        
        <!-- Projects -->
        <a href="/projects" class="bottom-nav-item" :class="currentPath.includes('/projects') ? 'active' : ''">
            <i class="fas fa-building"></i>
            <span style="z-index: 2;">Projects</span>
        </a>
        
        <!-- Home -->
        <a href="/" class="bottom-nav-item" :class="currentPath === '/' || currentPath === '/index.html' ? 'active' : ''">
            <i class="fas fa-home"></i>
            <span style="z-index: 2;">Home</span>
        </a>
        
        <!-- Contact -->
        <a href="/contact" class="bottom-nav-item" :class="currentPath.includes('/contact') ? 'active' : ''">
            <i class="fas fa-envelope"></i>
            <span style="z-index: 2;">Contact</span>
        </a>
        
        <!-- More Menu -->
        <button @click="mobileMenuOpen = true" class="bottom-nav-item" :class="mobileMenuOpen ? 'active' : ''">
            <i class="fas fa-bars"></i>
            <span style="z-index: 2;">Menu</span>
        </button>
    </nav>
</div>


<!-- ================================ -->
<!-- MOBILE SIDEBAR PANEL -->
<!-- ================================ -->

<div x-show="mobileMenuOpen" x-cloak class="mobile-sidebar">
    
    <!-- Overlay Backdrop -->
    <div x-show="mobileMenuOpen" 
         x-transition.opacity.duration.200ms
         @click="mobileMenuOpen = false" 
         class="mobile-overlay"
         aria-hidden="true"></div>

    <!-- Slide-out Panel -->
    <nav x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="mobile-panel"
         role="dialog"
         aria-modal="true"
         aria-label="Mobile navigation menu">
        
        <!-- Header with Logo & Close -->
        <div class="mobile-panel-header">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Builtech Logo">
            <button @click="mobileMenuOpen = false" class="mobile-close-btn" aria-label="Close menu">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="mobile-links-container">
            
            <!-- Home -->
            <a href="/" class="mobile-link" :class="currentPath === '/' ? 'active-mobile-link' : ''">Home</a>
            
            <!-- About Us (Expandable) -->
            <div x-data="{ open: false }">
                <button @click="open = !open; $parent.aboutOpen = !$parent.aboutOpen" 
                        class="mobile-link mobile-submenu-btn"
                        :class="(currentPath.includes('/about') || currentPath.includes('/our-people')) ? 'active-mobile-link' : ''">
                    About Us 
                    <span>
                        <svg :class="open ? 'rotated' : ''" 
                             class="mobile-submenu-chevron w-3 h-3" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                             stroke-width="3" stroke-linecap="round">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>
                
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mobile-submenu"
                     :class="open ? 'open' : ''">
                    <a href="/about" class="mobile-submenu-link">Brand Story</a>
                    <a href="/our-people" class="mobile-submenu-link">Our People</a>
                    <a href="/corporate" class="mobile-submenu-link">Corporate Governance</a>
                </div>
            </div>

            <!-- Services -->
            <a href="/services" class="mobile-link" :class="currentPath.includes('/services') ? 'active-mobile-link' : ''">Services</a>
            
            <!-- Projects -->
            <a href="/projects" class="mobile-link" :class="currentPath.includes('/projects') ? 'active-mobile-link' : ''">Projects</a>
            
            <!-- Media & Awards (Expandable) -->
            <div x-data="{ open: false }">
                <button @click="open = !open; $parent.mediaOpen = !$parent.mediaOpen" 
                        class="mobile-link mobile-submenu-btn"
                        :class="(currentPath.includes('/news') || currentPath.includes('/awards')) ? 'active-mobile-link' : ''">
                    Media & Awards 
                    <span>
                        <svg :class="open ? 'rotated' : ''" 
                             class="mobile-submenu-chevron w-3 h-3" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                             stroke-width="3" stroke-linecap="round">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>
                
                <div x-show="open" 
                     x-transition
                     class="mobile-submenu"
                     :class="open ? 'open' : ''">
                    <a href="/media" class="mobile-submenu-link">Media Center</a>
                    <a href="/news" class="mobile-submenu-link">News & Updates</a>
                    <a href="/awards" class="mobile-submenu-link">Awards & Honors</a>
                    <a href="/culture" class="mobile-submenu-link">Culture & Activities</a>
                </div>
            </div>

            <!-- Careers -->
            <a href="/careers" class="mobile-link" :class="currentPath.includes('/careers') ? 'active-mobile-link' : ''">Careers</a>
            
        </div>

        <!-- Footer CTA Area -->
        <div class="mobile-footer-cta">
            <a href="/contact" class="nav-cta">Contact Us</a>
            <a href="tel:+60465933399" class="mobile-phone-link">
                <i class="fas fa-phone-alt" style="color: var(--color-gold); margin-right: 6px;"></i> +604-659 3399
            </a>
        </div>
        
    </nav>
</div>



</div>

<!-- Alpine.js CDN (Load once at end of body) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/components/navbar.blade.php ENDPATH**/ ?>