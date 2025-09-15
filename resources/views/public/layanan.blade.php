@extends('public.layouts.app')

@section('title', 'Layanan Permohonan')
@section('description', 'Layanan permohonan infrastruktur Dinas PUPR Kabupaten Katingan')

@section('content')
<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="display-5 fw-bold mb-3">Layanan Permohonan</h1>
                <p class="lead mb-0">Pilih layanan perizinan yang Anda butuhkan atau ajukan permohonan umum untuk kemajuan infrastruktur Kabupaten Katingan</p>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Layanan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Services Info Section -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="fw-bold mb-3" style="color: var(--primary-color);">Layanan yang Tersedia</h2>
                <p class="text-muted">Dinas PUPR Kabupaten Katingan menyediakan berbagai layanan perizinan untuk mendukung pembangunan infrastruktur</p>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- IMB Service -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('public.layanan.form', 'imb') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 shadow-sm rounded-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-3 bg-warning bg-opacity-10 p-3 mb-3 d-inline-flex">
                                <i class="bi bi-building text-warning fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--primary-color);">Izin Mendirikan Bangunan</h5>
                            <p class="text-muted small mb-3">Permohonan IMB untuk pembangunan gedung, rumah, dan bangunan lainnya sesuai peraturan yang berlaku</p>
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">IMB</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- SBG Service -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('public.layanan.form', 'sbg') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 shadow-sm rounded-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-3 bg-success bg-opacity-10 p-3 mb-3 d-inline-flex">
                                <i class="bi bi-shield-check text-success fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--primary-color);">Surat Bukti Gangguan</h5>
                            <p class="text-muted small mb-3">Permohonan SBG untuk usaha yang berpotensi menimbulkan gangguan lingkungan</p>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">SBG</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- RTBL Service -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('public.layanan.form', 'rtbl') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 shadow-sm rounded-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-3 bg-info bg-opacity-10 p-3 mb-3 d-inline-flex">
                                <i class="bi bi-map text-info fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--primary-color);">Rencana Tata Bangunan</h5>
                            <p class="text-muted small mb-3">Permohonan RTBL untuk perencanaan tata ruang dan bangunan kawasan</p>
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">RTBL</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Advice Planning Service -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('public.layanan.form', 'advice_planning') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 shadow-sm rounded-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-3 bg-primary bg-opacity-10 p-3 mb-3 d-inline-flex">
                                <i class="bi bi-lightbulb text-primary fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--primary-color);">Advice Planning</h5>
                            <p class="text-muted small mb-3">Konsultasi dan saran perencanaan pembangunan infrastruktur</p>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Konsultasi</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- PKKPR Service -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <a href="{{ route('public.layanan.form', 'pkkpr') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 shadow-sm rounded-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-3 bg-danger bg-opacity-10 p-3 mb-3 d-inline-flex">
                                <i class="bi bi-tools text-danger fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--primary-color);">PKKPR</h5>
                            <p class="text-muted small mb-3">Permohonan Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang</p>
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">PKKPR</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- General Application -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="card border-2 border-primary h-100 shadow-sm rounded-4 bg-primary bg-opacity-5">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-3 bg-primary bg-opacity-10 p-3 mb-3 d-inline-flex">
                            <i class="bi bi-file-earmark-text text-primary fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--primary-color);">Permohonan Umum</h5>
                        <p class="text-muted small mb-3">Gunakan form di bawah untuk permohonan layanan umum lainnya</p>
                        <span class="badge bg-primary px-3 py-2 rounded-pill text-white">Form Utama</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sistem permohonan layanan telah dihapus -->
<!-- Redirect ke pengaduan untuk permohonan umum -->

