{{-- resources/views/components/sidebar-admin.blade.php
Light minimalistic sidebar for the Super Admin dashboard. --}}



<aside class="admin-sidebar">

    {{-- ─── Logo ─────────────────────────────────────────── --}}
    <div class="admin-logo">
        <div class="admin-logo-icon">
            <svg class="logo-svg" width="100" height="100" viewBox="0 0 100 100">

                <rect width="100" height="100" rx="20" fill="#2563EB" />

                <path class="heartbeat" pathLength="100" d="M20 50 L35 50 L42 35 L52 65 L62 50 L80 50" stroke="white"
                    stroke-width="5" fill="none" />

            </svg>
        </div>
        <div class="admin-logo-text">
            <span class="admin-logo-name">CivicPulse</span>
            <span class="admin-logo-sub">Civic Issue Reporting</span>
        </div>
    </div>

    {{-- ─── Navigation ───────────────────────────────────── --}}
    <nav class="admin-nav-scroll">

    {{-- MAIN --}}
    <div class="admin-section-label">Main</div>

    <a href="{{ route('officers.dashboard') }}"
       class="admin-nav-item {{ request()->routeIs('officer.dashboard') ? 'active' : '' }}">
        <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/>
            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/>
            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/>
            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/>
        </svg>
        <span class="admin-nav-text">Dashboard</span>
    </a>

    {{-- REPORTS --}}
    <div class="admin-section-label">Reports</div>

    <a href="{{ route('officers.reports.index') }}"
       class="admin-nav-item {{ request()->routeIs('officer.reports.index') ? 'active' : '' }}">
        <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                stroke="currentColor" stroke-width="2"/>
            <path d="M14 2v6h6"
                stroke="currentColor"
                stroke-width="2"/>
        </svg>
        <span class="admin-nav-text">Department Reports</span>
    </a>

    <a href="{{ route('officers.reports.pending') }}"
       class="admin-nav-item {{ request()->routeIs('officer.reports.pending') ? 'active' : '' }}">
        <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9"
                stroke="currentColor"
                stroke-width="2"/>
            <polyline points="12 7 12 12 15 15"
                stroke="currentColor"
                stroke-width="2"/>
        </svg>
        <span class="admin-nav-text">Pending Reports</span>
    </a>

    <a href="{{ route('officers.reports.inprogress') }}"
       class="admin-nav-item {{ request()->routeIs('officer.reports.inprogress') ? 'active' : '' }}">
        <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9"
                stroke="currentColor"
                stroke-width="2"/>
            <polyline points="12 7 12 12 15 15"
                stroke="currentColor"
                stroke-width="2"/>
        </svg>
        <span class="admin-nav-text">In Progress</span>
    </a>

    <a href="{{ route('officers.reports.resolved') }}"
       class="admin-nav-item {{ request()->routeIs('officer.reports.resolved') ? 'active' : '' }}">
        <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9"
                stroke="currentColor"
                stroke-width="2"/>
            <polyline points="12 7 12 12 15 15"
                stroke="currentColor"
                stroke-width="2"/>
        </svg>
        <span class="admin-nav-text">Resolved Reports</span>
    </a>

    <a href="{{ route('officers.reports.assigned') }}"
       class="admin-nav-item {{ request()->routeIs('officer.reports.assigned') ? 'active' : '' }}">
        <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5"
                stroke="currentColor"
                stroke-width="2"/>
            <circle cx="9" cy="7"
                r="4"
                stroke="currentColor"
                stroke-width="2"/>
        </svg>
        <span class="admin-nav-text">Assigned To Me</span>
    </a>

    


    

</nav>

    {{-- ─── Emergency Contacts (bottom card) ─────────────── --}}
    <div class="emergency-content">
        <button class="bg-danger text-white rounded " onclick="emergency()"
            style="height: 50px; width: 200px; border: none; margin-left: 5px; color: white; background-color: black; font-weight: 700; border-radius: 6px; margin-bottom: 13px; cursor: pointer;"
            data-bs-toggle="modal" data-bs-target="#emergencyModal">Emergency
            Contact</button>
    </div>

