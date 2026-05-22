<?php $__env->startSection('title', 'Industry Resources | Builtech Project Management'); ?>

<?php $__env->startSection('content'); ?>

<style>
    :root {
        --white: #ffffff;
        --off-white: #fcfbf8;
        --gold: #c5a059;
        --navy: #001F3F; 
        --text-main: #1a1a2e;
        --text-light: #718096;
        --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        --shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* --- HERO HEADER --- */
    .links-hero {
        padding: 180px 5% 100px;
        background: var(--navy);
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .links-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://www.transparenttextures.com/patterns/dark-matter.png');
        opacity: 0.1;
    }

    .links-hero h1 {
        font-family: 'Oswald', sans-serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        letter-spacing: 4px;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .links-hero p {
        font-size: 0.85rem;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 4px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    /* --- LINKS GRID --- */
    .links-section {
        max-width: 1200px;
        margin: -50px auto 100px;
        padding: 0 20px;
        position: relative;
        z-index: 10;
    }

    .links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .link-card {
        background: var(--white);
        padding: 50px 30px;
        border-radius: 16px;
        text-align: center;
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .link-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.08);
        border-color: rgba(197, 160, 89, 0.3);
    }

    .link-logo-container {
        height: 100px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }

    .link-card img {
        max-height: 80px;
        max-width: 80%;
        object-fit: contain;
        filter: grayscale(100%);
        transition: var(--transition);
        opacity: 0.8;
    }

    .link-card:hover img {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.05);
    }

    .link-card h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.4rem;
        color: var(--navy);
        margin-bottom: 15px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .link-card p {
        font-size: 0.9rem;
        color: var(--text-light);
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .link-btn {
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 2px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }

    .link-btn i {
        font-size: 0.8rem;
    }

    @media (max-width: 768px) {
        .links-hero { padding: 140px 5% 80px; }
        .links-hero h1 { font-size: 2.2rem; }
    }
</style>

<header class="links-hero">
    <div class="reveal">
        <h1>RESOURCES</h1>
        <p>Official Industry Portals</p>
    </div>
</header>

<section class="links-section">
    <div class="links-grid">
        
        <a href="https://www.cidb.gov.my" target="_blank" class="link-card reveal delay-100">
            <div class="link-logo-container">
                <img src="<?php echo e(asset('img/images/cidb_logo-768x250.png')); ?>" alt="CIDB Malaysia">
            </div>
            <h3>CIDB Malaysia</h3>
            <p>Construction Industry Development Board official regulatory body and industry lead.</p>
            <span class="link-btn">Access Portal <i class="fas fa-external-link-alt"></i></span>
        </a>

        
        <a href="https://www.jkr.gov.my" target="_blank" class="link-card reveal delay-200">
            <div class="link-logo-container">
                <img src="<?php echo e(asset('img/images/t_500x300.jpg')); ?>" alt="JKR Malaysia">
            </div>
            <h3>JKR Malaysia</h3>
            <p>Public Works Department (Jabatan Kerja Raya) official portal for national infrastructure.</p>
            <span class="link-btn">Access Portal <i class="fas fa-external-link-alt"></i></span>
        </a>

        
        <a href="https://www.mbpp.gov.my" target="_blank" class="link-card reveal delay-300">
            <div class="link-logo-container">
                <img src="<?php echo e(asset('img/images/OIP (1).jpg')); ?>" alt="MBPP Penang">
            </div>
            <h3>MBPP</h3>
            <p>City Council of Penang Island (Majlis Bandaraya Pulau Pinang) local government.</p>
            <span class="link-btn">Access Portal <i class="fas fa-external-link-alt"></i></span>
        </a>

        
        <a href="https://www.mbsp.gov.my" target="_blank" class="link-card reveal delay-400">
            <div class="link-logo-container">
                <img src="<?php echo e(asset('img/images/OIP.jpg')); ?>" alt="MBSP Penang">
            </div>
            <h3>MBSP</h3>
            <p>Seberang Perai City Council (Majlis Bandaraya Seberang Perai) municipal authority.</p>
            <span class="link-btn">Access Portal <i class="fas fa-external-link-alt"></i></span>
        </a>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/links.blade.php ENDPATH**/ ?>