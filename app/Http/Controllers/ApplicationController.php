<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $this->authorize('apply', $job);

        $request->validate([
            'cover_letter' => 'required|string|min:50',
        ]);

        // Check if user already applied
        $existingApplication = $job->applications()
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->withErrors(['cover_letter' => 'You have already applied for this job.']);
        }

        $application = $job->applications()->create([
            'user_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Application submitted successfully!');
    }

    public function index()
    {
        $this->authorize('viewApplications', Application::class);

        $applications = Auth::user()->applications()
            ->with('job.user')
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function jobApplications(Job $job)
    {
        $this->authorize('viewJobApplications', $job);

        $applications = $job->applications()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('applications.job-applications', compact('job', 'applications'));
    }

    public function update(Request $request, Application $application)
    {
        $this->authorize('updateApplication', $application);

        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated successfully!');
    }

    public function destroy(Application $application)
    {
        $this->authorize('deleteApplication', $application);

        $application->delete();

        return back()->with('success', 'Application withdrawn successfully!');
    }
} 