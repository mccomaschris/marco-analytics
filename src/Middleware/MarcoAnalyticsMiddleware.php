<?php

namespace McComasChris\MarcoAnalytics\Middleware;

use Closure;
use Illuminate\Http\Request;
use McComasChris\MarcoAnalytics\Models\Analytics;
use Jenssegers\Agent\Agent;

class AnalyticsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // List of file extensions to ignore
        $ignoredExtensions = ['js', 'css', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'otf'];

        // Extract the file extension from the URL
        $path = $request->path();
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        // Skip tracking if it's a static file
        if (in_array($extension, $ignoredExtensions)) {
            return $next($request);
        }

        // Skip tracking Livewire assets
        if (str_starts_with($path, 'livewire/')) {
            return $next($request);
        }

        // Skip tracking Laravel's built-in assets (e.g., /_debugbar/)
        if (str_starts_with($path, '_debugbar')) {
            return $next($request);
        }

        // Skip tracking API requests
        if ($request->is('api/*')) {
            return $next($request);
        }

        // Detect device/browser and store analytics
        $agent = new Agent();

        Analytics::create([
            'url' => $request->fullUrl(),
            'browser' => $agent->browser(),
            'device' => $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
            'ip_address' => config('marco-analytics.track_ip') ? $request->ip() : null,
        ]);

        return $next($request);
    }
}
