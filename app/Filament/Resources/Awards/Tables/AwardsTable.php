<?php

namespace App\Filament\Resources\Awards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 * Awards Table — Easy to Read
 */
class AwardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Eager-load media so the photo-count column doesn't fire a query per row.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with('media'))
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('display_image')
                    ->label('Award Logo')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->extraImgAttributes(['style' => 'min-width: 80px; min-height: 60px; max-width: 80px; max-height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);'])
                    ->defaultImageUrl(asset('images/award-fallback.png')),

                TextColumn::make('name')
                    ->label('Award Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('photo_count')
                    ->label('Photos')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->state(fn ($record) => $record->getMedia('logo')->count() + $record->getMedia('gallery')->count())
                    ->badge()
                    ->icon('heroicon-o-photo')
                    ->color(fn (int $state) => match (true) {
                        $state === 0 => 'danger',
                        $state <= 3  => 'warning',
                        default      => 'success',
                    })
                    ->tooltip(fn ($record) => 'Logo: ' . $record->getMedia('logo')->count() . ' · Gallery: ' . $record->getMedia('gallery')->count())
                    ->formatStateUsing(fn (int $state) => $state === 0 ? 'None' : $state . ($state === 1 ? ' photo' : ' photos')),

                TextColumn::make('issuer')
                    ->label('Issued By')
                    ->searchable(),

                TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('primary'),
            ])
            ->defaultSort('year', 'desc')
            ->defaultGroup(
                \Filament\Tables\Grouping\Group::make('year')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
                    ->orderQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query, string $direction) => $query->orderBy('year', 'desc'))
            )
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filter by Category')
                    ->relationship('category', 'name', fn($query) => $query->where('model_type', 'Award'))
                    ->searchable()
                    ->preload(),
                SelectFilter::make('year')
                    ->label('Filter by Year')
                    ->searchable()
                    ->preload()
                    ->options(function () {
                        return \App\Models\Award::query()
                            ->whereNotNull('year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    }),
            ])
            ->recordActions([
                EditAction::make()->label('Edit'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Awards Yet')
            ->emptyStateIcon('heroicon-o-trophy')
            ->deferFilters(false);
    }
}
