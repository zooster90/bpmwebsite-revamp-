@php
    // Filament v3 injects getViewData() keys directly as view variables.
    // Variables available: $months, $inquiryData, $newsData, $statusBreakdown, $totalInquiries, $resolvedRate
    $months    = json_encode($months   ?? []);
    $inqData   = json_encode($inquiryData ?? []);
    $newsData  = json_encode($newsData ?? []);
    $statusBk  = $statusBreakdown ?? ['new' => 0, 'in_progress' => 0, 'resolved' => 0];
    $rate      = $resolvedRate ?? 0;
    $total     = $totalInquiries ?? 0;
@endphp

<style>
.dashboard-analytics-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
}
.dashboard-analytics-grid > div {
    border-right: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}
.dashboard-analytics-grid > div:last-child {
    border-right: none;
}

@media (max-width: 1024px) {
    .dashboard-analytics-grid {
        grid-template-columns: 1fr;
    }
    .dashboard-analytics-grid > div {
        border-right: none !important;
    }
}
</style>

<x-filament-widgets::widget>
<div style="
    background: var(--bt-card);
    border-radius: var(--bt-radius);
    border: 1px solid var(--bt-border);
    box-shadow: var(--bt-shadow);
    overflow: hidden;
">

    {{-- ── Header ────────────────────────────────────────── --}}
    <div style="
        background: linear-gradient(135deg, #0A1326 0%, #112240 100%);
        padding: 24px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    ">
        <div>
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:4px;">
                <div style="
                    width:36px; height:36px;
                    background: #C5A059;
                    border-radius: 10px;
                    display:flex; align-items:center; justify-content:center;
                    box-shadow: 0 4px 12px rgba(197, 160, 89, 0.2);
                ">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#FFFFFF" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <h2 style="font-size:1.2rem; font-weight:800; color:#fff; letter-spacing:-0.3px; margin:0;">
                    Performance Analytics
                </h2>
            </div>
            <p style="font-size:0.85rem; color:rgba(255,255,255,0.6); margin:0; font-weight:500;">
                6-month trend · Auto-refreshed every 30 seconds
            </p>
        </div>

        {{-- KPI Summary Pills --}}
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
            <div style="
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 12px;
                padding: 10px 18px;
                text-align: center;
            ">
                <div style="font-size:1.5rem; font-weight:800; color:#FFFFFF; line-height:1;">{{ $total }}</div>
                <div style="font-size:0.65rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.08em; margin-top:2px;">Total Inquiries</div>
            </div>
            <div style="
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 12px;
                padding: 10px 18px;
                text-align: center;
            ">
                <div style="font-size:1.5rem; font-weight:800; color:#10B981; line-height:1;">{{ $rate }}%</div>
                <div style="font-size:0.65rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.08em; margin-top:2px;">Resolution Rate</div>
            </div>
            <div style="
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 12px;
                padding: 10px 18px;
                text-align: center;
            ">
                <div style="font-size:1.5rem; font-weight:800; color:#C5A059; line-height:1;">{{ $statusBk['new'] }}</div>
                <div style="font-size:0.65rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.08em; margin-top:2px;">Pending Review</div>
            </div>
        </div>
    </div>

    {{-- ── Charts Grid ────────────────────────────────────── --}}
    <div class="dashboard-analytics-grid">

        {{-- Line Chart: Inquiry Trend --}}
        <div style="padding: 24px 24px 24px 32px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <div>
                    <div style="font-size:0.75rem; font-weight:800; color:#64748B; text-transform:uppercase; letter-spacing:0.1em;">Monthly Inquiries</div>
                    <div style="font-size:1.4rem; font-weight:800; color:#0A1326; letter-spacing:-0.5px; margin-top:2px;">Lead Trend</div>
                </div>
                <div style="
                    background: rgba(197,160,89,0.1);
                    border: 1px solid rgba(197,160,89,0.2);
                    border-radius: 8px;
                    padding: 4px 12px;
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #C5A059;
                ">6 Months</div>
            </div>
            <canvas id="btInquiryChart" height="140"></canvas>
        </div>

        {{-- Bar Chart: News Published --}}
        <div style="padding: 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <div>
                    <div style="font-size:0.75rem; font-weight:800; color:#64748B; text-transform:uppercase; letter-spacing:0.1em;">Content Output</div>
                    <div style="font-size:1.4rem; font-weight:800; color:#0A1326; letter-spacing:-0.5px; margin-top:2px;">News Published</div>
                </div>
                <div style="
                    background: rgba(26,54,93,0.1);
                    border: 1px solid rgba(26,54,93,0.2);
                    border-radius: 8px;
                    padding: 4px 12px;
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #1A365D;
                ">Monthly</div>
            </div>
            <canvas id="btNewsChart" height="140"></canvas>
        </div>

        {{-- Donut Chart: Inquiry Status --}}
        <div style="padding: 24px; display:flex; flex-direction:column; justify-content:center;">
            <div style="margin-bottom:16px;">
                <div style="font-size:0.75rem; font-weight:800; color:#64748B; text-transform:uppercase; letter-spacing:0.1em;">Inquiry Pipeline</div>
                <div style="font-size:1.4rem; font-weight:800; color:#0A1326; letter-spacing:-0.5px; margin-top:2px;">Status Breakdown</div>
            </div>
            <div style="position:relative; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                <canvas id="btStatusChart" width="160" height="160"></canvas>
                <div style="position:absolute; text-align:center; pointer-events:none;">
                    <div style="font-size:1.6rem; font-weight:800; color:#0A1326; line-height:1;">{{ $total }}</div>
                    <div style="font-size:0.65rem; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.06em;">Total</div>
                </div>
            </div>
            {{-- Legend --}}
            <div style="display:flex; flex-direction:column; gap:8px;">
                <div style="display:flex; align-items:center; justify-content:space-between; font-size:0.85rem;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:12px; height:12px; border-radius:4px; background:#C5A059; flex-shrink:0;"></div>
                        <span style="font-weight:600; color:#64748B;">New</span>
                    </div>
                    <span style="font-weight:800; color:#1E293B;">{{ $statusBk['new'] }}</span>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between; font-size:0.85rem;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:12px; height:12px; border-radius:4px; background:#1A365D; flex-shrink:0;"></div>
                        <span style="font-weight:600; color:#64748B;">In Progress</span>
                    </div>
                    <span style="font-weight:800; color:#1E293B;">{{ $statusBk['in_progress'] }}</span>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between; font-size:0.85rem;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:12px; height:12px; border-radius:4px; background:#10B981; flex-shrink:0;"></div>
                        <span style="font-weight:600; color:#64748B;">Resolved</span>
                    </div>
                    <span style="font-weight:800; color:#1E293B;">{{ $statusBk['resolved'] }}</span>
                </div>
            </div>
        </div>

    </div>{{-- end charts grid --}}

    {{-- ── Image Card Strip ───────────────────────────────── --}}
    <div style="
        background: #F8FAFC;
        padding: 24px 32px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    ">
        <div style="font-size:0.75rem; font-weight:800; color:#64748B; text-transform:uppercase; letter-spacing:0.1em; flex-shrink:0;">
            Featured Project
        </div>
        {{-- Placeholder project image cards --}}
        @php
            $projects = \App\Models\Project::where('is_published', true)->latest()->take(4)->get();
        @endphp
        <div style="display:flex; gap:16px; overflow-x:auto; padding-bottom:4px;">
            @forelse($projects as $project)
                @php
                    $thumb = $project->getFirstMediaUrl('project-images') ?: $project->getFirstMediaUrl('gallery');
                @endphp
                <div style="
                    flex-shrink: 0;
                    width: 180px;
                    border-radius: 12px;
                    overflow: hidden;
                    border: 1px solid #E2E8F0;
                    background: #FFFFFF;
                    transition: all 0.2s ease;
                    cursor: pointer;
                " onmouseover="this.style.borderColor='#C5A059';this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 12px rgba(197,160,89,0.1)';"
                   onmouseout="this.style.borderColor='#E2E8F0';this.style.transform='translateY(0)';this.style.boxShadow='none';">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $project->title }}"
                             style="width:100%; height:100px; object-fit:cover; display:block;">
                    @else
                        <div style="
                            width:100%; height:100px;
                            background: #112240;
                            display:flex; align-items:center; justify-content:center;
                        ">
                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#C5A059" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                        </div>
                    @endif
                    <div style="padding:12px;">
                        <div style="font-size:0.8rem; font-weight:700; color:#1E293B; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $project->title }}
                        </div>
                        <div style="font-size:0.7rem; color:#64748B; margin-top:2px; font-weight:500;">
                            {{ $project->category ?? 'Project' }}
                        </div>
                    </div>
                </div>
            @empty
                <div style="font-size:0.85rem; color:#64748B; font-weight:500; font-style:italic;">No projects published yet.</div>
            @endforelse
        </div>
        <a href="{{ route('filament.admin.resources.projects.index') }}"
           style="
                margin-left:auto; flex-shrink:0;
                font-size:0.85rem; font-weight:700;
                color:#C5A059; text-decoration:none;
                display:flex; align-items:center; gap:6px;
                padding:10px 20px;
                border:1px solid rgba(197,160,89,0.3);
                border-radius:10px;
                background:rgba(197,160,89,0.05);
                transition:all 0.2s ease;
           "
           onmouseover="this.style.background='rgba(197,160,89,0.1)';this.style.borderColor='rgba(197,160,89,0.5)';"
           onmouseout="this.style.background='rgba(197,160,89,0.05)';this.style.borderColor='rgba(197,160,89,0.3)';"
        >
            View All Projects →
        </a>
    </div>

