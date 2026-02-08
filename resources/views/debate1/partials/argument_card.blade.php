<div class="card mb-4 border-0 shadow-sm position-relative overflow-hidden">
    <!-- Visual Indicator Strip -->
    <div class="position-absolute top-0 bottom-0 start-0" 
         style="width: 6px; background-color: {{ $arg->side == 'pro' ? '#10b981' : '#ef4444' }};">
    </div>

    <div class="card-body p-4 ps-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start mb-3 ms-2">
            <div class="d-flex align-items-center gap-2">
                <!-- Avatar -->
                <img src="https://ui-avatars.com/api/?name={{ $arg->user->name }}&background=random" 
                     class="rounded-circle" width="40" height="40">
                
                <div class="d-flex flex-column">
                    <span class="fw-bold text-dark lh-1">{{ $arg->user->name }}</span>
                    <span class="small text-muted" style="font-size: 0.75rem;">
                        {{ $arg->side == 'pro' ? 'Agreeing' : 'Disagreeing' }} • {{ $arg->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            
            <!-- Badge -->
            @if($arg->side == 'pro')
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">PRO</span>
            @else
                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">CON</span>
            @endif
        </div>

        <!-- Content -->
        <div class="ms-2">
            <p class="text-dark mb-3" style="font-size: 1.05rem; line-height: 1.6;">
                {{ $arg->body }}
            </p>

            <!-- Actions Bar -->
            <div class="d-flex align-items-center gap-3 pt-3 border-top">
                <!-- Vote Agree -->
                <form action="{{ route('argument.vote', $arg->id) }}" method="POST">
                    @csrf <input type="hidden" name="type" value="agree">
                    <button class="btn btn-sm btn-light rounded-pill px-3 text-success fw-bold">
                        <i class="fa-solid fa-thumbs-up me-1"></i> {{ $arg->votes->where('type', 'agree')->count() }}
                    </button>
                </form>

                <!-- Vote Disagree -->
                <form action="{{ route('argument.vote', $arg->id) }}" method="POST">
                    @csrf <input type="hidden" name="type" value="disagree">
                    <button class="btn btn-sm btn-light rounded-pill px-3 text-danger fw-bold">
                        <i class="fa-solid fa-thumbs-down me-1"></i> {{ $arg->votes->where('type', 'disagree')->count() }}
                    </button>
                </form>

                <!-- Reply -->
                @if(auth()->check() && isset($userSide))
                    <button class="btn btn-sm btn-link text-decoration-none text-muted ms-auto" 
                            type="button" data-bs-toggle="collapse" data-bs-target="#replyBox-{{ $arg->id }}">
                        <i class="fa-solid fa-reply me-1"></i> Reply
                    </button>
                @endif
            </div>

            <!-- Reply Section -->
            @if(auth()->check() && isset($userSide))
            <div class="collapse mt-3" id="replyBox-{{ $arg->id }}">
                <div class="bg-light p-3 rounded-3">
                    <form action="{{ route('argument.store', $arg->debate_id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $arg->id }}">
                        <input type="hidden" name="side" value="{{ $userSide }}">
                        
                        <div class="d-flex gap-2 mb-2">
                            <select name="reply_type" class="form-select form-select-sm w-auto border-0 shadow-none bg-white">
                                <option value="neutral">Neutral</option>
                                <option value="agree">Agree & Reply</option>
                                <option value="disagree">Disagree & Reply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <input type="text" name="body" class="form-control border-0 shadow-none" placeholder="Write a reply..." required>
                            <button class="btn btn-dark"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Nested Replies -->
            @if($arg->replies->count() > 0)
                <div class="mt-3 ps-3 border-start border-2">
                    @foreach($arg->replies as $reply)
                        <div class="bg-white p-3 rounded-3 mb-2 shadow-sm border border-light">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <img src="https://ui-avatars.com/api/?name={{ $reply->user->name }}&size=20" class="rounded-circle">
                                <strong class="small">{{ $reply->user->name }}</strong>
                                
                                @if($reply->reply_type == 'agree')
                                    <i class="fa-solid fa-check-circle text-success small" title="Agreed"></i>
                                @elseif($reply->reply_type == 'disagree')
                                    <i class="fa-solid fa-times-circle text-danger small" title="Disagreed"></i>
                                @endif
                                
                                <span class="text-muted ms-auto" style="font-size: 0.65rem;">{{ $reply->created_at->shortAbsoluteDiffForHumans() }}</span>
                            </div>
                            <p class="mb-0 small text-secondary ps-4">{{ $reply->body }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>