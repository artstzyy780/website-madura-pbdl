# 🏪 Toko Madura POS
**Point of Sale System untuk Toko Madura/Material**
Tech Stack: **Laravel 11 · SQLite/MySQL · Bootstrap 5 · Vanilla JS**

---

## 📋 Fitur Utama

| Modul | Fitur |
|-------|-------|
| **Kasir / POS** | Cari produk real-time, scan barcode, keranjang belanja, diskon, cetak struk |
| **Produk & Stok** | CRUD produk, kategori, adjust stok masuk/keluar, alert stok kritis |
| **Hutang Pelanggan** | Catat hutang dari transaksi, bayar cicilan, riwayat per pelanggan |
| **Laporan** | Laporan penjualan (filter tanggal), laporan nilai stok |
| **Dashboard** | Grafik penjualan 7 hari, produk terlaris, ringkasan harian |
| **Manajemen User** | Multi-role (Admin/Kasir), aktif/nonaktif user |
| **Audit Log** | Rekam semua aktivitas penting (create/update/delete) |

---

## 🚀 Cara Instalasi

### 1. Clone / Extract project
```bash
# Jika dari ZIP, extract ke folder
cd toko-madura
```

### 2. Install dependencies
```bash
composer install
```

### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup database

#### Opsi A: SQLite (mudah, tidak perlu install MySQL)
```bash
# .env sudah diset SQLite secara default
touch database/database.sqlite
php artisan migrate --seed
```

#### Opsi B: MySQL
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_madura
DB_USERNAME=root
DB_PASSWORD=password_kamu
```
Lalu:
```bash
mysql -u root -p -e "CREATE DATABASE toko_madura CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate --seed
```

### 5. Jalankan server
```bash
php artisan serve
```
Buka browser: **http://localhost:8000**

---

## 🔑 Akun Default

| Username | Password | Role |
|----------|----------|------|
| `admin` | `admin123` | Admin (akses penuh) |
| `kasir` | `kasir123` | Kasir (akses POS & produk) |

> ⚠️ Ganti password setelah pertama login!

---

## 📁 Struktur Database

```
users           → Data user (admin/kasir)
kategori        → Kategori produk
produk          → Master produk & stok
pelanggan       → Data pelanggan
transaksi       → Header transaksi penjualan
transaksi_item  → Detail item per transaksi
hutang          → Catatan hutang pelanggan
pembayaran_hutang → Riwayat bayar hutang
audit_log       → Jejak semua aktivitas
```

---

## 🖨️ Struk / Print

Struk otomatis terbuka di tab baru setelah transaksi selesai. Lebar optimal: **80mm** (thermal printer). Gunakan browser print dialog atau CTRL+P.

---

## ⌨️ Keyboard Shortcut (Halaman Kasir)

| Tombol | Fungsi |
|--------|--------|
| `F2` | Fokus ke kotak pencarian produk |

---

## 🔧 Konfigurasi Tambahan

### Ganti nama toko (di struk)
Edit file: `resources/views/kasir/struk.blade.php`

### Ganti logo/nama sidebar
Edit file: `resources/views/layouts/app.blade.php`

### Gunakan MySQL (production)
Ubah `DB_CONNECTION=mysql` di file `.env` dan isi kredensial DB.

---

## 📦 Dependencies

- **Laravel 11** - PHP Framework
- **Bootstrap 5.3** - CSS Framework (CDN)
- **Bootstrap Icons** - Icon set (CDN)
- **Chart.js 4** - Grafik dashboard (CDN)

*Semua frontend library dari CDN — tidak perlu npm/vite.*

---

## 🧪 Testing Login & Flow

1. Login sebagai **kasir** → buka halaman **Kasir**
2. Ketik nama produk di search → klik untuk tambah ke keranjang
3. Pilih metode bayar → klik **Proses Pembayaran**
4. Struk otomatis muncul

---

## 📝 Catatan untuk Laporan

Sistem ini dibuat untuk memenuhi kriteria penilaian:
- ✅ **Fungsionalitas**: Pencatatan barang & total belanja
- ✅ **Akurasi Data & Stok**: Stok berkurang otomatis setelah transaksi
- ✅ **Efisiensi**: Lebih cepat dari pencatatan manual
- ✅ **Stabilitas**: Transaction DB untuk konsistensi data
- ✅ **UI/UX**: Tampilan bersih, tombol besar, mudah dibaca
