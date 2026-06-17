<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

// routes/web.php

use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/submit', function () {
    return view('layouts.submit');
})->name('submit');



Route::get('/reports/{report}', [ReportController::class, 'show'])
    ->name('show');



Route::get('/submit', [ReportController::class, 'create'])
    ->name('submit');

Route::post('/submit', [ReportController::class, 'store'])
    ->name('reports.store');

require __DIR__.'/auth.php';
