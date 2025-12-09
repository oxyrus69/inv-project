# Aplikasi Manajemen Inventaris (Laravel + Tailwind)

Aplikasi ini adalah sistem manajemen stok barang berbasis web yang dibangun menggunakan **Laravel** dan **Tailwind CSS**. Project ini dibuat untuk memenuhi persyaratan tes teknis (Technical Assessment).

Aplikasi ini menerapkan arsitektur **MVC**, prinsip **Clean Code**, dan desain antarmuka yang **Responsif (Mobile-Friendly)**.

## 📋 Fitur Utama

Sesuai dengan persyaratan studi kasus, aplikasi ini memiliki fitur:

-   **Autentikasi Aman:** Sistem Login & Logout menggunakan Laravel Breeze.
-   **Dashboard:** Ringkasan navigasi yang user-friendly.
-   **CRUD Barang:**
    -   Menambah data barang (Nama, Kategori, Jumlah, Harga).
    -   Melihat daftar barang.
    -   Mengedit data barang.
    -   Menghapus data barang.
-   **Pencarian & Paginasi:**
    -   Fitur pencarian real-time berdasarkan Nama atau Kategori.
    -   Pagination otomatis (10 item per halaman).
-   **Validasi Data:** Validasi sisi server (Server-side validation) untuk integritas data.
-   **Desain Responsif:**
    -   Tampilan optimal di Desktop.
    -   Tabel yang _scrollable_ dan layout adaptif di Mobile (HP).

## 🛠 Teknologi yang Digunakan

-   **Backend:** Laravel Framework (v10.x / v11.x)
-   **Frontend:** Blade Templates, Tailwind CSS
-   **Authentication:** Laravel Breeze
-   **Database:** MySQL
-   **Scripting:** Alpine.js (via Breeze)

## ⚙️ Persyaratan Sistem

Pastikan komputer sudah terinstall:

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   MySQL Database

## 🚀 Cara Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal (Localhost):

### 1. Clone Repository

```bash
git clone [https://github.com/]https://github.com/oxyrus69/laravel-inventory-app.git
cd laravel-inventory-app
```

### 2. Instal dependensi

composer install
npm install

### 3. Atur .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_inventory
DB_USERNAME=root
DB_PASSWORD=

### 4. Generate app key & migrasi

php artisan key:generate
php artisan migrate

### 5. bangun tailwind

npm run build

### 6. akses web

php artisan serve
npm run dev (inisiasi tailwind)
