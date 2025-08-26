@extends('layouts.app')

@section('title', 'Browse Jobs')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-briefcase me-2"></i>Browse Jobs</h1>
        @auth
            @if(auth()->user()->isBoss())
                <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Post a Job
                </a>
            @endif
        @endauth
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('jobs.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Jobs</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search by title, description, or location">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        <option value="laundry" {{ request('category') == 'laundry' ? 'selected' : '' }}>Laundry</option>
                        <option value="builder" {{ request('category') == 'builder' ? 'selected' : '' }}>Builder</option>
                        <option value="builder_helper" {{ request('category') == 'builder_helper' ? 'selected' : '' }}>Builder Helper</option>
                        <option value="farmer" {{ request('category') == 'farmer' ? 'selected' : '' }}>Farmer</option>
                        <option value="cleaner" {{ request('category') == 'cleaner' ? 'selected' : '' }}>Cleaner</option>
                        <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" 
                           value="{{ request('location') }}" placeholder="Enter location">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($jobs->count() > 0)
                <div class="row g-4">
                    @foreach($jobs as $job)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                            {{ $job->title }}
                                        </a>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <i class="fas fa-building me-1"></i>{{ $job->user->name }}
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                                        </span>
                                        <span class="badge bg-primary me-1">
                                            <i class="fas fa-tag me-1"></i>{{ ucfirst($job->category) }}
                                        </span>
                                        <span class="badge bg-success">
                                            <i class="fas fa-dollar-sign me-1"></i>RWF {{ number_format($job->daily_rate, 0) }}/day
                                        </span>
                                    </div>
                                    
                                    <p class="card-text text-muted">
                                        {{ Str::limit($job->description, 120) }}
                                    </p>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <strong>Duration:</strong> {{ $job->duration_text }} | 
                                            <strong>Date:</strong> {{ $job->date_range_text }} | 
                                            <strong>Time:</strong> {{ \Carbon\Carbon::parse($job->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($job->end_time)->format('g:i A') }}
                                        </small>
                                        @if($job->isLongTermJob())
                                            <br><small class="text-warning"><i class="fas fa-clock me-1"></i>Long-term job</small>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                                        </small>
                                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>No jobs found</h4>
                    <p class="text-muted">Try adjusting your search criteria or check back later for new opportunities.</p>
                    @auth
                        @if(auth()->user()->isBoss())
                            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Post the First Job
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <!-- AI Recommendations Placeholder for Workers -->
    @auth
        @if(auth()->user()->isWorker() && $jobs->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-robot me-2"></i>AI-Powered Recommendations</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Based on your profile and preferences, here are some jobs you might be interested in:</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="card-title">Senior Laravel Developer</h6>
                                    <p class="card-text text-muted">TechCorp Inc.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary">95% Match</span>
                                        <small class="text-muted">Remote</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h6 class="card-title">Full Stack Developer</h6>
                                    <p class="card-text text-muted">StartupXYZ</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-success">88% Match</span>
                                        <small class="text-muted">New York</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h6 class="card-title">Web Application Developer</h6>
                                    <p class="card-text text-muted">Digital Solutions</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-info">82% Match</span>
                                        <small class="text-muted">San Francisco</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
</div>
@endsection 