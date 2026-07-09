# 📦 Wibu-POS - Panduan Penggunaan

Selamat datang di **Wibu-POS**, sistem **Point of Sales (POS)** berbasis Laravel dengan tema anime. Berikut adalah panduan lengkap penggunaan aplikasi.

---

# 🚀 Login

Buka aplikasi melalui browser, lalu login menggunakan akun yang tersedia.

## Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@wibu.com` | `password` |
| Kasir | `kasir@wibu.com` | `password` |

> **Catatan:** Pendaftaran akun baru hanya dapat dilakukan oleh Admin melalui menu **Kelola User**.

---

# 👤 Role & Hak Akses

| Menu | Admin | Kasir |
|------|:-----:|:-----:|
| Dashboard | ✅ | ✅ |
| Penjualan | ✅ | ✅ |
| Produk | ✅ | ❌ |
| Kategori | ✅ | ❌ |
| Supplier | ✅ | ❌ |
| Pembelian | ✅ | ❌ |
| Kelola User | ✅ | ❌ |
| Export Data | ✅ | ✅ (Penjualan saja) |
| Hapus Transaksi | ✅ | ❌ |

---

# 📊 Dashboard

Halaman dashboard menampilkan informasi:

- **Total Data**
  - Produk
  - Kategori
  - Supplier
  - Transaksi

- **Penjualan Hari Ini**
  - Total pendapatan
  - Jumlah transaksi hari ini

- **Penjualan Bulan Ini**
  - Total pendapatan bulan berjalan

- **Stok Menipis**
  - Jumlah produk dengan stok di bawah batas minimum

- **Grafik Penjualan**
  - Grafik transaksi 7 hari terakhir menggunakan Chart.js

---

# 🛒 Penjualan

## 1. Membuat Transaksi Baru

Langkah transaksi:

1. Masuk menu **Penjualan**.
2. Klik tombol **Transaksi Baru**.
3. Isi data transaksi:
   - Nama Pelanggan *(opsional)*
   - Metode Pembayaran:
     - Cash
     - Debit
     - Kredit
     - QRIS

4. Tambahkan produk:
   - **Manual**
     - Pilih produk dari dropdown.
     - Atur jumlah produk.
   
   - **Scan QR**
     - Masukkan kode produk.
     - Tekan Enter.

5. Atur:
   - Diskon
   - Pajak *(jika ada)*

6. Masukkan jumlah uang pembayaran.

7. Sistem akan menghitung kembalian otomatis.

8. Klik **Proses Transaksi**.

9. Setelah berhasil, sistem akan menampilkan invoice.

---

## 2. Melihat Riwayat Penjualan

- Admin dapat melihat seluruh transaksi.
- Kasir hanya dapat melihat transaksi yang dibuat sendiri.

---

## 3. Menghapus Transaksi

Ketentuan:

- Hanya Admin yang dapat menghapus transaksi.
- Klik tombol 🗑️ hapus.
- Konfirmasi penghapusan.
- Stok produk akan dikembalikan otomatis.

---

# 📦 Produk (Admin Only)

## Tambah Produk

1. Masuk menu **Produk**.
2. Klik **Tambah Produk**.
3. Isi data:

| Field | Keterangan |
|------|------------|
| Kode Produk | Harus unik (contoh: `PRD-0001`) |
| Nama Produk | Nama produk |
| Kategori | Pilih kategori |
| Supplier | Pilih supplier |
| Harga Beli | Harga modal |
| Harga Jual | Harga jual |
| Stok | Jumlah stok |
| Minimal Stok | Batas stok minimum |
| Deskripsi | Opsional |

4. Klik **Simpan**.

---

## Edit & Hapus Produk

- Klik ✏️ untuk mengedit produk.
- Klik 🗑️ untuk menghapus produk.
- Setiap penghapusan menggunakan konfirmasi SweetAlert2.

---

## Detail Produk & QR Code

1. Klik tombol 👁️ pada produk.
2. Sistem menampilkan:
   - Detail produk.
   - QR Code produk.

QR Code dapat digunakan untuk mempercepat transaksi.

---

# 🏷️ Kategori (Admin Only)

Langkah penggunaan:

1. Masuk menu **Kategori**.
2. Klik **Tambah Kategori**.
3. Isi:
   - Nama kategori.
   - Deskripsi.

