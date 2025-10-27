@extends('layouts.admin')

@section('title', 'Detail Ulasan')
@section('page-title', 'Detail Ulasan')
@section('page-subtitle', 'Lihat detail ulasan pengunjung')

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, 0.15);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.25rem 2rem rgba(58, 59, 69, 0.25);
}

.card-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: white;
    border-radius: 0.35rem 0.35rem 0 0 !important;
    padding: 1rem 1.25rem;
}

.card-header h6 {
    color: white !important;
    margin: 0;
    font-weight: 700;
}

.rating-stars {
    color: #ffc107;
    font-size: 1.2rem;
}

.user-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4e73df, #224abe);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-align: center;
}

.action-btn {
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
    padding: 0.75rem 1rem;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,0.1);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e3e6f0;
}

.info-item:last-child {
    border-bottom: none;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .col-lg-6 {
        margin-bottom: 1.5rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .action-btn {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
    }
}

@media (max-width: 576px) {
    .row.g-2 > .col-md-6 {
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-comment-dots text-primary me-2"></i>Detail Ulasan
        </h1>
        <a href="{{ route('admin.ulasan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column - User Info & Review -->
        <div class="col-lg-6 mb-4">
            <!-- User Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6><i class="fas fa-user me-2"></i>Informasi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="user-avatar">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold text-primary mb-1">{{ $ulasan->nama }}</h5>
                            @if($ulasan->instansi)
                                <p class="text-muted mb-1">
                                    <i class="fas fa-building me-1"></i>{{ $ulasan->instansi }}
                                </p>
                            @endif
                            @if($ulasan->email)
                                <p class="text-muted mb-1">
                                    <i class="fas fa-envelope me-1"></i>{{ $ulasan->email }}
                                </p>
                            @endif
                            @if($ulasan->telepon)
                                <p class="text-muted mb-0">
                                    <i class="fas fa-phone me-1"></i>{{ $ulasan->telepon }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating & Category -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6><i class="fas fa-star me-2"></i>Penilaian</h6>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="rating-stars mb-2">
                                {!! $ulasan->getRatingStarsAttribute() !!}
                            </div>
                            <h3 class="text-primary fw-bold">{{ $ulasan->rating }}/5</h3>
                            <small class="text-muted">Rating</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <span class="badge bg-primary p-2 fs-6">
                                <i class="fas fa-tag me-1"></i>{{ $ulasan->kategori }}
                            </span>
                            <br><small class="text-muted">Kategori</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Content -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6><i class="fas fa-quote-left me-2"></i>Ulasan</h6>
                </div>
                <div class="card-body">
                    <div class="border-start border-primary border-3 ps-3">
                        <p class="mb-0 text-justify" style="line-height: 1.6;">
                            "{{ $ulasan->ulasan }}"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="card">
                <div class="card-header">
                    <h6><i class="fas fa-info-circle me-2"></i>Status</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="status-badge {{ $ulasan->is_published ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                <i class="fas {{ $ulasan->is_published ? 'fa-eye' : 'fa-eye-slash' }} me-1"></i>
                                {{ $ulasan->is_published ? 'Publik' : 'Tersembunyi' }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="status-badge {{ $ulasan->is_featured ? 'bg-primary text-white' : 'bg-secondary text-white' }}">
                                <i class="fas fa-star me-1"></i>
                                {{ $ulasan->is_featured ? 'Unggulan' : 'Biasa' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Actions & Details -->
        <div class="col-lg-6">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6><i class="fas fa-tools me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <form action="{{ route('admin.ulasan.updateStatus', $ulasan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_published" value="{{ $ulasan->is_published ? '0' : '1' }}">
                                <input type="hidden" name="is_featured" value="{{ $ulasan->is_featured ? '1' : '0' }}">
                                <button type="submit" class="btn {{ $ulasan->is_published ? 'btn-warning' : 'btn-success' }} action-btn w-100">
                                    <i class="fas {{ $ulasan->is_published ? 'fa-eye-slash' : 'fa-check' }} me-1"></i>
                                    {{ $ulasan->is_published ? 'Sembunyikan' : 'Publikasikan' }}
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.ulasan.updateStatus', $ulasan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_published" value="{{ $ulasan->is_published ? '1' : '0' }}">
                                <input type="hidden" name="is_featured" value="{{ $ulasan->is_featured ? '0' : '1' }}">
                                <button type="submit" class="btn {{ $ulasan->is_featured ? 'btn-outline-primary' : 'btn-primary' }} action-btn w-100">
                                    <i class="fas fa-star me-1"></i>
                                    {{ $ulasan->is_featured ? 'Hapus Unggulan' : 'Jadikan Unggulan' }}
                                </button>
                            </form>
                        </div>
                        <div class="col-12">
                            <form action="{{ route('admin.ulasan.destroy', $ulasan) }}" method="POST" class="delete-form"
                                  data-message="Yakin hapus ulasan dari {{ $ulasan->nama }}?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger action-btn w-100">
                                    <i class="fas fa-trash me-1"></i>Hapus Ulasan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6><i class="fas fa-info-circle me-2"></i>Detail Info</h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <span><i class="fas fa-hashtag me-1 text-muted"></i>ID:</span>
                        <strong class="text-primary">#{{ $ulasan->id }}</strong>
                    </div>
                    <div class="info-item">
                        <span><i class="fas fa-calendar-plus me-1 text-muted"></i>Dibuat:</span>
                        <strong>{{ $ulasan->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                    <div class="info-item">
                        <span><i class="fas fa-edit me-1 text-muted"></i>Update:</span>
                        <strong>{{ $ulasan->updated_at->format('d/m/Y H:i') }}</strong>
                    </div>
                    <div class="info-item">
                        <span><i class="fas fa-spell-check me-1 text-muted"></i>Kata:</span>
                        <strong class="text-success">{{ str_word_count($ulasan->ulasan) }}</strong>
                    </div>
                    <div class="info-item">
                        <span><i class="fas fa-text-width me-1 text-muted"></i>Karakter:</span>
                        <strong class="text-info">{{ strlen($ulasan->ulasan) }}</strong>
                    </div>
                </div>
            </div>

            <!-- Preview (only if published) -->
            @if($ulasan->is_published)
            <div class="card">
                <div class="card-header">
                    <h6><i class="fas fa-eye me-2"></i>Preview</h6>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3" style="background: #f8f9fa;">
                        <!-- Rating -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rating-stars">
                                {!! $ulasan->getRatingStarsAttribute() !!}
                            </div>
                            <span class="badge bg-primary">{{ $ulasan->rating }}/5</span>
                        </div>
                        
                        <!-- User -->
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                <i class="fas fa-user text-white small"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 small">{{ $ulasan->nama }}</h6>
                                <small class="text-muted">{{ $ulasan->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <p class="text-muted mb-2 small">"{{ Str::limit($ulasan->ulasan, 80) }}"</p>
                        
                        <!-- Category -->
                        <span class="badge bg-light text-dark small">
                            <i class="fas fa-tag me-1"></i>{{ $ulasan->kategori }}
                        </span>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted">Tampilan di website</small>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

.info-row:last-child {
    border-bottom: none;
}

.badge-status {
    font-size: 0.85em;
    padding: 8px 12px;
}

@media (max-width: 992px) {
    .col-lg-7, .col-lg-5 {
        margin-bottom: 1rem;
    }
}

.blockquote p {
    font-style: italic;
    line-height: 1.6;
}
</style>
@endpush

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

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comment-alt me-2"></i>Ulasan dari {{ $ulasan->nama }}
                    </h6>
                </div>
                <div class="card-body">
                    <!-- User Info Section -->
                    <div class="user-info-section p-3 rounded mb-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="fw-bold mb-1">{{ $ulasan->nama }}</h6>
                                <small class="text-muted d-block">
                                    <i class="fas fa-envelope me-1"></i>{{ $ulasan->email }}
                                </small>
                                @if($ulasan->instansi)
                                <small class="text-muted d-block">
                                    <i class="fas fa-building me-1"></i>{{ $ulasan->instansi }}
                                </small>
                                @endif
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-info badge-status">
                                    <i class="fas fa-tag me-1"></i>{{ $ulasan->kategori }}
                                </span>
                                <div class="text-muted small mt-1">
                                    <i class="fas fa-calendar me-1"></i>{{ $ulasan->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rating & Status -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="rating-section p-3 rounded">
                                <h6 class="mb-2"><i class="fas fa-star text-warning me-1"></i>Rating Keseluruhan</h6>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="text-warning fs-5">
                                        {!! $ulasan->getRatingStarsAttribute() !!}
                                    </div>
                                    <span class="badge bg-primary">{{ $ulasan->rating }}/5</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-2"><i class="fas fa-info-circle text-primary me-1"></i>Status</h6>
                            @if($ulasan->is_published)
                                <span class="badge bg-success badge-status mb-2">
                                    <i class="fas fa-check me-1"></i>Dipublikasikan
                                </span>
                            @else
                                <span class="badge bg-warning badge-status mb-2">
                                    <i class="fas fa-clock me-1"></i>Menunggu
                                </span>
                            @endif
                            
                            @if($ulasan->is_featured)
                                <br><span class="badge bg-primary badge-status">
                                    <i class="fas fa-star me-1"></i>Unggulan
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Ulasan Text -->
                    <div class="mb-4">
                        <h6><i class="fas fa-quote-left text-muted me-1"></i>Ulasan</h6>
                        <div class="bg-light p-3 rounded border-start border-primary border-3">
                            <blockquote class="blockquote mb-0">
                                <p class="mb-0">"{{ $ulasan->ulasan }}"</p>
                                <footer class="blockquote-footer mt-2">
                                    <cite title="Source Title">{{ $ulasan->nama }}</cite>
                                </footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Rating -->
            @if($ulasan->rating_detail && is_array($ulasan->rating_detail))
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Detail Penilaian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($ulasan->rating_detail as $key => $value)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 bg-light h-100 shadow-sm">
                                <div class="card-body text-center p-3">
                                    <div class="text-primary mb-2">
                                        <i class="fas fa-star-half-alt fs-5"></i>
                                    </div>
                                    <h6 class="card-title mb-2 small">{{ ucfirst($key) }}</h6>
                                    <div class="text-warning mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $value)
                                                <i class="fas fa-star small"></i>
                                            @else
                                                <i class="far fa-star small"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="badge bg-success small">{{ $value }}/5</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-6">
        <!-- Sidebar -->
        <div class="col-lg-5">
        <!-- Right Column -->
        <div class="col-lg-6">
            <div class="row g-4">
                <!-- Quick Actions -->
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-tools me-2"></i>Aksi Cepat
                            </h6>
                        </div>
                        <div class="card-body">
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
                                            {{ $ulasan->is_featured ? 'Hapus Unggulan' : 'Jadikan Unggulan' }}
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
                                            <img src="{{ asset('Icon/Delete.gif') }}" alt="Delete" style="width: 16px; height: 16px; margin-right: 5px;">
                                            Hapus Ulasan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Detail -->
                <div class="col-md-6">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Detail Info
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="info-row d-flex justify-content-between mb-2">
                                <small class="text-muted"><i class="fas fa-hashtag me-1"></i>ID:</small>
                                <strong class="text-primary">#{{ $ulasan->id }}</strong>
                            </div>
                            <div class="info-row d-flex justify-content-between mb-2">
                                <small class="text-muted"><i class="fas fa-calendar-plus me-1"></i>Dibuat:</small>
                                <strong>{{ $ulasan->created_at->format('d/m/Y') }}</strong>
                            </div>
                            <div class="info-row d-flex justify-content-between mb-2">
                                <small class="text-muted"><i class="fas fa-clock me-1"></i>Waktu:</small>
                                <strong>{{ $ulasan->created_at->format('H:i') }} WIB</strong>
                            </div>
                            <div class="info-row d-flex justify-content-between mb-2">
                                <small class="text-muted"><i class="fas fa-edit me-1"></i>Update:</small>
                                <strong>{{ $ulasan->updated_at->format('d/m/Y') }}</strong>
                            </div>
                            <hr class="my-2">
                            <div class="info-row d-flex justify-content-between mb-2">
                                <small class="text-muted"><i class="fas fa-spell-check me-1"></i>Kata:</small>
                                <strong class="text-success">{{ str_word_count($ulasan->ulasan) }}</strong>
                            </div>
                            <div class="info-row d-flex justify-content-between">
                                <small class="text-muted"><i class="fas fa-text-width me-1"></i>Karakter:</small>
                                <strong class="text-info">{{ strlen($ulasan->ulasan) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                @if($ulasan->is_published)
                <div class="col-md-6">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-eye me-2"></i>Preview Web
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="border rounded p-3" style="background: #f8f9fa; font-size: 0.9em;">
                                <!-- Rating Display -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="text-warning">
                                        {!! $ulasan->getRatingStarsAttribute() !!}
                                    </div>
                                    <span class="badge bg-primary small">{{ $ulasan->rating }}/5</span>
                                </div>
                                
                                <!-- User Info -->
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i class="fas fa-user text-primary small"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 small">{{ $ulasan->nama }}</h6>
                                        <small class="text-muted">{{ $ulasan->created_at->format('d M Y') }}</small>
                                        @if($ulasan->instansi)
                                            <br><small class="text-muted">{{ $ulasan->instansi }}</small>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Review Content -->
                                <p class="text-muted mb-2 small">"{{ Str::limit($ulasan->ulasan, 80) }}"</p>
                                
                                <!-- Service Category -->
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-tag me-1"></i>{{ $ulasan->kategori }}
                                </span>
                            </div>
                            
                            <div class="text-center mt-2">
                                <small class="text-muted">Tampilan di website</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
