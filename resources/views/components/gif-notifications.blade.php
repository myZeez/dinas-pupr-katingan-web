{{-- Universal GIF Notifications Component --}}
{{-- Component notifikasi dengan icon GIF untuk seluruh halaman admin --}}

<style>
/* GIF Notification Styles */
.gif-notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
    pointer-events: none;
}

.gif-notification {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    margin-bottom: 10px;
    padding: 16px 20px;
    pointer-events: all;
    animation: slideInRight 0.3s ease-out;
    border-left: 4px solid #007bff;
    position: relative;
    overflow: hidden;
}

.gif-notification.success {
    border-left-color: #28a745;
}

.gif-notification.error,
.gif-notification.danger {
    border-left-color: #dc3545;
}

.gif-notification.warning {
    border-left-color: #ffc107;
}

.gif-notification.loading {
    border-left-color: #007bff;
}

.gif-notification .gif-icon {
    width: 24px;
    height: 24px;
    object-fit: contain;
    margin-right: 12px;
    flex-shrink: 0;
}

.gif-notification .content {
    flex: 1;
}

.gif-notification .title {
    font-weight: 600;
    color: #1a1d29;
    margin-bottom: 4px;
    font-size: 14px;
}

.gif-notification .message {
    color: #6c757d;
    font-size: 13px;
    line-height: 1.4;
}

.gif-notification .close-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: none;
    border: none;
    color: #adb5bd;
    font-size: 18px;
    cursor: pointer;
    padding: 4px;
    line-height: 1;
}

.gif-notification .close-btn:hover {
    color: #6c757d;
}

.gif-notification .progress-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #0056b3);
    transition: width 0.1s linear;
}

.gif-notification.success .progress-bar {
    background: linear-gradient(90deg, #28a745, #1e7e34);
}

.gif-notification.error .progress-bar,
.gif-notification.danger .progress-bar {
    background: linear-gradient(90deg, #dc3545, #c82333);
}

.gif-notification.warning .progress-bar {
    background: linear-gradient(90deg, #ffc107, #e0a800);
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.gif-notification.hide {
    animation: slideOutRight 0.3s ease-in forwards;
}
</style>

<!-- Notification Container -->
<div id="gif-notification-container" class="gif-notification-container"></div>

<script>
// GIF Notification System
class GifNotifications {
    constructor() {
        this.container = document.getElementById('gif-notification-container');
        this.defaultDuration = 5000; // 5 detik
        this.notifications = new Map();
    }

    show(title, message, type = 'success', duration = null) {
        if (!this.container) return;

        const id = 'gif-notif-' + Date.now();
        const notification = this.createNotification(id, title, message, type);
        
        this.container.appendChild(notification);
        this.notifications.set(id, notification);

        // Auto hide after duration
        const hideTimeout = setTimeout(() => {
            this.hide(id);
        }, duration || this.defaultDuration);

        // Store timeout for manual clearing
        notification.hideTimeout = hideTimeout;

        return id;
    }

    createNotification(id, title, message, type) {
        const notification = document.createElement('div');
        notification.id = id;
        notification.className = `gif-notification ${type}`;

        const iconPath = this.getIconPath(type);
        
        notification.innerHTML = `
            <div class="d-flex align-items-start">
                <img src="${iconPath}" alt="${type}" class="gif-icon">
                <div class="content">
                    <div class="title">${title}</div>
                    <div class="message">${message}</div>
                </div>
                <button type="button" class="close-btn" onclick="gifNotifications.hide('${id}')">&times;</button>
            </div>
            <div class="progress-bar" style="width: 0%"></div>
        `;

        // Start progress bar animation
        setTimeout(() => {
            const progressBar = notification.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = '100%';
                progressBar.style.transition = `width ${this.defaultDuration}ms linear`;
            }
        }, 100);

        return notification;
    }

    getIconPath(type) {
        const iconMap = {
            'success': '/icon/Succes.gif',
            'error': '/icon/Delete.gif',
            'danger': '/icon/Delete.gif',
            'warning': '/icon/loading.gif', // Gunakan loading untuk warning
            'loading': '/icon/loading.gif',
            'info': '/icon/Done.gif'
        };
        
        return iconMap[type] || iconMap['info'];
    }

    hide(id) {
        const notification = this.notifications.get(id);
        if (notification) {
            // Clear timeout if exists
            if (notification.hideTimeout) {
                clearTimeout(notification.hideTimeout);
            }

            // Add hide animation
            notification.classList.add('hide');
            
            // Remove from DOM after animation
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
                this.notifications.delete(id);
            }, 300);
        }
    }

    hideAll() {
        this.notifications.forEach((notification, id) => {
            this.hide(id);
        });
    }

    // Helper methods for common notifications
    success(title, message, duration) {
        return this.show(title, message, 'success', duration);
    }

    error(title, message, duration) {
        return this.show(title, message, 'error', duration);
    }

    warning(title, message, duration) {
        return this.show(title, message, 'warning', duration);
    }

    loading(title, message) {
        return this.show(title, message, 'loading', 0); // No auto hide for loading
    }

    info(title, message, duration) {
        return this.show(title, message, 'info', duration);
    }
}

// Initialize global instance
const gifNotifications = new GifNotifications();

// Expose to window for global access
window.gifNotifications = gifNotifications;

// Shorthand functions for easier use
window.showSuccess = (title, message, duration) => gifNotifications.success(title, message, duration);
window.showError = (title, message, duration) => gifNotifications.error(title, message, duration);
window.showWarning = (title, message, duration) => gifNotifications.warning(title, message, duration);
window.showLoading = (title, message) => gifNotifications.loading(title, message);
window.showInfo = (title, message, duration) => gifNotifications.info(title, message, duration);

// Auto-show notifications from Laravel session
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showSuccess('Berhasil!', '{{ session('success') }}');
    @endif

    @if(session('error'))
        showError('Error!', '{{ session('error') }}');
    @endif

    @if(session('warning'))
        showWarning('Perhatian!', '{{ session('warning') }}');
    @endif

    @if(session('info'))
        showInfo('Informasi', '{{ session('info') }}');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showError('Validation Error', '{{ $error }}');
        @endforeach
    @endif
});
</script>
