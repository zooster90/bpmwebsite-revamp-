<div x-data="{ mobileMenuOpen: false }" class="bt-mobile-nav-wrapper">
    
    <!-- ── BOTTOM SHEET OVERLAY ── -->
    <div 
        class="bt-mobile-sheet-overlay" 
        x-show="mobileMenuOpen" 
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="mobileMenuOpen = false"
        x-cloak
    ></div>

    <!-- ── BOTTOM SHEET MENU (PREMIUM REDESIGN) ── -->
    <div 
        class="bt-mobile-sheet"
        x-show="mobileMenuOpen"
        x-transition:enter="transition-transform ease-out duration-500 cubic-bezier(0.32, 0.72, 0, 1)"
        x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition-transform ease-in duration-400 cubic-bezier(0.32, 0.72, 0, 1)"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        x-cloak
    >
        <div class="bt-sheet-handle"></div>
        <div class="bt-sheet-header">
            <div>
                <h3 class="font-heading">Explore Portal</h3>
                <p class="bt-sheet-subtitle">Engineering Excellence since 1996</p>
            </div>
            <button @click="mobileMenuOpen = false" class="bt-sheet-close" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="bt-sheet-grid">
            <a href="{{ url('/about-us/brand-story') }}" class="bt-sheet-item">
                <div class="bt-sheet-icon"><i class="fas fa-history"></i></div>
                <span>Brand Story</span>
            </a>
            <a href="{{ url('/media-and-culture/awards-and-honors') }}" class="bt-sheet-item">
                <div class="bt-sheet-icon"><i class="fas fa-trophy"></i></div>
                <span>Awards</span>
            </a>
            <a href="{{ url('/media-and-culture/latest-news') }}" class="bt-sheet-item">
                <div class="bt-sheet-icon"><i class="fas fa-newspaper"></i></div>
                <span>News</span>
            </a>
            <a href="{{ url('/media-and-culture/staff-activities') }}" class="bt-sheet-item">
                <div class="bt-sheet-icon"><i class="fas fa-users-viewfinder"></i></div>
                <span>Culture</span>
            </a>
            <a href="{{ url('/careers') }}" class="bt-sheet-item">
                <div class="bt-sheet-icon"><i class="fas fa-id-card-clip"></i></div>
                <span>Careers</span>
            </a>
            <a href="{{ url('/contact') }}" class="bt-sheet-item">
                <div class="bt-sheet-icon"><i class="fas fa-paper-plane"></i></div>
                <span>Get in Touch</span>
            </a>
        </div>

        <div class="bt-sheet-footer">
            <div class="bt-sheet-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>HQ: Penang, Malaysia</span>
            </div>
        </div>
    </div>

    <!-- ── NAVIGATION BAR (PREMIUM GLASSMORPHISM) ── -->
    <nav class="bt-mobile-nav" aria-label="Mobile Navigation">
        <a href="{{ route('projects.index') }}" class="bt-mobile-nav-item {{ request()->is('projects*') ? 'active' : '' }}">
            <div class="bt-nav-icon-wrapper">
                <i class="fas fa-city"></i>
            </div>
            <span>Projects</span>
        </a>
        
        <a href="{{ url('/services') }}" class="bt-mobile-nav-item {{ request()->is('services*') ? 'active' : '' }}">
            <div class="bt-nav-icon-wrapper">
                <i class="fas fa-drafting-compass"></i>
            </div>
            <span>Services</span>
        </a>

        <!-- Center Floating Action (Home) -->
        <a href="{{ url('/') }}" class="bt-mobile-nav-item bt-mobile-nav-home">
            <div class="bt-home-btn-container">
                <div class="bt-home-btn-glow"></div>
                <div class="bt-home-btn">
                    <i class="fas fa-house"></i>
                </div>
            </div>
        </a>
        
        <a href="{{ url('/contact') }}" class="bt-mobile-nav-item {{ request()->is('contact*') ? 'active' : '' }}">
            <div class="bt-nav-icon-wrapper">
                <i class="fas fa-headset"></i>
            </div>
            <span>Contact</span>
        </a>
        
        <button type="button" class="bt-mobile-nav-item" @click="mobileMenuOpen = !mobileMenuOpen" :class="{ 'active': mobileMenuOpen }">
            <div class="bt-nav-icon-wrapper">
                <i class="fas fa-grip"></i>
            </div>
            <span>Menu</span>
        </button>
    </nav>
</div>

