<?php

namespace App\Filament\Resources\OurPeople\Pages;

use App\Filament\Resources\OurPeople\OurPeopleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOurPeople extends ListRecords
{
    protected static string $resource = OurPeopleResource::class;

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