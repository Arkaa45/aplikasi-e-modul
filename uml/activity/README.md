# Dokumentasi Diagram Aktivitas (Activity Diagram)

Dokumen ini berisi penjelasan dari setiap diagram aktivitas yang menggambarkan alur proses dalam sistem E-Modul Praktikum. Diagram aktivitas digunakan untuk memvisualisasikan alur kerja (workflow) dari setiap fitur utama sistem, menunjukkan interaksi antara pengguna, sistem, dan database.

---

## 1. Login (`login.png`)

**Aktor:** Admin, Laboran, Mahasiswa

Diagram ini menggambarkan alur autentikasi pengguna ke dalam sistem E-Modul Praktikum. Proses dimulai ketika pengguna mengakses halaman login melalui browser dan mengisi form dengan email serta password. Setelah pengguna mengklik tombol login, sistem akan melakukan serangkaian validasi secara bertahap.

Pertama, sistem memvalidasi apakah semua field sudah terisi dengan benar dan tidak ada yang kosong. Jika ada field yang kosong, sistem akan menampilkan pesan error dan meminta pengguna mengisi ulang. Kedua, sistem akan melakukan query ke database untuk mencari user berdasarkan email yang diinputkan. Jika email tidak ditemukan atau password tidak cocok setelah proses verifikasi hash bcrypt, sistem akan menampilkan pesan "Kredensial salah".

Ketiga, jika kredensial valid, sistem akan memeriksa status keaktifan akun melalui field is_active. Akun yang dinonaktifkan oleh admin tidak dapat login meskipun email dan password benar. Jika semua validasi berhasil, sistem akan membuat session berisi informasi user (id, nama, email, role) dan mencatat aktivitas login ke tabel activity_log lengkap dengan IP address dan user agent browser.

Terakhir, pengguna akan di-redirect ke dashboard yang sesuai dengan role-nya: admin menuju halaman admin, laboran menuju halaman laboran, dan mahasiswa menuju halaman mahasiswa. Setiap role memiliki menu dan akses fitur yang berbeda sesuai dengan kewenangannya.

---

## 2. Kelola Log Aktivitas (`log.png`)

**Aktor:** Admin

Diagram ini menggambarkan proses admin dalam memantau dan mengaudit aktivitas seluruh pengguna sistem melalui fitur Activity Log. Fitur ini penting untuk keperluan keamanan, pelacakan masalah, dan monitoring penggunaan sistem secara keseluruhan.
Ketika admin mengakses menu Activity Log dari sidebar, sistem akan mengirimkan request ke database untuk mengambil data log aktivitas. Query akan melakukan join antara tabel activity_log dengan tabel users untuk mendapatkan informasi lengkap termasuk nama pengguna, role, jenis aksi yang dilakukan, deskripsi aktivitas, IP address, browser yang digunakan, dan waktu kejadian. Data kemudian ditampilkan dalam bentuk tabel dengan urutan terbaru di atas (descending by created_at).
Admin dapat menggunakan fitur filter untuk mempersempit hasil pencarian. Filter yang tersedia meliputi filter berdasarkan tanggal (range tanggal tertentu), filter berdasarkan jenis aksi (login, logout, upload_modul, delete_user, dll), dan filter berdasarkan pengguna tertentu. Ketika filter diterapkan, sistem akan melakukan query ulang dengan kondisi WHERE yang sesuai dan menampilkan hasil yang sudah difilter.
Melalui Activity Log, admin dapat mendeteksi aktivitas mencurigakan seperti percobaan login berulang yang gagal, penghapusan data yang tidak wajar, atau akses dari IP address yang tidak dikenal. Fitur ini juga berguna untuk memverifikasi siapa yang melakukan perubahan tertentu pada sistem.

---

## 3. Kelola Mata Praktikum (`matkum.png`)

**Aktor:** Admin

