<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Rumah Sakit System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #e9ecef;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --accent-primary: #4361ee;
            --accent-secondary: #3a0ca3;
            --accent-danger: #e5383b;
            --accent-success: #2a9d8f;
            --accent-warning: #fca311;
            --border-color: #dee2e6;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            --sidebar-width: 250px;
            --transition-speed: 0.3s;
        }

        [data-theme="dark"] {
            --bg-primary: #121212;
            --bg-secondary: #1e1e1e;
            --bg-tertiary: #2d2d2d;
            --text-primary: #f8f9fa;
            --text-secondary: #adb5bd;
            --border-color: #404040;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        @media (prefers-color-scheme: dark) {
            [data-theme="auto"] {
                --bg-primary: #121212;
                --bg-secondary: #1e1e1e;
                --bg-tertiary: #2d2d2d;
                --text-primary: #f8f9fa;
                --text-secondary: #adb5bd;
                --border-color: #404040;
                --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        .navbar {
            background-color: var(--bg-primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: calc(100vh - 56px);
            border-right: 1px solid var(--border-color);
            transition: all var(--transition-speed);
        }

        .sidebar .nav-link {
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.25rem 0.5rem;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover {
            color: var(--accent-primary);
            background-color: var(--bg-tertiary);
        }

        .sidebar .nav-link.active {
            color: var(--accent-primary);
            background-color: rgba(67, 97, 238, 0.1);
            font-weight: 500;
        }

        .card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--accent-primary);
            border-color: var(--accent-primary);
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: var(--accent-secondary);
            border-color: var(--accent-secondary);
        }

        .btn-outline-primary {
            color: var(--accent-primary);
            border-color: var(--accent-primary);
            border-radius: 8px;
        }

        .btn-outline-primary:hover {
            background-color: var(--accent-primary);
            color: white;
        }

        .table {
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .table th {
            border-top: none;
            background-color: var(--bg-tertiary);
            font-weight: 600;
            color: var(--text-primary);
        }

        .table-hover tbody tr:hover {
            background-color: var(--bg-tertiary);
        }

        .form-control {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            line-height: 1.5;
            appearance: none;
        }

        .form-control:focus {
            background-color: var(--bg-primary);
            border-color: var(--accent-primary);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 16px;
            overflow: hidden;
            background-color: var(--bg-primary);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .theme-switcher {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--bg-primary);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            border: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 999;
                width: var(--sidebar-width);
                transform: translateX(-100%);
                height: calc(100vh - 56px);
                overflow-y: auto;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .overlay {
                display: none;
                position: fixed;
                top: 56px;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 998;
            }

            .overlay.show {
                display: block;
            }

            main {
                width: 100%;
                padding: 1rem;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--bg-tertiary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 12px;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        .activity-item-custom {
            background-color: var(--bg-card) !important;
            color: var(--text-primary) !important;
        }
    </style>
</head>

<body>
    @if (Request::is('/'))
        @yield('content')
    @else

            <div id="app">
                @auth
                    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
                        <div class="container-fluid">
                            <button class="navbar-toggler d-md-none mr-2" type="button" id="sidebarToggle">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <a class="navbar-brand font-weight-bold" href="{{ url('/dashboard') }}">
                                <i class="fas fa-hospital mr-2 text-primary"></i> Manajemen Rumah Sakit
                            </a>

                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center"
                                            href="#" role="button" data-toggle="dropdown">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2"
                                                style="width: 32px; height: 32px;">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                @endauth

                <div class="overlay"></div>

                <div class="container-fluid">
                    <div class="row">
                        @auth
                            <nav class="col-md-2 d-md-block sidebar py-3">
                                <div class="sidebar-sticky">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                                                href="{{ route('dashboard') }}">
                                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::is('rumah-sakit*') ? 'active' : '' }}"
                                                href="{{ route('rumah-sakit.index') }}">
                                                <i class="fas fa-hospital mr-2"></i> Rumah Sakit
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::is('pasien*') ? 'active' : '' }}"
                                                href="{{ route('pasien.index') }}">
                                                <i class="fas fa-user-injured mr-2"></i> Pasien
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        @endauth

                        <main role="main" class="col-md-10 ml-sm-auto px-md-4 py-4">
                            @yield('content')
                        </main>
                    </div>
                </div>
            </div>

            <div class="theme-switcher" id="themeSwitcher">
                <i class="fas fa-moon"></i>
            </div>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const themeSwitcher = document.getElementById('themeSwitcher');
        const currentTheme = localStorage.getItem('theme') || 'light';

        document.documentElement.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);

        themeSwitcher.addEventListener('click', function() {
            let theme = document.documentElement.getAttribute('data-theme');

            if (theme === 'light') {
                theme = 'dark';
            } else if (theme === 'dark') {
                theme = 'auto';
            } else {
                theme = 'light';
            }

            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            updateThemeIcon(theme);
        });

        function updateThemeIcon(theme) {
            const icon = themeSwitcher.querySelector('i');

            if (theme === 'light') {
                icon.className = 'fas fa-sun';
            } else if (theme === 'dark') {
                icon.className = 'fas fa-moon';
            } else {
                icon.className = 'fas fa-adjust';
            }
        }

        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.overlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.classList.add('fade-in');
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
