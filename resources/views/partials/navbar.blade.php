@php
    $currentRoute = Route::currentRouteName();
    // Pages that have a light background at the top, where the navbar text needs to be dark
    $lightBgRoutes = ['news.show', 'projects.show', 'ongoing-projects.show', 'privacy'];
    $isLightBg = in_array($currentRoute, $lightBgRoutes);
@endphp

<nav class="navbar {{ $isLightBg ? 'navbar-dark-text' : '' }}" id="mainNav">
    <div class="navbar-inner">
        <a href="/" class="navbar-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Builtech Logo" class="logo-img">
        </a>

        <ul class="nav-menu">
            <li><a href="/" class="nav-link {{ $currentRoute == 'home' ? 'active' : '' }}">Home</a></li>
            
            <li class="dropdown">
                <a href="{{ route('about') }}" class="nav-link {{ in_array($currentRoute, ['about', 'our-people', 'story']) ? 'active' : '' }}">
                    About Us <i class="fa-solid fa-chevron-down" style="font-size: 0.6rem; margin-left: 5px;"></i>
                </a>
                <div class="dropdown-content">
                    <div class="dropdown-grid" style="grid-template-columns: 1fr 1fr 1fr;">
                        <div class="dropdown-column">
                            <a href="{{ route('about') }}">
                                <i class="fa-solid fa-building-columns"></i>
                                Corporate Profile
                            </a>
                            <div class="nested-items">
                                <a href="{{ route('corporate') }}">Corporate Governance</a>
                                <a href="{{ route('story') }}">Our Legacy</a>
                                <a href="{{ route('our-people') }}">Leadership Team</a>
                            </div>
                        </div>
                        <div class="dropdown-column">
                            <a href="{{ route('sustainability') }}">
                                <i class="fa-solid fa-leaf"></i>
                                Sustainability
                            </a>
                            <a href="{{ route('culture') }}">
                                <i class="fa-solid fa-users-rays"></i>
                                Staff Activities
                            </a>
                        </div>
                        <div class="dropdown-column">
                            <a href="{{ route('awards') }}">
                                <i class="fa-solid fa-award"></i>
                                Awards &amp; Honours
                            </a>
                            <a href="{{ route('media') }}">
                                <i class="fa-solid fa-newspaper"></i>
                                Press &amp; Media
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            <li><a href="{{ route('services.index') }}" class="nav-link {{ $currentRoute == 'services.index' ? 'active' : '' }}">Expertise</a></li>
            <li><a href="{{ route('projects.index') }}" class="nav-link {{ str_contains($currentRoute, 'projects') ? 'active' : '' }}">Portfolio</a></li>
            <li><a href="{{ route('news.index') }}" class="nav-link {{ str_contains($currentRoute, 'news') ? 'active' : '' }}">Journal</a></li>
            <li><a href="{{ route('careers') }}" class="nav-link {{ $currentRoute == 'careers' ? 'active' : '' }}">Careers</a></li>
            
            <li>
                <a href="{{ route('contact') }}" class="btn-contact-nav">
                    Contact Us
                </a>
            </li>
        </ul>

        <button class="mobile-toggle" id="menuToggle" aria-label="Toggle Navigation">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </button>
    </div>
</nav>

