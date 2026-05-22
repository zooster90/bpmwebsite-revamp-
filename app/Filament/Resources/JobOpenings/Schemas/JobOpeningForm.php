<?php

namespace App\Filament\Resources\JobOpenings\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class JobOpeningForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('Job Openings', [
                    ['icon' => '💼', 'title' => 'Enter Job Details',        'tip' => 'Fill in the Job Title, Department, Location, and Employment Type. The slug is auto-generated from the title.'],
                    ['icon' => '📋', 'title' => 'Write Job Description',    'tip' => 'Use the rich text editor to list the main responsibilities. Use bullet points for easy reading.'],
                    ['icon' => '🎓', 'title' => 'Add Requirements',         'tip' => 'List required education, skills, and experience in the Requirements section. Be specific to attract the right candidates.'],
                    ['icon' => '📅', 'title' => 'Set Closing Date',         'tip' => '(Optional) Set an application deadline. The job listing will automatically disappear from the website after this date.'],
                    ['icon' => '✅', 'title' => 'Activate & Deploy',        'tip' => 'Toggle "Show on Website" to ON. Click Save, then click 🚀 Deploy on the Dashboard to make it live.'],
                ], 'Toggle "Mark as Actively Hiring" to show a green badge on the careers page, signalling to candidates that you are currently recruiting.'),

                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                // ══ Job Position Details ══
                                Section::make('Job Position Details')
                                    ->description('Provide the core information regarding this vacancy.')
                                    ->icon('heroicon-o-briefcase')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Job Title / Position Name')
                                            ->helperText('The official job title. Example: "Site Engineer" or "Quantity Surveyor"')
                                            ->placeholder('e.g. Project Manager')
                                            ->prefixIcon('heroicon-o-briefcase')
                                            ->required()
                                            ->maxLength(255)
                                            // Interaction: Automatically generate Slug from title on blur
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                            )
                                            ->columnSpanFull(),

                                        TextInput::make('department')
                                            ->label('Department')
                                            ->helperText('Which department is this for? Example: "Engineering" or "HSE"')
                                            ->placeholder('e.g. Project Management')
                                            ->prefixIcon('heroicon-o-user-group')
                                            ->datalist([
                                                'Engineering',
                                                'Construction',
                                                'Management',
                                                'HSE',
                                                'Quality & Safety',
                                                'Admin & Finance',
                                            ]),

                                        TextInput::make('location')
                                            ->label('Work Location')
                                            ->helperText('Workplace location. Example: "Penang HQ" or "On-Site, Jelutong"')
                                            ->placeholder('e.g. Penang')
                                            ->prefixIcon('heroicon-o-map-pin')
                                            ->default('Penang, PG'),

                                        Select::make('type')
                                            ->label('Employment Type')
                                            ->options([
                                                'Full-Time'  => 'Full-Time (Permanent)',
                                                'Part-Time'  => 'Part-Time',
                                                'Contract'   => 'Contract',
                                                'Internship' => 'Internship / Industrial Training',
                                            ])
                                            ->prefixIcon('heroicon-o-clock')
                                            ->required()
                                            ->default('Full-Time'),
                                    ]),

                                // ══ Detailed Descriptions ══
                                Section::make('Job Description & Requirements')
                                    ->description('Outline the responsibilities and qualifications for this role.')
                                    ->icon('heroicon-o-document-text')
                                    ->schema([
                                        RichEditor::make('description')
                                            ->label('Job Description')
                                            ->helperText('Describe the main daily responsibilities.')
                                            ->toolbarButtons([
                                                'bold', 'italic', 'underline', 'strike', 
                                                'bulletList', 
                                                'orderedList', // Fix: Use orderedList instead of numberedList
                                                'h3', 'link', 'undo', 'redo'
                                            ])
                                            ->required()
                                            ->columnSpanFull(),

                                        RichEditor::make('requirements')
                                            ->label('Requirements & Qualifications')
                                            ->helperText('List the required education, experience, and skills.')
                                            ->toolbarButtons([
                                                'bold', 'italic', 
                                                'bulletList', 
                                                'orderedList', // Fix: Use orderedList instead of numberedList
                                                'link', 'undo', 'redo'
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        \Filament\Schemas\Components\Group::make()
                            ->extraAttributes(['class' => 'lg:sticky lg:top-6 lg:self-start space-y-6'])
                            ->schema([
                                // ══ Visibility & Hiring Status ══
                                Section::make('Visibility')
                                    ->description('Control how this job appears on the corporate portal.')
                                    ->icon('heroicon-o-eye')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Show on Website')
                                            ->helperText('If ON, the job will be visible on the frontend Careers page.')
                                            ->default(true),

                                        Toggle::make('is_available')
                                            ->label('Mark as Actively Hiring')
                                            ->helperText('If ON, indicates that the company is currently seeking candidates.')
                                            ->default(true),
                                            
                                        \Filament\Forms\Components\DateTimePicker::make('closing_date')
                                            ->label('Application Closing Date')
                                            ->helperText('If set, the job will automatically close and disappear from the website after this date.')
                                            ->prefixIcon('heroicon-o-calendar')
                                            ->minDate(now()),
                                            
                                        TextInput::make('sort_order')
                                            ->label('Display Order Number')
                                            ->helperText('Lower numbers appear first on the website. Default is 0.')
                                            ->prefixIcon('heroicon-o-bars-arrow-down')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                // ══ Advanced Settings ══
                                Section::make('Advanced Settings')
                                    ->icon('heroicon-o-cog-6-tooth')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('slug')
                                            ->label('URL Identifier (Slug)')
                                            ->helperText('This defines the job ID in the URL. Do not change unless necessary.')
                                            ->prefixIcon('heroicon-o-link')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }
}