<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Models\Pengaduan;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

/* ================== AUTH ================== */
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/dashboard-admin', function () {
        return view('admin.dashboard-admin');
    })->name('dashboard.admin');

    // CRUD Pengaduan (WAJIB cuma 1x)
    Route::resource('pengaduan', PengaduanController::class);

    // Rekapitulasi
    Route::get('/rekapitulasi', [PengaduanController::class, 'rekapitulasi'])
    ->name('rekapitulasi');

    // User
    Route::get('/user', [UserController::class, 'index'])
    ->name('user.index')
    ->middleware('auth');

    // Dashboard statistik
    Route::get('/dashboard-pengaduan', [PengaduanController::class, 'dashboard'])
        ->name('dashboard.pengaduan');

    // Mahasiswa
    Route::get('/mahasiswa', function () {
        $pengaduans = Pengaduan::latest()->get();
        return view('dashboard-mahasiswa', compact('pengaduans'));
    })->name('dashboard.mahasiswa');

    // Tanggapan
    Route::post('/tanggapan/{id}', [TanggapanController::class, 'store'])
        ->name('tanggapan.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';