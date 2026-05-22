<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

    

    <url>
        <loc><?php echo e(url('/')); ?></loc>
        <lastmod><?php echo e(now()->tz('UTC')->toAtomString()); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?php echo e(url('/about')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo e(url('/our-people')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo e(url('/corporate')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc><?php echo e(url('/sustainability')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo e(url('/services')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo e(url('/projects')); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?php echo e(url('/news')); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?php echo e(url('/awards')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo e(url('/culture')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo e(url('/media')); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo e(url('/careers')); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo e(url('/contact')); ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <?php
        $pageTitle  = e($project->name ?? $project->title ?? '');
        $category   = e($project->category?->name ?? 'Construction');
        $location   = e($project->location ?? 'Malaysia');
        $year       = $project->year ?? '';
        $desc       = $project->description
                        ? e(\Illuminate\Support\Str::limit($project->description, 200))
                        : "A Builtech {$category} project in {$location}" . ($year ? ", completed {$year}." : '.');

        // Canonical keyword-rich title for Google Image index
        $imgTitle   = "{$pageTitle} — {$category} in {$location} | Builtech Engineering Malaysia";

        // Cover image — use display_image accessor which handles ALL fallback chains
        $coverUrl   = $project->display_image;

        // Skip unsplash fallback images from the sitemap (they're not our content)
        $isUnsplash = str_contains($coverUrl, 'unsplash.com');

        // Ensure cover is absolute URL
        if (!filter_var($coverUrl, FILTER_VALIDATE_URL)) {
            $coverUrl = null;
        }

        // Gallery images from Spatie MediaLibrary
        $galleryImages = $project->hasMedia('gallery')
            ? $project->getMedia('gallery')->take(8)->pluck(null)->all()
            : [];
    ?>
        <url>
            <loc><?php echo e(url('/projects/' . $project->slug)); ?></loc>
            <lastmod><?php echo e($project->updated_at->tz('UTC')->toAtomString()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coverUrl && !$isUnsplash): ?>
            <image:image>
                <image:loc><?php echo e($coverUrl); ?></image:loc>
                <image:title><?php echo e($imgTitle); ?></image:title>
                <image:caption><?php echo e($desc); ?></image:caption>
                <image:license><?php echo e(url('/privacy-policy')); ?></image:license>
            </image:image>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galleryImg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <image:image>
                <image:loc><?php echo e($galleryImg->getUrl()); ?></image:loc>
                <image:title><?php echo e($pageTitle); ?> — <?php echo e($category); ?>, <?php echo e($location); ?> — Builtech Engineering Malaysia</image:title>
                <image:caption><?php echo e($desc); ?></image:caption>
                <image:license><?php echo e(url('/privacy-policy')); ?></image:license>
            </image:image>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        </url>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <?php
        $newsTitle  = e($article->title ?? '');
        $newsDesc   = $article->excerpt
                        ? e(\Illuminate\Support\Str::limit($article->excerpt, 200))
                        : ($article->content ? e(\Illuminate\Support\Str::limit(strip_tags($article->content), 200)) : 'Builtech News Update');

        // Use display_image accessor for full fallback chain
        $newsImg    = $article->display_image;
        $isUnsplashNews = str_contains($newsImg, 'unsplash.com');

        if (!filter_var($newsImg, FILTER_VALIDATE_URL)) {
            $newsImg = null;
        }
    ?>
        <url>
            <loc><?php echo e(url('/news/' . $article->slug)); ?></loc>
            <lastmod><?php echo e($article->updated_at->tz('UTC')->toAtomString()); ?></lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($newsImg && !$isUnsplashNews): ?>
            <image:image>
                <image:loc><?php echo e($newsImg); ?></image:loc>
                <image:title><?php echo e($newsTitle); ?> — Builtech Project Management Sdn. Bhd.</image:title>
                <image:caption><?php echo e($newsDesc); ?></image:caption>
                <image:license><?php echo e(url('/privacy-policy')); ?></image:license>
            </image:image>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->hasMedia('gallery')): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $article->getMedia('gallery')->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsGallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <image:image>
                    <image:loc><?php echo e($newsGallery->getUrl()); ?></image:loc>
                    <image:title><?php echo e($newsTitle); ?> — Builtech News Gallery</image:title>
                    <image:license><?php echo e(url('/privacy-policy')); ?></image:license>
                </image:image>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </url>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

</urlset>
<?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/sitemap.blade.php ENDPATH**/ ?>