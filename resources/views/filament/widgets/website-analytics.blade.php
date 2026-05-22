@php
    // Filament v3 injects getViewData() keys as view variables
    $todayVisitors  = $todayVisitors  ?? 0;
    $weekVisitors   = $weekVisitors   ?? 0;
    $monthVisitors  = $monthVisitors  ?? 0;
    $totalPageviews = $totalPageviews ?? 0;
    $avgTime        = $avgTime        ?? 0;
    $topPages       = $topPages       ?? collect();
    $browsers       = $browsers       ?? collect();
    $devices        = $devices        ?? collect();
    $osList         = $osList         ?? collect();
    $dailyVisitors  = $dailyVisitors  ?? collect();
    $hourlyData     = $hourlyData     ?? collect();
    $referrers      = $referrers      ?? collect();

    $avgTimeMin = $avgTime >= 60 ? floor($avgTime / 60) . 'm ' . ($avgTime % 60) . 's' : $avgTime . 's';
    $hasData    = $totalPageviews > 0;

    $browserColors = ['#3b82f6','#f59e0b','#10b981','#f43f5e','#8b5cf6','#64748b'];
    $deviceColors  = ['#3b82f6','#10b981','#f59e0b'];

    $dailyLabels = $dailyVisitors->pluck('date')->toJson();
    $dailyCounts = $dailyVisitors->pluck('count')->toJson();
    $hourLabels  = $hourlyData->pluck('hour')->toJson();
    $hourCounts  = $hourlyData->pluck('count')->toJson();
    $maxDaily    = max(1, $dailyVisitors->max('count'));
@endphp

<style>
.widget-grid-kpis {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0;
}
.widget-grid-charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
}
.widget-grid-breakdown {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 0;
}
.widget-grid-kpis > div {
    border-right: 1px solid #eef2f9;
}
.widget-grid-kpis > div:last-child {
    border-right: none;
}
.widget-grid-charts > div:first-child {
    border-right: 1px solid #eef2f9;
}
.widget-grid-breakdown > div {
    border-right: 1px solid #eef2f9;
}
.widget-grid-breakdown > div:last-child {
    border-right: none;
}

