<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\User;
use App\Models\Argument;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $totalDebates = Debate::count();
        $totalUsers = User::count();
        $proArgs = Argument::where('side', 'pro')->count();
        $conArgs = Argument::where('side', 'con')->count();

        $recentDebates = Debate::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalDebates', 'totalUsers', 'proArgs', 'conArgs', 'recentDebates'));
    }

    public function users() {
        $users = User::latest()->get(); 
        return view('admin.users.index', compact('users'));
    }
}