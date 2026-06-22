<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class AdminDashboardController extends Controller
{

    public function index()
    {
        $user = Auth::id();
        $now = Carbon::now();

        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // ── Stat counts ────────────────────────────────────────────
        $totalReports = Report::count();

        $pendingReports = Report::whereIn('status', [
            'pending',
            'submitted',
            'assigned'
        ])->count();

        $inProgressReports = Report::where('status', 'in_progress')
            ->count();

        $resolvedReports = Report::where('status', 'resolved')
            ->count();

        // ── Last-month counts for trend calculation ────────────────
        $lastMonthTotal = Report::where('id', $user)
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $lastMonthPending = Report::where('id', $user)
            ->whereIn('status', ['pending', 'submitted'])
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $lastMonthInProgress = Report::where('id', $user)
            ->where('status', 'in_progress')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $lastMonthResolved = Report::where('id', $user)
            ->where('status', 'resolved')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();




        // ── Trend helpers ──────────────────────────────────────────
        $totalTrend = $this->calcTrend($totalReports, $lastMonthTotal);
        $pendingTrend = $this->calcTrend($pendingReports, $lastMonthPending);
        $inProgressTrend = $this->calcTrend($inProgressReports, $lastMonthInProgress);
        $resolvedTrend = $this->calcTrend($resolvedReports, $lastMonthResolved);

        // ── Paginated report history ───────────────────────────────
        $sort = request('sort', 'latest');

$query = Report::with('user');

switch ($sort) {

    case 'oldest':
        $query->oldest();
        break;

    case 'priority':
        $query->orderByRaw("
            FIELD(priority,
            'High',
            'Medium',
            'Low')
        ");
        break;

    case 'status':
        $query->orderBy('status');
        break;

    default:
        $query->latest();
        break;
}

$reports = $query->paginate(10)
                 ->appends(request()->query());

        // ── Recent notifications ───────────────────────────────────
        // Use DB notifications table if you have one, or Laravel's built-in
        $notifications = DB::table('notifications')
            ->where('id', $user)
            ->latest()
            ->take(5)
            ->get();

        // ── Attention count ────────────────────────────────────────
        $attentionCount = Report::whereIn('status', [
            'pending',
            'submitted',
            'assigned'
        ])->count();

        // ── Most recent active report for Case Tracker ─────────────
        $activeReport = Report::whereNotIn('status', [
            'resolved',
            'closed'
        ])
            ->latest()
            ->first();

        $totalCategories = Report::distinct('category')
            ->count('category');

        $totalUsers = User::count();

        

        // ── Impact rank ────────────────────────────────────────────
        $impactRank = $this->getImpactRank(Auth::id());

        // ── Map pins ───────────────────────────────────────────────
          $mapReports = Report::whereNotNull('latitude')
    ->whereNotNull('longitude')
    ->latest()
    ->take(100)
    ->get([
        'id',
        'title',
        'status',
        'latitude',
        'longitude'
    ]);

        $departmentCounts = [
            'PWD' => Report::whereIn('category', [
                'Road Damage',
                'Pothole',
                'Drainage'
            ])->count(),

            'Water Supply' => Report::where('category', 'Water Leakage')->count(),

            'Electricity' => Report::where('category', 'Street Light')->count(),

            'Sanitation' => Report::where('category', 'Garbage')->count(),
        ];

        $monthlyReports = Report::selectRaw(
            'MONTH(created_at) as month,
     COUNT(*) as total'
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartLabels = [];
        $chartData = [];

        foreach ($monthlyReports as $report) {
            $chartLabels[] = Carbon::create()
                ->month($report->month)
                ->format('M');

            $chartData[] = $report->total;
        }

        $departmentCounts['Others'] =
            Report::count() - array_sum($departmentCounts);

        return view('admin.dashboard', compact(
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'reports',
            'notifications',
            'attentionCount',
            'activeReport',
            'totalUsers',
            'totalCategories',
            'departmentCounts',
            'chartLabels',
            'chartData',
            'mapReports'
        ));
    }

    // ── Private helpers ────────────────────────────────────────────

    private function calcTrend(int $current, int $previous): array
    {
        if ($previous === 0) {
            return ['direction' => 'up', 'value' => 0];
        }
        $pct = round((($current - $previous) / $previous) * 100);
        return [
            'direction' => $pct >= 0 ? 'up' : 'down',
            'value' => abs($pct),
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
            if ($row->user_id === $userId) {
                return $rank;
            }
            $rank++;
        }

        return $rank;
    }
}