<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use App\Models\JobApplication;
use App\Models\Project;
use Filament\Widgets\Widget;

class NeedsAttentionWidget extends Widget
{
    protected string $view = 'filament.widgets.needs-attention';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public function getItems(): array
    {
        $unreadInquiries     = Inquiry::where('status', 'New')->whereNull('archived_at')->count();
        $pendingApplications = JobApplication::where('status', 'new')->count();
        $unpublishedProjects = Project::where('is_published', false)->count();

        return [
            [
                'label'   => 'Unread enquiries',
                'count'   => $unreadInquiries,
                'icon'    => 'heroicon-o-inbox-arrow-down',
                'colour'  => 'amber',
                'url'     => '/admin/inquiries?tableFilters[status][value]=New',
                'cta'     => 'Review',
            ],
            [
                'label'   => 'New job applications',
                'count'   => $pendingApplications,
                'icon'    => 'heroicon-o-user-plus',
                'colour'  => 'sky',
                'url'     => '/admin/job-applications?tableFilters[status][value]=new',
                'cta'     => 'Review',
            ],
            [
                'label'   => 'Unpublished projects',
                'count'   => $unpublishedProjects,
                'icon'    => 'heroicon-o-eye-slash',
                'colour'  => 'rose',
                'url'     => '/admin/projects?tableFilters[is_published][value]=0',
                'cta'     => 'Publish',
            ],
        ];
    }
}
