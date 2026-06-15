<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now  = Carbon::now();

        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd   = $now->copy()->subMonth()->endOfMonth();

        // ── Stat counts ────────────────────────────────────────────
        $totalReports = Report::where('id', $user->id)->count();

        $pendingReports = Report::where('id', $user->id)
                                ->whereIn('status', ['pending', 'submitted'])
                                ->count();

        $inProgressReports = Report::where('id', $user->id)
                                   ->where('status', 'in_progress')
                                   ->count();

        $resolvedReports = Report::where('id', $user->id)
                                 ->where('status', 'resolved')
                                 ->count();

        // ── Last-month counts for trend calculation ────────────────
        $lastMonthTotal = Report::where('id', $user->id)
                                ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                                ->count();

        $lastMonthPending = Report::where('id', $user->id)
                                  ->whereIn('status', ['pending', 'submitted'])
                                  ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                                  ->count();

        $lastMonthInProgress = Report::where('id', $user->id)
                                     ->where('status', 'in_progress')
                                     ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                                     ->count();

        $lastMonthResolved = Report::where('id', $user->id)
                                   ->where('status', 'resolved')
                                   ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                                   ->count();

        // ── Trend helpers ──────────────────────────────────────────
        $totalTrend      = $this->calcTrend($totalReports, $lastMonthTotal);
        $pendingTrend    = $this->calcTrend($pendingReports, $lastMonthPending);
        $inProgressTrend = $this->calcTrend($inProgressReports, $lastMonthInProgress);
        $resolvedTrend   = $this->calcTrend($resolvedReports, $lastMonthResolved);

        // ── Paginated report history ───────────────────────────────
        $reports = Report::where('id', $user->id)
                         ->with('department')
                         ->latest()
                         ->paginate(10);

        // ── Recent notifications ───────────────────────────────────
        // Use DB notifications table if you have one, or Laravel's built-in
        $notifications = DB::table('notifications')
                            ->where('id', $user->id)
                            ->latest()
                            ->take(5)
                            ->get();

        // ── Attention count ────────────────────────────────────────
        $attentionCount = Report::where('id', $user->id)
                                ->whereIn('status', ['pending', 'submitted', 'assigned'])
                                ->count();

        // ── Most recent active report for Case Tracker ─────────────
        $activeReport = Report::where('id', $user->id)
                              ->whereNotIn('status', ['resolved', 'closed'])
                              ->with('statusLogs')
                              ->latest()
                              ->first();

        // ── Impact rank ────────────────────────────────────────────
        $impactRank = $this->getImpactRank($user->id);

        // ── Map pins ───────────────────────────────────────────────
        $mapReports = Report::where('id', $user->id)
                            ->whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->latest()
                            ->take(10)
                            ->get(['id', 'status', 'latitude', 'longitude']);

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
            'mapReports',
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
            'value'     => abs($pct),
        ];
    }

    private function getImpactRank(int $userId): int
    {
        $rows = Report::selectRaw('id, COUNT(*) as cnt')
                      ->groupBy('id')
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