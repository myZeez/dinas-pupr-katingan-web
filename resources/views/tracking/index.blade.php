@extends('public.layouts.app')

@section('title', 'Lacak Status Permohonan')
@section('description', 'Lacak status permohonan layanan PUPR Kabupaten Katingan')

@section('content')
<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="display-5 fw-bold mb-3">Lacak Status Permohonan</h1>
                <p class="lead mb-0">Masukkan nomor permohonan Anda untuk melihat status terkini dan progress pengajuan layanan</p>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Lacak Status</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Section -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Alert Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert" data-aos="fade-down">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert" data-aos="fade-down">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search Form Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-5" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; min-width: 80px;">
                                <i class="bi bi-search text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-2" style="color: var(--primary-color);">Cek Status Permohonan</h3>
                            <p class="text-muted">Masukkan nomor permohonan untuk melihat status terkini</p>
                        </div>

                        <form action="{{ route('public.tracking.track') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <div class="mb-4">
                                        <label for="nomor_permohonan" class="form-label fw-semibold text-dark">
                                            Nomor Permohonan
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-lg @error('nomor_permohonan') is-invalid @enderror" 
                                               id="nomor_permohonan" 
                                               name="nomor_permohonan" 
                                               placeholder="Contoh: PL-20250809-001 atau 1"
                                               value="{{ old('nomor_permohonan') }}"
                                               required>
                                        @error('nomor_permohonan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle text-primary me-1"></i>
                                            Masukkan nomor permohonan yang Anda terima saat mengajukan layanan
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-warning btn-lg w-100 text-dark fw-bold">
                                        <i class="bi bi-search me-2"></i>
                                        Lacak Sekarang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="row g-4 mb-5">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card border-0 h-100 text-center p-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-speedometer2 text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Mudah & Cepat</h5>
                                <p class="text-muted small mb-0">Lacak status dengan mudah menggunakan nomor permohonan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card border-0 h-100 text-center p-4" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-clock-history text-success" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Real-time</h5>
                                <p class="text-muted small mb-0">Status permohonan terupdate secara real-time</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card border-0 h-100 text-center p-4" style="background: linear-gradient(135deg, #fff3e0 0%, #ffcc02 100%);">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="bi bi-shield-check text-warning" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Aman</h5>
                                <p class="text-muted small mb-0">Data permohonan Anda terjamin keamanannya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Help Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4" data-aos="fade-up">
                    <h3 class="fw-bold mb-3" style="color: var(--primary-color);">Butuh Bantuan?</h3>
                    <p class="text-muted">Panduan dan informasi untuk menggunakan fitur tracking</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-question-circle text-warning"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-2">Nomor tidak ditemukan?</h6>
                                <p class="text-muted small mb-0">Pastikan nomor permohonan yang dimasukkan benar dan sesuai dengan yang diterima saat pengajuan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-telephone text-success"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-2">Butuh bantuan lebih?</h6>
                                <p class="text-muted small mb-0">Hubungi layanan pelanggan atau datang langsung ke kantor Dinas PUPR.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('public.layanan') }}" class="btn btn-outline-primary me-3">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Layanan
                    </a>
                    <a href="{{ route('public.home') }}#contact" class="btn btn-primary">
                        <i class="bi bi-telephone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Responsive icon fixes */
@media (max-width: 768px) {
    .card-body i[style*="font-size: 3rem"] {
        font-size: 2.5rem !important;
    }
    
    .card-body i[style*="font-size: 2.5rem"] {
        font-size: 2rem !important;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .card-body i[style*="font-size: 3rem"] {
        font-size: 2rem !important;
    }
    
    .card-body i[style*="font-size: 2.5rem"] {
        font-size: 1.8rem !important;
    }
    
    .card-body {
        padding: 1rem !important;
    }
}
</style>
@endsection