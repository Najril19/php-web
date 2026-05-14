# MJMScan+ (Laravel)

Port **Laravel 11 + PHP 8.2+** dari proyek Next.js `mjmscan-next`: **URL utama, skema PostgreSQL, alur auth, diagnosa forward chaining, admin CRUD, export laporan** disamakan.

## Prasyarat

- PHP **8.2+** (ext: `pdo_pgsql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`)
- [Composer](https://getcomposer.org/)
- PostgreSQL (sama seperti Next: Neon / lokal)

## Setup

```bash
cd mjmscan-laravel
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

- `DB_*` — isi sama dengan `DATABASE_URL` / koneksi yang dipakai app Next (bisa **database yang sama**; migrasi Laravel membuat tabel yang sama persis dengan `db.ts`).
- `ADMIN_EMAIL`, `ADMIN_PASSWORD` — akun admin seed (default `admin@local.id` / `admin123`).
- `APP_URL` — URL publik app Laravel.

Jalankan migrasi + seed:

```bash
php artisan migrate --seed
php artisan serve
```

Buka `http://127.0.0.1:8000` → redirect ke `/login`. Login admin pakai `ADMIN_EMAIL` / `ADMIN_PASSWORD`.

## Rute (mirror Next)

| Area | Contoh |
|------|--------|
| Auth | `/login`, `/register`, `POST /auth/signout` |
| User | `/user/dashboard`, `/user/diagnosa`, `/user/hasil-diagnosa/{id}`, `/user/riwayat`, … |
| Admin | `/admin/dashboard`, `/admin/penyakit`, `/admin/gejala`, `/admin/relasi`, `/admin/pengguna`, `/admin/riwayat`, `/admin/laporan`, `/admin/diagnosa/{id}` |
| Export | `GET /api/admin/export/laporan?format=pdf|excel&start_date=&end_date=` |
| Health | `/api/health`, `/api/health/db` |

Sesi disimpan di **session Laravel** (bukan iron-session); perilaku proteksi route setara middleware Next.

## Catatan deploy

- **Jangan** commit `.env`.
- Bisa deploy ke **Railway / VPS** dengan `php artisan serve` atau **Nginx + PHP-FPM** (document root `public/`).
- Export PDF memakai **barryvdh/laravel-dompdf**; Excel memakai **PhpSpreadsheet** (format `.xlsx`).

## Folder Next asli

Proyek Next tetap ada di `../mjmscan-next` — dua stack bisa dipakai berdampingan sampai migrasi penuh ke PHP selesai.
