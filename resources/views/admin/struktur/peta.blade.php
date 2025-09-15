@extends('layouts.admin')

@section('title', 'Struktur Organisasi - Peta Jabatan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mt-4">Struktur Organisasi</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Struktur Organisasi</li>
            </ol>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.struktur.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-list-ul me-2"></i>Daftar Tabel
            </a>
            <a href="{{ route('admin.struktur.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Pegawai
            </a>
        </div>
    </div>

    <!-- Peta Struktur Organisasi -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-diagram-3 me-2"></i>Peta Jabatan Dinas PUPR
            </h5>
            <small class="text-muted">Berdasarkan Dokumen Peta Jabatan Maret 2024</small>
        </div>
        <div class="card-body">
            <!-- Kepala Dinas -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="org-box org-head text-center">
                        <div class="org-content">
                            <div class="org-title">KEPALA DINAS</div>
                            <div class="org-class">(IV/c - S.3) (Kelas Jabatan 14)</div>
                            <div class="org-person">
                                <strong>Dr. Ir. CHRISTIAN RAIN, MT</strong><br>
                                <small>NIP. 196808131995031004</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sekretaris -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="org-box org-secretary text-center">
                        <div class="org-content">
                            <div class="org-title">SEKRETARIS</div>
                            <div class="org-class">(IV/b - S.1) (Kelas Jabatan 12)</div>
                            <div class="org-person">
                                <strong>Lowongan Tersedia</strong><br>
                                <small class="text-muted">Belum terisi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub Bagian -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="org-box org-subunit">
                        <div class="org-content">
                            <div class="org-title">KEPALA SUBBAGIAN UMUM DAN KEPEGAWAIAN</div>
                            <div class="org-class">(III/c - S.1) (Kelas Jabatan 8)</div>
                            <div class="org-person">
                                <strong>Lowongan Tersedia</strong><br>
                                <small class="text-muted">Belum terisi</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="org-box org-subunit">
                        <div class="org-content">
                            <div class="org-title">KEPALA SUBBAGIAN KEUANGAN, PERENCANAAN, EVALUASI DAN PELAPORAN</div>
                            <div class="org-class">(III/d - S.1) (Kelas Jabatan 9)</div>
                            <div class="org-person">
                                <strong>Lowongan Tersedia</strong><br>
                                <small class="text-muted">Belum terisi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bidang-Bidang -->
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="org-box org-bidang">
                        <div class="org-content">
                            <div class="org-title">KEPALA BIDANG BINA MARGA</div>
                            <div class="org-class">(IV/a - S.1) (Kelas Jabatan 11)</div>
                            <div class="org-person">
                                <strong>Lowongan Tersedia</strong><br>
                                <small class="text-muted">Belum terisi</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="org-box org-bidang">
                        <div class="org-content">
                            <div class="org-title">KEPALA BIDANG CIPTA KARYA</div>
                            <div class="org-class">(IV/a - S.1) (Kelas Jabatan 11)</div>
                            <div class="org-person">
                                <strong>Lowongan Tersedia</strong><br>
                                <small class="text-muted">Belum terisi</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="org-box org-bidang">
                        <div class="org-content">
                            <div class="org-title">KEPALA BIDANG TATA RUANG DAN BINA KONSTRUKSI</div>
                            <div class="org-class">(IV/a - S.1) (Kelas Jabatan 11)</div>
                            <div class="org-person">
                                <strong>Lowongan Tersedia</strong><br>
                                <small class="text-muted">Belum terisi</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="org-box org-bidang">
                        <div class="org-content">
                            <div class="org-title">KEPALA BIDANG SUMBER DAYA AIR</div>
                            <div class="org-class">(IV/a - S.1) (Kelas Jabatan 11)</div>
                            <div class="org-person">
                                <strong>Lowongan Tersedia</strong><br>
                                <small class="text-muted">Belum terisi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kekuatan Pegawai -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle me-2"></i>Kekuatan Pegawai</h6>
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <strong>IV/e:</strong> - &nbsp;&nbsp;&nbsp; 
                                <strong>III/d:</strong> 15 &nbsp;&nbsp;&nbsp; 
                                <strong>II/d:</strong> 2 &nbsp;&nbsp;&nbsp;
                                <strong>I/b:</strong> -
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>IV/d:</strong> - &nbsp;&nbsp;&nbsp; 
                                <strong>III/c:</strong> 9 &nbsp;&nbsp;&nbsp; 
                                <strong>II/c:</strong> 2 &nbsp;&nbsp;&nbsp;
                                <strong>I/a:</strong> -
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>IV/c:</strong> 1 &nbsp;&nbsp;&nbsp; 
                                <strong>III/b:</strong> 5 &nbsp;&nbsp;&nbsp;
                                <strong>II/b:</strong> -
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>IV/b:</strong> 1 &nbsp;&nbsp;&nbsp; 
                                <strong>III/a:</strong> 7 &nbsp;&nbsp;&nbsp;
                                <strong>II/a:</strong> -
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>90 ASN Dan PHL TERDIRI DARI</strong><br>
                                Es.I: - &nbsp; Es.III: 5 &nbsp; JF: 8 &nbsp; <strong>JFU: 26</strong>
                            </div>
                            <div class="col-md-6">
                                Es.II: 1 &nbsp; Es.IV: 2 &nbsp; PHL: 48
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Organisasi Chart Styles */
.org-box {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    min-height: 120px;
    display: flex;
    align-items: center;
}

.org-box:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.org-content {
    padding: 15px;
    width: 100%;
}

.org-title {
    font-size: 11px;
    font-weight: bold;
    color: #1a1d29;
    margin-bottom: 5px;
    line-height: 1.2;
}

.org-class {
    font-size: 9px;
    color: #6b7280;
    margin-bottom: 8px;
    font-style: italic;
}

.org-person {
    font-size: 10px;
    line-height: 1.3;
}

.org-person strong {
    color: #1a1d29;
}

.org-person small {
    color: #9ca3af;
}

/* Specific Styles */
.org-head {
    border-color: #dc3545;
    background: linear-gradient(45deg, #fff5f5, #ffffff);
}

.org-secretary {
    border-color: #0d6efd;
    background: linear-gradient(45deg, #f0f7ff, #ffffff);
}

.org-subunit {
    border-color: #198754;
    background: linear-gradient(45deg, #f0fff4, #ffffff);
}

.org-bidang {
    border-color: #fd7e14;
    background: linear-gradient(45deg, #fff8f0, #ffffff);
}

.org-head .org-title {
    color: #dc3545;
    font-size: 13px;
}

.org-secretary .org-title {
    color: #0d6efd;
    font-size: 12px;
}

.org-subunit .org-title {
    color: #198754;
}

.org-bidang .org-title {
    color: #fd7e14;
}

/* Responsive */
@media (max-width: 768px) {
    .org-box {
        min-height: 100px;
    }
    
    .org-title {
        font-size: 10px;
    }
    
    .org-class {
        font-size: 8px;
    }
    
    .org-person {
        font-size: 9px;
    }
}
</style>
@endsection
