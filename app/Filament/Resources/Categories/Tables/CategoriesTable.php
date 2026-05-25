<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('slug')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('model_type')
                    ->label('Usage')
                    ->sortable()
                    ->badge(),
                \Filament\Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('model_type')
                    ->label('Filter by Usage')
                    ->options([
                        'Project' => 'Project',
                        'CultureEvent' => 'Culture Event',
                        'Award' => 'Award',
                        'News' => 'News',
                    ]),
            ])
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