<!-- Mobile Sidebar (Comprehensive Master Menu sliding from the Left) -->
<div class="mobile-sidebar" id="mobileSidebar">
    <div class="sidebar-header">
        <img src="{{ asset('img/logo.png') }}" alt="Builtech" class="mobile-logo">
        <div class="mobile-close-btn" id="closeMenu">&times;</div>
    </div>
    
    <div class="sidebar-content">
        {{-- Main Navigation --}}
        <div class="mobile-section">
            <a href="/" class="mobile-link main-link">
                <i class="fa-solid fa-house text-gold w-8"></i> Home
            </a>
            <span class="section-title">The Company</span>
            <a href="{{ route('about') }}">
                <i class="fa-solid fa-building-columns text-gold w-6"></i> About Builtech
            </a>
            <a href="{{ route('our-people') }}">
                <i class="fa-solid fa-user-tie text-gold w-6"></i> Leadership Team
            </a>
            <a href="{{ route('corporate') }}">
                <i class="fa-solid fa-scale-balanced text-gold w-6"></i> Corporate Governance
            </a>
            <a href="{{ route('story') }}">
                <i class="fa-solid fa-book-open text-gold w-6"></i> Our Legacy
            </a>
            <a href="{{ route('sustainability') }}">
                <i class="fa-solid fa-leaf text-gold w-6"></i> Sustainability
            </a>
        </div>

        {{-- Operations & Expertise --}}
        <div class="mobile-section">
            <span class="section-title">Operations</span>
            <a href="{{ route('services.index') }}">
                <i class="fa-solid fa-helmet-safety text-gold w-6"></i> Expertise &amp; Services
            </a>
            <a href="{{ route('projects.index') }}">
                <i class="fa-solid fa-city text-gold w-6"></i> Project Portfolio
            </a>
            <a href="{{ route('news.index') }}">
                <i class="fa-solid fa-newspaper text-gold w-6"></i> Engineering Journal
            </a>
        </div>

        {{-- Recognition --}}
        <div class="mobile-section">
            <span class="section-title">Recognition</span>
            <a href="{{ route('awards') }}">
                <i class="fa-solid fa-award text-gold w-6"></i> Awards &amp; Honours
            </a>
            <a href="{{ route('media') }}">
                <i class="fa-solid fa-bullhorn text-gold w-6"></i> Press &amp; Media
            </a>
        </div>

        {{-- Community & Careers --}}
        <div class="mobile-section">
            <span class="section-title">Community &amp; Talent</span>
            <a href="{{ route('culture') }}">
                <i class="fa-solid fa-users-rays text-gold w-6"></i> Staff Activities
            </a>
            <a href="{{ route('careers') }}">
                <i class="fa-solid fa-briefcase text-gold w-6"></i> Career Opportunities
            </a>
            <a href="{{ route('culture', ['category' => 'intern']) }}">
                <i class="fa-solid fa-user-graduate text-gold w-6"></i> Internship Programme
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('contact') }}" class="mobile-contact-btn">
            <i class="fa-solid fa-headset mr-2"></i> GET IN TOUCH
        </a>
        <a href="https://incredible-florentine-3dd88d.netlify.app/login.html" class="mobile-staff-btn">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> STAFF PORTAL
        </a>
    </div>
</div>

<!-- Mobile Bottom Navigation Bar (Footer Menu) -->
<div class="mobile-bottom-nav" id="mobileBottomNav">
    <a href="{{ route('projects.index') }}" class="bottom-nav-item {{ str_contains($currentRoute, 'projects') ? 'active' : '' }}">
        <i class="fa-solid fa-city"></i>
        <span>PROJECTS</span>
    </a>

    <a href="{{ route('services.index') }}" class="bottom-nav-item {{ $currentRoute == 'services.index' ? 'active' : '' }}">
        <i class="fa-solid fa-compass-drafting"></i>
        <span>SERVICES</span>
    </a>

    <div class="bottom-nav-center-wrapper">
        <a href="/" class="bottom-nav-center-btn" aria-label="Home">
            <i class="fa-solid fa-house"></i>
        </a>
    </div>

    <a href="{{ route('contact') }}" class="bottom-nav-item {{ $currentRoute == 'contact' ? 'active' : '' }}">
        <i class="fa-solid fa-headset"></i>
        <span>CONTACT</span>
    </a>

    {{-- 🌟 CLIENT REQUESTED LABEL CHANGE: 'MORE' instead of 'MENU' 🌟 --}}
    <a href="#" class="bottom-nav-item" id="bottomNavMenuToggle" aria-label="Open More Menu">
        <i class="fa-solid fa-table-cells-large"></i>
        <span>MORE</span>
    </a>
</div>

