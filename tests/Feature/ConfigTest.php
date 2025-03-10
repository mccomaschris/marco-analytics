<?php

use Illuminate\Support\Facades\Config;

test('config file has correct defaults', function () {
	expect(Config::get('marco-analytics.track_ip'))->toBeTrue();
	expect(Config::get('marco-analytics.ignore_bots'))->toBeTrue();
	expect(Config::get('marco-analytics.ignored_paths'))->toBeArray();
});
