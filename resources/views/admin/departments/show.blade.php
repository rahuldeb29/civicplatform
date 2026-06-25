@extends('layouts.admin')

@section('title', $department->name)

@section('content')


<div class="page-header">
    <h1>{{ $department->name }}</h1>
    <p>{{ $department->description }}</p>
</div>

<div class="stats-grid">

    <div class="stat-card">
        <h3>Total Reports</h3>
        <span>
            {{ \App\Models\Report::where('department_id',$department->id)->count() }}
        </span>
    </div>

    <div class="stat-card">
        <h3>Pending</h3>
        <span>
            {{ \App\Models\Report::where('department_id',$department->id)
                ->whereIn('status',['pending','submitted'])
                ->count() }}
        </span>
    </div>

    <div class="stat-card">
        <h3>Resolved</h3>
        <span>
            {{ \App\Models\Report::where('department_id',$department->id)
                ->where('status','resolved')
                ->count() }}
        </span>
    </div>

</div>

<div class="card">

    <h3>Department Information</h3>

    <table class="info-table">
        <tr>
            <td>Name</td>
            <td>{{ $department->name }}</td>
        </tr>

        <tr>
            <td>Code</td>
            <td>{{ $department->code }}</td>
        </tr>

        <tr>
            <td>Head Officer</td>
            <td>{{ $department->head_officer }}</td>
        </tr>

        <tr>
            <td>Email</td>
            <td>{{ $department->email }}</td>
        </tr>

        <tr>
            <td>Phone</td>
            <td>{{ $department->phone }}</td>
        </tr>

    </table>

</div>

<div class="card">

    <h3>Recent Reports</h3>

    <table class="table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>

            @forelse($reports as $report)

                <tr>

                    <td>#CP-{{ $report->id }}</td>

                    <td>{{ $report->title }}</td>

                    <td>{{ $report->priority }}</td>

                    <td>{{ $report->status }}</td>

                    <td>
                        {{ $report->created_at->format('d M Y') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5">
                        No reports assigned.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection