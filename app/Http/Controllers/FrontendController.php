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
    public function index() {
        $debate = Debate::where('status', 'active')->latest()->first();

        $roots = collect();
        if ($debate) {
            $roots = $debate->arguments()
                ->whereNull('parent_id')
                ->with(['user', 'votes', 'replies.user', 'replies.votes'])
                ->latest()
                ->get();
        }

        // লজিক: ইউজার লগইন থাকলেও, সে এই ডিবেটে জয়েন করেছে কিনা চেক করা
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
        
        // যদি ইউজার অলরেডি জয়েন করা থাকে (পক্ষ নিয়ে থাকে), তবে তাকে জয়েন পেজে যেতে দেব না
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
    // ১. এডমিন চেক
    if (Auth::check() && Auth::user()->role === 'admin') {
        Auth::logout();
        return redirect()->route('debate.join_form', $debateId)
            ->with('error', 'Please join as a regular user (not Admin).');
    }

    $user = Auth::user();

    // ২. যদি নতুন ইউজার হয় (রেজিস্ট্রেশন)
    if (!$user) {
        // ভ্যালিডেশন
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

        // ইউজার তৈরি (Create User with provided credentials)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // আসল ইমেইল
            'password' => Hash::make($request->password), // আসল পাসওয়ার্ড
            'avatar' => $avatarPath,
            'role' => 'user'
        ]);

        // লগইন করানো
        Auth::login($user, true);
    } else {
        // বিদ্যমান ইউজার হলে শুধু সাইড চেক
        $request->validate([
            'side' => 'required|in:pro,con',
        ]);
        
        // ছবি আপডেট (অপশনাল)
        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'nullable|image|max:5120']);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
            $user->save();
        }
    }

    // ৩. ডিবেটে এন্ট্রি
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

        // চেক: ইউজার কি পার্টিসিপেন্ট? (এডমিন হলেও এখানে আটকাবে যদি সে জয়েন না করে)
        $participant = DebateParticipant::where('debate_id', $debateId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$participant) {
            return redirect()->route('debate.join_form', $debateId)
                ->with('error', 'Please choose a side to participate in this debate.');
        }

        $request->validate(['body' => 'required']);

       Argument::create([
            'debate_id' => $debateId,
            'user_id' => Auth::id(),
            // Use the request input (clicked button value), fallback to participant side if missing
            'side' => $request->side ?? $participant->side, 
            'body' => $request->body,
            'parent_id' => $request->parent_id ?? null,
            'reply_type' => $request->reply_type ?? 'neutral',
        ]);

        return redirect()->back()->with('success', 'Comment posted!');
    }

    // vote method same as before...
    public function vote(Request $request, $argumentId) {
        if(!Auth::check()) return redirect()->route('debate.join_form', Argument::find($argumentId)->debate_id);
        Vote::updateOrCreate(['user_id' => Auth::id(), 'argument_id' => $argumentId], ['type' => $request->type]);
        return redirect()->back();
    }
}