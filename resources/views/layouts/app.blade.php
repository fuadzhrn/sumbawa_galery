<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Karya Seniman Budaya Sumbawa')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('extra-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
    @stack('styles')
</head>
<body>
    <div class="container-main">
        <!-- HEADER -->
        <header class="header">
            <div class="header-content">
                <h1 class="header-title">Aplikasi Portal Karya Seniman Budaya Sumbawa</h1>
                <div class="header-user-section">
                    @if(Auth::check())
                        <div class="user-menu">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-logout">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">Login</a>
                    @endif
                </div>
            </div>
        </header>

        <!-- MAIN LAYOUT -->
        <div class="layout-wrapper">
            <!-- SIDEBAR -->
            <aside class="sidebar">
                <nav class="sidebar-nav">
                    <ul class="nav-menu">
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <!-- ADMIN MENU -->
                            <li class="nav-item">
                                <a href="/admin/dashboard" class="nav-link @if(request()->path() === 'admin/dashboard') active @endif" data-page="admin-dashboard">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/photo-slider" class="nav-link @if(request()->path() === 'admin/photo-slider') active @endif" data-page="photo-slider">Photo Slider</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/kata-sambutan" class="nav-link @if(request()->path() === 'admin/kata-sambutan') active @endif" data-page="sambutan-edit">Kata Sambutan</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/kategori" class="nav-link @if(request()->path() === 'admin/kategori') active @endif" data-page="kategori">Kategori</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/seniman" class="nav-link @if(request()->path() === 'admin/seniman') active @endif" data-page="seniman">Seniman</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/karya-seni" class="nav-link @if(request()->path() === 'admin/karya-seni') active @endif" data-page="karya-seni">Karya Seni</a>
                            </li>
                            <li class="nav-item" style="margin-top: auto; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                               
                            </li>
                        @elseif(Auth::check() && Auth::user()->isSeniman())
                            <!-- SENIMAN MENU -->
                            <li class="nav-item">
                                <a href="/seniman/dashboard" class="nav-link @if(request()->path() === 'seniman/dashboard' || str_starts_with(request()->path(), 'seniman')) active @endif" data-page="seniman-dashboard">Beranda</a>
                            </li>
                            <li class="nav-divider">
                                <span class="divider-label">Kategori Seni</span>
                            </li>
                            @php
                                $kategoris = \App\Models\Kategori::all();
                            @endphp
                            @forelse($kategoris as $kategori)
                            <li class="nav-item">
                                <a href="/{{ $kategori->slug }}" class="nav-link @if(request()->path() === $kategori->slug) active @endif" data-page="{{ $kategori->slug }}">{{ $kategori->nama }}</a>
                            </li>
                            @empty
                            <li class="nav-item">
                                <span class="nav-link" style="color: #9ca3af; cursor: default;">Belum ada kategori</span>
                            </li>
                            @endforelse
                            <li class="nav-item" style="margin-top: auto; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                                
                            </li>
                        @else
                            <!-- PUBLIC MENU -->
                            <li class="nav-item">
                                <a href="/" class="nav-link @if(request()->path() === '' || request()->path() === '/' || request()->path() === 'GalerySumbawa/') active @endif" data-page="beranda">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a href="/sambutan" class="nav-link @if(request()->path() === 'GalerySumbawa/sambutan' || request()->path() === 'sambutan') active @endif" data-page="sambutan">Kata Sambutan</a>
                            </li>
                            
                            <!-- Divider/Separator -->
                            <li class="nav-divider">
                                <span class="divider-label">Kategori Seni</span>
                            </li>
                            
                            @php
                                $kategoris = \App\Models\Kategori::all();
                            @endphp
                            @forelse($kategoris as $kategori)
                            <li class="nav-item nav-item-collapsible">
                                <div class="nav-item-header">
                                    <a href="/{{ $kategori->slug }}" class="nav-link @if(request()->path() === $kategori->slug) active @endif" data-page="{{ $kategori->slug }}">{{ $kategori->nama }}</a>
                                    <button class="nav-toggle" data-toggle="kategori-{{ $kategori->id }}" aria-expanded="false">
                                        ▼
                                    </button>
                                </div>
                                
                                <!-- Submenu: Daftar Seniman -->
                                <ul class="nav-submenu" id="kategori-{{ $kategori->id }}">
                                    @php
                                        $senimans = \App\Models\KaryaSeni::where('kategori_id', $kategori->id)
                                            ->where('status', 'approved')
                                            ->distinct('user_id')
                                            ->with(['user', 'user.seniman'])
                                            ->get()
                                            ->pluck('user')
                                            ->unique('id');
                                    @endphp
                                    @forelse($senimans as $user)
                                    @if($user->seniman)
                                    <li class="nav-submenu-item">
                                        <a href="/seniman/{{ $user->seniman->id }}" class="nav-sublink">{{ $user->name }}</a>
                                    </li>
                                    @endif
                                    @empty
                                    <li class="nav-submenu-item">
                                        <span class="nav-sublink" style="color: #9ca3af; cursor: default;">Belum ada seniman</span>
                                    </li>
                                    @endforelse
                                </ul>
                            </li>
                            @empty
                            <li class="nav-item">
                                <span class="nav-link" style="color: #9ca3af; cursor: default;">Belum ada kategori</span>
                            </li>
                            @endforelse
                        @endif
                    </ul>
                   
                </nav>
            </aside>

            <!-- CONTENT AREA -->
            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    @yield('extra-js')
    @stack('scripts')
</body>
</html>
