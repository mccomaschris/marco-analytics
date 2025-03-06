<?php

namespace McComasChris\MarcoAnalytics;

use Illuminate\Support\ServiceProvider;

class MarcoAnalyticsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load Config
        $this->publishes([
            __DIR__.'/../config/marco-analytics.php' => config_path('marco-analytics.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/marco-analytics.php', 'marco-analytics');
    }

    public function register()
    {
        $this->app->bind('command.marco:purge', function () {
            return new \McComasChris\MarcoAnalytics\Console\PurgeMarcoAnalytics;
        });

        $this->commands([
            'command.marco:purge',
        ]);
    }
}
