<?php

namespace App\Filament\Resources\PressCoverages\Pages;

use App\Filament\Resources\PressCoverages\PressCoverageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPressCoverage extends ViewRecord
{
    protected static string $resource = PressCoverageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
