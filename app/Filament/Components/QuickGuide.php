<?php

namespace App\Filament\Components;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

/**
 * Reusable Quick Guide banner for Filament admin pages.
 * Renders a collapsible, gold-styled instruction panel at the top of any form.
 */
class QuickGuide
{
    /**
     * @param  string  $title   The guide title
     * @param  array   $steps   Array of ['icon' => '...', 'title' => '...', 'tip' => '...']
     * @param  string  $note    Optional warning/note message
     */
    public static function make(string $title, array $steps, string $note = ''): Section
    {
        $stepsHtml = '';
        foreach ($steps as $i => $step) {
            $num   = $i + 1;
            $icon  = $step['icon']  ?? '💡';
            $label = $step['title'] ?? '';
            $tip   = $step['tip']   ?? '';
            $stepsHtml .= <<<HTML
            <div style="display:flex;align-items:flex-start;gap:14px;padding:12px 16px;background:rgba(197,160,89,0.07);border-radius:10px;border:1px solid rgba(197,160,89,0.18);">
                <div style="min-width:32px;height:32px;background:#c5a059;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem;color:#fff;flex-shrink:0;">{$num}</div>
                <div>
                    <div style="font-weight:700;font-size:0.9rem;color:#292524;margin-bottom:2px;">{$icon} {$label}</div>
                    <div style="font-size:0.82rem;color:#78716c;line-height:1.5;">{$tip}</div>
                </div>
            </div>
            HTML;
        }

        $noteHtml = $note
            ? '<div style="margin-top:12px;padding:10px 14px;background:rgba(245,158,11,0.1);border-left:3px solid #f59e0b;border-radius:6px;font-size:0.82rem;color:#92400e;"><strong>⚠ Note:</strong> ' . e($note) . '</div>'
            : '';

        $html = <<<HTML
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;">
            {$stepsHtml}
        </div>
        {$noteHtml}
        HTML;

        return Section::make('📋 Quick Guide — ' . $title)
            ->description('Click to expand / collapse this guide anytime.')
            ->icon('heroicon-o-light-bulb')
            ->collapsible()
            ->collapsed()
            ->schema([
                Placeholder::make('_guide_content')
                    ->label('')
                    ->content(new HtmlString($html)),
            ]);
    }
}
