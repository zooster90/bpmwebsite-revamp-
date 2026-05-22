<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardHero extends Widget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.dashboard-hero';
}
