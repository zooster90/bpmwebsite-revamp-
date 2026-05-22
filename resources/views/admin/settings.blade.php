<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>System Settings — Builtech Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN (replace with compiled asset if using Mix/Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:    { DEFAULT: '#0d1b2a', mid: '#162032', card: '#1c2b3d', border: '#243447' },
                        gold:    { DEFAULT: '#c9a84c', light: '#e2c87a', dim: 'rgba(201,168,76,0.12)' },
                    },
                    fontFamily: {
                        sans:    ['Inter', 'sans-serif'],
                        display: ['"Playfair Display"', 'serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { background-color: #0d1b2a; }

        /* Subtle grid overlay on the page background */
        .grid-bg {
            background-image:
                linear-gradient(rgba(201,168,76,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* Custom toggle switch */
        .toggle-input:checked + .toggle-track { background-color: #c9a84c; }
        .toggle-input:checked + .toggle-track .toggle-thumb {
            transform: translateX(1.5rem);
            background-color: #0d1b2a;
        }
        .toggle-thumb { transition: transform .25s cubic-bezier(.4,0,.2,1); }

        /* Card hover glow */
        .settings-card:hover { box-shadow: 0 0 0 1px rgba(201,168,76,.2), 0 8px 32px rgba(0,0,0,.4); }

        /* Toast */
        #toast { transition: all .4s cubic-bezier(.4,0,.2,1); }
        #toast.show { opacity: 1; transform: translateY(0); }
        #toast.hide { opacity: 0; transform: translateY(1rem); pointer-events: none; }

        /* Row hover */
        .setting-row:hover { background: rgba(201,168,76,.04); }

        /* Section tab active */
        .tab-btn.active {
            background: rgba(201,168,76,.12);
            color: #c9a84c;
            border-color: rgba(201,168,76,.3);
        }
    </style>
</head>
<body class="grid-bg font-sans text-white min-h-screen">

    {{-- ── Toast Notification ────────────────────────────────────────────── --}}
    <div id="toast"
         role="alert"
         class="hide fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-navy-card border border-gold/20 rounded-xl px-5 py-3.5 shadow-2xl max-w-xs">
        <div id="toast-icon" class="w-5 h-5 shrink-0"></div>
        <p id="toast-msg" class="text-sm text-gray-200"></p>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-10 lg:py-16">

        {{-- ── Page Header ──────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
            <div>
                <p class="text-xs font-semibold tracking-[.16em] uppercase text-gold mb-1">
                    Admin Panel
                </p>
                <h1 class="font-display text-3xl font-semibold text-white leading-tight">
                    System Settings
                </h1>
                <p class="text-sm text-gray-400 mt-1">
                    Configure global site behaviour and operational controls.
                </p>
            </div>

            {{-- Save all button (form fallback) --}}
            <button form="settings-form" type="submit"
                    id="btn-save-all"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-gold text-navy font-semibold text-sm
                           hover:bg-gold-light transition-colors duration-200 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Save All Changes
            </button>
        </div>

        {{-- ── Flash message (server-side) ─────────────────────────────── --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400
                        text-sm px-5 py-3 rounded-xl">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.707-9.293a1 1 0 0 0-1.414-1.414L9 10.586 7.707 9.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Section Tabs ─────────────────────────────────────────────── --}}
        <div class="flex flex-wrap gap-2 mb-8" role="tablist" id="section-tabs">
            <button type="button" data-tab="system"
                    class="tab-btn active text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-lg border border-white/10 text-gray-300 transition-all duration-200"
                    onclick="switchTab('system', this)">
                System
            </button>
            <button type="button" data-tab="general"
                    class="tab-btn text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-lg border border-white/10 text-gray-300 transition-all duration-200"
                    onclick="switchTab('general', this)">
                General
            </button>
            <button type="button" data-tab="media"
                    class="tab-btn text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-lg border border-white/10 text-gray-300 transition-all duration-200"
                    onclick="switchTab('media', this)">
                Media
            </button>
            <button type="button" data-tab="notifications"
                    class="tab-btn text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-lg border border-white/10 text-gray-300 transition-all duration-200"
                    onclick="switchTab('notifications', this)">
                Notifications
            </button>
        </div>

        {{-- ── Settings Form ─────────────────────────────────────────────── --}}
        <form id="settings-form" method="POST" action="{{ route('admin.settings.bulk') }}">
            @csrf
            @method('PATCH')

            @foreach ($settings as $group => $groupSettings)
                <div id="tab-{{ $group }}" class="tab-panel {{ $group === 'system' ? '' : 'hidden' }} space-y-4">

                    {{-- ── System Status Card (special featured card) ───── --}}
                    @if ($group === 'system')
                    <div class="settings-card bg-navy-card border border-navy-border rounded-2xl overflow-hidden
                                transition-all duration-300 mb-6">

                        {{-- Card header with alert indicator --}}
                        <div class="flex items-center gap-3 px-6 py-4 border-b border-navy-border">
                            <div class="w-8 h-8 rounded-lg bg-gold/10 border border-gold/20 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-white">System Status &amp; Controls</h2>
                                <p class="text-xs text-gray-400">Critical operational toggles — changes take effect immediately.</p>
                            </div>

                            {{-- Live status badge --}}
                            @php $isDown = $groupSettings->firstWhere('key', 'maintenance_mode')?->value == '1'; @endphp
                            <div id="live-status-badge"
                                 class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $isDown ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' }}">
                                <span id="live-status-dot"
                                      class="w-2 h-2 rounded-full {{ $isDown ? 'bg-amber-400' : 'bg-emerald-400' }}
                                             {{ $isDown ? 'animate-pulse' : '' }}"></span>
                                <span id="live-status-text">{{ $isDown ? 'Maintenance Active' : 'Site Live' }}</span>
                            </div>
                        </div>

                        {{-- Settings rows --}}
                        <div class="divide-y divide-navy-border">
                            @foreach ($groupSettings as $setting)
                                <div class="setting-row flex flex-col sm:flex-row sm:items-center gap-4 px-6 py-5 transition-colors duration-150">
                                    <div class="flex-1 min-w-0">
                                        <label for="setting-{{ $setting->key }}" class="block text-sm font-medium text-white">
                                            {{ $setting->label ?? $setting->key }}
                                        </label>
                                        <p class="text-xs text-gray-400 mt-0.5">Key: <code class="font-mono text-gold/80">{{ $setting->key }}</code></p>
                                    </div>

                                    <div class="shrink-0 sm:w-72">
                                        {{-- ── BOOLEAN / Toggle ───────────────────────────────────── --}}
                                        @if ($setting->type === 'boolean')
                                            <div class="flex items-center gap-3">
                                                {{-- Hidden input ensures '0' is posted if unchecked --}}
                                                <input type="hidden" name="{{ $setting->key }}" value="0" />

                                                <label class="relative inline-flex items-center cursor-pointer"
                                                       id="toggle-label-{{ $setting->key }}">
                                                    <input type="checkbox"
                                                           id="setting-{{ $setting->key }}"
                                                           name="{{ $setting->key }}"
                                                           value="1"
                                                           class="toggle-input sr-only"
                                                           {{ $setting->value == '1' ? 'checked' : '' }}
                                                           onchange="saveSetting('{{ $setting->key }}', this.checked ? '1' : '0', this)"
                                                    />
                                                    <div class="toggle-track relative w-12 h-6 bg-white/10 rounded-full border border-white/10 transition-colors duration-300">
                                                        <div class="toggle-thumb absolute top-0.5 left-0.5 w-5 h-5 bg-gray-400 rounded-full shadow {{ $setting->value == '1' ? 'translate-x-6 !bg-navy' : '' }}"></div>
                                                    </div>
                                                </label>

                                                <span id="toggle-label-text-{{ $setting->key }}"
                                                      class="text-sm font-medium {{ $setting->value == '1' ? 'text-amber-400' : 'text-gray-400' }}">
                                                    {{ $setting->value == '1' ? 'Enabled' : 'Disabled' }}
                                                </span>
                                            </div>

                                        {{-- ── TEXTAREA ────────────────────────────────────────────── --}}
                                        @elseif ($setting->type === 'textarea')
                                            <textarea id="setting-{{ $setting->key }}"
                                                      name="{{ $setting->key }}"
                                                      rows="3"
                                                      class="w-full bg-navy/60 border border-navy-border rounded-lg px-3 py-2.5 text-sm text-gray-200
                                                             placeholder-gray-500 focus:outline-none focus:border-gold/50 focus:ring-1 focus:ring-gold/20
                                                             transition-colors duration-200 resize-none"
                                            >{{ old($setting->key, $setting->value) }}</textarea>

                                        {{-- ── TEXT (default) ──────────────────────────────────────── --}}
                                        @else
                                            <input type="text"
                                                   id="setting-{{ $setting->key }}"
                                                   name="{{ $setting->key }}"
                                                   value="{{ old($setting->key, $setting->value) }}"
                                                   class="w-full bg-navy/60 border border-navy-border rounded-lg px-3 py-2.5 text-sm text-gray-200
                                                          placeholder-gray-500 focus:outline-none focus:border-gold/50 focus:ring-1 focus:ring-gold/20
                                                          transition-colors duration-200"
                                            />
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>{{-- /System card --}}
                    @else

                    {{-- ── Generic Group Card ────────────────────────────── --}}
                    <div class="settings-card bg-navy-card border border-navy-border rounded-2xl overflow-hidden transition-all duration-300">
                        <div class="px-6 py-4 border-b border-navy-border">
                            <h2 class="text-sm font-semibold text-white capitalize">{{ $group }} Settings</h2>
                        </div>
                        <div class="divide-y divide-navy-border">
                            @foreach ($groupSettings as $setting)
                                <div class="setting-row flex flex-col sm:flex-row sm:items-center gap-4 px-6 py-5 transition-colors duration-150">
                                    <div class="flex-1 min-w-0">
                                        <label for="setting-{{ $setting->key }}" class="block text-sm font-medium text-white">
                                            {{ $setting->label ?? $setting->key }}
                                        </label>
                                        <p class="text-xs text-gray-400 mt-0.5">Key: <code class="font-mono text-gold/80">{{ $setting->key }}</code></p>
                                    </div>
                                    <div class="shrink-0 sm:w-72">
                                        @if ($setting->type === 'boolean')
                                            <div class="flex items-center gap-3">
                                                <input type="hidden" name="{{ $setting->key }}" value="0" />
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox"
                                                           id="setting-{{ $setting->key }}"
                                                           name="{{ $setting->key }}"
                                                           value="1"
                                                           class="toggle-input sr-only"
                                                           {{ $setting->value == '1' ? 'checked' : '' }}
                                                           onchange="saveSetting('{{ $setting->key }}', this.checked ? '1' : '0', this)"
                                                    />
                                                    <div class="toggle-track relative w-12 h-6 bg-white/10 rounded-full border border-white/10 transition-colors duration-300">
                                                        <div class="toggle-thumb absolute top-0.5 left-0.5 w-5 h-5 bg-gray-400 rounded-full shadow {{ $setting->value == '1' ? 'translate-x-6 !bg-navy' : '' }}"></div>
                                                    </div>
                                                </label>
                                                <span class="text-sm text-gray-400">{{ $setting->value == '1' ? 'Enabled' : 'Disabled' }}</span>
                                            </div>
                                        @elseif ($setting->type === 'textarea')
                                            <textarea id="setting-{{ $setting->key }}" name="{{ $setting->key }}" rows="3"
                                                      class="w-full bg-navy/60 border border-navy-border rounded-lg px-3 py-2.5 text-sm text-gray-200
                                                             focus:outline-none focus:border-gold/50 focus:ring-1 focus:ring-gold/20 transition-colors duration-200 resize-none"
                                            >{{ old($setting->key, $setting->value) }}</textarea>
                                        @else
                                            <input type="text" id="setting-{{ $setting->key }}" name="{{ $setting->key }}"
                                                   value="{{ old($setting->key, $setting->value) }}"
                                                   class="w-full bg-navy/60 border border-navy-border rounded-lg px-3 py-2.5 text-sm text-gray-200
                                                          focus:outline-none focus:border-gold/50 focus:ring-1 focus:ring-gold/20 transition-colors duration-200" />
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>{{-- /Generic card --}}
                    @endif

                </div>{{-- /tab-panel --}}
            @endforeach

        </form>

    </div>{{-- /max-w-5xl --}}

    {{-- ── JavaScript ─────────────────────────────────────────────────────── --}}
    <script>
        // ─── Tab Switcher ────────────────────────────────────────────────────
        function switchTab(group, btn) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            const panel = document.getElementById('tab-' + group);
            if (panel) panel.classList.remove('hidden');
            btn.classList.add('active');
        }

        // ─── AJAX single-setting save (used by toggles) ──────────────────────
        async function saveSetting(key, value, inputEl) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Optimistic UI feedback on the maintenance toggle badge
            if (key === 'maintenance_mode') {
                updateMaintenanceBadge(value === '1');
            }

            try {
                const res = await fetch('{{ route("admin.settings.update") }}', {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept':       'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ key, value }),
                });

                const data = await res.json();

                if (data.success) {
                    showToast('success', `"${key}" updated successfully.`);

                    // Update toggle label text
                    const labelEl = document.getElementById('toggle-label-text-' + key);
                    if (labelEl) {
                        labelEl.textContent = value === '1' ? 'Enabled' : 'Disabled';
                        labelEl.className = `text-sm font-medium ${value === '1' ? 'text-amber-400' : 'text-gray-400'}`;
                    }
                } else {
                    showToast('error', data.message || 'Update failed.');
                    // Revert toggle on failure
                    if (inputEl) inputEl.checked = !inputEl.checked;
                    if (key === 'maintenance_mode') updateMaintenanceBadge(inputEl.checked);
                }
            } catch (err) {
                showToast('error', 'Network error. Please try again.');
                if (inputEl) inputEl.checked = !inputEl.checked;
                if (key === 'maintenance_mode') updateMaintenanceBadge(inputEl.checked);
            }
        }

        // ─── Update the live status badge for maintenance mode ───────────────
        function updateMaintenanceBadge(isDown) {
            const badge = document.getElementById('live-status-badge');
            const dot   = document.getElementById('live-status-dot');
            const text  = document.getElementById('live-status-text');
            if (!badge) return;

            if (isDown) {
                badge.className = badge.className.replace(/bg-\S+\/10\s+text-\S+\s+border\s+border-\S+\/20/,
                    'bg-amber-500/10 text-amber-400 border border-amber-500/20');
                dot.className   = dot.className.replace(/bg-\S+/, 'bg-amber-400') + ' animate-pulse';
                text.textContent = 'Maintenance Active';
            } else {
                badge.className = badge.className.replace(/bg-\S+\/10\s+text-\S+\s+border\s+border-\S+\/20/,
                    'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20');
                dot.className   = dot.className.replace(/bg-\S+/, 'bg-emerald-400').replace(' animate-pulse', '');
                text.textContent = 'Site Live';
            }
        }

        // ─── Toast notification helper ───────────────────────────────────────
        function showToast(type, msg) {
            const toast    = document.getElementById('toast');
            const iconEl   = document.getElementById('toast-icon');
            const msgEl    = document.getElementById('toast-msg');

            msgEl.textContent = msg;

            if (type === 'success') {
                iconEl.innerHTML = `<svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-400">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.707-9.293a1 1 0 0 0-1.414-1.414L9 10.586 7.707 9.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>`;
            } else {
                iconEl.innerHTML = `<svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-rose-400">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd"/>
                </svg>`;
            }

            toast.classList.remove('hide');
            toast.classList.add('show');

            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(() => {
                toast.classList.remove('show');
                toast.classList.add('hide');
            }, 3200);
        }
    </script>
</body>
</html>
