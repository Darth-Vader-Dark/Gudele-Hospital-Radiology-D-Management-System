<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gudele Hospital Radiology Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 12px 15px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background-color: #667eea;
            border: none;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            color: white;
            font-weight: 600;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #5568d3;
            color: white;
        }

        .alert {
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .hospital-icon {
            font-size: 40px;
            color: #667eea;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="hospital-icon">
                <i class="fas fa-hospital"></i>
            </div>
            <h1>Gudele Hospital</h1>
            <p>Radiology Department Management System</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('authenticate') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted" style="font-size: 12px;">
                <i class="fas fa-info-circle"></i> Contact your administrator for login credentials
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
