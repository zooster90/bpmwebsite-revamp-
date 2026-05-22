<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

/**
 * ============================================================
 *  BUILTECH WEBSITE ANALYTICS WIDGET
 *  Shows real visitor data from page_views table.
 * ============================================================
 */
class WebsiteAnalytics extends Widget
{
    protected string $view = 'filament.widgets.website-analytics';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = '60s';

    public function getViewData(): array
    {
        // Guard: if migration hasn't run yet, return empty data gracefully
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('page_views')) {
                return $this->emptyData();
            }
        } catch (\Throwable) {
            return $this->emptyData();
        }

        try {
            $today    = now()->startOfDay();
            $week     = now()->subDays(7)->startOfDay();
            $month    = now()->subDays(30)->startOfDay();

            $todayVisitors  = PageView::where('created_at', '>=', $today)
                ->distinct('session_id')->count('session_id');
            $weekVisitors   = PageView::where('created_at', '>=', $week)
                ->distinct('session_id')->count('session_id');
            $monthVisitors  = PageView::where('created_at', '>=', $month)
                ->distinct('session_id')->count('session_id');
            $totalPageviews = PageView::where('created_at', '>=', $month)->count();

            $avgTime = (int) PageView::where('created_at', '>=', $month)
                ->whereNotNull('time_on_page')
                ->where('time_on_page', '>', 0)
                ->avg('time_on_page');

            $topPages = PageView::where('created_at', '>=', $month)
                ->select('route_name', 'url', DB::raw('COUNT(*) as views'))
                ->groupBy('route_name', 'url')
                ->orderByDesc('views')
                ->limit(8)
                ->get()
                ->map(fn($r) => [
                    'label'  => $r->route_name
                        ? str_replace(['.index', '.show', '-'], ['', ' (detail)', ' '], $r->route_name)
                        : parse_url($r->url, PHP_URL_PATH),
                    'views'  => $r->views,
                    'url'    => $r->url,
                ]);

            $browsers = PageView::where('created_at', '>=', $month)
                ->select('browser', DB::raw('COUNT(*) as count'))
                ->groupBy('browser')->orderByDesc('count')->limit(6)->get();

            $devices = PageView::where('created_at', '>=', $month)
                ->select('device_type', DB::raw('COUNT(*) as count'))
                ->groupBy('device_type')->orderByDesc('count')->get();

            $osList = PageView::where('created_at', '>=', $month)
                ->select('os', DB::raw('COUNT(*) as count'))
                ->groupBy('os')->orderByDesc('count')->limit(5)->get();

            $dailyVisitors = collect(range(13, 0))->map(function ($d) {
                $date = now()->subDays($d)->format('Y-m-d');
                return [
                    'date'  => now()->subDays($d)->format('d M'),
                    'count' => PageView::whereDate('created_at', $date)
                        ->distinct('session_id')->count('session_id'),
                ];
            });

            $peakHours = PageView::where('created_at', '>=', $week)
                ->select(
                    DB::raw("CAST(strftime('%H', created_at) AS INTEGER) as hour"),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('hour')->orderBy('hour')->get()->keyBy('hour');

            $hourlyData = collect(range(0, 23))->map(fn($h) => [
                'hour'  => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00',
                'count' => $peakHours->get($h)?->count ?? 0,
            ]);

            $referrers = PageView::where('created_at', '>=', $month)
                ->whereNotNull('referrer')->where('referrer', '!=', '')
                ->select('referrer', DB::raw('COUNT(*) as count'))
                ->groupBy('referrer')->orderByDesc('count')->limit(5)->get()
                ->map(fn($r) => [
                    'host'  => parse_url($r->referrer, PHP_URL_HOST) ?? $r->referrer,
                    'count' => $r->count,
                ]);

            return compact(
                'todayVisitors', 'weekVisitors', 'monthVisitors', 'totalPageviews',
                'avgTime', 'topPages', 'browsers', 'devices', 'osList',
                'dailyVisitors', 'hourlyData', 'referrers'
            );
        } catch (\Throwable $e) {
            logger()->warning('WebsiteAnalytics widget error: ' . $e->getMessage());
            return $this->emptyData();
        }
    }

    private function emptyData(): array
    {
        $empty = collect();
        return [
            'todayVisitors' => 0, 'weekVisitors' => 0, 'monthVisitors' => 0,
            'totalPageviews' => 0, 'avgTime' => 0,
            'topPages' => $empty, 'browsers' => $empty, 'devices' => $empty,
            'osList' => $empty, 'referrers' => $empty,
            'dailyVisitors' => collect(range(13, 0))->map(fn($d) => ['date' => now()->subDays($d)->format('d M'), 'count' => 0]),
            'hourlyData'    => collect(range(0, 23))->map(fn($h) => ['hour' => str_pad($h, 2, '0', STR_PAD_LEFT).':00', 'count' => 0]),
        ];
    }
}
