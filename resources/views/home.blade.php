@extends('layouts.app')

@section('content')

@if(!$debate)
    <!-- State 1: No Debate Created Yet -->
    <div class="container py-5 text-center">
        <div class="alert alert-info">
            <h2>No Active Debate</h2>
            <p>Waiting for Admin to create a topic.</p>
            @auth
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Admin Panel</a>
                @endif
            @endauth
        </div>
    </div>
@else
    <!-- State 2: Active Debate UI -->
    <div class="container-fluid">
        
        <!-- Header Section -->
        <div class="row bg-dark text-white text-center py-5 mb-4">
            <div class="col-md-8 offset-md-2">
                <h1 class="display-4 fw-bold">{{ $debate->title }}</h1>
                <p class="lead">{{ $debate->description }}</p>
            </div>
        </div>

        <!-- Debate Columns -->
        <div class="row px-2">
            <!-- PRO COLUMN -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h2 class="h4 mb-0">PRO (Agreed)</h2>
                        <small>Supporters of the statement</small>
                    </div>
                    <div class="card-body bg-light" style="min-height: 500px;">
                        
                        <!-- Input for PRO -->
                        @auth
                        <div class="card mb-4 border-success">
                            <div class="card-body p-3">
                                <h6 class="text-success"><i class="bi bi-chat-quote-fill"></i> State your PRO argument</h6>
                                <form action="{{ route('argument.store', $debate->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="side" value="pro">
                                    <textarea name="body" class="form-control mb-2" rows="2" placeholder="Why do you agree?" required></textarea>
                                    <button class="btn btn-success w-100">Submit Argument</button>
                                </form>
                            </div>
                        </div>
                        @else
                            <div class="alert alert-warning text-center">Login to debate</div>
                        @endauth

                        <!-- List of PRO Arguments -->
                        @foreach($pros as $arg)
                            @include('debate.partials.argument_card', ['arg' => $arg, 'sideColor' => 'success'])
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- CON COLUMN -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-danger text-white text-center py-3">
                        <h2 class="h4 mb-0">CON (Disagreed)</h2>
                        <small>Opponents of the statement</small>
                    </div>
                    <div class="card-body bg-light" style="min-height: 500px;">
                        
                        <!-- Input for CON -->
                        @auth
                        <div class="card mb-4 border-danger">
                            <div class="card-body p-3">
                                <h6 class="text-danger"><i class="bi bi-chat-quote-fill"></i> State your CON argument</h6>
                                <form action="{{ route('argument.store', $debate->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="side" value="con">
                                    <textarea name="body" class="form-control mb-2" rows="2" placeholder="Why do you disagree?" required></textarea>
                                    <button class="btn btn-danger w-100">Submit Argument</button>
                                </form>
                            </div>
                        </div>
                        @else
                            <div class="alert alert-warning text-center">Login to debate</div>
                        @endauth

                        <!-- List of CON Arguments -->
                        @foreach($cons as $arg)
                            @include('debate.partials.argument_card', ['arg' => $arg, 'sideColor' => 'danger'])
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endif
@endsection