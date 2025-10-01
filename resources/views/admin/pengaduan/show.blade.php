@extends('layouts.admin')

@section('title', 'Detail Pengaduan')

@push('styles')
    @include('admin.partials.show-styles')
    <style>
        .admin-show-pengaduan-content {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }

        .admin-show-contact-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .admin-show-contact-link:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <div class="admin-show-container">
        <!-- Header -->
        <div class="admin-show-header">
            <div>
                <h1 class="admin-show-title">Detail Pengaduan</h1>
                <nav>
                    <ol class="admin-show-breadcrumb">
                        <li><a href="{{ route('admin.pengaduan.index') }}">Pengaduan</a></li>
                        <li>Detail Pengaduan</li>
                    </ol>
                </nav>
            </div>
            <div class="admin-show-btn-group">
                <a href="{{ route('admin.pengaduan.index') }}" class="admin-show-btn admin-show-btn-secondary">
                    ← Kembali
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-show-card">
            <div class="admin-show-card-header">
                <h6>📝 {{ $pengaduan->kategori }}</h6>
                <div class="admin-show-btn-group">
                    <span
                        class="admin-show-badge
                    @if ($pengaduan->status === 'pending') admin-show-badge-warning
                    @elseif($pengaduan->status === 'proses') admin-show-badge-primary
                    @elseif($pengaduan->status === 'selesai') admin-show-badge-success
                    @else admin-show-badge-secondary @endif">
                        {{ ucfirst($pengaduan->status) }}
                    </span>
                </div>
            </div>
            <div class="admin-show-card-body">
                <div class="admin-show-layout">
                    <!-- Content Section -->
                    <div class="admin-show-content">
                        <div class="admin-show-d-flex admin-show-align-center admin-show-text-muted admin-show-mb-3">
                            <span>📅 {{ $pengaduan->tanggal_pengaduan->format('d F Y, H:i') }} WIB</span>
                        </div>

                        <div class="admin-show-pengaduan-content">
                            <h5 style="margin-bottom: 15px;">Isi Pengaduan</h5>
                            <p style="margin: 0; line-height: 1.6; color: #333;">{{ $pengaduan->isi_pengaduan }}</p>
                        </div>

                        @if ($pengaduan->file_pendukung)
                            <div style="margin-top: 25px;">
                                <h5>File Pendukung</h5>
                                <div style="text-align: center; margin: 15px 0;">
                                    <img src="{{ asset('storage/' . $pengaduan->file_pendukung) }}" alt="File Pendukung"
                                        class="admin-show-image" onclick="openImageModal()">
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Info Panel -->
                    <div class="admin-show-info-panel">
                        <div class="admin-show-info-header">
                            <h6>👤 Informasi Pelapor</h6>
                        </div>
                        <table class="admin-show-info-table">
                            <tr>
                                <th>Nama:</th>
                                <td>{{ $pengaduan->nama }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <a href="mailto:{{ $pengaduan->email }}?subject=Re: {{ $pengaduan->kategori }}"
                                        class="admin-show-contact-link">
                                        {{ $pengaduan->email }}
                                    </a>
                                </td>
                            </tr>
                            @if ($pengaduan->telepon)
                                <tr>
                                    <th>Telepon:</th>
                                    <td>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaduan->telepon) }}?text=Halo,%20saya%20dari%20Dinas%20PUPR%20Katingan%20terkait%20pengaduan%20Anda:%20{{ urlencode($pengaduan->kategori) }}"
                                            target="_blank" class="admin-show-contact-link">
                                            {{ $pengaduan->telepon }}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>Kategori:</th>
                                <td>{{ $pengaduan->kategori }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span
                                        class="admin-show-badge
                                    @if ($pengaduan->status === 'pending') admin-show-badge-warning
                                    @elseif($pengaduan->status === 'proses') admin-show-badge-primary
                                    @elseif($pengaduan->status === 'selesai') admin-show-badge-success
                                    @else admin-show-badge-secondary @endif">
                                        {{ ucfirst($pengaduan->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Diterima:</th>
                                <td>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diperbarui:</th>
                                <td>{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>

                        <div class="admin-show-actions">
                            <a href="mailto:{{ $pengaduan->email }}?subject=Re: {{ $pengaduan->kategori }}"
                                class="admin-show-btn admin-show-btn-primary">
                                ✉️ Balas Email
                            </a>
                            @if ($pengaduan->telepon)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaduan->telepon) }}?text=Halo,%20saya%20dari%20Dinas%20PUPR%20Katingan%20terkait%20pengaduan%20Anda:%20{{ urlencode($pengaduan->kategori) }}"
                                    target="_blank" class="admin-show-btn admin-show-btn-success">
                                    💬 WhatsApp
                                </a>
                            @endif
                            <a href="{{ route('admin.pengaduan.index') }}" class="admin-show-btn admin-show-btn-secondary">
                                📋 Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    @if ($pengaduan->file_pendukung)
        <div id="imageModal" class="admin-show-modal">
            <span class="admin-show-modal-close" onclick="closeImageModal()">&times;</span>
            <img class="admin-show-modal-image" src="{{ asset('storage/' . $pengaduan->file_pendukung) }}"
                alt="File Pendukung">
        </div>
    @endif

    <script>
        function openImageModal() {
            document.getElementById('imageModal').classList.add('show');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.remove('show');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const imageModal = document.getElementById('imageModal');

            if (event.target === imageModal) {
                closeImageModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection
<div class="col-sm-9">
    <span class="badge {{ $pengaduan->status_badge }} badge-lg">{{ $pengaduan->status }}</span>
</div>
</div>

<hr>

<div class="row">
    <div class="col-sm-3">
        <strong>Pesan:</strong>
    </div>
    <div class="col-sm-9">
        <div class="bg-light p-3 rounded">
            {!! nl2br(e($pengaduan->pesan)) !!}
        </div>
    </div>
</div>
</div>
</div>
</div>

<!-- Sidebar Actions -->
<div class="col-lg-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Update Status -->
            <div class="mb-4">
                <h6 class="fw-bold">Ubah Status</h6>
                <div class="btn-group-vertical d-grid gap-2">
                    @foreach (['Baru', 'Diproses', 'Selesai', 'Ditolak'] as $status)
                        <form method="POST" action="{{ route('admin.pengaduan.updateStatus', $pengaduan) }}"
                            class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $status }}">
                            <button type="submit"
                                class="btn btn-outline-{{ $status == 'Selesai' ? 'success' : ($status == 'Ditolak' ? 'danger' : ($status == 'Diproses' ? 'warning' : 'primary')) }} {{ $pengaduan->status == $status ? 'active' : '' }}"
                                {{ $pengaduan->status == $status ? 'disabled' : '' }}>
                                @if ($status == 'Baru')
                                    <i class="fas fa-star"></i>
                                @elseif($status == 'Diproses')
                                    <i class="fas fa-clock"></i>
                                @elseif($status == 'Selesai')
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ $status }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>

            <hr>

            <!-- Contact Actions -->
            <div class="mb-4">
                <h6 class="fw-bold">Kontak</h6>
                <div class="d-grid gap-2">
                    <button onclick="openGmail('{{ $pengaduan->email }}', 'Re: {{ $pengaduan->kategori }}')"
                        class="btn btn-outline-primary">
                        <i class="fab fa-google"></i> Balas Email
                    </button>
                    @if ($pengaduan->telepon)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaduan->telepon) }}?text=Halo,%20saya%20dari%20Dinas%20PUPR%20Katingan%20terkait%20pengaduan%20Anda:%20{{ urlencode($pengaduan->kategori) }}"
                            target="_blank" class="btn btn-outline-success">
                            <i class="fab fa-whatsapp"></i> Chat WhatsApp
                        </a>
                    @endif
                </div>
            </div>

            <hr>

            <!-- Delete Action -->
            <div class="mb-2">
                <h6 class="fw-bold text-danger">Zona Bahaya</h6>
                <form method="POST" action="{{ route('admin.pengaduan.destroy', $pengaduan) }}" class="delete-form"
                    data-message="Apakah Anda yakin ingin menghapus pengaduan dari {{ $pengaduan->nama }}?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <img src="{{ asset('icon/Delete.gif') }}" alt="Delete"
                            style="width: 20px; height: 20px; margin-right: 5px;">
                        Hapus Pengaduan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Timeline/Info -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history me-2"></i>Timeline Pengaduan
            </h6>
        </div>
        <div class="card-body">
            @if ($pengaduan->histories && $pengaduan->histories->count() > 0)
                <div class="timeline">
                    @foreach ($pengaduan->histories as $history)
                        <div class="timeline-item">
                            <div
                                class="timeline-marker {{ $history->action == 'Dibuat' ? 'bg-primary' : ($history->action == 'Selesai' ? 'bg-success' : ($history->action == 'Ditolak' ? 'bg-danger' : ($history->action == 'Diproses' ? 'bg-info' : 'bg-warning'))) }}">
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-1">
                                        <i class="{{ $history->status_icon }}"></i>
                                        {{ $history->action }}
                                        @if ($history->status_from && $history->status_to)
                                            ({{ $history->status_from }} → {{ $history->status_to }})
                                        @endif
                                    </h6>
                                    <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <p class="text-muted small mb-1">
                                    {{ $history->keterangan ?: $history->keterangan_default }}
                                </p>
                                @if ($history->admin_name && $history->admin_name !== 'Sistem')
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-user-tie"></i> {{ $history->admin_name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback jika tidak ada history -->
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">
                                <i class="fas fa-plus-circle text-primary"></i>
                                Pengaduan Dibuat
                            </h6>
                            <p class="text-muted small mb-0">{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB
                            </p>
                            <p class="text-muted small">Pengaduan baru dari masyarakat</p>
                        </div>
                    </div>

                    @if ($pengaduan->updated_at != $pengaduan->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">
                                    <i class="fas fa-edit text-info"></i>
                                    Terakhir Diperbarui
                                </h6>
                                <p class="text-muted small mb-0">{{ $pengaduan->updated_at->format('d F Y, H:i') }}
                                    WIB</p>
                                <p class="text-muted small">Status: {{ $pengaduan->status }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>

<style>
    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -35px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        top: 5px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e3e6f0;
    }
</style>

@push('scripts')
    <script>
        // Function to open Gmail compose in new tab
        function openGmail(email, subject = '') {
            const encodedSubject = encodeURIComponent(subject || 'Balasan dari Dinas PUPR Katingan');
            const body = encodeURIComponent(
                'Halo,\n\nTerima kasih telah menghubungi Dinas PUPR Katingan.\n\nSalam hormat,\nAdmin Dinas PUPR Katingan'
                );
            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${encodedSubject}&body=${body}`;

            window.open(gmailUrl, '_blank');
        }
    </script>
@endpush
@endsection
