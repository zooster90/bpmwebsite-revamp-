<?php $__env->startSection('title', $project->meta_title ?: (($project->name ?? $project->title) . ' — Builtech Engineering Malaysia')); ?>
<?php $__env->startSection('description', $project->meta_description ?: ($project->description ?? 'Explore the engineering excellence and construction details of this Builtech project — CIDB Grade G7 contractor in Malaysia.')); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" />
<style>
    :root {
        --gold: #c5a059;
        --gold-light: #d4b88a;
        --navy: #1a242f;
        --navy-darker: #0d151f;
        --bg: #fcfbf9;
        --text-main: #334155;
        --text-light: #64748b;
        --transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        --shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--bg);
        background-image: radial-gradient(rgba(197, 160, 89, 0.05) 1px, transparent 1px);
        background-size: 30px 30px;
    }

    /* --- HERO --- */
    .project-hero {
        padding-top: 120px;
        padding-bottom: 60px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .project-tag {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(197, 160, 89, 0.1);
        border: 1px solid rgba(197, 160, 89, 0.2);
        color: var(--gold);
        font-family: 'Oswald', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.75rem;
        border-radius: 50px;
        margin-bottom: 24px;
    }

    .project-title {
        font-family: 'Oswald', sans-serif;
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        color: var(--navy);
        line-height: 1.1;
        text-transform: uppercase;
        margin-bottom: 40px;
        max-width: 900px;
    }

    /* --- SPEC BAR --- */
    .spec-bar {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.02);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
        margin-bottom: 60px;
        position: relative;
        z-index: 10;
    }

    .spec-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .spec-label {
        font-family: 'Oswald', sans-serif;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .spec-value {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--navy);
    }

    /* --- GALLERY --- */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 24px;
        margin-bottom: 80px;
    }

    .gallery-item {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        background: #eee;
    }

    .gallery-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.1);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .gallery-item:hover img { transform: scale(1.05); }

    .item-main { grid-column: span 12; height: 70vh; }
    .item-sub { grid-column: span 4; height: 350px; }

    @media (max-width: 992px) {
        .item-sub { grid-column: span 6; }
    }

    @media (max-width: 640px) {
        .item-sub { grid-column: span 12; }
        .item-main { height: 50vh; }
        .spec-bar { grid-template-columns: 1fr; gap: 24px; }
    }

    /* --- DESCRIPTION --- */
    .project-content {
        max-width: 800px;
        margin: 0 auto 100px;
        text-align: center;
    }

    .project-desc {
        font-size: 1.2rem;
        line-height: 1.8;
        color: var(--text-main);
        margin-bottom: 40px;
    }

    /* --- RELATED --- */
    .related-section {
        padding: 100px 0;
        background: var(--navy);
        color: white;
        border-radius: 40px 40px 0 0;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 32px;
        margin-top: 60px;
    }

    .related-card {
        background: rgba(255,255,255,0.05);
        border-radius: 20px;
        overflow: hidden;
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .related-card:hover {
        background: rgba(255,255,255,0.1);
        transform: translateY(-10px);
        border-color: var(--gold);
    }

    .related-img { width: 100%; height: 200px; object-fit: cover; }
    .related-body { padding: 24px; color: rgba(255, 255, 255, 0.85); }
    .related-title { font-family: 'Oswald', sans-serif; font-size: 1.2rem; text-transform: uppercase; margin-bottom: 8px; color: #ffffff; }

    /* --- REVEAL --- */
    .reveal { opacity: 0; transform: translateY(30px); transition: 1s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bt-wrapper">
<div class="bt-container">
    <header class="project-hero">
        <div class="reveal">
            <span class="project-tag"><?php echo e($project->category?->name ?? 'General'); ?></span>
            <h1 class="project-title"><?php echo e($project->name ?? $project->title); ?></h1>
        </div>

        <div class="spec-bar reveal">
            <div class="spec-item">
                <span class="spec-label"><i class="fas fa-map-marker-alt text-gold"></i> Location</span>
                <span class="spec-value"><?php echo e($project->location ?? 'Malaysia'); ?></span>
            </div>
            <div class="spec-item">
                <span class="spec-label"><i class="far fa-calendar-check text-gold"></i> Completion</span>
                <span class="spec-value"><?php echo e($project->year ?? $project->completion_year ?? 'Ongoing'); ?></span>
            </div>
            <div class="spec-item">
                <span class="spec-label"><i class="fas fa-tasks text-gold"></i> Sector</span>
                <span class="spec-value"><?php echo e($project->category?->name ?? 'Infrastructure'); ?></span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->client): ?>
                <div class="spec-item">
                    <span class="spec-label"><i class="fas fa-user-tie text-gold"></i> Client</span>
                    <span class="spec-value"><?php echo e($project->client); ?></span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </header>

    
    <section class="gallery-section">
        <?php
            $images = [];
            if ($project->hasMedia('cover_image')) {
                $images[] = $project->getFirstMediaUrl('cover_image');
            } elseif ($project->cover_image) {
                $images[] = asset('storage/' . $project->cover_image);
            } elseif ($project->image_url) {
                $images[] = str_starts_with($project->image_url, 'http') ? $project->image_url : asset($project->image_url);
            }

            // Add Gallery images
            if ($project->hasMedia('gallery')) {
                foreach($project->getMedia('gallery') as $media) {
                    $images[] = $media->getUrl();
                }
            } elseif ($project->gallery_uploads) {
                foreach($project->gallery_uploads as $path) {
                    $images[] = asset('storage/' . $path);
                }
            }

            // Remove duplicates and blanks
            $images = array_unique(array_filter($images));
            
            // Fallback if no images
            if(empty($images)) $images[] = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000';
        ?>

        <div class="gallery-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="gallery-item reveal <?php echo e($index === 0 ? 'item-main' : 'item-sub'); ?>">
                    
                    <a href="<?php echo e($img); ?>" data-type="image" data-gallery="project-gallery" class="glightbox" aria-label="View <?php echo e($project->name ?? $project->title); ?> photo <?php echo e($index + 1); ?>" oncontextmenu="return false;">
                        <img src="<?php echo e($img); ?>" alt="<?php echo e(($project->name ?? $project->title)); ?> — Builtech Engineering Malaysia" loading="<?php echo e($index === 0 ? 'eager' : 'lazy'); ?>" oncontextmenu="return false;">
                    </a>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </section>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->description): ?>
        <section class="project-content reveal">
            <div class="w-20 h-1 bg-gold mx-auto mb-12"></div>
            <div class="project-desc">
                <?php echo nl2br(e($project->description)); ?>

            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedProjects && $relatedProjects->count() > 0): ?>
    <section class="related-section">
        <div class="bt-container">
            <div class="flex justify-between items-end reveal">
                <div>
                    <span class="text-gold font-bold tracking-[3px] uppercase text-xs mb-2 block">Case Studies</span>
                    <h2 class="font-heading font-bold text-4xl uppercase">Similar Engineering <span class="text-gold">Works</span></h2>
                </div>
                <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-outline border-white text-white hover:bg-white hover:text-navy px-8 py-3 text-sm">View All</a>
            </div>

            <div class="related-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $relatedProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e($rel instanceof \App\Models\CurrentProject ? route('ongoing-projects.show', $rel->slug) : route('projects.show', $rel->slug)); ?>" class="related-card reveal">
                        <img src="<?php echo e($rel->display_image ?? 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=800'); ?>" class="related-img" alt="<?php echo e($rel->name ?? $rel->title); ?>">
                        <div class="related-body">
                            <span class="text-gold font-bold text-[10px] uppercase tracking-widest block mb-2"><?php echo e($rel->category?->name ?? 'General'); ?></span>
                            <h3 class="related-title"><?php echo e($rel->name ?? $rel->title); ?></h3>
                        </div>
                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('meta'); ?>

