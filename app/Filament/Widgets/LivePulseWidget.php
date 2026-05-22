<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\Widget;

class LivePulseWidget extends Widget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = '10s';

    protected string $view = 'filament.widgets.live-pulse';

    public function getViewData(): array
    {
        $recent = PageView::latest()->take(5)->get()->map(fn($pv) => [
            'url' => parse_url($pv->url, PHP_URL_PATH) ?: '/',
            'browser' => $pv->browser ?? 'Unknown',
            'device' => $pv->device_type ?? 'Desktop',
            'time' => $pv->created_at->diffForHumans(),
            'ip' => $pv->ip_address,
        ]);

        $activeNow = PageView::where('created_at', '>=', now()->subMinutes(5))
            ->distinct('session_id')->count('session_id');

        return [
            'recent' => $recent,
            'activeNow' => $activeNow,
        ];
    }
}
