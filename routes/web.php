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
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== PROTECTED ROUTES ====================
Route::middleware(['auth'])->group(function () {

    // Dashboard - All roles can access
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== LAYANAN ROUTES (READ-ONLY FOR ALL) ====================
    // All authenticated users can view layanan (warga needs to see available services)
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/{layanan}', [LayananController::class, 'show'])->name('layanan.show');

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
    });

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
        
        // Reports
        Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('/reports/performance', [ReportController::class, 'performance'])->name('reports.performance');
    });

    // ==================== WARGA ONLY ROUTES ====================
    Route::middleware(['role:warga'])->group(function () {
        Route::get('/profile', function () {
            return view('profile');
        })->name('profile');
        Route::get('/my-permohonan', [PermohonanController::class, 'myPermohonan'])->name('permohonan.my');
    });
});

// ==================== FALLBACK ROUTE ====================
Route::fallback(function () {
    return view('errors.404');
});