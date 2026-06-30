<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminDepartmentController;
use App\Http\Controllers\AdminOfficerController;

use App\Http\Controllers\OfficerReportController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Citizen Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:citizen'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/submit', [ReportController::class, 'create'])
        ->name('submit');

    Route::post('/submit', [ReportController::class, 'store'])
        ->name('reports.store');

    Route::get('/reports/{report}', [ReportController::class, 'show'])
        ->name('reports.show');
});


/*
|--------------------------------------------------------------------------
| Officer Routes
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Department Head Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:department_head'])->prefix('department')->name('department.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'departmentDashboard'])
        ->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| Admin & Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/reports', [AdminReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/pending', [AdminReportController::class, 'pending'])
            ->name('reports.pending');

        Route::get('/reports/resolved', [AdminReportController::class, 'resolved'])
            ->name('reports.resolved');

        Route::get('/reports/{report}', [AdminReportController::class, 'show'])
            ->name('reports.show');

        Route::patch('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])
            ->name('reports.updateStatus');


        Route::patch(
            '/reports/{report}/assign',
            [AdminReportController::class, 'assignOfficer']
        )->name('reports.assign');

        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        Route::resource('departments', AdminDepartmentController::class);

        /*
        |--------------------------------------------------------------------------
        | Officers
        |--------------------------------------------------------------------------
        */






        Route::resource('officers', AdminOfficerController::class);

        Route::patch('/officers/{officer}/suspend', [AdminOfficerController::class, 'suspend'])
            ->name('officers.suspend');
    });

Route::middleware(['auth', 'role:officer'])
    ->prefix('officers')
    ->name('officers.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'officerDashboard'])
            ->name('dashboard');

        Route::get('/reports', [OfficerReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/pending', [OfficerReportController::class, 'pending'])
            ->name('reports.pending');

        Route::get('/reports/in-progress', [OfficerReportController::class, 'inProgress'])
            ->name('reports.inprogress');

        Route::get('/reports/resolved', [OfficerReportController::class, 'resolved'])
            ->name('reports.resolved');

        Route::get('/reports/assigned', [OfficerReportController::class, 'assigned'])
            ->name('reports.assigned');

        Route::get('/reports/map', [OfficerReportController::class, 'map'])
            ->name('map');

        Route::get('/reports/{report}', [OfficerReportController::class, 'show'])
            ->name('reports.show');

        Route::patch('/reports/{report}/status', [OfficerReportController::class, 'updateStatus'])
            ->name('reports.updateStatus');

        Route::post('/reports/{report}/remark', [OfficerReportController::class, 'addRemark'])
            ->name('reports.remark');

        Route::get('/reports/assigned', [OfficerReportController::class, 'assigned'])
            ->name('reports.assigned');
    });



require __DIR__ . '/auth.php';