@extends('layouts.admin')

@section('title', 'Tambah Program')
@section('page-title', 'Tambah Program')
@section('page-subtitle', 'Buat program kerja baru')

@section('content')
<div class="row g-4">
    <!-- Kolom Kiri: Form Text Saja -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-clipboard-check text-success" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">Form Tambah Program</h5>
                        <small class="text-muted">Lengkapi informasi program kerja</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Alert untuk error -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.1rem;"></i>
                            <strong>Terjadi kesalahan!</strong>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Alert untuk success -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="font-size: 1.1rem;"></i>
                            <strong>{{ session('success') }}</strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Alert untuk warning -->
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.1rem;"></i>
                            <strong>{{ session('warning') }}</strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Alert untuk info -->
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2" style="font-size: 1.1rem;"></i>
                            <strong>{{ session('info') }}</strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form action="{{ route('admin.konten.program.store') }}" method="POST" id="program-form">
                    @csrf
                    
                    <!-- Nama Program - Diperluas -->
                    <div class="mb-4">
                        <label for="nama_program" class="form-label fw-semibold">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('nama_program') is-invalid @enderror" 
                               id="nama_program" name="nama_program" value="{{ old('nama_program') }}" 
                               placeholder="Masukkan nama program kerja..." required>
                        @error('nama_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Berikan nama yang jelas dan deskriptif untuk program kerja</div>
                    </div>

                    <!-- Deskripsi Program - Diperluas -->
                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Program <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror d-none" 
                                  id="deskripsi" name="deskripsi" rows="8" required>{{ old('deskripsi') }}</textarea>
                        <div id="program-editor" style="min-height: 200px; border: 1px solid #ced4da; border-radius: 0.375rem;">
                            {!! old('deskripsi', '') !!}
                        </div>
                        @error('deskripsi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Jelaskan detail program, tujuan, target, dan manfaat yang diharapkan</div>
                    </div>

                    <!-- Lokasi - Diperluas -->
                    <div class="mb-4">
                        <label for="lokasi" class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('lokasi') is-invalid @enderror" 
                               id="lokasi" name="lokasi" value="{{ old('lokasi') }}" 
                               placeholder="Masukkan lokasi pelaksanaan program..." required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Sebutkan lokasi lengkap pelaksanaan program</div>
                    </div>
                </form>
            </div>
        </div>
                <!-- Card Panduan -->
        <div class="card shadow-sm border-0 mt-4" style="border-radius: 10px;">
            <div class="card-header bg-info bg-opacity-10 border-bottom-0 p-4" style="border-radius: 10px 10px 0 0;">
            <h6 class="mb-0 fw-semibold text-info">
                <i class="bi bi-info-circle me-2"></i>
                Panduan Program
            </h6>
            </div>
            <div class="card-body p-4" style="border-radius: 0 0 10px 10px;">
            <div class="d-flex align-items-start mb-3">
                <div class="bg-success bg-opacity-20 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; min-width: 32px;">
                <i class="bi bi-lightbulb text-success" style="font-size: 0.9rem;"></i>
                </div>
                <div>
                <strong class="text-success">Perencanaan:</strong> Program masih dalam tahap perencanaan
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <div class="bg-primary bg-opacity-20 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; min-width: 32px;">
                <i class="bi bi-play-circle text-primary" style="font-size: 0.9rem;"></i>
                </div>
                <div>
                <strong class="text-primary">Berjalan:</strong> Program sedang dalam pelaksanaan
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <div class="bg-success bg-opacity-20 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; min-width: 32px;">
                <i class="bi bi-check-circle text-success" style="font-size: 0.9rem;"></i>
                </div>
                <div>
                <strong class="text-success">Selesai:</strong> Program telah selesai dilaksanakan
                </div>
            </div>
            <hr class="my-3">
            <p class="small text-muted mb-0">
                Pastikan semua informasi program diisi dengan lengkap dan akurat untuk memudahkan monitoring dan evaluasi.
            </p>
            </div>
        </div>
    </div>
    
    <!-- Kolom Kanan: Status, Tanggal, Panduan, dan Tombol -->
    <div class="col-lg-5">
        <!-- Card Status dan Tanggal -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary bg-opacity-10 border-bottom-0 p-4">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="bi bi-gear me-2"></i>
                    Pengaturan Program
                </h6>
            </div>
            <div class="card-body p-4">
                <!-- Status Program -->
                <div class="mb-4">
                    <label for="status" class="form-label fw-semibold">Status Program <span class="text-danger">*</span></label>
                    <select class="form-select form-select-lg @error('status') is-invalid @enderror" id="status" name="status" form="program-form" required>
                        <option value="">Pilih Status</option>
                        <option value="Perencanaan" {{ old('status') == 'Perencanaan' ? 'selected' : '' }}>🟡 Perencanaan</option>
                        <option value="Berjalan" {{ old('status') == 'Berjalan' ? 'selected' : '' }}>🔵 Berjalan</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>🟢 Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-4">
                    <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-lg @error('tanggal_mulai') is-invalid @enderror" 
                           id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" form="program-form" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div class="mb-4">
                    <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-lg @error('tanggal_selesai') is-invalid @enderror" 
                           id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" form="program-form" required>
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Card Tombol Aksi -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-grid gap-2">
                    <button type="submit" form="program-form" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle me-2"></i>💾 Simpan Program
                    </button>
                    <a href="{{ route('admin.konten.program.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CKEditor 5 Integration for Program
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
            
            // Set initial content if exists
            const initialContent = document.querySelector('#deskripsi').value;
            if (initialContent) {
                editor.setData(initialContent);
            }
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
            // Fallback to textarea if CKEditor fails
            document.querySelector('#deskripsi').classList.remove('d-none');
            document.querySelector('#program-editor').style.display = 'none';
        });
};
document.head.appendChild(script);

