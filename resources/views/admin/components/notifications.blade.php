{{-- Universal Admin Notifications Component --}}
{{-- File ini menggunakan sistem notifikasi universal yang konsisten --}}

<script>
// Universal Notification System
function showNotification(title, message, type = 'info', icon = 'bi-info-circle') {
    const container = document.getElementById('notification-container');
    if (!container) return;
    
    // Create notification element
    const notification = document.createElement('div');
    const notificationId = 'notification-' + Date.now();
    notification.id = notificationId;
    
    // Set CSS classes based on type
    let alertClass = 'alert-info';
    let iconClass = icon;
    
    switch(type) {
        case 'success':
            alertClass = 'alert-success';
            iconClass = icon || 'bi-check-circle';
            break;
        case 'danger':
        case 'error':
            alertClass = 'alert-danger';
            iconClass = icon || 'bi-x-circle';
            break;
        case 'warning':
            alertClass = 'alert-warning';
            iconClass = icon || 'bi-exclamation-triangle';
            break;
        case 'info':
        default:
            alertClass = 'alert-info';
            iconClass = icon || 'bi-info-circle';
            break;
    }
    
    notification.className = `alert ${alertClass} alert-dismissible fade show notification-slide-in`;
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="${iconClass} me-2"></i>
            <div class="flex-grow-1">
                <div class="fw-semibold">${title}</div>
                <div class="small">${message}</div>
            </div>
            <button type="button" class="btn-close" onclick="removeNotification('${notificationId}')"></button>
        </div>
        <div class="notification-progress"></div>
    `;
    
    // Add to container
    container.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        removeNotification(notificationId);
    }, 5000);
    
    // Start progress bar animation
    setTimeout(() => {
        const progressBar = notification.querySelector('.notification-progress');
        if (progressBar) {
            progressBar.style.animation = 'progressBar 5s linear forwards';
        }
    }, 100);
}

function removeNotification(notificationId) {
    const notification = document.getElementById(notificationId);
    if (notification) {
        notification.classList.add('notification-slide-out');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
}

// Handle session-based notifications
document.addEventListener('DOMContentLoaded', function() {
    @if(session('alert_message'))
        showNotification(
            '{{ session('alert_title', 'Notification') }}',
            '{{ session('alert_message') }}',
            '{{ session('alert_type', 'info') }}',
            '{{ session('alert_icon', 'bi-info-circle') }}'
        );
    @endif
});

// Setup AJAX untuk menampilkan notifikasi dari response
$(document).ajaxComplete(function(event, xhr, settings) {
    try {
        const response = xhr.responseJSON;
        if (response && response.alert_message) {
            showNotification(
                response.alert_title || 'Notification',
                response.alert_message,
                response.alert_type || 'info',
                response.alert_icon || 'bi-info-circle'
            );
        }
    } catch (e) {
        // Silent fail untuk non-JSON responses
    }
});
</script>

<style>
/* Notification Styles */
.notification-slide-in {
    animation: slideInFromRight 0.4s ease-out;
}

.notification-slide-out {
    animation: slideOutToRight 0.3s ease-in;
}

@keyframes slideInFromRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutToRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

@keyframes progressBar {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

.notification-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    width: 100%;
    border-radius: 0 0 8px 8px;
}

#notification-container .alert {
    position: relative;
    margin-bottom: 10px;
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

#notification-container .alert-success {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border-left: 4px solid #10b981;
    color: #065f46;
}

#notification-container .alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
    border-left: 4px solid #ef4444;
    color: #991b1b;
}

#notification-container .alert-warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fed7aa 100%);
    border-left: 4px solid #f59e0b;
    color: #92400e;
}

#notification-container .alert-info {
    background: linear-gradient(135deg, #eff6ff 0%, #bfdbfe 100%);
    border-left: 4px solid #3b82f6;
    color: #1e40af;
}

#notification-container .btn-close {
    color: inherit;
    opacity: 0.7;
}

#notification-container .btn-close:hover {
    opacity: 1;
}
</style>
