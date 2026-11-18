<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | TravelBooking Administration Portal</title>

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
            --sidebar-bg: #102d45;         /* Figma Deep Navy */
            --sidebar-width: 260px;
            --bg-body: #f4f6f8;            /* Figma App Shell Gray */
            --text-main: #102a43;
            --slate-border: #e2e8f0;
            --card-shadow: 0 4px 6px -1px rgba(16, 45, 69, 0.03), 0 2px 4px -2px rgba(16, 45, 69, 0.02);
            --card-shadow-hover: 0 12px 24px -5px rgba(255, 107, 74, 0.12);
        }

        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, .font-display {
            font-family: 'Manrope', 'DM Sans', sans-serif;
            letter-spacing: -0.02em;
        }

        /* Sidebar Styling (Figma App Shell) */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: rgba(255, 255, 255, 0.7);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1050;
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.4rem 1.3rem;
            color: #ffffff;
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-icon-wrapper {
            width: 36px;
            height: 36px;
            background: #ff6b4a;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(255, 107, 74, 0.35);
        }

        .sidebar-menu {
            padding: 1rem 0.85rem;
            list-style: none;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.45);
            padding: 0.85rem 0.85rem 0.35rem;
            letter-spacing: 0.08em;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1rem;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.92rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 0.3rem;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(2px);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: #ff6b4a;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(255, 107, 74, 0.35);
        }

        .sidebar-link i {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
            text-align: center;
        }

        /* Figma Make Detail & Action Buttons */
        .btn-detail-figma {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.42rem 0.95rem;
            border-radius: 9999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
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
            padding: 0.42rem 1.1rem;
            border-radius: 9999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
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

        /* Layout Structure */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s;
        }

        .admin-header {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 0.9rem 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .content-wrapper {
            padding: 1.75rem;
            flex-grow: 1;
        }

        /* Modern Card Styling (Figma rounded-2xl) */
        .card-stat {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 18px;
            padding: 1.4rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(255, 107, 74, 0.25);
        }

        .card-admin {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 18px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .card-admin-header {
            padding: 1.2rem 1.5rem;
            background: #ffffff;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Clean Admin Tables (Figma Style) */
        .table-admin th {
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            background: #fafaf8;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.9rem 1.1rem;
            letter-spacing: 0.05em;
        }

        .table-admin td {
            padding: 0.95rem 1.1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.92rem;
        }

        .badge-soft-primary { background: #fff0ec; color: #e54e2e; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-cyan    { background: #eff6ff; color: #2563eb; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-success { background: #ecfdf5; color: #047857; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-warning { background: #fffbeb; color: #b45309; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }
        .badge-soft-danger  { background: #fef2f2; color: #dc2626; font-weight: 700; border-radius: 9999px; padding: 0.35rem 0.75rem; }

        /* Modern Table Action Buttons */
        .table-admin .btn-outline-info,
        .table-admin .btn-outline-primary,
        .table-admin .btn-outline-danger {
            border-radius: 9999px;
            padding: 0.32rem 0.65rem;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .table-admin .btn-outline-info {
            color: #475569 !important;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .table-admin .btn-outline-info:hover {
            background: #f1f5f9;
            color: #0f172a !important;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .table-admin .btn-outline-primary {
            color: #e54e2e !important;
            background: #fff0ec;
            border: 1px solid #ffd5cc;
        }
        .table-admin .btn-outline-primary:hover {
            background: #ff6b4a;
            color: #ffffff !important;
            border-color: #ff6b4a;
            transform: translateY(-1px);
        }
        .table-admin .btn-outline-danger {
            color: #dc2626 !important;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }
        .table-admin .btn-outline-danger:hover {
            background: #dc2626;
            color: #ffffff !important;
            border-color: #dc2626;
            transform: translateY(-1px);
        }

        /* Mobile Backdrop Overlay */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(16, 45, 69, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1045;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .sidebar-backdrop.show {
                display: block;
            }
            .admin-main {
                margin-left: 0;
            }
            .content-wrapper {
                padding: 1.15rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Mobile Overlay Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon-wrapper">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
            <span>TravelBooking</span>
            <span class="badge ms-auto" style="background: rgba(255,255,255,0.15); font-size: 0.65rem;">ADMIN</span>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-heading">Analytics & Overview</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-heading">Management (CRUD)</li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>User Accounts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.hotels.index') }}" class="sidebar-link {{ request()->routeIs('admin.hotels*') ? 'active' : '' }}">
                    <i class="fa-solid fa-hotel"></i>
                    <span>Hotel Listings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.flights.index') }}" class="sidebar-link {{ request()->routeIs('admin.flights*') ? 'active' : '' }}">
                    <i class="fa-solid fa-plane-departure"></i>
                    <span>Flight Schedules</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.packages.index') }}" class="sidebar-link {{ request()->routeIs('admin.packages*') ? 'active' : '' }}">
                    <i class="fa-solid fa-umbrella-beach"></i>
                    <span>Tour Packages</span>
                </a>
            </li>

            <li class="sidebar-heading">Reservations & Refunds</li>
            <li>
                <a href="{{ route('admin.reservations.index') }}" class="sidebar-link {{ request()->routeIs('admin.reservations*') ? 'active' : '' }}">
                    <i class="fa-solid fa-ticket"></i>
                    <span>All Reservations</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.refunds.index') }}" class="sidebar-link {{ request()->routeIs('admin.refunds*') ? 'active' : '' }}">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Refund Claims</span>
                </a>
            </li>

            <li class="sidebar-heading">Shortcuts</li>
            <li>
                <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Public Portal</span>
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link border-0 bg-transparent text-danger w-100 text-start">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Admin Logout</span>
                    </button>
                </form>
            </li>
        </ul>

        <!-- Bottom Admin User Pill (Matching Figma AppShell) -->
        <div class="p-3 border-top border-white border-opacity-10 mt-auto">
            <div class="d-flex align-items-center gap-3 px-1">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; background: #ffe0d8; color: #d94b2d; font-size: 0.88rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-white fw-bold small text-truncate">{{ auth()->user()->name }}</div>
                    <div class="small opacity-50 text-white" style="font-size: 0.72rem;">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Admin Header (Figma Make Header) -->
        <header class="admin-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <div>
                    <div class="text-muted small" style="font-size: 0.72rem;">Welcome back, {{ auth()->user()->name }}</div>
                    <h5 class="fw-bold mb-0 text-dark">@yield('page_title', 'Administration Panel')</h5>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="position-relative d-none d-md-block">
                    <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left: 14px; top: 11px; font-size: 0.85rem;"></i>
                    <input type="text" class="form-control form-control-sm border-0 ps-5" placeholder="Search anything..." style="background: #f1f5f9; border-radius: 12px; width: 200px; font-size: 0.88rem;">
                </div>
                
                <div class="position-relative">
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm bg-white border rounded-3 p-2 text-muted" title="Notifications">
                        <i class="fa-solid fa-bell"></i>
                        <span class="position-absolute top-0 end-0 p-1 border border-light rounded-circle" style="transform: translate(-30%, 30%); background: #ff6b4a;"></span>
                    </a>
                </div>

                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-custom rounded-pill px-3 d-none d-sm-inline-flex align-items-center gap-1">
                    <i class="fa-solid fa-globe"></i> Public Portal
                </a>
                
                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; background: #ffe0d8; color: #d94b2d; font-size: 0.88rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="d-none d-md-block text-start">
                        <div class="fw-bold text-dark small leading-tight">{{ auth()->user()->name }}</div>
                        <div class="badge" style="background: #fff0ec; color: #e54e2e; font-size: 0.68rem;">Super Admin</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Notifications -->
        <div class="px-4 pt-3">
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

        <!-- Body Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Admin Footer -->
        <footer class="bg-white border-top py-3 px-4 text-center small text-muted">
            TravelBooking Admin Control Panel &bull; Virtual University CS619 Final Year Project &bull; Supervisor: Sheikh Israr Ahmad
        </footer>
    </div>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarBackdrop').classList.toggle('show');
        }
    </script>
    @stack('scripts')
</body>
</html>
