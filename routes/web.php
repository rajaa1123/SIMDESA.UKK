<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AssetController;

use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [DashboardController::class, 'landing']);
Route::get('/verifikasi-surat/{code}', [App\Http\Controllers\SuratController::class, 'verify'])->name('surat.verify');


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Flow
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ==================== PROTECTED ROUTES ====================
Route::middleware(['auth'])->group(function () {

    // Notification API (Admin & Kepala Desa only)
    Route::middleware(['role:admin,kepala_desa'])->group(function () {
        Route::get('/api/notifications/pending-count', [App\Http\Controllers\NotificationController::class, 'getPendingCount'])->name('api.notifications.pending');
        Route::get('/api/notifications/recent', [App\Http\Controllers\NotificationController::class, 'getRecentSubmissions'])->name('api.notifications.recent');
    });

    // Approval Count API (Kepala Desa only)
    Route::middleware(['role:kepala_desa'])->group(function () {
        Route::get('/api/notifications/approval-count', [App\Http\Controllers\NotificationController::class, 'getApprovalCount'])->name('api.notifications.approval');
    });

    // Dashboard - All roles can access
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== LAYANAN ROUTES (READ-ONLY FOR ALL) ====================
    // All authenticated users can view layanan (warga needs to see available services)
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');

    // ==================== BERITA ROUTES (READ-ONLY FOR ALL) ====================
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

    // ==================== ADMIN & KEPALA_DESA ROUTES ====================
    Route::middleware(['role:admin,kepala_desa'])->group(function () {

        // Warga Management
        Route::resource('warga', WargaController::class);

        // Kartu Keluarga Management
        Route::resource('kartu-keluarga', KartuKeluargaController::class);

        // Layanan Management (Create, Edit, Delete for Admin/Kepala Desa only)
        Route::resource('layanan', LayananController::class)->except(['index', 'show']);

        // Dokumen Management
        Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
        Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
        Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
        Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show'); // ✅ PAKAI {dokumen}
        Route::get('/dokumen/{dokumen}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit'); // ✅ PAKAI {dokumen}
        Route::put('/dokumen/{dokumen}', [DokumenController::class, 'update'])->name('dokumen.update'); // ✅ PAKAI {dokumen}
        Route::delete('/dokumen/{dokumen}', [DokumenController::class, 'destroy'])->name('dokumen.destroy'); // ✅ PAKAI {dokumen}

        // User Management
        Route::resource('users', UserController::class);
        Route::post('/users/bulk-activate', [UserController::class, 'bulkActivate'])->name('users.bulk-activate');
        Route::post('/users/bulk-deactivate', [UserController::class, 'bulkDeactivate'])->name('users.bulk-deactivate');
        Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/permohonan', [ReportController::class, 'permohonan'])->name('reports.permohonan');
        Route::get('/reports/warga', [ReportController::class, 'warga'])->name('reports.warga');
        Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('/reports/performance', [ReportController::class, 'performance'])->name('reports.performance');

        // Keuangan Management
        Route::resource('keuangan', KeuanganController::class);

        // Asset Management
        Route::resource('assets', AssetController::class);



        // Backup Management (Admin Only)
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');
        });

        // Berita Management (Admin/Kades only for create/edit/delete)
        Route::resource('berita', BeritaController::class)->except(['index', 'show'])->parameters(['berita' => 'berita']);
    });

    Route::get('/layanan/{layanan}', [LayananController::class, 'show'])->name('layanan.show');
    Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

    // ==================== PERMOHONAN/PENGAJUAN LAYANAN ROUTES ====================

    // All authenticated users can view and create pengajuan
    Route::resource('permohonan', PermohonanController::class)->except(['edit', 'update', 'destroy']);
    
    // API: Get form schema for layanan (for dynamic form rendering)
    Route::get('/api/layanan/{layanan}/form-schema', [PermohonanController::class, 'getFormSchema'])
        ->name('api.layanan.form-schema');

    // ==================== FILE OPERATIONS (SECURE DOWNLOAD/UPLOAD) ====================
    // Secure file download and stream (all authenticated users with proper authorization)
    Route::get('/file/{attachment}/download', [FileController::class, 'download'])
        ->name('file.download');
    Route::get('/file/{attachment}/stream', [FileController::class, 'stream'])
        ->name('file.stream');
    
    // Upload/manage attachments (warga only, with authorization checks in controller)
    Route::post('/permohonan/{permohonan}/upload-attachment', [PermohonanController::class, 'uploadAttachment'])
        ->name('permohonan.upload-attachment');
    Route::post('/attachment/{attachment}/replace', [PermohonanController::class, 'replaceAttachment'])
        ->name('attachment.replace');
    Route::delete('/attachment/{attachment}', [PermohonanController::class, 'deleteAttachment'])
        ->name('attachment.delete');

    // Hasil Surat Operations (Admin/Kades can upload, Warga/Admin/Kades can download)
    Route::post('/permohonan/{permohonan}/upload-hasil-surat', [PermohonanController::class, 'uploadHasilSurat'])
        ->middleware('role:admin,kepala_desa')
        ->name('permohonan.upload-hasil-surat');
    
    Route::get('/permohonan/{permohonan}/download-hasil-surat', [PermohonanController::class, 'downloadHasilSurat'])
        ->name('permohonan.download-hasil-surat');

    // Admin can verify pengajuan (terima/tolak)
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/permohonan/{permohonan}/verifikasi', [PermohonanController::class, 'verifikasiAdmin'])
            ->name('permohonan.verifikasi');
    });

    // Admin & Kepala Desa can manage all permohonan
    Route::middleware(['role:admin,kepala_desa'])->group(function () {
        Route::get('/permohonan/{permohonan}/edit', [PermohonanController::class, 'edit'])->name('permohonan.edit');
        Route::put('/permohonan/{permohonan}', [PermohonanController::class, 'update'])->name('permohonan.update');
        Route::delete('/permohonan/{permohonan}', [PermohonanController::class, 'destroy'])->name('permohonan.destroy');
        Route::post('/permohonan/{permohonan}/update-status', [PermohonanController::class, 'updateStatus'])->name('permohonan.update-status');
        
        // Surat Management (Auto-Generate)
        Route::get('/surat/{permohonan}/preview', [App\Http\Controllers\SuratController::class, 'preview'])->name('surat.preview');
        Route::post('/surat/{permohonan}/generate', [App\Http\Controllers\SuratController::class, 'generate'])->name('surat.generate');
    });

    // ==================== KEPALA_DESA ONLY ROUTES ====================
    Route::middleware(['role:kepala_desa'])->group(function () {
        // Approval pengajuan layanan
        Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
        Route::get('/approval/{permohonan}', [ApprovalController::class, 'show'])->name('approval.show');
        Route::post('/approval/{permohonan}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/approval/{permohonan}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    });

    // ==================== PROFILE ROUTES ====================
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // ==================== WARGA ONLY ROUTES ====================
    Route::middleware(['role:warga'])->group(function () {
        Route::get('/my-permohonan', [PermohonanController::class, 'myPermohonan'])->name('permohonan.my');
    });

    // ==================== PENGADUAN MASYARAKAT ====================
    Route::resource('pengaduan', PengaduanController::class);

});

// ==================== FALLBACK ROUTE ====================
Route::fallback(function () {
    return view('errors.404');
});