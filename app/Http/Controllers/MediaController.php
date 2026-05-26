<?php

namespace App\Http\Controllers;

use App\Models\PressCoverage;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        // Eager-load media + category so the press-coverage grid doesn't fire
        // one query per item when display_image / hasMedia is called.
        // Filter out rows without published_date — the view assumes the date
        // is non-null when it calls $item->published_date->format('Y').
        $coverages = PressCoverage::with(['media', 'category'])
            ->whereNotNull('published_date')
            ->orderBy('published_date', 'desc')
            ->get();

        // Build the year filter list in PHP. The previous query used SQLite's
        // strftime(), which 500s on MySQL/MariaDB (Laravel Cloud's default).
        $years = $coverages
            ->map(fn ($c) => $c->published_date?->format('Y'))
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();

        return view('media', compact('coverages', 'years'));
    }
}
