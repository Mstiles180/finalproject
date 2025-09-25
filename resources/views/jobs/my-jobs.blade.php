@extends('layouts.app')

@section('title', 'My Jobs')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-briefcase me-2"></i>My Jobs</h2>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Post New Job
                </a>
            </div>

            @if($jobs->count() === 0)
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Jobs Posted Yet</h4>
                        <p class="text-muted">You haven't posted any jobs yet. Start by creating your first job opportunity!</p>
                        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Post Your First Job
                        </a>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Job Offers</th>
                                        <th>Posted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $job)
                                        <tr>
                                            <td>
                                                <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                                    {{ $job->title }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($job->category === 'other')
                                                    {{ $job->other_category }}
                                                @else
                                                    {{ ucfirst(str_replace('_', ' ', $job->category)) }}
                                                @endif
                                            </td>
                                            <td>{{ $job->location }}</td>
                                            <td>
                                                {{ $job->date_range_text }}
                                                @if($job->isMultiDayJob())
                                                    <br><small class="text-info">{{ $job->duration_text }}</small>
                                                @endif
                                            </td>
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
                                                <a href="{{ route('job-offers.index') }}" class="text-decoration-none">
                                                    {{ $job->job_offers_count }} offers
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
                                                    <form method="POST" action="{{ route('jobs.destroy', $job) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this job?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 