<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\Argument;
use App\Models\Vote;
use App\Models\DebateParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index() {
    $debate = Debate::where('status', 'active')->latest()->first();

    $roots = collect();
    if ($debate) {
        $roots = $debate->arguments()
            ->whereNull('parent_id') // শুধুমাত্র মেইন আর্গুমেন্টগুলো আনবে
            ->with(['user', 'votes', 'replies']) // মডেলের 'replies' এর ভেতর already recursive load দেওয়া আছে
            ->latest()
            ->get();
    }

    // বাকি কোড অপরিবর্তিত থাকবে...
    $userSide = null;
    if(Auth::check() && $debate) {
        $participant = DebateParticipant::where('debate_id', $debate->id)
            ->where('user_id', Auth::id())
            ->first();
        if($participant) $userSide = $participant->side;
    }

    return view('home', compact('debate', 'roots', 'userSide'));
}

   public function storeArgument(Request $request, $debateId) {
    // 1. Validation
    $request->validate([
        'body' => 'required',
        // 'side' => 'required' // এডমিনের জন্য এটি কমেন্ট করে রাখতে পারেন টেস্টিং এর সময়
    ]);

    // 2. Determine Side (Fallback for Admin)
    $side = $request->side;
    
    // যদি সাধারণ ইউজার হয়, চেক করুন সে সাইড সুইচ করছে কিনা
    if (Auth::user()->role !== 'admin') {
        $participant = DebateParticipant::where('debate_id', $debateId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$participant) {
            return redirect()->back()->with('error', 'You must join the debate first!');
        }
        $side = $participant->side;
    } else {
        // এডমিন হলে ডিফল্ট 'pro' অথবা ফর্ম থেকে আসা ভ্যালু নিন
        $side = $request->side ?? 'pro';
    }

    // 3. Create Argument
    Argument::create([
        'debate_id' => $debateId,
        'user_id' => Auth::id(),
        'side' => $side,
        'body' => $request->body,
        'parent_id' => $request->parent_id ?? null, // Parent ID রিসিভ হচ্ছে কিনা নিশ্চিত করুন
        'reply_type' => $request->reply_type ?? 'neutral',
    ]);

    return redirect()->back()->with('success', 'Argument posted!');
}

    public function vote(Request $request, $argumentId) {
        if(!Auth::check()) return redirect()->route('login');
        
        // Use updateOrCreate for cleaner code
        Vote::updateOrCreate(
            ['user_id' => Auth::id(), 'argument_id' => $argumentId],
            ['type' => $request->type]
        );

        return redirect()->back();
    }
}