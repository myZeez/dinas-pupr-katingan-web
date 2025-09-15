@extends('layouts.admin')

@section('title', 'Edit File Download')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit File Download</h1>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Edit File Download</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.konten.index') }}">Konten</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.konten.download.show', $fileDownload) }}">{{ $fileDownload->nama_file }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.konten.download.show', $fileDownload) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">Form Edit File Download</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.konten.download.update', $fileDownload) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nama_file" class="form-label">Nama File <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_file') is-invalid @enderror"
                                    id="nama_file" name="nama_file" value="{{ old('nama_file', $fileDownload->nama_file) }}"
                                    required>
                                @error('nama_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $fileDownload->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Ganti File (Opsional)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Kosongkan jika tidak ingin mengganti file. Maksimal 100MB
                                </div>
                            </div>

                            <!-- Current File Info -->
                            @if ($fileDownload->file_path)
                                <div class="mb-3">
                                    <label class="form-label">File Saat Ini:</label>
                                    <div class="d-flex align-items-center p-3 border rounded bg-light">
                                        <div class="me-3">
                                            <i class="fas fa-file fa-2x text-primary"></i>
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
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                    name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="dokumen"
                                        {{ old('kategori', $fileDownload->kategori) == 'dokumen' ? 'selected' : '' }}>
                                        Dokumen</option>
                                    <option value="formulir"
                                        {{ old('kategori', $fileDownload->kategori) == 'formulir' ? 'selected' : '' }}>
                                        Formulir</option>
                                    <option value="peraturan"
                                        {{ old('kategori', $fileDownload->kategori) == 'peraturan' ? 'selected' : '' }}>
                                        Peraturan</option>
                                    <option value="panduan"
                                        {{ old('kategori', $fileDownload->kategori) == 'panduan' ? 'selected' : '' }}>
                                        Panduan</option>
                                    <option value="infrastruktur"
                                        {{ old('kategori', $fileDownload->kategori) == 'infrastruktur' ? 'selected' : '' }}>
                                        Infrastruktur</option>
                                    <option value="perencanaan"
                                        {{ old('kategori', $fileDownload->kategori) == 'perencanaan' ? 'selected' : '' }}>
                                        Perencanaan</option>
                                    <option value="pembangunan"
                                        {{ old('kategori', $fileDownload->kategori) == 'pembangunan' ? 'selected' : '' }}>
                                        Pembangunan</option>
                                    <option value="pemeliharaan"
                                        {{ old('kategori', $fileDownload->kategori) == 'pemeliharaan' ? 'selected' : '' }}>
                                        Pemeliharaan</option>
                                    <option value="monitoring"
                                        {{ old('kategori', $fileDownload->kategori) == 'monitoring' ? 'selected' : '' }}>
                                        Monitoring</option>
                                    <option value="lainnya"
                                        {{ old('kategori', $fileDownload->kategori) == 'lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="urutan" class="form-label">Urutan</label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                    id="urutan" name="urutan" value="{{ old('urutan', $fileDownload->urutan) }}"
                                    min="0">
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif"
                                        {{ old('status', $fileDownload->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="non-aktif"
                                        {{ old('status', $fileDownload->status) == 'non-aktif' ? 'selected' : '' }}>Non
                                        Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statistics -->
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-download fa-2x mb-2"></i>
                                    <h4>{{ number_format($fileDownload->download_count) }}</h4>
                                    <p class="mb-0">Total Download</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.konten.download.show', $fileDownload) }}"
                            class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Update File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
