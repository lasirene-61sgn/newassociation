@extends('admin.layout.app')
@section('title', 'Edit Committee Category')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Committee Category</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.committee_category.update', $committee_category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $committee_category->name) }}" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $committee_category->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $committee_category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection