@extends('layouts.admin')

@section('title', 'Manage Jobs')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Jobs</h2>
        <div>
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.jobs') }}">Export CSV</a>
        </div>
    </div>

    <form class="row g-2 mb-3" method="get">
        <div class="col-md-4">
            <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search title">
        </div>
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">All statuses</option>
                <option value="active" @selected(request('status')==='active')>Active</option>
                <option value="completed" @selected(request('status')==='completed')>Completed</option>
                <option value="pending" @selected(request('status')==='pending')>Pending</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle admin-card">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Status</th>
                    <th>Start</th>
                    <th>End</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $j)
                <tr>
                    <td>{{ $j->id }}</td>
                    <td>{{ $j->title }}</td>
                    <td>{{ optional($j->user)->email }}</td>
                    <td><span class="badge text-bg-secondary text-capitalize">{{ $j->status }}</span></td>
                    <td>{{ $j->start_date }}</td>
                    <td>{{ $j->end_date }}</td>
                    <td class="text-nowrap">
                        <form method="post" action="{{ route('admin.jobs.force-close', $j) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-warning" @disabled($j->status==='completed')>Force Close</button>
                        </form>
                        <form method="post" action="{{ route('admin.jobs.delete', $j) }}" class="d-inline" onsubmit="return confirm('Delete job?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $jobs->links() }}
</div>
@endsection


