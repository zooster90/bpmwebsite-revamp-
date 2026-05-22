<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Filters\SelectFilter;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-finger-print';
    protected static ?string $navigationLabel = 'Activity Audit Trail';
    protected static string | \UnitEnum | null $navigationGroup = '⚙️ Settings & System';
    protected static ?int $navigationSort = 10000;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime()
                    ->sortable(),
                
                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->placeholder('System'),

                TextColumn::make('description')
                    ->label('Action')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'created') => 'success',
                        str_contains($state, 'updated') => 'warning',
                        str_contains($state, 'deleted') => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('subject_type')
                    ->label('Resource')
                    ->formatStateUsing(fn ($state) => str_replace('App\\Models\\', '', $state))
                    ->searchable(),

                TextColumn::make('properties')
                    ->label('Changes')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('subject_type')
                    ->label('Resource Type')
                    ->options([
                        'App\\Models\\Project' => 'Projects',
                        'App\\Models\\News' => 'News',
                        'App\\Models\\Inquiry' => 'Inquiries',
                        'App\\Models\\JobOpening' => 'Job Openings',
                        'App\\Models\\JobApplication' => 'Job Applications',
                        'App\\Models\\Award' => 'Awards',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ActivityLogResource\Pages\ListActivityLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
