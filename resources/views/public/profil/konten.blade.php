@extends('public.layouts.app')

@section('title', 'Galeri & Media')
@section('description', 'Galeri Foto, Video, dan Media Konten Dinas PUPR Kabupaten Katingan')

@section('content')
<!-- Hero Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-3">Galeri & Media</h1>
                <p class="lead mb-4">Dokumentasi kegiatan dan pencapaian Dinas PUPR Kabupaten Katingan</p>
                <div class="d-flex flex-wrap gap-2">
                    <div class="badge bg-light text-dark px-3 py-2">
                        <i class="fas fa-images me-1"></i>{{ $carousel->count() }} Foto
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2">
                        <i class="fas fa-video me-1"></i>{{ $videos->count() }} Video
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2">
                        <i class="fas fa-handshake me-1"></i>{{ $mitra->count() }} Mitra
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2">
                        <i class="fas fa-file-download me-1"></i>{{ $files->count() }} File
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center" data-aos="fade-left">
                <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                     style="width: 200px; height: 200px;">
                    <i class="fas fa-camera fa-5x text-white"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Tabs -->
<section class="py-3 bg-white border-bottom">
    <div class="container">
        <ul class="nav nav-pills justify-content-center" id="mediaTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="galeri-tab" data-bs-toggle="pill" data-bs-target="#galeri" type="button" role="tab">
                    <i class="fas fa-images me-2"></i>Galeri Foto
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video" type="button" role="tab">
                    <i class="fas fa-video me-2"></i>Video
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mitra-tab" data-bs-toggle="pill" data-bs-target="#mitra" type="button" role="tab">
                    <i class="fas fa-handshake me-2"></i>Mitra Kerja
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="files-tab" data-bs-toggle="pill" data-bs-target="#files" type="button" role="tab">
                    <i class="fas fa-download me-2"></i>Unduhan
                </button>
            </li>
        </ul>
    </div>
</section>

