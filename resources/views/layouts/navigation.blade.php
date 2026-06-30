<header class="admin-topbar d-flex justify-content-between align-items-center w-100">

    {{-- Search Block Container --}}
    <div class="admin-search-wrapper">
        <div class="input-group">
            <input type="text" class="form-control admin-search-input" placeholder="Search reports, officers, departments..." aria-label="Search">
            <button class="btn admin-search-btn" type="button">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>

    {{-- User Navigation Actions --}}
    <div class="admin-topbar-actions d-flex align-items-center">

        {{-- Dropdown Wrapper --}}
        <div class="position-relative">
            <button class="btn admin-topbar-user-btn d-flex align-items-center gap-3" type="button" id="profileDropdownBtn">
                
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="admin-user-avatar" alt="{{ Auth::user()->name }}">
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="d-none d-sm-flex flex-column text-start">
                    <span class="fw-semibold text-dark lh-sm" style="font-size: 14px;">{{ Auth::user()->name }}</span>
                    <span class="text-muted small mt-0.5" style="font-size: 12px;">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</span>
                </div>

                <i class="fa-solid fa-chevron-down text-secondary ms-1 small d-none d-sm-inline-block"></i>
            </button>

            {{-- Custom Dropdown Menu Container --}}
            <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu mt-2 position-absolute" id="profileDropdownMenu" style="right: 0; display: none;">
                
                <li class="px-4 py-3 border-bottom d-flex align-items-center gap-3">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="rounded-circle object-fit-cover" width="48" height="48">
                    @else
                        <div class="dropdown-avatar-placeholder">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="d-flex flex-column">
                        <span class="fw-bold text-dark lh-sm">{{ Auth::user()->name }}</span>
                        <span class="text-muted small">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</span>
                    </div>
                </li>

                <li>
                    <a class="dropdown-item custom-dropdown-item mt-1" href="{{ route('profile.edit') }}">
                        <i class="fa-regular fa-user text-secondary"></i> My Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item custom-dropdown-item" href="#">
                        <i class="fa-solid fa-gear text-secondary"></i> Settings
                    </a>
                </li>
                
                <li><hr class="dropdown-divider my-1 text-black-50"></li>

                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item custom-dropdown-item custom-logout-item fw-semibold w-100 text-start border-0 bg-transparent">
                            <i class="fa-solid fa-door-open"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</header>

<style>
    .admin-topbar {
        background-color: transparent;
        padding: 15px 0;
    }

    .admin-search-wrapper {
        max-width: 450px;
        width: 100%;
    }

    .admin-search-input {
        border: 1px solid #cbd5e1;
        border-radius: 10px 0 0 10px !important;
        padding: 11px 16px;
        font-size: 14px;
        background-color: #ffffff;
    }

    .admin-search-input:focus {
        border-color: #1a56db;
        box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.1);
    }

    .admin-search-btn {
        background-color: #1a56db;
        border: 1px solid #1a56db;
        border-radius: 0 10px 10px 0 !important;
        padding: 0 20px;
        color: #ffffff;
        transition: background-color 0.15s ease;
    }

    .admin-search-btn:hover {
        background-color: #154ec1;
        border-color: #154ec1;
    }

    .admin-topbar-user-btn {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 6px 16px 6px 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }

    .admin-topbar-user-btn:hover, 
    .admin-topbar-user-btn:focus {
        background-color: #f8fafc;
        border-color: #e2e8f0;
    }

    .admin-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #1a56db;
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
    }

    .dropdown-avatar-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #1a56db;
        color: #ffffff;
        font-weight: 700;
        font-size: 18px;
    }

    .custom-dropdown-menu {
        border: none;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        min-width: 250px;
        padding: 8px 0;
        z-index: 1050;
    }

    .custom-dropdown-item {
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .custom-dropdown-item:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }

    .custom-logout-item {
        color: #dc2626;
    }

    .custom-logout-item:hover {
        background-color: #fef2f2 !important;
        color: #991b1b !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownBtn = document.getElementById('profileDropdownBtn');
        const dropdownMenu = document.getElementById('profileDropdownMenu');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isDisplayed = dropdownMenu.style.display === 'block';
                dropdownMenu.style.display = isDisplayed ? 'none' : 'block';
            });

            document.addEventListener('click', function () {
                dropdownMenu.style.display = 'none';
            });

            dropdownMenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    });
</script>