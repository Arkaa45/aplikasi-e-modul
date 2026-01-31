# Dokumen Pengujian Blackbox Testing
## Aplikasi E-Modul Praktikum

---

## 1. Pendahuluan

### 1.1 Tujuan Pengujian
Dokumen ini berisi skenario pengujian **blackbox testing** untuk aplikasi E-Modul Praktikum. Pengujian dilakukan untuk memastikan bahwa setiap fungsi aplikasi berjalan sesuai dengan kebutuhan yang diharapkan tanpa melihat struktur kode internal.

### 1.2 Ruang Lingkup
Pengujian mencakup seluruh fitur utama aplikasi yang diakses oleh tiga role pengguna:
- **Admin (Kepala Lab)**
- **Laboran (Asisten Dosen)**  
- **Mahasiswa**

### 1.3 Metode Pengujian
Metode yang digunakan adalah **Equivalence Partitioning** dan **Boundary Value Analysis** untuk memvalidasi input data, serta **Functional Testing** untuk memverifikasi alur kerja aplikasi.

---

## 2. Kelas Uji

| Kode Kelas | Nama Kelas Uji | Deskripsi |
|------------|---------------|-----------|
| KU-01 | Autentikasi Pengguna | Pengujian login dan logout sistem |
| KU-02 | Manajemen User (Admin) | Pengujian CRUD data user |
| KU-03 | Import User CSV | Pengujian import user secara massal |
| KU-04 | Manajemen Mata Praktikum | Pengujian pengelolaan mata praktikum |
| KU-05 | Penugasan Laboran | Pengujian assign laboran ke matkum |
| KU-06 | Pendaftaran Mahasiswa | Pengujian assign mahasiswa ke matkum |
| KU-07 | Upload Konten (Laboran) | Pengujian upload RPS, referensi, modul |
| KU-08 | Manajemen Modul | Pengujian edit, hapus, toggle visibilitas |
| KU-09 | Akses Konten (Mahasiswa) | Pengujian akses dan download materi |
| KU-10 | Activity Log | Pengujian log aktivitas sistem |

---

## 3. Skenario Pengujian

### 3.1 Kelas Uji: Autentikasi Pengguna (KU-01)

#### Tabel Pengujian Login

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 1 | TC-01-001 | Login dengan kredensial valid (Admin) | Email: admin@test.com, Password: admin123 | Berhasil login, diarahkan ke dashboard admin | | ☐ |
| 2 | TC-01-002 | Login dengan kredensial valid (Laboran) | Email: laboran@test.com, Password: laboran123 | Berhasil login, diarahkan ke dashboard laboran | | ☐ |
| 3 | TC-01-003 | Login dengan kredensial valid (Mahasiswa) | Email: mahasiswa@test.com, Password: 12345678 | Berhasil login, diarahkan ke dashboard mahasiswa | | ☐ |
| 4 | TC-01-004 | Login dengan email kosong | Email: (kosong), Password: password123 | Tampil pesan error "Email dan password wajib diisi" | | ☐ |
| 5 | TC-01-005 | Login dengan password kosong | Email: user@test.com, Password: (kosong) | Tampil pesan error "Email dan password wajib diisi" | | ☐ |
| 6 | TC-01-006 | Login dengan email tidak terdaftar | Email: tidakada@test.com, Password: password | Tampil pesan error "Email atau password salah" | | ☐ |
| 7 | TC-01-007 | Login dengan password salah | Email: admin@test.com, Password: salah | Tampil pesan error "Email atau password salah" | | ☐ |
| 8 | TC-01-008 | Login dengan akun tidak aktif | Email: nonaktif@test.com (status inactive) | Tampil pesan error "akun tidak aktif" | | ☐ |
| 9 | TC-01-009 | Login dengan format email tidak valid | Email: emailsalah, Password: password | Tampil pesan error validasi email | | ☐ |

#### Tabel Pengujian Logout

| No | Kode Pengujian | Skenario | Kondisi Awal | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|--------------|----------------------|-----------------|--------|
| 10 | TC-01-010 | Logout dari sistem | User telah login | Session dihapus, diarahkan ke halaman login | | ☐ |
| 11 | TC-01-011 | Akses halaman setelah logout | User telah logout | Diarahkan ke halaman login | | ☐ |

---

### 3.2 Kelas Uji: Manajemen User - Admin (KU-02)

#### Tabel Pengujian Tambah User

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 1 | TC-02-001 | Tambah user dengan data lengkap | Nama: Test User, Email: test@email.com, Password: password123, Role: mahasiswa, NIM: 1234567890, Prodi: Teknik Informatika, Angkatan: 2024 | User berhasil ditambahkan | | ☐ |
| 2 | TC-02-002 | Tambah user dengan email yang sudah ada | Email: existing@email.com (sudah terdaftar) | Tampil pesan error email sudah digunakan | | ☐ |
| 3 | TC-02-003 | Tambah user dengan NIM/NIP yang sudah ada | NIM: 1234567890 (sudah terdaftar) | Tampil pesan error NIM/NIP sudah digunakan | | ☐ |
| 4 | TC-02-004 | Tambah user dengan field wajib kosong | Nama: (kosong) | Tampil pesan validasi field wajib | | ☐ |
| 5 | TC-02-005 | Tambah user role admin | Role: admin, data lengkap | User admin berhasil ditambahkan | | ☐ |
| 6 | TC-02-006 | Tambah user role laboran | Role: laboran, data lengkap | User laboran berhasil ditambahkan | | ☐ |

#### Tabel Pengujian Edit User

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 7 | TC-02-007 | Edit nama user | Nama baru: Updated Name | Data user berhasil diperbarui | | ☐ |
| 8 | TC-02-008 | Edit email ke email yang sudah ada | Email: existing@email.com | Tampil pesan error email sudah digunakan | | ☐ |
| 9 | TC-02-009 | Edit password user | Password baru: newpassword | Password berhasil diperbarui (terenkripsi) | | ☐ |
| 10 | TC-02-010 | Edit role user | Role: laboran → admin | Role user berhasil diubah | | ☐ |

#### Tabel Pengujian Hapus dan Toggle Status User

| No | Kode Pengujian | Skenario | Kondisi Awal | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|--------------|----------------------|-----------------|--------|
| 11 | TC-02-011 | Hapus user yang tidak memiliki relasi | User tanpa assignment | User berhasil dihapus | | ☐ |
| 12 | TC-02-012 | Toggle status user aktif → nonaktif | Status: aktif | Status berubah menjadi nonaktif | | ☐ |
| 13 | TC-02-013 | Toggle status user nonaktif → aktif | Status: nonaktif | Status berubah menjadi aktif | | ☐ |
| 14 | TC-02-014 | Filter user berdasarkan role | Role: mahasiswa | Hanya menampilkan user mahasiswa | | ☐ |

---

### 3.3 Kelas Uji: Import User CSV (KU-03)

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 1 | TC-03-001 | Import CSV dengan format valid | File CSV dengan kolom: nama, email, nim_nip, prodi, angkatan | Semua user berhasil diimport | | ☐ |
| 2 | TC-03-002 | Import CSV dengan email duplikat | File berbeda namun email sama dengan user existing | Tampil error untuk baris dengan email duplikat | | ☐ |
| 3 | TC-03-003 | Import CSV dengan NIM duplikat | File dengan NIM yang sudah terdaftar | Tampil error untuk baris dengan NIM duplikat | | ☐ |
| 4 | TC-03-004 | Import CSV dengan kolom tidak lengkap | File tanpa kolom 'email' | Tampil pesan error format tidak valid | | ☐ |
| 5 | TC-03-005 | Import file bukan CSV | File .xlsx atau .txt | Tampil pesan error tipe file tidak valid | | ☐ |
| 6 | TC-03-006 | Import CSV kosong | File CSV tanpa data | Tampil pesan tidak ada data untuk diimport | | ☐ |
| 7 | TC-03-007 | Download template CSV | Klik tombol download template | File template CSV berhasil diunduh | | ☐ |
| 8 | TC-03-008 | Import CSV sebagian gagal | File dengan beberapa baris valid, beberapa invalid | Baris valid di-import, baris invalid ditolak dengan pesan | | ☐ |

---

### 3.4 Kelas Uji: Manajemen Mata Praktikum (KU-04)

#### Tabel Pengujian Tambah Mata Praktikum

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 1 | TC-04-001 | Tambah matkum dengan data lengkap | Kode: TI101, Nama: Praktikum Basis Data, SKS: 1, Deskripsi: Deskripsi praktikum | Mata praktikum berhasil ditambahkan | | ☐ |
| 2 | TC-04-002 | Tambah matkum dengan kode yang sudah ada | Kode: TI101 (sudah ada) | Tampil pesan error kode sudah digunakan | | ☐ |
| 3 | TC-04-003 | Tambah matkum dengan field wajib kosong | Nama: (kosong) | Tampil pesan validasi field wajib | | ☐ |
| 4 | TC-04-004 | Tambah matkum dengan SKS negatif | SKS: -1 | Tampil pesan validasi SKS harus positif | | ☐ |

