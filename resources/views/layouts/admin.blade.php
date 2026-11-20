<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - DETROIT Digital Invitation Studio')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --admin-sidebar-bg: #11141A;
            --admin-sidebar-hover: #1A1F29;
            --admin-sidebar-active: #202735;
            --admin-gold: #C59B27;
            --admin-body-bg: #F4F6F9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-body-bg);
            color: #2D3748;
            min-height: 100vh;
        }

        /* Sidebar matching Image 2 */
        .admin-sidebar {
            width: 260px;
            background-color: var(--admin-sidebar-bg);
            color: #A0AEC0;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            color: #FFFFFF;
        }

        .sidebar-brand-badge {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1.5px solid var(--admin-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cinzel', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--admin-gold);
            background: rgba(197, 155, 39, 0.1);
        }

        .sidebar-menu {
            padding: 16px 12px;
            list-style: none;
            margin: 0;
        }

        .sidebar-item {
            margin-bottom: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #A0AEC0;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .sidebar-link:hover {
            color: #FFFFFF;
            background-color: var(--admin-sidebar-hover);
        }

        .sidebar-link.active {
            color: #FFFFFF;
            background-color: #2563EB; /* Matching blue active indicator in Image 2 */
            font-weight: 600;
        }

        .admin-main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            background-color: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-content {
            padding: 30px;
            flex-grow: 1;
        }

        /* Stats Cards */
        .stat-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar (matching Image 2) -->
    <aside class="admin-sidebar">
        <!-- Logo Header -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-badge">D</div>
            <div>
                <div class="font-cinzel fw-bold" style="letter-spacing: 1.5px; font-size: 1.05rem;">DETROIT</div>
                <div style="font-size: 0.65rem; color: #718096; letter-spacing: 1px;">Invitation Studio</div>
            </div>
        </a>

        <!-- Menu Navigation -->
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="bi bi-cart3"></i>
                    <span>Pesanan</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('admin.templates.index') }}" class="sidebar-link {{ request()->routeIs('admin.templates*') ? 'active' : '' }}">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Template</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <i class="bi bi-folder2-open"></i>
                    <span>Kategori</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Pengguna</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>Pengaturan</span>
                </a>
            </li>

            <li class="sidebar-item mt-4 pt-3 border-top border-secondary border-opacity-25">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start text-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main-wrapper">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div>
                <h5 class="fw-bold mb-0">@yield('page_title', 'Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-globe me-1"></i> Buka Website
                </a>

                <div class="vr mx-2 text-muted"></div>

                <!-- Admin User Profile -->
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-semibold small line-height-1">{{ Auth::user()->name ?? 'Admin Detroit' }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Body Content -->
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
