<?php

namespace App\Filament\Resources\OurPeople;

use App\Filament\Resources\OurPeople\Pages\CreateOurPeople;
use App\Filament\Resources\OurPeople\Pages\EditOurPeople;
use App\Filament\Resources\OurPeople\Pages\ListOurPeople;
use App\Filament\Resources\OurPeople\Schemas\OurPeopleForm;
use App\Filament\Resources\OurPeople\Tables\OurPeopleTable;
use App\Models\OurPeople;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OurPeopleResource extends Resource
{
    use \App\Filament\Concerns\RoleBasedAccess;

    protected static ?string $model = OurPeople::class;

    protected static ?string $navigationLabel = 'Leadership Team';
    protected static string | \UnitEnum | null $navigationGroup = '🏢 About Us';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Team Member';
    protected static ?string $pluralModelLabel = 'Leadership Team';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return OurPeopleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OurPeopleTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOurPeople::route('/'),
            'create' => CreateOurPeople::route('/create'),
            'edit' => EditOurPeople::route('/{record}/edit'),
        ];
    }
}
