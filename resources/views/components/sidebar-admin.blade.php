{{-- resources/views/components/sidebar-admin.blade.php
     Dark sidebar for the Super Admin dashboard. --}}

<aside class="admin-sidebar">
    {{-- Logo --}}
    <div class="admin-logo">
        <div class="admin-logo-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6l-8-4z" fill="#22D3EE"/>
                <path d="M9 12l2 2 4-4" stroke="#0F172A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="admin-logo-text">
            <span class="admin-logo-name">CivicPulse</span>
            <span class="admin-logo-sub">Civic Issue Reporting</span>
        </div>
    </div>

    <nav class="admin-nav-scroll">
        {{-- MAIN --}}
        <div class="admin-section-label">Main</div>
        <a href="{{ route('admin.dashboard') }}"
           class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="admin-nav-text">Dashboard</span>
        </a>

        {{-- REPORTS --}}
        <div class="admin-section-label">Reports</div>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 2v6h6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <line x1="8" y1="13" x2="16" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="8" y1="17" x2="16" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="admin-nav-text">All Reports</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                <polyline points="12 7 12 12 15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="admin-nav-text">Pending Reports</span>
            <span class="admin-nav-badge">12</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                <path d="M2 21v-2a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M17 8l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="admin-nav-text">Assigned Reports</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                <path d="M8 12l3 3 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="admin-nav-text">Resolved Reports</span>
        </a>

        {{-- MANAGEMENT --}}
        <div class="admin-section-label">Management</div>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <path d="M4 21V8l8-5 8 5v13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <line x1="9" y1="21" x2="9" y2="12" stroke="currentColor" stroke-width="2"/>
                <line x1="15" y1="21" x2="15" y2="12" stroke="currentColor" stroke-width="2"/>
            </svg>
            <span class="admin-nav-text">Departments</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                <rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
            </svg>
            <span class="admin-nav-text">Categories</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                <path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="18" cy="7" r="3" stroke="currentColor" stroke-width="2"/>
            </svg>
            <span class="admin-nav-text">Users</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6l-8-4z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="admin-nav-text">Roles &amp; Permissions</span>
        </a>

        {{-- ANALYTICS --}}
        <div class="admin-section-label">Analytics</div>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <path d="M21.21 15.89A10 10 0 1 1 8 2.83" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M22 12A10 10 0 0 0 12 2v10z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="admin-nav-text">Analytics</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <line x1="18" y1="20" x2="18" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="12" y1="20" x2="12" y2="4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="6" y1="20" x2="6" y2="14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="admin-nav-text">Reports Overview</span>
        </a>

        {{-- SYSTEM --}}
        <div class="admin-section-label">System</div>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" stroke="currentColor" stroke-width="2"/>
            </svg>
            <span class="admin-nav-text">Settings</span>
        </a>
        <a href="#" class="admin-nav-item">
            <svg class="admin-nav-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="admin-nav-text">Help &amp; Support</span>
        </a>
    </nav>

    {{-- Emergency Contacts --}}
    <a href="#" class="admin-emergency">
        <div class="admin-emergency-icon">
            <svg viewBox="0 0 24 24" fill="none" width="18" height="18">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" fill="white"/>
            </svg>
        </div>
        <div class="admin-emergency-text">
            <span class="admin-emergency-title">Emergency Contacts</span>
            <span class="admin-emergency-sub">Quick access to important numbers</span>
        </div>
        <svg class="admin-emergency-arrow" viewBox="0 0 24 24" fill="none" width="14" height="14">
            <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
</aside>