Diagram ini menggambarkan proses lengkap pengelolaan mata praktikum (Create, Read, Update, Delete) oleh admin. Mata praktikum adalah entitas utama dalam sistem yang menjadi wadah untuk modul, RPS, dan referensi pembelajaran.

Alur dimulai ketika admin mengakses menu Mata Praktikum dari sidebar. Sistem akan mengambil daftar semua mata praktikum dari database beserta informasi jumlah laboran yang ditugaskan untuk setiap mata praktikum. Data ditampilkan dalam bentuk card atau tabel yang menunjukkan kode, nama, SKS, dan status aktif masing-masing mata praktikum.

Untuk **menambah mata praktikum baru**, admin mengklik tombol "Tambah" dan mengisi form yang berisi kode mata praktikum (harus unik), nama mata praktikum, jumlah SKS, deskripsi (opsional), dan status aktif. Setelah submit, sistem melakukan validasi untuk memastikan kode tidak duplikat, lalu menyimpan data ke tabel mata_kuliah dan menampilkan notifikasi sukses.

Untuk **mengedit mata praktikum**, admin mengklik tombol Edit pada mata praktikum yang dipilih. Form akan terisi otomatis dengan data existing. Admin dapat mengubah field yang diinginkan lalu menyimpan. Sistem akan melakukan UPDATE pada record yang bersangkutan.

Untuk **menghapus mata praktikum**, admin mengklik tombol Hapus dan harus mengkonfirmasi penghapusan. Sistem akan menghapus mata praktikum beserta seluruh data terkait secara cascade, termasuk semua modul, RPS, referensi, penugasan laboran, dan pendaftaran mahasiswa yang terhubung dengan mata praktikum tersebut. Oleh karena itu, penghapusan harus dilakukan dengan hati-hati.

---

## 4. Kelola User (`user2.png`)

**Aktor:** Admin

Diagram ini menggambarkan proses pengelolaan pengguna sistem secara lengkap oleh admin, termasuk fitur CRUD standar dan fitur import massal melalui CSV yang berguna untuk mendaftarkan banyak mahasiswa sekaligus.
Ketika admin mengakses menu Kelola User, sistem menampilkan daftar seluruh user dalam bentuk tabel dengan kolom nama, email, role, NIM/NIP, prodi, angkatan, dan status aktif. Admin dapat memfilter tampilan berdasarkan role (admin, laboran, mahasiswa) untuk memudahkan pengelolaan.
Untuk menambah user baru secara manual, admin mengklik tombol "Tambah User" dan mengisi form lengkap meliputi nama, email (harus unik), password, role, NIM/NIP (harus unik), program studi, angkatan, dan status aktif. Sistem akan memvalidasi bahwa email dan NIM/NIP tidak duplikat, meng-hash password menggunakan bcrypt, lalu menyimpan data ke database.
Untuk mengedit user, admin memilih user dari daftar dan mengklik tombol Edit. Semua field dapat diubah kecuali email. Password hanya diubah jika admin mengisi field password baru; jika dikosongkan, password lama tetap berlaku.
Untuk menghapus user, admin mengklik tombol Hapus dan mengkonfirmasi. User akan dihapus permanen dari sistem beserta semua activity log yang terkait.
Fitur mport CSV sangat berguna untuk mendaftarkan mahasiswa baru dalam jumlah besar. Admin mengupload file CSV dengan format kolom: nama, email, nim_nip, prodi, angkatan. Sistem akan mem-parsing file, memvalidasi setiap baris (cek duplikasi email dan NIM, validasi format email), menggunakan NIM sebagai password default, meng-hash password, dan menyimpan secara batch. Setelah proses selesai, sistem menampilkan laporan hasil import yang menunjukkan jumlah user berhasil ditambahkan dan detail error untuk baris yang gagal.

---

## 5. Assign Mahasiswa (`assgin_mhs.png`)

**Aktor:** Admin

Diagram ini menggambarkan proses pendaftaran mahasiswa ke mata praktikum tertentu. Mahasiswa hanya dapat mengakses konten dari mata praktikum yang sudah didaftarkan oleh admin, sehingga proses ini menentukan hak akses mahasiswa.

