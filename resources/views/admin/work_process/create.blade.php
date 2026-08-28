@extends('admin.layout.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add Work Process Media</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.work_process.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Media (Images/Videos)</label>
                <input type="file" name="media[]" class="form-control" multiple accept="image/*,video/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.work_process.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection