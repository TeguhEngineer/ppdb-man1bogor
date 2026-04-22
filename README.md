# BUSINESS REQUIREMENTS DOCUMENT (BRD)

## Sistem Penerimaan Peserta Didik Baru (PPDB)

---

## 1. TUJUAN SISTEM

Sistem PPDB ini dibuat untuk:

* Mempermudah proses pendaftaran siswa baru secara online
* Mengintegrasikan seluruh jalur pendaftaran dalam satu platform
* Memudahkan peserta dalam mengakses informasi, mendaftar, dan melihat hasil seleksi

---

## 2. AKTOR SISTEM

### 2.1 Peserta (User)

* Melihat informasi PPDB
* Mendaftar akun
* Login
* Mengisi biodata
* Mengisi Data Raport
* Melihat status & pengumuman

### 2.2 Admin

* Verifikasi data
* Mengelola status seleksi
* Mengelola pengumuman

---

## 3. FITUR UTAMA SISTEM

### 3.1 Landing Page

* Beranda
* Informasi
* Alur Pendaftaran
* Pengumuman
* FAQ
* Kontak
* CTA Login & Daftar

### 3.2 Sistem Pendaftaran

* 1 halaman berisi:

  * Jalur Reguler
  * Jalur Prestasi
  * Jalur Afirmasi
* User hanya bisa memilih 1 jalur

### 3.3 Autentikasi

* Registrasi akun
* Login
* Logout

### 3.4 Dashboard Peserta

Menu:
* Dasbor
* Peserta
  ** Akun Saya
  ** Biodata
* Lihat Pesan
* Ubah Password
* Keluar

### 3.5 Informasi PPDB

* Jadwal:

  * Pendaftaran
  * Verifikasi biodata dan nilai raport
  * Tes & wawancara
  * Pengumuman
  * Daftar ulang
* Syarat umum:

  * Rapor/Ijazah
  * KK & Akta lahir
  * Foto 3x4
  * Surat pernyataan

### 3.6 Pengumuman

* Menampilkan hasil seleksi peserta

### 3.7 FAQ

* Cara daftar
* Ketentuan jalur
* Dokumen
* Jadwal pengumuman

### 3.8 Kontak

* Informasi kontak admin

---

## 4. ALUR BISNIS

Landing Page → Daftar → Login → Isi Biodata → Isi Nilai Raport → Verifikasi → Tes/Wawancara → Pengumuman → Daftar Ulang

---

## 5. DESAIN DATABASE

### 5.1 Tabel: users

id
name
email
password
role (default: peserta)
created_at
updated_at

### 5.2 Tabel: jalur_pendaftaran

id
nama_jalur (Reguler / Prestasi / Afirmasi)
deskripsi
created_at
updated_at

### 5.3 Tabel: pendaftaran

id
no_pendaftaran (Format: PPDB+YYYYMMDD+0001, contoh: PPDB202604220001)
nisn
user_id
jalur_id
kampus(defaut MAN 1 BOGOR)
status_pendaftaran (pending, verifikasi, tes, lulus, tidak_lulus)
created_at
updated_at

### 5.4 Tabel: biodata

id
<!-- Data Pendaftaran -->
pendaftaran_id
<!-- Data Pribadi -->
foto_profil(upload file png/jpg/jpeg max.1mb)
nama_lengkap
tempat_lahir
tanggal_lahir
jenis_kelamin
nik
no_kk
tinggi_badan
berat_badan
status_dalam_keluarga
tinggal_bersama
anak_ke
jumlah_saudara
agama
no_whatsapp
<!-- Data Alamat sesuai KK -->
alamat
desa
kecamatan
kabupaten
provinsi
kode_pos
jarak_ke_sekolah
waktu_tempuh_ke_sekolah
<!-- Data Pendidikan -->
asal_satuan_pendidikan(SMP/MTS)
nama_asal_sekolah
npsn
<!-- Data Penunjang Prestasi -->
kategori_prestasi
jumlah_juz
tingkat_prestasi
jenis_prestasi
nama_lomba
sertifikat(upload file jpg/jpeg/png/pdf max.2mb)
<!-- Data Slip Gaji -->
slip_gaji(upload file jpg/jpeg/png/pdf max.2mb)
<!-- Data Ayah -->
nama_ayah
nik_ayah
tempat_lahir_ayah
tanggal_lahir_ayah
pendidikan_terakhir_ayah
pekerjaan_ayah
penghasilan_ayah
no_hp_ayah
<!-- Data Ibu -->
nama_ibu
nik_ibu
tempat_lahir_ibu
tanggal_lahir_ibu
pendidikan_terakhir_ibu
pekerjaan_ibu
penghasilan_ibu
no_hp_ibu
kartu_keluarga(upload file)
<!-- Data Wali -->
nama_wali
nik_wali
tempat_lahir_wali
tanggal_lahir_wali
pendidikan_terakhir_wali
pekerjaan_wali
penghasilan_wali
no_hp_wali
created_at
updated_at

### 5.5 Tabel: raport

id
pendaftaran_id
file_rapor_ijazah
file_kk
file_akta_lahir
file_foto
file_surat_pernyataan
created_at
updated_at

### 5.6 Tabel: jadwal

id
jalur_id
tanggal_pendaftaran
tanggal_verifikasi
tanggal_tes
tanggal_pengumuman
tanggal_daftar_ulang
created_at
updated_at

### 5.7 Tabel: pengumuman

id
pendaftaran_id
judul
keterangan
status (lulus / tidak_lulus)
created_at
updated_at

### 5.8 Tabel: faq

id
pertanyaan
jawaban
created_at
updated_at

### 5.9 Tabel: kontak

id
nama_kontak
email
no_hp
alamat
created_at
updated_at

### 5.10 Tabel: pesan

id
pendaftaran_id
judul
isi_pesan
status_baca (0/1)
created_at
updated_at

---

## 6. RULES SISTEM

* 1 user hanya bisa memilih 1 jalur
* Status pendaftaran: pending, verifikasi, tes, lulus, tidak_lulus
* Sistem menyediakan notifikasi/pesan ke peserta

---

## 7. CATATAN UI/UX

* Semua jalur dalam 1 halaman
* CTA harus menonjol
* Alur ditampilkan dalam bentuk teks (bukan gambar)
* Desain bebas, flow tetap sama

---

## 8. KESIMPULAN

Sistem PPDB berbasis web dengan konsep single landing page yang terintegrasi, memudahkan user dalam proses pendaftaran hingga pengumuman hasil seleksi.