Alur dimulai ketika admin membuka halaman detail mata praktikum dan mengklik tombol "Assign Mahasiswa". Sistem akan mengambil dua set data dari database: daftar semua mahasiswa aktif dari tabel users (WHERE role = 'mahasiswa' AND is_active = 1) dan daftar mahasiswa yang sudah terdaftar di mata praktikum tersebut dari tabel mahasiswa_matkum.

Halaman menampilkan dua section: bagian atas menunjukkan mahasiswa yang sudah terdaftar dengan opsi untuk menghapus pendaftaran, dan bagian bawah menunjukkan mahasiswa yang belum terdaftar dengan opsi untuk menambahkan. Admin dapat menggunakan filter angkatan untuk mempersempit daftar mahasiswa, yang sangat berguna ketika jumlah mahasiswa sangat banyak.

Untuk **mendaftarkan mahasiswa**, admin cukup mengklik tombol "Tambah" pada baris mahasiswa yang dipilih. Sistem akan menyimpan relasi baru ke tabel mahasiswa_matkum (id_user, id_matkul) dan me-refresh tampilan. Mahasiswa yang baru didaftarkan akan langsung dapat mengakses mata praktikum tersebut dari dashboard mereka.

Untuk **menghapus pendaftaran**, admin mengklik tombol "Hapus" pada mahasiswa yang terdaftar. Sistem akan menghapus relasi dari tabel mahasiswa_matkum. Mahasiswa yang dihapus tidak akan lagi melihat mata praktikum tersebut di dashboard dan tidak dapat mengakses kontennya.

---

## 6. Assign Laboran (`assign_lab.png`)

**Aktor:** Admin

Diagram ini menggambarkan proses penugasan laboran untuk mengelola mata praktikum tertentu. Laboran yang ditugaskan akan bertanggung jawab untuk mengupload dan mengelola konten pembelajaran (modul, RPS, referensi) pada mata praktikum yang menjadi tugasnya.

Prosesnya mirip dengan assign mahasiswa namun lebih sederhana karena jumlah laboran biasanya jauh lebih sedikit dibanding mahasiswa. Admin membuka halaman detail mata praktikum dan mengklik tombol "Assign Laboran". Sistem menampilkan daftar semua laboran aktif yang tersedia beserta informasi status penugasannya untuk mata praktikum ini.

Untuk **menugaskan laboran baru**, admin mengklik tombol "Tugaskan" pada laboran yang dipilih. Sistem menyimpan relasi ke tabel laboran_matkul dan mencatat aktivitas assign_laboran ke activity_log. Laboran yang baru ditugaskan akan langsung melihat mata praktikum tersebut di dashboard mereka dan dapat mulai mengelola konten.

Untuk **menghapus penugasan**, admin mengklik tombol "Hapus" pada laboran yang sudah ditugaskan. Relasi dihapus dari tabel laboran_matkul dan laboran tidak lagi memiliki akses untuk mengelola mata praktikum tersebut. Namun, konten yang sudah diupload oleh laboran tersebut tetap tersimpan dan tidak ikut terhapus.

Satu mata praktikum dapat ditangani oleh beberapa laboran sekaligus, dan satu laboran dapat ditugaskan ke beberapa mata praktikum. Fleksibilitas ini memungkinkan pembagian tugas yang efisien sesuai kebutuhan laboratorium.

---

## 7. CRUD Konten - Admin (`Crud_konten,png.png`)

**Aktor:** Admin

Diagram ini menggambarkan proses pengelolaan konten pembelajaran oleh admin. Sebagai superuser, admin memiliki akses penuh ke semua mata praktikum tanpa perlu ditugaskan terlebih dahulu, berbeda dengan laboran yang aksesnya terbatas.

Setelah memilih mata praktikum dan melihat halaman detailnya, admin dapat mengelola tiga jenis konten yang masing-masing memiliki karakteristik berbeda:

