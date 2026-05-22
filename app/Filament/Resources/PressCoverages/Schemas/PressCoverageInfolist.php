<?php

namespace App\Filament\Resources\PressCoverages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PressCoverageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('headline'),
                TextEntry::make('publication')
                    ->placeholder('-'),
                TextEntry::make('published_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('external_url')
                    ->placeholder('-'),
                TextEntry::make('excerpt')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
