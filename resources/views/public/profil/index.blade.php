@extends('public.layouts.app')

@section('title', 'Profil Dinas PUPR')
@section('description', 'Profil lengkap Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 text-white position-relative"
        style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); min-height: 60vh;">
        @if ($profil && $profil->foto_dinas)
            <div class="position-absolute top-0 start-0 w-100 h-100"
                style="background: url('{{ $profil->foto_dinas_url }}') center/cover; opacity: 0.2;"></div>
        @endif
        <div class="container position-relative">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">
                        {{ $profil->nama_dinas ?? 'Dinas PUPR Kabupaten Katingan' }}
                    </h1>
                    <p class="lead mb-4 fs-5">
                        {{ $profil->deskripsi ?? 'Melayani dengan dedikasi untuk membangun infrastruktur yang berkualitas dan berkelanjutan' }}
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#tentang" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-info-circle me-2"></i>Tentang Kami
                        </a>
                        <a href="#kontak" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-phone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
                @if ($profil && $profil->foto_profil)
                    <div class="col-lg-4 text-center" data-aos="fade-left">
                        <img src="{{ $profil->foto_profil_url }}" class="img-fluid rounded-circle shadow-lg"
                            style="max-width: 300px; border: 5px solid rgba(255,255,255,0.2);">
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-primary">
                                {{ $hierarki->sum(function ($h) {return $h->children->count() + 1;}) }}</h3>
                            <p class="text-muted mb-0">Anggota Tim</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-success mb-3">
                                <i class="fas fa-eye fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-success">1</h3>
                            <p class="text-muted mb-0">Visi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-info mb-3">
                                <i class="fas fa-list fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-info">{{ $misi->count() }}</h3>
                            <p class="text-muted mb-0">Misi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-warning mb-3">
                                <i class="fas fa-tasks fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-warning">{{ $tupoksi->count() }}</h3>
                            <p class="text-muted mb-0">Tupoksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-3 text-primary">Tentang Dinas</h2>
                    <p class="lead text-muted">Mengenal lebih dekat visi, misi, dan tujuan kami</p>
                </div>
            </div>

            <div class="row">
                <!-- Visi -->
                @if ($visi)
                    <div class="col-lg-6 mb-4" data-aos="fade-right">
                        <div class="card border-0 shadow-lg h-100 border-start border-success border-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-eye fa-lg"></i>
                                    </div>
                                    <h4 class="fw-bold text-success mb-0">{{ $visi->judul }}</h4>
                                </div>
                                <p class="text-muted mb-0">{{ $visi->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Misi -->
                <div class="col-lg-6 mb-4" data-aos="fade-left">
                    <div class="card border-0 shadow-lg h-100 border-start border-info border-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="fas fa-list fa-lg"></i>
                                </div>
                                <h4 class="fw-bold text-info mb-0">Misi Dinas</h4>
                            </div>
                            @if ($misi->count() > 0)
                                <ol class="ps-3">
                                    @foreach ($misi as $item)
                                        <li class="text-muted mb-2">{{ $item->deskripsi }}</li>
                                    @endforeach
                                </ol>
                            @else
                                <p class="text-muted mb-0">Misi akan segera ditambahkan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tupoksi -->
            @if ($tupoksi->count() > 0)
                <div class="row mt-4">
                    <div class="col-12" data-aos="fade-up">
                        <div class="card border-0 shadow-lg border-start border-warning border-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-tasks fa-lg"></i>
                                    </div>
                                    <h4 class="fw-bold text-warning mb-0">Tugas Pokok dan Fungsi</h4>
                                </div>
                                <div class="row">
                                    @foreach ($tupoksi as $item)
                                        <div class="col-lg-6 mb-3">
                                            <h6 class="fw-bold text-warning">{{ $item->judul }}</h6>
                                            <p class="text-muted mb-0">{{ $item->deskripsi }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Carousel Section -->
    @if ($carousel->count() > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5" data-aos="fade-up">
                        <h2 class="display-5 fw-bold mb-3 text-primary">Galeri Kegiatan</h2>
                        <p class="lead text-muted">Dokumentasi kegiatan dan pencapaian dinas</p>
                    </div>
                </div>

                <div id="carouselKegiatan" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-4 shadow-lg">
                        @foreach ($carousel as $index => $item)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $item->media_url }}" class="d-block w-100"
                                    style="height: 400px; object-fit: cover;">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                                    <h5 class="fw-bold">{{ $item->judul }}</h5>
                                    @if ($item->deskripsi)
                                        <p>{{ $item->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselKegiatan"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselKegiatan"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </section>
    @endif

    <!-- Video Section -->
    @if ($videos->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5" data-aos="fade-up">
                        <h2 class="display-5 fw-bold mb-3 text-primary">Video Profil</h2>
                        <p class="lead text-muted">Mengenal lebih dekat melalui video</p>
                    </div>
                </div>

                <div class="row">
                    @foreach ($videos as $video)
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up"
                            data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card border-0 shadow-lg h-100">
                                <div class="position-relative">
                                    @if ($video->media)
                                        <img src="{{ $video->media_url }}" class="card-img-top"
                                            style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="height: 200px;">
                                            <i class="fab fa-youtube fa-3x text-danger"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <a href="{{ $video->url }}" target="_blank"
                                            class="btn btn-danger rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="fas fa-play fa-lg"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="fw-bold">{{ $video->judul }}</h6>
                                    @if ($video->deskripsi)
                                        <p class="text-muted small">{{ Str::limit($video->deskripsi, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Kontak Section -->
    <section id="kontak" class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-3">Hubungi Kami</h2>
                    <p class="lead">Siap melayani dan bekerja sama dengan Anda</p>
                </div>
            </div>

            @if ($profil)
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card bg-white text-dark border-0 shadow h-100">
                            <div class="card-body text-center p-4">
                                <div class="text-primary mb-3">
                                    <i class="fas fa-map-marker-alt fa-3x"></i>
                                </div>
                                <h5 class="fw-bold">Alamat</h5>
                                <p class="text-muted">{{ $profil->alamat ?? 'Alamat akan segera ditambahkan' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card bg-white text-dark border-0 shadow h-100">
                            <div class="card-body text-center p-4">
                                <div class="text-primary mb-3">
                                    <i class="fas fa-phone fa-3x"></i>
                                </div>
                                <h5 class="fw-bold">Telepon</h5>
                                <p class="text-muted">{{ $profil->telepon ?? 'Nomor telepon akan segera ditambahkan' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card bg-white text-dark border-0 shadow h-100">
                            <div class="card-body text-center p-4">
                                <div class="text-primary mb-3">
                                    <i class="fas fa-envelope fa-3x"></i>
                                </div>
                                <h5 class="fw-bold">Email</h5>
                                <p class="text-muted">{{ $profil->email ?? 'Email akan segera ditambahkan' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                @if ($profil->facebook || $profil->instagram || $profil->youtube || $profil->website)
                    <div class="row mt-4">
                        <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="400">
                            <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                            <div class="d-flex justify-content-center gap-3">
                                @if ($profil->facebook)
                                    <a href="{{ $profil->facebook }}" target="_blank"
                                        class="btn btn-light btn-lg rounded-circle">
                                        <i class="fab fa-facebook fa-lg text-primary"></i>
                                    </a>
                                @endif
                                @if ($profil->instagram)
                                    <a href="{{ $profil->instagram }}" target="_blank"
                                        class="btn btn-light btn-lg rounded-circle">
                                        <i class="fab fa-instagram fa-lg text-danger"></i>
                                    </a>
                                @endif
                                @if ($profil->youtube)
                                    <a href="{{ $profil->youtube }}" target="_blank"
                                        class="btn btn-light btn-lg rounded-circle">
                                        <i class="fab fa-youtube fa-lg text-danger"></i>
                                    </a>
                                @endif
                                @if ($profil->website)
                                    <a href="{{ $profil->website }}" target="_blank"
                                        class="btn btn-light btn-lg rounded-circle">
                                        <i class="fas fa-globe fa-lg text-info"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>

    @push('styles')
        <style>
            .min-vh-50 {
                min-height: 50vh;
            }

            .carousel-item img {
                border-radius: 1rem;
            }

            .btn-lg.rounded-circle {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                transition: transform 0.3s ease;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Smooth scrolling for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

                // Auto-play carousel with interval
                const carousel = document.querySelector('#carouselKegiatan');
                if (carousel) {
                    new bootstrap.Carousel(carousel, {
                        interval: 5000,
                        wrap: true
                    });
                }
            });
        </script>
    @endpush
@endsection
