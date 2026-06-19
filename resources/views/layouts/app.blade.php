{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicPulse – @yield('title', 'Dashboard')</title>
    <style>
        /* ─── Reset & Base ─────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F3F4F6;
            color: #111827;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ─── Sidebar ───────────────────────────────────────────── */
        .sidebar {
            width: 220px;
            min-width: 220px;
            background: #fff;
            border-right: 1px solid #E5E7EB;
            display: flex;
            flex-direction: column;
            padding: 20px 0 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 18px 24px;
            border-bottom: 1px solid #F3F4F6;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: #1D4ED8;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-name {
            font-weight: 700;
            font-size: 14px;
            color: #111827;
            line-height: 1.2;
        }

        .logo-sub {
            font-size: 11px;
            color: #6B7280;
        }

        .sidebar-nav {
            padding: 12px 10px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            transition: background .15s, color .15s;
        }

        .nav-item:hover {
            background: #F3F4F6;
        }

        .nav-item.active {
            background: #EFF6FF;
            color: #1D4ED8;
        }

        .nav-item.active .nav-icon {
            color: #1D4ED8;
        }

        .nav-item-inner {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            color: #6B7280;
            flex-shrink: 0;
        }

        .nav-item.active .nav-icon {
            color: #1D4ED8;
        }

        .badge {
            margin-left: auto;
            background: #EF4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 600;
            color: #9CA3AF;
            letter-spacing: .06em;
            padding: 8px 20px 0;
        }

        .sidebar-user {
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-top: 1px solid #F3F4F6;
            cursor: pointer;
        }

        .user-avatar-sm {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .user-name-sm {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        .user-id {
            font-size: 11px;
            color: #9CA3AF;
        }

        .chevron-icon {
            width: 16px;
            height: 16px;
            color: #9CA3AF;
        }

        /* ─── Main Layout ───────────────────────────────────────── */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ─── Topbar ────────────────────────────────────────────── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            height: 60px;
            min-height: 60px;
            background: #fff;
            border-bottom: 1px solid #E5E7EB;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 480px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            font-size: 13.5px;
            color: #374151;
            outline: none;
        }

        .search-input::placeholder {
            color: #9CA3AF;
        }

        .search-input:focus {
            border-color: #93C5FD;
            background: #fff;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notif-btn,
        .settings-btn {
            position: relative;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: background .15s;
        }

        .notif-btn:hover,
        .settings-btn:hover {
            background: #F3F4F6;
        }

        .notif-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #EF4444;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            min-width: 16px;
            height: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-meta {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 13.5px;
            font-weight: 600;
            color: #111827;
        }

        .user-role {
            font-size: 11px;
            color: #6B7280;
        }

        /* ─── Page Content ──────────────────────────────────────── */
        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 28px 28px 28px;
        }

        .heartbeat{
    stroke-dasharray:100;
    stroke-dashoffset:100;
    animation:heartbeatLine 2s linear infinite;
}

@keyframes heartbeatLine{
    0%{
        stroke-dashoffset:100;
    }

    40%{
        stroke-dashoffset:0;
    }

    100%{
        stroke-dashoffset:0;
    }
}

        #page-loader {
            position: fixed;
            inset: 0;
            background: white;
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            inset: 0;
            background: white;
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;

            opacity: 1;
            transition: opacity .3s ease;
        }

        .loader-logo {
            text-align: center;
        }

        .loader-text {
            margin-top: 15px;
            font-size: 20px;
            font-weight: 600;
            color: #2563EB;
        }

.logo-svg{
    transform-origin:center center;
    animation:heartBeatLogo 2s ease-in-out infinite;
}

@keyframes heartBeatLogo{

    0%,100%{
        transform:scale(1);
    }

    15%{
        transform:scale(1.15);
    }

    25%{
        transform:scale(1);
    }

    35%{
        transform:scale(1.12);
    }

    50%,100%{
        transform:scale(1);
    }
}
    </style>
    @stack('styles')
</head>

<body>

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    <div class="main-wrapper">
        {{-- Navbar --}}
        @include('layouts.navigation')

        {{-- Main Content --}}
        <main class="page-content">
            @yield('content')
        </main>
    </div>


    <div id="page-loader">
        <div class="loader-logo">

            {{-- Your CivicPulse SVG --}}
            <svg width="100" height="100" viewBox="0 0 100 100">
                <rect width="100" height="100" rx="20" fill="#2563EB" class="logo-svg"/>

                <path class="heartbeat" d="M20 50 L35 50 L42 35 L52 65 L62 50 L80 50" stroke="white" stroke-width="5"
                    fill="none" />
            </svg>

            <div class="loader-text">
                CivicPulse
            </div>

        </div>
    </div>

    @stack('scripts')
</body>

<script>
    window.addEventListener('load', () => {

    const loader = document.getElementById('page-loader');

    setTimeout(() => {

        loader.style.opacity = '0';

        setTimeout(() => {
            loader.style.display = 'none';
        }, 300);

    }, 2000);

});



    document.querySelectorAll('a').forEach(link => {

    link.addEventListener('click', function(e) {

        if (
            this.href &&
            !this.href.includes('#') &&
            this.target !== '_blank'
        ) {
            e.preventDefault();

            const loader = document.getElementById('page-loader');

            loader.style.display = 'flex';
            loader.style.opacity = '1';

            setTimeout(() => {
                window.location.href = this.href;
            }, 600);
        }

    });

});
</script>

</html>