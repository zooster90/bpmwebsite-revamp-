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
        $resource = $this->getResource();
        $indexUrl = session()->get('resources.' . $resource . '.index_url');
        if ($indexUrl) {
            return $indexUrl;
        }
        if ($this->previousUrl && !str_contains($this->previousUrl, '/edit')) {
            return $this->previousUrl;
        }
        return $resource::getUrl('index');
    }
}