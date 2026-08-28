@extends('admin.layout.app')
@section('title', 'Edit Labh')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Labh</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.labh.update', $labh->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Heading</label>
                <input type="text" name="heading" class="form-control" value="{{ old('heading', $labh->heading) }}">
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $labh->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection