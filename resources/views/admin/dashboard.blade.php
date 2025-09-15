@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan statistik dan informasi sistem')

@section('content')
<!-- Stats Cards -->
<div class="row g-3 mb-4 fade-in-up">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-warning me-3">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Total Berita</p>
                        <h5 class="mb-0 fw-bold">{{ $totalBerita }}</h5>
                        <small class="text-muted">
                            @if($beritaPercentage > 0)
                                <i class="bi bi-arrow-up text-success me-1"></i>+{{ $beritaPercentage }}%
                            @elseif($beritaPercentage < 0)
                                <i class="bi bi-arrow-down text-danger me-1"></i>{{ $beritaPercentage }}%
                            @else
                                <i class="bi bi-dash text-muted me-1"></i>0%
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-primary me-3">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Total Program</p>
                        <h5 class="mb-0 fw-bold">{{ $totalProgram }}</h5>
                        <small class="text-muted">
                            @if($programPercentage > 0)
                                <i class="bi bi-arrow-up text-success me-1"></i>+{{ $programPercentage }}%
                            @elseif($programPercentage < 0)
                                <i class="bi bi-arrow-down text-danger me-1"></i>{{ $programPercentage }}%
                            @else
                                <i class="bi bi-dash text-muted me-1"></i>0%
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-success me-3">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Program Berjalan</p>
                        <h5 class="mb-0 fw-bold">{{ $programBerjalan }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-clock text-muted me-1"></i>Aktif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-danger me-3">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Pengaduan Baru</p>
                        <h5 class="mb-0 fw-bold">{{ $pengaduanBaru }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-plus-circle text-info me-1"></i>Pending
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row Stats -->
<div class="row g-3 mb-4 fade-in-up">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-info me-3">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Total Ulasan</p>
                        <h5 class="mb-0 fw-bold">{{ $totalUlasan }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-people text-info me-1"></i>Dari Masyarakat
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-success me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Ulasan Published</p>
                        <h5 class="mb-0 fw-bold">{{ $ulasanPublished }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-eye text-success me-1"></i>Ditampilkan
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-warning me-3">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Menunggu Review</p>
                        <h5 class="mb-0 fw-bold">{{ $totalUlasan - $ulasanPublished }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-hourglass text-warning me-1"></i>Pending
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-primary me-3">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 fw-medium small">Staff Aktif</p>
                        <h5 class="mb-0 fw-bold">{{ $totalStaffAktif }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-people text-primary me-1"></i>Pegawai
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Management Section (Super Admin Only) -->
@if(auth()->user()->isSuperAdmin() && $adminStats)
<div class="row g-3 mb-4 fade-in-up">
    <div class="col-12">
        <div class="card shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-shield-check text-white fs-6"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-white">Manajemen Admin</h6>
                        <small class="text-white opacity-75">Statistik dan kontrol administrator sistem</small>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('admin.admin-management.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-gear me-1"></i>Kelola Admin
                        </a>
                    </div>
                </div>
                
                <div class="row g-2">
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-2 text-center">
                            <h6 class="mb-1 fw-bold text-white">{{ $adminStats['totalAdmins'] }}</h6>
                            <small class="text-white opacity-75">Total Admin</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-2 text-center">
                            <h6 class="mb-1 fw-bold text-white">{{ $adminStats['activeAdmins'] }}</h6>
                            <small class="text-white opacity-75">Admin Aktif</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-2 text-center">
                            <h6 class="mb-1 fw-bold text-white">{{ $adminStats['newAdminsThisMonth'] }}</h6>
                            <small class="text-white opacity-75">Baru Bulan Ini</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-2 text-center">
                            <h6 class="mb-1 fw-bold text-white">{{ $adminStats['recentLogins'] }}</h6>
                            <small class="text-white opacity-75">Login 7 Hari Terakhir</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Chart and Quick Actions Section -->
<div class="row g-4 fade-in-up">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-warning me-3">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">Statistik Bulanan</h5>
                        <small class="text-muted">Data Berita dan Program per Bulan</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 320px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-warning me-3">
                        <i class="bi bi-lightning"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">Akses Cepat</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('admin.konten.berita.create') }}" class="btn btn-outline-primary d-flex align-items-center text-start">
                        <div class="icon-circle icon-primary me-3">
                            <i class="bi bi-plus"></i>
                        </div>
                        <span class="fw-medium">Tambah Berita</span>
                    </a>
                    <a href="{{ route('admin.konten.program.create') }}" class="btn btn-outline-success d-flex align-items-center text-start">
                        <div class="icon-circle icon-success me-3">
                            <i class="bi bi-plus"></i>
                        </div>
                        <span class="fw-medium">Tambah Program</span>
                    </a>
                    
                    @if(auth()->user()->isSuperAdmin() && $totalSoftDeleted > 0)
                    <a href="{{ route('admin.soft-deleted.index') }}" class="btn btn-outline-danger d-flex align-items-center text-start">
                        <div class="icon-circle icon-danger me-3">
                            <i class="bi bi-trash"></i>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-medium">Data Terhapus</span>
                            <small class="text-muted d-block">{{ $totalSoftDeleted }} item</small>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        @if(auth()->user()->isSuperAdmin() && $totalSoftDeleted > 0)
        <!-- Soft Deleted Stats Card -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-danger me-3">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">Data Terhapus</h5>
                        <small class="text-muted">Recycle Bin - Data yang dapat dikembalikan</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($softDeletedStats as $type => $count)
                        @if($count > 0)
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-lg">
                                <div>
                                    <p class="mb-0 text-muted small">{{ ucfirst(str_replace('_', ' ', $type)) }}</p>
                                    <h6 class="mb-0 fw-bold">{{ $count }}</h6>
                                </div>
                                <div class="text-danger">
                                    <i class="bi bi-{{ $type === 'berita' ? 'newspaper' : ($type === 'program' ? 'clipboard-check' : ($type === 'galeri' ? 'images' : 'file-text')) }}"></i>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.soft-deleted.index') }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-eye me-2"></i>Kelola Data Terhapus
                    </a>
                    <a href="{{ route('admin.examples.delete-confirmation-demo') }}" class="btn btn-outline-info btn-sm ms-2">
                        <img src="{{ asset('icon/Done.gif') }}" alt="Demo" style="width: 16px; height: 16px; margin-right: 5px;">
                        Demo Konfirmasi Delete
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart with real data from database
    const chartElement = document.getElementById('monthlyChart');
    
    if (chartElement) {
        const ctx = chartElement.getContext('2d');
        
        try {
            const monthlyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($monthLabels ?? []),
                    datasets: [{
                        label: 'Berita',
                        data: @json($monthlyBerita ?? []),
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#dc3545',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                    }, {
                        label: 'Program',
                        data: @json($monthlyProgram ?? []),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#dee2e6',
                            borderWidth: 1
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f8f9fa',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return Math.floor(value);
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error creating chart:', error);
            chartElement.innerHTML = '<div class="text-center p-4"><p class="text-muted">Error loading chart</p></div>';
        }
    }
});
</script>
@endpush
