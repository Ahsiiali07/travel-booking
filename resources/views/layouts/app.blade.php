<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TravelBooking - Pakistan & Global Travel Portal') | VU CS619 Final Year Project</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;           /* Electric Indigo */
            --primary-dark: #3730a3;      /* Deep Royal Indigo */
            --primary-light: #eef2ff;     /* Soft Indigo Tint */
            --primary-hover: #4338ca;
            --accent: #06b6d4;            /* Vibrant Cyan */
            --accent-dark: #0891b2;
            --accent-gradient: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            --accent-gradient-hover: linear-gradient(135deg, #4338ca 0%, #0891b2 100%);
            --dark: #0b0f19;              /* Midnight Obsidian */
            --dark-card: #111827;
            --slate-border: #e2e8f0;
            --light-bg: #f8fafc;
            --card-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.07), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
            --card-shadow-hover: 0 20px 30px -10px rgba(79, 70, 229, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light-bg);
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Project Banner */
        .project-top-bar {
            background: linear-gradient(90deg, #090d16 0%, #1e1b4b 100%);
            font-size: 0.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Modern Navbar */
        .main-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 1px 15px rgba(0, 0, 0, 0.04);
            padding: 0.85rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.45rem;
            color: #0f172a !important;
            display: flex;
            align-items: center;
            gap: 0.55rem;
            letter-spacing: -0.02em;
        }

        .brand-icon-wrapper {
            width: 38px;
            height: 38px;
            background: var(--accent-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
            font-size: 1.05rem;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.92rem;
            color: #475569 !important;
            padding: 0.55rem 0.95rem !important;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background-color: var(--primary-light);
        }

        /* Modern Gradient Buttons */
        .btn-primary-custom {
            background: var(--accent-gradient);
            border: none;
            color: #ffffff !important;
            font-weight: 600;
            padding: 0.65rem 1.4rem;
            border-radius: 12px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
        }

        .btn-primary-custom:hover {
            background: var(--accent-gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
        }

        .btn-outline-custom {
            border: 1.5px solid var(--primary);
            color: var(--primary) !important;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.6rem 1.3rem;
            transition: all 0.2s;
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
        }

        /* Cards & Surfaces */
        .card-custom {
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: var(--card-shadow);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            overflow: hidden;
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(99, 102, 241, 0.4);
        }

        /* Color Badges */
        .badge-soft-primary { background: #eef2ff; color: #4f46e5; font-weight: 600; }
        .badge-soft-cyan    { background: #ecfeff; color: #0891b2; font-weight: 600; }
        .badge-soft-success { background: #ecfdf5; color: #059669; font-weight: 600; }
        .badge-soft-warning { background: #fffbeb; color: #d97706; font-weight: 600; }
        .badge-soft-danger  { background: #fef2f2; color: #dc2626; font-weight: 600; }

        /* Form Controls Overhaul */
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 0.65rem 0.95rem;
            font-size: 0.93rem;
            color: #1e293b;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
            outline: none;
        }

        /* Airport Search Styles */
        .airport-search-wrapper {
            position: relative;
        }

        .airport-input-group .form-control {
            border-radius: 0;
        }

        .airport-input-group .input-group-text:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .airport-input-group .airport-toggle-btn {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            background: #ffffff;
        }

        .airport-dropdown-menu {
            border-radius: 14px !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.05) !important;
        }

        .airport-option:hover {
            background-color: var(--primary-light) !important;
        }

        /* Footer */
        .footer {
            background: #090d16;
            color: #94a3b8;
            margin-top: auto;
            padding-top: 3.5rem;
            padding-bottom: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .footer h5 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 1.25rem;
            font-size: 1rem;
            letter-spacing: -0.01em;
        }

        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: #38bdf8;
        }

        .vu-project-badge {
            background: var(--accent-gradient);
            color: white;
            font-size: 0.75rem;
            padding: 0.4rem 0.85rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        /* Mobile Responsive Improvements */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #ffffff;
                padding: 1.25rem;
                border-radius: 16px;
                box-shadow: 0 15px 30px rgba(0,0,0,0.1);
                margin-top: 0.75rem;
                border: 1px solid var(--slate-border);
            }
            .nav-link {
                padding: 0.65rem 1rem !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Project Supervisor & Course Banner -->
    <div class="project-top-bar text-white py-1 px-3">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <span class="badge bg-primary text-uppercase me-2 font-monospace">VU CS619</span>
                <strong>Final Year Project:</strong> Travel Booking Application using MVC-based Framework (Laravel)
            </div>
            <div class="d-none d-md-block text-light opacity-90">
                <i class="fa-solid fa-user-tie me-1 text-info"></i> Supervisor: <strong>Sheikh Israr Ahmad</strong> (israr.ahmad@vu.edu.pk)
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="brand-icon-wrapper">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
                <span>TravelBooking</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars-staggered fs-4 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fa-solid fa-house me-1 text-primary"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('search*') ? 'active' : '' }}" href="{{ route('search') }}">
                            <i class="fa-solid fa-magnifying-glass me-1 text-primary"></i> Search
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flights*') ? 'active' : '' }}" href="{{ route('flights.index') }}">
                            <i class="fa-solid fa-plane-departure me-1 text-primary"></i> Flights
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('hotels*') ? 'active' : '' }}" href="{{ route('hotels.index') }}">
                            <i class="fa-solid fa-hotel me-1 text-primary"></i> Hotels
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('packages*') ? 'active' : '' }}" href="{{ route('packages.index') }}">
                            <i class="fa-solid fa-umbrella-beach me-1 text-primary"></i> Packages
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-lg-center gap-2 mt-3 mt-lg-0">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm text-dark fw-bold rounded-pill px-3 shadow-sm">
                                    <i class="fa-solid fa-shield-halved me-1"></i> Admin Portal
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-custom btn-sm rounded-pill px-3">
                                    <i class="fa-solid fa-chart-pie me-1"></i> My Dashboard
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-1" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.9rem;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="d-flex flex-column text-start">
                                    <span class="fw-bold text-dark small leading-tight">{{ auth()->user()->name }}</span>
                                    <span class="text-muted" style="font-size: 0.72rem;">{{ ucfirst(auth()->user()->role) }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2" style="min-width: 220px;">
                                @if(auth()->user()->isAdmin())
                                    <li><h6 class="dropdown-header text-uppercase small text-muted">Admin Controls</h6></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Admin Overview</a></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('admin.reservations.index') }}"><i class="fa-solid fa-ticket me-2 text-primary"></i>Reservations</a></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('admin.refunds.index') }}"><i class="fa-solid fa-rotate-left me-2 text-primary"></i>Refund Claims</a></li>
                                @else
                                    <li><h6 class="dropdown-header text-uppercase small text-muted">My Travel Center</h6></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('user.dashboard') }}"><i class="fa-solid fa-gauge me-2 text-primary"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('user.flight-schedules.index') }}"><i class="fa-solid fa-plane me-2 text-primary"></i>Flight Schedules</a></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('user.hotel-schedules.index') }}"><i class="fa-solid fa-bed me-2 text-primary"></i>Hotel Schedules</a></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('user.package-bookings.index') }}"><i class="fa-solid fa-suitcase me-2 text-primary"></i>Package Bookings</a></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('user.payments.index') }}"><i class="fa-solid fa-credit-card me-2 text-primary"></i>Payments & Receipts</a></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('user.refunds.index') }}"><i class="fa-solid fa-rotate-left me-2 text-primary"></i>Refund Requests</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('user.profile') }}"><i class="fa-solid fa-user-gear me-2 text-muted"></i>Profile Settings</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-2 py-2 text-danger">
                                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('login') }}">
                                <i class="fa-solid fa-right-to-bracket me-1 text-primary"></i> Log In
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary-custom btn-sm" href="{{ route('register') }}">
                                <i class="fa-solid fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                        <li class="nav-item ms-lg-1">
                            <a class="btn btn-outline-secondary btn-sm rounded-pill px-3" href="{{ route('admin.login') }}" title="Administrator Portal Login">
                                <i class="fa-solid fa-lock me-1"></i> Admin
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Notifications Container -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4 d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation fs-5 me-2 text-danger"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show shadow-sm rounded-4 d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-info fs-5 me-2 text-info"></i>
                <div class="flex-grow-1">{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4" role="alert">
                <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Please resolve the following errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Dynamic Content -->
    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-icon-wrapper" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                        <h4 class="text-white fw-bold mb-0">TravelBooking</h4>
                    </div>
                    <p class="small text-light opacity-75 leading-relaxed">
                        An enterprise-grade MVC-based web application for managing seamless travel bookings, flight schedules, hotel reservations, and curated vacation packages across Pakistan and international routes.
                    </p>
                    <div class="vu-project-badge mt-2">
                        <i class="fa-solid fa-graduation-cap"></i> Virtual University of Pakistan &bull; CS619
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Home</a></li>
                        <li><a href="{{ route('search') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Search Services</a></li>
                        <li><a href="{{ route('flights.index') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Pakistan Flights</a></li>
                        <li><a href="{{ route('hotels.index') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Luxury Hotels</a></li>
                        <li><a href="{{ route('packages.index') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Vacation Tours</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Customer Space</h5>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> User Dashboard</a></li>
                        <li><a href="{{ route('user.flight-schedules.index') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Flight Schedules</a></li>
                        <li><a href="{{ route('user.hotel-schedules.index') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Hotel Vouchers</a></li>
                        <li><a href="{{ route('user.refunds.index') }}"><i class="fa-solid fa-angle-right me-1 text-primary"></i> Refund Requests</a></li>
                        <li><a href="{{ route('admin.login') }}"><i class="fa-solid fa-lock me-1 text-warning"></i> Admin Panel</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Project Supervisor</h5>
                    <p class="small text-light opacity-80 mb-2 leading-relaxed">
                        <strong>Sheikh Israr Ahmad</strong><br>
                        Virtual University of Pakistan<br>
                        <i class="fa-solid fa-envelope me-1 text-info"></i> israr.ahmad@vu.edu.pk<br>
                        <i class="fa-brands fa-microsoft me-1 text-info"></i> israr.ahmad.vu@outlooks.com
                    </p>
                    <div class="small text-muted border-top border-secondary border-opacity-50 pt-2 mt-2">
                        Course Code: <strong>CS619 Final Year Project</strong><br>
                        Architecture: <strong>Laravel 12 (MVC) + MySQL</strong>
                    </div>
                </div>
            </div>

            <div class="border-top border-secondary border-opacity-50 pt-3 text-center small text-light opacity-75">
                &copy; {{ date('Y') }} TravelBooking Application. Built for Virtual University CS619 Final Year Project.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