#### Tabel Pengujian Edit dan Hapus Mata Praktikum

| No | Kode Pengujian | Skenario | Kondisi/Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|------------------|----------------------|-----------------|--------|
| 5 | TC-04-005 | Edit nama mata praktikum | Nama baru: Praktikum Database Lanjut | Data matkum berhasil diperbarui | | ☐ |
| 6 | TC-04-006 | Edit kode ke kode yang sudah ada | Kode: EXISTING | Tampil pesan error kode sudah digunakan | | ☐ |
| 7 | TC-04-007 | Hapus mata praktikum tanpa konten | Matkum tanpa modul/RPS | Matkum berhasil dihapus | | ☐ |
| 8 | TC-04-008 | Lihat detail mata praktikum | ID matkum valid | Menampilkan detail RPS, referensi, modul | | ☐ |

---

### 3.5 Kelas Uji: Penugasan Laboran (KU-05)

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 1 | TC-05-001 | Assign laboran ke mata praktikum | Laboran: user_1, Matkum: TI101 | Laboran berhasil ditugaskan | | ☐ |
| 2 | TC-05-002 | Assign laboran yang sudah ditugaskan | Laboran sudah ada di matkum | Tampil pesan laboran sudah ditugaskan | | ☐ |
| 3 | TC-05-003 | Remove laboran dari mata praktikum | Laboran yang sudah ditugaskan | Laboran berhasil dihapus dari penugasan | | ☐ |
| 4 | TC-05-004 | Laboran melihat matkum yang ditugaskan | Login sebagai laboran | Hanya matkum yang ditugaskan yang muncul | | ☐ |
| 5 | TC-05-005 | Laboran akses matkum yang tidak ditugaskan | Akses URL matkum lain | Diredirect dengan pesan error akses | | ☐ |

---

### 3.6 Kelas Uji: Pendaftaran Mahasiswa (KU-06)

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 1 | TC-06-001 | Assign mahasiswa ke mata praktikum | Mahasiswa: student_1, Matkum: TI101 | Mahasiswa berhasil didaftarkan | | ☐ |
| 2 | TC-06-002 | Assign mahasiswa yang sudah terdaftar | Mahasiswa sudah ada di matkum | Tampil pesan mahasiswa sudah terdaftar | | ☐ |
| 3 | TC-06-003 | Remove mahasiswa dari mata praktikum | Mahasiswa yang sudah terdaftar | Mahasiswa berhasil dihapus dari pendaftaran | | ☐ |
| 4 | TC-06-004 | Filter mahasiswa by angkatan | Angkatan: 2024 | Hanya mahasiswa angkatan 2024 yang muncul | | ☐ |
| 5 | TC-06-005 | Search mahasiswa by nama/NIM | Kata kunci: "John" | Menampilkan mahasiswa dengan nama mengandung "John" | | ☐ |
| 6 | TC-06-006 | Mahasiswa melihat matkum terdaftar | Login sebagai mahasiswa | Hanya matkum yang terdaftar yang muncul | | ☐ |

---

### 3.7 Kelas Uji: Upload Konten - Laboran (KU-07)

#### Tabel Pengujian Upload RPS

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 1 | TC-07-001 | Upload RPS dengan file PDF valid | Judul: RPS Semester Ganjil, File: rps.pdf (≤2MB) | RPS berhasil diupload | | ☐ |
| 2 | TC-07-002 | Upload RPS dengan file bukan PDF | File: rps.docx | Tampil pesan error format file tidak valid | | ☐ |
| 3 | TC-07-003 | Upload RPS dengan file melebihi batas | File: rps.pdf (>10MB) | Tampil pesan error ukuran file terlalu besar | | ☐ |
| 4 | TC-07-004 | Upload RPS dengan judul kosong | Judul: (kosong) | Tampil pesan validasi judul wajib diisi | | ☐ |

#### Tabel Pengujian Upload Referensi

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 5 | TC-07-005 | Upload referensi tipe file | Tipe: file, File: referensi.pdf, Judul: Panduan Lab | Referensi file berhasil diupload | | ☐ |
| 6 | TC-07-006 | Upload referensi tipe link | Tipe: link, URL: https://example.com, Judul: Tutorial Online | Referensi link berhasil disimpan | | ☐ |
| 7 | TC-07-007 | Upload referensi link dengan URL tidak valid | URL: bukan-url-valid | Tampil pesan error format URL tidak valid | | ☐ |
| 8 | TC-07-008 | Upload referensi tanpa judul | Judul: (kosong) | Tampil pesan validasi judul wajib | | ☐ |

#### Tabel Pengujian Upload Modul

| No | Kode Pengujian | Skenario | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|----------|----------------------|-----------------|--------|
| 9 | TC-07-009 | Upload modul PDF ke slot kosong | Slot: 1, Tipe: PDF, File: modul1.pdf | Modul berhasil diupload | | ☐ |
| 10 | TC-07-010 | Upload modul video | Slot: 2, Tipe: Video, File: tutorial.mp4 | Modul video berhasil diupload | | ☐ |
| 11 | TC-07-011 | Upload modul tipe link | Slot: 3, Tipe: Link, URL: https://youtube.com/... | Modul link berhasil disimpan | | ☐ |
| 12 | TC-07-012 | Upload modul ke slot yang sudah terisi | Slot: 1 (sudah ada modul) | Tampil konfirmasi untuk replace modul | | ☐ |
| 13 | TC-07-013 | Upload modul dengan slot invalid | Slot: 17 (melebihi 16) | Tampil pesan error slot tidak valid | | ☐ |
| 14 | TC-07-014 | Upload modul dengan visibilitas hidden | Visible: false | Modul diupload dengan status hidden | | ☐ |

---

### 3.8 Kelas Uji: Manajemen Modul (KU-08)

| No | Kode Pengujian | Skenario | Kondisi/Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|------------------|----------------------|-----------------|--------|
| 1 | TC-08-001 | Edit judul modul | Judul baru: Modul 1 - Updated | Judul modul berhasil diperbarui | | ☐ |
| 2 | TC-08-002 | Edit deskripsi modul | Deskripsi baru: Deskripsi lengkap | Deskripsi berhasil diperbarui | | ☐ |
| 3 | TC-08-003 | Ganti file modul | File baru: modul_baru.pdf | File modul berhasil diganti | | ☐ |
| 4 | TC-08-004 | Toggle visibilitas hidden → visible | Status: hidden | Modul menjadi visible untuk mahasiswa | | ☐ |
| 5 | TC-08-005 | Toggle visibilitas visible → hidden | Status: visible | Modul tidak terlihat oleh mahasiswa | | ☐ |
| 6 | TC-08-006 | Hapus modul | Modul existing | Modul dan file berhasil dihapus | | ☐ |
| 7 | TC-08-007 | Hapus RPS | RPS existing | RPS dan file berhasil dihapus | | ☐ |
| 8 | TC-08-008 | Hapus referensi | Referensi existing | Referensi berhasil dihapus | | ☐ |

---

### 3.9 Kelas Uji: Akses Konten - Mahasiswa (KU-09)

| No | Kode Pengujian | Skenario | Kondisi Awal | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|--------------|----------------------|-----------------|--------|
| 1 | TC-09-001 | Lihat daftar mata praktikum terdaftar | Mahasiswa terdaftar di 3 matkum | Menampilkan 3 mata praktikum | | ☐ |
| 2 | TC-09-002 | Akses detail mata praktikum terdaftar | Mahasiswa terdaftar di matkum | Menampilkan halaman detail dengan konten | | ☐ |
| 3 | TC-09-003 | Akses mata praktikum tidak terdaftar | Mahasiswa tidak terdaftar | Redirect dengan pesan error akses | | ☐ |
| 4 | TC-09-004 | Lihat RPS inline (PDF viewer) | RPS tersedia | PDF ditampilkan di browser | | ☐ |
| 5 | TC-09-005 | Download RPS | RPS tersedia | File RPS berhasil diunduh | | ☐ |
| 6 | TC-09-006 | Lihat modul visible | Modul dengan status visible | Modul ditampilkan dalam daftar | | ☐ |
| 7 | TC-09-007 | Lihat modul hidden | Modul dengan status hidden | Modul tidak muncul dalam daftar | | ☐ |
| 8 | TC-09-008 | View modul PDF inline | Modul tipe PDF | PDF ditampilkan di browser | | ☐ |
| 9 | TC-09-009 | Download modul file | Modul tipe PDF/Video | File berhasil diunduh, counter bertambah | | ☐ |
| 10 | TC-09-010 | Akses modul tipe link | Modul tipe link | Redirect ke URL eksternal | | ☐ |
| 11 | TC-09-011 | Akses referensi file | Referensi tipe file | File berhasil diunduh | | ☐ |
| 12 | TC-09-012 | Akses referensi link | Referensi tipe link | Redirect ke URL eksternal | | ☐ |
| 13 | TC-09-013 | Download file yang tidak ada | File sudah dihapus dari server | Tampil pesan error "File tidak ditemukan" | | ☐ |

