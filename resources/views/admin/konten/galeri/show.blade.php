@extends('layouts.admin')

@section('title', 'Detail Galeri')

@push('styles')
    <style>
        * {
            box-sizing: border-box;
        }

        .page-header {
            padding: 20px 0;
            margin-bottom: 30px;
            background-color: white;
            border: none;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        .breadcrumb {
            list-style: none;
            padding: 0;
            margin: 8px 0 0 0;
            display: flex;
            gap: 8px;
            font-size: 14px;
            opacity: 0.9;
        }

        .breadcrumb li:not(:last-child)::after {
            content: '>';
            margin-left: 8px;
        }

        .breadcrumb a {
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            min-width: 100px;
            justify-content: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(10px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-body {
            padding: 30px;
        }

        .image-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .main-image {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .main-image:hover {
            transform: scale(1.02);
        }

        .image-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin: 20px 0 15px 0;
        }

        .image-description {
            color: #666;
            line-height: 1.6;
            font-size: 16px;
            text-align: left;
        }

        .info-card {
            height: fit-content;
        }

        .info-header {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            padding: 20px;
            border-bottom: 1px solid #e3e6f0;
            text-align: center;
        }

        .info-header h6 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid #e3e6f0;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table th,
        .info-table td {
            padding: 15px 20px;
            text-align: left;
            vertical-align: top;
        }

        .info-table th {
            font-weight: 600;
            color: #333;
            width: 40%;
            font-size: 14px;
        }

        .info-table td {
            color: #666;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary {
            background: #007bff;
            color: white;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .action-buttons {
            padding: 20px;
            border-top: 1px solid #e3e6f0;
            background: #f8f9fc;
        }

        .action-buttons .btn {
            width: 100%;
            margin-bottom: 10px;
            justify-content: flex-start;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .modal-image {
            max-width: 90vw;
            max-height: 90vh;
            border-radius: 8px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .close:hover {
            opacity: 0.7;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .header-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .btn-group {
                width: 100%;
                flex-direction: column;
            }

            .main-container {
                padding: 0 15px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-container">
            <div>
                <h1 class="page-title">Detail Galeri</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('admin.konten.index') }}">Konten</a></li>
                        <li>Detail Galeri</li>
                    </ol>
                </nav>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.konten.galeri.edit', $galeri) }}" class="btn btn-warning">
                    ✏️ Edit Galeri
                </a>
                <a href="{{ route('admin.konten.index', ['tab' => 'galeri']) }}" class="btn btn-primary">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-grid">
            <!-- Left Card: Image and Details -->
            <div class="card">
                <div class="card-body">
                    @if ($galeri->file_path)
                        <div class="image-section">
                            <img src="{{ Storage::url($galeri->file_path) }}" alt="{{ $galeri->judul }}" class="main-image"
                                onclick="openImageModal()">
                        </div>
                    @endif

                    <h2 class="image-title">{{ $galeri->judul }}</h2>

                    @if ($galeri->deskripsi)
                        <div class="image-description">
                            {!! $galeri->deskripsi !!}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Card: Information Panel -->
            <div class="card info-card">
                <div class="info-header">
                    <h6>ℹ️ Informasi Media</h6>
                </div>
                <table class="info-table">
                    <tr>
                        <th>Tipe:</th>
                        <td><span class="badge badge-primary">{{ ucfirst($galeri->tipe) }}</span></td>
                    </tr>
                    <tr>
                        <th>Kategori:</th>
                        <td>{{ $galeri->kategori ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge {{ $galeri->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
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
                            <th>Nama File:</th>
                            <td><small>{{ $galeri->file_name }}</small></td>
                        </tr>
                    @endif
                    @if ($galeri->file_size)
                        <tr>
                            <th>Ukuran:</th>
                            <td>{{ $galeri->file_size_formatted }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>Ditambahkan:</th>
                        <td>{{ $galeri->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui:</th>
                        <td>{{ $galeri->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @if ($galeri->user)
                        <tr>
                            <th>Dibuat oleh:</th>
                            <td>{{ $galeri->user->name }}</td>
                        </tr>
                    @endif
                </table>

                <div class="action-buttons">
                    <a href="{{ route('admin.konten.galeri.edit', $galeri) }}" class="btn btn-warning">
                        ✏️ Edit Item
                    </a>
                    <button type="button" class="btn btn-danger" onclick="openDeleteModal()">
                        🗑️ Hapus Item
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    @if ($galeri->file_path)
        <div id="imageModal" class="modal">
            <span class="close" onclick="closeImageModal()">&times;</span>
            <img class="modal-image" src="{{ Storage::url($galeri->file_path) }}" alt="{{ $galeri->judul }}">
        </div>
    @endif

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4 style="margin-bottom: 15px; color: #333;">Konfirmasi Hapus</h4>
            <p style="margin-bottom: 25px; color: #666;">Apakah Anda yakin ingin menghapus galeri "{{ $galeri->judul }}"?
            </p>
            <div class="btn-group">
                <form action="{{ route('admin.konten.galeri.destroy', $galeri) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
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
