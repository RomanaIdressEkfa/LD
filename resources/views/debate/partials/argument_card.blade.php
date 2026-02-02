<div class="card mb-3 border-0 shadow-sm" style="border-left: 5px solid var(--bs-{{ $sideColor }});">
    <div class="card-body">
        
        <!-- Header: User Info & Time -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-center gap-2">
                <div class="fw-bold text-dark">{{ $arg->user->name }}</div>
                @if($arg->user->role === 'admin')
                    <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">JUDGE</span>
                @else
                    <span class="badge bg-light text-secondary border" style="font-size: 0.65rem;">{{ strtoupper($arg->side) }}</span>
                @endif
            </div>
            <small class="text-muted" style="font-size: 0.75rem;">
                <i class="fa-regular fa-clock me-1"></i>{{ $arg->created_at->diffForHumans() }}
            </small>
        </div>
        
        <!-- Argument Body -->
        <p class="card-text text-secondary mb-3">{{ $arg->body }}</p>

        <!-- Footer: Actions (Vote & Reply) -->
        <div class="d-flex align-items-center gap-2 pt-2 border-top">
            
            <!-- Agree Vote -->
            <form action="{{ route('argument.vote', $arg->id) }}" method="POST">
                @csrf <input type="hidden" name="type" value="agree">
                <button class="btn btn-sm btn-light text-success fw-bold" title="I Agree">
                    <i class="fa-solid fa-check me-1"></i> 
                    {{ $arg->votes->where('type', 'agree')->count() }}
                </button>
            </form>
            
            <!-- Disagree Vote -->
            <form action="{{ route('argument.vote', $arg->id) }}" method="POST">
                @csrf <input type="hidden" name="type" value="disagree">
                <button class="btn btn-sm btn-light text-danger fw-bold" title="I Disagree">
                    <i class="fa-solid fa-xmark me-1"></i> 
                    {{ $arg->votes->where('type', 'disagree')->count() }}
                </button>
            </form>

            <!-- Reply Button (Only for Active Participants) -->
            @if(auth()->check() && isset($userSide) && $userSide)
                <button class="btn btn-sm btn-link text-decoration-none text-muted ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#replyBox-{{ $arg->id }}">
                    <i class="fa-solid fa-reply me-1"></i> Reply
                </button>
            @endif
        </div>

        <!-- Hidden Reply Form -->
        @if(auth()->check() && isset($userSide))
        <div class="collapse mt-3" id="replyBox-{{ $arg->id }}">
            <div class="card card-body bg-light border-0 p-3">
                <form action="{{ route('argument.store', $arg->debate_id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $arg->id }}">
                    <!-- CRITICAL FIX: Send the USER'S side, not the ARGUMENT'S side -->
                    <input type="hidden" name="side" value="{{ $userSide }}">
                    
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <span class="small text-muted">Stance:</span>
                        <select name="reply_type" class="form-select form-select-sm" style="width: auto;">
                            <option value="neutral">Neutral</option>
                            <option value="agree">Agreed with {{ $arg->user->name }}</option>
                            <option value="disagree">Disagreed with {{ $arg->user->name }}</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <input type="text" name="body" class="form-control form-control-sm" placeholder="Write your reply..." required>
                        <button class="btn btn-dark btn-sm"><i class="fa-solid fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Nested Replies Loop -->
        @if($arg->replies->count() > 0)
            <div class="mt-3 ps-3 border-start">
                @foreach($arg->replies as $reply)
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-dark small">{{ $reply->user->name }}</strong>
                            
                            <!-- Stance Badge -->
                            @if($reply->reply_type == 'agree')
                                <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.6rem;">Agreed</span>
                            @elseif($reply->reply_type == 'disagree')
                                <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.6rem;">Disagreed</span>
                            @endif
                            
                            <small class="text-muted ms-auto" style="font-size: 0.7rem;">{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0 text-secondary small mt-1">{{ $reply->body }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>