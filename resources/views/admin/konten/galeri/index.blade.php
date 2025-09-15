@extends('layouts.admin')

@section('title', 'Galeri')

@section('content')
    <style>
        /* Consistent card styling */
        .content-card {
            transition: all 0.3s ease;
            border: 1px solid #e3e6f0;
        }

        .content-card:hover {
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
            border-color: #d1d5db;
        }

        .image-container {
            overflow: hidden;
            border-radius: 0.5rem;
        }

        .image-container img {
            transition: transform 0.3s ease;
        }

        .content-card:hover .image-container img {
            transform: scale(1.02);
        }

        /* Simplified button styling */
        .btn-action {
            padding: 0.375rem 0.75rem;
            margin: 0 0.125rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            min-width: 60px;
            text-align: center;
            border: 1px solid transparent;
        }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-action i {
            margin-right: 0.25rem;
        }

        .btn-group-simple {
            display: inline-flex;
            gap: 0.375rem;
            flex-wrap: wrap;
        }

        /* Custom Notifications CSS for GIF animations */
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

    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Galeri</h1>
                        <p class="text-muted">Kelola foto galeri</p>
                    </div>
                    <div>
                        <button onclick="testGIF()" class="btn btn-warning me-2">Test GIF Alert</button>
                        <a href="{{ route('admin.konten.galeri.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Tambah Item
                        </a>
                    </div>
                </div>

                <!-- Filter dan Search -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.konten.index', ['tab' => 'galeri']) }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Tipe</label>
                                    <select name="tipe" class="form-select">
                                        <option value="">Semua Foto</option>
                                        <option value="foto" {{ request('tipe', 'foto') == 'foto' ? 'selected' : '' }}>
                                            Foto</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($galeris->pluck('kategori')->unique()->filter() as $kategori)
                                            <option value="{{ $kategori }}"
                                                {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                                {{ $kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="non-aktif" {{ request('status') == 'non-aktif' ? 'selected' : '' }}>
                                            Non-aktif</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Search</label>
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari judul..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-outline-secondary">
                                            <i class="bi bi-search"></i>
                                        </button>
                                        @if (request()->hasAny(['tipe', 'kategori', 'status', 'search']))
                                            <a href="{{ route('admin.konten.index', ['tab' => 'galeri']) }}"
                                                class="btn btn-outline-danger">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Grid Galeri -->
                <div class="row">
                    @forelse($galeris as $galeri)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 content-card">
                                <div class="position-relative image-container">
                                    @if ($galeri->tipe == 'foto')
                                        <img src="{{ $galeri->file_url }}" class="card-img-top" alt="{{ $galeri->judul }}"
                                            style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-dark d-flex align-items-center justify-content-center"
                                            style="height: 200px;">
                                            <i class="bi bi-play-circle text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif

                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge bg-{{ $galeri->status == 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($galeri->status) }}
                                        </span>
                                    </div>

                                    <div class="position-absolute top-0 start-0 p-2">
                                        <span class="badge bg-primary">
                                            {{ ucfirst($galeri->tipe) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h6 class="card-title">{{ $galeri->judul }}</h6>
                                    <p class="card-text small text-muted">
                                        {{ Str::limit($galeri->deskripsi, 100) }}
                                    </p>
                                    @if ($galeri->kategori)
                                        <span class="badge bg-info mb-2">{{ $galeri->kategori }}</span>
                                    @endif

                                    <!-- Tombol Detail Utama -->
                                    <div class="mb-2">
                                        <a href="{{ route('admin.konten.galeri.show', $galeri) }}"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-eye me-1"></i>Lihat Detail
                                        </a>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $galeri->created_at->format('d/m/Y') }}</small>
                                        <span class="badge bg-secondary">{{ $galeri->file_size_formatted }}</span>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $galeri->file_size_formatted }}</small>
                                        <div class="btn-group-simple">
                                            <a href="{{ route('admin.konten.galeri.edit', $galeri) }}"
                                                class="btn btn-action btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-action btn-danger"
                                                onclick="deleteItem({{ $galeri->id }}, '{{ $galeri->judul }}')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                                    <h5 class="mt-3">Belum ada item galeri</h5>
                                    <p class="text-muted">Mulai dengan menambahkan foto pertama</p>
                                    <a href="{{ route('admin.konten.galeri.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-lg"></i> Tambah Foto Pertama
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($galeris->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted">
                            {{ $galeris->firstItem() ?? 0 }} - {{ $galeris->lastItem() ?? 0 }} dari
                            {{ $galeris->total() }}
                        </small>
                        <div class="btn-group btn-group-sm">
                            @if (!$galeris->onFirstPage())
                                <a href="{{ $galeris->previousPageUrl() }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            @endif
                            @if ($galeris->hasMorePages())
                                <a href="{{ $galeris->nextPageUrl() }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Load SweetAlert2 and notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // GIF Icons configuration - inline untuk memastikan ter-load
        const GIF_ICONS = {
            success: '/Icon/Succes.gif',
            delete: '/Icon/Delete.gif',
            loading: '/Icon/loading.gif',
            done: '/Icon/Done.gif'
        };

        // Inline confirmDelete function untuk galeri
        function confirmDeleteGaleri(message, callback) {
            Swal.fire({
                title: message,
                imageUrl: GIF_ICONS.delete,
                imageWidth: 100,
                imageHeight: 100,
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'simple-dialog'
                }
            }).then((result) => {
                if (result.isConfirmed && typeof callback === 'function') {
                    callback();
                }
            });
        }

        // Debug - console log untuk memastikan script loaded
        console.log('Galeri page script loading...');
        console.log('Swal available:', typeof Swal);
        console.log('confirmDeleteGaleri defined:', typeof confirmDeleteGaleri);

        // Global deleteItem function dengan GIF langsung
        window.deleteItem = function(id, title) {
            console.log('deleteItem called with:', id, title);

            confirmDeleteGaleri(`Yakin ingin menghapus galeri "${title}"?`, function() {
                console.log('Delete confirmed, submitting form');
                const form = document.getElementById('deleteForm');
                form.action = `{{ route('admin.konten.galeri.index') }}/${id}`;
                form.submit();
            });
        };

        // Test function untuk memastikan GIF berfungsi
        window.testGIF = function() {
            console.log('Testing GIF alert...');
            confirmDeleteGaleri('Test GIF Delete Alert - Klik Ya untuk test!', function() {
                alert('GIF Alert berfungsi dengan baik!');
            });
        };

        console.log('deleteItem function registered with inline GIF');
        console.log('testGIF function registered');
    </script>
@endsection
