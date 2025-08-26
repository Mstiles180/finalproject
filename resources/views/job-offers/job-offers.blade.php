@extends('layouts.app')

@section('title', 'Job Offers - ' . $job->title)

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-briefcase me-2"></i>Job Offers</h2>
                    <p class="text-muted mb-0">{{ $job->title }}</p>
                </div>
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Job
                </a>
            </div>

            @if($jobOffers->count() === 0)
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Job Offers Sent</h4>
                        <p class="text-muted">You haven't sent any job offers for this position yet.</p>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($jobOffers as $jobOffer)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $jobOffer->worker->name }}</h5>
                                    {!! $jobOffer->status_badge !!}
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Worker Details:</strong><br>
                                        <i class="fas fa-user me-1"></i>{{ $jobOffer->worker->name }}<br>
                                        <i class="fas fa-envelope me-1"></i>{{ $jobOffer->worker->email }}<br>
                                        @if($jobOffer->worker->phone)
                                            <i class="fas fa-phone me-1"></i>{{ $jobOffer->worker->phone }}<br>
                                        @endif
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $jobOffer->worker->location }}<br>
                                        <i class="fas fa-dollar-sign me-1"></i>RWF {{ number_format($jobOffer->worker->daily_rate, 0) }}/day
                                    </div>

                                    <div class="mb-3">
                                        <strong>Job Details:</strong><br>
                                        <i class="fas fa-briefcase me-1"></i>{{ $job->title }}<br>
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}<br>
                                        <i class="fas fa-calendar me-1"></i>{{ $job->date_range_text }}<br>
                                        <i class="fas fa-calendar-week me-1"></i>{{ $job->duration_text }}<br>
                                        <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($job->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($job->end_time)->format('g:i A') }}<br>
                                        <i class="fas fa-dollar-sign me-1"></i>RWF {{ number_format($job->daily_rate, 0) }}/day
                                    </div>

                                    @if($jobOffer->status === 'pending')
                                        <div class="alert alert-warning mb-3">
                                            <i class="fas fa-clock me-2"></i>
                                            Waiting for worker response
                                        </div>
                                        <form method="POST" action="{{ route('job-offers.destroy', $jobOffer) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to cancel this job offer?')">
                                                <i class="fas fa-times me-1"></i>Cancel Offer
                                            </button>
                                        </form>
                                    @elseif($jobOffer->status === 'accepted')
                                        <div class="alert alert-success mb-3">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Worker accepted on {{ $jobOffer->accepted_at->format('M d, Y g:i A') }}
                                        </div>
                                        <div class="alert alert-info mb-0">
                                            <strong>Contact Information:</strong><br>
                                            <i class="fas fa-phone me-1"></i>{{ $jobOffer->worker->phone }}<br>
                                            <i class="fas fa-envelope me-1"></i>{{ $jobOffer->worker->email }}
                                        </div>
                                    @elseif($jobOffer->status === 'declined')
                                        <div class="alert alert-secondary mb-0">
                                            <i class="fas fa-times-circle me-2"></i>
                                            Worker declined on {{ $jobOffer->declined_at->format('M d, Y g:i A') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $jobOffers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 