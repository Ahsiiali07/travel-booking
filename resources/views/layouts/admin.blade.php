<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | TravelBooking Administration Portal</title>

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
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #eef2ff;
            --accent: #06b6d4;
            --accent-gradient: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            --sidebar-bg: #090d16;
            --sidebar-width: 270px;
            --slate-border: #e2e8f0;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            --card-shadow-hover: 0 12px 20px -5px rgba(79, 70, 229, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #94a3b8;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1050;
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-brand {
            padding: 1.35rem 1.4rem;
            color: #ffffff;
            font-weight: 800;
            font-size: 1.28rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            letter-spacing: -0.02em;
        }

        .brand-icon-wrapper {
            width: 34px;
            height: 34px;
            background: var(--accent-gradient);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.95rem;
        }

        .sidebar-menu {
            padding: 1rem 0.85rem;
            list-style: none;
            margin: 0;
        }

        .sidebar-heading {
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            padding: 0.85rem 0.85rem 0.4rem;
            letter-spacing: 0.06em;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: #94a3b8;
            padding: 0.7rem 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.92rem;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: var(--accent-gradient);
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
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
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--slate-border);
            padding: 0.9rem 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .content-wrapper {
            padding: 1.75rem;
            flex-grow: 1;
        }

        /* Modern Card Styling */
        .card-stat {
            background: #ffffff;
            border: 1px solid var(--slate-border);
            border-radius: 16px;
            padding: 1.4rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .card-admin {
            background: #ffffff;
            border: 1px solid var(--slate-border);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .card-admin-header {
            padding: 1.2rem 1.5rem;
            background: #ffffff;
            border-bottom: 1px solid var(--slate-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Clean Admin Tables */
        .table-admin th {
            font-size: 0.78rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid var(--slate-border);
            padding: 0.9rem 1.1rem;
            letter-spacing: 0.03em;
        }

        .table-admin td {
            padding: 0.95rem 1.1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge-soft-primary { background: #eef2ff; color: #4f46e5; font-weight: 600; }
        .badge-soft-cyan    { background: #ecfeff; color: #0891b2; font-weight: 600; }
        .badge-soft-success { background: #ecfdf5; color: #059669; font-weight: 600; }
        .badge-soft-warning { background: #fffbeb; color: #d97706; font-weight: 600; }
        .badge-soft-danger  { background: #fef2f2; color: #dc2626; font-weight: 600; }

        /* Mobile Backdrop Overlay */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
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
            <span class="badge bg-primary ms-auto" style="font-size: 0.65rem;">ADMIN</span>
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
                    <span>User Management</span>
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

        <div class="p-3 mt-3 mx-3 rounded-3 bg-dark border border-secondary border-opacity-50 text-light small">
            <div class="fw-bold text-info"><i class="fa-solid fa-graduation-cap me-1"></i> VU CS619 Viva Ready</div>
            <div class="opacity-75" style="font-size: 0.78rem;">Supervisor: Sheikh Israr Ahmad</div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Admin Header -->
        <header class="admin-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <h5 class="fw-bold mb-0 text-dark">@yield('page_title', 'Administration Panel')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 d-none d-sm-inline-flex align-items-center gap-1">
                    <i class="fa-solid fa-globe"></i> Public Portal
                </a>
                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.9rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="d-none d-md-block text-start">
                        <div class="fw-bold text-dark small leading-tight">{{ auth()->user()->name }}</div>
                        <div class="badge bg-danger-subtle text-danger" style="font-size: 0.68rem;">Super Admin</div>
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
