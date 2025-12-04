<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal Karya Seniman Budaya Sumbawa</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-left">
            <div class="auth-branding">
                <h1 class="brand-title">Portal Karya Seniman</h1>
                <p class="brand-subtitle">Budaya Sumbawa</p>
                <p class="brand-description">Jelajahi dan bagikan karya seni tradisional Sumbawa</p>
            </div>
            <div class="auth-illustration">
                <i class="fas fa-palette"></i>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="auth-right">
            <div class="login-form-wrapper">
                <h2 class="login-title">Masuk</h2>
                <p class="login-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>

                <!-- Display Errors -->
                @if ($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div class="alert-content">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Display Success Message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.handle') }}" class="login-form">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            required
                        >
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password Anda"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-checkbox">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label for="remember">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="form-divider">
                    <span>Belum punya akun?</span>
                </div>

                <!-- Register Link -->
                <a href="{{ route('register.show') }}" class="btn-register">
                    <i class="fas fa-user-plus"></i>
                    Daftar sebagai Seniman
                </a>

                <!-- Back to Home -->
                <a href="/" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>
</html>
