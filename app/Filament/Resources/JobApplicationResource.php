<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplications\Schemas\JobApplicationForm;
use App\Models\JobApplication;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static \UnitEnum|string|null $navigationGroup = '💼 Careers';
    protected static ?string $navigationLabel = 'Job Applications';
    protected static ?int $navigationSort = 20;

    // Red badge on sidebar for unread new applications
    public static function getNavigationBadge(): ?string
    {
        $count = JobApplication::where('status', 'new')->where('is_read', false)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return JobApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Applied')
                    ->dateTime('d M Y, g:i A')
                    ->sortable()
                    ->since(),

                TextColumn::make('name')
                    ->label('Applicant')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('position')
                    ->label('Position Applied')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->placeholder('—'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger'  => 'new',
                        'warning' => 'reviewed',
                        'info'    => 'interview',
                        'success' => 'shortlisted',
                        'gray'    => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state) => ucfirst($state)),

                TextColumn::make('interview_date')
                    ->label('Interview')
                    ->dateTime('d M Y, g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('—'),

                Tables\Columns\IconColumn::make('resume_path')
                    ->label('Resume')
                    ->boolean()
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'         => 'New',
                        'reviewed'    => 'Reviewed',
                        'interview'   => 'Interview Scheduled',
                        'shortlisted' => 'Shortlisted',
                        'rejected'    => 'Rejected',
                    ]),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (JobApplication $record) => static::getUrl('view', ['record' => $record])),

                Action::make('arrange_interview')
                    ->label('Interview')
                    ->icon('heroicon-o-calendar-days')
                    ->color('info')
                    ->visible(fn (JobApplication $record) => !in_array($record->status, ['rejected', 'shortlisted']))
                    ->form([
                        \Filament\Forms\Components\DateTimePicker::make('interview_date')
                            ->label('Interview Date & Time')
                            ->required()
                            ->minDate(now()),
                    ])
                    ->action(function (JobApplication $record, array $data) {
                        $record->update([
                            'status' => 'interview',
                            'interview_date' => $data['interview_date'],
                            'is_read' => true
                        ]);
                        Notification::make()->title('Interview arranged!')->success()->send();
                    }),

                Action::make('shortlist')
                    ->label('Shortlist')
                    ->icon('heroicon-o-star')
                    ->color('success')
                    ->visible(fn (JobApplication $record) => $record->status !== 'shortlisted')
                    ->action(function (JobApplication $record) {
                        $record->update(['status' => 'shortlisted', 'is_read' => true]);
                        Notification::make()->title('Applicant shortlisted!')->success()->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (JobApplication $record) => $record->status !== 'rejected')
                    ->requiresConfirmation()
                    ->action(function (JobApplication $record) {
                        $record->update(['status' => 'rejected', 'is_read' => true]);
                        Notification::make()->title('Application rejected.')->warning()->send();
                    }),

                Action::make('download_resume')
                    ->label('Resume')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->visible(fn (JobApplication $record) => !empty($record->resume_path))
                    ->url(fn (JobApplication $record) => asset('storage/' . $record->resume_path))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordAction(fn (JobApplication $record) => tap(null, fn () => $record->update(['is_read' => true])));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\JobApplications\Pages\ListJobApplications::route('/'),
            'view'  => \App\Filament\Resources\JobApplications\Pages\ViewJobApplication::route('/{record}'),
        ];
    }
}
