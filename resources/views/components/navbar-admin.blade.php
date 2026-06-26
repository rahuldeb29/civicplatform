<header class="admin-topbar">

    {{-- Search --}}
    <div class="admin-search-wrapper">
        <input
            type="text"
            class="admin-search-input"
            placeholder="Search reports, officers, departments..."
        >

        <button class="admin-search-btn" type="button">
            <svg viewBox="0 0 24 24" fill="none" width="17" height="17">
                <circle cx="11" cy="11" r="8" stroke="#fff" stroke-width="2"/>
                <path d="M21 21L16.65 16.65"
                      stroke="#fff"
                      stroke-width="2"
                      stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    <div class="admin-topbar-actions">

        {{-- Notifications --}}
        <button class="notification-btn">
            🔔
        </button>

        {{-- User Dropdown --}}
        <div class="user-dropdown">

            <button
                class="admin-topbar-user"
                id="profileDropdownBtn"
                type="button"
            >

                @if(Auth::user()->profile_image)

                    <img
                        src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                        class="admin-user-avatar"
                        alt="{{ Auth::user()->name }}"
                    >

                @else

                    <div class="admin-user-avatar avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </div>

                @endif

                <div class="admin-user-meta">

                    <span class="admin-user-name">
                        {{ Auth::user()->name }}
                    </span>

                    <span class="admin-user-role">
                        {{ ucwords(str_replace('_',' ',Auth::user()->role)) }}
                    </span>

                </div>

                <svg
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                >
                    <path
                        d="M6 9l6 6 6-6"
                        stroke="#374151"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

            </button>

            {{-- Dropdown --}}
            <div class="dropdown-menu" id="profileDropdown">

                <div class="dropdown-header">

                    @if(Auth::user()->profile_image)

                        <img
                            src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                            class="dropdown-avatar"
                        >

                    @else

                        <div class="dropdown-avatar avatar-placeholder">
                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                        </div>

                    @endif

                    <div>

                        <div class="dropdown-name">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="dropdown-role">
                            {{ ucwords(str_replace('_',' ',Auth::user()->role)) }}
                        </div>

                    </div>

                </div>

                <a href="{{ route('profile.edit') }}" class="dropdown-item">

                    👤 My Profile

                </a>

                <a href="#" class="dropdown-item">

                    ⚙️ Settings

                </a>

                <hr>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="dropdown-item logout-item"
                    >
                        🚪 Logout
                    </button>

                </form>

            </div>

        </div>

    </div>

</header>

<style>

.admin-topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.admin-topbar-actions{
    display:flex;
    align-items:center;
    gap:20px;
}

.notification-btn{
    width:42px;
    height:42px;
    border:none;
    border-radius:50%;
    background:#fff;
    cursor:pointer;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    font-size:18px;
}

.user-dropdown{
    position:relative;
}

.admin-topbar-user{

    display:flex;
    align-items:center;
    gap:12px;
    background:white;
    border:none;
    border-radius:12px;
    padding:8px 14px;
    cursor:pointer;
    box-shadow:0 5px 15px rgba(0,0,0,.08);

}

.admin-user-avatar{

    width:42px;
    height:42px;
    border-radius:50%;
    object-fit:cover;

}

.avatar-placeholder{

    display:flex;
    align-items:center;
    justify-content:center;
    background:#2563EB;
    color:white;
    font-weight:bold;

}

.admin-user-meta{

    display:flex;
    flex-direction:column;
    text-align:left;

}

.admin-user-name{

    font-weight:600;
    color:#111827;

}

.admin-user-role{

    font-size:13px;
    color:#6B7280;

}

.dropdown-menu{

    position:absolute;
    right:0;
    top:65px;

    width:260px;

    background:white;

    border-radius:15px;

    box-shadow:0 15px 35px rgba(0,0,0,.12);

    display:none;

    overflow:hidden;

    z-index:1000;

}

.dropdown-menu.show{

    display:block;

}

.dropdown-header{

    display:flex;
    align-items:center;
    gap:12px;

    padding:18px;

    border-bottom:1px solid #eee;

}

.dropdown-avatar{

    width:52px;
    height:52px;
    border-radius:50%;
    object-fit:cover;

}

.dropdown-name{

    font-weight:700;
    color:#111827;

}

.dropdown-role{

    font-size:13px;
    color:#6B7280;

}

.dropdown-item{

    display:block;

    width:100%;

    padding:14px 20px;

    text-decoration:none;

    color:#374151;

    background:white;

    border:none;

    text-align:left;

    cursor:pointer;

    font-size:15px;

    transition:.25s;

}

.dropdown-item:hover{

    background:#F3F4F6;

}

.logout-item{

    color:#DC2626;
    font-weight:600;

}

.logout-item:hover{

    background:#FEE2E2;

}

</style>

<script>

const btn = document.getElementById('profileDropdownBtn');

const menu = document.getElementById('profileDropdown');

btn.addEventListener('click', function(e){

    e.stopPropagation();

    menu.classList.toggle('show');

});

document.addEventListener('click', function(){

    menu.classList.remove('show');

});

menu.addEventListener('click', function(e){

    e.stopPropagation();

});

</script>