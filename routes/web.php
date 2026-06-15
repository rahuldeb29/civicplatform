<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// routes/web.php

use App\Http\Controllers\Dashboard\CitizenDashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CitizenDashboardController::class, 'index'])
         ->name('dashboard');
});

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
