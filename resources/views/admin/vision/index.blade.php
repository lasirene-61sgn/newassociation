@extends('admin.layout.app')
@section('title', ucfirst('vision') . ' List')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>{{ ucfirst('vision') }} List</h2>
        <a href="{{ route('admin.vision.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Images</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visions as $vision)
                <tr>
                    <td>{{ $vision->id }}</td>
                    <td>
                        @if(!empty($vision->images))
                            @foreach($vision->images as $img)
                                <img src="{{ asset('storage/' . $img) }}" width="50" height="50" class="me-1">
                            @endforeach
                        @endif
                    </td>
                    <td>{{ Str::limit($vision->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.vision.edit', $vision->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.vision.destroy', $vision->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $visions->links() }}
    </div>
</div>
@endsection