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

    .dashboard-left { display: flex; flex-direction: column; gap: 24px; }

    /* ─── Page Header ───────────────────────────────────────── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
    .page-header-text h1 { font-size: 24px; font-weight: 700; color: #111827; }
    .page-header-text p  { font-size: 13.5px; color: #6B7280; margin-top: 3px; }

    .page-header-actions { display: flex; gap: 10px; }

    .btn {
        display: flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px;
        font-size: 13.5px; font-weight: 500; cursor: pointer;
        border: none; transition: background .15s, box-shadow .15s;
        text-decoration: none;
    }
    .btn-outline {
        background: #fff; border: 1px solid #D1D5DB; color: #374151;
    }
    .btn-outline:hover { background: #F9FAFB; }
    .btn-primary { background: #1D4ED8; color: #fff; }
    .btn-primary:hover { background: #1E40AF; }
    .btn svg { width: 15px; height: 15px; }

    /* ─── Stat Cards ────────────────────────────────────────── */
    .stat-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #fff; border-radius: 12px;
        padding: 20px; border: 1px solid #E5E7EB;
    }
    .stat-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 12px;
    }
    .stat-label { font-size: 11px; font-weight: 600; color: #9CA3AF; letter-spacing: .05em; text-transform: uppercase; }

    .stat-icon {
        width: 36px; height: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-icon.blue   { background: #EFF6FF; }
    .stat-icon.orange { background: #FFF7ED; }
    .stat-icon.teal   { background: #F0FDFA; }
    .stat-icon.green  { background: #F0FDF4; }
    .stat-icon svg    { width: 18px; height: 18px; }

    .stat-value { font-size: 30px; font-weight: 700; color: #111827; line-height: 1; }

    .stat-footer { margin-top: 8px; display: flex; align-items: center; gap: 5px; font-size: 12.5px; }
    .stat-footer.up   .trend { color: #16A34A; }
    .stat-footer.down .trend { color: #EF4444; }
    .stat-footer .trend { font-weight: 600; display: flex; align-items: center; gap: 2px; }
    .stat-footer .period { color: #9CA3AF; }

    /* ─── Report History Table ──────────────────────────────── */
    .card {
        background: #fff; border-radius: 12px;
        border: 1px solid #E5E7EB; overflow: hidden;
    }
    .card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 20px 16px;
    }
    .card-title { font-size: 15px; font-weight: 700; color: #111827; }

    .card-actions { display: flex; gap: 8px; }
    .action-btn {
        display: flex; align-items: center; gap: 6px;
        padding: 7px 13px; border-radius: 7px;
        font-size: 13px; font-weight: 500;
        background: #fff; border: 1px solid #E5E7EB; color: #374151;
        cursor: pointer; transition: background .15s;
    }
    .action-btn:hover { background: #F9FAFB; }
    .action-btn svg { width: 14px; height: 14px; color: #6B7280; }

    /* Table */
    .report-table { width: 100%; border-collapse: collapse; }
    .report-table th {
        padding: 10px 16px; text-align: left;
        font-size: 11px; font-weight: 600; color: #9CA3AF;
        letter-spacing: .04em; text-transform: uppercase;
        background: #F9FAFB; border-bottom: 1px solid #E5E7EB;
    }
    .report-table td {
        padding: 14px 16px;
        font-size: 13.5px; color: #374151;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }
    .report-table tr:last-child td { border-bottom: none; }
    .report-table tr:hover td { background: #FAFAFA; }

    .report-id { color: #6B7280; font-size: 12.5px; }
    .report-title-text { font-weight: 600; color: #111827; font-size: 13.5px; }
    .report-address { font-size: 12px; color: #9CA3AF; margin-top: 2px; }

    /* Badges */
    .badge-pill {
        display: inline-block;
        padding: 3px 10px; border-radius: 6px;
        font-size: 11.5px; font-weight: 600;
    }
    .badge-medium   { background: #FEF3C7; color: #D97706; }
    .badge-high     { background: #FEE2E2; color: #DC2626; }
    .badge-low      { background: #DCFCE7; color: #16A34A; }
    .badge-critical { background: #FEE2E2; color: #B91C1C; border: 1px solid #FCA5A5; }

    .status-pill {
        display: inline-block;
        padding: 4px 10px; border-radius: 6px;
        font-size: 11.5px; font-weight: 600; letter-spacing: .02em;
    }
    .status-progress { background: #DBEAFE; color: #1D4ED8; }
    .status-assigned { background: #FEF3C7; color: #B45309; }
    .status-resolved { background: #DCFCE7; color: #15803D; }

    .view-link {
        display: flex; align-items: center; gap: 4px;
        color: #1D4ED8; font-size: 13px; font-weight: 500;
        text-decoration: none; white-space: nowrap;
    }
    .view-link svg { width: 14px; height: 14px; }
    .view-link:hover { text-decoration: underline; }

    /* Pagination */
    .table-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 20px;
        border-top: 1px solid #E5E7EB;
    }
    .table-showing { font-size: 13px; color: #6B7280; }

    .pagination { display: flex; align-items: center; gap: 4px; }
    .page-btn {
        min-width: 32px; height: 32px; padding: 0 8px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 7px; font-size: 13px; font-weight: 500;
        border: 1px solid #E5E7EB; background: #fff; color: #374151;
        cursor: pointer; transition: background .15s;
        text-decoration: none;
    }
    .page-btn:hover { background: #F3F4F6; }
    .page-btn.active { background: #1D4ED8; color: #fff; border-color: #1D4ED8; }
    .page-btn.nav-pg { gap: 4px; }

    /* ─── Bottom Row ────────────────────────────────────────── */
    .bottom-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    /* Notifications */
    .notif-list { padding: 0 20px 16px; display: flex; flex-direction: column; gap: 14px; }

    .notif-item { display: flex; align-items: flex-start; gap: 12px; }
    .notif-ico {
        width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .notif-ico.blue   { background: #DBEAFE; }
    .notif-ico.orange { background: #FFF7ED; }
    .notif-ico svg { width: 16px; height: 16px; }
    .notif-text { flex: 1; }
    .notif-msg  { font-size: 13px; color: #374151; line-height: 1.4; }
    .notif-time { font-size: 11.5px; color: #9CA3AF; margin-top: 3px; }

    .card-header-link { font-size: 13px; color: #1D4ED8; font-weight: 500; text-decoration: none; }
    .card-header-link:hover { text-decoration: underline; }

    /* Map */
    .map-container { margin: 0 20px 20px; border-radius: 10px; overflow: hidden; border: 1px solid #E5E7EB; }
    .map-placeholder {
        height: 180px; background: #E5E7EB;
        display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden;
    }
    /* Fake map grid */
    .map-placeholder::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(#D1D5DB 1px, transparent 1px),
            linear-gradient(90deg, #D1D5DB 1px, transparent 1px);
        background-size: 40px 40px;
        background-color: #EDE9FE;
    }
    .map-road-h, .map-road-v {
        position: absolute; background: #fff; opacity: .7;
    }
    .map-road-h { height: 6px; width: 100%; top: 45%; }
    .map-road-v { width: 6px; height: 100%; left: 30%; }
    .map-road-v2 { left: 65%; }

    .map-pin {
        position: absolute; font-size: 22px; transform: translate(-50%,-100%);
        filter: drop-shadow(0 2px 4px rgba(0,0,0,.2));
        cursor: pointer;
    }

    /* ─── Right Panel ───────────────────────────────────────── */
    .right-panel { display: flex; flex-direction: column; gap: 20px; }

    /* Profile Card */
    .profile-card {
        background: #fff; border-radius: 12px;
        border: 1px solid #E5E7EB;
        padding: 24px 20px;
        display: flex; flex-direction: column; align-items: center; text-align: center;
    }
    .profile-avatar {
        width: 64px; height: 64px; border-radius: 50%; object-fit: cover;
        margin-bottom: 12px;
    }
    .profile-name { font-size: 16px; font-weight: 700; color: #111827; }
    .profile-email { font-size: 12.5px; color: #6B7280; margin-top: 2px; }

    .rank-block { margin-top: 16px; width: 100%; padding-top: 16px; border-top: 1px solid #F3F4F6; }
    .rank-label { font-size: 10px; font-weight: 600; color: #9CA3AF; letter-spacing: .05em; text-transform: uppercase; }
    .rank-value { font-size: 28px; font-weight: 800; color: #1D4ED8; margin-top: 4px; }

    /* Case Tracker */
    .case-tracker {
        background: #fff; border-radius: 12px;
        border: 1px solid #E5E7EB; padding: 20px;
    }
    .case-tracker-header {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 16px;
    }
    .case-tracker-header svg { width: 18px; height: 18px; color: #6B7280; }
    .case-tracker-title { font-size: 15px; font-weight: 700; color: #111827; }

    .active-case {
        background: #F8FAFF; border: 1px solid #DBEAFE;
        border-radius: 8px; padding: 10px 12px; margin-bottom: 16px;
    }
    .active-label { font-size: 10px; font-weight: 600; color: #9CA3AF; letter-spacing: .05em; text-transform: uppercase; }
    .active-id { font-size: 13px; font-weight: 600; color: #1D4ED8; margin-top: 4px; }

    /* Timeline */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .timeline-step {
        display: flex; gap: 12px; position: relative;
        padding-bottom: 18px;
    }
    .timeline-step:last-child { padding-bottom: 0; }

    .step-dot-wrap {
        display: flex; flex-direction: column; align-items: center;
        flex-shrink: 0; width: 20px;
    }
    .step-dot {
        width: 20px; height: 20px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; z-index: 1;
    }
    .step-dot.done  { background: #16A34A; }
    .step-dot.done svg { color: #fff; width: 11px; height: 11px; }
    .step-dot.active { background: #1D4ED8; }
    .step-dot.active-inner {
        width: 10px; height: 10px; background: #fff; border-radius: 50%;
    }
    .step-dot.pending { background: #E5E7EB; }
    .step-dot.pending-inner {
        width: 10px; height: 10px; background: #9CA3AF; border-radius: 50%;
    }

    .step-line {
        flex: 1; width: 2px; margin-top: 2px;
        background: #E5E7EB; min-height: 14px;
    }
    .step-line.done-line { background: #16A34A; }

    .step-content { flex: 1; padding-top: 1px; }
    .step-name {
        font-size: 13.5px; font-weight: 600;
        color: #111827;
    }
    .step-name.pending-text { color: #9CA3AF; font-weight: 500; }
    .step-detail { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
    .step-detail.active-detail { color: #374151; font-weight: 500; }
</style>
@endpush

@section('content')
{{-- The content area is wrapped in the dashboard grid --}}
<div class="dashboard-grid">

    {{-- LEFT: main content --}}
    <div class="dashboard-left">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header-text">
                <h1>Citizen Dashboard</h1>
                <p>Welcome back, Alex. You have 2 reports requiring your attention.</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-outline">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <polyline points="7 10 12 15 17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="12" y1="15" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Export Report History
                </button>
                <button class="btn btn-primary" >
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                    Submit New Report
                </button>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="stat-cards">
            {{-- Total Reports --}}
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">TOTAL REPORTS</span>
                    <div class="stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="4" width="16" height="16" rx="2" stroke="#1D4ED8" stroke-width="2"/>
                            <line x1="8" y1="9" x2="16" y2="9" stroke="#1D4ED8" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="8" y1="12" x2="16" y2="12" stroke="#1D4ED8" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="8" y1="15" x2="12" y2="15" stroke="#1D4ED8" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">{{ $totalReports }}</div>
                <div class="stat-footer up">
                    <span class="trend">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
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
                            <circle cx="12" cy="12" r="9" stroke="#D97706" stroke-width="2"/>
                            <polyline points="12 7 12 12 15 15" stroke="#D97706" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-footer down">
                    <span class="trend">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
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
                            <circle cx="12" cy="12" r="9" stroke="#0D9488" stroke-width="2"/>
                            <path d="M16 11a4 4 0 0 1-4 4H8" stroke="#0D9488" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M12 8c.5 0 1 .1 1.5.2" stroke="#0D9488" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">{{ $inProgressReports }}</div>
                <div class="stat-footer up">
                    <span class="trend">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
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
                            <circle cx="12" cy="12" r="9" stroke="#16A34A" stroke-width="2"/>
                            <path d="M8 12l3 3 5-5" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">{{ $resolvedReports }}</div>
                <div class="stat-footer up">
                    <span class="trend">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                        0%
                    </span>
                    <span class="period">from last month</span>
                </div>
            </div>
        </div>

        {{-- Report History --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Report History</span>
                <div class="card-actions">
                    <button class="action-btn">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Filter
                    </button>
                    <button class="action-btn">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="3" y1="12" x2="15" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="3" y1="18" x2="9" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
                    <tr>
                        <td><span class="report-id">#CR-9012</span></td>
                        <td>
                            <div class="report-title-text">Pothole Repair</div>
                            <div class="report-address">124 Maple Ave, East District</div>
                        </td>
                        <td>Public Works</td>
                        <td><span class="badge-pill badge-medium">MEDIUM</span></td>
                        <td><span class="status-pill status-progress">IN PROGRESS</span></td>
                        <td>
                            <div>Oct 24, 2023</div>
                            <div style="font-size:12px;color:#9CA3AF;">09:12 AM</div>
                        </td>
                        <td><a href="#" class="view-link">View Details <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a></td>
                    </tr>
                    <tr>
                        <td><span class="report-id">#CR-8941</span></td>
                        <td>
                            <div class="report-title-text">Damaged Street Light</div>
                            <div class="report-address">Oak & 5th Intersection</div>
                        </td>
                        <td>Utilities</td>
                        <td><span class="badge-pill badge-high">HIGH</span></td>
                        <td><span class="status-pill status-assigned">ASSIGNED</span></td>
                        <td>
                            <div>Oct 23, 2023</div>
                            <div style="font-size:12px;color:#9CA3AF;">10:45 AM</div>
                        </td>
                        <td><a href="#" class="view-link">View Details <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a></td>
                    </tr>
                    <tr>
                        <td><span class="report-id">#CR-8820</span></td>
                        <td>
                            <div class="report-title-text">Graffiti Removal</div>
                            <div class="report-address">City Central Park Wall</div>
                        </td>
                        <td>Sanitation</td>
                        <td><span class="badge-pill badge-low">LOW</span></td>
                        <td><span class="status-pill status-resolved">RESOLVED</span></td>
                        <td>
                            <div>Oct 22, 2023</div>
                            <div style="font-size:12px;color:#9CA3AF;">02:30 PM</div>
                        </td>
                        <td><a href="#" class="view-link">View Details <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a></td>
                    </tr>
                    <tr>
                        <td><span class="report-id">#CR-8702</span></td>
                        <td>
                            <div class="report-title-text">Water Leakage</div>
                            <div class="report-address">982 Riverbend Road</div>
                        </td>
                        <td>Water Admin</td>
                        <td><span class="badge-pill badge-critical">CRITICAL</span></td>
                        <td><span class="status-pill status-progress">IN PROGRESS</span></td>
                        <td>
                            <div>Oct 21, 2023</div>
                            <div style="font-size:12px;color:#9CA3AF;">11:20 AM</div>
                        </td>
                        <td><a href="#" class="view-link">View Details <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a></td>
                    </tr>
                </tbody>
            </table>

            <div class="table-footer">
                <span class="table-showing">Showing 4 of 24 records</span>
                <div class="pagination">
                    <a href="#" class="page-btn nav-pg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Previous
                    </a>
                    <a href="#" class="page-btn active">1</a>
                    <a href="#" class="page-btn">2</a>
                    <a href="#" class="page-btn">3</a>
                    <span class="page-btn" style="border:none;cursor:default;">...</span>
                    <a href="#" class="page-btn">6</a>
                    <a href="#" class="page-btn nav-pg">
                        Next
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom Row: Notifications + Map --}}
        <div class="bottom-row">

            {{-- Recent Notifications --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Recent Notifications</span>
                    <a href="#" class="card-header-link">View All</a>
                </div>
                <div class="notif-list">
                    <div class="notif-item">
                        <div class="notif-ico blue">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="#1D4ED8" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="9" cy="7" r="4" stroke="#1D4ED8" stroke-width="2"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="#1D4ED8" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="notif-text">
                            <div class="notif-msg">Your report #CR-9012 has been assigned to Public Works Department.</div>
                            <div class="notif-time">10 minutes ago</div>
                        </div>
                    </div>
                    <div class="notif-item">
                        <div class="notif-ico orange">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="9" stroke="#D97706" stroke-width="2"/>
                                <polyline points="12 7 12 12 15 15" stroke="#D97706" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="notif-text">
                            <div class="notif-msg">Status updated for #CR-8702 - Water Leakage.</div>
                            <div class="notif-time">2 hours ago</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reports on Map --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Reports on Map</span>
                    <a href="#" class="card-header-link">View All</a>
                </div>
                <div class="map-container">
                    <div class="map-placeholder">
                        <div class="map-road-h"></div>
                        <div class="map-road-v"></div>
                        <div class="map-road-v map-road-v2"></div>
                        {{-- Map pins --}}
                        <span class="map-pin" style="left:22%;top:58%;">📍</span>
                        <span class="map-pin" style="left:44%;top:70%;font-size:20px;">🔴</span>
                        <span class="map-pin" style="left:60%;top:55%;">📍</span>
                        <span class="map-pin" style="left:78%;top:62%;color:#1D4ED8;font-size:20px;">📍</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- RIGHT: profile + case tracker --}}
    <div class="right-panel">

        {{-- Profile Card --}}
        <div class="profile-card">
            <img src="https://i.pravatar.cc/80?img=8" alt="Alex Jenkins" class="profile-avatar">
            <div class="profile-name">{{ Auth::user()->name }}</div>
            <div class="profile-email">{{ Auth::user()->email }}</div>
            <div class="rank-block">
                <div class="rank-label">IMPACT RANK</div>
                <div class="rank-value">#1</div>
            </div>
        </div>

        {{-- Case Tracker --}}
        <div class="case-tracker">
            <div class="case-tracker-header">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                    <path d="M12 8v4l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span class="case-tracker-title">Case Tracker</span>
            </div>

            <div class="active-case">
                <div class="active-label">CURRENT ACTIVE</div>
                <div class="active-id">#CR-9012 - Pothole Repair</div>
            </div>

            <div class="timeline">

                {{-- Submitted (done) --}}
                <div class="timeline-step">
                    <div class="step-dot-wrap">
                        <div class="step-dot done">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="step-line done-line"></div>
                    </div>
                    <div class="step-content">
                        <div class="step-name">Submitted</div>
                        <div class="step-detail">Oct 24, 2023 • 09:12 AM</div>
                    </div>
                </div>

                {{-- Assigned (done) --}}
                <div class="timeline-step">
                    <div class="step-dot-wrap">
                        <div class="step-dot done">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="step-line done-line"></div>
                    </div>
                    <div class="step-content">
                        <div class="step-name">Assigned</div>
                        <div class="step-detail">Public Works Dept • Oct 24</div>
                    </div>
                </div>

                {{-- In Progress (active) --}}
                <div class="timeline-step">
                    <div class="step-dot-wrap">
                        <div class="step-dot active" style="border:2px solid #1D4ED8;background:#EFF6FF;display:flex;align-items:center;justify-content:center;">
                            <div class="active-inner" style="width:8px;height:8px;background:#1D4ED8;border-radius:50%;"></div>
                        </div>
                        <div class="step-line"></div>
                    </div>
                    <div class="step-content">
                        <div class="step-name">In Progress</div>
                        <div class="step-detail active-detail">Crew working on site</div>
                    </div>
                </div>

                {{-- Assessment Complete (pending) --}}
                <div class="timeline-step">
                    <div class="step-dot-wrap">
                        <div class="step-dot pending" style="border:2px solid #D1D5DB;background:#fff;display:flex;align-items:center;justify-content:center;">
                            <div style="width:8px;height:8px;background:#D1D5DB;border-radius:50%;"></div>
                        </div>
                        <div class="step-line"></div>
                    </div>
                    <div class="step-content">
                        <div class="step-name pending-text">Assessment Complete</div>
                        <div class="step-detail">Pending</div>
                    </div>
                </div>

                {{-- Resolved (pending) --}}
                <div class="timeline-step">
                    <div class="step-dot-wrap">
                        <div class="step-dot pending" style="border:2px solid #D1D5DB;background:#fff;display:flex;align-items:center;justify-content:center;">
                            <div style="width:8px;height:8px;background:#D1D5DB;border-radius:50%;"></div>
                        </div>
                        <div class="step-line"></div>
                    </div>
                    <div class="step-content">
                        <div class="step-name pending-text">Resolved</div>
                        <div class="step-detail">Pending</div>
                    </div>
                </div>

                {{-- Closed (pending) --}}
                <div class="timeline-step">
                    <div class="step-dot-wrap">
                        <div class="step-dot pending" style="border:2px solid #D1D5DB;background:#fff;display:flex;align-items:center;justify-content:center;">
                            <div style="width:8px;height:8px;background:#D1D5DB;border-radius:50%;"></div>
                        </div>
                    </div>
                    <div class="step-content">
                        <div class="step-name pending-text">Closed</div>
                        <div class="step-detail">Pending</div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection