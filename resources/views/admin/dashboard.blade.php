@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* ═══════════════════════════════════════════════════════════
                               BASE & LAYOUT
                            ═══════════════════════════════════════════════════════════ */
        body {
            margin: 0;
            padding: 0;
            background: #F9FAFB;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #374151;
        }

        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            padding: 0;
        }

        .admin-main,
        main,
        .main-content {
            margin-left: 260px !important;
        }

        @media (max-width: 1024px) {

            .admin-main,
            main,
            .main-content {
                margin-left: 0 !important;
            }
        }

        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #F9FAFB;
            transition: margin-left .3s ease;
        }

        .admin-navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid #E5E7EB;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .admin-content {
            flex: 1;
            padding: 28px 32px;
        }

        @media (max-width: 1024px) {
            .admin-main {
                margin-left: 0;
            }

            .admin-content {
                padding: 20px 16px;
            }
        }

        /* ═══════════════════════════════════════════════════════════
                               PAGE HEADER
                            ═══════════════════════════════════════════════════════════ */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 4px;
            letter-spacing: -.3px;
        }

        .page-header p {
            font-size: 13.5px;
            color: #6B7280;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-text {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 4px;
            background: transparent;
            border: none;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            font-family: inherit;
            transition: color .15s;
        }

        .btn-text:hover {
            color: #111827;
        }

        .btn-text svg {
            width: 16px;
            height: 16px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            background: #2563EB;
            color: #fff;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s;
        }

        .btn-primary:hover {
            background: #1D4ED8;
        }

        .btn-primary svg {
            width: 16px;
            height: 16px;
        }

        /* ═══════════════════════════════════════════════════════════
                               STAT CARDS
                            ═══════════════════════════════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 22px 24px;
        }

        .stat-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 18px;
            height: 18px;
        }

        .si-blue {
            background: #EFF6FF;
            color: #2563EB;
        }

        .si-amber {
            background: #FFFBEB;
            color: #D97706;
        }

        .si-green {
            background: #F0FDF4;
            color: #16A34A;
        }

        .si-teal {
            background: #F0FDFA;
            color: #0D9488;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
            margin-bottom: 18px;
            letter-spacing: -.5px;
        }

        .stat-foot {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            padding-top: 14px;
            border-top: 1px solid #F3F4F6;
        }

        .stat-foot .trend-pct {
            font-weight: 600;
        }

        .stat-foot .period {
            color: #9CA3AF;
        }

        .stat-foot.up .trend-pct {
            color: #16A34A;
        }

        .stat-foot.down .trend-pct {
            color: #DC2626;
        }

        .stat-foot svg {
            width: 12px;
            height: 12px;
        }

        /* ═══════════════════════════════════════════════════════════
                               CHART ROW
                            ═══════════════════════════════════════════════════════════ */
        .chart-row {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        /* Donut */
        .donut-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 8px 0 4px;
        }

        .donut-canvas-box {
            position: relative;
            width: 170px;
            height: 170px;
            flex-shrink: 0;
        }

        .donut-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }

        .donut-center-value {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }

        .donut-center-label {
            font-size: 11px;
            color: #9CA3AF;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: .8px;
            font-weight: 600;
        }

        .donut-legend {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .legend-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .legend-row:last-child {
            border-bottom: none;
        }

        .legend-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-name {
            font-size: 13.5px;
            color: #374151;
        }

        .legend-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .legend-count {
            font-size: 13.5px;
            font-weight: 600;
            color: #111827;
        }

        .legend-pct {
            font-size: 11.5px;
            color: #6B7280;
            background: #F3F4F6;
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 500;
        }

        /* Line chart */
        .line-chart-wrap {
            height: 260px;
        }

        .chart-legend-inline {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: #6B7280;
        }

        .chart-legend-inline .legend-dot {
            background: #2563EB;
        }

        /* ═══════════════════════════════════════════════════════════
                               SECTION CARD (used by table / notifications / map / etc)
                            ═══════════════════════════════════════════════════════════ */
        .section-card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .section-title svg.title-icon {
            width: 18px;
            height: 18px;
            color: #2563EB;
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 14px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid #E5E7EB;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s;
        }

        .btn-outline:hover {
            background: #F9FAFB;
        }

        .btn-outline svg {
            width: 13px;
            height: 13px;
            color: #6B7280;
        }

        /* keep chart cards consistent */
        .chart-card-body {
            padding: 0 24px 22px;
        }

        /* ═══════════════════════════════════════════════════════════
                               TABLE
                            ═══════════════════════════════════════════════════════════ */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead tr {
            background: #F9FAFB;
            border-top: 1px solid #F3F4F6;
            border-bottom: 1px solid #F3F4F6;
        }

        .data-table th {
            padding: 12px 24px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            white-space: nowrap;
        }

        .data-table td {
            padding: 18px 24px;
            font-size: 13.5px;
            color: #374151;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr:hover td {
            background: #FAFAFB;
        }

        .cell-id {
            color: #6B7280;
            font-weight: 500;
        }

        .cell-title {
            font-weight: 600;
            color: #111827;
        }

        .cell-sub {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 3px;
        }

        .cell-date {
            color: #374151;
        }

        .cell-date-sub {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 2px;
        }

        /* Pills */
        .pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .3px;
            background: #B91C1C;
            color: #fff;
        }

        .pill-priority-high {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .pill-priority-medium {
            background: #FEF3C7;
            color: #B45309;
        }

        .pill-priority {
            background: #B91C1C;
            color: #fff;
        }

        .pill-priority-low {
            background: #DCFCE7;
            color: #15803D;
        }

        .pill-status-submitted {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .pill-status-assigned {
            background: #E0E7FF;
            color: #4338CA;
        }

        .pill-status-in_progress {
            background: #FEF3C7;
            color: #B45309;
        }

        .pill-status-pending {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .pill-status-resolved {
            background: #DCFCE7;
            color: #15803D;
        }

        .pill-cat {
            background: #DBEAFE;
            color: #1D4ED8;
            text-transform: none;
            letter-spacing: 0;
        }

        .view-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 13.5px;
            font-weight: 600;
            color: #2563EB;
            text-decoration: none;
        }

        .view-link:hover {
            text-decoration: underline;
        }

        .view-link svg {
            width: 13px;
            height: 13px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
        }

        .pagination-info {
            font-size: 13.5px;
            color: #6B7280;
        }

        .pagination-btns {
            display: flex;
            gap: 4px;
        }

        .page-btn {
            min-width: 34px;
            height: 34px;
            padding: 0 12px;
            border-radius: 7px;
            border: 1px solid transparent;
            background: transparent;
            font-size: 13px;
            font-weight: 500;
            color: #6B7280;
            cursor: pointer;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all .15s;
        }

        .page-btn:hover:not(.active):not(.dots) {
            background: #F3F4F6;
            color: #111827;
        }

        .page-btn.active {
            background: #2563EB;
            color: #fff;
        }

        .page-btn.dots {
            cursor: default;
        }

        .page-btn svg {
            width: 12px;
            height: 12px;
        }

        /* ═══════════════════════════════════════════════════════════
                               MID ROW : NOTIFICATIONS + MAP
                            ═══════════════════════════════════════════════════════════ */
        .mid-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .view-all {
            font-size: 13.5px;
            font-weight: 600;
            color: #2563EB;
            text-decoration: none;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        /* Notifications */
        .notif-list {
            padding: 8px 0;
            max-height: 360px;
            overflow-y: auto;
        }

        .notif-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 14px 24px;
        }

        .notif-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notif-icon svg {
            width: 16px;
            height: 16px;
        }

        .ni-blue {
            background: #EFF6FF;
            color: #2563EB;
        }

        .ni-amber {
            background: #FFFBEB;
            color: #D97706;
        }

        .ni-green {
            background: #F0FDF4;
            color: #16A34A;
        }

        .ni-red {
            background: #FEF2F2;
            color: #DC2626;
        }

        .ni-purple {
            background: #F5F3FF;
            color: #7C3AED;
        }

        .notif-body {
            flex: 1;
            padding-top: 2px;
        }

        .notif-body p {
            font-size: 14px;
            color: #374151;
            line-height: 1.5;
            margin: 0;
        }

        .notif-body p strong {
            color: #111827;
            font-weight: 600;
        }

        .notif-time {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 6px;
        }

        /* Map */
        #reportMap {
            height: 320px;
            border-radius: 0 0 12px 12px;
        }

        /* ═══════════════════════════════════════════════════════════
                               BOTTOM ROW : SUMMARY + CASE TRACKER
                            ═══════════════════════════════════════════════════════════ */
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }

        /* Quick Summary */
        .summary-list {
            padding: 8px 0;
        }

        .summary-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            border-bottom: 1px solid #F3F4F6;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .summary-icon svg {
            width: 16px;
            height: 16px;
            color: #6B7280;
        }

        .summary-label {
            flex: 1;
            font-size: 14px;
            color: #374151;
        }

        .summary-value {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        /* Case Tracker */
        .tracker-body {
            padding: 0 24px 24px;
        }

        .current-active-box {
            padding: 14px 0 18px;
            border-top: 1px solid #F3F4F6;
            border-bottom: 1px solid #F3F4F6;
            margin-bottom: 20px;
        }

        .current-active-label {
            font-size: 11px;
            font-weight: 600;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .current-active-id {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: #2563EB;
            margin-top: 4px;
            text-decoration: none;
        }

        .current-active-id:hover {
            text-decoration: underline;
        }

        /* Timeline */
        .timeline {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .timeline-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            position: relative;
            padding-bottom: 18px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item:not(:last-child) .tl-dot-wrap::after {
            content: '';
            position: absolute;
            top: 22px;
            left: 9px;
            width: 2px;
            height: calc(100% + 0px);
            background: #E5E7EB;
        }

        .timeline-item.done:not(:last-child) .tl-dot-wrap::after {
            background: #16A34A;
        }

        .tl-dot-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .tl-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: #fff;
            z-index: 1;
            position: relative;
        }

        .tl-done {
            background: #16A34A;
        }

        .tl-done svg {
            width: 11px;
            height: 11px;
            color: #fff;
        }

        .tl-active {
            background: #fff;
            border: 2px solid #2563EB;
        }

        .tl-active::after {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2563EB;
        }

        .tl-pending {
            background: #fff;
            border: 2px solid #D1D5DB;
        }

        .tl-content {
            flex: 1;
            padding-top: 0;
        }

        .tl-content h4 {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .tl-content p {
            font-size: 12.5px;
            color: #9CA3AF;
            margin: 2px 0 0;
        }

        .timeline-item.pending .tl-content h4 {
            color: #6B7280;
            font-weight: 500;
        }

        .badge-critical {
            background: #ff0000;
            color: #fff;
            border: 1px solid #FCA5A5;
        }



        /* ─── Stat Cards ────────────────────────────────────────── */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 15px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E5E7EB;
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #9CA3AF;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.blue {
            background: #EFF6FF;
        }

        .stat-icon.orange {
            background: #FFF7ED;
        }

        .stat-icon.teal {
            background: #F0FDFA;
        }

        .stat-icon.green {
            background: #F0FDF4;
        }

        .stat-icon svg {
            width: 18px;
            height: 18px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }

        .stat-footer {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
        }

        .stat-footer.up .trend {
            color: #16A34A;
        }

        .stat-footer.down .trend {
            color: #EF4444;
        }

        .stat-footer .trend {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .stat-footer .period {
            color: #9CA3AF;
        }


        .btn-action {
            padding: 0.5rem 1rem;
            background-color: #4299e1;
            color: white;
            border-radius: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-action:hover {
            background-color: #3182ce;
        }




        /* ═══════════════════════════════════════════════════════════
                               RESPONSIVE
                            ═══════════════════════════════════════════════════════════ */
        @media (max-width: 1200px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .chart-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {

            .mid-row,
            .bottom-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ══ PAGE HEADER ══════════════════════════════════════════ --}}
    <div class="page-header">
        <div>
            <h1> Admin Dashboard</h1>
            <p>
                Welcome back, Super Admin. You have
                <strong>{{ $attentionCount }}</strong>
                reports requiring your attention.
            </p>
        </div>

    </div>

    {{-- ══ STAT CARDS ═══════════════════════════════════════════ --}}
    <div class="stat-cards">
        {{-- Total Reports --}}
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">TOTAL REPORTS</span>
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="4" width="16" height="16" rx="2" stroke="#1D4ED8" stroke-width="2" />
                        <line x1="8" y1="9" x2="16" y2="9" stroke="#1D4ED8" stroke-width="1.5" stroke-linecap="round" />
                        <line x1="8" y1="12" x2="16" y2="12" stroke="#1D4ED8" stroke-width="1.5" stroke-linecap="round" />
                        <line x1="8" y1="15" x2="12" y2="15" stroke="#1D4ED8" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <div class="stat-value">{{ $totalReports }}</div>
            <div class="stat-footer up">
                <span class="trend">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                        <path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                    0%
                </span>
                <span class="period">from last month</span>
            </div>
        </div>

        {{-- Pending Action --}}
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">PENDING ACTION</span>
                <div class="stat-icon orange">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="9" stroke="#D97706" stroke-width="2" />
                        <polyline points="12 7 12 12 15 15" stroke="#D97706" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $pendingReports }}</div>
            <div class="stat-footer up">
                <span class="trend">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                    0%
                </span>
                <span class="period">from last month</span>
            </div>
        </div>

        {{-- In Progress --}}
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">IN PROGRESS</span>
                <div class="stat-icon teal">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="9" stroke="#0D9488" stroke-width="2" />
                        <path d="M16 11a4 4 0 0 1-4 4H8" stroke="#0D9488" stroke-width="1.8" stroke-linecap="round" />
                        <path d="M12 8c.5 0 1 .1 1.5.2" stroke="#0D9488" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $inProgressReports }}</div>
            <div class="stat-footer up">
                <span class="trend">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                        <path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                    0
                </span>
                <span class="period">from last month</span>
            </div>
        </div>

        {{-- Resolved Cases --}}
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">RESOLVED CASES</span>
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="9" stroke="#16A34A" stroke-width="2" />
                        <path d="M8 12l3 3 5-5" stroke="#16A34A" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $resolvedReports }}</div>
            <div class="stat-footer up">
                <span class="trend">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                        <path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                    0%
                </span>
                <span class="period">from last month</span>
            </div>
        </div>
    </div>

    {{-- ══ CHART ROW : DONUT + LINE ═════════════════════════════ --}}
    <div class="chart-row">

        {{-- Reports by Department --}}
        <div class="section-card" style="margin-bottom:0;">
            <div class="section-head">
                <div class="section-title">
                    <svg class="title-icon" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                        <path d="M12 3a9 9 0 0 1 6.36 15.36" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                    Reports by Department
                </div>
            </div>
            <div class="chart-card-body">
                <div class="donut-wrap">
                    <div class="donut-canvas-box">
                        <canvas id="deptDonutChart"></canvas>
                        <div class="donut-center">
                            <div class="donut-center-value">{{$totalReports}}</div>
                            <div class="donut-center-label">Total</div>
                        </div>
                    </div>
                    <div class="donut-legend">
                        @php
                            $colors = [
                                'PWD' => '#2563EB',
                                'Water Supply' => '#06B6D4',
                                'Electricity' => '#F59E0B',
                                'Sanitation' => '#FF826F',
                                'Others' => '#9CA3AF'
                            ];
                        @endphp

                        @foreach($departmentCounts as $department => $count)
                            <div class="legend-row">
                                <div class="legend-left">
                                    <span class="legend-dot" style="background:{{ $colors[$department] }}"></span>

                                    <span class="legend-name">{{ $department }}</span>
                                </div>

                                <div class="legend-right">
                                    <span class="legend-count">{{ $count }}</span>

                                    <span class="legend-pct">
                                        {{ $totalReports > 0 ? round(($count / $totalReports) * 100) : 0 }}%
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Reports Over Time --}}
        <div class="section-card" style="margin-bottom:0;">
            <div class="section-head">
                <div class="section-title">
                    <svg class="title-icon" viewBox="0 0 24 24" fill="none">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Reports Over Time
                </div>
                <div class="chart-legend-inline">
                    <span class="legend-dot"></span>
                    Monthly Reports
                </div>
            </div>
            <div class="chart-card-body">
                <div class="line-chart-wrap">
                    <canvas id="reportsLineChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- ══ REPORT HISTORY ══════════════════════════════════════ --}}
    <div class="section-card">
        <div class="section-head">
            <div class="section-title">
                <svg class="title-icon" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Report History
            </div>

            <span class="text-muted">
                Sorted by:
                {{ ucfirst(request('sort', 'latest')) }}
            </span>



            <div class="dropdown">
                <button class="btn-outline dropdown-toggle" data-bs-toggle="dropdown">
                    Sort
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}">
                            Latest First
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">
                            Oldest First
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'priority']) }}">
                            Priority
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'status']) }}">
                            Status
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Department</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Submitted By</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="cell-id">#CP-{{ $report->id }}</td>

                            <td>
                                <div class="cell-title">{{ $report->title }}</div>
                                <div class="cell-sub">{{ $report->address }}</div>
                            </td>

                            <td>
                                <span class="pill pill-cat">
                                    {{ $report->category }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $departmentMap = [
                                        'Road Damage' => 'PWD',
                                        'Pothole' => 'PWD',
                                        'Drainage' => 'PWD',
                                        'Water Leakage' => 'Water Supply',
                                        'Street Light' => 'Electricity',
                                        'Garbage' => 'Sanitation',
                                    ];
                                @endphp

                                {{ $departmentMap[$report->category] ?? 'General' }}
                            </td>

                            <td>
                                <span class="pill pill-priority-{{ strtolower($report->priority) }}">
                                    {{ $report->priority }}
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" onchange="this.form.submit()" class="status-select">

                                        <option value="submitted" {{ $report->status == 'submitted' ? 'selected' : '' }}>
                                            Submitted
                                        </option>

                                        <option value="assigned" {{ $report->status == 'assigned' ? 'selected' : '' }}>
                                            Assigned
                                        </option>

                                        <option value="in_progress" {{ $report->status == 'in_progress' ? 'selected' : '' }}>
                                            In Progress
                                        </option>

                                        <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>
                                            Resolved
                                        </option>

                                        <option value="closed" {{ $report->status == 'closed' ? 'selected' : '' }}>
                                            Closed
                                        </option>

                                    </select>
                                </form>
                            </td>

                            <td>
                                {{ $report->user->name ?? 'Unknown' }}
                            </td>

                            <td>
                                {{ $report->created_at->format('M d, Y') }}
                            </td>

                            <td>
                                <a href="{{ route('admin.reports.show', $report->id) }}" class="btn-action">
                                    <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                No reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <div class="pagination-info">
                Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }}
                of {{ $reports->total() }} records
            </div>

            <div>
                {{ $reports->links() }}
            </div>
        </div>
    </div>

    {{-- ══ MID ROW : NOTIFICATIONS + MAP ════════════════════════ --}}
    <div class="mid-row">

        <div class="section-card" style="margin-bottom:0;">
            <div class="section-head">
                <div class="section-title">Recent Notifications</div>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="notif-list">
                <div class="notif-item">
                    <div class="notif-icon ni-blue">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                            <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                            <path d="M19 8v6M22 11h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="notif-body">
                        <p>Your report <strong>#CR-9012</strong> has been assigned to Public Works Department.</p>
                        <div class="notif-time">10 minutes ago</div>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon ni-amber">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                            <polyline points="12 7 12 12 15 15" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="notif-body">
                        <p>Status updated for <strong>#CR-8702</strong> - Water Leakage.</p>
                        <div class="notif-time">2 hours ago</div>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon ni-green">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="notif-body">
                        <p>Report <strong>#CR-8650</strong> - Pothole Repair has been resolved successfully.</p>
                        <div class="notif-time">5 hours ago</div>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon ni-purple">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M14 2v6h6M12 18v-6M9 15h6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="notif-body">
                        <p>New report <strong>#CR-9013</strong> submitted for Street Light issue.</p>
                        <div class="notif-time">8 hours ago</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-card" style="margin-bottom:0;">
            <div class="section-head">
                <div class="section-title">Reports on Map</div>
                <a href="#" class="view-all">View All</a>
            </div>
            <div id="reportMap"></div>
        </div>

    </div>

    {{-- ══ BOTTOM ROW : SUMMARY + CASE TRACKER ═════════════════ --}}
    <div class="bottom-row">

        <div class="section-card" style="margin-bottom:0;">
            <div class="section-head">
                <div class="section-title">Quick Summary</div>
            </div>
            <div class="summary-list">
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                            <path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                            <circle cx="18" cy="7" r="3" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <span class="summary-label">Total Citizens</span>
                    <span class="summary-value">{{ $totalUsers }}</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M4 21V8l8-5 8 5v13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <line x1="9" y1="21" x2="9" y2="12" stroke="currentColor" stroke-width="2" />
                            <line x1="15" y1="21" x2="15" y2="12" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <span class="summary-label">Active Departments</span>
                    <span class="summary-value">5</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" />
                            <path d="M4 21c0-4 4-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                            <path d="M17 9l2 2 3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="summary-label">Total Officers</span>
                    <span class="summary-value">28</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
                            <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
                            <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
                            <rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <span class="summary-label">Total Categories</span>
                    <span class="summary-value">{{ $totalCategories }}</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                            <path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                            <circle cx="18" cy="9" r="3" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <span class="summary-label">Total Users</span>
                    <span class="summary-value">{{ $totalUsers }}</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="summary-label">Avg. Impact Rank</span>
                    <span class="summary-value">4.2</span>
                </div>
            </div>
        </div>

        @php
            $timelineSteps = [
                'submitted' => [
                    'title' => 'Submitted',
                    'description' => $activeReport?->created_at?->format('M d, Y • h:i A')
                ],
                'assigned' => [
                    'title' => 'Assigned',
                    'description' => 'Assigned to Department'
                ],
                'in_progress' => [
                    'title' => 'In Progress',
                    'description' => 'Work in progress'
                ],
                'assessment_complete' => [
                    'title' => 'Assessment Complete',
                    'description' => 'Assessment completed'
                ],
                'resolved' => [
                    'title' => 'Resolved',
                    'description' => 'Issue resolved'
                ],
                'closed' => [
                    'title' => 'Closed',
                    'description' => 'Case closed'
                ],
            ];

            $currentStep = array_search(
                strtolower($activeReport?->status ?? 'submitted'),
                array_keys($timelineSteps)
            );

            if ($currentStep === false) {
                $currentStep = 0;
            }
        @endphp

        <div class="timeline">

            @foreach($timelineSteps as $key => $step)

                @php
                    $index = array_search($key, array_keys($timelineSteps));

                    if ($index < $currentStep) {
                        $class = 'done';
                    } elseif ($index == $currentStep) {
                        $class = 'active';
                    } else {
                        $class = 'pending';
                    }
                @endphp

                <div class="timeline-item {{ $class }}">

                    <div class="tl-dot-wrap">

                        @if($class === 'done')
                            <div class="tl-dot tl-done">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                        @elseif($class === 'active')
                            <div class="tl-dot tl-active"></div>

                        @else
                            <div class="tl-dot tl-pending"></div>
                        @endif

                    </div>

                    <div class="tl-content">
                        <h4>{{ $step['title'] }}</h4>

                        <p>
                            @if($class === 'pending')
                                Pending
                            @else
                                {{ $step['description'] }}
                            @endif
                        </p>
                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        /* ── Donut Chart ───────────────────────────────────────── */
        const deptCtx = document.getElementById('deptDonutChart').getContext('2d');
        new Chart(deptCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($departmentCounts)),
                datasets: [{
                    data: @json(array_values($departmentCounts)),
                    backgroundColor: [
                        '#2563EB',
                        '#06B6D4',
                        '#F59E0B',
                        '#FF826F',
                        '#9CA3AF'
                    ]
                }]
            },
            options: {
                cutout: '74%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw} reports`
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        /* ── Line Chart ────────────────────────────────────────── */
        const lineCtx = document.getElementById('reportsLineChart').getContext('2d');
        const grad = lineCtx.createLinearGradient(0, 0, 0, 260);
        grad.addColorStop(0, 'rgba(37, 99, 235, 0.18)');
        grad.addColorStop(1, 'rgba(37, 99, 235, 0)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Reports',
                    data: @json($chartData),
                    borderColor: '#2563EB',
                    backgroundColor: grad,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 50,
                        ticks: {
                            stepSize: 100,
                            color: '#9CA3AF',
                            font: { size: 13.5, family: "'Inter', sans-serif" }
                        },
                        grid: { color: '#F3F4F6', drawBorder: false },
                        border: { display: false }
                    },
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 13.5, family: "'Inter', sans-serif" } },
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });

        /* ── Leaflet Map ───────────────────────────────────────── */
        const map = L.map('reportMap').setView([23.856946113678067, 91.29741994402143], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 18
        }).addTo(map);

        const reports = @json($mapReports);

        reports.forEach(report => {

            let color = '#2563EB';

            if (report.status === 'resolved')
                color = '#16A34A';

            if (report.status === 'pending' || report.status === 'submitted')
                color = '#DC2626';

            if (report.status === 'assigned')
                color = '#7C3AED';

            if (report.status === 'in_progress')
                color = '#F59E0B';

            const icon = L.divIcon({
                html: `
                    <div style="
                        width:16px;
                        height:16px;
                        background:${color};
                        border:3px solid white;
                        border-radius:50%;
                        box-shadow:0 2px 6px rgba(0,0,0,.3);
                    "></div>
                `,
                className: '',
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            });

            L.marker(
                [report.latitude, report.longitude],
                { icon }
            )
                .addTo(map)
                .bindPopup(`
                <div style="font-family:Inter,sans-serif">
                    <strong>#CP-${report.id}</strong><br>
                    ${report.title}<br>
                    <span style="color:${color};font-weight:600">
                        ${report.status.replace('_', ' ')}
                    </span>
                </div>
            `);
        });


    </script>
@endpush