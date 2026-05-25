<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * ============================================================
 *  Project Form — Senior Enterprise UX Design
 * ============================================================
 *  ✅ 8+4 Column Split Layout (Industry Standard)
 *  ✅ Drag-and-drop gallery with full image preview grid
 *  ✅ Auto-Slug generation upon typing
 * ============================================================
 */
class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('Projects', [
                    ['icon' => '🏗️', 'title' => 'Fill Core Details',       'tip' => 'Enter the project name, client, location, and status. The URL slug will auto-generate from the name.'],
                    ['icon' => '🖼️', 'title' => 'Upload Cover Photo',       'tip' => 'Upload one high-quality cover image (JPG/PNG/WEBP, max 10MB). You can also crop and edit it after uploading.'],
                    ['icon' => '🗂️', 'title' => 'Add Gallery Photos',       'tip' => 'Upload multiple site photos. Drag to reorder them. The first image leads the gallery on the live website.'],
                    ['icon' => '✅', 'title' => 'Set Visibility & Publish', 'tip' => 'Toggle "Live on Website" to ON and click Save. Then click the Deploy button on the Dashboard to update the live site.'],
                ], 'After saving, remember to click the 🚀 Deploy button on the Dashboard to push changes to the public website.'),

                Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        // ==========================================
                        // 左侧核心内容区 (占 8 列)
                        // ==========================================
                        Group::make()
                            ->schema([
                                // ── 基础信息 ──
                                Section::make('Core Project Credentials')
                                    ->description('Essential identity and engineering details.')
                                    ->icon('heroicon-o-building-office-2')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Project Portfolio Name')
                                            ->placeholder('e.g. Citadines Connect Hotel')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true) 
                                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                            )
                                            ->columnSpanFull(),

                                        Grid::make(2)->schema([
                                            TextInput::make('client')
                                                ->label('Client / Developer')
                                                ->placeholder('e.g. Mah Sing Group Berhad')
                                                ->prefixIcon('heroicon-o-user'),

                                            TextInput::make('location')
                                                ->label('Project Location')
                                                ->placeholder('e.g. Georgetown, Penang')
                                                ->prefixIcon('heroicon-o-map-pin'),
                                        ]),

                                        Textarea::make('description')
                                            ->label('Executive Summary')
                                            ->placeholder('Describe the project in 1-3 sentences...')
                                            ->rows(3)
                                            ->columnSpanFull(),

                                        Grid::make(3)->schema([
                                            Select::make('status')
                                                ->label('Execution Status')
                                                ->options([
                                                    'Ongoing'     => 'Ongoing',
                                                    'Completed'   => 'Completed',
                                                    'Coming Soon' => 'Upcoming',
                                                ])
                                                ->native(false)
                                                ->required(),

                                            Select::make('category_id')
                                                ->label('Category')
                                                ->relationship('category', 'name', fn($query) => $query->where('model_type', 'Project'))
                                                ->createOptionForm([
                                                    TextInput::make('name')->required(),
                                                    TextInput::make('slug')->required(),
                                                    \Filament\Forms\Components\Hidden::make('model_type')->default('Project'),
                                                ])
                                                ->searchable()
                                                ->preload()
                                                ->native(false)
                                                ->required(),

                                            TextInput::make('year')
                                                ->label('Year')
                                                ->numeric()
                                                ->minValue(1990)
                                                ->maxValue(2035),
                                        ]),

                                        Grid::make(2)->schema([
                                            TextInput::make('contract_value')
                                                ->label('Contract Value')
                                                ->placeholder('e.g. RM 45 Million')
                                                ->prefixIcon('heroicon-o-banknotes'),

                                            TextInput::make('award')
                                                ->label('Award Snippet')
                                                ->placeholder('e.g. QLASSIC: 83% | SHASSIC 5 Stars')
                                                ->prefixIcon('heroicon-o-trophy')
                                                ->helperText('To add multiple awards, separate them with a space and pipe symbol ( | ).'),
                                        ]),
                                    ]),

                                // ── 主封面图 ──
                                Section::make('Featured Cover Photo')
                                    ->description('The primary visual for the project card.')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        TextInput::make('image_url')
                                            ->label('Image Web Address (URL)')
                                            ->placeholder('https://...')
                                            ->url()
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('cover_image')
                                            ->collection('cover_image')
                                            ->label('Upload Cover Image')
                                            ->helperText('Accepted formats: JPG, PNG, WEBP. Max 10 MB.')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(2)
                                            ->imageEditorAspectRatios(['16:9', '4:3'])
                                            ->imagePreviewHeight('250')
                                            ->maxSize(10240)
                                            ->panelAspectRatio('2:1') 
                                            ->panelLayout('integrated') 
                                            ->columnSpanFull(),
                                    ]),

                                // ── 多图图集 ──
                                Section::make('Project Gallery')
                                    ->description('Drag and drop multiple photos. The first image will lead the gallery.')
                                    ->icon('heroicon-o-squares-2x2')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->label('') 
                                            ->multiple()
                                            ->reorderable()
                                            ->appendFiles()
                                            ->openable()
                                            ->downloadable()
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(2)
                                            ->imagePreviewHeight('160')
                                            ->maxSize(10240)
                                            ->panelLayout('grid')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        // ==========================================
                        // 右侧边栏设置区 (占 4 列)
                        // ==========================================
                        Group::make()
                            ->extraAttributes(['class' => 'lg:sticky lg:top-6 lg:self-start space-y-6'])
                            ->schema([
                                // ── 可见性与排序 ──
                                Section::make('Publishing Controls')
                                    ->schema([
                                        Toggle::make('is_published')
                                            ->label('Live on Website')
                                            ->onColor('success')
                                            ->default(true),

                                        Toggle::make('is_flagship')
                                            ->label('Flagship Project')
                                            ->helperText('Feature this prominently on the portal.')
                                            ->onColor('warning'), 

                                        TextInput::make('sort_order')
                                            ->label('Display Order')
                                            ->helperText('0 = Auto sorting')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                // ── SEO ──
                                Section::make('SEO Data')
                                    ->collapsed() 
                                    ->schema([
                                        TextInput::make('slug')
                                            ->label('URL Identifier')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                            
                                        TextInput::make('meta_title')
                                            ->label('Browser Title (Meta Title)')
                                            ->placeholder('e.g. Luxury Hotel Construction in Penang | Builtech')
                                            ->helperText('Defaults to Project Name if empty.'),

                                        Textarea::make('meta_description')
                                            ->label('Search Description (Meta Description)')
                                            ->placeholder('A brief summary for Google search results...')
                                            ->rows(3)
                                            ->helperText('Defaults to Executive Summary if empty.'),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }
}