**RPS (Rencana Pembelajaran Semester)** adalah dokumen perencanaan pembelajaran yang berisi tujuan, materi, metode evaluasi, dan jadwal selama satu semester. Untuk mengupload RPS, admin mengklik tombol "Upload RPS", mengisi judul, dan memilih file PDF dari komputer. Sistem akan memvalidasi tipe file (harus PDF), menyimpan file ke folder uploads/rps dengan nama terenkripsi untuk keamanan, dan menyimpan metadata ke tabel matkum_rps.

**Referensi** adalah materi pendukung pembelajaran yang dapat berupa file dokumen atau link eksternal. Untuk menambah referensi, admin mengisi judul, deskripsi, memilih tipe (file atau link), lalu mengupload file atau memasukkan URL. Referensi berguna untuk menyediakan jurnal, ebook, video YouTube, atau sumber belajar tambahan lainnya.

**Modul** adalah materi pembelajaran utama yang diorganisir berdasarkan slot pertemuan (1-16). Untuk mengupload modul, admin memilih slot yang masih kosong, mengisi judul modul, deskripsi, memilih tipe konten (PDF, video, link, atau lainnya), mengupload file atau memasukkan link, dan menentukan apakah modul langsung ditampilkan ke mahasiswa atau disembunyikan dulu. Sistem memastikan setiap slot hanya berisi satu modul.

---

## 8. CRUD Konten - Laboran (`Crud_konten,png.png`)

**Aktor:** Laboran

Diagram ini menggambarkan proses pengelolaan konten oleh laboran dengan pembatasan akses berdasarkan penugasan. Tidak seperti admin yang dapat mengakses semua mata praktikum, laboran hanya dapat mengelola konten untuk mata praktikum yang sudah ditugaskan kepadanya oleh admin.

Alur dimulai ketika laboran memilih mata praktikum dari dashboard. Sebelum menampilkan halaman detail, sistem melakukan pengecekan otorisasi dengan memeriksa apakah ada record di tabel laboran_matkul yang menghubungkan id user laboran dengan id mata praktikum yang dipilih. Jika tidak ditemukan (laboran tidak ditugaskan), sistem akan menolak akses dan mengarahkan laboran kembali ke dashboard dengan pesan error.

Jika laboran memiliki akses, sistem menampilkan halaman detail mata praktikum lengkap dengan semua konten yang ada. Laboran dapat melakukan operasi yang sama dengan admin untuk mengelola konten:

Untuk **RPS**, laboran dapat mengupload file PDF baru atau menghapus RPS yang sudah ada. Setiap upload akan mencatat id laboran sebagai uploader di field uploaded_by.

Untuk **Referensi**, laboran dapat menambah referensi baru (file atau link) dengan mengisi form yang sesuai, atau menghapus referensi yang ada.

Untuk **Modul**, laboran dapat mengupload modul ke slot yang tersedia, mengedit modul yang sudah ada (mengubah judul, deskripsi, mengganti file), mengatur visibilitas modul (show/hide), dan menghapus modul. Fitur edit modul memungkinkan laboran memperbarui materi tanpa perlu menghapus dan mengupload ulang.

---

## 9. Lihat Konten - Mahasiswa (`lihat.png`)

**Aktor:** Mahasiswa

