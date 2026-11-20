# DETROIT - Digital Invitation Studio

Aplikasi Web Undangan Digital Premium berbasis **Laravel (PHP 8.2 / 8.3)**, **MySQL Database**, **Bootstrap 5**, dan **WhatsApp Notification API Integration**.

Proyek ini dibangun berdasarkan desain referensi yang mencakup Landing Page elegan bernuansa *champagne gold*, alur pemesanan 3 langkah (Pilih Template, Data Pesanan, Pembayaran QRIS/Bank/E-Wallet), notifikasi otomatis WhatsApp beserta halaman undangan digital interaktif, dan Admin Dashboard lengkap.

---

## 🌟 Fitur Utama

### 1. Landing Page Elegan (Sesuai Referensi Gambar 1 & 2)
- **Header & Brand:** Logo monogram emas Detroit, menu navigasi responsif, pencarian, dan tombol *Pesan Sekarang*.
- **Hero Section:**
  - Badge *✨ Undangan Digital Premium*.
  - Headline eksklusif *DETROIT Digital Invitation Studio*.
  - Keunggulan utama (*Proses Super Cepat*, *Desain Responsif*, *Kualitas Premium*).
  - Mockup visual smartphone & kartu ucapan *Terima Kasih*.
  - Tombol CTA *Pesan Sekarang* & *Lihat Demo*.
- **Katalog 10+ Template Eksklusif:**
  - Kategori lengkap: Pernikahan, Khitanan, Ulang Tahun, Aqiqah, Lamaran, Pengajian.
  - Filter kategori interaktif.
  - Tombol *Pilih Template* dan *Lihat Demo*.
- **Kategori Spesial:**
  - Pernikahan & Lamaran
  - Khitanan & Aqiqah
  - Ulang Tahun & Anniversary
  - Pengajian & Acara Islami
  - Acara Lainnya
- **Mengapa Memilih DETROIT:**
  - Desain Premium, Mudah Digunakan, Harga Terjangkau, Customer Support.
- **Paket Harga:**
  - **Basic:** Rp 99.000
  - **Premium (Paling Populer):** Rp 149.000
  - **Enterprise:** Rp 299.000
- **Call to Action Banner:** Banner hitam emas mewah untuk pemesanan instan.

---

### 2. Alur Pemesanan & Pembayaran 3 Langkah (Wizard Checkout)
1. **Langkah 1 (Pilih Template):** Pemilihan template visual dengan pratinjau langsung.
2. **Langkah 2 (Data Pesanan):**
   - Ringkasan pesanan & harga total (Rp 149.000).
   - Form data pemesan (Nama, No. WhatsApp, Email).
   - Detail acara (Judul undangan, tanggal acara, nama mempelai, venue/lokasi).
3. **Langkah 3 (Pembayaran Multi-Metode):**
   - **QRIS:** Pratinjau kode QRIS nasional untuk scan semua bank & e-wallet.
   - **Transfer Bank:** Pilihan rekening BCA, Bank Mandiri, BNI, BRI dengan tombol salin nomor rekening instan.
   - **E-Wallet:** Pilihan transfer GoPay, DANA, OVO.
   - Konfirmasi pembayaran instan.

---

### 3. Integrasi Notifikasi WhatsApp (Sesuai Referensi Gambar 2)
Setelah pembayaran berhasil, sistem langsung:
- Menghasilkan tautan undangan aktif (`/invitation/{slug}` atau `/invitation/abc123`).
- Menampilkan mockup chat WhatsApp resmi Detroit.
- Menyediakan tombol langsung **"Buka & Kirim ke WhatsApp"** yang memicu URL `api.whatsapp.com/send` dengan pesan otomatis:
  ```text
  Halo Kak Alfaro Fadhil,
  Terima kasih telah memesan di DETROIT!

  Berikut detail pesanan Anda:
  📦 Template: Elegance Wedding
  💰 Total: Rp 149.000
  💳 Metode: QRIS

  🔗 Link Undangan Anda:
  http://localhost/Detroit/public/invitation/abc123

  Terima kasih telah mempercayakan momen spesial Anda kepada kami. ❤️
  ```

