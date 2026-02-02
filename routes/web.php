<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DebateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- FRONTEND ROUTES ---
Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/debate/{id}/argument', [FrontendController::class, 'storeArgument'])->name('argument.store');
    Route::post('/argument/{id}/vote', [FrontendController::class, 'vote'])->name('argument.vote');
    Route::post('/debate/{id}/join', [DebateController::class, 'join'])->name('debate.join');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');

    Route::get('/debates', [DebateController::class, 'index'])->name('debates.index');
    Route::get('/debates/create', [DebateController::class, 'create'])->name('debates.create');
    Route::post('/debates', [DebateController::class, 'store'])->name('debates.store');
    Route::get('/debates/{id}/edit', [DebateController::class, 'edit'])->name('debates.edit');
    Route::put('/debates/{id}', [DebateController::class, 'update'])->name('debates.update');
    Route::delete('/debates/{id}', [DebateController::class, 'destroy'])->name('debates.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';