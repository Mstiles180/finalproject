@extends('layouts.admin')

@section('title', 'Cells')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Cells</h2>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.cells') }}">Export CSV</a>
            <form class="d-flex" method="post" action="{{ route('admin.cells.store') }}">
                @csrf
                <input class="form-control me-2" name="name" placeholder="Name" required>
                <select class="form-select me-2" name="sector_id" required>
                    <option value="">Sector</option>
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
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
                    <th>Sector</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cells as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ optional($c->sector)->name }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.cells.delete', $c) }}" onsubmit="return confirm('Delete?')">
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

    {{ $cells->links() }}
</div>
@endsection