<!-- CTA Section -->

                        <form action="{{ route('public.pengaduan.store') }}" method="POST" enctype="multipart/form-data" id="permohonanForm" class="space-y-6">
                            @csrf
                            
                            <!-- Data Pemohon Section -->
                            <div class="bg-light rounded-4 border-0 mb-4 transition-all duration-300 hover:shadow-lg" data-aos="fade-up">
                                <div class="p-4">
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-2">
                                        <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                                            <i class="bi bi-person text-primary fs-4"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0 text-dark">Data Pemohon</h5>
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nama" class="form-label fw-semibold text-dark">
                                                Nama Lengkap <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control rounded-3 border-2 py-3 px-4 transition-all duration-200 @error('nama') is-invalid @enderror" 
                                                   id="nama" name="nama" value="{{ old('nama') }}" 
                                                   placeholder="Masukkan nama lengkap" required>
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="nik" class="form-label fw-semibold text-dark">
                                                NIK <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control rounded-3 border-2 py-3 px-4 transition-all duration-200 @error('nik') is-invalid @enderror" 
                                                   id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" 
                                                   placeholder="16 digit NIK" required>
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-semibold text-dark">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" 
                                                   class="form-control rounded-3 border-2 py-3 px-4 transition-all duration-200 @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" 
                                                   placeholder="contoh@email.com" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="telepon" class="form-label fw-semibold text-dark">
                                                Nomor Telepon <span class="text-danger">*</span>
                                            </label>
                                            <input type="tel" 
                                                   class="form-control rounded-3 border-2 py-3 px-4 transition-all duration-200 @error('telepon') is-invalid @enderror" 
                                                   id="telepon" name="telepon" value="{{ old('telepon') }}" 
                                                   placeholder="08xxxxxxxxxx" required>
                                            @error('telepon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="alamat" class="form-label fw-semibold text-dark">
                                                Alamat <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control rounded-3 border-2 py-3 px-4 transition-all duration-200 @error('alamat') is-invalid @enderror" 
                                                      id="alamat" name="alamat" rows="3" 
                                                      placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Layanan Section -->
                            <div class="bg-light rounded-4 border-0 mb-4 transition-all duration-300 hover:shadow-lg" data-aos="fade-up" data-aos-delay="100">
                                <div class="p-4">
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-2">
                                        <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3">
                                            <i class="bi bi-clipboard-check text-success fs-4"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0 text-dark">Jenis Layanan</h5>
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="jenis_layanan" class="form-label fw-semibold text-dark">
                                                Pilih Jenis Layanan <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select rounded-3 border-2 py-3 px-4 transition-all duration-200 @error('jenis_layanan') is-invalid @enderror" 
                                                    id="jenis_layanan" name="jenis_layanan" required>
                                                <option value="">-- Pilih Jenis Layanan --</option>
                                                <option value="permohonan_imb" {{ old('jenis_layanan') == 'permohonan_imb' ? 'selected' : '' }}>
                                                    Permohonan Izin Mendirikan Bangunan (IMB)
                                                </option>
                                                <option value="permohonan_sbg" {{ old('jenis_layanan') == 'permohonan_sbg' ? 'selected' : '' }}>
                                                    Permohonan Surat Bukti Gangguan (SBG)
                                                </option>
                                                <option value="permohonan_rtbl" {{ old('jenis_layanan') == 'permohonan_rtbl' ? 'selected' : '' }}>
                                                    Permohonan Rencana Tata Bangunan dan Lingkungan (RTBL)
                                                </option>
                                                <option value="permohonan_advice_planning" {{ old('jenis_layanan') == 'permohonan_advice_planning' ? 'selected' : '' }}>
                                                    Permohonan Advice Planning
                                                </option>
                                                <option value="permohonan_pkkpr" {{ old('jenis_layanan') == 'permohonan_pkkpr' ? 'selected' : '' }}>
                                                    Permohonan Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR)
                                                </option>
                                            </select>
                                            @error('jenis_layanan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="deskripsi" class="form-label fw-semibold text-dark">
                                                Deskripsi Permohonan <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control rounded-3 border-2 py-3 px-4 transition-all duration-200 @error('deskripsi') is-invalid @enderror" 
                                                      id="deskripsi" name="deskripsi" rows="4" 
                                                      placeholder="Jelaskan detail permohonan Anda..." required>{{ old('deskripsi') }}</textarea>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Dokumen Section -->
                            <div class="bg-light rounded-4 border-0 mb-4 transition-all duration-300 hover:shadow-lg" 
                                 data-aos="fade-up" data-aos-delay="200" id="upload-section" style="display: none;">
                                <div class="p-4">
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-2">
                                        <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3">
                                            <i class="bi bi-cloud-upload text-info fs-4"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0 text-dark">Upload Dokumen Persyaratan</h5>
                                    </div>
                                    
                                    <div class="text-center mb-4 p-4 rounded-3 border-2 border-dashed border-primary bg-primary bg-opacity-5">
                                        <i class="bi bi-cloud-arrow-up text-primary mb-3" style="font-size: 3rem;"></i>
                                        <h6 class="fw-bold text-dark mb-2">Upload Dokumen Persyaratan</h6>
                                        <p class="text-muted mb-0 small">
                                            Format yang diterima: PDF, DOC, DOCX, JPG, PNG<br>
                                            Maksimal ukuran file: 5MB per dokumen
                                        </p>
                                    </div>
                                    
                                    <div id="upload-fields" class="space-y-3">
                                        <!-- Dynamic upload fields will be generated here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Section -->
                            <div class="text-center pt-4 border-top border-2">
                                <div class="mb-4">
                                    <p class="text-muted mb-3 fs-6">
                                        Pastikan semua data dan dokumen telah diisi dengan benar sebelum mengirim permohonan.
                                    </p>
                                    <p class="text-primary fw-semibold small">
                                        <i class="bi bi-clock me-1"></i>
                                        Permohonan akan diproses dalam waktu 5-14 hari kerja.
                                    </p>
                                </div>
                                
                                <button type="submit" 
                                        class="btn btn-primary btn-lg px-5 py-3 rounded-3 fw-bold transition-all duration-200 hover:shadow-lg" 
                                        id="submitBtn">
                                    <i class="bi bi-send me-2"></i>Ajukan Permohonan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--primary-color) 0%, #e6a200 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h3 class="fw-bold mb-3">Butuh Bantuan?</h3>
                <p class="mb-0">Hubungi kami jika Anda membutuhkan bantuan dalam mengajukan permohonan layanan infrastruktur.</p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <a href="{{ route('public.kontak') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-chat-dots me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Utility Classes - Tailwind-like */
