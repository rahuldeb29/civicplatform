@extends('layouts.admin')

@section('title', 'Departments')

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
            padding: 12px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }

        .search-box {
            margin-bottom: 24px;
        }

        .search-box input {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
        }

        .department-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 24px;
        }

        .department-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #E5E7EB;
            padding: 24px;
            transition: .3s;
        }

        .department-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .department-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .department-name {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .department-desc {
            color: #6B7280;
            font-size: 14px;
        }

        .department-head {
            background: #EFF6FF;
            color: #2563EB;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 20px;
        }

        .stat-box {
            background: #F9FAFB;
            border-radius: 12px;
            padding: 14px;
        }

        .stat-number {
            font-size: 20px;
            font-weight: 700;
        }

        .stat-label {
            color: #6B7280;
            font-size: 13px;
        }

        .officer-list {
            margin-top: 20px;
        }

        .officer-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .officer-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #2563EB;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
        }

        .actions {
            margin-top: 22px;
            display: flex;
            gap: 10px;
        }

        .btn-view,
        .btn-edit,
        .btn-delete {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
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

        .btn-delete {
            background: #FEE2E2;
            color: #DC2626;
        }
    </style>

    <div class="page-header">

        <div>
            <h1>Departments</h1>
            <p>Manage civic departments, officers and assigned reports.</p>
        </div>

        <a href="{{ route('admin.departments.create') }}" class="btn-primary">
            + Add Department
        </a>

    </div>

    <div class="search-box">
        <input type="text" placeholder="Search departments...">
    </div>

    <div class="department-grid">

        @foreach($departments as $department)

            <div class="department-card">

                <div class="department-top">

                    <div>
                        <div class="department-name">
                            {{ $department->name }}
                        </div>

                        <div class="department-desc">
                            {{ $department->description }}
                        </div>
                    </div>

                    <div class="department-head">
                        Head: {{ $department->head_name }}
                    </div>

                </div>

                <div class="stats-grid">

                    <div class="stat-box">
                        <div class="stat-number">
                            {{ $department->reports_count }}
                        </div>
                        <div class="stat-label">
                            Total Reports
                        </div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-number">
                            {{ $department->pending_reports_count ?? 0 }}
                        </div>
                        <div class="stat-label">
                            Pending Reports
                        </div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-number">
                            {{ $department->officers_count }}
                        </div>
                        <div class="stat-label">
                            Officers
                        </div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-number">
                            {{ $department->resolved_reports_count ?? 0 }}
                        </div>
                        <div class="stat-label">
                            Resolved
                        </div>
                    </div>

                </div>

                <div class="officer-list">

                    <div class="officer-title">
                        Officers
                    </div>

                    @foreach($department->officers->take(3) as $officer)

                        <div class="officer-item">

                            <div class="avatar">
                                @if($officer->profile_image)
                                    <img src="{{ asset('storage/' . $officer->profile_image) }}" alt="{{ $officer->name }}"
                                        style="border-radius: 50%; height: 43px; width: 43px;">
                                @else
                                    {{ strtoupper(substr($officer->name, 0, 1)) }}
                                @endif
                            </div>

                            <div>
                                <strong>{{ $officer->name }}</strong><br>
                                <small>{{ $officer->designation }}</small>
                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="actions">

                    <a href="{{ route('admin.departments.show', $department->id) }}" class="btn-view">
                        View
                    </a>

                    <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn-edit">
                        Edit
                    </a>

                    <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" style="flex:1;">
                        @csrf
                        @method('DELETE')

                        <button class="btn-delete" style="width:100%;border:none;">
                            Delete
                        </button>
                    </form>

                </div>

            </div>

        @endforeach

    </div>

@endsection