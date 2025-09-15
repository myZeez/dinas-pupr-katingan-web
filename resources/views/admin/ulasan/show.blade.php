@extends('layouts.admin')

@section('title', 'Detail Ulasan')
@section('page-title', 'Detail Ulasan')
@section('page-subtitle', 'Lihat detail ulasan pengunjung')

@section('content')

<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('admin.ulasan.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Ulasan
    </a>
</div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Rating Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rating Keseluruhan</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="text-warning fs-2 mb-2">
                            {!! $ulasan->getRatingStarsAttribute() !!}
                        </div>
                        <h3 class="text-primary fw-bold">{{ $ulasan->rating }}/5</h3>
                    </div>
                    
                    <!-- Detail Rating -->
                    @if($ulasan->rating_detail && is_array($ulasan->rating_detail))
                    <div class="row mt-4">
                        @foreach($ulasan->rating_detail as $key => $value)
                        <div class="col-md-4 mb-3">
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ ucfirst($key) }}</h6>
                                    <div class="text-warning mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $value)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="badge bg-success">{{ $value }}/5</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Ulasan Content -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ulasan dari {{ $ulasan->nama }}</h6>
                </div>
                <div class="card-body">
                    <div class="bg-light p-4 rounded">
                        <blockquote class="blockquote mb-0">
                            <p class="fs-5 text-justify">"{{ $ulasan->ulasan }}"</p>
                        </blockquote>
                    </div>
                </div>
            </div>

                        <!-- Status & Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status & Aksi</h6>
                </div>
                <div class="card-body">
                    <!-- Current Status -->
                    <div class="mb-3">
                        <h6>Status Saat Ini:</h6>
                        <div class="d-flex gap-2">
                            @if($ulasan->is_published)
                                <span class="badge bg-success fs-6">Dipublikasikan</span>
                            @else
                                <span class="badge bg-warning fs-6">Menunggu Persetujuan</span>
                            @endif
                            
                            @if($ulasan->is_featured)
                                <span class="badge bg-primary fs-6">Unggulan</span>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row g-2">
                        <!-- Publish/Unpublish -->
                        <div class="col-md-6">
                            <form action="{{ route('admin.ulasan.updateStatus', $ulasan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_published" value="{{ $ulasan->is_published ? '0' : '1' }}">
                                <input type="hidden" name="is_featured" value="{{ $ulasan->is_featured ? '1' : '0' }}">
                                <button type="submit" class="btn {{ $ulasan->is_published ? 'btn-warning' : 'btn-success' }} w-100">
                                    <i class="fas {{ $ulasan->is_published ? 'fa-eye-slash' : 'fa-check' }} me-1"></i>
                                    {{ $ulasan->is_published ? 'Sembunyikan' : 'Publikasikan' }}
                                </button>
                            </form>
                        </div>

                        <!-- Feature/Unfeature -->
                        <div class="col-md-6">
                            <form action="{{ route('admin.ulasan.updateStatus', $ulasan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_published" value="{{ $ulasan->is_published ? '1' : '0' }}">
                                <input type="hidden" name="is_featured" value="{{ $ulasan->is_featured ? '0' : '1' }}">
                                <button type="submit" class="btn {{ $ulasan->is_featured ? 'btn-outline-primary' : 'btn-primary' }} w-100">
                                    <i class="fas fa-star me-1"></i>
                                    {{ $ulasan->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                                </button>
                            </form>
                        </div>

                        <!-- Delete -->
                        <div class="col-12">
                            <form action="{{ route('admin.ulasan.destroy', $ulasan) }}" method="POST" class="delete-form"
                                data-message="Apakah Anda yakin ingin menghapus ulasan dari {{ $ulasan->nama }}?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-1"></i>
                                    Hapus Ulasan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- User Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengirim</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user text-primary fa-2x"></i>
                        </div>
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama:</strong></td>
                            <td>{{ $ulasan->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td><a href="mailto:{{ $ulasan->email }}">{{ $ulasan->email }}</a></td>
                        </tr>
                        @if($ulasan->instansi)
                        <tr>
                            <td><strong>Instansi:</strong></td>
                            <td>{{ $ulasan->instansi }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Kategori:</strong></td>
                            <td><span class="badge bg-info">{{ $ulasan->kategori }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal:</strong></td>
                            <td>{{ $ulasan->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection
