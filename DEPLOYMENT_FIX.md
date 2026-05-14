# Fix untuk Error "Target class [view] does not exist"

## Masalah
Error `BindingResolutionException: Target class [view] does not exist` terjadi karena Laravel's core service providers tidak ter-register dengan benar.

## Solusi yang Sudah Diterapkan

### 1. Update `bootstrap/providers.php`
File ini sekarang secara eksplisit mendaftarkan semua core service providers Laravel, termasuk `ViewServiceProvider`.

### 2. Tambah `config/app.php`
File konfigurasi aplikasi standar Laravel telah ditambahkan.

## Langkah-Langkah di Container/Railway

Setelah deploy ulang, jalankan perintah berikut di container:

```bash
# 1. Pastikan composer dependencies ter-install
composer install --optimize-autoloader --no-dev

# 2. Generate application key jika belum ada
php artisan key:generate

# 3. Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 4. Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Jalankan migrasi jika belum
php artisan migrate --force
```

## Penjelasan Teknis

Dalam Laravel 11, framework seharusnya otomatis menemukan (auto-discover) core service providers dari package `laravel/framework`. Namun, dalam environment tertentu (seperti FrankenPHP/Docker), auto-discovery bisa gagal.

Solusinya adalah mendaftarkan service providers secara eksplisit di `bootstrap/providers.php`, yang merupakan file yang dibaca Laravel saat bootstrap aplikasi.

## Verifikasi

Setelah menjalankan langkah-langkah di atas, akses aplikasi. Error seharusnya sudah hilang dan aplikasi berjalan normal.

Jika masih ada error, cek:
1. `APP_KEY` sudah di-set di `.env`
2. `DATABASE_URL` sudah benar
3. Permissions untuk direktori `storage/` dan `bootstrap/cache/`
