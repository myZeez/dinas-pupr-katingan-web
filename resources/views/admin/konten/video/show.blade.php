@extends('layouts.admin')

@section('title', 'Detail Video')

@push('styles')
    @include('admin.partials.show-styles')
@endpush

@section('content')
    <div class="admin-show-container">
        <!-- Header -->
        <div class="admin-show-header">
            <div>
                <h1 class="admin-show-title">Detail Video</h1>
                <nav>
                    <ol class="admin-show-breadcrumb">
                        <li><a href="{{ route('admin.konten.video.index') }}">Video</a></li>
                        <li>Detail Video</li>
                    </ol>
                </nav>
            </div>
            <div class="admin-show-btn-group">
                <a href="{{ route('admin.konten.video.edit', $video) }}" class="admin-show-btn admin-show-btn-warning">
                    ✏️ Edit Video
                </a>
                <a href="{{ route('admin.konten.video.index') }}" class="admin-show-btn admin-show-btn-secondary">
                    ← Kembali
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-show-card">
            <div class="admin-show-card-header">
                <h6>🎬 {{ $video->title }}</h6>
                <div class="admin-show-btn-group">
                    <a href="{{ route('admin.konten.video.edit', $video) }}" class="admin-show-btn admin-show-btn-warning">
                        ✏️ Edit
                    </a>
                    <button type="button" class="admin-show-btn admin-show-btn-danger" onclick="openDeleteModal()">
                        🗑️ Hapus
                    </button>
                </div>
            </div>
            <div class="admin-show-card-body">
                <div class="admin-show-layout">
                    <!-- Video Section -->
                    <div class="admin-show-content">
                        @if (strpos($video->video_url, 'youtube.com') !== false || strpos($video->video_url, 'youtu.be') !== false)
                            @php
                                $video_id = '';
                                if (strpos($video->video_url, 'youtube.com') !== false) {
                                    parse_str(parse_url($video->video_url, PHP_URL_QUERY), $params);
                                    $video_id = $params['v'] ?? '';
                                } elseif (strpos($video->video_url, 'youtu.be') !== false) {
                                    $video_id = substr(parse_url($video->video_url, PHP_URL_PATH), 1);
                                }
                            @endphp
                            @if ($video_id)
                                <div class="admin-show-video">
                                    <iframe src="https://www.youtube.com/embed/{{ $video_id }}"
                                        allowfullscreen></iframe>
                                </div>
                            @else
                                <div
                                    style="padding: 20px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; color: #856404;">
                                    <strong>⚠️ URL YouTube tidak valid:</strong><br>
                                    <a href="{{ $video->video_url }}" target="_blank">{{ $video->video_url }}</a>
                                </div>
                            @endif
                        @elseif(strpos($video->video_url, 'vimeo.com') !== false)
                            @php
                                $video_id = substr(parse_url($video->video_url, PHP_URL_PATH), 1);
                            @endphp
                            <div class="admin-show-video">
                                <iframe src="https://player.vimeo.com/video/{{ $video_id }}" allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="admin-show-video">
                                <video controls style="width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
                                    <source src="{{ $video->video_url }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            </div>
                        @endif

                        @if ($video->description)
                            <div style="margin-top: 25px;">
                                <h5>Deskripsi Video</h5>
                                <div class="admin-show-content">
                                    {{ $video->description }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Info Panel -->
                    <div class="admin-show-info-panel">
                        <div class="admin-show-info-header">
                            <h6>ℹ️ Informasi Video</h6>
                        </div>

                        @if ($video->thumbnail)
                            <div style="padding: 20px; text-align: center;">
                                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail"
                                    class="admin-show-image" style="max-height: 150px; width: auto;"
                                    onclick="openImageModal()">
                            </div>
                        @endif

                        <table class="admin-show-info-table">
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span
                                        class="admin-show-badge {{ $video->status == 'active' ? 'admin-show-badge-success' : 'admin-show-badge-secondary' }}">
                                        {{ $video->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Slug:</th>
                                <td><code
                                        style="background: #f8f9fa; padding: 2px 6px; border-radius: 4px;">{{ $video->slug }}</code>
                                </td>
                            </tr>
                            <tr>
                                <th>URL Video:</th>
                                <td>
                                    <a href="{{ $video->video_url }}" target="_blank"
                                        style="color: #007bff; text-decoration: none;">
                                        🔗 Buka Link
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat:</th>
                                <td>{{ $video->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diperbarui:</th>
                                <td>{{ $video->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if ($video->user)
                                <tr>
                                    <th>Dibuat oleh:</th>
                                    <td>{{ $video->user->name }}</td>
                                </tr>
                            @endif
                        </table>

                        <div class="admin-show-actions">
                            <form action="{{ route('admin.konten.video.toggle-status', $video) }}" method="POST"
                                style="margin-bottom: 10px;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="admin-show-btn {{ $video->status == 'active' ? 'admin-show-btn-warning' : 'admin-show-btn-success' }}">
                                    {{ $video->status == 'active' ? '⏸️ Nonaktifkan' : '▶️ Aktifkan' }}
                                </button>
                            </form>

                            <a href="{{ route('admin.konten.video.edit', $video) }}"
                                class="admin-show-btn admin-show-btn-warning">
                                ✏️ Edit Video
                            </a>
                            <a href="{{ route('admin.konten.video.index') }}"
                                class="admin-show-btn admin-show-btn-secondary">
                                📋 Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal for Thumbnail -->
    @if ($video->thumbnail)
        <div id="imageModal" class="admin-show-modal">
            <span class="admin-show-modal-close" onclick="closeImageModal()">&times;</span>
            <img class="admin-show-modal-image" src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail">
        </div>
    @endif

    <!-- Delete Modal -->
    <div id="deleteModal" class="admin-show-modal">
        <div class="admin-show-modal-content">
            <h4>Konfirmasi Hapus</h4>
            <p>Apakah Anda yakin ingin menghapus video "{{ $video->title }}"?</p>
            <div class="admin-show-btn-group">
                <form action="{{ route('admin.konten.video.destroy', $video) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-show-btn admin-show-btn-danger">Ya, Hapus</button>
                </form>
                <button type="button" class="admin-show-btn admin-show-btn-secondary"
                    onclick="closeDeleteModal()">Batal</button>
            </div>
        </div>
    </div>

    <script>
        function openImageModal() {
            document.getElementById('imageModal').classList.add('show');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.remove('show');
        }

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const imageModal = document.getElementById('imageModal');
            const deleteModal = document.getElementById('deleteModal');

            if (event.target === imageModal) {
                closeImageModal();
            }
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
                closeDeleteModal();
            }
        });
    </script>
@endsection
