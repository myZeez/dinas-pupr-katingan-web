@extends('layouts.admin')

@section('title', 'Data Terhapus')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Data Terhapus</h1>
                <p class="text-muted">Kelola data yang telah dihapus (Soft Delete)</p>
            </div>

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#cleanupModal">
                    <i class="bi bi-trash"></i> Bersihkan Data Lama
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid-container">
            @foreach ($stats as $key => $count)
                <div class="stats-grid-item">
                    <div class="stats-card">
                        <div class="stats-content">
                            <h6 class="stats-count">{{ $count }}</h6>
                            <p class="stats-label">
                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <style>
            /* Statistics Cards Grid Layout - Pure CSS */
            .stats-grid-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 20px;
                margin-bottom: 32px;
                padding: 0;
            }

            .stats-grid-item {
                margin: 0;
                padding: 0;
            }

            .stats-card {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .stats-card:hover {
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
                transform: translateY(-2px);
            }

            .stats-content {
                padding: 24px 16px;
                text-align: center;
                margin: 0;
            }

            .stats-count {
                font-size: 28px;
                font-weight: 700;
                color: #333;
                margin: 0 0 8px 0;
                padding: 0;
                line-height: 1.2;
            }

            .stats-label {
                font-size: 13px;
                color: #6c757d;
                margin: 0;
                padding: 0;
                line-height: 1.4;
                text-transform: capitalize;
            }

            /* Responsive Breakpoints */
            @media (max-width: 1400px) {
                .stats-grid-container {
                    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                    gap: 16px;
                    margin-bottom: 28px;
                }

                .stats-content {
                    padding: 20px 14px;
                }

                .stats-count {
                    font-size: 24px;
                }
            }

            @media (max-width: 1200px) {
                .stats-grid-container {
                    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
                    gap: 14px;
                    margin-bottom: 24px;
                }

                .stats-content {
                    padding: 18px 12px;
                }

                .stats-count {
                    font-size: 22px;
                    margin: 0 0 6px 0;
                }

                .stats-label {
                    font-size: 12px;
                }
            }

            @media (max-width: 992px) {
                .stats-grid-container {
                    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                    gap: 12px;
                    margin-bottom: 20px;
                }

                .stats-content {
                    padding: 16px 10px;
                }

                .stats-count {
                    font-size: 20px;
                }
            }

            @media (max-width: 768px) {
                .stats-grid-container {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 12px;
                    margin-bottom: 20px;
                }

                .stats-content {
                    padding: 16px 12px;
                }
            }

            @media (max-width: 576px) {
                .stats-grid-container {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                    margin-bottom: 16px;
                }

                .stats-content {
                    padding: 14px 10px;
                }

                .stats-count {
                    font-size: 18px;
                }

                .stats-label {
                    font-size: 11px;
                }
            }

            /* Additional Page Spacing - Pure CSS */
            .container-fluid {
                padding: 24px 28px;
                margin: 0;
            }

            /* Header Section */
            .container-fluid > div:first-child {
                margin-bottom: 28px;
                padding: 0;
            }

            .container-fluid h1 {
                margin: 0 0 8px 0;
                padding: 0;
            }

            .container-fluid p.text-muted {
                margin: 0;
                padding: 0;
            }

            /* Card Container */
            .card {
                margin: 0 0 28px 0;
                padding: 0;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            }

            .card-header {
                padding: 16px 20px;
                margin: 0;
                background: #f8f9fa;
                border-bottom: 1px solid #dee2e6;
            }

            .card-body {
                padding: 24px;
                margin: 0;
            }

            /* Navigation Tabs */
            .nav-tabs {
                margin: 0;
                padding: 0;
                border-bottom: none;
            }

            .nav-item {
                margin: 0 8px 0 0;
                padding: 0;
            }

            .nav-link {
                padding: 10px 16px;
                margin: 0;
                border-radius: 8px 8px 0 0;
            }

            /* Table Styling */
            .table-responsive {
                margin: 0 0 20px 0;
                padding: 0;
            }

            .table {
                margin: 0;
            }

            .table thead th {
                padding: 14px 12px;
                margin: 0;
                background: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
            }

            .table tbody td {
                padding: 14px 12px;
                margin: 0;
                vertical-align: middle;
            }

            /* Pagination Section */
            .d-flex.justify-content-between {
                margin: 20px 0 0 0;
                padding: 16px 0 0 0;
                border-top: 1px solid #dee2e6;
            }

            /* Button Groups */
            .btn-group {
                margin: 0;
                padding: 0;
            }

            .btn-group .btn {
                margin: 0 2px;
                padding: 6px 12px;
            }

            /* Empty State */
            .text-center.py-5 {
                padding: 48px 24px !important;
                margin: 0;
            }

            .text-center.py-5 i {
                margin: 0 0 20px 0;
            }

            .text-center.py-5 h4 {
                margin: 0 0 12px 0;
                padding: 0;
            }

            .text-center.py-5 p {
                margin: 0;
                padding: 0;
            }

            /* Modal Styling */
            .modal-header {
                padding: 20px 24px;
                margin: 0;
            }

            .modal-body {
                padding: 24px;
                margin: 0;
            }

            .modal-footer {
                padding: 16px 24px;
                margin: 0;
            }

            /* Badges */
            .badge {
                padding: 6px 12px;
                margin: 0 4px 0 0;
                border-radius: 6px;
            }

            /* Responsive Adjustments */
            @media (max-width: 992px) {
                .container-fluid {
                    padding: 20px 16px;
                }

                .card-body {
                    padding: 20px 16px;
                }

                .table thead th,
                .table tbody td {
                    padding: 12px 10px;
                }
            }

            @media (max-width: 768px) {
                .container-fluid {
                    padding: 16px 12px;
                }

                .card-header {
                    padding: 14px 16px;
                }

                .card-body {
                    padding: 16px;
                }

                .nav-item {
                    margin: 0 4px 4px 0;
                }

                .nav-link {
                    padding: 8px 12px;
                    font-size: 14px;
                }

                .table thead th,
                .table tbody td {
                    padding: 10px 8px;
                    font-size: 13px;
                }
            }

            @media (max-width: 576px) {
                .container-fluid {
                    padding: 12px 10px;
                }

                .card-body {
                    padding: 14px 12px;
                }

                .modal-body {
                    padding: 20px 16px;
                }
            }
        </style>

        <!-- Filter Tabs -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'berita' ? 'active' : '' }}"
                            href="{{ route('admin.soft-deleted.index', ['type' => 'berita']) }}">
                            Berita ({{ $stats['berita'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'program' ? 'active' : '' }}"
                            href="{{ route('admin.soft-deleted.index', ['type' => 'program']) }}">
                            Program ({{ $stats['program'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'pengaduan' ? 'active' : '' }}"
                            href="{{ route('admin.soft-deleted.index', ['type' => 'pengaduan']) }}">
                            Pengaduan ({{ $stats['pengaduan'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'ulasan' ? 'active' : '' }}"
                            href="{{ route('admin.soft-deleted.index', ['type' => 'ulasan']) }}">
                            Ulasan ({{ $stats['ulasan'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'galeri' ? 'active' : '' }}"
                            href="{{ route('admin.soft-deleted.index', ['type' => 'galeri']) }}">
                            Galeri ({{ $stats['galeri'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'struktur' ? 'active' : '' }}"
                            href="{{ route('admin.soft-deleted.index', ['type' => 'struktur']) }}">
                            Struktur ({{ $stats['struktur'] }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'public_content_news' ? 'active' : '' }}"
                            href="{{ route('admin.soft-deleted.index', ['type' => 'public_content_news']) }}">
                            Public Content ({{ $stats['public_content_news'] }})
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                @if ($data->count() > 0)
                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    @if ($type === 'berita')
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tanggal</th>
                                    @elseif($type === 'program')
                                        <th>Nama Program</th>
                                        <th>Status</th>
                                        <th>Lokasi</th>
                                    @elseif($type === 'pengaduan')
                                        <th>Nama</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                    @elseif($type === 'permohonan')
                                        <th>Nomor</th>
                                        <th>Nama Pemohon</th>
                                        <th>Jenis Layanan</th>
                                    @elseif($type === 'ulasan')
                                        <th>Nama</th>
                                        <th>Rating</th>
                                        <th>Instansi</th>
                                    @elseif($type === 'galeri')
                                        <th>Judul</th>
                                        <th>Tipe</th>
                                        <th>Kategori</th>
                                    @elseif($type === 'struktur')
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Unit Kerja</th>
                                    @elseif($type === 'public_content_news')
                                        <th>Tipe</th>
                                        <th>Judul</th>
                                        <th>File/YouTube</th>
                                        <th>Status</th>
                                    @endif
                                    <th>Dihapus</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        @if ($type === 'berita')
                                            <td>
                                                <strong>{{ Str::limit($item->judul, 50) }}</strong>
                                                @if ($item->thumbnail)
                                                    <br><small class="text-muted">Ada thumbnail</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $item->kategori ?? 'Umum' }}</span>
                                            </td>
                                            <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                                        @elseif($type === 'program')
                                            <td>
                                                <strong>{{ Str::limit($item->nama_program, 50) }}</strong>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->status === 'Selesai' ? 'success' : ($item->status === 'Berjalan' ? 'primary' : 'warning') }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($item->lokasi, 30) }}</td>
                                        @elseif($type === 'pengaduan')
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ Str::limit($item->judul, 40) }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $item->kategori }}</span>
                                            </td>
                                        @elseif($type === 'permohonan')
                                            <td>
                                                <strong>{{ $item->nomor_permohonan }}</strong>
                                            </td>
                                            <td>{{ $item->nama_pemohon }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $item->jenis_layanan }}</span>
                                            </td>
                                        @elseif($type === 'ulasan')
                                            <td>{{ $item->nama }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="bi bi-star{{ $i <= $item->rating ? '-fill text-warning' : '' }}"></i>
                                                @endfor
                                            </td>
                                            <td>{{ $item->instansi ?? '-' }}</td>
                                        @elseif($type === 'galeri')
                                            <td>{{ Str::limit($item->judul, 40) }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $item->tipe }}</span>
                                            </td>
                                            <td>{{ $item->kategori ?? '-' }}</td>
                                        @elseif($type === 'struktur')
                                            <td>
                                                <strong>{{ $item->nama }}</strong>
                                                @if ($item->foto)
                                                    <br><small class="text-muted">Ada foto</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $item->jabatan }}</span>
                                            </td>
                                            <td>{{ $item->unit_kerja }}</td>
                                        @elseif($type === 'public_content_news')
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->tipe === 'karousel' ? 'primary' : ($item->tipe === 'video' ? 'info' : 'success') }}">
                                                    {{ ucfirst($item->tipe) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ Str::limit($item->judul, 40) }}</strong>
                                                @if ($item->deskripsi)
                                                    <br><small
                                                        class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->file_path)
                                                    <i class="fas fa-file text-success" title="{{ $item->file_name }}"></i>
                                                @endif
                                                @if ($item->youtube_url)
                                                    <a href="{{ $item->youtube_url }}" target="_blank" class="text-danger">
                                                        <i class="fab fa-youtube"></i>
                                                    </a>
                                                @endif
                                                @if (!$item->file_path && !$item->youtube_url)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->status === 'aktif' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                        @endif

                                        <td>
                                            <small class="text-muted">
                                                {{ $item->deleted_at->format('d/m/Y H:i') }}
                                                <br>{{ $item->deleted_at->diffForHumans() }}
                                            </small>
                                        </td>

                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="restoreItem('{{ $type }}', {{ $item->id }})"
                                                    title="Kembalikan">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>

                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="forceDeleteItem('{{ $type }}', {{ $item->id }})"
                                                    title="Hapus Permanen">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}
                                dari {{ $data->total() }} data
                            </small>
                        </div>
                        <div>
                            @include('components.custom-pagination', ['paginator' => $data])
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h4 class="mt-3">Tidak Ada Data Terhapus</h4>
                        <p class="text-muted">Tidak ada data {{ ucfirst($type) }} yang dihapus.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cleanup Modal -->
    <div class="modal fade" id="cleanupModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bersihkan Data Lama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <strong>Peringatan!</strong>
                        <p>Aksi ini akan <strong>menghapus permanen</strong> semua data yang telah dihapus lebih dari 30
                            hari yang lalu.</p>
                        <p class="mb-0">Data yang dihapus permanen tidak dapat dikembalikan!</p>
                    </div>
                    <p>Apakah Anda yakin ingin melanjutkan?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.soft-deleted.cleanup') }}" method="POST" class="d-inline delete-form"
                        data-message="Apakah Anda yakin ingin membersihkan data lama? Semua data yang dihapus lebih dari 30 hari akan dihapus PERMANEN!">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <img src="{{ asset('Icon/Delete.gif') }}" alt="Delete"
                                style="width: 20px; height: 20px; margin-right: 5px;">
                            Ya, Bersihkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function restoreItem(type, id) {
            console.log('Restore button clicked:', type, id);

            // Gunakan sistem konfirmasi yang konsisten dengan halaman lain
            confirmAction(
                'Apakah Anda yakin ingin mengembalikan data ini?',
                'success',
                'Ya, Restore'
            ).then((confirmed) => {
                if (confirmed) {
                    console.log('User confirmed restore');

                    // Tampilkan loading
                    showLoadingOverlay('Memproses restore data...');

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/soft-deleted/${type}/${id}/restore`;

                    console.log('Form action:', form.action);

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function forceDeleteItem(type, id) {
            console.log('Force delete button clicked:', type, id);

            // Gunakan sistem konfirmasi yang konsisten
            confirmAction(
                'PERINGATAN: Data akan dihapus PERMANEN dan tidak dapat dikembalikan!',
                'delete',
                'Ya, Hapus Permanen'
            ).then((confirmed) => {
                if (confirmed) {
                    console.log('User confirmed force delete');

                    // Tampilkan loading
                    showLoadingOverlay('Menghapus data secara permanen...');
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/soft-deleted/${type}/${id}/force-delete`;

                    console.log('Form action:', form.action);

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Function untuk menampilkan loading overlay
        function showLoadingOverlay(message) {
            // Hapus overlay yang ada jika ada
            const existingOverlay = document.getElementById('loadingOverlay');
            if (existingOverlay) {
                existingOverlay.remove();
            }

            // Buat loading overlay
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    `;

            overlay.innerHTML = `
        <div style="
            background: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 300px;
            width: 90%;
        ">
            <div class="css-dots-loader" style="margin: 0 auto 1rem;">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <h5 style="margin: 0 0 0.5rem 0; color: #333; font-weight: 600;">Memproses...</h5>
            <p style="margin: 0; color: #666; font-size: 14px;">${message}</p>
            <style>
                .css-dots-loader {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 8px;
                    height: 64px;
                }
                .css-dots-loader .dot {
                    width: 12px;
                    height: 12px;
                    border-radius: 50%;
                    background: #5b72ee;
                    animation: dotPulse 1.4s infinite ease-in-out both;
                }
                .css-dots-loader .dot:nth-child(1) {
                    animation-delay: -0.32s;
                }
                .css-dots-loader .dot:nth-child(2) {
                    animation-delay: -0.16s;
                    background: #00d4aa;
                }
                .css-dots-loader .dot:nth-child(3) {
                    background: #f4b400;
                }
                @keyframes dotPulse {
                    0%, 80%, 100% {
                        transform: scale(0.6);
                        opacity: 0.5;
                    }
                    40% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }
            </style>
        </div>
    `;

            document.body.appendChild(overlay);

            // Auto hide setelah 10 detik sebagai fallback
            setTimeout(() => {
                if (document.getElementById('loadingOverlay')) {
                    overlay.remove();
                }
            }, 10000);
        }
    </script>
@endpush
