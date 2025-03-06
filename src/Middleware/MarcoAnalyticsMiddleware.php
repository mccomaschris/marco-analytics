<?php

namespace McComasChris\MarcoAnalytics\Middleware;

use Closure;
use Illuminate\Http\Request;
use McComasChris\MarcoAnalytics\Models\MarcoAnalytics;
use Jenssegers\Agent\Agent;

class MarcoAnalyticsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('admin/*')) {
            $agent = new Agent();

            MarcoAnalytics::create([
                'url' => $request->fullUrl(),
                'browser' => $agent->browser(),
                'device' => $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
                'ip_address' => config('marco-analytics.track_ip') ? $request->ip() : null,
            ]);
        }

        return $next($request);
    }
}
