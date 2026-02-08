@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.debates.index') }}" class="btn btn-light border text-muted mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i> Back to Debates
    </a>
    <h4 class="fw-bold text-dark">{{ $debate->title }}</h4>
    <p class="text-muted">Total Participants: {{ $debate->participants->count() }}</p>
</div>

<div class="row">
    <!-- AGREED / PRO SECTION -->
    <div class="col-lg-6 mb-4">
        <div class="card-custom h-100 border-top border-4 border-primary shadow-sm">
            <div class="p-4 border-bottom bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0 text-primary">
                    <i class="fa-solid fa-thumbs-up me-2"></i> AGREED ({{ $agreed->count() }})
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">User Name</th>
                            <th>Email (Generated)</th>
                            <th>Joined At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agreed as $participant)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $participant->user->avatar ? asset('storage/'.$participant->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($participant->user->name) }}" 
                                         class="rounded-circle me-2 border" width="35" height="35">
                                    <span class="fw-bold text-dark">{{ $participant->user->name }}</span>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $participant->user->email }}</td>
                            <td class="small text-muted">{{ $participant->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                No participants agreed yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DISAGREED / CON SECTION -->
    <div class="col-lg-6 mb-4">
        <div class="card-custom h-100 border-top border-4 border-danger shadow-sm">
            <div class="p-4 border-bottom bg-danger bg-opacity-10 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0 text-danger">
                    <i class="fa-solid fa-thumbs-down me-2"></i> DISAGREED ({{ $disagreed->count() }})
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">User Name</th>
                            <th>Email (Generated)</th>
                            <th>Joined At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($disagreed as $participant)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $participant->user->avatar ? asset('storage/'.$participant->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($participant->user->name) }}" 
                                         class="rounded-circle me-2 border" width="35" height="35">
                                    <span class="fw-bold text-dark">{{ $participant->user->name }}</span>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $participant->user->email }}</td>
                            <td class="small text-muted">{{ $participant->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                No participants disagreed yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection