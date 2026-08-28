@extends('admin.layout.app')
@section('title', 'Add Labh')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add Labh</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.labh.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Heading</label>
                <input type="text" name="heading" class="form-control" value="{{ old('heading') }}">
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