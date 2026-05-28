<?php

namespace App\Filament\Resources\OurPeople\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class OurPeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Eager-load media so the photo-count column doesn't N+1.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with('media'))
            ->columns([
                ImageColumn::make('display_image')
                    ->state(fn ($record) => $record->displayImage)
                    ->label('Photo')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->extraImgAttributes(['style' => 'min-width: 80px; min-height: 60px; max-width: 80px; max-height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);']),
                TextColumn::make('title')
                    ->label('Team Name')
                    ->searchable()
                    ->sortable(),

                // Photo count: cover + gallery, color-coded.
                TextColumn::make('photo_count')
                    ->label('Photos')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->state(fn ($record) => $record->getMedia('people_image')->count() + $record->getMedia('gallery')->count())
                    ->badge()
                    ->icon('heroicon-o-photo')
                    ->color(fn (int $state) => match (true) {
                        $state === 0 => 'danger',
                        $state <= 3  => 'warning',
                        default      => 'success',
                    })
                    ->tooltip(fn ($record) => 'Cover: ' . $record->getMedia('people_image')->count() . ' · Gallery: ' . $record->getMedia('gallery')->count())
                    ->formatStateUsing(fn (int $state) => $state === 0 ? 'None' : $state . ($state === 1 ? ' photo' : ' photos')),

                TextColumn::make('department')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->deferFilters(false);
    }
}
