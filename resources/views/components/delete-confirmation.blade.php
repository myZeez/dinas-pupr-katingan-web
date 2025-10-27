{{-- Global Delete Confirmation Component --}}
<script>
// Global function untuk konfirmasi delete dengan GIF
function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?', type = 'delete') {
    return new Promise((resolve) => {
        // Buat modal konfirmasi dengan GIF
        const iconMap = {
            'delete': '{{ asset("Icon/Delete.gif") }}',
            'warning': '{{ asset("Icon/loading.gif") }}',
            'info': '{{ asset("Icon/Done.gif") }}',
            'success': '{{ asset("Icon/Succes.gif") }}'
        };

        const modalHtml = `
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg" style="background: white; border-radius: 20px;">
                        <div class="modal-body text-center p-5" style="background: white;">
                            <div class="mb-4">
                                <div class="icon-container mx-auto mb-3" style="width: 100px; height: 100px; background: transparent; border: 3px solid #f8d7da; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <img src="${iconMap[type]}" alt="Delete" style="width: 60px; height: 60px;">
                                </div>
                                <h5 class="fw-bold mb-2" style="color: #212529;">Konfirmasi Hapus</h5>
                                <p class="mb-0" style="color: #6c757d; font-size: 15px; line-height: 1.5;">${message}</p>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-lg fw-bold" id="confirmDeleteBtn" style="background: #dc3545; color: white; border: none; border-radius: 8px; padding: 12px 24px;">
                                    Ya, Hapus
                                </button>
                                <button type="button" class="btn btn-lg" data-bs-dismiss="modal" style="background: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px 24px;">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Hapus modal yang ada jika ada
        $('#confirmDeleteModal').remove();
        
        // Tambahkan modal ke body
        $('body').append(modalHtml);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();

        // Handle konfirmasi
        $('#confirmDeleteBtn').on('click', function() {
            modal.hide();
            resolve(true);
        });

        // Handle cancel
        $('#confirmDeleteModal').on('hidden.bs.modal', function() {
            $(this).remove();
            resolve(false);
        });
    });
}

// Function untuk attach ke form delete
function attachDeleteConfirmation() {
    // Handle form dengan class delete-form
    $(document).on('submit', '.delete-form', async function(e) {
        e.preventDefault();
        
        const form = this;
        
        // Skip if already confirmed
        if (form.dataset.deleteConfirmed === 'true') {
            return; // Let the form submit naturally with global loading
        }
        
        const message = $(form).data('message') || 'Apakah Anda yakin ingin menghapus data ini?';
        const confirmed = await confirmDelete(message);
        
        if (confirmed) {
            // Set confirmed flag and submit
            form.dataset.deleteConfirmed = 'true';
            form.submit();
        }
    });

    // Handle tombol dengan class delete-btn
    $(document).on('click', '.delete-btn', async function(e) {
        e.preventDefault();
        
        const btn = this;
        const message = $(btn).data('message') || 'Apakah Anda yakin ingin menghapus data ini?';
        const confirmed = await confirmDelete(message);
        
        if (confirmed) {
            const form = $(btn).closest('form');
            if (form.length) {
                form.submit();
            } else {
                // Jika tidak ada form, redirect ke href
                window.location.href = $(btn).attr('href');
            }
        }
    });
}

// Initialize ketika document ready
$(document).ready(function() {
    attachDeleteConfirmation();
});

// Function untuk konfirmasi aksi lainnya
function confirmAction(message, type = 'warning', confirmText = 'Ya, Lanjutkan') {
    return new Promise((resolve) => {
        const iconMap = {
            'warning': '{{ asset("Icon/loading.gif") }}',
            'info': '{{ asset("Icon/Done.gif") }}',
            'success': '{{ asset("Icon/Succes.gif") }}',
            'delete': '{{ asset("Icon/Delete.gif") }}'
        };

        const colorMap = {
            'warning': { bg: 'linear-gradient(135deg, #ffc107, #e0a800)', shadow: 'rgba(255, 193, 7, 0.3)' },
            'info': { bg: 'linear-gradient(135deg, #17a2b8, #138496)', shadow: 'rgba(23, 162, 184, 0.3)' },
            'success': { bg: 'linear-gradient(135deg, #28a745, #208637)', shadow: 'rgba(40, 167, 69, 0.3)' },
            'delete': { bg: 'linear-gradient(135deg, #ff6b6b, #ee5a52)', shadow: 'rgba(238, 90, 82, 0.3)' }
        };

        // Define simpler color scheme for white theme - hanya border tanpa fill
        const iconBorderMap = {
            'warning': '#ffc107',
            'info': '#17a2b8', 
            'success': '#28a745',
            'delete': '#dc3545'
        };

        const buttonColorMap = {
            'warning': '#ffc107',
            'info': '#17a2b8',
            'success': '#28a745',
            'delete': '#dc3545'
        };

        const modalHtml = `
            <div class="modal fade" id="confirmActionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg" style="background: white; border-radius: 20px;">
                        <div class="modal-body text-center p-5" style="background: white;">
                            <div class="mb-4">
                                <div class="icon-container mx-auto mb-3" style="width: 100px; height: 100px; background: transparent; border: 3px solid ${iconBorderMap[type]}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <img src="${iconMap[type]}" alt="Action" style="width: 60px; height: 60px;">
                                </div>
                                <h5 class="fw-bold mb-2" style="color: #212529;">Konfirmasi</h5>
                                <p class="mb-0" style="color: #6c757d; font-size: 15px; line-height: 1.5;">${message}</p>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-lg fw-bold" id="confirmActionBtn" style="background: ${buttonColorMap[type]}; color: white; border: none; border-radius: 8px; padding: 12px 24px;">
                                    ${confirmText}
                                </button>
                                <button type="button" class="btn btn-lg" data-bs-dismiss="modal" style="background: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px 24px;">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#confirmActionModal').remove();
        $('body').append(modalHtml);
        
        const modal = new bootstrap.Modal(document.getElementById('confirmActionModal'));
        modal.show();
        
        $('#confirmActionBtn').on('click', function() {
            modal.hide();
            resolve(true);
        });
        
        $('#confirmActionModal').on('hidden.bs.modal', function() {
            $(this).remove();
            resolve(false);
        });
    });
}

