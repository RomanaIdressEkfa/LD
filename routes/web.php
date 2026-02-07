<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DebateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- FRONTEND ROUTES ---
Route::get('/', [FrontendController::class, 'index'])->name('home');

// গেস্ট ইউজারদের জন্য জয়েন প্রসেস (নাম, ছবি দিয়ে)
Route::get('/debate/{id}/join-guest', [FrontendController::class, 'showJoinForm'])->name('debate.join_form');
Route::post('/debate/{id}/join-guest', [FrontendController::class, 'processJoin'])->name('debate.process_join');

// লগইন করা ইউজারদের জন্য
Route::middleware('auth')->group(function () {
    Route::post('/debate/{id}/argument', [FrontendController::class, 'storeArgument'])->name('argument.store');
    Route::post('/argument/{id}/vote', [FrontendController::class, 'vote'])->name('argument.vote');
    
    // যারা অলরেডি লগইন কিন্তু ডিবেটে জয়েন করেনি
    Route::post('/debate/{id}/join-auth', [DebateController::class, 'join'])->name('debate.join');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::resource('debates', DebateController::class);
});

// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';