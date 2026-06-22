<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create()
    {
        return view('layouts.submit');
    }

    public function show(Report $report)
{
    $report->load('user');

    return view('requests.show', compact('report'));
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'priority' => 'required',
            'description' => 'required',
            'location' => 'required',
            'image' => 'nullable|image',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'accuracy' => 'nullable|numeric',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('reports', 'public');
        }

        $report = Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'priority' => $request->priority,
            'description' => $request->description,
            'location' => $request->location,

            

            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,

            'image' => $imagePath,
            'status' => 'submitted',
        ]);
        
        return redirect()
            ->route('dashboard')
            ->with('success', 'Report submitted successfully.');
    }
}