Diagram ini menggambarkan proses mahasiswa dalam mengakses dan melihat konten pembelajaran dari mata praktikum yang diikutinya. Akses mahasiswa dibatasi hanya pada mata praktikum yang sudah didaftarkan oleh admin.
Ketika mahasiswa login ke sistem, dashboard akan menampilkan daftar mata praktikum yang diikuti berdasarkan data di tabel mahasiswa_matkum. Mahasiswa memilih salah satu mata praktikum untuk melihat kontennya. Sistem melakukan validasi ulang untuk memastikan mahasiswa benar-benar terdaftar di mata praktikum tersebut. Jika tidak terdaftar (misalnya mencoba mengakses langsung via URL), sistem akan menampilkan pesan error dan menolak akses.
Jika mahasiswa terdaftar, sistem akan mengambil semua konten yang tersedia: daftar RPS, daftar referensi, dan daftar modul. Untuk modul, sistem hanya menampilkan modul yang field is_visible bernilai 1 (visible), sedangkan modul yang disembunyikan oleh laboran tidak akan muncul di daftar mahasiswa.
Mahasiswa dapat memilih konten untuk dilihat berdasarkan jenisnya:
Untuk RPS, sistem akan membuka file PDF di tab baru browser atau mendownload otomatis tergantung pengaturan browser mahasiswa.
Untuk Referensi, jika tipe file maka sistem akan mendownload file, jika tipe link maka sistem akan membuka URL di tab baru untuk mengakses sumber eksternal.
Untuk Modul, sistem akan menampilkan atau mendownload file sesuai tipe kontennya (PDF viewer, video player, atau redirect ke link). Setiap akses modul akan menambah counter pada field download_count untuk statistik popularitas materi.

---

## 10. Download Konten - Mahasiswa (`lihat.png`)

**Aktor:** Mahasiswa

Diagram ini menggambarkan proses download konten oleh mahasiswa secara lebih detail dengan fokus pada mekanisme download dan pencatatan statistik. Proses ini merupakan kelanjutan dari alur lihat konten dengan penekanan pada aspek teknis download.

Setelah mahasiswa berhasil melewati validasi akses (terdaftar di mata praktikum), sistem menampilkan daftar konten yang dapat didownload. Mahasiswa memilih konten yang ingin diunduh dengan mengklik tombol download atau ikon yang tersedia.

Untuk **RPS**, sistem akan melakukan force download dengan mengatur header Content-Disposition: attachment. File PDF akan terunduh ke komputer mahasiswa dengan nama file original atau nama yang sudah di-generate oleh sistem.

Untuk **Referensi** dengan tipe file, sistem melakukan force download serupa dengan RPS. Untuk referensi dengan tipe link, sistem melakukan redirect ke URL eksternal yang akan dibuka di tab baru browser.

Untuk **Modul**, proses download menyesuaikan dengan tipe konten. File PDF atau video akan didownload langsung, sedangkan modul bertipe link akan di-redirect ke URL eksternal. Yang membedakan modul dengan konten lain adalah adanya pencatatan statistik: setiap kali modul diakses atau didownload, sistem akan menjalankan query UPDATE untuk menambah nilai field download_count sebesar 1.

Setelah proses download selesai, sistem mencatat aktivitas ke tabel activity_log. Record log berisi informasi id mahasiswa, jenis aksi (download_modul, download_rps, atau download_referensi), deskripsi konten yang didownload, IP address, dan timestamp. Data ini berguna untuk monitoring penggunaan sistem dan analisis materi mana yang paling sering diakses oleh mahasiswa.

---

## Ringkasan Diagram

| No | Nama File | Aktor | Fungsi | Tabel Database Terkait |
|----|-----------|-------|--------|------------------------|
| 1 | `login.png` | Semua User | Autentikasi masuk ke sistem | users, activity_log |
| 2 | `log.png` | Admin | Monitoring aktivitas pengguna | activity_log, users |
| 3 | `matkum.png` | Admin | CRUD mata praktikum | mata_kuliah |
| 4 | `user2.png` | Admin | CRUD user & import CSV | users |
| 5 | `assgin_mhs.png` | Admin | Pendaftaran mahasiswa ke matkum | mahasiswa_matkum, users |
| 6 | `assign_lab.png` | Admin | Penugasan laboran ke matkum | laboran_matkul, users |
| 7 | `Crud_konten,png.png` | Admin/Laboran | Upload RPS, Referensi, Modul | matkum_rps, matkum_referensi, modul |
| 8 | `lihat.png` | Mahasiswa | Akses & download konten | modul, matkum_rps, matkum_referensi, activity_log |
