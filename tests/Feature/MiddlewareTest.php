<?php

use McComasChris\MarcoAnalytics\Models\MarcoAnalytics;
use McComasChris\MarcoAnalytics\Middleware\MarcoAnalyticsMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
	MarcoAnalytics::truncate();
});

test('middleware tracks a visit', function () {
	Config::set('marco-analytics.track_ip', true);
	Config::set('marco-analytics.ignore_bots', true);

	$request = Request::create('/test-page');
	$middleware = new MarcoAnalyticsMiddleware();
	$middleware->handle($request, fn($req) => null);

	expect(MarcoAnalytics::count())->toBe(1);
});

test('middleware does not track ignored paths', function () {
	Config::set('marco-analytics.ignored_paths', ['/admin/*']);

	$request = Request::create('/admin/dashboard');
	$middleware = new MarcoAnalyticsMiddleware();
	$middleware->handle($request, fn($req) => null);

	expect(MarcoAnalytics::count())->toBe(0);
});

test('middleware does not track bot traffic', function () {
	Config::set('marco-analytics.ignore_bots', true);

	$request = Request::create('/test');
	$request->headers->set('User-Agent', 'Googlebot');

	$middleware = new MarcoAnalyticsMiddleware();
	$middleware->handle($request, fn($req) => null);

	expect(MarcoAnalytics::count())->toBe(0);
});
