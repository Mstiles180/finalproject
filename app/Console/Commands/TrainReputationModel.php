<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TrainReputationModel extends Command
{
    protected $signature = 'ml:train-reputation';
    protected $description = 'Assemble dataset from DB and train the reputation model via ML service';

    public function handle()
    {
        $baseUrl = rtrim((string) env('ML_API_URL', 'http://127.0.0.1:5000'), '/');

        // Build samples from job_offers, joining worker and aggregations
        $workers = DB::table('users')->where('role', 'worker')->pluck('id');
        $samples = [];
        foreach ($workers as $wid) {
            $avgRating = (float) DB::table('job_offers')->where('worker_id', $wid)->whereNotNull('rating')->avg('rating');
            $completed = (int) DB::table('job_offers')->where('worker_id', $wid)->where('status', 'completed')->count();
            $totalAccepted = (int) DB::table('job_offers')->where('worker_id', $wid)->whereIn('status', ['accepted','completed'])->count();
            $completionRate = $totalAccepted > 0 ? ($completed / $totalAccepted) : 0.0;
            $isVerified = (bool) DB::table('users')->where('id', $wid)->value('is_verified');
            $numReports = (int) DB::table('reports')->where('reportable_type', \App\Models\User::class)->where('reportable_id', $wid)->count();

            // Use current heuristic score as target initially (self-distillation). In future, replace with business labels.
            $target = min(100.0, max(0.0, ($avgRating/5.0)*50.0 + min($completed,20) + ($isVerified?15.0:0.0) + ($completionRate*10.0) - ($numReports*5.0)));

            $samples[] = [
                'avg_rating' => $avgRating ?: 0.0,
                'completed_jobs' => $completed,
                'is_verified' => $isVerified,
                'completion_rate' => $completionRate,
                'num_reports' => $numReports,
                'target_score' => $target,
            ];
        }

        if (empty($samples)) {
            $this->warn('No worker samples found.');
            return self::SUCCESS;
        }

        $resp = Http::acceptJson()->post($baseUrl . '/train', ['samples' => $samples]);
        $this->info('Train response: ' . json_encode($resp->json()));
        return self::SUCCESS;
    }
}


