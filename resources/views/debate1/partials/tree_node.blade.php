<div class="discussion-thread mb-3">
    
    <!-- ARGUMENT CARD -->
    <div class="soft-card p-4">
        <div class="d-flex gap-3">
            
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($arg->user->name) }}&background=random&color=fff&rounded=true" 
                     alt="{{ $arg->user->name }}" 
                     class="rounded-circle shadow-sm" 
                     width="45" height="45">
            </div>

            <!-- Content Area -->
            <div class="flex-grow-1">
                
                <!-- Header: Name & Badge -->
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h6 class="fw-bold m-0 text-dark">{{ $arg->user->name }}</h6>
                    
                    <!-- Dynamic Badge Style -->
                    @if($arg->side == 'pro')
                        <span class="badge-pill badge-pro">
                            <i class="fa-solid fa-check-circle me-1"></i> Agree
                        </span>
                    @else
                        <span class="badge-pill badge-con">
                            Disagree
                        </span>
                    @endif

                    <span class="text-muted small ms-1">&bull; {{ $arg->created_at->diffForHumans() }}</span>
                </div>

                <!-- Body Text -->
                <div class="text-secondary mb-3" style="font-size: 15px; line-height: 1.6;">
                    {{ $arg->body }}
                </div>

                <!-- Action Footer -->
                <div class="d-flex align-items-center gap-3">
                    
                    <!-- Vote Button -->
                    <form action="{{ route('argument.vote', $arg->id) }}" method="POST" class="d-inline">
                        @csrf <input type="hidden" name="type" value="agree">
                        <button class="btn-action {{ $arg->votes->where('user_id', Auth::id())->where('type', 'agree')->count() ? 'active' : '' }}">
                            <i class="fa-solid fa-thumbs-up"></i>
                            <span>{{ $arg->votes->where('type', 'agree')->count() }}</span>
                        </button>
                    </form>

                    <!-- Reply Button -->
                    <button @click="handleInteraction({{ $arg->id }}, '{{ addslashes($arg->user->name) }}')" 
                            class="btn-action">
                        <i class="fa-regular fa-comment-dots"></i>
                        <span>Reply {{ $arg->replies->count() > 0 ? '('.$arg->replies->count().')' : '' }}</span>
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- RECURSIVE CHILDREN (Indented) -->
    @if($arg->replies->count() > 0)
        <!-- মার্জিন এবং বর্ডার দিয়ে হায়ারার্কি বোঝানো হচ্ছে -->
        <div class="ps-4 ps-md-5 ms-2 border-start border-2 border-light" style="border-color: #e2e8f0 !important;">
            @foreach($arg->replies as $reply)
                @include('debate.partials.tree_node', ['arg' => $reply])
            @endforeach
        </div>
    @endif

</div>