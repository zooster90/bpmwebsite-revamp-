<?php

namespace App\Filament\Resources\PressCoverages;

use App\Filament\Resources\PressCoverages\Pages\CreatePressCoverage;
use App\Filament\Resources\PressCoverages\Pages\EditPressCoverage;
use App\Filament\Resources\PressCoverages\Pages\ListPressCoverages;
use App\Filament\Resources\PressCoverages\Schemas\PressCoverageForm;
use App\Filament\Resources\PressCoverages\Tables\PressCoveragesTable;
use App\Models\PressCoverage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PressCoverageResource extends Resource
{
    use \App\Filament\Concerns\RoleBasedAccess;

    protected static ?string $model = PressCoverage::class;

    protected static ?string $navigationLabel = 'Press & Media';
    protected static string | \UnitEnum | null $navigationGroup = '🏆 Recognition';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 20;

    protected static ?string $modelLabel = 'Press Coverage';
    protected static ?string $pluralModelLabel = 'Press & Media';
    protected static ?string $recordTitleAttribute = 'headline';

    public static function form(Schema $schema): Schema
    {
        return PressCoverageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PressCoveragesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPressCoverages::route('/'),
            'create' => CreatePressCoverage::route('/create'),
            'edit'   => EditPressCoverage::route('/{record}/edit'),
        ];
    }
}
