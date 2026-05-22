<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Builtech Project Management Sdn. Bhd.', 'description' => '']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title' => 'Builtech Project Management Sdn. Bhd.', 'description' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title); ?></title>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($description): ?>
    <meta name="description" content="<?php echo e($description); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <link rel="canonical" href="<?php echo e(url()->current()); ?>">

    
    <meta property="og:title" content="<?php echo e($title); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($description): ?>
    <meta property="og:description" content="<?php echo e($description); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:site_name" content="Builtech Project Management">
    <meta property="og:locale" content="en_MY">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($ogImage) && $ogImage): ?>
    <meta property="og:image" content="<?php echo e($ogImage); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo e($title); ?> — Builtech Engineering Malaysia">
    <?php else: ?>
    <meta property="og:image" content="<?php echo e(asset('images/logo.png')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($title); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($description): ?>
    <meta name="twitter:description" content="<?php echo e($description); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($ogImage) && $ogImage): ?>
    <meta name="twitter:image" content="<?php echo e($ogImage); ?>">
    <?php else: ?>
    <meta name="twitter:image" content="<?php echo e(asset('images/logo.png')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />

    <?php echo $__env->yieldPushContent('styles'); ?>

    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    
    
    
    <style>
        [x-cloak] { display: none !important; }
        
        :root {
            /* Bright & Gold Premium Theme Tokens */
            --color-gold: #c5a059;
            --color-gold-hover: #b38f4d;
            --color-navy: #1a242f;
            --color-bright-base: #ffffff;
            --color-bright-off: #fafaf9;
            --color-bright-warm: #f4eee0;
            --font-body: 'Montserrat', sans-serif;
            --font-heading: 'Outfit', sans-serif;
            --nav-height: 80px;
        }

        body { 
            font-family: var(--font-body); 
            color: var(--color-navy);
            background-color: var(--color-bright-base);
            -webkit-font-smoothing: antialiased;
        }

        .font-heading { font-family: var(--font-heading); }
        
        /* 强制统一的 Container */
        .container-tidy { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }

        /* 防止 Fixed Navbar 导致的内容塌陷 */
        main { display: block; width: 100%; position: relative; overflow: hidden; }

        /* 隔离 Back to top 按钮 */
        .back-to-top-wrapper { position: fixed; bottom: 2rem; right: 2rem; z-index: 50; pointer-events: none; }
        .back-to-top-wrapper button { pointer-events: auto; }

        /* ── Image Copyright Watermark & Security Shield ── */
        .img-copyright-wrapper { 
            position: relative; 
            display: inline-block; 
            max-width: 100%; 
            overflow: hidden;
            user-select: none;
            -webkit-user-select: none;
        }
        
        /* Transparent CSS Click-Shield: Blocks right-clicking and dragging */
        .img-copyright-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: transparent;
            z-index: 5;
            pointer-events: auto;
        }

        .img-copyright-wrapper img {
            user-drag: none;
            -webkit-user-drag: none;
            pointer-events: none;
        }

        /* Gold-Branded Premium Watermark Badge */
        .img-copyright-wrapper::after {
            content: "© BUILTECH • WE BUILD TO LAST";
            position: absolute;
            bottom: 12px;
            right: 12px;
            color: #ffffff;
            font-family: var(--font-heading);
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            background: rgba(26, 36, 47, 0.9);
            border: 1px solid rgba(197, 160, 89, 0.5);
            padding: 5px 12px;
            border-radius: 50px;
            pointer-events: none;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 10;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .img-copyright-wrapper:hover::after {
            background: rgba(197, 160, 89, 0.95);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 6px 20px rgba(197, 160, 89, 0.4);
            transform: translateY(-2px);
        }
    </style>

    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
    <script type="application/ld+json">
    <?php echo json_encode([
        '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Builtech Project Management Sdn. Bhd.',
        'description' => 'CIDB Grade G7 contractor with 30+ years delivering quality construction across Malaysia.',
        'url' => url('/'),
        'telephone' => '+604-659 3399',
        'email' => 'contact@builtech.com.my',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '17H, Level 1-Level 3, Lebuhraya Batu Lanchang',
            'addressLocality' => 'Jelutong, Penang',
            'postalCode' => '11600',
            'addressCountry' => 'MY'
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>

    
    <?php echo $__env->yieldPushContent('head'); ?>
</head>

<body class="bg-white overflow-x-hidden">

    <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

    <main>
        <?php echo e($slot); ?>

    </main>

    <?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>

    
    <div class="back-to-top-wrapper" x-data="{ showTop: false }" @scroll.window="showTop = (window.scrollY > 400)">
        <button x-show="showTop" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-10"
                x-transition:enter-end="opacity-100 translate-y-0"
                @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="w-12 h-12 shadow-2xl flex items-center justify-center hover:-translate-y-1 transition-all focus:outline-none border border-white/20"
                style="background-color: var(--color-gold); color: white;"
                aria-label="Scroll to top">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
        </button>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });

            // Automatically apply AOS to content elements for one-shot scroll animation
            const animateElements = document.querySelectorAll('main h1, main h2, main h3, main p, main .card, main .glass-card, main img');
            animateElements.forEach((el, index) => {
                if (!el.classList.contains('reveal') && !el.closest('.reveal') && !el.closest('.hero')) {
                    if (!el.hasAttribute('data-aos')) {
                        el.setAttribute('data-aos', 'fade-up');
                        el.setAttribute('data-aos-delay', (index % 4) * 100);
                    }
                }
            });

            // Automatically wrap large images for copyright watermark
            document.querySelectorAll('main img').forEach(img => {
                // Ignore small images, icons, logos
                if (img.closest('header') || img.closest('nav') || img.closest('.iso-strip') || img.closest('.stat-item') || img.clientWidth < 150) return;
                
                if (!img.closest('.img-copyright-wrapper')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'img-copyright-wrapper';
                    const displayStyle = window.getComputedStyle(img).display;
                    wrapper.style.display = (displayStyle === 'inline' || displayStyle === 'inline-block') ? 'inline-block' : 'block';
                    
                    if (img.parentElement && img.parentElement.tagName !== 'PICTURE') {
                        img.parentNode.insertBefore(wrapper, img);
                        wrapper.appendChild(img);
                    }
                }
            });
            
            // Refresh AOS after DOM changes
            setTimeout(() => AOS.refresh(), 500);
        });
    </script>
</body>
</html><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/components/layout.blade.php ENDPATH**/ ?>