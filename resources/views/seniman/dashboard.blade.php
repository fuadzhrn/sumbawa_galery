@extends('layouts.app')

@section('title', 'Seniman Dashboard - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<!-- PAGE HEADER -->
<div class="dashboard-header">
    <div class="header-top">
        <div>
            <h1 class="dashboard-title">Dashboard Seniman</h1>
            <p class="dashboard-subtitle">Kelola profil dan karya Anda</p>
        </div>
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-role">Seniman</span>
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
                <i class="fas fa-image"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">0</h3>
                <p class="stat-label">Total Karya</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">0</h3>
                <p class="stat-label">Total Views</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(168, 85, 247, 0.1); color: #a855f7;">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">0</h3>
                <p class="stat-label">Total Likes</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(249, 115, 22, 0.1); color: #f97316;">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ Auth::user()->created_at->format('d M Y') }}</h3>
                <p class="stat-label">Bergabung Sejak</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="#" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Upload Karya Baru
        </a>
        <a href="#" class="btn btn-secondary">
            <i class="fas fa-user-circle"></i>
            Edit Profil
        </a>
        <a href="#" class="btn btn-secondary">
            <i class="fas fa-cog"></i>
            Pengaturan Akun
        </a>
    </div>

    <!-- Profile Card -->
    <div class="section-card">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p>{{ Auth::user()->email }}</p>
                    <div class="profile-stats">
                        <span><strong>0</strong> Karya</span>
                        <span><strong>0</strong> Views</span>
                        <span><strong>0</strong> Likes</span>
                    </div>
                </div>
            </div>
            <button class="btn btn-secondary">
                <i class="fas fa-edit"></i>
                Edit Profil
            </button>
        </div>
    </div>

    <!-- Recent Works -->
    <div class="section-card">
        <div class="section-header">
            <h2>Karya Terbaru Anda</h2>
            <a href="#" class="btn btn-small">
                <i class="fas fa-plus"></i>
                Tambah Karya
            </a>
        </div>

        <div class="empty-state">
            <i class="fas fa-image"></i>
            <h3>Belum Ada Karya</h3>
            <p>Mulai bagikan karya seni Anda dengan memulai upload karya pertama</p>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Upload Karya Pertama
            </a>
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
