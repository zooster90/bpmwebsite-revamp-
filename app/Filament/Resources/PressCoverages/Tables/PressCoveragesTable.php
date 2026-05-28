<?php

namespace App\Filament\Resources\PressCoverages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Press Coverages Table — Easy to Read
 */
class PressCoveragesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Eager-load media so the photo-count column doesn't fire a query per row.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with('media'))
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('display_image')
                    ->label('Clipping')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->extraImgAttributes(['style' => 'min-width: 80px; min-height: 60px; max-width: 80px; max-height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);']),

                TextColumn::make('headline')
                    ->label('Headline')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('photo_count')
                    ->label('Photos')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->state(fn ($record) => $record->getMedia('press_image')->count() + $record->getMedia('gallery')->count())
                    ->badge()
                    ->icon('heroicon-o-photo')
                    ->color(fn (int $state) => match (true) {
                        $state === 0 => 'danger',
                        $state <= 3  => 'warning',
                        default      => 'success',
                    })
                    ->tooltip(fn ($record) => 'Cover: ' . $record->getMedia('press_image')->count() . ' · Gallery: ' . $record->getMedia('gallery')->count())
                    ->formatStateUsing(fn (int $state) => $state === 0 ? 'None' : $state . ($state === 1 ? ' photo' : ' photos')),

                TextColumn::make('publication')
                    ->label('Publication')
                    ->searchable(),

                TextColumn::make('published_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->placeholder('-'),

                TextColumn::make('external_url')
                    ->label('Link')
                    ->icon('heroicon-o-link')
                    ->url(fn ($record) => $record->external_url)
                    ->openUrlInNewTab()
                    ->limit(20)
                    ->placeholder('No link'),

                // ── Publish status badge ───────────────────────────────
                \Filament\Tables\Columns\IconColumn::make('is_published')
                    ->label('Live')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->tooltip(fn ($record) => $record->is_published ? 'Visible on public /media page' : 'Draft — hidden from website')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->label('Filter by Category')
                    ->relationship('category', 'name', fn($query) => $query->where('model_type', \App\Models\PressCoverage::class))
                    ->searchable()
                    ->preload(),
                \Filament\Tables\Filters\SelectFilter::make('year')
                    ->label('Filter by Year')
                    ->options(function () {
                        return \App\Models\PressCoverage::query()
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
                    }),

                \Filament\Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publish status')
                    ->placeholder('All')
                    ->trueLabel('Live on website')
                    ->falseLabel('Draft (hidden)'),
            ])
            ->defaultSort('published_date', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('publish')
                        ->label('Publish (show on website)')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn () => auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false)
                        ->requiresConfirmation()
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_published' => true]))
                        ->deselectRecordsAfterCompletion(),

                    \Filament\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish (hide from website)')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->visible(fn () => auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false)
                        ->requiresConfirmation()
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_published' => false]))
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Press Coverage Yet')
            ->emptyStateIcon('heroicon-o-globe-alt')
            ->deferFilters(false);
    }
}
