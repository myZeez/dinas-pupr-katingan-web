@extends('layouts.admin')

@section('title', 'Tambah Admin Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">➕ Tambah Admin Baru</h1>
                    <p class="text-muted mb-0">Buat akun administrator baru untuk sistem</p>
                </div>
                <div>
                    <a href="{{ route('admin.admin-management.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-plus me-2"></i>Form Tambah Admin
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.admin-management.store') }}">
                                @csrf

                                <!-- Basic Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                <i class="fas fa-user me-1"></i>Nama Lengkap
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   required 
                                                   autocomplete="name"
                                                   placeholder="Masukkan nama lengkap">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                <i class="fas fa-envelope me-1"></i>Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email') }}" 
                                                   required 
                                                   autocomplete="email"
                                                   placeholder="admin@example.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">
                                                <i class="fas fa-phone me-1"></i>Nomor Telepon
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone') }}" 
                                                   placeholder="08xxxxxxxxxx">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">
                                                <i class="fas fa-user-tag me-1"></i>Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('role') is-invalid @enderror" 
                                                    id="role" 
                                                    name="role" 
                                                    required>
                                                <option value="">Pilih Role</option>
                                                <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>
                                                    🎩 Super Admin
                                                </option>
                                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                                    👨‍💼 Admin Biasa
                                                </option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">
                                                <i class="fas fa-toggle-on me-1"></i>Status
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status" 
                                                    required>
                                                <option value="">Pilih Status</option>
                                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                                                    ✅ Aktif
                                                </option>
                                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                                    ⏸️ Tidak Aktif
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Section -->
                                <hr class="my-4">
                                <h6 class="text-muted mb-3">
                                    <i class="fas fa-lock me-2"></i>Pengaturan Password
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">
                                                <i class="fas fa-key me-1"></i>Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" 
                                                       class="form-control @error('password') is-invalid @enderror" 
                                                       id="password" 
                                                       name="password" 
                                                       required 
                                                       minlength="8"
                                                       placeholder="Minimal 8 karakter">
                                                <button class="btn btn-outline-secondary" 
                                                        type="button" 
                                                        id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Password harus minimal 8 karakter
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">
                                                <i class="fas fa-key me-1"></i>Konfirmasi Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" 
                                                       class="form-control" 
                                                       id="password_confirmation" 
                                                       name="password_confirmation" 
                                                       required 
                                                       minlength="8"
                                                       placeholder="Ulangi password">
                                                <button class="btn btn-outline-secondary" 
                                                        type="button" 
                                                        id="togglePasswordConfirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role Information -->
                                <div class="alert alert-info" id="roleInfo" style="display: none;">
                                    <h6 class="alert-heading">Informasi Role:</h6>
                                    <div id="roleDescription"></div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.admin-management.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Admin
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordConfirmation = document.getElementById('password_confirmation');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    togglePasswordConfirmation.addEventListener('click', function() {
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    // Role information
    const roleSelect = document.getElementById('role');
    const roleInfo = document.getElementById('roleInfo');
    const roleDescription = document.getElementById('roleDescription');

    const roleDescriptions = {
        'super_admin': `
            <strong>🎩 Super Admin</strong>
            <ul class="mb-0 mt-2">
                <li>Memiliki akses penuh ke seluruh fitur sistem</li>
                <li>Dapat mengatur akun semua admin</li>
                <li>Dapat membuat, mengedit, dan menghapus admin lain</li>
                <li>Dapat mereset password admin tanpa verifikasi email</li>
                <li>Akses ke pengaturan sistem utama</li>
            </ul>
        `,
        'admin': `
            <strong>👨‍💼 Admin Biasa</strong>
            <ul class="mb-0 mt-2">
                <li>Akses terbatas hanya pada fitur operasional</li>
                <li>Tidak bisa mengatur akun admin lain</li>
                <li>Tidak memiliki akses ke pengaturan sistem utama</li>
                <li>Fokus pada pengelolaan konten dan data</li>
            </ul>
        `
    };

    roleSelect.addEventListener('change', function() {
        if (this.value && roleDescriptions[this.value]) {
            roleDescription.innerHTML = roleDescriptions[this.value];
            roleInfo.style.display = 'block';
        } else {
            roleInfo.style.display = 'none';
        }
    });

    // Trigger change event on page load if role is already selected
    if (roleSelect.value) {
        roleSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
