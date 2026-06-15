<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicPulse – @yield('title', 'Submit Report')</title>
    <style>
        /* ─── Reset & Base ─────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F3F4F6;
            color: #111827;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ─── Sidebar ──────────────────────────────────────── */
        .sidebar {
            width: 200px; min-width: 200px;
            background: #fff;
            border-right: 1px solid #E5E7EB;
            display: flex; flex-direction: column;
            padding: 20px 0 0;
            height: 100vh; overflow-y: auto;
        }

        .sidebar-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 0 16px 20px;
        }
        .logo-icon {
            width: 34px; height: 34px; background: #1D4ED8;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .logo-text { display: flex; flex-direction: column; }
        .logo-name { font-weight: 800; font-size: 13.5px; color: #111827; line-height: 1.2; }
        .logo-sub  { font-size: 10.5px; color: #9CA3AF; }

        .sidebar-nav { padding: 8px 10px; display: flex; flex-direction: column; gap: 1px; }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: #374151;
            text-decoration: none; transition: background .15s, color .15s;
        }
        .nav-item:hover { background: #F3F4F6; }
        .nav-item.active { background: #EFF6FF; color: #1D4ED8; }
        .nav-item.active .nav-icon { color: #1D4ED8; }

        .nav-icon { width: 17px; height: 17px; color: #9CA3AF; flex-shrink: 0; }
        .nav-item.active .nav-icon { color: #1D4ED8; }

        /* ─── Topbar ───────────────────────────────────────── */
        .main-wrapper {
            flex: 1; display: flex; flex-direction: column; overflow: hidden;
        }
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            height: 56px; min-height: 56px;
            background: #fff; border-bottom: 1px solid #E5E7EB;
        }
        .search-wrapper { position: relative; flex: 1; max-width: 360px; }
        .search-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            width: 15px; height: 15px; pointer-events: none;
        }
        .search-input {
            width: 100%; padding: 7px 12px 7px 33px;
            background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px;
            font-size: 13px; color: #374151; outline: none;
        }
        .search-input::placeholder { color: #B0B7C3; }
        .search-input:focus { border-color: #9CA3AF; background: #fff; }

        .topbar-actions { display: flex; align-items: center; gap: 14px; }

        .notif-btn {
            position: relative; width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; cursor: pointer; transition: background .15s;
        }
        .notif-btn:hover { background: #F3F4F6; }
        .notif-badge {
            position: absolute; top: 2px; right: 2px;
            background: #EF4444; color: #fff;
            font-size: 9px; font-weight: 700;
            min-width: 15px; height: 15px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; padding: 0 3px;
        }
        .topbar-user { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
        .user-meta { display: flex; flex-direction: column; }
        .user-name { font-size: 13px; font-weight: 700; color: #111827; line-height: 1.2; }
        .user-role { font-size: 11px; color: #9CA3AF; }

        /* ─── Page Content ─────────────────────────────────── */
        .page-content {
            flex: 1; overflow-y: auto;
            padding: 28px 32px;
            background: #F3F4F6;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('components.sidebar-submit')

    <div class="main-wrapper">
        @include('components.navbar-submit')
        <main class="page-content">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>