<?php

namespace App\Filament\Resources\CultureEvents\Tables;

use App\Models\Category;
use App\Models\CultureEvent;
use Filament\Actions\ActionGroup;
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
            // Eager-load media so the photo-count column doesn't fire a query
            // per row. One query for all rows instead of N.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with('media'))
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

                // ── Photo Count Badge (cover + gallery) ───────────────
                TextColumn::make('photo_count')
                    ->label('Photos')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->state(function ($record) {
                        $cover   = $record->getMedia('culture_image')->count();
                        $gallery = $record->getMedia('gallery')->count();
                        return $cover + $gallery;
                    })
                    ->badge()
                    ->icon('heroicon-o-photo')
                    ->color(fn (int $state) => match (true) {
                        $state === 0   => 'danger',
                        $state <= 3    => 'warning',
                        default        => 'success',
                    })
                    ->tooltip(function ($record) {
                        $cover   = $record->getMedia('culture_image')->count();
                        $gallery = $record->getMedia('gallery')->count();
                        return "Cover: {$cover} · Gallery: {$gallery}";
                    })
                    ->formatStateUsing(fn (int $state) => $state === 0 ? 'No photos' : ($state . ' ' . ($state === 1 ? 'photo' : 'photos'))),

                // ── Video Indicator ────────────────────────────────────
                TextColumn::make('video_status')
                    ->label('Video')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->state(function ($record) {
                        if (! empty($record->video_upload)) return 'file';
                        if (! empty($record->video_url))    return 'link';
                        return 'none';
                    })
                    ->badge()
                    ->icon(fn (string $state) => match ($state) {
                        'file' => 'heroicon-o-film',
                        'link' => 'heroicon-o-link',
                        default => 'heroicon-o-minus-circle',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'file' => 'success',
                        'link' => 'info',
                        default => 'gray',
                    })
                    ->tooltip(fn ($record) => match (true) {
                        ! empty($record->video_upload) => 'Uploaded MP4/WebM file',
                        ! empty($record->video_url)    => 'External video: ' . $record->video_url,
                        default                        => 'No video attached',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'file' => 'Uploaded',
                        'link' => 'Linked',
                        default => 'None',
                    }),

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

                // ── Location ───────────────────────────────────────────
                // Surfaced as a quick column + searchable so admins can spot
                // records that still have no location set (they fall back
                // to "Penang, Malaysia" on the public site, which boss
                // flagged as misleading for trips abroad).
                TextColumn::make('location')
                    ->label('Location')
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('warning')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(40)
                    ->placeholder('— No location set —')
                    ->toggleable(),

                // ── Publish status — interactive ToggleColumn ──────────
                // Was an IconColumn (read-only) which forced admins into the
                // Edit page to flip a single switch. Boss flagged that
                // records existed but didnt appear on the public site,
                // and the icon-only column made it non-obvious that the
                // record was a draft. ToggleColumn lets admins flip the
                // state directly from the list view — one click per row.
                // The trait/policy still gates: only Editor / Super Admin
                // can mutate; Viewers see the toggle but it stays disabled.
                \Filament\Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Live')
                    ->alignment(\Filament\Support\Enums\Alignment::Center)
                    ->disabled(fn () => ! (auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false))
                    ->tooltip(fn ($record) => $record->is_published ? 'Visible on public Culture page — click to unpublish' : 'Draft — hidden from website. Click to publish.')
                    ->sortable(),

                // ── Intern Type badge (Site vs Office) ─────────────────
                // Shown by default so editors can see at a glance which
                // intern records are categorised and which still need a
                // type picked. Records with NULL show as "Highlight".
                TextColumn::make('intern_type')
                    ->label('Intern Type')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'site'   => 'Site',
                        'office' => 'Office',
                        default  => 'Highlight',
                    })
                    ->icon(fn (?string $state) => match ($state) {
                        'site'   => 'heroicon-o-wrench-screwdriver',
                        'office' => 'heroicon-o-building-office',
                        default  => 'heroicon-o-camera',
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'site'   => 'warning',
                        'office' => 'info',
                        default  => 'gray',
                    })
                    ->tooltip(fn ($record) => $record->intern_type
                        ? 'Counted in Total Interns for ' . ($record->year ?? 'this cohort')
                        : 'Cohort highlight / group photo — NOT counted as an intern')
                    ->visible(fn ($livewire) => true),

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

                // ── Intern Type filter (site / office / uncategorised) ──
                SelectFilter::make('intern_type')
                    ->label('Intern Type')
                    ->placeholder('All Records')
                    ->options([
                        'site'   => 'Site Interns Only',
                        'office' => 'Office Interns Only',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data) {
                        if (! filled($data['value'] ?? null)) return $query;
                        return $query->where('intern_type', $data['value']);
                    }),

                // ── Publish status filter ──────────────────────────────
                \Filament\Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publish status')
                    ->placeholder('All')
                    ->trueLabel('Live on website')
                    ->falseLabel('Draft (hidden)'),
            ], layout: FiltersLayout::AboveContent)

            // ══════════════════════════════════════════════════════════
            //  ROW ACTIONS — Consolidated into a single dropdown so the
            //  table breathes; Edit stays as a quick standalone button
            //  because it is the most-used action.
            // ══════════════════════════════════════════════════════════
            ->actions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),

                ActionGroup::make([
                    ViewAction::make()
                        ->label('View Details')
                        ->icon('heroicon-o-eye')
                        ->color('gray'),

                    DeleteAction::make()
                        ->label('Delete')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete this Activity Record?')
                        ->modalDescription('This will permanently delete the record AND all uploaded photos attached to it. This cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete permanently')
                        ->color('danger'),
                ])
                    ->label('More')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->size(\Filament\Support\Enums\Size::Small)
                    ->button(),
            ])

            // ── Table-level "Publish All Drafts" shortcut ──────────────
            // Sits above the rows so admins don't need to select records
            // one by one when they just want every hidden record live.
            // The action runs a single UPDATE for safety + speed; only
            // touches records that are currently is_published = false so
            // it's effectively a no-op when there's nothing to publish.
            ->headerActions([
                \Filament\Actions\Action::make('publishAllDrafts')
                    ->label(fn () => 'Publish All Drafts (' . \App\Models\CultureEvent::where('is_published', false)->count() . ')')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn () => (auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false)
                        && \App\Models\CultureEvent::where('is_published', false)->exists())
                    ->requiresConfirmation()
                    ->modalHeading('Publish every draft activity?')
                    ->modalDescription('This will flip every Staff Activities & Events record where Live is currently OFF to ON, making them appear on the public website. You can still unpublish individual records afterwards.')
                    ->modalSubmitActionLabel('Yes, publish all drafts')
                    ->action(function () {
                        $count = \App\Models\CultureEvent::where('is_published', false)->update(['is_published' => true]);
                        \Filament\Notifications\Notification::make()
                            ->title("Published {$count} record" . ($count === 1 ? '' : 's'))
                            ->body('They are now live on the public Culture page.')
                            ->success()
                            ->send();
                    }),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('publish')
                        ->label('Publish (show on website)')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn () => auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false)
                        ->requiresConfirmation()
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_published' => true]))
                        ->deselectRecordsAfterCompletion(),

                    \Filament\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish (hide from website)')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->visible(fn () => auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false)
                        ->requiresConfirmation()
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_published' => false]))
                        ->deselectRecordsAfterCompletion(),

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
