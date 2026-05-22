<?php

namespace App\Filament\Resources\CurrentProjectResource\Pages;

use App\Filament\Resources\CurrentProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurrentProjects extends ListRecords
{
    protected static string $resource = CurrentProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function mount(): void
    {
        parent::mount();
        session()->put('resources.' . static::$resource . '.index_url', request()->fullUrl());
    }
}