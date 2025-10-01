@extends('layouts.admin')

@section('title', 'Manajemen Struktur Organisasi')

@section('content')
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manajemen Struktur Organisasi</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.struktur.peta') }}" class="btn btn-outline-info">
                        <i class="bi bi-diagram-3 me-2"></i>Peta Jabatan
                    </a>
                    <a href="{{ route('admin.struktur.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Struktur
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Filter Form -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Data Struktur Organisasi</h6>
                    </div>
                    <div class="card-body bg-light">
                        <form method="GET" action="{{ route('admin.struktur.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="jabatan" class="form-label fw-semibold">
                                    <i class="bi bi-person-badge me-1"></i>Filter Jabatan
                                </label>
                                <select name="jabatan" id="jabatan" class="form-select border-primary">
                                    <option value="">Semua Jabatan</option>
                                    @foreach ($jabatanList as $jabatan)
                                        <option value="{{ $jabatan }}"
                                            {{ request('jabatan') == $jabatan ? 'selected' : '' }}>
                                            {{ $jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="unit_kerja" class="form-label fw-semibold">
                                    <i class="bi bi-building me-1"></i>Filter Unit Kerja
                                </label>
                                <select name="unit_kerja" id="unit_kerja" class="form-select border-info">
                                    <option value="">Semua Unit Kerja</option>
                                    @foreach ($unitKerjaList as $unitKerja)
                                        <option value="{{ $unitKerja }}"
                                            {{ request('unit_kerja') == $unitKerja ? 'selected' : '' }}>
                                            {{ $unitKerja }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i>Filter Status
                                </label>
                                <select name="status" id="status" class="form-select border-success">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm px-3">
                                        <i class="bi bi-funnel me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.struktur.index') }}"
                                        class="btn btn-outline-secondary btn-sm px-3">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                    </a>
                                    <small class="text-muted align-self-center ms-2">
                                        Filter otomatis saat memilih
                                    </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($strukturs->count() > 0)
                    <!-- Filter Results Info -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted">
                                <i class="bi bi-list-ul me-1"></i>
                                Menampilkan <strong class="text-primary">{{ $strukturs->count() }}</strong> data
                                @if (request()->hasAny(['jabatan', 'unit_kerja', 'status']))
                                    dengan filter:
                                    @if (request('jabatan'))
                                        <span class="badge bg-primary filter-badge ms-1">
                                            <i class="bi bi-person-badge me-1"></i>{{ request('jabatan') }}
                                        </span>
                                    @endif
                                    @if (request('unit_kerja'))
                                        <span class="badge bg-info filter-badge ms-1">
                                            <i class="bi bi-building me-1"></i>{{ request('unit_kerja') }}
                                        </span>
                                    @endif
                                    @if (request('status'))
                                        <span class="badge bg-success filter-badge ms-1">
                                            <i
                                                class="bi bi-check-circle me-1"></i>{{ ucfirst(str_replace('_', ' ', request('status'))) }}
                                        </span>
                                    @endif
                                @endif
                            </small>
                        </div>
                        @if (request()->hasAny(['jabatan', 'unit_kerja', 'status']))
                            <div>
                                <a href="{{ route('admin.struktur.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Hapus Filter
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Urutan</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    <th>Golongan</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($strukturs as $struktur)
                                    <tr>
                                        <td>{{ $struktur->urutan }}</td>
                                        <td>
                                            @if ($struktur->foto)
                                                <img src="{{ asset('storage/' . $struktur->foto) }}"
                                                    alt="Foto {{ $struktur->nama }}" class="img-thumbnail"
                                                    style="max-height: 50px">
                                            @else
                                                <span class="text-muted">No Photo</span>
                                            @endif
                                        </td>
                                        <td>{{ $struktur->nama }}</td>
                                        <td>{{ $struktur->nip ?? '-' }}</td>
                                        <td>{{ $struktur->jabatan }}</td>
                                        <td>{{ $struktur->unit_kerja ?? '-' }}</td>
                                        <td>{{ $struktur->golongan ?? '-' }}</td>
                                        <td>
                                            @if ($struktur->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.struktur.edit', $struktur) }}"
                                                    class="btn btn-sm btn-outline-warning"
                                                    style="border-radius: 6px 0 0 6px;" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.struktur.destroy', $struktur) }}"
                                                    method="POST" class="d-inline delete-form"
                                                    data-message="Apakah Anda yakin ingin menghapus data struktur {{ $struktur->nama }}?">
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

                    <!-- Pagination -->
                    @if ($strukturs->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            @include('components.custom-pagination', ['paginator' => $strukturs])
                        </div>
                    @endif
                @else
                    <div class="alert alert-info">
                        @if (request()->hasAny(['jabatan', 'unit_kerja', 'status']))
                            Tidak ada data struktur organisasi yang sesuai dengan filter yang dipilih.
                            <a href="{{ route('admin.struktur.index') }}" class="alert-link">Reset filter</a> untuk
                            melihat semua data.
                        @else
                            Belum ada data struktur organisasi. Silakan tambahkan data baru.
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .border-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .border-info:focus {
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
        }

        .border-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .filter-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit filter ketika dropdown berubah
            const filterSelects = document.querySelectorAll('#jabatan, #unit_kerja, #status');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    // Tambahkan loading indicator
                    const form = this.closest('form');
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Memfilter...';
                    submitBtn.disabled = true;

                    // Submit form
                    setTimeout(() => {
                        form.submit();
                    }, 200);
                });
            });

            // Konfirmasi delete
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const message = this.dataset.message ||
                        'Apakah Anda yakin ingin menghapus data ini?';

                    if (confirm(message)) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush
