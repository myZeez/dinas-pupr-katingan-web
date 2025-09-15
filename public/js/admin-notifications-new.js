/**
 * Admin Notifications System - Simple & Clean
 * Using SweetAlert2 with GIF animations
 */

// Check if SweetAlert2 is loaded
if (typeof Swal === 'undefined') {
    console.error('SweetAlert2 is not loaded. Please include SweetAlert2 before this script.');
}

// GIF Icons configuration
const GIF_ICONS = {
    success: '/Icon/Succes.gif',
    delete: '/Icon/Delete.gif',
    loading: '/Icon/loading.gif',
    done: '/Icon/Done.gif'
};

/**
 * Show success notification with GIF
 * @param {string} message - Success message
 */
function showSuccessNotification(message) {
    Swal.fire({
        title: message,
        imageUrl: GIF_ICONS.success,
        imageWidth: 100,
        imageHeight: 100,
        showConfirmButton: false,
        timer: 3000,
        background: '#ffffff',
        customClass: {
            popup: 'simple-toast'
        }
    });
}

/**
 * Show loading notification
 * @param {string} message - Loading message
 */
function showLoadingNotification(message = 'Memproses...') {
    Swal.fire({
        title: message,
        imageUrl: GIF_ICONS.loading,
        imageWidth: 100,
        imageHeight: 100,
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        background: '#ffffff',
        customClass: {
            popup: 'simple-dialog'
        }
    });
}

/**
 * Confirm delete with GIF animation
 * @param {string} message - Confirmation message
 * @param {function} callback - Function to execute if confirmed
 */
function confirmDelete(message, callback) {
    Swal.fire({
        title: message,
        imageUrl: GIF_ICONS.delete,
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#ffffff',
        customClass: {
            popup: 'simple-dialog'
        }
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

/**
 * Confirm action with GIF animation
 * @param {string} message - Confirmation message
 * @param {function} callback - Function to execute if confirmed
 */
function confirmAction(message, callback) {
    Swal.fire({
        title: message,
        imageUrl: GIF_ICONS.done,
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Lanjutkan!',
        cancelButtonText: 'Batal',
        background: '#ffffff',
        customClass: {
            popup: 'simple-dialog'
        }
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

/**
 * Close current notification
 */
function closeNotification() {
    Swal.close();
}

// Export functions to window object
window.showSuccessNotification = showSuccessNotification;
window.showLoadingNotification = showLoadingNotification;
window.confirmDelete = confirmDelete;
window.confirmAction = confirmAction;
window.closeNotification = closeNotification;

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Notifications System loaded successfully');
});
