@extends('public.layouts.app')

@section('title', 'Program & Kegiatan')
@section('description', 'Program pembangunan infrastruktur Dinas PUPR Kabupaten Katingan')

@section('content')
    <!-- Hero Section -->
    <section class="py-4 py-md-5 text-white"
        style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="display-5 fw-bold mb-2 mb-md-3">Program & Kegiatan</h1>
                    <p class="lead mb-0">Program pembangunan infrastruktur untuk kemajuan Kabupaten Katingan</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}"
                                    class="text-white-50">Beranda</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Program</li>
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
                    <h5 class="mb-0 fw-bold text-center text-lg-start">{{ $programs->total() }} Program Ditemukan</h5>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                        <select class="form-select form-select-sm" style="width: auto; min-width: 150px;">
                            <option>Semua Status</option>
                            <option>Perencanaan</option>
                            <option>Berjalan</option>
                            <option>Selesai</option>
                        </select>
                        <select class="form-select form-select-sm" style="width: auto; min-width: 120px;">
                            <option>Semua Tahun</option>
                            <option>2024</option>
                            <option>2023</option>
                            <option>2022</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-5" style="background-color: var(--bg-light);">
        <div class="container">
            @if ($programs->count() > 0)
                <div class="row g-4">
                    @foreach ($programs as $program)
                        <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up"
                            data-aos-delay="{{ ($loop->iteration % 3) * 50 }}">
                            <div class="card h-100 border-0 shadow-sm program-card">
                                <!-- Card Header with Status -->
                                <div class="card-header border-0 bg-transparent p-3 pb-0">
                                    <div
                                        class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                        @php
                                            $statusColor = match ($program->status) {
                                                'Berjalan' => 'success',
                                                'Selesai' => 'primary',
                                                'Perencanaan' => 'warning',
                                                default => 'secondary',
                                            };
                                            $statusIcon = match ($program->status) {
                                                'Berjalan' => 'play-circle',
                                                'Selesai' => 'check-circle',
                                                'Perencanaan' => 'clock',
                                                default => 'circle',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }} px-2 py-1 small">
                                            <i class="bi bi-{{ $statusIcon }} me-1"></i>{{ $program->status }}
                                        </span>
                                        @if ($program->tanggal_mulai)
                                            <small
                                                class="text-muted fw-medium">{{ $program->tanggal_mulai->format('M Y') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body p-3 pt-2">
                                    <!-- Program Title -->
                                    <h5 class="card-title fw-bold mb-2 mb-md-3 program-title line-clamp-2"
                                        style="color: var(--secondary-color); line-height: 1.3; font-size: 1.1rem;">
                                        {{ $program->nama_program }}
                                    </h5>

                                    <!-- Program Description -->
                                    <div class="card-text text-muted mb-2 mb-md-3 program-excerpt line-clamp-3">
                                        {{ Str::limit(html_entity_decode(strip_tags($program->deskripsi), ENT_QUOTES, 'UTF-8'), 100) }}
                                    </div>

                                    <!-- Location -->
                                    @if ($program->lokasi)
                                        <div class="d-flex align-items-center mb-2 mb-md-3 text-muted">
                                            <div class="me-2 d-flex align-items-center justify-content-center bg-light rounded-circle"
                                                style="width: 28px; height: 28px;">
                                                <i class="bi bi-geo-alt text-primary small"></i>
                                            </div>
                                            <small class="fw-medium line-clamp-1">{{ $program->lokasi }}</small>
                                        </div>
                                    @endif

                                    <!-- Timeline -->
                                    @if ($program->tanggal_mulai || $program->tanggal_selesai)
                                        <div class="mb-3 mb-md-4">
                                            <div class="d-flex align-items-center text-muted small">
                                                <div class="me-2 d-flex align-items-center justify-content-center bg-light rounded-circle"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="bi bi-calendar3 text-primary small"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    @if ($program->tanggal_mulai)
                                                        <div class="fw-medium">
                                                            {{ $program->tanggal_mulai->format('d M Y') }}</div>
                                                    @endif
                                                    @if ($program->tanggal_selesai)
                                                        <div class="text-muted small">Target:
                                                            {{ $program->tanggal_selesai->format('d M Y') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Actions -->
                                    <div class="mt-auto">
                                        <button class="btn btn-primary btn-sm w-100 shadow-sm rounded-pill"
                                            data-bs-toggle="modal" data-bs-target="#programModal{{ $program->id }}">
                                            <i class="bi bi-eye me-1"></i>
                                            <span class="d-none d-sm-inline">Lihat Detail Program</span>
                                            <span class="d-inline d-sm-none">Detail</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4 mt-md-5">
                    @include('components.custom-pagination', ['paginator' => $programs])
                </div>
            @else
                <!-- No Programs -->
                <div class="text-center py-5" data-aos="fade-up">
                    <div class="bg-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 100px; height: 100px;">
                        <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="text-muted mb-3">Belum Ada Program</h4>
                    <p class="text-muted">Program pembangunan akan segera dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Program Modals -->
    @foreach ($programs as $program)
        <div class="modal fade" id="programModal{{ $program->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-gradient text-white"
                        style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
                        <div class="flex-grow-1">
                            <h5 class="modal-title fw-bold mb-1 pe-3">{{ $program->nama_program }}</h5>
                            @php
                                $statusColor = match ($program->status) {
                                    'Berjalan' => 'success',
                                    'Selesai' => 'light',
                                    'Perencanaan' => 'warning',
                                    default => 'secondary',
                                };
                                $statusIcon = match ($program->status) {
                                    'Berjalan' => 'play-circle',
                                    'Selesai' => 'check-circle',
                                    'Perencanaan' => 'clock',
                                    default => 'circle',
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }} text-dark">
                                <i class="bi bi-{{ $statusIcon }} me-1"></i>{{ $program->status }}
                            </span>
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-3 p-md-4">
                        <div class="row g-3 g-md-4">
                            <div class="col-12 col-lg-8 order-2 order-lg-1">
                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="bi bi-file-text me-2"></i>Deskripsi Program
                                </h6>
                                <div class="text-muted program-description">
                                    {!! $program->deskripsi !!}
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 order-1 order-lg-2">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-3 mb-md-4 text-primary">
                                            <i class="bi bi-info-circle me-2"></i>Informasi Program
                                        </h6>

                                        <div class="mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-flag text-primary me-2"></i>
                                                <small class="text-muted">Status Program</small>
                                            </div>
                                            @php
                                                $statusColor = match ($program->status) {
                                                    'Berjalan' => 'success',
                                                    'Selesai' => 'primary',
                                                    'Perencanaan' => 'warning',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            <span
                                                class="badge bg-{{ $statusColor }} px-3 py-2">{{ $program->status }}</span>
                                        </div>

                                        @if ($program->lokasi)
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                                    <small class="text-muted">Lokasi</small>
                                                </div>
                                                <span class="fw-medium">{{ $program->lokasi }}</span>
                                            </div>
                                        @endif

                                        @if ($program->tanggal_mulai)
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-calendar-check text-primary me-2"></i>
                                                    <small class="text-muted">Tanggal Mulai</small>
                                                </div>
                                                <span
                                                    class="fw-medium">{{ $program->tanggal_mulai->format('d F Y') }}</span>
                                            </div>
                                        @endif

                                        @if ($program->tanggal_selesai)
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-calendar-x text-primary me-2"></i>
                                                    <small class="text-muted">Target Selesai</small>
                                                </div>
                                                <span
                                                    class="fw-medium">{{ $program->tanggal_selesai->format('d F Y') }}</span>
                                            </div>
                                        @endif

                                        @if ($program->tanggal_mulai && $program->tanggal_selesai)
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-hourglass-split text-primary me-2"></i>
                                                    <small class="text-muted">Durasi Program</small>
                                                </div>
                                                @php
                                                    $durasi = $program->tanggal_mulai->diffInDays(
                                                        $program->tanggal_selesai,
                                                    );
                                                @endphp
                                                <span class="fw-medium">{{ $durasi }} Hari</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- CTA Section -->
    <section class="py-5 text-white" style="background: linear-gradient(135deg, var(--primary-color) 0%, #e6a200 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h3 class="fw-bold mb-3">Punya Usulan Program?</h3>
                    <p class="mb-0">Sampaikan usulan atau saran program pembangunan infrastruktur untuk kemajuan
                        Kabupaten Katingan.</p>
                </div>
                <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                    <a href="{{ route('public.kontak') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-chat-dots me-2"></i>Sampaikan Usulan
                    </a>
                </div>
            </div>
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

        /* Enhanced Program Cards */
        .program-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .program-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .program-card .card-header {
            padding: 1.25rem 1.5rem 0.5rem;
        }

        .program-title {
            min-height: 3.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .program-excerpt {
            min-height: 4rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }

        .program-card .badge {
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 20px;
        }

        .program-card .btn {
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .program-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 123, 255, 0.3);
        }

        /* Modal Enhancements */
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
            padding: 2rem 2rem 1rem;
        }

        .modal-body {
            padding: 0 2rem 1rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 2rem 2rem;
            background: #f8f9fa;
        }

        /* Program Description Styling */
        .program-description {
            line-height: 1.7;
        }

        .program-description h1,
        .program-description h2,
        .program-description h3,
        .program-description h4,
        .program-description h5,
        .program-description h6 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            margin-top: 1.5rem;
        }

        .program-description h1 {
            font-size: 1.5rem;
        }

        .program-description h2 {
            font-size: 1.4rem;
        }

        .program-description h3 {
            font-size: 1.3rem;
        }

        .program-description h4 {
            font-size: 1.2rem;
        }

        .program-description h5 {
            font-size: 1.1rem;
        }

        .program-description h6 {
            font-size: 1rem;
        }

        .program-description p {
            margin-bottom: 1rem;
            text-align: justify;
        }

        .program-description ul,
        .program-description ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        .program-description li {
            margin-bottom: 0.5rem;
        }

        .program-description strong,
        .program-description b {
            color: var(--secondary-color);
            font-weight: 600;
        }

        .program-description em,
        .program-description i {
            color: #666;
        }

        .program-description blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
            margin: 1rem 0;
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
        }

        /* Information Card in Modal */
        .modal .card {
            border-radius: 15px;
            border: 1px solid #e9ecef;
        }

        .modal .card-body {
            padding: 1.5rem;
        }

        /* Status Badge Improvements */
        .badge {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Icon Styling */
        .bi {
            font-size: 1rem;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 50px;
            margin: 0 2px;
            border: none;
            color: var(--secondary-color);
            padding: 0.5rem 1rem;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .display-5 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .program-card .card-header {
                padding: 0.75rem 0.75rem 0.25rem;
            }

            .program-card .card-body {
                padding: 0.5rem 0.75rem 0.75rem;
            }

            .modal-header {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .modal-header .btn-close {
                position: absolute;
                top: 1rem;
                right: 1rem;
                margin: 0;
            }

            .modal-body {
                padding: 0.75rem;
            }

            .modal-footer {
                padding: 0.75rem;
            }

            .program-title {
                font-size: 1rem !important;
                line-height: 1.3;
            }

            .program-excerpt {
                font-size: 0.875rem;
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
            .py-4 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }

            .py-5 {
                padding-top: 2.5rem !important;
                padding-bottom: 2.5rem !important;
            }

            .program-card {
                margin-bottom: 1rem;
            }

            .program-card .card-header {
                padding: 0.5rem;
            }

            .program-card .card-body {
                padding: 0.5rem;
            }

            .program-title {
                font-size: 0.95rem !important;
                margin-bottom: 0.5rem !important;
            }

            .program-excerpt {
                font-size: 0.8rem;
                margin-bottom: 0.75rem !important;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem !important;
            }

            .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-header h5 {
                font-size: 1.1rem;
                padding-right: 2rem;
            }

            .lead {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .g-4 {
                --bs-gutter-x: 0.75rem;
                --bs-gutter-y: 0.75rem;
            }

            .program-card .card-body {
                padding: 0.4rem;
            }

            .program-title {
                font-size: 0.9rem !important;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .modal-dialog {
                margin: 0.25rem;
            }
        }

        /* Filter Section */
        .form-select {
            border-radius: 20px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        @media (max-width: 576px) {
            .form-select {
                font-size: 0.8rem;
                padding: 0.375rem 2rem 0.375rem 0.75rem;
            }
        }

        /* Loading States */
        .program-card.loading {
            opacity: 0.7;
            pointer-events: none;
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

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Hover Effects for Icons */
        .program-card .bg-light {
            transition: all 0.3s ease;
        }

        .program-card .bg-light:hover {
            background-color: var(--primary-color) !important;
            transform: scale(1.05);
        }

        .program-card .bg-light:hover .bi {
            color: white !important;
        }
    </style>
@endpush
