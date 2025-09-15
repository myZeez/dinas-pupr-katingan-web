@extends('layouts.admin')

@section('title', 'Pengaturan Akun')
@section('page-title', 'Pengaturan Akun')
@section('page-subtitle', 'Kelola informasi akun dan keamanan admin')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.2rem;"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profile Information Card -->
        <div class="card mb-4" style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-header bg-transparent border-0 py-4">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, #5b72ee 0%, #7c93ff 100%);">
                        <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1" style="color: #1a1d29; font-weight: 600;">Informasi Profil</h5>
                        <p class="card-subtitle text-muted mb-0" style="font-size: 0.9rem;">Perbarui informasi profil dan alamat email akun Anda</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.account.updateProfile') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label" style="font-weight: 500; color: #1a1d29;">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label" style="font-weight: 500; color: #1a1d29;">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500; color: #1a1d29;">Role</label>
                            <input type="text" 
                                   class="form-control" 
                                   value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" 
                                   readonly
                                   style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem; background-color: #f8f9fa;">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 500; color: #1a1d29;">Tanggal Bergabung</label>
                            <input type="text" 
                                   class="form-control" 
                                   value="{{ $user->created_at->format('d M Y') }}" 
                                   readonly
                                   style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem; background-color: #f8f9fa;">
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="border-radius: 12px; padding: 12px 24px; font-weight: 500; border: none; background: linear-gradient(135deg, #5b72ee 0%, #7c93ff 100%); box-shadow: 0 4px 12px rgba(91, 114, 238, 0.3);">
                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Security Card -->
        <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-header bg-transparent border-0 py-4">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, #ff8f44 0%, #ffb020 100%);">
                        <i class="bi bi-shield-lock-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1" style="color: #1a1d29; font-weight: 600;">Keamanan Password</h5>
                        <p class="card-subtitle text-muted mb-0" style="font-size: 0.9rem;">Perbarui password untuk menjaga keamanan akun Anda</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.account.updatePassword') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="current_password" class="form-label" style="font-weight: 500; color: #1a1d29;">Password Saat Ini</label>
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required
                                   style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label" style="font-weight: 500; color: #1a1d29;">Password Baru</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="password_confirmation" class="form-label" style="font-weight: 500; color: #1a1d29;">Konfirmasi Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   style="border-radius: 12px; border: 1px solid #e6ebf4; padding: 12px 16px; font-size: 0.95rem;">
                        </div>
                    </div>
                    
                    <div class="alert alert-info d-flex align-items-start mb-4" style="border-radius: 12px; border: none; background-color: #f0f9ff; border-left: 4px solid #0ea5e9;">
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
                        <button type="submit" class="btn btn-warning" style="border-radius: 12px; padding: 12px 24px; font-weight: 500; border: none; background: linear-gradient(135deg, #ff8f44 0%, #ffb020 100%); box-shadow: 0 4px 12px rgba(255, 143, 68, 0.3); color: white;">
                            <i class="bi bi-shield-check me-2"></i>Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Account Info Summary -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-center" style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-body py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 60px; height: 60px; background: linear-gradient(135deg, #00d4aa 0%, #00b894 100%);">
                    <i class="bi bi-person-check-fill text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h6 class="card-title" style="color: #1a1d29; font-weight: 600;">Status Akun</h6>
                <span class="badge bg-success" style="border-radius: 8px; padding: 6px 12px;">Aktif & Terverifikasi</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-center" style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-body py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 60px; height: 60px; background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);">
                    <i class="bi bi-clock-fill text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h6 class="card-title" style="color: #1a1d29; font-weight: 600;">Login Terakhir</h6>
                <p class="text-muted small mb-0">{{ now()->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-center" style="border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-body py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 60px; height: 60px; background: linear-gradient(135deg, #ff5757 0%, #ff7b7b 100%);">
                    <i class="bi bi-shield-fill-check text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h6 class="card-title" style="color: #1a1d29; font-weight: 600;">Tingkat Akses</h6>
                <span class="badge bg-danger" style="border-radius: 8px; padding: 6px 12px;">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Form validation enhancement
    document.addEventListener('DOMContentLoaded', function() {
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                // Add your password strength logic here
                console.log('Password strength check:', password.length);
            });
        }

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush
