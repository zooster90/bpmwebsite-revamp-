<?php

namespace App\Filament\Resources\CultureEvents;

use App\Filament\Resources\CultureEvents\Pages\CreateCultureEvent;
use App\Filament\Resources\CultureEvents\Pages\EditCultureEvent;
use App\Filament\Resources\CultureEvents\Pages\ListCultureEvents;
use App\Filament\Resources\CultureEvents\Pages\ViewCultureEvent;
use App\Filament\Resources\CultureEvents\Schemas\CultureEventForm;
use App\Filament\Resources\CultureEvents\Tables\CultureEventsTable;
use App\Models\CultureEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CultureEventResource extends Resource
{
    protected static ?string $model = CultureEvent::class;

    protected static ?string $navigationLabel = 'Staff Activities & Events';
    protected static string | \UnitEnum | null $navigationGroup = '👥 Staff Activities';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-camera';
    protected static ?int $navigationSort = 60;

    protected static ?string $modelLabel = 'Staff Activity';
    protected static ?string $pluralModelLabel = 'Staff Activities & Events';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CultureEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CultureEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCultureEvents::route('/'),
            'create' => CreateCultureEvent::route('/create'),
            'view'   => ViewCultureEvent::route('/{record}'),
            'edit'   => EditCultureEvent::route('/{record}/edit'),
        ];
    }
}
