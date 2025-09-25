@extends('layouts.admin')

@section('title', 'Reports & Disputes')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reports & Disputes</h2>
        <form class="d-flex" method="get">
            <select class="form-select me-2" name="status">
                <option value="">All</option>
                <option value="open" @selected(request('status')==='open')>Open</option>
                <option value="resolved" @selected(request('status')==='resolved')>Resolved</option>
                <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
            </select>
            <button class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reporter</th>
                    <th>Reported Worker</th>
                    <th>Reason</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->reporter_name ?? $r->reporter_id }}</td>
                    <td>{{ $r->subject_name ?? ($r->reportable_type.'#'.$r->reportable_id) }}</td>
                    <td>{{ $r->reason }}</td>
                    <td class="small text-muted" style="max-width: 280px; white-space: normal;">{{ $r->details }}</td>
                    <td><span class="badge text-bg-secondary text-capitalize">{{ $r->status }}</span></td>
                    <td>{{ $r->created_at }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.reports.update-status', $r->id) }}" class="d-flex gap-2 align-items-center">
                            @csrf
                            <select class="form-select form-select-sm" name="status">
                                <option value="open" @selected($r->status==='open')>Open</option>
                                <option value="resolved" @selected($r->status==='resolved')>Resolved</option>
                                <option value="rejected" @selected($r->status==='rejected')>Rejected</option>
                            </select>
                            <button class="btn btn-sm btn-outline-primary">Update</button>
                            @if($r->reportable_type === App\Models\User::class)
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#warn{{ $r->id }}">Warn Worker</button>
                            @endif
                        </form>
                        @if($r->reportable_type === App\Models\User::class)
                        <div class="modal fade" id="warn{{ $r->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header"><h5 class="modal-title">Send Warning to {{ $r->subject_name ?? ('User#'.$r->reportable_id) }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="post" action="{{ route('admin.warn-user', $r->reportable_id) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <textarea name="message" class="form-control" rows="4" required placeholder="Enter warning message..."></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning">Send Warning</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $reports->links() }}
</div>
@endsection


