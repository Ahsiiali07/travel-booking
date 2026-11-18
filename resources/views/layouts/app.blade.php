<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TravelBooking - Pakistan & Global Travel Portal') | VU CS619 Final Year Project</title>

    <!-- Google Fonts: DM Sans & Manrope (Figma Make Theme) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #ff6b4a;            /* Figma Coral / Warm Orange */
            --primary-hover: #ee5b3c;
            --primary-dark: #e85335;
            --primary-light: #fff0ec;      /* Warm Peach Tint */
            --primary-subtle: #fff0ec;
            --navy: #102d45;               /* Figma Deep Navy */
            --navy-dark: #07192b;          /* Darker Midnight Navy */
            --navy-card: #15344e;          /* Card Navy */
            --gold: #ffb64d;               /* Warm Gold Accent */
            --bg-page: #fafaf7;            /* Figma Creamy Off-White */
            --text-main: #102a43;          /* Deep Slate Navy Text */
            --text-muted: #64748b;
            --slate-border: #e2e8f0;
            --card-shadow: 0 10px 30px -5px rgba(16, 45, 69, 0.06), 0 4px 6px -2px rgba(16, 45, 69, 0.02);
            --card-shadow-hover: 0 20px 35px -8px rgba(16, 45, 69, 0.12), 0 8px 12px -4px rgba(16, 45, 69, 0.04);
        }

        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, .font-display, .section-title {
            font-family: 'Manrope', 'DM Sans', sans-serif;
            letter-spacing: -0.03em;
        }

        .section-kicker {
            color: #e85335;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .section-title {
            font-size: clamp(2rem, 3.8vw, 2.85rem);
            font-weight: 700;
            line-height: 1.15;
            color: #102a43;
        }

        /* Top Project Banner */
        .project-top-bar {
            background: #07192b;
            font-size: 0.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Modern Navbar */
        .main-navbar {
            background: rgba(250, 250, 247, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 1px 15px rgba(16, 45, 69, 0.04);
            padding: 0.9rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .navbar-brand {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.45rem;
            color: #102a43 !important;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            letter-spacing: -0.02em;
        }

        .brand-icon-wrapper {
            width: 38px;
            height: 38px;
            background: #ff6b4a;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(255, 107, 74, 0.35);
            font-size: 1.05rem;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.92rem;
            color: #475569 !important;
            padding: 0.55rem 0.95rem !important;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #e54e2e !important;
            background-color: #fff0ec;
        }

        /* Modern Coral Pill Buttons (Figma Make) */
        .btn-primary-custom {
            background: #ff6b4a;
            border: none;
            color: #ffffff !important;
            font-weight: 600;
            padding: 0.65rem 1.4rem;
            border-radius: 9999px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(255, 107, 74, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
        }

        .btn-primary-custom:hover {
            background: #ee5b3c;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 74, 0.45);
            color: #ffffff !important;
        }

        .btn-outline-custom {
            border: 1.5px solid #ff6b4a;
            color: #ff6b4a !important;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.6rem 1.3rem;
            transition: all 0.2s;
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: #ff6b4a;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(255, 107, 74, 0.25);
        }

        /* Cards & Surfaces */
        .card-custom {
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 24px;
            background: #ffffff;
            box-shadow: var(--card-shadow);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            overflow: hidden;
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(255, 107, 74, 0.3);
        }

        /* Global Bootstrap Color Overrides to Figma Make Brand */
        .text-primary { color: #ff6b4a !important; }
        .bg-primary { background-color: #ff6b4a !important; }
        .border-primary { border-color: #ff6b4a !important; }
        .bg-primary-subtle { background-color: #fff0ec !important; color: #e54e2e !important; }
        .btn-primary {
            background-color: #ff6b4a !important;
            border-color: #ff6b4a !important;
            color: #ffffff !important;
            border-radius: 9999px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #ee5b3c !important;
            border-color: #ee5b3c !important;
            color: #ffffff !important;
        }
        .btn-outline-primary {
            color: #ff6b4a !important;
            border-color: #ff6b4a !important;
            border-radius: 9999px;
            font-weight: 600;
        }
        .btn-outline-primary:hover, .btn-check:checked + .btn-outline-primary {
            background-color: #ff6b4a !important;
            border-color: #ff6b4a !important;
            color: #ffffff !important;
        }
        .nav-pills .nav-link {
            color: #64748b;
            font-weight: 600;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link.active {
            background-color: #fff0ec !important;
            color: #e54e2e !important;
            box-shadow: none !important;
        }
        .pagination .page-item.active .page-link {
            background-color: #ff6b4a !important;
            border-color: #ff6b4a !important;
            color: #ffffff !important;
        }
        .pagination .page-link {
            color: #102a43;
            border-radius: 8px;
            margin: 0 2px;
        }
        .pagination .page-link:hover {
            color: #ff6b4a;
            background-color: #fff0ec;
        }

        /* Color Badges (Figma Make Style) */
        .badge-soft-primary { background: #fff0ec; color: #e54e2e; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-cyan    { background: #eff6ff; color: #2563eb; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-success { background: #ecfdf5; color: #047857; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-warning { background: #fffbeb; color: #b45309; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-danger  { background: #fef2f2; color: #dc2626; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }

        /* Form Controls Overhaul */
        .form-control, .form-select {
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            padding: 0.68rem 1rem;
            font-size: 0.93rem;
            color: #102a43;
            transition: all 0.2s ease;
            background-color: #fafaf8;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff6b4a;
            box-shadow: 0 0 0 4px rgba(255, 107, 74, 0.15);
            outline: none;
            background-color: #ffffff;
        }

        /* Airport Search Styles */
        .airport-search-wrapper {
            position: relative;
        }

        .airport-input-group .form-control {
            border-radius: 0;
            background-color: #ffffff;
        }

        .airport-input-group .input-group-text:first-child {
            border-top-left-radius: 14px;
            border-bottom-left-radius: 14px;
            background-color: #ffffff;
            color: #ff6b4a !important;
        }

        .airport-input-group .airport-toggle-btn {
            border-top-right-radius: 14px;
            border-bottom-right-radius: 14px;
            background: #ffffff;
        }

        .airport-dropdown-menu {
            border-radius: 16px !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 15px 35px -5px rgba(16, 45, 69, 0.15), 0 5px 15px rgba(0, 0, 0, 0.05) !important;
        }

        .airport-option:hover {
            background-color: #fff0ec !important;
        }

        /* Universal Button Styles (Figma Make) */
        .btn-detail-figma {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.45rem 1rem;
            border-radius: 9999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
        }
        .btn-detail-figma:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a;
            transform: translateY(-1px);
        }

        .btn-book-figma {
            background: #ff6b4a;
            border: 1.5px solid #ff6b4a;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.45rem 1.15rem;
            border-radius: 9999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 4px 12px rgba(255, 107, 74, 0.25);
            transition: all 0.2s ease;
        }
        .btn-book-figma:hover {
            background: #ee5b3c;
            border-color: #ee5b3c;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(255, 107, 74, 0.35);
        }

        /* Clean Modern Footer (Figma Make Inspired) */
        .footer {
            background: #ffffff;
            color: #64748b;
            margin-top: auto;
            padding-top: 3.5rem;
            padding-bottom: 2.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .footer-brand {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: #102a43;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .footer-nav-link {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }

        .footer-nav-link:hover {
            color: #ff6b4a;
            background: #fff0ec;
        }

        .vu-project-badge {
            background: #f8fafc;
            color: #475569;
            font-size: 0.78rem;
            padding: 0.45rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Mobile Responsive Improvements (Figma Make Style) */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #ffffff;
                padding: 1.25rem;
                border-radius: 24px;
                box-shadow: 0 20px 45px -10px rgba(16, 45, 69, 0.12);
                margin-top: 0.85rem;
                border: 1px solid #e2e8f0;
            }
            .main-navbar .navbar-nav .nav-link {
                padding: 0.7rem 1.1rem !important;
                border-radius: 14px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.65rem;
                color: #475569;
                margin-bottom: 0.25rem;
                transition: all 0.2s ease;
            }
            .main-navbar .navbar-nav .nav-link:hover {
                background-color: #f8fafc;
                color: #102a43;
            }
            .main-navbar .navbar-nav .nav-link.active {
                background-color: #fff0ec !important;
                color: #e54e2e !important;
            }
            .main-navbar .navbar-nav .nav-link i {
                width: 20px;
                text-align: center;
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
                <span class="badge bg-danger text-uppercase me-2 font-monospace" style="background-color: #ff6b4a !important;">VU CS619</span>
                <strong>Final Year Project:</strong> Travel Booking Application using MVC-based Framework (Laravel)
            </div>
            <div class="d-none d-md-block text-light opacity-90">
                <i class="fa-solid fa-user-tie me-1 text-warning"></i> Supervisor: <strong>Sheikh Israr Ahmad</strong> (israr.ahmad@vu.edu.pk)
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

    <!-- Clean Modern Footer (Figma Make Theme) -->
    <footer class="footer">
        <div class="container text-center">
            <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                <a href="{{ route('home') }}" class="footer-brand mb-2">
                    <div class="brand-icon-wrapper" style="width: 34px; height: 34px; font-size: 0.9rem; border-radius: 10px; background: #ff6b4a;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <span>TravelBooking</span>
                </a>
                <p class="text-muted small mb-3" style="max-width: 520px;">
                    Curated journeys, made personal. Extraordinary hotel stays, scheduled domestic flights, and unforgettable tour packages across Pakistan.
                </p>

                <!-- Clean Nav Links -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                    <a href="{{ route('home') }}" class="footer-nav-link">Home</a>
                    <a href="{{ route('flights.index') }}" class="footer-nav-link">Flights</a>
                    <a href="{{ route('hotels.index') }}" class="footer-nav-link">Hotels</a>
                    <a href="{{ route('packages.index') }}" class="footer-nav-link">Packages</a>
                    <a href="{{ route('search') }}" class="footer-nav-link">Search</a>
                    <a href="{{ route('admin.login') }}" class="footer-nav-link text-muted">Admin Portal</a>
                </div>

                <!-- Academic Info Pill -->
                <div class="vu-project-badge mb-3">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #ff6b4a; display: inline-block;"></span>
                    <span>Virtual University of Pakistan &bull; CS619 Final Year Project</span>
                    <span class="text-muted">&bull;</span>
                    <span class="text-dark fw-bold">Supervisor: Sheikh Israr Ahmad</span>
                    <a href="mailto:israr.ahmad@vu.edu.pk" class="text-muted text-decoration-none ms-1"><i class="fa-solid fa-envelope"></i></a>
                </div>
            </div>

            <div class="pt-3 border-top d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small text-muted" style="border-color: #f1f5f9 !important; font-size: 0.82rem;">
                <div>
                    &copy; {{ date('Y') }} <strong>TravelBooking</strong> &bull; Designed for your next great story.
                </div>
                <div class="d-flex gap-3 text-muted">
                    <span>Clean MVC Architecture</span>
                    <span>&bull;</span>
                    <span>Laravel 12 &bull; MySQL</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
