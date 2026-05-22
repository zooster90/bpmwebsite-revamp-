<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

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