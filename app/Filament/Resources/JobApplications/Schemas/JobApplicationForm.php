<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Grid::make(12)
                ->columnSpanFull()
                ->schema([
                    \Filament\Schemas\Components\Group::make()->schema([
                        Section::make('Applicant Profile')->icon('heroicon-o-user')->columns(2)->schema([
                            TextInput::make('name')->label('Full Name')->disabled(),
                            TextInput::make('email')->label('Email Address')->disabled(),
                            TextInput::make('phone')->label('Phone Number')->disabled(),
                            TextInput::make('position')->label('Position Applied For')->disabled()->columnSpanFull(),
                            Textarea::make('cover_letter')->label('Cover Letter / Message')->disabled()->rows(6)->columnSpanFull(),
                        ]),
                    ])->columnSpan(['default' => 12, 'lg' => 8]),

                    \Filament\Schemas\Components\Group::make()->schema([
                        Section::make('Resume & Documents')->icon('heroicon-o-document-arrow-down')->schema([
                            \Filament\Forms\Components\Placeholder::make('resume_download')
                                ->label('')
                                ->content(function ($record) {
                                    if (!$record || !$record->resume_path) {
                                        return \Illuminate\Support\HtmlString('<div style="color:var(--bt-muted); font-style:italic;">No resume attached.</div>');
                                    }
                                    $url = cdn_rewrite(asset('storage/' . ltrim($record->resume_path, '/')));
                                    return new \Illuminate\Support\HtmlString('
                                        <a href="'.$url.'" target="_blank" style="
                                            display:flex; align-items:center; gap:12px; 
                                            padding:16px; background:var(--bt-gold); color:white; 
                                            border-radius:12px; text-decoration:none; font-weight:700;
                                            transition:all 0.2s ease; box-shadow: 0 4px 12px rgba(197, 160, 89, 0.3);
                                        " onmouseover="this.style.transform=\'translateY(-2px)\'" onmouseout="this.style.transform=\'none\'">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path></svg>
                                            Download Resume
                                        </a>
                                    ');
                                }),
                        ]),

                        Section::make('Management')->icon('heroicon-o-clipboard-document-check')->schema([
                            Select::make('status')->label('Application Status')->options([
                                'new'         => 'New',
                                'reviewed'    => 'Reviewed',
                                'interview'   => 'Interview Scheduled',
                                'shortlisted' => 'Shortlisted',
                                'rejected'    => 'Rejected',
                            ])->required(),
                            
                            \Filament\Forms\Components\DateTimePicker::make('interview_date')
                                ->label('Interview Schedule')
                                ->minDate(now())
                                ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('status') !== 'interview'),
                        ]),
                    ])->columnSpan(['default' => 12, 'lg' => 4]),
                ]),
        ]);
    }
}
