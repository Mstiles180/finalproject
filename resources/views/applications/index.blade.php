@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-file-alt me-2"></i>My Applications</h2>
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-search me-2"></i>Browse More Jobs
                </a>
            </div>

            @if($applications->count() === 0)
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Applications Yet</h4>
                        <p class="text-muted">You haven't applied to any jobs yet. Start by browsing available opportunities!</p>
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Browse Jobs
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
                                        <th>Employer</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Applied</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>
                                                <a href="{{ route('jobs.show', $application->job) }}" class="text-decoration-none">
                                                    {{ $application->job->title }}
                                                </a>
                                            </td>
                                            <td>{{ $application->job->user->name }}</td>
                                            <td>{{ $application->job->location }}</td>
                                            <td>{!! $application->status_badge !!}</td>
                                            <td>{{ $application->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('applications.destroy', $application) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to withdraw this application?')">
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
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 