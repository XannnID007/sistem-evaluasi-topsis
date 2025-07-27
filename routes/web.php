<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\EvaluasiController as AdminEvaluasiController;
use App\Http\Controllers\Admin\HasilController as AdminHasilController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\KriteriaController as AdminKriteriaController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Pegawai\EvaluasiController as PegawaiEvaluasiController;
use App\Http\Controllers\Pegawai\HistoryController as PegawaiHistoryController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'pegawai.dashboard')
        : redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Data Pegawai
    Route::resource('pegawai', AdminPegawaiController::class);
    Route::get('/pegawai/export', [AdminPegawaiController::class, 'export'])->name('pegawai.export');

    // Input Evaluasi
    Route::resource('evaluasi', AdminEvaluasiController::class);
    Route::get('/evaluasi/bulk/create', [AdminEvaluasiController::class, 'bulkCreate'])->name('evaluasi.bulk-create');
    Route::post('/evaluasi/bulk/store', [AdminEvaluasiController::class, 'bulkStore'])->name('evaluasi.bulk-store');

    // Hasil & Ranking
    Route::get('/hasil', [AdminHasilController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/{evaluasi}', [AdminHasilController::class, 'show'])->name('hasil.show');
    Route::get('/hasil/export', [AdminHasilController::class, 'export'])->name('hasil.export');
    Route::get('/hasil/comparison', [AdminHasilController::class, 'comparison'])->name('hasil.comparison');

    // Laporan
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/generate', [AdminLaporanController::class, 'generate'])->name('laporan.generate');
    Route::post('/laporan/generate', [AdminLaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{laporan}', [AdminLaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/{laporan}/download', [AdminLaporanController::class, 'download'])->name('laporan.download');

    // Kriteria & Setting
    Route::resource('kriteria', AdminKriteriaController::class);
    Route::post('/kriteria/{kriteria}/toggle-status', [AdminKriteriaController::class, 'toggleStatus'])->name('kriteria.toggle-status');

    // Periode Evaluasi
    Route::resource('periode', AdminPeriodeController::class);
});

// Pegawai Routes
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');

    // Hasil Evaluasi Saya
    Route::get('/evaluasi', [PegawaiEvaluasiController::class, 'index'])->name('evaluasi.index');
    Route::get('/evaluasi/{evaluasi}', [PegawaiEvaluasiController::class, 'show'])->name('evaluasi.show');
    Route::get('/evaluasi/{evaluasi}/download', [PegawaiEvaluasiController::class, 'download'])->name('evaluasi.download');

    // History Evaluasi
    Route::get('/history', [PegawaiHistoryController::class, 'index'])->name('history.index');
    Route::get('/history/comparison', [PegawaiHistoryController::class, 'compareWithPeers'])->name('history.comparison');
});

// Shared Routes (Admin & Pegawai)
Route::middleware('auth')->group(function () {

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});

// API Routes for AJAX calls
Route::middleware('auth')->prefix('api')->name('api.')->group(function () {

    // Get pegawai by kelas jabatan
    Route::get('/pegawai/by-kelas/{kelas}', function ($kelas) {
        return App\Models\User::where('role', 'pegawai')
            ->where('kelas_jabatan', $kelas)
            ->where('status', 'aktif')
            ->select('id', 'nama', 'jabatan')
            ->get();
    })->name('pegawai.by-kelas');

    // Get evaluasi statistics
    Route::get('/evaluasi/stats/{periode_id}', function ($periodeId) {
        $stats = App\Models\Evaluasi::where('periode_id', $periodeId)
            ->selectRaw('
                                       COUNT(*) as total,
                                       AVG(total_skor) as avg_score,
                                       MAX(total_skor) as max_score,
                                       MIN(total_skor) as min_score
                                   ')
            ->first();
        return response()->json($stats);
    })->name('evaluasi.stats');

    // Check if pegawai already evaluated in periode
    Route::get('/evaluasi/check/{user_id}/{periode_id}', function ($userId, $periodeId) {
        $exists = App\Models\Evaluasi::where('user_id', $userId)
            ->where('periode_id', $periodeId)
            ->exists();
        return response()->json(['exists' => $exists]);
    })->name('evaluasi.check');
});

// Fallback route for 404
Route::fallback(function () {
    return abort(404);
});
