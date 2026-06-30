<x-guest-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Full page deep blue background wrapper */
        .page-wrapper {
            background-color: #0d255c; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 40px 20px;
        }

        /* Combined two-column card layout */
        .main-container {
            max-width: 1050px;
            width: 100%;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            margin: auto;
        }

        /* Left Sidebar Styling */
        .sidebar-panel {
            background: linear-gradient(180deg, #e0ecff 0%, #badaff 100%);
            padding: 48px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 580px;
        }

        /* Subtle vector city background placement */
        .sidebar-panel::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            /* Replace with your local cityscape SVG path if needed */
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" fill="%2394c2fc" opacity="0.5"><path d="M0,224L120,208C240,192,480,160,720,160C960,160,1200,192,1320,208L1440,224L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>') bottom center no-repeat;
            background-size: cover;
            pointer-events: none;
            z-index: 1;
        }

        .sidebar-content {
            position: relative;
            z-index: 2;
        }

        .brand-logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .brand-icon {
            background-color: #1a56db;
            color: white;
            padding: 10px;
            border-radius: 10px;
            font-size: 20px;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 700;
            color: #0b255c;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 13px;
            color: #6b7280;
        }

        .hero-headline {
            font-weight: 700;
            color: #0b255c;
            font-size: 32px;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .hero-headline span {
            color: #1a56db;
        }

        .hero-desc {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 40px;
        }

        /* Features List Styling */
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }

        .feat-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .feat-blue { background-color: #dbeafe; color: #1e40af; }
        .feat-green { background-color: #d1fae5; color: #065f46; }
        .feat-purple { background-color: #f3e8ff; color: #5b21b6; }

        .feat-title {
            font-weight: 700;
            color: #1f2937;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .feat-text {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.4;
        }

        /* Right Side Form Panel */
        .form-panel {
            padding: 50px;
            background: #ffffff;
        }

        .inner-auth-card {
            border: 1px solid #f0f2f5;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            background: #ffffff;
        }

        /* Form Tab Navigation */
        .auth-tabs {
            display: flex;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 16px;
            cursor: pointer;
            font-weight: 600;
            color: #64748b;
            border: none;
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
        }

        .auth-tab.active {
            color: #1a56db;
            background-color: #ffffff;
            font-weight: 700;
            border-bottom: 2px solid #1a56db;
        }

        .form-body-padding {
            padding: 40px;
        }

        .form-control-wrapper {
            position: relative;
        }

        .form-icon-left {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .form-input-custom {
            padding: 14px 16px 14px 45px !important;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            color: #334155;
        }

        .form-input-custom:focus {
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15);
        }

        .password-toggle-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
        }

        .btn-login-custom {
            background-color: #1a56db;
            color: white;
            font-weight: 600;
            padding: 14px;
            border-radius: 10px;
            border: none;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s ease;
        }

        .btn-login-custom:hover {
            background-color: #154ec1;
            color: white;
        }

        .divider-text {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            margin: 24px 0;
        }

        .divider-text::before, .divider-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider-text:not(:empty)::before { margin-right: .5em; }
        .divider-text:not(:empty)::after { margin-left: .5em; }

        /* Footer links styling */
        .footer-area {
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            margin-top: 30px;
            width: 100%;
            max-width: 1050px;
        }

        .footer-area a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            margin-left: 20px;
        }

        .footer-area a:hover {
            color: #ffffff;
        }
    </style>

    <div class="page-wrapper">
        
        <div class="main-container">
            <div class="row g-0">
                
                <div class="col-lg-5 sidebar-panel">
                    <div class="sidebar-content">
                        <div class="brand-logo-area">
                            <div class="brand-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <div class="brand-title">CivicPulse</div>
                                <div class="brand-subtitle">Civic Issue Reporting Platform</div>
                            </div>
                        </div>

                        <h1 class="hero-headline">Together, Let's Build a <span>Better Community</span></h1>
                        <p class="hero-desc">Report civic issues, track progress, and help create a cleaner, safer and better tomorrow for everyone.</p>

                        <div class="feature-item">
                            <div class="feat-icon-box feat-blue">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>
                            <div>
                                <div class="feat-title">Report Issues</div>
                                <div class="feat-text">Easily report civic problems in your area</div>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="feat-icon-box feat-green">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <div class="feat-title">Track Progress</div>
                                <div class="feat-text">Track the real-time status of your reports</div>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="feat-icon-box feat-purple">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <div class="feat-title">Stronger Community</div>
                                <div class="feat-text">Your voice helps build a better tomorrow</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 form-panel d-flex flex-column justify-content-center">
                    <div class="inner-auth-card">
                        
                        <div class="auth-tabs">
                            <button type="button" class="auth-tab active" id="citizenTab">
                                <i class="fa-regular fa-user"></i> Citizen
                            </button>
                            <button type="button" class="auth-tab" id="adminTab">
                                <i class="fa-solid fa-shield-heart"></i> Administration
                            </button>
                        </div>

                        <div class="form-body-padding">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-dark mb-1">Welcome Back!</h3>
                                <p class="text-muted small">Login to your account to continue</p>
                            </div>

                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="login_type" id="loginType" value="citizen">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                                    <div class="form-control-wrapper">
                                        <i class="fa-regular fa-envelope form-icon-left"></i>
                                        <input class="form-control form-input-custom" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required autofocus>
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-secondary small">Password</label>
                                    <div class="form-control-wrapper">
                                        <i class="fa-solid fa-lock form-icon-left"></i>
                                        <input id="password" class="form-control form-input-custom" type="password" name="password" placeholder="Enter your password" required>
                                        <i class="fa-regular fa-eye password-toggle-icon" onclick="togglePassword()" id="togglePasswordIcon"></i>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                        <label class="form-check-label text-secondary small" for="remember_me">Remember Me</label>
                                    </div>
                                    @if(Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold" style="color: #1a56db;">Forgot Password?</a>
                                    @endif
                                </div>

                                <button type="submit" class="btn-login-custom">
                                    <i class="fa-solid fa-lock-open small"></i> Login
                                </button>

                                @if(Route::has('register'))
                                    <div class="divider-text">OR</div>
                                    <div class="text-center small text-secondary">
                                        Don't have an account? 
                                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none ms-1" style="color: #1a56db;">
                                            Register Now <i class="fa-solid fa-angle-right small ms-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-area d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-2 mb-md-0">
                <i class="fa-solid fa-shield-halved me-1"></i> CivicPulse &copy; {{ date('Y') }} All rights reserved.
            </div>
            <div>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>

    </div>

    <script>
        const citizen = document.getElementById('citizenTab');
        const admin = document.getElementById('adminTab');
        const loginType = document.getElementById('loginType');

        citizen.onclick = () => {
            citizen.classList.add('active');
            admin.classList.remove('active');
            loginType.value = 'citizen';
        };

        admin.onclick = () => {
            admin.classList.add('active');
            citizen.classList.remove('active');
            loginType.value = 'admin';
        };

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-regular', 'fa-eye');
                toggleIcon.classList.add('fa-solid', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-solid', 'fa-eye-slash');
                toggleIcon.classList.add('fa-regular', 'fa-eye');
            }
        }
    </script>
</x-guest-layout>