@extends('layouts.admin')

@section('title', 'Detail Program')

@push('styles')
    @include('admin.partials.show-styles')
    <style>
        .admin-show-progress-bar {
            width: 100%;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 15px 0;
        }

        .admin-show-progress-fill {
            height: 100%;
            transition: width 0.3s ease;
            border-radius: 10px;
        }

        .admin-show-timeline {
            margin-top: 20px;
        }

        .admin-show-timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-left: 35px;
            position: relative;
        }

        .admin-show-timeline-item::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 25px;
            width: 2px;
            height: calc(100% + 10px);
            background: #e3e6f0;
        }

        .admin-show-timeline-item:last-child::before {
            display: none;
        }

        .admin-show-timeline-icon {
            position: absolute;
            left: 8px;
            top: 8px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="admin-show-container">
        <!-- Header -->
        <div class="admin-show-header">
            <div>
                <h1 class="admin-show-title">Detail Program</h1>
                <nav>
                    <ol class="admin-show-breadcrumb">
                        <li><a href="{{ route('admin.konten.program.index') }}">Program</a></li>
                        <li>Detail Program</li>
                    </ol>
                </nav>
            </div>
            <div class="admin-show-btn-group">
                <a href="{{ route('admin.konten.program.edit', $program) }}" class="admin-show-btn admin-show-btn-warning">
                    ✏️ Edit Program
                </a>
                <a href="{{ route('admin.konten.program.index') }}" class="admin-show-btn admin-show-btn-secondary">
                    ← Kembali
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-show-card">
            <div class="admin-show-card-header">
                <h6>🏗️ {{ $program->nama_program }}</h6>
                <div class="admin-show-btn-group">
                    <span
                        class="admin-show-badge {{ $program->status === 'Selesai'
                            ? 'admin-show-badge-success'
                            : ($program->status === 'Berjalan'
                                ? 'admin-show-badge-primary'
                                : ($program->status === 'Ditunda'
                                    ? 'admin-show-badge-warning'
                                    : 'admin-show-badge-secondary')) }}">
                        {{ $program->status }}
                    </span>
                    @if ($program->isOverdue())
                        <span class="admin-show-badge admin-show-badge-danger">Terlambat</span>
                    @endif
                    <button type="button" class="admin-show-btn admin-show-btn-primary" onclick="openStatusModal()">
                        🔄 Update Status
                    </button>
                </div>
            </div>
            <div class="admin-show-card-body">
                <div class="admin-show-layout">
                    <!-- Content Section -->
                    <div class="admin-show-content">
                        <!-- Progress Bar -->
                        @if ($program->tanggal_mulai && $program->tanggal_selesai)
                            <div style="margin-bottom: 25px;">
                                <div
                                    class="admin-show-d-flex admin-show-justify-between admin-show-align-center admin-show-mb-2">
                                    <span style="font-weight: 600;">Progress Program</span>
                                    <span
                                        style="font-weight: 600; color: #007bff;">{{ $program->getProgressPercentage() }}%</span>
                                </div>
                                <div class="admin-show-progress-bar">
                                    <div class="admin-show-progress-fill"
                                        style="width: {{ $program->getProgressPercentage() }}%;
                                            background: {{ $program->status === 'Selesai'
                                                ? 'linear-gradient(135deg, #28a745 0%, #20c997 100%)'
                                                : ($program->isOverdue()
                                                    ? 'linear-gradient(135deg, #dc3545 0%, #e74c3c 100%)'
                                                    : ($program->status === 'Berjalan'
                                                        ? 'linear-gradient(135deg, #007bff 0%, #0056b3 100%)'
                                                        : 'linear-gradient(135deg, #ffc107 0%, #e0a800 100%)')) }};">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="admin-show-d-flex admin-show-align-center admin-show-text-muted admin-show-mb-3">
                            <span>📅 {{ $program->tanggal_mulai ? $program->tanggal_mulai->format('d F Y') : '-' }} -
                                {{ $program->tanggal_selesai ? $program->tanggal_selesai->format('d F Y') : '-' }}</span>
                            <span style="margin: 0 10px;">📍</span>
                            <span>{{ $program->lokasi }}</span>
                        </div>

                        <div class="admin-show-content">
                            <h5>Deskripsi Program</h5>
                            {!! $program->deskripsi !!}
                        </div>

                        <!-- Status History Timeline -->
                        @if ($program->statusHistories && $program->statusHistories->count() > 0)
                            <div style="margin-top: 30px;">
                                <h5>📈 Riwayat Perubahan Status</h5>
                                <div class="admin-show-timeline">
                                    @foreach ($program->statusHistories as $history)
                                        <div class="admin-show-timeline-item">
                                            <div
                                                class="admin-show-timeline-icon admin-show-badge-{{ $history->status_baru === 'Selesai'
                                                    ? 'success'
                                                    : ($history->status_baru === 'Berjalan'
                                                        ? 'primary'
                                                        : ($history->status_baru === 'Ditunda'
                                                            ? 'warning'
                                                            : 'secondary')) }}">
                                                {{ $history->status_baru === 'Selesai'
                                                    ? '✓'
                                                    : ($history->status_baru === 'Berjalan'
                                                        ? '▶'
                                                        : ($history->status_baru === 'Ditunda'
                                                            ? '⏸'
                                                            : '●')) }}
                                            </div>
                                            <div style="flex-grow: 1;">
                                                <div
                                                    class="admin-show-d-flex admin-show-justify-between admin-show-align-center">
                                                    <h6 style="margin: 0; font-size: 14px; font-weight: 600;">
                                                        @if ($history->status_lama)
                                                            {{ $history->status_lama }} → {{ $history->status_baru }}
                                                        @else
                                                            Status awal: {{ $history->status_baru }}
                                                        @endif
                                                    </h6>
                                                    <small
                                                        class="admin-show-text-muted">{{ $history->tanggal_perubahan->format('d M Y H:i') }}</small>
                                                </div>
                                                <p style="margin: 5px 0 0 0; font-size: 13px; color: #666;">
                                                    {{ $history->keterangan }}</p>
                                                <small style="color: #999;">
                                                    {{ $history->trigger_type === 'manual'
                                                        ? '👤 Manual'
                                                        : ($history->trigger_type === 'auto_date'
                                                            ? '📅 Otomatis (tanggal)'
                                                            : '🤖 Sistem') }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Info Panel -->
                    <div class="admin-show-info-panel">
                        <div class="admin-show-info-header">
                            <h6>ℹ️ Informasi Program</h6>
                        </div>
                        <table class="admin-show-info-table">
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span
                                        class="admin-show-badge {{ $program->status === 'Selesai'
                                            ? 'admin-show-badge-success'
                                            : ($program->status === 'Berjalan'
                                                ? 'admin-show-badge-primary'
                                                : ($program->status === 'Ditunda'
                                                    ? 'admin-show-badge-warning'
                                                    : 'admin-show-badge-secondary')) }}">
                                        {{ $program->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Lokasi:</th>
                                <td>{{ $program->lokasi }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai:</th>
                                <td>{{ $program->tanggal_mulai ? $program->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai:</th>
                                <td>{{ $program->tanggal_selesai ? $program->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Durasi:</th>
                                <td>{{ $program->tanggal_mulai && $program->tanggal_selesai ? $program->tanggal_mulai->diffInDays($program->tanggal_selesai) . ' hari' : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Progress:</th>
                                <td>{{ $program->getProgressPercentage() }}%</td>
                            </tr>
                            <tr>
                                <th>Dibuat:</th>
                                <td>{{ $program->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diperbarui:</th>
                                <td>{{ $program->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>

                        <div class="admin-show-actions">
                            <button type="button" class="admin-show-btn admin-show-btn-primary"
                                onclick="openStatusModal()">
                                🔄 Update Status
                            </button>
                            <a href="{{ route('admin.konten.program.edit', $program) }}"
                                class="admin-show-btn admin-show-btn-warning">
                                ✏️ Edit Program
                            </a>
                            <a href="{{ route('admin.konten.program.index') }}"
                                class="admin-show-btn admin-show-btn-secondary">
                                📋 Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="admin-show-modal">
        <div class="admin-show-modal-content">
            <h4>Update Status Program</h4>
            <form id="statusForm">
                @csrf
                <div style="margin: 20px 0;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Status Baru</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="Perencanaan" {{ $program->status === 'Perencanaan' ? 'selected' : '' }}>Perencanaan
                        </option>
                        <option value="Berjalan" {{ $program->status === 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="Selesai" {{ $program->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Ditunda" {{ $program->status === 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                        <option value="Dibatalkan" {{ $program->status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>
                <div style="margin: 20px 0;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                        placeholder="Alasan perubahan status..."></textarea>
                </div>
                <div class="admin-show-btn-group">
                    <button type="submit" class="admin-show-btn admin-show-btn-primary">Update Status</button>
                    <button type="button" class="admin-show-btn admin-show-btn-secondary"
                        onclick="closeStatusModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStatusModal() {
            document.getElementById('statusModal').classList.add('show');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.remove('show');
        }

        // Handle status form submission
        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;

            fetch('{{ route('admin.konten.program.update-status', $program) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat update status');
                })
                .finally(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const statusModal = document.getElementById('statusModal');

            if (event.target === statusModal) {
                closeStatusModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeStatusModal();
            }
        });
    </script>
@endsection
</p>
<p><strong>Lokasi:</strong> {{ $program->lokasi }}</p>
</div>
<div class="col-md-6">
    <p><strong>Tanggal Mulai:</strong>
        {{ $program->tanggal_mulai ? $program->tanggal_mulai->format('d F Y') : '-' }}</p>
    <p><strong>Tanggal Selesai:</strong>
        {{ $program->tanggal_selesai ? $program->tanggal_selesai->format('d F Y') : '-' }}</p>
</div>
</div>

<h6>Deskripsi Program:</h6>
<div class="bg-light p-4 rounded">
    <div class="content">
        {!! $program->deskripsi !!}
    </div>
</div>
</div>
</div>

<!-- Riwayat Perubahan Status -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="fas fa-history me-2"></i>
            Riwayat Perubahan Status
        </h6>
    </div>
    <div class="card-body">
        @if ($program->statusHistories->count() > 0)
            <div class="timeline">
                @foreach ($program->statusHistories as $history)
                    <div class="timeline-item mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div
                                    class="badge {{ $history->getStatusBadgeClass($history->status_baru) }} rounded-circle p-2">
                                    <i
                                        class="fas fa-
                                            @if ($history->status_baru === 'Selesai') check
                                            @elseif($history->status_baru === 'Berjalan') play
                                            @elseif($history->status_baru === 'Perencanaan') clock
                                            @elseif($history->status_baru === 'Ditunda') pause
                                            @else times @endif
                                        "></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">
                                        @if ($history->status_lama)
                                            {{ $history->status_lama }} → {{ $history->status_baru }}
                                        @else
                                            Status awal: {{ $history->status_baru }}
                                        @endif
                                    </h6>
                                    <small
                                        class="text-muted">{{ $history->tanggal_perubahan->format('d M Y H:i') }}</small>
                                </div>
                                <p class="mb-1 text-muted">{{ $history->keterangan }}</p>
                                <small class="text-muted">
                                    <i
                                        class="fas fa-
                                            @if ($history->trigger_type === 'manual') user
                                            @elseif($history->trigger_type === 'auto_date') calendar
                                            @else robot @endif me-1"></i>
                                    {{ $history->getTriggerDescription() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-history text-muted fa-3x mb-3"></i>
                <p class="text-muted">Belum ada riwayat perubahan status</p>
            </div>
        @endif
    </div>
</div>
</div>

<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="fas fa-tools me-2"></i>
                Aksi
            </h6>
        </div>
        <div class="card-body">
            <div class="d-grid gap-2">
                <a href="{{ route('admin.konten.program.edit', $program) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit Program
                </a>

                <!-- Tombol Update Status Manual -->
                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                    data-bs-target="#updateStatusModal">
                    <i class="fas fa-sync me-1"></i>Update Status
                </button>

                <a href="{{ route('admin.konten.program.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                </a>
                <form action="{{ route('admin.konten.program.destroy', $program) }}" method="POST"
                    class="d-inline delete-form"
                    data-message="Apakah Anda yakin ingin menghapus program {{ $program->nama_program }}?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-1"></i>
                        Hapus Program
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Informasi
            </h6>
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <td><strong>Dibuat:</strong></td>
                    <td>{{ $program->created_at ? $program->created_at->format('d M Y, H:i') : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Diperbarui:</strong></td>
                    <td>{{ $program->updated_at ? $program->updated_at->format('d M Y, H:i') : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Durasi:</strong></td>
                    <td>{{ $program->tanggal_mulai && $program->tanggal_selesai ? $program->tanggal_mulai->diffInDays($program->tanggal_selesai) . ' hari' : '-' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Status Otomatis:</strong></td>
                    <td>
                        @php $autoStatus = $program->determineStatusByDate(); @endphp
                        @if ($program->status !== $autoStatus)
                            <span class="text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Seharusnya: {{ $autoStatus }}
                            </span>
                        @else
                            <span class="text-success">
                                <i class="fas fa-check me-1"></i>
                                Sesuai tanggal
                            </span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Status Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Baru</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Perencanaan" {{ $program->status === 'Perencanaan' ? 'selected' : '' }}>
                                Perencanaan</option>
                            <option value="Berjalan" {{ $program->status === 'Berjalan' ? 'selected' : '' }}>Berjalan
                            </option>
                            <option value="Selesai" {{ $program->status === 'Selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="Ditunda" {{ $program->status === 'Ditunda' ? 'selected' : '' }}>Ditunda
                            </option>
                            <option value="Dibatalkan" {{ $program->status === 'Dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                            placeholder="Alasan perubahan status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .timeline-item {
        position: relative;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 40px;
        width: 2px;
        height: calc(100% + 20px);
        background-color: #dee2e6;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateStatusForm = document.getElementById('updateStatusForm');

        updateStatusForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;

            fetch('{{ route('admin.konten.program.update-status', $program) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload halaman untuk menampilkan perubahan
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat update status');
                })
                .finally(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });
    });
</script>
@endsection
