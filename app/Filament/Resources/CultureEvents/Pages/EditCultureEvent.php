<?php

namespace App\Filament\Resources\CultureEvents\Pages;

use App\Filament\Resources\CultureEvents\CultureEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCultureEvent extends EditRecord
{
    protected static string $resource = CultureEventResource::class;

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
