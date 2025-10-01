@extends('public.layouts.app')

@section('title', 'Permohonan RTBL (Rencana Tata Bangunan dan Lingkungan)')

@section('styles')
    <style>
        /* Custom styles for RTBL form */
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
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .btn-primary {
            background-color: #8b7ec8;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #7a6db3;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(139, 126, 200, 0.2);
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
            border-color: #7c3aed;
            background: #f3f4f6;
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
            background-color: #8b7ec8;
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
            background: #7c3aed;
            color: white;
        }

        .step.completed .step-number {
            background: #5b21b6;
            color: white;
        }

        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .zone-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            background: #fafafa;
        }

        .zone-header {
            background: #7c3aed;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">RTBL</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="d-inline-block p-3 rounded-circle mb-3"
                style="background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);">
                <i class="fas fa-city text-white" style="font-size: 24px;"></i>
            </div>
            <h1 class="h3 fw-bold text-dark mb-2">Permohonan RTBL</h1>
            <p class="text-muted">Rencana Tata Bangunan dan Lingkungan</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Info Box -->
                <div class="info-box">
                    <h6 class="fw-bold text-primary mb-2">
                        <i class="fas fa-info-circle me-2"></i>Tentang RTBL
                    </h6>
                    <p class="mb-0 small">
                        RTBL adalah pedoman rancang bangun suatu lingkungan/kawasan yang dimaksudkan untuk mengendalikan
                        pemanfaatan ruang, penataan bangunan dan lingkungan, serta memuat materi pokok ketentuan program
                        bangunan dan lingkungan, rencana umum dan panduan rancangan, rencana investasi, ketentuan
                        pengendalian rencana, dan pedoman pengendalian pelaksanaan pembangunan.
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
                            <div class="step" id="step-project">
                                <div class="step-number">2</div>
                                <span>Data Proyek</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="step" id="step-location">
                                <div class="step-number">3</div>
                                <span>Lokasi & Area</span>
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
                        id="rtblForm">
                        @csrf
                        <input type="hidden" name="jenis_layanan" value="permohonan_rtbl">

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
                                    <label for="jabatan" class="form-label">Jabatan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        placeholder="Direktur, Arsitek, Perencana, dll." required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="instansi" class="form-label">Nama Instansi/Perusahaan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="instansi" name="instansi" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sertifikat_ahli" class="form-label">Nomor Sertifikat Keahlian</label>
                                    <input type="text" class="form-control" id="sertifikat_ahli" name="sertifikat_ahli"
                                        placeholder="Nomor sertifikat dari LPJK/INKINDO">
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

                        <!-- Project Information Section -->
                        <div class="form-section d-none" id="section-project">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-building me-2"></i>Data Proyek RTBL
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_proyek" class="form-label">Nama Proyek/Kawasan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_proyek" name="nama_proyek"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kawasan" class="form-label">Jenis Kawasan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_kawasan" name="jenis_kawasan" required>
                                        <option value="">-- Pilih Jenis Kawasan --</option>
                                        <option value="perumahan">Kawasan Perumahan</option>
                                        <option value="komersial">Kawasan Komersial</option>
                                        <option value="perkantoran">Kawasan Perkantoran</option>
                                        <option value="industri">Kawasan Industri</option>
                                        <option value="campuran">Kawasan Campuran</option>
                                        <option value="wisata">Kawasan Wisata</option>
                                        <option value="pendidikan">Kawasan Pendidikan</option>
                                        <option value="kesehatan">Kawasan Kesehatan</option>
                                        <option value="olahraga">Kawasan Olahraga</option>
                                        <option value="transportasi">Kawasan Transportasi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="luas_kawasan" class="form-label">Luas Kawasan (Ha) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="luas_kawasan" name="luas_kawasan"
                                        step="0.01" min="0" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nilai_investasi" class="form-label">Perkiraan Nilai Investasi (Rp)</label>
                                    <input type="text" class="form-control" id="nilai_investasi"
                                        name="nilai_investasi" placeholder="Contoh: 50000000000">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="target_mulai" class="form-label">Target Mulai Pembangunan</label>
                                    <input type="date" class="form-control" id="target_mulai" name="target_mulai">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="target_selesai" class="form-label">Target Selesai Pembangunan</label>
                                    <input type="date" class="form-control" id="target_selesai"
                                        name="target_selesai">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_proyek" class="form-label">Deskripsi Proyek <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="deskripsi_proyek" name="deskripsi_proyek" rows="4" maxlength="3000"
                                    placeholder="Jelaskan konsep, tujuan, dan gambaran umum proyek RTBL..." required></textarea>
                                <div class="form-text">Maksimal 3000 karakter</div>
                            </div>
                        </div>

                        <!-- Location & Area Section -->
                        <div class="form-section d-none" id="section-location">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-map-marker-alt me-2"></i>Lokasi & Area Perencanaan
                            </h5>

                            <!-- Zone Information -->
                            <div class="zone-card">
                                <div class="zone-header">Informasi Lokasi</div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="provinsi" class="form-label">Provinsi <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="provinsi" name="provinsi"
                                            value="Kalimantan Selatan" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="kabupaten" class="form-label">Kabupaten/Kota <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="kabupaten" name="kabupaten" required>
                                            <option value="">-- Pilih Kabupaten/Kota --</option>
                                            <option value="banjarmasin">Kota Banjarmasin</option>
                                            <option value="banjarbaru">Kota Banjarbaru</option>
                                            <option value="banjar">Kabupaten Banjar</option>
                                            <option value="barito_kuala">Kabupaten Barito Kuala</option>
                                            <option value="tanah_laut">Kabupaten Tanah Laut</option>
                                            <option value="kotabaru">Kabupaten Kotabaru</option>
                                            <option value="tanah_bumbu">Kabupaten Tanah Bumbu</option>
                                            <option value="balangan">Kabupaten Balangan</option>
                                            <option value="tapin">Kabupaten Tapin</option>
                                            <option value="hulu_sungai_selatan">Kabupaten Hulu Sungai Selatan</option>
                                            <option value="hulu_sungai_tengah">Kabupaten Hulu Sungai Tengah</option>
                                            <option value="hulu_sungai_utara">Kabupaten Hulu Sungai Utara</option>
                                            <option value="tabalong">Kabupaten Tabalong</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kecamatan" class="form-label">Kecamatan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                            required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="kelurahan" class="form-label">Kelurahan/Desa <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="kelurahan" name="kelurahan"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat_lengkap" class="form-label">Alamat Lengkap Lokasi <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3"
                                        placeholder="Alamat lengkap beserta patokan/landmark" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="koordinat_lat" class="form-label">Koordinat Latitude</label>
                                        <input type="text" class="form-control" id="koordinat_lat"
                                            name="koordinat_lat" placeholder="-3.325000">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="koordinat_lng" class="form-label">Koordinat Longitude</label>
                                        <input type="text" class="form-control" id="koordinat_lng"
                                            name="koordinat_lng" placeholder="114.590000">
                                    </div>
                                </div>
                            </div>

                            <!-- Land Status -->
                            <div class="zone-card">
                                <div class="zone-header">Status Tanah & Kepemilikan</div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status_tanah" class="form-label">Status Kepemilikan Tanah <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="status_tanah" name="status_tanah" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="hak_milik">Hak Milik (SHM)</option>
                                            <option value="hak_guna_usaha">Hak Guna Usaha (HGU)</option>
                                            <option value="hak_guna_bangunan">Hak Guna Bangunan (HGB)</option>
                                            <option value="hak_pakai">Hak Pakai</option>
                                            <option value="wakaf">Tanah Wakaf</option>
                                            <option value="negara">Tanah Negara</option>
                                            <option value="adat">Tanah Adat</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nomor_sertifikat" class="form-label">Nomor Sertifikat/Dokumen</label>
                                        <input type="text" class="form-control" id="nomor_sertifikat"
                                            name="nomor_sertifikat">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="pemilik_tanah" class="form-label">Nama Pemilik Tanah <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pemilik_tanah" name="pemilik_tanah"
                                        required>
                                </div>
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
                                    <span class="requirement-badge">1</span> Surat Permohonan RTBL <span
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

                            <!-- Document 3: Surat Kuasa -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">3</span> Surat Kuasa (jika dikuasakan)
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc3').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Surat Kuasa</p>
                                    <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 5MB)</p>
                                </div>
                                <input type="file" id="doc3" name="documents[]" class="d-none"
                                    accept=".pdf,.doc,.docx">
                                <div id="file3" class="mt-2"></div>
                            </div>

                            <!-- Document 4: Dokumen Kepemilikan -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">4</span> Dokumen Kepemilikan Tanah <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc4').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Sertifikat/Dokumen Tanah</p>
                                    <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                                </div>
                                <input type="file" id="doc4" name="documents[]" class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png" required>
                                <div id="file4" class="mt-2"></div>
                            </div>

                            <!-- Document 5: Peta Lokasi -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">5</span> Peta Lokasi & Situasi <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc5').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Peta Lokasi</p>
                                    <p class="text-muted small">Format: PDF, JPG, PNG, CAD (Max: 10MB)</p>
                                </div>
                                <input type="file" id="doc5" name="documents[]" class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png,.dwg,.dxf" required>
                                <div id="file5" class="mt-2"></div>
                            </div>

                            <!-- Document 6: Proposal Konsep -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">6</span> Proposal/Konsep Awal RTBL <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc6').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Proposal/Konsep</p>
                                    <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 20MB)</p>
                                </div>
                                <input type="file" id="doc6" name="documents[]" class="d-none"
                                    accept=".pdf,.doc,.docx" required>
                                <div id="file6" class="mt-2"></div>
                            </div>

                            <!-- Document 7: Studi Kelayakan -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">7</span> Studi Kelayakan/Justifikasi Teknis
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc7').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Studi Kelayakan</p>
                                    <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 20MB)</p>
                                </div>
                                <input type="file" id="doc7" name="documents[]" class="d-none"
                                    accept=".pdf,.doc,.docx">
                                <div id="file7" class="mt-2"></div>
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
            const form = document.getElementById('rtblForm');

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
            for (let i = 1; i <= 7; i++) {
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
                const stepNames = ['personal', 'project', 'location', 'documents'];
                return stepNames[step - 1];
            }

            // Validation functions
            function validatePersonalInfo() {
                const required = ['nama', 'jabatan', 'instansi', 'email', 'telepon', 'alamat'];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateProjectInfo() {
                const required = ['nama_proyek', 'jenis_kawasan', 'luas_kawasan', 'deskripsi_proyek'];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateLocationInfo() {
                const required = ['kabupaten', 'kecamatan', 'kelurahan', 'alamat_lengkap', 'status_tanah',
                    'pemilik_tanah'
                ];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateDocuments() {
                const requiredDocs = ['doc1', 'doc2', 'doc4', 'doc5', 'doc6']; // doc3 and doc7 are optional
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
                    isValid = validateProjectInfo();
                    if (!isValid) {
                        alert('Mohon lengkapi semua data proyek yang diperlukan.');
                        return;
                    }
                } else if (currentStep === 3) {
                    isValid = validateLocationInfo();
                    if (!isValid) {
                        alert('Mohon lengkapi semua data lokasi yang diperlukan.');
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
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Permohonan RTBL berhasil diajukan! Nomor permohonan: ' + data
                                .nomor_permohonan);
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

            document.getElementById('luas_kawasan').addEventListener('input', function() {
                if (this.value < 0) this.value = 0;
            });

            document.getElementById('nilai_investasi').addEventListener('input', function() {
                // Format currency
                let value = this.value.replace(/[^0-9]/g, '');
                if (value) {
                    this.value = parseInt(value).toLocaleString('id-ID');
                }
            });

            // Coordinate validation
            document.getElementById('koordinat_lat').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9.-]/g, '');
            });

            document.getElementById('koordinat_lng').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9.-]/g, '');
            });

            // Date validation
            document.getElementById('target_mulai').addEventListener('change', function() {
                const mulai = new Date(this.value);
                const selesai = document.getElementById('target_selesai').value;

                if (selesai && mulai >= new Date(selesai)) {
                    alert('Tanggal mulai harus lebih awal dari tanggal selesai.');
                    this.value = '';
                }
            });

            document.getElementById('target_selesai').addEventListener('change', function() {
                const selesai = new Date(this.value);
                const mulai = document.getElementById('target_mulai').value;

                if (mulai && selesai <= new Date(mulai)) {
                    alert('Tanggal selesai harus lebih akhir dari tanggal mulai.');
                    this.value = '';
                }
            });

            // Initialize
            showStep(currentStep);
        });
    </script>
@endpush
