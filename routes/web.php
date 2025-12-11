<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/generate-dummy-data', function () {

    // 1. Cek Kategori, kalau kosong buat dulu
    if (Category::count() == 0) {
        Category::create(['name' => 'Elektronik']);
        Category::create(['name' => 'Furniture']);
        Category::create(['name' => 'ATK']);
        Category::create(['name' => 'Peralatan Masak']);
    }

    $categories = Category::all();

    // 2. Loop 20 kali untuk membuat barang
    for ($i = 1; $i <= 20; $i++) {
        Item::create([
            // Nama barang acak, misal: "Barang A1b2C"
            'name' => 'Barang Demo ' . $i . ' - ' . Str::random(5),

            // Pilih kategori acak dari yang sudah ada
            'category_id' => $categories->random()->id,

            // Jumlah acak 1-100
            'quantity' => rand(1, 100),

            // Harga acak 10rb - 5juta
            'price' => rand(10, 5000) * 1000
        ]);
    }

    return "SUKSES! 20 Data Barang Dummy berhasil ditambahkan. Silakan cek halaman Data Barang.";
});

Route::get('/fix-migration', function () {
    try {

        DB::statement('DROP SCHEMA public CASCADE');
        DB::statement('CREATE SCHEMA public');


        Artisan::call('migrate', ["--force" => true]);

        return '<h1>SUKSES! Database Reset & Migrasi Berhasil.</h1>' . nl2br(Artisan::output());
    } catch (\Exception $e) {
        return '<h1>MASIH ERROR:</h1>' . $e->getMessage();
    }
});


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
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
