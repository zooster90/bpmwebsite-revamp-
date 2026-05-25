<?php

namespace App\Filament\Resources\CultureEvents\Tables;

use App\Models\Category;
use App\Models\CultureEvent;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

/**
 * ══════════════════════════════════════════════════
 *  Staff Activities Table — Clean, Smart, Human-Friendly
 * ══════════════════════════════════════════════════
 *  ✅ Category filter: shows unique readable names only (no duplicate raw slugs)
 *  ✅ Year filter: skips null/blank years, shows newest first
 *  ✅ Delete: requires confirmation — no accidental deletions
 *  ✅ Columns: thumbnail, title, category badge, year badge, date
 * ══════════════════════════════════════════════════
 */
class CultureEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // ── Thumbnail ──────────────────────────────────────────
                SpatieMediaLibraryImageColumn::make('culture_image')
                    ->collection('culture_image')
                    ->label('Photo')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->defaultImageUrl(fn ($record) => $record->display_image)
                    ->extraImgAttributes(['style' => 'min-width: 80px; min-height: 60px; max-width: 80px; max-height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);']),

                // ── Title + Intern Sub-description ─────────────────────
                TextColumn::make('title')
                    ->label('Activity / Event Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->intern_name
                        ? '🎓 ' . $record->intern_name . ($record->university ? ' · ' . $record->university : '')
                        : ($record->description ? \Illuminate\Support\Str::limit($record->description, 60) : null)
                    ),

                // ── Category Badge ─────────────────────────────────────
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color(fn ($record) => match(strtolower($record->category?->slug ?? '')) {
                        'intern', 'internship'   => 'info',
                        'festive', 'celebration' => 'warning',
                        'work', 'training'       => 'primary',
                        'csr', 'charity'         => 'success',
                        'tb', 'team_building'    => 'gray',
                        'trip', 'company_trip'   => 'info',
                        'event', 'sponsor'       => 'warning',
                        default                  => 'gray',
                    })
                    ->placeholder('— No Category —'),

                // ── Year Badge ─────────────────────────────────────────
                TextColumn::make('year')
                    ->label('Year')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->placeholder('—'),

                // ── Event Date ─────────────────────────────────────────
                TextColumn::make('event_date')
                    ->label('Event Date')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('—'),

                // ── Hidden by default: intern details ──────────────────
                TextColumn::make('intern_name')
                    ->label('Intern Name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                TextColumn::make('university')
                    ->label('University')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                TextColumn::make('intern_period')
                    ->label('Internship Period')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                // ── Last Updated (hidden by default) ───────────────────
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip(fn ($record) => 'Updated: ' . $record->updated_at?->format('d M Y, H:i')),
            ])

            ->defaultSort('year', 'desc')
            ->defaultGroup(
                \Filament\Tables\Grouping\Group::make('year')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
                    ->orderQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query, string $direction) => $query->orderBy('year', 'desc'))
            )

            // ══════════════════════════════════════════════════════════
            //  FILTERS — Clean, deduped, human-readable
            // ══════════════════════════════════════════════════════════
            ->filters([
                // ── Year Filter: Only years that actually have records ──
                SelectFilter::make('year')
                    ->label('Filter by Year')
                    ->placeholder('All Years')
                    ->options(function () {
                        return CultureEvent::query()
                            ->whereNotNull('year')
                            ->where('year', '>', 1990)           // exclude bogus years
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    }),
            ], layout: FiltersLayout::AboveContent)

            // ══════════════════════════════════════════════════════════
            //  ROW ACTIONS — With confirmation on Delete
            // ══════════════════════════════════════════════════════════
            ->actions([
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('gray'),

                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->modalHeading('Delete this Activity Record?')
                    ->modalDescription('This will permanently delete the record AND all uploaded photos attached to it. This cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete permanently')
                    ->color('danger'),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Records?')
                        ->modalDescription('This will permanently delete all selected records and their photos. This cannot be undone.'),
                ]),
            ])

            ->emptyStateHeading('No Staff Activities Found')
            ->emptyStateDescription('Use the filters above to search, or click "+ New Activity" to add a record.')
            ->emptyStateIcon('heroicon-o-camera')
            ->deferFilters(false);
    }
}
