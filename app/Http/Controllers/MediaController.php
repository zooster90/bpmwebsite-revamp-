<?php

namespace App\Http\Controllers;

use App\Models\PressCoverage;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $coverages = PressCoverage::orderBy('published_date', 'desc')->get();
        
        $years = PressCoverage::selectRaw('strftime("%Y", published_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('media', compact('coverages', 'years'));
    }
}
