@extends('public.layouts.app')

@section('title', 'Permohonan Advice Planning (Saran Perencanaan)')

@section('styles')
    <style>
        /* Custom styles for Advice Planning form */
        .form-card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            background: white;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
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

        .breadcrumb-item+.breadcrumb-item::before {
            content: ">";
            color: #6b7280;
        }

        .requirement-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            background: #d97706;
            color: white;
        }

        .info-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .consultation-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            background: #fafafa;
        }

        .consultation-header {
            background: #f59e0b;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .priority-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 8px;
        }

        .priority-low {
            background: #dcfce7;
            color: #166534;
        }

        .priority-medium {
            background: #fef3c7;
            color: #92400e;
        }

        .priority-high {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Advice Planning</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="d-inline-block p-3 rounded-circle mb-3"
                style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="fas fa-lightbulb text-white" style="font-size: 24px;"></i>
            </div>
            <h1 class="h3 fw-bold text-dark mb-2">Permohonan Advice Planning</h1>
            <p class="text-muted">Konsultasi dan Saran Perencanaan Pembangunan</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Info Box -->
                <div class="info-box">
                    <h6 class="fw-bold text-warning mb-2">
                        <i class="fas fa-info-circle me-2"></i>Tentang Advice Planning
                    </h6>
                    <p class="mb-0 small">
                        Layanan konsultasi dan pemberian saran teknis untuk perencanaan pembangunan infrastruktur, bangunan
                        gedung, dan tata ruang. Dapatkan panduan profesional dari ahli perencanaan untuk memastikan proyek
                        Anda sesuai dengan standar dan regulasi yang berlaku.
                    </p>
                </div>

                <!-- Progress Section -->
                <div class="progress-section">
                    <h6 class="fw-semibold mb-3">Progress Pengisian</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="step active" id="step-personal">
                                <div class="step-number">1</div>
                                <span>Data Pemohon</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="step" id="step-consultation">
                                <div class="step-number">2</div>
                                <span>Detail Konsultasi</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="step" id="step-project">
                                <div class="step-number">3</div>
                                <span>Data Proyek</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="step" id="step-documents">
                                <div class="step-number">4</div>
                                <span>Dokumen</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="form-card p-4">
                    <form action="{{ route('public.permohonan.store') }}" method="POST" enctype="multipart/form-data"
                        id="adviceForm">
                        @csrf
                        <input type="hidden" name="jenis_layanan" value="permohonan_advice_planning">

                        <!-- Personal Information Section -->
                        <div class="form-section" id="section-personal">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-user me-2"></i>Data Pemohon
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jabatan" class="form-label">Jabatan/Profesi <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        placeholder="Arsitek, Kontraktor, Developer, dll." required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="instansi" class="form-label">Nama Instansi/Perusahaan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="instansi" name="instansi" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis_instansi" class="form-label">Jenis Instansi <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_instansi" name="jenis_instansi" required>
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        <option value="pemerintah">Instansi Pemerintah</option>
                                        <option value="swasta">Perusahaan Swasta</option>
                                        <option value="bumn">BUMN/BUMD</option>
                                        <option value="konsultan">Konsultan</option>
                                        <option value="kontraktor">Kontraktor</option>
                                        <option value="developer">Developer</option>
                                        <option value="lsm">LSM/Yayasan</option>
                                        <option value="perorangan">Perorangan</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telepon" class="form-label">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('telepon') is-invalid @enderror"
                                        id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                    required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Consultation Details Section -->
                        <div class="form-section d-none" id="section-consultation">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-comments me-2"></i>Detail Konsultasi
                            </h5>

                            <div class="consultation-card">
                                <div class="consultation-header">Jenis Konsultasi</div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_konsultasi" class="form-label">Kategori Konsultasi <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_konsultasi" name="jenis_konsultasi"
                                            required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="perencanaan_bangunan">Perencanaan Bangunan Gedung</option>
                                            <option value="perencanaan_infrastruktur">Perencanaan Infrastruktur</option>
                                            <option value="tata_ruang">Perencanaan Tata Ruang</option>
                                            <option value="review_desain">Review Desain</option>
                                            <option value="kelayakan_teknis">Studi Kelayakan Teknis</option>
                                            <option value="standar_konstruksi">Standar & Spesifikasi Konstruksi</option>
                                            <option value="perizinan">Konsultasi Perizinan</option>
                                            <option value="renovasi">Perencanaan Renovasi</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="prioritas" class="form-label">Tingkat Prioritas <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="prioritas" name="prioritas" required>
                                            <option value="">-- Pilih Prioritas --</option>
                                            <option value="rendah">Rendah - Konsultasi Umum</option>
                                            <option value="sedang">Sedang - Proyek dalam Perencanaan</option>
                                            <option value="tinggi">Tinggi - Proyek Mendesak</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="metode_konsultasi" class="form-label">Metode Konsultasi <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="metode_konsultasi" name="metode_konsultasi"
                                            required>
                                            <option value="">-- Pilih Metode --</option>
                                            <option value="tatap_muka">Tatap Muka di Kantor</option>
                                            <option value="online">Video Conference</option>
                                            <option value="survei_lapangan">Survei Lapangan</option>
                                            <option value="presentasi">Presentasi</option>
                                            <option value="workshop">Workshop/Diskusi Kelompok</option>
                                            <option value="email">Konsultasi via Email</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="estimasi_durasi" class="form-label">Estimasi Durasi Konsultasi</label>
                                        <select class="form-select" id="estimasi_durasi" name="estimasi_durasi">
                                            <option value="">-- Pilih Durasi --</option>
                                            <option value="1_jam">1 Jam</option>
                                            <option value="2_jam">2 Jam</option>
                                            <option value="setengah_hari">Setengah Hari (4 Jam)</option>
                                            <option value="sehari_penuh">Sehari Penuh (8 Jam)</option>
                                            <option value="multi_hari">Multi Hari</option>
                                            <option value="ongoing">Berkelanjutan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="masalah_dihadapi" class="form-label">Masalah/Tantangan yang Dihadapi <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="masalah_dihadapi" name="masalah_dihadapi" rows="4" maxlength="2000"
                                        placeholder="Jelaskan secara detail masalah, tantangan, atau aspek yang ingin dikonsultasikan..." required></textarea>
                                    <div class="form-text">Maksimal 2000 karakter</div>
                                </div>

                                <div class="mb-3">
                                    <label for="solusi_diharapkan" class="form-label">Solusi/Hasil yang Diharapkan <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="solusi_diharapkan" name="solusi_diharapkan" rows="3" maxlength="1500"
                                        placeholder="Jelaskan solusi atau hasil konsultasi yang diharapkan..." required></textarea>
                                    <div class="form-text">Maksimal 1500 karakter</div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Information Section -->
                        <div class="form-section d-none" id="section-project">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-building me-2"></i>Data Proyek (Opsional)
                            </h5>

                            <div class="consultation-card">
                                <div class="consultation-header">Informasi Proyek</div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_proyek" class="form-label">Nama Proyek</label>
                                        <input type="text" class="form-control" id="nama_proyek" name="nama_proyek">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_proyek" class="form-label">Jenis Proyek</label>
                                        <select class="form-select" id="jenis_proyek" name="jenis_proyek">
                                            <option value="">-- Pilih Jenis Proyek --</option>
                                            <option value="rumah_tinggal">Rumah Tinggal</option>
                                            <option value="ruko">Ruko/Rukan</option>
                                            <option value="gedung_perkantoran">Gedung Perkantoran</option>
                                            <option value="gedung_komersial">Gedung Komersial</option>
                                            <option value="industri">Bangunan Industri</option>
                                            <option value="pendidikan">Fasilitas Pendidikan</option>
                                            <option value="kesehatan">Fasilitas Kesehatan</option>
                                            <option value="infrastruktur">Infrastruktur Jalan/Jembatan</option>
                                            <option value="pengairan">Sistem Pengairan/Drainase</option>
                                            <option value="perumahan">Kawasan Perumahan</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tahap_proyek" class="form-label">Tahap Proyek Saat Ini</label>
                                        <select class="form-select" id="tahap_proyek" name="tahap_proyek">
                                            <option value="">-- Pilih Tahap --</option>
                                            <option value="konsep_awal">Konsep Awal</option>
                                            <option value="pra_desain">Pra Desain</option>
                                            <option value="desain_skematik">Desain Skematik</option>
                                            <option value="pengembangan_desain">Pengembangan Desain</option>
                                            <option value="detail_desain">Detail Desain</option>
                                            <option value="dokumen_konstruksi">Dokumen Konstruksi</option>
                                            <option value="perizinan">Proses Perizinan</option>
                                            <option value="konstruksi">Tahap Konstruksi</option>
                                            <option value="selesai">Proyek Selesai</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nilai_proyek" class="form-label">Perkiraan Nilai Proyek (Rp)</label>
                                        <input type="text" class="form-control" id="nilai_proyek" name="nilai_proyek"
                                            placeholder="Contoh: 500000000">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="lokasi_proyek" class="form-label">Lokasi Proyek</label>
                                        <input type="text" class="form-control" id="lokasi_proyek"
                                            name="lokasi_proyek" placeholder="Alamat atau lokasi proyek">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="luas_lahan" class="form-label">Luas Lahan/Area (m²)</label>
                                        <input type="number" class="form-control" id="luas_lahan" name="luas_lahan"
                                            step="0.01" min="0" placeholder="Contoh: 500">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi_proyek" class="form-label">Deskripsi Singkat Proyek</label>
                                    <textarea class="form-control" id="deskripsi_proyek" name="deskripsi_proyek" rows="3" maxlength="1000"
                                        placeholder="Jelaskan gambaran umum proyek..."></textarea>
                                    <div class="form-text">Maksimal 1000 karakter</div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Upload Section -->
                        <div class="form-section d-none" id="section-documents">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-file-upload me-2"></i>Upload Dokumen Pendukung
                            </h5>

                            <!-- Document 1: Surat Permohonan -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">1</span> Surat Permohonan Konsultasi <span
                                        class="text-danger">*</span>
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

                            <!-- Document 2: KTP/Identitas -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">2</span> Fotocopy KTP/Identitas Pemohon <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc2').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload KTP/Identitas</p>
                                    <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                                </div>
                                <input type="file" id="doc2" name="documents[]" class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png" required>
                                <div id="file2" class="mt-2"></div>
                            </div>

                            <!-- Document 3: Profil Perusahaan -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">3</span> Profil Perusahaan/Instansi
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc3').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Profil Perusahaan</p>
                                    <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 10MB)</p>
                                </div>
                                <input type="file" id="doc3" name="documents[]" class="d-none"
                                    accept=".pdf,.doc,.docx">
                                <div id="file3" class="mt-2"></div>
                            </div>

                            <!-- Document 4: Dokumen Teknis -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">4</span> Dokumen Teknis Proyek (jika ada)
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc4').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Dokumen Teknis</p>
                                    <p class="text-muted small">Format: PDF, CAD, JPG, PNG (Max: 20MB)</p>
                                </div>
                                <input type="file" id="doc4" name="documents[]" class="d-none"
                                    accept=".pdf,.dwg,.dxf,.jpg,.jpeg,.png">
                                <div id="file4" class="mt-2"></div>
                            </div>

                            <!-- Document 5: Gambar/Foto -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">5</span> Gambar/Foto Kondisi Existing (jika ada)
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc5').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Gambar/Foto</p>
                                    <p class="text-muted small">Format: JPG, PNG, PDF (Max: 10MB)</p>
                                </div>
                                <input type="file" id="doc5" name="documents[]" class="d-none"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <div id="file5" class="mt-2"></div>
                            </div>

                            <!-- Document 6: TOR -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">6</span> Terms of Reference (TOR) - jika ada
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc6').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload TOR</p>
                                    <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 10MB)</p>
                                </div>
                                <input type="file" id="doc6" name="documents[]" class="d-none"
                                    accept=".pdf,.doc,.docx">
                                <div id="file6" class="mt-2"></div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" id="prevBtn"
                                style="display: none;">
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
            const totalSteps = 4;

            const sections = document.querySelectorAll('.form-section');
            const steps = document.querySelectorAll('.step');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('adviceForm');

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
                if (fileType.includes('word') || fileType.includes('document'))
                return 'fas fa-file-word text-primary';
                if (fileType.includes('image')) return 'fas fa-file-image text-success';
                if (fileType.includes('cad') || fileType.includes('dwg')) return 'fas fa-file-code text-warning';
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
                const stepNames = ['personal', 'consultation', 'project', 'documents'];
                return stepNames[step - 1];
            }

            // Validation functions
            function validatePersonalInfo() {
                const required = ['nama', 'jabatan', 'instansi', 'jenis_instansi', 'email', 'telepon', 'alamat'];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateConsultationInfo() {
                const required = ['jenis_konsultasi', 'prioritas', 'metode_konsultasi', 'masalah_dihadapi',
                    'solusi_diharapkan'
                ];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateDocuments() {
                const requiredDocs = ['doc1', 'doc2']; // Only doc1 and doc2 are required
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
                        alert('Mohon lengkapi semua data pemohon yang diperlukan.');
                        return;
                    }
                } else if (currentStep === 2) {
                    isValid = validateConsultationInfo();
                    if (!isValid) {
                        alert('Mohon lengkapi semua detail konsultasi yang diperlukan.');
                        return;
                    }
                } else if (currentStep === 3) {
                    isValid = true; // Project info is optional
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
                    alert('Mohon upload dokumen yang diperlukan (Surat Permohonan dan KTP/Identitas).');
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
                            alert('Permohonan Advice Planning berhasil diajukan! Nomor permohonan: ' +
                                data.nomor_permohonan);
                            window.location.href = data.redirect || '/';
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim permohonan. Silakan coba lagi.');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML =
                        '<i class="fas fa-paper-plane me-2"></i>Ajukan Permohonan';
                    });
            });

            // Input validations
            document.getElementById('telepon').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+]/g, '');
            });

            document.getElementById('nilai_proyek').addEventListener('input', function() {
                // Format currency
                let value = this.value.replace(/[^0-9]/g, '');
                if (value) {
                    this.value = parseInt(value).toLocaleString('id-ID');
                }
            });

            document.getElementById('luas_lahan').addEventListener('input', function() {
                if (this.value < 0) this.value = 0;
            });

            // Priority badge display
            document.getElementById('prioritas').addEventListener('change', function() {
                const priorityText = this.selectedOptions[0].text;
                // You can add visual feedback here if needed
            });

            // Character count for textareas
            function setupCharacterCount(textareaId, maxLength) {
                const textarea = document.getElementById(textareaId);
                if (textarea) {
                    textarea.addEventListener('input', function() {
                        const remaining = maxLength - this.value.length;
                        const counter = this.parentElement.querySelector('.form-text');
                        if (counter) {
                            counter.textContent = `${remaining} karakter tersisa`;
                            if (remaining < 100) {
                                counter.style.color = '#dc3545';
                            } else {
                                counter.style.color = '#6c757d';
                            }
                        }
                    });
                }
            }

            setupCharacterCount('masalah_dihadapi', 2000);
            setupCharacterCount('solusi_diharapkan', 1500);
            setupCharacterCount('deskripsi_proyek', 1000);

            // Initialize
            showStep(currentStep);
        });
    </script>
@endpush
