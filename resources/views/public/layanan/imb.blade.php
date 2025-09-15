@extends('public.layouts.app')

@section('title', 'Permohonan Izin Mendirikan Bangunan (IMB)')

@section('styles')
<style>
/* Custom styles for IMB form */
.form-card {
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border-radius: 12px;
    background: white;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.btn-primary {
    background-color: #d4a574;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #c49660;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(212, 165, 116, 0.2);
}

.upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.2s ease;
    background: #f9fafb;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #f59e0b;
    background: #fffbeb;
}

.upload-area.dragover {
    border-color: #f59e0b;
    background: #fffbeb;
}

.file-item {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: between;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin-bottom: 2rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: #6b7280;
}

.requirement-badge {
    background-color: #d4a574;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.progress-section {
    background: #f8fafc;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.step {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.step-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 12px;
    color: #6b7280;
}

.step.active .step-number {
    background: #f59e0b;
    color: white;
}

.step.completed .step-number {
    background: #10b981;
    color: white;
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.layanan') }}">Layanan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permohonan IMB</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="d-inline-block p-3 rounded-circle mb-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <i class="fas fa-building text-white" style="font-size: 24px;"></i>
        </div>
        <h1 class="h3 fw-bold text-dark mb-2">Permohonan Izin Mendirikan Bangunan (IMB)</h1>
        <p class="text-muted">Lengkapi formulir di bawah ini untuk mengajukan permohonan IMB</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Progress Section -->
            <div class="progress-section">
                <h6 class="fw-semibold mb-3">Progress Pengisian</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="step active" id="step-personal">
                            <div class="step-number">1</div>
                            <span>Data Pribadi</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step" id="step-building">
                            <div class="step-number">2</div>
                            <span>Data Bangunan</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step" id="step-documents">
                            <div class="step-number">3</div>
                            <span>Upload Dokumen</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="form-card p-4">
                <form action="{{ route('public.permohonan.store') }}" method="POST" enctype="multipart/form-data" id="imbForm">
                    @csrf
                    <input type="hidden" name="jenis_layanan" value="permohonan_imb">
                    
                    <!-- Personal Information Section -->
                    <div class="form-section" id="section-personal">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="fas fa-user me-2"></i>Data Pribadi Pemohon
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                       id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Building Information Section -->
                    <div class="form-section d-none" id="section-building">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="fas fa-building me-2"></i>Data Bangunan
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fungsi_bangunan" class="form-label">Fungsi Bangunan <span class="text-danger">*</span></label>
                                <select class="form-select" id="fungsi_bangunan" name="fungsi_bangunan" required>
                                    <option value="">-- Pilih Fungsi Bangunan --</option>
                                    <option value="rumah_tinggal">Rumah Tinggal</option>
                                    <option value="ruko">Ruko/Rukan</option>
                                    <option value="gedung_perkantoran">Gedung Perkantoran</option>
                                    <option value="gedung_perdagangan">Gedung Perdagangan</option>
                                    <option value="gudang">Gudang</option>
                                    <option value="industri">Industri</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jumlah_lantai" class="form-label">Jumlah Lantai <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="jumlah_lantai" 
                                       name="jumlah_lantai" min="1" max="20" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="luas_tanah" class="form-label">Luas Tanah (m²) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="luas_tanah" 
                                       name="luas_tanah" min="1" step="0.01" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="luas_bangunan" class="form-label">Luas Bangunan (m²) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="luas_bangunan" 
                                       name="luas_bangunan" min="1" step="0.01" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_bangunan" class="form-label">Lokasi Bangunan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="lokasi_bangunan" name="lokasi_bangunan" 
                                      rows="3" placeholder="Alamat lengkap lokasi bangunan yang akan didirikan" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Bangunan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="4" maxlength="2000" 
                                      placeholder="Jelaskan detail bangunan yang akan didirikan..." required>{{ old('deskripsi') }}</textarea>
                            <div class="form-text">Maksimal 2000 karakter</div>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Documents Upload Section -->
                    <div class="form-section d-none" id="section-documents">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="fas fa-file-upload me-2"></i>Upload Dokumen Persyaratan
                        </h5>

                        <!-- Document 1: Surat Permohonan -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">1</span> Surat Permohonan <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc1').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Surat Permohonan</p>
                                <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc1" name="documents[]" class="d-none" 
                                   accept=".pdf,.doc,.docx" required>
                            <div id="file1" class="mt-2"></div>
                        </div>

                        <!-- Document 2: KTP Pemohon -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">2</span> Fotocopy KTP Pemohon <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc2').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload KTP Pemohon</p>
                                <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc2" name="documents[]" class="d-none" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div id="file2" class="mt-2"></div>
                        </div>

                        <!-- Document 3: Sertifikat Tanah -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">3</span> Fotocopy Sertifikat Tanah <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc3').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Sertifikat Tanah</p>
                                <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc3" name="documents[]" class="d-none" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div id="file3" class="mt-2"></div>
                        </div>

                        <!-- Document 4: Gambar Rencana -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">4</span> Gambar Rencana Bangunan <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc4').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Gambar Rencana</p>
                                <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc4" name="documents[]" class="d-none" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div id="file4" class="mt-2"></div>
                        </div>

                        <!-- Document 5: Perhitungan Struktur -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">5</span> Perhitungan Struktur
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc5').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Perhitungan Struktur</p>
                                <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 5MB) - Opsional untuk bangunan 1 lantai</p>
                            </div>
                            <input type="file" id="doc5" name="documents[]" class="d-none" 
                                   accept=".pdf,.doc,.docx">
                            <div id="file5" class="mt-2"></div>
                        </div>

                        <!-- Document 6: Surat Pernyataan Tetangga -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">6</span> Surat Pernyataan Tidak Keberatan Tetangga <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc6').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Surat Pernyataan</p>
                                <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc6" name="documents[]" class="d-none" 
                                   accept=".pdf,.doc,.docx" required>
                            <div id="file6" class="mt-2"></div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" id="prevBtn" style="display: none;">
                            <i class="fas fa-arrow-left me-2"></i>Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary" id="nextBtn">
                            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                            <i class="fas fa-paper-plane me-2"></i>Ajukan Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;
    
    const sections = document.querySelectorAll('.form-section');
    const steps = document.querySelectorAll('.step');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('imbForm');

    // File upload handlers
    function setupFileUpload(inputId, displayId) {
        const input = document.getElementById(inputId);
        const display = document.getElementById(displayId);
        
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileIcon = getFileIcon(file.type);
                
                display.innerHTML = `
                    <div class="file-item">
                        <div class="d-flex align-items-center flex-grow-1">
                            <i class="${fileIcon} me-2"></i>
                            <div>
                                <div class="fw-medium">${file.name}</div>
                                <small class="text-muted">${fileSize} MB</small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile('${inputId}', '${displayId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            }
        });
    }

    // Setup all file uploads
    for (let i = 1; i <= 6; i++) {
        setupFileUpload(`doc${i}`, `file${i}`);
    }

    // Remove file function
    window.removeFile = function(inputId, displayId) {
        document.getElementById(inputId).value = '';
        document.getElementById(displayId).innerHTML = '';
    };

    // Get file icon
    function getFileIcon(fileType) {
        if (fileType.includes('pdf')) return 'fas fa-file-pdf text-danger';
        if (fileType.includes('word') || fileType.includes('document')) return 'fas fa-file-word text-primary';
        if (fileType.includes('image')) return 'fas fa-file-image text-success';
        return 'fas fa-file text-secondary';
    }

    // Step navigation
    function showStep(step) {
        // Hide all sections
        sections.forEach(section => section.classList.add('d-none'));
        
        // Show current section
        document.getElementById(`section-${getStepName(step)}`).classList.remove('d-none');
        
        // Update step indicators
        steps.forEach((stepEl, index) => {
            stepEl.classList.remove('active', 'completed');
            if (index + 1 < step) {
                stepEl.classList.add('completed');
            } else if (index + 1 === step) {
                stepEl.classList.add('active');
            }
        });
        
        // Update buttons
        prevBtn.style.display = step > 1 ? 'block' : 'none';
        nextBtn.style.display = step < totalSteps ? 'block' : 'none';
        submitBtn.style.display = step === totalSteps ? 'block' : 'none';
    }

    function getStepName(step) {
        const stepNames = ['personal', 'building', 'documents'];
        return stepNames[step - 1];
    }

    // Validation functions
    function validatePersonalInfo() {
        const required = ['nama', 'nik', 'email', 'telepon', 'alamat'];
        return required.every(field => {
            const input = document.getElementById(field);
            return input && input.value.trim() !== '';
        });
    }

    function validateBuildingInfo() {
        const required = ['fungsi_bangunan', 'jumlah_lantai', 'luas_tanah', 'luas_bangunan', 'lokasi_bangunan', 'deskripsi'];
        return required.every(field => {
            const input = document.getElementById(field);
            return input && input.value.trim() !== '';
        });
    }

    function validateDocuments() {
        const requiredDocs = ['doc1', 'doc2', 'doc3', 'doc4', 'doc6'];
        return requiredDocs.every(docId => {
            const input = document.getElementById(docId);
            return input && input.files.length > 0;
        });
    }

    // Navigation event listeners
    nextBtn.addEventListener('click', function() {
        let isValid = false;
        
        if (currentStep === 1) {
            isValid = validatePersonalInfo();
            if (!isValid) {
                alert('Mohon lengkapi semua data pribadi yang diperlukan.');
                return;
            }
        } else if (currentStep === 2) {
            isValid = validateBuildingInfo();
            if (!isValid) {
                alert('Mohon lengkapi semua data bangunan yang diperlukan.');
                return;
            }
        }
        
        if (isValid && currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateDocuments()) {
            alert('Mohon upload semua dokumen yang diperlukan.');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        
        // Create FormData
        const formData = new FormData(form);
        
        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);
            
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Server response:', text);
                    throw new Error(`Server error: ${response.status} - ${text.substring(0, 200)}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Success response:', data);
            if (data.success) {
                alert('Permohonan IMB berhasil diajukan! Nomor permohonan: ' + data.nomor_permohonan);
                window.location.href = data.redirect || '/';
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            let errorMessage = 'Terjadi kesalahan saat mengirim permohonan.';
            if (error.message.includes('Server error')) {
                errorMessage += ' Detail: ' + error.message;
            } else {
                errorMessage += ' Silakan coba lagi.';
            }
            alert(errorMessage);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Ajukan Permohonan';
        });
    });

    // Input validations
    document.getElementById('nik').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });

    document.getElementById('telepon').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9+]/g, '');
    });

    // Initialize
    showStep(currentStep);
});
</script>
@endpush
