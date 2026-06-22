{{-- resources/views/layouts/admin.blade.php
Layout shell for the Super Admin dashboard.
Includes the dark sidebar + light topbar. --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicPulse Admin – @yield('title', 'Dashboard')</title>
    <style>
        /* ─── Reset & Base ─────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F1F3F7;
            color: #111827;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        a {
            color: inherit;
        }

        /* ═══════════════════ SIDEBAR (dark) ═══════════════════ */
        .admin-sidebar {
            width: 266px;
            min-width: 266px;
            background: #0B1120;
            color: #CBD5E1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            transition: width .2s, min-width .2s;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 20px 20px;
        }

        .admin-logo-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .admin-logo-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-logo-name {
            font-weight: 800;
            font-size: 17px;
            color: #fff;
            line-height: 1.2;
        }

        .admin-logo-sub {
            font-size: 10.5px;
            color: #64748B;
            white-space: nowrap;
        }

        .admin-nav-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 6px 14px 10px;
        }

        .admin-nav-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .admin-nav-scroll::-webkit-scrollbar-thumb {
            background: #1E293B;
            border-radius: 3px;
        }

        .admin-section-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #475569;
            letter-spacing: .08em;
            padding: 16px 10px 8px;
        }

        .admin-section-label:first-child {
            padding-top: 4px;
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: #94A3B8;
            text-decoration: none;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
        }

        .admin-nav-item:hover {
            background: #161E2E;
            color: #E2E8F0;
        }

        .admin-nav-item.active {
            background: #1D4ED8;
            color: #fff;
        }

        .admin-nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .admin-emergency {
            margin: 12px 14px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 14px;
            background: #1A1029;
            border: 1px solid #3B1530;
            border-radius: 10px;
            cursor: pointer;
            transition: background .15s;
        }

        .admin-emergency:hover {
            background: #211134;
        }

        .admin-emergency-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #EF4444;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .admin-emergency-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-emergency-title {
            font-size: 12.5px;
            font-weight: 700;
            color: #F1F5F9;
        }

        .admin-emergency-sub {
            font-size: 10.5px;
            color: #94A3B8;
            line-height: 1.4;
            margin-top: 1px;
        }

        .admin-emergency-arrow {
            color: #64748B;
            flex-shrink: 0;
        }

        /* ═══════════════════ MAIN AREA ═══════════════════ */
        .admin-main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ═══════════════════ TOPBAR ═══════════════════ */
        .admin-topbar {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 0 28px;
            height: 72px;
            min-height: 72px;
            background: #fff;
            border-bottom: 1px solid #E5E7EB;
            margin-left: 260px;
        }

        .admin-hamburger {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            transition: background .15s;
            flex-shrink: 0;
        }

        .admin-hamburger:hover {
            background: #F3F4F6;
        }

        .admin-search-wrapper {
            position: relative;
            flex: 1;
            max-width: 460px;
            display: flex;
            align-items: center;
        }

        .admin-search-input {
            width: 100%;
            padding: 11px 48px 11px 18px;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            font-size: 13.5px;
            color: #374151;
            outline: none;
        }

        .admin-search-input::placeholder {
            color: #9CA3AF;
        }

        .admin-search-input:focus {
            border-color: #9CA3AF;
            background: #fff;
        }

        .admin-search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #111827;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
        }

        .admin-search-btn:hover {
            background: #1F2937;
        }

        .admin-topbar-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-left: auto;
        }

        .admin-notif-btn {
            position: relative;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: background .15s;
        }

        .admin-notif-btn:hover {
            background: #F3F4F6;
        }

        .admin-notif-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #EF4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid #fff;
        }

        .admin-topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .admin-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .admin-user-meta {
            display: flex;
            flex-direction: column;
        }

        .admin-user-name {
            font-size: 13.5px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }

        .admin-user-role {
            font-size: 11.5px;
            color: #6B7280;
        }

        /* ═══════════════════ PAGE CONTENT ═══════════════════ */
        .admin-page-content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 28px 40px;

            margin-left: 280px;
            /* same as sidebar width */
            
           
        }

        /* Collapsed sidebar state (toggled by JS) */
        .admin-sidebar.collapsed {
            width: 0;
            min-width: 0;
            overflow: hidden;
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('components.sidebar-admin')

    <div class="admin-main-wrapper">
        @include('components.navbar-admin')
        <main class="admin-page-content">
            @yield('content')
        </main>
    </div>

    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            document.querySelector('.admin-sidebar')?.classList.toggle('collapsed');
        });
    </script>
    @stack('scripts')
</body>

</html>