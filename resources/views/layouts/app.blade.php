<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Chatbot') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
            --sidebar-width: 280px;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }

        [data-bs-theme="dark"] {
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: [data-bs-theme="light"] ? #f1f5f9 : #0f172a;
            overflow-x: hidden;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-right: 1px solid var(--glass-border);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            padding: 20px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: inherit;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.2s;
        }

        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Content Area */
        .content-area {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: all 0.3s ease;
        }

        .navbar-custom {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 15px 30px;
            margin: -30px -30px 30px -30px;
            position: relative;
            z-index: 900;
        }

        /* Glass Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }

        /* Animations removed as requested */
        .animate-fade-in {
            /* Removed animation */
        }

        /* Form Inputs */
        input:not([type="checkbox"]):not([type="radio"]), select, textarea {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--glass-border) !important;
            color: inherit !important;
            border-radius: 12px !important;
            padding: 12px 15px !important;
            transition: all 0.2s;
        }

        input:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
            outline: none;
        }

        label {
            font-weight: 500;
            margin-bottom: 8px;
            opacity: 0.8;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                left: -100%;
            }
            .sidebar.show {
                left: 0;
            }
            .content-area {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column" id="sidebar">
        <div class="sidebar-header mb-4 px-3">
            <h4 class="fw-bold mb-0 text-primary">Voxa AI</h4>
        </div>
        
        <div class="flex-grow-1">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('chat.index') }}" class="sidebar-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                <i class="fas fa-comment-dots"></i> AI Chatbot
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profile
            </a>
        </div>

        <div class="mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Content Area -->
    <div class="content-area">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid p-0">
                <button class="btn d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="ms-auto d-flex align-items-center">
                    <button class="btn btn-outline-secondary rounded-circle me-3" id="themeToggle">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                    
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" alt="" class="rounded-circle me-2" width="35" height="35">
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="animate-fade-in">
            {{ $slot }}
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Theme Toggle Logic
    const themeToggle = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;
    const themeIcon = document.getElementById('themeIcon');

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    htmlElement.setAttribute('data-bs-theme', savedTheme);
    updateIcon(savedTheme);

    themeToggle.addEventListener('click', () => {
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        htmlElement.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon(newTheme);
    });

    function updateIcon(theme) {
        if (theme === 'dark') {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    }

    // Mobile Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if(sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }
</script>
{{ $scripts ?? '' }}

</body>
</html>
