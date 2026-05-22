<?php

namespace App\Filament\Resources\CurrentProjectResource\Pages;

use App\Filament\Resources\CurrentProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrentProject extends EditRecord
{
    protected static string $resource = CurrentProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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