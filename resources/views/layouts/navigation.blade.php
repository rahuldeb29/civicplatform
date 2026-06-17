{{-- resources/views/components/navbar.blade.php --}}
<header class="topbar">
    {{-- Search --}}
    <div class="search-wrapper">
        <svg class="search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2" />
            <path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" />
        </svg>
        <input type="text" class="search-input" placeholder="Search report ID, department, or street name...">
    </div>

    {{-- Right Actions --}}
    <div class="topbar-actions">
        {{-- Notifications --}}
        <div class="notif-btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path d="M18 8A6 6 0 1 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="#374151" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="#374151" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="notif-badge">9</span>
        </div>

        {{-- Settings --}}
        <div class="settings-btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <circle cx="12" cy="12" r="3" stroke="#374151" stroke-width="2" />
                <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"
                    stroke="#374151" stroke-width="2" />
            </svg>
        </div>

        {{-- User --}}
        <div class="topbar-user">
            <img src="{{ Auth::user()->profile_image
    ? asset('storage/' . Auth::user()->profile_image)
    : asset('images/default-user.png') }}" alt="Profile Image" class="rounded-circle" width="40" height="40">

            <div class="user-meta">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role">Citizen</span>
            </div>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                <path d="M6 9l6 6 6-6" stroke="#374151" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                this.closest('form').submit();">

                    Logout

                </x-dropdown-link>
            </form>
        </div>
    </div>
</header>