<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warning;

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

            // Mark unseen warnings as read now
            Warning::where('user_id', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

            // Fetch warnings that are still within 24h of being read (or unread)
            $warnings = Warning::where('user_id', $user->id)
                ->where(function($q){
                    $q->whereNull('read_at')
                      ->orWhere('read_at', '>=', now()->subDay());
                })
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.worker', compact('pendingJobOffers', 'acceptedJobOffers', 'warnings'));
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

        // If setting to available, ensure worker has a pickup point.
        // Location hierarchy is derived from the admin-assigned pickup point.
        if (!$user->is_available) {
            if (empty($user->pickup_point_id)) {
                return redirect()->route('settings.profile')
                    ->with('error', 'Please set your pickup point in Settings before becoming available.');
            }

            // Backfill location fields from pickup point's village hierarchy if missing
            $pickup = \App\Models\PickupPoint::with('village.cell.sector.district.province')->find($user->pickup_point_id);
            if ($pickup && $pickup->village) {
                $user->village_id = $user->village_id ?: $pickup->village->id;
                $user->cell_id = $user->cell_id ?: $pickup->village->cell->id;
                $user->sector_id = $user->sector_id ?: $pickup->village->cell->sector->id;
                $user->district_id = $user->district_id ?: $pickup->village->cell->sector->district->id;
                $user->province_id = $user->province_id ?: $pickup->village->cell->sector->district->province->id;
            }
        }

        $user->is_available = !$user->is_available;
        $user->save();

        $status = $user->is_available ? 'available' : 'unavailable';
        return redirect()->back()->with('success', "You are now {$status} for work.");
    }
} 