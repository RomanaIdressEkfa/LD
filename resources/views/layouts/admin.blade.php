<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Logically Debate</title>
    <!-- Favicon -->
    <link rel="icon" href="https://i.ibb.co.com/s916M5xG/Logo-01.png" type="image/png">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e1e2d;
            --sidebar-text: #9899ac;
            --sidebar-hover: #1b1b28;
            --sidebar-active: #3699ff;
            --header-height: 70px;
            --bg-color: #f3f6f9;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            overflow-x: hidden;
        }

        /* --- Sidebar --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            transition: all 0.3s ease;
            overflow-y: auto;
            scrollbar-width: none; /* Hide scrollbar Firefox */
        }
        
        .sidebar::-webkit-scrollbar { display: none; } /* Hide scrollbar Chrome */

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 25px;
            background-color: rgba(0,0,0,0.1);
        }
        
        .sidebar-brand img {
            max-height: 28px;
            width: auto;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .menu-label {
            padding: 15px 25px 10px;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #5c5c6d;
            font-weight: 600;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover {
            color: #fff;
            background-color: var(--sidebar-hover);
        }

        .sidebar-menu li a.active {
            color: #fff;
            background-color: var(--sidebar-hover);
            border-left-color: var(--sidebar-active);
        }

        .sidebar-menu li a i {
            width: 30px;
            font-size: 18px;
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* --- Topbar --- */
        .topbar {
            height: var(--header-height);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .toggle-btn {
            font-size: 20px;
            cursor: pointer;
            color: #5e6278;
            margin-right: 15px;
            display: none; /* Hidden on desktop */
        }

        .user-profile {
            cursor: pointer;
        }

        /* --- Page Content --- */
        .page-content {
            padding: 30px;
            flex-grow: 1;
        }

        .card-custom {
            background: #fff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 0 20px 0 rgba(76,87,125,0.02);
        }

        /* --- Mobile Overlay --- */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* --- Responsive Design --- */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-btn {
                display: block;
            }

            .sidebar-brand {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <!-- Logo -->
        <a href="{{ route('home') }}">
            <img src="https://i.ibb.co.com/gbLB6Dqj/Logo-02.png" alt="Logically Debate">
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="menu-label">DASHBOARD</li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-grid-2"></i> Dashboard
            </a>
        </li>

        <li class="menu-label">DEBATE CENTER</li>
        <li>
            <a href="{{ route('admin.debates.index') }}" class="{{ request()->routeIs('admin.debates.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gavel"></i> Manage Debates
            </a>
        </li>
        <!-- Example: Add Categories or Tags here if needed -->

        <li class="menu-label">USER MANAGEMENT</li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> User List
            </a>
        </li>

        <li class="menu-label">SETTINGS</li>
        <li>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f64e60;">
                    <i class="fa-solid fa-power-off"></i> Logout
                </a>
            </form>
        </li>
    </ul>
</nav>

<!-- Main Content Wrapper -->
<div class="main-content">
    
    <!-- Top Header -->
    <header class="topbar">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-bars toggle-btn" id="sidebarToggle"></i>
            <h5 class="m-0 fw-bold text-secondary d-none d-sm-block">Admin Control Panel</h5>
        </div>

        <!-- User Dropdown -->
        <div class="dropdown">
            <div class="d-flex align-items-center user-profile gap-2" data-bs-toggle="dropdown">
                <div class="text-end d-none d-md-block">
                    <small class="d-block text-muted" style="line-height: 1;">Logged in as</small>
                    <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=3699ff&color=fff" class="rounded-circle shadow-sm" width="40" height="40">
            </div>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                <li><h6 class="dropdown-header">User Options</h6></li>
                <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fa-solid fa-globe me-2"></i> View Website</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger"><i class="fa-solid fa-sign-out-alt me-2"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <!-- Page Content -->
    <main class="page-content">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Dynamic Content -->
        @yield('content')
    </main>

    <footer class="text-center py-3 text-muted small">
        &copy; {{ date('Y') }} Logically Debate. All rights reserved.
    </footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("sidebarToggle");
        const overlay = document.getElementById("sidebarOverlay");

        // Toggle Sidebar
        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        });

        // Close Sidebar when clicking overlay
        overlay.addEventListener("click", function () {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });
    });
</script>

</body>
</html>