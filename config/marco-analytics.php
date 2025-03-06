<?php

return [
    'track_ip' => true, // Allow disabling IP tracking

    // File extensions to exclude from tracking
    'ignored_extensions' => ['js', 'css', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'otf'],

    // URL paths to exclude from tracking (e.g., `/admin`, `/login`, `/api/*`)
    'ignored_paths' => [
        'admin', // Ignore admin route
        'admin/*', // Ignore all admin routes
        'login', // Ignore login page
        'register', // Ignore registration page
        'password/*', // Ignore password reset
        'api/*', // Ignore API routes
        'debugbar/*' // Ignore Laravel Debugbar
    ],

    'ignore_bots' => true,
];
