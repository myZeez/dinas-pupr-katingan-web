@extends('layouts.admin')

@section('title', 'Detail File Download')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Detail File Download</h1>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Detail File Download</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.konten.index') }}">Konten</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail File Download</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.konten.download.edit', $fileDownload) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.konten.index', ['tab' => 'download']) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">{{ $fileDownload->judul }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        @if ($fileDownload->deskripsi)
                            <div class="mb-4">
                                <h5>Deskripsi</h5>
                                <p class="text-muted">{{ $fileDownload->deskripsi }}</p>
                            </div>
                        @endif

                        <div class="mb-4">
                            <h5>File</h5>
                            <div class="d-flex align-items-center p-3 border rounded bg-light">
                                <div class="me-3">
                                    <i class="fas fa-file fa-3x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $fileDownload->file_name }}</h6>
                                    <small class="text-muted">
                                        Ukuran: {{ number_format($fileDownload->file_size / 1024, 2) }} KB
                                        <br>
                                        Didownload: {{ number_format($fileDownload->download_count) }} kali
                                    </small>
                                </div>
                                <div>
                                    <a href="{{ route('admin.konten.download.file', $fileDownload) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Informasi File</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Kategori:</strong></td>
                                        <td>{{ $fileDownload->kategori ?: 'Tidak dikategorikan' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span
                                                class="badge {{ $fileDownload->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($fileDownload->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Urutan:</strong></td>
                                        <td>{{ $fileDownload->urutan }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Download:</strong></td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ number_format($fileDownload->download_count) }} kali
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ukuran File:</strong></td>
                                        <td>{{ number_format($fileDownload->file_size / 1024, 2) }} KB</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ditambahkan:</strong></td>
                                        <td><small>{{ $fileDownload->created_at->format('d/m/Y H:i') }}</small></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diperbarui:</strong></td>
                                        <td><small>{{ $fileDownload->updated_at->format('d/m/Y H:i') }}</small></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Statistics Card -->
                        <div class="card bg-primary text-white mt-3">
                            <div class="card-body text-center">
                                <i class="fas fa-download fa-2x mb-2"></i>
                                <h4>{{ number_format($fileDownload->download_count) }}</h4>
                                <p class="mb-0">Total Download</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
