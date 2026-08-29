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
                <label>Images</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            </div>
            <div class="mb-3">
                <label>Videos</label>
                <input type="file" name="videos[]" class="form-control" multiple accept="video/*">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.work_process.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection