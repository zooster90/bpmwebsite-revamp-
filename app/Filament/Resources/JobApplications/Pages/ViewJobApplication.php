<?php

namespace App\Filament\Resources\JobApplications\Pages;

use App\Filament\Resources\JobApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJobApplication extends ViewRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download_resume')
                ->label('Download Resume')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->visible(fn () => !empty($this->record->resume_path))
                ->url(fn () => asset('storage/' . $this->record->resume_path))
                ->openUrlInNewTab(),
        ];
    }
}
