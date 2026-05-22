<?php

namespace App\Filament\Resources\CultureEvents\Pages;

use App\Filament\Resources\CultureEvents\CultureEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListCultureEvents extends ListRecords
{
    protected static string $resource = CultureEventResource::class;

    public function getSubheading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return new \Illuminate\Support\HtmlString('
            <div style="padding: 1.25rem; margin-bottom: 1.5rem; font-size: 0.875rem; color: #1e3a8a; border-radius: 12px; background-color: #eff6ff; border: 1px solid #bfdbfe; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);" role="alert">
                <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; margin-bottom: 0.5rem; font-size: 1rem; color: #1d4ed8;">
                    <svg style="width: 20px; height: 20px; color: #2563eb; flex-shrink: 0; display: inline-block; fill: currentColor;" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 12H9v-2h2v2zm0-4H9V7h2v3z"/></svg>
                    <span>💡 Admin Quick Start Guide &amp; Tutorial (For First-Time &amp; Senior Staff)</span>
                </div>
                <ul style="list-style-type: disc; list-style-position: inside; margin-left: 0.25rem; margin-top: 0.5rem; padding-left: 0; color: #1e40af; line-height: 1.6;">
                    <li style="margin-bottom: 0.375rem;"><strong>Creating Events:</strong> Click the <span style="text-decoration: underline; font-weight: 600;">New Staff Activity</span> button above. Fill in the Title, Category, and Date.</li>
                    <li style="margin-bottom: 0.375rem;"><strong>Full Date Format:</strong> Always select the exact Day, Month, and Year (DD/MM/YYYY) so it displays perfectly on the public frontend.</li>
                    <li style="margin-bottom: 0.375rem;"><strong>Internship Grouping:</strong> For <span style="font-weight: 600;">🎓 Internship</span> category, all interns with the SAME YEAR are automatically grouped together into one beautiful cohort page on the website! You do not need to create a combined entry.</li>
                    <li style="margin-bottom: 0px;"><strong>Review &amp; Edit:</strong> Click <span style="text-decoration: underline; font-weight: 600;">View Details</span> to inspect a record or <span style="text-decoration: underline; font-weight: 600;">Edit</span> to update photos and details. Changes appear live on the website instantly!</li>
                </ul>
            </div>
        ');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New Staff Activity'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all'     => Tab::make('All Events'),
            'festive' => Tab::make('🎊 Festive')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', ['festive', 'celebration', 'annual-dinner', 'cny', 'raya', 'mid-autumn', 'christmas', 'birthday', 'durian', 'dumpling', 'solstice']))),
            'tb'      => Tab::make('🧗 Team Building')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', ['tb', 'team_building', 'team-building', 'teambuilding']))),
            'work'    => Tab::make('🏗️ Training')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', ['work', 'training', 'site', 'safety', 'seminar', 'certification']))),
            'trip'    => Tab::make('✈️ Trips')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', ['trip', 'travel', 'company_trip', 'company-trip', 'local-trip', 'site-visit']))),
            'csr'     => Tab::make('🤝 CSR')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', ['csr', 'charity', 'community', 'environment', 'education-support']))),
            'event'   => Tab::make('📸 Events')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', ['event', 'sponsor', 'sponsorship', 'exhibition', 'conference', 'award']))),
            'intern'  => Tab::make('🎓 Internship')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('category', fn($q) => $q->whereIn('slug', ['intern', 'internship', 'industrial', 'practical', 'polytechnic', 'school-attachment']))),
        ];
    }
    public function mount(): void
    {
        parent::mount();
        session()->put('resources.' . static::$resource . '.index_url', request()->fullUrl());
    }
}