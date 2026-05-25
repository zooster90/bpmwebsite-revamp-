<?php

namespace App\Http\Controllers;

use App\Models\CultureEvent;
use Illuminate\Http\Request;

/**
 * ╔══════════════════════════════════════════════════════════════════════╗
 * ║   CultureController — 2026 Elite Curated Hub Edition                 ║
 * ║   ─────────────────────────────────────────────────────────────────  ║
 * ║   Main page  → Curated Sectioned Hub (No messy dumping of records)   ║
 * ║   Sub-pages  → Full category grid + Dynamic Subcategory filtering    ║
 * ╚══════════════════════════════════════════════════════════════════════╝
 */
class CultureController extends Controller
{
    /**
     * Category display config — matches form options in CultureEventForm.
     */
    protected function categoryConfig(): array
    {
        return [
            'tb'      => ['label' => 'Team Building',     'icon' => '🧗', 'color' => '#10b981', 'fallback' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=800&q=80'],
            'work'    => ['label' => 'Training',          'icon' => '🏗️', 'color' => '#6366f1', 'fallback' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80'],
            'trip'    => ['label' => 'Trips',             'icon' => '✈️', 'color' => '#0ea5e9', 'fallback' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80'],
            'csr'     => ['label' => 'CSR',               'icon' => '🤝', 'color' => '#f97316', 'fallback' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&q=80'],
            'festive' => ['label' => 'Festive',           'icon' => '🎊', 'color' => '#f59e0b', 'fallback' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80'],
            'event'   => ['label' => 'Events',            'icon' => '📸', 'color' => '#fbbf24', 'fallback' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&q=80'],
            'intern'  => ['label' => 'Internship',        'icon' => '🎓', 'color' => '#8b5cf6', 'fallback' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800&q=80'],
        ];
    }

    /**
     * Get the best available image URL for an event.
     */
    protected function getEventImage(CultureEvent $event, string $category): string
    {
        if ($event->hasMedia('culture_image')) {
            return $event->getFirstMediaUrl('culture_image');
        }
        if (! empty($event->culture_image_upload)) {
            return cdn_rewrite(asset('storage/' . ltrim($event->culture_image_upload, '/')));
        }
        if (! empty($event->image_url)) {
            return str_starts_with($event->image_url, 'http')
                ? $event->image_url
                : cdn_rewrite(asset(ltrim($event->image_url, '/')));
        }
        
        $config = $this->categoryConfig();
        $catKey = strtolower(trim($category));
        return $config[$catKey]['fallback']
            ?? 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80';
    }

    public function index(Request $request)
    {
        $activeCategory = $request->query('category', '');
        $config         = $this->categoryConfig();

        // Mapping for legacy data compatibility
        $categoryMap = [
            'festive' => ['festive', 'celebration'],
            'work'    => ['work', 'training', 'site'],
            'tb'      => ['tb', 'team_building', 'teambuilding'],
            'trip'    => ['trip', 'travel', 'company_trip'],
            'csr'     => ['csr', 'charity'],
            'event'   => ['event', 'sponsor', 'sponsorship'],
            'intern'  => ['intern', 'internship'],
        ];

        // Fetch all events (Sort strictly by newest year first, then newest event date)
        $allEvents = CultureEvent::with(['category', 'subCategory'])->orderBy('year', 'desc')->orderBy('event_date', 'desc')->get();
        $allEvents->each(function ($e) use ($categoryMap) {
            // Normalize category key
            $rawCat = strtolower(trim($e->category?->slug ?? ''));
            $matchedKey = 'event';
            foreach ($categoryMap as $key => $synonyms) {
                if (in_array($rawCat, $synonyms)) {
                    $matchedKey = $key;
                    break;
                }
            }
            $e->normalized_category = $matchedKey;
            $e->displayImage = $this->getEventImage($e, $matchedKey);
        });

        // ── SPECIAL: Internship — group by year ──────────────────────────
        $allInterns = $allEvents->filter(fn($e) => $e->normalized_category === 'intern');
        $internsByYear = $allInterns->groupBy(
            fn ($e) => $e->year ?? ($e->event_date ? $e->event_date->format('Y') : 'Unknown')
        )->sortKeysDesc();

        // ── Build Subcategory Map (Category -> Unique Subcategories) ─────────
        $subCategoriesByCategory = collect($categoryConfig ?? $config)->mapWithKeys(function ($catData, $catKey) use ($allEvents) {
            $subs = $allEvents->filter(fn($e) => $e->normalized_category === $catKey)
                              ->map(fn($e) => $e->subCategory ? str_replace('-', '_', strtolower(trim($e->subCategory->slug))) : null)
                              ->filter(fn($s) => !empty($s) && $s !== 'all')
                              ->unique()
                              ->values();
            return [$catKey => $subs];
        });

        // ── Build Latest Per Category Map (For Curated Hub View) ─────────────
        $latestPerCategory = collect($categoryConfig ?? $config)->mapWithKeys(function ($catData, $catKey) use ($allEvents) {
            return [$catKey => $allEvents->filter(fn($e) => $e->normalized_category === $catKey)->take(3)->values()];
        });

        $years = $allEvents->filter(fn($e) => $e->year)->pluck('year')->unique()->sortDesc()->values();

        return view('culture', [
            'allEvents'               => $allEvents,
            'events'                  => $allEvents,
            'category'                => $activeCategory,
            'categoryConfig'          => $config,
            'subCategoriesByCategory' => $subCategoriesByCategory,
            'latestPerCategory'       => $latestPerCategory,
            'internsByYear'           => $internsByYear,
            'years'                   => $years,
        ]);
    }
}
