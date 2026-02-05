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
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .sidebar {
            background-color: var(--primary-color);
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            width: 250px;
            left: 0;
            top: 56px;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: var(--secondary-color);
            padding-left: 30px;
        }

        .sidebar a.active {
            background-color: var(--secondary-color);
            border-left: 4px solid #fff;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px 8px 0 0;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .alert {
            border-radius: 8px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-card .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: var(--secondary-color);
            margin: 10px 0;
        }

        .stat-card .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }

        .table thead {
            background-color: var(--light-color);
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
        }

        .badge-success {
            background-color: var(--success-color);
        }

        .badge-danger {
            background-color: var(--danger-color);
        }

        .badge-warning {
            background-color: var(--warning-color);
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                top: 0;
                height: auto;
            }

            .main-content {
                margin-left: 0;
                margin-top: 0;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="fas fa-hospital"></i> Gudele Radiology</a>
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

                @yield('content')
            </div>
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('extra-js')
</body>
</html>
