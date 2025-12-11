<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes (Versi Debugging Terpisah)
|--------------------------------------------------------------------------
*/

Route::get('/fix-migration', function () {
    try {
        // TAHAP 1: Hapus Total (Nuklir) via PHP
        // Ini menjamin kita menghapus DB yang SEDANG terkoneksi ke Vercel
        DB::statement('DROP SCHEMA public CASCADE');
        DB::statement('CREATE SCHEMA public');

        // TAHAP 2: Jalankan Migrasi Bersih
        Artisan::call('migrate', [
            "--force" => true
        ]);

        return '<h1 style="color:green">SUKSES TOTAL!</h1>' .
            'Database berhasil di-reset dan dimigrasi ulang.<br><br>' .
            'Log Output:<br>' . nl2br(Artisan::output());
    } catch (\Exception $e) {
        return '<h1 style="color:red">ERROR LAGI:</h1>' . $e->getMessage();
    }
});

// Route terpisah untuk Seeding (Isi Data)
Route::get('/run-seed', function () {
    try {
        Artisan::call('db:seed', ["--force" => true]);
        return '2. SEEDER BERHASIL! <br>' . nl2br(Artisan::output());
    } catch (\Exception $e) {
        return 'ERROR SEEDING: ' . $e->getMessage();
    }
});

Route::get('/check-migrations', function () {
    $files = scandir(database_path('migrations'));
    $usersMigrations = [];

    foreach ($files as $file) {
        if (strpos($file, 'users') !== false) {
            $usersMigrations[] = $file;
        }
    }

    return [
        'TOTAL FILE' => count($files),
        'FILE USERS (Harusnya cuma 1)' => $usersMigrations,
        'SEMUA FILE' => $files
    ];
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
