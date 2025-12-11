<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/run-migration', function () {
    // Paksa bersihkan cache config
    Artisan::call('config:clear');

    // GUNAKAN 'migrate:fresh'
    // Ini akan MENGHAPUS semua tabel dulu, baru buat ulang.
    // Dijamin 100% bersih dari error transaksi macet.
    Artisan::call('migrate:fresh', [
        "--force" => true,
        "--seed" => true // Sekalian isi data dummy biar bisa login
    ]);

    return 'RESET DATABASE & MIGRASI SUKSES! <br> Data Dummy sudah dibuat. <br>' . nl2br(Artisan::output());
});

Route::get('/run-seed', function () {
    Artisan::call('db:seed', ["--force" => true]);
    return 'SEEDER SUKSES! <br>' . nl2br(Artisan::output());
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth', 'verified')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('items/print', [ItemController::class, 'print'])->name('items.print');
    Route::resource('items', ItemController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "Cache berhasil dibersihkan! Silakan refresh halaman utama.";
});

require __DIR__ . '/auth.php';
