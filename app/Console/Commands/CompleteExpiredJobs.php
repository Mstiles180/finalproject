<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;

class CompleteExpiredJobs extends Command
{
    protected $signature = 'jobs:complete-expired';
    protected $description = 'Mark jobs as completed when their end date has passed';

    public function handle()
    {
        $this->info('Checking for expired jobs...');

        $expiredJobs = Job::where('status', 'active')
            ->where('end_date', '<', Carbon::today())
            ->get();

        $completedCount = 0;

        foreach ($expiredJobs as $job) {
            $job->update(['status' => 'completed']);
            
            // Mark all accepted job offers as completed
            $job->jobOffers()
                ->where('status', 'accepted')
                ->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);

            $completedCount++;
            $this->info("Completed job: {$job->title} (ID: {$job->id})");
        }

        $this->info("Completed {$completedCount} expired jobs.");
        return 0;
    }
}
