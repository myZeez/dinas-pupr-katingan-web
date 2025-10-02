@extends('public.layouts.app')

@section('title', 'Beranda')
@section('description',
    'Website Resmi Dinas PUPR Kabupaten Katingan - Membangun Infrastruktur untuk Kesejahteraan
    Masyarakat')

    @push('styles')
        <style>
            /* YouTube Autoplay Enhancement */
            .hero-video-container iframe,
            .video-container iframe {
                pointer-events: auto !important;
                user-select: none;
            }

            .hero-video-container {
                position: relative;
                overflow: hidden;
            }

            .video-container {
                position: relative;
                background: #000;
            }

            /* Ensure video covers container properly */
            .ratio iframe {
                object-fit: cover;
                width: 100% !important;
                height: 100% !important;
            }

            /* Mobile optimizations */
            @media (max-width: 768px) {
                .hero-video-container iframe {
                    transform: scale(1.2);
                    transform-origin: center center;
                }
            }

            /* Text readability enhancements */
            .hero-content {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            }

            .hero-content h1 {
                text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.9);
                font-weight: 700;
            }

            .hero-content p {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
                font-weight: 400;
            }

            /* Enhanced overlay for better contrast */
            .hero-overlay {
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0.8) 100%);
            }
        </style>
    @endpush

