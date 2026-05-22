<?php $__env->startSection('title', 'Awards & Recognition | Builtech'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <style>
        .bt-sticky-jump {
            position: sticky;
            top: 100px;
            z-index: 40;
            margin-top: -3rem;
        }
        .bt-cat-anchor {
            background: #FFFFFF;
            border: 1px solid var(--border);
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            border-radius: 8px;
            height: 100%;
            text-decoration: none !important;
        }
        .bt-cat-anchor:hover {
            border-color: var(--gold);
            transform: translateY(-3px);
            background: #FFF;
            box-shadow: var(--shadow-md);
        }
        .bt-cat-anchor img {
            height: 40px;
            width: auto;
            object-fit: contain;
            filter: grayscale(1);
            transition: all 0.5s;
            opacity: 0.45;
        }
        .bt-cat-anchor:hover img { filter: grayscale(0); opacity: 1; }
        .bt-cat-anchor span {
            margin-top: 0.6rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            text-align: center;
        }
        
        .award-plaque {
            background: #FFFFFF;
            border: 1px solid var(--border);
            padding: 3rem 2.5rem;
            position: relative;
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 12px;
        }
        .award-plaque::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 0; height: 3px;
            background: var(--gold);
            border-radius: 3px 3px 0 0;
            transition: width 0.7s var(--ease);
        }
        .award-plaque:hover::before { width: 100%; }
        .award-plaque:hover {
            border-color: var(--border-gold);
            box-shadow: var(--shadow-md);
            transform: translateY(-10px);
        }
        .timeline-year {
            font-family: 'Oswald', sans-serif;
            font-size: 5rem;
            font-weight: 900;
            color: rgba(10, 25, 47, 0.025);
            position: absolute;
            top: -1rem;
            right: 1.5rem;
            line-height: 1;
            pointer-events: none;
            transition: all 0.5s;
        }
        .award-plaque:hover .timeline-year {
            color: rgba(197, 160, 89, 0.06);
            transform: scale(1.1);
        }
        
        .award-section-header {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            margin-bottom: 5rem;
        }
        .award-section-title {
            font-family: 'Oswald', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--navy);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        .award-milestones-line {
            height: 2px;
            width: 60px;
            background: var(--gold);
        }
        .award-milestones-text {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.3em;
        }
        
        @media (max-width: 768px) {
            .bt-section { padding-top: 3rem !important; }
            .bt-cat-anchor { padding: 0.75rem; }
            .award-plaque { padding: 1.5rem 1.25rem; border-radius: 16px; background: rgba(255, 255, 255, 0.95); box-shadow: 0 4px 20px rgba(0,0,0,0.04); }
            .timeline-year { font-size: 3rem; right: 0.75rem; top: -0.2rem; }
            .award-title-text { font-size: 1.15rem !important; }
            
            .award-section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.25rem;
                margin-bottom: 3rem;
            }
            .award-section-title {
                font-size: 1.45rem;
            }
            .award-milestones-line {
                width: 30px;
            }
            .award-milestones-text {
                letter-spacing: 0.15em;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bt-wrapper bg-[#FBFBFA]">
    <!-- Hero Section -->
    <section style="background:var(--navy); padding:160px 5% 90px; position:relative; overflow:hidden;">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gold rounded-full blur-[150px] -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-white rounded-full blur-[120px] translate-y-1/2 -translate-x-1/4 opacity-20"></div>
        </div>
        <div class="bt-container relative z-10 reveal">
            <div class="max-w-4xl">
                <span class="section-label">The Builtech Archive</span>
                <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(3rem,6vw,5.5rem); font-weight:700; color:white; text-transform:uppercase; line-height:1.05; margin-bottom:1rem;">
                    Awards &amp; <span style="color:var(--gold);">Recognition.</span>
                </h1>
                <p style="font-size:1.05rem; color:rgba(255,255,255,0.72); max-width:600px; line-height:1.85; font-family:'Montserrat',sans-serif;">
                    An uncompromising commitment to engineering excellence, documented through decades of industry-leading certifications and national recognition.
                </p>
            </div>
        </div>
    </section>

    <!-- Sticky Jump Navigation -->
    <div class="bt-sticky-jump">
        <div class="bt-container">
            <div class="bt-glass-card p-3 rounded-sm flex justify-center">
                <div class="grid grid-cols-3 md:grid-cols-6 gap-3 w-full">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <a href="#cat-<?php echo e($id); ?>" class="bt-cat-anchor">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category['img']): ?>
                                <img src="<?php echo e($category['img']); ?>" alt="<?php echo e($category['title']); ?>">
                            <?php else: ?>
                                <i class="fa-solid fa-award text-gold/30"></i>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span><?php echo e($category['title']); ?></span>
                        </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Awards Display -->
    <section class="bt-section bg-transparent pt-32">
        <div class="bt-container">
            <div class="space-y-48">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div id="cat-<?php echo e($id); ?>" class="reveal scroll-mt-48">
                        <!-- Section Header -->
                        <div class="award-section-header">
                            <div class="flex-shrink-0 bt-glow">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category['img']): ?>
                                    <img src="<?php echo e($category['img']); ?>" alt="<?php echo e($category['title']); ?>" class="h-20 w-auto object-contain">
                                <?php else: ?>
                                    <div class="w-20 h-20 bg-white border border-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-award text-3xl text-gold"></i>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="flex-1">
                                <h2 class="award-section-title"><?php echo e($category['title']); ?></h2>
                                <div style="display:flex; align-items:center; gap:1rem; margin-top:0.5rem;">
                                    <div class="award-milestones-line"></div>
                                    <span class="award-milestones-text"><?php echo e(count($category['data'])); ?> Milestones</span>
                                </div>
                            </div>
                        </div>

                        <!-- Records Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-12 pb-10">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $category['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="award-plaque group reveal" style="transition-delay: <?php echo e($loop->index * 75); ?>ms;">
                                    <div class="timeline-year"><?php echo e($item['year']); ?></div>
                                    
                                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem; position:relative; z-index:10;">
                                        <span style="font-size:0.82rem; font-weight:800; color:var(--navy); border-bottom:2px solid var(--gold); padding-bottom:4px; text-transform:uppercase; letter-spacing:0.1em;"><?php echo e($item['year']); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['img']): ?>
                                            <a href="<?php echo e($item['img']); ?>" class="glightbox">
                                                <div class="w-20 h-20 bg-off-white flex items-center justify-center p-3 grayscale group-hover:grayscale-0 transition-all duration-700">
                                                    <img src="<?php echo e($item['img']); ?>" alt="<?php echo e($item['title']); ?>" class="w-full h-full object-contain">
                                                </div>
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    
                                        <h4 style="font-family:'Oswald',sans-serif; font-weight:700; color:var(--navy); margin-bottom:0.75rem; line-height:1.25; transition:color 0.4s; position:relative; z-index:10;" class="group-hover:text-gold text-xl md:text-[1.35rem] award-title-text"><?php echo e($item['title']); ?></h4>
                                        <p style="color:var(--text-muted); line-height:1.7; margin-bottom:1.5rem; position:relative; z-index:10;" class="text-sm md:text-[0.97rem] line-clamp-3 md:line-clamp-none"><?php echo e($item['remarks']); ?></p>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['starRating'] || $item['grade'] || $item['score'] || $item['certLevel']): ?>
                                        <div style="margin-top:auto; padding-top:1.2rem; border-top:1px solid #f3f4f6; display:flex; flex-wrap:wrap; gap:1.5rem; align-items:center; position:relative; z-index:10;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['starRating']): ?>
                                                <div class="flex gap-1.5">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i=0; $i<(int)$item['starRating']; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <i class="fa-solid fa-star text-gold text-xs"></i>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['grade']): ?>
                                                    <div style="display:flex; flex-direction:column;">
                                                        <span style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.2em; color:var(--text-muted); font-weight:700; margin-bottom:4px;">Rating</span>
                                                        <span style="font-size:0.85rem; font-weight:800; color:var(--navy);">GRADE <?php echo e($item['grade']); ?></span>
                                                    </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['score']): ?>
                                                    <div style="display:flex; flex-direction:column;">
                                                        <span style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.2em; color:var(--text-muted); font-weight:700; margin-bottom:4px;">Score</span>
                                                        <span style="font-size:1.4rem; font-weight:800; color:var(--gold);"><?php echo e($item['score']); ?></span>
                                                    </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Support/Contact CTA -->
    <section style="background:white; padding:100px 5%; text-align:center; border-top:1px solid var(--border);">
        <div class="bt-container reveal" style="max-width:800px;">
            <span class="section-label">Engineering Excellence</span>
            <h2 class="section-title">Engineered for <br><span style="color:var(--gold);">Generations.</span></h2>
            <p style="font-size:1.05rem; color:var(--text-muted); max-width:640px; margin:0 auto 2.5rem; line-height:1.85;">Our milestones reflect a deep-rooted commitment to Malaysia's skyline. Join us in building a future defined by quality and integrity.</p>
            <a href="<?php echo e(route('contact')); ?>" class="btn-primary">
                <i class="fas fa-handshake"></i> Request Consultation
            </a>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/awards.blade.php ENDPATH**/ ?>