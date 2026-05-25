<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PressCoverage; // ← YOUR EXACT MODEL NAME
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class PageController extends Controller
{
    /**
     * Homepage - Builtech Landing Page
     * 
     * Uses YOUR exact models:
     * - Project (with cover_image media collection)
     * - PressCoverage (with press_image media collection)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cacheDuration = Carbon::now()->addHours(6);

        // ========================================
        // 1. FEATURED / FLAGSHIP PROJECTS
        // ========================================
        $featuredProjects = Cache::remember('homepage.flagship_projects', $cacheDuration, function () {
            return Project::query()
                ->where('is_flagship', true)
                ->where('is_published', true)
                ->with(['media' => function ($query) {
                    $query->where('collection_name', 'cover_image');
                }])
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get()
                ->map(function ($project) {
                    return [
                        // Keep ALL original fields - NO DATA LOSS
                        'id'                  => $project->id,
                        'name'                => $project->name,
                        'slug'                => $project->slug,
                        'description'         => $project->description,
                        'client'              => $project->client,
                        'location'            => $project->location ?? 'Penang, Malaysia',
                        'category'            => $project->category?->name,
                        'status'              => $project->status,
                        'year'                => $project->year,
                        'is_flagship'         => $project->is_flagship,
                        'is_published'        => $project->is_published,
                        'sort_order'          => $project->sort_order,
                        'image_url'           => $project->image_url,
                        'contract_value'      => $project->contract_value,
                        'cover_image_upload'  => $project->cover_image_upload,
                        'gallery_uploads'     => $project->gallery_uploads,
                        
                        // Computed fields for frontend
                        'cover_image'         => $this->getProjectCoverImage($project),
                        'detail_page'         => route('projects.show', $project->slug),
                        'url'                 => url("/projects/{$project->slug}"),
                    ];
                });
        });

        // FALLBACK: If no flagships marked, get latest published projects
        if ($featuredProjects->count() === 0) {
            $featuredProjects = Cache::remember('homepage.latest_projects_fallback', $cacheDuration, function () {
                return Project::where('is_published', true)
                    ->with(['media' => fn($q) => $q->where('collection_name', 'cover_image')])
                    ->orderBy('sort_order', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get()
                    ->map(fn($p) => [
                        'id'              => $p->id,
                        'name'            => $p->name,
                        'slug'            => $p->slug,
                        'location'        => $p->location ?? 'Penang, Malaysia',
                        'category'        => $p->category?->name,
                        'status'          => $p->status,
                        'year'            => $p->year,
                        'is_flagship'     => $p->is_flagship ?? false,
                        'is_published'    => $p->is_published,
                        'image_url'       => $p->image_url,
                        'contract_value'  => $p->contract_value,
                        'client'          => $p->client,
                        'description'     => $p->description,
                        'cover_image'     => $this->getProjectCoverImage($p),
                        'detail_page'     => route('projects.show', $p->slug),
                        'url'             => url("/projects/{$p->slug}"),
                    ]);
            });
        }

        // ========================================
        // 2. PRESS COVERAGE / MEDIA RECOGNITION
        // Uses YOUR PressCoverage MODEL with press_image collection
        // ========================================
        $pressCoverage = Cache::remember('homepage.press_coverage', $cacheDuration, function () {
            return PressCoverage::query()
                ->with(['media' => function ($query) {
                    $query->where('collection_name', 'press_image');
                }])
                ->orderBy('published_date', 'desc')
                ->take(6)
                ->get()
                ->map(function ($coverage) {
                    return [
                        // ALL ORIGINAL FIELDS PRESERVED
                        'id'             => $coverage->id,
                        'headline'       => $coverage->headline,
                        'publication'    => $coverage->publication,
                        'published_date' => $coverage->published_date?->format('Y-m-d'),
                        'external_url'   => $coverage->external_url,
                        'excerpt'        => $coverage->excerpt,
                        'image_url'      => $coverage->image_url,
                        
                        // Computed field for display
                        'display_image'  => $this->getPressCoverageImage($coverage),
                    ];
                });
        });

        // ========================================
        // 3. COMPANY STATS (Dynamic Calculation)
        // ========================================
        $companyStats = [
            'founding_year'       => 1996,
            'current_year'        => now()->year,
            'years_of_excellence' => now()->year - 1996,
            'total_projects'      => Project::count(),
            'flagship_projects'   => Project::where('is_flagship', true)->count(),
            'published_projects'  => Project::where('is_published', true)->count(),
            'total_press_coverage'=> PressCoverage::count(),
            'cidb_rating'         => 'G7',
            'cidb_stars'          => 5,
            'qlassic_score'       => 82,
            'shassic_score'       => 83,
        ];

        // ========================================
        // RETURN VIEW WITH ALL DATA INTACT
        // ========================================
        return view('index', compact(
            'featuredProjects',
            'pressCoverage',
            'companyStats'
        ));
    }

    /**
     * API Endpoint: Get Projects
     * GET /api/projects?flagship=true&limit=10
     */
    public function apiProjects(Request $request)
    {
        try {
            $flagship = filter_var($request->query('flagship', false), FILTER_VALIDATE_BOOLEAN);
            $limit = min((int)$request->query('limit', 12), 20);

            $query = Project::with(['media' => fn($q) => $q->where('collection_name', 'cover_image')]);

            if ($flagship) {
                $query->where('is_flagship', true);
            }

            $projects = $query->where('is_published', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get()
                ->map(function ($p) {
                    return [
                        'id'               => $p->id,
                        'name'             => $p->name,
                        'slug'             => $p->slug,
                        'description'      => $p->description,
                        'client'           => $p->client,
                        'location'         => $p->location ?? 'Penang, Malaysia',
                        'category'         => $p->category?->name,
                        'status'           => $p->status,
                        'year'             => $p->year,
                        'is_flagship'      => (bool)$p->is_flagship,
                        'is_published'     => (bool)$p->is_published,
                        'sort_order'       => $p->sort_order,
                        'image_url'        => $p->image_url,
                        'contract_value'   => $p->contract_value,
                        'cover_image'      => $this->getProjectCoverImage($p),
                        'detail_page'      => route('projects.show', $p->slug),
                    ];
                });

            return response()->json([
                'success' => true,
                'data'    => $projects,
                'count'   => $projects->count(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'  => 'Failed to load projects',
                'message' => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * API Endpoint: Get Press Coverage
     * GET /api/press-coverage?limit=4
     */
    public function apiPressCoverage(Request $request)
    {
        try {
            $limit = min((int)$request->query('limit', 4), 10);

            $items = PressCoverage::with(['media' => fn($q) => $q->where('collection_name', 'press_image')])
                ->orderBy('published_date', 'desc')
                ->take($limit)
                ->get()
                ->map(function ($item) {
                    return [
                        'id'             => $item->id,
                        'headline'       => $item->headline,
                        'publication'    => $item->publication,
                        'published_date' => $item->published_date?->format('Y-m-d'),
                        'external_url'   => $item->external_url,
                        'excerpt'        => $item->excerpt,
                        'image_url'      => $item->image_url,
                        'display_image'  => $this->getPressCoverageImage($item),
                    ];
                });

            return response()->json([
                'success' => true,
                'data'    => $items,
                'count'   => $items->count(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'  => 'Failed to load press coverage',
            ], 500);
        }
    }

    /**
     * API Endpoint: Company Stats
     * GET /api/stats
     */
    public function apiStats()
    {
        return response()->json([
            'founding_year'       => 1996,
            'current_year'        => now()->year,
            'years_of_excellence' => now()->year - 1996,
            'total_projects'      => Project::count(),
            'flagship_projects'   => Project::where('is_flagship', true)->count(),
            'total_press_coverage'=> PressCoverage::count(),
            'cidb_rating'         => 'G7',
            'qlassic_score'       => 82,
            'shassic_score'       => 83,
            'updated_at'          => now()->toIso8601String(),
        ]);
    }

    /**
     * Helper: Get project cover image with fallback chain
     * Uses YOUR cover_image media collection
     */
    private function getProjectCoverImage(Project $project): string
    {
        // 1. Try Spatie Media Library: cover_image collection
        if ($project->hasMedia('cover_image')) {
            $img = $project->getFirstMediaUrl('cover_image');
            if ($img && $img !== '') return $img;
        }

        // 2. Try image_url field from database
        if (!empty($project->image_url)) {
            return str_starts_with($project->image_url, 'http')
                ? $project->image_url
                : cdn_rewrite(asset(ltrim($project->image_url, '/')));
        }

        // 3. Try cover_image_upload field
        if (!empty($project->cover_image_upload)) {
            return cdn_rewrite(asset('storage/' . ltrim($project->cover_image_upload, '/')));
        }

        // 4. Ultimate fallback
        return asset('images/placeholder.jpg');
    }

    /**
     * Helper: Get press coverage image with fallback chain
     * Uses YOUR press_image media collection
     */
    private function getPressCoverageImage(PressCoverage $coverage): string
    {
        // 1. Try Spatie Media Library: press_image collection
        if ($coverage->hasMedia('press_image')) {
            $img = $coverage->getFirstMediaUrl('press_image');
            if ($img && $img !== '') return $img;
        }

        // 2. Try image_url field from database
        if (!empty($coverage->image_url)) {
            return str_starts_with($coverage->image_url, 'http')
                ? $coverage->image_url
                : cdn_rewrite(asset(ltrim($coverage->image_url, '/')));
        }

        // 3. Ultimate fallback
        return asset('images/placeholder.jpg');
    }
}