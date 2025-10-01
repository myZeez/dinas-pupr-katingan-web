@extends('public.layouts.app')

@section('title', 'Struktur Organisasi')
@section('description', 'Struktur Organisasi Dinas PUPR Kabupaten Katingan - Kepemimpinan dan Staff')

@section('content')
<!-- Hero Section -->
<section class="py-4 text-white" style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="display-6 fw-bold mb-3">Struktur Organisasi</h1>
                <p class="lead mb-3 fs-6">Struktur Organisasi Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan</p>
                <div class="d-flex flex-wrap gap-2">
                    <div class="badge bg-light text-dark px-2 py-1 fs-7">
                        <i class="bi bi-people me-1"></i>{{ $strukturs->count() }} Personil
                    </div>
                    <div class="badge bg-light text-dark px-2 py-1 fs-7">
                        <i class="bi bi-diagram-3 me-1"></i>{{ $strukturs->pluck('jabatan')->unique()->count() }} Jabatan
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Struktur</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-4">
    <div class="container">
        @if($strukturs->count() > 0)
            <!-- Kepala Dinas -->
            @php
                $kepalaDinas = $strukturs->where('jabatan', 'kepala_dinas')->first();
                $sekretaris = $strukturs->where('jabatan', 'sekretaris')->first();
            @endphp

            @if($kepalaDinas)
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-3 text-primary fs-3">Pimpinan Dinas</h2>
                <div class="row justify-content-center" data-aos="fade-up">
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-lg h-100 leader-card">
                            <div class="card-body text-center p-4">
                                <div class="position-relative mb-4">
                                    @if($kepalaDinas->foto)
                                        <img src="{{ $kepalaDinas->foto_url }}"
                                             alt="{{ $kepalaDinas->nama }}"
                                             class="img-fluid rounded-circle mx-auto d-block leader-photo mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="default-avatar mx-auto" style="display: none;">
                                            <i class="bi bi-person fs-1 text-muted"></i>
                                        </div>
                                    @else
                                        <div class="default-avatar mx-auto">
                                            <i class="bi bi-person fs-1 text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <h4 class="fw-bold text-dark mb-2">{{ $kepalaDinas->nama }}</h4>
                                <p class="text-primary fw-semibold mb-3">{{ $kepalaDinas->jabatan_label }}</p>
                            </div>
                        </div>
                    </div>
                    @if($sekretaris)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-lg h-100 leader-card">
                            <div class="card-body text-center p-4">
                                <div class="position-relative mb-4">
                                    @if($sekretaris->foto)
                                        <img src="{{ $sekretaris->foto_url }}"
                                             alt="{{ $sekretaris->nama }}"
                                             class="img-fluid rounded-circle mx-auto d-block leader-photo mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="default-avatar mx-auto" style="display: none;">
                                            <i class="bi bi-person fs-1 text-muted"></i>
                                        </div>
                                    @else
                                        <div class="default-avatar mx-auto">
                                            <i class="bi bi-person fs-1 text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <h4 class="fw-bold text-dark mb-2">{{ $sekretaris->nama }}</h4>
                                <p class="text-primary fw-semibold mb-3">{{ $sekretaris->jabatan_label }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Filter Berdasarkan Jabatan -->
            @php
                $allJabatan = $strukturs->pluck('jabatan_label')->unique()->sort()->values();
            @endphp

            <div class="mb-4">
                <h2 class="fw-bold text-center mb-3 text-primary fs-4">Filter Berdasarkan Jabatan</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex flex-wrap justify-content-center gap-2 mb-2">
                                    <button class="btn btn-primary btn-sm active" onclick="filterJabatan('semua')" id="btn-semua">
                                        <i class="bi bi-people me-1"></i>Semua ({{ $strukturs->count() }})
                                    </button>
                                    @foreach($allJabatan as $jabatan)
                                        @php
                                            $count = $strukturs->where('jabatan_label', $jabatan)->count();
                                        @endphp
                                        <button class="btn btn-outline-primary btn-sm" onclick="filterJabatan('{{ Str::slug($jabatan) }}')" id="btn-{{ Str::slug($jabatan) }}">
                                            {{ $jabatan }} ({{ $count }})
                                        </button>
                                    @endforeach
                                </div>
                                <small class="text-muted d-block text-center fs-7">Klik tombol di atas untuk melihat anggota berdasarkan jabatan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Struktur Berdasarkan Jabatan (Hidden by default) -->
            @php
                // Group by jabatan
                $jabatanList = $strukturs->groupBy('jabatan')->sortKeys();
            @endphp

            @foreach($jabatanList as $namaJabatan => $anggotaJabatan)
            <div class="mb-4 jabatan-section" id="section-{{ Str::slug($namaJabatan) }}">
                <!-- Header Section dengan Judul dan Deskripsi Jabatan -->
                <div class="text-center mb-4 jabatan-header-section">
                    <h1 class="display-6 fw-bold jabatan-title mb-3">{{ $namaJabatan }}</h1>

                    @php
                        $deskripsiJabatan = '';
                        switch($namaJabatan) {
                            case 'Kepala Dinas':
                                $deskripsiJabatan = 'Kepala Dinas merupakan pimpinan tertinggi yang bertanggung jawab dalam menjalankan tugas pokok dan fungsi Dinas PUPR. Memimpin seluruh kegiatan perencanaan, pelaksanaan, monitoring dan evaluasi program pembangunan infrastruktur untuk meningkatkan kesejahteraan masyarakat.';
                                break;
                            case 'Sekretaris Dinas':
                                $deskripsiJabatan = 'Sekretaris Dinas bertugas menyelenggarakan koordinasi pelaksanaan tugas, pembinaan, dan pemberian dukungan administrasi kepada seluruh unsur organisasi. Mengkoordinasikan perencanaan, keuangan, umum dan kepegawaian untuk mendukung kelancaran operasional dinas.';
                                break;
                            case 'Kepala Bidang Bina Marga':
                                $deskripsiJabatan = 'Bidang Bina Marga bertanggung jawab dalam perencanaan, pelaksanaan, dan pemeliharaan infrastruktur jalan dan jembatan. Mengelola pembangunan jaringan transportasi yang aman, nyaman, dan berkelanjutan untuk mendukung mobilitas masyarakat dan pertumbuhan ekonomi daerah.';
                                break;
                            case 'Kepala Bidang Cipta Karya':
                                $deskripsiJabatan = 'Bidang Cipta Karya menangani pembangunan infrastruktur permukiman meliputi perumahan, air minum, dan sanitasi. Berkomitmen menciptakan lingkungan hunian yang layak, sehat, dan berkelanjutan bagi masyarakat dengan standar kualitas yang tinggi.';
                                break;
                            case 'Kepala Bidang Penataan Ruang':
                                $deskripsiJabatan = 'Bidang Penataan Ruang melaksanakan perencanaan tata ruang wilayah, pengendalian pemanfaatan ruang, dan pengawasan tata ruang. Mengatur pemanfaatan ruang yang optimal untuk keseimbangan pembangunan dan kelestarian lingkungan yang berkelanjutan.';
                                break;
                            case 'Kepala Sub Bagian Umum':
                                $deskripsiJabatan = 'Sub Bagian Umum mengelola administrasi umum, kepegawaian, perlengkapan, dan rumah tangga dinas. Memberikan dukungan administratif dan logistik untuk kelancaran operasional seluruh unit kerja di lingkungan Dinas PUPR dengan pelayanan yang profesional.';
                                break;
                            case 'Kepala Seksi Jalan':
                                $deskripsiJabatan = 'Seksi Jalan bertanggung jawab dalam pembangunan, pemeliharaan, dan rehabilitasi infrastruktur jalan kabupaten. Melaksanakan survei, perencanaan teknis, konstruksi, dan pengawasan mutu untuk memastikan kualitas jalan yang optimal dan tahan lama.';
                                break;
                            case 'Staff':
                                $deskripsiJabatan = 'Staff teknis yang melaksanakan tugas operasional dan administratif untuk mendukung pelaksanaan program kerja di berbagai bidang. Membantu dalam persiapan, pelaksanaan, dan evaluasi kegiatan sesuai dengan bidang tugasnya masing-masing.';
                                break;
                            default:
                                $deskripsiJabatan = 'Melaksanakan tugas dan fungsi sesuai dengan jabatan dalam struktur organisasi Dinas PUPR Kabupaten Katingan untuk mendukung pelayanan publik yang optimal.';
                        }
                    @endphp

                    <div class="row justify-content-center">
                        <div class="col-lg-9 col-xl-8">
                            <p class="jabatan-description mb-3 fs-6">
                                Personil yang bertugas pada jabatan {{ $jabatan }}
                            </p>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                                <div class="text-center">
                                    <h3 class="fw-bold text-primary mb-0">{{ $anggotaJabatan->count() }}</h3>
                                    <small class="text-muted">{{ $anggotaJabatan->count() > 1 ? 'Personil' : 'Personil' }}</small>
                                </div>
                                <div class="stats-divider" style="height: 40px;"></div>
                                <div class="text-center">
                                    <h3 class="fw-bold text-success mb-0">{{ $anggotaJabatan->where('is_active', true)->count() }}</h3>
                                    <small class="text-muted">Aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cards Section -->
                <div class="row g-3 justify-content-center">
                    @foreach($anggotaJabatan as $anggota)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card border-0 shadow-lg h-100 anggota-card-new">
                            <div class="card-body text-center p-3">
                                <!-- Photo Section -->
                                <div class="position-relative mb-4">
                                    @if($anggota->foto)
                                        <img src="{{ $anggota->foto_url }}"
                                             alt="{{ $anggota->nama }}"
                                             class="rounded-circle mx-auto d-block staff-photo-new"
                                             style="width: 100px; height: 100px; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="default-avatar-new mx-auto" style="display: none;">
                                            <i class="bi bi-person fs-2 text-primary"></i>
                                        </div>
                                    @else
                                        <div class="default-avatar-new mx-auto">
                                            <i class="bi bi-person fs-2 text-primary"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Name and Position -->
                                <h5 class="fw-bold text-dark mb-2">{{ $anggota->nama }}</h5>
                                <p class="text-primary fw-semibold mb-3">{{ $anggota->jabatan_label }}</p>

                                <div class="mb-3">
                                    <span class="badge bg-primary px-2 py-1 rounded-pill fs-7">
                                        {{ $anggota->jabatan }}
                                    </span>
                                </div>

                                @if($anggota->unit_kerja)
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-building me-2"></i>{{ $anggota->unit_kerja }}
                                    </p>
                                @endif

                                <!-- Detail Jabatan -->
                                @if($anggota->keterangan)
                                    <div class="detail-jabatan-new">
                                        <h6 class="text-primary fw-bold mb-2">Detail Jabatan</h6>
                                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                                            {!! nl2br(e($anggota->keterangan)) !!}
                                        </p>
                                    </div>
                                @endif

                                <!-- Additional Info -->
                                <div class="mt-3 pt-3 border-top">
                                    <div class="row text-center">
                                        @if($anggota->golongan)
                                            <div class="col-6">
                                                <small class="text-muted d-block">Golongan</small>
                                                <span class="badge bg-info text-white">{{ $anggota->golongan }}</span>
                                            </div>
                                        @endif
                                        @if($anggota->status)
                                            <div class="col-6">
                                                <small class="text-muted d-block">Status</small>
                                                <span class="badge {{ $anggota->status == 'aktif' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($anggota->status) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @else
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Data struktur organisasi belum tersedia.
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
function filterJabatan(jabatan) {
    // Reset semua tombol
    document.querySelectorAll('.btn').forEach(btn => {
        if (btn.id.startsWith('btn-')) {
            btn.classList.remove('btn-primary', 'active');
            btn.classList.add('btn-outline-primary');
        }
    });

    // Aktifkan tombol yang dipilih
    const activeBtn = document.getElementById('btn-' + jabatan);
    if (activeBtn) {
        activeBtn.classList.remove('btn-outline-primary');
        activeBtn.classList.add('btn-primary', 'active');
    }

    if (jabatan === 'semua') {
        // Tampilkan semua section jabatan
        document.querySelectorAll('.jabatan-section').forEach(section => {
            section.style.display = 'block';
        });
    } else {
        // Sembunyikan semua section jabatan
        document.querySelectorAll('.jabatan-section').forEach(section => {
            section.style.display = 'none';
        });

        // Tampilkan section jabatan yang dipilih
        const targetSection = document.getElementById('section-' + jabatan);
        if (targetSection) {
            targetSection.style.display = 'block';
            // Scroll ke section yang dipilih
            targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

// Animasi untuk card hover
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.anggota-card');

    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

<style>
/* Custom utility class for smaller text */
.fs-7 {
    font-size: 0.85rem !important;
}

.anggota-card {
    transition: all 0.3s ease;
    border-radius: 15px;
}

.anggota-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.staff-photo {
    border: 3px solid #e9ecef;
    transition: border-color 0.3s ease;
}

.anggota-card:hover .staff-photo {
    border-color: var(--bs-primary);
}

.default-avatar-small, .default-avatar-medium {
    border: 3px solid #e9ecef;
    transition: border-color 0.3s ease;
}

.anggota-card:hover .default-avatar-small,
.anggota-card:hover .default-avatar-medium {
    border-color: var(--bs-primary);
}

.btn {
    transition: all 0.3s ease;
    border-radius: 25px;
}

.btn:hover {
    transform: translateY(-2px);
}

.leader-card {
    transition: all 0.3s ease;
}

.leader-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.leader-photo {
    border: 4px solid #ffffff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* New card design based on the provided mockup */
.anggota-card-new {
    transition: all 0.3s ease;
    border-radius: 20px;
    border: 1px solid #e3f2fd;
    overflow: hidden;
    background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
}

.anggota-card-new:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(33, 150, 243, 0.12) !important;
    border-color: #2196f3;
}

.staff-photo-new {
    border: 4px solid #e3f2fd;
    transition: all 0.3s ease;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
}

.anggota-card-new:hover .staff-photo-new {
    border-color: #2196f3;
    box-shadow: 0 10px 25px rgba(33, 150, 243, 0.25);
}

.default-avatar-new {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid #e3f2fd;
    margin: 0 auto;
}

.anggota-card-new:hover .default-avatar-new {
    border-color: #2196f3;
    background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
}

.anggota-card-new:hover .default-avatar-new i {
    color: white !important;
}

.detail-jabatan-new {
    background: linear-gradient(135deg, #f3f8ff 0%, #e8f2ff 100%);
    border-radius: 15px;
    padding: 1rem;
    margin: 1rem 0;
    border-left: 4px solid #2196f3;
    text-align: left;
}

.detail-jabatan-new h6 {
    color: #1976d2 !important;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-jabatan-new p {
    color: #546e7a !important;
    font-size: 0.85rem;
    line-height: 1.6;
}

/* Responsive adjustments for 14" laptops (1366x768 to 1920x1080) */
@media (min-width: 1200px) and (max-width: 1600px) {
    .jabatan-title {
        font-size: 2.5rem !important;
    }

    .jabatan-description {
        font-size: 0.95rem !important;
        line-height: 1.5;
    }

    .anggota-card-new {
        margin-bottom: 1rem;
    }

    .staff-photo-new,
    .default-avatar-new {
        width: 90px !important;
        height: 90px !important;
    }

    .detail-jabatan-new {
        padding: 0.75rem;
        margin: 0.75rem 0;
    }

    .card-body {
        padding: 1rem !important;
    }
}

/* Specific optimization for 14" laptops at 1080p */
@media (min-width: 1366px) and (max-width: 1440px) {
    .display-6 {
        font-size: 2.2rem !important;
    }

    .container {
        max-width: 1200px;
    }

    .col-xl-4 {
        flex: 0 0 auto;
        width: 33.333333%;
    }
}

/* Additional responsive font sizes */
@media (max-width: 1439px) {
    .fs-7 {
        font-size: 0.8rem !important;
    }
}
</style>

@endsection
