<?php

namespace App\Filament\Resources\OurPeople\Pages;

use App\Filament\Resources\OurPeople\OurPeopleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOurPeople extends EditRecord
{
    protected static string $resource = OurPeopleResource::class;

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