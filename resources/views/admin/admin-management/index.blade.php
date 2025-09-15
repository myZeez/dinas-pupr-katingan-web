@extends('layouts.admin')

@section('title', 'Manajemen Admin')

@section('content')
    <style>
        /* Admin Management Action Buttons - Outline Only */
        .admin-btn-action {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 0.25rem;
            transition: all 0.15s ease;
            min-width: 70px;
            text-align: center;
            background-color: transparent;
            border: 1px solid #dee2e6;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 0.2rem;
            color: #6c757d;
            cursor: pointer;
            pointer-events: auto;
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
        }

        /* Outline button variants - no fill, only border colors */
        .admin-btn-action.admin-btn-edit {
            color: #6c757d;
            border-color: #ced4da;
        }

        .admin-btn-action.admin-btn-edit:hover {
            color: #495057;
            border-color: #6c757d;
            background-color: transparent;
        }

        .admin-btn-action.admin-btn-warning {
            color: #6c757d;
            border-color: #ced4da;
        }

        .admin-btn-action.admin-btn-warning:hover {
            color: #495057;
            border-color: #6c757d;
            background-color: transparent;
        }

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

        /* Admin action column styling */
        .admin-action-column {
            min-width: 80px;
            vertical-align: middle;
        }

        /* Modal Reset Password Animations */
        .warning-icon-container {
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
        }

        .warning-icon {
            font-size: 3.5rem;
            color: #ffc107;
            position: relative;
            z-index: 2;
            animation: iconBounce 2s infinite ease-in-out;
        }

        .icon-pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 80px;
            height: 80px;
            border: 3px solid #ffc107;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: pulseRing 2s infinite ease-out;
            opacity: 0;
        }

        @keyframes iconBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulseRing {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.4);
                opacity: 0;
            }
        }

        /* Modal Custom Styling */
        #resetPasswordModal .modal-content {
            border-radius: 15px;
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        }

        #resetPasswordModal .alert {
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        #resetPasswordModal .btn {
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        #resetPasswordModal .btn-warning {
            background: linear-gradient(45deg, #ffc107, #ffb300);
            border: none;
            color: #fff;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }

        #resetPasswordModal .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        }

        #resetPasswordModal .btn-light {
            background-color: #e9ecef;
            border: 1px solid #dee2e6;
            color: #6c757d;
        }

        #resetPasswordModal .btn-light:hover {
            background-color: #f8f9fa;
            border-color: #adb5bd;
            transform: translateY(-1px);
        }

        /* Loading Spinner Animation */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        /* Success Animation */
        #resetPasswordModal .btn-success {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: #fff;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        /* Fade in animation for modal */
        #resetPasswordModal.fade .modal-dialog {
            transition: transform 0.4s ease-out;
            transform: translateY(-50px);
        }

        #resetPasswordModal.show .modal-dialog {
            transform: translateY(0);
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1">🎩 Manajemen Admin</h1>
                        <p class="text-muted mb-0">Kelola akun administrator sistem</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.admin-management.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Admin Baru
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-users text-primary fs-1 mb-2"></i>
                                <h4 class="mb-1">{{ $statistics['total_admins'] }}</h4>
                                <small class="text-muted">Total Admin</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-crown text-warning fs-1 mb-2"></i>
                                <h4 class="mb-1">{{ $statistics['super_admins'] }}</h4>
                                <small class="text-muted">Super Admin</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-user-tie text-info fs-1 mb-2"></i>
                                <h4 class="mb-1">{{ $statistics['regular_admins'] }}</h4>
                                <small class="text-muted">Admin Biasa</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-check-circle text-success fs-1 mb-2"></i>
                                <h4 class="mb-1">{{ $statistics['active_admins'] }}</h4>
                                <small class="text-muted">Aktif</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-times-circle text-danger fs-1 mb-2"></i>
                                <h4 class="mb-1">{{ $statistics['inactive_admins'] }}</h4>
                                <small class="text-muted">Tidak Aktif</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin List -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Daftar Admin</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($admins->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Admin</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Terakhir Login</th>
                                            <th>Dibuat</th>
                                            <th width="100" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admins as $admin)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-3">
                                                            @if ($admin->avatar)
                                                                <img src="{{ asset('storage/' . $admin->avatar) }}"
                                                                    alt="{{ $admin->name }}" class="rounded-circle"
                                                                    width="40" height="40">
                                                            @else
                                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div>
                                                            <h6 class="mb-1">{{ $admin->name }}</h6>
                                                            <small class="text-muted">{{ $admin->email }}</small>
                                                            @if ($admin->phone)
                                                                <br><small class="text-muted">{{ $admin->phone }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($admin->isSuperAdmin())
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-crown me-1"></i>Super Admin
                                                        </span>
                                                    @else
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-user-tie me-1"></i>Admin
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($admin->status)
                                                        @case('active')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i>Aktif
                                                            </span>
                                                        @break

                                                        @case('inactive')
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                                                            </span>
                                                        @break

                                                        @case('suspended')
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-ban me-1"></i>Disuspend
                                                            </span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if ($admin->last_login_at)
                                                        <small>{{ $admin->last_login_at->format('d/m/Y H:i') }}</small>
                                                    @else
                                                        <small class="text-muted">Belum pernah login</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small>{{ $admin->created_at->format('d/m/Y') }}</small>
                                                </td>
                                                <td class="admin-action-column">
                                                    <div class="admin-btn-group-vertical">
                                                        <!-- Edit -->
                                                        <a href="{{ route('admin.admin-management.edit', $admin) }}"
                                                            class="admin-btn-action admin-btn-edit" title="Edit Admin">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <!-- Reset Password -->
                                                        <button type="button"
                                                            class="admin-btn-action admin-btn-warning reset-password-btn"
                                                            data-admin-id="{{ $admin->id }}"
                                                            data-admin-name="{{ $admin->name }}" title="Reset Password"
                                                            style="cursor: pointer;">
                                                            <i class="fas fa-key"></i> Reset
                                                        </button>

                                                        <!-- Toggle Status -->
                                                        @if ($admin->id !== auth()->id())
                                                            <form method="POST"
                                                                action="{{ route('admin.admin-management.toggle-status', $admin) }}"
                                                                style="display: inline;">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="admin-btn-action admin-btn-{{ $admin->status === 'active' ? 'danger' : 'success' }}"
                                                                    title="{{ $admin->status === 'active' ? 'Suspend' : 'Aktifkan' }}"
                                                                    data-confirm-status
                                                                    data-status="{{ $admin->status === 'active' ? 'suspend' : 'aktif' }}"
                                                                    data-item-name="admin {{ $admin->name }}">
                                                                    <i
                                                                        class="fas fa-{{ $admin->status === 'active' ? 'ban' : 'check' }}"></i>
                                                                    {{ $admin->status === 'active' ? 'Suspend' : 'Aktifkan' }}
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <!-- Delete -->
                                                        @if ($admin->id !== auth()->id())
                                                            <form method="POST"
                                                                action="{{ route('admin.admin-management.destroy', $admin) }}"
                                                                style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="admin-btn-action admin-btn-danger"
                                                                    title="Hapus Admin" data-confirm-delete
                                                                    data-item-name="admin {{ $admin->name }}">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($admins->hasPages())
                                <div class="card-footer bg-white">
                                    @include('components.custom-pagination', ['paginator' => $admins])
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-muted">Belum ada admin</h5>
                                <p class="text-muted">Klik tombol "Tambah Admin Baru" untuk membuat admin pertama.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar img,
        .avatar div {
            object-fit: cover;
        }

        /* Simple modal fixes - no conflicting animations */
        .modal-dialog {
            margin-top: 3rem;
        }

        /* Ensure proper z-index */
        .modal {
            z-index: 1055 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        /* Prevent table row click events from interfering */
        .table tbody tr {
            cursor: default;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.025);
        }

        /* Ensure action buttons work properly */
        .admin-action-column {
            position: relative;
            z-index: 10;
        }

        .admin-btn-group-vertical {
            position: relative;
            z-index: 11;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Admin management page loaded');

            // Add event listeners to reset password buttons
            document.querySelectorAll('.reset-password-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const adminId = this.getAttribute('data-admin-id');
                    const adminName = this.getAttribute('data-admin-name');
                    console.log('Reset button clicked for:', adminId, adminName);
                    resetPassword(adminId, adminName);
                });
            });

            // Test function - untuk debugging
            window.testResetPassword = function(adminId) {
                console.log('=== DEBUGGING RESET PASSWORD ===');
                console.log('Testing reset password for admin ID:', adminId);

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                console.log('CSRF Token:', csrfToken);

                const url = `{{ route('admin.admin-management.reset-password', ['user' => ':id']) }}`.replace(
                    ':id', adminId);
                console.log('Request URL:', url);

                // Use FormData instead of JSON
                const formData = new FormData();
                formData.append('_token', csrfToken);
                console.log('FormData created with _token');

                const requestOptions = {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                };
                console.log('Request options:', requestOptions);

                fetch(url, requestOptions)
                    .then(response => {
                        console.log('=== RESPONSE RECEIVED ===');
                        console.log('Response status:', response.status);
                        console.log('Response statusText:', response.statusText);
                        console.log('Response ok:', response.ok);
                        console.log('Response headers:', [...response.headers.entries()]);

                        return response.text(); // Get as text first to see everything
                    })
                    .then(text => {
                        console.log('=== RAW RESPONSE TEXT ===');
                        console.log('Response length:', text.length);
                        console.log('First 500 chars:', text.substring(0, 500));
                        console.log('Last 200 chars:', text.substring(text.length - 200));

                        // Check if it starts with HTML
                        if (text.trim().startsWith('<!DOCTYPE') || text.trim().startsWith('<html')) {
                            console.error('❌ Server returned HTML page instead of JSON');
                            alert('ERROR: Server returned HTML page. Check browser console for details.');
                            return;
                        }

                        // Check if it starts with JSON
                        if (text.trim().startsWith('{') || text.trim().startsWith('[')) {
                            console.log('✅ Response looks like JSON, parsing...');
                            try {
                                const data = JSON.parse(text);
                                console.log('✅ Parsed JSON successfully:', data);
                                if (data.success) {
                                    alert('SUCCESS: ' + data.message);
                                } else {
                                    alert('ERROR: ' + data.message);
                                }
                            } catch (e) {
                                console.error('❌ JSON parse error:', e);
                                alert('JSON Parse Error: ' + e.message);
                            }
                        } else {
                            console.error('❌ Response is neither HTML nor JSON');
                            alert('Unknown response format. First 200 chars: ' + text.substring(0, 200));
                        }
                    })
                    .catch(error => {
                        console.error('=== NETWORK ERROR ===');
                        console.error('Fetch error:', error);
                        console.error('Error message:', error.message);
                        console.error('Error stack:', error.stack);
                        alert('Network error: ' + error.message);
                    });
            }
        });

        // Function untuk show alert
        function showAlert(message, type) {
            const alertClass = {
                'success': 'alert-success',
                'error': 'alert-danger',
                'danger': 'alert-danger',
                'warning': 'alert-warning',
                'info': 'alert-info'
            } [type] || 'alert-info';

            const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

            const container = document.querySelector('.container-fluid');
            if (container) {
                container.insertAdjacentHTML('afterbegin', alertHtml);

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    const alert = container.querySelector('.alert');
                    if (alert) {
                        alert.remove();
                    }
                }, 5000);
            }
        }

        // Function untuk reset password admin
        function resetPassword(adminId, adminName) {
            console.log('Reset password function called for admin:', adminId, adminName);

            // Show confirmation modal with simple design and animated icon
            const modalHtml = `
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-body text-center p-4">
                        <!-- Animated Warning Icon -->
                        <div class="mb-4">
                            <div class="warning-icon-container">
                                <i class="fas fa-key warning-icon"></i>
                                <div class="icon-pulse"></div>
                            </div>
                        </div>

                        <!-- Title -->
                        <h5 class="modal-title fw-bold mb-3 text-dark">Reset Password</h5>

                        <!-- Message -->
                        <p class="text-muted mb-3 fs-6">
                            Yakin ingin reset password untuk<br>
                            <strong class="text-dark">${adminName}</strong>?
                        </p>

                        <!-- Info Badge -->
                        <div class="alert alert-light border mb-4 py-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle text-primary me-1"></i>
                                Password akan direset ke <code class="text-warning">@admin123</code>
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-warning btn-sm fw-bold" onclick="confirmResetPassword(${adminId})">
                                <i class="fas fa-key me-2"></i>Ya, Reset Password
                            </button>
                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

            // Remove existing modal if any
            const existingModal = document.getElementById('resetPasswordModal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
            modal.show();
        }

        // Function untuk konfirmasi dan kirim request reset password
        function confirmResetPassword(adminId) {
            console.log('=== RESET PASSWORD PROCESS INITIATED ===');
            console.log('Admin ID:', adminId);

            const modal = bootstrap.Modal.getInstance(document.getElementById('resetPasswordModal'));
            const resetBtn = document.querySelector('#resetPasswordModal .btn-warning');
            const cancelBtn = document.querySelector('#resetPasswordModal .btn-light');

            // Disable buttons and show loading animation
            resetBtn.disabled = true;
            cancelBtn.disabled = true;
            resetBtn.innerHTML = `
        <div class="spinner-border spinner-border-sm me-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        Memproses...
    `;

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);

            // Create form data
            const formData = new FormData();
            formData.append('_token', csrfToken);

            const url = `{{ route('admin.admin-management.reset-password', ['user' => ':id']) }}`.replace(':id', adminId);
            console.log('Request URL:', url);

            // Send POST request with enhanced error handling
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    console.log('=== RAW RESPONSE RECEIVED ===');
                    console.log('Status:', response.status);
                    console.log('Status Text:', response.statusText);
                    console.log('Content-Type:', response.headers.get('content-type'));
                    console.log('Response OK:', response.ok);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status} - ${response.statusText}`);
                    }

                    // Get response as text for cleaning
                    return response.text();
                })
                .then(rawText => {
                    console.log('=== RAW RESPONSE TEXT ===');
                    console.log('Raw response length:', rawText.length);
                    console.log('First 300 chars:', rawText.substring(0, 300));
                    console.log('Last 300 chars:', rawText.substring(rawText.length - 300));

                    // Clean response - remove any PHP notices, warnings, or other output
                    let cleanedText = rawText.trim();

                    // Split by lines and find JSON start
                    const lines = cleanedText.split('\n');
                    let jsonStartIndex = -1;
                    let jsonEndIndex = -1;

                    // Find the first line that starts with { and contains "success"
                    for (let i = 0; i < lines.length; i++) {
                        const line = lines[i].trim();
                        if (line.startsWith('{') && line.includes('"success"')) {
                            jsonStartIndex = i;
                            break;
                        }
                    }

                    // Find the last line that ends with }
                    for (let i = lines.length - 1; i >= 0; i--) {
                        const line = lines[i].trim();
                        if (line.endsWith('}')) {
                            jsonEndIndex = i;
                            break;
                        }
                    }

                    if (jsonStartIndex !== -1 && jsonEndIndex !== -1 && jsonEndIndex >= jsonStartIndex) {
                        // Extract only the JSON part
                        cleanedText = lines.slice(jsonStartIndex, jsonEndIndex + 1).join('\n');
                        console.log('=== EXTRACTED JSON ===');
                        console.log('JSON text:', cleanedText);
                    } else {
                        // Fallback: try to find JSON pattern using regex
                        const jsonMatch = cleanedText.match(/\{.*"success".*\}/s);
                        if (jsonMatch) {
                            cleanedText = jsonMatch[0];
                            console.log('=== REGEX EXTRACTED JSON ===');
                            console.log('JSON text:', cleanedText);
                        }
                    }

                    // Try to parse cleaned JSON
                    try {
                        const data = JSON.parse(cleanedText);
                        console.log('=== SUCCESSFULLY PARSED JSON ===');
                        console.log('Parsed data:', data);
                        return data;
                    } catch (parseError) {
                        console.error('=== JSON PARSE ERROR ===');
                        console.error('Parse error:', parseError.message);
                        console.error('Cleaned text that failed:', cleanedText);
                        throw new Error(
                            `JSON Parse Failed: ${parseError.message}. Cleaned response: ${cleanedText.substring(0, 200)}...`
                            );
                    }
                })
                .then(data => {
                    console.log('=== PROCESSING RESPONSE DATA ===');
                    console.log('Response data:', data);

                    if (data.success) {
                        console.log('Success response:', data.message);
                        console.log('New password:', data.new_password);

                        // Show success animation first
                        resetBtn.innerHTML = `
                <i class="fas fa-check me-2"></i>
                Berhasil!
            `;
                        resetBtn.className = 'btn btn-success btn-sm fw-bold';

                        // Show success alert with new password after delay
                        setTimeout(() => {
                            const successMessage = data.message +
                                (data.new_password ? `\n\nPassword baru: ${data.new_password}` : '');
                            showAlert(successMessage, 'success');
                            modal.hide();
                        }, 1500);
                    } else {
                        console.error('Server returned error:', data.message);
                        showAlert(data.message || 'Gagal reset password admin.', 'danger');
                        modal.hide();
                    }
                })
                .catch(error => {
                    console.error('=== REQUEST ERROR ===');
                    console.error('Error object:', error);
                    console.error('Error message:', error.message);
                    console.error('Error stack:', error.stack);

                    let errorMessage = 'Terjadi kesalahan saat reset password.';
                    if (error.message.includes('JSON Parse Failed')) {
                        errorMessage = 'Server response format error. Periksa console untuk detail.';
                    } else if (error.message.includes('HTTP error')) {
                        errorMessage = `Server error: ${error.message}`;
                    }

                    showAlert(errorMessage, 'danger');
                    modal.hide();
                })
                .finally(() => {
                    console.log('=== RESET PASSWORD PROCESS COMPLETED ===');

                    // Reset button state after delay
                    setTimeout(() => {
                        resetBtn.disabled = false;
                        cancelBtn.disabled = false;
                        resetBtn.innerHTML = '<i class="fas fa-key me-2"></i>Ya, Reset Password';
                        resetBtn.className = 'btn btn-warning btn-sm fw-bold';
                    }, 2000);
                });
        }
    </script>
@endpush
