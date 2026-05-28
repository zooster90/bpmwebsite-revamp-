<?php

namespace App\Filament\Resources\CultureEvents\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * ============================================================
 *  Culture Event Form — Internship-Aware Edition
 * ============================================================
 *  ✅ Internship entries grouped by year on the frontend
 *  ✅ Individual intern info: name, university, department, period
 *  ✅ Full gallery with drag-drop reordering
 * ============================================================
 */
class CultureEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('Company Culture & Events', [
                    ['icon' => '🎉', 'title' => 'Select Category First',      'tip' => 'Choose the Main Category (e.g. Company Event, Internship, CSR). This determines which fields are shown. For interns, select "Internship".'],
                    ['icon' => '🎓', 'title' => 'For Internship Records',     'tip' => 'Create ONE record per intern. Fill in their name, university, department, and period. The website automatically groups all interns with the same Year into a cohort page.'],
                    ['icon' => '🖼️', 'title' => 'Upload Cover + Gallery',    'tip' => 'Upload the main cover photo, then add more photos to the gallery. Drag to reorder. For interns, the gallery shows their work/activities.'],
                    ['icon' => '✅', 'title' => 'Save & Deploy',              'tip' => 'Click Save, then click the 🚀 Deploy button on the Dashboard to push changes to the live website.'],
                ], 'IMPORTANT for Interns: The Year field is critical. All interns with the same year will be grouped together automatically on the website.'),

                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                Section::make('Event Details')
                                    ->description('Fill in the main details about this company activity or culture event.')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Event Title')
                                            ->helperText(fn (callable $get) => 
                                                $get('category_id') && in_array(\App\Models\Category::find($get('category_id'))?->slug, ['intern', 'internship'])
                                                    ? 'For internship entries, use format: "2025 Internship Cohort" — all same-year interns will be grouped together on the website.'
                                                    : 'The title of this company activity or culture event.'
                                            )
                                            ->placeholder(fn (callable $get) => 
                                                $get('category_id') && in_array(\App\Models\Category::find($get('category_id'))?->slug, ['intern', 'internship'])
                                                    ? 'e.g. 2025 Internship Cohort'
                                                    : 'e.g. CNY Celebration'
                                            )
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, callable $set, callable $get) {
                                                if ($operation !== 'create' || blank($state)) {
                                                    return;
                                                }
                                                $base = $state;
                                                if ($get('year')) {
                                                    $base .= '-' . $get('year');
                                                }
                                                $slug = \Illuminate\Support\Str::slug($base);
                                                $originalSlug = $slug;
                                                $count = 1;
                                                while (\App\Models\CultureEvent::where('slug', $slug)->exists()) {
                                                    $slug = $originalSlug . '-' . $count;
                                                    $count++;
                                                }
                                                $set('slug', $slug);
                                            })
                                            ->columnSpanFull(),

                                        TextInput::make('name')
                                            ->label('Official Event Name')
                                            ->helperText('The full name used for internal records and reporting.')
                                            ->placeholder('e.g. 15th Annual Corporate Dinner')
                                            ->maxLength(255),

                                        DatePicker::make('event_date')
                                            ->label('Event Date')
                                            ->helperText(fn (callable $get) => 
                                                $get('category_id') && in_array(\App\Models\Category::find($get('category_id'))?->slug, ['intern', 'internship'])
                                                    ? 'When did this happen? For interns, use the start date of internship.'
                                                    : 'When did this event or activity happen?'
                                            )
                                            ->displayFormat('d/m/Y')
                                            ->default(now())
                                            ->live()
                                            ->afterStateUpdated(fn ($state, callable $set) => 
                                                $state ? $set('year', \Carbon\Carbon::parse($state)->year) : null
                                            ),

                                        TextInput::make('year')
                                            ->label(fn (callable $get) => 
                                                $get('category_id') && in_array(\App\Models\Category::find($get('category_id'))?->slug, ['intern', 'internship'])
                                                    ? 'Year (⚠️ Important for Interns)'
                                                    : 'Year'
                                            )
                                            ->helperText(fn (callable $get) => 
                                                $get('category_id') && in_array(\App\Models\Category::find($get('category_id'))?->slug, ['intern', 'internship'])
                                                    ? 'For internships: all interns sharing the SAME YEAR will be combined into one cohort page on the website. Make sure this is correct.'
                                                    : 'The calendar year of this activity.'
                                            )
                                            ->placeholder('e.g. 2025')
                                            ->numeric()
                                            ->minValue(1990)
                                            ->maxValue(2035)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, callable $set, callable $get) {
                                                if ($operation !== 'create' || blank($get('title'))) {
                                                    return;
                                                }
                                                $base = $get('title');
                                                if ($state) {
                                                    $base .= '-' . $state;
                                                }
                                                $slug = \Illuminate\Support\Str::slug($base);
                                                $originalSlug = $slug;
                                                $count = 1;
                                                while (\App\Models\CultureEvent::where('slug', $slug)->exists()) {
                                                    $slug = $originalSlug . '-' . $count;
                                                    $count++;
                                                }
                                                $set('slug', $slug);
                                            })
                                            ->required(),

                                        Select::make('category_id')
                                            ->label('Main Category')
                                            ->relationship('category', 'name', fn($query) => $query->where('model_type', 'CultureEvent')->whereNull('parent_id'))
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                                TextInput::make('slug')
                                                    ->required()
                                                    ->unique('categories', 'slug', ignoreRecord: true, modifyRuleUsing: fn ($rule) => $rule->where('model_type', 'CultureEvent')->whereNull('parent_id')),
                                                \Filament\Forms\Components\Hidden::make('model_type')->default('CultureEvent'),
                                            ])
                                            ->helperText('Choose the category that best describes this activity. Select "Internship" for intern records.')
                                            ->live()
                                            ->searchable()
                                            ->preload()
                                            ->afterStateUpdated(fn (callable $set) => $set('sub_category_id', null))
                                            ->required(),

                                        Select::make('sub_category_id')
                                            ->label('Sub-Category')
                                            ->helperText('Select the specific type of event. Options change based on the Main Category above.')
                                            ->relationship('subCategory', 'name', fn($query, callable $get) => $query->where('model_type', 'CultureEvent')->where('parent_id', $get('category_id')))
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                                TextInput::make('slug')
                                                    ->required()
                                                    ->unique('categories', 'slug', ignoreRecord: true, modifyRuleUsing: fn ($rule, callable $get) => $rule->where('model_type', 'CultureEvent')->where('parent_id', $get('category_id'))),
                                                \Filament\Forms\Components\Hidden::make('model_type')->default('CultureEvent'),
                                                \Filament\Forms\Components\Hidden::make('parent_id')->default(fn(callable $get) => $get('category_id')),
                                            ])
                                            ->visible(fn (callable $get) => filled($get('category_id')))
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        Textarea::make('description')
                                            ->label('Event Description / Notes')
                                            ->helperText(fn (callable $get) => 
                                                $get('category_id') && in_array(\App\Models\Category::find($get('category_id'))?->slug, ['intern', 'internship'])
                                                    ? 'For internship: write what the intern worked on, learnt, or contributed.'
                                                    : 'A description or summary notes about this event.'
                                            )
                                            ->placeholder('Write a brief summary...')
                                            ->maxLength(1000)
                                            ->rows(4)
                                            ->columnSpanFull(),
                                    ]),

                                // ── Internship-Specific Info ─────────────────────
                                Section::make('🎓 Internship Details')
                                    ->description('These fields only apply when Category = Internship. Each intern is ONE record. The website automatically groups all interns with the same Year into one cohort page — you do NOT need to create a separate combined entry.')
                                    ->columns(2)
                                    ->visible(fn (callable $get) => 
                                        $get('category_id') && in_array(\App\Models\Category::find($get('category_id'))?->slug, ['intern', 'internship'])
                                    )
                                    ->schema([
                                        TextInput::make('intern_name')
                                            ->label('Intern Full Name')
                                            ->helperText('Full name of the intern, e.g. "Ahmad bin Ali"')
                                            ->placeholder('e.g. Ahmad bin Ali')
                                            ->maxLength(255),

                                        TextInput::make('university')
                                            ->label('University / Institution')
                                            ->helperText('Name of the university, polytechnic, or college')
                                            ->placeholder('e.g. Universiti Sains Malaysia (USM)')
                                            ->maxLength(255),

                                        TextInput::make('department')
                                            ->label('Department / Faculty')
                                            ->helperText('Which team or department did the intern join?')
                                            ->placeholder('e.g. Civil & Structural Engineering')
                                            ->maxLength(255),

                                        TextInput::make('intern_period')
                                            ->label('Internship Period')
                                            ->helperText('Duration of the internship')
                                            ->placeholder('e.g. January – March 2025')
                                            ->maxLength(255),
                                    ]),

                                // ── Cover Photo ──────────────────────────────────
                                Section::make('Main Cover Photo')
                                    ->description('Upload ONE main photo. For interns, this can be a group photo or the individual intern\'s photo.')
                                    ->schema([
                                        TextInput::make('image_url')
                                            ->label('Image URL (optional)')
                                            ->helperText('If the photo is already online, paste its link here.')
                                            ->placeholder('https://...')
                                            ->url()
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('culture_image')
                                            ->collection('culture_image')
                                            ->label('Upload Main Photo')
                                            ->helperText('Accepted: JPG, PNG, WEBP — Max 10 MB. Recommended: 4:3 or 1:1 for intern portraits.')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                                            ->imagePreviewHeight('200')
                                            ->maxSize(10240)
                                            ->columnSpanFull(),
                                    ]),

                                // ── Video (Optional) ─────────────────────────────
                                Section::make('Video (Optional)')
                                    ->description('Upload a short video clip (MP4) OR provide a YouTube/Vimeo link to show a highlight video.')
                                    ->schema([
                                        \Filament\Forms\Components\FileUpload::make('video_upload')
                                            ->label('Upload Video File')
                                            ->helperText('Accepted: MP4, WebM. Max 50MB. (If you provide both, the direct upload will be used).')
                                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                                            ->maxSize(51200) // 50MB
                                            ->disk('public')
                                            ->directory('event-videos')
                                            ->columnSpanFull(),

                                        TextInput::make('video_url')
                                            ->label('Or paste Video URL (YouTube/Vimeo)')
                                            ->helperText('e.g. https://www.youtube.com/watch?v=... or https://vimeo.com/...')
                                            ->placeholder('Paste YouTube/Vimeo URL here...')
                                            ->url()
                                            ->columnSpanFull(),
                                    ]),

                                // ── Gallery ────────────────────────────────────
                                Section::make('Photo Gallery')
                                    ->description('Upload all photos. For interns, upload photos from their activities. All appear in the year-cohort gallery.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->label('Upload Gallery Photos')
                                            ->helperText('Accepted: JPG, PNG, WEBP — Max 10 MB per file. Drag to reorder.')
                                            ->multiple()
                                            ->reorderable()
                                            ->appendFiles()
                                            ->openable()
                                            ->downloadable()
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                                            ->imagePreviewHeight('160')
                                            ->maxSize(10240)
                                            ->panelLayout('grid')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        \Filament\Schemas\Components\Group::make()
                            ->extraAttributes(['class' => 'lg:sticky lg:top-6 lg:self-start space-y-6'])
                            ->schema([
                                // ── Publish Status ───────────────────────────────
                                Section::make('Publish Status')
                                    ->description('Control whether this activity appears on the public Culture page.')
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('is_published')
                                            ->label('Show on website')
                                            ->helperText('Turn OFF while you collect photos / write the description. Turn ON when ready for public.')
                                            ->default(true)
                                            ->inline(false)
                                            ->onColor('success')
                                            ->offColor('warning'),
                                    ]),

                                // ── System Settings ──────────────────────────────
                                Section::make('System Settings')
                                    ->schema([
                                        TextInput::make('slug')
                                            ->label('URL Identifier (Auto-generated)')
                                            ->helperText('Used in the page URL. Do not change unless certain.')
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