<!-- Tab Content -->
<section class="py-5">
    <div class="container">
        <div class="tab-content" id="mediaTabsContent">
            
            <!-- Galeri Tab -->
            <div class="tab-pane fade show active" id="galeri" role="tabpanel">
                @if($carousel->count() > 0)
                    <div class="row">
                        <div class="col-12 text-center mb-4">
                            <h2 class="fw-bold text-primary">Galeri Foto Kegiatan</h2>
                            <p class="text-muted">Dokumentasi visual berbagai kegiatan dan pencapaian</p>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        @foreach($carousel as $item)
                            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="card border-0 shadow gallery-card">
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ $item->media_url }}" 
                                             class="card-img-top gallery-img" 
                                             style="height: 250px; object-fit: cover;" 
                                             data-bs-toggle="modal" 
                                             data-bs-target="#galleryModal" 
                                             data-img="{{ $item->media_url }}"
                                             data-title="{{ $item->judul }}"
                                             data-desc="{{ $item->deskripsi }}">
                                        <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-search-plus fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $item->judul }}</h6>
                                        @if($item->deskripsi)
                                            <p class="card-text text-muted small">{{ Str::limit($item->deskripsi, 80) }}</p>
                                        @endif
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada galeri foto</h4>
                        <p class="text-muted">Galeri foto akan ditampilkan di sini</p>
                    </div>
                @endif
            </div>

            <!-- Video Tab -->
            <div class="tab-pane fade" id="video" role="tabpanel">
                @if($videos->count() > 0)
                    <div class="row">
                        <div class="col-12 text-center mb-4">
                            <h2 class="fw-bold text-primary">Video Dokumentasi</h2>
                            <p class="text-muted">Koleksi video dokumentasi kegiatan dan pencapaian</p>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        @foreach($videos as $video)
                            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="card border-0 shadow">
                                    <div class="position-relative">
                                        @if($video->url)
                                            <!-- YouTube/External Video -->
                                            @php
                                                $videoId = '';
                                                if (strpos($video->url, 'youtube.com') !== false || strpos($video->url, 'youtu.be') !== false) {
                                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->url, $matches);
                                                    $videoId = $matches[1] ?? '';
                                                }
                                            @endphp
                                            
                                            @if($videoId)
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                            title="{{ $video->judul }}" 
                                                            allowfullscreen></iframe>
                                                </div>
                                            @else
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="{{ $video->url }}" 
                                                            title="{{ $video->judul }}" 
                                                            allowfullscreen></iframe>
                                                </div>
                                            @endif
                                        @elseif($video->media)
                                            <!-- Local Video File -->
                                            <video class="w-100" controls style="max-height: 300px;">
                                                <source src="{{ $video->media_url }}" type="video/mp4">
                                                Browser Anda tidak mendukung tag video.
                                            </video>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $video->judul }}</h6>
                                        @if($video->deskripsi)
                                            <p class="card-text text-muted">{{ Str::limit($video->deskripsi, 100) }}</p>
                                        @endif
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $video->created_at->format('d M Y') }}
                                        </small>
                                        @if($video->url)
                                            <div class="mt-2">
                                                <a href="{{ $video->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-external-link-alt me-1"></i>Lihat di YouTube
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-video fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada video</h4>
                        <p class="text-muted">Video dokumentasi akan ditampilkan di sini</p>
                    </div>
                @endif
            </div>

            <!-- Mitra Tab -->
            <div class="tab-pane fade" id="mitra" role="tabpanel">
                @if($mitra->count() > 0)
                    <div class="row">
                        <div class="col-12 text-center mb-4">
                            <h2 class="fw-bold text-primary">Mitra Kerja Sama</h2>
                            <p class="text-muted">Partner strategis dalam pembangunan infrastruktur</p>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        @foreach($mitra as $partner)
                            <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                <div class="card border-0 shadow h-100 mitra-card">
                                    <div class="card-body text-center p-4">
                                        @if($partner->media)
                                            <img src="{{ $partner->media_url }}" 
                                                 class="mb-3" 
                                                 style="max-width: 120px; max-height: 80px; object-fit: contain;" 
                                                 alt="{{ $partner->judul }}">
                                        @else
                                            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center mb-3 mx-auto" 
                                                 style="width: 80px; height: 80px;">
                                                <i class="fas fa-handshake fa-2x"></i>
                                            </div>
                                        @endif
                                        <h6 class="fw-bold">{{ $partner->judul }}</h6>
                                        @if($partner->deskripsi)
                                            <p class="text-muted small">{{ Str::limit($partner->deskripsi, 60) }}</p>
                                        @endif
                                        @if($partner->url)
                                            <a href="{{ $partner->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-external-link-alt me-1"></i>Kunjungi
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-handshake fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada mitra kerja</h4>
                        <p class="text-muted">Informasi mitra kerja akan ditampilkan di sini</p>
                    </div>
                @endif
            </div>

            <!-- Files Tab -->
            <div class="tab-pane fade" id="files" role="tabpanel">
                @if($files->count() > 0)
                    <div class="row">
                        <div class="col-12 text-center mb-4">
                            <h2 class="fw-bold text-primary">File Unduhan</h2>
                            <p class="text-muted">Dokumen dan file penting untuk diunduh</p>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        @foreach($files as $file)
                            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                <div class="card border-0 shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @php
                                                    $extension = pathinfo($file->media, PATHINFO_EXTENSION);
                                                    $iconClass = match(strtolower($extension)) {
                                                        'pdf' => 'fas fa-file-pdf text-danger',
                                                        'doc', 'docx' => 'fas fa-file-word text-primary',
                                                        'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                                        'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
                                                        'zip', 'rar' => 'fas fa-file-archive text-secondary',
                                                        default => 'fas fa-file text-muted'
                                                    };
                                                @endphp
                                                <i class="{{ $iconClass }} fa-2x"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1">{{ $file->judul }}</h6>
                                                @if($file->deskripsi)
                                                    <p class="text-muted small mb-2">{{ $file->deskripsi }}</p>
                                                @endif
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $file->created_at->format('d M Y') }}
                                                    @if($file->media)
                                                        <span class="ms-2">
                                                            <i class="fas fa-file me-1"></i>
                                                            {{ strtoupper($extension) }}
                                                        </span>
                                                    @endif
                                                </small>
                                            </div>
                                            <div>
                                                @if($file->media)
                                                    <a href="{{ $file->media_url }}" 
                                                       class="btn btn-primary btn-sm" 
                                                       download="{{ $file->judul }}.{{ $extension }}">
                                                        <i class="fas fa-download me-1"></i>Unduh
                                                    </a>
                                                @elseif($file->url)
                                                    <a href="{{ $file->url }}" 
                                                       target="_blank" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-external-link-alt me-1"></i>Akses
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-download fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada file unduhan</h4>
                        <p class="text-muted">File dan dokumen akan ditampilkan di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="galleryModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="galleryModalImg" class="img-fluid w-100" style="max-height: 70vh; object-fit: contain;">
                <div class="p-4">
                    <p id="galleryModalDesc" class="text-muted"></p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.nav-pills .nav-link {
    border-radius: 25px;
    margin: 0 5px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.nav-pills .nav-link.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.gallery-card {
    transition: transform 0.3s ease;
    cursor: pointer;
}

.gallery-card:hover {
    transform: translateY(-5px);
}

.gallery-img {
    transition: transform 0.3s ease;
}

.overlay {
    background: rgba(0,0,0,0.6);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .overlay {
    opacity: 1;
}

.gallery-card:hover .gallery-img {
    transform: scale(1.1);
}

.mitra-card:hover {
    transform: translateY(-3px);
    transition: transform 0.3s ease;
}

@media (max-width: 768px) {
    .nav-pills {
        flex-direction: column;
    }
    
    .nav-pills .nav-link {
        margin: 2px 0;
        text-align: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery modal
    const galleryModal = document.getElementById('galleryModal');
    const galleryImages = document.querySelectorAll('.gallery-img');
    
    galleryImages.forEach(img => {
        img.addEventListener('click', function() {
            const imgSrc = this.getAttribute('data-img');
            const title = this.getAttribute('data-title');
            const desc = this.getAttribute('data-desc');
            
            document.getElementById('galleryModalImg').src = imgSrc;
            document.getElementById('galleryModalTitle').textContent = title;
            document.getElementById('galleryModalDesc').textContent = desc || '';
        });
    });
    
    // Tab switching with URL hash
    const tabTriggerList = [].slice.call(document.querySelectorAll('#mediaTabs button'));
    tabTriggerList.forEach(function (tabTriggerEl) {
        tabTriggerEl.addEventListener('click', function(event) {
            const target = event.target.getAttribute('data-bs-target');
            window.location.hash = target.replace('#', '');
        });
    });
    
    // Check URL hash on load
    const hash = window.location.hash.replace('#', '');
    if (hash) {
        const targetTab = document.querySelector(`#${hash}-tab`);
        if (targetTab) {
            const tab = new bootstrap.Tab(targetTab);
            tab.show();
        }
    }
});
</script>
@endpush
@endsection