---

### 4. Halaman Undangan Digital Interaktif
- **Floating Music Player:** Pemutar audio latar (BGM) romantis dengan piringan berputar dan tombol play/pause.
- **Opening Envelope Cover:** Halaman pembuka personal *"Kepada Yth. Bapak/Ibu/Saudara/i [Nama Tamu]"* yang membuka undangan dengan transisi halus dan memutar lagu secara otomatis.
- **Mempelai & Orang Tua:** Biodata lengkap kedua mempelai beserta tautan Instagram.
- **Ayat Suci / Kutipan Mutiara:** Kutipan QS. Ar-Rum: 21.
- **Hitung Mundur (Countdown Timer):** Timer langsung (Hari, Jam, Menit, Detik).
- **Rangkaian Acara:** Akad Nikah & Resepsi Pernikahan dilengkapi tombol *Buka Google Maps*.
- **RSVP Online:** Formulir konfirmasi kehadiran tamu (Hadir, Tidak Hadir, Ragu-ragu) tersimpan ke database.
- **Buku Tamu (Guestbook):** Formulir ucapan dan feed doa restu dari para tamu secara langsung.
- **Amplop Digital:** Rekening BCA dan Bank Mandiri untuk hadiah tanda kasih dilengkapi tombol salin nomor rekening.

---

### 5. Admin Panel & Dashboard (Sesuai Referensi Gambar 2)
Akses di URL `/admin` (Login diperlukan):
- **Sidebar Gelap:** Dashboard, Pesanan, Template, Kategori, Pengguna, Pengaturan, Logout.
- **Kartu Metrik Statistik:**
  - Total Pesanan: **245** (+12%)
  - Pendapatan: **Rp 35.750.000** (+18%)
  - Template Aktif: **10** (+2)
- **Grafik Penjualan:** Grafik garis interaktif (Chart.js) selama 12 bulan (Jan - Des).
- **Pesanan Terbaru:** Daftar pesanan masuk dengan status *Paid* / *Pending*, nominal, dan opsi detail.
- **Manajemen Pesanan:** Ubah status (Pending, Paid, Cancelled) dan tombol kirim WhatsApp ke pembeli.
- **Manajemen Template:** Tambah, edit, aktifkan/nonaktifkan, dan hapus template undangan.
- **Manajemen Kategori:** Tambah dan edit kategori undangan.
- **Manajemen Pengguna:** Lihat daftar user, role, dan total pesanan.
- **Pengaturan Platform:** Kelola nomor WhatsApp admin, nama brand, email, dan rekening bank.

---

## 🗄️ Database & Kredensial

Database MySQL: **`detroit`**
File backup dump SQL lengkap tersedia di: [`database/detroit.sql`](database/detroit.sql).

### Akun Login Bawaan:
| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@detroit.id` | `password` |
| **Super Admin** | `superadmin@detroit.id` | `password` |
| **Pelanggan Demo** | `alfaro@email.com` | `password` |

---

## 🚀 Panduan Menjalankan di XAMPP

1. **Jalankan Apache & MySQL** pada XAMPP Control Panel.
2. Pastikan database `detroit` sudah ada. Jika ingin mengimpor ulang database:
   ```bash
   mysql -u root detroit < database/detroit.sql
   ```
3. Akses melalui web browser:
   - **Landing Page:** [http://localhost/Detroit/public](http://localhost/Detroit/public) atau [http://127.0.0.1:8000](http://127.0.0.1:8000) jika menggunakan `php artisan serve`.
   - **Form Pemesanan:** [http://localhost/Detroit/public/pesan](http://localhost/Detroit/public/pesan)
   - **Contoh Undangan Digital:** [http://localhost/Detroit/public/invitation/andika-salsabila](http://localhost/Detroit/public/invitation/andika-salsabila) atau [http://localhost/Detroit/public/invitation/abc123](http://localhost/Detroit/public/invitation/abc123)
   - **Admin Login:** [http://localhost/Detroit/public/login](http://localhost/Detroit/public/login)
   - **Admin Dashboard:** [http://localhost/Detroit/public/admin](http://localhost/Detroit/public/admin)
