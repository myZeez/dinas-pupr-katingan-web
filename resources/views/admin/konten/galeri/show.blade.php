@extends('layouts.admin')

@section('title', 'Detail Galeri')

@push('styles')
    <style>
        .detail-image {
            cursor: pointer;
            transition: transform 0.3s ease;
            border-radius: 0.5rem;
        }

        .detail-image:hover {
            transform: scale(1.02);
        }

        /* Simplified button styling consistent with other pages */
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

        /* Additional button styles */
        .btn-action.btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-action.btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
            color: white;
        }

        .info-card {
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 0.5rem;
        }

        .info-table th {
            background: #f1f3f4;
            font-weight: 600;
            border: none;
            padding: 0.75rem;
        }

        .info-table td {
            border: none;
            padding: 0.75rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Detail Galeri</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.konten.index') }}">Konten</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Detail Galeri</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-group-simple">
                        <a href="{{ route('admin.konten.galeri.edit', $galeri) }}" class="btn btn-action btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit Galeri
                        </a>
                        <a href="{{ route('admin.konten.index', ['tab' => 'galeri']) }}"
                            class="btn btn-action btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-images me-2"></i>{{ $galeri->judul }}</h6>
                        <div class="btn-group-simple">
                            <a href="{{ route('admin.konten.galeri.edit', $galeri) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                @if ($galeri->file_path)
                                    <div class="text-center mb-4">
                                        <img src="{{ Storage::url($galeri->file_path) }}" alt="{{ $galeri->judul }}"
                                            class="img-fluid rounded shadow detail-image" style="max-height: 500px;"
                                            data-bs-toggle="modal" data-bs-target="#imageModal">
                                    </div>
                                @endif

                                @if ($galeri->deskripsi)
                                    <div class="mb-3">
                                        <h5>Deskripsi</h5>
                                        <p class="text-muted">{{ $galeri->deskripsi }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="info-card">
                                    <div class="card-header bg-light border-bottom">
                                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Media</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table info-table mb-0">
                                            <tr>
                                                <th width="40%">Tipe:</th>
                                                <td>
                                                    <span class="badge bg-primary">{{ ucfirst($galeri->tipe) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Kategori:</th>
                                                <td>{{ $galeri->kategori ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>
                                                    <span
                                                        class="badge {{ $galeri->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($galeri->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Urutan:</th>
                                                <td>{{ $galeri->urutan }}</td>
                                            </tr>
                                            @if ($galeri->file_name)
                                                <tr>
                                                    <td><strong>Nama File:</strong></td>
                                                    <td><small>{{ $galeri->file_name }}</small></td>
                                                </tr>
                                            @endif
                                            @if ($galeri->file_size)
                                                <tr>
                                                    <td><strong>Ukuran:</strong></td>
                                                    <td>{{ $galeri->file_size_formatted }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td><strong>Ditambahkan:</strong></td>
                                                <td><small>{{ $galeri->created_at->format('d/m/Y H:i') }}</small></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Diperbarui:</strong></td>
                                                <td><small>{{ $galeri->updated_at->format('d/m/Y H:i') }}</small></td>
                                            </tr>
                                            @if ($galeri->user)
                                                <tr>
                                                    <td><strong>Dibuat oleh:</strong></td>
                                                    <td><small>{{ $galeri->user->name }}</small></td>
                                                </tr>
                                            @endif
                                        </table>

                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2 mt-3">
                                            <a href="{{ route('admin.konten.galeri.edit', $galeri) }}"
                                                class="btn btn-warning action-btn">
                                                <i class="fas fa-edit me-2"></i>Edit Item
                                            </a>
                                            @if ($galeri->file_path)
                                                <a href="{{ Storage::url($galeri->file_path) }}" target="_blank"
                                                    class="btn btn-info action-btn">
                                                    <i class="fas fa-download me-2"></i>Download File
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-danger action-btn" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fas fa-trash me-2"></i>Hapus Item
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview Gambar -->
    @if ($galeri->tipe === 'foto' && $galeri->file_path)
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">{{ $galeri->judul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ Storage::url($galeri->file_path) }}" alt="{{ $galeri->judul }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x me-3"></i>
                        <div>
                            <h6 class="mb-1">Yakin ingin menghapus item galeri ini?</h6>
                            <p class="mb-0 text-muted">{{ $galeri->judul }}</p>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <small><i class="fas fa-info-circle me-1"></i>Tindakan ini tidak dapat dibatalkan. File akan
                            dihapus permanen dari server.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <form action="{{ route('admin.konten.galeri.destroy', $galeri) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
