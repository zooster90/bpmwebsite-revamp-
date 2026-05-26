<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    /**
     * Category display configuration.
     * Core = shown in the 4-column highlight grid.
     * Non-core = shown in the Industry Honors grid.
     */
    protected function categoryConfig(): array
    {
        return [
            'cidb'     => ['label' => 'CIDB Star Rating',    'isCore' => true],
            'shassic'  => ['label' => 'SHASSIC / Safety',    'isCore' => true],
            'gbi'      => ['label' => 'GBI Green Building',  'isCore' => true],
            'qlassic'  => ['label' => 'QLASSIC / CONQUAS',   'isCore' => true],
            'iso'      => ['label' => 'ISO Certification',   'isCore' => false],
            'quality'  => ['label' => 'Quality & Standards', 'isCore' => false],
            'safety'   => ['label' => 'Safety Rating',       'isCore' => false],
            'business' => ['label' => 'Corporate Excellence','isCore' => false],
        ];
    }

    /**
     * Logo fallback map — used when an award has no logo_upload.
     */
    protected function logoMap(): array
    {
        return [
            'cidb'     => 'images/cidb_logo-768x250.png',
            'shassic'  => 'images/shassic_logo-removebg-preview.png',
            'gbi'      => 'images/GBI logo ..png',
            'qlassic'  => 'images/R (1).png',
            'iso'      => 'images/ISO_14001_Latest.jpg',
            'quality'  => 'images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg',
            'safety'   => 'images/MSOSH Logo.jpg',
            'business' => 'images/SME .png',
        ];
    }

    /**
     * Normalize a single Award model into the shape the JS expects.
     */
    protected function normalizeAward(Award $award, string $fallbackTitle): array
    {
        $img = null;
        // Priority 1: Spatie Media Library (Collection: logo)
        if ($award->hasMedia('logo')) {
            $img = $award->getFirstMediaUrl('logo');
        }
        // Priority 2: Legacy Direct Upload Column
        elseif (!empty($award->logo_upload)) {
            $img = cdn_rewrite(asset('storage/' . ltrim($award->logo_upload, '/')));
        }
        // Priority 3: Legacy URL column (Supabase or Local assets)
        elseif (!empty($award->image_url)) {
            $img = str_starts_with($award->image_url, 'http')
                ? $award->image_url
                : cdn_rewrite(asset(ltrim($award->image_url, '/')));
        }
        // Priority 4: Old document/certificate columns (if any)
        elseif (!empty($award->document_url)) {
            $img = cdn_rewrite(asset(ltrim($award->document_url, '/')));
        } elseif (!empty($award->certificate_url)) {
            $img = cdn_rewrite(asset(ltrim($award->certificate_url, '/')));
        }

        // Gallery Logic
        $gallery = [];
        if ($award->hasMedia('gallery')) {
            foreach($award->getMedia('gallery') as $media) {
                $gallery[] = $media->getUrl();
            }
        }
        $legacyGallery = is_array($award->gallery_uploads) ? array_filter($award->gallery_uploads) : [];
        foreach($legacyGallery as $path) {
            $gallery[] = str_starts_with($path, 'http') ? $path : cdn_rewrite(asset('storage/' . ltrim($path, '/')));
        }
        $gallery = array_values(array_unique(array_filter($gallery)));

        return [
            'year'      => (int) ($award->year ?? date('Y')),
            'title'     => trim($award->name ?? $award->project_name ?? $fallbackTitle),
            'grade'     => $award->grade ?? '',
            'certLevel' => $award->certification_level ?? '',
            'starRating'=> $award->star_rating ?? '',
            'score'     => $award->score ?? '',
            'remarks'   => $award->description ?? $award->remarks ?? $award->issuer ?? '',
            'img'       => $img,
            'gallery'   => $gallery,
        ];
    }

    /**
     * Resolve the best logo for a category group.
     */
    protected function resolveCategoryLogo(string $catKey, $awards): ?string
    {
        $map = $this->logoMap();
        if (isset($map[$catKey])) {
            return asset($map[$catKey]);
        }
        
        // Try to find ANY award in this group that has a Spatie logo
        $firstSpatie = $awards->first(fn($a) => $a->hasMedia('logo'));
        if ($firstSpatie) {
            return $firstSpatie->getFirstMediaUrl('logo');
        }

        $first = $awards->firstWhere('logo_upload', '!=', null);
        if ($first) {
            return cdn_rewrite(asset('storage/' . ltrim($first->logo_upload, '/')));
        }
        return null;
    }

    public function index()
    {
        $config = $this->categoryConfig();
        $logoMap = $this->logoMap();

        // 1. All awards, newest first.
        // Eager-load media + category so normalizeAward() / resolveCategoryLogo()
        // don't fire one query per award when they call hasMedia() / getMedia().
        $awards = Award::with(['media', 'category'])
            ->orderBy('year', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        // 2. Group by normalized category key
        $grouped = $awards->groupBy(function ($award) {
            return strtolower(trim($award->category?->slug ?? 'other'));
        });

        // 3. Build the $allCategories structure the JS template expects
        $allCategories = [];

        foreach ($grouped as $catKey => $items) {
            $cfg = $config[$catKey] ?? null;
            $isCore = $cfg['isCore'] ?? false;
            $label = $cfg['label'] ?? ucfirst($catKey);
            $logo = $this->resolveCategoryLogo($catKey, $items);

            // Core categories keep their simple key (cidb, shassic, etc.)
            // Non-core get a "gen-" prefix to avoid key collisions
            $id = $isCore ? $catKey : 'gen-' . Str::slug($catKey);

            $allCategories[$id] = [
                'title'  => $label,
                'img'    => $logo,
                'isCore' => $isCore,
                'data'   => $items->map(fn($a) => $this->normalizeAward($a, $label))->values()->all(),
            ];
        }

        // 4. Sort: core categories first (in config order), then non-core alphabetically
        $coreKeys = collect(array_keys($config))->filter(fn($k) => isset($allCategories[$k]));
        $genKeys = collect(array_keys($allCategories))
            ->filter(fn($k) => str_starts_with($k, 'gen-'))
            ->sortKeys();

        $sorted = [];
        foreach ($coreKeys as $k) $sorted[$k] = $allCategories[$k];
        foreach ($genKeys as $k) $sorted[$k] = $allCategories[$k];

        // 5. Total record count
        $totalRecords = collect($sorted)->sum(fn($g) => count($g['data']));

        return view('awards', [
            'allCategories' => $sorted,
            'totalRecords'  => $totalRecords,
        ]);
    }
}