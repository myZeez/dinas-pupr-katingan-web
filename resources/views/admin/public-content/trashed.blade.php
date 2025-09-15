@extends('layouts.admin')

@section('title', 'Konten Public - Dihapus')

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
    min-width: 80px;
}

/* Outline button variants */
.admin-btn-action.admin-btn-success {
    color: #6c757d;
    border-color: #ced4da;
}

.admin-btn-action.admin-btn-success:hover {
    color: #495057;
    border-color: #6c757d;
    background-color: transparent;
}

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
                    <h3 class="card-title">Konten Public yang Dihapus</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.public-content.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($trashedContent->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Tipe</th>
                                        <th width="20%">Judul</th>
                                        <th width="25%">Deskripsi</th>
                                        <th width="10%">File</th>
                                        <th width="10%">YouTube</th>
                                        <th width="10%">Tanggal Hapus</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trashedContent as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($item->tipe) }}</span>
                                        </td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ Str::limit($item->deskripsi ?? '-', 50) }}</td>
                                        <td class="text-center">
                                            @if($item->file_path)
                                                <i class="fas fa-file text-success" title="{{ $item->file_name }}"></i>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->youtube_url)
                                                <a href="{{ $item->youtube_url }}" target="_blank" class="text-danger">
                                                    <i class="fab fa-youtube"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <small>{{ $item->deleted_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="admin-btn-group-vertical">
                                                <form action="{{ route('admin.public-content.restore', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="admin-btn-action admin-btn-success" data-confirm-status data-status="dikembalikan" data-item-name="konten">
                                                        <i class="fas fa-undo"></i> Restore
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.public-content.force-delete', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-btn-action admin-btn-danger" data-confirm-delete data-item-name="konten (PERMANEN)">
                                                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Data Terhapus</h5>
                            <p class="text-muted">Tidak ada data Konten_public yang dihapus.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
document.addEventListener('DOMContentLoaded', function() {
    // Handle restore confirmation dengan sistem yang konsisten
    document.querySelectorAll('[data-confirm-status]').forEach(function(button) {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const itemName = this.getAttribute('data-item-name') || 'item';
            
            const confirmed = await confirmAction(
                `Apakah Anda yakin ingin memulihkan ${itemName}?`,
                'success',
                'Ya, Restore'
            );
            
            if (confirmed) {
                // Tampilkan loading
                showLoadingOverlay('Memproses restore data...');
                form.submit();
            }
        });
    });

    // Handle permanent delete confirmation dengan sistem yang konsisten
    document.querySelectorAll('[data-confirm-delete]').forEach(function(button) {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const itemName = this.getAttribute('data-item-name') || 'item';
            
            const confirmed = await confirmAction(
                `PERINGATAN: ${itemName} akan dihapus PERMANEN dan tidak dapat dikembalikan!`,
                'delete',
                'Ya, Hapus Permanen'
            );
            
            if (confirmed) {
                // Tampilkan loading
                showLoadingOverlay('Menghapus data secara permanen...');
                form.submit();
            }
        });
    });
});

// Function untuk menampilkan loading overlay
function showLoadingOverlay(message) {
    // Hapus overlay yang ada jika ada
    const existingOverlay = document.getElementById('loadingOverlay');
    if (existingOverlay) {
        existingOverlay.remove();
    }
    
    // Buat loading overlay
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    `;
    
    overlay.innerHTML = `
        <div style="
            background: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 300px;
            width: 90%;
        ">
            <img src="{{ asset('icon/loading.gif') }}" alt="Loading" style="width: 64px; height: 64px; margin-bottom: 1rem;">
            <h5 style="margin: 0 0 0.5rem 0; color: #333; font-weight: 600;">Memproses...</h5>
            <p style="margin: 0; color: #666; font-size: 14px;">${message}</p>
        </div>
    `;
    
    document.body.appendChild(overlay);
    
    // Auto hide setelah 10 detik sebagai fallback
    setTimeout(() => {
        if (document.getElementById('loadingOverlay')) {
            overlay.remove();
        }
    }, 10000);
}
</script>

<!-- Load SweetAlert2 first -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Then load our custom notifications -->
<script src="{{ asset('js/admin-notifications-new.js') }}"></script>
@endsection
