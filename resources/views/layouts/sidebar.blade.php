{{-- resources/views/components/sidebar.blade.php --}}
<aside class="sidebar">
    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="logo-icon">
            <svg class="logo-svg" width="100" height="100" viewBox="0 0 100 100">

    <rect width="100" height="100" rx="20" fill="#2563EB"/>

    <path
        class="heartbeat"
        pathLength="100"
        d="M20 50 L35 50 L42 35 L52 65 L62 50 L80 50"
        stroke="white"
        stroke-width="5"
        fill="none"
    />

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
        
        
    </nav>

    

    {{-- User Profile at Bottom --}}
    <div class="emergency-content">
        <button class="bg-danger text-white rounded " onclick="emergency()"
            style="height: 50px; width: 200px; border: none; margin-left: 5px; color: white; background-color: black; font-weight: 700; border-radius: 6px; margin-top: 580px; cursor: pointer;"
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
                         Emergency Contact Directory
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