@extends('public.layouts.app')

@section('title', 'Galeri')

@section('content')
    <!-- Header Section -->
    <section class="py-4 py-md-5 text-white"
        style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="display-5 fw-bold mb-2 mb-md-3">Galeri Foto</h1>
                    <p class="lead mb-0">Dokumentasi kegiatan dan program Dinas PUPR Katingan</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}"
                                    class="text-white-50">Beranda</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="container mb-4 mb-md-5">
        <div class="row g-3 g-md-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box bg-primary bg-gradient text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-images fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-1" style="font-size: 1.25rem;">{{ $totalGaleris }}</h4>
                        <p class="text-muted mb-0 small">Total Foto</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box bg-success bg-gradient text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-calendar-event fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-success mb-1" style="font-size: 1.25rem;">{{ $monthlyCount }}</h4>
                        <p class="text-muted mb-0 small">Bulan Ini</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box bg-warning bg-gradient text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-camera fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-warning mb-1" style="font-size: 1.25rem;">{{ $weeklyCount }}</h4>
                        <p class="text-muted mb-0 small">Minggu Ini</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box bg-info bg-gradient text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-eye fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-info mb-1" style="font-size: 1.25rem;">{{ $totalViews }}</h4>
                        <p class="text-muted mb-0 small">Total Views</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="container mb-4 mb-md-5">
        @if ($galeris->count() > 0)
            <div class="row g-3 g-md-4" id="gallery">
                @foreach ($galeris as $galeri)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 gallery-item">
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img src="{{ asset('storage/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}"
                                    class="card-img-top h-100 w-100 object-cover gallery-image"
                                    style="object-fit: cover; transition: transform 0.3s ease;" data-bs-toggle="modal"
                                    data-bs-target="#imageModal" data-image="{{ asset('storage/' . $galeri->file_path) }}"
                                    data-title="{{ $galeri->judul }}" data-description="{{ $galeri->deskripsi }}"
                                    data-date="{{ $galeri->created_at->format('d F Y') }}">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary px-2 py-1">
                                        <i class="bi bi-eye me-1"></i>{{ $galeri->views ?? 0 }}
                                    </span>
                                </div>
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                    style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s ease;">
                                    <i class="bi bi-zoom-in text-white fs-1"></i>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h5 class="card-title fw-bold mb-2 line-clamp-2" style="font-size: 1rem;">
                                    {{ $galeri->judul }}</h5>
                                <p class="card-text text-muted small mb-2 mb-md-3 line-clamp-2">
                                    {{ Str::limit($galeri->deskripsi, 80) }}</p>
                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>{{ $galeri->created_at->format('d M Y') }}
                                    </small>
                                    <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-image="{{ asset('storage/' . $galeri->file_path) }}"
                                        data-title="{{ $galeri->judul }}" data-description="{{ $galeri->deskripsi }}"
                                        data-date="{{ $galeri->created_at->format('d F Y') }}">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4 mt-md-5">
                @include('components.custom-pagination', ['paginator' => $galeris])
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-images text-muted display-1 mb-4"></i>
                <h3 class="text-muted">Belum Ada Foto</h3>
                <p class="text-muted">Galeri foto belum tersedia saat ini.</p>
            </div>
        @endif
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-0 p-3">
                    <h5 class="modal-title fw-bold" id="imageModalLabel">Detail Foto</h5>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img id="modalImage" src="" alt="" class="w-100 rounded-bottom">
                    <div class="p-4">
                        <h6 class="fw-bold mb-2" id="modalTitle"></h6>
                        <p class="text-muted mb-2" id="modalDescription"></p>
                        <small class="text-muted" id="modalDate"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .gallery-item:hover .gallery-image {
            transform: scale(1.05);
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1 !important;
        }

        .gallery-image {
            cursor: pointer;
        }

        .icon-box {
            transition: transform 0.3s ease;
        }

        .card:hover .icon-box {
            transform: translateY(-5px);
        }

        .breadcrumb-dark .breadcrumb-item a {
            text-decoration: none;
        }

        .breadcrumb-dark .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        /* Line Clamp Utilities */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .display-5 {
                font-size: 2rem;
            }

            .lead {
                font-size: 1.1rem;
            }

            .card-body {
                padding: 0.75rem !important;
            }

            .gallery-item {
                margin-bottom: 0.75rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-header {
                padding: 0.75rem;
            }

            .modal-header h5 {
                font-size: 1.1rem;
                padding-right: 2rem;
            }

            .pagination-wrapper .pagination {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.25rem;
            }

            .pagination-wrapper .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }

            .display-5 {
                font-size: 1.75rem;
            }

            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .g-3 {
                --bs-gutter-x: 0.75rem;
                --bs-gutter-y: 0.75rem;
            }

            .card-body {
                padding: 0.5rem !important;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.4rem !important;
            }

            .modal-dialog {
                margin: 0.25rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle modal image display
            const imageModal = document.getElementById('imageModal');

            // Event delegation for dynamically loaded content
            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-bs-target="#imageModal"]')) {
                    const trigger = e.target.closest('[data-bs-target="#imageModal"]');
                    const image = trigger.dataset.image;
                    const title = trigger.dataset.title;
                    const description = trigger.dataset.description;
                    const date = trigger.dataset.date;

                    document.getElementById('modalImage').src = image;
                    document.getElementById('modalTitle').textContent = title;
                    document.getElementById('modalDescription').textContent = description;
                    document.getElementById('modalDate').textContent = date;
                }
            });
        });
    </script>
@endpush
