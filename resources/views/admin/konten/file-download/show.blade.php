@extends('layouts.admin')

@section('title', 'Detail File Download')

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

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
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

        .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
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

        .content-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin: 20px 0 15px 0;
        }

        .content-description {
            color: #666;
            line-height: 1.6;
            font-size: 16px;
            margin-bottom: 25px;
        }

        .file-preview {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border: 1px solid #e3e6f0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .file-icon {
            font-size: 3rem;
            color: #007bff;
            min-width: 60px;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .file-meta {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }

        .download-stats {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            border-radius: 8px;
            padding: 15px 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .download-stats .number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .download-stats .label {
            font-size: 14px;
            opacity: 0.9;
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

        .badge-info {
            background: #17a2b8;
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

            .file-preview {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-container">
            <div>
                <h1 class="page-title">Detail File Download</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('admin.konten.index', ['tab' => 'download']) }}">Konten</a></li>
                        <li>Detail File Download</li>
                    </ol>
                </nav>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.konten.download.edit', $fileDownload) }}" class="btn btn-warning">
                    ✏️ Edit File
                </a>
                <a href="{{ route('admin.konten.index', ['tab' => 'download']) }}" class="btn btn-primary">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-grid">
            <!-- Left Card: Content and Details -->
            <div class="card">
                <div class="card-body">
                    <h2 class="content-title">{{ $fileDownload->judul }}</h2>

                    @if ($fileDownload->deskripsi)
                        <div class="content-description">
                            {{ $fileDownload->deskripsi }}
                        </div>
                    @endif

                    <!-- File Preview Section -->
                    <div class="file-preview">
                        <div class="file-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name">{{ $fileDownload->file_name }}</div>
                            <div class="file-meta">
                                📊 Ukuran: {{ number_format($fileDownload->file_size / 1024, 2) }} KB<br>
                                📥 Didownload: {{ number_format($fileDownload->download_count) }} kali<br>
                                📅 Diupload: {{ $fileDownload->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.konten.download.file', $fileDownload) }}" class="btn btn-success">
                                📥 Download File
                            </a>
                        </div>
                    </div>

                    <!-- Download Statistics -->
                    <div class="download-stats">
                        <div class="number">{{ number_format($fileDownload->download_count) }}</div>
                        <div class="label">Total Download</div>
                    </div>
                </div>
            </div>

            <!-- Right Card: Information Panel -->
            <div class="card info-card">
                <div class="info-header">
                    <h6>ℹ️ Informasi File</h6>
                </div>
                <table class="info-table">
                    <tr>
                        <th>Kategori:</th>
                        <td>{{ $fileDownload->kategori ?: 'Tidak dikategorikan' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge {{ $fileDownload->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($fileDownload->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Urutan:</th>
                        <td>{{ $fileDownload->urutan }}</td>
                    </tr>
                    <tr>
                        <th>Nama File:</th>
                        <td><small>{{ $fileDownload->file_name }}</small></td>
                    </tr>
                    <tr>
                        <th>Ukuran File:</th>
                        <td>{{ number_format($fileDownload->file_size / 1024, 2) }} KB</td>
                    </tr>
                    <tr>
                        <th>Total Download:</th>
                        <td>
                            <span class="badge badge-info">
                                {{ number_format($fileDownload->download_count) }} kali
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Ditambahkan:</th>
                        <td>{{ $fileDownload->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui:</th>
                        <td>{{ $fileDownload->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @if ($fileDownload->user)
                        <tr>
                            <th>Dibuat oleh:</th>
                            <td>{{ $fileDownload->user->name }}</td>
                        </tr>
                    @endif
                </table>

                <div class="action-buttons">
                    <a href="{{ route('admin.konten.download.edit', $fileDownload) }}" class="btn btn-warning">
                        ✏️ Edit File
                    </a>
                    <a href="{{ route('admin.konten.download.file', $fileDownload) }}" class="btn btn-success">
                        📥 Download File
                    </a>
                    <button type="button" class="btn btn-danger" onclick="openDeleteModal()">
                        🗑️ Hapus File
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4 style="margin-bottom: 15px; color: #333;">Konfirmasi Hapus</h4>
            <p style="margin-bottom: 25px; color: #666;">Apakah Anda yakin ingin menghapus file
                "{{ $fileDownload->judul }}"?</p>
            <div class="btn-group">
                <form action="{{ route('admin.konten.download.destroy', $fileDownload) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const deleteModal = document.getElementById('deleteModal');
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
@endsection
