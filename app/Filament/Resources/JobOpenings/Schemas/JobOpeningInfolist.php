<?php

namespace App\Filament\Resources\JobOpenings\Schemas;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class JobOpeningInfolist
{
    /**
     * 配置详情页展示
     * 修复：同步了 Seeder 中的所有新字段，并优化了 UI 布局
     */
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // 顶部：核心信息区块
                Section::make('Basic Information')
                    ->description('General details about the job vacancy.')
                    ->schema([
                        Grid::make(3) // 设为三列布局
                            ->schema([
                                TextEntry::make('title')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('department')
                                    ->badge() // 部门以标签形式展示，更美观
                                    ->color('gray'),

                                TextEntry::make('type')
                                    ->badge()
                                    ->color('info'),
                                
                                TextEntry::make('location')
                                    ->icon('heroicon-o-map-pin'),

                                TextEntry::make('slug')
                                    ->color('gray')
                                    ->fontFamily('mono'),

                                TextEntry::make('sort_order')
                                    ->label('Priority Order')
                                    ->numeric(),
                            ]),
                    ])
                    ->collapsible(),

                // 中间：状态控制区块
                Section::make('Status & Visibility')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label('Display on Frontend?')
                                    ->boolean()
                                    ->helperText('If off, this position will not be seen by candidates.'),

                                // 即使你主要用 is_active，建议也保留这个作为内部状态记录
                                IconEntry::make('is_available')
                                    ->label('Available for Application?')
                                    ->boolean(),
                            ]),
                    ])
                    ->compact(),

                // 底部：详细内容区块
                Section::make('Job Content')
                    ->schema([
                        TextEntry::make('description')
                            ->html() // 必须开启 .html()，因为你的 Seeder 里存的是 HTML 标签
                            ->columnSpanFull()
                            ->prose(),

                        TextEntry::make('requirements')
                            ->html()
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder('No specific requirements listed.'),
                    ])
                    ->collapsible(),

                // 系统信息
                Section::make('System Logs')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->color('gray'),
                                TextEntry::make('updated_at')
                                    ->dateTime()
                                    ->color('gray'),
                            ]),
                    ])
                    ->compact()
                    ->collapsible(),
            ]);
    }
}