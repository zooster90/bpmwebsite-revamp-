{{-- Intern card — shared by every section in the year cohort view
     (Site Interns, Office Interns, Cohort Highlights). Expects:
       $intern : App\Models\CultureEvent
       $year   : string|int  (used for the year badge on the photo) --}}
<article class="intern-card intern-item reveal"
         data-title="{{ strtolower($intern->intern_name ?: $intern->title) }}"
         data-uni="{{ strtolower($intern->university ?? '') }}">
    @php $img = $intern->displayImage ?? null; @endphp
    <div class="h-64 bg-navy relative overflow-hidden">
        @if($img)
            <a href="{{ $img }}" class="glightbox" data-gallery="event-{{ $intern->id }}" data-title="{{ $intern->intern_name ?? $intern->title }}">
                <div class="gallery-overlay">
                    <i class="fa-solid fa-images text-4xl text-white mb-2"></i>
                    <span class="text-white font-bold tracking-widest text-xs uppercase mt-2">View Photo</span>
                </div>
                <img src="{{ $img }}"
                     alt="{{ $intern->intern_name ?? $intern->title }}"
                     class="w-full h-full object-cover object-top transition duration-700 hover:scale-110"
                     loading="lazy" decoding="async" width="600" height="400">
            </a>
            <div class="hidden" style="display:none;">
                @foreach($intern->getMedia('gallery') as $media)
                    <a href="{{ $media->getUrl() }}" class="glightbox" data-gallery="event-{{ $intern->id }}" data-title="{{ $intern->intern_name ?? $intern->title }}"></a>
                @endforeach
                @if(is_array($intern->gallery_uploads))
                    @foreach($intern->gallery_uploads as $path)
                        <a href="{{ cdn_rewrite(asset('storage/' . ltrim($path, '/'))) }}" class="glightbox" data-gallery="event-{{ $intern->id }}" data-title="{{ $intern->intern_name ?? $intern->title }}"></a>
                    @endforeach
                @endif
            </div>
        @else
            <div class="w-full h-full flex items-center justify-content-center">
                <i class="fa-solid fa-user-graduate text-gold/30 text-6xl mx-auto mt-20"></i>
            </div>
        @endif
        <span class="absolute top-4 right-4 bg-gold text-white text-[0.65rem] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-md">{{ $year }}</span>
    </div>

    <div class="p-6 border-t-4 border-gold flex flex-col justify-between flex-1 bg-white">
        <div>
            <h3 class="font-heading text-lg font-bold text-navy uppercase mb-4 leading-tight">{{ $intern->intern_name ?: $intern->title }}</h3>
            @if($intern->university)
                <div class="flex items-start gap-3 text-sm text-slate-700 font-semibold mb-3">
                    <i class="{{ $intern->institution_icon }} text-gold mt-1"></i>
                    <span class="leading-snug">{{ $intern->university }}</span>
                </div>
            @endif
            @if($intern->department)
                <div class="flex items-center gap-3 text-xs text-slate-500 mb-4">
                    <i class="fa-solid fa-people-group text-gold"></i>
                    <span class="uppercase tracking-wide font-semibold">{{ $intern->department }}</span>
                </div>
            @endif
        </div>

        <div class="mt-4 pt-4 border-t border-border">
            @if($intern->intern_period)
                <div class="flex items-center gap-3 text-xs text-slate-500 font-semibold mb-2">
                    <i class="fa-regular fa-calendar text-gold"></i>
                    <span>{{ $intern->intern_period }}</span>
                </div>
            @endif
            @if($intern->description)
                <p class="text-xs text-slate-500 mt-3 line-clamp-3 leading-relaxed">{{ $intern->description }}</p>
            @endif
        </div>
    </div>
</article>
