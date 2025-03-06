<?php

namespace McComaschris\MarcoAnalytics\Console;

use Illuminate\Console\Command;
use McComaschris\MarcoAnalytics\Models\MarcoAnalytics;
use Carbon\Carbon;

class PurgeMarcoAnalytics extends Command
{
    protected $signature = 'marco:purge {days=30 : The number of days to keep}';
    protected $description = 'Delete analytics data older than the specified number of days (default: 30 days)';

    public function handle()
    {
        $days = (int) $this->argument('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $deleted = MarcoAnalytics::where('created_at', '<', $cutoffDate)->delete();

        $this->info("Deleted $deleted analytics records older than $days days.");
    }
}
