<?php

namespace App\Filament\Resources\PressCoverages\Pages;

use App\Filament\Resources\PressCoverages\PressCoverageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPressCoverages extends ListRecords
{
    protected static string $resource = PressCoverageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    public function mount(): void
    {
        parent::mount();
        session()->put('resources.' . static::$resource . '.index_url', request()->fullUrl());
    }
}