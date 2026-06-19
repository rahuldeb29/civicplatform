{{-- resources/views/components/sidebar.blade.php --}}
<aside class="sidebar">
    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="logo-icon">
            <svg width="34" height="34" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">

                <!-- Background -->
                <rect width="64" height="64" rx="14" fill="#1D4ED8" />

                <!-- Location Pin -->
                <path
                    d="M32 14C24.82 14 19 19.82 19 27C19 37.5 32 50 32 50C32 50 45 37.5 45 27C45 19.82 39.18 14 32 14Z"
                    fill="white" />

                <!-- Pulse Line -->
                <path d="M23 31H28L31 25L34 36L37 29H41" stroke="#1D4ED8" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round" />

            </svg>
        </div>
        <div class="logo-text">
            <span class="logo-name">CivicPulse</span>
            <span class="logo-sub">City Governance</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" onclick="window.location='{{ route('dashboard') }}'"
            class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="cursor: pointer">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="3" width="7" height="7" rx="1" fill="currentColor" />
                <rect x="14" y="3" width="7" height="7" rx="1" fill="currentColor" />
                <rect x="3" y="14" width="7" height="7" rx="1" fill="currentColor" />
                <rect x="14" y="14" width="7" height="7" rx="1" fill="currentColor" />
            </svg>
            Dashboard
        </a>
        <a href="{{ route('submit') }}" onclick="window.location='{{ route('submit') }}'"
            class="nav-item {{ request()->routeIs('submit') ? 'active' : '' }}" style="cursor: pointer">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <line x1="12" y1="12" x2="15" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <line x1="12" y1="6" x2="12" y2="6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
            </svg>
            Submit Report
        </a>
        <a href="#" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2" />
                <line x1="8" y1="9" x2="16" y2="9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <line x1="8" y1="15" x2="12" y2="15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            My Reports
        </a>
        <a href="#" class="nav-item">
            <div class="nav-item-inner">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8A6 6 0 1 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                </svg>
                Notifications
                <span class="badge">7</span>
            </div>
        </a>
        <a href="#" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="18" y1="20" x2="18" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <line x1="12" y1="20" x2="12" y2="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <line x1="6" y1="20" x2="6" y2="14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Analytics
        </a>
    </nav>

    {{-- Preferences --}}
    <div class="sidebar-section-label">PREFERENCES</div>
    <nav class="sidebar-nav">
        <a href="#" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"
                    stroke="currentColor" stroke-width="2" />
            </svg>
            Settings
        </a>
        <a href="#" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" />
            </svg>
            Help & Support
        </a>
    </nav>

    {{-- User Profile at Bottom --}}
    <div class="emergency-content">
        <button class="bg-danger text-white rounded " onclick="emergency()"
            style="height: 50px; width: 200px; border: none; margin-left: 5px; color: white; background-color: black; font-weight: 700; border-radius: 6px; margin-top: 360px; cursor: pointer;"
            data-bs-toggle="modal" data-bs-target="#emergencyModal">Emergency
            Contact</button>
    </div>
    <div class="sidebar-user">
        <img src="{{ Auth::user()->profile_image
    ? asset('storage/' . Auth::user()->profile_image)
    : asset('images/default-user.png') }}" alt="Profile Image" class="rounded-circle" width="40" height="40">
        <div class="user-info">
            <span class="user-name-sm">{{ Auth::user()->name }}</span>
            <span class="user-id">Resident ID: 133</span>
        </div>
        <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div>


    {{-- Pop-Up Model for Emergency Contact Details --}}

    <div class="modal fade" id="emergencyModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        🚨 Emergency Contact Directory
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</aside>