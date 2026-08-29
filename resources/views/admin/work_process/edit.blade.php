@extends('admin.layout.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Work Process Media</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.work_process.update', $work_process->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Current Images</label>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @if(!empty($work_process->images))
                        @foreach($work_process->images as $mediaItem)
                            <div class="position-relative">
                                <img src="{{ Storage::url($mediaItem) }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                <div>
                                    <input type="checkbox" name="removed_images[]" value="{{ $mediaItem }}"> Remove
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No images uploaded yet.</p>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label>Current Videos</label>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @if(!empty($work_process->videos))
                        @foreach($work_process->videos as $mediaItem)
                            <div class="position-relative">
                                <video src="{{ Storage::url($mediaItem) }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;" controls></video>
                                <div>
                                    <input type="checkbox" name="removed_videos[]" value="{{ $mediaItem }}"> Remove
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No videos uploaded yet.</p>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label>Add New Images</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            </div>
            <div class="mb-3">
                <label>Add New Videos</label>
                <input type="file" name="videos[]" class="form-control" multiple accept="video/*">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.work_process.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection