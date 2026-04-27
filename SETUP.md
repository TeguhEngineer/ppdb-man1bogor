# Panduan Instalasi Sistem PPDB MAN 1 BOGOR

Berikut adalah langkah-langkah untuk menyiapkan dan menjalankan aplikasi PPDB di komputer lokal (Windows).

## Kebutuhan Sistem (Prerequisites)

Pastikan Anda telah menginstal beberapa perangkat lunak berikut sebelum menjalankan aplikasi:

### 1. XAMPP (dengan PHP 8.2)
Aplikasi ini menggunakan framework Laravel 11 yang membutuhkan PHP versi 8.2 atau lebih tinggi.
- Jika Anda sudah memiliki XAMPP, pastikan versi PHP yang aktif adalah 8.2.x.
- Jika belum, Anda dapat mengunduh XAMPP terbaru di: [Apache Friends - Download XAMPP](https://www.apachefriends.org/download.html)

### 2. Composer
Composer adalah *dependency manager* untuk bahasa pemrograman PHP, digunakan untuk menginstal paket-paket yang dibutuhkan Laravel.
- **Link Download:** [Download Composer (Composer-Setup.exe)](https://getcomposer.org/Composer-Setup.exe)
- **Cara Install:** Jalankan file installer yang telah didownload. Pastikan path PHP mengarah ke direktori PHP di dalam XAMPP Anda (misal: `C:\xampp\php\php.exe`).

### 3. Node.js & NPM
Node.js dan NPM digunakan untuk mengelola dependensi frontend dan kompilasi aset (Tailwind CSS, Vite, dll).
- **Link Download:** [Download Node.js (Versi LTS disarankan)](https://nodejs.org/en/download/)
- **Cara Install:** Jalankan installer yang didownload dan ikuti petunjuk default hingga selesai.

---

## Langkah-langkah Instalasi Aplikasi

### Langkah 1: Siapkan Folder Proyek
1. Buka aplikasi **XAMPP Control Panel**, lalu jalankan modul **Apache** dan **MySQL**.
2. Pastikan folder proyek `ppdb` sudah berada di direktori yang Anda inginkan.
3. Buka **Terminal** atau **Command Prompt (CMD)**, arahkan ke dalam direktori proyek tersebut.
   ```bash
   cd path/ke/folder/ppdb
   ```

### Langkah 2: Buat Database
Karena _source code_ yang diberikan sudah lengkap (beserta folder `vendor` dan file `.env` yang sudah dikonfigurasi), Anda hanya perlu membuat database.
1. Buka [http://localhost/phpmyadmin](http://localhost/phpmyadmin) di browser Anda.
2. Buat database baru dengan nama: `ppdb`

### Langkah 3: Migrasi Database & Seeding
Agar tabel database beserta data awal (seperti Akun Admin dan Data Jalur) terbuat, jalankan perintah berikut di terminal:
```bash
php artisan migrate:fresh --seed
```
*Catatan: `--seed` akan memasukkan akun Admin default:*
- **Email:** `administrator@gmail.com`
- **Password:** `password`

### Langkah 4: Generate Storage Link
Aplikasi membutuhkan akses ke folder penyimpanan untuk mengelola file upload (seperti foto profil, berkas, dll). Jalankan perintah:
```bash
php artisan storage:link
```

---

## Menjalankan Aplikasi

Untuk menjalankan aplikasi ini secara penuh, Anda perlu menjalankan dua server lokal secara bersamaan. Buka **2 tab/jendela Terminal** di direktori proyek:

**Terminal 1 (Menjalankan Server PHP):**
```bash
php artisan serve
```
*Aplikasi bisa diakses di `http://127.0.0.1:8000` atau `http://localhost:8000`*

**Terminal 2 (Menjalankan Server Vite / Frontend Asset):**
```bash
npm run dev
```
*Vite akan melakukan hot-reload setiap ada perubahan pada file CSS/JS/Blade.*

---

## Penyelesaian Masalah (Troubleshooting)
- Jika gambar logo atau foto upload tidak muncul, pastikan Anda telah menjalankan `php artisan storage:link`.
- Jika tampilan CSS rusak/tidak rapi, pastikan `npm run dev` sedang berjalan atau jalankan `npm run build` untuk mengompilasi file secara permanen.
- Jika database error, pastikan MySQL di XAMPP berjalan dan nama database sudah dibuat di phpMyAdmin sesuai dengan isi file `.env`.
