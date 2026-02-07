<div class="comment-thread">
    <!-- Main Comment -->
    <div class="comment-wrapper">
        <img src="{{ $argument->user->avatar ? asset('storage/'.$argument->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($argument->user->name) }}" 
             alt="{{ $argument->user->name }}" 
             class="comment-avatar">
        
        <div class="comment-content-wrapper">
            <div class="comment-bubble">
                <div class="comment-author">
                    {{ $argument->user->name }}
                    <span class="side-badge {{ $argument->side == 'pro' ? 'badge-agreed' : 'badge-disagreed' }}">
                        {{ $argument->side == 'pro' ? 'AGREED' : 'DISAGREED' }}
                    </span>
                </div>
                <div class="comment-text">{{ $argument->body }}</div>
            </div>
        </div>
    </div>

    <!-- Comment Actions -->
    <div class="comment-meta">
        <span class="comment-action" onclick="toggleReplyInput({{ $argument->id }})">
            <i class="fas fa-reply"></i> Reply
        </span>
        <span class="comment-time">
            <i class="far fa-clock"></i> {{ $argument->created_at->diffForHumans() }}
        </span>
    </div>

    <!-- Reply Input Form -->
    @if(Auth::check() && $userSide)
        <div class="reply-input-container" id="replyInput-{{ $argument->id }}">
            <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                 alt="{{ Auth::user()->name }}" 
                 class="comment-avatar">
            
            <div class="input-wrapper">
                <form action="{{ route('argument.store', $debate->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $argument->id }}">
                    
                    {{-- 
                       Removed the hidden input for 'side'.
                       We now pass the side value via the buttons below.
                    --}}
                    
                    <textarea class="reply-textarea" 
                              name="body" 
                              id="replyTextarea-{{ $argument->id }}"
                              placeholder="Write a reply..."
                              required></textarea>
                    
                    <div class="reply-action-buttons" id="replyButtons-{{ $argument->id }}">
                        {{-- Show Both Buttons --}}
                        <button type="submit" name="side" value="pro" class="reply-btn btn-agreed">
                            <i class="fas fa-thumbs-up"></i> AGREED
                        </button>

                        <button type="submit" name="side" value="con" class="reply-btn btn-disagreed">
                            <i class="fas fa-thumbs-down"></i> DISAGREED
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Nested Replies -->
    @if($argument->replies && $argument->replies->count() > 0)
        <div class="replies-container" id="replies-{{ $argument->id }}">
            @foreach($argument->replies as $reply)
                <div class="reply-wrapper">
                    @include('frontend.partials.comment_tree', ['argument' => $reply, 'debate' => $debate, 'userSide' => $userSide])
                </div>
            @endforeach
        </div>

        <!-- Collapse Toggle Button -->
        <div class="collapse-toggle" onclick="toggleReplies({{ $argument->id }})">
            <i class="fas fa-chevron-down"></i>
            <span>Hide Replies</span>
        </div>
    @endif
</div>