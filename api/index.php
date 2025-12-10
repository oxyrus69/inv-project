<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| VERCEL FIX: Read-Only Filesystem
|--------------------------------------------------------------------------
| Karena Vercel read-only, kita pindahkan storage path ke folder "/tmp"
| yang diizinkan untuk ditulis.
*/
$storage = '/tmp/storage';

if (!file_exists($storage)) {
    // Buat folder struktur storage di /tmp secara otomatis
    mkdir($storage . '/framework/views', 0777, true);
    mkdir($storage . '/framework/cache', 0777, true);
    mkdir($storage . '/framework/sessions', 0777, true);
    mkdir($storage . '/logs', 0777, true);
}

// Perintahkan Laravel pakai folder ini
$app->useStoragePath($storage);

// Jalankan Aplikasi
// (Gunakan handleRequest untuk Laravel 11, atau handle untuk versi lama)
if (method_exists($app, 'handleRequest')) {
    $app->handleRequest(Request::capture());
} else {
    $app->handle(Request::capture())->send();
}
