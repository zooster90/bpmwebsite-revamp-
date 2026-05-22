<?php

namespace App\Filament\Resources\PressCoverages\Pages;

use App\Filament\Resources\PressCoverages\PressCoverageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePressCoverage extends CreateRecord
{
    protected static string $resource = PressCoverageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
