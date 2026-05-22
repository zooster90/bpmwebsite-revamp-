<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Projects'),

            'high_rise' => Tab::make('High Rise')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'high-rise', 'highrise', 'high_rise',
                    'residential', 'terrace', 'bungalow', 'semid', 'semi-d',
                    'terrace-house', 'apartment', 'condominium', 'landed',
                ]))),

            'healthcare' => Tab::make('Healthcare')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'healthcare', 'hospital', 'medical', 'clinic',
                ]))),

            'commercial' => Tab::make('Commercial')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'commercial', 'office', 'retail', 'shopping-mall',
                ]))),

            'hotel' => Tab::make('Hotel')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'hotel', 'resort', 'hospitality',
                ]))),

            'institution' => Tab::make('Institution')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'institutional', 'institution', 'school', 'education',
                    'public', 'public-sector', 'government',
                ]))),

            'infrastructure' => Tab::make('Infrastructure')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'infrastructure', 'roads', 'road', 'roadwork', 'roadworks',
                    'pipes-laying-sewer-line', 'sewer', 'drainage', 'utility',
                    'mechanical-electrical-works', 'pumping-station', 'civil',
                ]))),

            'industrial' => Tab::make('Industrial')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'industrial', 'factory', 'warehouse', 'manufacturing',
                ]))),

            'residential' => Tab::make('Residential')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'residential', 'terrace', 'bungalow', 'semid', 'semi-d',
                    'terrace-house', 'apartment', 'condominium', 'landed',
                ]))),

            'renovation' => Tab::make('Renovation')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', [
                    'interior-design', 'renovation', 'refurbishment',
                    'landscaping', 'landscaping-works', 'landscape',
                ]))),
        ];
    }

    public function mount(): void
    {
        parent::mount();
        session()->put('resources.' . static::$resource . '.index_url', request()->fullUrl());
    }
}