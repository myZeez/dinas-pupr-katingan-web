@extends('layouts.admin')

@section('title', 'Manajemen Konten')

{{-- Load Dependencies di Head --}}
@push('styles')
    <style>
        /* ==========================================================================
       KONTEN MANAGEMENT - UNIFIED STYLES
       ========================================================================== */

        /* Action Buttons - Konsisten untuk semua tab */
        .btn-action {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            min-width: 70px;
            text-align: center;
            background-color: white;
            color: #6c757d;
            border: 1px solid #dee2e6;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 0.25rem;
        }

        .btn-action:hover {
            background-color: #f8f9fa;
            border-color: #adb5bd;
            color: #495057;
            text-decoration: none;
        }

        .btn-action i {
            margin-right: 0.25rem;
            font-size: 0.75rem;
        }

        .btn-group-vertical {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
            align-items: stretch;
        }

        /* Button Variants */
        .btn-action.btn-detail {
            border-color: #6f42c1;
            color: #6f42c1;
        }

        .btn-action.btn-detail:hover {
            background-color: #6f42c1;
            color: white;
        }

        .btn-action.btn-edit {
            border-color: #fd7e14;
            color: #fd7e14;
        }

        .btn-action.btn-edit:hover {
            background-color: #fd7e14;
            color: white;
        }

        .btn-action.btn-delete {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-action.btn-delete:hover {
            background-color: #dc3545;
            color: white;
        }

        .btn-action.btn-download {
            border-color: #20c997;
            color: #20c997;
        }

        .btn-action.btn-download:hover {
            background-color: #20c997;
            color: white;
        }

        /* Action column styling */
        .action-column {
            min-width: 80px;
            vertical-align: middle;
        }

        /* Status badges */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
        }

        .status-success {
            background-color: #d1edff;
            color: #0c63e4;
            border: 1px solid #b3d9ff;
        }

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Table improvements */
        .table thead th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* GIF Notifications Styles */
        .simple-toast {
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
            font-family: 'Inter', sans-serif !important;
            padding: 20px !important;
        }

        .simple-toast .swal2-title {
            font-weight: 600 !important;
            font-size: 15px !important;
            margin-bottom: 0 !important;
            margin-top: 10px !important;
            text-align: center !important;
        }

        .simple-dialog {
            border-radius: 16px !important;
            padding: 30px !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .simple-dialog .swal2-title {
            font-weight: 600 !important;
            font-size: 18px !important;
            margin-bottom: 0 !important;
            margin-top: 15px !important;
            text-align: center !important;
        }

        .simple-dialog .swal2-content {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <!-- Notification Container -->
    <div id="notification-container" class="position-fixed" style="top: 80px; right: 20px; z-index: 1050; width: 350px;"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Manajemen Konten</h1>
                        <p class="mb-0 text-muted">Kelola semua konten dalam satu tempat</p>
                    </div>
                </div>

                {{-- Statistics Cards --}}
                <div class="row mb-4">
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card border-left-primary shadow h-100 py-1">
                            <div class="card-body p-3">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Berita</div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $beritaCount ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-newspaper fa-lg text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card border-left-warning shadow h-100 py-1">
                            <div class="card-body p-3">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Galeri</div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $galeriCount ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-images fa-lg text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card border-left-success shadow h-100 py-1">
                            <div class="card-body p-3">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">File Download
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $downloadCount ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-download fa-lg text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                        <div class="card border-left-info shadow h-100 py-1">
                            <div class="card-body p-3">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Konten
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ ($beritaCount ?? 0) + ($galeriCount ?? 0) + ($downloadCount ?? 0) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-lg text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabs Navigation --}}
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <ul class="nav nav-tabs card-header-tabs" id="kontenTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ !request('tab') || request('tab') == 'berita' ? 'active' : '' }}"
                                    id="berita-tab" data-bs-toggle="tab" data-bs-target="#berita" type="button"
                                    role="tab" aria-controls="berita"
                                    aria-selected="{{ !request('tab') || request('tab') == 'berita' ? 'true' : 'false' }}">
                                    <i class="fas fa-newspaper me-2"></i>Berita ({{ $beritaCount ?? 0 }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ request('tab') == 'galeri' ? 'active' : '' }}" id="galeri-tab"
                                    data-bs-toggle="tab" data-bs-target="#galeri" type="button" role="tab"
                                    aria-controls="galeri"
                                    aria-selected="{{ request('tab') == 'galeri' ? 'true' : 'false' }}">
                                    <i class="fas fa-images me-2"></i>Galeri ({{ $galeriCount ?? 0 }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ request('tab') == 'download' ? 'active' : '' }}"
                                    id="download-tab" data-bs-toggle="tab" data-bs-target="#download" type="button"
                                    role="tab" aria-controls="download"
                                    aria-selected="{{ request('tab') == 'download' ? 'true' : 'false' }}">
                                    <i class="fas fa-download me-2"></i>File Download ({{ $downloadCount ?? 0 }})
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="kontenTabsContent">
                            {{-- Tab Berita --}}
                            <div class="tab-pane fade {{ !request('tab') || request('tab') == 'berita' ? 'show active' : '' }}"
                                id="berita" role="tabpanel" aria-labelledby="berita-tab">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">Berita</h4>
                                    <a href="{{ route('admin.konten.berita.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Berita
                                    </a>
                                </div>

                                @if (isset($beritas) && $beritas->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Judul</th>
                                                    <th>Status</th>
                                                    <th>Tanggal</th>
                                                    <th width="120">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($beritas as $berita)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if ($berita->thumbnail)
                                                                    <img src="{{ $berita->thumbnail_url }}"
                                                                        class="rounded me-3"
                                                                        style="width: 60px; height: 60px; object-fit: cover;"
                                                                        alt="{{ $berita->judul }}"
                                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                                        style="width: 60px; height: 60px; display: none;">
                                                                        <i class="fas fa-newspaper text-muted"></i>
                                                                    </div>
                                                                @else
                                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                                        style="width: 60px; height: 60px;">
                                                                        <i class="fas fa-newspaper text-muted"></i>
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <h6 class="mb-0">{{ $berita->judul }}</h6>
                                                                    <small
                                                                        class="text-muted">{{ Str::limit(strip_tags($berita->konten), 100) }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($berita->status == 'published')
                                                                <span class="badge bg-success">Published</span>
                                                            @else
                                                                <span class="badge bg-warning">Draft</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $berita->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            <div class="btn-group-vertical">
                                                                <a href="{{ route('admin.konten.berita.show', $berita) }}"
                                                                    class="btn btn-action btn-detail" title="Detail">
                                                                    <i class="bi bi-eye"></i> Detail
                                                                </a>
                                                                <a href="{{ route('admin.konten.berita.edit', $berita) }}"
                                                                    class="btn btn-action btn-edit" title="Edit">
                                                                    <i class="bi bi-pencil"></i> Edit
                                                                </a>
                                                                <button type="button" class="btn btn-action btn-delete"
                                                                    title="Hapus"
                                                                    onclick="KontenActions.deleteBerita('{{ $berita->id }}', '{{ addslashes($berita->judul) }}')">
                                                                    <i class="bi bi-trash"></i> Hapus
                                                                </button>
                                                            </div>

                                                            {{-- Hidden form for delete --}}
                                                            <form id="delete-berita-form-{{ $berita->id }}"
                                                                method="POST"
                                                                action="{{ route('admin.konten.berita.destroy', $berita) }}"
                                                                style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination --}}
                                    @if (isset($beritas) && method_exists($beritas, 'links'))
                                        <div class="d-flex justify-content-center">
                                            @include('components.custom-pagination', [
                                                'paginator' => $beritas,
                                            ])
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada berita</h5>
                                        <p class="text-muted">Tambahkan berita pertama untuk memulai</p>
                                        <a href="{{ route('admin.konten.berita.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Berita
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Galeri --}}
                            <div class="tab-pane fade {{ request('tab') == 'galeri' ? 'show active' : '' }}"
                                id="galeri" role="tabpanel" aria-labelledby="galeri-tab">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">Galeri</h4>
                                    <a href="{{ route('admin.konten.galeri.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Galeri
                                    </a>
                                </div>

                                @if (isset($galeris) && $galeris->count() > 0)
                                    <div class="row">
                                        @foreach ($galeris as $galeri)
                                            <div class="col-md-4 mb-4">
                                                <div class="card">
                                                    @if ($galeri->file_path)
                                                        <img src="{{ $galeri->file_url }}" class="card-img-top"
                                                            alt="{{ $galeri->judul }}"
                                                            style="height: 200px; object-fit: cover;">
                                                    @else
                                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                                            style="height: 200px;">
                                                            <i class="fas fa-image fa-3x text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $galeri->judul }}</h5>
                                                        <p class="card-text">{{ Str::limit($galeri->deskripsi, 100) }}</p>
                                                        <div class="btn-group-vertical w-100">
                                                            <a href="{{ route('admin.konten.galeri.show', $galeri) }}"
                                                                class="btn btn-action btn-detail">
                                                                <i class="bi bi-eye"></i> Detail
                                                            </a>
                                                            <a href="{{ route('admin.konten.galeri.edit', $galeri) }}"
                                                                class="btn btn-action btn-edit"
                                                                onclick="console.log('Edit clicked for galeri ID:', {{ $galeri->id }}); console.log('URL:', '{{ route('admin.konten.galeri.edit', $galeri) }}');">
                                                                <i class="bi bi-pencil"></i> Edit
                                                            </a>
                                                            <button type="button" class="btn btn-action btn-delete"
                                                                onclick="KontenActions.deleteGaleri('{{ $galeri->id }}', '{{ addslashes($galeri->judul) }}')">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </div>

                                                        {{-- Hidden form for delete --}}
                                                        <form id="delete-galeri-form-{{ $galeri->id }}" method="POST"
                                                            action="{{ route('admin.konten.galeri.destroy', $galeri) }}"
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Pagination --}}
                                    @if (isset($galeris) && method_exists($galeris, 'links'))
                                        <div class="d-flex justify-content-center">
                                            @include('components.custom-pagination', [
                                                'paginator' => $galeris,
                                            ])
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-images fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada galeri</h5>
                                        <p class="text-muted">Tambahkan foto atau video pertama</p>
                                        <a href="{{ route('admin.konten.galeri.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Galeri
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab File Download --}}
                            <div class="tab-pane fade {{ request('tab') == 'download' ? 'show active' : '' }}"
                                id="download" role="tabpanel" aria-labelledby="download-tab">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">File Download</h4>
                                    <a href="{{ route('admin.konten.download.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah File
                                    </a>
                                </div>

                                @if (isset($fileDownloads) && $fileDownloads->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama File</th>
                                                    <th>Kategori</th>
                                                    <th>Ukuran File</th>
                                                    <th>Download</th>
                                                    <th>Tanggal</th>
                                                    <th width="120">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($fileDownloads as $file)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @php
                                                                    $fileExtension = pathinfo(
                                                                        $file->file_name ?? '',
                                                                        PATHINFO_EXTENSION,
                                                                    );
                                                                    $iconClass = match (strtolower($fileExtension)) {
                                                                        'pdf' => 'fas fa-file-pdf text-danger',
                                                                        'doc',
                                                                        'docx'
                                                                            => 'fas fa-file-word text-primary',
                                                                        'xls',
                                                                        'xlsx'
                                                                            => 'fas fa-file-excel text-success',
                                                                        'ppt',
                                                                        'pptx'
                                                                            => 'fas fa-file-powerpoint text-warning',
                                                                        'jpg',
                                                                        'jpeg',
                                                                        'png',
                                                                        'gif'
                                                                            => 'fas fa-file-image text-info',
                                                                        'zip',
                                                                        'rar'
                                                                            => 'fas fa-file-archive text-secondary',
                                                                        default => 'fas fa-file-alt text-primary',
                                                                    };
                                                                @endphp
                                                                <i class="{{ $iconClass }} fa-2x me-3"></i>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $file->nama_file }}</h6>
                                                                    <small class="text-muted">
                                                                        {{ $file->file_name ?? '' }}
                                                                        @if ($file->file_path)
                                                                            <br><a href="{{ $file->file_url }}"
                                                                                target="_blank" class="text-primary">
                                                                                <i
                                                                                    class="fas fa-download me-1"></i>Download
                                                                            </a>
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-success">{{ ucfirst($file->kategori ?? '') }}</span>
                                                        </td>
                                                        <td>{{ $file->file_size_formatted ?? '-' }}</td>
                                                        <td>
                                                            <span
                                                                class="badge bg-info">{{ $file->download_count ?? 0 }}</span>
                                                        </td>
                                                        <td>{{ $file->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            <div class="btn-group-vertical">
                                                                <a href="{{ route('admin.konten.download.show', $file) }}"
                                                                    class="btn btn-action btn-detail" title="Detail">
                                                                    <i class="bi bi-eye"></i> Detail
                                                                </a>
                                                                <a href="{{ route('admin.konten.download.edit', $file) }}"
                                                                    class="btn btn-action btn-edit" title="Edit">
                                                                    <i class="bi bi-pencil"></i> Edit
                                                                </a>
                                                                <button type="button" class="btn btn-action btn-delete"
                                                                    title="Hapus"
                                                                    onclick="KontenActions.deleteFileDownload('{{ $file->id }}', '{{ addslashes($file->nama_file) }}')">
                                                                    <i class="bi bi-trash"></i> Hapus
                                                                </button>
                                                            </div>

                                                            {{-- Hidden form for delete --}}
                                                            <form id="delete-file-form-{{ $file->id }}"
                                                                method="POST"
                                                                action="{{ route('admin.konten.download.destroy', $file) }}"
                                                                style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination --}}
                                    @if (isset($fileDownloads) && method_exists($fileDownloads, 'links'))
                                        <div class="d-flex justify-content-center">
                                            @include('components.custom-pagination', [
                                                'paginator' => $fileDownloads,
                                            ])
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-download fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada file download</h5>
                                        <p class="text-muted">Tambahkan file pertama untuk download</p>
                                        <a href="{{ route('admin.konten.download.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Scripts Section - Terpusat dan Terorganisir --}}
