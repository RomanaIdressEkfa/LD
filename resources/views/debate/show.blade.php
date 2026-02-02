@extends('layouts.app')

@section('content')
<style>
    .debate-header {
        background: linear-gradient(135deg, #1e1e2d 0%, #2c2c3e 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
    }
    .join-card {
        border: 2px dashed #ccc;
        background-color: #f8f9fa;
        transition: 0.3s;
        cursor: pointer;
    }
    .join-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .join-card-pro:hover { border-color: #198754; background-color: #e8f5e9; }
    .join-card-con:hover { border-color: #dc3545; background-color: #fbeaea; }
    
    .participant-badge { font-size: 0.85rem; padding: 5px 10px; border-radius: 20px; margin-bottom: 5px; display: inline-block;}
    .bg-pro { background-color: #d1e7dd; color: #0f5132; }
    .bg-con { background-color: #f8d7da; color: #842029; }
</style>

<!-- 1. HERO SECTION -->
<div class="debate-header text-center shadow-sm">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">{{ $debate->title }}</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 800px;">
            {{ $debate->description }}
        </p>

        <div class="d-flex justify-content-center gap-3 mt-4">
            @if($debate->isFull())
                <span class="badge bg-danger fs-6 px-3 py-2">Debate Full</span>
            @else
                <span class="badge bg-success fs-6 px-3 py-2">Active</span>
                <span class="badge bg-light text-dark fs-6 px-3 py-2">
                    {{ $debate->spotsLeft() }} Spots Remaining
                </span>
            @endif
            <span class="badge bg-dark border fs-6 px-3 py-2">
                <i class="fa-solid fa-users me-1"></i> {{ $debate->participants->count() }} Joined
            </span>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    
    <!-- 2. ADMIN PANEL (Only Visible to Admin) -->
    @auth
        @if(Auth::user()->role === 'admin')
        <div class="row mb-5">
            <div class="col-md-8 offset-md-2">
                <div class="card border-warning shadow-sm">
                    <div class="card-header bg-warning bg-opacity-25 fw-bold text-dark">
                        <i class="fa-solid fa-shield-halved me-2"></i> Admin Control Panel
                    </div>
                    <div class="card-body">
                        <h6 class="text-muted mb-3 text-center text-uppercase small ls-1">Current Participants</h6>
                        <div class="row">
                            <div class="col-md-6 text-center border-end">
                                <strong class="text-success d-block mb-2">PRO SIDE</strong>
                                @forelse($debate->participants->where('side', 'pro') as $p)
                                    <span class="participant-badge bg-pro">
                                        <i class="fa-solid fa-user me-1"></i> {{ $p->user->name }}
                                    </span>
                                @empty
                                    <small class="text-muted">No one joined yet</small>
                                @endforelse
                            </div>
                            <div class="col-md-6 text-center">
                                <strong class="text-danger d-block mb-2">CON SIDE</strong>
                                @forelse($debate->participants->where('side', 'con') as $p)
                                    <span class="participant-badge bg-con">
                                        <i class="fa-solid fa-user me-1"></i> {{ $p->user->name }}
                                    </span>
                                @empty
                                    <small class="text-muted">No one joined yet</small>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endauth

    <!-- 3. MAIN DEBATE COLUMNS -->
    <div class="row">
        
        <!-- ================= PRO COLUMN ================= -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="m-0 fw-bold"><i class="fa-solid fa-thumbs-up me-2"></i>PRO (Agreed)</h4>
                    <small>Supporters of the statement</small>
                </div>
                <div class="card-body bg-light" style="min-height: 500px;">
                    
                    <!-- LOGIC BLOCK: PRO SIDE -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <!-- Admin sees no input -->
                        <div class="alert alert-secondary text-center small mb-4">You are the Judge (Admin View)</div>

                    @elseif(Auth::check() && $userSide === 'pro')
                        <!-- JOINED AS PRO: Show Input -->
                        <div class="card mb-4 border-success shadow-sm">
                            <div class="card-body">
                                <h6 class="text-success fw-bold"><i class="fa-solid fa-pen-nib me-2"></i>State your Argument</h6>
                                <form action="{{ route('argument.store', $debate->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="side" value="pro">
                                    <textarea name="body" class="form-control mb-2" rows="3" placeholder="Why do you agree?" required></textarea>
                                    <button class="btn btn-success w-100 fw-bold">Post Argument</button>
                                </form>
                            </div>
                        </div>
                    
                    @elseif(Auth::check() && $userSide === 'con')
                        <!-- JOINED AS CON: Show nothing here -->

                    @elseif(!$debate->isFull())
                        <!-- NOT JOINED: Show Join Button -->
                        <div class="card mb-4 join-card join-card-pro p-4 text-center">
                            <h5 class="text-success fw-bold">Agree with this?</h5>
                            <p class="text-muted small">Join the debate as a PRO member to participate.</p>
                            
                            @auth
                                <form action="{{ route('debate.join', $debate->id) }}" method="POST">
                                    @csrf <input type="hidden" name="side" value="pro">
                                    <button class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                                        Join as PRO Debater
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-success rounded-pill px-4">Login to Join</a>
                            @endauth
                        </div>
                    @endif

                    <!-- PRO ARGUMENTS LIST -->
                    @foreach($pros as $arg)
                        @include('debate.partials.argument_card', ['arg' => $arg, 'sideColor' => 'success', 'userSide' => $userSide ])
                    @endforeach

                </div>
            </div>
        </div>

        <!-- ================= CON COLUMN ================= -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-danger text-white text-center py-3">
                    <h4 class="m-0 fw-bold"><i class="fa-solid fa-thumbs-down me-2"></i>CON (Disagreed)</h4>
                    <small>Opponents of the statement</small>
                </div>
                <div class="card-body bg-light" style="min-height: 500px;">
                    
                    <!-- LOGIC BLOCK: CON SIDE -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <!-- Admin sees no input -->
                        <div class="alert alert-secondary text-center small mb-4">You are the Judge (Admin View)</div>

                    @elseif(Auth::check() && $userSide === 'con')
                        <!-- JOINED AS CON: Show Input -->
                        <div class="card mb-4 border-danger shadow-sm">
                            <div class="card-body">
                                <h6 class="text-danger fw-bold"><i class="fa-solid fa-pen-nib me-2"></i>State your Argument</h6>
                                <form action="{{ route('argument.store', $debate->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="side" value="con">
                                    <textarea name="body" class="form-control mb-2" rows="3" placeholder="Why do you disagree?" required></textarea>
                                    <button class="btn btn-danger w-100 fw-bold">Post Argument</button>
                                </form>
                            </div>
                        </div>
                    
                    @elseif(Auth::check() && $userSide === 'pro')
                        <!-- JOINED AS PRO: Show nothing here -->

                    @elseif(!$debate->isFull())
                        <!-- NOT JOINED: Show Join Button -->
                        <div class="card mb-4 join-card join-card-con p-4 text-center">
                            <h5 class="text-danger fw-bold">Disagree with this?</h5>
                            <p class="text-muted small">Join the debate as a CON member to participate.</p>
                            
                            @auth
                                <form action="{{ route('debate.join', $debate->id) }}" method="POST">
                                    @csrf <input type="hidden" name="side" value="con">
                                    <button class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                                        Join as CON Debater
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill px-4">Login to Join</a>
                            @endauth
                        </div>
                    @endif

                    <!-- CON ARGUMENTS LIST -->
                    @foreach($cons as $arg)
                        @include('debate.partials.argument_card', ['arg' => $arg, 'sideColor' => 'danger', 'userSide' => $userSide ])
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</div>
@endsection