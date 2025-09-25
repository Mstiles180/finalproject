@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Admin Dashboard</h2>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-sm btn-gradient" href="{{ route('admin.export.users') }}"><i class="fas fa-file-export me-1"></i>Users CSV</a>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.export.jobs') }}">Jobs CSV</a>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.export.offers') }}">Offers CSV</a>
            
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card admin-card p-3">
                <div class="text-muted">Active Jobs</div>
                <div class="fs-3 fw-bold">{{ $activeJobs }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card p-3">
                <div class="text-muted">Completed Jobs</div>
                <div class="fs-3 fw-bold">{{ $completedJobs }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card p-3">
                <div class="text-muted">Active Workers</div>
                <div class="fs-3 fw-bold">{{ $activeWorkers }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card p-3">
                <div class="text-muted">Employers</div>
                <div class="fs-3 fw-bold">{{ $bosses }}</div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h5 class="section-title">Administrative Data</h5>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.provinces') }}">Provinces</a>
            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.districts') }}">Districts</a>
            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.sectors') }}">Sectors</a>
            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.cells') }}">Cells</a>
            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.villages') }}">Villages</a>
        </div>
    </div>
</div>
@endsection


