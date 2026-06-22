<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\AdminReportController;

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

use App\Http\Controllers\AdminDashboardController;

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

Route::get('/reports/{report}', [ReportController::class, 'show'])
    ->name('show');



Route::get('/submit', [ReportController::class, 'create'])
    ->name('submit');

Route::post('/submit', [ReportController::class, 'store'])
    ->name('reports.store');

Route::patch(
    '/admin/reports/{report}/status',
    [AdminReportController::class, 'updateStatus']
)->name('admin.reports.updateStatus');

Route::get('/admin/reports', [AdminReportController::class, 'index'])
    ->name('admin.reports.index');

Route::get('/admin/reports/pending', [AdminReportController::class, 'pending'])
    ->name('admin.reports.pending');

Route::get('/admin/reports/resolved', [AdminReportController::class, 'resolved'])
    ->name('admin.reports.resolved');

Route::get('/admin/reports/{report}', [AdminReportController::class, 'show'])
    ->name('admin.reports.show');
require __DIR__ . '/auth.php';
