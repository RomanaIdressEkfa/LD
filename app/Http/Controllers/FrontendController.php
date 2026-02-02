<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\Argument;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index() {
        $debate = Debate::where('status', 'active')
            ->with(['arguments.user', 'arguments.votes', 'arguments.replies.user'])
            ->latest()
            ->first();

        $pros = $debate ? $debate->arguments->where('side', 'pro') : collect();
        $cons = $debate ? $debate->arguments->where('side', 'con') : collect();

        return view('home', compact('debate', 'pros', 'cons'));
    }

    public function storeArgument(Request $request, $debateId) {
        $request->validate(['body' => 'required', 'side' => 'required']);

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

    public function vote(Request $request, $argumentId) {
        if(!Auth::check()) return redirect()->route('login');
        
        $existing = Vote::where('user_id', Auth::id())->where('argument_id', $argumentId)->first();

        if ($existing) {
            $existing->update(['type' => $request->type]);
        } else {
            Vote::create([
                'user_id' => Auth::id(),
                'argument_id' => $argumentId,
                'type' => $request->type
            ]);
        }
        return redirect()->back();
    }
}