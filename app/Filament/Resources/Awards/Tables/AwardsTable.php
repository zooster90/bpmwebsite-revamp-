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
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('display_image')
                    ->label('Award Logo')
                    ->width(50)
                    ->height(50)
                    ->circular()
                    ->defaultImageUrl(asset('images/award-fallback.png')),

                TextColumn::make('name')
                    ->label('Award Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

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
            ->defaultGroup('year')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filter by Category')
                    ->relationship('category', 'name', fn($query) => $query->where('model_type', 'Award')),
                SelectFilter::make('year')
                    ->label('Filter by Year')
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
            ->emptyStateIcon('heroicon-o-trophy');
    }
}
