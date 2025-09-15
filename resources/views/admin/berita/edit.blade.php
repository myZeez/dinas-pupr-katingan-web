@extends('layouts.admin')

@section('title', 'Edit Berita')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- FontAwesome for toolbar icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        ✏️ Edit Berita
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Alert untuk error -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi kesalahan!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Alert untuk success -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Form untuk edit berita -->
                    <!-- Form untuk edit berita -->
                    <form action="{{ route('admin.konten.berita.update', $berita) }}" method="POST" enctype="multipart/form-data" id="beritaForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Judul Berita -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">
                                Judul Berita <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul', $berita->judul) }}" 
                                   placeholder="Masukkan judul berita" 
                                   required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konten Berita -->
                        <div class="mb-3">
                            <label for="konten" class="form-label">
                                Konten Berita <span class="text-danger">*</span>
                            </label>
                            
                            <!-- Toolbar Formatting -->
                            <div id="formatting-toolbar" class="formatting-toolbar p-3 mb-3">
                                <div class="d-flex flex-wrap gap-1">
                                    <!-- Text Formatting -->
                                    <div class="btn-group btn-group-sm me-2" role="group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('bold')" title="Bold">
                                            <strong>B</strong>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('italic')" title="Italic">
                                            <em>I</em>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('underline')" title="Underline">
                                            <u>U</u>
                                        </button>
                                    </div>
                                    
                                    <!-- Text Alignment -->
                                    <div class="btn-group btn-group-sm me-2" role="group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('alignLeft')" title="Align Left">
                                            ⬅
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('alignCenter')" title="Align Center">
                                            ↔
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('alignRight')" title="Align Right">
                                            ➡
                                        </button>
                                    </div>
                                    
                                    <!-- Lists -->
                                    <div class="btn-group btn-group-sm me-2" role="group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('bulletList')" title="Bullet List">
                                            • List
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('numberList')" title="Numbered List">
                                            1. List
                                        </button>
                                    </div>
                                    
                                    <!-- Headings -->
                                    <div class="btn-group btn-group-sm me-2" role="group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('h1')" title="Heading 1">
                                            H1
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('h2')" title="Heading 2">
                                            H2
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('h3')" title="Heading 3">
                                            H3
                                        </button>
                                    </div>
                                    
                                    <!-- Others -->
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('link')" title="Insert Link">
                                            🔗 Link
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('br')" title="Line Break">
                                            Break
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('hr')" title="Horizontal Rule">
                                            HR
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <strong>Tips:</strong> Gunakan toolbar untuk format teks dengan mudah.
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Visual Editor -->
                            <div id="visual-editor" class="visual-editor mb-2" 
                                 contenteditable="true" 
                                 style="min-height: 400px; border: 1px solid #ced4da; border-radius: 0.375rem; padding: 12px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: white;"
                                 placeholder="Tulis konten berita di sini...">{{ old('konten', $berita->konten) }}</div>
                            
                            <!-- Hidden HTML Textarea -->
                            <textarea class="form-control @error('konten') is-invalid @enderror" 
                                      id="konten" 
                                      name="konten" 
                                      rows="15" 
                                      style="display: none; min-height: 400px; font-family: 'Courier New', monospace;"
                                      required>{{ old('konten', $berita->konten) }}</textarea>
                            
                            @error('konten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gambar Berita -->
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Gambar Berita</label>
                            @if($berita->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="Current thumbnail" class="img-thumbnail" style="max-height: 150px;">
                                    <p class="small text-muted mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            <input type="file" 
                                   class="form-control @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" 
                                   name="thumbnail" 
                                   accept="image/*">
                            <div class="form-text">
                                Format yang diizinkan: JPG, JPEG, PNG, GIF. Maksimal 5MB. Kosongkan jika tidak ingin mengubah.
                            </div>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Gambar -->
                        <div id="imagePreview" class="mb-3" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>

                        <!-- Status Publikasi -->
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                Status Publikasi <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>
                                <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>
                                    Dipublikasikan
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penulis -->
                        <div class="mb-3">
                            <label for="author" class="form-label">Penulis</label>
                            <input type="text" 
                                   class="form-control @error('author') is-invalid @enderror" 
                                   id="author" 
                                   name="author" 
                                   value="{{ old('author', $berita->author ?? auth()->user()->name) }}" 
                                   placeholder="Nama penulis">
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Publikasi -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Publikasi</label>
                            <input type="date" 
                                   class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" 
                                   name="tanggal" 
                                   value="{{ old('tanggal', $berita->tanggal ? $berita->tanggal->format('Y-m-d') : '') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.konten.index', ['tab' => 'berita']) }}" 
                               class="btn btn-secondary">
                                ← Kembali
                            </a>
                            <div>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    ↻ Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    💾 Update Berita
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk visual editor -->
<script>
// Simplified visual editor system
class VisualEditor {
    constructor() {
        this.visualEditor = document.getElementById('visual-editor');
        this.htmlTextarea = document.getElementById('konten');
        this.toolbar = document.getElementById('formatting-toolbar');
        
        this.init();
    }
    
    init() {
        // Set initial content
        if (this.htmlTextarea.value) {
            this.visualEditor.innerHTML = this.htmlTextarea.value;
        }
        
        // Sync visual to textarea on input
        this.visualEditor.addEventListener('input', () => {
            this.htmlTextarea.value = this.visualEditor.innerHTML;
        });
        
        // Handle empty content placeholder
        this.visualEditor.addEventListener('blur', () => {
            if (this.visualEditor.innerHTML === '' || this.visualEditor.innerHTML === '<br>') {
                this.visualEditor.innerHTML = '';
                this.htmlTextarea.value = '';
            }
        });
        
        // Form submission handler
        document.getElementById('beritaForm').addEventListener('submit', () => {
            this.htmlTextarea.value = this.visualEditor.innerHTML;
        });
    }
}

// Initialize global editor instance
let editorInstance;

// Global formatting function
window.formatText = function(command) {
    editorInstance.visualEditor.focus();
    
    switch(command) {
        case 'bold':
            document.execCommand('bold', false, null);
            break;
        case 'italic':
            document.execCommand('italic', false, null);
            break;
        case 'underline':
            document.execCommand('underline', false, null);
            break;
        case 'alignLeft':
            document.execCommand('justifyLeft', false, null);
            break;
        case 'alignCenter':
            document.execCommand('justifyCenter', false, null);
            break;
        case 'alignRight':
            document.execCommand('justifyRight', false, null);
            break;
        case 'bulletList':
            document.execCommand('insertUnorderedList', false, null);
            break;
        case 'numberList':
            document.execCommand('insertOrderedList', false, null);
            break;
        case 'h1':
            document.execCommand('formatBlock', false, '<h1>');
            break;
        case 'h2':
            document.execCommand('formatBlock', false, '<h2>');
            break;
        case 'h3':
            document.execCommand('formatBlock', false, '<h3>');
            break;
        case 'link':
            insertLink();
            break;
        case 'br':
            document.execCommand('insertHTML', false, '<br>');
            break;
        case 'hr':
            document.execCommand('insertHTML', false, '<hr>');
            break;
    }
    
    // Update textarea after formatting
    editorInstance.htmlTextarea.value = editorInstance.visualEditor.innerHTML;
};

function insertLink() {
    const url = prompt('Masukkan URL link:', 'https://');
    if (url) {
        const text = window.getSelection().toString() || prompt('Masukkan teks link:', 'Klik di sini') || url;
        document.execCommand('insertHTML', false, `<a href="${url}" target="_blank">${text}</a>`);
        editorInstance.htmlTextarea.value = editorInstance.visualEditor.innerHTML;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize visual editor
    editorInstance = new VisualEditor();
    
    // Preview gambar functionality
    const gambarInput = document.getElementById('thumbnail');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (gambarInput) {
        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    }

    // Form validation
    const form = document.getElementById('beritaForm');
    if (form) {
        form.addEventListener('submit', function(e) {        
            const judul = document.getElementById('judul').value.trim();
            const konten = document.getElementById('konten').value.trim();
            const status = document.getElementById('status').value;

            if (!judul || !konten || !status) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
                return false;
            }

            // Tampilkan loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}

.btn {
    font-weight: 500;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}

#imagePreview img {
    border: 2px solid #dee2e6;
}

/* Styling untuk toolbar formatting */
.formatting-toolbar {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.formatting-toolbar .btn {
    border: 1px solid #ced4da;
    margin: 1px;
    transition: all 0.2s ease;
}

.formatting-toolbar .btn:hover {
    background-color: #007bff;
    color: white;
    transform: translateY(-1px);
}

.formatting-toolbar .btn-group {
    margin-right: 8px !important;
}

/* Preview area untuk formatted text */
.format-preview {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    padding: 10px;
    background: #fff;
    border-radius: 4px;
    margin-top: 10px;
}

/* Visual Editor Styling */
.visual-editor {
    min-height: 400px;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 12px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: white;
    line-height: 1.6;
    font-size: 14px;
    overflow-y: auto;
}

.visual-editor:focus {
    outline: none;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.visual-editor:empty:before {
    content: "Tulis konten berita di sini...";
    color: #6c757d;
    font-style: italic;
}

.visual-editor h1 {
    font-size: 2rem;
    font-weight: bold;
    margin: 1rem 0 0.5rem 0;
    color: #212529;
}

.visual-editor h2 {
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0.8rem 0 0.4rem 0;
    color: #212529;
}

.visual-editor h3 {
    font-size: 1.25rem;
    font-weight: bold;
    margin: 0.6rem 0 0.3rem 0;
    color: #212529;
}

.visual-editor p {
    margin: 0.5rem 0;
}

.visual-editor ul, .visual-editor ol {
    margin: 0.5rem 0;
    padding-left: 2rem;
}

.visual-editor li {
    margin: 0.25rem 0;
}

.visual-editor a {
    color: #0d6efd;
    text-decoration: underline;
}

.visual-editor a:hover {
    color: #0a58ca;
}

.visual-editor hr {
    margin: 1rem 0;
    border: none;
    border-top: 1px solid #dee2e6;
}

.visual-editor strong {
    font-weight: bold;
}

.visual-editor em {
    font-style: italic;
}

.visual-editor u {
    text-decoration: underline;
}
</style>
@endsection
