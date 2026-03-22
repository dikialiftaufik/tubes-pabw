# 🍽️ The Komar's — Restaurant Management System

Aplikasi web manajemen restoran **full-stack** yang dibangun menggunakan **Laravel 12**, mencakup fitur pemesanan makanan, reservasi meja, manajemen menu, serta pelaporan penjualan. Aplikasi ini mendukung tiga peran pengguna: **Admin**, **Kasir**, dan **Pembeli**.

> **Tugas Besar** — Pengembangan Aplikasi Berbasis Web (PABW)  
> Telkom University — Semester 3

---

## ✨ Fitur Utama

| Modul                | Deskripsi                                                         |
| -------------------- | ----------------------------------------------------------------- |
| 🔐 Autentikasi       | Login & Register dengan role-based access (Admin, Kasir, Pembeli) |
| 📋 Manajemen Menu    | CRUD menu makanan oleh Admin (nama, harga, gambar, deskripsi)     |
| 🛒 Pemesanan Online  | Pembeli dapat melihat menu, menambah ke keranjang, dan checkout   |
| 💳 Pembayaran        | Proses pembayaran pesanan dengan berbagai metode                  |
| 📅 Reservasi Meja    | Pembeli dapat melakukan reservasi meja secara online              |
| 📊 Laporan Penjualan | Admin dapat melihat laporan & export ke **Excel** dan **PDF**     |
| 🔔 Notifikasi        | Sistem notifikasi real-time untuk seluruh pengguna                |
| ⭐ Feedback          | Pembeli dapat memberikan feedback/ulasan                          |
| 👨‍🍳 Dashboard Kasir   | Kasir mengelola stok, status pesanan, dan status reservasi        |
| 📜 Riwayat           | Pembeli dapat melihat riwayat pesanan dan reservasi               |

---

## 🛠️ Tech Stack

| Layer        | Teknologi                                             |
| ------------ | ----------------------------------------------------- |
| **Backend**  | PHP 8.2+, Laravel 12                                  |
| **Frontend** | Blade Templates, Bootstrap 5, AdminLTE 3, Vite        |
| **Database** | MySQL                                                 |
| **Auth**     | Laravel UI, Laravel Sanctum                           |
| **Export**   | Maatwebsite Excel (`.xlsx`), Barryvdh DomPDF (`.pdf`) |
| **Styling**  | SASS, TailwindCSS 4, Bootstrap 5                      |

---

## 🏗️ Arsitektur & Struktur Proyek

```
tubes/
├── app/
│   ├── Exports/            # Export logic (SalesReportExport)
│   ├── Http/
│   │   ├── Controllers/    # Controller untuk setiap fitur
│   │   └── Middleware/     # Role-based middleware
│   ├── Models/             # Eloquent Models
│   └── Providers/
├── database/
│   ├── migrations/         # Skema database
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/          # View halaman admin
│       ├── Kasir/          # View halaman kasir
│       ├── auth/           # View login & register
│       ├── layouts/        # Layout utama
│       └── pembayaran/     # View proses pembayaran
├── routes/
│   ├── web.php             # Route utama (web)
│   └── api.php             # Route API
└── public/
    └── img/                # Aset gambar menu & restoran
```

---

## 🔐 Role & Hak Akses

### Admin

- Dashboard statistik penjualan
- CRUD menu makanan
- Cetak laporan penjualan (Export Excel/PDF)
- Kelola notifikasi, reservasi, dan customer
- Moderasi feedback

### Kasir

- Dashboard kasir
- Update stok menu
- Update status pesanan & reservasi
- Profil kasir (upload foto)

### Pembeli

- Melihat menu & detail makanan
- Menambah item ke keranjang & checkout
- Reservasi meja online
- Melihat riwayat pesanan & reservasi
- Memberikan feedback

---

## 🚀 Instalasi & Setup

### Prasyarat

- PHP ≥ 8.2
- Composer
- Node.js & npm
- MySQL

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/<username>/tubes-pabw.git
cd tubes-pabw

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node.js
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
#    DB_DATABASE=tubes-pabw
#    DB_USERNAME=root
#    DB_PASSWORD=

# 7. Jalankan migrasi & seeder
php artisan migrate --seed

# 8. Jalankan aplikasi
composer dev
# atau secara terpisah:
# php artisan serve
# npm run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## 👥 Tim Pengembang

| NIM          | Nama                    | Kontribusi |
| ------------ | ----------------------- | ---------- |
| 607012400005 | **Diki Alif Taufik**    |
| 607012400032 | **Ega Fiandra Pratama** |
| 607012400093 | **Ahmad Zufar Fathoni** |

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademis pada mata kuliah **Pengembangan Aplikasi Berbasis Web** di **Telkom University**.
