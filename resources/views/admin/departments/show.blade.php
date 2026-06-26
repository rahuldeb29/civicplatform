@extends('layouts.admin')

@section('title', $department->name)

@section('content')

<style>
    /* Base spacing and layout */
    .page-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .page-header h1 {
        font-size: 1.875rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        margin-top: 0;
    }
    .page-header p {
        color: #64748b;
        font-size: 1rem;
        margin: 0;
    }

    /* Grid for Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    /* Individual Stat Cards */
    .stat-card {
        background: #ffffff;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease-in-out;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
    .stat-card h3 {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0;
        margin-bottom: 0.75rem;
    }
    .stat-card span {
        font-size: 2.25rem;
        font-weight: 700;
        color: #0f172a;
        display: block;
        line-height: 1;
    }

    /* General Cards */
    .card {
        background: #ffffff;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
    }
    .card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-top: 0;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Department Info Table */
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table td {
        padding: 0.875rem 0;
        border-bottom: 1px solid #f8fafc;
    }
    .info-table tr:last-child td {
        border-bottom: none;
    }
    .info-table td:first-child {
        font-weight: 500;
        color: #64748b;
        width: 30%;
    }
    .info-table td:last-child {
        color: #1e293b;
        font-weight: 500;
    }

    /* Recent Reports Data Table */
    .table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .table th, .table td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    .table tbody td {
        color: #334155;
        font-size: 0.95rem;
    }
    
    /* Status Badges */
    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-block;
    }
    .badge-pending { background-color: #fef3c7; color: #92400e; }
    .badge-resolved { background-color: #d1fae5; color: #065f46; }
    .badge-submitted { background-color: #e0e7ff; color: #3730a3; }
    .badge-default { background-color: #f1f5f9; color: #475569; }
</style>

<div class="page-header">
    <h1>{{ $department->name }}</h1>
    <p>{{ $department->description }}</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Reports</h3>
        <span>
            {{ $totalReports }}
        </span>
    </div>

    <div class="stat-card">
        <h3>Pending</h3>
        <span>
            {{ $pendingReports }}
        </span>
    </div>

    <div class="stat-card">
        <h3>Resolved</h3>
        <span>
            {{ $resolvedReports }}
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
                    <td style="font-weight: 600; color: #2563eb;">#CP-{{ $report->id }}</td>
                    <td>{{ $report->title }}</td>
                    <td>{{ $report->priority }}</td>
                    <td>
                        <span class="badge badge-{{ strtolower($report->status) }}">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td style="color: #64748b;">
                        {{ $report->created_at->format('d M Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #64748b; padding: 2rem;">
                        No reports assigned.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">

    <h3>Department Officers</h3>

    @forelse($officers as $officer)

        <p>
            <strong>{{ $officer->name }}</strong>
            <br>
            {{ ucfirst(str_replace('_',' ',$officer->role)) }}
        </p>

    @empty

        <p>No officers assigned.</p>

    @endforelse

</div>

@endsection