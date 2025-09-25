@extends('layouts.admin')

@section('title', 'User Verifications')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>User Verifications</h2>
        <form class="d-flex" method="get">
            <select class="form-select me-2" name="status">
                <option value="">All</option>
                <option value="0" @selected(request('status')==='0')>Unverified</option>
                <option value="1" @selected(request('status')==='1')>Verified</option>
            </select>
            <button class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Document</th>
                    <th>Verified</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @if($u->document_url)
                            <a href="{{ $u->document_url }}" target="_blank">View</a>
                        @endif
                    </td>
                    <td>{{ $u->is_verified ? 'Yes' : 'No' }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.verifications.set', $u) }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="verified" value="{{ $u->is_verified ? 0 : 1 }}">
                            <button class="btn btn-sm {{ $u->is_verified ? 'btn-warning' : 'btn-success' }}">
                                {{ $u->is_verified ? 'Unverify' : 'Verify' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection


