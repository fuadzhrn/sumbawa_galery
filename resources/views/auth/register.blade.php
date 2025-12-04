<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Seniman - Portal Karya Seniman Budaya Sumbawa</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-left">
            <div class="auth-branding">
                <h1 class="brand-title">Bergabunglah</h1>
                <p class="brand-subtitle">sebagai Seniman</p>
                <p class="brand-description">Bagikan karya seni Anda dengan dunia</p>
            </div>
            <div class="auth-illustration">
                <i class="fas fa-paint-brush"></i>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="auth-right">
            <div class="login-form-wrapper">
                <h2 class="login-title">Daftar Akun Baru</h2>
                <p class="login-subtitle">Isi data di bawah untuk membuat akun seniman</p>

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

                <form method="POST" action="{{ route('register.handle') }}" class="login-form">
                    @csrf

                    <!-- Name Input -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i>
                            Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap Anda"
                            required
                        >
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

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
                                placeholder="Minimal 8 karakter"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-hint">Password harus minimal 8 karakter</small>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i>
                            Konfirmasi Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Ulangi password Anda"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Terms Agreement -->
                    <div class="form-checkbox">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">Saya setuju dengan syarat dan ketentuan</label>
                    </div>

                    <!-- Register Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-user-plus"></i>
                        Daftar
                    </button>
                </form>

                <!-- Divider -->
                <div class="form-divider">
                    <span>Sudah punya akun?</span>
                </div>

                <!-- Login Link -->
                <a href="{{ route('login') }}" class="btn-register">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk sekarang
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
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleBtn = event.currentTarget;
            
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
