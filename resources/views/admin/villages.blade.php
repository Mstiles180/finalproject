@extends('layouts.admin')

@section('title', 'Villages')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Villages</h2>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.villages') }}">Export CSV</a>
            <form class="d-flex" method="post" action="{{ route('admin.villages.store') }}">
                @csrf
                <input class="form-control me-2" name="name" placeholder="Name" required>
                <select class="form-select me-2" name="cell_id" required>
                    <option value="">Cell</option>
                    @foreach($cells as $cell)
                        <option value="{{ $cell->id }}">{{ $cell->name }}</option>
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
                    <th>Cell</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($villages as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->name }}</td>
                    <td>{{ optional($v->cell)->name }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.villages.delete', $v) }}" onsubmit="return confirm('Delete?')">
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

    {{ $villages->links() }}
</div>
@endsection


