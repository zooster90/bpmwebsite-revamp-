<?php

namespace App\Filament\Pages;

use App\Models\PageView;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * ============================================================
 *  BUILTECH ANALYTICS COMMAND CENTER
 *  Dedicated full-page analytics dashboard
 * ============================================================
 */
class Analytics extends Page
{
    protected static string | \BackedEnum | null $navigationIcon  = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel = 'Analytics';
    protected static ?string $title           = 'Website Analytics';
    protected static string|\UnitEnum|null $navigationGroup = 'Analytics & Reports';
    protected static ?int    $navigationSort  = 1;
    protected string  $view            = 'filament.pages.analytics';

    // ── Interactive Filters ────────────────────────────────
    public string $period     = '30'; // Options: 1, 7, 30, 90, 365
    public string $deviceType = 'all'; // Options: all, Desktop, Mobile, Tablet

    // ── Data resolved fresh on every page load ─────────────
    public array $stats        = [];
    public array $dailyData    = [];
    public array $hourlyData   = [];
    public array $topPages     = [];
    public array $browsers     = [];
    public array $devices      = [];
    public array $osList       = [];
    public array $referrers    = [];
    public array $countryData  = [];
    public array $recentVisits = [];
    public int   $activeNow    = 0;

    public function mount(): void
    {
        $this->loadData();
    }

    /**
     * Livewire rendering hook - ensures data matches filter state on every request
     */
    public function rendering(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        if (!Schema::hasTable('page_views')) {
            return;
        }

        try {
            $now   = now();
            $today = $now->copy()->startOfDay();
            
            // Define active start date based on selected period
            $startDate = match($this->period) {
                '1' => $now->copy()->startOfDay(),
                '7' => $now->copy()->subDays(7)->startOfDay(),
                '30' => $now->copy()->subDays(30)->startOfDay(),
                '90' => $now->copy()->subDays(90)->startOfDay(),
                '365' => $now->copy()->subDays(365)->startOfDay(),
                default => $now->copy()->subDays(30)->startOfDay(),
            };

            // Custom query helper applying active timeframe and device filters
            $queryHelper = function() use ($startDate) {
                $q = PageView::query();
                if ($startDate) {
                    $q->where('created_at', '>=', $startDate);
                }
                if ($this->deviceType !== 'all') {
                    $q->where('device_type', $this->deviceType);
                }
                return $q;
            };

            // Active now: sessions seen in last 5 minutes (filtered by device type)
            $this->activeNow = PageView::where('created_at', '>=', $now->copy()->subMinutes(5))
                ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                ->distinct('session_id')->count('session_id');

            // KPI stats
            $todayViews   = PageView::where('created_at', '>=', $today)
                ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                ->count();
            
            $filteredViews    = $queryHelper()->count();
            $filteredSessions = $queryHelper()->distinct('session_id')->count('session_id');

            $avgTime = (int) $queryHelper()
                ->whereNotNull('time_on_page')->where('time_on_page', '>', 0)
                ->avg('time_on_page');

            $bounceCount = $queryHelper()->where('is_bounce', true)->count();
            $bounceRate  = $filteredViews > 0 ? round(($bounceCount / $filteredViews) * 100) : 0;

            // Previous month for delta calculation
            $prevMonth      = $now->copy()->subDays(60)->startOfDay();
            $prevMonthEnd   = $now->copy()->subDays(31)->endOfDay();
            $prevViews      = PageView::whereBetween('created_at', [$prevMonth, $prevMonthEnd])
                ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                ->count();
            $viewsDelta     = $prevViews > 0 ? round((($filteredViews - $prevViews) / $prevViews) * 100) : 0;

            $this->stats = [
                'active_now'     => $this->activeNow,
                'today_views'    => $todayViews,
                'today_sessions' => PageView::where('created_at', '>=', $today)
                    ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                    ->distinct('session_id')->count('session_id'),
                'week_views'     => PageView::where('created_at', '>=', $now->copy()->subDays(7)->startOfDay())
                    ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                    ->count(),
                'week_sessions'  => PageView::where('created_at', '>=', $now->copy()->subDays(7)->startOfDay())
                    ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                    ->distinct('session_id')->count('session_id'),
                'month_views'    => $filteredViews,
                'month_sessions' => $filteredSessions,
                'avg_time'       => $avgTime,
                'bounce_rate'    => $bounceRate,
                'views_delta'    => $viewsDelta,
            ];

            // Daily visitor trend
            $daysToTrend = match($this->period) {
                '1' => 1,
                '7' => 7,
                '30' => 30,
                '90' => 90,
                '365' => 365,
                default => 30,
            };

            if ($daysToTrend === 1) {
                // Today trend: show hourly views counts for today
                $this->dailyData = collect(range(0, 23))->map(function ($h) {
                    $hourStart = now()->startOfDay()->addHours($h);
                    $hourEnd = $hourStart->copy()->endOfHour();
                    return [
                        'date' => $hourStart->format('H:00'),
                        'views' => PageView::whereBetween('created_at', [$hourStart, $hourEnd])
                            ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                            ->count(),
                        'visitors' => PageView::whereBetween('created_at', [$hourStart, $hourEnd])
                            ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                            ->distinct('session_id')->count('session_id'),
                    ];
                })->toArray();
            } else {
                $this->dailyData = collect(range($daysToTrend - 1, 0))->map(function ($d) {
                    $date = now()->subDays($d)->format('Y-m-d');
                    return [
                        'date'     => now()->subDays($d)->format('d M'),
                        'views'    => PageView::whereDate('created_at', $date)
                            ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                            ->count(),
                        'visitors' => PageView::whereDate('created_at', $date)
                            ->when($this->deviceType !== 'all', fn($q) => $q->where('device_type', $this->deviceType))
                            ->distinct('session_id')->count('session_id'),
                    ];
                })->toArray();
            }

            // Hourly heatmap — based on timeframe
            $peakHours = $queryHelper()
                ->select(
                    DB::raw("CAST(strftime('%H', created_at) AS INTEGER) as hour"),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('hour')->orderBy('hour')->get()->keyBy('hour');

            $this->hourlyData = collect(range(0, 23))->map(fn($h) => [
                'hour'  => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00',
                'count' => $peakHours->get($h)?->count ?? 0,
            ])->toArray();

            // Top pages
            $this->topPages = $queryHelper()
                ->select('route_name', 'url', DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT session_id) as unique_visitors'))
                ->groupBy('route_name', 'url')
                ->orderByDesc('views')
                ->limit(10)->get()
                ->map(fn($r) => [
                    'label'    => $r->route_name
                        ? str_replace(['.index', '.show', '-'], ['', ' (detail)', ' '], $r->route_name)
                        : (parse_url($r->url, PHP_URL_PATH) ?: '/'),
                    'url'      => $r->url,
                    'views'    => $r->views,
                    'visitors' => $r->unique_visitors,
                ])->toArray();

            // Browser breakdown
            $this->browsers = $queryHelper()
                ->select('browser', DB::raw('COUNT(*) as count'))
                ->groupBy('browser')->orderByDesc('count')->limit(6)->get()
                ->map(fn($r) => ['browser' => $r->browser ?? 'Unknown', 'count' => $r->count])
                ->toArray();

            // Device breakdown (always all devices for period-filtered breakdown)
            $this->devices = PageView::query()
                ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
                ->select('device_type', DB::raw('COUNT(*) as count'))
                ->groupBy('device_type')->orderByDesc('count')->get()
                ->map(fn($r) => ['device' => $r->device_type ?? 'Other', 'count' => $r->count])
                ->toArray();

            // OS breakdown
            $this->osList = $queryHelper()
                ->select('os', DB::raw('COUNT(*) as count'))
                ->groupBy('os')->orderByDesc('count')->limit(6)->get()
                ->map(fn($r) => ['os' => $r->os ?? 'Other', 'count' => $r->count])
                ->toArray();

            // Referrers
            $this->referrers = $queryHelper()
                ->whereNotNull('referrer')->where('referrer', '!=', '')
                ->select('referrer', DB::raw('COUNT(*) as count'))
                ->groupBy('referrer')->orderByDesc('count')->limit(8)->get()
                ->map(fn($r) => [
                    'host'  => parse_url($r->referrer, PHP_URL_HOST) ?? $r->referrer,
                    'count' => $r->count,
                ])->toArray();

            // Recent visits feed — last 20
            $this->recentVisits = $queryHelper()
                ->latest()->limit(20)->get()
                ->map(fn($r) => [
                    'url'        => parse_url($r->url, PHP_URL_PATH) ?: '/',
                    'device'     => $r->device_type ?? 'Unknown',
                    'browser'    => $r->browser ?? 'Unknown',
                    'os'         => $r->os ?? 'Unknown',
                    'time'       => $r->created_at->diffForHumans(),
                    'time_on'    => $r->time_on_page ?? 0,
                ])->toArray();

        } catch (\Throwable $e) {
            logger()->warning('Analytics page error: ' . $e->getMessage());
        }
    }
}
