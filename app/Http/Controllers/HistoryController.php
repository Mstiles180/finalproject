<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Initialize both variables to empty collections
        $completedJobs = collect();
        $completedOffers = collect();
        
        if ($user->isBoss()) {
            // For employers, show completed jobs where they can give feedback
            $completedJobs = Job::where('user_id', $user->id)
                ->whereHas('jobOffers', function ($query) {
                    $query->where('status', 'completed');
                })
                ->with(['jobOffers' => function ($query) {
                    $query->where('status', 'completed')
                          ->with('worker');
                }])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // For workers, show their completed job offers
            $completedOffers = JobOffer::where('worker_id', $user->id)
                ->where('status', 'completed')
                ->with(['job.user', 'job'])
                ->orderBy('completed_at', 'desc')
                ->get();
        }
        
        return view('history.index', compact('completedJobs', 'completedOffers'));
    }
    
    public function showFeedback($jobOfferId)
    {
        $jobOffer = JobOffer::with(['job', 'worker'])->findOrFail($jobOfferId);
        
        // Ensure only the employer can give feedback
        if ($jobOffer->job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        return view('history.feedback', compact('jobOffer'));
    }
    
    public function storeFeedback(Request $request, $jobOfferId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|max:1000',
        ]);
        
        $jobOffer = JobOffer::with('job')->findOrFail($jobOfferId);
        
        // Ensure only the employer can give feedback
        if ($jobOffer->job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Ensure the job is completed
        if ($jobOffer->status !== 'completed') {
            return back()->with('error', 'Can only give feedback for completed jobs.');
        }
        
        $jobOffer->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'feedback_at' => now(),
        ]);
        
        return redirect()->route('history.index')->with('success', 'Feedback submitted successfully!');
    }
}
