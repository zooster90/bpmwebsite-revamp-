<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = \App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();
        return view('services', compact('services'));
    }

    public function show($slug)
    {
        $service = \App\Models\Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('service-details', compact('service'));
    }
}