<style>
/* ── GLOBAL MOBILE FIXES ── */
@media (max-width: 768px) {
    html, body {
        overflow-x: hidden;
        max-width: 100vw;
    }
    body {
        padding-bottom: calc(85px + env(safe-area-inset-bottom)) !important;
    }
}

[x-cloak] { display: none !important; }

/* ── BOTTOM SHEET (PREMIUM) ── */
.bt-mobile-sheet-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 19, 38, 0.7);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 99998;
}

.bt-mobile-sheet {
    position: fixed;
    bottom: calc(10px + env(safe-area-inset-bottom));
    left: 10px;
    right: 10px;
    width: calc(100% - 20px);
    background: #ffffff;
    border-radius: 28px;
    box-shadow: 0 -20px 60px rgba(0,0,0,0.2);
    z-index: 99999;
    padding: 24px;
    display: flex;
    flex-direction: column;
}

.bt-sheet-handle {
    width: 36px;
    height: 5px;
    background: #e2e8f0;
    border-radius: 10px;
    margin: 0 auto 24px;
}

.bt-sheet-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 28px;
}

.bt-sheet-header h3 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1.5rem;
    font-weight: 800;
    color: #0A1326;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bt-sheet-subtitle {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 2px;
    font-weight: 500;
}

.bt-sheet-close {
    background: #F1F5F9;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0A1326;
    cursor: pointer;
    transition: all 0.2s;
}

.bt-sheet-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 24px;
}

.bt-sheet-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    gap: 10px;
    padding: 16px 8px;
    border-radius: 20px;
    transition: all 0.2s;
}

.bt-sheet-item:active {
    background: #F8FAFC;
    transform: scale(0.95);
}

.bt-sheet-icon {
    width: 54px;
    height: 54px;
    border-radius: 16px;
    background: #F8FAFC;
    border: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #C5A059;
    transition: all 0.3s;
}

.bt-sheet-item:active .bt-sheet-icon {
    background: #ffffff;
    border-color: #C5A059;
}

.bt-sheet-item span {
    font-size: 10px;
    font-weight: 700;
    color: #1E293B;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    text-align: center;
}

.bt-sheet-footer {
    border-top: 1px solid #F1F5F9;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.bt-sheet-location {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #64748b;
    font-size: 0.85rem;
    font-weight: 500;
}

.bt-sheet-location i {
    color: #C5A059;
}

/* ── NAVIGATION BAR ── */
.bt-mobile-nav {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: calc(75px + env(safe-area-inset-bottom));
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-top: 1px solid rgba(0,0,0,0.05);
    z-index: 99997;
    padding-bottom: env(safe-area-inset-bottom);
}

@media (max-width: 768px) {
    .bt-mobile-nav {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }
}

.bt-mobile-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94A3B8;
    text-decoration: none;
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    height: 75px;
    width: 20%;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    background: none;
    position: relative;
}

.bt-nav-icon-wrapper {
    position: relative;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 4px;
}

.bt-mobile-nav-item i {
    font-size: 20px;
    transition: all 0.3s;
}

.bt-mobile-nav-item.active {
    color: #C5A059;
}

.bt-mobile-nav-item.active .bt-nav-icon-wrapper i {
    transform: translateY(-2px);
    filter: drop-shadow(0 4px 8px rgba(197, 160, 89, 0.3));
}

.bt-mobile-nav-item::after {
    content: '';
    position: absolute;
    bottom: 12px;
    width: 4px;
    height: 4px;
    background: #C5A059;
    border-radius: 50%;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s;
}

.bt-mobile-nav-item.active::after {
    opacity: 1;
    transform: translateY(0);
}

/* Home Button Container */
.bt-mobile-nav-home {
    overflow: visible;
}

.bt-home-btn-container {
    position: relative;
    z-index: 10;
    margin-top: -30px;
}

.bt-home-btn-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: radial-gradient(circle, rgba(197, 160, 89, 0.4) 0%, transparent 70%);
    border-radius: 50%;
    z-index: -1;
}

.bt-home-btn {
    background: linear-gradient(135deg, #C5A059 0%, #A68546 100%);
    width: 58px;
    height: 58px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(197, 160, 89, 0.3);
    border: 4px solid #ffffff;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.bt-home-btn i {
    font-size: 24px;
    color: #ffffff !important;
}

.bt-mobile-nav-home:active .bt-home-btn {
    transform: scale(0.9);
}
</style>

</style>
