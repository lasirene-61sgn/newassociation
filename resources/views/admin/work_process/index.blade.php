@extends('admin.layout.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Work Process Media</h2>
        <a href="{{ route('admin.work_process.create') }}" class="btn btn-primary">Add New Media</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Media Preview</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workProcesses as $wp)
                <tr>
                    <td>{{ $wp->id }}</td>
                    <td>
                        @if(!empty($wp->images))
                            @foreach($wp->images as $mediaItem)
                                <img src="{{ Storage::url($mediaItem) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            @endforeach
                        @endif
                        @if(!empty($wp->videos))
                            @foreach($wp->videos as $mediaItem)
                                <video src="{{ Storage::url($mediaItem) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;" controls></video>
                            @endforeach
                        @endif
                        @if(empty($wp->images) && empty($wp->videos))
                            No media
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.work_process.edit', $wp->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.work_process.destroy', $wp->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $workProcesses->links() }}
    </div>
</div>
@endsection