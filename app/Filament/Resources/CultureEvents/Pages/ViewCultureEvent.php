<?php

namespace App\Filament\Resources\CultureEvents\Pages;

use App\Filament\Resources\CultureEvents\CultureEventResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCultureEvent extends ViewRecord
{
    protected static string $resource = CultureEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->url(fn() => $this->getResource()::getUrl('index'))
                ->color('gray'),
            EditAction::make(),
        ];
    }
}
