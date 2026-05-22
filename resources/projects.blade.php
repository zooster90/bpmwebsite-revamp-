<x-layout>
    <x-slot:title>{{ $project->name }} | Case Study | Builtech</x-slot:title>
    <x-slot:description>{{ Str::limit(strip_tags($project->description), 160) }}</x-slot:description>

    @php
        // ── Fallback Image ──
        $fallback = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?auto=format&fit=crop&q=80&w=2000';
        if (in_array($project->category, ['Civic', 'Infrastructure', 'Civil & Infrastructural Works'])) {
            $fallback = 'https://images.unsplash.com/photo-1513828583688-c52646db42da?auto=format&fit=crop&q=80&w=2000';
        }

        // ── Status ──
        $statusRaw = strtolower(trim($project->status ?? 'completed'));
        if (in_array($statusRaw, ['active', 'in progress', 'ongoing', 'started'])) {
            $statusDot = 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]';
            $statusLabel = 'In Progress';
            $statusPulse = true;
        } else if (in_array($statusRaw, ['pending', 'upcoming', 'soon'])) {
            $statusDot = 'bg-sky-500 shadow-[0_0_8px_rgba(14,165,233,0.5)]';
            $statusLabel = 'Upcoming';
            $statusPulse = true;
        } else {
            $statusDot = 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]';
            $statusLabel = 'Completed';
            $statusPulse = false;
        }

        // ── Hero Source ──
        $heroSrc = $fallback;
        if (!empty($project->cover_image_upload)) {
            $heroSrc = asset('storage/' . $project->cover_image_upload);
        } else if (!empty($project->image_url)) {
            $heroSrc = $project->image_url;
        } else if (method_exists($project, 'getFirstMediaUrl') && $project->getFirstMediaUrl('cover_image')) {
            $heroSrc = $project->getFirstMediaUrl('cover_image');
        }

        // ── Gallery: first image hero-sized, rest in pairs ──
        $galleryHero = $heroSrc;
        $galleryPairs = array();
        if (method_exists($project, 'hasMedia') && $project->hasMedia('gallery')) {
            $galleryItems = $project->getMedia('gallery');
            $seen = array($heroSrc);
            $pair = array();
            foreach ($galleryItems as $gi) {
                $url = $gi->getUrl();
                if (!in_array($url, $seen)) {
                    $pair[] = $url;
                    $seen[] = $url;
                    if (count($pair) === 2) {
                        $galleryPairs[] = $pair;
                        $pair = array();
                    }
                }
            }
            if (count($pair) === 1) {
                $galleryPairs[] = $pair;
            }
        }
        $totalImages = 1 + count($galleryPairs) * 2;
        // correct for odd trailing pair
        if (!empty($galleryPairs)) {
            $lastPair = end($galleryPairs);
            if (count($lastPair) === 1) {
                $totalImages = 1 + (count($galleryPairs) - 1) * 2 + 1;
            }
        }

        // ── Awards: pre-compute images ──
        $awardData = array();
        $awardCount = 0;
        if ($project->awards) {
            $awardCount = $project->awards->count();
            foreach ($project->awards as $aw) {
                $img = null;
                if (!empty($aw->logo_upload)) {
                    $img = asset('storage/' . $aw->logo_upload);
                } else if (!empty($aw->image_url)) {
                    $img = $aw->image_url;
                } else if (method_exists($aw, 'getFirstMediaUrl') && $aw->getFirstMediaUrl('logo')) {
                    $img = $aw->getFirstMediaUrl('logo');
                }
                $awardData[] = array(
                    'id'    => $aw->id,
                    'name'  => $aw->name,
                    'issuer' => $aw->issuer,
                    'year'  => $aw->year,
                    'img'   => $img,
                );
            }
        }
    @endphp


    <!-- ═══════════════════════════════════════════════════════
         PAGE HEADER — Clean top bar with breadcrumb + status
         ═══════════════════════════════════════════════════════ -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100">
        <div class="max-w-[100rem] mx-auto px-4 md:px-8 lg:px-12 h-16 md:h-18 flex items-center justify-between">
            <a href="/projects"
               class="group flex items-center gap-2.5 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-gray-900 transition-colors">
                <span class="w-6 h-px bg-gray-300 group-hover:w-10 group-hover:bg-[#c9a84c] transition-all duration-400"></span>
                All Projects
            </a>

            <div class="flex items-center gap-4">
                <span class="hidden md:block text-[9px] font-mono text-gray-300 tracking-wider">BT-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</span>
                <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-gray-200/80 bg-gray-50/80">
                    <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }} {{ $statusPulse ? 'animate-pulse' : '' }}"></span>
                    <span class="text-[9px] font-bold uppercase tracking-[0.15em] text-gray-500">{{ $statusLabel }}</span>
                </div>
            </div>
        </div>
    </header>


    <!-- ═══════════════════════════════════════════════════════
         HERO IMAGE — Full-width cinematic opener
         ═══════════════════════════════════════════════════════ -->
    <section class="relative w-full h-[50vh] md:h-[65vh] lg:h-[72vh] mt-16 md:mt-18 overflow-hidden bg-gray-100">
        <img id="hero-bg"
             src="{{ $heroSrc }}"
             alt="{{ $project->name }}"
             class="w-full h-full object-cover"
             onerror="this.src='{{ $fallback }}'">

        <!-- Gradient overlays -->
        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/20 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-transparent"></div>

        <!-- Bottom content overlay -->
        <div class="absolute bottom-0 left-0 right-0">
            <div class="max-w-[100rem] mx-auto px-4 md:px-8 lg:px-12 pb-8 md:pb-12">
                <div class="flex items-end justify-between gap-6">
                    <div class="hero-reveal" data-delay="0">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-px bg-[#c9a84c]"></span>
                            <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#c9a84c]">{{ $project->category }}</span>
                        </div>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-gray-900 leading-[0.9] tracking-tighter max-w-3xl">
                            {{ $project->name }}
                        </h1>
                    </div>
                    <div class="hidden md:flex items-center gap-8 hero-reveal" data-delay="0.15">
                        <div class="text-right">
                            <span class="block text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-1">Location</span>
                            <span class="block text-sm font-bold text-gray-700">{{ $project->location }}</span>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="text-right">
                            <span class="block text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-1">Year</span>
                            <span class="block text-sm font-bold text-gray-700">{{ $project->year }}</span>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="text-right">
                            <span class="block text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-1">Value</span>
                            <span class="block text-sm font-bold text-[#c9a84c]">{{ $project->contract_value ?: 'Proprietary' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
         MAIN SPLIT LAYOUT
         ═══════════════════════════════════════════════════════ -->
    <main class="bg-white">
        <div class="max-w-[100rem] mx-auto px-4 md:px-8 lg:px-12 py-16 md:py-24">
            <div class="flex flex-col lg:flex-row gap-12 xl:gap-20">

                <!-- ════════ LEFT: GALLERY ════════ -->
                <article class="w-full lg:w-7/12 xl:w-2/3 order-2 lg:order-1">

                    <!-- Section label -->
                    <div class="flex items-center gap-4 mb-10 scroll-reveal">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-300">01</span>
                        <span class="w-6 h-px bg-gray-200"></span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Visual Documentation</span>
                        <span class="ml-auto text-[9px] font-mono text-gray-300 tracking-wider">{{ $totalImages }} images</span>
                    </div>

                    <div class="space-y-3 md:space-y-4">

                        <!-- Hero gallery image (full width, tall) -->
                        <figure class="gallery-item scroll-reveal relative w-full overflow-hidden bg-gray-50 m-0 group">
                            <img src="{{ $galleryHero }}"
                                 class="w-full h-[45vh] md:h-[58vh] object-cover"
                                 alt="{{ $project->name }} — Primary view"
                                 loading="eager"
                                 decoding="async">
                            <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        </figure>

                        <!-- Paired gallery images -->
                        @foreach($galleryPairs as $pairIndex => $pair)
                            @if(count($pair) === 2)
                                <div class="grid grid-cols-2 gap-3 md:gap-4">
                                    @foreach($pair as $imgIndex => $img)
                                        <figure class="gallery-item scroll-reveal relative w-full overflow-hidden bg-gray-50 m-0 group" data-delay="{{ $imgIndex * 0.08 }}">
                                            <img src="{{ $img }}"
                                                 class="w-full h-[30vh] md:h-[42vh] object-cover"
                                                 alt="{{ $project->name }} — Detail {{ $pairIndex * 2 + $imgIndex + 2 }}"
                                                 loading="lazy"
                                                 decoding="async">
                                            <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                                        </figure>
                                    @endforeach
                                </div>
                            @else
                                <!-- Single leftover image -->
                                <figure class="gallery-item scroll-reveal relative w-full overflow-hidden bg-gray-50 m-0 group">
                                    <img src="{{ $pair[0] }}"
                                         class="w-full h-[35vh] md:h-[45vh] object-cover"
                                         alt="{{ $project->name }} — Additional view"
                                         loading="lazy"
                                         decoding="async">
                                    <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                                </figure>
                            @endif
                        @endforeach

                        @if(empty($galleryPairs))
                            <div class="text-center py-12">
                                <span class="text-[10px] font-mono text-gray-300 tracking-wider">Archival Ref. BT-{{ str_pad($project->id + 1000, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        @endif

                    </div>
                </article>


                <!-- ════════ RIGHT: DETAILS (STICKY) ════════ -->
                <aside class="w-full lg:w-5/12 xl:w-1/3 order-1 lg:order-2">
                    <div class="lg:sticky lg:top-28 space-y-0">

                        <!-- ── Project Overview ── -->
                        <div class="scroll-reveal pb-10 border-b border-gray-100">
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-300">02</span>
                                <span class="w-6 h-px bg-gray-200"></span>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Overview</span>
                            </div>
                            <div class="text-gray-500 text-[15px] font-light leading-[1.8] whitespace-pre-line">
                                {{ $project->description }}
                            </div>
                        </div>

                        <!-- ── Specifications ── -->
                        <div class="scroll-reveal py-10 border-b border-gray-100" data-delay="0.1">
                            <div class="flex items-center gap-4 mb-8">
                                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-300">03</span>
                                <span class="w-6 h-px bg-gray-200"></span>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Specifications</span>
                            </div>
                            <dl class="space-y-0 divide-y divide-gray-50">
                                <div class="flex items-center justify-between py-4 first:pt-0">
                                    <dt class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400">Client</dt>
                                    <dd class="text-sm font-semibold text-gray-800 text-right">{{ $project->client ?: 'Confidential' }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-4">
                                    <dt class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400">Location</dt>
                                    <dd class="text-sm font-semibold text-gray-800 text-right">{{ $project->location }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-4">
                                    <dt class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400">Completed</dt>
                                    <dd class="text-sm font-semibold text-gray-800 text-right">{{ $project->year }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-4">
                                    <dt class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400">Contract Value</dt>
                                    <dd class="text-sm font-bold text-[#c9a84c] text-right">{{ $project->contract_value ?: 'Proprietary' }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-4">
                                    <dt class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400">Delivery</dt>
                                    <dd class="text-sm font-semibold text-gray-800 text-right">Design & Build</dd>
                                </div>
                                <div class="flex items-center justify-between py-4 last:pb-0">
                                    <dt class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400">CIDB Grade</dt>
                                    <dd class="text-sm font-semibold text-gray-800 text-right">G7</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- ── Credentials Badge ── -->
                        <div class="scroll-reveal py-10 border-b border-gray-100" data-delay="0.15">
                            <div class="flex items-center gap-4 p-5 rounded-xl bg-gray-50/80 border border-gray-100">
                                <div class="w-12 h-12 rounded-lg bg-[#c9a84c]/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#c9a84c]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-700 mb-0.5">CIDB Grade G7 Registered</p>
                                    <p class="text-[11px] text-gray-400 leading-snug">Highest contractor registration grade in Malaysia, eligible for unlimited tender value.</p>
                                </div>
                            </div>
                        </div>

                        <!-- ── Awards ── -->
                        @if($awardCount > 0)
                        <div class="scroll-reveal py-10 border-b border-gray-100" data-delay="0.2">
                            <div class="flex items-center gap-4 mb-8">
                                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-300">04</span>
                                <span class="w-6 h-px bg-gray-200"></span>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Recognition</span>
                                <span class="ml-auto text-[9px] font-mono text-gray-300 tracking-wider">{{ $awardCount }} {{ $awardCount === 1 ? 'award' : 'awards' }}</span>
                            </div>
                            <div class="space-y-0 divide-y divide-gray-50">
                                @foreach($awardData as $ad)
                                    <div class="flex items-center gap-4 py-4 first:pt-0 last:pb-0 group">
                                        @if(!empty($ad['img']))
                                            <div class="w-11 h-11 flex-shrink-0 bg-white border border-gray-100 shadow-sm rounded-lg flex items-center justify-center p-1.5 group-hover:border-[#c9a84c]/30 transition-colors duration-300">
                                                <img src="{{ $ad['img'] }}" alt="{{ $ad['name'] }}" loading="lazy" decoding="async" class="max-w-full max-h-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500">
                                            </div>
                                        @else
                                            <div class="w-11 h-11 flex-shrink-0 bg-[#c9a84c]/[0.06] border border-[#c9a84c]/10 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#c9a84c]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-800 leading-snug mb-0.5 group-hover:text-gray-900 transition-colors">{{ $ad['name'] }}</p>
                                            <span class="text-[10px] font-bold tracking-wider uppercase text-gray-400">
                                                {{ $ad['issuer'] }}@if($ad['year']) &middot; {{ $ad['year'] }}@endif
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- ── CTA ── -->
                        <div class="scroll-reveal pt-10" data-delay="0.3">
                            <a href="/contact"
                               class="group flex items-center justify-center gap-3 w-full py-4 bg-gray-900 text-white text-[10px] font-black uppercase tracking-[0.25em] rounded-xl hover:bg-[#c9a84c] transition-colors duration-400">
                                Discuss a Similar Project
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            <p class="text-center text-[10px] text-gray-300 mt-4 tracking-wide">
                                Free consultation &middot; Response within 24 hours
                            </p>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </main>


    <!-- ═══════════════════════════════════════════════════════
         BOTTOM — Next Step
         ═══════════════════════════════════════════════════════ -->
    <section class="bg-gray-50 border-t border-gray-100">
        <div class="max-w-[100rem] mx-auto px-4 md:px-8 lg:px-12 py-20 md:py-28">
            <div class="scroll-reveal flex flex-col md:flex-row items-start md:items-end justify-between gap-8">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#c9a84c] mb-4 block">Continue Exploring</span>
                    <h3 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tighter leading-[0.95]">
                        View Our Full<br>Track Record
                    </h3>
                </div>
                <a href="/projects"
                   class="group inline-flex items-center gap-4 px-10 py-4 border-2 border-gray-900 text-gray-900 text-[10px] font-black uppercase tracking-[0.25em] rounded-full hover:bg-gray-900 hover:text-white transition-all duration-400 flex-shrink-0">
                    <span>All Projects</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════
         STYLES
         ═══════════════════════════════════════════════════════ -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #ffffff;
            color: #111827;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::selection { background: rgba(201, 168, 76, 0.2); color: #111827; }

        /* ── Header Entry ── */
        header {
            opacity: 0;
            transform: translateY(-10px);
            animation: headerIn 0.8s 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes headerIn { to { opacity: 1; transform: translateY(0); } }

        /* ── Hero Reveals ── */
        .hero-reveal {
            opacity: 0;
            transform: translateY(24px);
            animation: heroIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes heroIn { to { opacity: 1; transform: translateY(0); } }
        .hero-reveal[data-delay="0"]    { animation-delay: 0.2s; }
        .hero-reveal[data-delay="0.15"] { animation-delay: 0.4s; }

        /* ── Scroll Reveals ── */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .scroll-reveal[data-delay="0.08"] { transition-delay: 0.08s; }
        .scroll-reveal[data-delay="0.1"]  { transition-delay: 0.1s; }
        .scroll-reveal[data-delay="0.15"] { transition-delay: 0.15s; }
        .scroll-reveal[data-delay="0.2"]  { transition-delay: 0.2s; }
        .scroll-reveal[data-delay="0.3"]  { transition-delay: 0.3s; }
        .scroll-reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── Gallery ── */
        .gallery-item { cursor: pointer; }
        .gallery-item img {
            transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .gallery-item:hover img { transform: scale(1.035); }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f9fafb; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .gallery-item img { transition: none; }
            .gallery-item:hover img { transform: none; }
        }
        @media (prefers-reduced-motion: reduce) {
            .scroll-reveal, .hero-reveal, .gallery-item img, header {
                transition: none !important;
                animation: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>


    <!-- ═══════════════════════════════════════════════════════
         SCRIPTS
         ═══════════════════════════════════════════════════════ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Instant reveal for reduced motion
            if (prefersReduced) {
                document.querySelectorAll('.scroll-reveal').forEach(function(el) {
                    el.classList.add('visible');
                });
                return;
            }

            // Scroll reveal observer
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.06, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.scroll-reveal').forEach(function(el) {
                observer.observe(el);
            });

            // Hero parallax
            var heroBg = document.getElementById('hero-bg');
            if (heroBg && window.matchMedia('(min-width: 768px)').matches) {
                var ticking = false;
                window.addEventListener('scroll', function() {
                    if (!ticking) {
                        requestAnimationFrame(function() {
                            var y = window.scrollY;
                            var h = window.innerHeight;
                            if (y < h) {
                                var p = y / h;
                                heroBg.style.transform = 'scale(1.08) translateY(' + (p * 30) + 'px)';
                            }
                            ticking = false;
                        });
                        ticking = true;
                    }
                }, { passive: true });
            }

            // GSAP gallery scroll-scrub
            function initGSAP() {
                if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
                    setTimeout(initGSAP, 100);
                    return;
                }
                gsap.registerPlugin(ScrollTrigger);
                if (window.matchMedia('(min-width: 1024px)').matches) {
                    document.querySelectorAll('.gallery-item img').forEach(function(img) {
                        gsap.fromTo(img,
                            { scale: 1.06 },
                            {
                                scale: 1,
                                ease: 'none',
                                scrollTrigger: {
                                    trigger: img.parentElement,
                                    start: 'top 90%',
                                    end: 'bottom 10%',
                                    scrub: 1.5,
                                }
                            }
                        );
                    });
                }
            }
            initGSAP();
        });
    </script>

</x-layout>