// Form submission handler
document.querySelector('#program-form').addEventListener('submit', function(e) {
    if (programEditorInstance) {
        // Ensure content is synced before submission
        const data = programEditorInstance.getData();
        document.querySelector('#deskripsi').value = data;
        
        // Validate minimum content requirement
        const textContent = data.replace(/<[^>]*>/g, '').trim();
        if (textContent.length < 20) {
            e.preventDefault();
            showNotification('error', 'Deskripsi program harus minimal 20 karakter!');
            return false;
        }
    }
    
    // Show loading notification
    showNotification('info', 'Sedang menyimpan program...', false);
    
    // Disable submit button to prevent double submission
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Menyimpan...';
    submitBtn.disabled = true;
});

// Enhanced notification system
function showNotification(type, message, autoHide = true) {
    // Remove existing notifications
    const existingAlerts = document.querySelectorAll('.alert.custom-notification');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create notification element
    const alertTypes = {
        'success': { class: 'alert-success', icon: 'bi-check-circle-fill' },
        'error': { class: 'alert-danger', icon: 'bi-exclamation-triangle-fill' },
        'warning': { class: 'alert-warning', icon: 'bi-exclamation-triangle-fill' },
        'info': { class: 'alert-info', icon: 'bi-info-circle-fill' }
    };
    
    const alertConfig = alertTypes[type] || alertTypes['info'];
    
    const alertElement = document.createElement('div');
    alertElement.className = `alert ${alertConfig.class} alert-dismissible fade show custom-notification position-fixed`;
    alertElement.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
    
    alertElement.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi ${alertConfig.icon} me-2" style="font-size: 1.1rem;"></i>
            <strong>${message}</strong>
        </div>
        ${autoHide ? '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' : ''}
    `;
    
    // Add to page
    document.body.appendChild(alertElement);
    
    // Auto hide after 5 seconds if enabled
    if (autoHide) {
        setTimeout(() => {
            if (alertElement.parentNode) {
                alertElement.remove();
            }
        }, 5000);
    }
}

// Form validation with notifications
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#program-form');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    // Real-time validation feedback
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
    
    // Date validation
    const tanggalMulai = document.querySelector('#tanggal_mulai');
    const tanggalSelesai = document.querySelector('#tanggal_selesai');
    
    function validateDates() {
        if (tanggalMulai.value && tanggalSelesai.value) {
            const mulai = new Date(tanggalMulai.value);
            const selesai = new Date(tanggalSelesai.value);
            
            if (selesai <= mulai) {
                tanggalSelesai.classList.add('is-invalid');
                showNotification('warning', 'Tanggal selesai harus lebih besar dari tanggal mulai!');
                return false;
            } else {
                tanggalSelesai.classList.remove('is-invalid');
                tanggalSelesai.classList.add('is-valid');
                return true;
            }
        }
        return true;
    }
    
    tanggalMulai.addEventListener('change', validateDates);
    tanggalSelesai.addEventListener('change', validateDates);
    
    // Show welcome notification
    setTimeout(() => {
        showNotification('info', 'Silakan lengkapi form untuk menambah program baru.');
    }, 1000);
});

// Auto-hide alerts after page load
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert:not(.custom-notification)');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 7000);
    });
});
</script>
@endpush