</div>

{{-- ── Chart.js ─────────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function() {
    const months   = {!! $months !!};
    const inqData  = {!! $inqData !!};
    const newsData = {!! $newsData !!};
    const status   = {!! json_encode($statusBk) !!};

    const commonGrid = {
        color: 'rgba(100,116,139,0.1)',
        drawBorder: false,
    };
    const commonTick = {
        color: '#64748B',
        font: { family: 'Outfit', size: 11, weight: '500' },
    };

    // ── Line Chart: Inquiries ──────────────────────────
    const inqCtx = document.getElementById('btInquiryChart');
    if (inqCtx) {
        new Chart(inqCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Inquiries',
                    data: inqData,
                    borderColor: '#C5A059',
                    backgroundColor: (ctx) => {
                        const chart = ctx.chart;
                        const {ctx: c, chartArea} = chart;
                        if (!chartArea) return 'transparent';
                        const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        g.addColorStop(0, 'rgba(197,160,89,0.25)');
                        g.addColorStop(1, 'rgba(197,160,89,0)');
                        return g;
                    },
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#C5A059',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#FFFFFF',
                        titleColor: '#C5A059',
                        bodyColor: '#1E293B',
                        borderColor: 'rgba(197,160,89,0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        titleFont: { family: 'Outfit', weight: '700', size: 13 },
                        bodyFont: { family: 'Outfit', size: 13, weight: '500' },
                        boxShadow: '0 4px 15px rgba(0,0,0,0.05)',
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} inquiries`,
                        }
                    }
                },
                scales: {
                    x: { grid: commonGrid, ticks: commonTick, border: { display: false } },
                    y: { grid: commonGrid, ticks: { ...commonTick, stepSize: 1 }, border: { display: false }, min: 0 },
                }
            }
        });
    }

    // ── Bar Chart: News ────────────────────────────────
    const newsCtx = document.getElementById('btNewsChart');
    if (newsCtx) {
        new Chart(newsCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Articles',
                    data: newsData,
                    backgroundColor: (ctx) => {
                        const chart = ctx.chart;
                        const {ctx: c, chartArea} = chart;
                        if (!chartArea) return 'rgba(26,54,93,0.7)';
                        const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        g.addColorStop(0, 'rgba(26,54,93,0.85)');
                        g.addColorStop(1, 'rgba(26,54,93,0.3)');
                        return g;
                    },
                    borderRadius: 6,
                    borderSkipped: false,
                    hoverBackgroundColor: '#112240',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#FFFFFF',
                        titleColor: '#1A365D',
                        bodyColor: '#1E293B',
                        borderColor: 'rgba(26,54,93,0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        titleFont: { family: 'Outfit', weight: '700', size: 13 },
                        bodyFont: { family: 'Outfit', size: 13, weight: '500' },
                        boxShadow: '0 4px 15px rgba(0,0,0,0.05)',
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} articles published`,
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: commonTick, border: { display: false } },
                    y: { grid: commonGrid, ticks: { ...commonTick, stepSize: 1 }, border: { display: false }, min: 0 },
                }
            }
        });
    }

    // ── Donut Chart: Status Breakdown ─────────────────
    const statusCtx = document.getElementById('btStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['New', 'In Progress', 'Resolved'],
                datasets: [{
                    data: [status.new, status.in_progress, status.resolved],
                    backgroundColor: ['#C5A059', '#1A365D', '#10B981'],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#FFFFFF',
                        titleColor: '#0A1326',
                        bodyColor: '#1E293B',
                        borderColor: 'rgba(10,19,38,0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        titleFont: { family: 'Outfit', weight: '700', size: 12 },
                        bodyFont: { family: 'Outfit', size: 12, weight: '500' },
                    }
                }
            }
        });
    }
})();
</script>
</x-filament-widgets::widget>
