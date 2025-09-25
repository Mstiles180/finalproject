@extends('layouts.admin')

@section('title', 'Manage Offers')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Job Offers</h2>
        <div>
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.offers') }}">Export CSV</a>
        </div>
    </div>

    <form class="row g-2 mb-3" method="get">
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">All statuses</option>
                <option value="pending" @selected(request('status')==='pending')>Pending</option>
                <option value="accepted" @selected(request('status')==='accepted')>Accepted</option>
                <option value="declined" @selected(request('status')==='declined')>Declined</option>
                <option value="completed" @selected(request('status')==='completed')>Completed</option>
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
                    <th>Worker</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offers as $o)
                <tr>
                    <td>{{ $o->id }}</td>
                    <td>{{ optional($o->job)->title }}</td>
                    <td>{{ optional($o->worker)->email }}</td>
                    <td><span class="badge text-bg-secondary text-capitalize">{{ $o->status }}</span></td>
                    <td>{{ $o->created_at }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.offers.reassign', $o) }}" class="d-flex align-items-center gap-2">
                            @csrf
                            <input class="form-control form-control-sm" name="worker_id" placeholder="Worker ID" style="width: 140px;">
                            <button class="btn btn-sm btn-outline-primary">Reassign</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $offers->links() }}
</div>
@endsection


