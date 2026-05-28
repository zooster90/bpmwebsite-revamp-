<?php

namespace App\Filament\Resources\OurPeople\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Spatie\MediaLibrary\HasMedia;

class OurPeopleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('Our People — Team Directory', [
                    ['icon' => '👥', 'title' => 'Enter Team Name',          'tip' => 'Each record represents one team or department group (e.g. "Head Office Team", "Site Engineering Team"). Not individual people.'],
                    ['icon' => '🏢', 'title' => 'Add Department / Location', 'tip' => 'Enter the department or office location (e.g. "Corporate HQ, Penang" or "Site Office, KL").'],
                    ['icon' => '🖼️', 'title' => 'Upload Team Photo',       'tip' => 'Upload a group photo of the team. Recommended resolution: 800x600. Accepted: JPG, PNG, WEBP. Max 10MB.'],
                    ['icon' => '🔢', 'title' => 'Set Sort Order',           'tip' => 'Lower numbers appear first on the Our People page. Use 0 for auto-sorting.'],
                    ['icon' => '✅', 'title' => 'Activate & Deploy',         'tip' => 'Toggle "Active" to ON. Click Save, then click 🚀 Deploy on the Dashboard to make it live.'],
                ]),

                \Filament\Schemas\Components\Section::make('Team Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Team Name')
                            ->placeholder('e.g., Head Office Team')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('department')
                            ->label('Department / Location')
                            ->placeholder('e.g., Corporate HQ, Penang')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
                \Filament\Schemas\Components\Section::make('Team Image')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('current_image_preview')
                            ->label('Current Live Photo')
                            ->content(fn ($record) => $record && $record->displayImage ? new \Illuminate\Support\HtmlString('
                                <div style="border: 1px solid #e8e3db; border-radius: 12px; padding: 8px; background: #fff; display: inline-block; box-shadow: 0 4px 12px rgba(40,30,20,0.05);">
                                    <img src="' . $record->displayImage . '" style="max-height: 150px; border-radius: 8px; object-fit: cover;">
                                </div>
                            ') : 'No image uploaded yet.')
                            ->hintAction(
                                \Filament\Actions\Action::make('remove_current_image')
                                    ->label('Remove Photo')
                                    ->color('danger')
                                    ->icon('heroicon-o-trash')
                                    ->requiresConfirmation()
                                    ->action(function ($record) {
                                        $record->clearMediaCollection('people_image');
                                        $record->image = null;
                                        $record->save();
                                    })
                                    ->visible(fn ($record) => $record && $record->displayImage !== null)
                            )
                            ->visible(fn ($record) => $record !== null),
                        \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('people_image')
                            ->collection('people_image')
                            ->label('Main Team Photo (cover)')
                            ->helperText('The primary photo. Shown as the team cover. Recommended: 800x600.')
                            ->image()
                            ->imageEditor()
                            ->imageEditorMode(1)
                            ->maxSize(10240)
                            ->columnSpanFull(),

                        // ── Multi-image team gallery ─────────────────────
                        \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                            ->collection('gallery')
                            ->label('Additional Team Photos (gallery)')
                            ->helperText('Upload multiple. Drag to reorder. Shown as a carousel on the public team page. Max 10 MB each.')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->openable()
                            ->downloadable()
                            ->image()
                            ->imageEditor()
                            ->imageEditorMode(1)
                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                            ->imagePreviewHeight('150')
                            ->maxSize(10240)
                            ->panelLayout('grid')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
