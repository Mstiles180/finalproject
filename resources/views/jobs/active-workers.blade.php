@extends('layouts.app')

@section('title', 'Active Workers')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-users me-2"></i>Active Workers</h2>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Post New Job
                </a>
            </div>

            @if($activeJobs->count() === 0)
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Active Workers</h4>
                        <p class="text-muted">You don't have any workers currently working on your jobs.</p>
                        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Post a Job
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($activeJobs as $job)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                            {{ $job->title }}
                                        </a>
                                    </h5>
                                    <small class="text-muted">{{ $job->location }}</small>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Job Details:</strong><br>
                                        <i class="fas fa-calendar me-1"></i>{{ $job->date_range_text }}<br>
                                        <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($job->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($job->end_time)->format('g:i A') }}<br>
                                        <i class="fas fa-calendar-week me-1"></i>{{ $job->duration_text }}<br>
                                        <i class="fas fa-dollar-sign me-1"></i>RWF {{ number_format($job->daily_rate, 0) }}/day
                                        @if($job->isMultiDayJob())
                                            <br><i class="fas fa-calculator me-1"></i>Total: {{ $job->total_amount }}
                                        @endif
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Workers Currently Working:</strong>
                                                                                 @foreach($job->jobOffers as $jobOffer)
                                             <div class="card mt-2 border-success">
                                                 <div class="card-body py-2">
                                                     <div class="d-flex justify-content-between align-items-center">
                                                         <div>
                                                             <strong>{{ $jobOffer->worker->name }}</strong><br>
                                                             <small class="text-muted">
                                                                 <i class="fas fa-phone me-1"></i>{{ $jobOffer->worker->phone ?? 'No phone' }}<br>
                                                                 <i class="fas fa-envelope me-1"></i>{{ $jobOffer->worker->email }}<br>
                                                                 <i class="fas fa-map-marker-alt me-1"></i>{{ $jobOffer->worker->location ?? 'No location' }}
                                                             </small>
                                                         </div>
                                                         <div class="text-end">
                                                             <span class="badge bg-success">Working</span><br>
                                                             <small class="text-muted">Accepted: {{ $jobOffer->accepted_at->format('M d, g:i A') }}</small>
                                                             <br>
                                                             <form method="POST" action="{{ route('jobs.remove-worker', [$job, $jobOffer]) }}" class="d-inline mt-1">
                                                                 @csrf
                                                                 @method('DELETE')
                                                                 <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove {{ $jobOffer->worker->name }} from this job?')">
                                                                     <i class="fas fa-user-minus"></i> Remove
                                                                 </button>
                                                             </form>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endforeach
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>Posted {{ $job->created_at->diffForHumans() }}
                                        </small>
                                                                                 <div class="btn-group btn-group-sm">
                                             <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary">
                                                 <i class="fas fa-eye"></i> View Job
                                             </a>
                                             <a href="{{ route('job-offers.job-offers', $job) }}" class="btn btn-outline-info">
                                                 <i class="fas fa-users"></i> All Offers
                                             </a>
                                             <form method="POST" action="{{ route('jobs.end-job', $job) }}" class="d-inline">
                                                 @csrf
                                                 @method('PATCH')
                                                 <button type="submit" class="btn btn-outline-warning" onclick="return confirm('End this job and release all workers?')">
                                                     <i class="fas fa-stop-circle"></i> End Job
                                                 </button>
                                             </form>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $activeJobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
