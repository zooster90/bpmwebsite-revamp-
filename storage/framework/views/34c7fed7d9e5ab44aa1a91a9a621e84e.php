<?php $__env->startSection('title', $service->title . ' | Builtech Services'); ?>
<?php $__env->startSection('description', $service->short_description); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .service-detail-hero {
        position: relative;
        min-height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--white);
        padding: 160px 5% 80px;
        background: #000;
        overflow: hidden;
        border-bottom: 3px solid var(--gold);
    }
    .service-detail-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('<?php echo e($service->image_path ? asset("storage/".$service->image_path) : "https://images.unsplash.com/photo-1541888081628-ebec21e25e2e?q=80&w=1920"); ?>') center/cover no-repeat;
        opacity: 0.45;
        animation: slowZoom 20s infinite alternate ease-in-out;
    }
    .service-detail-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(10,25,47,0.96) 0%, rgba(10,25,47,0.65) 100%);
    }
    .service-detail-inner { position: relative; z-index: 2; max-width: 820px; }
    
    .service-content-wrapper {
        background: var(--off-white);
        padding: 80px 5% 100px;
    }
    .service-content-container {
        max-width: 900px;
        margin: 0 auto;
        background: var(--white);
        padding: 4rem;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
    }
    .service-icon-header {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 90px; height: 90px;
        background: rgba(197,160,89,0.1);
        color: var(--gold);
        border-radius: 50%;
        font-size: 2.5rem;
        margin: -80px auto 2rem;
        border: 4px solid var(--white);
        box-shadow: var(--shadow-sm);
        position: relative;
        z-index: 10;
    }

    .service-body {
        font-size: 1.05rem;
        line-height: 1.85;
        color: var(--text-body);
    }
    .service-body h2 {
        font-family: 'Oswald', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--navy);
        margin: 2rem 0 1rem;
        text-transform: uppercase;
    }
    .service-body h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--navy);
        margin: 1.5rem 0 0.8rem;
    }
    .service-body p { margin-bottom: 1.5rem; }
    .service-body ul { margin-bottom: 1.5rem; padding-left: 1.5rem; }
    .service-body li { margin-bottom: 0.5rem; }
    
    .back-btn {
        display: inline-flex; align-items: center; gap: 8px;
        color: var(--navy); font-weight: 800; font-size: 0.85rem;
        text-transform: uppercase; letter-spacing: 0.1em;
        text-decoration: none; margin-bottom: 2rem;
        transition: var(--transition);
    }
    .back-btn:hover { color: var(--gold); transform: translateX(-5px); }

    @media (max-width: 768px) {
        .service-content-container { padding: 2rem 1.5rem; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bt-wrapper">
    <header class="service-detail-hero">
        <div class="service-detail-inner reveal">
            <span class="section-label" style="justify-content:center;">Our Services</span>
            <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(2.5rem,5vw,4.5rem); text-transform:uppercase; line-height:1.1; font-weight:700; margin-bottom:1rem;">
                <?php echo e($service->title); ?>

            </h1>
            <p style="font-size:1.1rem; color:rgba(255,255,255,0.8); max-width:600px; margin:0 auto;">
                <?php echo e($service->short_description); ?>

            </p>
        </div>
    </header>

    <div class="service-content-wrapper">
        <div class="bt-container">
            <div class="service-content-container reveal">
                <a href="<?php echo e(route('services.index')); ?>" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Services</a>
                
                <div class="service-icon-header">
                    <i class="<?php echo e($service->icon_class); ?>"></i>
                </div>
                
                <div class="service-body">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($service->content): ?>
                        <?php echo $service->content; ?>

                    <?php else: ?>
                        <p>Detailed information about <?php echo e($service->title); ?> will be updated soon. Please check back later or contact us directly for inquiries.</p>
                        <div style="margin-top:2rem;">
                            <a href="<?php echo e(route('contact')); ?>" class="bt-btn bt-btn-primary">Contact Us</a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/service-details.blade.php ENDPATH**/ ?>