/**
 * Admin Notifications - Simple GIF Icon System
 * Using SweetAlert2 with animated GIF icons
 */

// GIF Icons untuk berbagai jenis notifikasi
const gifIcons = {
    success: '/Icon/Succes.gif',
    error: '/Icon/Delete.gif',
    warning: '/Icon/loading.gif',
    info: '/Icon/Done.gif',
    question: '/Icon/Done.gif',
    loading: '/Icon/loading.gif'
};

// Initialize SweetAlert2 dengan GIF icons
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    background: '#ffffff',
    borderRadius: '12px',
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Success notification dengan GIF - hanya judul
function showSuccessNotification(message, title = 'Berhasil!') {
    Toast.fire({
        imageUrl: gifIcons.success,
        imageWidth: 60,
        imageHeight: 60,
        title: message,  // Langsung tampilkan pesan sebagai judul
        background: '#f8fffe',
        color: '#065f46',
        customClass: {
            popup: 'simple-toast success-toast',
            image: 'gif-icon'
        }
    });
}

// Error notification dengan GIF - hanya judul
function showErrorNotification(message, title = 'Gagal!') {
    Toast.fire({
        imageUrl: gifIcons.error,
        imageWidth: 60,
        imageHeight: 60,
        title: message,  // Langsung tampilkan pesan sebagai judul
        background: '#fffef8',
        color: '#991b1b',
        customClass: {
            popup: 'simple-toast error-toast',
            image: 'gif-icon'
        }
    });
}

// Warning notification dengan GIF - hanya judul
function showWarningNotification(message, title = 'Perhatian!') {
    Toast.fire({
        imageUrl: gifIcons.warning,
        imageWidth: 60,
        imageHeight: 60,
        title: message,  // Langsung tampilkan pesan sebagai judul
        background: '#fffef5',
        color: '#92400e',
        customClass: {
            popup: 'simple-toast warning-toast',
            image: 'gif-icon'
        }
    });
}

// Info notification dengan GIF - hanya judul
function showInfoNotification(message, title = 'Informasi') {
    Toast.fire({
        imageUrl: gifIcons.info,
        imageWidth: 60,
        imageHeight: 60,
        title: message,  // Langsung tampilkan pesan sebagai judul
        background: '#f8faff',
        color: '#1e40af',
        customClass: {
            popup: 'simple-toast info-toast',
            image: 'gif-icon'
        }
    });
}

// Confirmation dialog dengan GIF - hanya judul
function showConfirmDialog(options = {}) {
    const defaultOptions = {
        title: 'Apakah Anda yakin?',  // Hanya 1 judul, tanpa text
        imageUrl: gifIcons.question,
        imageWidth: 80,
        imageHeight: 80,
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: '✓ Ya',
        cancelButtonText: '✕ Batal',
        background: '#ffffff',
        backdrop: 'rgba(0,0,0,0.3)',
        customClass: {
            popup: 'simple-dialog',
            confirmButton: 'simple-btn simple-btn-confirm',
            cancelButton: 'simple-btn simple-btn-cancel',
            image: 'gif-icon-large'
        },
        buttonsStyling: false
    };

    return Swal.fire({
        ...defaultOptions,
        ...options
    });
}

// Delete confirmation dengan GIF - hanya judul
function confirmDelete(itemName = 'item', onConfirm = null) {
    return showConfirmDialog({
        title: `Hapus ${itemName}?`,  // Hanya judul, tanpa text
        imageUrl: gifIcons.error,
        confirmButtonText: '🗑️ Ya, Hapus!',
        cancelButtonText: '❌ Batal'
    }).then((result) => {
        if (result.isConfirmed && onConfirm) {
            onConfirm();
        }
        return result;
    });
}

// Status update confirmation dengan GIF - hanya judul
function confirmStatusUpdate(status, itemName = 'status') {
    return showConfirmDialog({
        title: `Ubah ${itemName} menjadi ${status}?`,  // Hanya judul, tanpa text
        imageUrl: gifIcons.info,
        confirmButtonColor: '#059669',
        confirmButtonText: '✓ Ya, Ubah!',
        cancelButtonText: '❌ Batal'
    });
}

// Loading notification dengan GIF - hanya judul
function showLoadingNotification(message = 'Memproses...') {
    return Swal.fire({
        title: message,  // Hanya judul, tanpa text
        imageUrl: gifIcons.loading,
        imageWidth: 80,
        imageHeight: 80,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        background: '#ffffff',
        customClass: {
            popup: 'simple-loading',
            image: 'gif-icon-large'
        }
    });
}

// Hide loading
function hideLoadingNotification() {
    Swal.close();
}

// Auto-hide alerts
function hideBootstrapAlerts() {
    // Hide bootstrap alerts after 3 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(alert => {
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    }, 3000);
}

// Initialize notifications when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Check for Laravel session messages and show appropriate notifications
    const successMessage = document.querySelector('meta[name="success-message"]');
    const errorMessage = document.querySelector('meta[name="error-message"]');
    const warningMessage = document.querySelector('meta[name="warning-message"]');
    const infoMessage = document.querySelector('meta[name="info-message"]');

    if (successMessage && successMessage.content) {
        showSuccessNotification(successMessage.content);
    }

    if (errorMessage && errorMessage.content) {
        showErrorNotification(errorMessage.content);
    }

    if (warningMessage && warningMessage.content) {
        showWarningNotification(warningMessage.content);
    }

    if (infoMessage && infoMessage.content) {
        showInfoNotification(infoMessage.content);
    }

    // Auto-hide bootstrap alerts
    hideBootstrapAlerts();

    // Setup delete buttons with confirmation
    document.querySelectorAll('[data-confirm-delete]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const itemName = this.getAttribute('data-item-name') || 'item';
            const form = this.closest('form');
            
            confirmDelete(itemName, () => {
                if (form) {
                    form.submit();
                }
            });
        });
    });

    // Setup status update buttons with confirmation
    document.querySelectorAll('[data-confirm-status]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const status = this.getAttribute('data-status');
            const itemName = this.getAttribute('data-item-name') || 'status';
            const form = this.closest('form');
            
            confirmStatusUpdate(status, itemName).then((result) => {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
        });
    });
});

// Export functions for global use
window.showSuccessNotification = showSuccessNotification;
window.showErrorNotification = showErrorNotification;
window.showWarningNotification = showWarningNotification;
window.showInfoNotification = showInfoNotification;
window.confirmDelete = confirmDelete;
window.confirmStatusUpdate = confirmStatusUpdate;
window.showLoadingNotification = showLoadingNotification;
window.hideLoadingNotification = hideLoadingNotification;
