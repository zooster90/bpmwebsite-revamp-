<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

/**
 * ╔══════════════════════════════════════════════════════════════════════╗
 * ║   ProjectController — Redesigned                                     ║
 * ║   ─────────────────────────────────────────────────────────────────  ║
 * ║   Main page  → 6 per status section + flagship strip                ║
 * ║   Sub-pages  → /projects?status=completed (paginated full list)     ║
 * ║   Order      → Completed → Ongoing → Coming Soon                    ║
 * ╚══════════════════════════════════════════════════════════════════════╝
 */
class ProjectController extends Controller
{
    /**
     * Normalize raw DB status values to our 3 canonical keys.
     */
    protected function normalizeStatus(?string $s): string
    {
        $s = strtolower(trim($s ?? 'completed'));
        if (in_array($s, ['active', 'ongoing', 'in progress', 'started'])) return 'ongoing';
        if (in_array($s, ['pending', 'upcoming', 'soon', 'coming soon']))   return 'coming soon';
        return 'completed';
    }

    /**
     * Return categories in the same order as builtech.com.my Track Records,
     * only including those that have at least one published project.
     */
    protected function getOrderedCategories(): \Illuminate\Support\Collection
    {
        // Canonical order matching the official website sidebar
        $officialOrder = [
            'High Rise',
            'Hospital',
            'Hotel',
            'Factory (Industrial Building Works)',
            'Terrace, Semi-D & Bungalow',
            'Commercial Building',
            'Maintenance',
            'Civil & Infrastructural Works',
            'Government Building',
            'School',
            'Sewerage Treatment Plant',
            'Pipes Laying & Sewer Line',
            'Interior Design, Furniture & Renovation Works',
            'Landscaping Works',
            'Pumping Station',
            'Mechanical & Electrical Works',
        ];

        // Only show categories that actually have published projects
        $withProjects = \App\Models\Category::where('model_type', 'Project')
            ->whereHas('projects', fn($q) => $q->where('is_published', true))
            ->pluck('name')
            ->toArray();

        // Return in official order, filtered to those with projects
        return collect($officialOrder)->filter(fn($name) => in_array($name, $withProjects))->values();
    }



    public function index(Request $request)
    {
        $category      = $request->query('category');
        $status        = $request->query('status');
        $search        = $request->query('search');
        $hasFilters    = ! empty($category) || ! empty($status) || ! empty($search);

        // ── Base query ─────────────────────────────────────────
        // Eager-load media so card thumbnails don't fire one query per project.
        $query = Project::where('is_published', true)->with(['media', 'category']);

        if ($category && $category !== 'all') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        if ($status && $status !== 'all') {
            // Match against multiple synonyms
            $statusMap = [
                'completed'    => ['Completed', 'completed'],
                'ongoing'      => ['Ongoing', 'ongoing', 'Active', 'active', 'In Progress'],
                'coming-soon'  => ['Coming Soon', 'coming soon', 'Pending', 'Upcoming'],
                'coming soon'  => ['Coming Soon', 'coming soon', 'Pending', 'Upcoming'],
            ];
            $synonyms = $statusMap[strtolower($status)] ?? [$status];
            $query->whereIn('status', $synonyms);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%");
            });
        }

        // ── If a CATEGORY filter is active → full paginated sub-page ─
        if ($category && $category !== 'all') {
            $projects = $query->orderBy('year', 'desc')
                              ->orderBy('sort_order', 'asc')
                              ->orderBy('name', 'asc')
                              ->paginate(12)
                              ->withQueryString();

            $categories = $this->getOrderedCategories();

            return view('projects', compact('projects', 'categories'))
                ->with([
                    'activeStatus'     => $status ?? '',
                    'activeCategory'   => $category,
                    'activeSearch'     => $search ?? '',
                    'isSubPage'        => true,
                    'flagshipProjects'  => collect(),
                    'groupedProjects'   => collect(),
                    'statusCounts'      => $this->getStatusCounts(),
                ]);
        }

        // ── If a status filter is active → full paginated sub-page ─
        if ($status && $status !== 'all') {
            $projects = $query->orderBy('year', 'desc')
                              ->orderBy('sort_order', 'asc')
                              ->orderBy('name', 'asc')
                              ->paginate(12)
                              ->withQueryString();

            $categories = $this->getOrderedCategories();

            return view('projects', compact('projects', 'categories'))
                ->with([
                    'activeStatus'   => $status,
                    'activeCategory' => $category ?? '',
                    'activeSearch'   => $search ?? '',
                    'isSubPage'      => true,
                    'flagshipProjects' => collect(),
                    'groupedProjects'  => collect(),
                    'statusCounts'     => $this->getStatusCounts(),
                ]);
        }

        // ── Main page → fetch ALL published, group by status ───
        $allProjects = Project::where('is_published', true)
            ->with(['media', 'category'])
            ->when($search, fn($q) => $q->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            }))
            ->orderBy('year', 'desc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Group into our 3 canonical status buckets
        $groupedProjects = $allProjects->groupBy(fn($p) => $this->normalizeStatus($p->status));

        // Flagship strip: is_flagship=true, fallback to top 3 Completed
        $flagshipProjects = Project::where('is_published', true)
            ->where('is_flagship', true)
            ->with(['media', 'category'])
            ->orderBy('year', 'desc')
            ->take(6)
            ->get();

        if ($flagshipProjects->isEmpty()) {
            $flagshipProjects = Project::where('is_published', true)
                ->whereIn('status', ['Completed', 'completed'])
                ->with(['media', 'category'])
                ->orderBy('year', 'desc')
                ->take(3)
                ->get();
        }

        // For pagination on main page — use a simple paginator for the count
        $projects = Project::where('is_published', true)->paginate(999)->withQueryString();

        $categories = $this->getOrderedCategories();

        return view('projects', compact('projects', 'categories'))
            ->with([
                'activeStatus'    => $status ?? '',
                'activeCategory'  => $category ?? '',
                'activeSearch'    => $search ?? '',
                'isSubPage'       => false,
                'flagshipProjects' => $flagshipProjects,
                'groupedProjects'  => $groupedProjects,
                'statusCounts'     => $this->getStatusCounts(),
            ]);
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->with(['media', 'category', 'awards.media'])
            ->firstOrFail();

        $relatedProjects = Project::where('is_published', true)
            ->whereHas('category', function ($q) use ($project) {
                if ($project->category_id) {
                    $q->where('id', $project->category_id);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->where('id', '!=', $project->id)
            ->with(['media', 'category'])
            ->orderBy('year', 'desc')
            ->take(3)
            ->get();

        // Resolve best available cover image for OG/social sharing
        $ogImage = null;
        if ($project->hasMedia('cover_image')) {
            $ogImage = $project->getFirstMediaUrl('cover_image');
        }
        if (!$ogImage && filter_var($project->image_url ?? '', FILTER_VALIDATE_URL)) {
            $ogImage = $project->image_url;
        }
        if (!$ogImage) {
            $ogImage = $project->display_image;
        }

        return view('project-detail', compact('project', 'relatedProjects', 'ogImage'));
    }

    /**
     * Get count per status for the stats panel.
     */
    protected function getStatusCounts(): array
    {
        $all = Project::where('is_published', true)->get();
        $counts = ['completed' => 0, 'ongoing' => 0, 'coming soon' => 0];
        foreach ($all as $p) {
            $key = $this->normalizeStatus($p->status);
            $counts[$key] = ($counts[$key] ?? 0) + 1;
        }
        return $counts;
    }
}