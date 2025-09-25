@extends('layouts.admin')

@section('title', 'Sectors')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sectors</h2>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.sectors') }}">Export CSV</a>
            <form class="d-flex" method="post" action="{{ route('admin.sectors.store') }}">
                @csrf
                <input class="form-control me-2" name="name" placeholder="Name" required>
                <select class="form-select me-2" name="district_id" required>
                    <option value="">District</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
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
                    <th>District</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sectors as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ optional($s->district)->name }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.sectors.delete', $s) }}" onsubmit="return confirm('Delete?')">
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

    {{ $sectors->links() }}
</div>
@endsection


