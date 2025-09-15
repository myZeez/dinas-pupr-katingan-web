{{-- Global Loading Animation Component --}}
<div id="globalLoadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-container">
        <div class="loading-content">
            <div class="loading-icon">
                <img src="{{ asset('icon/loading.gif') }}" alt="Loading..." style="width: 80px; height: 80px;">
            </div>
            <div class="loading-text">
                <h5 id="loadingTitle">Memproses...</h5>
                <p id="loadingMessage">Mohon tunggu sebentar</p>
            </div>
            <div class="loading-progress">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%; background: linear-gradient(90deg, #5b72ee, #00d4aa);"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(5px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease-in-out;
}

.loading-container {
    text-align: center;
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 20px 60px rgba(31, 41, 55, 0.15);
    border: 1px solid rgba(91, 114, 238, 0.1);
    max-width: 350px;
    width: 90%;
    animation: slideIn 0.4s ease-out;
}

.loading-icon {
    margin-bottom: 20px;
}

.loading-text h5 {
    color: #1a1d29;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 18px;
}

.loading-text p {
    color: #8b92a5;
    margin-bottom: 20px;
    font-size: 14px;
}

.loading-progress {
    margin-top: 15px;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
    to { 
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Loading button states */
.btn-loading {
    position: relative;
    pointer-events: none;
    opacity: 0.8;
}

.btn-loading::after {
    content: '';
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-right: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}
</style>

<script>
class GlobalLoading {
    constructor() {
        this.overlay = document.getElementById('globalLoadingOverlay');
        this.titleElement = document.getElementById('loadingTitle');
        this.messageElement = document.getElementById('loadingMessage');
        this.isVisible = false;
        this.init();
    }

    init() {
        // Auto-handle forms
        this.setupFormHandlers();
        
        // Auto-handle delete confirmations
        this.setupDeleteHandlers();
        
        // Auto-handle AJAX requests
        this.setupAjaxHandlers();
    }

    show(title = 'Memproses...', message = 'Mohon tunggu sebentar') {
        if (this.isVisible) return;
        
        this.titleElement.textContent = title;
        this.messageElement.textContent = message;
        this.overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        this.isVisible = true;
        
        console.log('Loading shown:', { title, message });
    }

    hide() {
        if (!this.isVisible) return;
        
        this.overlay.style.display = 'none';
        document.body.style.overflow = '';
        this.isVisible = false;
        
        console.log('Loading hidden');
    }

    setupFormHandlers() {
        // Handle all forms with specific classes or data attributes  
        document.addEventListener('submit', (e) => {
            const form = e.target;
            
            // Skip if form has data-no-loading attribute
            if (form.hasAttribute('data-no-loading')) return;
            
            // Skip delete-form during confirmation phase
            if (form.classList.contains('delete-form') && !form.dataset.deleteConfirmed) return;
            
            // Determine loading message based on form action
            let title = 'Memproses...';
            let message = 'Mohon tunggu sebentar';
            
            const action = form.action.toLowerCase();
            const method = (form.method || 'get').toLowerCase();
            
            if (method === 'post' || form.querySelector('input[name="_method"][value="PUT"]')) {
                if (action.includes('store') || action.includes('create')) {
                    title = 'Menyimpan Data...';
                    message = 'Sedang menyimpan perubahan';
                } else if (action.includes('update') || action.includes('edit')) {
                    title = 'Memperbarui Data...';
                    message = 'Sedang memperbarui informasi';
                } else {
                    title = 'Menyimpan...';
                    message = 'Sedang memproses permintaan';
                }
            } else if (form.querySelector('input[name="_method"][value="DELETE"]')) {
                title = 'Menghapus Data...';
                message = 'Sedang menghapus item yang dipilih';
            }
            
            // Add loading state to submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            }
            
            this.show(title, message);
        });
    }

    setupDeleteHandlers() {
        // Hook into delete confirmation component
        if (window.confirmDelete) {
            const originalConfirmDelete = window.confirmDelete;
            window.confirmDelete = async (...args) => {
                const result = await originalConfirmDelete(...args);
                if (result) {
                    this.show('Menghapus Data...', 'Sedang menghapus item yang dipilih');
                }
                return result;
            };
        }
    }

    setupAjaxHandlers() {
        // jQuery AJAX handlers
        if (typeof $ !== 'undefined') {
            $(document).ajaxStart(() => {
                this.show('Memuat Data...', 'Sedang mengambil informasi');
            });
            
            $(document).ajaxStop(() => {
                setTimeout(() => this.hide(), 500);
            });
            
            $(document).ajaxError(() => {
                this.hide();
            });
        }
        
        // Fetch API interceptor
        if (window.fetch) {
            const originalFetch = window.fetch;
            window.fetch = async (...args) => {
                const [url, options = {}] = args;
                
                // Skip if request has no-loading header
                if (options.headers && options.headers['X-No-Loading']) {
                    return originalFetch(...args);
                }
                
                let title = 'Memuat Data...';
                let message = 'Sedang mengambil informasi';
                
                if (options.method) {
                    const method = options.method.toUpperCase();
                    if (method === 'POST') {
                        title = 'Menyimpan...';
                        message = 'Sedang memproses data';
                    } else if (method === 'PUT' || method === 'PATCH') {
                        title = 'Memperbarui...';
                        message = 'Sedang memperbarui data';
                    } else if (method === 'DELETE') {
                        title = 'Menghapus...';
                        message = 'Sedang menghapus data';
                    }
                }
                
                this.show(title, message);
                
                try {
                    const response = await originalFetch(...args);
                    setTimeout(() => this.hide(), 500);
                    return response;
                } catch (error) {
                    this.hide();
                    throw error;
                }
            };
        }
    }

    // Public API
    showSave() {
        this.show('Menyimpan Data...', 'Sedang menyimpan perubahan');
    }
    
    showUpdate() {
        this.show('Memperbarui Data...', 'Sedang memperbarui informasi');
    }
    
    showDelete() {
        this.show('Menghapus Data...', 'Sedang menghapus item yang dipilih');
    }
    
    showUpload() {
        this.show('Mengunggah File...', 'Sedang memproses file yang dipilih');
    }
    
    showExport() {
        this.show('Mengekspor Data...', 'Sedang menyiapkan file ekspor');
    }
    
    showImport() {
        this.show('Mengimpor Data...', 'Sedang memproses file import');
    }
}

// Initialize global loading
window.globalLoading = new GlobalLoading();

// Shortcuts for easy access
window.showLoading = (title, message) => window.globalLoading.show(title, message);
window.hideLoading = () => window.globalLoading.hide();

// Auto-hide loading on page ready
document.addEventListener('DOMContentLoaded', () => {
    // Hide any existing loading after page is fully loaded
    setTimeout(() => {
        if (window.globalLoading) {
            window.globalLoading.hide();
        }
    }, 1000);
});

// Handle browser navigation
window.addEventListener('beforeunload', () => {
    if (window.globalLoading) {
        window.globalLoading.show('Memuat Halaman...', 'Sedang berpindah halaman');
    }
});
</script>
