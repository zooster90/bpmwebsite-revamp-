<?php

namespace App\Filament\Resources\News\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section; // ✅ 唯一改动：Section 搬到 Schemas 下了！
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

/**
 * News Form — Clear and simple for non-technical staff.
 */
class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('News Article Details')
                    ->description('Fill in the information for this news article.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Article Title / Headline')
                            ->helperText('The title of the news article. Example: "Builtech Wins 5-Star CIDB SCORE Rating 2024"')
                            ->placeholder('e.g. Builtech Achieves ISO 9001:2015 Recertification')
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('excerpt')
                            ->label('Short Summary (Appears in news list)')
                            ->helperText('Write 1-2 sentences summarising the article. This appears under the headline in the news list.')
                            ->placeholder('A brief summary of what this news article is about...')
                            ->rows(2)
                            ->columnSpanFull(),

                        Select::make('category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->label('News Category')
                            ->helperText('Pick the most suitable category for this article.')
                            ->options([
                                'Company News'         => 'Company News',
                                'Project Updates'      => 'Project Updates',
                                'Industry Insights'    => 'Industry Insights',
                                'Awards & Recognition' => 'Awards & Recognition',
                                'CSR & Community'      => 'CSR & Community',
                            ])
                            ->default('Company News'),

                        DatePicker::make('published_date')
                            ->label('Published Date')
                            ->helperText('When was (or will) this article be published?')
                            ->displayFormat('d M Y')
                            ->default(now()),

                        TextInput::make('author')
                            ->label('Author Name (Optional)')
                            ->helperText('Who wrote this article? Leave blank if not needed.')
                            ->placeholder('e.g. Builtech Communications Team'),

                        Toggle::make('is_published')
                            ->label('Publish on Website')
                            ->helperText('Turn ON to show this article on the website. Turn OFF to save as a draft.')
                            ->default(true),
                    ]),

                Section::make('Full Article Content')
                    ->description('Write the full news article below. You can use bold, italic, and bullet points.')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Article Body')
                            ->helperText('Write the full article here. Use the toolbar buttons for bold, italic, headings, and lists.')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline',
                                'bulletList', 'orderedList',
                                'h2', 'h3',
                                'link', 'blockquote',
                                'undo', 'redo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Article Cover Image')
                    ->description('Upload a cover photo for this news article.')
                    ->schema([
                        TextInput::make('image_url')
                            ->label('Image Web Address (URL)'),
                        FileUpload::make('news_image_upload')
                            ->label('Upload News Photo')
                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                            ->disk('public')
                            ->directory('news-images')
                            ->columnSpanFull(),
                    ]),

                Section::make('Advanced Settings')
                    ->description('These are automatically filled in — only change if needed.')
                    ->collapsed()
                    ->schema([
                        TextInput::make('slug')
                            ->label('URL Identifier (Auto-generated)')
                            ->helperText('This is the web address for this article. Do not change unless you are certain of the impact.')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),
            ]);
    }
}