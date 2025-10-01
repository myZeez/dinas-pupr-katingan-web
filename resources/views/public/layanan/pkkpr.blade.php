@extends('public.layouts.app')

@section('title', 'Permohonan PKKPR (Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang)')

@section('styles')
    <style>
        /* Custom styles for PKKPR form */
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
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .btn-primary {
            background-color: #c07676;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #b06666;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(192, 118, 118, 0.2);
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
            border-color: #dc2626;
            background: #fef2f2;
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
            background-color: #c07676;
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
            background: #dc2626;
            color: white;
        }

        .step.completed .step-number {
            background: #991b1b;
            color: white;
        }

        .info-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .space-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            background: #fafafa;
        }

        .space-header {
            background: #dc2626;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .zone-info {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 12px;
        }

        .land-use-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 12px;
        }

        .land-use-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 13px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">PKKPR</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="d-inline-block p-3 rounded-circle mb-3"
                style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);">
                <i class="fas fa-map-marked-alt text-white" style="font-size: 24px;"></i>
            </div>
            <h1 class="h3 fw-bold text-dark mb-2">Permohonan PKKPR</h1>
            <p class="text-muted">Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Info Box -->
                <div class="info-box">
                    <h6 class="fw-bold text-danger mb-2">
                        <i class="fas fa-info-circle me-2"></i>Tentang PKKPR
                    </h6>
                    <p class="mb-0 small">
                        PKKPR adalah persetujuan dari pemerintah daerah bahwa rencana kegiatan pemanfaatan ruang sesuai
                        dengan rencana tata ruang. Persetujuan ini diperlukan sebelum memperoleh izin pemanfaatan ruang dan
                        merupakan dasar penerbitan izin mendirikan bangunan.
                    </p>
                </div>

                <!-- Progress Section -->
                <div class="progress-section">
                    <h6 class="fw-semibold mb-3">Progress Pengisian</h6>
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                            <div class="step active" id="step-personal">
                                <div class="step-number">1</div>
                                <span>Data Pemohon</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                            <div class="step" id="step-location">
                                <div class="step-number">2</div>
                                <span>Lokasi & Tanah</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                            <div class="step" id="step-landuse">
                                <div class="step-number">3</div>
                                <span>Rencana Pemanfaatan</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                            <div class="step" id="step-technical">
                                <div class="step-number">4</div>
                                <span>Data Teknis</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                            <div class="step" id="step-documents">
                                <div class="step-number">5</div>
                                <span>Dokumen</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="form-card p-4">
                    <form action="{{ route('public.permohonan.store') }}" method="POST" enctype="multipart/form-data"
                        id="pkkprForm">
                        @csrf
                        <input type="hidden" name="jenis_layanan" value="permohonan_pkkpr">

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
                                    <label for="jenis_pemohon" class="form-label">Jenis Pemohon <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_pemohon" name="jenis_pemohon" required>
                                        <option value="">-- Pilih Jenis Pemohon --</option>
                                        <option value="perorangan">Perorangan</option>
                                        <option value="badan_usaha">Badan Usaha/Perusahaan</option>
                                        <option value="yayasan">Yayasan/Organisasi</option>
                                        <option value="pemerintah">Instansi Pemerintah</option>
                                        <option value="koperasi">Koperasi</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nama_badan" class="form-label">Nama Badan Usaha/Instansi</label>
                                    <input type="text" class="form-control" id="nama_badan" name="nama_badan"
                                        placeholder="Kosongkan jika perorangan">
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

                        <!-- Location & Land Section -->
                        <div class="form-section d-none" id="section-location">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-map-marker-alt me-2"></i>Lokasi & Data Tanah
                            </h5>

                            <div class="space-card">
                                <div class="space-header">Lokasi Kegiatan</div>

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
                                    <label for="alamat_lokasi" class="form-label">Alamat Lengkap Lokasi <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat_lokasi" name="alamat_lokasi" rows="3"
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

                            <!-- Land Data -->
                            <div class="space-card">
                                <div class="space-header">Data Tanah</div>

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
                                            <option value="sewa">Sewa</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nomor_sertifikat" class="form-label">Nomor Sertifikat/Dokumen <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nomor_sertifikat"
                                            name="nomor_sertifikat" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="luas_tanah" class="form-label">Luas Tanah (m²) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="luas_tanah" name="luas_tanah"
                                            step="0.01" min="1" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="pemilik_tanah" class="form-label">Nama Pemilik Tanah <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pemilik_tanah"
                                            name="pemilik_tanah" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Land Use Planning Section -->
                        <div class="form-section d-none" id="section-landuse">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-drafting-compass me-2"></i>Rencana Pemanfaatan Ruang
                            </h5>

                            <div class="space-card">
                                <div class="space-header">Pemanfaatan Ruang yang Direncanakan</div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="peruntukan_ruang" class="form-label">Peruntukan Ruang <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="peruntukan_ruang" name="peruntukan_ruang"
                                            required>
                                            <option value="">-- Pilih Peruntukan --</option>
                                            <option value="perumahan">Perumahan</option>
                                            <option value="perdagangan_jasa">Perdagangan dan Jasa</option>
                                            <option value="perkantoran">Perkantoran</option>
                                            <option value="industri">Industri</option>
                                            <option value="pendidikan">Pendidikan</option>
                                            <option value="kesehatan">Kesehatan</option>
                                            <option value="olahraga_rekreasi">Olahraga dan Rekreasi</option>
                                            <option value="peribadatan">Peribadatan</option>
                                            <option value="transportasi">Transportasi</option>
                                            <option value="utilitas">Utilitas Umum</option>
                                            <option value="rtnh">Ruang Terbuka Non Hijau</option>
                                            <option value="rth">Ruang Terbuka Hijau</option>
                                            <option value="pertanian">Pertanian</option>
                                            <option value="perikanan">Perikanan</option>
                                            <option value="kehutanan">Kehutanan</option>
                                            <option value="pertambangan">Pertambangan</option>
                                            <option value="campuran">Peruntukan Campuran</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="intensitas_ruang" class="form-label">Intensitas Pemanfaatan <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="intensitas_ruang" name="intensitas_ruang"
                                            required>
                                            <option value="">-- Pilih Intensitas --</option>
                                            <option value="rendah">Rendah (KDB ≤ 40%, KLB ≤ 1)</option>
                                            <option value="sedang">Sedang (KDB 40-60%, KLB 1-2)</option>
                                            <option value="tinggi">Tinggi (KDB 60-80%, KLB 2-4)</option>
                                            <option value="sangat_tinggi">Sangat Tinggi (KDB > 80%, KLB > 4)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="kdb" class="form-label">KDB (%) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="kdb" name="kdb"
                                            min="0" max="100" step="0.1" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="klb" class="form-label">KLB <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="klb" name="klb"
                                            min="0" step="0.1" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="kdh" class="form-label">KDH (%)</label>
                                        <input type="number" class="form-control" id="kdh" name="kdh"
                                            min="0" max="100" step="0.1">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="ketinggian_maks" class="form-label">Ketinggian Maksimal
                                            (lantai)</label>
                                        <input type="number" class="form-control" id="ketinggian_maks"
                                            name="ketinggian_maks" min="1" step="1">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="gsb" class="form-label">Garis Sempadan Bangunan (meter)</label>
                                        <input type="number" class="form-control" id="gsb" name="gsb"
                                            min="0" step="0.1">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="kegiatan_detail" class="form-label">Detail Kegiatan yang Direncanakan
                                        <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="kegiatan_detail" name="kegiatan_detail" rows="4" maxlength="2000"
                                        placeholder="Jelaskan secara detail kegiatan/fungsi bangunan yang akan dilakukan..." required></textarea>
                                    <div class="form-text">Maksimal 2000 karakter</div>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Data Section -->
                        <div class="form-section d-none" id="section-technical">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-tools me-2"></i>Data Teknis Bangunan
                            </h5>

                            <div class="space-card">
                                <div class="space-header">Spesifikasi Teknis</div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_bangunan" class="form-label">Jenis Bangunan <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_bangunan" name="jenis_bangunan" required>
                                            <option value="">-- Pilih Jenis Bangunan --</option>
                                            <option value="rumah_tinggal">Rumah Tinggal</option>
                                            <option value="ruko">Ruko/Rukan</option>
                                            <option value="gedung_perkantoran">Gedung Perkantoran</option>
                                            <option value="gedung_komersial">Gedung Komersial</option>
                                            <option value="hotel">Hotel/Penginapan</option>
                                            <option value="industri">Bangunan Industri</option>
                                            <option value="gudang">Gudang/Pergudangan</option>
                                            <option value="sekolah">Bangunan Sekolah</option>
                                            <option value="rumah_sakit">Rumah Sakit/Klinik</option>
                                            <option value="tempat_ibadah">Tempat Ibadah</option>
                                            <option value="olahraga">Fasilitas Olahraga</option>
                                            <option value="utilitas">Bangunan Utilitas</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="jumlah_lantai" class="form-label">Jumlah Lantai <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="jumlah_lantai"
                                            name="jumlah_lantai" min="1" max="50" step="1" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="luas_bangunan" class="form-label">Luas Bangunan (m²) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="luas_bangunan"
                                            name="luas_bangunan" min="1" step="0.01" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="tinggi_bangunan" class="form-label">Tinggi Bangunan (meter)</label>
                                        <input type="number" class="form-control" id="tinggi_bangunan"
                                            name="tinggi_bangunan" min="1" step="0.1">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kapasitas" class="form-label">Kapasitas/Daya Tampung</label>
                                        <input type="number" class="form-control" id="kapasitas" name="kapasitas"
                                            min="1" placeholder="Jumlah orang/unit">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="estimasi_biaya" class="form-label">Estimasi Biaya Pembangunan
                                            (Rp)</label>
                                        <input type="text" class="form-control" id="estimasi_biaya"
                                            name="estimasi_biaya" placeholder="Contoh: 500000000">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="rencana_mulai" class="form-label">Rencana Mulai Pembangunan</label>
                                        <input type="date" class="form-control" id="rencana_mulai"
                                            name="rencana_mulai">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="rencana_selesai" class="form-label">Rencana Selesai
                                            Pembangunan</label>
                                        <input type="date" class="form-control" id="rencana_selesai"
                                            name="rencana_selesai">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="utilitas" class="form-label">Utilitas yang Dibutuhkan</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="air_bersih"
                                                    name="utilitas[]" value="air_bersih">
                                                <label class="form-check-label" for="air_bersih">Air Bersih</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="listrik"
                                                    name="utilitas[]" value="listrik">
                                                <label class="form-check-label" for="listrik">Listrik</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="telepon"
                                                    name="utilitas[]" value="telepon">
                                                <label class="form-check-label" for="telepon">Telepon/Internet</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gas"
                                                    name="utilitas[]" value="gas">
                                                <label class="form-check-label" for="gas">Gas</label>
                                            </div>
                                        </div>
                                    </div>
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
                                    <span class="requirement-badge">1</span> Surat Permohonan PKKPR <span
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

                            <!-- Document 2: KTP -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">2</span> Fotocopy KTP Pemohon <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc2').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload KTP</p>
                                    <p class="text-muted small">Format: PDF, JPG, PNG (Max: 5MB)</p>
                                </div>
                                <input type="file" id="doc2" name="documents[]" class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png" required>
                                <div id="file2" class="mt-2"></div>
                            </div>

                            <!-- Document 3: Sertifikat Tanah -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">3</span> Fotocopy Sertifikat Tanah <span
                                        class="text-danger">*</span>
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

                            <!-- Document 4: Peta Lokasi -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">4</span> Peta Lokasi & Situasi <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc4').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Peta Lokasi</p>
                                    <p class="text-muted small">Format: PDF, JPG, PNG, CAD (Max: 10MB)</p>
                                </div>
                                <input type="file" id="doc4" name="documents[]" class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png,.dwg,.dxf" required>
                                <div id="file4" class="mt-2"></div>
                            </div>

                            <!-- Document 5: Rencana Tapak -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">5</span> Rencana Tapak/Site Plan <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc5').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Rencana Tapak</p>
                                    <p class="text-muted small">Format: PDF, CAD, JPG, PNG (Max: 10MB)</p>
                                </div>
                                <input type="file" id="doc5" name="documents[]" class="d-none"
                                    accept=".pdf,.dwg,.dxf,.jpg,.jpeg,.png" required>
                                <div id="file5" class="mt-2"></div>
                            </div>

                            <!-- Document 6: Rencana Arsitektur -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">6</span> Rencana Arsitektur (Denah, Tampak, Potongan)
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc6').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Rencana Arsitektur</p>
                                    <p class="text-muted small">Format: PDF, CAD, JPG, PNG (Max: 20MB)</p>
                                </div>
                                <input type="file" id="doc6" name="documents[]" class="d-none"
                                    accept=".pdf,.dwg,.dxf,.jpg,.jpeg,.png">
                                <div id="file6" class="mt-2"></div>
                            </div>

                            <!-- Document 7: Akta Pendirian -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">7</span> Akta Pendirian Badan Usaha (jika pemohon badan
                                    usaha)
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc7').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Akta Pendirian</p>
                                    <p class="text-muted small">Format: PDF, JPG, PNG (Max: 10MB)</p>
                                </div>
                                <input type="file" id="doc7" name="documents[]" class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div id="file7" class="mt-2"></div>
                            </div>

                            <!-- Document 8: Surat Kuasa -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <span class="requirement-badge">8</span> Surat Kuasa (jika dikuasakan)
                                </label>
                                <div class="upload-area" onclick="document.getElementById('doc8').click()">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik untuk upload Surat Kuasa</p>
                                    <p class="text-muted small">Format: PDF, DOC, DOCX (Max: 5MB)</p>
                                </div>
                                <input type="file" id="doc8" name="documents[]" class="d-none"
                                    accept=".pdf,.doc,.docx">
                                <div id="file8" class="mt-2"></div>
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
            const totalSteps = 5;

            const sections = document.querySelectorAll('.form-section');
            const steps = document.querySelectorAll('.step');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('pkkprForm');

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
            for (let i = 1; i <= 8; i++) {
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
                const stepNames = ['personal', 'location', 'landuse', 'technical', 'documents'];
                return stepNames[step - 1];
            }

            // Validation functions
            function validatePersonalInfo() {
                const required = ['nama', 'nik', 'jenis_pemohon', 'email', 'telepon', 'alamat'];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateLocationInfo() {
                const required = ['kabupaten', 'kecamatan', 'kelurahan', 'alamat_lokasi', 'status_tanah',
                    'nomor_sertifikat', 'luas_tanah', 'pemilik_tanah'
                ];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateLandUseInfo() {
                const required = ['peruntukan_ruang', 'intensitas_ruang', 'kdb', 'klb', 'kegiatan_detail'];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateTechnicalInfo() {
                const required = ['jenis_bangunan', 'jumlah_lantai', 'luas_bangunan'];
                return required.every(field => {
                    const input = document.getElementById(field);
                    return input && input.value.trim() !== '';
                });
            }

            function validateDocuments() {
                const requiredDocs = ['doc1', 'doc2', 'doc3', 'doc4', 'doc5']; // Required documents
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
                    isValid = validateLocationInfo();
                    if (!isValid) {
                        alert('Mohon lengkapi semua data lokasi dan tanah yang diperlukan.');
                        return;
                    }
                } else if (currentStep === 3) {
                    isValid = validateLandUseInfo();
                    if (!isValid) {
                        alert('Mohon lengkapi semua data rencana pemanfaatan ruang yang diperlukan.');
                        return;
                    }
                } else if (currentStep === 4) {
                    isValid = validateTechnicalInfo();
                    if (!isValid) {
                        alert('Mohon lengkapi semua data teknis bangunan yang diperlukan.');
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
                            alert('Permohonan PKKPR berhasil diajukan! Nomor permohonan: ' + data
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
            document.getElementById('nik').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16);
                }
            });

            document.getElementById('telepon').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+]/g, '');
            });

            document.getElementById('koordinat_lat').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9.-]/g, '');
            });

            document.getElementById('koordinat_lng').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9.-]/g, '');
            });

            document.getElementById('estimasi_biaya').addEventListener('input', function() {
                // Format currency
                let value = this.value.replace(/[^0-9]/g, '');
                if (value) {
                    this.value = parseInt(value).toLocaleString('id-ID');
                }
            });

            // KDB/KLB validation
            document.getElementById('kdb').addEventListener('input', function() {
                if (this.value > 100) this.value = 100;
                if (this.value < 0) this.value = 0;
            });

            document.getElementById('klb').addEventListener('input', function() {
                if (this.value < 0) this.value = 0;
            });

            document.getElementById('kdh').addEventListener('input', function() {
                if (this.value > 100) this.value = 100;
                if (this.value < 0) this.value = 0;
            });

            // Date validation
            document.getElementById('rencana_mulai').addEventListener('change', function() {
                const mulai = new Date(this.value);
                const selesai = document.getElementById('rencana_selesai').value;

                if (selesai && mulai >= new Date(selesai)) {
                    alert('Tanggal mulai harus lebih awal dari tanggal selesai.');
                    this.value = '';
                }
            });

            document.getElementById('rencana_selesai').addEventListener('change', function() {
                const selesai = new Date(this.value);
                const mulai = document.getElementById('rencana_mulai').value;

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
