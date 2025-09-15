// Enhanced loading utilities for specific admin operations
document.addEventListener('DOMContentLoaded', function() {
    
    // File Upload Progress Loading
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const fileSize = this.files[0].size;
                const fileName = this.files[0].name;
                
                // Show upload preview
                if (fileSize > 1024 * 1024) { // > 1MB
                    if (window.globalLoading) {
                        window.globalLoading.show(
                            'Menyiapkan Upload...', 
                            `File: ${fileName} (${(fileSize / 1024 / 1024).toFixed(2)} MB)`
                        );
                        
                        // Hide after file is processed
                        setTimeout(() => {
                            window.globalLoading.hide();
                        }, 2000);
                    }
                }
            }
        });
    });
    
    // Batch Operations Loading
    const batchButtons = document.querySelectorAll('[data-batch-action]');
    batchButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.batchAction;
            const selectedItems = document.querySelectorAll('input[type="checkbox"]:checked').length;
            
            let title = 'Memproses...';
            let message = 'Sedang memproses item yang dipilih';
            
            switch(action) {
                case 'delete':
                    title = 'Menghapus Item...';
                    message = `Sedang menghapus ${selectedItems} item`;
                    break;
                case 'export':
                    title = 'Mengekspor Data...';
                    message = `Sedang menyiapkan ekspor ${selectedItems} item`;
                    break;
                case 'archive':
                    title = 'Mengarsipkan...';
                    message = `Sedang mengarsipkan ${selectedItems} item`;
                    break;
                case 'restore':
                    title = 'Memulihkan...';
                    message = `Sedang memulihkan ${selectedItems} item`;
                    break;
            }
            
            if (window.globalLoading) {
                window.globalLoading.show(title, message);
            }
        });
    });
    
    // DataTables Loading Integration
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $(document).on('processing.dt', function(e, settings, processing) {
            if (processing) {
                if (window.globalLoading) {
                    window.globalLoading.show('Memuat Tabel...', 'Sedang memproses data tabel');
                }
            } else {
                if (window.globalLoading) {
                    setTimeout(() => window.globalLoading.hide(), 300);
                }
            }
        });
    }
    
    // Form Validation Loading
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('invalid', function(e) {
            // Hide loading if form validation fails
            if (window.globalLoading) {
                window.globalLoading.hide();
            }
            
            // Remove loading state from buttons
            const loadingBtns = form.querySelectorAll('.btn-loading');
            loadingBtns.forEach(btn => {
                btn.classList.remove('btn-loading');
                btn.disabled = false;
            });
        }, true);
    });
    
    // Status Update Loading
    const statusSelects = document.querySelectorAll('select[data-update-status]');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const itemType = this.dataset.updateStatus || 'item';
            if (window.globalLoading) {
                window.globalLoading.show(
                    'Memperbarui Status...', 
                    `Sedang mengubah status ${itemType}`
                );
            }
        });
    });
    
    // Quick Edit Loading
    const editButtons = document.querySelectorAll('[data-quick-edit]');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (window.globalLoading) {
                window.globalLoading.show('Membuka Editor...', 'Sedang menyiapkan form edit');
                
                setTimeout(() => {
                    window.globalLoading.hide();
                }, 1000);
            }
        });
    });
    
    // Search/Filter Loading
    const searchInputs = document.querySelectorAll('input[data-search]');
    searchInputs.forEach(input => {
        let searchTimeout;
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length > 2) {
                    if (window.globalLoading) {
                        window.globalLoading.show('Mencari...', 'Sedang melakukan pencarian');
                        
                        setTimeout(() => {
                            window.globalLoading.hide();
                        }, 1500);
                    }
                }
            }, 500);
        });
    });
    
    // Export/Import Button Loading
    const exportBtns = document.querySelectorAll('[data-action="export"]');
    exportBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const format = this.dataset.format || 'Excel';
            if (window.globalLoading) {
                window.globalLoading.show(
                    'Mengekspor Data...', 
                    `Sedang menyiapkan file ${format}`
                );
            }
        });
    });
    
    const importBtns = document.querySelectorAll('[data-action="import"]');
    importBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (window.globalLoading) {
                window.globalLoading.show(
                    'Menyiapkan Import...', 
                    'Sedang membuka dialog import'
                );
                
                setTimeout(() => {
                    window.globalLoading.hide();
                }, 800);
            }
        });
    });
});

// Utility functions for manual loading control
window.loadingUtils = {
    save: () => window.globalLoading?.showSave(),
    update: () => window.globalLoading?.showUpdate(),
    delete: () => window.globalLoading?.showDelete(),
    upload: (filename = '') => {
        const message = filename ? `Mengunggah: ${filename}` : 'Sedang mengunggah file';
        window.globalLoading?.show('Mengunggah File...', message);
    },
    export: (format = 'Excel') => {
        window.globalLoading?.show('Mengekspor Data...', `Menyiapkan file ${format}`);
    },
    import: (filename = '') => {
        const message = filename ? `Mengimpor: ${filename}` : 'Sedang memproses import';
        window.globalLoading?.show('Mengimpor Data...', message);
    },
    search: (query = '') => {
        const message = query ? `Mencari: "${query}"` : 'Sedang melakukan pencarian';
        window.globalLoading?.show('Mencari Data...', message);
    },
    custom: (title, message) => window.globalLoading?.show(title, message),
    hide: () => window.globalLoading?.hide()
};
