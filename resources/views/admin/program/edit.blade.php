@extends('layouts.admin')

@section('title', 'Edit Program')
@section('page-title', 'Edit Program')
@section('page-subtitle', 'Perbarui informasi program kerja')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil me-2"></i>
                    Form Edit Program
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.konten.program.update', $program) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_program" class="form-label">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_program') is-invalid @enderror" 
                               id="nama_program" name="nama_program" value="{{ old('nama_program', $program->nama_program) }}" required>
                        @error('nama_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Program <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror d-none" 
                                  id="deskripsi" name="deskripsi" rows="6" required>{{ old('deskripsi', $program->deskripsi) }}</textarea>
                        <div id="program-editor" style="min-height: 200px; border: 1px solid #ced4da; border-radius: 0.375rem;">
                            {!! old('deskripsi', $program->deskripsi) !!}
                        </div>
                        @error('deskripsi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Program <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Perencanaan" {{ old('status', $program->status) == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                                    <option value="Berjalan" {{ old('status', $program->status) == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                                    <option value="Selesai" {{ old('status', $program->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                       id="lokasi" name="lokasi" value="{{ old('lokasi', $program->lokasi) }}" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $program->tanggal_mulai ? $program->tanggal_mulai->format('Y-m-d') : '') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $program->tanggal_selesai ? $program->tanggal_selesai->format('Y-m-d') : '') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.konten.program.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Update Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Informasi Program
                </h6>
            </div>
            <div class="card-body">
                <p><strong>Dibuat:</strong> {{ $program->created_at ? $program->created_at->format('d M Y, H:i') : '-' }}</p>
                <p><strong>Diperbarui:</strong> {{ $program->updated_at ? $program->updated_at->format('d M Y, H:i') : '-' }}</p>
                <p><strong>Durasi:</strong> {{ $program->tanggal_mulai->diffInDays($program->tanggal_selesai) }} hari</p>
                <hr>
                <div class="d-grid">
                    <a href="{{ route('admin.konten.program.show', $program) }}" class="btn btn-outline-info">
                        <i class="bi bi-eye me-1"></i>Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CKEditor 5 Integration for Program Edit
let programEditorInstance;

// Load CKEditor 5
const script = document.createElement('script');
script.src = 'https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js';
script.onload = function() {
    ClassicEditor
        .create(document.querySelector('#program-editor'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'fontSize', 'fontColor', '|',
                    'numberedList', 'bulletedList', '|',
                    'alignment', '|',
                    'outdent', 'indent', '|',
                    'link', 'insertTable', 'blockQuote', '|',
                    'undo', 'redo'
                ]
            },
            language: 'id',
            placeholder: 'Masukkan deskripsi program secara detail...',
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            },
            fontSize: {
                options: [
                    9, 11, 13, 'default', 17, 19, 21
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            }
        })
        .then(editor => {
            programEditorInstance = editor;
            
            // Sync with hidden textarea
            editor.model.document.on('change:data', () => {
                const data = editor.getData();
                document.querySelector('#deskripsi').value = data;
            });
            
            // Set initial content
            const initialContent = document.querySelector('#deskripsi').value;
            if (initialContent) {
                editor.setData(initialContent);
            }
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });
};
document.head.appendChild(script);
</script>
@endpush
