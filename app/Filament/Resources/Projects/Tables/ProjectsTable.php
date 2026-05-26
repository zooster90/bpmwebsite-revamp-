<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Enums\Alignment; 

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;

/**
 * ============================================================
 * Classic & Clean Projects Table — Strict Uniform Alignment
 * ============================================================
 * 强制所有图片尺寸绝对统一，所有列严格对齐。
 */
class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Eager-load media so the photo-count column doesn't fire a query per row.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with('media'))
            ->columns([
                // 1. 照片列 - 强制固定尺寸，统一长方形
                \Filament\Tables\Columns\ImageColumn::make('display_image')
                    ->label('Photo')
                    ->alignment(Alignment::Center)
                    ->extraImgAttributes([
                        // 🌟 终极修复：强制绝对大小为 96x64，使用 object-fit: cover 自动完美裁剪，绝不拉伸变形！
                        'style' => 'min-width: 96px; min-height: 64px; max-width: 96px; max-height: 64px; object-fit: cover; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);'
                    ])
                    ->grow(false),

                // 2. 项目名称
                TextColumn::make('name')
                    ->label('Project Name')
                    ->weight('bold')
                    ->size('lg')
                    ->searchable()
                    ->description(fn (Project $record): string => $record->client ?: 'Direct Client')
                    ->wrap()
                    ->grow(),

                // 2b. 照片数量徽章 (cover + gallery)
                TextColumn::make('photo_count')
                    ->label('Photos')
                    ->alignment(Alignment::Center)
                    ->state(fn ($record) => $record->getMedia('cover_image')->count() + $record->getMedia('gallery')->count())
                    ->badge()
                    ->icon('heroicon-o-photo')
                    ->color(fn (int $state) => match (true) {
                        $state === 0 => 'danger',
                        $state <= 3  => 'warning',
                        default      => 'success',
                    })
                    ->tooltip(fn ($record) => 'Cover: ' . $record->getMedia('cover_image')->count() . ' · Gallery: ' . $record->getMedia('gallery')->count())
                    ->formatStateUsing(fn (int $state) => $state === 0 ? 'None' : $state . ($state === 1 ? ' photo' : ' photos')), 

                // 3. 奖项列
                TextColumn::make('award')
                    ->label('Awards')
                    ->icon('heroicon-o-trophy')
                    ->color('warning') 
                    ->searchable()
                    ->placeholder('—')
                    ->width('180px'),

                // 4. 状态列
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'ongoing'     => 'warning',
                        'completed'   => 'success',
                        'coming soon' => 'info',
                        default       => 'gray',
                    })
                    ->width('110px'),

                // 5. 年份列
                TextColumn::make('year')
                    ->label('Year')
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->color('gray')
                    ->width('80px'),

                // 6. 前台显示开关
                ToggleColumn::make('is_published')
                    ->label('Live')
                    ->alignment(Alignment::Center),
            ])
            ->defaultSort('year', 'desc')
            ->defaultGroup(
                \Filament\Tables\Grouping\Group::make('year')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
                    ->orderQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query, string $direction) => $query->orderBy('year', 'desc'))
            )
            ->striped()
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Ongoing'     => 'Ongoing',
                        'Completed'   => 'Completed',
                        'Coming Soon' => 'Coming Soon',
                    ]),
                SelectFilter::make('year')
                    ->options(function () {
                        return Project::query()
                            ->whereNotNull('year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),

                ActionGroup::make([
                    DeleteAction::make()
                        ->label('Delete')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->color('danger'),
                ])
                    ->label('More')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->size(\Filament\Support\Enums\Size::Small)
                    ->button(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Projects Found')
            ->emptyStateIcon('heroicon-o-building-office-2')
            ->deferFilters(false);
    }
}