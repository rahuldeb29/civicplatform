{{-- resources/views/components/navbar-admin.blade.php
     Topbar for the Super Admin dashboard. --}}

<header class="admin-topbar">
    {{-- Hamburger --}}
    <button class="admin-hamburger" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
        <svg viewBox="0 0 24 24" fill="none" width="22" height="22">
            <line x1="3" y1="6" x2="21" y2="6" stroke="#374151" stroke-width="2" stroke-linecap="round"/>
            <line x1="3" y1="12" x2="21" y2="12" stroke="#374151" stroke-width="2" stroke-linecap="round"/>
            <line x1="3" y1="18" x2="21" y2="18" stroke="#374151" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>

    {{-- Search --}}
    <div class="admin-search-wrapper">
        <input type="text" class="admin-search-input" placeholder="Search anything...">
        <button class="admin-search-btn" type="button" aria-label="Search">
            <svg viewBox="0 0 24 24" fill="none" width="17" height="17">
                <circle cx="11" cy="11" r="8" stroke="#fff" stroke-width="2"/>
                <path d="M21 21l-4.35-4.35" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    {{-- Right Actions --}}
    <div class="admin-topbar-actions">
        {{-- Notifications --}}
        <div class="admin-notif-btn">
            <svg viewBox="0 0 24 24" fill="none" width="21" height="21">
                <path d="M18 8A6 6 0 1 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="#111827" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="admin-notif-badge">12</span>
        </div>

        {{-- User --}}
        <div class="admin-topbar-user">
            <img src="https://i.pravatar.cc/40?img=33" alt="Admin" class="admin-user-avatar">
            <div class="admin-user-meta">
                <span class="admin-user-name">Admin</span>
                <span class="admin-user-role">Super Administrator</span>
            </div>
            <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                <path d="M6 9l6 6 6-6" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>
</header>