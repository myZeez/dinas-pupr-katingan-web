@extends('layouts.admin')

@section('title', 'Demo Notifikasi GIF')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Demo Notifikasi GIF</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @include('components.gif-notifications')

    <!-- Demo GIF Icons Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <img src="{{ asset('Icon/Succes.gif') }}" alt="Success" style="width: 24px; height: 24px; margin-right: 8px;">
                        Icon GIF yang Tersedia
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <img src="{{ asset('Icon/Succes.gif') }}" alt="Success" style="width: 64px; height: 64px;">
                                <h6 class="mt-2">Success</h6>
                                <small class="text-muted">Untuk operasi berhasil</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <img src="{{ asset('Icon/Delete.gif') }}" alt="Delete" style="width: 64px; height: 64px;">
                                <h6 class="mt-2">Delete</h6>
                                <small class="text-muted">Untuk operasi hapus</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <img src="{{ asset('Icon/loading.gif') }}" alt="Loading" style="width: 64px; height: 64px;">
                                <h6 class="mt-2">Loading</h6>
                                <small class="text-muted">Untuk proses loading</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <img src="{{ asset('Icon/Done.gif') }}" alt="Done" style="width: 64px; height: 64px;">
                                <h6 class="mt-2">Done</h6>
                                <small class="text-muted">Untuk konfirmasi selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Buttons Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Demo Notifikasi</h6>
                </div>
                <div class="card-body">
                    <p class="mb-3">Klik tombol di bawah untuk melihat demo notifikasi GIF:</p>
                    
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <button onclick="showNotification('success')" class="btn btn-success w-100">
                                <img src="{{ asset('Icon/Succes.gif') }}" alt="Success" style="width: 20px; height: 20px; margin-right: 5px;">
                                Success
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button onclick="showNotification('error')" class="btn btn-danger w-100">
                                <img src="{{ asset('Icon/Delete.gif') }}" alt="Error" style="width: 20px; height: 20px; margin-right: 5px;">
                                Error
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button onclick="showNotification('info')" class="btn btn-info w-100">
                                <img src="{{ asset('Icon/Done.gif') }}" alt="Info" style="width: 20px; height: 20px; margin-right: 5px;">
                                Info
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button onclick="showNotification('warning')" class="btn btn-warning w-100">
                                <img src="{{ asset('Icon/loading.gif') }}" alt="Warning" style="width: 20px; height: 20px; margin-right: 5px;">
                                Warning
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Implementation Guide -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panduan Implementasi</h6>
                </div>
                <div class="card-body">
                    <h6>1. Di Controller:</h6>
                    <pre class="bg-light p-3 rounded"><code>return redirect()->back()->with('success', 'Data berhasil disimpan!');</code></pre>
                    
                    <h6 class="mt-3">2. Di View (sudah otomatis include):</h6>
                    <pre class="bg-light p-3 rounded"><code>@include('components.gif-notifications')</code></pre>
                    
                    <h6 class="mt-3">3. Jenis Session yang Didukung:</h6>
                    <ul class="list-unstyled">
                        <li><code class="text-success">success</code> - <img src="{{ asset('Icon/Succes.gif') }}" alt="Success" style="width: 16px; height: 16px;"> Sukses</li>
                        <li><code class="text-danger">error</code> - <img src="{{ asset('Icon/Delete.gif') }}" alt="Error" style="width: 16px; height: 16px;"> Error</li>
                        <li><code class="text-info">info</code> - <img src="{{ asset('Icon/Done.gif') }}" alt="Info" style="width: 16px; height: 16px;"> Informasi</li>
                        <li><code class="text-warning">warning</code> - <img src="{{ asset('Icon/loading.gif') }}" alt="Warning" style="width: 16px; height: 16px;"> Peringatan</li>
                    </ul>

                    <h6 class="mt-3">4. Contoh Penggunaan di Form:</h6>
                    <pre class="bg-light p-3 rounded"><code>&lt;button type="submit" class="btn btn-primary"&gt;
    &lt;img src="{{ asset('Icon/Succes.gif') }}" alt="Save" style="width: 20px; height: 20px; margin-right: 5px;"&gt;
    Simpan Data
&lt;/button&gt;</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showNotification(type) {
    // Simulasi notifikasi dengan membuat elemen DOM secara dinamis
    const messages = {
        'success': 'Operasi berhasil dilakukan!',
        'error': 'Terjadi kesalahan dalam proses!',
        'info': 'Informasi penting untuk Anda.',
        'warning': 'Perhatian diperlukan pada proses ini.'
    };

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
            <strong>${messages[type]}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);

    $('body').append(notification);

    // Auto hide setelah 5 detik
    setTimeout(() => {
        notification.fadeOut(() => notification.remove());
    }, 5000);
}
</script>
@endpush