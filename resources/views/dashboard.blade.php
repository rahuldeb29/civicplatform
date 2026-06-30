{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Citizen Dashboard')

@push('styles')
    <style>
        /* ─── Dashboard Layout ──────────────────────────────────── */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 24px;
            align-items: start;
        }

        .dashboard-left {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ─── Page Header ───────────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .page-header-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .page-header-text p {
            font-size: 13.5px;
            color: #6B7280;
            margin-top: 3px;
        }

        .page-header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: background .15s, box-shadow .15s;
            text-decoration: none;
        }

        .btn-outline {
            background: #fff;
            border: 1px solid #D1D5DB;
            color: #374151;
        }

        .btn-outline:hover {
            background: #F9FAFB;
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
            background: #1E40AF;
        }

        .btn svg {
            width: 15px;
            height: 15px;
        }

        /* ─── Stat Cards ────────────────────────────────────────── */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
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

        /* ─── Report History Table ──────────────────────────────── */
        .card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px 16px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .card-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            background: #fff;
            border: 1px solid #E5E7EB;
            color: #374151;
            cursor: pointer;
            transition: background .15s;
        }

        .action-btn:hover {
            background: #F9FAFB;
        }

        .action-btn svg {
            width: 14px;
            height: 14px;
            color: #6B7280;
        }

        /* Table */
        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th {
            padding: 10px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #9CA3AF;
            letter-spacing: .04em;
            text-transform: uppercase;
            background: #F9FAFB;
            border-bottom: 1px solid #E5E7EB;
        }

        .report-table td {
            padding: 14px 16px;
            font-size: 13.5px;
            color: #374151;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }

        .report-table tr:last-child td {
            border-bottom: none;
        }

        .report-table tr:hover td {
            background: #FAFAFA;
        }

        .report-id {
            color: #6B7280;
            font-size: 12.5px;
        }

        .report-title-text {
            font-weight: 600;
            color: #111827;
            font-size: 13.5px;
        }

        .report-address {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 2px;
        }

        /* Badges */
        .badge-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-medium {
            background: #FEF3C7;
            color: #D97706;
        }

        .badge-high {
            background: #FEE2E2;
            color: #DC2626;
        }

        .badge-low {
            background: #DCFCE7;
            color: #16A34A;
        }

        .badge-critical {
            background: #ff0000;
            color: #fff;
            border: 1px solid #FCA5A5;
        }

        .status-pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: .02em;
        }

        .status-progress {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .status-assigned {
            background: #FEF3C7;
            color: #B45309;
        }

        .status-resolved {
            background: #DCFCE7;
            color: #15803D;
        }

        .view-link {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #1D4ED8;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
        }

        .view-link svg {
            width: 14px;
            height: 14px;
        }

        .view-link:hover {
            text-decoration: underline;
        }

        /* Pagination */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid #E5E7EB;
        }

        .table-showing {
            font-size: 13px;
            color: #6B7280;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-btn {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #E5E7EB;
            background: #fff;
            color: #374151;
            cursor: pointer;
            transition: background .15s;
            text-decoration: none;
        }

        .page-btn:hover {
            background: #F3F4F6;
        }

        .page-btn.active {
            background: #1D4ED8;
            color: #fff;
            border-color: #1D4ED8;
        }

        .page-btn.nav-pg {
            gap: 4px;
        }

        /* ─── Bottom Row ────────────────────────────────────────── */
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Notifications */
        .notif-list {
            padding: 0 20px 16px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .notif-ico {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notif-ico.blue {
            background: #DBEAFE;
        }

        .notif-ico.orange {
            background: #FFF7ED;
        }

        .notif-ico svg {
            width: 16px;
            height: 16px;
        }

        .notif-text {
            flex: 1;
        }

        .notif-msg {
            font-size: 13px;
            color: #374151;
            line-height: 1.4;
        }

        .notif-time {
            font-size: 11.5px;
            color: #9CA3AF;
            margin-top: 3px;
        }

        .card-header-link {
            font-size: 13px;
            color: #1D4ED8;
            font-weight: 500;
            text-decoration: none;
        }

        .card-header-link:hover {
            text-decoration: underline;
        }

        /* Map */
        .map-container {
            margin: 0 20px 20px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #E5E7EB;
        }

        .map-placeholder {
            height: 180px;
            background: #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Fake map grid */
        .map-placeholder::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(#D1D5DB 1px, transparent 1px),
                linear-gradient(90deg, #D1D5DB 1px, transparent 1px);
            background-size: 40px 40px;
            background-color: #EDE9FE;
        }

        .map-road-h,
        .map-road-v {
            position: absolute;
            background: #fff;
            opacity: .7;
        }

        .map-road-h {
            height: 6px;
            width: 100%;
            top: 45%;
        }

        .map-road-v {
            width: 6px;
            height: 100%;
            left: 30%;
        }

        .map-road-v2 {
            left: 65%;
        }

        .map-pin {
            position: absolute;
            font-size: 22px;
            transform: translate(-50%, -100%);
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .2));
            cursor: pointer;
        }

        /* ─── Right Panel ───────────────────────────────────────── */
        .right-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Profile Card */
        .profile-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 12px;
        }

        .profile-name {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .profile-email {
            font-size: 12.5px;
            color: #6B7280;
            margin-top: 2px;
        }

        .rank-block {
            margin-top: 16px;
            width: 100%;
            padding-top: 16px;
            border-top: 1px solid #F3F4F6;
        }

        .rank-label {
            font-size: 10px;
            font-weight: 600;
            color: #9CA3AF;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .rank-value {
            font-size: 28px;
            font-weight: 800;
            color: #1D4ED8;
            margin-top: 4px;
        }

        /* Case Tracker */
        .case-tracker {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            padding: 20px;
        }

        .case-tracker-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .case-tracker-header svg {
            width: 18px;
            height: 18px;
            color: #6B7280;
        }

        .case-tracker-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .active-case {
            background: #F8FAFF;
            border: 1px solid #DBEAFE;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 16px;
        }

        .active-label {
            font-size: 10px;
            font-weight: 600;
            color: #9CA3AF;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .active-id {
            font-size: 13px;
            font-weight: 600;
            color: #1D4ED8;
            margin-top: 4px;
        }

        /* Timeline */
        .timeline {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .timeline-step {
            display: flex;
            gap: 12px;
            position: relative;
            padding-bottom: 18px;
        }

        .timeline-step:last-child {
            padding-bottom: 0;
        }

        .step-dot-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
            width: 20px;
        }

        .step-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            z-index: 1;
        }




        .chart-row {
        display: grid; grid-template-columns: 420px 1fr; gap: 20px;
        margin-bottom: 24px;
    }
    .card {
        background: #fff; border: 1px solid #E5E7EB; border-radius: 14px;
        padding: 22px;
    }
    .card-title-row {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 18px;
    }
    .card-title {
        font-size: 16px; font-weight: 700; color: #111827;
        display: flex; align-items: center; gap: 8px;
    }
    .card-title svg { width: 18px; height: 18px; color: #2563EB; }

    .view-all-mini {
        font-size: 13px; font-weight: 600; color: #2563EB;
        text-decoration: none;
    }
    .view-all-mini:hover { text-decoration: underline; }

    /* Donut */
    .donut-wrap { display: flex; align-items: center; gap: 24px; }
    .donut-canvas-box { position: relative; width: 170px; height: 170px; flex-shrink: 0; }
    .donut-center {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        text-align: center; pointer-events: none;
    }
    .donut-center-value { font-size: 21px; font-weight: 800; color: #111827; line-height: 1; }
    .donut-center-label { font-size: 11px; color: #9CA3AF; margin-top: 2px; }
    .donut-legend { display: flex; flex-direction: column; gap: 13px; flex: 1; }
    .legend-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .legend-left { display: flex; align-items: center; gap: 9px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .legend-name { font-size: 13px; color: #374151; }
    .legend-value { font-size: 13px; color: #6B7280; white-space: nowrap; }

    .line-legend { display: flex; align-items: center; gap: 7px; font-size: 12.5px; color: #6B7280; }
    .line-legend .legend-dot { background: #2563EB; }
    .line-chart-box { height: 230px; }

    /* ─── Report History ─────────────────────────────────────── */
    .reports-card { padding: 22px 0 6px; margin-bottom: 24px; }
    .reports-card .card-title-row { padding: 0 22px; }

    .table-toolbar { display: flex; gap: 10px; }
    .toolbar-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border-radius: 8px;
        background: #fff; border: 1px solid #E5E7EB;
        font-size: 13px; font-weight: 500; color: #374151;
        cursor: pointer; font-family: inherit;
    }
    .toolbar-btn:hover { background: #F9FAFB; }
    .toolbar-btn svg { width: 13px; height: 13px; color: #6B7280; }

    .recent-table { width: 100%; border-collapse: collapse; }
    .recent-table th {
        padding: 14px 22px; text-align: left;
        font-size: 12px; font-weight: 600; color: #6B7280;
        background: #F9FAFB; text-transform: uppercase; letter-spacing: 0.5px;
        border-top: 1px solid #F3F4F6;
        border-bottom: 1px solid #F3F4F6;
        white-space: nowrap;
    }
    .recent-table td {
        padding: 14px 22px; font-size: 13.5px; color: #374151;
        border-bottom: 1px solid #F8F9FB; vertical-align: middle;
    }
    .recent-table tr:last-child td { border-bottom: none; }
    .recent-table tr:hover td { background: #FAFAFB; }

    .id-cell { color: #6B7280; font-weight: 500; }
    .title-cell { font-weight: 600; color: #111827; }

    .pill {
        display: inline-block; padding: 3px 11px; border-radius: 14px;
        font-size: 11.5px; font-weight: 600;
    }
    .pill-water-leakage { background: #DBEAFE; color: #1D4ED8; }
    .pill-street-light  { background: #FEF3C7; color: #B45309; }
    .pill-garbage       { background: #F3E8FF; color: #7E22CE; }
    .pill-road-damage   { background: #DCFCE7; color: #15803D; }
    .pill-drainage      { background: #FEE2E2; color: #B91C1C; }

    .priority-pill { background: #FEE2E2; color: #B91C1C; }
    .priority-pill.medium { background: #FEF3C7; color: #B45309; }
    .priority-pill.low    { background: #DCFCE7; color: #15803D; }

    .status-text { font-weight: 600; font-size: 13px; }
    .status-assigned    { color: #1D4ED8; }
    .status-in_progress { color: #B45309; }
    .status-pending     { color: #DC2626; }
    .status-resolved    { color: #16A34A; }

    .view-btn {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        background: #F3F4F6; border: none; cursor: pointer;
        transition: background .15s;
    }
    .view-btn:hover { background: #E5E7EB; }
    .view-btn svg { width: 15px; height: 15px; color: #374151; }

    /* Pagination */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 22px 8px;
    }
    .pagination-info { font-size: 14px; color: #6B7280; }
    .pagination-btns { display: flex; gap: 6px; }
    .page-btn {
        min-width: 34px; height: 34px;
        padding: 0 12px; border-radius: 7px;
        border: 1px solid transparent; background: transparent;
        font-size: 13px; font-weight: 500; color: #6B7280;
        cursor: pointer; font-family: inherit;
        display: inline-flex; align-items: center; justify-content: center; gap: 4px;
        transition: all .15s;
    }
    .page-btn:hover:not(.active) { background: #F3F4F6; color: #111827; }
    .page-btn.active {
        background: #2563EB; color: #fff;
    }
    .page-btn svg { width: 12px; height: 12px; }

    /* ─── Mid Row: Notifications + Map ───────────────────────── */
    .mid-row {
        display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        margin-bottom: 24px;
    }

    /* Notifications */
    .notif-list { display: flex; flex-direction: column; max-height: 360px; overflow-y: auto; }
    .notif-item {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 14px 0;
    }
    .notif-icon {
        width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .notif-icon svg { width: 18px; height: 18px; }
    .ni-blue   { background: #EFF6FF; color: #3B82F6; }
    .ni-amber  { background: #FFF7ED; color: #F59E0B; }
    .ni-green  { background: #F0FDF4; color: #16A34A; }
    .ni-red    { background: #FEF2F2; color: #DC2626; }
    .ni-purple { background: #F3E8FF; color: #7E22CE; }

    .notif-body { flex: 1; padding-top: 2px; }
    .notif-body p { font-size: 14px; color: #374151; line-height: 1.45; }
    .notif-time { font-size: 12px; color: #9CA3AF; margin-top: 4px; }

    /* Map */
    #reportMap {
        height: 320px; border-radius: 10px; border: 1px solid #E5E7EB;
    }

    /* ─── Bottom Row: Quick Summary + Case Tracker ───────────── */
    .bottom-row {
        display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        align-items: start;
    }

    /* Quick Summary */
    .summary-list { display: flex; flex-direction: column; gap: 4px; }
    .summary-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 0;
        border-bottom: 1px solid #F8F9FB;
    }
    .summary-item:last-child { border-bottom: none; }
    .summary-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: #F3F4F6;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .summary-icon svg { width: 16px; height: 16px; color: #374151; }
    .summary-label { flex: 1; font-size: 13.5px; color: #374151; }
    .summary-value { font-size: 14px; font-weight: 700; color: #111827; }

    /* ─── Case Tracker (Reference Style) ─────────────────────── */
    .case-active-box {
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 20px;
    }
    .case-active-label {
        font-size: 11px; font-weight: 600; color: #9CA3AF;
        text-transform: uppercase; letter-spacing: 0.8px;
    }
    .case-active-id {
        display: block; font-size: 15px; font-weight: 700;
        color: #111827; margin-top: 4px; text-decoration: none;
    }

    .timeline { display: flex; flex-direction: column; gap: 18px; }
    .timeline-item {
        display: flex; gap: 14px; align-items: flex-start;
    }
    .timeline-dot {
        width: 24px; height: 24px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .timeline-dot svg { width: 12px; height: 12px; }
    .dot-done {
        background: #DCFCE7; color: #16A34A;
    }
    .dot-active {
        background: #DBEAFE; color: #2563EB;
        position: relative;
    }
    .dot-active::after {
        content: ''; position: absolute; inset: 0; border-radius: 50%;
        border: 2px solid #2563EB;
    }
    .dot-active svg { color: #2563EB; }
    .dot-pending {
        background: #F3F4F6; color: #9CA3AF;
        border: 2px dashed #D1D5DB;
    }
    .timeline-content { flex: 1; padding-top: 2px; }
    .timeline-content h4 {
        font-size: 14px; font-weight: 600; color: #111827;
    }
    .timeline-content p {
        font-size: 12px; color: #9CA3AF; margin-top: 2px;
    }
    .timeline-item.pending .timeline-content h4 { color: #6B7280; }

    /* ─── Responsive ─────────────────────────────────────────── */
    @media (max-width: 1200px) {
        .stat-cards { grid-template-columns: repeat(2, 1fr); }
        .chart-row, .mid-row, .bottom-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stat-cards { grid-template-columns: 1fr; }
    }

        .step-dot.done {
            background: #16A34A;
        }

        .step-dot.done svg {
            color: #fff;
            width: 11px;
            height: 11px;
        }

        .step-dot.active {
            background: #1D4ED8;
        }

        .step-dot.active-inner {
            width: 10px;
            height: 10px;
            background: #fff;
            border-radius: 50%;
        }

        .step-dot.pending {
            background: #E5E7EB;
        }

        .step-dot.pending-inner {
            width: 10px;
            height: 10px;
            background: #9CA3AF;
            border-radius: 50%;
        }

        .step-line {
            flex: 1;
            width: 2px;
            margin-top: 2px;
            background: #E5E7EB;
            min-height: 14px;
        }

        .step-line.done-line {
            background: #16A34A;
        }

        .step-content {
            flex: 1;
            padding-top: 1px;
        }

        .step-name {
            font-size: 13.5px;
            font-weight: 600;
            color: #111827;
        }

        .step-name.pending-text {
            color: #9CA3AF;
            font-weight: 500;
        }

        .step-detail {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 2px;
        }

        .step-detail.active-detail {
            color: #374151;
            font-weight: 500;
        }


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





         .btn-action { padding: 0.5rem 1rem; background-color: #4299e1; color: white; border-radius: 0.375rem; font-size: 0.8125rem; font-weight: 500; text-decoration: none; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 0.25rem; }
    .btn-action:hover { background-color: #3182ce; }
    </style>
@endpush

@section('content')
    {{-- The content area is wrapped in the dashboard grid --}}

    <link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <div class="dashboard-grid">

        {{-- LEFT: main content --}}
        <div class="dashboard-left">

            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-header-text">
                    <h1>Citizen Dashboard</h1>
                    <p>Welcome back, {{ Auth::user()->name }}. You have {{ $pendingReports }} reports requiring your attention.</p>
                </div>
                
            </div>

            <div class="page-header-actions">
                    
                    <button class="btn btn-primary" onclick="window.location='{{ route('submit') }}'" style="font-weight: 600; font-size: 20px; height:60px; width: 100%;">
                       
                       + Submit New Report
                    </button>
                </div>

            {{-- Stat Cards --}}
            

            {{-- Report History --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Report History</span>
                    <div class="card-actions">
                        <button class="action-btn">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Filter
                        </button>
                        <button class="action-btn">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <line x1="3" y1="12" x2="15" y2="12" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <line x1="3" y1="18" x2="9" y2="18" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            Sort
                        </button>
                    </div>
                </div>

                <table class="report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>DEPARTMENT</th>
                            <th>PRIORITY</th>
                            <th>STATUS</th>
                            <th>CREATED ON</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>
                                    <span class="report-id">
                                        #CR-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="report-title-text">
                                        {{ $report->title }}
                                    </div>

                                    <div class="report-address">
                                        {{ $report->location }}
                                    </div>
                                </td>

                               <td>
    @switch($report->category)

        @case('Road Damage')
            PWD
            @break

        @case('Street Light')
            Electricity Department
            @break

        @case('Water Leakage')
            Water Supply Department
            @break

        @case('Garbage')
            Sanitation Department
            @break

        @case('Drainage')
            Sanitation Department
            @break

        @case('Electricity')
            Electricity Department
            @break

        @default
            Not Assigned

    @endswitch
</td>

                                <td>
                                    <span class="badge-pill badge-{{ strtolower($report->priority) }}">
                                        {{ strtoupper($report->priority) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status-pill status-{{ strtolower($report->status) }}">
    {{ strtoupper(str_replace('_',' ',$report->status)) }}
</span>
                                </td>

                                <td>
                                    <div>{{ $report->created_at->format('M d, Y') }}</div>
                                    <div style="font-size:12px;color:#9CA3AF;">
                                        {{ $report->created_at->format('h:i A') }}
                                    </div>
                                </td>

                                <td>
                               <a href="{{ route('reports.show', ['report' => $report->id]) }}">
                                    <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View
                                </a>
                            </td>
                            
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:20px;">
                                    No reports found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="table-footer">
    <span class="table-showing">
        Showing {{ $reports->firstItem() }}
        to {{ $reports->lastItem() }}
        of {{ $reports->total() }} records
    </span>

    {{ $reports->links() }}
</div>
            </div>

            {{-- Bottom Row: Notifications + Map --}}
            <div class="mid-row">
        <div class="card">
            <div class="card-title-row">
                <span class="card-title">Recent Notifications</span>
                <a href="#" class="view-all-mini">View All</a>
            </div>
            <div class="notif-list">
                <div class="notif-item">
                    <div class="notif-icon ni-blue">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M19 8v6M22 11h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div class="notif-body">
                        <p>Your report <strong>#CR-9012</strong> has been assigned to Public Works Department.</p>
                        <div class="notif-time">10 minutes ago</div>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon ni-amber">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><polyline points="12 7 12 12 15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="notif-body">
                        <p>Status updated for <strong>#CR-8702</strong> - Water Leakage.</p>
                        <div class="notif-time">2 hours ago</div>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon ni-green">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="notif-body">
                        <p>Report <strong>#CR-8650</strong> - Pothole Repair has been resolved successfully.</p>
                        <div class="notif-time">5 hours ago</div>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon ni-purple">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2v6h6M12 18v-6M9 15h6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="notif-body">
                        <p>New report <strong>#CR-9013</strong> submitted by citizen Anjali Shil for Street Light issue.</p>
                        <div class="notif-time">8 hours ago</div>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon ni-red">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0zM12 9v4M12 17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="notif-body">
                        <p>High priority report <strong>#CR-9010</strong> - Drainage overflow requires immediate attention.</p>
                        <div class="notif-time">1 day ago</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title-row">
                <span class="card-title">Reports on Map</span>
                <a href="#" class="view-all-mini">View All</a>
            </div>
            <div id="reportMap"></div>
        </div>
    </div>

        </div>

        {{-- RIGHT: profile + case tracker --}}
        <div class="right-panel">

            {{-- Profile Card --}}
            <div class="profile-card">
                <img src="{{ Auth::user()->profile_image
        ? asset('storage/' . Auth::user()->profile_image)
        : asset('images/default-user.png') }}" alt="Profile Image" class="rounded-circle" width="40" height="40">
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-email">{{ Auth::user()->email }}</div>
                <div class="rank-block">
                    <div class="rank-label">IMPACT RANK</div>
                    <div class="rank-value">{{ $impactRank }}</div>
                </div>
            </div>

            {{-- Case Tracker --}}
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
                            <path
                                d="M20 6L9 17l-5-5"
                                stroke="currentColor"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
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
    </div>
   <script>
document.addEventListener('DOMContentLoaded', function () {

    const reports = @json($mapReports);

    const map = L.map('reportMap').setView([23.856930489407134, 91.29], 16);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 24
        }
    ).addTo(map);

    reports.forEach(report => {

        let color = '#2563EB';

        if (report.status === 'resolved')
            color = '#16A34A';

        if (report.status === 'pending' || report.status === 'submitted')
            color = '#DC2626';

        if (report.status === 'in_progress')
            color = '#F59E0B';

        const icon = L.divIcon({
            html: `
                <div style="
                    width:18px;
                    height:18px;
                    background:${color};
                    border-radius:50%;
                    border:3px solid white;
                    box-shadow:0 0 5px rgba(0,0,0,.3);
                "></div>
            `,
            className: ''
        });

        L.marker(
            [report.latitude, report.longitude],
            { icon: icon }
        )
        .addTo(map)
        .bindPopup(`
<a href="/reports/${report.id}"
   style="
        display:block;
        color:inherit;
        text-decoration:none;
        font-family:Inter,sans-serif;
   ">
    <strong>#CP-${report.id}</strong><br>
    ${report.title}<br>
    <span style="color:${color};font-weight:600">
        ${report.status.replace('_', ' ')}
    </span>
</a>
`);
    });

    // Focus map on first report
    if (reports.length > 0) {
        map.setView(
            [reports[0].latitude, reports[0].longitude],
            15
        );
    }

    setTimeout(() => {
        map.invalidateSize();
    }, 300);

});
</script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection