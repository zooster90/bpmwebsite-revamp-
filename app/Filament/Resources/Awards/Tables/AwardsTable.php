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

                // ── Publish status badge ───────────────────────────────
                \Filament\Tables\Columns\IconColumn::make('is_published')
                    ->label('Live')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->tooltip(fn ($record) => $record->is_published ? 'Visible on public Awards page' : 'Draft — hidden from website')
                    ->sortable(),
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

                \Filament\Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publish status')
                    ->placeholder('All')
                    ->trueLabel('Live on website')
                    ->falseLabel('Draft (hidden)'),
            ])
            ->recordActions([
                EditAction::make()->label('Edit'),
            ])
            ->bulkActions([
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
            ->emptyStateHeading('No Awards Yet')
            ->emptyStateIcon('heroicon-o-trophy')
            ->deferFilters(false);
    }
}
