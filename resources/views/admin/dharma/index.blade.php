@extends('admin.layout.app')
@section('title', ucfirst('dharma') . ' List')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>{{ ucfirst('dharma') }} List</h2>
        <a href="{{ route('admin.dharma.create') }}" class="btn btn-primary">Add New</a>
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
                @foreach($dharmas as $dharma)
                <tr>
                    <td>{{ $dharma->id }}</td>
                    <td>
                        @if(!empty($dharma->images))
                            @foreach($dharma->images as $img)
                                <img src="{{ asset('storage/' . $img) }}" width="50" height="50" class="me-1">
                            @endforeach
                        @endif
                    </td>
                    <td>{{ Str::limit($dharma->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.dharma.edit', $dharma->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.dharma.destroy', $dharma->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dharmas->links() }}
    </div>
</div>
@endsection