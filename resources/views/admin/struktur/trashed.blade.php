@extends('layouts.app')

@section('title', 'Data Struktur Terhapus')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Struktur Terhapus</h5>
                <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Struktur
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($strukturs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Urutan</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    <th>Golongan</th>
                                    <th>Status</th>
                                    <th>Tanggal Dihapus</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($strukturs as $struktur)
                                    <tr>
                                        <td>{{ $struktur->urutan }}</td>
                                        <td>
                                            @if($struktur->foto)
                                                <img src="{{ asset('storage/' . $struktur->foto) }}" 
                                                     alt="Foto {{ $struktur->nama }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 50px">
                                            @else
                                                <span class="text-muted">No Photo</span>
                                            @endif
                                        </td>
                                        <td>{{ $struktur->nama }}</td>
                                        <td>{{ $struktur->nip ?? '-' }}</td>
                                        <td>{{ $struktur->jabatan }}</td>
                                        <td>{{ $struktur->unit_kerja ?? '-' }}</td>
                                        <td>{{ $struktur->golongan ?? '-' }}</td>
                                        <td>
                                            @if($struktur->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $struktur->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('admin.struktur.restore', $struktur->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-success" 
                                                            style="border-radius: 6px 0 0 6px;"
                                                            title="Pulihkan"
                                                            data-confirm-status data-status="dipulihkan" data-item-name="struktur">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.struktur.force-delete', $struktur->id) }}" 
                                                      method="POST" 
                                                      class="d-inline delete-form"
                                                      data-message="Apakah Anda yakin ingin menghapus PERMANEN struktur {{ $struktur->nama }}? Tindakan ini tidak dapat dibatalkan!">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            style="border-radius: 0 6px 6px 0;"
                                                            title="Hapus Permanen">
                                                        <i class="bi bi-trash3"></i>
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
                        <i class="bi bi-trash3" style="font-size: 4rem; color: #dee2e6;"></i>
                        <h4 class="mt-3 text-muted">Tidak Ada Data Terhapus</h4>
                        <p class="text-muted">Belum ada data struktur yang dihapus.</p>
                        <a href="{{ route('admin.struktur.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Struktur
                        </a>
                    </div>
                @endif
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
