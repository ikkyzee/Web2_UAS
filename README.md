# 📦 Sistem Inventaris & Distribusi Gudang Tekstil

Aplikasi berbasis web berskala *enterprise* untuk manajemen stok dan distribusi tekstil. Sistem ini dirancang menggunakan konsep **Serialized Inventory Tracking** (pelacakan aset satuan), di mana 1 baris data merepresentasikan 1 fisik gulungan kain (roll) beserta bobot (kiloan) uniknya. 

Dibangun dengan ekosistem Laravel 11 dan antarmuka modern menggunakan Tailwind CSS, sistem ini bertujuan untuk menghilangkan *data silo* antara gudang pusat dan toko cabang, serta memastikan akurasi data pengiriman logistik.

---

## ✨ Fitur Utama

- **🔐 Manajemen Hak Akses (Role-Based Access Control):**
  - **Admin:** Akses penuh ke seluruh data master, pengguna, dan laporan.
  - **Petugas (Operator Gudang):** Akses operasional untuk mencatat penerimaan barang (Inbound) dan memproses surat jalan pengiriman (Outbound).
  - **Admin Toko:** Akses visibilitas untuk melihat jadwal pengiriman ke tokonya sendiri.
- **🏷️ Serialized Inventory (Inbound & Cataloging):**
  - Pemisahan fase *Staging* (Penerimaan fisik barang per batch & roll) dan *Cataloging* (Pendaftaran roll fisik ke dalam master katalog SKU barang).
- **🚚 Manajemen Distribusi (Outbound):**
  - Pembuatan surat jalan dengan validasi armada dan supir.
  - Pemilihan spesifik gulungan kain (roll) yang akan dinaikkan ke truk menggunakan antarmuka *checkbox* dinamis.
- **📊 Dashboard & Laporan:**
  - Visualisasi tren pengiriman bulanan menggunakan Chart.js.
  - Filter laporan stok (*Real-time* di gudang vs Terkirim ke toko).
  - Export laporan operasional ke format **PDF** dan **Excel**.
- **🎨 Modern UI/UX:**
  - Antarmuka responsif berbasis **Tailwind CSS**.
  - Interaksi *dropdown* dan *expandable row* menggunakan **Alpine.js**.
  - Notifikasi dan validasi popup menggunakan **SweetAlert2**.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Packages:**
  - `barryvdh/laravel-dompdf` (Cetak PDF)
  - `maatwebsite/excel` (Export Excel)
  - `realrashid/sweet-alert` (Alert Dialogs)

---

## ⚙️ Persyaratan Sistem (Prerequisites)

Sebelum menginstal, pastikan sistem Anda memiliki:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB

---

## 🚀 Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di komputer lokal Anda:

1. **Clone Repositori**
   ```bash
   git clone [https://github.com/username-kamu/nama-repo-kamu.git](https://github.com/username-kamu/nama-repo-kamu.git)
   cd nama-repo-kamu