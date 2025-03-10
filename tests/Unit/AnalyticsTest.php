<?php

use McComasChris\MarcoAnalytics\Models\MarcoAnalytics;

test('analytics model can store and retrieve visits', function () {
	$entry = MarcoAnalytics::create([
		'url' => 'https://example.com',
		'browser' => 'Chrome',
		'device' => 'Desktop',
		'ip_address' => '127.0.0.1',
	]);

	expect(MarcoAnalytics::count())->toBe(1);
	expect($entry->url)->toBe('https://example.com');
});
