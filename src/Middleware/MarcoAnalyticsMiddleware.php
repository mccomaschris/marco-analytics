<?php

namespace McComasChris\MarcoAnalytics\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use McComasChris\MarcoAnalytics\Models\MarcoAnalytics;

class MarcoAnalyticsMiddleware
{
	public function handle(Request $request, Closure $next)
	{
		$path = rtrim($request->path(), '/'); // Remove trailing slashes
		$extension = pathinfo($path, PATHINFO_EXTENSION);

		// Load ignored paths from config
		$ignoredPaths = config('marco-analytics.ignored_paths', []);
		$ignoredExtensions = config('marco-analytics.ignored_extensions', []);

		// Ignore file extensions
		if (in_array($extension, $ignoredExtensions)) {
			return $next($request);
		}

		// Ignore specific URL paths
		foreach ($ignoredPaths as $ignoredPath) {
			if ($request->is(trim($ignoredPath, '/'))) { // Trim ignored path slashes too
				return $next($request);
			}
		}

		// Ignore any URL that contains 'callback' (e.g., Socialite auth URLs)
		if (str_contains($request->fullUrl(), 'callback')) {
			return $next($request);
		}

		// Detect device/browser and store analytics
		$agent = new Agent;

		if (config('marco-analytics.ignore_bots') && $agent->isRobot()) {
			return $next($request);
		}

		MarcoAnalytics::create([
			'url' => $request->fullUrl(),
			'browser' => $agent->browser(),
			'device' => $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
			'ip_address' => config('marco-analytics.track_ip') ? $request->ip() : null,
		]);

		return $next($request);
	}
}
