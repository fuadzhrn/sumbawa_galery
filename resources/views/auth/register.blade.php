<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Portal Karya Seniman Budaya Sumbawa</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Auth CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    
    <style>
        /* Additional custom styles for this page */
        body {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            font-family: 'Source Sans Pro', sans-serif;
        }

        .register-page {
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .register-box {
            width: 100%;
            max-width: 550px;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            border: none;
            background-color: white;
        }

        .card-header {
            padding: 2rem;
            text-align: center;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
        }

        .card-header h2 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .card-header p {
            margin: 0.5rem 0 0 0;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .card-body {
            padding: 2.5rem;
        }

        /* Form Group Styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background-color: #fff;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background-color: #fff;
        }

        .form-control::placeholder {
            color: #999;
            font-size: 0.95rem;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        /* Input Group */
        .input-group {
            display: flex;
            align-items: center;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            background-color: white;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .input-group .form-control {
            border: none;
            box-shadow: none;
            padding: 0.75rem 1rem;
            flex: 1;
            margin: 0;
        }

        .input-group .form-control:focus {
            box-shadow: none;
            border: none;
        }

        .input-group-text {
            padding: 0.75rem 1rem;
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .input-group-text:hover {
            color: #1e40af;
        }

        /* Form Row for side-by-side inputs */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Checkbox Styling */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 0;
            cursor: pointer;
            accent-color: #1e40af;
            border: 2px solid #e5e7eb;
            border-radius: 4px;
        }

        .form-check-input:hover {
            border-color: #1e40af;
        }

        .form-check-label {
            cursor: pointer;
            margin-bottom: 0;
            font-size: 0.95rem;
            color: #333;
            user-select: none;
        }

        .form-check-label a {
            color: #1e40af;
            text-decoration: none;
            font-weight: 600;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            vertical-align: middle;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 1.05rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1a35a5 0%, #2d6ce8 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(30, 64, 175, 0.2);
        }

        .btn-primary i {
            margin-right: 0.5rem;
        }

        /* Error Message */
        .error-message {
            display: block;
            font-size: 0.875rem;
            color: #dc2626;
            margin-top: 0.25rem;
        }

        .card-footer {
            background: #f9fafb;
            padding: 1.5rem 2.5rem;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 0.95rem;
            color: #666;
        }

        .card-footer a {
            color: #1e40af;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .card-footer a:hover {
            text-decoration: underline;
            color: #1530a8;
        }

        @media (max-width: 640px) {
            .register-box {
                width: 95%;
            }

            .card-header {
                padding: 1.5rem;
            }

            .card-header h2 {
                font-size: 1.5rem;
                gap: 0.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-footer {
                padding: 1rem 1.5rem;
                font-size: 0.9rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="register-page">
        <div class="register-box">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header">
                    <h2>
                        <i class="fas fa-user-plus"></i>
                        Register
                    </h2>
                    <p>Buat akun baru untuk bergabung</p>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    @if ($errors->any())
                        <div style="background-color: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            <strong><i class="fas fa-exclamation-circle"></i> Registrasi Gagal!</strong>
                            <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.handle') }}">
                        @csrf

                        <!-- Name Input -->
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   placeholder="Masukkan nama lengkap Anda">
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   placeholder="nama@example.com">
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password & Confirm Password Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required
                                           placeholder="Minimal 8 karakter">
                                    <span class="input-group-text" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required
                                           placeholder="Ulangi password">
                                    <span class="input-group-text" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#">Syarat dan Ketentuan</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </form>
                </div>

                <!-- Card Footer -->
                <div class="card-footer">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = event.target.closest('.input-group-text').querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