@section('content')
    <!-- Modern Hero Section with Dynamic Background -->
    <section class="hero-section position-relative overflow-hidden" style="min-height: 100vh;">
        <!-- Dynamic Background -->
        <div class="hero-background position-absolute w-100 h-100" style="top: 0; left: 0; z-index: 1;">
            @if ($carouselSlides->count() > 0)
                <!-- Carousel Background -->
                <div id="heroCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner h-100">
                        @foreach ($carouselSlides as $index => $slide)
                            <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}">
                                <div class="hero-bg-image h-100"
                                    style="
                            background-image: url('{{ asset('storage/' . $slide->file_path) }}');
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                        ">
                                </div>
                                <div class="hero-overlay position-absolute w-100 h-100"
                                    style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0.8) 100%);">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Carousel Indicators -->
                    @if ($carouselSlides->count() > 1)
                        <div class="carousel-indicators">
                            @foreach ($carouselSlides as $index => $slide)
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @elseif(isset($heroVideo) && $heroVideo)
                <!-- Video Background -->
                <div class="hero-video-container h-100">
                    @if ($heroVideo->youtube_url)
                        <!-- YouTube Embed as Background -->
                        <div class="ratio ratio-16x9 h-100">
                            @php
                                $youtubeId = '';
                                if (
                                    preg_match(
                                        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                        $heroVideo->youtube_url,
                                        $matches,
                                    )
                                ) {
                                    $youtubeId = $matches[1];
                                }
                            @endphp
                            <iframe
                                src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&enablejsapi=1&origin={{ request()->getSchemeAndHttpHost() }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen class="w-100 h-100" style="object-fit: cover;"
                                onload="this.contentWindow.postMessage('{\"event\":\"command\",\"func\":\"playVideo\",\"args\":\"\"}', '*')">
                            </iframe>
                        </div>
                    @elseif($heroVideo->file_path)
                        <!-- Local Video Background -->
                        <video autoplay muted loop playsinline class="w-100 h-100" style="object-fit: cover;">
                            <source src="{{ asset('storage/' . $heroVideo->file_path) }}" type="video/mp4">
                        </video>
                    @endif
                    <div class="hero-overlay position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.7);"></div>
                </div>
            @else
                <!-- Fallback Gradient Background -->
                <div class="hero-gradient h-100"
                    style="background: linear-gradient(135deg, #003DA0 0%, #1565C0 50%, #1976D2 100%);"></div>
            @endif
        </div>

        <!-- Hero Content -->
        <div class="hero-content position-relative h-100 d-flex align-items-center justify-content-center"
            style="z-index: 2;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center">
                        <div class="hero-text text-white" data-aos="fade-up" data-aos-duration="1000">
                            <h1 class="display-4 fw-bold mb-4 text-shadow">
                                Membangun <span class="text-warning">Infrastruktur</span><br>
                                untuk Kesejahteraan Masyarakat
                            </h1>
                            <p class="lead mb-5 text-shadow"
                                style="font-size: 1.1rem; opacity: 0.95; max-width: 600px; margin: 0 auto;">
                                Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan berkomitmen membangun
                                infrastruktur berkualitas untuk mendukung kemajuan daerah dan kesejahteraan masyarakat.
                            </p>
                            <div class="hero-buttons d-flex flex-wrap gap-3 justify-content-center">
                                <a href="{{ route('public.program') }}"
                                    class="btn btn-warning btn-lg px-4 py-3 fw-semibold shadow-lg">
                                    <i class="bi bi-eye me-2"></i>Lihat Program
                                </a>
                                <a href="{{ route('public.berita') }}"
                                    class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold shadow-lg">
                                    <i class="bi bi-newspaper me-2"></i>Berita & Informasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Title - Bottom Left -->
        @if ($carouselSlides->count() > 0)
            <div class="position-absolute bottom-0 start-0 m-4" style="z-index: 3;">
                <div class="carousel-title text-white">
                    @foreach ($carouselSlides as $index => $slide)
                        <div class="slide-title {{ $index === 0 ? 'active' : '' }}" id="slide-title-{{ $index }}">
                            @if ($slide->judul)
                                <h6 class="mb-1 text-shadow fw-semibold" style="font-size: 0.9rem;">{{ $slide->judul }}
                                </h6>
                            @endif
                            @if ($slide->deskripsi)
                                <p class="mb-0 text-shadow small opacity-75" style="font-size: 0.75rem; max-width: 300px;">
                                    {{ Str::limit($slide->deskripsi, 80) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4" style="z-index: 3;">
            <div class="scroll-indicator">
                <div class="scroll-mouse"></div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                @if ($statsCounters->count() > 0)
                    @foreach ($statsCounters as $index => $stat)
                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="text-center">
                                <div class="bg-{{ $stat->metadata['color'] ?? 'primary' }} bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i
                                        class="bi bi-{{ $stat->metadata['icon'] ?? 'building' }} text-{{ $stat->metadata['color'] ?? 'primary' }} fs-2"></i>
                                </div>
                                <h3 class="fw-bold text-{{ $stat->metadata['color'] ?? 'primary' }}">{{ $stat->content }}
                                </h3>
                                <p class="text-muted mb-0">{{ $stat->title }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default stats if no content available - using real database data -->
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-building text-primary fs-2"></i>
                            </div>
                            <h3 class="fw-bold text-primary">{{ $totalProgram }}</h3>
                            <p class="text-muted mb-0">Total Program</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-gear text-success fs-2"></i>
                            </div>
                            <h3 class="fw-bold text-success">{{ $programBerjalan }}</h3>
                            <p class="text-muted mb-0">Program Berjalan</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="text-center">
                            <div class="bg-info bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-newspaper text-info fs-2"></i>
                            </div>
                            <h3 class="fw-bold text-info">{{ $totalBerita }}</h3>
                            <p class="text-muted mb-0">Berita Diterbitkan</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-chat-dots text-warning fs-2"></i>
                            </div>
                            <h3 class="fw-bold text-warning">{{ $totalPengaduan }}</h3>
                            <p class="text-muted mb-0">Pengaduan Masyarakat</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Modern Video Showcase Section -->
    @if (isset($heroVideo) && $heroVideo)
        <section class="py-5 video-showcase-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="video-showcase-content">
                            <h2 class="fw-bold mb-4">Profil Dinas PUPR Katingan</h2>
                            @if ($heroVideo->judul)
                                <h3 class="h5 text-primary mb-3">{{ $heroVideo->judul }}</h3>
                            @endif
                            @if ($heroVideo->deskripsi)
                                <p class="text-muted mb-4">{{ $heroVideo->deskripsi }}</p>
                            @endif
                            <div class="video-stats d-flex gap-4 mb-4">
                                <div class="stat-item">
                                    <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-2">
                                        <i class="bi bi-play-circle text-primary fs-4"></i>
                                    </div>
                                    <span class="small fw-semibold">Video Profil</span>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon bg-success bg-opacity-10 rounded-circle p-3 mb-2">
                                        <i class="bi bi-building text-success fs-4"></i>
                                    </div>
                                    <span class="small fw-semibold">Infrastruktur</span>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon bg-info bg-opacity-10 rounded-circle p-3 mb-2">
                                        <i class="bi bi-people text-info fs-4"></i>
                                    </div>
                                    <span class="small fw-semibold">Layanan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="video-container position-relative rounded-4 overflow-hidden shadow-lg">
                            @if ($heroVideo->youtube_url)
                                @php
                                    $youtubeId = '';
                                    if (
                                        preg_match(
                                            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                            $heroVideo->youtube_url,
                                            $matches,
                                        )
                                    ) {
                                        $youtubeId = $matches[1];
                                    }
                                @endphp
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&controls=1&rel=0&modestbranding=1&playsinline=1&enablejsapi=1&origin={{ request()->getSchemeAndHttpHost() }}"
                                        title="{{ $heroVideo->judul }}" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen class="rounded-4"
                                        onload="this.contentWindow.postMessage('{\"event\":\"command\",\"func\":\"playVideo\",\"args\":\"\"}', '*')">
                                    </iframe>
                                </div>
                            @elseif($heroVideo->file_path)
                                <div class="ratio ratio-16x9">
                                    <video class="rounded-4" controls>
                                        <source src="{{ asset('storage/' . $heroVideo->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endif

                            <!-- Video Overlay Info -->
                            <div class="video-overlay position-absolute bottom-0 start-0 w-100 p-3"
                                style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                <div class="text-white">
                                    <small class="opacity-75">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $heroVideo->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- About Section -->
    <section class="py-5 about-section" style="background-color: var(--bg-light);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    @if (isset($profil) && $profil->background_image)
                        <img src="{{ asset('storage/' . $profil->background_image) }}" alt="Background Dinas PUPR"
                            class="img-fluid rounded-4 shadow w-100" style="height: 350px; object-fit: cover;">
                    @else
                        <img src="{{ asset('img/pembangunan.jpg') }}" alt="Infrastruktur"
                            class="img-fluid rounded-4 shadow w-100" style="height: 350px; object-fit: cover;"
                            onerror="this.style.display='none';">
                    @endif
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h2 class="section-title">Tentang Dinas PUPR Katingan</h2>
                    @if (isset($profil) && $profil->deskripsi)
                        <p class="section-subtitle">{{ $profil->deskripsi }}</p>
                    @else
                        <p class="section-subtitle">Berkomitmen membangun infrastruktur yang berkelanjutan dan berkualitas
                            untuk kemajuan Kabupaten Katingan.</p>
                    @endif

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px; min-width: 50px;">
                                    <i class="bi bi-eye text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Visi</h6>
                                    @if (isset($profil) && $profil->visi)
                                        <p class="mb-0 small">{{ $profil->visi }}</p>
                                    @else
                                        <p class="mb-0 small">Terwujudnya infrastruktur yang berkualitas dan berkelanjutan
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-success rounded-circle me-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px; min-width: 50px;">
                                    <i class="bi bi-target text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Misi</h6>
                                    @if (isset($profil) && $profil->misi)
                                        <p class="mb-0 small">{{ $profil->misi }}</p>
                                    @else
                                        <p class="mb-0 small">Melayani masyarakat dengan profesional dan transparan</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('public.struktur') }}" class="btn btn-primary rounded-pill">
                        <i class="bi bi-diagram-3 me-2"></i>Lihat Struktur
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Program Terbaru</h2>
                <p class="section-subtitle">Program pembangunan infrastruktur terkini untuk kemajuan Katingan</p>
            </div>

            <div class="row g-4">
                @foreach ($latestProgram as $program)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-primary rounded-pill">{{ $program->status }}</span>
                                    <small
                                        class="text-muted">{{ $program->tanggal_mulai ? $program->tanggal_mulai->format('M Y') : 'TBA' }}</small>
                                </div>
                                <h5 class="card-title fw-bold">{{ $program->nama_program }}</h5>
                                <p class="card-text text-muted">
                                    {{ Str::limit(html_entity_decode(strip_tags($program->deskripsi), ENT_QUOTES, 'UTF-8'), 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $program->lokasi }}
                                    </small>
                                    <a href="{{ route('public.program') }}"
                                        class="btn btn-outline-primary btn-sm">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('public.program') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-grid me-2"></i>Lihat Semua Program
                </a>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-5" style="background-color: var(--bg-light);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Berita & Publikasi</h2>
                <p class="section-subtitle">Informasi terkini seputar kegiatan dan program Dinas PUPR Katingan</p>
            </div>

            <div class="row g-4">
                @foreach ($latestBerita as $berita)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card h-100">
                            @if ($berita->thumbnail)
                                @php
                                    // Handle different image sources for berita thumbnail
                                    $beritaImagePath = '';
                                    if (
                                        str_starts_with($berita->thumbnail, 'http') ||
                                        str_starts_with($berita->thumbnail, '//')
                                    ) {
                                        // External URL - use as is
                                        $beritaImagePath = $berita->thumbnail;
                                    } elseif (str_starts_with($berita->thumbnail, 'storage/')) {
                                        // Already has storage prefix - remove it and add storage path
                                        $beritaImagePath = asset(
                                            'storage/' . str_replace('storage/', '', $berita->thumbnail),
                                        );
                                    } elseif (file_exists(storage_path('app/public/' . $berita->thumbnail))) {
                                        // File exists in storage/app/public
                                        $beritaImagePath = asset('storage/' . $berita->thumbnail);
                                    } elseif (file_exists(public_path($berita->thumbnail))) {
                                        // File exists in public folder
                                        $beritaImagePath = asset($berita->thumbnail);
                                    } else {
                                        // Default fallback with storage path
                                        $beritaImagePath = asset('storage/' . $berita->thumbnail);
                                    }
                                @endphp
                                <img src="{{ $beritaImagePath }}" class="card-img-top" alt="{{ $berita->judul }}"
                                    style="height: 200px; object-fit: cover;"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <!-- Fallback if image fails to load -->
                                <div class="bg-light d-none align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2 text-muted small mb-2">
                                    <span>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $berita->tanggal ? $berita->tanggal->format('d M Y') : $berita->created_at->format('d M Y') }}
                                    </span>
                                    @if ($berita->author)
                                        <span>
                                            <i class="bi bi-person-fill me-1"></i>
                                            {{ $berita->author }}
                                        </span>
                                    @endif
                                </div>
                                <h5 class="card-title fw-bold mt-2">{{ $berita->judul }}</h5>
                                <p class="card-text text-muted">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                                <a href="{{ route('public.berita.show', $berita->slug) }}"
                                    class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('public.berita') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-newspaper me-2"></i>Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

    <!-- Partner Logos Section -->
    @if ($partnerLogos->count() > 0)
        <section class="py-5 bg-white">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Mitra Kerjasama</h2>
                    <p class="section-subtitle">Bekerjasama dengan berbagai instansi untuk pembangunan yang berkelanjutan
                    </p>
                </div>

                <div class="row g-4 justify-content-center align-items-center">
                    @foreach ($partnerLogos as $partner)
                        <div class="col-lg-2 col-md-3 col-4" data-aos="fade-up"
                            data-aos-delay="{{ $loop->iteration * 50 }}">
                            <div class="text-center p-3">
                                @if ($partner->file_path)
                                    @php
                                        // Path sudah termasuk konten_public/ dari database
                                        $partnerImagePath = '';
                                        if (
                                            str_starts_with($partner->file_path, 'http') ||
                                            str_starts_with($partner->file_path, '//')
                                        ) {
                                            // External URL - use as is
                                            $partnerImagePath = $partner->file_path;
                                        } else {
                                            // Default dengan storage path karena file ada di storage/app/public/konten_public/
                                            $partnerImagePath = asset('storage/' . $partner->file_path);
                                        }
                                    @endphp
                                    <img src="{{ $partnerImagePath }}" alt="{{ $partner->judul }}" class="img-fluid"
                                        style="max-height: 60px; width: auto; filter: grayscale(100%); transition: filter 0.3s ease;"
                                        onmouseover="this.style.filter='grayscale(0%)'"
                                        onmouseout="this.style.filter='grayscale(100%)'"
                                        onerror="this.style.display='none'">
                                @else
                                    <div class="bg-light rounded p-3">
                                        <i class="bi bi-building text-muted fs-2"></i>
                                    </div>
                                @endif
                                @if ($partner->judul)
                                    <small class="text-muted d-block mt-2">{{ $partner->judul }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonials Section -->
    @if ($testimonials->count() > 0)
        <section class="py-5" style="background-color: var(--bg-light);">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Testimoni Masyarakat</h2>
                    <p class="section-subtitle">Apa kata masyarakat tentang layanan kami</p>
                </div>

                <div class="row g-4">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    @if ($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}"
                                            alt="{{ $testimonial->title }}" class="rounded-circle mb-3"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                            style="width: 80px; height: 80px;">
                                            <i class="bi bi-person text-primary fs-2"></i>
                                        </div>
                                    @endif
                                    <h6 class="fw-bold">{{ $testimonial->title }}</h6>
                                    <p class="text-muted small mb-3">"{{ $testimonial->content }}"</p>
                                    <div class="text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery Section -->
    @if ($latestGaleri && $latestGaleri->count() > 0)
        <section class="py-5 bg-white">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Galeri Foto</h2>
                    <p class="section-subtitle">Dokumentasi kegiatan dan pembangunan infrastruktur</p>
                </div>

                <div class="row g-4">
                    @foreach ($latestGaleri as $galeri)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="gallery-item position-relative overflow-hidden rounded-3 shadow-sm">
                                @if ($galeri->file_path)
                                    @php
                                        $galeriImagePath = '';
                                        if (
                                            str_starts_with($galeri->file_path, 'http') ||
                                            str_starts_with($galeri->file_path, '//')
                                        ) {
                                            $galeriImagePath = $galeri->file_path;
                                        } elseif (str_starts_with($galeri->file_path, 'storage/')) {
                                            $galeriImagePath = asset(
                                                'storage/' . str_replace('storage/', '', $galeri->file_path),
                                            );
                                        } elseif (file_exists(storage_path('app/public/' . $galeri->file_path))) {
                                            $galeriImagePath = asset('storage/' . $galeri->file_path);
                                        } elseif (file_exists(public_path($galeri->file_path))) {
                                            $galeriImagePath = asset($galeri->file_path);
                                        } else {
                                            $galeriImagePath = asset('storage/' . $galeri->file_path);
                                        }
                                    @endphp
                                    <img src="{{ $galeriImagePath }}" class="img-fluid w-100"
                                        alt="{{ $galeri->judul }}"
                                        style="height: 250px; object-fit: cover; transition: transform 0.3s ease;"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <!-- Fallback if image fails to load -->
                                    <div class="bg-light d-none align-items-center justify-content-center"
                                        style="height: 250px;">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>
                                @endif

                                <!-- Overlay -->
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end"
                                    style="background: linear-gradient(transparent, rgba(0,0,0,0.7)); opacity: 0; transition: opacity 0.3s ease;">
                                    <div class="p-3 text-white w-100">
                                        <h6 class="fw-bold mb-1">{{ $galeri->judul }}</h6>
                                        @if ($galeri->deskripsi)
                                            <p class="small mb-2 opacity-75">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                                        @endif
                                        <small class="opacity-75">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $galeri->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('public.galeri') }}" class="btn btn-primary rounded-pill">
                        <i class="bi bi-images me-2"></i>Lihat Semua Galeri
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Top Reviews Section -->
    @if (isset($topUlasan) && $topUlasan->count() > 0)
        <section class="py-5" style="background-color: var(--bg-light);">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Ulasan Terbaik Masyarakat</h2>
                    <p class="section-subtitle">Penilaian dan ulasan terbaik dari masyarakat terhadap layanan kami</p>
                </div>

                <div class="row g-4">
                    @foreach ($topUlasan as $ulasan)
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <!-- Rating Display -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="text-warning">
                                            {!! $ulasan->getRatingStarsAttribute() !!}
                                        </div>
                                        <span class="badge bg-primary">{{ $ulasan->rating }}/5</span>
                                    </div>

                                    <!-- User Info -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="bi bi-person text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $ulasan->nama }}</h6>
                                            <small class="text-muted">{{ $ulasan->created_at->format('d M Y') }}</small>
                                            @if ($ulasan->instansi)
                                                <br><small class="text-muted">{{ $ulasan->instansi }}</small>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Review Content -->
                                    @if ($ulasan->ulasan)
                                        <p class="text-muted mb-3">"{{ Str::limit($ulasan->ulasan, 120) }}"</p>
                                    @endif

                                    <!-- Service Category -->
                                    @if ($ulasan->kategori)
                                        <div class="mt-auto">
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-tag me-1"></i>{{ $ulasan->kategori }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Rating Breakdown (if detailed ratings exist) -->
                                    @if ($ulasan->rating_detail && is_array($ulasan->rating_detail))
                                        <div class="mt-3 pt-3 border-top">
                                            <small class="text-muted">Detail Penilaian:</small>
                                            <div class="row text-center mt-2">
                                                @foreach ($ulasan->rating_detail as $key => $value)
                                                    @if ($loop->index < 3)
                                                        <div class="col-4">
                                                            <small class="d-block">{{ ucfirst($key) }}</small>
                                                            <span class="badge bg-success">{{ $value }}/5</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5" data-aos="fade-up">
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center">
                        <button type="button" class="btn btn-warning btn-lg px-4 py-3 rounded-pill shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#ulasanModal">
                            <i class="bi bi-plus-circle me-2"></i>Buat Ulasan
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Announcements Section -->
    @if ($announcements->count() > 0)
        <section class="py-5 bg-white">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Pengumuman Terbaru</h2>
                    <p class="section-subtitle">Informasi penting yang perlu diketahui masyarakat</p>
                </div>

                <div class="row g-4">
                    @foreach ($announcements as $announcement)
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="card h-100 border-0 shadow-sm">
                                @if ($announcement->image)
                                    <img src="{{ asset('storage/' . $announcement->image) }}" class="card-img-top"
                                        alt="{{ $announcement->title }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-danger me-2">
                                            <i class="bi bi-megaphone me-1"></i>Pengumuman
                                        </span>
                                        <small class="text-muted">{{ $announcement->created_at->format('d M Y') }}</small>
                                    </div>
                                    <h5 class="card-title fw-bold">{{ $announcement->title }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($announcement->content, 100) }}</p>
                                    @if ($announcement->link)
                                        <a href="{{ $announcement->link }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-arrow-right me-1"></i>Selengkapnya
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

