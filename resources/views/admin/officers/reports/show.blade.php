@extends('layouts.admin')

@section('title', 'Report Details')

@section('content')

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-title h1 {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .page-title p {
            color: #6B7280;
            font-size: 15px;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #2563EB;
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: .25s;
        }

        .back-btn:hover {
            background: #1D4ED8;
        }

        .grid {
            display: grid;
            grid-template-columns: 2fr 400px;
            gap: 28px;
            align-items: start;
        }

        .grid>div:last-child {
            position: sticky;
            top: 90px;
        }

        .card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .05);
        }

        .card h2 {
            font-size: 20px;
            margin-bottom: 22px;
            color: #111827;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 18px 20px;
        }

        .info-label {
            color: #6B7280;
            font-weight: 600;
        }

        .info-value {
            color: #111827;
            font-weight: 500;
        }

        .description-box {
            margin-top: 20px;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 18px;
            line-height: 1.8;
            color: #374151;
        }

        .gallery img {
            width: 100%;
            max-height: 520px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid #E5E7EB;
            transition: .3s;
        }

        .gallery img:hover {
            transform: scale(1.02);
        }

        .status-summary {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #F3F4F6;
            padding-bottom: 12px;
        }

        .summary-label {
            color: #6B7280;
            font-size: 14px;
        }

        .summary-value {
            font-weight: 600;
            color: #111827;
        }

        select {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #D1D5DB;
            font-size: 15px;
            margin-top: 10px;
        }

        button {
            width: 100%;
            margin-top: 18px;
            padding: 14px;
            background: #2563EB;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
        }

        button:hover {
            background: #1D4ED8;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 13px;
        }

        .pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .submitted {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .assigned {
            background: #EDE9FE;
            color: #6D28D9;
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
    </style>

    <div class="page-header">

        <div class="page-title">

            <h1>#CP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</h1>

            <p>{{ $report->title }}</p>

        </div>

        <a href="{{ route('officers.reports.index') }}" class="back-btn">

            ← Back to Reports

        </a>

    </div>

    <div class="grid">

        <div>

            <div class="card">

                <h2>Report Information</h2>

                <div class="info-grid">

                    <div class="info-label">Citizen</div>
                    <div class="info-value">{{ optional($report->user)->name }}</div>

                    <div class="info-label">Category</div>
                    <div class="info-value">{{ $report->category }}</div>

                    <div class="info-label">Priority</div>
                    <div class="info-value">
                        <span class="badge {{ strtolower($report->priority) }}">
                            {{ ucfirst($report->priority) }}
                        </span>
                    </div>

                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="badge {{ strtolower($report->status) }}">
                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                        </span>
                    </div>

                    <div class="info-label">Location</div>
                    <div class="info-value">{{ $report->location }}</div>

                    <div class="info-label">Submitted</div>
                    <div class="info-value">
                        {{ $report->created_at->format('d M Y, h:i A') }}
                    </div>

                </div>

                <div class="description-box">

                    {{ $report->description }}

                </div>

            </div>

            @if($report->image)

                <div class="card">

                    <h2>Evidence Image</h2>

                    <div class="gallery">

                        <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image">

                    </div>

                </div>

            @endif



        </div>

        <div>

            <div class="card">

                <h2>Report Summary</h2>

                <div class="status-summary">

                    <div class="summary-row">
                        <span class="summary-label">Report ID</span>
                        <span class="summary-value">#CP-{{ $report->id }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Category</span>
                        <span class="summary-value">{{ $report->category }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Priority</span>
                        <span class="summary-value">
                            {{ ucfirst($report->priority) }}
                        </span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Current Status</span>
                        <span class="summary-value">
                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                        </span>
                    </div>

                </div>

            </div>

            <div class="card">

                <h2>Update Status</h2>

                <form method="POST" action="{{ route('officers.reports.updateStatus', $report) }}">

                    @csrf
                    @method('PATCH')

                    <label style="font-size:14px;font-weight:600;color:#6B7280;">
                        Select New Status
                    </label>

                    <select name="status">

                        @foreach(['pending', 'submitted', 'assigned', 'in_progress', 'resolved'] as $status)

                            <option value="{{ $status }}" {{ $report->status == $status ? 'selected' : '' }}>

                                {{ ucfirst(str_replace('_', ' ', $status)) }}

                            </option>

                        @endforeach

                    </select>

                    <button type="submit">

                        Update Report Status

                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection