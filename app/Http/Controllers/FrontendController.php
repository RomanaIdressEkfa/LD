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

   // app/Http/Controllers/FrontendController.php

public function processJoin(Request $request, $debateId) {
    // ১. ভ্যালিডেশন
    $request->validate([
        'name' => 'required|string|max:255',
        'side' => 'required|in:pro,con',
        'avatar' => 'nullable|image|max:2048',
    ]);

    $user = Auth::user(); // বর্তমান ইউজার (Admin বা অন্য কেউ)

    // ২. যদি ইউজার লগইন না থাকে (Guest), তবে নতুন ইউজার বানাবো
    if (!$user) {
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            // ডিফল্ট অ্যাভাতার
            $avatarPath = 'avatars/default.png'; 
        }

        $fakeEmail = Str::slug($request->name) . rand(1000, 9999) . '@debater.com';
        
        $user = User::create([
            'name' => $request->name,
            'email' => $fakeEmail,
            'password' => Hash::make('password123'),
            'avatar' => $avatarPath,
        ]);

        Auth::login($user);
    } else {
        // ৩. যদি ইউজার অলরেডি লগইন থাকে (যেমন: Admin)
        // আমরা চাইলে তার নাম বা ছবি আপডেট করতে পারি, অথবা শুধু পার্টিসিপেন্ট টেবিলে যোগ করতে পারি।
        // এখানে ইউজার যদি নতুন ছবি দেয়, তা আপডেট করে দিচ্ছি:
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();
        }
        // নাম আপডেট (অপশনাল, যদি চান অ্যাডমিন নাম পাল্টে ফেলুক)
        // $user->name = $request->name;
        // $user->save();
    }

    // ৪. ডিবেট পার্টিসিপেন্ট টেবিলে এন্ট্রি (updateOrCreate ব্যবহার করছি যাতে ডুপ্লিকেট না হয়)
    DebateParticipant::updateOrCreate(
        [
            'debate_id' => $debateId,
            'user_id' => $user->id
        ],
        [
            'side' => $request->side
        ]
    );

    // ৫. রিডাইরেক্ট এবং স্ক্রল (Anchor Tag ব্যবহার করা হয়েছে)
    // '#disqus-card' দিলে পেজ লোড হওয়ার পর সরাসরি কমেন্ট বক্সে চলে যাবে
    return redirect()->to(route('home') . '#disqus-card')->with('success', 'You have joined successfully! Now you can post.');
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
            'side' => $participant->side, // ডাটাবেস থেকে ইউজারের পক্ষ নেওয়া হচ্ছে
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