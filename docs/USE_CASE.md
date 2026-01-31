# Use Case E-Modul Praktikum

## Ringkasan Aplikasi

E-Modul Praktikum adalah sistem manajemen modul pembelajaran praktikum yang memungkinkan pengelolaan konten pembelajaran seperti RPS, referensi, dan modul per pertemuan. Sistem ini memiliki tiga role utama: **Admin**, **Laboran**, dan **Mahasiswa**.

---

## Daftar Aktor

| No | Aktor | Deskripsi |
|----|-------|-----------|
| 1 | **Admin** | Pengelola utama sistem, mengelola user, mata praktikum, dan penugasan |
| 2 | **Laboran** | Pengelola konten mata praktikum, mengupload modul, RPS, dan referensi |
| 3 | **Mahasiswa** | Pengguna akhir yang mengakses dan mengunduh konten pembelajaran |

---

## Use Case Detail per Role

### 1. Role: Admin

#### UC-A01: Login
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin melakukan autentikasi untuk masuk ke sistem |
| **Precondition** | Admin memiliki akun aktif |
| **Flow** | 1. Admin membuka halaman login<br>2. Admin memasukkan email dan password<br>3. Sistem memvalidasi kredensial<br>4. Sistem mengarahkan ke dashboard admin |
| **Postcondition** | Admin berhasil login dan session aktif |


#### UC-A02: Kelola User
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola data pengguna sistem |
| **Operasi** | Create, Read, Update, Delete, Toggle Status |
| **Field Data** | Nama, email, password, role, NIM/NIP, prodi, angkatan, status aktif |
| **Filter** | Filter berdasarkan role (admin/laboran/mahasiswa) |

#### UC-A03: Import User CSV
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengimpor data mahasiswa secara massal dari file CSV |
| **Format CSV** | nama, email, nim_nip, prodi, angkatan |
| **Validasi** | Email unik, NIM/NIP unik, format email valid |
| **Default** | Password = NIM/NIP, Role = mahasiswa |

#### UC-A04: Kelola Mata Praktikum
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola data mata praktikum |
| **Operasi** | Create, Read, Update, Delete |
| **Field Data** | Kode matkum, nama matkum, SKS, deskripsi, status aktif |

#### UC-A05: Assign Laboran ke Mata Praktikum
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin menugaskan laboran untuk mengelola mata praktikum tertentu |
| **Operasi** | Assign, Remove |
| **Catatan** | Satu laboran dapat ditugaskan ke banyak mata praktikum |

#### UC-A07: Assign Mahasiswa ke Mata Praktikum
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mendaftarkan mahasiswa ke mata praktikum tertentu |
| **Operasi** | Assign, Remove |
| **Fitur** | Filter angkatan, search nama/NIM, filter status |

#### UC-A08: Upload Konten
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengupload konten pembelajaran |
| **Tipe Konten** | RPS (PDF), Referensi (file/link), Modul (PDF/video/link) |
| **Slot Modul** | 16 slot per mata praktikum |

#### UC-A09: Hapus Konten
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin menghapus konten pembelajaran yang sudah diupload |
| **Tipe Konten** | RPS, Referensi, Modul |

#### UC-A10: Lihat Activity Log
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Admin |
| **Deskripsi** | Admin melihat log aktivitas seluruh pengguna sistem |
| **Data Log** | User, action, deskripsi, IP address, waktu |

---

### 2. Role: Laboran

#### UC-L01: Login
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran melakukan autentikasi untuk masuk ke sistem |
| **Precondition** | Laboran memiliki akun aktif |


#### UC-L03: Lihat Detail Mata Praktikum
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran melihat detail mata praktikum termasuk RPS, referensi, dan modul |
| **Akses** | Hanya mata praktikum yang ditugaskan |

#### UC-L04: Upload RPS
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran mengupload file RPS (Rencana Pembelajaran Semester) |
| **Format** | PDF |
| **Field** | Judul, file |

#### UC-L05: Upload Referensi
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran menambahkan referensi tambahan |
| **Tipe** | File (PDF, DOC, dll) atau Link eksternal |
| **Field** | Judul, deskripsi, tipe, file/link |

