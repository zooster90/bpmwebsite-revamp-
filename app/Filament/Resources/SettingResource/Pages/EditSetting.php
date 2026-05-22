<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
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