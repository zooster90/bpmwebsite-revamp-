<?php

namespace App\Filament\Resources\JobOpenings\Pages;

use App\Filament\Resources\JobOpenings\JobOpeningResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobOpening extends ViewRecord
{
    protected static string $resource = JobOpeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
