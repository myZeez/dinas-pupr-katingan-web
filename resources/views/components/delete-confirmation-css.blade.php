{{-- Global Delete Confirmation Component - Pure CSS Icons --}}

<style>
/* ========== CSS MODAL ICONS ========== */
.modal-css-icon {
    width: 80px;
    height: 80px;
    position: relative;
    margin: 0 auto 20px;
}

/* Delete Icon - X in Circle */
.modal-css-icon.delete {
    border: 4px solid #dc3545;
    border-radius: 50%;
    animation: modalIconPop 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.modal-css-icon.delete::before,
.modal-css-icon.delete::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 4px;
    background: #dc3545;
    border-radius: 2px;
}

.modal-css-icon.delete::before {
    transform: translate(-50%, -50%) rotate(45deg);
    animation: deleteLineLeft 0.4s 0.3s ease-out forwards;
    width: 0;
}

.modal-css-icon.delete::after {
    transform: translate(-50%, -50%) rotate(-45deg);
    animation: deleteLineRight 0.4s 0.5s ease-out forwards;
    width: 0;
}

@keyframes modalIconPop {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    60% {
        transform: scale(1.15);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes deleteLineLeft {
    0% { width: 0; }
    100% { width: 40px; }
}

@keyframes deleteLineRight {
    0% { width: 0; }
    100% { width: 40px; }
}

/* Warning Icon - Exclamation in Triangle */
.modal-css-icon.warning {
    width: 0;
    height: 0;
    border-left: 40px solid transparent;
    border-right: 40px solid transparent;
    border-bottom: 70px solid #ffc107;
    border-radius: 5px;
    margin: 5px auto 20px;
    animation: warningShake 0.6s ease-out;
}

.modal-css-icon.warning::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 15px;
    transform: translateX(-50%);
    width: 4px;
    height: 28px;
    background: white;
    border-radius: 3px;
    animation: exclamationSlideDown 0.4s 0.3s ease-out forwards;
    opacity: 0;
}

.modal-css-icon.warning::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: 8px;
    transform: translateX(-50%);
    width: 5px;
    height: 5px;
    background: white;
    border-radius: 50%;
    animation: exclamationDotPop 0.3s 0.5s ease-out forwards;
    opacity: 0;
}

@keyframes warningShake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

@keyframes exclamationSlideDown {
    0% {
        height: 0;
        opacity: 1;
    }
    100% {
        height: 28px;
        opacity: 1;
    }
}

@keyframes exclamationDotPop {
    0% {
        transform: translateX(-50%) scale(0);
        opacity: 1;
    }
    100% {
        transform: translateX(-50%) scale(1);
        opacity: 1;
    }
}

/* Success Icon - Checkmark in Circle */
.modal-css-icon.success {
    border: 4px solid #28a745;
    border-radius: 50%;
    animation: successBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.modal-css-icon.success::after {
    content: '';
    position: absolute;
    left: 28px;
    top: 14px;
    width: 12px;
    height: 28px;
    border: solid #28a745;
    border-width: 0 5px 5px 0;
    transform: rotate(45deg);
    animation: successCheck 0.5s 0.3s ease-out forwards;
    opacity: 0;
}

@keyframes successBounce {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.15);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes successCheck {
    0% {
        height: 0;
        width: 0;
        opacity: 1;
    }
    50% {
        height: 28px;
        width: 0;
        opacity: 1;
    }
    100% {
        height: 28px;
        width: 12px;
        opacity: 1;
    }
}

/* Info Icon - i in Circle */
.modal-css-icon.info {
    border: 4px solid #17a2b8;
    border-radius: 50%;
    animation: infoPulse 0.5s ease-out;
}

.modal-css-icon.info::before {
    content: '';
    position: absolute;
    top: 15px;
    left: 50%;
    transform: translateX(-50%);
    width: 6px;
    height: 6px;
    background: #17a2b8;
    border-radius: 50%;
    animation: infoDotPop 0.3s 0.2s ease-out forwards;
    opacity: 0;
}

.modal-css-icon.info::after {
    content: '';
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 5px;
    height: 32px;
    background: #17a2b8;
    border-radius: 3px;
    animation: infoLineGrow 0.4s 0.3s ease-out forwards;
    opacity: 0;
}

@keyframes infoPulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

@keyframes infoDotPop {
    0% {
        transform: translateX(-50%) scale(0);
        opacity: 1;
    }
    100% {
        transform: translateX(-50%) scale(1);
        opacity: 1;
    }
}

@keyframes infoLineGrow {
    0% {
        height: 0;
        opacity: 1;
    }
    100% {
        height: 32px;
        opacity: 1;
    }
}

/* Modal Container Styles */
.css-confirm-modal .modal-content {
    background: white;
    border-radius: 20px;
    border: none;
}

.css-confirm-modal .modal-body {
    padding: 40px 30px;
}

.css-confirm-modal .confirm-title {
    color: #212529;
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 12px;
}

.css-confirm-modal .confirm-message {
    color: #6c757d;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 24px;
}

.css-confirm-modal .btn-confirm {
    padding: 12px 32px;
    border-radius: 10px;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
}

.css-confirm-modal .btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.css-confirm-modal .btn-cancel {
    padding: 12px 32px;
    border-radius: 10px;
    font-weight: 600;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #6c757d;
    transition: all 0.3s ease;
}

.css-confirm-modal .btn-cancel:hover {
    background: #e9ecef;
    border-color: #ced4da;
}
</style>

<script>
// Global function untuk konfirmasi delete dengan Pure CSS Icons
function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?', type = 'delete') {
    return new Promise((resolve) => {
        const typeConfig = {
            'delete': {
                title: 'Konfirmasi Hapus',
                buttonText: 'Ya, Hapus',
                buttonColor: '#dc3545'
            },
            'warning': {
                title: 'Peringatan',
                buttonText: 'Ya, Lanjutkan',
                buttonColor: '#ffc107'
            },
            'success': {
                title: 'Konfirmasi',
                buttonText: 'Ya, Lanjutkan',
                buttonColor: '#28a745'
            },
            'info': {
                title: 'Informasi',
                buttonText: 'OK',
                buttonColor: '#17a2b8'
            }
        };

        const config = typeConfig[type] || typeConfig['delete'];

        const modalHtml = `
            <div class="modal fade css-confirm-modal" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content shadow-lg">
                        <div class="modal-body text-center">
                            <div class="modal-css-icon ${type}"></div>
                            <h5 class="confirm-title">${config.title}</h5>
                            <p class="confirm-message">${message}</p>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-confirm" id="confirmDeleteBtn"
                                    style="background: ${config.buttonColor}; color: white;">
                                    ${config.buttonText}
                                </button>
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
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
    return confirmDelete(message, type);
}

// Expose to window
window.confirmDelete = confirmDelete;
window.confirmAction = confirmAction;
</script>
