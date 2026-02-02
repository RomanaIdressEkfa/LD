@extends('layouts.admin')
@section('content')
<div class="card-custom">
    <div class="p-4 border-bottom">
        <h5 class="fw-bold m-0">Create New Debate</h5>
    </div>
    <div class="p-4">
        <form action="{{ route('admin.debates.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-bold">Debate Title</label>
                <input type="text" name="title" class="form-control form-control-lg" placeholder="e.g. Is AI safe?" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <button class="btn btn-primary px-4">Launch Debate</button>
        </form>
    </div>
</div>
@endsection