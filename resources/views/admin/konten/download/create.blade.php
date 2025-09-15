@extends('layouts.admin')

@section('title', 'Tambah File Download')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Tambah File Download</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.konten.index') }}">Konten</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah File Download</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('admin.konten.index', ['tab' => 'download']) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <!-- Form -->
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">Form Tambah File Download</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.konten.download.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Nama File <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" value="{{ old('judul') }}" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                            name="kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="dokumen" {{ old('kategori') == 'dokumen' ? 'selected' : '' }}>
                                                Dokumen</option>
                                            <option value="formulir" {{ old('kategori') == 'formulir' ? 'selected' : '' }}>
                                                Formulir</option>
                                            <option value="peraturan"
                                                {{ old('kategori') == 'peraturan' ? 'selected' : '' }}>Peraturan</option>
                                            <option value="panduan" {{ old('kategori') == 'panduan' ? 'selected' : '' }}>
                                                Panduan</option>
                                            <option value="infrastruktur"
                                                {{ old('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur
                                            </option>
                                            <option value="perencanaan"
                                                {{ old('kategori') == 'perencanaan' ? 'selected' : '' }}>Perencanaan
                                            </option>
                                            <option value="pembangunan"
                                                {{ old('kategori') == 'pembangunan' ? 'selected' : '' }}>Pembangunan
                                            </option>
                                            <option value="pemeliharaan"
                                                {{ old('kategori') == 'pemeliharaan' ? 'selected' : '' }}>Pemeliharaan
                                            </option>
                                            <option value="monitoring"
                                                {{ old('kategori') == 'monitoring' ? 'selected' : '' }}>Monitoring</option>
                                            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Upload File <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror"
                                            id="file" name="file" required>
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maksimal 10MB
                                        </div>
                                    </div>

                                    <!-- File Info Area -->
                                    <div id="file-info" class="d-none">
                                        <label class="form-label">Informasi File:</label>
                                        <div class="border rounded p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-file-alt fa-2x text-primary me-3"></i>
                                                <div>
                                                    <div id="file-name" class="fw-bold"></div>
                                                    <div id="file-size" class="text-muted small"></div>
                                                    <div id="file-type" class="text-muted small"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.konten.index', ['tab' => 'download']) }}"
                                    class="btn btn-secondary me-2">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-upload me-2"></i>Upload File
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const fileInfo = document.getElementById('file-info');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const fileType = document.getElementById('file-type');

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    fileType.textContent = file.type || 'Unknown';
                    fileInfo.classList.remove('d-none');
                } else {
                    fileInfo.classList.add('d-none');
                }
            });

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
@endsection
