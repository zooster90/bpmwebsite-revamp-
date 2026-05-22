<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    
    <style>
        .nd-card {
            background: var(--bt-card, #fdfcfb);
            border-radius: var(--bt-radius, 14px);
            border: 1px solid var(--bt-border, #e8e3db);
            box-shadow: var(--bt-shadow, 0 2px 10px rgba(40, 30, 20, 0.05));
            padding: 24px;
            color: var(--bt-text, #1c1917);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: var(--bt-transition, all 0.22s ease);
        }
        .nd-card:hover {
            box-shadow: var(--bt-shadow-lg, 0 8px 28px rgba(40, 30, 20, 0.08));
        }
        .nd-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            border-bottom: 1px solid var(--bt-border-soft, #f0ebe3);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .nd-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nd-pulse-dot {
            position: relative;
            display: inline-flex;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #10b981;
            flex-shrink: 0;
        }
        .nd-pulse-ping {
            position: absolute;
            top: 0;
            left: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #10b981;
            animation: nd-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        .nd-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--bt-navy, #292524);
            letter-spacing: 0.02em;
            text-transform: uppercase;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            line-height: 1.2;
        }
        .nd-subtitle {
            font-size: 0.78rem;
            color: var(--bt-muted, #78716c);
            margin: 4px 0 0 0;
            font-weight: 500;
        }
        .nd-badges {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }
        .nd-badge-url {
            display: inline-flex;
            align-items: center;
            background: #fef3c7;
            color: #d97706;
            font-weight: 700;
            font-size: 0.72rem;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid rgba(217, 119, 6, 0.15);
        }
        .nd-badge-time {
            display: inline-flex;
            align-items: center;
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
            font-size: 0.72rem;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        
        /* 3-Column Bento Grid */
        .nd-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin: 20px 0;
        }
        @media (max-width: 1024px) {
            .nd-grid {
                grid-template-columns: 1fr;
            }
        }
        .nd-grid-item {
            background: rgba(247, 245, 242, 0.4);
            border: 1px solid var(--bt-border, #e8e3db);
            border-radius: 12px;
            padding: 16px;
        }
        .nd-item-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nd-icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .nd-item-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--bt-navy, #292524);
        }
        .nd-item-desc {
            font-size: 0.72rem;
            color: var(--bt-muted, #78716c);
            margin: 8px 0 0 0;
            line-height: 1.4;
            font-weight: 500;
        }

        /* Action Panel */
        .nd-action-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            border: 1px dashed var(--bt-border, #e8e3db);
            border-radius: 12px;
            background: rgba(247, 245, 242, 0.2);
            text-align: center;
        }
        .nd-btn {
            background: var(--bt-gold, #c5a059);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 28px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(197, 160, 89, 0.2);
        }
        .nd-btn:hover:not(:disabled) {
            background: var(--bt-gold-hover, #b08d47);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(197, 160, 89, 0.3);
        }
        .nd-btn:active:not(:disabled) {
            transform: translateY(1px);
        }
        .nd-btn:disabled {
            background: #cbd5e1;
            color: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
        }
        
        /* Terminal Window */
        .nd-terminal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #1e293b;
            padding: 8px 16px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            font-family: monospace;
            font-size: 11px;
            color: #94a3b8;
            border-bottom: 1px solid #334155;
        }
        .nd-terminal-dots {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nd-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }
        .nd-terminal-body {
            background: #030712;
            color: #34d399;
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            padding: 16px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            max-height: 240px;
            overflow-y: auto;
            text-align: left;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.5);
        }
        .nd-terminal-pre {
            margin: 0;
            white-space: pre-wrap;
            word-break: break-all;
            line-height: 1.5;
        }

        /* Loading Spinner */
        .nd-spinner {
            animation: nd-spin 1s linear infinite;
        }

        @keyframes nd-ping {
            75%, 100% {
                transform: scale(3);
                opacity: 0;
            }
        }
        @keyframes nd-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>

    <div class="nd-card" <?php if($deployStatus === 'running'): ?> wire:poll.1s="checkForUpdates" <?php endif; ?>>
        
        <div class="nd-header">
            <div>
                <div class="nd-title-group">
                    <span class="nd-pulse-dot">
                        <span class="nd-pulse-ping"></span>
                    </span>
                    <h2 class="nd-title">
                        Netlify Live CDN Synchronization
                    </h2>
                </div>
                <p class="nd-subtitle">
                    Export all Laravel pages statically and synchronize them to Netlify's high-speed global edge servers in one click.
                </p>
            </div>
            
            <div class="nd-badges">
                <a href="https://vermillion-seahorse-912ac2.netlify.app/" target="_blank" class="nd-badge-url" style="text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1">
                    Live CDN: vermillion-seahorse-912ac2.netlify.app
                    <svg style="width:12px;height:12px;margin-left:4px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
                <span class="nd-badge-time">
                    Last Sync: <span style="font-family: monospace; font-weight: 700; margin-left: 4px;"><?php echo e($lastDeployTime); ?></span>
                </span>
            </div>
        </div>

        
        <div class="nd-grid">
            <div class="nd-grid-item">
                <div class="nd-item-header">
                    <div class="nd-icon-wrap" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width: 16px; height: 16px; display: block;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="nd-item-title">Extreme Edge Speeds</span>
                </div>
                <p class="nd-item-desc">
                    Netlify serves static HTML pages on a global CDN. Pages load instantly without database latency, giving visitors a perfect Grade G7 premium experience.
                </p>
            </div>
            
            <div class="nd-grid-item">
                <div class="nd-item-header">
                    <div class="nd-icon-wrap" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width: 16px; height: 16px; display: block;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="nd-item-title">Bulletproof Security</span>
                </div>
                <p class="nd-item-desc">
                    The live web server is 100% static, rendering it completely immune to SQL injections, administrative breaches, database failures, or dynamic hacking.
                </p>
            </div>

            <div class="nd-grid-item">
                <div class="nd-item-header">
                    <div class="nd-icon-wrap" style="background: rgba(59, 130, 246, 0.1); color: #2563eb;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width: 16px; height: 16px; display: block;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="nd-item-title">Zero Server Cost</span>
                </div>
                <p class="nd-item-desc">
                    Netlify's static plan is 100% free, which saves you thousands in yearly dynamic PHP database hosting costs and server maintenance.
                </p>
            </div>
        </div>

        
        <div class="nd-action-box">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deployStatus === 'idle' || $deployStatus === 'success' || $deployStatus === 'failed'): ?>
                <button 
                    wire:click="deploy" 
                    wire:loading.attr="disabled"
                    class="nd-btn"
                >
                    <svg class="nd-btn-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width: 18px; height: 18px; display: inline-block;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                    Deploy to Netlify Live
                </button>
                
                <p style="font-size: 0.72rem; color: var(--bt-muted, #78716c); margin: 8px 0 0 0; font-weight: 500;">
                    Triggers local static export, synchronizes Supabase uploads, and pushes to live Netlify CDN.
                </p>
            <?php elseif($deployStatus === 'running'): ?>
                
                <div style="padding: 16px 0;">
                    <svg class="nd-spinner" width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 36px; height: 36px; color: var(--bt-gold, #c5a059); display: inline-block;">
                        <circle cx="12" cy="12" r="10" stroke="rgba(197, 160, 89, 0.2)" stroke-width="3"/>
                        <path d="M4 12c0-4.418 3.582-8 8-8" stroke="var(--bt-gold, #c5a059)" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                    
                    <h3 style="font-size: 0.9rem; font-weight: 800; color: var(--bt-navy, #292524); text-transform: uppercase; margin: 12px 0 4px 0;">
                        Compilation and Deployment in progress...
                    </h3>
                    <p style="font-size: 0.72rem; color: var(--bt-muted, #78716c); margin: 0; font-weight: 500; opacity: 0.8;">
                        Synchronizing directories and uploading assets to high-speed CDN nodes...
                    </p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deployLog): ?>
            <div style="margin-top: 20px;">
                <div class="nd-terminal-header">
                    <div class="nd-terminal-dots">
                        <span class="nd-dot" style="background: #ef4444;"></span>
                        <span class="nd-dot" style="background: #f59e0b;"></span>
                        <span class="nd-dot" style="background: #10b981;"></span>
                        <span style="margin-left: 8px; font-size: 10px; color: #64748b;">terminal@builtech:~/deploy-pipeline</span>
                    </div>
                    <span style="font-size: 10px; color: #475569;">bash</span>
                </div>
                <div class="nd-terminal-body" x-data x-init="$el.scrollTop = $el.scrollHeight" x-effect="$el.scrollTop = $el.scrollHeight">
                    <pre class="nd-terminal-pre"><?php echo e($deployLog); ?></pre>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/filament/widgets/netlify-deploy.blade.php ENDPATH**/ ?>