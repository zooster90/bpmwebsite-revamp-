<?php

namespace App\Filament\Resources\OurPeople\Pages;

use App\Filament\Resources\OurPeople\OurPeopleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOurPeople extends CreateRecord
{
    protected static string $resource = OurPeopleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
