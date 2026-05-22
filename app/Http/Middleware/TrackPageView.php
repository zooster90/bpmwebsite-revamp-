<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * TrackPageView Middleware
 * Records every frontend page visit to the page_views table.
 * Admin routes (/admin/*) and API routes are excluded.
 */
class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track frontend GET requests (skip admin, api, assets, ajax)
        if (
            $request->isMethod('GET') &&
            !$request->is('admin*') &&
            !$request->is('api*') &&
            !$request->is('*.css') &&
            !$request->is('*.js') &&
            !$request->expectsJson() &&
            !$request->ajax() &&
            $response->getStatusCode() === 200
        ) {
            try {
                $ua = $request->userAgent() ?? '';
                ['browser' => $browser, 'version' => $version] = PageView::parseBrowser($ua);

                PageView::create([
                    'url'             => substr($request->fullUrl(), 0, 500),
                    'page_title'      => null, // populated client-side
                    'route_name'      => $request->route()?->getName(),
                    'session_id'      => substr(session()->getId() ?? '', 0, 100),
                    'ip_address'      => PageView::anonymiseIp($request->ip() ?? '0.0.0.0'),
                    'user_agent'      => substr($ua, 0, 500),
                    'browser'         => $browser,
                    'browser_version' => $version,
                    'os'              => PageView::parseOS($ua),
                    'device_type'     => PageView::parseDevice($ua),
                    'referrer'        => substr($request->headers->get('referer') ?? '', 0, 500),
                    'is_bounce'       => false,
                ]);
            } catch (\Throwable $e) {
                // Never break the page for a tracking failure
                logger()->warning('PageView tracking failed: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
