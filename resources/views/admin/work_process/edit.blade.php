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
                <label>Current Media</label>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @if(!empty($work_process->media))
                        @foreach($work_process->media as $mediaItem)
                            @php
                                $ext = pathinfo($mediaItem, PATHINFO_EXTENSION);
                                $isVideo = in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'wmv']);
                            @endphp
                            <div class="position-relative">
                                @if($isVideo)
                                    <video src="{{ Storage::url($mediaItem) }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;" controls></video>
                                @else
                                    <img src="{{ Storage::url($mediaItem) }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                                <div>
                                    <input type="checkbox" name="removed_media[]" value="{{ $mediaItem }}"> Remove
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No media uploaded yet.</p>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label>Add New Media (Images/Videos)</label>
                <input type="file" name="media[]" class="form-control" multiple accept="image/*,video/*">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.work_process.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection