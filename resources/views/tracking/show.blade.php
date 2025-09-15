@extends('public.layouts.app')

@section('title', 'Detail Status Permohonan')
@section('description', 'Detail status permohonan layanan PUPR Kabupaten Katingan')

@section('content')
<!-- Hero Section -->
<section class="py-4 text-white" style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="h3 fw-bold mb-2">Detail Status Permohonan</h1>
                <p class="mb-0">Nomor Permohonan: <strong>{{ $permohonan->nomor_permohonan }}</strong></p>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('public.tracking.index') }}" class="text-white-50">Lacak Status</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Section -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row">
            <!-- Left Column - Status Timeline -->
            <div class="col-lg-8 mb-4">
                <!-- Status Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="me-3 flex-shrink-0">
                                @php
                                    $statusColors = [
                                        'Diajukan' => 'warning',
                                        'Verifikasi' => 'info', 
                                        'Diproses' => 'primary',
                                        'Selesai' => 'success',
                                        'Ditolak' => 'danger'
                                    ];
                                    $statusColor = $statusColors[$permohonan->status] ?? 'secondary';
                                @endphp
                                <div class="bg-{{ $statusColor }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px;">
                                    <i class="bi bi-file-earmark-check text-{{ $statusColor }} fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1" style="color: var(--primary-color);">Status: {{ $permohonan->status }}</h4>
                                <p class="text-muted mb-0">Terakhir diperbarui: {{ $permohonan->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Progress Timeline -->
                        <div class="timeline">
                            @php
                                $statuses = ['Diajukan', 'Verifikasi', 'Diproses', 'Selesai'];
                                $currentStatusIndex = array_search($permohonan->status, $statuses);
                                if ($permohonan->status === 'Ditolak') {
                                    $currentStatusIndex = 1; // Show as stopped at verification
                                }
                            @endphp

                            @foreach($statuses as $index => $status)
                                @php
                                    $isCompleted = $index <= $currentStatusIndex && $permohonan->status !== 'Ditolak';
                                    $isCurrent = $index === $currentStatusIndex && $permohonan->status !== 'Ditolak';
                                    $isRejected = $permohonan->status === 'Ditolak' && $index === 1;
                                @endphp
                                
                                <div class="timeline-item {{ $isCompleted || $isCurrent || $isRejected ? 'active' : '' }}">
                                    <div class="timeline-marker {{ $isCompleted ? 'completed' : ($isCurrent || $isRejected ? 'current' : '') }}">
                                        @if($isCompleted && !$isRejected)
                                            <i class="bi bi-check"></i>
                                        @elseif($isRejected)
                                            <i class="bi bi-x"></i>
                                        @elseif($isCurrent)
                                            <i class="bi bi-clock"></i>
                                        @else
                                            <span>{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1">
                                            @if($isRejected)
                                                Ditolak
                                            @else
                                                {{ $status }}
                                            @endif
                                        </h6>
                                        <p class="text-muted small mb-0">
                                            @if($status === 'Diajukan')
                                                Permohonan telah diterima dan terdaftar dalam sistem
                                            @elseif($status === 'Verifikasi')
                                                @if($isRejected)
                                                    Permohonan tidak memenuhi syarat dan ditolak
                                                @else
                                                    Dokumen dan persyaratan sedang diverifikasi
                                                @endif
                                            @elseif($status === 'Diproses')
                                                Permohonan sedang diproses oleh tim terkait
                                            @elseif($status === 'Selesai')
                                                Permohonan telah selesai diproses
                                            @endif
                                        </p>
                                        @if($isCompleted || $isCurrent || $isRejected)
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ $permohonan->created_at->format('d M Y') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            @if($permohonan->status === 'Ditolak')
                                <div class="alert alert-danger mt-3">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Permohonan Ditolak</strong>
                                    <p class="mb-0 mt-2">Mohon periksa kembali dokumen dan persyaratan, kemudian ajukan permohonan baru.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Catatan/Keterangan -->
                @if($permohonan->catatan)
                <div class="card border-0 shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--primary-color);">
                            <i class="bi bi-chat-text me-2"></i>Catatan
                        </h5>
                        <div class="bg-light rounded-3 p-3">
                            <p class="mb-0">{{ $permohonan->catatan }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Detail Information -->
            <div class="col-lg-4">
                <!-- Detail Permohonan -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--primary-color);">
                            <i class="bi bi-info-circle me-2"></i>Detail Permohonan
                        </h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Nama Pemohon</label>
                            <p class="mb-0">{{ $permohonan->nama_pemohon }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Jenis Layanan</label>
                            <p class="mb-0">{{ $permohonan->layanan->nama ?? 'Layanan tidak ditemukan' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Tanggal Pengajuan</label>
                            <p class="mb-0">{{ $permohonan->created_at->format('d F Y') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Email</label>
                            <p class="mb-0">{{ $permohonan->email }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">No. Telepon</label>
                            <p class="mb-0">{{ $permohonan->no_telepon }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dokumen -->
                @if($permohonan->dokumen)
                <div class="card border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--primary-color);">
                            <i class="bi bi-paperclip me-2"></i>Dokumen
                        </h5>
                        
                        @php
                            $dokumen = is_string($permohonan->dokumen) ? json_decode($permohonan->dokumen, true) : $permohonan->dokumen;
                        @endphp
                        
                        @if($dokumen && is_array($dokumen))
                            @foreach($dokumen as $file)
                                @php
                                    $filePath = 'storage/' . $file;
                                    $fileName = basename($file);
                                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                    $isPdf = $fileExtension === 'pdf';
                                    $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                                @endphp
                                
                                <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                    <div class="me-3">
                                        @if($isPdf)
                                            <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                                        @elseif($isImage)
                                            <i class="bi bi-file-earmark-image text-primary fs-4"></i>
                                        @else
                                            <i class="bi bi-file-earmark text-secondary fs-4"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">{{ Str::limit($fileName, 30) }}</small>
                                        <a href="{{ asset($filePath) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Lihat
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted small">Tidak ada dokumen</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="card border-0 shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold mb-3">Butuh Bantuan?</h6>
                        <a href="{{ route('public.tracking.index') }}" class="btn btn-outline-primary btn-sm me-2">
                            <i class="bi bi-arrow-left me-1"></i>Lacak Lain
                        </a>
                        <a href="{{ route('public.home') }}#contact" class="btn btn-warning btn-sm text-dark">
                            <i class="bi bi-telephone me-1"></i>Hubungi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.timeline {
    position: relative;
    padding-left: 0;
}

.timeline-item {
    position: relative;
    padding-left: 60px;
    margin-bottom: 30px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    height: calc(100% + 10px);
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-item.active:before {
    background-color: #0d6efd;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
    border: 3px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
    color: #6c757d;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-marker.completed {
    background-color: #198754;
    color: white;
}

.timeline-marker.current {
    background-color: #0d6efd;
    color: white;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
    }
}

.timeline-content h6 {
    color: #495057;
}

.timeline-item.active .timeline-content h6 {
    color: #0d6efd;
}

/* Responsive fixes for mobile */
@media (max-width: 768px) {
    .timeline-item {
        padding-left: 50px;
    }
    
    .timeline-marker {
        width: 35px;
        height: 35px;
        font-size: 12px;
    }
    
    .timeline-item:before {
        left: 17px;
    }
    
    .d-flex .flex-shrink-0 > div {
        width: 50px !important;
        height: 50px !important;
        min-width: 50px !important;
    }
    
    .d-flex .flex-shrink-0 i {
        font-size: 1.2rem !important;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .timeline-item {
        padding-left: 45px;
        margin-bottom: 25px;
    }
    
    .timeline-marker {
        width: 30px;
        height: 30px;
        font-size: 11px;
    }
    
    .timeline-item:before {
        left: 15px;
    }
    
    .d-flex .flex-shrink-0 > div {
        width: 45px !important;
        height: 45px !important;
        min-width: 45px !important;
    }
    
    .d-flex .flex-shrink-0 i {
        font-size: 1rem !important;
    }
}
</style>
@endsection
