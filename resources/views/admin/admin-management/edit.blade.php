@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('page-subtitle', 'Ubah informasi administrator')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-gear text-white fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Edit Admin</h5>
                            <small class="text-muted">Perbarui informasi administrator</small>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('admin.admin-management.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.admin-management.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body p-4">
                        <!-- Current Avatar Display -->
                        @if($user->avatar)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="Avatar {{ $user->name }}" 
                                 class="rounded-circle border border-3 border-light shadow"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        @endif

                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}" 
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <label for="role" class="form-label">Peran</label>
                                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">Pilih Peran</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin Biasa</option>
                                    <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Avatar Upload -->
                            <div class="col-md-6">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" 
                                       class="form-control @error('avatar') is-invalid @enderror" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Permissions -->
                            <div class="col-12">
                                <label class="form-label">Izin Akses</label>
                                <div class="row g-2">
                                    @php
                                        $availablePermissions = [
                                            'manage_berita' => 'Kelola Berita',
                                            'manage_program' => 'Kelola Program',
                                            'manage_layanan' => 'Kelola Layanan',
                                            'manage_pengaduan' => 'Kelola Pengaduan',
                                            'manage_galeri' => 'Kelola Galeri',
                                            'view_analytics' => 'Lihat Analitik',
                                        ];
                                        $currentPermissions = $user->permissions ? json_decode($user->permissions, true) : [];
                                    @endphp
                                    @foreach($availablePermissions as $key => $label)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $key }}" 
                                                   id="perm_{{ $key }}"
                                                   {{ in_array($key, $currentPermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $key }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Password Change Section -->
                            <div class="col-12">
                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-key me-2"></i>Ubah Password (Opsional)
                                </h6>
                                <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-4">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.admin-management.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create or update preview image
                let preview = document.getElementById('avatar-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'avatar-preview';
                    preview.className = 'rounded-circle border border-3 border-light shadow mt-2';
                    preview.style.cssText = 'width: 80px; height: 80px; object-fit: cover;';
                    document.getElementById('avatar').parentNode.appendChild(preview);
                }
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Password confirmation validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmation = this.value;
        
        if (password && confirmation && password !== confirmation) {
            this.setCustomValidity('Password tidak cocok');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
</script>
@endpush
@endsection