<!-- Modal Pengaduan -->
<div class="modal fade" id="pengaduanModal" tabindex="-1" aria-labelledby="pengaduanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="pengaduanModalLabel">
                    <i class="bi bi-chat-square-text me-2"></i>Sampaikan Pengaduan Anda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Success Alert (Hidden by default) -->
                <div id="successAlert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Berhasil!</strong> <span id="successMessage">Pengaduan Anda telah berhasil dikirim. Terima
                        kasih!</span>
                </div>

                <!-- Error Alert (Hidden by default) -->
                <div id="errorAlert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Gagal!</strong> <span id="errorMessage">Terjadi kesalahan. Silakan coba lagi.</span>
                </div>

                <form action="{{ route('public.pengaduan.store') }}" method="POST" id="pengaduanForm">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" required
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="contoh@email.com">
                        </div>

                        <div class="col-md-6">
                            <label for="telepon" class="form-label fw-semibold">No. Telepon/WhatsApp</label>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                placeholder="08123456789">
                        </div>

                        <div class="col-md-6">
                            <label for="kategori" class="form-label fw-semibold">Kategori Pesan <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Infrastruktur">Infrastruktur</option>
                                <option value="Layanan Publik">Layanan Publik</option>
                                <option value="Keluhan">Keluhan</option>
                                <option value="Saran">Saran</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="pesan" class="form-label fw-semibold">Pesan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="4" required
                                placeholder="Tuliskan pesan, pertanyaan, atau pengaduan Anda dengan detail..."></textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreement" required>
                                <label class="form-check-label" for="agreement">
                                    Saya menyetujui bahwa data yang saya berikan akan digunakan untuk menindaklanjuti
                                    pesan ini sesuai
                                    dengan kebijakan privasi yang berlaku.
                                </label>
                            </div>
                        </div>

                        <!-- CAPTCHA for Modal -->
                        <div class="col-12">
                            <div class="mb-3">
                                @if (app('App\Services\CaptchaService')->isRequired())
                                    {!! app('App\Services\CaptchaService')->html() !!}
                                    <div class="text-danger small mt-1" id="captcha-error" style="display: none;">
                                        Verifikasi CAPTCHA wajib dilengkapi.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitPengaduanBtn">
                            <span id="submitText">
                                <i class="bi bi-send me-1"></i>Kirim Pesan
                            </span>
                            <span id="loadingSpinner" class="d-none">
                                <div class="spinner-border spinner-border-sm me-1" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Mengirim...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="successToast" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-semibold">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span id="toastMessage">Pengaduan Anda telah berhasil dikirim!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none"
    style="background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="bg-white rounded-4 p-4 shadow-lg text-center" style="min-width: 250px;">
            <div class="mb-3">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <h6 class="text-dark mb-2">Mengirim Pengaduan...</h6>
            <p class="text-muted small mb-0">Sedang memproses pengaduan Anda</p>
            <div class="progress mt-3" style="height: 6px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                    style="width: 100%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Success Overlay -->
