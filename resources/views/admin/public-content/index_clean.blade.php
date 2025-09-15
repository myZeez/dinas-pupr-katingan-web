@extends('layouts.admin')

@section('title', 'Konten Public')

@section('content')
<div class="container-fluid">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Konten Public</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            <i class="fas fa-plus"></i> Tambah Konten
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="contentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="karousel-tab" data-bs-toggle="tab" data-bs-target="#karousel" type="button" role="tab">
                                <i class="fas fa-images"></i> Karousel ({{ count($karousels) }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab">
                                <i class="fas fa-video"></i> Video ({{ count($videos) }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mitra-tab" data-bs-toggle="tab" data-bs-target="#mitra" type="button" role="tab">
                                <i class="fas fa-handshake"></i> Mitra ({{ count($mitras) }})
                            </button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3" id="contentTabsContent">
                        <!-- Karousel Tab -->
                        <div class="tab-pane fade show active" id="karousel" role="tabpanel">
                            <div class="row" id="karousel-list">
                                @forelse($karousels as $item)
                                <div class="col-md-4 mb-3" data-id="{{ $item->id }}">
                                    <div class="card">
                                        <div class="card-img-container" style="height: 200px; overflow: hidden;">
                                            @if($item->file_path)
                                                <img src="{{ asset('storage/' . $item->file_path) }}" class="card-img-top" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $item->judul }}</h6>
                                            <p class="card-text small">{{ Str::limit($item->deskripsi, 50) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </span>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary btn-edit" data-item="{{ json_encode($item) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.public-content.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" data-confirm-delete data-item-name="konten">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="text-center py-4">
                                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada karousel</p>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Video Tab -->
                        <div class="tab-pane fade" id="video" role="tabpanel">
                            <div class="row">
                                @forelse($videos as $item)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $item->judul }}</h6>
                                            <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>
                                            
                                            @if($item->youtube_url)
                                                <div class="mb-2">
                                                    <small class="text-info">
                                                        <i class="fab fa-youtube"></i> YouTube: 
                                                        <a href="{{ $item->youtube_url }}" target="_blank">Lihat Video</a>
                                                    </small>
                                                </div>
                                            @endif
                                            
                                            @if($item->file_path)
                                                <div class="mb-2">
                                                    <small class="text-success">
                                                        <i class="fas fa-file-video"></i> File: {{ $item->file_name }}
                                                    </small>
                                                </div>
                                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </span>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary btn-edit" data-item="{{ json_encode($item) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.public-content.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" data-confirm-delete data-item-name="konten">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="text-center py-4">
                                        <i class="fas fa-video fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada video</p>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Mitra Tab -->
                        <div class="tab-pane fade" id="mitra" role="tabpanel">
                            <div class="row" id="mitra-list">
                                @forelse($mitras as $item)
                                <div class="col-md-3 mb-3" data-id="{{ $item->id }}">
                                    <div class="card">
                                        <div class="card-img-container" style="height: 150px; overflow: hidden;">
                                            @if($item->file_path)
                                                <img src="{{ asset('storage/' . $item->file_path) }}" class="card-img-top" style="width: 100%; height: 100%; object-fit: contain;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                    <i class="fas fa-handshake fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $item->judul }}</h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </span>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary btn-edit" data-item="{{ json_encode($item) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.public-content.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" data-confirm-delete data-item-name="konten">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="text-center py-4">
                                        <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada mitra</p>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Konten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="kontenForm" method="POST" action="{{ route('admin.public-content.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="method" name="_method" value="POST">
                    <input type="hidden" id="item_id" name="item_id">
                    
                    <div class="form-group mb-3">
                        <label>Tipe Konten *</label>
                        <select class="form-control" name="tipe" id="tipe" required>
                            <option value="">Pilih Tipe</option>
                            <option value="karousel">Karousel</option>
                            <option value="video">Video</option>
                            <option value="mitra">Mitra</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Judul *</label>
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>File *</label>
                        <input type="file" class="form-control" name="file" id="file" accept="image/*,video/*">
                        <small class="text-muted">
                            Karousel & Mitra: JPG, PNG (max: 100MB) | Video: MP4, MOV, AVI, WEBM, MKV (max: 2GB)
                        </small>
                    </div>

                    <!-- YouTube Field - Normal Mode -->
                    <div class="form-group mb-3" id="youtube-field" style="display: none; border: 2px solid #007bff; padding: 10px; background-color: #f8f9fa;">
                        <label class="fw-bold text-primary">🎥 YouTube URL (Untuk Video)</label>
                        <input type="url" class="form-control border-primary" name="youtube_url" id="youtube_url" placeholder="https://www.youtube.com/watch?v=ABC123 atau https://youtu.be/ABC123">
                        <small class="text-info">
                            <i class="fas fa-info-circle"></i> Jika diisi, video akan ditampilkan dari YouTube. File upload menjadi opsional.
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Urutan</label>
                                <input type="number" class="form-control" name="urutan" id="urutan" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6" id="status-group" style="display: none;">
                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="aktif">Aktif</option>
                                    <option value="non-aktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// YouTube Toggle Script - CLEAN VERSION
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 YouTube toggle script loaded');
    
    const tipeSelect = document.getElementById('tipe');
    const youtubeField = document.getElementById('youtube-field');
    
    if (tipeSelect && youtubeField) {
        tipeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            console.log('🔄 Selected:', selectedType);
            
            if (selectedType === 'video') {
                youtubeField.style.display = 'block';
                console.log('✅ YouTube field shown');
            } else {
                youtubeField.style.display = 'none';
                document.getElementById('youtube_url').value = '';
                console.log('✅ YouTube field hidden');
            }
        });
    }
    
    // Modal reset
    const modal = document.getElementById('tambahModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', function() {
            setTimeout(function() {
                document.getElementById('tipe').value = '';
                document.getElementById('youtube-field').style.display = 'none';
                document.getElementById('youtube_url').value = '';
            }, 50);
        });
    }
});
</script>
@endpush
