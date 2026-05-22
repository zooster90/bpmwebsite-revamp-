<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\News;
use App\Models\CurrentProject;

class PageController extends Controller
{
    public function index()
    {
        // 只选出发布了且标记为“旗舰”的项目放在首页展示
        $flagships = Project::where('is_published', true)
            ->where('is_flagship', true)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // 首页也可以带上最新的 3 条社论/动态，且必须包含图片
        $latest_news = News::where(function($q) {
            $q->whereNotNull('image_url')->where('image_url', '!=', '')
              ->orWhereNotNull('news_image_upload')->where('news_image_upload', '!=', '');
        })->orderBy('published_date', 'desc')->limit(3)->get();
        
        // 首页媒体报道
        $latestMedia = \App\Models\PressCoverage::orderBy('published_date', 'desc')->limit(3)->get();

        // 🏗️ 获取正在进行的重点项目
        $ongoingProjects = CurrentProject::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('welcome', compact('flagships', 'latest_news', 'latestMedia', 'ongoingProjects'));
    }

    /**
     * API Endpoint: Get Projects
     * GET /api/projects?category=...&limit=10
     */
    public function apiProjects(\Illuminate\Http\Request $request)
    {
        try {
            $category = $request->query('category');
            $limit = min((int)$request->query('limit', 12), 20);

            $query = \App\Models\Project::with(['media' => fn($q) => $q->where('collection_name', 'cover_image')]);

            if ($category && $category !== 'all') {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('name', $category)->orWhere('slug', $category);
                });
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
                        'image_url'        => $p->image_url,
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
            ], 500);
        }
    }

    /**
     * API Endpoint: Get Press Coverage
     */
    public function apiPressCoverage(\Illuminate\Http\Request $request)
    {
        try {
            $limit = min((int)$request->query('limit', 4), 10);
            $items = \App\Models\PressCoverage::with(['media' => fn($q) => $q->where('collection_name', 'press_image')])
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

            return response()->json(['success' => true, 'data' => $items, 'count' => $items->count()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to load press coverage'], 500);
        }
    }

    /**
     * API Endpoint: Company Stats
     */
    public function apiStats()
    {
        return response()->json([
            'total_projects'      => \App\Models\Project::count(),
            'published_projects'  => \App\Models\Project::where('is_published', true)->count(),
        ]);
    }

    private function getProjectCoverImage(\App\Models\Project $project): string
    {
        if ($project->hasMedia('cover_image')) {
            $img = $project->getFirstMediaUrl('cover_image');
            if ($img && $img !== '') return $img;
        }
        if (!empty($project->image_url)) return $project->image_url;
        if (!empty($project->cover_image_upload)) return asset('storage/' . $project->cover_image_upload);
        return asset('images/placeholder.jpg');
    }

    private function getPressCoverageImage(\App\Models\PressCoverage $coverage): string
    {
        if ($coverage->hasMedia('press_image')) {
            $img = $coverage->getFirstMediaUrl('press_image');
            if ($img && $img !== '') return $img;
        }
        if (!empty($coverage->image_url)) return $coverage->image_url;
        return asset('images/placeholder.jpg');
    }
}