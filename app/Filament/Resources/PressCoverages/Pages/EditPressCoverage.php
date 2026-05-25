<?php

namespace App\Filament\Resources\PressCoverages\Pages;

use App\Filament\Resources\PressCoverages\PressCoverageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPressCoverage extends EditRecord
{
    protected static string $resource = PressCoverageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}