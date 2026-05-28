<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrentProjectResource\Pages;
use App\Models\CurrentProject;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CurrentProjectResource extends Resource
{
    use \App\Filament\Concerns\RoleBasedAccess;

    protected static ?string $model = CurrentProject::class;

    protected static ?string $navigationLabel = 'Ongoing Projects';
    protected static string | \UnitEnum | null $navigationGroup = '📁 Project Portfolio';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Ongoing Project';
    protected static ?string $pluralModelLabel = 'Ongoing Projects';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                Section::make('Ongoing Project Details')
                                    ->icon('heroicon-o-information-circle')
                                    ->description('Details for projects currently under construction.')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Project Title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                                                $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                                            )
                                            ->columnSpanFull(),
                                        
                                        \Filament\Schemas\Components\Grid::make(2)->schema([
                                            TextInput::make('client')
                                                ->label('Client'),
                                            
                                            TextInput::make('location')
                                                ->label('Location'),
                                        ]),
                                        
                                        Textarea::make('description')
                                            ->label('Brief Description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                            
                                        \Filament\Schemas\Components\Grid::make(3)->schema([
                                            Select::make('status')
                                                ->label('Status')
                                                ->options([
                                                    'Ongoing' => 'Ongoing',
                                                    'Starting' => 'Starting',
                                                    'Finishing' => 'Finishing',
                                                ])
                                                ->default('Ongoing'),

                                            Select::make('category_id')
                                                ->label('Category')
                                                ->relationship('category', 'name', fn($query) => $query->where('model_type', 'Project'))
                                                ->searchable()
                                                ->preload(),

                                            TextInput::make('year')
                                                ->label('Expected Completion Year')
                                                ->numeric(),
                                        ]),

                                        \Filament\Schemas\Components\Grid::make(2)->schema([
                                            TextInput::make('contract_value')
                                                ->label('Contract Value'),
                                        ]),
                                    ]),

                                Section::make('Project Photo')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        // Hidden the explicit URL entry. Stays in DB for fallback.
                                        TextInput::make('image_url')
                                            ->label('Image URL')
                                            ->hidden(),
                                        
                                        SpatieMediaLibraryFileUpload::make('cover_image')
                                            ->collection('cover_image')
                                            ->label('Upload Photo')
                                            ->helperText('Accepted: JPG, PNG, WEBP. Max 10 MB.')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->imagePreviewHeight('250')
                                            ->maxSize(10240)
                                            ->panelAspectRatio('2:1')
                                            ->panelLayout('integrated')
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->label('Gallery Photos')
                                            ->multiple()
                                            ->reorderable()
                                            ->appendFiles()
                                            ->openable()
                                            ->downloadable()
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->imagePreviewHeight('160')
                                            ->maxSize(10240)
                                            ->panelLayout('grid')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                Section::make('Settings')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Visible on Website')
                                            ->default(true),

                                        TextInput::make('completion_percentage')
                                            ->label('Completion Progress (%)')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->default(0)
                                            ->suffix('%'),

                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->helperText('Auto-generated from title, used in URLs.')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),

                                        TextInput::make('sort_order')
                                            ->label('Display Order')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Lower numbers appear first.'),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // Eager-load media so the photo-count column doesn't fire a query per row.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with('media'))
            ->columns([
                ImageColumn::make('display_image')
                    ->label('Image')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->extraImgAttributes(['style' => 'min-width: 80px; min-height: 60px; max-width: 80px; max-height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);']),

                TextColumn::make('title')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (CurrentProject $record): string => $record->location ?? ''),

                TextColumn::make('photo_count')
                    ->label('Photos')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->state(fn ($record) => $record->getMedia('cover_image')->count() + $record->getMedia('gallery')->count())
                    ->badge()
                    ->icon('heroicon-o-photo')
                    ->color(fn (int $state) => match (true) {
                        $state === 0 => 'danger',
                        $state <= 3  => 'warning',
                        default      => 'success',
                    })
                    ->tooltip(fn ($record) => 'Cover: ' . $record->getMedia('cover_image')->count() . ' · Gallery: ' . $record->getMedia('gallery')->count())
                    ->formatStateUsing(fn (int $state) => $state === 0 ? 'None' : $state . ($state === 1 ? ' photo' : ' photos')),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string | null $state): string => match ($state) {
                        'Starting' => 'info',
                        'Ongoing' => 'warning',
                        'Finishing' => 'danger',
                        'Completed' => 'success',
                        default => 'gray',
                    }),
                
                TextColumn::make('category.name')
                    ->label('Category'),
                
                \Filament\Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),
                
                TextColumn::make('completion_percentage')
                    ->label('Progress')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        $pct = intval($state ?? 0);
                        return "
                            <div class=\"flex items-center gap-2\" style=\"min-width: 120px;\">
                                <div class=\"w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700 overflow-hidden\">
                                    <div class=\"bg-[#c5a059] h-2 rounded-full transition-all\" style=\"width: {$pct}%\"></div>
                                </div>
                                <span class=\"text-xs font-bold text-gray-700 min-w-[32px] text-right\">{$pct}%</span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->defaultGroup(
                \Filament\Tables\Grouping\Group::make('year')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
                    ->orderQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query, string $direction) => $query->orderBy('year', 'desc'))
            )
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete this Ongoing Project?')
                    ->modalDescription('Are you sure you want to delete this project? All associated uploaded files will also be removed.')
                    ->color('danger'),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filter by Category')
                    ->relationship('category', 'name', fn($query) => $query->where('model_type', 'Project'))
                    ->searchable()
                    ->preload(),
                SelectFilter::make('year')
                    ->label('Filter by Target Year')
                    ->options(function () {
                        return \App\Models\CurrentProject::query()
                            ->whereNotNull('year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCurrentProjects::route('/'),
            'create' => Pages\CreateCurrentProject::route('/create'),
            'edit' => Pages\EditCurrentProject::route('/{record}/edit'),
        ];
    }
}