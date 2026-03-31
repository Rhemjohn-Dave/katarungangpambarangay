<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Katarungang Pambarangay Case Management System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --primary: #3855a5; --primary-dark: #2c4589; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #3855a5 50%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 1rem;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 2rem 2rem 1.75rem;
            text-align: center;
            color: #fff;
        }

        .login-header .brgy-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1rem;
            display: block;
            border: 3px solid rgba(255,255,255,0.5);
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        }

        .login-header h4 {
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .login-header p {
            font-size: 0.8rem;
            opacity: 0.75;
            margin: 0.25rem 0 0;
        }

        .login-body {
            padding: 2rem;
            background: #fff;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(56,85,165,0.15);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 10px;
            padding: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-dark), #1e3a8a);
        }

        .input-icon {
            position: relative;
        }

        .input-icon .form-control {
            padding-left: 2.5rem;
        }

        .input-icon .icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .login-footer {
            text-align: center;
            padding: 0 2rem 1.5rem;
            background: #fff;
            font-size: 0.8rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">

        <div class="login-card card">
            <!-- Header -->
            <div class="login-header">
                <img src="{{ asset('brgylogo.jpg') }}" alt="Barangay Logo" class="brgy-logo">
                <h4>Brgy. Zone 12-A</h4>
                <br>
                <h4>Talisay City</h4>
                <h4>Katarungang Pambarangay</h4>
                <p>Case Management System</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <p class="text-center text-muted mb-4 small">Sign in to access your account</p>

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ $errors->first() }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-dark">Username</label>
                        <div class="input-icon">
                            <i class="bi bi-envelope icon"></i>
                            <input id="email" type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="admin@barangay.com"
                                   required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-dark">Password</label>
                        <div class="input-icon">
                            <i class="bi bi-lock icon"></i>
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter your password"
                                   required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100 text-white">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <i class="bi bi-geo-alt me-1"></i>
                Republic of the Philippines &bull; Barangay Justice System
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
