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

<?php
    $user = auth()->user();
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
    $initials = collect(explode(' ', $user->name))->map(fn($n) => substr($n, 0, 1))->take(2)->join('');

    $newInquiries    = \App\Models\Inquiry::where('status', 'new')->count();
    $inProgressInq   = \App\Models\Inquiry::where('status', 'in-progress')->count();
    $totalInquiries  = \App\Models\Inquiry::count();
    $resolvedInq     = \App\Models\Inquiry::where('status', 'resolved')->count();
    $resolvedRate    = $totalInquiries > 0 ? round(($resolvedInq / $totalInquiries) * 100) : 0;

    $activeProjects  = \App\Models\Project::where('is_published', true)->count();
    $draftProjects   = \App\Models\Project::where('is_published', false)->count();
    $totalApps       = \App\Models\JobApplication::count();
    $newApps         = \App\Models\JobApplication::where('status', 'pending')->count();
    $liveJobs        = \App\Models\JobOpening::where('is_active', true)->count();
    $publishedNews   = \App\Models\News::where('is_published', true)->count();
    $totalAwards     = \App\Models\Award::count();

    $recentInquiries = \App\Models\Inquiry::latest()->take(5)->get();
    $recentProjects  = \App\Models\Project::where('is_published', true)->latest()->take(4)->get();

    // Monthly inquiry sparkline (last 6 months)
    $sparkData = collect(range(5, 0))->map(fn($m) =>
        \App\Models\Inquiry::whereBetween('created_at', [
            now()->subMonths($m)->startOfMonth(),
            now()->subMonths($m)->endOfMonth(),
        ])->count()
    )->values()->toArray();

    $maintenanceMode = \App\Models\Setting::get('maintenance_mode') === '1';
?>

<style>
.bt-bento { display: grid; gap: 16px; }
.bt-card {
    background: #fdfcfb;
    border-radius: 14px;
    border: 1px solid #e8e3db;
    overflow: hidden;
    transition: box-shadow 0.2s ease;
}
.bt-card:hover { box-shadow: 0 6px 24px rgba(40, 30, 20, 0.07); }
.bt-card-pad { padding: 20px 24px; }
.bt-label {
    font-size: 0.68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: #a8a29e; margin-bottom: 6px;
}
.bt-val { font-size: 2.2rem; font-weight: 800; color: #1c1917; letter-spacing: -1px; line-height: 1; }
.bt-sub { font-size: 0.78rem; color: #78716c; font-weight: 500; margin-top: 4px; }
.bt-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 99px;
    font-size: 0.7rem; font-weight: 700;
}
.bt-row { display: flex; align-items: center; gap: 12px; }
.bt-sep { width: 1px; height: 20px; background: #e8e3db; }
.bt-stat-bar {
    height: 5px; border-radius: 3px; background: #f0ebe3;
    overflow: hidden; margin-top: 8px;
}
.bt-stat-bar-fill { height: 100%; border-radius: 3px; }
.bt-inq-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 0; border-bottom: 1px solid #f0ebe3;
    font-size: 0.82rem;
}
.bt-inq-row:last-child { border-bottom: none; }
</style>


<div class="bt-card" style="background: linear-gradient(105deg, #1e293b 0%, #334155 100%); border: none; margin-bottom: 0;">
    <div class="bt-card-pad" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div style="display:flex; align-items:center; gap:16px;">
            <div style="width:56px;height:56px;border-radius:16px;background:rgba(197,160,89,0.15);border:1px solid rgba(197,160,89,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="font-size:1.4rem;font-weight:800;color:#c5a059;"><?php echo e($initials); ?></span>
            </div>
            <div>
                <div style="font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:-0.5px;">
                    <?php echo e($greeting); ?>, <span style="color:#c5a059;"><?php echo e(explode(' ', $user->name)[0]); ?></span>
                </div>
                <div style="font-size:0.85rem;color:rgba(255,255,255,0.55);margin-top:2px;font-weight:500;">
                    Builtech Command Center &mdash; <?php echo e(now()->format('l, d F Y')); ?>

                </div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['label'=>'Live Projects','val'=>$activeProjects,'color'=>'#c5a059'],['label'=>'Enquiries','val'=>$newInquiries,'color'=>'#f59e0b'],['label'=>'Applications','val'=>$totalApps,'color'=>'#22c55e']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="text-align:center;">
                <div style="font-size:1.6rem;font-weight:800;color:<?php echo e($s['color']); ?>;line-height:1;"><?php echo e($s['val']); ?></div>
                <div style="font-size:0.65rem;font-weight:700;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.08em;margin-top:3px;"><?php echo e($s['label']); ?></div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$loop->last): ?><div style="width:1px;height:32px;background:rgba(255,255,255,0.1);"></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div style="display:flex;align-items:center;gap:6px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:10px;padding:8px 14px;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.7);">
                <div style="width:7px;height:7px;border-radius:50%;background:#22c55e;box-shadow:0 0 8px rgba(34,197,94,0.6);"></div>
                <span id="bt-clock"><?php echo e(now()->format('H:i:s')); ?></span>
            </div>
        </div>
    </div>
</div>



<script>
(function(){
    // Live clock
    function tickClock() {
        const el = document.getElementById('bt-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(tickClock, 1000);

    // Spark chart
    const ctx = document.getElementById('btSparkChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(collect(range(5,0))->map(fn($m) => now()->subMonths($m)->format('M'))->values()); ?>,
                datasets: [{
                    data: <?php echo e(json_encode($sparkData)); ?>,
                    borderColor: '#c5a059',
                    backgroundColor: (c) => {
                        const {ctx: x, chartArea: a} = c.chart;
                        if (!a) return 'rgba(197,160,89,0.1)';
                        const g = x.createLinearGradient(0, a.top, 0, a.bottom);
                        g.addColorStop(0, 'rgba(197,160,89,0.2)');
                        g.addColorStop(1, 'rgba(197,160,89,0)');
                        return g;
                    },
                    fill: true, tension: 0.4, borderWidth: 2.5,
                    pointRadius: 4, pointBackgroundColor: '#c5a059',
                    pointBorderColor: '#fff', pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => ` ${c.parsed.y} leads` }, backgroundColor: '#0f172a', cornerRadius: 8, padding: 10 } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11, weight: '600' } }, border: { display: false } },
                    y: { grid: { color: 'rgba(148,163,184,0.1)' }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 }, border: { display: false }, min: 0 }
                }
            }
        });
    }
})();
</script>
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
<?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/filament/widgets/dashboard-hero.blade.php ENDPATH**/ ?>