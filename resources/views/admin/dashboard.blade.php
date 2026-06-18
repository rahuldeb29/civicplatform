@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>

    /* ═══════════════════════════════════════════════════════════
   LAYOUT FIX - Main Content Beside Sidebar
   ═══════════════════════════════════════════════════════════ */

body {
    margin: 0;
    padding: 0;
    background: #F9FAFB;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Main wrapper - pushes everything right of sidebar */
.admin-main {
    margin-left: 260px;          /* ← Same as sidebar width */
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: #F9FAFB;
    transition: margin-left 0.3s ease;
}

/* Top Navbar - sticky at top, also offset from sidebar */
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

/* Page content area */
.admin-content {
    flex: 1;
    padding: 28px;
}

/* Responsive: hide sidebar on mobile, full-width content */
@media (max-width: 1024px) {
    .admin-main {
        margin-left: 0;
    }
}
    /* ─── Page Header ────────────────────────────────────────── */
    .dash-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 24px; flex-wrap: wrap; gap: 14px;
    }
    .dash-header h1 { font-size: 28px; font-weight: 800; color: #111827; letter-spacing: -.3px; }
    .dash-header p  { font-size: 13.5px; color: #6B7280; margin-top: 4px; }

    .header-actions { display: flex; gap: 14px; align-items: center; flex-wrap: wrap; }

    .btn-export {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 4px; background: transparent; border: none;
        font-size: 14px; font-weight: 500; color: #374151;
        cursor: pointer; font-family: inherit;
    }
    .btn-export:hover { color: #111827; }
    .btn-export svg { width: 16px; height: 16px; }

    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 20px; border-radius: 9px;
        background: #2563EB; color: #fff; border: none;
        font-size: 14px; font-weight: 600; cursor: pointer;
        font-family: inherit; transition: all .15s;
    }
    .btn-submit:hover { background: #1D4ED8; }
    .btn-submit svg { width: 16px; height: 16px; }

    .date-range-btn {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 16px;
        background: #fff; border: 1px solid #E5E7EB; border-radius: 9px;
        font-size: 13px; font-weight: 500; color: #374151;
        cursor: pointer; white-space: nowrap;
    }
    .date-range-btn svg { width: 15px; height: 15px; color: #6B7280; flex-shrink: 0; }

    /* ─── Stat Cards (Reference Style) ───────────────────────── */
    .stat-cards {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff; border: 1px solid #E5E7EB; border-radius: 14px;
        padding: 22px;
    }
    .stat-card-top {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 18px;
    }
    .stat-card-label {
        font-size: 12px; font-weight: 600; color: #6B7280;
        text-transform: uppercase; letter-spacing: 0.8px;
    }
    .stat-icon-circle {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon-circle svg { width: 18px; height: 18px; }
    .icon-bg-purple { background: #EEF2FF; color: #6366F1; }
    .icon-bg-orange { background: #FFF7ED; color: #F59E0B; }
    .icon-bg-blue   { background: #EFF6FF; color: #3B82F6; }
    .icon-bg-green  { background: #F0FDF4; color: #16A34A; }

    .stat-card-value {
        font-size: 38px; font-weight: 800; color: #111827;
        line-height: 1; margin-bottom: 14px;
    }
    .stat-card-trend {
        font-size: 13px; display: flex; align-items: center; gap: 6px;
        padding-top: 12px; border-top: 1px solid #F3F4F6;
    }
    .stat-card-trend.up   { color: #16A34A; }
    .stat-card-trend.down { color: #DC2626; }
    .stat-card-trend .trend-val { font-weight: 600; }
    .stat-card-trend .period { color: #9CA3AF; font-weight: 400; }
    .stat-card-trend svg { width: 12px; height: 12px; }

    /* ─── Chart Row (keep style) ─────────────────────────────── */
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
</style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="dash-header">
        <div>
            <h1>Dashboard</h1>
            <p>Welcome back, Admin! You have <strong>12</strong> reports requiring your attention.</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn-export">
                <svg viewBox="0 0 24 24" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Export Report History
            </button>
            <button type="button" class="btn-submit">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                Submit New Report
            </button>
            <button type="button" class="date-range-btn">
                <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/></svg>
                May 12, 2025 - Jun 12, 2025
            </button>
        </div>
    </div>

    {{-- Stat Cards (NEW STYLE - Reference Image) --}}
    <div class="stat-cards">
        {{-- Total Reports --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label">Total Reports</span>
                <div class="stat-icon-circle icon-bg-purple">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2v6h6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <div class="stat-card-value">1,248</div>
            <div class="stat-card-trend up">
                <svg viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                <span class="trend-val">18.6%</span>
                <span class="period">from last month</span>
            </div>
        </div>

        {{-- Pending Action --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label">Pending Action</span>
                <div class="stat-icon-circle icon-bg-orange">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><polyline points="12 7 12 12 15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <div class="stat-card-value">312</div>
            <div class="stat-card-trend down">
                <svg viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                <span class="trend-val">12.4%</span>
                <span class="period">from last month</span>
            </div>
        </div>

        {{-- In Progress --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label">In Progress</span>
                <div class="stat-icon-circle icon-bg-blue">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <div class="stat-card-value">456</div>
            <div class="stat-card-trend up">
                <svg viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                <span class="trend-val">8.7%</span>
                <span class="period">from last month</span>
            </div>
        </div>

        {{-- Resolved Cases --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label">Resolved Cases</span>
                <div class="stat-icon-circle icon-bg-green">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M8 12l3 3 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <div class="stat-card-value">480</div>
            <div class="stat-card-trend up">
                <svg viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                <span class="trend-val">24.3%</span>
                <span class="period">from last month</span>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="chart-row">
        <div class="card">
            <div class="card-title-row">
                <span class="card-title">Reports by Department</span>
            </div>
            <div class="donut-wrap">
                <div class="donut-canvas-box">
                    <canvas id="deptDonutChart"></canvas>
                    <div class="donut-center">
                        <div class="donut-center-value">1,248</div>
                        <div class="donut-center-label">Total</div>
                    </div>
                </div>
                <div class="donut-legend">
                    <div class="legend-row">
                        <div class="legend-left"><span class="legend-dot" style="background:#2563EB;"></span><span class="legend-name">Public Works (PWD)</span></div>
                        <span class="legend-value">32% (399)</span>
                    </div>
                    <div class="legend-row">
                        <div class="legend-left"><span class="legend-dot" style="background:#06B6D4;"></span><span class="legend-name">Water Supply</span></div>
                        <span class="legend-value">24% (299)</span>
                    </div>
                    <div class="legend-row">
                        <div class="legend-left"><span class="legend-dot" style="background:#F59E0B;"></span><span class="legend-name">Electricity</span></div>
                        <span class="legend-value">18% (225)</span>
                    </div>
                    <div class="legend-row">
                        <div class="legend-left"><span class="legend-dot" style="background:#A855F7;"></span><span class="legend-name">Sanitation</span></div>
                        <span class="legend-value">16% (200)</span>
                    </div>
                    <div class="legend-row">
                        <div class="legend-left"><span class="legend-dot" style="background:#9CA3AF;"></span><span class="legend-name">Others</span></div>
                        <span class="legend-value">10% (125)</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title-row">
                <span class="card-title">Reports Over Time</span>
                <div class="line-legend"><span class="legend-dot"></span>Reports</div>
            </div>
            <div class="line-chart-box">
                <canvas id="reportsLineChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Report History --}}
    <div class="card reports-card">
        <div class="card-title-row">
            <span class="card-title">Report History</span>
            <div class="table-toolbar">
                <button class="toolbar-btn">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Filter
                </button>
                <button class="toolbar-btn">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M3 6h18M6 12h12M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Sort
                </button>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Department</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Submitted By</th>
                        <th>Created On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="id-cell">#CP1248</td>
                        <td class="title-cell">Water leakage on MG Road</td>
                        <td><span class="pill pill-water-leakage">Water Leakage</span></td>
                        <td>Water Supply</td>
                        <td><span class="pill priority-pill">High</span></td>
                        <td><span class="status-text status-assigned">Assigned</span></td>
                        <td>Rahul Deb</td>
                        <td>Jun 12, 2025</td>
                        <td><button class="view-btn" title="View"><svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg></button></td>
                    </tr>
                    <tr>
                        <td class="id-cell">#CP1247</td>
                        <td class="title-cell">Street light not working</td>
                        <td><span class="pill pill-street-light">Street Light</span></td>
                        <td>Electricity</td>
                        <td><span class="pill priority-pill medium">Medium</span></td>
                        <td><span class="status-text status-in_progress">In Progress</span></td>
                        <td>Anjali Shil</td>
                        <td>Jun 12, 2025</td>
                        <td><button class="view-btn" title="View"><svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg></button></td>
                    </tr>
                    <tr>
                        <td class="id-cell">#CP1246</td>
                        <td class="title-cell">Garbage not collected</td>
                        <td><span class="pill pill-garbage">Garbage</span></td>
                        <td>Sanitation</td>
                        <td><span class="pill priority-pill low">Low</span></td>
                        <td><span class="status-text status-pending">Pending</span></td>
                        <td>Riya Saha</td>
                        <td>Jun 11, 2025</td>
                        <td><button class="view-btn" title="View"><svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg></button></td>
                    </tr>
                    <tr>
                        <td class="id-cell">#CP1245</td>
                        <td class="title-cell">Pothole on College Road</td>
                        <td><span class="pill pill-road-damage">Road Damage</span></td>
                        <td>Public Works</td>
                        <td><span class="pill priority-pill">High</span></td>
                        <td><span class="status-text status-resolved">Resolved</span></td>
                        <td>Samir Deb</td>
                        <td>Jun 11, 2025</td>
                        <td><button class="view-btn" title="View"><svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg></button></td>
                    </tr>
                    <tr>
                        <td class="id-cell">#CP1244</td>
                        <td class="title-cell">Broken drainage near park</td>
                        <td><span class="pill pill-drainage">Drainage</span></td>
                        <td>Public Works</td>
                        <td><span class="pill priority-pill medium">Medium</span></td>
                        <td><span class="status-text status-assigned">Assigned</span></td>
                        <td>Priya Das</td>
                        <td>Jun 10, 2025</td>
                        <td><button class="view-btn" title="View"><svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg></button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            <div class="pagination-info">Showing 5 of 24 records</div>
            <div class="pagination-btns">
                <button class="page-btn">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Previous
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">...</button>
                <button class="page-btn">6</button>
                <button class="page-btn">
                    Next
                    <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mid Row: Recent Notifications + Reports on Map --}}
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

    {{-- Bottom Row: Quick Summary + Case Tracker --}}
    <div class="bottom-row">

        {{-- Quick Summary --}}
        <div class="card">
            <div class="card-title-row">
                <span class="card-title">Quick Summary</span>
            </div>
            <div class="summary-list">
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="18" cy="7" r="3" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <span class="summary-label">Total Citizens</span>
                    <span class="summary-value">2,315</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M4 21V8l8-5 8 5v13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="9" y1="21" x2="9" y2="12" stroke="currentColor" stroke-width="2"/><line x1="15" y1="21" x2="15" y2="12" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <span class="summary-label">Active Departments</span>
                    <span class="summary-value">5</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M17 9l2 2 3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <span class="summary-label">Total Officers</span>
                    <span class="summary-value">28</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <span class="summary-label">Total Categories</span>
                    <span class="summary-value">12</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="18" cy="9" r="3" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <span class="summary-label">Total Users</span>
                    <span class="summary-value">2,343</span>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <svg viewBox="0 0 24 24" fill="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <span class="summary-label">Avg. Impact Rank</span>
                    <span class="summary-value">4.2</span>
                </div>
            </div>
        </div>

        {{-- Case Tracker (NEW STYLE) --}}
        <div class="card">
            <div class="card-title-row">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><polyline points="12 7 12 12 15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Case Tracker
                </span>
            </div>

            <div class="case-active-box">
                <div class="case-active-label">Current Active</div>
                <a href="#" class="case-active-id">#CR-9012 - Pothole Repair</a>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-dot dot-done">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="timeline-content">
                        <h4>Submitted</h4>
                        <p>Oct 24, 2023 • 09:12 AM</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot dot-done">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="timeline-content">
                        <h4>Assigned</h4>
                        <p>Public Works Dept • Oct 24</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot dot-active">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
                    </div>
                    <div class="timeline-content">
                        <h4>In Progress</h4>
                        <p>Crew working on site</p>
                    </div>
                </div>
                <div class="timeline-item pending">
                    <div class="timeline-dot dot-pending"></div>
                    <div class="timeline-content">
                        <h4>Assessment Complete</h4>
                        <p>Pending</p>
                    </div>
                </div>
                <div class="timeline-item pending">
                    <div class="timeline-dot dot-pending"></div>
                    <div class="timeline-content">
                        <h4>Resolved</h4>
                        <p>Pending</p>
                    </div>
                </div>
                <div class="timeline-item pending">
                    <div class="timeline-dot dot-pending"></div>
                    <div class="timeline-content">
                        <h4>Closed</h4>
                        <p>Pending</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // ─── Donut Chart ──────────────────────────────────────────
    const deptCtx = document.getElementById('deptDonutChart').getContext('2d');
    new Chart(deptCtx, {
        type: 'doughnut',
        data: {
            labels: ['Public Works (PWD)', 'Water Supply', 'Electricity', 'Sanitation', 'Others'],
            datasets: [{
                data: [399, 299, 225, 200, 125],
                backgroundColor: ['#2563EB', '#06B6D4', '#F59E0B', '#A855F7', '#9CA3AF'],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            cutout: '72%',
            plugins: { legend: { display: false }, tooltip: { enabled: true } },
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    // ─── Line Chart ───────────────────────────────────────────
    const lineCtx = document.getElementById('reportsLineChart').getContext('2d');
    const gradient = lineCtx.createLinearGradient(0, 0, 0, 230);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['June 12', 'June 19', 'June 26', 'July 02', 'July 09', 'July 16'],
            datasets: [{
                label: 'Reports',
                data: [130, 240, 200, 330, 310, 340],
                borderColor: '#2563EB',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#2563EB',
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 400,
                    ticks: { stepSize: 100, color: '#9CA3AF', font: { size: 11.5 } },
                    grid: { color: '#F3F4F6' },
                },
                x: {
                    ticks: { color: '#9CA3AF', font: { size: 11.5 } },
                    grid: { display: false },
                }
            }
        }
    });

    // ─── Leaflet Map ──────────────────────────────────────────
    const map = L.map('reportMap').setView([23.8315, 91.2868], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 18
    }).addTo(map);

    const reports = [
        { lat: 23.835, lng: 91.280, title: '#CR-9012 - Pothole',       status: 'In Progress', color: '#F59E0B' },
        { lat: 23.828, lng: 91.290, title: '#CR-9010 - Drainage',      status: 'Pending',     color: '#DC2626' },
        { lat: 23.840, lng: 91.295, title: '#CR-8702 - Water Leakage', status: 'In Progress', color: '#F59E0B' },
        { lat: 23.825, lng: 91.275, title: '#CR-8650 - Street Light',  status: 'Resolved',    color: '#16A34A' },
        { lat: 23.838, lng: 91.283, title: '#CR-9013 - Garbage',       status: 'Pending',     color: '#DC2626' },
    ];

    reports.forEach(r => {
        const icon = L.divIcon({
            html: `<div style="width:20px;height:20px;background:${r.color};border:3px solid #fff;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,.3);"></div>`,
            className: '',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });
        L.marker([r.lat, r.lng], { icon })
            .addTo(map)
            .bindPopup(`<div style="font-family:inherit;"><strong style="font-size:13px;">${r.title}</strong><br><span style="font-size:11px;color:${r.color};font-weight:600;">${r.status}</span></div>`);
    });

    setTimeout(() => map.invalidateSize(), 300);
</script>
@endpush