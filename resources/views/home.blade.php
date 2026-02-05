@extends('layouts.app')

@section('content')
<!-- Alpine.js (Updated Source) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    /* --- UI THEME --- */
    body { background-color: #eef2f6; font-family: 'Inter', sans-serif; color: #334155; }
    h1, h2, h3, h4, h5 { color: #0f172a; font-weight: 700; }

    /* Custom Card */
    .soft-card {
        background: #ffffff; border: none; border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    /* Topic Header */
    .topic-header {
        background: #ffffff; padding: 40px; border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); margin-bottom: 40px;
    }

    /* Tree Container */
    .discussion-tree { max-width: 900px; margin: 0 auto; }

    /* Badges & Buttons */
    .badge-pill { padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .badge-pro { background-color: #dbeafe; color: #2563eb; }
    .badge-con { background-color: #f3f4f6; color: #4b5563; }
    
    .btn-action {
        color: #64748b; font-size: 14px; font-weight: 500; display: inline-flex;
        align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px;
        border: 1px solid transparent; background: transparent; transition: all 0.2s;
    }
    .btn-action:hover { background-color: #f1f5f9; color: #334155; }
    .btn-action.active { color: #2563eb; background-color: #eff6ff; }

    /* Modal Styling */
    .custom-modal-overlay {
        background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        display: flex; justify-content: center; align-items: center; z-index: 9999;
    }
    .modal-card {
        border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        background: white; width: 100%; max-width: 550px; margin: 20px;
    }
    
    /* Close Button Fix */
    .custom-close-btn {
        background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;
    }
    .custom-close-btn:hover { color: #334155; }
</style>

<div class="container-fluid py-5" style="min-height: 100vh;">
    
    @if(!$debate)
        <div class="text-center py-5">
            <h3 class="text-muted">No Active Debate</h3>
        </div>
    @else

    <!-- Alpine Data Scope Starts Here -->
    <div x-data="debateSystem()">
        
        <!-- Header Section -->
        <div class="container">
            <div class="topic-header mx-auto" style="max-width: 900px;">
                <h1 class="mb-3">{{ $debate->title }}</h1>
                <p class="text-secondary lead mb-4">{{ $debate->description }}</p>
                <div class="mt-4">
                    <button @click="handleInteraction(null, 'Main Topic')" class="btn btn-primary rounded-pill px-4 fw-bold py-2 shadow-sm">
                        Start the Debate
                    </button>
                </div>
            </div>
        </div>

        <!-- Debate Tree -->
        <div class="container discussion-tree">
            <h5 class="fw-bold mb-4 ps-1">Debate Tree</h5>
            @foreach($roots as $arg)
                @include('debate.partials.tree_node', ['arg' => $arg])
            @endforeach
        </div>

        <!-- ================= MODALS ================= -->

        <!-- MODAL 1: SIDE SELECTION -->
        <template x-if="modal === 'side_selection'">
            <div class="custom-modal-overlay">
                <div class="card modal-card p-4" @click.outside="modal = null">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Choose Your Side</h4>
                        <p class="text-muted small">Select your stance to participate.</p>
                    </div>
                    
                    <form action="{{ route('debate.join', $debate->id) }}" method="POST">
                        @csrf
                        <div class="d-grid gap-3">
                            <button name="side" value="pro" class="btn btn-outline-primary py-3 rounded-3 fw-bold text-start ps-4">
                                <i class="fa-solid fa-circle-check me-2"></i> I Agree (PRO)
                            </button>
                            <button name="side" value="con" class="btn btn-outline-secondary py-3 rounded-3 fw-bold text-start ps-4">
                                <i class="fa-solid fa-circle-xmark me-2"></i> I Disagree (CON)
                            </button>
                        </div>
                    </form>
                    <button type="button" @click="modal = null" class="btn btn-link text-muted w-100 mt-3 text-decoration-none">Cancel</button>
                </div>
            </div>
        </template>

        <!-- MODAL 2: REPLY FORM -->
        <template x-if="modal === 'reply'">
            <div class="custom-modal-overlay">
                <div class="card modal-card" @click.outside="modal = null">
                    
                    <!-- FIX 1: Custom Close Button Header -->
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold m-0">Reply to <span class="text-primary" x-text="targetName"></span></h5>
                        
                        <!-- এই বাটনটি এখন কাজ করবে -->
                        <button type="button" @click="modal = null" class="custom-close-btn">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                    <div class="card-body p-4">
                        <!-- FIX 2: Added @submit="modal = null" -->
                        <form action="{{ route('argument.store', $debate->id) }}" method="POST" @submit="modal = null">
                            @csrf
                            
                            <input type="hidden" name="parent_id" :value="targetId">
                            <input type="hidden" name="side" value="{{ $userSide ?? 'pro' }}"> 

                            <div class="mb-3">
                                <label class="small text-muted fw-bold text-uppercase ls-1">Argument Type</label>
                                <select name="reply_type" class="form-select border-0 bg-light fw-bold text-secondary">
                                    <option value="agree">✅ Support this point</option>
                                    <option value="disagree">❌ Counter this point</option>
                                    <option value="neutral">💬 General Comment</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <textarea name="body" class="form-control border-0 bg-light p-3 rounded-3" rows="5" placeholder="Write your logical argument here..." style="resize: none;" required></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">
                                    Posting as 
                                    <strong class="{{ $userSide == 'pro' ? 'text-primary' : 'text-danger' }}">
                                        {{ $userSide ? strtoupper($userSide) : 'GUEST/ADMIN' }}
                                    </strong>
                                </span>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Post Reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

    </div> <!-- End Alpine Scope -->

    <!-- Logic Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('debateSystem', () => ({
                modal: null, 
                isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
                hasJoined: {{ $userSide ? 'true' : 'false' }},
                userSide: '{{ $userSide ?? "" }}',
                targetId: null,
                targetName: '',

                handleInteraction(id, name) {
                    if (!this.isLoggedIn) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    // Admin Bypass for Testing
                    if (!this.hasJoined && this.userSide === '') { 
                         // যদি এডমিন হন তবে সরাসরি রিপ্লাই দিতে পারবেন (টেস্টিং এর জন্য)
                         if('{{ Auth::check() && Auth::user()->role == "admin" }}') {
                            this.targetId = id;
                            this.targetName = name;
                            this.modal = 'reply';
                            return;
                         }
                        this.modal = 'side_selection';
                        return;
                    }
                    this.targetId = id;
                    this.targetName = name;
                    this.modal = 'reply';
                }
            }));
        });
    </script>
    @endif
</div>
@endsection