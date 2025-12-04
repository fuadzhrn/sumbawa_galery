<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Karya Seniman Budaya Sumbawa')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('extra-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-main">
        <!-- HEADER -->
        <header class="header">
            <div class="header-content">
                <h1 class="header-title">Aplikasi Portal Karya Seniman Budaya Sumbawa</h1>
                <div class="header-url">
                    <label class="url-label">URL (dummy):</label>
                    <input type="text" class="url-input" value="@yield('url-dummy', 'https://sumbawa-portal.local/gallery')" readonly>
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
                                <form method="POST" action="/logout" style="width: 100%;">
                                    @csrf
                                    <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; color: inherit; cursor: pointer;">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @elseif(Auth::check() && Auth::user()->isSeniman())
                            <!-- SENIMAN MENU -->
                            <li class="nav-item">
                                <a href="/seniman/dashboard" class="nav-link @if(request()->path() === 'seniman/dashboard' || str_starts_with(request()->path(), 'seniman')) active @endif" data-page="seniman-dashboard">Beranda</a>
                            </li>
                            <li class="nav-divider">
                                <span class="divider-label">Kategori Seni</span>
                            </li>
                            <li class="nav-item">
                                <a href="/musik" class="nav-link @if(request()->path() === 'GalerySumbawa/musik' || request()->path() === 'musik') active @endif" data-page="musik">Musik</a>
                            </li>
                            <li class="nav-item">
                                <a href="/rupa" class="nav-link @if(request()->path() === 'GalerySumbawa/rupa' || request()->path() === 'rupa') active @endif" data-page="rupa">Rupa</a>
                            </li>
                            <li class="nav-item">
                                <a href="/film" class="nav-link @if(request()->path() === 'GalerySumbawa/film' || request()->path() === 'film') active @endif" data-page="film">Film</a>
                            </li>
                            <li class="nav-item" style="margin-top: auto; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                                <form method="POST" action="/logout" style="width: 100%;">
                                    @csrf
                                    <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; color: inherit; cursor: pointer;">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
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
                            
                            <li class="nav-item">
                                <a href="/musik" class="nav-link @if(request()->path() === 'GalerySumbawa/musik' || request()->path() === 'musik') active @endif" data-page="musik">Musik</a>
                            </li>
                            <li class="nav-item">
                                <a href="/rupa" class="nav-link @if(request()->path() === 'GalerySumbawa/rupa' || request()->path() === 'rupa') active @endif" data-page="rupa">Rupa</a>
                            </li>
                            <li class="nav-item">
                                <a href="/film" class="nav-link @if(request()->path() === 'GalerySumbawa/film' || request()->path() === 'film') active @endif" data-page="film">Film</a>
                            </li>
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
</body>
</html>
