# FrankenPHP + Laravel 11 - Catatan Penting

## Masalah dengan Auto-Discovery

FrankenPHP menggunakan persistent PHP workers yang berbeda dari traditional PHP-FPM. Ini menyebabkan beberapa masalah dengan Laravel 11:

### 1. Service Provider Auto-Discovery Gagal
Laravel 11 mengandalkan auto-discovery untuk me-load core service providers. Di FrankenPHP, mekanisme ini tidak bekerja dengan baik karena:
- Worker persistence menyebabkan state yang tidak konsisten
- Timing issue saat bootstrap
- Cache yang tidak ter-refresh antar request

### 2. Solusi: Explicit Provider Registration
File `bootstrap/app.php` telah dimodifikasi untuk menggunakan `->withProviders()` yang secara eksplisit mendaftarkan semua core service providers:

```php
->withProviders([
    Illuminate\View\ViewServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    // ... dan lainnya
])
```

Ini memastikan semua service providers ter-load SEBELUM aplikasi mulai menangani request.

## Best Practices untuk FrankenPHP

### 1. Hindari Global State
FrankenPHP workers bersifat persistent, jadi hindari:
- Static variables yang menyimpan state
- Global variables
- Singleton yang menyimpan data request-specific

### 2. Clear Cache Setelah Deployment
Selalu jalankan setelah deploy:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 3. Environment Variables
Pastikan semua environment variables di-set dengan benar di Railway:
- `APP_KEY` - WAJIB, generate dengan `php artisan key:generate`
- `DATABASE_URL` - Connection string PostgreSQL
- `APP_ENV=production`
- `APP_DEBUG=false` (untuk production)

### 4. Restart Workers
Jika ada perubahan code yang signifikan, restart deployment di Railway untuk memastikan workers ter-restart dengan code terbaru.

## Troubleshooting

### Error "Target class [view] does not exist"
✅ Sudah diperbaiki dengan explicit provider registration di `bootstrap/app.php`

### Session tidak persist
Pastikan `SESSION_DRIVER` di-set dengan benar (default: `file`)

### Database connection error
Cek `DATABASE_URL` di environment variables Railway

### 500 Error tanpa detail
Set `APP_DEBUG=true` sementara untuk melihat error detail, tapi jangan lupa kembalikan ke `false` untuk production