<?php
    $schemaImages = [];
    if (isset($ogImage) && $ogImage) {
        $schemaImages[] = [
            '@type' => 'ImageObject',
            'url'   => $ogImage,
            'name'  => ($project->name ?? $project->title) . ' — Builtech Engineering Malaysia',
            'description' => $project->description ?? '',
            'author' => ['@type' => 'Organization', 'name' => 'Builtech Project Management Sdn. Bhd.'],
            'copyrightHolder' => ['@type' => 'Organization', 'name' => 'Builtech Project Management Sdn. Bhd.', 'url' => url('/')],
            'copyrightYear' => $project->year ?? date('Y'),
            'license' => url('/privacy-policy'),
            'acquireLicensePage' => url('/contact'),
        ];
    }
    $creativeWorkSchema = [
        '@context' => 'https://schema.org',
        '@type'    => 'CreativeWork',
        'name'     => $project->name ?? $project->title,
        'description' => $project->description ?? '',
        'url'      => url()->current(),
        'creator'  => ['@type' => 'Organization', 'name' => 'Builtech Project Management Sdn. Bhd.', 'url' => url('/')],
        'dateCreated' => optional($project->created_at)->toDateString(),
        'dateModified' => optional($project->updated_at)->toDateString(),
        'keywords' => implode(', ', array_filter([$project->category?->name, $project->location, 'Malaysia construction', 'CIDB G7'])),
    ];
    if (!empty($schemaImages)) $creativeWorkSchema['image'] = $schemaImages;
?>
<script type="application/ld+json">
<?php echo json_encode($creativeWorkSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lightbox = GLightbox({
            selector: '.glightbox',
            // Disable download button in lightbox to protect images
            download: false,
            openEffect: 'zoom',
            closeEffect: 'fade',
            // Override right-click context menu inside lightbox
            onOpen: () => {
                document.querySelectorAll('.glightbox-container img').forEach(img => {
                    img.addEventListener('contextmenu', e => e.preventDefault());
                    img.style.userSelect = 'none';
                    img.style.webkitUserDrag = 'none';
                });
            }
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/project-detail.blade.php ENDPATH**/ ?>