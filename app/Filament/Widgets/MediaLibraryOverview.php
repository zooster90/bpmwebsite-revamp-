<?php

namespace App\Filament\Widgets;

use App\Models\Award;
use App\Models\CultureEvent;
use App\Models\CurrentProject;
use App\Models\News;
use App\Models\OurPeople;
use App\Models\PressCoverage;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * ============================================================
 *  Media Library Overview — across-the-system photo accounting
 * ============================================================
 *  Tells the admin at a glance how much visual content lives in
 *  the system, where it lives, and how much storage it's using.
 *  Pulls straight from the Spatie `media` table (one query each)
 *  so it stays cheap even with a large library.
 * ============================================================
 */
class MediaLibraryOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $modelMap = [
            'Project'        => Project::class,
            'CurrentProject' => CurrentProject::class,
            'CultureEvent'   => CultureEvent::class,
            'News'           => News::class,
            'Award'          => Award::class,
            'PressCoverage'  => PressCoverage::class,
            'OurPeople'      => OurPeople::class,
        ];

        $modelTypes = array_map(fn ($class) => 'App\\Models\\' . class_basename($class), $modelMap);

        // ── Total media + storage ────────────────────────────
        $totalMedia = Media::whereIn('model_type', $modelTypes)->count();
        $totalBytes = (int) Media::whereIn('model_type', $modelTypes)->sum('size');
        $totalMB    = round($totalBytes / 1024 / 1024, 1);

        // ── Top-3 collections by file count ──────────────────
        $byCollection = Media::whereIn('model_type', $modelTypes)
            ->selectRaw('collection_name, COUNT(*) as cnt')
            ->groupBy('collection_name')
            ->orderByDesc('cnt')
            ->limit(3)
            ->get();

        $topCollections = $byCollection->isEmpty()
            ? 'No photos uploaded yet'
            : $byCollection->map(fn ($r) => $r->collection_name . ' (' . $r->cnt . ')')->implode(' · ');

        // ── Uploads this month (trend) ───────────────────────
        $thisMonth = Media::whereIn('model_type', $modelTypes)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $uploadTrend = collect(range(6, 0))->map(fn ($m) => Media::whereIn('model_type', $modelTypes)
            ->whereBetween('created_at', [
                now()->subMonths($m)->startOfMonth(),
                now()->subMonths($m)->endOfMonth(),
            ])
            ->count())
            ->values()
            ->toArray();

        // ── Photos still on local (post-fix audit) ───────────
        $strandedLocal = Media::whereIn('model_type', $modelTypes)
            ->where('disk', 'local')
            ->count();

        // ── Coverage: events with NO photos at all ───────────
        $eventsWithoutPhotos = CultureEvent::whereDoesntHave('media', fn ($q) => $q->whereIn('collection_name', ['culture_image', 'gallery']))->count();

        return [
            // 1. Total photos + storage
            Stat::make('Total Photos in Library', number_format($totalMedia))
                ->description($totalMB . ' MB on Cloudflare R2')
                ->descriptionIcon('heroicon-m-cloud')
                ->color('primary')
                ->chart($uploadTrend),

            // 2. Top collections breakdown
            Stat::make('Top Collections', (string) $byCollection->count())
                ->description($topCollections)
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),

            // 3. This month's uploads
            Stat::make('Uploaded This Month', number_format($thisMonth))
                ->description($thisMonth > 0 ? 'Active month — keep it up' : 'No uploads yet this month')
                ->descriptionIcon($thisMonth > 0 ? 'heroicon-m-arrow-up-right' : 'heroicon-m-minus')
                ->color($thisMonth > 0 ? 'success' : 'gray')
                ->chart($uploadTrend),

            // 4. Health flag — broken media + missing photos
            Stat::make(
                'Needs Attention',
                ($strandedLocal + $eventsWithoutPhotos) === 0 ? 'All clear' : ($strandedLocal + $eventsWithoutPhotos)
            )
                ->description(
                    ($strandedLocal + $eventsWithoutPhotos) === 0
                        ? 'No orphan files · all events have photos'
                        : trim(
                            ($strandedLocal > 0 ? "{$strandedLocal} stranded on local " : '') .
                            ($eventsWithoutPhotos > 0 ? "· {$eventsWithoutPhotos} events without photos" : '')
                        )
                )
                ->descriptionIcon(($strandedLocal + $eventsWithoutPhotos) === 0 ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-triangle')
                ->color(($strandedLocal + $eventsWithoutPhotos) === 0 ? 'success' : 'warning'),
        ];
    }
}