4. Klik **Simpan**.

Untuk mengedit atau menghapus gunakan tombol:

- ✏️ Edit
- 🗑️ Hapus

---

# 🏢 Supplier (Admin Only)

Tambah supplier:

1. Masuk menu **Supplier**.
2. Klik **Tambah Supplier**.
3. Isi data:

- Nama supplier
- Contact person
- Nomor telepon
- Email
- Alamat

4. Klik **Simpan**.

---

# 📥 Pembelian (Admin Only)

## Tambah Pembelian

1. Masuk menu **Pembelian**.
2. Klik **Tambah Pembelian**.
3. Pilih:
   - Supplier
   - Tanggal pembelian

4. Tambahkan produk:
   - Pilih produk.
   - Masukkan jumlah.
   - Masukkan harga beli.

5. Klik **Tambah Produk** untuk menambah item lain.

6. Klik **Simpan Pembelian**.

> Stok produk akan bertambah otomatis sesuai jumlah pembelian.

---

## Lihat & Hapus Pembelian

- Tombol 👁️ digunakan untuk melihat detail pembelian.
- Tombol 🗑️ digunakan untuk menghapus pembelian.
- Saat dihapus, stok akan dikurangi kembali.

---

# 👥 Kelola User (Admin Only)

Langkah menambah user:

1. Masuk menu **Kelola User**.
2. Klik **Tambah User**.
3. Isi:
   - Nama
   - Email
   - Password
   - Role:
     - Admin
     - Kasir

4. Klik **Simpan**.

> **Catatan:** Admin tidak dapat menghapus akun sendiri atau akun utama `admin@wibu.com`.

---

# 📤 Export Laporan

Export tersedia dalam format:

- Excel
- PDF

| Menu | Export |
|------|--------|
| Penjualan | Excel & PDF |
| Produk | Excel & PDF |
| Kategori | Excel & PDF |
| Supplier | Excel & PDF |
| Pembelian | Excel & PDF |

Klik tombol **Excel** atau **PDF**, kemudian file akan otomatis terdownload.

---

# 🌙 Dark Mode

Cara menggunakan:

1. Klik tombol **Mode** pada navbar.
2. Tema berubah antara:
   - Light Mode
   - Dark Mode

Preferensi tema akan tersimpan pada browser menggunakan **Local Storage**.

---

# 📱 QR Code

## Fungsi

Mempercepat proses input produk saat transaksi.

## Cara Menggunakan

1. Buka halaman transaksi.
2. Gunakan input **Scan QR Code**.
3. Scan QR Code produk menggunakan HP atau masukkan kode produk manual.
4. Tekan:
   - Enter
   - Tombol Tambah

5. Produk otomatis masuk ke keranjang.

---

# 🔒 Logout

Langkah logout:

1. Klik menu **Logout** pada navbar.
2. Konfirmasi SweetAlert2 akan muncul.
3. Klik **Logout!**

---

# 🖥️ Progressive Web App (PWA)

Wibu-POS dapat diinstall sebagai aplikasi desktop maupun mobile.

## Cara Install

1. Buka aplikasi menggunakan:
   - Google Chrome (Android)
   - Microsoft Edge (Desktop)

2. Klik tombol **Install** pada browser.

3. Ikuti instruksi instalasi.

4. Aplikasi akan muncul pada:
   - Home screen
   - Desktop

---

# ⚙️ Teknologi yang Digunakan

| Teknologi | Fungsi |
|-----------|--------|
| Laravel 11 | Framework Backend |
| PHP 8.3 | Bahasa Pemrograman |
| MySQL 8.0 | Database |
| Bootstrap 5 | UI Framework |
| Chart.js | Grafik Dashboard |
| SweetAlert2 | Notifikasi & Konfirmasi |
| DomPDF | Export PDF |
| MaatExcel | Export Excel |
| Simple QR Code | Generate QR Code |
| PWA | Aplikasi Mobile & Offline |

---

# 📌 Catatan

- Aplikasi dikembangkan untuk **Tugas Besar UAS Pemrograman Web 2**.
- Tema anime (Wibu) digunakan untuk memberikan pengalaman pengguna yang unik.
- Seluruh fitur telah diuji dan berjalan pada:
  - Lingkungan lokal
  - Hosting

---

# 🌸 Selamat Menggunakan Wibu-POS! 🎌
