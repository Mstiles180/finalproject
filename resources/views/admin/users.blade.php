@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Users</h2>
        <form class="d-flex" method="get">
            <input class="form-control me-2" type="text" name="q" value="{{ request('q') }}" placeholder="Search name, email, phone">
            <select class="form-select me-2" name="role">
                <option value="">All roles</option>
                <option value="worker" @selected(request('role')==='worker')>Worker</option>
                <option value="boss" @selected(request('role')==='boss')>Employer</option>
                <option value="admin" @selected(request('role')==='admin')>Admin</option>
            </select>
            <button class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle admin-card">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Available</th>
                    <th>Suspended</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge text-bg-secondary text-capitalize">{{ $u->role }}</span></td>
                    <td>{{ $u->phone }}</td>
                    <td>{{ $u->location }}</td>
                    <td>{{ $u->is_available ? 'Yes' : 'No' }}</td>
                    <td>{{ ($u->is_suspended ?? false) ? 'Yes' : 'No' }}</td>
                    <td class="text-nowrap">
                        @if(!($u->isAdmin() && auth()->id() === $u->id))
                        <form action="{{ route('admin.users.toggle-suspend', $u) }}" method="post" class="d-inline">
                            @csrf
                            <button class="btn btn-sm {{ ($u->is_suspended ?? false) ? 'btn-success' : 'btn-warning' }}">
                                {{ ($u->is_suspended ?? false) ? 'Activate' : 'Suspend' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.reset-password', $u) }}" method="post" class="d-inline" onsubmit="return confirm('Reset password?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary">Reset Password</button>
                        </form>
                        @endif
                        @if($u->role==='worker')
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#photosModal{{ $u->id }}">Photos</button>
                        @endif
                    </td>
                </tr>
                @if($u->role==='worker')
                <tr>
                    <td colspan="9">
                        <div class="modal fade" id="photosModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Worker Photos - {{ $u->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="{{ route('admin.users.update-photos', $u) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body" style="max-height:70vh; overflow:auto;">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">National ID Image</label>
                                                    <div class="border rounded p-2">
                                                        @if($u->nid_image_url)
                                                            <img src="{{ asset($u->nid_image_url) }}" alt="NID" style="max-width:100%; height:auto; max-height:220px; display:block; border-radius:6px;">
                                                            <a class="d-inline-block mt-2" href="{{ asset($u->nid_image_url) }}" target="_blank">Open</a>
                                                        @else
                                                            <div class="text-muted small">No NID image uploaded.</div>
                                                        @endif
                                                    </div>
                                                    <input type="file" class="form-control mt-2" name="nid_image" accept="image/*">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Experience Image</label>
                                                    <div class="border rounded p-2">
                                                        @if($u->experience_image_url)
                                                            <img src="{{ asset($u->experience_image_url) }}" alt="Experience" style="max-width:100%; height:auto; max-height:220px; display:block; border-radius:6px;">
                                                            <a class="d-inline-block mt-2" href="{{ asset($u->experience_image_url) }}" target="_blank">Open</a>
                                                        @else
                                                            <div class="text-muted small">No experience image uploaded.</div>
                                                        @endif
                                                    </div>
                                                    <input type="file" class="form-control mt-2" name="experience_image" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection


