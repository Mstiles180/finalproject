@extends('layouts.admin')

@section('title', 'Manage Applications')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Applications</h2>
        <div>
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.applications') }}">Export CSV</a>
        </div>
    </div>

    <form class="row g-2 mb-3" method="get">
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">All statuses</option>
                <option value="pending" @selected(request('status')==='pending')>Pending</option>
                <option value="accepted" @selected(request('status')==='accepted')>Accepted</option>
                <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
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
                    <th>Job</th>
                    <th>Applicant</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>{{ optional($a->job)->title }}</td>
                    <td>{{ optional($a->user)->email }}</td>
                    <td><span class="badge text-bg-secondary text-capitalize">{{ $a->status }}</span></td>
                    <td>{{ $a->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $applications->links() }}
</div>
@endsection


