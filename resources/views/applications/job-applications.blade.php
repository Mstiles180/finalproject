@extends('layouts.app')

@section('title', 'Applications - ' . $job->title)

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-file-alt me-2"></i>Job Applications</h2>
                    <p class="text-muted mb-0">{{ $job->title }}</p>
                </div>
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Job
                </a>
            </div>

            @if($applications->count() === 0)
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Applications Yet</h4>
                        <p class="text-muted">No one has applied to this job yet.</p>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Email</th>
                                        <th>Phone</th>
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
                                                <strong>{{ $application->user->name }}</strong>
                                            </td>
                                            <td>{{ $application->user->email }}</td>
                                            <td>{{ $application->user->phone ?? 'N/A' }}</td>
                                            <td>{{ $application->user->location ?? 'N/A' }}</td>
                                            <td>{!! $application->status_badge !!}</td>
                                            <td>{{ $application->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#applicationModal{{ $application->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if($application->status === 'pending')
                                                        <form method="POST" action="{{ route('applications.update', $application) }}" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="accepted">
                                                            <button type="submit" class="btn btn-outline-success" onclick="return confirm('Accept this application?')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('applications.update', $application) }}" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Reject this application?')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
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

<!-- Application Detail Modals -->
@foreach($applications as $application)
<div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Application Details - {{ $application->user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Applicant Information</h6>
                        <p><strong>Name:</strong> {{ $application->user->name }}</p>
                        <p><strong>Email:</strong> {{ $application->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $application->user->phone ?? 'N/A' }}</p>
                        <p><strong>Location:</strong> {{ $application->user->location ?? 'N/A' }}</p>
                        @if($application->user->category)
                            <p><strong>Category:</strong> {{ $application->user->category }}</p>
                        @endif
                        @if($application->user->daily_rate)
                            <p><strong>Daily Rate:</strong> RWF {{ number_format($application->user->daily_rate, 0) }}/day</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Application Details</h6>
                        <p><strong>Status:</strong> {!! $application->status_badge !!}</p>
                        <p><strong>Applied:</strong> {{ $application->created_at->format('M d, Y g:i A') }}</p>
                        @if($application->updated_at !== $application->created_at)
                            <p><strong>Last Updated:</strong> {{ $application->updated_at->format('M d, Y g:i A') }}</p>
                        @endif
                    </div>
                </div>
                <hr>
                <div>
                    <h6>Cover Letter</h6>
                    <div class="border rounded p-3 bg-light">
                        {{ $application->cover_letter }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if($application->status === 'pending')
                    <form method="POST" action="{{ route('applications.update', $application) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Accept this application?')">
                            <i class="fas fa-check me-2"></i>Accept Application
                        </button>
                    </form>
                    <form method="POST" action="{{ route('applications.update', $application) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this application?')">
                            <i class="fas fa-times me-2"></i>Reject Application
                        </button>
                    </form>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection 