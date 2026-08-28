@extends('admin.layout.app')
@section('title', 'Add ' . ucfirst('vision'))
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add {{ ucfirst('vision') }}</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.vision.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Images</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection