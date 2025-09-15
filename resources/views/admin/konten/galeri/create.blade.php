@extends('layouts.admin')

@section('title', 'Tambah Item Galeri')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Tambah Item Galeri</h1>
                        <p class="text-muted">Tambahkan foto ke galeri</p>
                    </div>
                    <a href="{{ route('admin.konten.index', ['tab' => 'galeri']) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.konten.galeri.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="judul" class="form-label">Judul <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('judul') is-invalid @enderror" id="judul"
                                                    name="judul" value="{{ old('judul') }}" required>
                                                @error('judul')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tipe" class="form-label">Tipe <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select @error('tipe') is-invalid @enderror"
                                                    id="tipe" name="tipe" required>
                                                    <option value="foto"
                                                        {{ old('tipe', 'foto') == 'foto' ? 'selected' : '' }}>Foto</option>
                                                </select>
                                                @error('tipe')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="file" class="form-label">File Gambar <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror"
                                            id="file" name="file" accept="image/*" required>
                                        <div class="form-text">
                                            Maksimal 10MB. Format yang didukung: JPG, JPEG, PNG, GIF, WEBP
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Preview Area -->
                                    <div id="preview-area" class="mb-3" style="display: none;">
                                        <label class="form-label">Preview</label>
                                        <div class="border rounded p-3">
                                            <div id="image-preview">
                                                <img id="preview-img" class="img-fluid rounded" style="max-height: 300px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="kategori" class="form-label">Kategori</label>
                                                <input type="text"
                                                    class="form-control @error('kategori') is-invalid @enderror"
                                                    id="kategori" name="kategori" value="{{ old('kategori') }}"
                                                    placeholder="Contoh: Kegiatan, Infrastruktur, dll">
                                                @error('kategori')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="urutan" class="form-label">Urutan</label>
                                                <input type="number"
                                                    class="form-control @error('urutan') is-invalid @enderror"
                                                    id="urutan" name="urutan" value="{{ old('urutan', 0) }}"
                                                    min="0">
                                                @error('urutan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                    <option value="aktif"
                                                        {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif
                                                    </option>
                                                    <option value="non-aktif"
                                                        {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-aktif
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.konten.index', ['tab' => 'galeri']) }}"
                                            class="btn btn-secondary">
                                            <i class="bi bi-x-lg"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const tipeSelect = document.getElementById('tipe');
            const previewArea = document.getElementById('preview-area');
            const imagePreview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileType = file.type;
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewArea.style.display = 'block';
                        imagePreview.style.display = 'block';
                        previewImg.src = e.target.result;

                        // Auto-set tipe to foto
                        tipeSelect.value = 'foto';
                    };

                    reader.readAsDataURL(file);
                } else {
                    previewArea.style.display = 'none';
                }
            });
        });
    </script>
@endpush
