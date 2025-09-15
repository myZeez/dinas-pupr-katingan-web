<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Lupa Password - Admin Dinas PUPR</title>
    <link rel="icon" type="image/png" href="{{ asset('img/LOGO.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .form-control {
            border: 2px solid #e3e6f0;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
        }
        
        .alert-warning {
            background: linear-gradient(45deg, #fff3cd, #ffeaa7);
            border-left: 4px solid #f39c12;
            color: #856404;
        }
        
        .alert-info {
            background: linear-gradient(45deg, #d1ecf1, #bee5eb);
            border-left: 4px solid #17a2b8;
            color: #0c5460;
        }
        
        .logo-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .back-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            color: white;
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <!-- Back to Login -->
                <div class="mb-4">
                    <a href="{{ route('login') }}" class="back-link d-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Login
                    </a>
                </div>
                
                <!-- Logo -->
                <div class="text-center logo-container">
                    <img src="{{ asset('img/LOGO.png') }}" alt="Logo Dinas PUPR" style="height: 60px;" class="mb-3">
                    <h4 class="fw-bold text-dark mb-1">Reset Password</h4>
                    <p class="text-muted mb-0">Admin Dinas PUPR Katingan</p>
                </div>
                
                <!-- Form Card -->
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-key-fill text-primary fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Reset Password Admin</h5>
                            <p class="text-muted mb-0">
                                Sistem reset password dengan pembatasan keamanan berdasarkan level admin
                            </p>
                        </div>
                        
                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success d-flex align-items-start border-0 shadow-sm">
                                <i class="bi bi-check-circle-fill me-3 mt-1 text-success fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-2 text-success">
                                        <i class="bi bi-envelope-check me-2"></i>Email Reset Password Terkirim
                                    </h6>
                                    <p class="mb-2">{{ session('success') }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>Silakan cek kotak masuk email Anda dan ikuti instruksi yang diberikan.
                                    </small>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Warning Message for Regular Admin -->
                        @if(session('warning'))
                            <div class="alert alert-warning d-flex align-items-start border-0 shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill me-3 mt-1 text-warning fs-4"></i>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-2 text-warning">
                                        <i class="bi bi-shield-x me-2"></i>Akses Terbatas untuk Admin Biasa
                                    </h6>
                                    <p class="mb-2"><strong>{{ session('warning') }}</strong></p>
                                    <div class="bg-light p-3 rounded-3 mt-3">
                                        <h6 class="fw-semibold text-primary mb-2">
                                            <i class="bi bi-info-circle me-2"></i>Cara Reset Password untuk Admin Biasa:
                                        </h6>
                                        <ol class="mb-2 ps-3">
                                            <li class="mb-1"><strong>Hubungi Super Admin</strong> via email: <a href="mailto:budiaat25@gmail.com" class="text-decoration-none fw-bold">budiaat25@gmail.com</a></li>
                                            <li class="mb-1"><strong>Kirim permintaan reset password</strong> dengan menyertakan nama lengkap dan email akun Anda</li>
                                            <li class="mb-1"><strong>Super Admin akan memverifikasi</strong> identitas Anda untuk keamanan</li>
                                            <li class="mb-1"><strong>Super Admin akan login</strong> dan masuk ke menu <span class="badge bg-primary">Admin Management</span></li>
                                            <li class="mb-1"><strong>Password baru akan dikirim</strong> ke email Anda setelah berhasil direset</li>
                                        </ol>
                                        <div class="alert alert-info border-0 mb-2 py-2">
                                            <small><i class="bi bi-envelope me-1"></i><strong>Email Super Admin:</strong> <a href="mailto:budiaat25@gmail.com">budiaat25@gmail.com</a></small>
                                        </div>
                                        <div class="alert alert-success border-0 mb-0 py-2">
                                            <small><i class="bi bi-clock me-1"></i><strong>Waktu Pelayanan:</strong> Senin-Jumat 08:00-16:00 WIB (Email 24/7)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Info Message for Regular Admin -->
                        @if(session('info'))
                            <div class="alert alert-info d-flex align-items-start">
                                <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                                <div>
                                    {{ session('info') }}
                                </div>
                            </div>
                        @endif
                        
                        <!-- Error Message -->
                        @if(session('error'))
                            <div class="alert alert-danger d-flex align-items-start border-0 shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill me-3 mt-1 text-danger fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-2 text-danger">
                                        <i class="bi bi-x-circle me-2"></i>Terjadi Kesalahan
                                    </h6>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.password.send-reset') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email Admin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px; border: 2px solid #e3e6f0;">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input id="email" 
                                           type="email" 
                                           class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email" 
                                           autofocus 
                                           placeholder="admin@dinaspupr.com"
                                           style="border-radius: 0 12px 12px 0;">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Reset Password Super Admin
                                </button>
                            </div>
                        </form>
                        
                        <!-- Help Text -->
                        <div class="mt-4 p-4 bg-light rounded-4 border">
                            <div class="text-center mb-3">
                                <i class="bi bi-info-circle-fill text-primary fs-3"></i>
                                <h6 class="fw-bold mt-2 text-primary">Informasi Sistem Reset Password</h6>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Super Admin Info -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25 h-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-shield-check-fill text-success me-2"></i>
                                            <strong class="text-success">Super Admin</strong>
                                        </div>
                                        <ul class="small mb-0 ps-3">
                                            <li class="mb-1">✅ Dapat menggunakan fitur reset password via email</li>
                                            <li class="mb-1">✅ Password baru dikirim otomatis ke email</li>
                                            <li class="mb-1">✅ Memiliki akses penuh ke semua fitur sistem</li>
                                            <li class="mb-1">✅ Dapat mengelola akun admin lainnya</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- Admin Biasa Info -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-warning bg-opacity-10 rounded-3 border border-warning border-opacity-25 h-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-shield-exclamation text-warning me-2"></i>
                                            <strong class="text-warning">Admin Biasa</strong>
                                        </div>
                                        <ul class="small mb-0 ps-3">
                                            <li class="mb-1">❌ <strong>TIDAK DAPAT</strong> menggunakan fitur reset password</li>
                                            <li class="mb-1">📞 Harus menghubungi Super Admin untuk reset password</li>
                                            <li class="mb-1">🔒 Akun dikelola sepenuhnya oleh Super Admin</li>
                                            <li class="mb-1">⚠️ Sistem akan menampilkan peringatan jika mencoba reset</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cara Reset untuk Admin Biasa -->
                            <div class="mt-4 p-3 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-25">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Langkah Reset Password untuk Admin Biasa
                                </h6>
                                <div class="row g-2">
                                    <div class="col-6 col-md-3">
                                        <div class="text-center p-2">
                                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                                <strong>1</strong>
                                            </div>
                                            <div class="small">
                                                <strong>Hubungi</strong><br>
                                                Super Admin
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="text-center p-2">
                                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                                <strong>2</strong>
                                            </div>
                                            <div class="small">
                                                <strong>Super Admin</strong><br>
                                                Login Sistem
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="text-center p-2">
                                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                                <strong>3</strong>
                                            </div>
                                            <div class="small">
                                                <strong>Buka Menu</strong><br>
                                                Admin Management
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="text-center p-2">
                                            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                                <i class="bi bi-check"></i>
                                            </div>
                                            <div class="small">
                                                <strong>Reset</strong><br>
                                                Password Selesai
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Security Note -->
                            <div class="mt-3 p-3 bg-info bg-opacity-10 rounded-3 border border-info border-opacity-25">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-shield-lock text-info me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-semibold text-info mb-2">Mengapa Sistem Keamanan Ini Diterapkan?</h6>
                                        <p class="small mb-0 text-muted">
                                            Sistem ini dirancang untuk memastikan keamanan maksimal aplikasi Dinas PUPR. 
                                            Dengan memberikan kontrol penuh kepada Super Admin atas semua akun admin, 
                                            kami dapat mencegah akses tidak sah dan memastikan integritas data sistem.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-white-50 small mb-0">
                        © {{ date('Y') }} Dinas PUPR Kabupaten Katingan. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Auto hide alerts -->
    <script>
        // Auto hide success alerts after 5 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>
