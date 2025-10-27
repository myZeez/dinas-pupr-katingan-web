@extends('layouts.admin')

@section('title', 'Demo Konfirmasi Delete')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Demo Konfirmasi Delete</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @include('components.gif-notifications')

    <!-- Demo Delete Confirmation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <img src="{{ asset('Icon/Delete.gif') }}" alt="Delete" style="width: 24px; height: 24px; margin-right: 8px;">
                        Sistem Konfirmasi Delete Universal
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="bi bi-info-circle"></i> Fitur yang Telah Diimplementasikan:</h5>
                        <ul class="mb-0">
                            <li>✅ <strong>White Theme Modal</strong> - Background putih bersih</li>
                            <li>✅ <strong>Simplified Design</strong> - Tanpa gradients atau shadow berlebihan</li>
                            <li>✅ <strong>Clean Icon Containers</strong> - Background warna pastel yang lembut</li>
                            <li>✅ <strong>Standard Button Colors</strong> - Warna Bootstrap standar</li>
                            <li>✅ <strong>Loading overlay dengan loading.gif</strong></li>
                            <li>✅ Auto-processing indicators saat submit</li>
                            <li>✅ Unified confirmation system untuk semua actions</li>
                            <li>✅ Responsive design untuk mobile</li>
                            <li>✅ Smooth animations dan transitions</li>
                        </ul>
                    </div>

                    <h6 class="mt-4 mb-3">Demo Berbagai Jenis Konfirmasi:</h6>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <form class="delete-form" data-message="Apakah Anda yakin ingin menghapus data demo ini?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" style="background: #dc3545; color: white; border: none; border-radius: 8px; padding: 12px;">
                                    <img src="{{ asset('Icon/Delete.gif') }}" alt="Delete" style="width: 20px; height: 20px; margin-right: 5px;">
                                    Delete Normal
                                </button>
                            </form>
                        </div>

                        <div class="col-md-3 mb-3">
                            <form class="delete-form" data-message="PERINGATAN: Data akan dihapus PERMANEN dan tidak dapat dikembalikan!">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning w-100" style="background: #ffc107; color: #212529; border: none; border-radius: 8px; padding: 12px;">
                                    <img src="{{ asset('Icon/Delete.gif') }}" alt="Delete" style="width: 20px; height: 20px; margin-right: 5px;">
                                    Force Delete
                                </button>
                            </form>
                        </div>

                        <div class="col-md-3 mb-3">
                            <button onclick="demoConfirmAction()" class="btn btn-info w-100" style="background: linear-gradient(135deg, #17a2b8, #138496); border: none; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);">
                                <img src="{{ asset('Icon/Done.gif') }}" alt="Confirm" style="width: 20px; height: 20px; margin-right: 5px;">
                                Custom Action
                            </button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <button onclick="demoBatchDelete()" class="btn btn-secondary w-100" style="background: linear-gradient(135deg, #6c757d, #545b62); border: none; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);">
                                <img src="{{ asset('Icon/Delete.gif') }}" alt="Batch" style="width: 20px; height: 20px; margin-right: 5px;">
                                Batch Delete (5 items)
                            </button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <button onclick="demoWarningAction()" class="btn btn-warning w-100" style="background: linear-gradient(135deg, #ffc107, #e0a800); border: none; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
                                <img src="{{ asset('Icon/loading.gif') }}" alt="Warning" style="width: 20px; height: 20px; margin-right: 5px;">
                                Warning Action
                            </button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <button onclick="demoSuccessAction()" class="btn btn-success w-100" style="background: linear-gradient(135deg, #28a745, #208637); border: none; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
                                <img src="{{ asset('Icon/Succes.gif') }}" alt="Success" style="width: 20px; height: 20px; margin-right: 5px;">
                                Success Action
                            </button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <button onclick="demoLoadingOverlay()" class="btn w-100" style="background: linear-gradient(135deg, #6f42c1, #5a2d91); color: white; border: none; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);">
                                <img src="{{ asset('Icon/loading.gif') }}" alt="Loading" style="width: 20px; height: 20px; margin-right: 5px;">
                                Demo Loading
                            </button>
                        </div>

                        <div class="col-md-3 mb-3">
                            <button onclick="demoRestoreAction()" class="btn w-100" style="background: linear-gradient(135deg, #20c997, #17a085); color: white; border: none; border-radius: 12px; padding: 12px; box-shadow: 0 4px 15px rgba(32, 201, 151, 0.3);">
                                <img src="{{ asset('Icon/Succes.gif') }}" alt="Restore" style="width: 20px; height: 20px; margin-right: 5px;">
                                Demo Restore
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Implementation Status -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <img src="{{ asset('Icon/Succes.gif') }}" alt="Success" style="width: 24px; height: 24px; margin-right: 8px;">
                        Status Implementasi di Halaman Admin
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">✅ Telah Diimplementasikan:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Berita:</strong> Index & Show pages
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Video:</strong> Index, Show, Create, Edit pages
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Complaints:</strong> Index page
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Ulasan:</strong> Index & Show pages
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Struktur:</strong> Index & Trashed pages
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Pengaduan:</strong> Index & Show pages
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Program:</strong> Index & Show pages
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Public Content:</strong> All sections (Karousel, Video, Mitra)
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Activity Log:</strong> Cleanup operation
                                </li>
                                <li class="mb-1">
                                    <span class="badge bg-success me-2">✓</span>
                                    <strong>Soft Deleted:</strong> Force delete & cleanup operations
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-info">📋 Cara Penggunaan:</h6>
                            <div class="bg-light p-3 rounded">
                                <h6>1. Untuk Form Delete Modern:</h6>
                                <pre class="mb-2"><code>&lt;form class="delete-form" data-message="Pesan custom"&gt;
    @csrf @method('DELETE')
    &lt;button type="submit" class="btn btn-danger" 
            style="background: linear-gradient(135deg, #ff6b6b, #ee5a52); 
                   border: none; border-radius: 12px; padding: 12px; 
                   box-shadow: 0 4px 15px rgba(238, 90, 82, 0.3);"&gt;
        &lt;img src="{{ asset('Icon/Delete.gif') }}" 
             style="width: 20px; height: 20px; margin-right: 5px;"&gt;
        Hapus
    &lt;/button&gt;
