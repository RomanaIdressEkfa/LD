<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\Argument;
use App\Models\Vote;
use App\Models\User;
use App\Models\DebateParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
   public function index(Request $request) { 
    $debate = Debate::where('status', 'active')->latest()->first();
    $roots = collect();

    if ($debate) {
        $query = $debate->arguments()
            ->whereNull('parent_id')
            ->with(['user', 'votes', 'replies.user', 'replies.votes'])
            ->withCount('votes'); 

        if ($request->get('sort') == 'latest') {
            $query->latest(); 
        } else {
            $query->orderBy('votes_count', 'desc')->latest();
        }

        $roots = $query->get();
    }

    $userSide = null;
    if(Auth::check() && $debate) {
        $participant = DebateParticipant::where('debate_id', $debate->id)
            ->where('user_id', Auth::id())
            ->first();
        
        if($participant) {
            $userSide = $participant->side;
        }
    }

    return view('home', compact('debate', 'roots', 'userSide'));
}

    public function showJoinForm($debateId) {
        $debate = Debate::findOrFail($debateId);
    
        if(Auth::check()) {
            $participant = DebateParticipant::where('debate_id', $debateId)
                ->where('user_id', Auth::id())
                ->exists();
            
            if($participant) {
                return redirect()->route('home')->with('info', 'You have already joined this debate.');
            }
        }

        return view('frontend.auth.debate-join', compact('debate'));
    }

  public function processJoin(Request $request, $debateId) {
    if (Auth::check() && Auth::user()->role === 'admin') {
        Auth::logout();
        return redirect()->route('debate.join_form', $debateId)
            ->with('error', 'Please join as a regular user (not Admin).');
    }

    $user = Auth::user();

    if (!$user) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'side' => 'required|in:pro,con',
            'avatar' => 'nullable|image|max:5120',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
            'role' => 'user'
        ]);

        Auth::login($user, true);
    } else {
        $request->validate([
            'side' => 'required|in:pro,con',
        ]);

        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'nullable|image|max:5120']);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
            $user->save();
        }
    }

    DebateParticipant::updateOrCreate(
        [
            'debate_id' => $debateId,
            'user_id' => $user->id
        ],
        [
            'side' => $request->side
        ]
    );

    return redirect()->route('home')->with('success', 'Welcome! You have registered and joined successfully.');
}
    public function storeArgument(Request $request, $debateId) {
        if(!Auth::check()) {
            return redirect()->route('debate.join_form', $debateId);
        }

        $participant = DebateParticipant::where('debate_id', $debateId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$participant) {
            return redirect()->route('debate.join_form', $debateId)
                ->with('error', 'Please choose a side to participate in this debate.');
        }

        $request->validate(['body' => 'required']);
        $cleanBody = strip_tags($request->body, '<span><br>');

       Argument::create([
            'debate_id' => $debateId,
            'user_id' => Auth::id(),
            'side' => $request->side ?? $participant->side, 
            'body' => $cleanBody,
            'parent_id' => $request->parent_id ?? null,
            'reply_type' => $request->reply_type ?? 'neutral',
        ]);

        return redirect()->back()->with('success', 'Comment posted!')->with('expanded_id', $request->parent_id); ;
    }


public function vote(Request $request, $argumentId) {
    if(!Auth::check()) {
        return response()->json(['status' => 'login_required', 'debate_id' =>Argument::find($argumentId)->debate_id]);
    }

    $userId = Auth::id();
    $type = $request->type; 
    $existingVote = Vote::where('user_id', $userId)
                        ->where('argument_id', $argumentId)
                        ->first();

    if ($existingVote) {
        if ($existingVote->type == $type) {
            $existingVote->delete();
            $userVote = null;
        } else {
            $existingVote->update(['type' => $type]);
            $userVote = $type;
        }
    } else {
        Vote::create([
            'user_id' => $userId,
            'argument_id' => $argumentId,
            'type' => $type
        ]);
        $userVote = $type;
    }

    $argument = Argument::withCount([
        'votes as agree_count' => function ($query) { $query->where('type', 'agree'); },
        'votes as disagree_count' => function ($query) { $query->where('type', 'disagree'); }
    ])->find($argumentId);

    return response()->json([
        'status' => 'success',
        'agree_count' => $argument->agree_count,
        'disagree_count' => $argument->disagree_count,
        'user_vote' => $userVote
    ]);
}
}