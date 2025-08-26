@extends('layouts.app')

@section('title', 'My Job Offers')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-briefcase me-2"></i>My Job Offers</h2>
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-search me-2"></i>Browse More Jobs
                </a>
            </div>

            @if($jobOffers->count() === 0)
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Job Offers Yet</h4>
                        <p class="text-muted">You haven't received any job offers yet. Keep your profile updated and stay available for work!</p>
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Browse Available Jobs
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($jobOffers as $jobOffer)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $jobOffer->job->title }}</h5>
                                    {!! $jobOffer->status_badge !!}
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Employer:</strong> {{ $jobOffer->job->user->name }}<br>
                                        <strong>Location:</strong> {{ $jobOffer->job->location }}<br>
                                        <strong>Date:</strong> {{ $jobOffer->job->date_range_text }}<br>
                                        <strong>Duration:</strong> {{ $jobOffer->job->duration_text }}<br>
                                        <strong>Time:</strong> {{ \Carbon\Carbon::parse($jobOffer->job->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($jobOffer->job->end_time)->format('g:i A') }}<br>
                                        <strong>Rate:</strong> RWF {{ number_format($jobOffer->job->daily_rate, 0) }}/day<br>
                                        <strong>Total:</strong> {{ $jobOffer->job->total_amount }}
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Job Description:</strong><br>
                                        <p class="text-muted">{{ Str::limit($jobOffer->job->description, 150) }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Employer Contact:</strong><br>
                                        <i class="fas fa-user me-1"></i>{{ $jobOffer->job->user->name }}<br>
                                        <i class="fas fa-envelope me-1"></i>{{ $jobOffer->job->user->email }}<br>
                                        @if($jobOffer->job->user->phone)
                                            <i class="fas fa-phone me-1"></i>{{ $jobOffer->job->user->phone }}
                                        @endif
                                    </div>

                                    @if($jobOffer->status === 'pending')
                                        <div class="d-flex gap-2">
                                            <form method="POST" action="{{ route('job-offers.accept', $jobOffer) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" 
                                                        onclick="return confirm('Are you sure you want to accept this job offer? You will become unavailable for other jobs.')">
                                                    <i class="fas fa-check me-1"></i>Accept Offer
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('job-offers.decline', $jobOffer) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to decline this job offer?')">
                                                    <i class="fas fa-times me-1"></i>Decline Offer
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($jobOffer->status === 'accepted')
                                        <div class="alert alert-success mb-0">
                                            <i class="fas fa-check-circle me-2"></i>
                                            You accepted this job offer on {{ $jobOffer->accepted_at->format('M d, Y g:i A') }}
                                        </div>
                                    @elseif($jobOffer->status === 'declined')
                                        <div class="alert alert-secondary mb-0">
                                            <i class="fas fa-times-circle me-2"></i>
                                            You declined this job offer on {{ $jobOffer->declined_at->format('M d, Y g:i A') }}
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