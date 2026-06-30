<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\User;

class AdminReportController extends Controller
{



    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:submitted,assigned,in_progress,resolved,closed'
        ]);

        $report->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status updated successfully');
    }

    public function index()
    {
        $reports = Report::with('user')
            ->latest()
            ->paginate(15);
        $query = Report::with('user');

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('category')) {
            $query->where('category', request('category'));
        }

        $reports = $query->latest()->paginate(15);

        return view('admin.reports.index', compact('reports'));
    }

    public function pending()
    {
        $reports = Report::with('user')
            ->whereIn('status', [
                'submitted',
                'pending',
                'assigned'
            ])
            ->latest()
            ->paginate(15);

        $pendingCount = Report::whereIn('status', [
            'submitted',
            'pending',
            'assigned'
        ])->count();

        return view(
            'admin.reports.pending',
            compact(
                'reports',
                'pendingCount'
            )
        );
    }

    public function resolved()
    {
        $reports = Report::with('user')
            ->whereIn('status', [

                'resolved',

            ])
            ->latest()
            ->paginate(15);

        $resolvedCount = Report::whereIn('status', [
            'resolved'
        ])->count();

        return view(
            'admin.reports.resolved',
            compact(
                'reports',
                'resolvedCount'
            )
        );
    }

    public function show(Report $report)
    {
        $report->load([
            'user',
            'assignedOfficer'
        ]);

        $officers = User::where('role', 'officer')
            ->where('department_id', $report->department_id)
            ->orderBy('name')
            ->get();

        return view('admin.reports.show', compact(
            'report',
            'officers'
        ));
    }

    public function assignOfficer(Request $request, Report $report)
{
    $request->validate([
        'assigned_to' => 'required|exists:users,id',
    ]);

    $report->update([
        'assigned_to' => $request->assigned_to,
        'status' => 'assigned',
    ]);

    return back()->with('success', 'Officer assigned successfully.');
}
}