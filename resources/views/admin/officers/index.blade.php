@extends('layouts.admin')

@section('title', 'Officers')

@section('content')

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .page-header p {
            color: #6B7280;
            margin-top: 4px;
        }

        .btn-primary {
            background: #2563EB;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 20px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
        }

        .stat-label {
            color: #6B7280;
            font-size: 14px;
        }

        .table-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #E5E7EB;
        }

        .search-box input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #D1D5DB;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #F9FAFB;
        }

        th {
            text-align: left;
            padding: 16px;
            font-size: 13px;
            color: #6B7280;
            text-transform: uppercase;
        }

        td {
            padding: 16px;
            border-top: 1px solid #F3F4F6;
        }

        .officer-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #2563EB;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .officer-name {
            font-weight: 600;
        }

        .officer-email {
            font-size: 13px;
            color: #6B7280;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #DCFCE7;
            color: #166534;
        }

        .status-suspended {
            background: #FEE2E2;
            color: #991B1B;
        }

        .role-admin {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .role-officer {
            background: #EDE9FE;
            color: #6D28D9;
        }

        .role-department_head {
            background: #FEF3C7;
            color: #92400E;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-view,
        .btn-edit,
        .btn-suspend,
        .btn-delete {
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-view {
            background: #2563EB;
            color: white;
        }

        .btn-edit {
            background: #F3F4F6;
            color: #111827;
        }

        .btn-suspend {
            background: #FEF3C7;
            color: #92400E;
        }

        .btn-delete {
            background: #FEE2E2;
            color: #DC2626;
        }
    </style>

    <div class="page-header">

        <div>
            <h1>Officers & Administrators</h1>
            <p>Manage department officers and administrators.</p>
        </div>

        <a href="{{ route('admin.officers.create') }}" class="btn-primary">
            + Add Officer
        </a>

    </div>

    <div class="stats-row">

        <div class="stat-card">
            <div class="stat-value">
                {{ $officers->count() }}
            </div>
            <div class="stat-label">
                Total Officers
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-value">
                {{ $officers->where('status', 'active')->count() }}
            </div>
            <div class="stat-label">
                Active
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-value">
                {{ $officers->where('status', 'suspended')->count() }}
            </div>
            <div class="stat-label">
                Suspended
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-value">
                {{ $officers->pluck('department_id')->unique()->count() }}
            </div>
            <div class="stat-label">
                Departments
            </div>
        </div>

    </div>

    <div class="table-card">

        <div class="table-header">

            <div class="search-box">
                <input type="text" placeholder="Search officers...">
            </div>

        </div>

        <table>

            <thead>
                <tr>
                    <th>Officer</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Reports</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($officers as $officer)

                    <tr>

                        <td>

                            <div class="officer-cell">

                                <div class="avatar">
                                    @if($officer->profile_image)
                                        <img src="{{ asset('storage/' . $officer->profile_image) }}" alt="{{ $officer->name }}"
                                            style="border-radius: 50%; height: 45px; width: 45px;">
                                    @else
                                        {{ strtoupper(substr($officer->name, 0, 1)) }}
                                    @endif
                                </div>

                                <div>

                                    <div class="officer-name">
                                        {{ $officer->name }}
                                    </div>

                                    <div class="officer-email">
                                        {{ $officer->email }}
                                    </div>

                                </div>

                            </div>

                        </td>

                        <td>
                            {{ $officer->department->name ?? 'Not Assigned' }}
                        </td>

                        <td>

                            <span class="badge role-{{ $officer->role }}">
                                {{ ucwords(str_replace('_', ' ', $officer->role)) }}
                            </span>

                        </td>

                        <td>

                            <span class="badge status-{{ $officer->status }}">
                                {{ ucfirst($officer->status) }}
                            </span>

                        </td>

                        <td>
                            {{ $officer->assigned_reports_count ?? 0 }}
                        </td>

                        <td>

                            <div class="actions">

                                <a href="{{ route('admin.officers.show', $officer->id) }}" class="btn-view">
                                    View
                                </a>

                                <a href="{{ route('admin.officers.edit', $officer->id) }}" class="btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('admin.officers.suspend', $officer->id) }}" method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button class="btn-suspend">
                                        Suspend
                                    </button>

                                </form>

                                <form action="{{ route('admin.officers.destroy', $officer->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-delete" onclick="return confirm('Delete officer?')">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@endsection