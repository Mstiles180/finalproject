@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h1><i class="fas fa-tachometer-alt me-2"></i>Employer Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="stats-card bg-primary text-white hover-lift">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">{{ $totalJobs }}</h2>
                        <p class="mb-0 opacity-90">Total Jobs Posted</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-briefcase fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="stats-card bg-success text-white hover-lift">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">{{ $totalApplications }}</h2>
                        <p class="mb-0 opacity-90">Total Job Offers Sent</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-paper-plane fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="stats-card bg-info text-white hover-lift">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">{{ $recentJobs->where('status', 'active')->count() }}</h2>
                        <p class="mb-0 opacity-90">Active Jobs</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 animate-fade-in-up" style="animation-delay: 0.4s;">
            <div class="stats-card bg-warning text-white hover-lift">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">{{ $activeWorkers }}</h2>
                        <p class="mb-0 opacity-90">Active Workers</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if($pendingFeedback > 0)
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                <div>
                    <strong>Pending Feedback!</strong> You have {{ $pendingFeedback }} completed job{{ $pendingFeedback > 1 ? 's' : '' }} that need{{ $pendingFeedback > 1 ? '' : 's' }} your feedback.
                    <a href="{{ route('history.index') }}" class="btn btn-warning btn-sm ms-3">
                        <i class="fas fa-star me-1"></i>Give Feedback
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-plus me-2"></i>Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Post New Job
                        </a>
                        <a href="{{ route('jobs.my-jobs') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>View My Jobs
                        </a>
                        <a href="{{ route('jobs.active-workers') }}" class="btn btn-outline-warning">
                            <i class="fas fa-users me-2"></i>Active Workers
                        </a>
                        <a href="{{ route('history.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-history me-2"></i>Work History
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-chart-bar me-2"></i>AI Insights</h5>
                    <p class="text-muted">Get AI-powered insights about your job postings and applications.</p>
                    <button class="btn btn-outline-info" onclick="showAIRecommendations()">
                        <i class="fas fa-robot me-2"></i>View AI Recommendations
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Job Postings -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Job Postings</h5>
        </div>
        <div class="card-body">
            @if($recentJobs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Status</th>
                                                                 <th>Offers Sent</th>
                                <th>Posted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentJobs as $job)
                                <tr>
                                    <td>
                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                            {{ $job->title }}
                                        </a>
                                    </td>
                                    <td>{{ $job->location }}</td>
                                    <td>
                                        @if($job->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($job->status === 'inactive')
                                            <span class="badge bg-secondary">Inactive</span>
                                        @elseif($job->status === 'completed')
                                            <span class="badge bg-info">Completed</span>
                                        @else
                                            <span class="badge bg-primary">Filled</span>
                                        @endif
                                    </td>
                                                                         <td>
                                         <a href="{{ route('applications.job-applications', $job) }}" class="text-decoration-none">
                                             {{ $job->applications_count }} offers sent
                                         </a>
                                     </td>
                                    <td>{{ $job->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                    <h5>No jobs posted yet</h5>
                    <p class="text-muted">Start by posting your first job opportunity!</p>
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Post Your First Job
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- AI Insights & Recommendations Placeholder -->
    <div class="card mt-4" id="aiInsights" style="display: none;">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-robot me-2"></i>AI Insights & Recommendations</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Job Performance Analysis</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-chart-line text-success me-2"></i>Your "Software Developer" job has high engagement</li>
                        <li><i class="fas fa-users text-info me-2"></i>Consider adding more details to attract better candidates</li>
                        <li><i class="fas fa-clock text-warning me-2"></i>Jobs posted on Tuesdays get 15% more applications</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Recommended Actions</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-lightbulb text-primary me-2"></i>Add salary range to increase application quality</li>
                        <li><i class="fas fa-tags text-success me-2"></i>Use more specific skill requirements</li>
                        <li><i class="fas fa-map-marker-alt text-info me-2"></i>Consider remote work options</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showAIRecommendations() {
    const insights = document.getElementById('aiInsights');
    if (insights.style.display === 'none') {
        insights.style.display = 'block';
    } else {
        insights.style.display = 'none';
    }
}
</script>
@endsection 