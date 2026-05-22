<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action as TableAction;
use Filament\Widgets\TableWidget as BaseWidget;

/**
 * ============================================================
 *  BUILTECH LATEST ENQUIRIES WIDGET — v3.0
 *  Premium table widget with avatar initials, urgency ring,
 *  copyable email/phone, status badge, and read action.
 * ============================================================
 */
class LatestInquiries extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Latest Enquiries from the Website';

    protected static ?string $maxHeight = '480px';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inquiry::query()->latest()->limit(10)
            )
            ->columns([

                // ── Received On ─────────────────────────────────
                TextColumn::make('created_at')
                    ->label('Received On')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->size('sm')
                    ->color('gray'),

                // ── Customer Name ──────────────────────────────────
                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->weight('bold')
                    ->size('sm'),

                // ── Email ───────────────────────────────────────
                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->icon('heroicon-m-envelope')
                    ->size('sm')
                    ->color('primary'),

                // ── Phone (if exists) ───────────────────────────
                TextColumn::make('phone')
                    ->label('Phone')
                    ->placeholder('—')
                    ->copyable()
                    ->copyMessage('Phone copied!')
                    ->icon('heroicon-m-phone')
                    ->size('sm')
                    ->toggleable(),

                // ── Subject ─────────────────────────────────────
                TextColumn::make('subject')
                    ->label('Subject')
                    ->limit(45)
                    ->placeholder('No subject')
                    ->tooltip(fn(Inquiry $r) => $r->subject ?? null)
                    ->size('sm'),

                // ── Status Badge ─────────────────────────────────
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match(strtolower($state)) {
                        'new'         => 'New',
                        'in-progress',
                        'in_progress' => 'In Progress',
                        'resolved'    => 'Resolved',
                        default       => ucfirst($state),
                    })
                    ->color(fn(string $state): string => match(strtolower($state)) {
                        'new'                        => 'danger',
                        'in-progress', 'in_progress' => 'info',
                        'resolved'                   => 'success',
                        default                      => 'gray',
                    })
                    ->icon(fn(string $state): string => match(strtolower($state)) {
                        'new'                        => 'heroicon-m-bell-alert',
                        'in-progress', 'in_progress' => 'heroicon-m-arrow-path',
                        'resolved'                   => 'heroicon-m-check-circle',
                        default                      => 'heroicon-m-question-mark-circle',
                    })
                    ->size('sm'),
            ])
            ->actions([
                TableAction::make('view')
                    ->label('Open')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Inquiry $record) => route('filament.admin.resources.inquiries.edit', $record))
                    ->color('primary')
                    ->size('sm'),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No enquiries yet')
            ->emptyStateDescription('New website inquiries will appear here automatically.')
            ->emptyStateIcon('heroicon-o-inbox');
    }
}
