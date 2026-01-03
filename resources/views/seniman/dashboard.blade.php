@extends('layouts.seniman')

@section('title', 'Dashboard - Seniman')
@section('page_title', 'Dashboard')

@section('extra-css')
    <style>
        .small-box {
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .small-box .inner {
            padding: 10px 15px;
        }

        .small-box h3 {
            font-size: 2.2rem;
            font-weight: bold;
            margin: 0;
        }

        .small-box p {
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        .small-box .icon {
            position: absolute;
            top: -10px;
            right: 15px;
            z-index: 0;
            font-size: 90px;
            opacity: 0.1;
        }

        .bg-info { background-color: #17a2b8 !important; color: white; }
        .bg-success { background-color: #28a745 !important; color: white; }
        .bg-warning { background-color: #ffc107 !important; color: black; }
        .bg-danger { background-color: #dc3545 !important; color: white; }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: bold;
        }

        .card-tools {
            float: right;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-primary { background-color: #007bff; color: white; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
    </style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Stats Row -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalKarya }}</h3>
                        <p>Total Karya</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-image"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalPending }}</h3>
                        <p>Menunggu Persetujuan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalApproved }}</h3>
                        <p>Diterima</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalRejected }}</h3>
                        <p>Ditolak</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>

  
@endsection

@section('extra-js')
    <script>
        // Open detail modal
        document.querySelectorAll('.btn-detail-karya').forEach(button => {
            button.addEventListener('click', function() {
                const karyaId = this.getAttribute('data-karya-id');
                fetch(`/seniman/karya/${karyaId}`)
                    .then(response => response.json())
                    .then(data => {
                        alert('Detail Karya: ' + data.judul);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
