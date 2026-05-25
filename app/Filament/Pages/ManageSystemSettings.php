<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class ManageSystemSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static string | \UnitEnum | null $navigationGroup = '⚙️ Settings & System';
    protected static ?string $navigationLabel = 'System Settings';
    protected static ?string $title = 'System Configuration';
    protected static ?string $slug = 'settings';
    protected static ?int $navigationSort = 9999;
    protected string $view = 'filament.pages.manage-system-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        // Cast maintenance_mode to boolean for the toggle
        if (isset($settings['maintenance_mode'])) {
            $settings['maintenance_mode'] = $settings['maintenance_mode'] === '1';
        }
        $this->form->fill($settings);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('General Information')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Company / Site Name')
                                    ->required(),
                                TextInput::make('contact_email')
                                    ->label('Contact Email')
                                    ->email()
                                    ->required(),
                                Textarea::make('contact_phone')
                                    ->label('Contact Phone Numbers')
                                    ->helperText('Enter each number on a new line.')
                                    ->rows(3),
                                Textarea::make('office_address')
                                    ->label('Office Address')
                                    ->rows(4),
                            ]),

                        Tab::make('SEO Metadata')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Textarea::make('meta_description')
                                    ->label('Global Meta Description')
                                    ->helperText('Used for search engine optimization. Recommended: 150–160 characters for best results.')
                                    ->rows(4)
                                    ->maxLength(255),
                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->helperText('Comma-separated keywords (e.g., Construction, Malaysia, Architecture).'),
                                TextInput::make('og_title')
                                    ->label('Open Graph Title')
                                    ->helperText('Title shown when sharing on Facebook/LinkedIn.'),
                                TextInput::make('google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->helperText('e.g., G-XXXXXXXXXX or UA-XXXXX-X'),
                            ]),

                        Tab::make('Social Links')
                            ->icon('heroicon-o-share')
                            ->schema([
                                TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->prefix('https://'),
                                TextInput::make('linkedin_url')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->prefix('https://'),
                                TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->prefix('https://'),
                                TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->prefix('https://'),
                            ]),

                        Tab::make('System & Maintenance')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->schema([
                                Toggle::make('maintenance_mode')
                                    ->label('Enable Maintenance Mode')
                                    ->helperText('When ON, visitors see a maintenance page. You retain full admin access.')
                                    ->onColor('danger')
                                    ->offColor('success'),
                            ]),
                    ])
                    ->columnSpanFull()
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            $storedValue = is_bool($value) ? ($value ? '1' : '0') : ($value ?? '');

            $group = match (true) {
                in_array($key, ['site_name', 'contact_email', 'contact_phone', 'office_address']) => 'company',
                in_array($key, ['meta_description', 'meta_keywords', 'og_title', 'google_analytics_id']) => 'seo',
                in_array($key, ['facebook_url', 'linkedin_url', 'instagram_url', 'youtube_url']) => 'social',
                default => 'general',
            };

            $type = match (true) {
                is_bool($value) => 'boolean',
                in_array($key, ['office_address', 'meta_description', 'contact_phone']) => 'textarea',
                default => 'text',
            };

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $storedValue,
                    'type' => $type,
                    'group' => $group,
                    'label' => ucwords(str_replace('_', ' ', $key)),
                ]
            );
        }

        Notification::make()
            ->title('Settings Saved Successfully')
            ->body('All configuration has been updated.')
            ->success()
            ->send();
    }
}
