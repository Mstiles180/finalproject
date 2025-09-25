<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;

class CompleteExpiredJobs extends Command
{
    protected $signature = 'jobs:complete-expired';
    protected $description = 'Mark jobs as completed when their end date/time has passed';

    public function handle()
    {
        $this->info('Checking for expired jobs...');

        $nowDate = Carbon::today();
        $nowTime = Carbon::now()->format('H:i:s');

        $expiredJobs = Job::where('status', 'active')
            ->where(function ($query) use ($nowDate, $nowTime) {
                $query->where('end_date', '<', $nowDate)
                      ->orWhere(function ($q) use ($nowDate, $nowTime) {
                          $q->whereDate('end_date', '=', $nowDate)
                            ->whereTime('end_time', '<=', $nowTime);
                      });
            })
            ->get();

        $completedCount = 0;

        foreach ($expiredJobs as $job) {
            $job->update(['status' => 'completed']);
            
            // Mark all accepted job offers as completed and make workers available again
            $acceptedOffers = $job->jobOffers()->where('status', 'accepted')->get();
            foreach ($acceptedOffers as $offer) {
                $offer->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
                if ($offer->worker) {
                    $offer->worker->update(['is_available' => true]);
                }
            }

            $completedCount++;
            $this->info("Completed job: {$job->title} (ID: {$job->id})");
        }

        $this->info("Completed {$completedCount} expired jobs.");
        return 0;
    }
}