.transition-all { transition: all 0.3s ease; }
.duration-200 { transition-duration: 200ms; }
.duration-300 { transition-duration: 300ms; }
.hover\:shadow-lg:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
.hover\:transform:hover { transform: translateY(-8px); }
.hover\:-translate-y-1:hover { transform: translateY(-0.25rem); }
.space-y-3 > * + * { margin-top: 0.75rem; }
.space-y-6 > * + * { margin-top: 1.5rem; }

/* Breadcrumb Styling */
.breadcrumb-item a {
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}

/* Form Controls */
.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.form-control:hover, .form-select:hover {
    border-color: #94a3b8;
}

/* Upload Item Styling */
.upload-item {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
    position: relative;
}

.upload-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
    border-radius: 12px 0 0 12px;
}

.upload-item:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Button Enhancements */
.btn:hover {
    transform: translateY(-1px);
}

/* Animation for AOS fallback */
[data-aos] {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

[data-aos].aos-animate {
    opacity: 1;
    transform: translateY(0);
}

/* File Input Custom Styling */
.file-input::-webkit-file-upload-button {
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    margin-right: 12px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
}

.file-input::-webkit-file-upload-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Enhanced Notification Modal Styles */
#notificationModal .modal-content {
    animation: modalSlideIn 0.3s ease-out;
    backdrop-filter: blur(10px);
}

#notificationModal .modal-backdrop {
    background: rgba(0, 0, 0, 0.6);
}

.notification-icon-container {
    animation: iconBounce 0.6s ease-out;
    position: relative;
}

.notification-icon-container::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: inherit;
    opacity: 0.3;
    animation: iconPulse 2s infinite;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

