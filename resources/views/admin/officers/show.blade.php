@extends('layouts.admin')

@section('title', 'Officer Profile')

@section('content')

    <style>
        .profile-container {
            max-width: 1200px;
            margin: auto;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .profile-header h1 {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
        }

        .profile-header p {
            color: #6B7280;
        }

        .btn-edit {
            background: #2563EB;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 25px;
        }

        .card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 18px;
            padding: 25px;
        }

        .profile-card {
            text-align: center;
            height: 450px;
        }

        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #E5E7EB;
            margin-bottom: 18px;
        }

        .avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: #2563EB;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            font-weight: bold;
            margin: auto;
            margin-bottom: 18px;
        }

        .name {
            font-size: 24px;
            font-weight: 700;
        }

        .email {
            color: #6B7280;
            margin-top: 5px;
        }

        .badge {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .active {
            background: #DCFCE7;
            color: #166534;
        }

        .suspended {
            background: #FEE2E2;
            color: #991B1B;
        }

        .role {
            background: #DBEAFE;
            color: #1D4ED8;
            margin-left: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-box {
            background: #F9FAFB;
            padding: 18px;
            border-radius: 12px;
        }

        .label {
            font-size: 13px;
            color: #6B7280;
            margin-bottom: 8px;
        }

        .value {
            font-size: 18px;
            font-weight: 600;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 25px;
        }

        .stat {
            background: #F9FAFB;
            padding: 20px;
            border-radius: 14px;
            text-align: center;
        }

        .stat h2 {
            font-size: 32px;
            color: #111827;
        }

        .stat p {
            color: #6B7280;
            margin-top: 8px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            background: #F9FAFB;
            padding: 15px;
        }

        td {
            padding: 15px;
            border-top: 1px solid #F3F4F6;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        .btn-danger {
            background: #FEE2E2;
            color: #DC2626;
        }
    </style>

    <div class="profile-container">

        <div class="profile-header">

            <div>
                <h1>Officer Profile</h1>
                <p>View officer details and assigned responsibilities.</p>
            </div>

            <a href="{{ route('admin.officers.edit', $officer->id) }}" class="btn-edit">
                Edit Officer
            </a>

        </div>

        <div class="profile-grid">

            <div class="card profile-card">

                @if($officer->profile_image)

                    <img src="{{ asset('storage/' . $officer->profile_image) }}" class="profile-img" style="margin-left: 55px">

                @else

                    <div class="avatar-placeholder">
                        {{ strtoupper(substr($officer->name, 0, 1)) }}
                    </div>

                @endif

                <div class="name">
                    {{ $officer->name }}
                </div>

                <div class="email">
                    {{ $officer->email }}
                </div>

                <span class="badge {{ $officer->status }}">
                    {{ ucfirst($officer->status) }}
                </span>

                <span class="badge role">
                    {{ ucwords(str_replace('_', ' ', $officer->role)) }}
                </span>

                <div class="action-buttons">

                    <form action="{{ route('admin.officers.suspend', $officer->id) }}" method="POST" style="flex:1">

                        @csrf
                        @method('PATCH')

                        <button class="btn btn-warning" style="width:100%;border:none;">
                            Suspend
                        </button>

                    </form>

                    <form action="{{ route('admin.officers.destroy', $officer->id) }}" method="POST" style="flex:1">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger" style="width:100%;border:none;"
                            onclick="return confirm('Delete officer?')">
                            Delete
                        </button>

                    </form>

                </div>

            </div>

            <div>

                <div class="card">

                    <div class="section-title">
                        Officer Information
                    </div>

                    <div class="info-grid">

                        <div class="info-box">
                            <div class="label">Department</div>
                            <div class="value">
                                {{ $officer->department->name ?? 'Not Assigned' }}
                            </div>
                        </div>

                        <div class="info-box">
                            <div class="label">Designation</div>
                            <div class="value">
                                {{ $officer->designation }}
                            </div>
                        </div>

                        <div class="info-box">
                            <div class="label">Phone</div>
                            <div class="value">
                                {{ $officer->phone }}
                            </div>
                        </div>

                        <div class="info-box">
                            <div class="label">Joined</div>
                            <div class="value">
                                {{ $officer->created_at->format('d M Y') }}
                            </div>
                        </div>

                    </div>

                    <div class="stats">

                        <div class="stat">
                            <h2>{{ $assignedReports }}</h2>
                            <p>Assigned Reports</p>
                        </div>

                        <div class="stat">
                            <h2>{{ $pendingReports }}</h2>
                            <p>Pending</p>
                        </div>

                        <div class="stat">
                            <h2>{{ $resolvedReports }}</h2>
                            <p>Resolved</p>
                        </div>

                        <div class="stat">
                            <h2>{{ $completionRate }}%</h2>
                            <p>Completion Rate</p>
                        </div>

                    </div>

                </div>

                <div class="card" style="margin-top:25px;">

                    <div class="section-title">
                        Recent Assigned Reports
                    </div>

                    <table>

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th></th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($reports as $report)

                                <tr>

                                    <td>#CP-{{ $report->id }}</td>

                                    <td>{{ $report->title }}</td>

                                    <td>{{ ucfirst($report->status) }}</td>

                                    <td>{{ $report->priority }}</td>

                                    <td>

                                        <a href="{{ route('admin.reports.show', $report->id) }}">
                                            View
                                        </a>

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

            </div>

        </div>

    </div>

@endsection