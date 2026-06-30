@extends('layouts.admin')

@section('title', 'Assigned Reports')

@section('content')

<style>
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:28px;
}

.page-title h1{
    font-size:30px;
    font-weight:700;
    color:#111827;
}

.page-title p{
    margin-top:6px;
    color:#6B7280;
}

.stats-row{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:#fff;
    border:1px solid #E5E7EB;
    border-radius:16px;
    padding:22px;
}

.stat-title{
    font-size:14px;
    color:#6B7280;
}

.stat-value{
    margin-top:8px;
    font-size:32px;
    font-weight:700;
    color:#111827;
}

.card{
    background:#fff;
    border:1px solid #E5E7EB;
    border-radius:16px;
    overflow:hidden;
}

.table-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
}

.search-box input{
    width:320px;
    padding:10px 14px;
    border:1px solid #D1D5DB;
    border-radius:10px;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#F9FAFB;
    padding:14px;
    text-align:left;
    color:#6B7280;
    font-size:13px;
}

.table td{
    padding:16px 14px;
    border-top:1px solid #E5E7EB;
}

.badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.pending{
    background:#FEF3C7;
    color:#92400E;
}

.submitted{
    background:#DBEAFE;
    color:#1D4ED8;
}

.assigned{
    background:#EDE9FE;
    color:#6D28D9;
}

.in_progress{
    background:#DBEAFE;
    color:#1D4ED8;
}

.resolved{
    background:#DCFCE7;
    color:#166534;
}

.high{
    background:#FEE2E2;
    color:#991B1B;
}

.medium{
    background:#FEF3C7;
    color:#92400E;
}

.low{
    background:#DCFCE7;
    color:#166534;
}

.actions{
    display:flex;
    gap:10px;
}

.btn{
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}

.btn-view{
    background:#2563EB;
    color:white;
}

.btn-update{
    background:#F3F4F6;
    color:#111827;
}

.pagination{
    padding:20px;
}
</style>

<div class="page-header">

    <div class="page-title">
        <h1>Assigned To Me</h1>
        <p>Reports currently assigned to you.</p>
    </div>

</div>

<div class="stats-row">

    <div class="stat-card">
        <div class="stat-title">Assigned Reports</div>
        <div class="stat-value">{{ $reports->total() }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Pending</div>
        <div class="stat-value">
            {{ $reports->where('status','pending')->count() }}
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-title">In Progress</div>
        <div class="stat-value">
            {{ $reports->where('status','in_progress')->count() }}
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Resolved</div>
        <div class="stat-value">
            {{ $reports->where('status','resolved')->count() }}
        </div>
    </div>

</div>

<div class="card">

    <div class="table-header">

        <h2>Assigned Reports</h2>

        <div class="search-box">
            <input type="text" placeholder="Search reports...">
        </div>

    </div>

    <table class="table">

        <thead>

        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Citizen</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Assigned</th>
            <th>Actions</th>
        </tr>

        </thead>

        <tbody>

        @forelse($reports as $report)

            <tr>

                <td>#CP-{{ $report->id }}</td>

                <td>
                    <strong>{{ $report->title }}</strong><br>

                    <small style="color:#6B7280;">
                        {{ \Illuminate\Support\Str::limit($report->description,55) }}
                    </small>
                </td>

                <td>
                    {{ optional($report->user)->name }}
                </td>

                <td>
                    <span class="badge {{ strtolower($report->priority) }}">
                        {{ ucfirst($report->priority) }}
                    </span>
                </td>

                <td>
                    <span class="badge {{ strtolower($report->status) }}">
                        {{ ucfirst(str_replace('_',' ',$report->status)) }}
                    </span>
                </td>

                <td>
                    {{ $report->updated_at->format('d M Y') }}
                </td>

                <td>

                    <div class="actions">

                        <a href="{{ route('officers.reports.show',$report) }}"
                           class="btn btn-view">
                            View
                        </a>

                        <a href="{{ route('officers.reports.show',$report) }}"
                           class="btn btn-update">
                            Update
                        </a>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" style="text-align:center;padding:40px;">
                    <strong>No reports have been assigned to you.</strong>
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="pagination">
        {{ $reports->links() }}
    </div>

</div>

@endsection