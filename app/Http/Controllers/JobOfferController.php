<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $this->authorize('createOffer', $job);

        $request->validate([
            'worker_id' => 'required|exists:users,id',
        ]);

        // Check if worker is available
        $worker = User::find($request->worker_id);
        if (!$worker->is_available) {
            return back()->withErrors(['worker_id' => 'This worker is not available.']);
        }

        // Check if job offer already exists
        $existingOffer = $job->jobOffers()
            ->where('worker_id', $request->worker_id)
            ->first();

        if ($existingOffer) {
            return back()->withErrors(['worker_id' => 'You have already offered this job to this worker.']);
        }

        $jobOffer = $job->jobOffers()->create([
            'worker_id' => $request->worker_id,
            'status' => 'pending',
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job offer sent successfully!');
    }

    public function index()
    {
        $this->authorize('viewOffers', JobOffer::class);

        $jobOffers = Auth::user()->jobOffers()
            ->with('job.user')
            ->latest()
            ->paginate(10);

        return view('job-offers.index', compact('jobOffers'));
    }

    public function jobOffers(Job $job)
    {
        $this->authorize('viewJobOffers', $job);

        $jobOffers = $job->jobOffers()
            ->with('worker')
            ->latest()
            ->paginate(10);

        return view('job-offers.job-offers', compact('job', 'jobOffers'));
    }

    public function accept(JobOffer $jobOffer)
    {
        $this->authorize('respondToOffer', $jobOffer);

        $jobOffer->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        // Make worker unavailable
        $jobOffer->worker->update(['is_available' => false]);

        return back()->with('success', 'Job offer accepted! You are now unavailable for other jobs.');
    }

    public function decline(JobOffer $jobOffer)
    {
        $this->authorize('respondToOffer', $jobOffer);

        $jobOffer->update([
            'status' => 'declined',
            'declined_at' => now(),
        ]);

        return back()->with('success', 'Job offer declined.');
    }

    public function destroy(JobOffer $jobOffer)
    {
        $this->authorize('deleteOffer', $jobOffer);

        $jobOffer->delete();

        return back()->with('success', 'Job offer cancelled successfully!');
    }
} 