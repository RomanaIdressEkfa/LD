@extends('layouts.admin')
@section('content')
<div class="card-custom">
    <div class="p-4 border-bottom">
        <h5 class="fw-bold m-0">Edit Debate</h5>
    </div>
    <div class="p-4">
        <form action="{{ route('admin.debates.update', $debate->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $debate->title }}" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5" required>{{ $debate->description }}</textarea>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $debate->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="closed" {{ $debate->status == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <button class="btn btn-success">Update Debate</button>
        </form>
    </div>
</div>
@endsection