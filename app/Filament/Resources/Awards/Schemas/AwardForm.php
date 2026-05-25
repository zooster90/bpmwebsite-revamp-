<?php

namespace App\Filament\Resources\Awards\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class AwardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('Awards & Certifications', [
                    ['icon' => '🏆', 'title' => 'Select Award Type',      'tip' => 'Choose the Award Type (e.g. CIDB, QLASSIC, GBI). The official logo will automatically appear on the live website — no manual upload needed for standard types.'],
                    ['icon' => '📝', 'title' => 'Fill Grade / Score',      'tip' => 'Enter the grade, score, or recognition title (e.g. "82%", "Grade G7", "5 Star"). This is the main text shown on the Awards page.'],
                    ['icon' => '📎', 'title' => 'Upload Custom Logo',      'tip' => 'Only needed if this is a non-standard award. Leave empty if you already selected a standard Award Type above.'],
                    ['icon' => '📄', 'title' => 'Attach Certificates',    'tip' => 'Upload your official certificate images or photos from the award ceremony. Drag to reorder.'],
                    ['icon' => '✅', 'title' => 'Save & Deploy',           'tip' => 'Click Save, then click the 🚀 Deploy button on the Dashboard to publish changes to the live website.'],
                ], 'The logo is auto-displayed based on Award Type. You only need to manually upload a logo for new/custom awards not already in the system.'),

                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        Group::make()->schema([
                            Section::make('Certification Details')
                                ->description('Core information for this award or certification.')
                                ->icon('heroicon-o-shield-check')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Award Grade, Score or Title')
                                        ->helperText('e.g. "82%", "5 Star", "Grade 7" or full title.')
                                        ->placeholder('Enter the grade, score or recognition title')
                                        ->required()
                                        ->columnSpanFull(),

                                    Grid::make(2)->schema([
                                        TextInput::make('issuer')
                                            ->label('Awarding Body')
                                            ->helperText('e.g. CIDB Malaysia, MSOSH')
                                            ->placeholder('Organisation name')
                                            ->maxLength(200),

                                        TextInput::make('year')
                                            ->label('Year Received')
                                            ->helperText('4-digit year')
                                            ->placeholder('e.g. 2024')
                                            ->numeric()
                                            ->minValue(1990)
                                            ->maxValue(2035)
                                            ->required(),
                                    ]),

                                    Fieldset::make('Categorisation')->schema([
                                        Select::make('category_id')
                                            ->label('Award Type (Auto Logo)')
                                            ->helperText('Select CIDB, QLASSIC, GBI etc. Logo will automatically display!')
                                            ->relationship('category', 'name', fn($query) => $query->where('model_type', 'Award'))
                                            ->createOptionForm([
                                                \Filament\Forms\Components\TextInput::make('name')->required(),
                                                \Filament\Forms\Components\TextInput::make('slug')->required(),
                                                \Filament\Forms\Components\Hidden::make('model_type')->default('Award'),
                                            ])
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->columnSpan(1),

                                        Select::make('project_id')
                                            ->label('Linked Project (Optional)')
                                            ->relationship('project', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(1),
                                    ])->columns(2),

                                    Textarea::make('description')
                                        ->label('Citation / Remarks')
                                        ->placeholder('Brief details about this recognition...')
                                        ->maxLength(500)
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ]),
                        ])->columnSpan(['default' => 12, 'lg' => 8]),

                        Group::make()
                            ->extraAttributes(['class' => 'lg:sticky lg:top-6 lg:self-start space-y-6'])
                            ->schema([
                                Section::make('Organization Logo')
                                    ->description('The issuer\'s official logo.')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('logo')
                                            ->collection('logo')
                                            ->label('Upload Custom Logo (Optional)')
                                            ->helperText('Leave empty if using a standard Award Type (e.g. CIDB).')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->imagePreviewHeight('120')
                                            ->maxSize(5120)
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('image_url')
                                            ->label('Or Use External URL')
                                            ->url()
                                            ->maxLength(2048)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Documentation')
                                    ->description('Certificates & Ceremony Photos.')
                                    ->icon('heroicon-o-document-magnifying-glass')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->label('Upload Certificates')
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
                                            ->columnSpanFull()
                                            ->helperText('Drag to reorder. Max 10MB per file.'),
                                    ]),
                            ])->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }
}