---

### 3.10 Kelas Uji: Activity Log (KU-10)

| No | Kode Pengujian | Skenario | Kondisi Awal | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|----------------|----------|--------------|----------------------|-----------------|--------|
| 1 | TC-10-001 | Lihat activity log | Admin login | Menampilkan daftar log aktivitas | | ☐ |
| 2 | TC-10-002 | Log tercatat saat login | User melakukan login | Log login tercatat dengan IP dan user agent | | ☐ |
| 3 | TC-10-003 | Log tercatat saat logout | User melakukan logout | Log logout tercatat dengan waktu | | ☐ |
| 4 | TC-10-004 | Log tercatat saat upload konten | Laboran upload modul | Log aktivitas upload tercatat | | ☐ |
| 5 | TC-10-005 | Filter log berdasarkan user | Pilih user tertentu | Menampilkan log hanya dari user tersebut | | ☐ |
| 6 | TC-10-006 | Filter log berdasarkan tanggal | Rentang tanggal tertentu | Menampilkan log dalam rentang tersebut | | ☐ |

---

## 4. Ringkasan Hasil Pengujian

### Tabel Rekapitulasi

| Kode Kelas | Nama Kelas Uji | Jumlah Test Case | Berhasil | Gagal | Tidak Diuji |
|------------|---------------|------------------|----------|-------|-------------|
| KU-01 | Autentikasi Pengguna | 11 | | | |
| KU-02 | Manajemen User (Admin) | 14 | | | |
| KU-03 | Import User CSV | 8 | | | |
| KU-04 | Manajemen Mata Praktikum | 8 | | | |
| KU-05 | Penugasan Laboran | 5 | | | |
| KU-06 | Pendaftaran Mahasiswa | 6 | | | |
| KU-07 | Upload Konten (Laboran) | 14 | | | |
| KU-08 | Manajemen Modul | 8 | | | |
| KU-09 | Akses Konten (Mahasiswa) | 13 | | | |
| KU-10 | Activity Log | 6 | | | |
| **TOTAL** | | **93** | | | |

### Persentase Keberhasilan

```
Persentase Keberhasilan = (Jumlah Berhasil / Total Test Case) × 100%
                        = (____ / 93) × 100%
                        = ____%
```

---

## 5. Kesimpulan

Berdasarkan hasil pengujian blackbox testing yang telah dilakukan pada aplikasi E-Modul Praktikum, dapat disimpulkan bahwa:

1. **Fitur Autentikasi**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]
2. **Fitur Manajemen User**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]
3. **Fitur Import CSV**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]
4. **Fitur Manajemen Mata Praktikum**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]
5. **Fitur Penugasan**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]
6. **Fitur Upload Konten**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]
7. **Fitur Akses Mahasiswa**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]
8. **Fitur Activity Log**: [Berhasil/Perlu Perbaikan] - [Deskripsi hasil]

### Catatan Temuan

| No | Kode Test Case | Temuan | Severity | Status |
|----|---------------|--------|----------|--------|
| 1 | | | | |
| 2 | | | | |
| 3 | | | | |

---

## 6. Lampiran

### 6.1 Environment Pengujian

| Komponen | Spesifikasi |
|----------|-------------|
| Sistem Operasi | |
| Browser | |
| Server | XAMPP (Apache + MySQL) |
| PHP Version | 7.x / 8.x |
| Database | MySQL |
| Framework | CodeIgniter 3 |

### 6.2 Data Pengujian

#### Sample User Testing

| Role | Email | Password | Status |
|------|-------|----------|--------|
| Admin | admin@test.com | admin123 | Aktif |
| Laboran | laboran@test.com | laboran123 | Aktif |
| Mahasiswa | mahasiswa@test.com | 12345678 | Aktif |
| Mahasiswa Nonaktif | nonaktif@test.com | password | Nonaktif |

#### Sample Mata Praktikum

| Kode | Nama | SKS |
|------|------|-----|
| TI101 | Praktikum Basis Data | 1 |
| TI102 | Praktikum Pemrograman Web | 1 |

---

**Dokumen dibuat oleh:** ________________

**Tanggal pengujian:** ________________

**Versi Aplikasi:** E-Modul Praktikum v1.0
