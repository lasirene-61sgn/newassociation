@extends('admin.layout.app')
@section('title', 'Labh List')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Labh List</h2>
        <a href="{{ route('admin.labh.create') }}" class="btn btn-primary">Add New Labh</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Heading</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($labhs as $labh)
                <tr>
                    <td>{{ $labh->id }}</td>
                    <td>{{ $labh->heading }}</td>
                    <td>{{ Str::limit($labh->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.labh.edit', $labh->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.labh.destroy', $labh->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $labhs->links() }}
    </div>
</div>
@endsection