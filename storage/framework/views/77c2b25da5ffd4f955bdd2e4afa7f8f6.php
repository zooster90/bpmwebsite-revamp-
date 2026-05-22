<?php $__env->startSection('title', 'Sustainability | ESG Commitment & ISO Certification | Builtech'); ?>
<?php $__env->startSection('description', 'Builtech\'s commitment to Environmental, Social & Governance (ESG) excellence. Triple ISO certified — 9001, 45001, 14001 — for quality, safety and environmental responsibility since 1996.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ═══════════════════════════════════════════════════════
       SUSTAINABILITY - EMINENCE EDITION
       The Blueprint for a Responsible Future
       ═══════════════════════════════════════════════════════ */
    
    /* 1. Sustainability Hero */
    .bt-su-hero {
        height: 60vh;
        min-height: 550px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bt-navy);
        overflow: hidden;
    }
    .bt-su-hero::before {
        content: ''; position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2000') center/cover no-repeat;
        opacity: 0.25;
        mix-blend-mode: luminosity;
        animation: slowZoom 25s infinite alternate ease-in-out;
    }
    
    .bt-su-hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 900px;
        padding: 0 5%;
    }

    /* 2. ESG Pillar Grid */
    .bt-esg-pillar {
        background: #fff;
        padding: 5rem 4rem;
        border-radius: 4px;
        text-align: center;
        border: 1px solid #F1F1F1;
        transition: all 0.6s var(--bt-ease);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .bt-esg-pillar:hover { transform: translateY(-10px); box-shadow: var(--bt-shadow-lg); border-color: var(--bt-gold); }
    .bt-esg-pillar::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 3px;
        background: var(--bt-gold); transition: width 0.6s var(--bt-ease);
    }
    .bt-esg-pillar:hover::after { width: 100%; }

    .bt-esg-icon {
        width: 80px; height: 80px; background: #FBFBFA; color: var(--bt-gold);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 2.5rem; font-size: 2.2rem; transition: all 0.5s;
    }
    .bt-esg-pillar:hover .bt-esg-icon { background: var(--bt-gold); color: #fff; transform: rotateY(180deg); }
    .bt-esg-pillar h3 { font-family: var(--bt-font-display); font-weight: 800; font-size: 1.1rem; text-transform: uppercase; color: var(--bt-navy); margin-bottom: 1.5rem; letter-spacing: 0.1em; }
    .bt-esg-pillar p { font-size: 0.85rem; color: var(--bt-text-muted); line-height: 1.7; flex-grow: 1; }

    /* 3. CSR Collage Layout */
    .bt-csr-split {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 8rem;
        align-items: center;
    }
    .bt-csr-media {
        position: relative;
        padding: 1.5rem;
        background: #fff;
        box-shadow: 25px 25px 0 var(--bt-gold-light);
        border-radius: 4px;
        border: 1px solid #F1F1F1;
        transition: all 0.6s var(--bt-ease);
    }
    .bt-csr-media:hover { transform: translateY(-10px); box-shadow: 35px 35px 0 rgba(197,160,89,0.15); }
    .bt-csr-media img { width: 100%; border-radius: 2px; }

    /* 4. Certification Cards */
    .bt-cert-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
    }
    .bt-cert-card {
        background: #fff;
        padding: 4rem 3rem;
        border-radius: 4px;
        text-align: center;
        border: 1px solid #F1F1F1;
        transition: all 0.5s var(--bt-ease);
        cursor: pointer;
    }
    .bt-cert-card:hover { transform: translateY(-8px); box-shadow: var(--bt-shadow-lg); border-color: var(--bt-gold); }
    .bt-cert-card img { height: 100px; width: auto; margin: 0 auto 2.5rem; mix-blend-mode: multiply; filter: contrast(1.1); }
    .bt-cert-card h4 { font-family: var(--bt-font-display); font-weight: 900; color: var(--bt-navy); font-size: 1.1rem; text-transform: uppercase; margin-bottom: 0.5rem; }
    .bt-cert-card p { font-size: 0.75rem; color: var(--bt-gold); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; }

    @media (max-width: 1024px) {
        .bt-csr-split { grid-template-columns: 1fr; gap: 6rem; }
        .bt-cert-grid { grid-template-columns: 1fr; gap: 2rem; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bt-wrapper">
    
    <!-- 1. HERO -->
    <header class="bt-su-hero">
        <div class="bt-su-hero-content reveal">
            <span class="bt-badge border-gold/40 text-gold bg-gold/10 mb-8 px-8 py-3">Environmental &bull; Social &bull; Governance</span>
            <h1 class="bt-title text-white text-6xl md:text-8xl mb-8 leading-tight">Sustainable <br><span class="bt-serif text-gold">Engineering.</span></h1>
            <p class="text-xl text-white/50 font-light max-w-2xl mx-auto">Integrating ecological responsibility and social equity into our engineering DNA.</p>
        </div>
    </header>

    <!-- 2. COMMITMENT PILLARS -->
    <section class="bt-section bg-white">
        <div class="bt-container">
            <div class="max-w-3xl mb-24 reveal">
                <span class="bt-badge border-navy/10 text-navy bg-navy/5 mb-8">Our Philosophy</span>
                <h2 class="bt-title text-6xl text-navy">Building a <br><span class="bt-serif text-gold">Better World.</span></h2>
                <p class="text-xl text-gray-400 font-light mt-8">At Builtech, sustainability is not a secondary goal — it is a primary mandate. We balance robust economic growth with rigorous environmental stewardship.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                
                <div class="reveal" data-delay="0">
                    <div class="bt-esg-pillar">
                        <div class="bt-esg-icon"><i class="fa-solid fa-leaf"></i></div>
                        <h3>Environmental</h3>
                        <p>We maintain strict protocols to sustain a green and clean environment on all project sites, relentlessly reducing the footprint of our industrial processes.</p>
                    </div>
                </div>
                
                <div class="reveal" data-delay="150">
                    <div class="bt-esg-pillar">
                        <div class="bt-esg-icon"><i class="fa-solid fa-people-roof"></i></div>
                        <h3>Social Equity</h3>
                        <p>Building communities, not just structures. We allocate yearly resources for higher education, youth sponsorships, and local community outreach.</p>
                    </div>
                </div>
                
                <div class="reveal" data-delay="300">
                    <div class="bt-esg-pillar">
                        <div class="bt-esg-icon"><i class="fa-solid fa-shield-heart"></i></div>
                        <h3>Health & Safety</h3>
                        <p>Governed by ISO 45001:2018, we ensure a zero-harm environment for our workforce and the public through daily rigorous site coordination.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CSR COLLAGE -->
    <section class="bt-section bg-[#FBFBFA]">
        <div class="bt-container">
            <div class="bt-csr-split">
                <div class="reveal">
                    <span class="bt-badge border-navy/10 text-navy bg-navy/5 mb-8">Community Impact</span>
                    <h2 class="bt-title text-6xl text-navy mb-10">Corporate <br><span class="bt-serif text-gold">Responsibility.</span></h2>
                    <p class="text-xl text-gray-400 font-light leading-relaxed mb-8">
                        True corporate success lies in the tangible, positive impact we create in the communities where we operate.
                    </p>
                    <p class="text-xl text-gray-400 font-light leading-relaxed mb-12">
                        We actively support university practical training programs to nurture the next generation of engineering talent. Internally, our recruitment is conducted purely on merit, upholding the highest industry standards of transparency and anti-corruption.
                    </p>
                    <a href="<?php echo e(route('culture')); ?>#csr" class="bt-btn bt-btn-primary">Explore CSR Activities</a>
                </div>
                <div class="reveal delay-200">
                    <div class="bt-csr-media">
                        <img src="<?php echo e(asset('img/images/csr_collage.jpg')); ?>" alt="CSR Activities Collage">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. CERTIFIED EXCELLENCE -->
    <section class="bt-section bg-white">
        <div class="bt-container">
            <div class="text-center mb-24 reveal">
                <span class="bt-badge border-navy/10 text-navy bg-navy/5 mb-8">Verified Standards</span>
                <h2 class="bt-title text-6xl text-navy">Triple ISO <span class="bt-serif text-gold">Authority.</span></h2>
            </div>

            <div class="bt-cert-grid">
                
                <div class="reveal" data-delay="0">
                    <div class="bt-cert-card" onclick="openGlobalLightbox('<?php echo e(asset('img/images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg')); ?>')">
                        <img src="<?php echo e(asset('img/images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg')); ?>" alt="ISO 9001">
                        <h4>ISO 9001:2015</h4>
                        <p>Quality Management System<br>MY 10/00630.01</p>
                    </div>
                </div>
                
                <div class="reveal" data-delay="150">
                    <div class="bt-cert-card" onclick="openGlobalLightbox('<?php echo e(asset('img/images/SGS_ISO 45001 DSM Mark_TCL_LR.jpg')); ?>')">
                        <img src="<?php echo e(asset('img/images/SGS_ISO 45001 DSM Mark_TCL_LR.jpg')); ?>" alt="ISO 45001">
                        <h4>ISO 45001:2018</h4>
                        <p>Health & Safety Management<br>MY 15/01790.01</p>
                    </div>
                </div>
                
                <div class="reveal" data-delay="300">
                    <div class="bt-cert-card" onclick="openGlobalLightbox('<?php echo e(asset('img/images/ISO_14001_Latest.jpg')); ?>')">
                        <img src="<?php echo e(asset('img/images/ISO_14001_Latest.jpg')); ?>" alt="ISO 14001">
                        <h4>ISO 14001:2015</h4>
                        <p>Environmental Management<br>6071254/E</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FINAL CTA -->
    <section class="bt-section py-64 bg-navy relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(var(--bt-gold) 1px, transparent 0); background-size: 40px 40px;"></div>
        <div class="bt-container relative z-10 text-center reveal">
            <h2 class="bt-title text-6xl md:text-8xl text-white mb-10 leading-tight">Together for a <br><span class="bt-serif text-gold">Better Future.</span></h2>
            <p class="text-xl text-gray-400 font-light max-w-2xl mx-auto mb-20">We are dedicated to building responsibly—delivering architectural projects while protecting our environment and communities.</p>
            <a href="<?php echo e(route('our-people')); ?>" class="bt-btn bt-btn-primary !px-16 !py-6">Meet Our People</a>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/sustainability.blade.php ENDPATH**/ ?>