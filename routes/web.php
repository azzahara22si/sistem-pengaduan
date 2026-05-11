<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Models\Pengaduan;
use App\Models\UnitLayanan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitLayananController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $stats = [
        'total' => Pengaduan::count(),
        'menunggu' => Pengaduan::where('status', 'menunggu')->count(),
        'proses' => Pengaduan::where('status', 'proses')->count(),
        'selesai' => Pengaduan::where('status', 'selesai')->count(),
    ];

    $unitReports = UnitLayanan::all()->map(function ($unit) {
        $unit->report_count = Pengaduan::where('unit_id', $unit->id)
            ->orWhere(function ($query) use ($unit) {
                $query->whereNull('unit_id')->where('unit_tujuan', $unit->nama_unit);
            })
            ->count();
        return $unit;
    });

    $socialLinks = [
        'instagram' => 'https://www.instagram.com/pcr_campus?igsh=MTdjajY1OXF5NnNybQ==',
        'youtube' => 'https://www.youtube.com/@PoliteknikCaltexRiauOfficial',
        'twitter' => 'https://x.com/PolicaltexRiau',
        'google' => 'https://pcr.ac.id',
    ];

    return view('landing', compact('stats', 'unitReports', 'socialLinks')); 
})->name('landing');

/* ================== AUTH ================== */
Route::middleware(['auth'])->group(function () {

    // Dashboard Redirector
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role === 'admin_spmi') {
            return redirect()->route('dashboard.admin_spmi');
        }
        return redirect()->route('dashboard.mahasiswa');
    })->name('dashboard');

    // Dashboard Admin (Unit)
    Route::get('/dashboard-admin', function () {
        $user = Auth::user();
        $unit_id = $user->unit_id;
        
        $pengaduans = Pengaduan::where('unit_id', $unit_id)
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'baru' => Pengaduan::where('unit_id', $unit_id)->where('status', 'menunggu')->count(),
            'proses' => Pengaduan::where('unit_id', $unit_id)->where('status', 'proses')->count(),
            'selesai' => Pengaduan::where('unit_id', $unit_id)->where('status', 'selesai')->count(),
        ];
        
        return view('admin.dashboard-admin', compact('pengaduans', 'stats'));
    })->name('dashboard.admin');

    Route::get('/dashboard-admin-spmi', function () {
        $pengaduans = Pengaduan::latest()->paginate(5);
        
        // Data untuk Bar Chart (Per Unit)
        $unitStats = Pengaduan::select('unit_tujuan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('unit_tujuan')
            ->get();
            
        // Data untuk Pie Chart (Status/Urgensi - as dummy category for now since category column is not consistent)
        $statusStats = Pengaduan::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin-spmi.dashboard-admin-spmi', compact('pengaduans', 'unitStats', 'statusStats'));
    })->name('dashboard.admin_spmi');

    // CRUD Pengaduan (WAJIB cuma 1x)
    Route::resource('pengaduan', PengaduanController::class);

    // Rekapitulasi
    Route::get('/rekapitulasi', [PengaduanController::class, 'rekapitulasi'])
    ->name('rekapitulasi');

    // User Resource
    Route::resource('user', UserController::class)->middleware('auth');

    // Unit Layanan Resource
    Route::resource('unit', UnitLayananController::class)->middleware('auth');

    // Dashboard statistik
    Route::get('/dashboard-pengaduan', [PengaduanController::class, 'dashboard'])
        ->name('dashboard.pengaduan');

    // Mahasiswa
    Route::get('/mahasiswa', function () {
        $user = Auth::user();
        $pengaduans = Pengaduan::where('user_id', $user->id)->latest()->take(5)->get();
        $stats = [
            'total' => Pengaduan::where('user_id', $user->id)->count(),
            'proses' => Pengaduan::where('user_id', $user->id)->where('status', 'proses')->count(),
            'selesai' => Pengaduan::where('user_id', $user->id)->where('status', 'selesai')->count(),
        ];
        return view('dashboard-mahasiswa', compact('pengaduans', 'stats'));
    })->name('dashboard.mahasiswa');

    // Tanggapan & Status
    Route::post('/tanggapan/{id}', [TanggapanController::class, 'store'])->name('tanggapan.store');
    Route::patch('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.status.update');
    Route::post('/pengaduan/{id}/salurkan', [PengaduanController::class, 'salurkan'])->name('pengaduan.salurkan');
    Route::post('/pengaduan/{id}/feedback', [PengaduanController::class, 'storeFeedback'])->name('pengaduan.feedback');
    Route::get('/riwayat-tanggapan', [PengaduanController::class, 'riwayat'])->name('riwayat.tanggapan');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';