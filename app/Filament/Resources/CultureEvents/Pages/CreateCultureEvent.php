<?php

namespace App\Filament\Resources\CultureEvents\Pages;

use App\Filament\Resources\CultureEvents\CultureEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCultureEvent extends CreateRecord
{
    protected static string $resource = CultureEventResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
