<?php

namespace App\Filament\Resources\JobOpenings\Pages;

use App\Filament\Resources\JobOpenings\JobOpeningResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobOpening extends EditRecord
{
    protected static string $resource = JobOpeningResource::class;

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