&lt;/form&gt;</code></pre>

                                <h6>2. Untuk Konfirmasi Custom Modern:</h6>
                                <pre class="mb-2"><code>const confirmed = await confirmAction(
    'Pesan konfirmasi',
    'info', // info, warning, success, delete
    'Ya, Lakukan'
);
if (confirmed) {
    // Lakukan aksi
}</code></pre>

                                <h6>3. Untuk Batch Delete Modern:</h6>
                                <pre class="mb-0"><code>const confirmed = await confirmBatchDelete(5);
if (confirmed) {
    // Lakukan batch delete
}</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mt-4">
                        <h6><i class="bi bi-check-circle"></i> Sistem Telah Aktif!</h6>
                        <p class="mb-0">
                            Konfirmasi delete dengan GIF telah diterapkan ke semua halaman admin. 
                            Sistem akan otomatis mendeteksi form dengan class <code>delete-form</code> 
                            dan menampilkan modal konfirmasi yang menarik dengan animasi GIF.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Demo function untuk custom action
async function demoConfirmAction() {
    const confirmed = await confirmAction(
        'Apakah Anda yakin ingin melakukan aksi custom ini?',
        'info',
        'Ya, Lakukan'
    );
    
    if (confirmed) {
        showDemoNotification('success', 'Aksi custom berhasil dilakukan!');
    }
}

// Demo function untuk warning action
async function demoWarningAction() {
    const confirmed = await confirmAction(
        'Tindakan ini memerlukan perhatian khusus. Lanjutkan?',
        'warning',
        'Ya, Saya Mengerti'
    );
    
    if (confirmed) {
        showDemoNotification('warning', 'Aksi warning berhasil dikonfirmasi!');
    }
}

// Demo function untuk success action
async function demoSuccessAction() {
    const confirmed = await confirmAction(
        'Konfirmasi untuk melakukan aksi positif ini?',
        'success',
        'Ya, Setuju'
    );
    
    if (confirmed) {
        showDemoNotification('success', 'Aksi berhasil dikonfirmasi!');
    }
}

// Demo function untuk batch delete
async function demoBatchDelete() {
    const confirmed = await confirmBatchDelete(5);
    
    if (confirmed) {
        showDemoNotification('success', '5 item berhasil dihapus!');
    }
}

// Demo function untuk loading overlay
function demoLoadingOverlay() {
    showLoadingOverlay('Demonstrasi loading dengan GIF animasi...');
    
    // Auto hide setelah 3 detik untuk demo
    setTimeout(() => {
        hideLoadingOverlay();
        showDemoNotification('success', 'Loading selesai!');
    }, 3000);
}

// Demo function untuk restore action
async function demoRestoreAction() {
    const confirmed = await confirmAction(
        'Apakah Anda yakin ingin memulihkan data ini?',
        'success',
        'Ya, Restore'
    );
    
    if (confirmed) {
        showLoadingOverlay('Memproses restore data...');
        
        // Simulasi proses restore
        setTimeout(() => {
            hideLoadingOverlay();
            showDemoNotification('success', 'Data berhasil di-restore!');
        }, 2000);
    }
}

// Function untuk menampilkan demo notification
function showDemoNotification(type, message) {
    const icons = {
        'success': '{{ asset("Icon/Succes.gif") }}',
        'error': '{{ asset("Icon/Delete.gif") }}',
        'info': '{{ asset("Icon/Done.gif") }}',
        'warning': '{{ asset("Icon/loading.gif") }}'
    };

    const colors = {
        'success': 'alert-success',
        'error': 'alert-danger',
        'info': 'alert-info',
        'warning': 'alert-warning'
    };

    // Hapus notifikasi yang ada
    $('.demo-notification').remove();

    // Buat notifikasi baru
    const notification = $(`
        <div class="alert ${colors[type]} alert-dismissible fade show demo-notification" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <img src="${icons[type]}" alt="${type}" style="width: 24px; height: 24px; margin-right: 8px;">
            <strong>${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);

    $('body').append(notification);

    // Auto hide setelah 3 detik
    setTimeout(() => {
        notification.fadeOut(() => notification.remove());
    }, 3000);
}

// Override form submission untuk demo (mencegah submit asli)
$(document).ready(function() {
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        // Demo saja, tidak submit ke server
        showDemoNotification('success', 'Demo berhasil! (Tidak ada data yang benar-benar dihapus)');
    });
});
</script>
@endpush
