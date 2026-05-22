<?php $__env->startSection('title', 'Corporate Governance | Vision, Mission & Quality Commitments | Builtech'); ?>
<?php $__env->startSection('description', 'Builtech Project Management\'s corporate governance framework — our Vision, Mission, guiding principles, and ISO-certified quality commitments. Established 1996, CIDB Grade G7.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ═══════════════════════════════════════════════════════
       CORPORATE - EMINENCE EDITION
       The Authority of Governance
       ═══════════════════════════════════════════════════════ */
    
    /* 1. Corporate Hero */
    .bt-corp-hero {
        height: 60vh;
        min-height: 550px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bt-navy);
        overflow: hidden;
    }
    .bt-corp-hero::before {
        content: ''; position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2000') center/cover no-repeat;
        opacity: 0.25;
        mix-blend-mode: luminosity;
        animation: slowZoom 25s infinite alternate ease-in-out;
    }
    
    .bt-corp-hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 900px;
        padding: 0 5%;
    }

    /* 2. Overlap Vision/Mission Cards */
    .bt-pillar-overlap {
        margin-top: -80px;
        position: relative;
        z-index: 50;
    }
    .bt-pillar-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2.5rem;
    }
    .bt-pillar-card {
        background: #fff;
        padding: 5rem 4rem;
        border-radius: 4px;
        box-shadow: var(--bt-shadow-lg);
        transition: all 0.6s var(--bt-ease);
        border: 1px solid #F1F1F1;
        position: relative;
        overflow: hidden;
    }
    .bt-pillar-card:hover { transform: translateY(-10px); border-color: var(--bt-gold); }
    .bt-pillar-card i { font-size: 2.5rem; color: var(--bt-gold); margin-bottom: 2rem; display: block; }
    .bt-pillar-card h3 { font-family: var(--bt-font-display); font-weight: 800; font-size: 1.5rem; text-transform: uppercase; color: var(--bt-navy); margin-bottom: 1.5rem; letter-spacing: 0.05em; }
    .bt-pillar-card p { font-size: 0.95rem; color: var(--bt-text-muted); line-height: 1.8; }

    /* 3. Operational Excellence Grid */
    .bt-op-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    .bt-op-item {
        background: #fff;
        padding: 3.5rem 2.5rem;
        border-radius: 4px;
        border: 1px solid #F1F1F1;
        transition: all 0.5s var(--bt-ease);
    }
    .bt-op-item:hover { transform: translateY(-8px); box-shadow: var(--bt-shadow-lg); border-color: var(--bt-gold); }
    .bt-op-item h4 { font-family: var(--bt-font-display); font-weight: 800; font-size: 0.9rem; text-transform: uppercase; color: var(--bt-gold); margin-bottom: 1.2rem; letter-spacing: 0.1em; display: flex; align-items: center; gap: 0.75rem; }
    .bt-op-item p { font-size: 0.85rem; color: var(--bt-text-muted); line-height: 1.7; }

    /* 4. Quality Section */
    .bt-quality-card {
        background: var(--bt-navy);
        padding: 6rem;
        border-radius: 4px;
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 6rem;
        align-items: center;
        color: #fff;
    }
    .bt-cert-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    .bt-cert-mini {
        background: rgba(255,255,255,0.05);
        padding: 2.5rem 1.5rem;
        border-radius: 4px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.4s;
    }
    .bt-cert-mini:hover { background: rgba(255,255,255,0.1); border-color: var(--bt-gold); }
    .bt-cert-mini img { height: 60px; width: auto; margin-bottom: 1.5rem; background: #fff; padding: 5px; border-radius: 2px; }
    .bt-cert-mini span { display: block; font-family: var(--bt-font-display); font-weight: 800; font-size: 0.65rem; text-transform: uppercase; color: var(--bt-gold); letter-spacing: 0.1em; }

    @media (max-width: 1024px) {
        .bt-pillar-grid { grid-template-columns: 1fr; }
        .bt-op-grid { grid-template-columns: repeat(2, 1fr); }
        .bt-quality-card { grid-template-columns: 1fr; padding: 3rem; gap: 4rem; }
    }
    @media (max-width: 768px) {
        .bt-op-grid { grid-template-columns: 1fr; }
        .bt-cert-row { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bt-wrapper">
    
    <!-- 1. HERO -->
    <header class="bt-corp-hero">
        <div class="bt-corp-hero-content reveal">
            <span class="bt-badge border-gold/40 text-gold bg-gold/10 mb-8 px-8 py-3">Established 1996</span>
            <h1 class="bt-title text-white text-6xl md:text-9xl mb-8 leading-[0.9]">Corporate <br><span style="font-family:'Oswald',sans-serif; font-style:italic; font-weight:700; color:var(--gold);">Governance.</span></h1>
            <p class="text-xl font-light max-w-2xl mx-auto" style="color:rgba(255,255,255,0.88);">The architecture of integrity, governing every landmark we build.</p>
        </div>
    </header>

    <!-- 2. PILLAR OVERLAP -->
    <div class="bt-container bt-pillar-overlap">
        <div class="bt-pillar-grid reveal">
            <div class="bt-pillar-card">
                <i class="fa-solid fa-eye"></i>
                <h3>Our Vision</h3>
                <p>To be an excellent builder to build your best living environment.</p>
            </div>
            <div class="bt-pillar-card">
                <i class="fa-solid fa-bullseye"></i>
                <h3>Our Mission</h3>
                <p>We are committed to deliver quality product through stringent quality control at highest integrity, achieving cost effectiveness. At Builtech, <strong style="color:var(--bt-gold);">We Built To Last.</strong></p>
            </div>
        </div>
    </div>

    <!-- 3. GUIDING PRINCIPLES -->
    <section class="bt-section bg-white" style="padding-top: 130px;">
        <div class="bt-container">
            <div class="max-w-3xl mb-24 reveal">
                <span class="bt-badge border-navy/10 text-navy bg-navy/5 mb-8">Guiding Principles</span>
                <h2 class="bt-title text-6xl text-navy">Corporate <br><span class="bt-serif text-gold">Statements.</span></h2>
                <p class="text-xl font-light mt-8" style="color:#6b7280;">Four core pillars that define our operational ethics and technical delivery across Malaysia.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="reveal" data-delay="0">
                    <div class="bt-op-item">
                        <h4><i class="fa-solid fa-scale-balanced"></i> Ethics</h4>
                        <p>All dealings are conducted with transparency, honesty, and full compliance with Malaysian Law and CIDB regulations.</p>
                    </div>
                </div>
                
                <div class="reveal" data-delay="100">
                    <div class="bt-op-item">
                        <h4><i class="fa-solid fa-award"></i> Quality</h4>
                        <p>Maintaining high CONQUAS and QLASSIC standards through meticulous site inspections and professional craftsmanship.</p>
                    </div>
                </div>
                
                <div class="reveal" data-delay="200">
                    <div class="bt-op-item">
                        <h4><i class="fa-solid fa-hard-hat"></i> Safety</h4>
                        <p>Committed to a zero-accident workplace by adhering to strict ISO 45001:2018 occupational health protocols.</p>
                    </div>
                </div>
                
                <div class="reveal" data-delay="300">
                    <div class="bt-op-item">
                        <h4><i class="fa-solid fa-seedling"></i> Environment</h4>
                        <p>Protecting our ecosystem through sustainable waste management and processes certified to ISO 14001:2015.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. OPERATIONAL EXCELLENCE -->
    <section class="bt-section bg-[#FBFBFA]">
        <div class="bt-container">
            <div class="max-w-3xl mb-24 reveal">
                <span class="bt-badge border-navy/10 text-navy bg-navy/5 mb-8">Execution Excellence</span>
                <h2 class="bt-title text-6xl text-navy">Operational <br><span class="bt-serif text-gold">Commitments.</span></h2>
            </div>

            <div class="bt-op-grid">
                <div class="bt-op-item reveal" data-delay="0">
                    <h4><i class="fa-solid fa-users-gear"></i> Our Team</h4>
                    <p>Strong project teams utilizing the latest technologies and good construction practices. Employees are viewed as family with work-life balance.</p>
                </div>
                <div class="bt-op-item reveal" data-delay="100">
                    <h4><i class="fa-solid fa-leaf"></i> Sustainability</h4>
                    <p>Control of site safety and environment aspects to ensure worker and public safety. Continuous Kaizen of work practices for efficiency.</p>
                </div>
                <div class="bt-op-item reveal" data-delay="200">
                    <h4><i class="fa-solid fa-handshake"></i> Stakeholders</h4>
                    <p>Emphasis on win-win situations with partners and subcontractors. Corporate culture of high business ethics and integrity.</p>
                </div>
                <div class="bt-op-item reveal" data-delay="300">
                    <h4><i class="fa-solid fa-chart-line"></i> Quality & Growth</h4>
                    <p>Monitoring construction materials and worker competencies. Research for better methodologies to meet CONQUAS standards.</p>
                </div>
                <div class="bt-op-item reveal" data-delay="400">
                    <h4><i class="fa-solid fa-heart"></i> Community</h4>
                    <p>Contribution through Corporate Social Responsibility sponsorship and community service annually across Malaysia.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. QUALITY ASSURED (TRIPLE ISO) -->
    <section class="bt-section bg-white">
        <div class="bt-container">
            <div class="bt-quality-card reveal">
                <div>
                    <span class="bt-badge border-white/20 text-white bg-white/5 mb-8">Verified Authority</span>
                    <h2 class="bt-title text-white text-5xl mb-10">Quality <br><span class="bt-serif text-gold">Assured.</span></h2>
                    <p class="text-white/60 font-light leading-relaxed">
                        Builtech is triple-certified under internationally recognised ISO management systems — validating our unwavering standards across quality, safety, and environmental stewardship.
                    </p>
                </div>
                <div class="bt-cert-row">
                    <div class="bt-cert-mini" onclick="openGlobalLightbox('<?php echo e(asset('img/images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg')); ?>')">
                        <img src="<?php echo e(asset('img/images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg')); ?>" alt="ISO 9001">
                        <span style="color: var(--bt-gold) !important;">ISO 9001:2015</span>
                    </div>
                    <div class="bt-cert-mini" onclick="openGlobalLightbox('<?php echo e(asset('img/images/SGS_ISO 45001 DSM Mark_TCL_LR.jpg')); ?>')">
                        <img src="<?php echo e(asset('img/images/SGS_ISO 45001 DSM Mark_TCL_LR.jpg')); ?>" alt="ISO 45001">
                        <span style="color: var(--bt-gold) !important;">ISO 45001:2018</span>
                    </div>
                    <div class="bt-cert-mini" onclick="openGlobalLightbox('<?php echo e(asset('img/images/ISO_14001_Latest.jpg')); ?>')">
                        <img src="<?php echo e(asset('img/images/ISO_14001_Latest.jpg')); ?>" alt="ISO 14001">
                        <span style="color: var(--bt-gold) !important;">ISO 14001:2015</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. FINAL CTA -->
    <section class="bt-section py-64 bg-navy relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(var(--bt-gold) 1px, transparent 0); background-size: 40px 40px;"></div>
        <div class="bt-container relative z-10 text-center reveal">
            <h2 class="bt-title text-6xl md:text-8xl text-white mb-10 leading-tight">Explore our <br><span class="bt-serif text-gold">Green Mandate.</span></h2>
            <p class="text-xl font-light max-w-2xl mx-auto mb-20" style="color:rgba(255,255,255,0.75);">Discover how our governance framework translates into real-world environmental stewardship.</p>
            <a href="<?php echo e(route('sustainability')); ?>" class="bt-btn bt-btn-primary !px-16 !py-6">Sustainability Commitment</a>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/corporate.blade.php ENDPATH**/ ?>