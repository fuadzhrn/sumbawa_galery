@extends('layouts.app')

@section('title', 'Admin Dashboard - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<!-- PAGE HEADER -->
<div class="dashboard-header">
    <div class="header-top">
        <div>
            <h1 class="dashboard-title">Dashboard Admin</h1>
            <p class="dashboard-subtitle">Kelola portal karya seniman</p>
        </div>
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-role">Admin</span>
        </div>
    </div>
</div>

<!-- SUCCESS MESSAGE -->
@if (session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <p>{{ session('success') }}</p>
    </div>
@endif

<!-- DASHBOARD CONTENT -->
<div class="dashboard-content">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalSeniman }}</h3>
                <p class="stat-label">Total Seniman</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalSenimanAktif }}</h3>
                <p class="stat-label">Seniman Aktif</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(168, 85, 247, 0.1); color: #a855f7;">
                <i class="fas fa-music"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalKarya }}</h3>
                <p class="stat-label">Total Karya Diterima</p>
            </div>
        </div>

       

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
                <i class="fas fa-images"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalSlider }}</h3>
                <p class="stat-label">Foto Slider</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('admin.karya-seni') }}" class="btn btn-primary">
            <i class="fas fa-images"></i>
            Kelola Karya Seni
        </a>
    </div>

    <!-- Users Table -->
    <div class="section-card">
        <div class="section-header">
            <h2>Daftar Seniman</h2>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari seniman...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Bergabung</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse (\App\Models\User::where('role', 'seniman')->latest()->take(10)->get() as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge @if($user->is_active) badge-success @else badge-danger @endif">
                                    @if($user->is_active) Aktif @else Nonaktif @endif
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem;">
                                <p style="color: #9ca3af;">Tidak ada seniman terdaftar</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Logout Button di Sidebar -->
@section('extra-js')
    <script>
        // Tambahkan logout button ke sidebar jika belum ada
        document.addEventListener('DOMContentLoaded', function() {
            const navMenu = document.querySelector('.nav-menu');
            if (navMenu && !navMenu.querySelector('.logout-item')) {
                const logoutItem = document.createElement('li');
                logoutItem.className = 'nav-item logout-item';
                logoutItem.style.marginTop = 'auto';
                logoutItem.style.borderTop = '1px solid var(--border-color)';
                logoutItem.innerHTML = `
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem;"></i>
                            Logout
                        </button>
                    </form>
                `;
                navMenu.appendChild(logoutItem);
            }
        });
    </script>
@endsection
@endsection
