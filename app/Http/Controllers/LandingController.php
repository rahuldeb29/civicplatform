<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Department;
class LandingController extends Controller
{
    //
    public function index()
{
    $totalReports = Report::count();

    $resolvedReports = Report::where('status','resolved')->count();

    $departmentCount = Department::count();

    $officerCount = User::whereIn('role',[
        'officer',
        'department_head',
        'admin',
        'super_admin'
    ])->count();

    $resolutionRate = $totalReports > 0
        ? round(($resolvedReports / $totalReports) * 100)
        : 0;

    return view('welcome', compact(
        'totalReports',
        'resolvedReports',
        'departmentCount',
        'officerCount',
        'resolutionRate'
    ));
}


}
