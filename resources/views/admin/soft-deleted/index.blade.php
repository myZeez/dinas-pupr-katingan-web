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
        <div class="row mb-4">
            @foreach ($stats as $key => $count)
                <div class="col-md-2">
                    <div class="card text-center h-100 border-0 shadow-sm">
                        <div class="card-body py-2">
                            <h6 class="card-title mb-1 fw-bold">{{ $count }}</h6>
                            <p class="card-text small text-muted mb-0">
                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

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
            <img src="{{ asset('Icon/loading.gif') }}" alt="Loading" style="width: 64px; height: 64px; margin-bottom: 1rem;">
            <h5 style="margin: 0 0 0.5rem 0; color: #333; font-weight: 600;">Memproses...</h5>
            <p style="margin: 0; color: #666; font-size: 14px;">${message}</p>
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
