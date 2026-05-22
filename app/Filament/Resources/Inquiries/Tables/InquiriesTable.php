<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Models\Inquiry;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 * Inquiries Table — Reads like an email inbox.
 */
class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->since(),

                TextColumn::make('name')
                    ->label('From')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->placeholder('—'),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(35)
                    ->placeholder('No subject'),

                TextColumn::make('message')
                    ->label('Message Preview')
                    ->limit(50)
                    ->tooltip(fn (Inquiry $record) => $record->message),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'New'         => 'warning',
                        'In Progress' => 'info',
                        'Resolved'    => 'success',
                        'Archived'    => 'gray',
                        default       => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'New'         => 'New — Unread',
                        'In Progress' => 'In Progress',
                        'Resolved'    => 'Resolved',
                        'Archived'    => 'Archived',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->label('Read & Update'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Delete Selected'),
                ]),
            ])
            ->emptyStateHeading('No Enquiries Yet')
            ->emptyStateDescription('Enquiries from the Contact Us page will appear here.')
            ->emptyStateIcon('heroicon-o-envelope');
    }
}
