# Centrental — Base Code Structure

Skeleton struktur kode Laravel untuk Centrental, disusun **persis mengikuti** dokumen di
folder `V2/`: `Rental PRD.md`, `Sprint-Plan-8-Minggu.md`, `ERD-Database-Fase0-1.md`,
`Environment-Setup-Guide.md`, `Testing-Checklist-E2E.md`, dan seluruh file di `wireframe/`.

Ini adalah **kerangka dasar (skeleton)**, bukan aplikasi jadi — file `composer.json` dan
`.env.example` mendaftarkan semua package yang harus diinstal, tapi `vendor/` belum ada
(butuh `composer install` di environment dengan akses ke Packagist). Class dan migration
sudah lengkap strukturnya, dengan `// TODO` di titik yang menunggu detail lebih lanjut
(kredensial API eksternal, business logic detail).

## Struktur Folder

```
app/
  Console/Kernel.php          # Task Scheduler (cron) — lihat Rental PRD.md 5.1
  Http/
    Controllers/Api/          # Endpoint API publik (tenant & kendaraan saja, TANPA data staff)
    Livewire/                 # Satu komponen per layar wireframe (01–19)
  Models/                     # 1 model per tabel di ERD-Database-Fase0-1.md
  Services/                   # Business logic per modul (Tenant, RoleBuilder, Booking, Payment, Verification)
  Repositories/
    Contracts/                # Interface: OcrProviderInterface, RiskScraperInterface, GpsProviderInterface
    Fallback/                 # Implementasi mock — AKTIF DEFAULT (pola fallback)
    Live/                     # Implementasi API asli — TODO menunggu kredensial/format dari Anda
  Jobs/                       # Job queue: OCR ganda, scoring risiko, sync GPS, laporan, webhook
  Policies/                   # Otorisasi berbasis permission (role-builder)
  Providers/AppServiceProvider.php  # Binding interface -> Fallback/Live berdasar .env

config/
  permission.php              # spatie/laravel-permission, teams=true (role-builder per tenant)
  services.php                # Flag OCR_MODE / SCRAPER_MODE / GPS_MODE

database/
  migrations/                 # 18 tabel sesuai ERD-Database-Fase0-1.md, urut sesuai foreign key
  seeders/                    # Role default, tenant demo, 3 kendaraan dummy

resources/views/livewire/     # Blade stub per komponen (belum diisi markup dari wireframe)

routes/
  web.php                     # Rute per wireframe (01–19)
  api.php                     # API publik v1 (booking, vehicle, report)
  console.php
```

## Yang Masih Perlu Dikerjakan (sesuai Item Terbuka di Rental PRD.md)

1. Isi markup Blade di `resources/views/livewire/` dari desain di `wireframe/*.html`.
2. Lengkapi `app/Repositories/Live/*.php` begitu kredensial/format API (VeryHub, PaddleOCR,
   API scraper, API/data GPS tenant) tersedia — cukup isi implementasinya, tidak perlu ubah
   kode di Services/Jobs karena semua bicara ke interface (`Contracts/`).
3. Lengkapi detail permission per modul (`database/seeders/PermissionSeeder.php` baru permission
   dasar CRUD — perlu disempurnakan sesuai daftar aksi final per role).
4. Jalankan `composer install` dan `npm install` di environment dengan akses internet penuh
   (lihat `Environment-Setup-Guide.md` untuk urutan lengkap).

Nama produk final belum ditentukan — kode ini pakai nama folder `Centrental` mengikuti nama
file yang Anda unggah, sesuai `Rental PRD.md` yang sengaja tidak mencantumkan brand.
