<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Công việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
    <style>
        .card { border-radius: 1rem; }
        .btn { border-radius: 2rem; }
    </style>
</head>
<body>

    @auth
    <!-- Header -->
    <header class="app-header">
        <div class="header-container">
            <div class="header-left">
                <div class="logo-container">
                    <i class="bi bi-clipboard-check-fill logo-icon"></i>
                    <span class="logo-text">Quản lý Công việc</span>
                </div>
            </div>
            
            <div class="header-right">
                <div class="user-info-dropdown">
                    <button class="user-info-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">{{ Auth::user()->role === 'manager' ? 'Quản lý' : 'Nhân viên' }}</span>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i> Hồ sơ cá nhân
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear"></i> Cài đặt
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="app-body">
        <!-- Sidebar -->
        <aside class="app-sidebar">
            <div class="sidebar-inner">
                <ul class="sidebar-nav">
                    <li><a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house-door"></i> <span>Trang chủ</span>
                    </a></li>
                    <li><a href="{{ route('tasks.index') }}" class="{{ Request::routeIs('tasks.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task"></i> <span>Công việc</span>
                    </a></li>
                    @can('manage', App\Models\User::class)
                        <li><a href="{{ route('tasks.create') }}">
                            <i class="bi bi-plus-circle"></i> <span>Giao việc</span>
                        </a></li>
                    @endcan
                    <li><a href="{{ route('employees.index') }}" class="{{ Request::routeIs('employees.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> <span>Nhân viên</span>
                    </a></li>
                    <li><a href="{{ route('messages.index') }}" class="{{ Request::routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> <span>Tin nhắn</span>
                    </a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @else
    <!-- Guest Layout -->
    <main class="guest-main">
        @yield('content')
    </main>
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Header Styles */
        .app-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0 24px;
        }
        
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 100%;
            height: 64px;
        }
        
        .header-left .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-icon {
            font-size: 28px;
            color: #fff;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-info-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 50px;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-info-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }
        
        .user-avatar {
            font-size: 24px;
            display: flex;
            align-items: center;
        }
        
        .user-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
        
        .user-name {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
        }
        
        .user-role {
            font-size: 11px;
            opacity: 0.85;
            line-height: 1.2;
        }
        
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
            min-width: 200px;
            margin-top: 8px;
        }
        
        .dropdown-item {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: #f8f9fa;
        }
        
        .dropdown-item i {
            font-size: 16px;
        }
        
        /* App Body - Container for Sidebar + Main */
        .app-body {
            display: flex;
            min-height: calc(100vh - 64px);
        }
        
        /* Sidebar Styles */
        .app-sidebar {
            width: 260px;
            background: #2d3748;
            color: #fff;
            padding: 24px 16px;
            box-shadow: 2px 0 12px rgba(0,0,0,0.08);
            flex-shrink: 0;
        }
        
        .sidebar-inner {
            position: sticky;
            top: 80px;
        }
        
        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-nav li {
            margin-bottom: 8px;
        }
        
        .sidebar-nav a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(4px);
        }
        
        .sidebar-nav a.active {
            background: rgba(102, 126, 234, 0.3);
            color: #fff;
            font-weight: 600;
        }
        
        .sidebar-nav a i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Area */
        .app-main {
            flex: 1;
            padding: 24px 32px;
            background: #f7fafc;
            overflow-x: hidden;
        }
        
        /* Guest Layout */
        .guest-main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7fafc;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .app-sidebar {
                position: fixed;
                left: -260px;
                height: calc(100vh - 64px);
                transition: left 0.3s ease;
                z-index: 999;
            }
            
            .app-sidebar.show {
                left: 0;
            }
            
            .app-main {
                padding: 16px 20px;
            }
            
            .logo-text {
                display: none;
            }
            
            .user-details {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .header-container {
                padding: 0;
            }
            
            .user-info-btn {
                padding: 6px 12px;
            }
            
            .app-main {
                padding: 12px 16px;
            }
        }
    </style>
</body>
</html>
