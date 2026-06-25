<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Report;

class AdminOfficerController extends Controller
{
    /**
     * Display all officers
     */
    public function index()
    {
        $officers = User::with('department')
            ->whereIn('role', [
                'officer',
                'department_head',
                'admin',
                'super_admin'
            ])
            ->latest()
            ->get();

        return view('admin.officers.index', compact('officers'));
    }

    /**
     * Show create officer form
     */
    public function create()
    {
        $departments = Department::all();

        return view(
            'admin.officers.create',
            compact('departments')
        );
    }

    /**
     * Store new officer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $photo = null;

        if ($request->hasFile('profile_image')) {

            $photo = $request
                ->file('profile_image')
                ->store('officers', 'public');

        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id,
            'designation' => $request->designation,
            'phone' => $request->phone,
            'status' => $request->status,
            'profile_image' => $photo,
        ]);

        return redirect()
            ->route('admin.officers.index')
            ->with(
                'success',
                'Officer created successfully.'
            );
    }

    /**
     * Officer profile
     */
    public function show(User $officer)
    {
        $officer->load('department');

        $reports = Report::where('department_id', $officer->department_id)
            ->latest()
            ->get();

        $assignedReports = $reports->count();

        $pendingReports = $reports
            ->whereIn('status', ['submitted', 'pending', 'assigned', 'in_progress'])
            ->count();

        $resolvedReports = $reports
            ->where('status', 'resolved')
            ->count();

        $completionRate = $assignedReports > 0
            ? round(($resolvedReports / $assignedReports) * 100)
            : 0;

        return view('admin.officers.show', compact(
            'officer',
            'reports',
            'assignedReports',
            'pendingReports',
            'resolvedReports',
            'completionRate'
        ));
    }

    /**
     * Show edit form
     */
    public function edit(User $officer)
    {
        $departments = Department::all();

        return view(
            'admin.officers.edit',
            compact(
                'officer',
                'departments'
            )
        );
    }

    /**
     * Update officer
     */
    public function update(
        Request $request,
        User $officer
    ) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required',
        ]);

        $officer->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.officers.index')
            ->with(
                'success',
                'Officer updated successfully.'
            );
    }

    /**
     * Delete officer
     */
    public function destroy(User $officer)
    {
        $officer->delete();

        return redirect()
            ->route('admin.officers.index')
            ->with(
                'success',
                'Officer deleted successfully.'
            );
    }

    /**
     * Suspend officer
     */
    public function suspend(User $officer)
    {
        $officer->update([
            'status' => 'suspended'
        ]);

        return back()
            ->with(
                'success',
                'Officer suspended successfully.'
            );
    }
}