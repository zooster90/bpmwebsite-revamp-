<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;
    public function mount(): void
    {
        parent::mount();
        session()->put('resources.' . static::$resource . '.index_url', request()->fullUrl());
    }
}