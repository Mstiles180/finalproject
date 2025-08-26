<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'boss') {
            $recentJobs = $user->jobs()->withCount('jobOffers')->latest()->take(5)->get();
            $totalJobs = $user->jobs()->count();
            $totalOffers = $user->jobs()->withCount('jobOffers')->get()->sum('job_offers_count');
            $totalApplications = \App\Models\Application::whereIn('job_id', $user->jobs()->pluck('id'))->count();
            $activeWorkers = $user->jobs()->withAcceptedOffers()->withCount(['jobOffers' => function($q) {
                $q->where('status', 'accepted');
            }])->get()->sum('job_offers_count');
            
            // Count pending feedback for completed jobs
            $pendingFeedback = \App\Models\JobOffer::whereHas('job', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'completed')
              ->whereNull('rating')
              ->count();

            return view('dashboard.boss', compact('recentJobs', 'totalJobs', 'totalOffers', 'totalApplications', 'activeWorkers', 'pendingFeedback'));
        } else {
            // Job offer statistics for workers
            $pendingJobOffers = $user->jobOffers()->where('status', 'pending')->count();
            $acceptedJobOffers = $user->jobOffers()->where('status', 'accepted')->count();

            return view('dashboard.worker', compact('pendingJobOffers', 'acceptedJobOffers'));
        }
    }

    public function toggleAvailability(Request $request)
    {
        $user = Auth::user();
        
        // Only workers can toggle availability
        if (!$user->isWorker()) {
            return redirect()->back()->with('error', 'Only workers can toggle availability.');
        }

        // Check if worker has active jobs when trying to become available
        if (!$user->is_available && $user->hasActiveJobs()) {
            $activeJobs = $user->getActiveJobs();
            $jobTitles = $activeJobs->pluck('job.title')->implode(', ');
            return redirect()->back()->with('error', "You cannot become available while working on active jobs: {$jobTitles}. Please wait until these jobs are completed or ask your employer to end them early.");
        }

        // If setting to available, require pickup point and administrative location
        if (!$user->is_available) {
            $request->validate([
                'pickup_point_id' => 'required|exists:pickup_points,id',
                'province_id' => 'required|exists:provinces,id',
                'district_id' => 'required|exists:districts,id',
                'sector_id' => 'required|exists:sectors,id',
                'cell_id' => 'required|exists:cells,id',
                'village_id' => 'required|exists:villages,id',
            ]);
            
            $user->pickup_point_id = $request->pickup_point_id;
            $user->province_id = $request->province_id;
            $user->district_id = $request->district_id;
            $user->sector_id = $request->sector_id;
            $user->cell_id = $request->cell_id;
            $user->village_id = $request->village_id;
        }

        $user->is_available = !$user->is_available;
        $user->save();

        $status = $user->is_available ? 'available' : 'unavailable';
        return redirect()->back()->with('success', "You are now {$status} for work.");
    }
} 