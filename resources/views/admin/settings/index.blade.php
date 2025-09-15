@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
    <style>
        .input-group .btn-outline-secondary {
            border-color: #ced4da;
        }

        .input-group .btn-outline-secondary:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }

        #togglePassword {
            cursor: pointer;
        }

        .nav-tabs .nav-link {
            border-radius: 8px 8px 0 0;
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 24px;
            margin-right: 4px;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, #5b72ee 0%, #7c93ff 100%);
            color: white;
            border: none;
        }

        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
        }
    </style>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Pengaturan Sistem</h1>

        <!-- Navigation Tabs -->
        <div class="card mb-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email"
                            type="button" role="tab">
                            <i class="bi bi-envelope me-2"></i>Pengaturan Email
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account"
                            type="button" role="tab">
                            <i class="bi bi-person-gear me-2"></i>Akun Pengguna
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="api-tab" data-bs-toggle="tab" data-bs-target="#api" type="button"
                            role="tab">
                            <i class="bi bi-book me-2"></i>API
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="captcha-tab" data-bs-toggle="tab" data-bs-target="#captcha"
                            type="button" role="tab">
                            <i class="bi bi-shield-check me-2"></i>CAPTCHA
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="settingsTabContent">
                <!-- Email Settings Tab -->
                <div class="tab-pane fade show active" id="email" role="tabpanel">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.settings.mail.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_mailer" class="form-label">Mail Driver</label>
                                        <select class="form-select" name="mail_mailer" id="mail_mailer" required>
                                            <option value="smtp"
                                                {{ App\Models\Setting::get('mail_mailer') == 'smtp' ? 'selected' : '' }}>
                                                SMTP</option>
                                            <option value="sendmail"
                                                {{ App\Models\Setting::get('mail_mailer') == 'sendmail' ? 'selected' : '' }}>
                                                Sendmail</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_host" class="form-label">SMTP Host</label>
                                        <input type="text" class="form-control" name="mail_host" id="mail_host"
                                            value="{{ App\Models\Setting::get('mail_host') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_port" class="form-label">SMTP Port</label>
                                        <input type="number" class="form-control" name="mail_port" id="mail_port"
                                            value="{{ App\Models\Setting::get('mail_port') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_encryption" class="form-label">Enkripsi</label>
                                        <select class="form-select" name="mail_encryption" id="mail_encryption" required>
                                            <option value="tls"
                                                {{ App\Models\Setting::get('mail_encryption') == 'tls' ? 'selected' : '' }}>
                                                TLS</option>
                                            <option value="ssl"
                                                {{ App\Models\Setting::get('mail_encryption') == 'ssl' ? 'selected' : '' }}>
                                                SSL</option>
                                            <option value="null"
                                                {{ App\Models\Setting::get('mail_encryption') == 'null' ? 'selected' : '' }}>
                                                None</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_username" class="form-label">Username Email</label>
                                        <input type="email" class="form-control" name="mail_username"
                                            id="mail_username" value="{{ App\Models\Setting::get('mail_username') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_password" class="form-label">Password Email</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="mail_password"
                                                id="mail_password" value="{{ App\Models\Setting::get('mail_password') }}"
                                                required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_from_address" class="form-label">From Email</label>
                                        <input type="email" class="form-control" name="mail_from_address"
                                            id="mail_from_address"
                                            value="{{ App\Models\Setting::get('mail_from_address') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_from_name" class="form-label">From Name</label>
                                        <input type="text" class="form-control" name="mail_from_name"
                                            id="mail_from_name" value="{{ App\Models\Setting::get('mail_from_name') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Simpan Pengaturan
                                </button>
                            </div>
                        </form>

                        <!-- Email Configuration Tips -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card h-100"
                                    style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                                                <i class="bi bi-envelope-check-fill text-white"
                                                    style="font-size: 1.3rem;"></i>
                                            </div>
                                            <h6 class="card-title mb-0" style="color: #1a1d29; font-weight: 600;">Tips
                                                Gmail SMTP</h6>
                                        </div>
                                        <ul class="mb-0" style="font-size: 0.85rem; color: #374151; line-height: 1.6;">
                                            <li class="mb-2">🔑 Gunakan <strong>App Password</strong> bukan password
                                                Gmail biasa</li>
                                            <li class="mb-2">🔒 Port 465 (SSL) atau Port 587 (TLS) untuk Gmail</li>
                                            <li class="mb-2">✅ Aktifkan "2-Step Verification" di akun Gmail</li>
                                            <li class="mb-2">🔧 Buat App Password di pengaturan keamanan Gmail</li>
                                            <li class="mb-0">📧 Test email setelah menyimpan pengaturan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100"
                                    style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                                <i class="bi bi-gear-fill text-white" style="font-size: 1.3rem;"></i>
                                            </div>
                                            <h6 class="card-title mb-0" style="color: #1a1d29; font-weight: 600;">
                                                Troubleshooting</h6>
                                        </div>
                                        <ul class="mb-0" style="font-size: 0.85rem; color: #374151; line-height: 1.6;">
                                            <li class="mb-2">🔍 Periksa koneksi internet jika test email gagal</li>
                                            <li class="mb-2">⚡ Coba port 587 jika port 465 tidak berfungsi</li>
                                            <li class="mb-2">🔄 Clear cache setelah mengubah pengaturan</li>
                                            <li class="mb-2">📝 Cek log error di storage/logs/laravel.log</li>
                                            <li class="mb-0">🔧 Hubungi admin sistem jika masalah berlanjut</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration Status -->
                        <div class="card mt-4"
                            style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 45px; height: 45px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                        <i class="bi bi-activity text-white" style="font-size: 1.3rem;"></i>
                                    </div>
                                    <h6 class="card-title mb-0" style="color: #1a1d29; font-weight: 600;">Status
                                        Konfigurasi</h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="badge bg-success me-2"
                                                style="width: 8px; height: 8px; border-radius: 50%;"></div>
                                            <small class="text-muted">Mail Driver:</small>
                                            <span
                                                class="badge bg-primary ms-auto">{{ App\Models\Setting::get('mail_mailer', 'SMTP') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="badge bg-success me-2"
                                                style="width: 8px; height: 8px; border-radius: 50%;"></div>
                                            <small class="text-muted">Host:</small>
                                            <span
                                                class="badge bg-info ms-auto">{{ App\Models\Setting::get('mail_host', 'Belum diatur') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="badge bg-success me-2"
                                                style="width: 8px; height: 8px; border-radius: 50%;"></div>
                                            <small class="text-muted">Port:</small>
                                            <span
                                                class="badge bg-warning ms-auto">{{ App\Models\Setting::get('mail_port', 'Belum diatur') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Settings Tab -->
                <div class="tab-pane fade" id="account" role="tabpanel">
                    <div class="card-body">
                        @if (session('account_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.2rem;"></i>
                                    <div>{{ session('account_success') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Profile Information Card -->
                        <div class="card mb-4"
                            style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                            <div class="card-header bg-transparent border-0 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px; background: linear-gradient(135deg, #5b72ee 0%, #7c93ff 100%);">
                                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-1" style="color: #1a1d29; font-weight: 600;">Informasi
                                            Profil</h5>
                                        <p class="card-subtitle text-muted mb-0" style="font-size: 0.9rem;">Perbarui
                                            informasi profil dan alamat email akun Anda</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form method="POST" action="{{ route('admin.settings.profile.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label"
                                                style="font-weight: 500; color: #1a1d29;">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name"
                                                value="{{ old('name', Auth::user()->name) }}" required
                                                style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label"
                                                style="font-weight: 500; color: #1a1d29;">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" value="{{ old('email', Auth::user()->email) }}" required
                                                style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="font-weight: 500; color: #1a1d29;">Role</label>
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}" readonly
                                                style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem; background-color: #f8f9fa;">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" style="font-weight: 500; color: #1a1d29;">Tanggal
                                                Bergabung</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->created_at->format('d M Y') }}" readonly
                                                style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem; background-color: #f8f9fa;">
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary"
                                            style="border-radius: 12px; padding: 12px 24px; font-weight: 500; border: none; background: linear-gradient(135deg, #5b72ee 0%, #7c93ff 100%); box-shadow: 0 4px 12px rgba(91, 114, 238, 0.3);">
                                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Password Security Card -->
                        <div class="card"
                            style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                            <div class="card-header bg-transparent border-0 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px; background: linear-gradient(135deg, #ff8f44 0%, #ffb020 100%);">
                                        <i class="bi bi-shield-lock-fill text-white" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-1" style="color: #1a1d29; font-weight: 600;">Keamanan
                                            Password</h5>
                                        <p class="card-subtitle text-muted mb-0" style="font-size: 0.9rem;">Perbarui
                                            password untuk menjaga keamanan akun Anda</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form method="POST" action="{{ route('admin.settings.password.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="current_password" class="form-label"
                                                style="font-weight: 500; color: #1a1d29;">Password Saat Ini</label>
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                id="current_password" name="current_password" required
                                                style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="password" class="form-label"
                                                style="font-weight: 500; color: #1a1d29;">Password Baru</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" required
                                                style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="password_confirmation" class="form-label"
                                                style="font-weight: 500; color: #1a1d29;">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required
                                                style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                                        </div>
                                    </div>

                                    <div class="alert alert-info d-flex align-items-start mb-4"
                                        style="border-radius: 12px; border: none; background-color: #f0f9ff; border-left: 4px solid #0ea5e9;">
                                        <i class="bi bi-info-circle-fill me-2 mt-1" style="color: #0ea5e9;"></i>
                                        <div style="font-size: 0.9rem; color: #0369a1;">
                                            <strong>Persyaratan Password:</strong>
                                            <ul class="mb-0 mt-1" style="padding-left: 1rem;">
                                                <li>Minimal 8 karakter</li>
                                                <li>Kombinasi huruf besar dan kecil direkomendasikan</li>
                                                <li>Gunakan angka dan simbol untuk keamanan lebih baik</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-warning"
                                            style="border-radius: 12px; padding: 12px 24px; font-weight: 500; border: none; background: linear-gradient(135deg, #ff8f44 0%, #ffb020 100%); box-shadow: 0 4px 12px rgba(255, 143, 68, 0.3); color: white;">
                                            <i class="bi bi-shield-check me-2"></i>Perbarui Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security Tips & Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100"
                                    style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #e8f5e8 0%, #f0f9f0 100%);">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                                <i class="bi bi-shield-check-fill text-white"
                                                    style="font-size: 1.3rem;"></i>
                                            </div>
                                            <h6 class="card-title mb-0" style="color: #1a1d29; font-weight: 600;">Tips
                                                Keamanan</h6>
                                        </div>
                                        <ul class="mb-0" style="font-size: 0.85rem; color: #374151; line-height: 1.6;">
                                            <li class="mb-2">🔐 Gunakan password yang unik dan kuat</li>
                                            <li class="mb-2">🔄 Ubah password secara berkala (minimal 3 bulan)</li>
                                            <li class="mb-2">🚫 Jangan bagikan informasi login kepada siapapun</li>
                                            <li class="mb-2">🔒 Selalu logout setelah selesai menggunakan sistem</li>
                                            <li class="mb-0">📱 Gunakan perangkat terpercaya untuk mengakses admin</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100"
                                    style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                                <i class="bi bi-lightbulb-fill text-white" style="font-size: 1.3rem;"></i>
                                            </div>
                                            <h6 class="card-title mb-0" style="color: #1a1d29; font-weight: 600;">Tips
                                                Profil</h6>
                                        </div>
                                        <ul class="mb-0" style="font-size: 0.85rem; color: #374151; line-height: 1.6;">
                                            <li class="mb-2">✉️ Pastikan email selalu aktif dan dapat diakses</li>
                                            <li class="mb-2">📝 Gunakan nama lengkap yang sesuai dengan identitas</li>
                                            <li class="mb-2">🔄 Perbarui informasi jika ada perubahan data</li>
                                            <li class="mb-2">🛡️ Verifikasi ulang setelah mengubah email</li>
                                            <li class="mb-0">📋 Catat perubahan penting untuk dokumentasi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Information -->
                        <div class="card"
                            style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 45px; height: 45px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                        <i class="bi bi-info-circle-fill text-white" style="font-size: 1.3rem;"></i>
                                    </div>
                                    <h6 class="card-title mb-0" style="color: #1a1d29; font-weight: 600;">Informasi Sistem
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <small class="text-muted">Versi Sistem:</small>
                                            <span class="badge bg-primary ms-2">Laravel 11.x</span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Level Akses:</small>
                                            <span
                                                class="badge bg-danger ms-2">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <small class="text-muted">Login Terakhir:</small>
                                            <span class="badge bg-info ms-2">{{ now()->format('d M Y, H:i') }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Status:</small>
                                            <span class="badge bg-success ms-2">Online & Aktif</span>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin: 1rem 0; border-color: #f59e0b;">
                                <div class="alert alert-warning d-flex align-items-center mb-0"
                                    style="border-radius: 8px; border: none; background-color: rgba(245, 158, 11, 0.1); padding: 12px;">
                                    <i class="bi bi-exclamation-triangle-fill me-2" style="color: #f59e0b;"></i>
                                    <small style="color: #92400e;">
                                        <strong>Penting:</strong> Semua aktivitas admin tercatat dalam sistem. Gunakan fitur
                                        dengan bijak dan sesuai prosedur.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API Documentation Tab -->
                <div class="tab-pane fade" id="api" role="tabpanel">
                    <div class="card-body">
                        <div class="card mb-4"
                            style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                            <div class="card-header bg-transparent border-0 py-3 d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 45px; height: 45px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                                    <i class="bi bi-journal-code text-white" style="font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0" style="color: #1a1d29; font-weight: 600;">API Documentation</h5>
                                    <small class="text-muted">Dokumentasi interaktif untuk endpoint API sistem</small>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <p class="text-muted mb-3">Gunakan tombol di bawah untuk membuka Swagger UI atau melihat
                                    file spesifikasi OpenAPI (JSON).</p>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <a href="{{ url('/docs') }}" target="_blank" class="btn btn-primary">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Swagger UI
                                    </a>
                                    <a href="{{ asset('api-docs.json') }}" target="_blank"
                                        class="btn btn-outline-secondary">
                                        <i class="bi bi-filetype-json me-1"></i> Lihat OpenAPI JSON
                                    </a>
                                </div>
                                <div class="alert alert-info mb-0" style="border-radius: 12px;">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <div>
                                            <div><strong>Base URL:</strong> {{ url('/api') }}</div>
                                            <small class="text-muted">Swagger UI menampilkan endpoint dan contoh
                                                request/response yang siap diuji.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CAPTCHA Settings Tab -->
                <div class="tab-pane fade" id="captcha" role="tabpanel">
                    <div class="card-body">
                        @if (session('captcha_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.2rem;"></i>
                                    <div>{{ session('captcha_success') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->has('captcha_error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle-fill me-2" style="font-size: 1.2rem;"></i>
                                    <div>{{ $errors->first('captcha_error') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- CAPTCHA Configuration Card -->
                        <div class="card mb-4"
                            style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                            <div class="card-header bg-transparent border-0 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                        <i class="bi bi-shield-check text-white" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-1" style="color: #1a1d29; font-weight: 600;">Pengaturan
                                            CAPTCHA</h5>
                                        <p class="card-subtitle text-muted mb-0" style="font-size: 0.9rem;">Konfigurasi
                                            sistem anti-spam untuk formulir website</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form action="{{ route('admin.settings.captcha.update') }}" method="POST"
                                    id="captchaForm">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- CAPTCHA Enable/Disable -->
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-semibold">Status CAPTCHA</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="captcha_required"
                                                    id="captcha_required" value="1"
                                                    {{ App\Models\CaptchaSetting::getValue('captcha_required', false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="captcha_required">
                                                    Aktifkan CAPTCHA pada formulir
                                                </label>
                                            </div>
                                            <small class="text-muted">Mengaktifkan atau menonaktifkan CAPTCHA di semua
                                                formulir</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Site Key -->
                                        <div class="col-md-6 mb-3">
                                            <label for="nocaptcha_sitekey" class="form-label fw-semibold">Site Key</label>
                                            <input type="text" class="form-control" name="nocaptcha_sitekey"
                                                id="nocaptcha_sitekey"
                                                value="{{ App\Models\CaptchaSetting::getValue('nocaptcha_sitekey') }}"
                                                placeholder="6LxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxX">
                                            <small class="text-muted">Public key untuk reCAPTCHA dari Google
                                                Console</small>
                                        </div>

                                        <!-- Secret Key -->
                                        <div class="col-md-6 mb-3">
                                            <label for="nocaptcha_secret" class="form-label fw-semibold">Secret
                                                Key</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="nocaptcha_secret"
                                                    id="nocaptcha_secret"
                                                    value="{{ App\Models\CaptchaSetting::getValue('nocaptcha_secret') }}"
                                                    placeholder="6LxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxX">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="toggleSecretKey">
                                                    <i class="bi bi-eye" id="toggleSecretIcon"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Private key untuk verifikasi reCAPTCHA</small>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-2 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>Simpan Pengaturan
                                        </button>
                                        <button type="button" class="btn btn-outline-success" onclick="testCaptcha()">
                                            <i class="bi bi-shield-check me-2"></i>Test CAPTCHA
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- CAPTCHA Setup Guide -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100"
                                    style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                                                <i class="bi bi-google text-white" style="font-size: 1.2rem;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1" style="color: #1e40af; font-weight: 600;">Setup Google
                                                    reCAPTCHA</h6>
                                                <small class="text-muted">Langkah-langkah konfigurasi</small>
                                            </div>
                                        </div>
                                        <ol class="mb-0" style="font-size: 0.9rem; color: #374151;">
                                            <li class="mb-2">Kunjungi <a href="https://www.google.com/recaptcha/admin"
                                                    target="_blank" class="text-decoration-none">Google reCAPTCHA
                                                    Console</a></li>
                                            <li class="mb-2">Daftarkan situs web Anda</li>
                                            <li class="mb-2">Pilih tipe reCAPTCHA (v2 atau v3)</li>
                                            <li class="mb-2">Tambahkan domain website Anda</li>
                                            <li class="mb-2">Salin Site Key dan Secret Key</li>
                                            <li>Masukkan key ke form di samping</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100"
                                    style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                                <i class="bi bi-shield-check text-white" style="font-size: 1.2rem;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1" style="color: #047857; font-weight: 600;">Status
                                                    CAPTCHA</h6>
                                                <small class="text-muted">Informasi konfigurasi saat ini</small>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Status:</small>
                                            <span
                                                class="badge {{ App\Models\CaptchaSetting::getValue('captcha_required', false) ? 'bg-success' : 'bg-secondary' }}">
                                                {{ App\Models\CaptchaSetting::getValue('captcha_required', false) ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Site Key:</small>
                                            <code
                                                style="font-size: 0.75rem; background: rgba(0,0,0,0.1); padding: 2px 6px; border-radius: 4px;">
                                                {{ App\Models\CaptchaSetting::getValue('nocaptcha_sitekey') ? Str::mask(App\Models\CaptchaSetting::getValue('nocaptcha_sitekey'), '*', 10, -10) : 'Belum diset' }}
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Mail Modal -->
    <div class="modal fade" id="testMailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Test Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="testMailForm">
                        <div class="mb-3">
                            <label for="test_email" class="form-label">Email Tujuan</label>
                            <input type="email" class="form-control" id="test_email" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="sendTestMail()">Kirim Test Email</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('mail_password');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        });

        // Handle tabs based on URL hash or success messages
        document.addEventListener('DOMContentLoaded', function() {
            // Check for account success message and switch to account tab
            @if (session('account_success'))
                const accountTab = new bootstrap.Tab(document.getElementById('account-tab'));
                accountTab.show();
            @endif

            // Handle URL hash for direct tab access
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                if (hash === 'account') {
                    const accountTab = new bootstrap.Tab(document.getElementById('account-tab'));
                    accountTab.show();
                } else if (hash === 'api') {
                    const apiTab = new bootstrap.Tab(document.getElementById('api-tab'));
                    apiTab.show();
                }
            }

            // Update URL hash when tab changes
            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tab) {
                tab.addEventListener('shown.bs.tab', function(e) {
                    const targetId = e.target.getAttribute('data-bs-target').substring(1);
                    if (targetId !== 'email') {
                        window.history.replaceState(null, null, '#' + targetId);
                    } else {
                        window.history.replaceState(null, null, window.location.pathname);
                    }
                });
            });
        });

        function sendTestMail() {
            const email = document.getElementById('test_email').value;

            if (!email) {
                alert('Masukkan email tujuan');
                return;
            }

            // Show loading state
            const sendButton = document.querySelector('#testMailModal .btn-primary');
            const originalText = sendButton.innerHTML;
            sendButton.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Mengirim...';
            sendButton.disabled = true;

            fetch('{{ route('admin.settings.mail.test') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        test_email: email
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response content type:', response.headers.get('content-type'));

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            throw new Error(`Expected JSON, got: ${text.substring(0, 100)}...`);
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    // Reset button
                    sendButton.innerHTML = originalText;
                    sendButton.disabled = false;

                    if (data.success) {
                        alert('✅ ' + data.message);
                        bootstrap.Modal.getInstance(document.getElementById('testMailModal')).hide();
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    // Reset button
                    sendButton.innerHTML = originalText;
                    sendButton.disabled = false;

                    console.error('Error:', error);
                    alert('❌ Terjadi kesalahan: ' + error.message);
                });
        }

        // Toggle CAPTCHA Secret Key visibility
        document.getElementById('toggleSecretKey').addEventListener('click', function() {
            const secretInput = document.getElementById('nocaptcha_secret');
            const toggleIcon = document.getElementById('toggleSecretIcon');

            if (secretInput.type === 'password') {
                secretInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                secretInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        });

        // Test CAPTCHA function
        function testCaptcha() {
            const siteKey = document.getElementById('nocaptcha_sitekey').value;
            const secretKey = document.getElementById('nocaptcha_secret').value;

            if (!siteKey || !secretKey) {
                alert('❌ Site Key dan Secret Key harus diisi untuk melakukan test');
                return;
            }

            // Create loading state
            const testButton = event.target;
            const originalText = testButton.innerHTML;
            testButton.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Testing...';
            testButton.disabled = true;

            fetch('{{ route('admin.settings.captcha.test') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        site_key: siteKey,
                        secret_key: secretKey
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button
                    testButton.innerHTML = originalText;
                    testButton.disabled = false;

                    if (data.success) {
                        alert('✅ ' + data.message);
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    // Reset button
                    testButton.innerHTML = originalText;
                    testButton.disabled = false;

                    console.error('CAPTCHA Test Error:', error);

                    // Provide helpful error message
                    let errorMessage = 'Terjadi kesalahan saat testing CAPTCHA.\n\n';
                    errorMessage += 'Kemungkinan penyebab:\n';
                    errorMessage += '• Koneksi internet bermasalah\n';
                    errorMessage += '• SSL certificate issue (development)\n';
                    errorMessage += '• Server tidak dapat mengakses Google API\n\n';
                    errorMessage += 'Solusi: Format key sudah divalidasi offline jika memungkinkan.';

                    alert('❌ ' + errorMessage);
                });
        }
    </script>
@endsection
