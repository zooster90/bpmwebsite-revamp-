<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

    {{-- ══════════════════════════════════════════
         STATIC CORE PAGES
         ══════════════════════════════════════════ --}}

    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ url('/about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/our-people') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/corporate') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ url('/sustainability') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/services') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/projects') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ url('/news') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ url('/awards') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/culture') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/media') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/careers') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/contact') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    {{-- ══════════════════════════════════════════
         PROJECT PAGES — Full Image SEO
         Uses display_image accessor for 100%
         coverage (Spatie → upload → image_url)
         ══════════════════════════════════════════ --}}

    @foreach ($projects as $project)
    @php
        $pageTitle  = e($project->name ?? $project->title ?? '');
        $category   = e($project->category?->name ?? 'Construction');
        $location   = e($project->location ?? 'Malaysia');
        $year       = $project->year ?? '';
        $desc       = $project->description
                        ? e(\Illuminate\Support\Str::limit($project->description, 200))
                        : "A Builtech {$category} project in {$location}" . ($year ? ", completed {$year}." : '.');

        // Canonical keyword-rich title for Google Image index
        $imgTitle   = "{$pageTitle} — {$category} in {$location} | Builtech Engineering Malaysia";

        // Cover image — use display_image accessor which handles ALL fallback chains
        $coverUrl   = $project->display_image;

        // Skip unsplash fallback images from the sitemap (they're not our content)
        $isUnsplash = str_contains($coverUrl, 'unsplash.com');

        // Ensure cover is absolute URL
        if (!filter_var($coverUrl, FILTER_VALIDATE_URL)) {
            $coverUrl = null;
        }

        // Gallery images from Spatie MediaLibrary
        $galleryImages = $project->hasMedia('gallery')
            ? $project->getMedia('gallery')->take(8)->pluck(null)->all()
            : [];
    @endphp
        <url>
            <loc>{{ url('/projects/' . $project->slug) }}</loc>
            <lastmod>{{ $project->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>

            {{-- Cover image --}}
            @if($coverUrl && !$isUnsplash)
            <image:image>
                <image:loc>{{ $coverUrl }}</image:loc>
                <image:title>{{ $imgTitle }}</image:title>
                <image:caption>{{ $desc }}</image:caption>
                <image:license>{{ url('/privacy-policy') }}</image:license>
            </image:image>
            @endif

            {{-- Gallery images --}}
            @foreach($galleryImages as $galleryImg)
            <image:image>
                <image:loc>{{ $galleryImg->getUrl() }}</image:loc>
                <image:title>{{ $pageTitle }} — {{ $category }}, {{ $location }} — Builtech Engineering Malaysia</image:title>
                <image:caption>{{ $desc }}</image:caption>
                <image:license>{{ url('/privacy-policy') }}</image:license>
            </image:image>
            @endforeach

        </url>
    @endforeach

    {{-- ══════════════════════════════════════════
         NEWS / JOURNAL PAGES — Google News SEO
         ══════════════════════════════════════════ --}}

    @foreach ($news as $article)
    @php
        $newsTitle  = e($article->title ?? '');
        $newsDesc   = $article->excerpt
                        ? e(\Illuminate\Support\Str::limit($article->excerpt, 200))
                        : ($article->content ? e(\Illuminate\Support\Str::limit(strip_tags($article->content), 200)) : 'Builtech News Update');

        // Use display_image accessor for full fallback chain
        $newsImg    = $article->display_image;
        $isUnsplashNews = str_contains($newsImg, 'unsplash.com');

        if (!filter_var($newsImg, FILTER_VALIDATE_URL)) {
            $newsImg = null;
        }
    @endphp
        <url>
            <loc>{{ url('/news/' . $article->slug) }}</loc>
            <lastmod>{{ $article->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>

            @if($newsImg && !$isUnsplashNews)
            <image:image>
                <image:loc>{{ $newsImg }}</image:loc>
                <image:title>{{ $newsTitle }} — Builtech Project Management Sdn. Bhd.</image:title>
                <image:caption>{{ $newsDesc }}</image:caption>
                <image:license>{{ url('/privacy-policy') }}</image:license>
            </image:image>
            @endif

            {{-- Gallery images for news --}}
            @if($article->hasMedia('gallery'))
                @foreach($article->getMedia('gallery')->take(4) as $newsGallery)
                <image:image>
                    <image:loc>{{ $newsGallery->getUrl() }}</image:loc>
                    <image:title>{{ $newsTitle }} — Builtech News Gallery</image:title>
                    <image:license>{{ url('/privacy-policy') }}</image:license>
                </image:image>
                @endforeach
            @endif

        </url>
    @endforeach

</urlset>
