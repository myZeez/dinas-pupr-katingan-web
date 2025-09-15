@extends('layouts.admin')

@section('title', 'Kelola Program')
@section('page-title', 'Kelola Program')
@section('page-subtitle', 'Kelola program kerja dan kegiatan dinas')

@section('content')
    <!-- Stats Summary -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 h-100"
                style="border-radius: 20px; background: #FFF; box-shadow: 2px 4px 24px -3px rgba(0, 0, 0, 0.20);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-clipboard-check text-white fs-5"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Total Program</p>
                            <h3 class="mb-0 fw-bold">{{ $programs->total() }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-list-ul text-success me-1"></i>Program
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 h-100"
                style="border-radius: 20px; background: #FFF; box-shadow: 2px 4px 24px -3px rgba(0, 0, 0, 0.20);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-play-circle text-white fs-5"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Program Berjalan</p>
                            <h3 class="mb-0 fw-bold">{{ $programs->where('status', 'Berjalan')->count() }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-arrow-right text-primary me-1"></i>Aktif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 h-100"
                style="border-radius: 20px; background: #FFF; box-shadow: 2px 4px 24px -3px rgba(0, 0, 0, 0.20);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-check-circle text-white fs-5"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Program Selesai</p>
                            <h3 class="mb-0 fw-bold">{{ $programs->where('status', 'Selesai')->count() }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-check text-info me-1"></i>Selesai
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card border-0 h-100"
                style="border-radius: 20px; background: #FFF; box-shadow: 2px 4px 24px -3px rgba(0, 0, 0, 0.20);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-clock text-white fs-5"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 fw-medium">Program Tunda</p>
                            <h3 class="mb-0 fw-bold">{{ $programs->where('status', 'Ditunda')->count() }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-pause text-warning me-1"></i>Pending
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0"
        style="border-radius: 20px; background: #FFF; box-shadow: 2px 4px 24px -3px rgba(0, 0, 0, 0.20);">
        <div class="card-header bg-white border-0 p-4" style="border-radius: 20px 20px 0 0;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-list-check text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Daftar Program</h5>
                        <small class="text-muted">Kelola dan pantau semua program kerja</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.konten.program.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Program
                    </a>
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light" placeholder="Cari program..."
                            style="border-radius: 0 8px 8px 0;">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($programs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="60">#</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted">Nama Program</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="120">Lokasi</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted text-center" width="100">Status</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted" width="140">Periode</th>
                                <th class="border-0 px-4 py-3 fw-semibold text-muted text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $program)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge bg-light text-dark">{{ $loop->iteration + ($programs->currentPage() - 1) * $programs->perPage() }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ Str::limit($program->nama_program, 50) }}</h6>
                                            <p class="text-muted mb-0 small">
                                                {{ Str::limit(html_entity_decode(strip_tags($program->deskripsi), ENT_QUOTES, 'UTF-8'), 80) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark">{{ Str::limit($program->lokasi, 20) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($program->status == 'Berjalan')
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25"
                                                style="padding: 6px 12px; font-weight: 500;">{{ $program->status }}</span>
                                        @elseif($program->status == 'Selesai')
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"
                                                style="padding: 6px 12px; font-weight: 500;">{{ $program->status }}</span>
                                        @else
                                            <span
                                                class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25"
                                                style="padding: 6px 12px; font-weight: 500;">{{ $program->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-calendar-event me-1"></i>{{ $program->tanggal_mulai ? $program->tanggal_mulai->format('d M Y') : '-' }}
                                            </small>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-calendar-check me-1"></i>{{ $program->tanggal_selesai ? $program->tanggal_selesai->format('d M Y') : '-' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.konten.program.show', $program) }}"
                                                class="btn btn-sm btn-outline-info" style="border-radius: 6px 0 0 6px;"
                                                title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.konten.program.edit', $program) }}"
                                                class="btn btn-sm btn-outline-warning" style="border-radius: 0;"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.konten.program.destroy', $program) }}"
                                                method="POST" class="d-inline delete-form"
                                                data-message="Apakah Anda yakin ingin menghapus program {{ $program->nama_program }}?">
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
                        <i class="bi bi-clipboard-check text-muted" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="text-muted mb-2 fw-semibold">Belum ada program</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan program kerja pertama untuk dinas</p>
                    <a href="{{ route('admin.konten.program.create') }}" class="btn btn-success shadow-sm"
                        style="border-radius: 12px; padding: 12px 24px; font-weight: 500;">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Program Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($programs->hasPages())
            <div class="card-footer bg-white border-0 p-4" style="border-radius: 0 0 20px 20px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $programs->firstItem() }} - {{ $programs->lastItem() }} dari
                        {{ $programs->total() }} program
                    </div>
                    <div>
                        @include('components.custom-pagination', ['paginator' => $programs])
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 212, 170, 0.02);
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
            background-color: #00d4aa;
            border-color: #00d4aa;
            border-radius: 8px;
        }

        .pagination .page-link:hover {
            color: #00d4aa;
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
