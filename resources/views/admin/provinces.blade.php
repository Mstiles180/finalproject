@extends('layouts.admin')

@section('title', 'Provinces')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Provinces</h2>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.export.provinces') }}">Export CSV</a>
            <form class="d-flex" method="post" action="{{ route('admin.provinces.store') }}">
                @csrf
                <input class="form-control me-2" name="name" placeholder="Name" required>
                <input class="form-control me-2" name="code" placeholder="Code" required>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($provinces as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->code }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.provinces.delete', $p) }}" onsubmit="return confirm('Delete?')">
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

    {{ $provinces->links() }}
</div>
@endsection


