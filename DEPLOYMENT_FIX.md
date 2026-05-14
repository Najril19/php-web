# Fix untuk Error "Target class [view] does not exist"

## Masalah
Error `BindingResolutionException: Target class [view] does not exist` terjadi karena Laravel's core service providers tidak ter-register dengan benar di environment FrankenPHP/Docker.

## Solusi yang Sudah Diterapkan

### 1. Update `bootstrap/app.php`
File ini sekarang menggunakan method `->withProviders()` untuk secara eksplisit mendaftarkan semua core service providers Laravel SEBELUM aplikasi di-create. Ini memastikan ViewServiceProvider dan service providers lainnya tersedia sejak awal.

### 2. Tambah `config/app.php`
File konfigurasi aplikasi standar Laravel telah ditambahkan.

### 3. Update `bootstrap/providers.php`
File ini berisi daftar lengkap core service providers (sebagai backup).

## Penjelasan Teknis

Dalam Laravel 11, framework seharusnya otomatis menemukan (auto-discover) core service providers dari package `laravel/framework`. Namun, dalam environment FrankenPHP/Docker, auto-discovery gagal karena:

1. FrankenPHP menggunakan persistent worker yang mungkin tidak me-reload service providers dengan benar
2. Timing issue saat bootstrap - exception terjadi sebelum service providers ter-load
3. Cache atau autoloader yang tidak ter-refresh dengan benar

Solusinya adalah menggunakan `->withProviders()` di `bootstrap/app.php` untuk memaksa registrasi service providers secara eksplisit sebelum aplikasi di-create.

## Langkah-Langkah di Container/Railway

Setelah deploy ulang, aplikasi seharusnya langsung berjalan. Jika masih ada masalah, jalankan:

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

# 4. Jalankan migrasi jika belum
php artisan migrate --force
```

## Verifikasi

Setelah deployment, akses aplikasi di browser. Error "Target class [view] does not exist" seharusnya sudah hilang.

Jika masih ada error, cek:
1. `APP_KEY` sudah di-set di environment variables Railway
2. `DATABASE_URL` sudah benar
3. Permissions untuk direktori `storage/` dan `bootstrap/cache/`
4. Restart deployment di Railway untuk memastikan FrankenPHP worker ter-restart
