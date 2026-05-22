<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php
    $s         = $stats ?? [];
    $hasData   = ($s['month_views'] ?? 0) > 0;
    $avgMin    = ($s['avg_time'] ?? 0) >= 60
        ? floor(($s['avg_time'])/60).'m '.($s['avg_time']%60).'s'
        : ($s['avg_time'] ?? 0).'s';

    $totalBrowsers  = max(1, collect($browsers)->sum('count'));
    $totalDevices   = max(1, collect($devices)->sum('count'));
    $totalOS        = max(1, collect($osList)->sum('count'));
    $maxPageViews   = max(1, collect($topPages)->max('views'));
    $maxReferrer    = max(1, collect($referrers)->max('count'));

    $bColors = ['#3b82f6','#f59e0b','#10b981','#f43f5e','#8b5cf6','#64748b'];
    $dColors = ['#3b82f6','#10b981','#f59e0b'];
?>

<style>
.bt-an { font-family:'Outfit',sans-serif; }
.bt-card { 
    background:#fff; 
    border:1px solid #e8edf5; 
    border-radius:16px; 
    box-shadow:0 2px 12px rgba(10,19,38,.05); 
    overflow:hidden; 
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: translateY(15px);
    animation: btSlideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}
.bt-card:hover {
    box-shadow: 0 10px 25px rgba(10,19,38,.08);
    transform: translateY(-2px);
    border-color: #cbd5e1;
}

