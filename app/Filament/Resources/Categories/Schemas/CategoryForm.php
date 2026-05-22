<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                \Filament\Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\Select::make('model_type')
                    ->label('Usage')
                    ->options([
                        'Project' => 'Project',
                        'CultureEvent' => 'Culture Event',
                        'Award' => 'Award',
                        'News' => 'News',
                    ])
                    ->required(),
                \Filament\Forms\Components\Select::make('parent_id')
                    ->label('Parent Category (for subcategories)')
                    ->relationship('parent', 'name')
                    ->searchable(),
            ]);
    }
}
