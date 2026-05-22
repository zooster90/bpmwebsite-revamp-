<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Schemas\Schema; 
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationLabel = 'System Settings';
    protected static string | \UnitEnum | null $navigationGroup = '⚙️ Settings & System';
    protected static ?int $navigationSort = 9999;

    public static function getFormMaxContentWidth(): string
    {
        return 'full';
    }

    public static function getTableMaxContentWidth(): string
    {
        return 'full';
    }

    public static function form(Schema $schema): Schema 
    {
        return $schema
            ->components([
                Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Configuration Details')
                                    ->description('Update the value for this setting.')
                                    ->schema(fn ($record) => match ($record?->type) {
                                        'boolean' => [
                                            Toggle::make('value')
                                                ->label('Enabled / Active')
                                                ->onColor('success')
                                                ->offColor('danger')
                                                ->required(),
                                        ],
                                        'color' => [
                                            ColorPicker::make('value')
                                                ->label('Color Value')
                                                ->required(),
                                        ],
                                        'select' => [
                                            Select::make('value')
                                                ->options(json_decode($record->options ?? '[]', true))
                                                ->required(),
                                        ],
                                        'image' => [
                                            FileUpload::make('value')
                                                ->label('Image / Icon')
                                                ->image()
                                                ->directory('settings')
                                                ->visibility('public')
                                                ->required(),
                                        ],
                                        default => [
                                            Textarea::make('value')
                                                ->label('Configuration Value')
                                                ->rows(5)
                                                ->required(),
                                        ],
                                    }),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        Group::make()
                            ->schema([
                                Section::make('System Information')
                                    ->schema([
                                        TextInput::make('label')
                                            ->disabled()
                                            ->dehydrated(false),
                                        TextInput::make('key')
                                            ->disabled()
                                            ->dehydrated(false),
                                        Select::make('group')
                                            ->options([
                                                'company' => 'Corporate Identity',
                                                'social'  => 'Social & Reach',
                                                'seo'     => 'SEO Metadata',
                                                'general' => 'Core Systems',
                                                'branding'=> 'Branding & Aesthetics',
                                            ])
                                            ->disabled()
                                            ->dehydrated(false),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Setting')
                    ->searchable()
                    ->description(fn($record) => $record->key)
                    ->weight('bold'),
                
                TextColumn::make('group')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'company' => 'info',
                        'social'  => 'success',
                        'seo'     => 'warning',
                        'branding'=> 'primary',
                        default   => 'gray',
                    }),

                TextColumn::make('value')
                    ->label('Configuration State')
                    ->limit(40)
                    ->wrap()
                    ->color(fn ($record) => $record?->value === '1' || $record?->value === '0' ? ($record?->value === '1' ? 'success' : 'danger') : 'gray')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record?->type === 'boolean') return $state === '1' ? 'ACTIVE' : 'OFFLINE';
                        if ($record?->type === 'color') return $state;
                        return $state;
                    }),

                ColorColumn::make('value')
                    ->label('Preview')
                    ->visible(fn($record) => $record?->type === 'color'),

                ImageColumn::make('value')
                    ->label('Asset')
                    ->visible(fn($record) => $record?->type === 'image')
                    ->square(),
            ])
            ->defaultGroup('group')
            ->headerActions([
                Action::make('visit_frontend')
                    ->label('Visit Live Website')
                    ->icon('heroicon-o-globe-alt')
                    ->url(url('/'))
                    ->openUrlInNewTab()
                    ->color('info'),

                Action::make('maintenance_mode')
                    ->label(fn () => \App\Models\Setting::where('key', 'maintenance_mode')->value('value') === '1' ? 'System is Under Maintenance (Click to Go Live)' : 'Enable Maintenance Mode')
                    ->icon(fn () => \App\Models\Setting::where('key', 'maintenance_mode')->value('value') === '1' ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
                    ->color(fn () => \App\Models\Setting::where('key', 'maintenance_mode')->value('value') === '1' ? 'success' : 'danger')
                    ->requiresConfirmation()
                    ->modalHeading(fn () => \App\Models\Setting::where('key', 'maintenance_mode')->value('value') === '1' ? 'Bring Website Back Online?' : 'Put Website in Maintenance Mode?')
                    ->modalDescription(fn () => \App\Models\Setting::where('key', 'maintenance_mode')->value('value') === '1' 
                        ? 'Visitors will now be able to see the live website normally.' 
                        : 'Visitors will see a custom maintenance design page. You will still have full access to this admin panel.')
                    ->action(function () {
                        $setting = \App\Models\Setting::firstOrCreate(
                            ['key' => 'maintenance_mode'],
                            ['label' => 'Maintenance Mode', 'group' => 'general', 'value' => '0']
                        );
                        
                        if ($setting->value === '1') {
                            $setting->update(['value' => '0']);
                            // Failsafe: Clear any native Laravel maintenance mode if it was accidentally triggered previously
                            if (app()->isDownForMaintenance()) {
                                \Illuminate\Support\Facades\Artisan::call('up');
                            }
                            Notification::make()->title('Website is now Live')->success()->send();
                        } else {
                            $setting->update(['value' => '1']);
                            Notification::make()->title('Maintenance Mode Enabled')->danger()->send();
                        }
                    }),
            ])
            ->recordActions([
                Action::make('edit')
                    ->url(fn ($record) => static::getUrl('edit', ['record' => $record]))
                    ->label('Update')
                    ->icon('heroicon-o-pencil'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}