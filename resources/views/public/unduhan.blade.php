@extends('public.layouts.app')

@section('title', 'Unduhan')

@section('content')
    <!-- Header Section -->
    <section class="py-4 py-md-5 text-white"
        style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="display-5 fw-bold mb-2 mb-md-3">Pusat Unduhan</h1>
                    <p class="lead mb-0">Dokumen, formulir, dan file penting untuk masyarakat Katingan</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}"
                                    class="text-white-50">Beranda</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Unduhan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-success bg-gradient text-white rounded-circle mx-auto mb-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-arrow-down fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-success">{{ $totalFiles }}</h3>
                        <p class="text-muted mb-0">Total File</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-primary bg-gradient text-white rounded-circle mx-auto mb-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-pdf fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-primary">{{ $pdfCount }}</h3>
                        <p class="text-muted mb-0">File PDF</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-warning bg-gradient text-white rounded-circle mx-auto mb-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-word fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-warning">{{ $docCount }}</h3>
                        <p class="text-muted mb-0">File Word</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-info bg-gradient text-white rounded-circle mx-auto mb-3"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-download fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-info">{{ $totalDownloads }}</h3>
                        <p class="text-muted mb-0">Total Download</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="container mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <select class="form-select" id="filterJenis">
                                    <option value="">Semua Jenis File</option>
                                    <option value="pdf">PDF</option>
                                    <option value="doc">DOC</option>
                                    <option value="docx">DOCX</option>
                                    <option value="xls">XLS</option>
                                    <option value="xlsx">XLSX</option>
                                    <option value="ppt">PPT</option>
                                    <option value="pptx">PPTX</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="filterKategori">
                                    <option value="">Semua Kategori</option>
                                    <option value="formulir">Formulir</option>
                                    <option value="panduan">Panduan</option>
                                    <option value="peraturan">Peraturan</option>
                                    <option value="laporan">Laporan</option>
                                    <option value="dokumen">Dokumen</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="searchFile" placeholder="Cari file...">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <button class="btn btn-outline-secondary" id="resetFilter">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Downloads Section -->
    <div class="container mb-5">
        @if ($fileDownloads->count() > 0)
            <div class="row g-4" id="downloadsContainer">
                @foreach ($fileDownloads as $file)
                    <div class="col-lg-6 download-item" data-jenis="{{ strtolower($file->file_type) }}"
                        data-kategori="{{ strtolower($file->kategori) }}" data-nama="{{ strtolower($file->nama_file) }}">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="file-icon me-3 flex-shrink-0">
                                        @if (strtolower($file->file_type) == 'pdf')
                                            <div class="icon-box bg-danger text-white rounded"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-file-earmark-pdf fs-4"></i>
                                            </div>
                                        @elseif(in_array(strtolower($file->file_type), ['doc', 'docx']))
                                            <div class="icon-box bg-primary text-white rounded"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-file-earmark-word fs-4"></i>
                                            </div>
                                        @elseif(in_array(strtolower($file->file_type), ['xls', 'xlsx']))
                                            <div class="icon-box bg-success text-white rounded"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-file-earmark-excel fs-4"></i>
                                            </div>
                                        @elseif(in_array(strtolower($file->file_type), ['ppt', 'pptx']))
                                            <div class="icon-box bg-warning text-white rounded"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-file-earmark-ppt fs-4"></i>
                                            </div>
                                        @else
                                            <div class="icon-box bg-secondary text-white rounded"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-file-earmark fs-4"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-2">{{ $file->nama_file }}</h6>
                                        <p class="text-muted small mb-2">{{ Str::limit($file->deskripsi, 120) }}</p>
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-folder me-1"></i>{{ ucfirst($file->kategori) }}
                                            </span>
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-file-type me-1"></i>{{ strtoupper($file->file_type) }}
                                            </span>
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-hdd me-1"></i>{{ $file->file_size ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-muted small">
                                                <i class="bi bi-download me-1"></i>{{ $file->download_count ?? 0 }}
                                                download
                                                <span class="mx-2">•</span>
                                                <i
                                                    class="bi bi-calendar me-1"></i>{{ $file->created_at->format('d M Y') }}
                                            </div>
                                            <a href="{{ route('admin.konten.download.file', $file) }}"
                                                class="btn btn-success btn-sm download-btn" target="_blank">
                                                <i class="bi bi-download me-1"></i>Unduh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                @include('components.custom-pagination', ['paginator' => $fileDownloads])
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-arrow-down text-muted display-1 mb-4"></i>
                <h3 class="text-muted">Belum Ada File</h3>
                <p class="text-muted">File unduhan belum tersedia saat ini.</p>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .icon-box {
            transition: transform 0.3s ease;
        }

        .card:hover .icon-box {
            transform: translateY(-5px);
        }

        .download-btn {
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            transform: translateY(-2px);
        }

        .breadcrumb-dark .breadcrumb-item a {
            text-decoration: none;
        }

        .breadcrumb-dark .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .file-icon {
            transition: transform 0.3s ease;
        }

        .card:hover .file-icon {
            transform: scale(1.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterJenis = document.getElementById('filterJenis');
            const filterKategori = document.getElementById('filterKategori');
            const searchFile = document.getElementById('searchFile');
            const resetFilter = document.getElementById('resetFilter');
            const downloadItems = document.querySelectorAll('.download-item');

            function filterFiles() {
                const jenisValue = filterJenis.value.toLowerCase();
                const kategoriValue = filterKategori.value.toLowerCase();
                const searchValue = searchFile.value.toLowerCase();

                downloadItems.forEach(item => {
                    const jenis = item.dataset.jenis;
                    const kategori = item.dataset.kategori;
                    const nama = item.dataset.nama;

                    const jenisMatch = !jenisValue || jenis.includes(jenisValue);
                    const kategoriMatch = !kategoriValue || kategori.includes(kategoriValue);
                    const searchMatch = !searchValue || nama.includes(searchValue);

                    if (jenisMatch && kategoriMatch && searchMatch) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            filterJenis.addEventListener('change', filterFiles);
            filterKategori.addEventListener('change', filterFiles);
            searchFile.addEventListener('input', filterFiles);

            resetFilter.addEventListener('click', function() {
                filterJenis.value = '';
                filterKategori.value = '';
                searchFile.value = '';
                filterFiles();
            });

            // Handle download tracking
            document.querySelectorAll('.download-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Add download tracking if needed
                    console.log('File downloaded');
                });
            });
        });
    </script>
@endpush
