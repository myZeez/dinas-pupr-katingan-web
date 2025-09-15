@extends('layouts.admin')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          datasets: [{
            label: 'Pengaduan',
            data: {!! json_encode($monthlyData['pengaduan']) !!},
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1
        }] class="h3 mb-0 text-gray-800">Analytics Dashboard</h1>
            <p class="text-muted">Analisis data dan statistik website</p>
        </div>
        <div>
            <a href="{{ route('admin.analytics.export') }}" class="btn btn-success">
                <i class="bi bi-download me-1"></i>
                Export Data
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-1">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Berita
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_berita']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-newspaper fa-lg text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-1">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pengaduan
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_pengaduan']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-chat-dots fa-lg text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Permohonan dihapus -->

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-1">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Downloads
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_downloads']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-download fa-lg text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Data Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Bulanan</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Rating Overview -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rating Rata-rata</h6>
                </div>
                <div class="card-body text-center">
                    <div class="display-4 text-warning mb-3">
                        {{ number_format($avgRating, 1) }}
                    </div>
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avgRating)
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-muted">Dari {{ $stats['total_ulasan'] }} ulasan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Charts Row -->
    <div class="row">
        <!-- Pengaduan Status -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengaduan</h6>
                </div>
                <div class="card-body">
                    <canvas id="pengaduanChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Permohonan dihapus -->
    </div>

    <!-- Popular Content Row -->
    <div class="row">
        <!-- Popular Videos -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Video Terpopuler</h6>
                </div>
                <div class="card-body">
                    @if($popularVideos->count() > 0)
                        @foreach($popularVideos as $video)
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-play-fill"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ Str::limit($video->title, 30) }}</h6>
                                <small class="text-muted">{{ number_format($video->views) }} views</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">Belum ada data video</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Popular Downloads -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">File Terpopuler</h6>
                </div>
                <div class="card-body">
                    @if($popularDownloads->count() > 0)
                        @foreach($popularDownloads as $file)
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ Str::limit($file->title, 30) }}</h6>
                                <small class="text-muted">{{ number_format($file->download_count) }} downloads</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">Belum ada data download</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Data Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyData['months']) !!},
        datasets: [{
            label: 'Berita',
            data: {!! json_encode($monthlyData['berita']) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }, {
            label: 'Pengaduan',
            data: {!! json_encode($monthlyData['pengaduan']) !!},
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1
        }, {
            label: 'Permohonan',
            data: {!! json_encode($monthlyData['permohonan']) !!},
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Pengaduan Status Chart
const pengaduanCtx = document.getElementById('pengaduanChart').getContext('2d');
const pengaduanChart = new Chart(pengaduanCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($pengaduanStats->keys()) !!},
        datasets: [{
            data: {!! json_encode($pengaduanStats->values()) !!},
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Chart Permohonan dihapus

</script>
@endpush
