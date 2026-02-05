<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Gudele Hospital Radiology Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a5568;
            --primary-light: #667eea;
            --secondary-color: #48bb78;
            --accent-color: #ed8936;
            --success-color: #38a169;
            --danger-color: #c53030;
            --warning-color: #d69e2e;
            --light-color: #f7fafc;
            --dark-color: #2d3748;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #cbd5e0;
            --bg-soft: #edf2f7;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #fafbfc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            overflow-x: hidden;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1001;
            border-bottom: 1px solid var(--border-color);
        }

        /* Ensure header content stays on one line with logo on the far left */
        .navbar .container-fluid {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: nowrap;
            padding: 10px 20px;
        }

        .navbar-brand {
            margin: 0;
            padding: 0;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 18px;
            letter-spacing: -0.3px;
        }

        .navbar-brand img {
            height: 36px;
            width: auto;
            border-radius: 6px;
            transition: opacity 0.3s ease;
        }

        .navbar-brand img:hover {
            opacity: 0.85;
        }

        .navbar .navbar-nav {
            margin-left: auto;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 12px !important;
        }

        .nav-link:hover {
            color: var(--primary-light) !important;
        }

        .sidebar {
            background-color: #f8fafb;
            height: calc(100vh - 56px);
            padding-top: 20px;
            position: fixed;
            width: 250px;
            left: 0;
            top: 56px;
            overflow-y: auto;
            z-index: 999;
            border-right: 1px solid var(--border-color);
        }

        .sidebar a {
            color: var(--text-secondary);
            text-decoration: none;
            display: block;
            padding: 11px 20px;
            margin: 4px 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            border-radius: 6px;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            background-color: var(--bg-soft);
            color: var(--primary-light);
            border-left-color: var(--primary-light);
            padding-left: 22px;
        }

        .sidebar a.active {
            background-color: #e6fffa;
            border-left: 3px solid var(--secondary-color);
            color: var(--secondary-color);
        }

        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 35px 40px;
            min-height: calc(100vh - 86px);
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
            transition: all 0.3s ease;
            background: white;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }

        .card-header {
            background-color: #f7fafc;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
            border-radius: 8px 8px 0 0;
            padding: 18px 20px;
            font-weight: 600;
            font-size: 15px;
        }

        .btn-primary {
            background-color: var(--primary-light);
            border: none;
            border-radius: 6px;
            font-weight: 600;
            padding: 9px 18px;
            font-size: 14px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5a67d8;
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        .btn-success {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 6px;
            font-weight: 600;
            color: white;
        }

        .btn-success:hover {
            background-color: #319795;
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 8px;
            border: 1px solid;
            border-left: 4px solid;
            padding: 16px 18px;
        }

        .alert-success {
            background-color: #f0fff4;
            border-color: #c6f6d5;
            border-left-color: var(--secondary-color);
            color: #22543d;
        }

        .alert-danger {
            background-color: #fff5f5;
            border-color: #fed7d7;
            border-left-color: var(--danger-color);
            color: #742a2a;
        }

        .alert-warning {
            background-color: #fffaf0;
            border-color: #fbd38d;
            border-left-color: var(--warning-color);
            color: #7c2d12;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            text-align: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }

        .stat-card .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-light);
            margin: 12px 0;
        }

        .stat-card .stat-label {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table {
            background: white;
            border-collapse: collapse;
        }

        .table thead {
            background-color: #f7fafc;
        }

        .table thead th {
            border-bottom: 2px solid var(--border-color);
            color: var(--text-primary);
            font-weight: 600;
            padding: 13px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .table tbody td {
            padding: 13px 15px;
            border-bottom: 1px solid #edf2f7;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .table tbody tr:hover {
            background-color: #fafbfc;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        .badge-success {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge-danger {
            background-color: #fed7d7;
            color: #742a2a;
        }

        .badge-warning {
            background-color: #feebc8;
            color: #7c2d12;
        }

        .badge-info {
            background-color: #bee3f8;
            color: #2c5282;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 10px 12px;
            transition: all 0.3s ease;
            font-size: 14px;
            background-color: white;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.08);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 14px;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                top: 0;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .main-content {
                margin-left: 0;
                margin-top: 0;
                padding: 20px;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('images/logo.png') }}" alt="Gudele Hospital Logo">
                    <span>Gudele Radiology</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            @include('layouts.sidebar')
            <div class="main-content w-100">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @auth
    <script>
        // Optimized session activity tracking with throttling
        let lastActivityTime = Date.now();
        let activityPingTimeout;
        const ACTIVITY_PING_INTERVAL = 5 * 60 * 1000; // Ping every 5 minutes instead of on every action

        function pingActivity() {
            // Debounce - only ping server every 5 minutes
            clearTimeout(activityPingTimeout);
            activityPingTimeout = setTimeout(() => {
                fetch('{{ route("session.activity") }}', {
                    method: 'HEAD',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).catch(() => {});
            }, ACTIVITY_PING_INTERVAL);
        }

        function recordActivity() {
            lastActivityTime = Date.now();
            pingActivity();
        }

        // Track user activity with debouncing to reduce server load
        let debounceTimer;
        const activityEvents = ['mousemove', 'keypress', 'click', 'scroll', 'touchstart'];
        
        activityEvents.forEach(event => {
            document.addEventListener(event, () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(recordActivity, 1000); // Wait 1 second to batch events
            }, { passive: true });
        });

        // Initial ping on page load
        recordActivity();
    </script>
    </script>
    @endauth
    
    @yield('extra-js')
</body>
</html>