<style>
    /* Navbar specific styles */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 90px;
        background: transparent;
        z-index: 1000;
        transition: var(--transition-premium);
        display: flex;
        align-items: center;
    }

    .navbar-scrolled {
        height: 70px;
        background: rgba(253, 252, 249, 0.98);
        backdrop-filter: blur(15px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .navbar-inner {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo-img { 
        height: 80px; 
        clip-path: polygon(0 0, 100% 0, 100% 55%, 0 55%);
        margin-bottom: -36px;
        margin-top: 8px;
        transition: var(--transition-premium); 
    }
    .navbar-scrolled .logo-img { 
        height: 65px; 
        margin-bottom: -29px;
        margin-top: 4px;
    }

    .nav-menu {
        display: none;
        list-style: none;
        align-items: center;
        gap: 35px;
        margin: 0;
        padding: 0;
    }

    @media (min-width: 1024px) { .nav-menu { display: flex; } }

    .nav-link {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--white);
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: var(--transition-premium);
        padding: 10px 0;
        position: relative;
    }

    .navbar-scrolled .nav-link,
    .navbar-dark-text .nav-link { color: var(--navy); }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gold);
        transition: var(--transition-premium);
    }

    .nav-link:hover::after, .nav-link.active::after { width: 100%; }
    .nav-link:hover, .nav-link.active { color: var(--gold) !important; }

    /* Dropdown */
    .dropdown { position: relative; }
    .dropdown-content {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: var(--white);
        min-width: 650px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.15);
        opacity: 0;
        visibility: hidden;
        transition: var(--transition-premium);
        border-radius: 12px;
        padding: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        z-index: 100;
    }

    .dropdown:hover > .dropdown-content {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    .dropdown-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .dropdown-column a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        color: var(--navy);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: var(--transition-premium);
    }

    .dropdown-column a i { color: var(--gold); width: 20px; }
    .dropdown-column a:hover { color: var(--gold); transform: translateX(5px); }

    .nested-items { padding-left: 32px; margin-top: 5px; border-left: 1px solid #eee; }
    .nested-items a { font-size: 0.75rem; color: #6B7280; font-weight: 500; }

    /* Mobile Toggle */
    .mobile-toggle { display: none; background: none; border: none; cursor: pointer; padding: 5px; }
    .hamburger-box { width: 30px; height: 24px; position: relative; }
    .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after {
        width: 30px; height: 2px; background: var(--white); position: absolute; transition: var(--transition-premium); border-radius: 4px;
    }
    .hamburger-inner { top: 50%; transform: translateY(-50%); }
    .hamburger-inner::before { content: ""; top: -8px; }
    .hamburger-inner::after { content: ""; bottom: -8px; }

    .navbar-scrolled .hamburger-inner,
    .navbar-scrolled .hamburger-inner::before,
    .navbar-scrolled .hamburger-inner::after,
    .navbar-dark-text .hamburger-inner,
    .navbar-dark-text .hamburger-inner::before,
    .navbar-dark-text .hamburger-inner::after { background: var(--navy); }

    @media (max-width: 1023px) { 
        .mobile-toggle { display: block; }
        .navbar-inner { padding: 0 15px !important; }
        .logo-img {
            max-width: 160px !important;
            height: auto !important;
            max-height: 55px !important;
            clip-path: none !important;
            margin: 0 !important;
            object-fit: contain;
        }
        .navbar-scrolled .logo-img {
            max-height: 48px !important;
            margin: 0 !important;
        }
    }

    /* 🌟 CLIENT REQUESTED LEFT MENU DRAWER 🌟 */
    .mobile-sidebar {
        position: fixed;
        top: 0;
        left: -100%; /* Slides from the Left! */
        width: 360px;
        max-width: 88vw;
        height: 100vh;
        background: var(--white);
        z-index: 2000;
        transition: left 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 20px 0 50px rgba(0,0,0,0.15); /* Shadow on the right side of the drawer */
        display: flex;
        flex-direction: column;
    }

    .mobile-sidebar.active { left: 0; }

    /* Immersive Glass Backdrop when mobile menu active */
    body::after {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(26, 36, 47, 0.55);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 1999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
        pointer-events: none;
    }
    body.mobile-menu-active::after {
        opacity: 1;
        visibility: visible;
    }
    .sidebar-header { padding: 25px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; }
    .mobile-logo { 
        max-width: 150px; 
        height: auto; 
        max-height: 50px;
        clip-path: none !important;
        margin: 0;
        object-fit: contain;
    }
    .mobile-close-btn { font-size: 2.2rem; color: var(--navy); cursor: pointer; line-height: 1; padding: 0 10px; }
    .sidebar-content { padding: 35px 30px; overflow-y: auto; flex: 1; }
    .mobile-link.main-link { font-family: 'Oswald', sans-serif; font-size: 1.4rem; font-weight: 700; color: var(--navy); margin-bottom: 25px; text-transform: uppercase; display: flex; align-items: center; }
    .mobile-section { margin-bottom: 35px; }
    .section-title { font-size: 0.72rem; font-weight: 800; color: var(--gold); letter-spacing: 2px; margin-bottom: 15px; display: block; text-transform: uppercase; }
    .mobile-section a { display: flex; align-items: center; padding: 14px 0; color: var(--navy); font-weight: 600; font-size: 0.95rem; border-bottom: 1px solid #f1f5f9; text-decoration: none; transition: all 0.3s ease; }
    .mobile-section a:hover { color: var(--gold); transform: translateX(4px); }
    .sidebar-footer { padding: 25px 30px; background: #f8fafc; display: flex; flex-direction: column; gap: 15px; border-top: 1px solid #e2e8f0; }
    .mobile-staff-btn { background: var(--navy); color: white; padding: 16px; border-radius: 12px; text-align: center; font-weight: 700; text-decoration: none; display: block; }
    .mobile-contact-btn { background: var(--gold); color: white; padding: 16px; border-radius: 12px; text-align: center; font-weight: 700; text-decoration: none; display: block; }

    .btn-contact-nav {
        background: var(--gold);
        color: white;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        transition: var(--transition-premium);
    }
    .btn-contact-nav:hover { background: var(--gold-dark); transform: scale(1.05); }

    /* ── Mobile Bottom Navigation Bar (Footer Menu) ── */
    .mobile-bottom-nav {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 72px;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 -4px 25px rgba(0, 0, 0, 0.08);
        z-index: 1050;
        justify-content: space-between;
        align-items: center;
        padding: 0 15px;
        transition: var(--transition-premium);
    }

    @media (max-width: 1023px) {
        .mobile-bottom-nav { display: flex; }
        body { padding-bottom: 72px !important; }
    }

    .bottom-nav-item {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        flex: 1; color: #64748b; text-decoration: none; transition: var(--transition-premium); gap: 4px; padding: 8px 0;
    }

    .bottom-nav-item i { font-size: 1.25rem; transition: transform 0.3s ease, color 0.3s ease; }
    .bottom-nav-item span { font-family: var(--bt-font-display, 'Oswald', sans-serif); font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
    .bottom-nav-item:hover, .bottom-nav-item.active { color: var(--gold, #c5a059); }
    .bottom-nav-item:hover i, .bottom-nav-item.active i { transform: translateY(-2px); color: var(--gold, #c5a059); }

    /* Central Floating Jewel Button */
    .bottom-nav-center-wrapper { display: flex; align-items: center; justify-content: center; flex: 1; position: relative; }
    .bottom-nav-center-btn {
        position: absolute; top: -36px; width: 64px; height: 64px; background: var(--gold, #c5a059);
        border: 4px solid #ffffff; border-radius: 20px; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 10px 25px rgba(197, 160, 89, 0.45); color: #ffffff; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 1060;
    }
    .bottom-nav-center-btn i { font-size: 1.6rem; color: #ffffff; transition: transform 0.3s ease; }
    .bottom-nav-center-btn:hover { background: var(--gold-hover, #b08d47); transform: translateY(-4px) scale(1.05); box-shadow: 0 15px 35px rgba(197, 160, 89, 0.6); color: #ffffff; }
    .bottom-nav-center-btn:hover i { transform: scale(1.1); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nav = document.getElementById('mainNav');
        const menuToggle = document.getElementById('menuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeMenu = document.getElementById('closeMenu');
        const bottomNavMenuToggle = document.getElementById('bottomNavMenuToggle');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 80) {
                nav.classList.add('navbar-scrolled');
            } else {
                nav.classList.remove('navbar-scrolled');
            }
        });

        if(menuToggle && mobileSidebar) {
            menuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                mobileSidebar.classList.add('active');
                document.body.classList.add('mobile-menu-active');
            });
        }
        if(closeMenu && mobileSidebar) {
            closeMenu.addEventListener('click', (e) => {
                e.stopPropagation();
                mobileSidebar.classList.remove('active');
                document.body.classList.remove('mobile-menu-active');
            });
        }
        if (bottomNavMenuToggle && mobileSidebar) {
            bottomNavMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                mobileSidebar.classList.add('active');
                document.body.classList.add('mobile-menu-active');
            });
        }
        
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (mobileSidebar && !mobileSidebar.contains(e.target) && 
                menuToggle && !menuToggle.contains(e.target) && 
                bottomNavMenuToggle && !bottomNavMenuToggle.contains(e.target) && 
                mobileSidebar.classList.contains('active')) {
                mobileSidebar.classList.remove('active');
                document.body.classList.remove('mobile-menu-active');
            }
        });
    });
</script>
