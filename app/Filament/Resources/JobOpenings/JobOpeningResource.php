<?php

namespace App\Filament\Resources\JobOpenings;

use App\Filament\Resources\JobOpenings\Pages\CreateJobOpening;
use App\Filament\Resources\JobOpenings\Pages\EditJobOpening;
use App\Filament\Resources\JobOpenings\Pages\ListJobOpenings;
use App\Filament\Resources\JobOpenings\Schemas\JobOpeningForm;
use App\Filament\Resources\JobOpenings\Tables\JobOpeningsTable;
use App\Models\JobOpening;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JobOpeningResource extends Resource
{
    use \App\Filament\Concerns\RoleBasedAccess;

    protected static ?string $model = JobOpening::class;

    protected static ?string $navigationLabel = 'Open Positions';
    protected static string | \UnitEnum | null $navigationGroup = '💼 Careers';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Open Position';
    protected static ?string $pluralModelLabel = 'Open Positions';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return JobOpeningForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobOpeningsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListJobOpenings::route('/'),
            'create' => CreateJobOpening::route('/create'),
            'edit'   => EditJobOpening::route('/{record}/edit'),
        ];
    }
}
