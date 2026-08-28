@extends('admin.layout.app')
@section('title', 'Committee Category List')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Committee Category List</h2>
        <a href="{{ route('admin.committee_category.create') }}" class="btn btn-primary">Add New Category</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ ucfirst($cat->status) }}</td>
                    <td>
                        <a href="{{ route('admin.committee_category.edit', $cat->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.committee_category.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>
@endsection