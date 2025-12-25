<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Panel</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.3.0/overlayscrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/daterangepicker/3.1/daterangepicker.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
    
    <style>
        :root {
            --primary-color: #1e40af;
        }
        
        .main-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);
        }
        
        .sidebar {
            background-color: #222d32;
        }
        
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
        }

        /* Mobile Toggle Button */
        #mobile-sidebar-toggle {
            color: white;
            font-size: 1.25rem;
        }

        #mobile-sidebar-toggle:hover {
            color: #e0e0e0;
        }

        /* MOBILE RESPONSIVE - SIDEBAR TOGGLE */
        @media (max-width: 991px) {
            /* Hide original AdminLTE sidebar on mobile */
            .main-sidebar {
                display: none !important;
            }

            /* Show mobile sidebar - overlay style */
            .mobile-sidebar {
                position: fixed;
                left: 0;
                top: 57px;
                width: 250px;
                height: calc(100vh - 57px);
                z-index: 900;
                background-color: #222d32;
                transition: left 0.3s ease;
                padding: 1rem 0;
                overflow-y: auto;
                display: block;
                border-right: 1px solid rgba(0, 0, 0, 0.1);
            }

            /* Hide mobile sidebar when collapsed */
            body.sidebar-collapse .mobile-sidebar {
                left: -250px;
            }

            /* Overlay backdrop when sidebar open */
            .mobile-sidebar::before {
                content: '';
                position: fixed;
                top: 57px;
                left: 250px;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 899;
            }

            body.sidebar-collapse .mobile-sidebar::before {
                display: none;
            }

            /* TABLE RESPONSIVENESS - Horizontal Scroll */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                display: block;
            }

            .table {
                min-width: 100%;
                margin-bottom: 1rem;
                font-size: 0.9rem;
            }

            .table thead th {
                padding: 0.5rem;
                font-size: 0.85rem;
                white-space: nowrap;
            }

            .table tbody td {
                padding: 0.5rem;
                white-space: nowrap;
            }

            .table tbody tr:nth-child(odd) {
                background-color: rgba(0, 0, 0, 0.02);
            }

            /* CONTENT OPTIMIZATION */
            .content-header {
                padding: 0.5rem 1rem;
            }

            .content-header h1 {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .card {
                margin-bottom: 1rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                padding: 0.75rem;
            }

            .card-body {
                padding: 1rem;
            }

            /* FORM OPTIMIZATION */
            .form-group {
                margin-bottom: 1rem;
            }

            .form-control,
            .form-select {
                font-size: 1rem;
                padding: 0.5rem;
            }

            /* BUTTON OPTIMIZATION */
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .btn-group {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            /* BREADCRUMB MOBILE */
            .breadcrumb {
                font-size: 0.85rem;
                padding: 0.5rem 0;
                margin-bottom: 0.5rem;
            }

            /* DROPDOWN MENU */
            .dropdown-menu {
                font-size: 0.9rem;
                min-width: 150px;
            }
        }

        /* DESKTOP - Show original sidebar, reset to AdminLTE defaults */
        @media (min-width: 992px) {
            .main-sidebar {
                display: block !important;
            }

            .mobile-sidebar {
                display: none !important;
            }

            .mobile-sidebar::before {
                display: none !important;
            }
        }

    </style>
    
    @yield('extra_css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item d-md-none">
                <a class="nav-link" href="#" id="mobile-sidebar-toggle" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- MOBILE SIDEBAR - HANYA DI MOBILE -->
    <aside class="mobile-sidebar">
        <div style="padding: 1rem 0.5rem;">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.photo-slider') }}" class="nav-link {{ request()->routeIs('admin.photo-slider') ? 'active' : '' }}">
                <i class="nav-icon fas fa-images"></i>
                <span>Photo Slider</span>
            </a>
            <a href="{{ route('admin.kategori') }}" class="nav-link {{ request()->routeIs('admin.kategori') ? 'active' : '' }}">
                <i class="nav-icon fas fa-list"></i>
                <span>Kategori</span>
            </a>
            <a href="{{ route('admin.seniman') }}" class="nav-link {{ request()->routeIs('admin.seniman') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <span>Seniman</span>
            </a>
            <a href="{{ route('admin.karya-seni') }}" class="nav-link {{ request()->routeIs('admin.karya-seni') ? 'active' : '' }}">
                <i class="nav-icon fas fa-palette"></i>
                <span>Karya Seni</span>
            </a>
            <a href="{{ route('sambutan.edit') }}" class="nav-link {{ request()->routeIs('sambutan.edit') ? 'active' : '' }}">
                <i class="nav-icon fas fa-quote-left"></i>
                <span>Kata Sambutan</span>
            </a>
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Sidebar Container (Desktop) -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/img1.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Galery Admin</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Photo Slider -->
                    <li class="nav-item">
                        <a href="{{ route('admin.photo-slider') }}" class="nav-link {{ request()->routeIs('admin.photo-slider') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Photo Slider</p>
                        </a>
                    </li>

                    <!-- Kategori -->
                    <li class="nav-item">
                        <a href="{{ route('admin.kategori') }}" class="nav-link {{ request()->routeIs('admin.kategori') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Kategori</p>
                        </a>
                    </li>

                    <!-- Seniman -->
                    <li class="nav-item">
                        <a href="{{ route('admin.seniman') }}" class="nav-link {{ request()->routeIs('admin.seniman') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Seniman</p>
                        </a>
                    </li>

                    <!-- Karya Seni -->
                    <li class="nav-item">
                        <a href="{{ route('admin.karya-seni') }}" class="nav-link {{ request()->routeIs('admin.karya-seni') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>Karya Seni</p>
                        </a>
                    </li>

                    <!-- Kata Sambutan -->
                    <li class="nav-item">
                        <a href="{{ route('sambutan.edit') }}" class="nav-link {{ request()->routeIs('sambutan.edit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-quote-left"></i>
                            <p>Kata Sambutan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <hr class="my-2">
                    </li>

                    <!-- Logout -->
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">@yield('page_title', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <i class="icon fa fa-check"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2025 <a href="#">Galery Sumbawa</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- Sparkline -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sparklines/2.1.2/jquery.sparkline.min.js"></script>
<!-- JQVMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.3.0/overlayscrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/pages/dashboard.js"></script> -->

<script>
    $(document).ready(function() {
        $('#mobile-sidebar-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $('body').toggleClass('sidebar-collapse');
            console.log('Toggle clicked, sidebar-collapse:', $('body').hasClass('sidebar-collapse'));
        });

        // Close sidebar when clicking on a nav link in mobile sidebar
        $('.mobile-sidebar a.nav-link').on('click', function() {
            if ($(window).width() <= 991) {
                $('body').addClass('sidebar-collapse');
            }
        });

        // Close sidebar when clicking on logout form
        $('#logout-form').on('click', function() {
            $('body').addClass('sidebar-collapse');
        });
    });
</script>

@yield('extra_js')
</body>
</html>
