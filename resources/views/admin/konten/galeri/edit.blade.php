@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Edit Galeri</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.konten.index') }}">Konten</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.konten.galeri.show', $galeri) }}">{{ $galeri->judul }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('admin.konten.galeri.show', $galeri) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <!-- Form -->
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">Form Edit Galeri</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.konten.galeri.update', $galeri) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}"
                                            required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="file" class="form-label">Ganti File Gambar (Opsional)</label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror"
                                            id="file" name="file" accept="image/*">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Kosongkan jika tidak ingin mengganti file.
                                            Format: JPG, JPEG, PNG, GIF, WEBP.
                                            Maksimal 10MB
                                        </div>
                                    </div>

                                    <!-- Current File Preview -->
                                    @if ($galeri->file_path)
                                        <div class="mb-3">
                                            <label class="form-label">File Saat Ini:</label>
                                            <div class="border rounded p-2">
                                                <img src="{{ Storage::url($galeri->file_path) }}"
                                                    alt="{{ $galeri->judul }}" class="img-thumbnail"
                                                    style="max-width: 200px; max-height: 150px;">
                                                <div class="mt-1">
                                                    <small class="text-muted">{{ $galeri->file_name }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tipe" class="form-label">Tipe Media <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('tipe') is-invalid @enderror" id="tipe"
                                            name="tipe" required>
                                            <option value="foto" selected>Foto</option>
                                        </select>
                                        @error('tipe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                            id="kategori" name="kategori" value="{{ old('kategori', $galeri->kategori) }}"
                                            placeholder="Misal: Kegiatan, Fasilitas">
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="urutan" class="form-label">Urutan</label>
                                        <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                            id="urutan" name="urutan" value="{{ old('urutan', $galeri->urutan) }}"
                                            min="0">
                                        @error('urutan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="aktif"
                                                {{ old('status', $galeri->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="non-aktif"
                                                {{ old('status', $galeri->status) == 'non-aktif' ? 'selected' : '' }}>Non
                                                Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.konten.galeri.show', $galeri) }}"
                                    class="btn btn-secondary me-2">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Update Galeri
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
