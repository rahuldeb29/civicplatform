<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Main Dashboard Redirect
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {

            'citizen'        => $this->citizenDashboard(),

            'officer'        => $this->officerDashboard(),

            'department_head'=> $this->departmentDashboard(),

            'admin',
            'super_admin'    => redirect()->route('admin.dashboard'),

            default          => abort(403),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Citizen Dashboard
    |--------------------------------------------------------------------------
    */

    public function citizenDashboard()
    {
        $user = Auth::id();
        $now  = Carbon::now();

        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd   = $now->copy()->subMonth()->endOfMonth();

        $totalReports = Report::where('user_id', $user)->count();

        $pendingReports = Report::where('user_id', $user)
            ->whereIn('status', ['pending','submitted'])
            ->count();

        $inProgressReports = Report::where('user_id', $user)
            ->where('status','in_progress')
            ->count();

        $resolvedReports = Report::where('user_id', $user)
            ->where('status','resolved')
            ->count();

        $lastMonthTotal = Report::where('user_id',$user)
            ->whereBetween('created_at',[$lastMonthStart,$lastMonthEnd])
            ->count();

        $lastMonthPending = Report::where('user_id',$user)
            ->whereIn('status',['pending','submitted'])
            ->whereBetween('created_at',[$lastMonthStart,$lastMonthEnd])
            ->count();

        $lastMonthInProgress = Report::where('user_id',$user)
            ->where('status','in_progress')
            ->whereBetween('created_at',[$lastMonthStart,$lastMonthEnd])
            ->count();

        $lastMonthResolved = Report::where('user_id',$user)
            ->where('status','resolved')
            ->whereBetween('created_at',[$lastMonthStart,$lastMonthEnd])
            ->count();

        $totalTrend = $this->calcTrend($totalReports,$lastMonthTotal);

        $pendingTrend = $this->calcTrend($pendingReports,$lastMonthPending);

        $inProgressTrend = $this->calcTrend($inProgressReports,$lastMonthInProgress);

        $resolvedTrend = $this->calcTrend($resolvedReports,$lastMonthResolved);

        $reports = Report::where('user_id',$user)
            ->latest()
            ->paginate(10);

        $notifications = DB::table('notifications')
            ->where('user_id',$user)
            ->latest()
            ->take(5)
            ->get();

        $attentionCount = Report::where('user_id',$user)
            ->whereIn('status',['pending','submitted','assigned'])
            ->count();

        $activeReport = Report::where('user_id',$user)
            ->whereNotIn('status',['resolved','closed'])
            ->latest()
            ->first();

        $impactRank = $this->getImpactRank($user);

        $mapReports = Report::where('user_id',$user)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->take(10)
            ->get([
                'id',
                'title',
                'status',
                'latitude',
                'longitude'
            ]);

        return view('dashboard', compact(
            'user',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'totalTrend',
            'pendingTrend',
            'inProgressTrend',
            'resolvedTrend',
            'reports',
            'notifications',
            'attentionCount',
            'activeReport',
            'impactRank',
            'mapReports'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Officer Dashboard
    |--------------------------------------------------------------------------
    */

    public function officerDashboard()
    {
        $user = Auth::user();

        $departmentId = $user->department_id;

        $reports = Report::where('department_id',$departmentId)
            ->latest()
            ->paginate(10);

        $totalReports = Report::where('department_id',$departmentId)->count();

        $pendingReports = Report::where('department_id',$departmentId)
            ->whereIn('status',['pending','submitted'])
            ->count();

        $inProgressReports = Report::where('department_id',$departmentId)
            ->where('status','in_progress')
            ->count();

        $resolvedReports = Report::where('department_id',$departmentId)
            ->where('status','resolved')
            ->count();

        $notifications = DB::table('notifications')
            ->where('user_id',$user->id)
            ->latest()
            ->take(5)
            ->get();

        $mapReports = Report::where('department_id',$departmentId)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.officers.dashboard', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'notifications',
            'mapReports'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Department Head Dashboard
    |--------------------------------------------------------------------------
    */

    public function departmentDashboard()
    {
        $user = Auth::user();

        $departmentId = $user->department_id;

        $reports = Report::where('department_id',$departmentId)
            ->latest()
            ->paginate(10);

        $totalReports = Report::where('department_id',$departmentId)->count();

        $pendingReports = Report::where('department_id',$departmentId)
            ->whereIn('status',['pending','submitted'])
            ->count();

        $inProgressReports = Report::where('department_id',$departmentId)
            ->where('status','in_progress')
            ->count();

        $resolvedReports = Report::where('department_id',$departmentId)
            ->where('status','resolved')
            ->count();

        $officers = DB::table('users')
            ->where('department_id',$departmentId)
            ->whereIn('role',['officer','department_head'])
            ->get();

        $notifications = DB::table('notifications')
            ->where('user_id',$user->id)
            ->latest()
            ->take(5)
            ->get();

        $mapReports = Report::where('department_id',$departmentId)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.departments.dashboard', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'officers',
            'notifications',
            'mapReports'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function calcTrend(int $current, int $previous): array
    {
        if ($previous == 0) {
            return [
                'direction' => 'up',
                'value' => 0
            ];
        }

        $percent = round((($current-$previous)/$previous)*100);

        return [
            'direction' => $percent >= 0 ? 'up' : 'down',
            'value' => abs($percent)
        ];
    }

    private function getImpactRank(int $userId): int
    {
        $rows = Report::selectRaw('user_id, COUNT(*) as cnt')
            ->groupBy('user_id')
            ->orderByDesc('cnt')
            ->get();

        $rank = 1;

        foreach ($rows as $row) {

            if ($row->user_id == $userId) {
                return $rank;
            }

            $rank++;
        }

        return $rank;
    }
}