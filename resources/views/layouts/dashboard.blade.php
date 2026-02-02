@extends('layouts.admin')

@section('admin-content')

<!-- 1. Stats Row -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold text-dark mb-1">{{ $debates->count() }}</h2>
            <div class="text-muted small fw-bold">TOTAL DEBATES</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold text-success mb-1">{{ \App\Models\User::count() }}</h2>
            <div class="text-muted small fw-bold">TOTAL USERS</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold text-primary mb-1">{{ \App\Models\Argument::where('side', 'pro')->count() }}</h2>
            <div class="text-muted small fw-bold">PRO ARGUMENTS</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4">
            <h2 class="fw-bold text-danger mb-1">{{ \App\Models\Argument::where('side', 'con')->count() }}</h2>
            <div class="text-muted small fw-bold">CON ARGUMENTS</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- 2. Create Debate Form -->
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold m-0"><i class="fa-solid fa-pen-to-square text-primary me-2"></i> Create New Debate</h5>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.debate.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Debate Title</label>
                        <input type="text" name="title" class="form-control form-control-lg bg-light border-0" placeholder="e.g. Is AI dangerous?" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Description</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="4" placeholder="Enter debate context..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
                        Launch Debate
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- 3. History List -->
    <div class="col-lg-4">
        <div class="card-custom h-100">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold m-0">History</h5>
            </div>
            <div class="p-2">
                @foreach($debates as $d)
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-bold text-dark">{{ Str::limit($d->title, 25) }}</div>
                        <small class="text-muted">{{ $d->created_at->format('d M Y') }}</small>
                    </div>
                    @if($d->status == 'active')
                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Closed</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection