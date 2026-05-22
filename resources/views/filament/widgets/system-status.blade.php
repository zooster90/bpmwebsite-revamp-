<x-filament-widgets::widget>
    <div style="
        background: var(--bt-card);
        border-radius: var(--bt-radius);
        border: 1px solid var(--bt-border);
        box-shadow: var(--bt-shadow);
        padding: 24px;
    ">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <div style="
                width:36px; height:36px;
                background: rgba(26, 54, 93, 0.05);
                border-radius: 10px;
                display:flex; align-items:center; justify-content:center;
                border: 1px solid rgba(26, 54, 93, 0.1);
            ">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--bt-navy)" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3v3.75a3 3 0 0 1-3 3m-13.5 0a3 3 0 0 0-3 3v3.75a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3V17.25a3 3 0 0 0-3-3m-13.5 0h13.5m-13.5 6h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Zm13.5 6h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Z" />
                </svg>
            </div>
            <div>
                <div style="font-size:0.9rem; font-weight:800; color:var(--bt-navy); letter-spacing:0.05em; text-transform:uppercase;">System Health</div>
                <div style="font-size:0.75rem; color:var(--bt-muted); font-weight:500;">Environment & Performance</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
            <div style="background:#F8FAFC; padding:12px; border-radius:12px; border:1px solid #E2E8F0;">
                <div style="font-size:0.65rem; font-weight:700; color:var(--bt-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">PHP Version</div>
                <div style="font-size:0.95rem; font-weight:800; color:var(--bt-navy);">{{ $phpVersion }}</div>
            </div>

            <div style="background:#F8FAFC; padding:12px; border-radius:12px; border:1px solid #E2E8F0;">
                <div style="font-size:0.65rem; font-weight:700; color:var(--bt-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">Laravel</div>
                <div style="font-size:0.95rem; font-weight:800; color:var(--bt-navy);">v{{ $laravelVersion }}</div>
            </div>

            <div style="background:#F8FAFC; padding:12px; border-radius:12px; border:1px solid #E2E8F0;">
                <div style="font-size:0.65rem; font-weight:700; color:var(--bt-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">Database ({{ strtoupper($dbDriver) }})</div>
                <div style="font-size:0.95rem; font-weight:800; color:var(--bt-navy);">{{ $dbSize }}</div>
            </div>

            <div style="background:#F8FAFC; padding:12px; border-radius:12px; border:1px solid #E2E8F0;">
                <div style="font-size:0.65rem; font-weight:700; color:var(--bt-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">Environment</div>
                <div style="
                    font-size:0.8rem; font-weight:800;
                    color:{{ $environment === 'production' ? '#10B981' : '#F59E0B' }};
                    text-transform:uppercase;
                ">{{ $environment }}</div>
            </div>
        </div>

        <div style="margin-top:16px; font-size:0.7rem; color:var(--bt-muted); font-weight:500; display:flex; align-items:center; gap:6px;">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            Server: {{ $serverSoftware }}
        </div>
    </div>
</x-filament-widgets::widget>