// Function untuk konfirmasi batch delete
async function confirmBatchDelete(count) {
    const message = `Akan menghapus <strong>${count} item</strong> yang dipilih.<br><small class="text-warning">Tindakan ini tidak dapat dibatalkan!</small>`;
    
    return new Promise((resolve) => {
        const modalHtml = `
            <div class="modal fade" id="confirmBatchModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg" style="background: white; border-radius: 20px;">
                        <div class="modal-body text-center p-5" style="background: white;">
                            <div class="mb-4">
                                <div class="icon-container mx-auto mb-3" style="width: 100px; height: 100px; background: transparent; border: 3px solid #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('Icon/Delete.gif') }}" alt="Batch Delete" style="width: 60px; height: 60px;">
                                </div>
                                <h5 class="fw-bold mb-2" style="color: #212529;">Hapus ${count} Item</h5>
                                <div style="color: #6c757d; font-size: 15px; line-height: 1.5;">${message}</div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-lg fw-bold" id="confirmBatchBtn" style="background: #dc3545; color: white; border: none; border-radius: 8px; padding: 12px 24px;">
                                    Ya, Hapus Semua
                                </button>
                                <button type="button" class="btn btn-lg" data-bs-dismiss="modal" style="background: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px 24px;">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#confirmBatchModal').remove();
        $('body').append(modalHtml);
        
        const modal = new bootstrap.Modal(document.getElementById('confirmBatchModal'));
        modal.show();
        
        $('#confirmBatchBtn').on('click', function() {
            modal.hide();
            resolve(true);
        });
        
        $('#confirmBatchModal').on('hidden.bs.modal', function() {
            $(this).remove();
            resolve(false);
        });
    });
}

// Function untuk menampilkan loading overlay
function showLoadingOverlay(message = 'Memproses data...') {
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
            <img src="{{ asset('Icon/loading.gif') }}" alt="Loading" style="width: 64px; height: 64px; margin-bottom: 1rem;">
            <h5 style="margin: 0 0 0.5rem 0; color: #333; font-weight: 600;">Memproses...</h5>
            <p style="margin: 0; color: #666; font-size: 14px;">${message}</p>
        </div>
    `;
    
    document.body.appendChild(overlay);
    
    // Auto hide setelah 15 detik sebagai fallback
    setTimeout(() => {
        if (document.getElementById('loadingOverlay')) {
            overlay.remove();
        }
    }, 15000);
}

// Function untuk menyembunyikan loading overlay
function hideLoadingOverlay() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.remove();
    }
}
</script>

{{-- CSS untuk styling modal putih modern --}}
<style>
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    background: white !important;
}

.modal-backdrop {
    background-color: rgba(0,0,0,0.4);
}

.icon-container {
    transition: all 0.3s ease;
    border: 3px solid transparent;
}

.modal-body .btn {
    transition: all 0.2s ease;
    font-weight: 600;
}

.modal-body .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.modal-body .btn:active {
    transform: translateY(0);
}

.fade {
    transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
}

.modal.fade .modal-dialog {
    transform: translateY(-20px) scale(0.95);
}

.modal.show .modal-dialog {
    transform: translateY(0) scale(1);
}

/* Remove dark theme overrides */
.modal-content,
.modal-body {
    background-color: white !important;
    color: #212529 !important;
}

/* Responsive */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 1rem;
    }
    
    .modal-body {
        padding: 2rem !important;
    }
    
    .icon-container {
        width: 90px !important;
        height: 90px !important;
    }
    
    .icon-container img {
        width: 50px !important;
        height: 50px !important;
    }
}
</style>
