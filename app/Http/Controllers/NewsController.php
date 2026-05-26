<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // Eager-load media + category so the card grid doesn't fire one query
        // per article on `hasMedia()` / `getFirstMediaUrl()`.
        $query = News::query()
            ->where('is_published', true)
            ->with(['media', 'category']);

        // Filter by search keyword
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('excerpt', 'like', $searchTerm)
                  ->orWhere('content', 'like', $searchTerm);
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category)
                  ->orWhere('slug', $request->category);
            });
        }

        $articles = $query
            ->orderByRaw("CASE WHEN (image_url IS NOT NULL AND image_url != '') OR (news_image_upload IS NOT NULL AND news_image_upload != '') THEN 1 ELSE 0 END DESC")
            ->orderBy('published_date', 'desc')
            ->paginate(12);

        return view('news', compact('articles'));
    }

    public function show(string $slug)
    {
        $article = News::where('slug', $slug)
            ->where('is_published', true)
            ->with(['media', 'category'])
            ->firstOrFail();

        return view('news-detail', compact('article'));
    }
}
