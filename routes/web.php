<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes (Versi Debugging Terpisah)
|--------------------------------------------------------------------------
*/

// TAHAP 1: HANYA MEMBUAT TABEL (Tanpa Data)
Route::get('/run-migration', function () {
    try {
        Artisan::call('config:clear');

        // Kita pakai migrate biasa, karena tabel sudah kita hapus manual di Neon
        Artisan::call('migrate', ["--force" => true]);

        return 'MIGRASI BERHASIL! <br>' . nl2br(Artisan::output());
    } catch (\Exception $e) {
        // Ini akan menampilkan error ASLI, bukan error "transaction aborted"
        return 'ERROR MIGRASI: ' . $e->getMessage();
    }
});

// TAHAP 2: HANYA MENGISI DATA
Route::get('/run-seed', function () {
    // Jalankan seeder secara terpisah
    try {
        Artisan::call('db:seed', ["--force" => true]);
        return '2. DATA DUMMY BERHASIL DIISI! <br> Silakan Login sekarang. <br><br>' . nl2br(Artisan::output());
    } catch (\Exception $e) {
        // Jika error, kita tangkap pesannya biar jelas bagian mana yang salah
        return 'ERROR SAAT SEEDING (Isi Data): <br>' . $e->getMessage();
    }
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified']) // Pastikan array di sini
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('items/print', [ItemController::class, 'print'])->name('items.print');
    Route::resource('items', ItemController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pembersih cache darurat
Route::get('/force-clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "Cache berhasil dibersihkan! Silakan refresh halaman utama.";
});

require __DIR__ . '/auth.php';