<div id="successOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none"
    style="background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="bg-white rounded-4 p-4 shadow-lg text-center" style="min-width: 250px;">
            <div class="mb-3">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
            </div>
            <h6 class="text-dark mb-2">Berhasil!</h6>
            <p class="text-muted small mb-0" id="successOverlayMessage">Pengaduan Anda telah berhasil dikirim</p>
        </div>
    </div>
</div>

<!-- Modal Tambah Ulasan -->
<div class="modal fade" id="ulasanModal" tabindex="-1" aria-labelledby="ulasanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="ulasanModalLabel">
                    <i class="bi bi-star-fill me-2"></i>Berikan Ulasan Anda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('public.ulasan.store') }}" method="POST" id="ulasanForm">
                    @csrf
                    <!-- Rating Section -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Rating Keseluruhan <span
                                class="text-danger">*</span></label>
                        <div class="rating-container d-flex align-items-center gap-3">
                            <div class="star-rating d-flex gap-1" id="starRating">
                                <i class="bi bi-star fs-3 text-muted star-btn" data-rating="1"></i>
                                <i class="bi bi-star fs-3 text-muted star-btn" data-rating="2"></i>
                                <i class="bi bi-star fs-3 text-muted star-btn" data-rating="3"></i>
                                <i class="bi bi-star fs-3 text-muted star-btn" data-rating="4"></i>
                                <i class="bi bi-star fs-3 text-muted star-btn" data-rating="5"></i>
                            </div>
                            <span class="rating-text text-muted">Pilih Rating</span>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required>
                    </div>

                    <div class="row g-3">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" required
                                placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="contoh@email.com">
                        </div>

                        <!-- Instansi -->
                        <div class="col-md-6">
                            <label for="instansi" class="form-label fw-semibold">Instansi/Perusahaan</label>
                            <input type="text" class="form-control" id="instansi" name="instansi"
                                placeholder="PT. Contoh / Universitas ABC">
                        </div>

                        <!-- Kategori Layanan -->
                        <div class="col-md-6">
                            <label for="kategori" class="form-label fw-semibold">Kategori Layanan <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Perizinan">Perizinan</option>
                                <option value="Infrastruktur">Infrastruktur</option>
                                <option value="Informasi">Informasi</option>
                                <option value="Konsultasi">Konsultasi</option>
                                <option value="Pelayanan Umum">Pelayanan Umum</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- Ulasan -->
                        <div class="col-12">
                            <label for="ulasan" class="form-label fw-semibold">Ulasan Anda <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="ulasan" name="ulasan" rows="4" required
                                placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..."></textarea>
                            <div class="form-text">Minimal 10 karakter</div>
                        </div>
                    </div>

                    <!-- Detail Rating (Optional) -->
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">Detail Penilaian (Opsional)</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small">Kecepatan Layanan</label>
                                <select class="form-select form-select-sm" name="rating_detail[kecepatan]">
                                    <option value="">-</option>
                                    <option value="1">1 - Sangat Lambat</option>
                                    <option value="2">2 - Lambat</option>
                                    <option value="3">3 - Cukup</option>
                                    <option value="4">4 - Cepat</option>
                                    <option value="5">5 - Sangat Cepat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Keramahan Petugas</label>
                                <select class="form-select form-select-sm" name="rating_detail[keramahan]">
                                    <option value="">-</option>
                                    <option value="1">1 - Sangat Buruk</option>
                                    <option value="2">2 - Buruk</option>
                                    <option value="3">3 - Cukup</option>
                                    <option value="4">4 - Baik</option>
                                    <option value="5">5 - Sangat Baik</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Kualitas Hasil</label>
                                <select class="form-select form-select-sm" name="rating_detail[kualitas]">
                                    <option value="">-</option>
                                    <option value="1">1 - Sangat Buruk</option>
                                    <option value="2">2 - Buruk</option>
                                    <option value="3">3 - Cukup</option>
                                    <option value="4">4 - Baik</option>
                                    <option value="5">5 - Sangat Baik</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="submit" form="ulasanForm" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Kirim Ulasan
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Modern Hero Section Styles */
        .hero-section {
            position: relative;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-bg-image {
            background-attachment: fixed;
            transition: transform 0.5s ease;
        }

        .hero-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 20, 50, 0.7) 50%, rgba(0, 30, 80, 0.6) 100%);
        }

        .text-shadow {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
        }

        /* Carousel Indicators Styling */
        .carousel-indicators {
            bottom: 30px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .carousel-indicators button.active {
            background-color: #F4B400;
            border-color: #F4B400;
            transform: scale(1.2);
        }

        /* Slide Info Animation */
        .slide-info {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.5s ease;
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
        }

        .slide-info.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
        }

        /* Carousel Title Animation - Bottom Left */
        .slide-title {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .slide-title.active {
            opacity: 1;
            transform: translateY(0);
            position: relative;
        }

        /* Scroll Indicator */
        .scroll-indicator {
            text-align: center;
            animation: bounce 2s infinite;
        }

        .scroll-mouse {
            width: 24px;
            height: 40px;
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            position: relative;
            margin: 0 auto;
        }

        .scroll-mouse::before {
            content: '';
            position: absolute;
            top: 6px;
            left: 50%;
            width: 2px;
            height: 6px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 1px;
            transform: translateX(-50%);
            animation: scroll 1.5s infinite;
        }

        @keyframes scroll {

            0%,
            20% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateX(-50%) translateY(12px);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        /* Hero Buttons */
        .hero-buttons .btn {
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .hero-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content .display-4 {
                font-size: 2.2rem;
            }

            .hero-content .lead {
                font-size: 1rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-bg-image {
                background-attachment: scroll;
            }

            .carousel-title {
                margin: 1rem !important;
            }

            .slide-title h6 {
                font-size: 0.8rem !important;
            }

            .slide-title p {
                font-size: 0.7rem !important;
            }
        }

        /* Video Showcase Section */
        .video-showcase-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .video-container {
            transition: all 0.3s ease;
        }

        .video-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .stat-item {
            text-align: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .stat-item:hover .stat-icon {
            transform: scale(1.1);
        }

        .video-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-container:hover .video-overlay {
            opacity: 1;
        }

        .min-vh-80 {
            min-height: 80vh;
        }

        /* Star Rating Styles */
        .star-btn {
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .star-btn:hover {
            transform: scale(1.1);
        }

        .rating-container {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        /* Gallery Styles */
        .gallery-item {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1 !important;
        }

        .modal-header {
            background-color: #5a72a0;
            border: none;
        }

        .modal-body {
            background: #ffffff;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
        }

        /* Form Styles */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background-color: #5a72a0;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4a628a;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(90, 114, 160, 0.2);
        }

        .btn-warning {
            background-color: #d4a574;
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #c49660;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(212, 165, 116, 0.2);
        }

        /* Animation for modal appearance */
        .modal.fade .modal-dialog {
            transition: transform 0.4s ease;
            transform: translate(0, -50px) scale(0.95);
        }

        .modal.show .modal-dialog {
            transform: translate(0, 0) scale(1);
        }

        .carousel-section {
            position: relative;
        }

        .carousel-section .carousel-item {
            transition: transform 0.6s ease;
        }

        .carousel-section .carousel-item img {
            filter: brightness(0.7);
        }

        .carousel-section .carousel-indicators {
            bottom: 30px;
            z-index: 15;
        }

        .carousel-section .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            border: 2px solid white;
            opacity: 0.5;
        }

        .carousel-section .carousel-indicators button.active {
            opacity: 1;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .carousel-section .carousel-control-prev,
        .carousel-section .carousel-control-next {
            width: 5%;
            opacity: 0.8;
        }

        .carousel-section .carousel-control-prev:hover,
        .carousel-section .carousel-control-next:hover {
            opacity: 1;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        /* About section image sizing */
        .about-section img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            margin: 0 auto;
            display: block;
            border-radius: 1.5rem;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .carousel-section .display-3 {
                font-size: 2.5rem !important;
            }

            .carousel-section .lead {
                font-size: 1.1rem !important;
            }

            .modal-dialog {
                margin: 1rem;
            }

            .modal-lg {
                max-width: calc(100% - 2rem);
            }

            .star-rating {
                justify-content: center !important;
            }

            .star-btn {
                font-size: 2rem !important;
            }

            /* About section images - responsive sizing */
            .col-lg-6 img,
            .about-section img {
                width: 100% !important;
                height: 280px !important;
                object-fit: cover;
            }
        }

        .carousel-section .btn-lg {
            padding: 0.75rem 2rem !important;
            font-size: 1rem !important;
        }
        }

        @media (max-width: 992px) {

            /* About section images - tablet sizing */
            .about-section img {
                width: 100% !important;
                height: 300px !important;
                object-fit: cover;
            }
        }

        @media (max-width: 576px) {
            .carousel-section .display-3 {
                font-size: 2rem !important;
            }

            .carousel-section .lead {
                font-size: 1rem !important;
            }

            .carousel-section .btn-lg {
                padding: 0.5rem 1.5rem !important;
                font-size: 0.9rem !important;
            }

            /* About section images - mobile sizing */
            .about-section img {
                width: 100% !important;
                height: 220px !important;
                object-fit: cover;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hero Carousel Slide Info Synchronization
            const carousel = document.getElementById('heroCarousel');
            const slideInfos = document.querySelectorAll('.slide-info');
            const slideTitles = document.querySelectorAll('.slide-title');

            if (carousel && (slideInfos.length > 0 || slideTitles.length > 0)) {
                carousel.addEventListener('slide.bs.carousel', function(event) {
                    // Hide all slide infos
                    slideInfos.forEach(info => {
                        info.classList.remove('active');
                    });

                    // Hide all slide titles
                    slideTitles.forEach(title => {
                        title.classList.remove('active');
                    });

                    // Show current slide info
                    const activeSlideInfo = document.getElementById('slide-info-' + event.to);
                    if (activeSlideInfo) {
                        setTimeout(() => {
                            activeSlideInfo.classList.add('active');
                        }, 300);
                    }

                    // Show current slide title
                    const activeSlideTitle = document.getElementById('slide-title-' + event.to);
                    if (activeSlideTitle) {
                        setTimeout(() => {
                            activeSlideTitle.classList.add('active');
                        }, 300);
                    }
                });
            }

            // Star Rating Functionality
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('ratingInput');
            const ratingText = document.querySelector('.rating-text');
            let selectedRating = 0;

            const ratingTexts = {
                1: '⭐ Sangat Buruk',
                2: '⭐⭐ Buruk',
                3: '⭐⭐⭐ Cukup',
                4: '⭐⭐⭐⭐ Baik',
                5: '⭐⭐⭐⭐⭐ Sangat Baik'
            };

            stars.forEach(star => {
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    highlightStars(rating);
                });

                star.addEventListener('mouseleave', function() {
                    highlightStars(selectedRating);
                });

                star.addEventListener('click', function() {
                    selectedRating = parseInt(this.dataset.rating);
                    ratingInput.value = selectedRating;
                    ratingText.textContent = ratingTexts[selectedRating];
                    ratingText.className = 'rating-text text-warning fw-semibold';
                    highlightStars(selectedRating);
                });
            });

            function highlightStars(rating) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.className = 'bi bi-star-fill fs-3 text-warning star-btn';
                    } else {
                        star.className = 'bi bi-star fs-3 text-muted star-btn';
                    }
                });
            }

            // Form Validation untuk Ulasan
            const ulasanForm = document.getElementById('ulasanForm');
            if (ulasanForm) {
                ulasanForm.addEventListener('submit', function(e) {
                    const rating = ratingInput.value;
                    const ulasan = document.getElementById('ulasan').value;

                    if (!rating) {
                        e.preventDefault();
                        alert('Mohon berikan rating terlebih dahulu!');
                        return false;
                    }

                    if (ulasan.length < 10) {
                        e.preventDefault();
                        alert('Ulasan minimal 10 karakter!');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Mengirim...';
                    submitBtn.disabled = true;

                    // If we get here, form is valid, let it submit normally
                    // In a real app, you might want to handle this with AJAX
                });
            }

            // Form Handler untuk Pengaduan (AJAX dengan Loading & Toast)
            console.log('🔍 Looking for pengaduan form elements...');
            const pengaduanForm = document.getElementById('pengaduanForm');
            const submitPengaduanBtn = document.getElementById('submitPengaduanBtn');
            const submitText = document.getElementById('submitText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            const successToast = document.getElementById('successToast');

            console.log('📋 Form elements found:', {
                pengaduanForm: !!pengaduanForm,
                submitPengaduanBtn: !!submitPengaduanBtn,
                submitText: !!submitText,
                loadingSpinner: !!loadingSpinner,
                loadingModal: !!document.getElementById('loadingModal'),
                successModal: !!document.getElementById('successModal')
            });

            if (pengaduanForm) {
                console.log('✅ Pengaduan form found, attaching event listener');
                pengaduanForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('🚀 Form submitted, starting AJAX process');

                    // Check CAPTCHA first (only if enabled)
                    const hasCaptcha = !!document.querySelector('.g-recaptcha');
                    if (hasCaptcha) {
                        const captchaResponse = grecaptcha && grecaptcha.getResponse ? grecaptcha
                            .getResponse() : '';

                        if (!captchaResponse) {
                            const captchaError = document.getElementById('captcha-error');
                            if (captchaError) {
                                captchaError.style.display = 'block';
                            }
                            showErrorAlert('Verifikasi CAPTCHA wajib dilengkapi.');
                            return;
                        }
                    }

                    // Reset previous states
                    clearValidationErrors();
                    hideAlerts();

                    // Hide CAPTCHA error if it was showing
                    const captchaError = document.getElementById('captcha-error');
                    if (captchaError) {
                        captchaError.style.display = 'none';
                    }

                    // Show loading state
                    console.log('🔄 Showing loading state');
                    showLoadingState();

                    // Prepare form data
                    const formData = new FormData(this);

                    // Get CSRF token
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') ||
                        document.querySelector('input[name="_token"]')?.value ||
                        formData.get('_token');

                    if (token) {
                        formData.set('_token', token);
                    }

                    // Send AJAX request with better error handling
                    const xhr = new XMLHttpRequest();

                    xhr.open('POST', this.action, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            try {
                                const data = JSON.parse(xhr.responseText);
                                if (data.success !== false) {
                                    handleSuccess(data.message ||
                                        'Pengaduan Anda telah berhasil dikirim. Terima kasih!');
                                } else {
                                    handleError(data);
                                }
                            } catch (e) {
                                // Response might not be JSON (redirect), assume success
                                handleSuccess('Pengaduan berhasil dikirim!');
                            }
                        } else {
                            handleError({
                                message: 'Terjadi kesalahan server. Silakan coba lagi.',
                                errors: {}
                            });
                        }
                        hideLoadingState();
                    };

                    xhr.onerror = function() {
                        handleError({
                            message: 'Terjadi kesalahan jaringan. Periksa koneksi internet Anda.',
                            errors: {}
                        });
                        hideLoadingState();
                    };

                    xhr.send(formData);
                });
            }

            function showLoadingState() {
                console.log('📱 Showing loading overlay');

                // Tampilkan loading overlay
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.classList.remove('d-none');
                    console.log('✅ Loading overlay shown');
                } else {
                    console.error('❌ Loading overlay element not found!');
                }

                // Disable submit button
                if (submitPengaduanBtn && submitText && loadingSpinner) {
                    submitPengaduanBtn.disabled = true;
                    submitText.classList.add('d-none');
                    loadingSpinner.classList.remove('d-none');
                }
            }

            function hideLoadingState() {
                console.log('📱 Hiding loading overlay');

                // Sembunyikan loading overlay
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.classList.add('d-none');
                    console.log('✅ Loading overlay hidden');
                }

                // Enable submit button
                if (submitPengaduanBtn && submitText && loadingSpinner) {
                    submitPengaduanBtn.disabled = false;
                    submitText.classList.remove('d-none');
                    loadingSpinner.classList.add('d-none');
                }
            }

            function handleSuccess(message) {
                console.log('🎉 Success! Showing success overlay');

                // Reset form
                pengaduanForm.reset();

                // Tutup modal form
                const modalElement = document.getElementById('pengaduanModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }

                // Tampilkan success overlay
                const successOverlay = document.getElementById('successOverlay');
                const successMessage = document.getElementById('successOverlayMessage');

                if (successOverlay && successMessage) {
                    successMessage.textContent = message;
                    successOverlay.classList.remove('d-none');

                    // Auto close success overlay setelah 3 detik
                    setTimeout(() => {
                        successOverlay.classList.add('d-none');
                    }, 3000);

                    console.log('✅ Success overlay shown');
                } else {
                    // Fallback: gunakan alert
                    alert(message);
                    console.log('⚠️ Success overlay not found, using alert');
                }
            }

            function handleError(data) {
                let message = data.message || 'Terjadi kesalahan. Silakan coba lagi.';

                // Show error alert
                if (errorAlert) {
                    document.getElementById('errorMessage').textContent = message;
                    errorAlert.classList.remove('d-none');
                }

                // Handle validation errors
                if (data.errors) {
                    showValidationErrors(data.errors);
                }

                // Auto hide error alert after 5 seconds
                setTimeout(() => {
                    if (errorAlert) {
                        errorAlert.classList.add('d-none');
                    }
                }, 5000);
            }

            function clearValidationErrors() {
                const invalidInputs = pengaduanForm.querySelectorAll('.is-invalid');
                invalidInputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });

                const errorFeedbacks = pengaduanForm.querySelectorAll('.invalid-feedback');
                errorFeedbacks.forEach(feedback => {
                    feedback.textContent = '';
                });
            }

            function showValidationErrors(errors) {
                Object.keys(errors).forEach(field => {
                    const input = pengaduanForm.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');

                        let feedback = input.parentNode.querySelector('.invalid-feedback');
                        if (!feedback) {
                            feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback';
                            input.parentNode.appendChild(feedback);
                        }
                        feedback.textContent = errors[field][0];
                    }
                });
            }

            function hideAlerts() {
                if (successAlert) successAlert.classList.add('d-none');
                if (errorAlert) errorAlert.classList.add('d-none');
            }

            // Reset modal ketika ditutup
            const pengaduanModal = document.getElementById('pengaduanModal');
            if (pengaduanModal) {
                pengaduanModal.addEventListener('hidden.bs.modal', function() {
                    // Reset form
                    if (pengaduanForm) {
                        pengaduanForm.reset();
                        clearValidationErrors();
                        hideAlerts();
                        hideLoadingState();
                    }
                });
            }

            // Reset modal ulasan ketika ditutup
            const ulasanModal = document.getElementById('ulasanModal');
            if (ulasanModal) {
                ulasanModal.addEventListener('hidden.bs.modal', function() {
                    // Reset form
                    ulasanForm.reset();
                    selectedRating = 0;
                    ratingInput.value = '';
                    ratingText.textContent = 'Pilih Rating';
                    ratingText.className = 'rating-text text-muted';
                    highlightStars(0);

                    // Reset submit button
                    const submitBtn = ulasanForm.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = '<i class="bi bi-send me-1"></i>Kirim Ulasan';
                    submitBtn.disabled = false;
                });
            }

            // Character counter for textarea
            const ulasanTextarea = document.getElementById('ulasan');
            if (ulasanTextarea) {
                const charCountDiv = document.createElement('div');
                charCountDiv.className = 'form-text text-end';
                charCountDiv.id = 'charCounter';
                ulasanTextarea.parentNode.appendChild(charCountDiv);

                ulasanTextarea.addEventListener('input', function() {
                    const length = this.value.length;
                    charCountDiv.textContent = `${length} karakter`;
                    charCountDiv.className = length >= 10 ? 'form-text text-end text-success' :
                        'form-text text-end text-muted';
                });
            }
        });

        // YouTube Autoplay Handler
        document.addEventListener('DOMContentLoaded', function() {
            const youtubeIframes = document.querySelectorAll('iframe[src*="youtube.com/embed"]');

            youtubeIframes.forEach(function(iframe) {
                // Add interaction-based autoplay for mobile
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Force autoplay when video comes into view
                            const src = iframe.src;
                            if (!src.includes('autoplay=1')) {
                                iframe.src = src + (src.includes('?') ? '&' : '?') +
                                    'autoplay=1&mute=1';
                            }
                        }
                    });
                }, {
                    threshold: 0.5
                });

                observer.observe(iframe);
            });

            // Handle user interaction for autoplay
            document.addEventListener('click', function() {
                youtubeIframes.forEach(function(iframe) {
                    const src = iframe.src;
                    if (src.includes('mute=1') && !src.includes('&autoplay=1')) {
                        // Try to enable autoplay after user interaction
                        iframe.src = src.replace('mute=1', 'mute=1&autoplay=1');
                    }
                });
            }, {
                once: true
            });
        });
    </script>

    <!-- Google reCAPTCHA Script -->
    @if (app('App\Services\CaptchaService')->isRequired())
        {!! app('App\Services\CaptchaService')->script() !!}
    @endif
@endpush