#### UC-L06: Upload Modul
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran mengupload modul per slot/pertemuan |
| **Slot** | 1-16 per mata praktikum |
| **Tipe** | PDF, Video, Link |
| **Field** | Slot, judul, deskripsi, tipe file, file/link, visibilitas |

#### UC-L07: Edit Modul
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran mengedit modul yang sudah diupload |
| **Operasi** | Update judul, deskripsi, file, visibilitas |

#### UC-L08: Hapus Konten
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran menghapus konten yang sudah diupload |
| **Tipe** | RPS, Referensi, Modul |

#### UC-L09: Toggle Visibilitas Modul
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Laboran |
| **Deskripsi** | Laboran mengubah status visibilitas modul untuk mahasiswa |
| **Status** | Visible / Hidden |

---

### 3. Role: Mahasiswa

#### UC-M01: Login
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Mahasiswa |
| **Deskripsi** | Mahasiswa melakukan autentikasi untuk masuk ke sistem |
| **Precondition** | Mahasiswa memiliki akun aktif dan terdaftar di minimal 1 mata praktikum |


#### UC-M03: Lihat Detail Mata Praktikum
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Mahasiswa |
| **Deskripsi** | Mahasiswa melihat detail konten mata praktikum |
| **Akses** | Hanya mata praktikum yang terdaftar |
| **Konten** | RPS, Referensi, Modul (yang visible) |

#### UC-M04: Lihat RPS
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Mahasiswa |
| **Deskripsi** | Mahasiswa melihat file RPS secara inline atau download |
| **Format** | PDF viewer inline |

#### UC-M05: Lihat Modul
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Mahasiswa |
| **Deskripsi** | Mahasiswa melihat modul per slot/pertemuan |
| **Tipe Akses** | View inline (PDF), redirect (link), download (video) |
| **Counter** | Download count di-increment |

#### UC-M06: Lihat Referensi
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Mahasiswa |
| **Deskripsi** | Mahasiswa mengakses referensi tambahan |
| **Tipe** | Download file atau redirect ke link eksternal |

#### UC-M07: Download Konten
| Aspek | Deskripsi |
|-------|-----------|
| **Aktor** | Mahasiswa |
| **Deskripsi** | Mahasiswa mengunduh file konten pembelajaran |
| **Tipe File** | RPS, Referensi, Modul |

---

## Matriks CRUD per Role

### Tabel Users

| Role | Create | Read | Update | Delete |
|------|--------|------|--------|--------|
| Admin | ✅ | ✅ | ✅ | ✅ |
| Laboran | ❌ | ❌ | ❌ | ❌ |
| Mahasiswa | ❌ | ❌ | ❌ | ❌ |

### Tabel Mata Praktikum

| Role | Create | Read | Update | Delete |
|------|--------|------|--------|--------|
| Admin | ✅ | ✅ | ✅ | ✅ |
| Laboran | ❌ | ✅* | ❌ | ❌ |
| Mahasiswa | ❌ | ✅* | ❌ | ❌ |

> *Hanya yang ditugaskan/terdaftar

### Tabel Modul

| Role | Create | Read | Update | Delete |
|------|--------|------|--------|--------|
| Admin | ✅ | ✅ | ✅ | ✅ |
| Laboran | ✅* | ✅* | ✅* | ✅* |
| Mahasiswa | ❌ | ✅* | ❌ | ❌ |

> *Terbatas pada matkum yang ditugaskan/terdaftar

### Tabel RPS

| Role | Create | Read | Update | Delete |
|------|--------|------|--------|--------|
| Admin | ✅ | ✅ | ❌ | ✅ |
| Laboran | ✅* | ✅* | ❌ | ✅* |
| Mahasiswa | ❌ | ✅* | ❌ | ❌ |

### Tabel Referensi

| Role | Create | Read | Update | Delete |
|------|--------|------|--------|--------|
| Admin | ✅ | ✅ | ❌ | ✅ |
| Laboran | ✅* | ✅* | ❌ | ✅* |
| Mahasiswa | ❌ | ✅* | ❌ | ❌ |