@keyframes btSlideUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bt-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#94a3b8; }
.bt-val   { font-size:2rem; font-weight:800; color:#0a1326; letter-spacing:-1px; line-height:1.1; }
.bt-sub   { font-size:.78rem; font-weight:500; color:#64748b; margin-top:3px; }
.bt-bar-track { height:6px; background:#f1f5f9; border-radius:4px; overflow:hidden; margin-top:5px; }
.bt-bar-fill  { height:100%; border-radius:4px; transition: width 1s ease-out; }
.pulse-dot { width:10px; height:10px; border-radius:50%; background:#22c55e;
             box-shadow:0 0 0 0 rgba(34,197,94,.6);
             animation:pulse-ring 1.5s ease infinite; display:inline-block; }

/* Responsive Grids */
.grid-kpis {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
.grid-charts {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 16px;
}
.grid-breakdown {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.grid-pages {
    display: grid;
    grid-template-columns: 3fr 2fr;
    gap: 16px;
}

@media (max-width: 1024px) {
    .grid-kpis { grid-template-columns: repeat(2, 1fr); }
    .grid-charts { grid-template-columns: 1fr; }
    .grid-breakdown { grid-template-columns: 1fr; }
    .grid-pages { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .grid-kpis { grid-template-columns: 1fr; }
}

@keyframes pulse-ring {
    0%   { box-shadow:0 0 0 0 rgba(34,197,94,.5); }
    70%  { box-shadow:0 0 0 8px rgba(34,197,94,0); }
    100% { box-shadow:0 0 0 0 rgba(34,197,94,0); }
}
</style>

<div class="bt-an" style="display:flex;flex-direction:column;gap:20px;padding-bottom:40px;">

    
    <div style="background:linear-gradient(135deg,#0a1326 0%,#112240 60%,#1a365d 100%);border-radius:20px;padding:28px 32px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <div class="pulse-dot"></div>
                <span style="font-size:.75rem;font-weight:700;color:#4ade80;text-transform:uppercase;letter-spacing:.12em;">Live Tracking Active</span>
            </div>
            <h1 style="margin:0;font-size:1.8rem;font-weight:800;color:#fff;letter-spacing:-.5px;">Analytics Command Center</h1>
            <p style="margin:4px 0 0;font-size:.85rem;color:rgba(255,255,255,.55);">Real visitor data · Last 30 days · Auto-refresh every 60s</p>
        </div>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            
            <div style="background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.3);border-radius:12px;padding:12px 20px;text-align:center;">
                <div style="font-size:1.8rem;font-weight:800;color:#4ade80;line-height:1;"><?php echo e($s['active_now'] ?? 0); ?></div>
                <div style="font-size:.65rem;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.08em;margin-top:2px;">Active Now</div>
            </div>
            <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:12px 20px;text-align:center;">
                <div style="font-size:1.8rem;font-weight:800;color:#fff;line-height:1;"><?php echo e(number_format($s['today_views'] ?? 0)); ?></div>
                <div style="font-size:.65rem;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.08em;margin-top:2px;">Today's Views</div>
            </div>
            <div style="background:rgba(197,160,89,.12);border:1px solid rgba(197,160,89,.3);border-radius:12px;padding:12px 20px;text-align:center;">
                <div style="font-size:1.8rem;font-weight:800;color:#c5a059;line-height:1;"><?php echo e(number_format($s['month_sessions'] ?? 0)); ?></div>
                <div style="font-size:.65rem;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.08em;margin-top:2px;">30-Day Visitors</div>
            </div>
        </div>
    </div>

    
    <div class="bt-card animate-slide-up" style="padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; background:#fff; border:1px solid #e8edf5; border-radius:16px; margin-top:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="font-size:1.2rem;">⚡</span>
            <span style="font-size:.82rem; font-weight:800; color:#475569; text-transform:uppercase; letter-spacing:.05em;">Interactive Dashboard Filters</span>
        </div>
        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
            
            <div style="display:flex; align-items:center; gap:8px;">
                <label style="font-size:.75rem; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:.03em;">Timeframe:</label>
                <select wire:model.live="period" style="font-family:'Montserrat',sans-serif; font-size:.82rem; font-weight:700; color:#0a1326; background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:6px 36px 6px 12px; cursor:pointer; outline:none; -webkit-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%23C5A059\' stroke-width=\'2\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 10px center; background-size:12px;">
                    <option value="1">Today</option>
                    <option value="7">Last 7 Days</option>
                    <option value="30">Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                    <option value="365">Last Year</option>
                </select>
            </div>
            
            
            <div style="display:flex; align-items:center; gap:8px;">
                <label style="font-size:.75rem; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:.03em;">Device:</label>
                <select wire:model.live="deviceType" style="font-family:'Montserrat',sans-serif; font-size:.82rem; font-weight:700; color:#0a1326; background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:6px 36px 6px 12px; cursor:pointer; outline:none; -webkit-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%23C5A059\' stroke-width=\'2\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 10px center; background-size:12px;">
                    <option value="all">All Devices</option>
                    <option value="Desktop">Desktop Only</option>
                    <option value="Mobile">Mobile Only</option>
                    <option value="Tablet">Tablet Only</option>
                </select>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$hasData): ?>
    
    <div class="bt-card" style="padding:60px;text-align:center;">
        <div style="font-size:3rem;margin-bottom:12px;">📊</div>
        <div style="font-size:1.1rem;font-weight:700;color:#0a1326;margin-bottom:8px;">No Visitor Data Yet</div>
        <div style="font-size:.85rem;color:#64748b;max-width:400px;margin:0 auto;">
            Visitor tracking is active. Data will appear once users visit the Builtech website.
        </div>
    </div>
    <?php else: ?>

    
    <div class="grid-kpis">
        <?php
        $kpis = [
            ['label'=>'30-Day Page Views',  'value'=>number_format($s['month_views']??0),  'sub'=>($s['views_delta']??0).'% vs prev month', 'color'=>'#3b82f6','icon'=>'👁'],
            ['label'=>'Avg. Time on Page',  'value'=>$avgMin,                               'sub'=>'Per session average',                    'color'=>'#8b5cf6','icon'=>'⏱'],
            ['label'=>'Bounce Rate',        'value'=>($s['bounce_rate']??0).'%',            'sub'=>'Single-page sessions',                   'color'=>'#f59e0b','icon'=>'↩'],
            ['label'=>'7-Day Visitors',     'value'=>number_format($s['week_sessions']??0), 'sub'=>number_format($s['week_views']??0).' page views', 'color'=>'#10b981','icon'=>'📅'],
        ];
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="bt-card" style="padding:22px 24px;border-top:3px solid <?php echo e($k['color']); ?>;">
            <div style="font-size:1.5rem;margin-bottom:8px;"><?php echo e($k['icon']); ?></div>
            <div class="bt-label"><?php echo e($k['label']); ?></div>
            <div class="bt-val" style="color:<?php echo e($k['color']); ?>;margin-top:4px;"><?php echo e($k['value']); ?></div>
            <div class="bt-sub"><?php echo e($k['sub']); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    
    <div class="grid-charts">

        
        <div class="bt-card" style="padding:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <div class="bt-label">30-Day Traffic Trend</div>
                    <div style="font-size:1.1rem;font-weight:800;color:#0a1326;margin-top:2px;">Daily Page Views & Visitors</div>
                </div>
                <div style="display:flex;gap:16px;font-size:.75rem;font-weight:600;">
                    <span style="display:flex;align-items:center;gap:5px;"><span style="width:10px;height:3px;background:#3b82f6;border-radius:2px;display:inline-block;"></span>Views</span>
                    <span style="display:flex;align-items:center;gap:5px;"><span style="width:10px;height:3px;background:#10b981;border-radius:2px;display:inline-block;"></span>Visitors</span>
                </div>
            </div>
            <canvas id="btDailyTrend" height="90"></canvas>
        </div>

        
        <div class="bt-card" style="padding:24px;">
            <div class="bt-label" style="margin-bottom:4px;">Peak Traffic Hours</div>
            <div style="font-size:1.05rem;font-weight:800;color:#0a1326;margin-bottom:16px;">Last 7 Days by Hour</div>
            <canvas id="btHourBar" height="140"></canvas>
        </div>
    </div>

    
    <div class="grid-breakdown">

        
        <div class="bt-card" style="padding:24px;">
            <div class="bt-label" style="margin-bottom:14px;">🌐 Browser Breakdown</div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $browsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                    <span style="font-size:.8rem;font-weight:600;color:#374151;"><?php echo e($b['browser']); ?></span>
                    <span style="font-size:.8rem;font-weight:800;color:#0a1326;"><?php echo e(round(($b['count']/$totalBrowsers)*100)); ?>%</span>
                </div>
                <div class="bt-bar-track"><div class="bt-bar-fill" style="width:<?php echo e(round(($b['count']/$totalBrowsers)*100)); ?>%;background:<?php echo e($bColors[$i] ?? '#94a3b8'); ?>;"></div></div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="bt-card" style="padding:24px;">
            <div class="bt-label" style="margin-bottom:12px;">📱 Device Type</div>
            <canvas id="btDeviceDonut" width="140" height="140" style="display:block;margin:0 auto 16px;"></canvas>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <div style="display:flex;align-items:center;gap:7px;">
                    <div style="width:10px;height:10px;border-radius:3px;background:<?php echo e($dColors[$i] ?? '#94a3b8'); ?>;flex-shrink:0;"></div>
                    <span style="font-size:.8rem;font-weight:600;color:#374151;"><?php echo e($d['device']); ?></span>
                </div>
                <span style="font-size:.8rem;font-weight:800;color:#0a1326;"><?php echo e(round(($d['count']/$totalDevices)*100)); ?>%</span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="bt-card" style="padding:24px;">
            <div class="bt-label" style="margin-bottom:14px;">💻 Operating System</div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $osList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                    <span style="font-size:.8rem;font-weight:600;color:#374151;"><?php echo e($o['os']); ?></span>
                    <span style="font-size:.8rem;font-weight:800;color:#0a1326;"><?php echo e($o['count']); ?></span>
                </div>
                <div class="bt-bar-track"><div class="bt-bar-fill" style="width:<?php echo e(round(($o['count']/$totalOS)*100)); ?>%;background:linear-gradient(90deg,#8b5cf6,#a78bfa);"></div></div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    
    <div class="grid-pages">

        
        <div class="bt-card" style="padding:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div>
                    <div class="bt-label">🏆 Top Pages</div>
                    <div style="font-size:1.05rem;font-weight:800;color:#0a1326;margin-top:2px;">By page views — last 30 days</div>
                </div>
                <div style="font-size:.7rem;font-weight:700;color:#64748b;background:#f8fafc;padding:4px 10px;border-radius:8px;">Views / Visitors</div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $topPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="margin-bottom:12px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                    <span style="font-size:.8rem;font-weight:600;color:#1e3a6e;max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?php echo e(ucwords($p['label']) ?: '/'); ?>

                    </span>
                    <span style="font-size:.78rem;font-weight:800;color:#3b82f6;white-space:nowrap;margin-left:8px;">
                        <?php echo e(number_format($p['views'])); ?> / <?php echo e(number_format($p['visitors'])); ?>

                    </span>
                </div>
                <div class="bt-bar-track">
                    <div class="bt-bar-fill" style="width:<?php echo e(round(($p['views']/$maxPageViews)*100)); ?>%;background:linear-gradient(90deg,#3b82f6,#60a5fa);"></div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="bt-card" style="padding:24px;">
            <div class="bt-label" style="margin-bottom:4px;">🔗 Traffic Sources</div>
            <div style="font-size:1.05rem;font-weight:800;color:#0a1326;margin-bottom:16px;">Top Referrers</div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $referrers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                <span style="font-size:.82rem;font-weight:600;color:#374151;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?php echo e($r['host'] ?: 'Direct / None'); ?>

                </span>
                <span style="font-size:.82rem;font-weight:800;color:#8b5cf6;"><?php echo e($r['count']); ?></span>
            </div>
            <div class="bt-bar-track">
                <div class="bt-bar-fill" style="width:<?php echo e(round(($r['count']/$maxReferrer)*100)); ?>%;background:linear-gradient(90deg,#8b5cf6,#a78bfa);"></div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p style="font-size:.83rem;color:#94a3b8;font-style:italic;">No referrer data yet</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="bt-card" style="padding:24px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <div class="pulse-dot"></div>
            <div>
                <div class="bt-label">Live Feed</div>
                <div style="font-size:1.05rem;font-weight:800;color:#0a1326;margin-top:1px;">Recent Page Visits</div>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:.82rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="text-align:left;padding:10px 14px;font-weight:700;color:#64748b;text-transform:uppercase;font-size:.68rem;letter-spacing:.08em;">Page</th>
                        <th style="text-align:left;padding:10px 14px;font-weight:700;color:#64748b;text-transform:uppercase;font-size:.68rem;letter-spacing:.08em;">Device</th>
                        <th style="text-align:left;padding:10px 14px;font-weight:700;color:#64748b;text-transform:uppercase;font-size:.68rem;letter-spacing:.08em;">Browser</th>
                        <th style="text-align:left;padding:10px 14px;font-weight:700;color:#64748b;text-transform:uppercase;font-size:.68rem;letter-spacing:.08em;">OS</th>
                        <th style="text-align:left;padding:10px 14px;font-weight:700;color:#64748b;text-transform:uppercase;font-size:.68rem;letter-spacing:.08em;">Time Spent</th>
                        <th style="text-align:left;padding:10px 14px;font-weight:700;color:#64748b;text-transform:uppercase;font-size:.68rem;letter-spacing:.08em;">When</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentVisits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr style="border-top:1px solid #f1f5f9;">
                        <td style="padding:10px 14px;font-weight:600;color:#1e293b;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($v['url']); ?></td>
                        <td style="padding:10px 14px;color:#374151;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v['device']==='Mobile'): ?> 📱 <?php elseif($v['device']==='Tablet'): ?> 🖥 <?php else: ?> 💻 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php echo e($v['device']); ?>

                        </td>
                        <td style="padding:10px 14px;color:#374151;"><?php echo e($v['browser']); ?></td>
                        <td style="padding:10px 14px;color:#374151;"><?php echo e($v['os']); ?></td>
                        <td style="padding:10px 14px;font-weight:600;color:#8b5cf6;">
                            <?php echo e($v['time_on'] > 0 ? ($v['time_on'] >= 60 ? floor($v['time_on']/60).'m '.($v['time_on']%60).'s' : $v['time_on'].'s') : '—'); ?>

                        </td>
                        <td style="padding:10px 14px;color:#94a3b8;white-space:nowrap;"><?php echo e($v['time']); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> 

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function(){
    // Gracefully destroy existing chart instances to allow seamless livewire updates without errors
    try {
        const prevDaily = Chart.getChart('btDailyTrend');
        if (prevDaily) prevDaily.destroy();
    } catch(e) {}
    try {
        const prevHour = Chart.getChart('btHourBar');
        if (prevHour) prevHour.destroy();
    } catch(e) {}
    try {
        const prevDevice = Chart.getChart('btDeviceDonut');
        if (prevDevice) prevDevice.destroy();
    } catch(e) {}

    const dailyLabels   = <?php echo json_encode(collect($dailyData)->pluck('date')); ?>;
    const dailyViews    = <?php echo json_encode(collect($dailyData)->pluck('views')); ?>;
    const dailyVisitors = <?php echo json_encode(collect($dailyData)->pluck('visitors')); ?>;
    const hourLabels    = <?php echo json_encode(collect($hourlyData)->pluck('hour')); ?>;
    const hourCounts    = <?php echo json_encode(collect($hourlyData)->pluck('count')); ?>;
    const devices       = <?php echo json_encode($devices); ?>;

    const grid = { color:'rgba(148,163,184,.1)' };
    const tick  = { color:'#94a3b8', font:{ family:'Outfit', size:10, weight:'600' } };

    // Daily trend
    const dCtx = document.getElementById('btDailyTrend');
    if(dCtx) new Chart(dCtx,{
        type:'line',
        data:{ labels:dailyLabels, datasets:[
            { data:dailyViews, borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,.1)',
              fill:true, tension:.4, borderWidth:2, pointRadius:2, pointHoverRadius:5,
              pointBackgroundColor:'#3b82f6', pointBorderColor:'#fff', pointBorderWidth:1.5 },
            { data:dailyVisitors, borderColor:'#10b981', backgroundColor:'rgba(16,185,129,.08)',
              fill:true, tension:.4, borderWidth:2, pointRadius:2, pointHoverRadius:5,
              pointBackgroundColor:'#10b981', pointBorderColor:'#fff', pointBorderWidth:1.5 },
        ]},
        options:{ responsive:true, maintainAspectRatio:true,
            plugins:{ legend:{display:false},
                tooltip:{ backgroundColor:'#0f172a', cornerRadius:10, padding:10,
                    callbacks:{ label:c=>' '+c.parsed.y+(c.datasetIndex===0?' views':' visitors') } }},
            scales:{ x:{grid,ticks:{...tick,maxTicksLimit:8},border:{display:false}},
                     y:{grid,ticks:{...tick,stepSize:1},border:{display:false},min:0} } }
    });

    // Hourly bar
    const hCtx = document.getElementById('btHourBar');
    if(hCtx) new Chart(hCtx,{
        type:'bar',
        data:{ labels:hourLabels.filter((_,i)=>i%2===0),
               datasets:[{ data:hourCounts.filter((_,i)=>i%2===0),
               backgroundColor:'rgba(139,92,246,.75)', borderRadius:4, hoverBackgroundColor:'#8b5cf6' }] },
        options:{ responsive:true, maintainAspectRatio:true,
            plugins:{ legend:{display:false},
                tooltip:{ backgroundColor:'#0f172a', cornerRadius:10, padding:8,
                    callbacks:{label:c=>' '+c.parsed.y+' hits'} }},
            scales:{ x:{grid:{display:false},ticks:tick,border:{display:false}},
                     y:{grid,ticks:{...tick,stepSize:1},border:{display:false},min:0} } }
    });

    // Device donut
    const dvCtx = document.getElementById('btDeviceDonut');
    if(dvCtx && devices.length) new Chart(dvCtx,{
        type:'doughnut',
        data:{ labels:devices.map(d=>d.device),
               datasets:[{ data:devices.map(d=>d.count),
               backgroundColor:['#3b82f6','#10b981','#f59e0b'],
               borderColor:'#fff', borderWidth:3, hoverOffset:5 }] },
        options:{ responsive:false, cutout:'68%',
            plugins:{ legend:{display:false},
                tooltip:{ backgroundColor:'#0f172a', cornerRadius:10, padding:8 } } }
    });
})();
</script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/filament/pages/analytics.blade.php ENDPATH**/ ?>