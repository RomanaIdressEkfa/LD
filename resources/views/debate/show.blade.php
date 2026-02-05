@extends('layouts.app')

@section('content')
<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>

<style>
    /* DARK MODE & TREE CSS */
    body { background-color: #0f1015; color: white; font-family: 'Inter', sans-serif; }
    
    /* The Canvas */
    .debate-arena {
        min-height: 100vh;
        background-image: radial-gradient(#2a2a35 1px, transparent 1px);
        background-size: 30px 30px;
        overflow-x: auto;
        padding-bottom: 100px;
    }

    /* TREE STRUCTURE (Org Chart Style) */
    .tree { display: flex; justify-content: center; padding-top: 20px; }
    .tree ul {
        padding-top: 20px; position: relative;
        transition: all 0.5s; display: flex; justify-content: center;
    }
    .tree li {
        float: left; text-align: center; list-style-type: none;
        position: relative; padding: 20px 10px 0 10px; transition: all 0.5s;
    }
    
    /* Connectors */
    .tree li::before, .tree li::after {
        content: ''; position: absolute; top: 0; right: 50%;
        border-top: 2px solid #555; width: 50%; height: 20px;
    }
    .tree li::after { right: auto; left: 50%; border-left: 2px solid #555; }
    .tree li:only-child::after, .tree li:only-child::before { display: none; }
    .tree li:only-child { padding-top: 0; }
    .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
    .tree li:last-child::before { border-right: 2px solid #555; border-radius: 0 5px 0 0; }
    .tree li:first-child::after { border-radius: 5px 0 0 0; }
    .tree ul ul::before {
        content: ''; position: absolute; top: 0; left: 50%;
        border-left: 2px solid #555; width: 0; height: 20px;
    }

    /* CARD DESIGN */
    .node-card {
        background: #1e1e2d; border: 1px solid #333;
        padding: 15px; border-radius: 12px;
        min-width: 280px; max-width: 320px;
        display: inline-block; text-align: left;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        position: relative; z-index: 10;
        transition: 0.3s;
    }
    .node-card:hover { transform: translateY(-5px); border-color: #666; }
    
    .border-pro { border-top: 4px solid #10b981; } /* Green */
    .border-con { border-top: 4px solid #ef4444; } /* Red */
    .border-root { border-top: 4px solid #fff; background: #222; }

    /* Live Badge Animation */
    .live-indicator {
        width: 10px; height: 10px; background: red; border-radius: 50%;
        display: inline-block; margin-right: 5px;
        box-shadow: 0 0 0 rgba(255, 0, 0, 0.4);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
    }

    /* Toggle Button */
    .toggle-btn {
        position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%);
        width: 22px; height: 22px; background: #444; color: #fff;
        border-radius: 50%; font-size: 12px; line-height: 20px;
        cursor: pointer; border: 2px solid #777; z-index: 20;
    }
</style>

<div class="debate-arena" x-data="debateLogic()">
    
    <!-- TOP BAR -->
    <div class="d-flex justify-content-between align-items-center p-3 sticky-top bg-dark border-bottom border-secondary shadow">
        <div class="d-flex align-items-center">
            <div class="live-indicator"></div>
            <span class="fw-bold text-uppercase ls-1 me-3 text-danger">LIVE DEBATE</span>
            <h5 class="m-0 d-none d-md-block text-white">{{ Str::limit($debate->title, 50) }}</h5>
        </div>
        <div class="d-flex gap-2">
            @auth
                @if($userSide)
                    <span class="badge {{ $userSide == 'pro' ? 'bg-success' : 'bg-danger' }}">
                        YOU ARE: {{ strtoupper($userSide) }}
                    </span>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Login to Debate</a>
            @endauth
        </div>
    </div>

    <!-- THE HIERARCHICAL TREE -->
    <div class="tree">
        <ul>
            <li>
                <!-- ROOT NODE (Main Topic) -->
                <div class="node-card border-root text-center mx-auto" style="min-width: 400px;">
                    <h4 class="fw-bold mb-2">{{ $debate->title }}</h4>
                    <p class="text-white-50 small mb-3">{{ $debate->description }}</p>
                    
                    <button @click="openAction(null, '{{ $debate->title }}')" class="btn btn-primary btn-sm w-100 rounded-pill">
                        <i class="fa-solid fa-plus"></i> Submit First Argument
                    </button>
                </div>

                <!-- Children -->
                <ul>
                    @foreach($roots as $arg)
                        @include('debate.partials.tree_node', ['arg' => $arg])
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>

    <!-- MODAL: JOIN DEBATE (Select Side) -->
    <div x-show="showJoinModal" style="display: none;" 
         class="position-fixed top-0 start-0 w-100 h-100 bg-black bg-opacity-90 d-flex justify-content-center align-items-center" style="z-index: 3000;">
        <div class="card bg-dark text-white border-secondary shadow-lg p-4" style="width: 400px;">
            <h4 class="text-center mb-3">Choose Your Side</h4>
            <p class="text-center text-muted small mb-4">You must pick a stance to participate in this debate.</p>
            
            <form action="{{ route('debate.join', $debate->id) }}" method="POST">
                @csrf
                <button name="side" value="pro" class="btn btn-outline-success w-100 mb-3 py-3 fw-bold">
                    <i class="fa-solid fa-check"></i> I AGREE (Join PRO)
                </button>
                <button name="side" value="con" class="btn btn-outline-danger w-100 py-3 fw-bold">
                    <i class="fa-solid fa-times"></i> I DISAGREE (Join CON)
                </button>
            </form>
            <button @click="showJoinModal = false" class="btn btn-link text-white-50 mt-3 w-100">Cancel</button>
        </div>
    </div>

    <!-- MODAL: REPLY / POST ARGUMENT -->
    <div x-show="showReplyModal" style="display: none;"
         class="position-fixed top-0 start-0 w-100 h-100 bg-black bg-opacity-80 d-flex justify-content-center align-items-center" style="z-index: 3000;">
        <div class="card bg-dark text-white border-secondary shadow-lg" style="width: 500px;">
            <div class="card-header border-secondary d-flex justify-content-between">
                <span>Argue with <strong x-text="targetName"></strong></span>
                <button @click="showReplyModal = false" class="btn btn-sm text-white"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="card-body">
                <form action="{{ route('argument.store', $debate->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" :value="targetId">
                    <input type="hidden" name="side" value="{{ $userSide }}">

                    <!-- Visual Context -->
                    <div class="alert alert-dark border border-secondary small fst-italic text-white-50">
                        Replying as <span class="fw-bold {{ $userSide == 'pro' ? 'text-success' : 'text-danger' }}">{{ strtoupper($userSide ?? 'USER') }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-2">Reply Logic:</label>
                        <select name="reply_type" class="form-select bg-dark text-white border-secondary">
                            <option value="neutral">Neutral Point</option>
                            <option value="agree">Support their point</option>
                            <option value="disagree">Counter their point</option>
                        </select>
                    </div>

                    <textarea name="body" class="form-control bg-black text-white border-secondary mb-3" rows="4" placeholder="Construct your argument..." required></textarea>
                    <button class="btn btn-light w-100 fw-bold">Post Argument</button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- LOGIC SCRIPT -->
<script>
    function debateLogic() {
        return {
            showJoinModal: false,
            showReplyModal: false,
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            hasJoined: {{ isset($userSide) && $userSide ? 'true' : 'false' }},
            targetId: null,
            targetName: '',

            openAction(id, name) {
                // 1. Check Login
                if (!this.isLoggedIn) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                
                // 2. Check if Joined Side
                if (!this.hasJoined) {
                    this.showJoinModal = true;
                    return;
                }

                // 3. Open Reply Box
                this.targetId = id;
                this.targetName = name;
                this.showReplyModal = true;
            }
        }
    }
</script>
@endsection