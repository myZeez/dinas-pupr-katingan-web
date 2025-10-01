@extends('layouts.admin')

@section('title', 'Konten Public')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@endpush

@section('content')
    <style>
        /* Public Content Action Buttons - Outline Only Style */
        .admin-btn-action {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 0.25rem;
            transition: all 0.15s ease;
            min-width: 60px;
            text-align: center;
            background-color: transparent;
            border: 1px solid #dee2e6;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 0.2rem;
            color: #6c757d;
        }

        .admin-btn-action:hover {
            text-decoration: none;
            background-color: transparent;
            border-color: #adb5bd;
            color: #495057;
        }

        .admin-btn-action i {
            margin-right: 0.3rem;
            font-size: 0.75rem;
        }

        .admin-btn-group-vertical {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            align-items: stretch;
            min-width: 70px;
        }

        /* Outline button variants */
        .admin-btn-action.admin-btn-danger {
            color: #6c757d;
            border-color: #ced4da;
        }

        .admin-btn-action.admin-btn-danger:hover {
            color: #495057;
            border-color: #6c757d;
            background-color: transparent;
        }
    </style>
    <div class="container-fluid">
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
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
                    </div>
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="contentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="karousel-tab" data-bs-toggle="tab"
                                    data-bs-target="#karousel" type="button" role="tab">
                                    <i class="fas fa-images"></i> Karousel ({{ count($karousels) }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video"
                                    type="button" role="tab">
                                    <i class="fas fa-video"></i> Video ({{ count($videos) }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="mitra-tab" data-bs-toggle="tab" data-bs-target="#mitra"
                                    type="button" role="tab">
                                    <i class="fas fa-handshake"></i> Mitra ({{ count($mitras) }})
                                </button>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content mt-3" id="contentTabsContent">
                            <!-- Karousel Tab -->
                            <div class="tab-pane fade show active" id="karousel" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0"><i class="fas fa-images"></i> Karousel</h5>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#tambahKarouselModal">
                                        <i class="fas fa-plus"></i> Tambah Karousel
                                    </button>
                                </div>
                                <div class="row" id="karousel-list">
                                    @forelse($karousels as $item)
                                        <div class="col-md-4 mb-3" data-id="{{ $item->id }}">
                                            <div class="card">
                                                <div class="card-img-container" style="height: 200px; overflow: hidden;">
                                                    @if ($item->file_path)
                                                        <img src="{{ asset('storage/' . $item->file_path) }}"
                                                            class="card-img-top"
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div
                                                            class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                            <i class="fas fa-image fa-2x text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $item->judul }}</h6>
                                                    <p class="card-text small">{{ Str::limit($item->deskripsi, 50) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span
                                                            class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                                                            {{ $item->status }}
                                                        </span>
                                                        <div class="admin-btn-group-vertical">
                                                            <form
                                                                action="{{ route('admin.public-content.destroy', $item->id) }}"
                                                                method="POST" class="d-inline delete-form"
                                                                data-message="Apakah Anda yakin ingin menghapus konten karousel {{ $item->judul }}?">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="admin-btn-action admin-btn-danger">
                                                                    <i class="fas fa-trash"></i> Hapus
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0"><i class="fas fa-video"></i> Video</h5>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#tambahVideoModal">
                                        <i class="fas fa-plus"></i> Tambah Video
                                    </button>
                                </div>
                                <div class="row">
                                    @forelse($videos as $item)
                                        <div class="col-md-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $item->judul }}</h6>
                                                    <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>

                                                    @if ($item->youtube_url)
                                                        <div class="mb-2">
                                                            <small class="text-info">
                                                                <i class="fab fa-youtube"></i> YouTube:
                                                                <a href="{{ $item->youtube_url }}" target="_blank">Lihat
                                                                    Video</a>
                                                            </small>
                                                        </div>
                                                    @endif

                                                    @if ($item->file_path)
                                                        <div class="mb-2">
                                                            <small class="text-success">
                                                                <i class="fas fa-file-video"></i> File:
                                                                {{ $item->file_name }}
                                                            </small>
                                                        </div>
                                                    @endif

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span
                                                            class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                                                            {{ $item->status }}
                                                        </span>
                                                        <div class="admin-btn-group-vertical">
                                                            <form
                                                                action="{{ route('admin.public-content.destroy', $item->id) }}"
                                                                method="POST" class="d-inline delete-form"
                                                                data-message="Apakah Anda yakin ingin menghapus konten video {{ $item->judul }}?">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="admin-btn-action admin-btn-danger">
                                                                    <i class="fas fa-trash"></i> Hapus
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0"><i class="fas fa-handshake"></i> Mitra</h5>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#tambahMitraModal">
                                        <i class="fas fa-plus"></i> Tambah Mitra
                                    </button>
                                </div>
                                <div class="row" id="mitra-list">
                                    @forelse($mitras as $item)
                                        <div class="col-md-3 mb-3" data-id="{{ $item->id }}">
                                            <div class="card">
                                                <div class="card-img-container" style="height: 150px; overflow: hidden;">
                                                    @if ($item->file_path)
                                                        <img src="{{ asset('storage/' . $item->file_path) }}"
                                                            class="card-img-top"
                                                            style="width: 100%; height: 100%; object-fit: contain;">
                                                    @else
                                                        <div
                                                            class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                            <i class="fas fa-handshake fa-2x text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $item->judul }}</h6>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span
                                                            class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                                                            {{ $item->status }}
                                                        </span>
                                                        <div class="admin-btn-group-vertical">
                                                            <form
                                                                action="{{ route('admin.public-content.destroy', $item->id) }}"
                                                                method="POST" class="d-inline delete-form"
                                                                data-message="Apakah Anda yakin ingin menghapus konten mitra {{ $item->judul }}?">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="admin-btn-action admin-btn-danger">
                                                                    <i class="fas fa-trash"></i> Hapus
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

    <!-- Modal Tambah Karousel -->
    <div class="modal fade" id="tambahKarouselModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🎠 Tambah Karousel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="karouselForm" method="POST" action="{{ route('admin.public-content.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tipe" value="karousel">

                        <div class="form-group mb-3">
                            <label>Judul *</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Gambar Karousel *</label>
                            <input type="file" class="form-control" name="file"
                                accept="image/jpeg,image/png,image/jpg" required>
                            <small class="text-muted">Format: JPG, PNG (max: 10MB)</small>
                        </div>

                        <div class="form-group mb-3">
                            <label>Urutan <span class="badge bg-info" id="karouselSuggestedOrder">Auto</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="urutan" id="karouselUrutan"
                                    min="0" readonly>
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="toggleUrutanManual('karousel')" id="karouselManualBtn">
                                    <i class="fas fa-edit"></i> Manual
                                </button>
                            </div>
                            <small class="text-muted" id="karouselUrutanHelp">Urutan otomatis akan ditentukan
                                sistem</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Karousel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Video -->
    <div class="modal fade" id="tambahVideoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📹 Tambah Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="videoForm" method="POST" action="{{ route('admin.public-content.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tipe" value="video">

                        <div class="form-group mb-3">
                            <label>Judul Video *</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>YouTube URL</label>
                            <input type="url" class="form-control" name="youtube_url"
                                placeholder="https://www.youtube.com/watch?v=ABC123">
                            <small class="text-info">
                                <i class="fas fa-youtube text-danger"></i> Masukkan URL YouTube untuk video online
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label>Upload File Video</label>
                            <input type="file" class="form-control" name="file"
                                accept="video/mp4,video/mov,video/avi,video/webm,video/mkv">
                            <small class="text-muted">Format: MP4, MOV, AVI, WEBM, MKV (max: 100MB) - Opsional jika ada
                                YouTube URL</small>
                        </div>

                        <div class="form-group mb-3">
                            <label>Urutan <span class="badge bg-info" id="videoSuggestedOrder">Auto</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="urutan" id="videoUrutan"
                                    min="0" readonly>
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="toggleUrutanManual('video')" id="videoManualBtn">
                                    <i class="fas fa-edit"></i> Manual
                                </button>
                            </div>
                            <small class="text-muted" id="videoUrutanHelp">Urutan otomatis akan ditentukan sistem</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Mitra -->
    <div class="modal fade" id="tambahMitraModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🤝 Tambah Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="mitraForm" method="POST" action="{{ route('admin.public-content.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tipe" value="mitra">

                        <div class="form-group mb-3">
                            <label>Nama Mitra *</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="2" placeholder="Informasi tambahan tentang mitra"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Logo/Gambar Mitra *</label>
                            <input type="file" class="form-control" name="file"
                                accept="image/jpeg,image/png,image/jpg" required>
                            <small class="text-muted">Format: JPG, PNG (max: 5MB) - Disarankan rasio 1:1 atau logo
                                transparan</small>
                        </div>

                        <div class="form-group mb-3">
                            <label>Urutan <span class="badge bg-info" id="mitraSuggestedOrder">Auto</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="urutan" id="mitraUrutan"
                                    min="0" readonly>
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="toggleUrutanManual('mitra')" id="mitraManualBtn">
                                    <i class="fas fa-edit"></i> Manual
                                </button>
                            </div>
                            <small class="text-muted" id="mitraUrutanHelp">Urutan otomatis akan ditentukan sistem</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Mitra</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Automatic Ordering System
        const contentData = {
            karousel: @json($karousels->pluck('urutan')->toArray()),
            video: @json($videos->pluck('urutan')->toArray()),
            mitra: @json($mitras->pluck('urutan')->toArray())
        };

        // Function to get next available order number
        function getNextOrder(type) {
            const existingOrders = contentData[type].sort((a, b) => a - b);
            let nextOrder = 1;

            for (let order of existingOrders) {
                if (order === nextOrder) {
                    nextOrder++;
                } else {
                    break;
                }
            }

            return nextOrder;
        }

        // Function to initialize automatic ordering when modal opens
        function initializeAutoOrder(type) {
            const nextOrder = getNextOrder(type);
            const input = document.getElementById(`${type}Urutan`);
            const badge = document.getElementById(`${type}SuggestedOrder`);

            if (input && badge) {
                input.value = nextOrder;
                badge.textContent = `Auto: ${nextOrder}`;
                input.readOnly = true;

                console.log(`🎯 Auto order for ${type}:`, nextOrder);
            }
        }

        // Function to toggle manual/automatic ordering
        window.toggleUrutanManual = function(type) {
            const input = document.getElementById(`${type}Urutan`);
            const badge = document.getElementById(`${type}SuggestedOrder`);
            const btn = document.getElementById(`${type}ManualBtn`);
            const help = document.getElementById(`${type}UrutanHelp`);

            if (input.readOnly) {
                // Switch to manual mode
                input.readOnly = false;
                input.style.backgroundColor = '';
                btn.innerHTML = '<i class="fas fa-magic"></i> Auto';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-outline-primary');
                badge.textContent = 'Manual';
                badge.classList.remove('bg-info');
                badge.classList.add('bg-warning');
                help.textContent = 'Masukkan urutan secara manual (sistem akan cek duplikat)';

                // Add duplicate check
                input.addEventListener('blur', function() {
                    checkDuplicateOrder(type, this.value);
                });

            } else {
                // Switch to automatic mode
                const nextOrder = getNextOrder(type);
                input.value = nextOrder;
                input.readOnly = true;
                input.style.backgroundColor = '#e9ecef';
                btn.innerHTML = '<i class="fas fa-edit"></i> Manual';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-outline-secondary');
                badge.textContent = `Auto: ${nextOrder}`;
                badge.classList.remove('bg-warning');
                badge.classList.add('bg-info');
                help.textContent = 'Urutan otomatis akan ditentukan sistem';

                // Remove duplicate check listener
                input.removeEventListener('blur', checkDuplicateOrder);
            }
        };

        // Function to check duplicate orders
        function checkDuplicateOrder(type, value) {
            const existingOrders = contentData[type];
            const orderValue = parseInt(value);

            if (existingOrders.includes(orderValue)) {
                const nextAvailable = getNextOrder(type);

                Swal.fire({
                    icon: 'warning',
                    title: 'Urutan Sudah Digunakan',
                    text: `Urutan ${orderValue} sudah digunakan untuk ${type}. Urutan yang tersedia: ${nextAvailable}`,
                    showCancelButton: true,
                    confirmButtonText: `Gunakan ${nextAvailable}`,
                    cancelButtonText: 'Biarkan Manual'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const input = document.getElementById(`${type}Urutan`);
                        input.value = nextAvailable;
                        contentData[type].push(nextAvailable);
                    }
                });
            }
        }

        });

        // Initialize when modals are shown
        $(document).ready(function() {
            console.log('🔧 Document ready - initializing forms');

            // Modal reset for separate forms - FIXED
            $('.modal').on('hidden.bs.modal', function() {
                const modalId = this.id;
                if (modalId.includes('tambah')) {
                    const type = modalId.replace('tambah', '').replace('Modal', '').toLowerCase();
                    const input = document.getElementById(`${type}Urutan`);
                    const badge = document.getElementById(`${type}SuggestedOrder`);
                    const btn = document.getElementById(`${type}ManualBtn`);
                    const help = document.getElementById(`${type}UrutanHelp`);

                    if (input) {
                        input.readOnly = true;
                        input.style.backgroundColor = '#e9ecef';
                        input.value = '';

                        if (btn) {
                            btn.innerHTML = '<i class="fas fa-edit"></i> Manual';
                            btn.classList.remove('btn-outline-primary');
                            btn.classList.add('btn-outline-secondary');
                        }

                        if (badge) {
                            badge.textContent = 'Auto';
                            badge.classList.remove('bg-warning');
                            badge.classList.add('bg-info');
                        }

                        if (help) {
                            help.textContent = 'Urutan otomatis akan ditentukan sistem';
                        }
                    }
                }
            });

        }
        }
        });

        // Modal reset for separate forms - FIXED
        $('#tambahKarouselModal').on('show.bs.modal', function() {
            console.log('🎠 Resetting Karousel form');
            $('#karouselForm')[0].reset();
            initializeAutoOrder('karousel');
        });

        $('#tambahVideoModal').on('show.bs.modal', function() {
            console.log('📹 Resetting Video form');
            $('#videoForm')[0].reset();
            initializeAutoOrder('video');
        });

        $('#tambahMitraModal').on('show.bs.modal', function() {
        console.log('🤝 Resetting Mitra form');
        $('#mitraForm')[0].reset();
        initializeAutoOrder('mitra');
        });
        });
    </script>
@endpush
