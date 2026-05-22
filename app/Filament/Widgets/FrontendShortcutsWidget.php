<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class FrontendShortcutsWidget extends Widget
{
    protected string $view = 'filament.widgets.frontend-shortcuts';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';
}