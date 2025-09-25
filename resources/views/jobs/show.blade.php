@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Job Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $job->title }}</h3>
                        @auth
                            @if(auth()->user()->id === $job->user_id)
                                <div class="btn-group">
                                    <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form method="POST" action="{{ route('jobs.destroy', $job) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this job?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6><i class="fas fa-building me-2"></i>Employer</h6>
                            <p class="text-muted mb-1">{{ $job->user->name }}</p>
                            @if($job->user->phone)
                                <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $job->user->phone }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-map-marker-alt me-2"></i>Location</h6>
                            <p class="text-muted">{{ $job->location }}</p>
                        </div>
                    </div>
                    
                    @if($job->pickupPoint)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6><i class="fas fa-location-arrow me-2"></i>Pickup Point</h6>
                            <p class="text-muted">
                                <strong>{{ $job->pickupPoint->name }}</strong><br>
                                <small>{{ $job->pickupPoint->location_description }}</small>
                            </p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar me-2"></i>Date Range</h6>
                            <p class="text-muted">{{ $job->date_range_text }}</p>
                            @if($job->isMultiDayJob())
                                <small class="text-info"><i class="fas fa-info-circle me-1"></i>{{ $job->duration_text }} duration</small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-clock me-2"></i>Daily Schedule</h6>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($job->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($job->end_time)->format('g:i A') }}</p>
                            @if($job->isLongTermJob())
                                <small class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Long-term job</small>
                            @endif
                        </div>
                    </div>

                    @if($job->isMultiDayJob() && $job->work_schedule)
                        <div class="mb-3">
                            <h6><i class="fas fa-calendar-week me-2"></i>Work Schedule</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($job->work_schedule as $schedule)
                                            <tr>
                                                <td>{{ $schedule['day_name'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($schedule['date'])->format('M d, Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($schedule['start_time'])->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule['end_time'])->format('g:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                                                    <h6><i class="fas fa-dollar-sign me-2"></i>Daily Rate</h6>
                        <p class="text-muted">RWF {{ number_format($job->daily_rate, 0) }}/day</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-calculator me-2"></i>Total Amount</h6>
                            <p class="text-muted">{{ $job->total_amount }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-tags me-2"></i>Category</h6>
                        <p class="text-muted">{{ ucfirst($job->category) }}{{ $job->other_category ? ' - ' . $job->other_category : '' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-file-alt me-2"></i>Job Description</h6>
                        <div class="text-muted">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Posted {{ $job->created_at->diffForHumans() }}
                        </small>
                        <span class="badge bg-{{ $job->status === 'active' ? 'success' : ($job->status === 'inactive' ? 'secondary' : ($job->status === 'completed' ? 'info' : 'primary')) }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Application Form for Workers -->
            @auth
                @if(auth()->user()->isWorker() && $job->status === 'active')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Apply for this Position</h5>
                        </div>
                        <div class="card-body">
                            @if($hasApplied)
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>You have already applied for this position.
                                </div>
                            @else
                                <form method="POST" action="{{ route('applications.store', $job) }}">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="cover_letter" class="form-label">Cover Letter *</label>
                                        <textarea class="form-control @error('cover_letter') is-invalid @enderror" 
                                                  id="cover_letter" name="cover_letter" rows="6" required 
                                                  placeholder="Tell us why you're the perfect candidate for this position...">{{ old('cover_letter') }}</textarea>
                                        <div class="form-text">Minimum 50 characters. Explain your relevant experience and why you're interested in this role.</div>
                                        @error('cover_letter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Interested in this position?</h5>
                        <p class="text-muted">Sign up or log in to apply for this job.</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
        
        <div class="col-lg-4">
            <!-- Job Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Job Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Job Offers Sent</span>
                        <span class="badge bg-primary">{{ $job->jobOffers->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Accepted Offers</span>
                        <span class="badge bg-success">{{ $job->jobOffers->where('status', 'accepted')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>
                        <span class="badge bg-{{ $job->status === 'active' ? 'success' : ($job->status === 'inactive' ? 'secondary' : ($job->status === 'completed' ? 'info' : 'primary')) }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Posted</span>
                        <small class="text-muted">{{ $job->created_at->format('M d, Y') }}</small>
                    </div>
                    
                    @auth
                        @if(auth()->user()->isBoss() && auth()->user()->id === $job->user_id)
                            <hr>
                            <a href="{{ route('job-offers.job-offers', $job) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-users me-2"></i>View Job Offers
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- AI Insights Placeholder -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-robot me-2"></i>AI Insights</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Skill Match Score</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" style="width: 85%">85%</div>
                        </div>
                        <small class="text-muted">Based on your profile</small>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Market Demand</h6>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-arrow-up text-success me-2"></i>
                            <span class="text-success">High demand for this role</span>
                        </div>
                    </div>
                    
                    <div>
                        <h6>Recommended Actions</h6>
                        <ul class="list-unstyled small">
                            <li><i class="fas fa-check text-success me-2"></i>Highlight relevant experience</li>
                            <li><i class="fas fa-check text-success me-2"></i>Mention specific skills</li>
                            <li><i class="fas fa-check text-success me-2"></i>Show enthusiasm for the role</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 