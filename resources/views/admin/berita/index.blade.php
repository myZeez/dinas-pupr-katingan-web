@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')
@section('page-subtitle', 'Kelola semua berita dan publikasi dinas')

@section('content')

    <!-- Stats Summary -->
    <div class="row g-4 mb-4 fade-in-up">
        <div class="col-xl-3 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle icon-primary me-3">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Total Berita</p>
                            <h3 class="mb-0 fw-bold">{{ $beritas->total() }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-files text-info me-1"></i>Publikasi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle icon-success me-3">
                            <i class="bi bi-eye"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Dilihat Hari Ini</p>
                            <h3 class="mb-0 fw-bold">{{ rand(50, 200) }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-arrow-up text-success me-1"></i>Views
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle icon-warning me-3">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Bulan Ini</p>
                            <h3 class="mb-0 fw-bold">
                                {{ $beritas->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-plus-circle text-warning me-1"></i>Baru
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle icon-info me-3">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Rata-rata/Bulan</p>
                            <h3 class="mb-0 fw-bold">
                                {{ round($beritas->total() / max(1, now()->diffInMonths($beritas->first()->created_at ?? now()) + 1)) }}
                            </h3>
                            <small class="text-muted">
                                <i class="bi bi-bar-chart text-info me-1"></i>Berita
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow-sm fade-in-up">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-circle icon-primary me-3">
                        <i class="bi bi-list-ul"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">Daftar Berita</h5>
                        <small class="text-muted">Kelola dan pantau semua berita publikasi</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.konten.berita.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Berita
                    </a>
                    <button type="button" class="btn btn-success" data-action="export" data-format="Excel"
                        title="Export ke Excel">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export
                    </button>
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light" placeholder="Cari berita..."
                            data-search style="border-radius: 0 8px 8px 0;">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($beritas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="60">#</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="80">Thumbnail</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted">Judul & Konten</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="120">Author</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="120">Tanggal Publikasi</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="100">Status</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beritas as $berita)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge bg-light text-dark">{{ $loop->iteration + ($beritas->currentPage() - 1) * $beritas->perPage() }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($berita->thumbnail)
                                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="Thumbnail"
                                                class="rounded"
                                                style="width: 50px; height: 35px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                style="width: 50px; height: 35px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ Str::limit($berita->judul, 60) }}</h6>
                                            <p class="text-muted mb-0 small">
                                                {{ Str::limit(strip_tags($berita->konten), 80) }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 30px; height: 30px;">
                                                <i class="bi bi-person text-white" style="font-size: 12px;"></i>
                                            </div>
                                            <span class="text-muted small">{{ $berita->author ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($berita->tanggal_publikasi)
                                            <span
                                                class="badge bg-success text-white">{{ $berita->tanggal_publikasi->format('d M Y') }}</span>
                                        @elseif($berita->status === 'publish')
                                            <span
                                                class="badge bg-info text-white">{{ $berita->created_at->format('d M Y') }}</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Dipublikasi</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($berita->status === 'publish')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Publish
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock me-1"></i>Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.konten.berita.show', $berita) }}"
                                                class="btn btn-sm btn-outline-info" style="border-radius: 6px 0 0 6px;"
                                                title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.konten.berita.edit', $berita) }}"
                                                class="btn btn-sm btn-outline-warning" style="border-radius: 0;"
                                                title="Edit" data-quick-edit>
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.konten.berita.destroy', $berita) }}"
                                                method="POST" class="d-inline delete-form"
                                                data-message="Apakah Anda yakin ingin menghapus berita '{{ $berita->judul }}'?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    style="border-radius: 0 6px 6px 0;" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5" style="padding: 80px 20px;">
                    <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-newspaper text-muted" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="text-muted mb-2 fw-semibold">Belum ada berita</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan berita pertama untuk dinas Anda</p>
                    <a href="{{ route('admin.konten.berita.create') }}" class="btn btn-primary shadow-sm"
                        style="border-radius: 12px; padding: 12px 24px; font-weight: 500;">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Berita Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($beritas->hasPages())
            <div class="card-footer bg-white border-0 p-4" style="border-radius: 0 0 20px 20px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $beritas->firstItem() }} - {{ $beritas->lastItem() }} dari {{ $beritas->total() }}
                        berita
                    </div>
                    <div>
                        @include('components.custom-pagination', ['paginator' => $beritas])
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 140, 0.02);
        }

        .btn-group .btn {
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .btn-group .btn:hover {
            z-index: 2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .pagination .page-link {
            border: none;
            color: #6c757d;
            padding: 8px 12px;
            margin: 0 2px;
            border-radius: 8px;
        }

        .pagination .page-item.active .page-link {
            background-color: #00008C;
            border-color: #00008C;
            border-radius: 8px;
        }

        .pagination .page-link:hover {
            color: #00008C;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .input-group .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            font-weight: 500;
        }
    </style>
@endpush
