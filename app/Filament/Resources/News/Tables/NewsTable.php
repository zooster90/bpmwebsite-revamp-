<?php

namespace App\Filament\Resources\News\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Eager-load media so the photo-count column doesn't fire a query per row.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with('media'))
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('display_image')
                    ->label('Thumbnail')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->extraImgAttributes(['style' => 'min-width: 80px; min-height: 60px; max-width: 80px; max-height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);']),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('photo_count')
                    ->label('Photos')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->state(fn ($record) => $record->getMedia('news_image')->count() + $record->getMedia('gallery')->count())
                    ->badge()
                    ->icon('heroicon-o-photo')
                    ->color(fn (int $state) => match (true) {
                        $state === 0 => 'danger',
                        $state <= 3  => 'warning',
                        default      => 'success',
                    })
                    ->tooltip(fn ($record) => 'Cover: ' . $record->getMedia('news_image')->count() . ' · Gallery: ' . $record->getMedia('gallery')->count())
                    ->formatStateUsing(fn (int $state) => $state === 0 ? 'None' : $state . ($state === 1 ? ' photo' : ' photos')),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('author')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('year')
                    ->label('Filter by Year')
                    ->options(function () {
                        return \App\Models\News::query()
                            ->whereNotNull('published_date')
                            ->pluck('published_date')
                            ->map(function ($date) {
                                return is_string($date) ? substr($date, 0, 4) : $date->format('Y');
                            })
                            ->unique()
                            ->sortDesc()
                            ->mapWithKeys(fn($year) => [$year => $year])
                            ->toArray();
                    })
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        if (!empty($data['value'])) {
                            $query->whereYear('published_date', $data['value']);
                        }
                        return $query;
                    })
            ])
            ->defaultSort('published_date', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferFilters(false);
    }
}
