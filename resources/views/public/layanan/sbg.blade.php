@extends('public.layouts.app')

@section('title', 'Permohonan Surat Bukti Gangguan (SBG)')

@section('styles')
<style>
/* Custom styles for SBG form */
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
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.btn-primary {
    background-color: #6b9080;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #5a7a6b;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(107, 144, 128, 0.2);
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
    border-color: #10b981;
    background: #f0fdf4;
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
    background-color: #6b9080;
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
    background: #10b981;
    color: white;
}

.step.completed .step-number {
    background: #059669;
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
            <li class="breadcrumb-item active" aria-current="page">Permohonan SBG</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="d-inline-block p-3 rounded-circle mb-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="fas fa-store text-white" style="font-size: 24px;"></i>
        </div>
        <h1 class="h3 fw-bold text-dark mb-2">Permohonan Surat Bukti Gangguan (SBG)</h1>
        <p class="text-muted">Lengkapi formulir di bawah ini untuk mengajukan permohonan SBG</p>
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
                        <div class="step" id="step-business">
                            <div class="step-number">2</div>
                            <span>Data Usaha</span>
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
                <form action="{{ route('public.permohonan.store') }}" method="POST" enctype="multipart/form-data" id="sbgForm">
                    @csrf
                    <input type="hidden" name="jenis_layanan" value="permohonan_sbg">
                    
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

                    <!-- Business Information Section -->
                    <div class="form-section d-none" id="section-business">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="fas fa-store me-2"></i>Data Usaha
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_usaha" class="form-label">Nama Usaha/Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis_usaha" class="form-label">Jenis Usaha <span class="text-danger">*</span></label>
                                <select class="form-select" id="jenis_usaha" name="jenis_usaha" required>
                                    <option value="">-- Pilih Jenis Usaha --</option>
                                    <option value="perdagangan">Perdagangan</option>
                                    <option value="jasa">Jasa</option>
                                    <option value="industri_kecil">Industri Kecil</option>
                                    <option value="industri_menengah">Industri Menengah</option>
                                    <option value="makanan_minuman">Makanan & Minuman</option>
                                    <option value="transportasi">Transportasi</option>
                                    <option value="konstruksi">Konstruksi</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="npwp" class="form-label">NPWP Perusahaan</label>
                                <input type="text" class="form-control" id="npwp" name="npwp" 
                                       placeholder="15 digit nomor NPWP">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jumlah_karyawan" class="form-label">Jumlah Karyawan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="jumlah_karyawan" 
                                       name="jumlah_karyawan" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat_usaha" class="form-label">Alamat Usaha <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="alamat_usaha" name="alamat_usaha" 
                                      rows="3" placeholder="Alamat lengkap lokasi usaha" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Kegiatan Usaha <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="4" maxlength="2000" 
                                      placeholder="Jelaskan detail kegiatan usaha yang dilakukan..." required>{{ old('deskripsi') }}</textarea>
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

                        <!-- Document 3: Akta Pendirian -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">3</span> Fotocopy Akta Pendirian Perusahaan <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc3').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Akta Pendirian</p>
                                <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc3" name="documents[]" class="d-none" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div id="file3" class="mt-2"></div>
                        </div>

                        <!-- Document 4: Domisili Usaha -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">4</span> Surat Keterangan Domisili Usaha <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc4').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Surat Domisili</p>
                                <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc4" name="documents[]" class="d-none" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div id="file4" class="mt-2"></div>
                        </div>

                        <!-- Document 5: Denah Lokasi -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">5</span> Denah Lokasi Usaha <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('doc5').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik untuk upload Denah Lokasi</p>
                                <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            <input type="file" id="doc5" name="documents[]" class="d-none" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div id="file5" class="mt-2"></div>
                        </div>

                        <!-- Document 6: Surat Pernyataan -->
                        <div class="mb-4">
                            <label class="form-label">
                                <span class="requirement-badge">6</span> Surat Pernyataan Tidak Mengganggu Lingkungan <span class="text-danger">*</span>
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
    const form = document.getElementById('sbgForm');

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
        const stepNames = ['personal', 'business', 'documents'];
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

    function validateBusinessInfo() {
        const required = ['nama_usaha', 'jenis_usaha', 'jumlah_karyawan', 'alamat_usaha', 'deskripsi'];
        return required.every(field => {
            const input = document.getElementById(field);
            return input && input.value.trim() !== '';
        });
    }

    function validateDocuments() {
        const requiredDocs = ['doc1', 'doc2', 'doc3', 'doc4', 'doc5', 'doc6'];
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
                showNotificationModal('error', 'Mohon lengkapi semua data pribadi yang diperlukan.');
                return;
            }
        } else if (currentStep === 2) {
            isValid = validateBusinessInfo();
            if (!isValid) {
                showNotificationModal('error', 'Mohon lengkapi semua data usaha yang diperlukan.');
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
            showNotificationModal('error', 'Mohon upload semua dokumen yang diperlukan.');
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
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotificationModal('success', 'Permohonan SBG berhasil diajukan! Nomor permohonan: ' + data.nomor_permohonan, function() {
                    window.location.href = data.redirect || '/';
                });
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotificationModal('error', 'Terjadi kesalahan saat mengirim permohonan. Silakan coba lagi.');
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

    document.getElementById('npwp').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 15) {
            this.value = this.value.slice(0, 15);
        }
    });

    // Initialize
    showStep(currentStep);

    // Enhanced Notification Modal Function
    function showNotificationModal(type, message, callback = null) {
        const modal = document.getElementById('notificationModal') || createNotificationModal();
        const title = modal.querySelector('#notificationTitle');
        const body = modal.querySelector('#notificationMessage');
        const icon = modal.querySelector('.notification-icon-container');
        const button = modal.querySelector('#notificationButton');
        
        // Icon and color mapping
        const typeConfig = {
            success: { icon: 'fas fa-check-circle', color: '#10b981', title: 'Berhasil!' },
            error: { icon: 'fas fa-exclamation-circle', color: '#ef4444', title: 'Oops!' },
            warning: { icon: 'fas fa-exclamation-triangle', color: '#f59e0b', title: 'Perhatian!' },
            info: { icon: 'fas fa-info-circle', color: '#3b82f6', title: 'Informasi' }
        };
        
        const config = typeConfig[type] || typeConfig.info;
        
        // Update modal content
        title.textContent = config.title;
        body.textContent = message;
        icon.style.backgroundColor = config.color;
        icon.innerHTML = `<i class="${config.icon}" style="color: white; font-size: 2.5rem;"></i>`;
        button.style.backgroundColor = config.color;
        
        // Store callback
        modal._callback = callback;
        
        // Show modal
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }
    
    function createNotificationModal() {
        const modalHTML = `
            <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-body text-center p-5">
                            <div class="notification-icon-container rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            </div>
                            <h4 class="modal-title fw-bold mb-3" id="notificationTitle"></h4>
                            <p class="text-muted mb-4" id="notificationMessage"></p>
                            <button type="button" class="btn btn-primary px-4 py-2" id="notificationButton" data-bs-dismiss="modal">
                                <i class="fas fa-check me-2"></i>OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        const modal = document.getElementById('notificationModal');
        
        // Add event listener for callback execution
        modal.addEventListener('hidden.bs.modal', function() {
            if (modal._callback && typeof modal._callback === 'function') {
                modal._callback();
                modal._callback = null;
            }
        });
        
        return modal;
    }
});
</script>

@push('styles')
<style>
/* Enhanced Notification Modal Styles */
#notificationModal .modal-content {
    animation: modalSlideIn 0.3s ease-out;
    backdrop-filter: blur(10px);
}

#notificationModal .modal-backdrop {
    background: rgba(0, 0, 0, 0.6);
}

.notification-icon-container {
    animation: iconBounce 0.6s ease-out;
    position: relative;
}

.notification-icon-container::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: inherit;
    opacity: 0.3;
    animation: iconPulse 2s infinite;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

@keyframes iconBounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0, 0, 0);
    }
    40%, 43% {
        transform: translate3d(0, -10px, 0);
    }
    70% {
        transform: translate3d(0, -5px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

@keyframes iconPulse {
    0% {
        transform: scale(1);
        opacity: 0.3;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.1;
    }
    100% {
        transform: scale(1.2);
        opacity: 0;
    }
}

#notificationModal .btn {
    transition: all 0.3s ease;
}

#notificationModal .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

@media (max-width: 768px) {
    #notificationModal .modal-dialog {
        margin: 1rem;
    }
    
    .notification-icon-container {
        width: 60px !important;
        height: 60px !important;
    }
    
    .notification-icon-container i {
        font-size: 2rem !important;
    }
}
</style>
@endpush
@endpush
