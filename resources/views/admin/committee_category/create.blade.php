@extends('admin.layout.app')
@section('title', 'Add Committee Category')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add Committee Category</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.committee_category.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection