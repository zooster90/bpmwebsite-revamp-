<?php

namespace App\Filament\Resources\PressCoverages\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * ============================================================
 *  Press Coverage Form — Senior UX Design
 * ============================================================
 *  ✅ Multi-image gallery for press clippings
 *  ✅ openable() + downloadable() per image
 *  ✅ Auto-compression to HD WebP on save (backend)
 * ============================================================
 */
class PressCoverageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('Press Coverage & Media Mentions', [
                    ['icon' => '📰', 'title' => 'Enter Article Headline',   'tip' => 'Copy the exact headline from the newspaper or website. This is the main title shown on the Press Coverage page.'],
                    ['icon' => '📝', 'title' => 'Write a Short Summary',   'tip' => 'Summarise the article in 1-2 sentences (max 500 characters). This is shown as the preview text on the listing page.'],
                    ['icon' => '🖼️', 'title' => 'Upload Press Clipping',   'tip' => 'Upload a screenshot or photo of the printed article. If it has multiple pages, upload the main page here and the rest in the gallery below.'],
                    ['icon' => '🔗', 'title' => 'Add External Link',       'tip' => '(Optional) Paste the URL to the online version of the article so visitors can read the full piece.'],
                    ['icon' => '✅', 'title' => 'Save & Deploy',             'tip' => 'Click Save, then click 🚀 Deploy on the Dashboard to publish to the live website.'],
                ], 'Use the gallery section to upload additional pages or related press photos for this same article.'),

                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                Section::make('Press Coverage Details')
                                    ->description('Fill in the details about this media mention or press article.')
                                    ->schema([
                                        TextInput::make('headline')
                                            ->label('Article Headline')
                                            ->helperText('The main title of the press article.')
                                            ->placeholder('e.g. Builtech Named Best Construction Firm 2024')
                                            ->required()
                                            ->columnSpanFull(),

                                        Textarea::make('excerpt')
                                            ->label('Short Summary')
                                            ->helperText('A brief summary of what the article says. Maximum 500 characters.')
                                            ->placeholder('Write a brief summary...')
                                            ->maxLength(500)
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),

                                // ── Main Press Clipping Image ────────────────────
                                Section::make('Main Press Clipping Image')
                                    ->description('Upload the main screenshot or photo of this press article. Auto-compressed to HD WebP on save.')
                                    ->schema([
                                        TextInput::make('image_url')
                                            ->label('Image Web Address (URL)')
                                            ->helperText('If the image is already online, paste its link here.')
                                            ->placeholder('https://...')
                                            ->url()
                                            ->maxLength(2048)
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('press_image')
                                            ->collection('press_image')
                                            ->label('Upload Main Press Clipping Photo')
                                            ->helperText('Accepted formats: JPG, PNG, WEBP — Maximum 5 MB. Upload a screenshot of the article or a press event photo.')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->imagePreviewHeight('200')
                                            ->maxSize(5120)
                                            ->columnSpanFull(),
                                    ]),

                                // ── Gallery (Multiple Clippings/Photos) ──────────
                                Section::make('Additional Press Clippings & Photos')
                                    ->description('Upload additional screenshots or photos related to this press coverage. Each image appears individually. Drag to reorder. Click the eye icon to preview.')
                                    ->schema([
                                        Placeholder::make('gallery_tip')
                                            ->label('')
                                            ->content('Tip: You can upload multiple pages of a newspaper article or multiple press photos here. Drag to reorder for the best presentation.')
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->label('Upload Additional Clippings & Photos')
                                            ->helperText('Accepted formats: JPG, PNG, WEBP — Maximum 10 MB per file. Drag to reorder after uploading.')
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
                                Section::make('Publishing & Media Info')
                                    ->schema([
                                        TextInput::make('publication')
                                            ->label('Media / Publication')
                                            ->helperText('Which newspaper or website published this?')
                                            ->placeholder('e.g. The Star, New Straits Times')
                                            ->maxLength(200),

                                        \Filament\Forms\Components\Select::make('category_id')
                                            ->label('Category')
                                            ->relationship('category', 'name', fn($query) => $query->where('model_type', 'News'))
                                            ->createOptionForm([
                                                \Filament\Forms\Components\TextInput::make('name')->required(),
                                                \Filament\Forms\Components\TextInput::make('slug')->required(),
                                                \Filament\Forms\Components\Hidden::make('model_type')->default('News'),
                                            ])
                                            ->searchable(),

                                        DatePicker::make('published_date')
                                            ->label('Publication Date')
                                            ->helperText('When was this published?')
                                            ->displayFormat('d M Y')
                                            ->default(now()),

                                        TextInput::make('external_url')
                                            ->label('External Link (URL)')
                                            ->helperText('Link to the original article online. Must begin with https://')
                                            ->placeholder('https://...')
                                            ->url()
                                            ->maxLength(2048),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }
}
