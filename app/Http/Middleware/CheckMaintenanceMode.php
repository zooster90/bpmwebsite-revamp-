<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // Allow admin backend, filament internal routes, api, and the maintenance page itself
        if ($request->is('admin*') || $request->is('livewire*') || $request->is('maintenance') || $request->is('api*')) {
            return $next($request);
        }

        try {
            $maintenanceEnabled = Setting::where('key', 'maintenance_mode')->value('value') === '1';
        } catch (\Exception $e) {
            $maintenanceEnabled = false;
        }

        if ($maintenanceEnabled) {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
