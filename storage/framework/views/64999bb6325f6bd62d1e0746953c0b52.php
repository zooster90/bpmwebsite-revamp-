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

    <div style="
        background: #0A1326;
        border-radius: var(--bt-radius);
        padding: 24px;
        color: #fff;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        position: relative;
        overflow: hidden;
    ">
        
        <div style="position:absolute; inset:0; opacity:0.1; background-image: radial-gradient(#C5A059 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div style="position:relative; z-index:1;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="position:relative;">
                        <div style="width:12px; height:12px; border-radius:50%; background:#22c55e;"></div>
                        <div style="position:absolute; top:0; left:0; width:12px; height:12px; border-radius:50%; background:#22c55e; animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;"></div>
                    </div>
                    <div>
                        <div style="font-size:0.9rem; font-weight:800; color:#fff; letter-spacing:0.05em; text-transform:uppercase;">Live Pulse</div>
                        <div style="font-size:0.75rem; color:rgba(255,255,255,0.5); font-weight:500;">Real-time Visitor Activity</div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:1.5rem; font-weight:800; color:#fff; line-height:1;"><?php echo e($activeNow); ?></div>
                    <div style="font-size:0.65rem; font-weight:700; color:#4ade80; text-transform:uppercase; letter-spacing:0.05em;">Users Online</div>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:12px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div style="
                    background: rgba(255,255,255,0.03);
                    border: 1px solid rgba(255,255,255,0.05);
                    border-radius: 12px;
                    padding: 12px 16px;
                    display: flex;
                    align-items:center;
                    justify-content:space-between;
                    transition: all 0.2s ease;
                " onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="font-size:1.2rem;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visit['device'] === 'Mobile'): ?> 📱 <?php else: ?> 💻 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <div style="font-size:0.85rem; font-weight:700; color:#fff;"><?php echo e($visit['url']); ?></div>
                            <div style="font-size:0.7rem; color:rgba(255,255,255,0.4);"><?php echo e($visit['browser']); ?> · <?php echo e($visit['ip']); ?></div>
                        </div>
                    </div>
                    <div style="font-size:0.75rem; color:rgba(255,255,255,0.3); font-weight:500;">
                        <?php echo e($visit['time']); ?>

                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div style="text-align:center; padding:20px; color:rgba(255,255,255,0.3); font-size:0.85rem; font-style:italic;">
                    Waiting for activity...
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div style="margin-top:16px; text-align:center;">
                <a href="<?php echo e(\App\Filament\Pages\Analytics::getUrl()); ?>" style="font-size:0.75rem; font-weight:700; color:var(--bt-gold); text-decoration:none; text-transform:uppercase; letter-spacing:0.05em;">
                    Open Full Analytics Center →
                </a>
            </div>
        </div>
    </div>

    <style>
    @keyframes ping {
        75%, 100% {
            transform: scale(3);
            opacity: 0;
        }
    }
    </style>
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
<?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/filament/widgets/live-pulse.blade.php ENDPATH**/ ?>