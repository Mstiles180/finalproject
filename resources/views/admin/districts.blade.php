@extends('layouts.admin')

@section('title', 'Districts')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Districts</h2>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.districts') }}">Export CSV</a>
            <form class="d-flex" method="post" action="{{ route('admin.districts.store') }}">
                @csrf
                <input class="form-control me-2" name="name" placeholder="Name" required>
                <input class="form-control me-2" name="code" placeholder="Code" required>
                <select class="form-select me-2" name="province_id" required>
                    <option value="">Province</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Province</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($districts as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->code }}</td>
                    <td>{{ optional($d->province)->name }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.districts.delete', $d) }}" onsubmit="return confirm('Delete?')">
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

    {{ $districts->links() }}
</div>
@endsection