@push('scripts')
    <!-- Load SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        /* ==========================================================================
       KONTEN MANAGEMENT - UNIFIED JAVASCRIPT
       ========================================================================== */

        // GIF Icons Configuration
        const KONTEN_GIF_ICONS = {
            success: '/Icon/Succes.gif',
            delete: '/Icon/Delete.gif',
            loading: '/Icon/loading.gif',
            done: '/Icon/Done.gif'
        };

        // Global Notification Functions
        const KontenNotifications = {
            // Success notification
            showSuccess: function(message) {
                showNotification('Berhasil!', message, 'success', 'bi-check-circle');
            },

            // Loading notification
            showLoading: function(message = 'Memproses...') {
                showNotification('Memproses', message, 'info', 'bi-hourglass-split');
            },

            // Delete confirmation
            confirmDelete: function(message, callback) {
                if (confirm(message + '\n\nApakah Anda yakin ingin melanjutkan?')) {
                    if (typeof callback === 'function') {
                        callback();
                        this.showSuccess('Data berhasil dihapus');
                    }
                }
            },

            // Action confirmation
            confirmAction: function(message, callback) {
                if (confirm(message + '\n\nApakah Anda yakin ingin melanjutkan?')) {
                    if (typeof callback === 'function') {
                        callback();
                        this.showSuccess('Aksi berhasil dilakukan');
                    }
                }
            },

            // Close notification
            close: function() {
                // Universal notification akan auto-close
            }
        };

        // Specific Delete Functions untuk setiap tab
        const KontenActions = {
            // Delete Berita
            deleteBerita: function(id, title) {
                KontenNotifications.confirmDelete(`Yakin ingin menghapus berita "${title}"?`, function() {
                    document.getElementById('delete-berita-form-' + id).submit();
                });
            },

            // Delete Galeri
            deleteGaleri: function(id, title) {
                KontenNotifications.confirmDelete(`Yakin ingin menghapus galeri "${title}"?`, function() {
                    document.getElementById('delete-galeri-form-' + id).submit();
                });
            },

            // Delete File Download
            deleteFileDownload: function(id, fileName) {
                KontenNotifications.confirmDelete(`Yakin ingin menghapus file "${fileName}"?`, function() {
                    document.getElementById('delete-file-form-' + id).submit();
                });
            },

            // Delete Program
            deleteProgram: function(id, title) {
                KontenNotifications.confirmDelete(`Yakin ingin menghapus program "${title}"?`, function() {
                    document.getElementById('delete-program-form-' + id).submit();
                });
            }
        };

        // Global Test Function
        function testGlobalNotifications() {
            console.log('Testing global notifications...');
            KontenNotifications.confirmDelete('Test GIF Delete Alert - Sistem berfungsi dengan baik!', function() {
                KontenNotifications.showSuccess('GIF Notifications berhasil ditest!');
            });
        }

        // Tab Management
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Konten Management loaded successfully');
            console.log('KontenNotifications available:', typeof KontenNotifications);
            console.log('KontenActions available:', typeof KontenActions);

            // Initialize tab handling
            const tabElements = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabElements.forEach(function(element) {
                element.addEventListener('shown.bs.tab', function(e) {
                    const tabId = e.target.getAttribute('data-bs-target').replace('#', '');
                    const url = new URL(window.location);
                    url.searchParams.set('tab', tabId);
                    window.history.pushState({}, '', url);
                });
            });

            // Set active tab from URL
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');
            if (activeTab) {
                const tabElement = document.getElementById(activeTab + '-tab');
                if (tabElement) {
                    tabElement.click();
                }
            }
        });

        // Export to global scope untuk backward compatibility
        window.KontenNotifications = KontenNotifications;
        window.KontenActions = KontenActions;
        window.confirmDelete = KontenNotifications.confirmDelete;
        window.showSuccessNotification = KontenNotifications.showSuccess;
        window.showLoadingNotification = KontenNotifications.showLoading;
    </script>
@endpush
