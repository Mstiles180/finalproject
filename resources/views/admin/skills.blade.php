@extends('layouts.admin')

@section('title', 'Skills')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Skills</h2>
        <form class="d-flex" method="post" action="{{ route('admin.skills.store') }}">
            @csrf
            <input class="form-control me-2" name="name" placeholder="Skill name" required>
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
                @foreach($skills as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.skills.delete', $s->id) }}" onsubmit="return confirm('Delete?')">
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

    {{ $skills->links() }}
</div>
@endsection


