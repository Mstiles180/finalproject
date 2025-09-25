<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ReputationClient;
use Illuminate\Console\Command;

class ScoreWorker extends Command
{
    protected $signature = 'ml:score-worker {worker_id}';
    protected $description = 'Compute worker reputation score via ML service';

    public function handle(ReputationClient $client)
    {
        $workerId = (int) $this->argument('worker_id');
        $user = User::findOrFail($workerId);
        if (!$user->isWorker()) {
            $this->error('User is not a worker');
            return self::FAILURE;
        }

        // Derive features
        $avgRating = (float) \DB::table('job_offers')
            ->where('worker_id', $user->id)
            ->whereNotNull('rating')
            ->avg('rating');

        $completedJobs = (int) \DB::table('job_offers')
            ->where('worker_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalAccepted = (int) \DB::table('job_offers')
            ->where('worker_id', $user->id)
            ->whereIn('status', ['accepted','completed'])
            ->count();

        $completionRate = $totalAccepted > 0 ? ($completedJobs / $totalAccepted) : 0.0;

        $numReports = (int) \DB::table('reports')
            ->where('reportable_type', \App\Models\User::class)
            ->where('reportable_id', $user->id)
            ->count();

        $payload = [
            'avg_rating' => $avgRating ?: 0.0,
            'completed_jobs' => $completedJobs,
            'is_verified' => (bool) ($user->is_verified ?? false),
            'completion_rate' => $completionRate,
            'num_reports' => $numReports,
        ];

        $this->line('Payload: ' . json_encode($payload));
        $result = $client->score($payload);
        $this->info('Result: ' . json_encode($result));

        return self::SUCCESS;
    }
}


