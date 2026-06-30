@extends('layouts.admin')

@section('title', 'Department Reports')

@section('content')

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-title h1 {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
        }

        .page-title p {
            color: #6B7280;
            margin-top: 5px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 22px;
            border: 1px solid #E5E7EB;
        }

        .stat-title {
            font-size: 14px;
            color: #6B7280;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-top: 8px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .search-box input {
            width: 320px;
            padding: 10px 14px;
            border: 1px solid #D1D5DB;
            border-radius: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #F9FAFB;
            padding: 15px;
            text-align: left;
            font-size: 13px;
            color: #6B7280;
            border-bottom: 1px solid #E5E7EB;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: top;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .submitted {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .in_progress {
            background: #E0F2FE;
            color: #0369A1;
        }

        .resolved {
            background: #DCFCE7;
            color: #166534;
        }

        .high {
            background: #FEE2E2;
            color: #991B1B;
        }

        .medium {
            background: #FEF3C7;
            color: #92400E;
        }

        .low {
            background: #DCFCE7;
            color: #166534;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .btn-view {
            background: #2563EB;
            color: #fff;
        }

        .btn-status {
            background: #F3F4F6;
            color: #111827;
        }

        .pagination {
            padding: 20px;
        }

        .pending {
            background: #FEF3C7;
            color: #92400E;
            border: 1px solid #FBBF24;
        }
    </style>

    <div class="page-header">
        <div class="page-title">
            <h1>Resolved Reports</h1>
            <p>Reports waiting for review or assignment.</p>
        </div>
    </div>

    <div class="stats-row">

        <div class="stat-card">
            <div class="stat-title">Resolved Reports</div>
            <div class="stat-value">{{ $reports->total() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">High Priority</div>
            <div class="stat-value">
                {{ $reports->where('priority', 'High')->count() }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Submitted Today</div>
            <div class="stat-value">
                {{ $reports->where('created_at', '>=', now()->startOfDay())->count() }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Awaiting Action</div>
            <div class="stat-value">
                {{ $reports->count() }}
            </div>
        </div>

    </div>

    <div class="card">

        <div class="table-header">
            <h2>Pending Department Reports</h2>

            <div class="search-box">
                <input type="text" placeholder="Search pending reports...">
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
                    <th>Date</th>
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
                                {{ \Illuminate\Support\Str::limit($report->description, 50) }}
                            </small>
                        </td>

                        <td>
                            {{ optional($report->user)->name ?? 'Citizen' }}
                        </td>

                        <td>
                            <span class="badge {{ strtolower($report->priority) }}">
                                {{ ucfirst($report->priority) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge {{ strtolower($report->status) }}">
                                {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                            </span>
                        </td>

                        <td>
                            {{ $report->created_at->format('d M Y') }}
                        </td>

                        <td>

                            <div class="actions">

                                <a href="{{ route('officers.reports.show', $report) }}" class="btn btn-view">
                                    View
                                </a>

                                <a href="{{ route('officers.reports.show', $report) }}" class="btn btn-status">
                                    Update
                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align:center;padding:35px;">
                            No reports in progress found.
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