@keyframes iconBounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0, 0, 0);
    }
    40%, 43% {
        transform: translate3d(0, -10px, 0);
    }
    70% {
        transform: translate3d(0, -5px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

@keyframes iconPulse {
    0% {
        transform: scale(1);
        opacity: 0.3;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.1;
    }
    100% {
        transform: scale(1.2);
        opacity: 0;
    }
}

/* Modal button hover effects */
#notificationModal .btn {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

#notificationModal .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

#notificationModal .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

#notificationModal .btn:hover::before {
    left: 100%;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .rounded-4 { border-radius: 1rem !important; }
    .rounded-3 { border-radius: 0.75rem !important; }
    .py-3 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
    .px-4 { padding-left: 1rem !important; padding-right: 1rem !important; }
    
    #notificationModal .modal-dialog {
        margin: 1rem;
    }
    
    .notification-icon-container {
        width: 60px !important;
        height: 60px !important;
    }
    
    .notification-icon-container i {
        font-size: 2rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisLayananSelect = document.getElementById('jenis_layanan');
    const uploadSection = document.getElementById('upload-section');
    const uploadFields = document.getElementById('upload-fields');
    const form = document.getElementById('permohonanForm');
    
    // Document requirements based on service type
    const documentRequirements = {
        'permohonan_imb': [
            'KTP Pemohon',
            'Surat Permohonan',
            'Sertifikat Tanah/Bukti Kepemilikan',
            'Gambar Situasi',
            'Gambar Denah',
            'Gambar Tampak',
            'Gambar Potongan',
            'Perhitungan Struktur',
            'Dokumen Lingkungan (jika diperlukan)'
        ],
        'permohonan_sbg': [
            'KTP Pemohon',
            'Surat Permohonan',
            'IMB/PBG',
            'Gambar As Built Drawing',
            'Dokumen Spesifikasi Teknis',
            'Hasil Pengujian Struktur',
            'Sertifikat Instalasi (Listrik, Mekanikal, Plumbing)',
            'Dokumen K3 Bangunan'
        ],
        'permohonan_rtbl': [
            'KTP Pemohon',
            'Surat Permohonan',
            'Peta Dasar/Situasi Eksisting',
            'Dokumen Perencanaan',
            'Analisis Dampak Lalu Lintas',
            'Dokumen Lingkungan',
            'Rencana Tapak',
            'Konsep Desain'
        ],
        'permohonan_advice_planning': [
            'KTP Pemohon',
            'Surat Permohonan',
            'Peta Lokasi',
            'Data Teknis Bangunan/Kawasan',
            'Dokumen Pendukung Lainnya'
        ],
        'permohonan_pkkpr': [
            'KTP Pemohon',
            'Surat Permohonan',
            'Dokumen Rencana Kegiatan',
            'Peta Lokasi dan Situasi',
            'Analisis Kesesuaian Ruang',
            'Dokumen Lingkungan (jika diperlukan)',
            'Dokumen Teknis Pendukung'
        ]
    };
    
    // Handle service type change
    jenisLayananSelect.addEventListener('change', function() {
        const selectedService = this.value;
        
        if (selectedService && documentRequirements[selectedService]) {
            generateUploadFields(selectedService);
            uploadSection.style.display = 'block';
        } else {
            uploadSection.style.display = 'none';
            uploadFields.innerHTML = '';
        }
    });
    
    // Generate upload fields for selected service
    function generateUploadFields(serviceType) {
        const requirements = documentRequirements[serviceType];
        let fieldsHTML = '';
        
        requirements.forEach((requirement, index) => {
            fieldsHTML += `
                <div class="upload-item bg-white rounded-3 border border-2 p-3 mb-3 transition-all duration-200 hover:shadow-md">
                    <div class="row align-items-center g-3">
                        <div class="col-md-4">
                            <label class="form-label mb-0 fw-bold text-dark d-flex align-items-center">
                                <i class="bi bi-file-earmark text-primary me-2 fs-5"></i>
                                ${requirement}
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" 
                                   class="form-control rounded-3 border-2 py-2 px-3 file-input transition-all duration-200" 
                                   name="documents[]" 
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                   data-requirement="${requirement}">
                            <div class="form-text mt-2 small text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Format: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        uploadFields.innerHTML = fieldsHTML;
        
        // Add file validation to new inputs
        const fileInputs = uploadFields.querySelectorAll('.file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', validateFile);
        });
    }
    
    // File validation
    function validateFile(event) {
        const file = event.target.files[0];
        const input = event.target;
        
        if (!file) return;
        
        // Check file size (5MB = 5 * 1024 * 1024 bytes)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            showNotificationModal('warning', 'File Terlalu Besar', 'Ukuran file tidak boleh lebih dari 5MB. Silakan pilih file yang lebih kecil.');
            input.value = '';
            return;
        }
        
        // Check file type
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];
        
        if (!allowedTypes.includes(file.type)) {
            showNotificationModal('warning', 'Format File Tidak Didukung', 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, JPG, atau PNG.');
            input.value = '';
            return;
        }
    }
    
    // Form submission handling
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim Permohonan...';
        submitBtn.classList.add('opacity-75');
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Submit using fetch
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);
            
            if (response.ok) {
                return response.json();
            } else {
                // Try to get error details from response
                return response.text().then(text => {
                    console.error('Server response:', text);
                    throw new Error(`Server error: ${response.status} - ${text.substring(0, 200)}`);
                });
            }
        })
        .then(data => {
            console.log('Success response:', data);
            if (data.success) {
                // Show success modal
                showNotificationModal('success', 'Berhasil!', data.message || 'Permohonan berhasil diajukan!', () => {
                    window.location.href = data.redirect || '/';
                });
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            // Show error modal
            let errorMessage = 'Terjadi kesalahan saat mengirim permohonan.';
            if (error.message.includes('Server error')) {
                errorMessage += ' Detail: ' + error.message;
            } else {
                errorMessage += ' Silakan coba lagi.';
            }
            showNotificationModal('error', 'Terjadi Kesalahan', errorMessage);
        })
        .finally(() => {
            // Restore button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            submitBtn.classList.remove('opacity-75');
        });
    });
    
    // Enhanced form validation dengan utility classes
    const formInputs = document.querySelectorAll('.form-control, .form-select');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '' && this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
        
        // Real-time validation
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                if (this.checkValidity() && this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            }
        });
    });
    
    // NIK validation (16 digits)
    document.getElementById('nik').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 16);
    });
    
    // Phone number validation
    document.getElementById('telepon').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    // Enhanced Notification Modal Function
    function showNotificationModal(type, title, message, callback = null) {
        const iconMap = {
            'success': 'bi-check-circle-fill text-success',
            'error': 'bi-exclamation-triangle-fill text-danger',
            'warning': 'bi-exclamation-circle-fill text-warning',
            'info': 'bi-info-circle-fill text-info'
        };

        const colorMap = {
            'success': 'success',
            'error': 'danger',
            'warning': 'warning',
            'info': 'info'
        };

        // Remove existing modal if any
        const existingModal = document.getElementById('notificationModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Create modal HTML
        const modalHtml = `
            <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <div class="mb-4">
                                <div class="notification-icon-container mx-auto d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; border-radius: 50%; background: var(--bs-${colorMap[type]}) !important; background-opacity: 0.1;">
                                    <i class="bi ${iconMap[type]}" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: var(--bs-${colorMap[type]});">${title}</h4>
                            <p class="text-muted mb-4 lh-base">${message}</p>
                            <button type="button" class="btn btn-${colorMap[type]} btn-lg px-4 py-2 rounded-pill" data-bs-dismiss="modal" id="modalOkButton">
                                <i class="bi bi-check-lg me-2"></i>OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
        modal.show();

        // Add callback to OK button if provided
        if (callback) {
            document.getElementById('modalOkButton').addEventListener('click', callback);
            document.getElementById('notificationModal').addEventListener('hidden.bs.modal', callback);
        }

        // Auto remove modal after hiding
        document.getElementById('notificationModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }
});
</script>
@endpush
