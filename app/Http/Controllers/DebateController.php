<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use App\Models\Debate;
use App\Models\DebateParticipant;
use App\Models\Vote; // Don't forget this if you use it
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{
    // --- ADMIN PANEL METHODS ---

    public function index() {
        $debates = Debate::latest()->get();
        $targetDebate = null;
        return view('admin.debates.index', compact('debates','targetDebate'));
    }

    public function create() {
        return redirect()->route('admin.debates.index');
    }

    // Fixed STORE method to handle limits
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'limit_option' => 'required' // 'unlimited' or 'custom'
        ]);

        // Logic: If custom, take the number. If unlimited, set null.
        $limit = $request->limit_option === 'custom' ? $request->max_participants : null;

        Debate::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'active',
            'max_participants' => $limit // Save the limit
        ]);

        return redirect()->route('admin.debates.index')->with('success', 'Debate Created Successfully!');
    }

    public function edit($id) {
        $debates = Debate::latest()->get(); 
        $targetDebate = Debate::findOrFail($id); 
        return view('admin.debates.index', compact('debates', 'targetDebate'));
    }

    // Fixed UPDATE method to handle limits
    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'limit_option' => 'required'
        ]);

        $debate = Debate::findOrFail($id);
        
        // Logic: Calculate limit again
        $limit = $request->limit_option === 'custom' ? $request->max_participants : null;

        $debate->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'max_participants' => $limit // Update the limit
        ]);

        return redirect()->route('admin.debates.index')->with('success', 'Debate Updated!');
    }

    public function destroy($id) {
        Debate::destroy($id);
        return redirect()->route('admin.debates.index')->with('success', 'Debate Deleted!');
    }

public function show($id) {
    $debate = Debate::with(['participants.user'])->findOrFail($id);

    // Fetch Roots
    $roots = $debate->arguments()
        ->whereNull('parent_id')
        ->with(['user', 'votes', 'replies.user', 'replies.votes']) 
        ->latest()
        ->get();

    // Check User Side
    $userSide = null;
    if(Auth::check()) {
        $p = $debate->participants->where('user_id', Auth::id())->first();
        if($p) $userSide = $p->side;
    }

    return view('debate.show', compact('debate', 'roots', 'userSide'));
}


    public function join(Request $request, $debateId) {
        if(!Auth::check()) { return redirect()->route('login'); }
        if(Auth::user()->role === 'admin') { return redirect()->back()->with('error', 'Admins are Judges, not Debaters.'); }

        $debate = Debate::findOrFail($debateId);

        if($debate->isFull()) {
            return redirect()->back()->with('error', 'Sorry, this debate is full!');
        }

        $existing = DebateParticipant::where('debate_id', $debateId)->where('user_id', Auth::id())->first();
        if($existing) { return redirect()->back()->with('error', 'You have already joined this debate.'); }

        DebateParticipant::create([
            'debate_id' => $debateId,
            'user_id' => Auth::id(),
            'side' => $request->side 
        ]);

        return redirect()->back()->with('success', 'You have joined as a ' . strtoupper($request->side) . ' Debater!');
    }

    public function storeArgument(Request $request, $debateId) {
        $participant = DebateParticipant::where('debate_id', $debateId)->where('user_id', Auth::id())->first();

        if (!$participant) { return redirect()->back()->with('error', 'You must Join the debate first.'); }
        if ($participant->side !== $request->side) { return redirect()->back()->with('error', 'Wrong side.'); }

        Argument::create([
            'debate_id' => $debateId,
            'user_id' => Auth::id(),
            'side' => $request->side,
            'body' => $request->body,
            'parent_id' => $request->parent_id ?? null,
            'reply_type' => $request->reply_type ?? 'neutral',
        ]);

        return redirect()->back();
    }
      public function participants($id) {
        $debate = Debate::with(['participants.user'])->findOrFail($id);

        // Agreed এবং Disagreed আলাদা করা
        $agreed = $debate->participants->where('side', 'pro');
        $disagreed = $debate->participants->where('side', 'con');

        return view('admin.debates.participants', compact('debate', 'agreed', 'disagreed'));
    }
}