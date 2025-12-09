<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Galery Sumbawa</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- iCheck Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    
    <style>
        :root {
            --primary-blue: #1e40af;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #3b82f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-page {
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .login-box {
            width: 100%;
            max-width: 500px;
            margin: auto;
        }
        
        .card {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #3b82f6 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .card-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .card-header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .card-body {
            padding: 40px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }
        
        .input-group-text {
            border: 2px solid #e5e7eb;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: var(--primary-blue);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #3b82f6 100%);
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px 0;
        }
        
        .remember-me input[type="checkbox"] {
            cursor: pointer;
        }
        
        .remember-me label {
            margin: 0;
            font-weight: normal;
            cursor: pointer;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        
        .forgot-password a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .register-divider {
            text-align: center;
            margin: 25px 0 20px 0;
            padding: 0;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        
        .register-divider span {
            background: white;
            padding: 0 10px;
            color: #999;
            font-size: 13px;
        }
        
        .btn-register-link {
            display: block;
            width: 100%;
            padding: 12px;
            text-align: center;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }
        
        .btn-register-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
            color: white;
        }
        
        .btn-register-link i {
            margin-right: 5px;
        }
        
        .alert {
            border-radius: 6px;
            border: none;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .invalid-feedback {
            display: block;
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }
        
        .toggle-password {
            cursor: pointer;
            user-select: none;
        }
        
        @media (max-width: 576px) {
            .login-box {
                width: 95%;
            }
            
            .card-header {
                padding: 20px;
            }
            
            .card-header h2 {
                font-size: 22px;
            }
            
            .card-body {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-box">
            <div class="card">
                <!-- Header -->
                <div class="card-header">
                    <h2>
                        <i class="fas fa-lock"></i>
                        Login
                    </h2>
                    <p>Galery Sumbawa Management System</p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Login Gagal!</strong>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST" class="login-form">
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email Anda"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password"
                                    placeholder="Masukkan password Anda"
                                    required
                                    autocomplete="current-password"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text toggle-password" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggle-icon"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="remember-me">
                            <input 
                                type="checkbox" 
                                id="remember" 
                                name="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label for="remember">Ingat saya</label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>

                        <!-- Forgot Password Link -->
                        <div class="forgot-password">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    <i class="fas fa-key"></i> Lupa Password?
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Register Divider -->
                    <div class="register-divider">
                        <span>Belum punya akun?</span>
                    </div>

                    <!-- Register Link -->
                    <a href="{{ route('register.show') }}" class="btn-register-link">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
