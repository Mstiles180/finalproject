@extends('layouts.app')

@section('title', 'History')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-history me-2"></i>Work History
            </h2>
            
            @if(auth()->user()->isBoss())
                <!-- Employer View -->
                @if($completedJobs->count() > 0)
                    <div class="row">
                        @foreach($completedJobs as $job)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-check-circle me-2"></i>Completed Job
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $job->title }}</h6>
                                        <p class="card-text text-muted small">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $job->created_at->format('M d, Y') }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Daily Rate:</strong> ${{ number_format($job->daily_rate, 2) }}
                                        </p>
                                        
                                        @foreach($job->jobOffers as $jobOffer)
                                            <div class="border-top pt-3 mt-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <strong>Worker: {{ $jobOffer->worker->name }}</strong>
                                                    @if($jobOffer->rating)
                                                        <div class="text-warning">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star{{ $i <= $jobOffer->rating ? '' : '-o' }}"></i>
                                                            @endfor
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($jobOffer->feedback)
                                                    <div class="bg-light p-2 rounded mb-2">
                                                        <small class="text-muted">Feedback:</small>
                                                        <p class="mb-0">{{ $jobOffer->feedback }}</p>
                                                    </div>
                                                @endif
                                                
                                                @if(!$jobOffer->rating)
                                                    <a href="{{ route('history.feedback', $jobOffer->id) }}" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-star me-1"></i>Give Feedback
                                                    </a>
                                                @else
                                                    <span class="badge bg-success">Feedback Given</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No completed jobs yet</h5>
                        <p class="text-muted">Completed jobs will appear here once workers finish their assigned tasks.</p>
                    </div>
                @endif
            @else
                <!-- Worker View -->
                @if($completedOffers->count() > 0)
                    <div class="row">
                        @foreach($completedOffers as $jobOffer)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-check-circle me-2"></i>Completed Work
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $jobOffer->job->title }}</h6>
                                        <p class="card-text text-muted small">
                                            <i class="fas fa-calendar me-1"></i>
                                            Completed: {{ $jobOffer->completed_at->format('M d, Y') }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Employer:</strong> {{ $jobOffer->job->user->name }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Daily Rate:</strong> ${{ number_format($jobOffer->job->daily_rate, 2) }}
                                        </p>
                                        
                                        @if($jobOffer->rating)
                                            <div class="border-top pt-3 mt-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <strong class="me-2">Rating:</strong>
                                                    <div class="text-warning">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star{{ $i <= $jobOffer->rating ? '' : '-o' }}"></i>
                                                        @endfor
                                                        <span class="ms-2 text-dark">({{ $jobOffer->rating }}/5)</span>
                                                    </div>
                                                </div>
                                                
                                                @if($jobOffer->feedback)
                                                    <div class="bg-light p-2 rounded">
                                                        <small class="text-muted">Employer Feedback:</small>
                                                        <p class="mb-0">{{ $jobOffer->feedback }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="border-top pt-3 mt-3">
                                                <span class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>Waiting for employer feedback
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No completed work yet</h5>
                        <p class="text-muted">Your completed jobs will appear here once you finish assigned tasks.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
