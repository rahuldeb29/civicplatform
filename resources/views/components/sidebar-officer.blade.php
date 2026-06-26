<aside class="admin-sidebar">

    <div class="admin-logo">
        <div class="admin-logo-icon">
            <img src="{{ asset('images/logo.png') }}" width="36">
        </div>

        <div class="admin-logo-text">
            <div class="admin-logo-name">CivicPulse</div>
            <div class="admin-logo-sub">Officer Panel</div>
        </div>
    </div>

    <div class="admin-nav-scroll">

        <div class="admin-section-label">
            MAIN
        </div>

        <a href="{{ route('officer.dashboard') }}" class="admin-nav-item">
            Dashboard
        </a>

        <div class="admin-section-label">
            REPORTS
        </div>

        <a href="{{ route('admin.reports.index') }}" class="admin-nav-item">
            Department Reports
        </a>

        <a href="{{ route('admin.reports.pending') }}" class="admin-nav-item">
            Pending Reports
        </a>

        <a href="{{ route('admin.reports.resolved') }}" class="admin-nav-item">
            Resolved Reports
        </a>

        <div class="admin-section-label">
            ACCOUNT
        </div>

        <a href="{{ route('profile.edit') }}" class="admin-nav-item">
            My Profile
        </a>

    </div>

</aside>