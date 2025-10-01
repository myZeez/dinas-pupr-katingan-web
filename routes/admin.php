<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\UlasanController;
use App\Http\Controllers\Admin\StrukturController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\ProfilDinasController;
use App\Http\Controllers\Admin\FileDownloadController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\SoftDeletedController;
use App\Http\Controllers\Admin\PublicContentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CaptchaSettingController;
use App\Http\Controllers\Admin\ApiDocumentationController;
use App\Http\Controllers\Admin\ComplaintController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'log.admin.activity'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Upload Image for TinyMCE
    Route::post('/upload/image', function (Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/editor', $filename, 'public');

            return response()->json([
                'success' => true,
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'No image uploaded'
        ], 400);
    })->name('upload.image');

    // Pengaduan Management
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('index');
        Route::get('/{pengaduan}', [PengaduanController::class, 'show'])->name('show');
        Route::patch('/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{pengaduan}', [PengaduanController::class, 'destroy'])->name('destroy');
    });

    // Ulasan Management
    Route::prefix('ulasan')->name('ulasan.')->group(function () {
        Route::get('/', [UlasanController::class, 'index'])->name('index');
        Route::get('/{ulasan}', [UlasanController::class, 'show'])->name('show');
        Route::patch('/{ulasan}/status', [UlasanController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{ulasan}', [UlasanController::class, 'destroy'])->name('destroy');
    });

    // Struktur Organisasi Management
    Route::prefix('struktur')->name('struktur.')->group(function () {
        Route::get('/', [StrukturController::class, 'index'])->name('index');
        Route::get('/peta', [StrukturController::class, 'peta'])->name('peta');
        Route::get('/create', [StrukturController::class, 'create'])->name('create');
        Route::post('/', [StrukturController::class, 'store'])->name('store');
        Route::get('/trashed', [StrukturController::class, 'trashed'])->name('trashed');
        Route::get('/jabatan-by-category/{category}', [StrukturController::class, 'getJabatanByCategory'])->name('jabatan-by-category');
        Route::get('/{struktur}', [StrukturController::class, 'show'])->name('show');
        Route::get('/{struktur}/edit', [StrukturController::class, 'edit'])->name('edit');
        Route::put('/{struktur}', [StrukturController::class, 'update'])->name('update');
        Route::delete('/{struktur}', [StrukturController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [StrukturController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [StrukturController::class, 'forceDelete'])->name('force-delete');
    });

    // Admin Management
    Route::prefix('admin-management')->name('admin-management.')->group(function () {
        Route::get('/', [AdminManagementController::class, 'index'])->name('index');
        Route::get('/create', [AdminManagementController::class, 'create'])->name('create');
        Route::post('/', [AdminManagementController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [AdminManagementController::class, 'edit'])->name('edit');
        Route::post('/{user}/reset-password', [AdminManagementController::class, 'resetPassword'])->name('reset-password');
        Route::patch('/{user}/toggle-status', [AdminManagementController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{user}', [AdminManagementController::class, 'show'])->name('show');
        Route::put('/{user}', [AdminManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminManagementController::class, 'destroy'])->name('destroy');
    });

    // User Management
    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::get('/{user}', [UserManagementController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Konten Management (Integrated: Berita, Galeri, File Download)
    Route::prefix('konten')->name('konten.')->group(function () {
        Route::get('/', [KontenController::class, 'index'])->name('index');

        // Berita nested routes
        Route::prefix('berita')->name('berita.')->group(function () {
            Route::get('/', [BeritaController::class, 'index'])->name('index');
            Route::get('/create', [BeritaController::class, 'create'])->name('create');
            Route::post('/', [BeritaController::class, 'store'])->name('store');
            Route::get('/{berita}', [BeritaController::class, 'show'])->name('show');
            Route::get('/{berita}/edit', [BeritaController::class, 'edit'])->name('edit');
            Route::put('/{berita}', [BeritaController::class, 'update'])->name('update');
            Route::delete('/{berita}', [BeritaController::class, 'destroy'])->name('destroy');
            Route::patch('/{berita}/toggle-status', [BeritaController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Galeri nested routes
        Route::prefix('galeri')->name('galeri.')->group(function () {
            Route::get('/', [GaleriController::class, 'index'])->name('index');
            Route::get('/create', [GaleriController::class, 'create'])->name('create');
            Route::post('/', [GaleriController::class, 'store'])->name('store');
            Route::get('/{galeri}', [GaleriController::class, 'show'])->name('show');
            Route::get('/{galeri}/edit', [GaleriController::class, 'edit'])->name('edit');
            Route::put('/{galeri}', [GaleriController::class, 'update'])->name('update');
            Route::delete('/{galeri}', [GaleriController::class, 'destroy'])->name('destroy');
        });

        // File Download nested routes
        Route::prefix('file-download')->name('file-download.')->group(function () {
            Route::get('/', [FileDownloadController::class, 'index'])->name('index');
            Route::get('/create', [FileDownloadController::class, 'create'])->name('create');
            Route::post('/', [FileDownloadController::class, 'store'])->name('store');
            Route::get('/{fileDownload}', [FileDownloadController::class, 'show'])->name('show');
            Route::get('/{fileDownload}/edit', [FileDownloadController::class, 'edit'])->name('edit');
            Route::put('/{fileDownload}', [FileDownloadController::class, 'update'])->name('update');
            Route::delete('/{fileDownload}', [FileDownloadController::class, 'destroy'])->name('destroy');
        });

        // Download aliases for backwards compatibility
        Route::prefix('download')->name('download.')->group(function () {
            Route::get('/', [FileDownloadController::class, 'index'])->name('index');
            Route::get('/create', [FileDownloadController::class, 'create'])->name('create');
            Route::post('/', [FileDownloadController::class, 'store'])->name('store');
            Route::get('/{fileDownload}', [FileDownloadController::class, 'show'])->name('show');
            Route::get('/{fileDownload}/edit', [FileDownloadController::class, 'edit'])->name('edit');
            Route::put('/{fileDownload}', [FileDownloadController::class, 'update'])->name('update');
            Route::delete('/{fileDownload}', [FileDownloadController::class, 'destroy'])->name('destroy');
            Route::get('/{fileDownload}/file', [FileDownloadController::class, 'download'])->name('file');
        });

        // Program nested routes
        Route::prefix('program')->name('program.')->group(function () {
            Route::get('/', [ProgramController::class, 'index'])->name('index');
            Route::get('/create', [ProgramController::class, 'create'])->name('create');
            Route::post('/', [ProgramController::class, 'store'])->name('store');
            Route::get('/{program}', [ProgramController::class, 'show'])->name('show');
            Route::get('/{program}/edit', [ProgramController::class, 'edit'])->name('edit');
            Route::put('/{program}', [ProgramController::class, 'update'])->name('update');
            Route::delete('/{program}', [ProgramController::class, 'destroy'])->name('destroy');
            Route::patch('/{program}/toggle-status', [ProgramController::class, 'toggleStatus'])->name('toggle-status');
            // New status management routes
            Route::post('/{program}/update-status', [ProgramController::class, 'updateStatus'])->name('update-status');
            Route::get('/{program}/status-history', [ProgramController::class, 'getStatusHistory'])->name('status-history');
            Route::post('/sync-statuses', [ProgramController::class, 'syncStatuses'])->name('sync-statuses');
        });

        // Video nested routes
        Route::prefix('video')->name('video.')->group(function () {
            Route::get('/', [VideoController::class, 'index'])->name('index');
            Route::get('/create', [VideoController::class, 'create'])->name('create');
            Route::post('/', [VideoController::class, 'store'])->name('store');
            Route::get('/{video}', [VideoController::class, 'show'])->name('show');
            Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('edit');
            Route::put('/{video}', [VideoController::class, 'update'])->name('update');
            Route::delete('/{video}', [VideoController::class, 'destroy'])->name('destroy');
            Route::patch('/{video}/toggle-status', [VideoController::class, 'toggleStatus'])->name('toggle-status');
        });
    });

    // Video Management - DISABLED (Empty controller)
    /*
    Route::prefix('video')->name('video.')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('index');
        Route::get('/create', [VideoController::class, 'create'])->name('create');
        Route::post('/', [VideoController::class, 'store'])->name('store');
        Route::get('/{video}', [VideoController::class, 'show'])->name('show');
        Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('edit');
        Route::put('/{video}', [VideoController::class, 'update'])->name('update');
        Route::delete('/{video}', [VideoController::class, 'destroy'])->name('destroy');
        Route::patch('/{video}/toggle-status', [VideoController::class, 'toggleStatus'])->name('toggle-status');
    });
    */

    // Profil Management
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');

        // Custom profil routes
        Route::put('/update-profil', [ProfilController::class, 'updateProfil'])->name('update-profil');
    });

    // Profil Dinas Management
    Route::prefix('profil-dinas')->name('profil-dinas.')->group(function () {
        Route::get('/', [ProfilDinasController::class, 'index'])->name('index');
        Route::get('/create', [ProfilDinasController::class, 'create'])->name('create');
        Route::post('/', [ProfilDinasController::class, 'store'])->name('store');
        Route::get('/{profilDinas}', [ProfilDinasController::class, 'show'])->name('show');
        Route::get('/{profilDinas}/edit', [ProfilDinasController::class, 'edit'])->name('edit');
        Route::put('/{profilDinas}', [ProfilDinasController::class, 'update'])->name('update');
        Route::delete('/{profilDinas}', [ProfilDinasController::class, 'destroy'])->name('destroy');
    });

    // Complaint Management
    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('index');
        Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('show');
        Route::put('/{complaint}', [ComplaintController::class, 'update'])->name('update');
        Route::delete('/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');
    });

    // Public Content Management
    Route::prefix('public-content')->name('public-content.')->group(function () {
        Route::get('/', [PublicContentController::class, 'index'])->name('index');
        Route::get('/create', [PublicContentController::class, 'create'])->name('create');
        Route::post('/', [PublicContentController::class, 'store'])->name('store');
        Route::get('/{publicContent}', [PublicContentController::class, 'show'])->name('show');
        Route::get('/{publicContent}/edit', [PublicContentController::class, 'edit'])->name('edit');
        Route::put('/{publicContent}', [PublicContentController::class, 'update'])->name('update');
        Route::delete('/{publicContent}', [PublicContentController::class, 'destroy'])->name('destroy');
    });

    // Account Management
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('updateProfile');
        Route::get('/password', [AccountController::class, 'password'])->name('password');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('updatePassword');
    });

    // Activity Log
    Route::prefix('activity-log')->name('activity-log.')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{log}', [ActivityLogController::class, 'show'])->name('show');
        Route::delete('/{log}', [ActivityLogController::class, 'destroy'])->name('destroy');
        Route::post('/clear', [ActivityLogController::class, 'clear'])->name('clear');
        Route::post('/cleanup', [ActivityLogController::class, 'cleanup'])->name('cleanup');
    });

    // Analytics
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::get('/reports', [AnalyticsController::class, 'reports'])->name('reports');
        Route::get('/export', [AnalyticsController::class, 'export'])->name('export');
    });

    // Recovery & Backup - DISABLED (Empty controller)
    /*
    Route::prefix('recovery')->name('recovery.')->group(function () {
        Route::get('/', [RecoveryController::class, 'index'])->name('index');
        Route::post('/backup', [RecoveryController::class, 'backup'])->name('backup');
        Route::post('/restore', [RecoveryController::class, 'restore'])->name('restore');
    });
    */

    // Soft Deleted Items
    Route::prefix('soft-deleted')->name('soft-deleted.')->group(function () {
        Route::get('/', [SoftDeletedController::class, 'index'])->name('index');
        Route::post('/{model}/{id}/restore', [SoftDeletedController::class, 'restore'])->name('restore');
        Route::delete('/{model}/{id}/force-delete', [SoftDeletedController::class, 'forceDelete'])->name('force-delete');
        Route::post('/cleanup', [SoftDeletedController::class, 'cleanup'])->name('cleanup');
    });

    // Public Content Management
    Route::prefix('public-content')->name('public-content.')->group(function () {
        Route::get('/', [PublicContentController::class, 'index'])->name('index');
        Route::get('/create', [PublicContentController::class, 'create'])->name('create');
        Route::post('/', [PublicContentController::class, 'store'])->name('store');
        Route::get('/{publicContent}', [PublicContentController::class, 'show'])->name('show');
        Route::get('/{publicContent}/edit', [PublicContentController::class, 'edit'])->name('edit');
        Route::put('/{publicContent}', [PublicContentController::class, 'update'])->name('update');
        Route::delete('/{publicContent}', [PublicContentController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [PublicContentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [PublicContentController::class, 'forceDelete'])->name('force-delete');
    });

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/mail', [SettingController::class, 'updateMail'])->name('mail.update');
        Route::post('/mail/test', [SettingController::class, 'testMail'])->name('mail.test');
        Route::put('/profile', [SettingController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [SettingController::class, 'updatePassword'])->name('password.update');
        Route::put('/captcha', [SettingController::class, 'updateCaptcha'])->name('captcha.update');
        Route::post('/captcha/test', [SettingController::class, 'testCaptcha'])->name('captcha.test');
    });

    // CAPTCHA Settings
    Route::prefix('captcha')->name('captcha.')->group(function () {
        Route::get('/', [CaptchaSettingController::class, 'index'])->name('index');
        Route::put('/', [CaptchaSettingController::class, 'update'])->name('update');
        Route::get('/test', [CaptchaSettingController::class, 'test'])->name('test');
    });

    // API Documentation
    Route::prefix('api-docs')->name('api-docs.')->group(function () {
        Route::get('/', function () {
            return redirect('/docs');
        })->name('index');
        Route::get('/swagger', function () {
            return redirect('/docs');
        })->name('swagger');
    });

    // Demo & Examples
    Route::prefix('examples')->name('examples.')->group(function () {
        Route::get('/delete-confirmation-demo', function () {
            return view('admin.examples.delete-confirmation-demo');
        })->name('delete-confirmation-demo');
    });
});