@media (max-width: 1200px) {
    .widget-grid-kpis { grid-template-columns: repeat(3, 1fr); }
    .widget-grid-kpis > div { border-bottom: 1px solid #eef2f9; }
    .widget-grid-kpis > div:nth-child(3) { border-right: none; }
    .widget-grid-breakdown { grid-template-columns: 1fr 1fr; }
    .widget-grid-breakdown > div { border-bottom: 1px solid #eef2f9; }
    .widget-grid-breakdown > div:nth-child(2n) { border-right: none; }
}
@media (max-width: 768px) {
    .widget-grid-kpis { grid-template-columns: 1fr; }
    .widget-grid-kpis > div { border-right: none !important; border-bottom: 1px solid #eef2f9; }
    .widget-grid-charts { grid-template-columns: 1fr; }
    .widget-grid-charts > div:first-child { border-right: none !important; border-bottom: 1px solid #eef2f9; }
    .widget-grid-breakdown { grid-template-columns: 1fr; }
    .widget-grid-breakdown > div { border-right: none !important; border-bottom: 1px solid #eef2f9; }
}
</style>

{{-- ══════════════════════════════════════════════════════════════
     BUILTECH WEBSITE ANALYTICS — Light Royal Blue Theme
     ══════════════════════════════════════════════════════════════ --}}

<div style="
    background: #fff;
    border-radius: 20px;
    border: 1px solid #dde8f7;
    box-shadow: 0 4px 24px rgba(30,74,160,0.07);
    overflow: hidden;
    font-family: 'Inter', sans-serif;
">

    {{-- ── HEADER BAR ──────────────────────────────────────── --}}
    <div style="
        background: #f8fafc;
        padding: 22px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        border-bottom: 1px solid #e2e8f0;
    ">
        <div style="display:flex; align-items:center; gap:14px;">
            <div style="
                width:44px; height:44px;
                background: rgba(197, 160, 89, 0.1);
                border-radius: 12px;
                display:flex; align-items:center; justify-content:center;
                border: 1px solid rgba(197, 160, 89, 0.2);
            ">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#C5A059" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4z"/>
                </svg>
            </div>
            <div>
                <div style="font-size:1.15rem; font-weight:800; color:#0f172a; letter-spacing:-0.3px;">
                    Intelligence & Traffic
                </div>
                <div style="font-size:0.75rem; color:#64748b; font-weight:600; margin-top:1px;">
                    Operational Analytics · Last 30 Days · Real-time Sync
                </div>
            </div>
        </div>

        {{-- GTM Status Pill --}}
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <div style="
                display:flex; align-items:center; gap:6px;
                background: #f1f5f9;
                border: 1px solid #cbd5e1;
                border-radius: 12px;
                padding: 8px 16px;
                font-size: 0.72rem; font-weight:700; color:#475569;
            ">
                <div style="width:8px; height:8px; border-radius:50%; background:#10b981; box-shadow:0 0 10px rgba(16, 185, 129, 0.5);"></div>
                SYSTEM SECURE
            </div>
        </div>
    </div>

    @if(!$hasData)
    {{-- Empty state --}}
    <div style="padding:60px 32px; text-align:center;">
        <svg width="56" height="56" fill="none" viewBox="0 0 24 24" stroke="#93c5fd" stroke-width="1.5" style="margin:0 auto 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75Z" />
        </svg>
        <div style="font-size:1.1rem; font-weight:700; color:#1e3a6e; margin-bottom:8px;">No Visitor Data Yet</div>
        <div style="font-size:0.85rem; color:#64748b; max-width:380px; margin:0 auto;">
            Visitor tracking is active. Data will appear here once users visit the Builtech website.
            Make sure to run <code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:0.8rem;">php artisan migrate</code> first.
        </div>
    </div>
    @else

    {{-- ── KPI SUMMARY CARDS ────────────────────────────────── --}}
    <div class="widget-grid-kpis" style="border-bottom: 1px solid #eef2f9;">
        @php
            $kpis = [
                ['label' => 'Today\'s Visitors',    'value' => number_format($todayVisitors),  'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z', 'color' => '#3b82f6', 'bg' => '#eff6ff'],
                ['label' => '7-Day Visitors',       'value' => number_format($weekVisitors),   'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5', 'color' => '#8b5cf6', 'bg' => '#f5f3ff'],
                ['label' => '30-Day Visitors',      'value' => number_format($monthVisitors),  'icon' => 'M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941', 'color' => '#10b981', 'bg' => '#ecfdf5'],
                ['label' => 'Total Page Views',     'value' => number_format($totalPageviews), 'icon' => 'M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z', 'color' => '#f59e0b', 'bg' => '#fffbeb'],
                ['label' => 'Avg. Time on Page',   'value' => $avgTimeMin,                    'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'color' => '#f43f5e', 'bg' => '#fff1f2'],
            ];
        @endphp
        @foreach($kpis as $i => $kpi)
        <div style="
            padding: 20px 24px;
            background: #fff;
        ">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                <div style="
                    width:36px; height:36px;
                    background: {{ $kpi['bg'] }};
                    border-radius: 10px;
                    display:flex; align-items:center; justify-content:center;
                    flex-shrink:0;
                ">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="{{ $kpi['color'] }}" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $kpi['icon'] }}"/>
                    </svg>
                </div>
                <span style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.07em;">{{ $kpi['label'] }}</span>
            </div>
            <div style="font-size:1.9rem; font-weight:800; color:#0f172a; letter-spacing:-1px; line-height:1;">
                {{ $kpi['value'] }}
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── CHARTS ROW ───────────────────────────────────────── --}}
    <div class="widget-grid-charts" style="border-bottom:1px solid #eef2f9;">

        {{-- Daily Visitors Line Chart --}}
        <div style="padding:24px 28px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <div>
                    <div style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em;">Visitor Trend</div>
                    <div style="font-size:1.1rem; font-weight:800; color:#0f172a; margin-top:2px;">Daily Unique Visitors</div>
                </div>
                <div style="font-size:0.7rem; font-weight:700; color:#3b82f6; background:#eff6ff; padding:4px 12px; border-radius:20px; border:1px solid #bfdbfe;">
                    Last 14 Days
                </div>
            </div>
            <canvas id="btDailyChart" height="120"></canvas>
        </div>

        {{-- Hourly Peak Chart --}}
        <div style="padding:24px 28px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <div>
                    <div style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em;">Peak Hours</div>
                    <div style="font-size:1.1rem; font-weight:800; color:#0f172a; margin-top:2px;">Traffic by Hour (Last 7d)</div>
                </div>
                <div style="font-size:0.7rem; font-weight:700; color:#8b5cf6; background:#f5f3ff; padding:4px 12px; border-radius:20px; border:1px solid #ddd6fe;">
                    All Hours
                </div>
            </div>
            <canvas id="btHourChart" height="120"></canvas>
        </div>
    </div>

    {{-- ── BREAKDOWN ROW ────────────────────────────────────── --}}
    <div class="widget-grid-breakdown">

        {{-- Top Pages Table --}}
        <div style="padding:24px 28px;">
            <div style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:14px;">
                🏆 Top Pages (30 days)
            </div>
            @php $maxPageViews = max(1, $topPages->max('views')); @endphp
            @forelse($topPages as $page)
            <div style="margin-bottom:10px;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
                    <span style="font-size:0.78rem; font-weight:600; color:#1e3a6e; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ ucwords($page['label']) ?: '/' }}
                    </span>
                    <span style="font-size:0.75rem; font-weight:800; color:#3b82f6;">{{ number_format($page['views']) }}</span>
                </div>
                <div style="height:5px; background:#f1f5f9; border-radius:3px; overflow:hidden;">
                    <div style="height:100%; width:{{ round(($page['views']/$maxPageViews)*100) }}%; background:linear-gradient(90deg,#C5A059,#E2C285); border-radius:3px; transition:width 0.6s ease;"></div>
                </div>
            </div>
            @empty
            <div style="color:#94a3b8; font-size:0.8rem; font-style:italic;">No page data yet</div>
            @endforelse
        </div>

        {{-- Browser Breakdown --}}
        <div style="padding:24px 20px;">
            <div style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:14px;">
                🌐 Browsers
            </div>
            @php
                $totalBrowsers = max(1, $browsers->sum('count'));
                $bIcons = ['Chrome'=>'🟡','Firefox'=>'🦊','Safari'=>'🔵','Edge'=>'🔷','Opera'=>'🔴','Unknown'=>'⚪'];
            @endphp
            @forelse($browsers as $idx => $b)
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:7px;">
                    <div style="width:10px; height:10px; border-radius:3px; background:{{ $browserColors[$idx] ?? '#94a3b8' }}; flex-shrink:0;"></div>
                    <span style="font-size:0.78rem; font-weight:600; color:#374151;">{{ $b->browser ?? 'Unknown' }}</span>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:0.8rem; font-weight:800; color:#0f172a;">{{ round(($b->count/$totalBrowsers)*100) }}%</div>
                    <div style="font-size:0.65rem; color:#94a3b8;">{{ $b->count }}</div>
                </div>
            </div>
            @empty
            <div style="color:#94a3b8; font-size:0.8rem; font-style:italic;">No data</div>
            @endforelse
        </div>

        {{-- Device Breakdown --}}
        <div style="padding:24px 20px;">
            <div style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:14px;">
                📱 Devices
            </div>
            @php $totalDevices = max(1, $devices->sum('count')); @endphp
            <canvas id="btDeviceChart" width="140" height="140" style="display:block; margin:0 auto 16px;"></canvas>
            @forelse($devices as $idx => $d)
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <div style="display:flex; align-items:center; gap:7px;">
                    <div style="width:10px; height:10px; border-radius:3px; background:{{ $deviceColors[$idx] ?? '#94a3b8' }}; flex-shrink:0;"></div>
                    <span style="font-size:0.75rem; font-weight:600; color:#374151;">{{ $d->device_type ?? 'Other' }}</span>
                </div>
                <span style="font-size:0.8rem; font-weight:800; color:#0f172a;">{{ round(($d->count/$totalDevices)*100) }}%</span>
            </div>
            @empty
            <div style="color:#94a3b8; font-size:0.8rem; font-style:italic;">No data</div>
            @endforelse
        </div>

        {{-- Referrers + OS --}}
        <div style="padding:24px 20px;">
            <div style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:14px;">
                🔗 Top Referrers
            </div>
            @forelse($referrers as $ref)
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:9px;">
                <span style="font-size:0.75rem; font-weight:600; color:#374151; max-width:130px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    {{ $ref['host'] ?: 'Direct' }}
                </span>
                <span style="font-size:0.78rem; font-weight:800; color:#8b5cf6;">{{ $ref['count'] }}</span>
            </div>
            @empty
            <div style="color:#94a3b8; font-size:0.78rem; font-style:italic; margin-bottom:16px;">No referrer data yet</div>
            @endforelse

            <div style="border-top:1px solid #f1f5f9; padding-top:14px; margin-top:4px;">
                <div style="font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:10px;">
                    💻 OS
                </div>
                @foreach($osList as $os)
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                    <span style="font-size:0.75rem; font-weight:600; color:#374151;">{{ $os->os ?? 'Other' }}</span>
                    <span style="font-size:0.78rem; font-weight:800; color:#10b981;">{{ $os->count }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    @endif {{-- end hasData --}}

</div>

{{-- ── Chart.js ─────────────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function () {
    const dailyLabels = {!! $dailyLabels !!};
    const dailyCounts = {!! $dailyCounts !!};
    const hourLabels  = {!! $hourLabels !!};
    const hourCounts  = {!! $hourCounts !!};
    const devices     = {!! $devices->map(fn($d) => ['label' => $d->device_type ?? 'Other', 'count' => $d->count])->toJson() !!};

    const gridColor = 'rgba(148,163,184,0.12)';
    const tickStyle = { color:'#94a3b8', font:{ family:'Inter', size:11, weight:'600' } };

    // ── Daily Visitors Line ────────────────────────────────
    const dailyCtx = document.getElementById('btDailyChart');
    if (dailyCtx) {
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    data: dailyCounts,
                    borderColor: '#C5A059',
                    backgroundColor: (ctx) => {
                        const {ctx: c, chartArea} = ctx.chart;
                        if (!chartArea) return 'rgba(197,160,89,0.1)';
                        const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        g.addColorStop(0, 'rgba(197,160,89,0.25)');
                        g.addColorStop(1, 'rgba(197,160,89,0)');
                        return g;
                    },
                    fill: true, tension: 0.4, borderWidth: 3,
                    pointRadius: 5, pointBackgroundColor: '#C5A059',
                    pointBorderColor: '#fff', pointBorderWidth: 2.5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: {
                    legend: { display:false },
                    tooltip: {
                        backgroundColor: '#0f172a', titleColor: '#60a5fa', bodyColor: '#e2e8f0',
                        cornerRadius: 10, padding: 10,
                        callbacks: { label: ctx => ` ${ctx.parsed.y} visitors` }
                    }
                },
                scales: {
                    x: { grid: { color: gridColor }, ticks: tickStyle, border: { display:false } },
                    y: { grid: { color: gridColor }, ticks: { ...tickStyle, stepSize: 1 }, border: { display:false }, min: 0 },
                }
            }
        });
    }

    // ── Peak Hours Bar ─────────────────────────────────────
    const hourCtx = document.getElementById('btHourChart');
    if (hourCtx) {
        const filteredHours = hourLabels.filter((_, i) => i % 2 === 0);
        const filteredCounts = hourCounts.filter((_, i) => i % 2 === 0);
        new Chart(hourCtx, {
            type: 'bar',
            data: {
                labels: filteredHours,
                datasets: [{
                    data: filteredCounts,
                    backgroundColor: (ctx) => {
                        const {ctx: c, chartArea} = ctx.chart;
                        if (!chartArea) return 'rgba(197,160,89,0.7)';
                        const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        g.addColorStop(0, 'rgba(197,160,89,0.9)');
                        g.addColorStop(1, 'rgba(197,160,89,0.3)');
                        return g;
                    },
                    borderRadius: 6, borderSkipped: false,
                    hoverBackgroundColor: '#C5A059',
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: {
                    legend: { display:false },
                    tooltip: {
                        backgroundColor: '#0f172a', titleColor: '#a78bfa', bodyColor: '#e2e8f0',
                        cornerRadius: 10, padding: 10,
                        callbacks: { label: ctx => ` ${ctx.parsed.y} visits` }
                    }
                },
                scales: {
                    x: { grid: { display:false }, ticks: tickStyle, border: { display:false } },
                    y: { grid: { color: gridColor }, ticks: { ...tickStyle, stepSize: 1 }, border: { display:false }, min: 0 },
                }
            }
        });
    }

    // ── Device Donut ───────────────────────────────────────
    const deviceCtx = document.getElementById('btDeviceChart');
    if (deviceCtx && devices.length) {
        new Chart(deviceCtx, {
            type: 'doughnut',
            data: {
                labels: devices.map(d => d.label),
                datasets: [{
                    data: devices.map(d => d.count),
                    backgroundColor: ['#3b82f6','#10b981','#f59e0b'],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: false, cutout: '68%',
                plugins: {
                    legend: { display:false },
                    tooltip: {
                        backgroundColor: '#0f172a', cornerRadius: 10, padding: 10,
                        titleFont: { family:'Inter', size:11 }, bodyFont: { family:'Inter', size:11 },
                    }
                }
            }
        });
    }
})();
</script>
