<?php

namespace App\Filament\Resources\Awards;

use App\Filament\Resources\Awards\Pages\CreateAward;
use App\Filament\Resources\Awards\Pages\EditAward;
use App\Filament\Resources\Awards\Pages\ListAwards;
use App\Filament\Resources\Awards\Schemas\AwardForm;
use App\Filament\Resources\Awards\Tables\AwardsTable;
use App\Models\Award;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AwardResource extends Resource
{
    use \App\Filament\Concerns\RoleBasedAccess;

    protected static ?string $model = Award::class;

    protected static ?string $navigationLabel = 'Awards & Honours';
    protected static string | \UnitEnum | null $navigationGroup = '🏆 Recognition';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';
    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Award';
    protected static ?string $pluralModelLabel = 'Awards & Honours';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AwardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AwardsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAwards::route('/'),
            'create' => CreateAward::route('/create'),
            'edit'   => EditAward::route('/{record}/edit'),
        ];
    }
}
