<div class="comment-thread" id="comment-{{ $argument->id }}">
    
    <!-- 1. Main Comment Row -->
    <div class="comment-wrapper">
        <!-- Avatar -->
        <img src="{{ $argument->user->avatar ? asset('storage/'.$argument->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($argument->user->name) }}" 
             alt="{{ $argument->user->name }}" 
             class="comment-avatar">
        
        <!-- Bubble & Meta -->
        <div class="comment-content" style="flex: 1;">
            
            <!-- The Bubble -->
            <div class="comment-bubble">
                <div class="comment-author">
                    {{ $argument->user->name }}
                    
                    @if($argument->side == 'pro')
                        <span class="badge-agreed">Agreed</span>
                    @else
                        <span class="badge-disagreed">Disagreed</span>
                    @endif
                </div>
                <div class="comment-text">{!! nl2br($argument->body) !!}</div>
            </div>

          <!-- Meta Links (Like, Dislike, Reply, Time) -->
<div class="comment-meta" style="margin-left: 12px; margin-top: 4px; display: flex; align-items: center; gap: 12px;">
    
    @php
        $userVote = null;
        if(Auth::check()) {
            $vote = $argument->votes->where('user_id', Auth::id())->first();
            if($vote) $userVote = $vote->type;
        }
        
        $agreeCount = $argument->votes->where('type', 'agree')->count();
        $disagreeCount = $argument->votes->where('type', 'disagree')->count();
    @endphp

    {{-- LIKE BUTTON (AGREE) --}}
    <button onclick="ajaxVote({{ $argument->id }}, 'agree')" 
            id="btn-agree-{{ $argument->id }}"
            class="vote-btn {{ $userVote == 'agree' ? 'active-like' : '' }}">
        <i class="far fa-thumbs-up"></i> 
        Like <span id="agree-count-{{ $argument->id }}">{{ $agreeCount > 0 ? $agreeCount : '' }}</span>
    </button>

    <button onclick="ajaxVote({{ $argument->id }}, 'disagree')" 
            id="btn-disagree-{{ $argument->id }}"
            class="vote-btn {{ $userVote == 'disagree' ? 'active-dislike' : '' }}">
        <i class="far fa-thumbs-down"></i> 
        Unlike <span id="disagree-count-{{ $argument->id }}">{{ $disagreeCount > 0 ? $disagreeCount : '' }}</span>
    </button>

    <span style="opacity: 0.5;">·</span>
    
    @auth
        @if($userSide)
            <span onclick="openReplyBox({{ $argument->id }}, '{{ $argument->user->name }}')" 
                  style="font-weight: 600; cursor: pointer; color: #65676B; font-size: 12px;">
                Reply
            </span>
        @else
            <span onclick="window.location='{{ route('debate.join_form', $debate->id) }}'" 
                  style="font-weight: 600; cursor: pointer; color: #65676B; font-size: 12px;">
                Reply
            </span>
        @endif
    @else
        <span onclick="window.location='{{ route('debate.join_form', $debate->id) }}'" 
              style="font-weight: 600; cursor: pointer; color: #65676B; font-size: 12px;">
            Reply
        </span>
    @endauth
    
    <span style="opacity: 0.5;">·</span>
    
    <span style="font-weight: 400; color: #65676B; font-size: 12px;">{{ $argument->created_at->diffForHumans(null, true, true) }}</span>
</div>
        </div>
    </div>

    @if(Auth::check() && $userSide)
        <div class="reply-input-container" id="replyInput-{{ $argument->id }}">
            <div style="display: flex; gap: 8px;">
                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                     style="width: 28px; height: 28px; border-radius: 50%;">
                
                <div style="flex: 1;">
                    <div class="custom-input-box" id="fakeInput-{{ $argument->id }}" contenteditable="true" placeholder="Write a reply..."></div>
                    
                    <form id="replyForm-{{ $argument->id }}" action="{{ route('argument.store', $debate->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $argument->id }}">
                        <input type="hidden" name="body" id="hiddenBody-{{ $argument->id }}">
                        <input type="hidden" name="side" id="hiddenSide-{{ $argument->id }}">
                    </form>

                    <div class="input-actions">
                        <button onclick="submitReply({{ $argument->id }}, 'pro')" class="mini-btn btn-agreed">
                            <i class="fas fa-paper-plane"></i> Agree
                        </button>
                        <button onclick="submitReply({{ $argument->id }}, 'con')" class="mini-btn btn-disagreed">
                            <i class="fas fa-paper-plane"></i> Disagree
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 3. Nested Replies -->
    @if($argument->replies && $argument->replies->count() > 0)
        <button class="view-replies-link" onclick="toggleReplies({{ $argument->id }}, {{ $argument->replies->count() }})">
            <i class="fas fa-reply" style="transform: rotate(180deg);" id="arrow-icon-{{ $argument->id }}"></i>
            <span>
                View {{ $argument->replies->count() }} 
                {{ Str::plural('reply', $argument->replies->count()) }}
            </span>
        </button>

        <div class="replies-container" id="replies-{{ $argument->id }}">
            @foreach($argument->replies as $reply)
                <div class="reply-item">
                    @include('frontend.partials.comment_tree', ['argument' => $reply, 'debate' => $debate, 'userSide' => $userSide])
                </div>
            @endforeach
        </div>
    @endif
</div>