@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan Profil Dinas</h3>
                </div>
                <div class="card-body">
                    <!-- Profil Dinas Form -->
                    <div>
                            <form action="{{ route('admin.profil.update-profil') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <!-- Logo -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Logo Dinas</label>
                                            <div class="text-center mb-3">
                                                @if($profil->logo)
                                                    <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo" class="img-thumbnail" style="max-width: 200px;">
                                                @else
                                                    <div class="bg-light p-4 rounded">
                                                        <i class="fas fa-image fa-3x text-muted"></i>
                                                        <p class="mt-2 text-muted">Belum ada logo</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" class="form-control" name="logo" accept="image/*">
                                            <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                                        </div>
                                    </div>

                                    <!-- Background Image -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Background Profil</label>
                                            <div class="text-center mb-3">
                                                @if($profil->background_image)
                                                    <img src="{{ asset('storage/' . $profil->background_image) }}" alt="Background" class="img-thumbnail" style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light p-4 rounded">
                                                        <i class="fas fa-image fa-3x text-muted"></i>
                                                        <p class="mt-2 text-muted">Belum ada background</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" class="form-control" name="background_image" accept="image/*">
                                            <small class="text-muted">Format: JPG, PNG (Max: 2MB)<br><small>Digunakan untuk bagian "Tentang Dinas" di beranda</small></small>
                                        </div>
                                    </div>

                                    <!-- Form Data -->
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Nama Instansi *</label>
                                            <input type="text" class="form-control" name="nama_instansi" value="{{ $profil->nama_instansi }}" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Alamat</label>
                                            <textarea class="form-control" name="alamat" rows="2">{{ $profil->alamat }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Telepon</label>
                                                    <input type="text" class="form-control" name="telepon" value="{{ $profil->telepon }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email" value="{{ $profil->email }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Website</label>
                                            <input type="url" class="form-control" name="website" value="{{ $profil->website }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Visi Misi -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Visi</label>
                                            <textarea class="form-control" name="visi" rows="4">{{ $profil->visi }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Misi</label>
                                            <textarea class="form-control" name="misi" rows="4">{{ $profil->misi }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Tugas Pokok dan Fungsi (TUPOKSI)</label>
                                    <textarea class="form-control" name="tupoksi" rows="6">{{ $profil->tupoksi }}</textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Profil
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
$(document).ready(function() {
    // File input preview
    $('input[name="logo"]').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = $('<img>').attr('src', e.target.result).addClass('img-thumbnail').css('max-width', '200px');
                $(this).closest('.form-group').find('.text-center').html(img);
            }.bind(this);
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
