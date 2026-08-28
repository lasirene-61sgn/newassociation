@extends('admin.layout.app')
@section('title', 'Edit ' . ucfirst('vision'))
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit {{ ucfirst('vision') }}</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.vision.update', $vision->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Current Images</label>
                <div class="d-flex flex-wrap">
                    @if(!empty($vision->images))
                        @foreach($vision->images as $img)
                            <div class="me-2 mb-2">
                                <img src="{{ asset('storage/' . $img) }}" width="100" height="100"><br>
                                <input type="checkbox" name="removed_images[]" value="{{ $img }}"> Remove
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label>Add New Images</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $vision->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection