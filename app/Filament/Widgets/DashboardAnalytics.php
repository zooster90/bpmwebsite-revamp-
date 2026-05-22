<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use App\Models\Project;
use App\Models\News;
use App\Models\JobOpening;
use Filament\Widgets\Widget;

/**
 * ============================================================
 *  BUILTECH ANALYTICS HUB — Chart.js Dashboard Widget
 *  Displays monthly trends for Inquiries, Projects, News
 * ============================================================
 */
class DashboardAnalytics extends Widget
{
    protected string $view = 'filament.widgets.dashboard-analytics';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $months = collect(range(5, 0))->map(fn($m) => now()->subMonths($m)->format('M Y'))->values()->toArray();

        $inquiryData = collect(range(5, 0))->map(fn($m) => Inquiry::whereBetween('created_at', [
            now()->subMonths($m)->startOfMonth(),
            now()->subMonths($m)->endOfMonth(),
        ])->count())->values()->toArray();

        $newsData = collect(range(5, 0))->map(fn($m) => News::where('is_published', true)
            ->whereBetween('created_at', [
                now()->subMonths($m)->startOfMonth(),
                now()->subMonths($m)->endOfMonth(),
            ])->count())->values()->toArray();

        // Inquiry status breakdown
        $statusBreakdown = [
            'new'         => Inquiry::where('status', 'new')->count(),
            'in_progress' => Inquiry::where('status', 'in-progress')->count(),
            'resolved'    => Inquiry::where('status', 'resolved')->count(),
        ];

        // Top inquiry subject patterns
        $recentInquiries = Inquiry::latest()->take(5)->get();

        return [
            'months'           => $months,
            'inquiryData'      => $inquiryData,
            'newsData'         => $newsData,
            'statusBreakdown'  => $statusBreakdown,
            'recentInquiries'  => $recentInquiries,
            'totalInquiries'   => Inquiry::count(),
            'resolvedRate'     => Inquiry::count() > 0
                ? round((Inquiry::where('status', 'resolved')->count() / Inquiry::count()) * 100)
                : 0,
        ];
    }
}
