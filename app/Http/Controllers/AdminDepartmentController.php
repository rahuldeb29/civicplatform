<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;

use App\Models\Report;

use App\Models\User;

class AdminDepartmentController extends Controller
{
    
    public function index()
    {
        $departments = Department::withCount([
            'reports',

            'reports as pending_reports_count' => function ($query) {
                $query->whereIn('status', [
                    'pending',
                    'submitted',
                    'assigned',
                    'in_progress'
                ]);
            },

            'reports as resolved_reports_count' => function ($query) {
                $query->where('status', 'resolved');
            },

            'officers'
        ])
            ->with('officers')
            ->get();

        return view(
            'admin.departments.index',
            compact('departments')
        );
    }

    
    public function create()
    {
        //
        $departments = Department::all();
        return view('admin.departments.create', compact('departments'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'head_name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'description' => 'nullable',
        ]);

        Department::create([
            'name' => $request->name,
            'code' => $request->code,
            'head_name' => $request->head_officer,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department created successfully');
    }



public function show($id)
{
    $department = Department::findOrFail($id);

    $reports = Report::where('department_id', $department->id)
        ->latest()
        ->take(10)
        ->get();

    $totalReports = Report::where('department_id', $department->id)->count();

    $pendingReports = Report::where('department_id', $department->id)
        ->whereIn('status', ['pending','submitted'])
        ->count();

    $resolvedReports = Report::where('department_id', $department->id)
        ->where('status', 'resolved')
        ->count();

    $officers = User::where('department_id', $department->id)
        ->whereIn('role', [
            'officer',
            'department_head',
            'admin'
        ])
        ->get();

    return view('admin.departments.show', compact(
        'department',
        'reports',
        'totalReports',
        'pendingReports',
        'resolvedReports',
        'officers'
    ));
}

    public function edit(Department $department)
    {
        return view(
            'admin.departments.edit',
            compact('department')
        );
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $department->update($request->all());

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }


}
