<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Công việc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        .card { border-radius: 1rem; }
        .btn { border-radius: 2rem; }
    </style>
</head>
<body>

    <div class="app-shell">
        @auth
        <aside class="app-sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-title">QL Công việc</div>
                <ul class="sidebar-nav">
                    <li><a href="{{ route('home') }}">🏠 Trang chủ</a></li>
                    <li><a href="{{ route('tasks.index') }}">📋 Công việc</a></li>
                    <li><a href="{{ route('tasks.create') }}">✍️ Giao việc</a></li>
                    <li><a href="{{ route('employees.index') }}">👥 Nhân viên</a></li>
                    <li><a href="{{ route('messages.index') }}">💬 Tin nhắn</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-logout" type="submit">Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>
        @endauth

        <main class="app-main">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <style>
        .app-shell { display: flex; min-height: 100vh; }
        .app-sidebar { width: 220px; background: #1976d2; color: #fff; padding: 28px 12px; box-shadow: 2px 0 12px rgba(0,0,0,0.06); }
        .sidebar-inner { position: sticky; top: 18px; }
        .sidebar-title { font-weight: 700; margin-bottom: 20px; text-align: center; }
        .sidebar-nav { list-style: none; padding: 0; margin: 0; }
        .sidebar-nav li { margin-bottom: 12px; }
        .sidebar-nav a { color: #fff; text-decoration: none; display: block; padding: 8px 12px; border-radius: 8px; }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.06); }
        .btn-logout { width: 100%; background: #fff; color: #1976d2; border: none; border-radius: 8px; padding: 8px 12px; }
        .app-main { flex: 1; padding: 28px; background: #f8fafc; }
        @media (max-width: 900px) { .app-sidebar { display:none; } .app-main { padding: 12px; } }
    </style>
</body>
</html>
