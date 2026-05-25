<?php

namespace App\Filament\Resources\News\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('News & Media', [
                    ['icon' => '📰', 'title' => 'Write the Article',       'tip' => 'Fill in the Article Title, Category, Author, and Publication Date. The URL slug is auto-generated from the title.'],
                    ['icon' => '✍️',  'title' => 'Add Content',              'tip' => 'Write the Short Summary (shown on the news listing page) and the Full Article Content using the rich text editor.'],
                    ['icon' => '🖼️', 'title' => 'Upload Featured Image',    'tip' => 'Upload one banner image for the article card. Recommended ratio: 16:9. Max 10MB.'],
                    ['icon' => '📸', 'title' => 'Add Gallery Photos',       'tip' => '(Optional) Upload additional supporting photos. Drag to reorder. These appear in the article\'s photo gallery.'],
                    ['icon' => '✅', 'title' => 'Publish & Deploy',         'tip' => 'Toggle "Publish this article" to ON. Click Save, then click the 🚀 Deploy button on the Dashboard.'],
                ], 'Set "Featured News" ON to show this article as the main headline at the top of the News page.'),

                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                Section::make('News Details')
                                    ->description('Main content for this news article.')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Article Title')
                                            ->helperText('The main headline of the article.')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                                                $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                                            )
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\Select::make('category_id')
                                            ->label('Category')
                                            ->helperText('Pick the most suitable category for this article.')
                                            ->relationship('category', 'name', fn($query) => $query->where('model_type', 'News'))
                                            ->createOptionForm([
                                                \Filament\Forms\Components\TextInput::make('name')->required(),
                                                \Filament\Forms\Components\TextInput::make('slug')->required(),
                                                \Filament\Forms\Components\Hidden::make('model_type')->default('News'),
                                            ])
                                            ->required()
                                            ->searchable(),

                                        TextInput::make('author')
                                            ->label('Author Name')
                                            ->placeholder('e.g. Builtech Communications')
                                            ->maxLength(150),

                                        DatePicker::make('published_date')
                                            ->label('Publication Date'),
                                    ]),

                                Section::make('Content & Excerpt')
                                    ->description('Write the news article here.')
                                    ->schema([
                                        Textarea::make('excerpt')
                                            ->label('Short Summary')
                                            ->helperText('A brief 1-2 sentence summary shown on the news listing page. Maximum 500 characters.')
                                            ->rows(2)
                                            ->maxLength(500)
                                            ->columnSpanFull(),

                                        RichEditor::make('content')
                                            ->label('Full Article Content')
                                            ->helperText('Write the full news article here. Minimum 50 characters required.')
                                            ->toolbarButtons([
                                                'bold', 'italic', 'underline', 'strike', 'bulletList', 'orderedList', 'h2', 'h3', 'blockquote', 'link', 'undo', 'redo'
                                            ])
                                            ->required()
                                            ->minLength(50)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Featured Image')
                                    ->description('Upload a high-quality banner image for this article. Auto-compressed to HD WebP on save.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('news_image')
                                            ->collection('news_image')
                                            ->label('Upload News Cover Photo')
                                            ->helperText('Accepted formats: JPG, PNG, WEBP — Maximum file size: 10 MB.')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->imageEditorAspectRatios(['16:9', '3:2'])
                                            ->imagePreviewHeight('200')
                                            ->maxSize(10240)
                                            ->columnSpanFull(),

                                        TextInput::make('image_url')
                                            ->label('Or Provide Image URL')
                                            ->helperText('Alternative: paste a direct image URL if the image is already hosted online.')
                                            ->url()
                                            ->maxLength(2048)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Article Gallery — Additional Photos')
                                    ->description('Upload additional photos for this article. Each image appears individually in the gallery. Drag to reorder. Click the eye icon to preview.')
                                    ->schema([
                                        Placeholder::make('gallery_tip')
                                            ->label('')
                                            ->content('Tip: Upload supporting photos for the article. Readers can view each photo in full size by clicking it. Use high-resolution images for best quality.')
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->label('Upload Additional Article Photos')
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
                            ->extraAttributes(['class' => 'lg:sticky lg:top-6 lg:self-start space-y-6'])
                            ->schema([
                                Section::make('Visibility Settings')
                                    ->schema([
                                        Toggle::make('is_published')
                                            ->label('Publish this article')
                                            ->helperText('Turn ON to make this article visible on the website.')
                                            ->default(true)
                                            ->required(),

                                        Toggle::make('is_featured')
                                            ->label('Featured News')
                                            ->helperText('Display this article as the main featured story at the top of the News page.'),
                                    ]),

                                Section::make('SEO Metadata')
                                    ->description('Optimize how this article appears in search engines like Google.')
                                    ->schema([
                                        TextInput::make('slug')
                                            ->label('URL Identifier')
                                            ->helperText('Auto-generated from the title — do not change unless necessary.')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),

                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->placeholder('e.g. Builtech Completes Major Infrastructure Project | Latest News')
                                            ->helperText('Maximum 60 characters recommended. Defaults to Article Title if empty.')
                                            ->maxLength(255),

                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->placeholder('A compelling summary to encourage clicks in search results...')
                                            ->helperText('Maximum 160 characters recommended. Defaults to Article Excerpt if empty.')
                                            ->rows(3)
                                            ->maxLength(500),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }
}
