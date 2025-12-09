<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Galery Sumbawa</title>

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
            padding: 20px;
        }
        
        .register-page {
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .register-box {
            width: 100%;
            max-width: 550px;
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
        
        .btn-register {
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
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3);
            color: white;
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .login-link a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-link a:hover {
            text-decoration: underline;
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
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        @media (max-width: 576px) {
            .register-box {
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
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="register-page">
        <div class="register-box">
            <div class="card">
                <!-- Header -->
                <div class="card-header">
                    <h2>
                        <i class="fas fa-user-plus"></i>
                        Register
                    </h2>
                    <p>Daftar sebagai Seniman</p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Daftar Gagal!</strong>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Register Form -->
                    <form action="{{ route('register.handle') }}" method="POST" class="register-form">
                        @csrf

                        <!-- Name Input -->
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Input -->
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

                        <!-- Password Input -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password"
                                placeholder="Minimal 8 karakter"
                                required
                                autocomplete="new-password"
                            >
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                required
                                autocomplete="new-password"
                            >
                            @error('password_confirmation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Terms Agreement -->
                        <div style="margin-bottom: 15px;">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agree" name="agree" required>
                                <label for="agree" style="margin-bottom: 0;">
                                    Saya setuju dengan syarat dan ketentuan
                                </label>
                            </div>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="btn btn-primary btn-register">
                            <i class="fas fa-user-plus"></i> Daftar
                        </button>

                        <!-- Login Link -->
                        <div class="login-link">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Masuk sekarang
                            </a>
                        </div>
                    </form>
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
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>
