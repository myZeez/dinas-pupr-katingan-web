@extends('public.layouts.app')

@section('title', 'Berita & Publikasi')
@section('description', 'Berita terkini dan publikasi Dinas PUPR Kabupaten Katingan')

@section('content')
    <!-- Hero Section -->
    <section class="py-4 py-md-5 text-white"
        style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="display-5 fw-bold mb-2 mb-md-3">Berita & Publikasi</h1>
                    <p class="lead mb-0">Informasi terkini seputar kegiatan dan program Dinas PUPR Katingan</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}"
                                    class="text-white-50">Beranda</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Berita</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-3 py-md-4 bg-white shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 mb-2 mb-lg-0">
                    <h5 class="mb-0 fw-bold text-center text-lg-start">{{ $beritas->total() }} Berita Ditemukan</h5>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="d-flex justify-content-lg-end">
                        <div class="input-group" style="max-width: 300px; width: 100%;">
                            <input type="text" class="form-control" placeholder="Cari berita..." id="searchInput">
                            <button class="btn btn-outline-primary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-5" style="background-color: var(--bg-light);">
        <div class="container">
            @if ($beritas->count() > 0)
                <div class="row g-4">
                    @foreach ($beritas as $berita)
                        <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up"
                            data-aos-delay="{{ ($loop->iteration % 3) * 50 }}">
                            <article class="card h-100 border-0 shadow-sm news-card">
                                <!-- News Image -->
                                <div class="position-relative overflow-hidden" style="height: 200px;">
                                    @if ($berita->thumbnail)
                                        <img src="{{ $berita->thumbnail_url }}" class="card-img-top h-100"
                                            alt="{{ $berita->judul }}" style="object-fit: cover;"
                                            onerror="this.style.display='none'; this.parentElement.querySelector('.bg-light').style.display='flex';">
                                    @endif

                                    <div class="bg-light h-100 d-flex align-items-center justify-content-center"
                                        style="{{ $berita->thumbnail ? 'display: none;' : 'display: flex;' }}">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>

                                    <!-- Date Badge -->
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-primary px-2 py-1">
                                            {{ $berita->tanggal ? $berita->tanggal->format('d M') : $berita->created_at->format('d M') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- News Content -->
                                <div class="card-body p-3 p-md-4">
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $berita->tanggal ? $berita->tanggal->format('d F Y') : $berita->created_at->format('d F Y') }}
                                            @if ($berita->author)
                                                <span class="ms-3">
                                                    <i class="bi bi-person-fill me-1"></i>
                                                    {{ $berita->author }}
                                                </span>
                                            @endif
                                        </small>
                                    </div>

                                    <h5 class="card-title fw-bold mb-3" style="color: var(--secondary-color);">
                                        <a href="{{ route('public.berita.show', $berita->slug) }}"
                                            class="text-decoration-none text-inherit">
                                            {{ $berita->judul }}
                                        </a>
                                    </h5>

                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit(strip_tags($berita->konten), 120) }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('public.berita.show', $berita->slug) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            Baca Selengkapnya
                                        </a>
                                        <div class="text-muted small">
                                            <i class="bi bi-eye me-1"></i>
                                            <span>{{ rand(50, 500) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    @include('components.custom-pagination', ['paginator' => $beritas])
                </div>
            @else
                <!-- No News -->
                <div class="text-center py-5" data-aos="fade-up">
                    <div class="bg-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 100px; height: 100px;">
                        <i class="bi bi-newspaper text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="text-muted mb-3">Belum Ada Berita</h4>
                    <p class="text-muted">Berita dan publikasi akan segera dipublikasikan.</p>
                    <a href="{{ route('public.home') }}" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .breadcrumb-item a {
            text-decoration: none;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }

        .news-card {
            transition: all 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .news-card .card-title a:hover {
            color: var(--primary-color) !important;
        }

        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 2px !important;
            border: 1px solid #dee2e6 !important;
            color: var(--secondary-color) !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 1rem !important;
            line-height: 1.25 !important;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        .input-group .form-control:focus {
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: none;
        }
    </style>
@endpush
