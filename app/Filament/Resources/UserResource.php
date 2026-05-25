<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Admin Users';
    protected static string | \UnitEnum | null $navigationGroup = '⚙️ Settings & System';
    protected static ?int $navigationSort = 9000;
 
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
                Section::make()
                    ->schema([
                        Placeholder::make('profile_header')
                            ->hiddenLabel()
                            ->content(fn ($record) => $record ? new \Illuminate\Support\HtmlString(\Illuminate\Support\Facades\Blade::render('
                                <div style="
                                    background: #ffffff;
                                    margin: -24px -24px 24px -24px;
                                    padding: 40px;
                                    border-radius: 24px 24px 0 0;
                                    display: flex;
                                    align-items: center;
                                    gap: 32px;
                                    position: relative;
                                    overflow: hidden;
                                    width: calc(100% + 48px);
                                    border-bottom: 1px solid #e4e4e7;
                                ">
                                    {{-- Accent glow --}}
                                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(197, 160, 89, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                                    
                                    <div style="position: relative; z-index: 10;">
                                        @if($record->getFirstMediaUrl("avatar"))
                                            <img src="{{ $record->getFirstMediaUrl("avatar") }}" style="width: 100px; height: 100px; border-radius: 24px; object-fit: cover; border: 1px solid #e4e4e7; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                                        @else
                                            <div style="width: 100px; height: 100px; border-radius: 24px; background: rgba(197, 160, 89, 0.1); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(197, 160, 89, 0.2); box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                                                <span style="font-size: 2.5rem; font-weight: 800; color: var(--bt-gold);">{{ substr($record->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div style="position: relative; z-index: 10;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <h1 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px;">{{ $record->name }}</h1>
                                            <span style="padding: 4px 12px; border-radius: 99px; background: @if($record->is_active) rgba(16, 185, 129, 0.1) @else rgba(244, 63, 94, 0.1) @endif; color: @if($record->is_active) #059669 @else #e11d48 @endif; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                                {{ $record->is_active ? "Active" : "Inactive" }}
                                            </span>
                                        </div>
                                        <p style="color: #64748b; margin: 4px 0 0; font-size: 1rem; font-weight: 500;">{{ $record->email }}</p>
                                        <div style="display: flex; gap: 8px; margin-top: 12px;">
                                            @foreach($record->roles as $role)
                                                <span style="padding: 4px 12px; border-radius: 6px; background: #f8fafc; color: #475569; font-size: 0.75rem; font-weight: 600; border: 1px solid #e2e8f0;">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            ', ['record' => $record])) : 'N/A'),

                        \Filament\Schemas\Components\Tabs::make('User Configuration')
                            ->tabs([
                                \Filament\Schemas\Components\Tabs\Tab::make('General Profile')
                                    ->icon('heroicon-o-user')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('name')->required()->maxLength(255),
                                            TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                                            \Filament\Forms\Components\Textarea::make('bio')
                                                ->label('Professional Headline')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                        ]),
                                    ]),

                                \Filament\Schemas\Components\Tabs\Tab::make('Security & Status')
                                    ->icon('heroicon-o-shield-check')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('password')->password()->dehydrateStateUsing(fn ($s) => filled($s) ? Hash::make($s) : null)->dehydrated(fn ($s) => filled($s))->placeholder('••••••••'),
                                            TextInput::make('password_confirmation')->password()->dehydrated(false)->same('password')->placeholder('••••••••'),
                                            Select::make('roles')->multiple()->relationship('roles', 'name')->preload()->required(),
                                            Toggle::make('is_active')->label('Allow Panel Access')->default(true)->inline(false),
                                        ]),
                                    ]),

                                \Filament\Schemas\Components\Tabs\Tab::make('Identity Asset')
                                    ->icon('heroicon-o-camera')
                                    ->schema([
                                        \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                                            ->collection('avatar')
                                            ->avatar()
                                            ->imageEditor()
                                            ->imageEditorMode(1)
                                            ->alignCenter()
                                            ->label('Official Profile Photo'),
                                    ]),

                                \Filament\Schemas\Components\Tabs\Tab::make('Audit History')
                                    ->icon('heroicon-o-clock')
                                    ->schema([
                                        Placeholder::make('recent_activity')
                                            ->hiddenLabel()
                                            ->content(fn ($record) => $record ? new \Illuminate\Support\HtmlString(\Illuminate\Support\Facades\Blade::render('
                                                <div style="display: flex; flex-direction: column; gap: 12px;">
                                                    @forelse(\Spatie\Activitylog\Models\Activity::where("causer_id", $record->id)->latest()->take(15)->get() as $log)
                                                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-radius: 12px; border: 1px solid #f3f4f6; background-color: #f9fafb;">
                                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                                <div style="width: 32px; height: 32px; border-radius: 10px; background-color: @if(str_contains($log->description, "created")) #ecfdf5 @elseif(str_contains($log->description, "deleted")) #fef2f2 @else #fff7ed @endif; display: flex; align-items: center; justify-content: center;">
                                                                    @php
                                                                        $icon = match(class_basename($log->subject_type)) {
                                                                            "Project" => "🏗️", "Inquiry" => "📧", "News" => "📰", "Award" => "🏆", "User" => "👤", default => "⚙️",
                                                                        };
                                                                    @endphp
                                                                    <span style="font-size: 16px;">{{ $icon }}</span>
                                                                </div>
                                                                <div>
                                                                    <div style="font-size: 14px; font-weight: 700; color: #111827; text-transform: capitalize;">{{ $log->description }}</div>
                                                                    <div style="font-size: 12px; color: #6b7280;">{{ class_basename($log->subject_type) }}</div>
                                                                </div>
                                                            </div>
                                                            <div style="font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em;">{{ $log->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    @empty
                                                        <div style="text-center; padding: 32px 0; color: #9ca3af; font-style: italic; font-size: 14px;">No recent activity found for this administrator.</div>
                                                    @endforelse
                                                </div>
                                            ', ['record' => $record])) : 'N/A'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->extraAttributes(['style' => 'max-width: none !important; width: 100% !important;'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatar')
                    ->label('')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->extraImgAttributes(['style' => 'min-width: 40px; min-height: 40px; max-width: 40px; max-height: 40px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);']),

                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => UserResource\Pages\ListUsers::route('/'),
            'create' => UserResource\Pages\CreateUser::route('/create'),
            'edit' => UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
