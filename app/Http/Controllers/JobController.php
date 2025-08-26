<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobOffer;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\Sector;
use App\Models\Cell;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('user')->active();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        $jobs = $query->latest()->paginate(12);

        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $job->load('user', 'jobOffers.worker', 'applications.user', 'pickupPoint');
        
        // Check if current user has applied (for workers)
        $hasApplied = false;
        if (auth()->check() && auth()->user()->isWorker()) {
            $hasApplied = $job->applications()->where('user_id', auth()->id())->exists();
        }

        return view('jobs.show', compact('job', 'hasApplied'));
    }

    public function create()
    {
        $this->authorize('create', Job::class);
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:laundry,builder,builder_helper,farmer,cleaner,other',
            'other_category' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'pickup_point_id' => 'required|exists:pickup_points,id',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'sector_id' => 'required|exists:sectors,id',
            'cell_id' => 'required|exists:cells,id',
            'village_id' => 'required|exists:villages,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'daily_rate' => 'required|numeric|min:0',
            'selected_workers' => 'required|array|min:1',
            'selected_workers.*' => 'exists:users,id',
        ]);

        // Calculate duration in days
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $validated['duration_days'] = $startDate->diffInDays($endDate) + 1;

        // Create work schedule for multi-day jobs
        if ($validated['duration_days'] > 1) {
            $workSchedule = [];
            $currentDate = $startDate->copy();
            
            for ($i = 0; $i < $validated['duration_days']; $i++) {
                $workSchedule[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'day_name' => $currentDate->format('l'),
                ];
                $currentDate->addDay();
            }
            $validated['work_schedule'] = $workSchedule;
        }

        // Remove selected_workers from validated data
        $selectedWorkers = $validated['selected_workers'];
        unset($validated['selected_workers']);

        $job = Auth::user()->jobs()->create($validated);

        // Send job offers to selected workers
        foreach ($selectedWorkers as $workerId) {
            $job->jobOffers()->create([
                'worker_id' => $workerId,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job posted and offers sent to selected workers!');
    }

    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:laundry,builder,builder_helper,farmer,cleaner,other',
            'other_category' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'pickup_point_id' => 'required|exists:pickup_points,id',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'sector_id' => 'required|exists:sectors,id',
            'cell_id' => 'required|exists:cells,id',
            'village_id' => 'required|exists:villages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'daily_rate' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,filled',
        ]);

        // Calculate duration in days
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $validated['duration_days'] = $startDate->diffInDays($endDate) + 1;

        // Create work schedule for multi-day jobs
        if ($validated['duration_days'] > 1) {
            $workSchedule = [];
            $currentDate = $startDate->copy();
            
            for ($i = 0; $i < $validated['duration_days']; $i++) {
                $workSchedule[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'day_name' => $currentDate->format('l'),
                ];
                $currentDate->addDay();
            }
            $validated['work_schedule'] = $workSchedule;
        }

        $job->update($validated);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return redirect()->route('jobs.my-jobs')
            ->with('success', 'Job deleted successfully!');
    }

    public function myJobs()
    {
        $this->authorize('viewMyJobs', Job::class);

        $jobs = Auth::user()->jobs()->withCount('jobOffers')->latest()->paginate(10);

        return view('jobs.my-jobs', compact('jobs'));
    }

    public function activeWorkers()
    {
        $this->authorize('viewMyJobs', Job::class);

        // Get jobs with accepted job offers (workers currently working)
        $activeJobs = Auth::user()->jobs()
            ->withAcceptedOffers()
            ->with(['jobOffers' => function($query) {
                $query->where('status', 'accepted')->with('worker');
            }])
            ->latest()
            ->paginate(10);

        return view('jobs.active-workers', compact('activeJobs'));
    }

    public function removeWorker(Request $request, Job $job, JobOffer $jobOffer)
    {
        $this->authorize('update', $job);

        // Only allow removing workers from active jobs
        if ($job->status !== 'active') {
            return redirect()->back()->with('error', 'Can only remove workers from active jobs.');
        }

        // Only allow removing accepted job offers
        if ($jobOffer->status !== 'accepted') {
            return redirect()->back()->with('error', 'Can only remove workers who are currently working.');
        }

        // Mark the job offer as completed
        $jobOffer->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        return redirect()->back()->with('success', "Worker {$jobOffer->worker->name} has been removed from the job.");
    }

    public function endJob(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        // Only allow ending active jobs
        if ($job->status !== 'active') {
            return redirect()->back()->with('error', 'Can only end active jobs.');
        }

        // Mark job as completed
        $job->update(['status' => 'completed']);

        // Mark all accepted job offers as completed and make workers available again
        $acceptedOffers = $job->jobOffers()->where('status', 'accepted')->get();
        
        foreach ($acceptedOffers as $offer) {
            $offer->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
            
            // Make worker available again
            $offer->worker->update(['is_available' => true]);
        }

        return redirect()->back()->with('success', "Job '{$job->title}' has been ended and all workers have been released.");
    }

    public function getAvailableWorkers(Request $request)
    {
        $this->authorize('create', Job::class);

        $category = $request->get('category');
        $pickupPointId = $request->get('pickup_point_id');
        $provinceId = $request->get('province_id');
        $districtId = $request->get('district_id');
        $sectorId = $request->get('sector_id');
        $cellId = $request->get('cell_id');
        $villageId = $request->get('village_id');

        $query = User::where('role', 'worker')
                    ->where('is_available', true);

        if ($category && $category !== 'other') {
            $query->where('category', $category);
        }

        if ($pickupPointId) {
            $query->where('pickup_point_id', $pickupPointId);
        }

        // Filter by administrative location
        if ($provinceId) {
            $query->where('province_id', $provinceId);
        }
        if ($districtId) {
            $query->where('district_id', $districtId);
        }
        if ($sectorId) {
            $query->where('sector_id', $sectorId);
        }
        if ($cellId) {
            $query->where('cell_id', $cellId);
        }
        if ($villageId) {
            $query->where('village_id', $villageId);
        }

        $workers = $query->with(['pickupPoint', 'province', 'district', 'sector', 'cell', 'village'])
                        ->select('id', 'name', 'location', 'daily_rate', 'phone', 'pickup_point_id', 
                                'province_id', 'district_id', 'sector_id', 'cell_id', 'village_id')
                        ->get();

        return response()->json(['workers' => $workers]);
    }

    public function getDistricts(Province $province)
    {
        try {
            $districts = $province->districts()->select('id', 'name')->get();
            return response()->json(['districts' => $districts]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'districts' => []], 500);
        }
    }

    public function getSectors(District $district)
    {
        try {
            $sectors = $district->sectors()->select('id', 'name')->get();
            return response()->json(['sectors' => $sectors]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'sectors' => []], 500);
        }
    }

    public function getCells(Sector $sector)
    {
        try {
            $cells = $sector->cells()->select('id', 'name')->get();
            return response()->json(['cells' => $cells]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'cells' => []], 500);
        }
    }

    public function getVillages(Cell $cell)
    {
        try {
            $villages = $cell->villages()->select('id', 'name')->get();
            return response()->json(['villages' => $villages]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'villages' => []], 500);
        }
    }
} 