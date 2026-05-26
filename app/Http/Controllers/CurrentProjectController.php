<?php

namespace App\Http\Controllers;

use App\Models\CurrentProject;
use Illuminate\Http\Request;

class CurrentProjectController extends Controller
{
    /**
     * Display the specified ongoing project.
     * Reuses the project-detail view for consistency.
     */
    public function show(string $slug)
    {
        $project = CurrentProject::where('slug', $slug)
            ->where('is_active', true)
            ->with(['media', 'category'])
            ->firstOrFail();

        // Convert title to name for view compatibility if necessary,
        // or we'll update the view to handle both.
        $project->name = $project->title;

        // Recommendations from CurrentProjects
        $relatedProjects = CurrentProject::where('is_active', true)
            ->where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->with(['media', 'category'])
            ->take(3)
            ->get();

        foreach($relatedProjects as $p) {
            $p->name = $p->title;
        }

        return view('project-detail', compact('project', 'relatedProjects'));
    }
}
