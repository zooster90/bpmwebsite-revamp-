<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                \Filament\Schemas\Components\Section::make('Core Service Details')
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                        
                                        TextInput::make('icon_class')
                                            ->required()
                                            ->default('fas fa-tasks'),
                                            
                                        Textarea::make('short_description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                            
                                        \Filament\Forms\Components\RichEditor::make('content')
                                            ->columnSpanFull(),
                                            
                                        FileUpload::make('image_path')
                                            ->image(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        \Filament\Schemas\Components\Group::make()
                            ->extraAttributes(['class' => 'lg:sticky lg:top-6 lg:self-start space-y-6'])
                            ->schema([
                                \Filament\Schemas\Components\Section::make('Publishing Controls')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Live on Website')
                                            ->default(true)
                                            ->required(),
                                            
                                        TextInput::make('sort_order')
                                            ->label('Display Order')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                    ]),
                                    
                                \Filament\Schemas\Components\Section::make('SEO Data')
                                    ->schema([
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }
}