</aside>

<div class="modal fade" id="emergencyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                     Emergency Contact Directory
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-body">
                                <h6>Police Control Room</h6>
                                <h4 class="text-danger">100</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6>Ambulance</h6>
                                <h4 class="text-success">108</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6>Fire Brigade</h6>
                                <h4 class="text-warning">101</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6>Disaster Management</h6>
                                <h4 class="text-primary">1070</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>Women Helpline</h6>
                                <h4>1091</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>Child Helpline</h6>
                                <h4>1098</h4>
                            </div>
                        </div>
                    </div>

                </div>

                <hr>

                <h6 class="mb-3">Local Government Offices</h6>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PWD Department</td>
                            <td>+91 381 1234567</td>
                        </tr>
                        <tr>
                            <td>Water Supply</td>
                            <td>+91 381 2234567</td>
                        </tr>
                        <tr>
                            <td>Electricity</td>
                            <td>+91 381 3234567</td>
                        </tr>
                        <tr>
                            <td>Sanitation</td>
                            <td>+91 381 4234567</td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>




<style>
    /* ═══════════════════════════════════════════════════════════
   SIDEBAR — Light Minimalistic Style
═══════════════════════════════════════════════════════════ */
    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        background: #FFFFFF;
        border-right: 1px solid #E5E7EB;
        display: flex;
        flex-direction: column;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        z-index: 50;
    }

    /* ─── Logo ─────────────────────────────────────────────── */
    .admin-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 22px 20px 20px;
        border-bottom: 1px solid #F3F4F6;
        flex-shrink: 0;
    }

    .admin-logo-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #EFF6FF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .admin-logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
        min-width: 0;
    }

    .admin-logo-name {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -.2px;
    }

    .admin-logo-sub {
        font-size: 11.5px;
        color: #9CA3AF;
        font-weight: 500;
        margin-top: 2px;
    }

    /* ─── Nav scroll area ──────────────────────────────────── */
    .admin-nav-scroll {
        flex: 1;
        overflow-y: auto;
        padding: 16px 12px 12px;
        display: flex;
        flex-direction: column;
    }

    /* Custom scrollbar */
    .admin-nav-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .admin-nav-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .admin-nav-scroll::-webkit-scrollbar-thumb {
        background: #E5E7EB;
        border-radius: 4px;
    }

    .admin-nav-scroll::-webkit-scrollbar-thumb:hover {
        background: #D1D5DB;
    }

    /* ─── Section label (small caps category headings) ────── */
    .admin-section-label {
        font-size: 10.5px;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        padding: 16px 12px 6px;
    }

    .admin-section-label:first-child {
        padding-top: 4px;
    }

    /* ─── Nav item ─────────────────────────────────────────── */
    .admin-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        margin-bottom: 2px;
        border-radius: 8px;
        text-decoration: none;
        color: #4B5563;
        font-size: 13.5px;
        font-weight: 500;
        transition: all .15s ease;
        position: relative;
    }

    .admin-nav-item:hover {
        background: #F9FAFB;
        color: #111827;
    }

    .admin-nav-item.active {
        background: #EFF6FF;
        color: #2563EB;
        font-weight: 600;
    }

    .admin-nav-icon {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        color: currentColor;
        stroke-width: 2;
    }

    .admin-nav-text {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ─── Badge (e.g. Pending count) ──────────────────────── */
    .admin-nav-badge {
        min-width: 22px;
        height: 20px;
        padding: 0 7px;
        border-radius: 999px;
        background: #DC2626;
        color: #fff;
        font-size: 10.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .admin-nav-item.active .admin-nav-badge {
        background: #2563EB;
    }



    /* ─── Responsive ───────────────────────────────────────── */
    @media (max-width: 1024px) {
        .admin-sidebar {
            transform: translateX(-100%);
            transition: transform .3s ease;
        }

        .admin-sidebar.open {
            transform: translateX(0);
        }
    }
</style>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>