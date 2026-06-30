<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerReportController extends Controller
{
    /**
     * All reports belonging to officer's department.
     */
    public function index()
    {
        $departmentId = Auth::user()->department_id;

        $totalReports = Report::where('department_id', $departmentId)->count();

        $pendingReports = Report::where('department_id', $departmentId)
            ->whereIn('status', ['pending', 'submitted'])
            ->count();

        $inProgressReports = Report::where('department_id', $departmentId)
            ->where('status', 'in_progress')
            ->count();

        $resolvedReports = Report::where('department_id', $departmentId)
            ->where('status', 'resolved')
            ->count();

        $reports = Report::with('user')
            ->where('department_id', $departmentId)
            ->latest()
            ->paginate(10);

        return view('admin.officers.reports.index', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports'
        ));
    }

    /**
     * Pending reports.
     */
    public function pending()
    {
        $departmentId = Auth::user()->department_id;

        $reports = Report::where('department_id', $departmentId)
            ->whereIn('status', ['pending', 'submitted'])
            ->latest()
            ->paginate(10);

        return view('admin.officers.reports.pending', compact('reports'));
    }

    /**
     * In Progress reports.
     */
    public function inProgress()
    {
        $departmentId = Auth::user()->department_id;

        $reports = Report::where('department_id', $departmentId)
            ->where('status', 'in_progress')
            ->latest()
            ->paginate(10);

        return view('admin.officers.reports.inprogress', compact('reports'));
    }

    /**
     * Resolved reports.
     */
    public function resolved()
    {
        $departmentId = Auth::user()->department_id;

        $reports = Report::where('department_id', $departmentId)
            ->where('status', 'resolved')
            ->latest()
            ->paginate(10);

        return view('admin.officers.reports.resolved', compact('reports'));
    }

    /**
     * Reports assigned to logged-in officer.
     */
    public function assigned()
    {
        $reports = Report::where('assigned_to', Auth::id())
            ->latest()
            ->paginate(10);

        return view('admin.officers.reports.assigned', compact('reports'));
    }



    /**
     * Map page.
     */
    public function map()
    {
        $departmentId = Auth::user()->department_id;

        $reports = Report::where('department_id', $departmentId)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('admin.officers.reports.map', compact('reports'));
    }

    /**
     * Officer report details.
     */
    public function show(Report $report)
    {
        if ($report->department_id != Auth::user()->department_id) {
            abort(403);
        }

        return view('admin.officers.reports.show', compact('report'));
    }

    /**
     * Officer updates report status.
     */
    public function updateStatus(Request $request, Report $report)
    {
        if ($report->department_id != Auth::user()->department_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,submitted,assigned,in_progress,resolved,rejected',
        ]);

        $report->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Report status updated successfully.');
    }

    /**
     * Officer adds remarks.
     */
    public function addRemark(Request $request, Report $report)
    {
        if ($report->department_id != Auth::user()->department_id) {
            abort(403);
        }

        $request->validate([
            'remark' => 'required|string|max:1000',
        ]);

        $report->remarks = $request->remark;
        $report->save();

        return back()->with('success', 'Remark added successfully.');
    }


}