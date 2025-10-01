@extends('public.layouts.app')

@section('title', 'Struktur Organisasi')
@section('description', 'Struktur Organisasi Dinas PUPR Kabupaten Katingan - Pimpinan dan Tim Terbaik')

@push('styles')
    <style>
        .struktur-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .struktur-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .avatar-placeholder {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto 1rem;
        }

        .jabatan-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 1.5rem;
            margin: 2rem 0 1rem;
            border-radius: 10px;
            position: relative;
        }

        .jabatan-header::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-bottom: 15px solid #007bff;
        }

        .jabatan-header:first-child::before {
            display: none;
        }

        .connecting-line {
            width: 2px;
            height: 30px;
            background: #007bff;
            margin: 0 auto;
        }

        .member-count {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 0.3rem 1rem;
            font-size: 0.9rem;
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        @media (max-width: 768px) {
            .struktur-card {
                margin-bottom: 1rem;
            }

            .jabatan-header {
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="py-4 py-md-5 text-white"
        style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="display-5 fw-bold mb-2 mb-md-3">Struktur Organisasi</h1>
                    <p class="lead mb-0">Hierarki kepemimpinan dan tim terbaik Dinas PUPR Katingan</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}"
                                    class="text-white-50">Beranda</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Struktur</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-3 py-md-4 bg-white shadow-sm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                        <div class="badge bg-primary text-white px-3 py-2">
                            <i class="fas fa-users me-1"></i>{{ $totalAnggota }} Total Anggota
                        </div>
                        <div class="badge bg-success text-white px-3 py-2">
                            <i class="fas fa-sitemap me-1"></i>{{ $totalJabatan }} Posisi Jabatan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <i class="fas fa-sitemap fa-5x text-white"></i>
    </div>
    </div>
    </div>
    </div>
    </section>

    <!-- Struktur Organisasi Section -->
    <section class="py-5">
        <div class="container">
            @if ($strukturByJabatan->count() > 0)
                @foreach ($strukturByJabatan as $jabatanGroup)
                    <!-- Connecting Line (except for first item) -->
                    @if (!$loop->first)
                        <div class="connecting-line" data-aos="fade-in"></div>
                    @endif

                    <!-- Jabatan Header -->
                    <div class="jabatan-header text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <h3 class="mb-2 fw-bold">{{ $jabatanGroup['jabatan'] }}</h3>
                        <span class="member-count">
                            <i class="fas fa-users me-1"></i>{{ $jabatanGroup['anggota']->count() }} Anggota
                        </span>
                    </div>

                    <!-- Anggota Cards -->
                    <div class="row justify-content-center mb-4">
                        @foreach ($jabatanGroup['anggota'] as $anggota)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3" data-aos="zoom-in"
                                data-aos-delay="{{ $loop->parent->index * 50 + $loop->index * 30 }}">
                                <div class="card struktur-card h-100 position-relative">
                                    <!-- Status Badge -->
                                    <div class="status-badge">
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    </div>

                                    <div class="card-body text-center p-4">
                                        <!-- Avatar -->
                                        @if ($anggota->foto)
                                            <img src="{{ asset('storage/' . $anggota->foto) }}"
                                                class="rounded-circle mx-auto d-block mb-3"
                                                style="width: 100px; height: 100px; object-fit: cover;"
                                                alt="Foto {{ $anggota->nama }}">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($anggota->nama, 0, 2)) }}
                                            </div>
                                        @endif

                                        <!-- Nama -->
                                        <h5 class="fw-bold text-primary mb-2">{{ $anggota->nama }}</h5>

                                        <!-- Jabatan -->
                                        <p class="text-muted mb-3">{{ $anggota->jabatan }}</p>

                                        <!-- Details -->
                                        <div class="border-top pt-3">
                                            @if ($anggota->nip)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <small class="text-muted"><i
                                                            class="fas fa-id-card me-1"></i>NIP:</small>
                                                    <small class="fw-semibold">{{ $anggota->nip }}</small>
                                                </div>
                                            @endif

                                            @if ($anggota->golongan)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <small class="text-muted"><i
                                                            class="fas fa-star me-1"></i>Golongan:</small>
                                                    <small class="fw-semibold">{{ $anggota->golongan }}</small>
                                                </div>
                                            @endif

                                            @if ($anggota->email)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <small class="text-muted"><i
                                                            class="fas fa-envelope me-1"></i>Email:</small>
                                                    <small class="fw-semibold text-break">{{ $anggota->email }}</small>
                                                </div>
                                            @endif

                                            @if ($anggota->telepon)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted"><i
                                                            class="fas fa-phone me-1"></i>Telepon:</small>
                                                    <small class="fw-semibold">{{ $anggota->telepon }}</small>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- PLT Information (if applicable) -->
                                        @if ($anggota->memerlukan_plt && ($anggota->plt_nama_manual || $anggota->pltStruktur))
                                            <div class="mt-3 p-2 bg-info bg-opacity-10 rounded">
                                                <small class="text-info fw-semibold">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    PLT:
                                                    @if ($anggota->pltStruktur)
                                                        {{ $anggota->pltStruktur->nama }}
                                                    @else
                                                        {{ $anggota->plt_nama_manual }}
                                                    @endif
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-users fa-5x text-muted"></i>
                    </div>
                    <h3 class="text-muted">Belum Ada Data Struktur Organisasi</h3>
                    <p class="text-muted">Data struktur organisasi belum tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Summary Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-3" data-aos="fade-up">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-primary">{{ $totalAnggota }}</h3>
                            <p class="text-muted mb-0">Total Anggota Tim</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="50">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-success mb-3">
                                <i class="fas fa-sitemap fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-success">{{ $totalJabatan }}</h3>
                            <p class="text-muted mb-0">Posisi Jabatan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-info mb-3">
                                <i class="fas fa-building fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-info">1</h3>
                            <p class="text-muted mb-0">Dinas PUPR</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
