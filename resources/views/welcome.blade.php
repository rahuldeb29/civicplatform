<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicConnect | Modern Issue Reporting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        secondary: '#3B82F6',
                        accent: '#60A5FA',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                }
            }
        }
    </script>

    <style>
        /* Glassmorphism utilities */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        /* Reveal animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Custom gradient text */
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #2563EB, #06B6D4);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased overflow-x-hidden">

    {{-- Mock Data (Usually passed from a Controller) --}}
    @php
        $navLinks = ['Home', 'Features', 'How It Works', 'Departments', 'Statistics', 'Testimonials'];
        
        $features = [
            ['title' => 'Citizen Reporting', 'desc' => 'Upload images, auto-capture GPS location, and track live status.', 'icon' => 'smartphone'],
            ['title' => 'Smart Dashboard', 'desc' => 'Advanced analytics, charts, and notifications for quick insights.', 'icon' => 'layout-dashboard'],
            ['title' => 'Department Management', 'desc' => 'Assign officers, track workload, and manage departmental efficiency.', 'icon' => 'building-2'],
            ['title' => 'Real-time Tracking', 'desc' => 'Visual timelines from submission to final resolution.', 'icon' => 'activity'],
            ['title' => 'Interactive Maps', 'desc' => 'Live report locations with marker clustering and status colors.', 'icon' => 'map'],
            ['title' => 'Secure Authentication', 'desc' => 'Role-based access for citizens, officers, and administrators.', 'icon' => 'shield-check'],
        ];

        $stats = [
            ['count' => '15842', 'label' => 'Reports Submitted', 'suffix' => '+'],
            ['count' => '98', 'label' => 'Resolution Rate', 'suffix' => '%'],
            ['count' => '67', 'label' => 'Departments Active', 'suffix' => ''],
            ['count' => '220', 'label' => 'Govt Officers', 'suffix' => ''],
        ];

        $departments = [
            ['name' => 'Roads & Infrastructure', 'reports' => 342, 'time' => '48h', 'progress' => 85, 'icon' => 'map-pin'],
            ['name' => 'Water Supply', 'reports' => 156, 'time' => '24h', 'progress' => 92, 'icon' => 'droplets'],
            ['name' => 'Electricity', 'reports' => 89, 'time' => '12h', 'progress' => 97, 'icon' => 'zap'],
            ['name' => 'Sanitation', 'reports' => 421, 'time' => '36h', 'progress' => 78, 'icon' => 'trash-2'],
        ];
    @endphp

    <nav id="navbar" class="fixed w-full z-50 transition-all duration-300 bg-transparent py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-xl text-white">
                    <i data-lucide="shield" class="w-6 h-6"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900" id="logo-text">CivicConnect</span>
            </div>
            
            <div class="hidden md:flex space-x-8 items-center">
                @foreach($navLinks as $link)
                    <a href="#{{ Str::slug($link) }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">{{ $link }}</a>
                @endforeach
            </div>

            <div class="hidden md:flex space-x-4 items-center">
                <a href="{{ route('login') ?? '#' }}" class="text-sm font-medium text-slate-600 hover:text-blue-600">Login</a>
                <a href="{{ route('register') ?? '#' }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-medium transition-all shadow-lg shadow-blue-200">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <div class="reveal">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold mb-6 border border-blue-100">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        SaaS Platform 2026
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-6">
                        Report Issues. <br>
                        <span class="text-gradient">Track Resolution.</span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 max-w-xl leading-relaxed">
                        Empower citizens to report infrastructure issues while enabling government departments to manage complaints efficiently through a centralized digital platform.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <button class="bg-primary text-white px-8 py-4 rounded-full font-medium hover:bg-slate-800 transition-all flex items-center justify-center gap-2 shadow-xl shadow-slate-200 hover:-translate-y-1">
                            Submit a Report <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                        <button class="bg-white text-slate-700 border border-slate-200 px-8 py-4 rounded-full font-medium hover:bg-slate-50 transition-all flex items-center justify-center shadow-sm">
                            Explore Platform
                        </button>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-6 border-t border-slate-200">
                        <div>
                            <p class="text-2xl font-bold text-slate-900">12k+</p>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Reports</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">94%</p>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Resolved</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">45</p>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Depts</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">24/7</p>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Uptime</p>
                        </div>
                    </div>
                </div>

                <div class="relative hidden lg:block reveal">
                    <div class="glass p-4 rounded-3xl shadow-2xl relative z-10 transform hover:-translate-y-2 transition-transform duration-500">
                        <div class="flex items-center justify-between mb-4 px-2">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="text-xs text-slate-400 font-medium">Dashboard Overview</div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Active Reports</p>
                                    <p class="text-lg font-bold">2,405</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                                <div class="bg-emerald-50 p-3 rounded-xl text-emerald-600">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Resolved Today</p>
                                    <p class="text-lg font-bold">184</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-slate-100 h-48 rounded-2xl mb-4 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Map" class="w-full h-full object-cover opacity-60">
                            <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-red-500 rounded-full border-2 border-white shadow-lg animate-bounce"></div>
                            <div class="absolute top-1/2 left-2/3 w-4 h-4 bg-yellow-500 rounded-full border-2 border-white shadow-lg"></div>
                            <div class="absolute bottom-1/3 right-1/4 w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-lg"></div>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-slate-100">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-semibold">Recent Complaints</span>
                                <span class="text-xs text-blue-600 cursor-pointer">View All</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                        <span class="font-medium">Pothole on Main St</span>
                                    </div>
                                    <span class="text-slate-500">10m ago</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                        <span class="font-medium">Streetlight Broken</span>
                                    </div>
                                    <span class="text-slate-500">1h ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-10 border-y border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap justify-center gap-12 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
            <span class="text-xl font-bold text-slate-800">MUNICIPAL CORP</span>
            <span class="text-xl font-bold text-slate-800">SMART CITY MISSION</span>
            <span class="text-xl font-bold text-slate-800">PUBLIC WORKS</span>
            <span class="text-xl font-bold text-slate-800">WATER AUTHORITY</span>
        </div>
    </section>

    <section id="features" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 reveal">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Complete Civic Management</h2>
                <p class="text-slate-600">A comprehensive suite of tools designed to connect citizens with government departments seamlessly.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($features as $feature)
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 reveal group">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <i data-lucide="{{ $feature['icon'] }}"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20 reveal">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">How It Works</h2>
                <p class="text-slate-600">Transparent routing from submission to resolution.</p>
            </div>

            <div class="relative reveal">
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 z-0"></div>
                <div class="hidden md:block absolute top-1/2 left-0 w-1/3 h-1 bg-blue-600 -translate-y-1/2 z-0"></div>
                
                <div class="grid md:grid-cols-4 gap-8 relative z-10">
                    {{-- Step 1 --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold ring-4 ring-white">1</div>
                        <h4 class="font-bold mb-2">Submit</h4>
                        <p class="text-sm text-slate-500">Citizen reports issue with GPS & photo.</p>
                    </div>
                    {{-- Step 2 --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold ring-4 ring-white">2</div>
                        <h4 class="font-bold mb-2">Assign</h4>
                        <p class="text-sm text-slate-500">AI routes to correct department & officer.</p>
                    </div>
                    {{-- Step 3 --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
                        <div class="w-10 h-10 bg-slate-200 text-slate-600 rounded-full flex items-center justify-center mx-auto mb-4 font-bold ring-4 ring-white">3</div>
                        <h4 class="font-bold mb-2">Resolve</h4>
                        <p class="text-sm text-slate-500">Officer tracks progress & updates status.</p>
                    </div>
                    {{-- Step 4 --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
                        <div class="w-10 h-10 bg-slate-200 text-slate-600 rounded-full flex items-center justify-center mx-auto mb-4 font-bold ring-4 ring-white">4</div>
                        <h4 class="font-bold mb-2">Feedback</h4>
                        <p class="text-sm text-slate-500">Citizen verifies completion & rates service.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="statistics" class="py-20 bg-primary text-white relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 rounded-full mix-blend-screen filter blur-3xl opacity-20"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 reveal">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach($stats as $stat)
                    <div class="p-6">
                        <h3 class="text-4xl lg:text-5xl font-bold mb-2 text-white">
                            <span class="counter" data-target="{{ $stat['count'] }}">0</span>{{ $stat['suffix'] }}
                        </h3>
                        <p class="text-blue-200 text-sm font-medium uppercase tracking-wider">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="departments" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12 reveal">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Department Showcase</h2>
                    <p class="text-slate-600">Track performance metrics across government sectors.</p>
                </div>
                <button class="hidden md:flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-700">
                    View All <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 reveal">
                @foreach($departments as $dept)
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-6">
                            <div class="p-3 bg-slate-50 rounded-xl text-slate-700">
                                <i data-lucide="{{ $dept['icon'] }}"></i>
                            </div>
                            <span class="text-xs font-semibold px-2 py-1 bg-green-50 text-green-600 rounded-full">{{ $dept['progress'] }}% Resolved</span>
                        </div>
                        <h3 class="font-bold text-lg mb-4">{{ $dept['name'] }}</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Active Reports</span>
                                <span class="font-semibold">{{ $dept['reports'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Avg. Resolution</span>
                                <span class="font-semibold">{{ $dept['time'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-cyan-500"></div>
        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center text-white reveal">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Help Build a Better City.</h2>
            <p class="text-xl text-blue-100 mb-10 leading-relaxed">
                Join thousands of citizens and proactive government officers making communities cleaner, safer, and more efficient.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') ?? '#' }}" class="bg-white text-blue-600 px-8 py-4 rounded-full font-bold hover:bg-slate-50 transition-all shadow-xl shadow-blue-900/20 hover:-translate-y-1">
                    Create Free Account
                </a>
                <button class="glass border border-white/30 text-white px-8 py-4 rounded-full font-bold hover:bg-white/10 transition-all">
                    Submit a Complaint
                </button>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-12 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="bg-blue-600 p-1.5 rounded-lg text-white">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                    </div>
                    <span class="text-lg font-bold text-white">CivicConnect</span>
                </div>
                <p class="text-sm">Modernizing civic issue management for smart cities and transparent governance.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-6">Platform</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-6">Departments</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Roads & Transport</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Water & Sanitation</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Electricity</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-6">Legal</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Contact Support</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} CivicConnect. All Rights Reserved.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-white"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                <a href="#" class="hover:text-white"><i data-lucide="github" class="w-4 h-4"></i></a>
                <a href="#" class="hover:text-white"><i data-lucide="linkedin" class="w-4 h-4"></i></a>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        const logoText = document.getElementById('logo-text');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('bg-white/80', 'backdrop-blur-md', 'shadow-sm', 'border-b', 'border-slate-100');
                navbar.classList.remove('bg-transparent', 'py-4');
                navbar.classList.add('py-3');
            } else {
                navbar.classList.remove('bg-white/80', 'backdrop-blur-md', 'shadow-sm', 'border-b', 'border-slate-100', 'py-3');
                navbar.classList.add('bg-transparent', 'py-4');
            }
        });

        // Intersection Observer for Reveal Animations
        const revealElements = document.querySelectorAll('.reveal');
        
        const revealOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const revealOnScroll = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    return;
                } else {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                    
                    // Trigger counter if element has counters
                    const counters = entry.target.querySelectorAll('.counter');
                    if (counters.length > 0) {
                        counters.forEach(counter => {
                            const target = +counter.getAttribute('data-target');
                            const duration = 2000; // ms
                            const increment = target / (duration / 16); // 60fps
                            
                            let current = 0;
                            const updateCounter = () => {
                                current += increment;
                                if (current < target) {
                                    counter.innerText = Math.ceil(current).toLocaleString();
                                    requestAnimationFrame(updateCounter);
                                } else {
                                    counter.innerText = target.toLocaleString();
                                }
                            };
                            updateCounter();
                        });
                    }
                }
            });
        }, revealOptions);

        revealElements.forEach(el => {
            revealOnScroll.observe(el);
        });
    </script>
</body>
</html>