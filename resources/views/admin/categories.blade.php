@extends('layouts.admin')

@section('title', 'Job Categories')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Job Categories</h2>
        <form class="d-flex" method="post" action="{{ route('admin.categories.store') }}">
            @csrf
            <input class="form-control me-2" name="name" placeholder="Category name" required>
            <button class="btn btn-primary">Add</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->name }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.categories.delete', $c->id) }}" onsubmit="return confirm('Delete?')">
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

    {{ $categories->links() }}
</div>
@endsection


