# Activity Diagram PlantUML - E-Modul Praktikum

Dokumen ini berisi 9 Activity Diagram dalam format PlantUML berdasarkan Use Case yang telah ditentukan.

---

## Daftar Use Case

| No | Use Case | Aktor |
|----|----------|-------|
| 1 | Kelola Log | Admin |
| 2 | Kelola Mata Praktikum | Admin |
| 3 | Kelola User | Admin |
| 4 | Assign Mahasiswa | Admin |
| 5 | Assign Laboran | Admin |
| 6 | CRUD Modul, RPS, Referensi (Konten) | Admin |
| 7 | CRUD Konten | Laboran |
| 8 | Lihat Konten | Mahasiswa |
| 9 | Download Konten | Mahasiswa |

---

## 1. Activity Diagram - Kelola Log (Admin)

```plantuml
@startuml AD_Kelola_Log
title Activity Diagram: Kelola Log

start

:Admin login ke sistem;

:Pilih menu Activity Log;

:Sistem menampilkan daftar log aktivitas;

:Admin melihat informasi log;
note right
  - User
  - Action
  - Deskripsi
  - IP Address
  - Waktu
end note

if (Ingin filter log?) then (Ya)
    :Pilih filter (user/action/tanggal);
    :Sistem menampilkan log yang sesuai;
else (Tidak)
endif

:Admin selesai melihat log;

stop

@enduml
```

---

## 2. Activity Diagram - Kelola Mata Praktikum (Admin)

```plantuml
@startuml AD_Kelola_Matkum
title Activity Diagram: Kelola Mata Praktikum

start

:Admin login ke sistem;

:Pilih menu Mata Praktikum;

:Sistem menampilkan daftar mata praktikum;

switch (Pilih Aksi?)
case (Tambah)
    :Klik tombol Tambah;
    :Isi form mata praktikum;
    note right
      - Kode Matkum
      - Nama Matkum
      - SKS
      - Deskripsi
      - Status Aktif
    end note
    :Klik Simpan;
    if (Validasi berhasil?) then (Ya)
        :Simpan ke database;
        :Tampilkan pesan sukses;
    else (Tidak)
        :Tampilkan pesan error;
        :Kembali ke form;
    endif
    
case (Edit)
    :Pilih mata praktikum;
    :Klik tombol Edit;
    :Tampilkan form dengan data existing;
    :Ubah data yang diperlukan;
    :Klik Simpan;
    :Update database;
    :Tampilkan pesan sukses;
    
case (Hapus)
    :Pilih mata praktikum;
    :Klik tombol Hapus;
    :Tampilkan konfirmasi;
    if (Konfirmasi hapus?) then (Ya)
        :Hapus dari database;
        :Tampilkan pesan sukses;
    else (Tidak)
        :Batalkan penghapusan;
    endif
    
case (Lihat Detail)
    :Pilih mata praktikum;
    :Klik untuk lihat detail;
    :Tampilkan halaman detail;
    note right
      - Info Matkum
      - Daftar Laboran
      - Daftar Mahasiswa
      - Konten (RPS, Referensi, Modul)
    end note
    
case (Selesai)
endswitch

:Kembali ke daftar mata praktikum;

stop

@enduml
```

---

## 3. Activity Diagram - Kelola User (Admin)

```plantuml
@startuml AD_Kelola_User
title Activity Diagram: Kelola User

start

:Admin login ke sistem;

:Pilih menu Kelola User;

:Sistem menampilkan daftar user;

if (Gunakan filter?) then (Ya)
    :Pilih filter role (Admin/Laboran/Mahasiswa);
    :Tampilkan user sesuai filter;
else (Tidak)
endif

switch (Pilih Aksi?)
case (Tambah User)
    :Klik tombol Tambah;
    :Isi form user;
    note right
      - Nama
      - Email
      - Password
      - Role
      - NIM/NIP
      - Prodi
      - Angkatan
    end note
    :Klik Simpan;
    if (Email/NIM sudah ada?) then (Ya)
        :Tampilkan error duplikasi;
    else (Tidak)
        :Hash password;
        :Simpan ke database;
        :Tampilkan pesan sukses;
    endif
    
case (Edit User)
    :Pilih user;
    :Klik tombol Edit;
    :Tampilkan form dengan data existing;
    :Ubah data yang diperlukan;
    :Klik Simpan;
    :Update database;
    :Tampilkan pesan sukses;
    
case (Hapus User)
    :Pilih user;
    :Klik tombol Hapus;
    if (Konfirmasi hapus?) then (Ya)
        :Hapus dari database;
        :Tampilkan pesan sukses;
    else (Tidak)
        :Batalkan;
    endif
    
case (Toggle Status)
    :Pilih user;
    :Klik toggle aktif/nonaktif;
    :Update status di database;
    :Refresh tampilan;
    
case (Import CSV)
    :Klik tombol Import;
    :Pilih file CSV atau paste data;
    :Sistem parse CSV;
    if (Header valid?) then (Ya)
        :Loop setiap baris;
        :Validasi data;
        :Insert user valid ke database;
        :Catat error untuk data invalid;
        :Tampilkan hasil import;
    else (Tidak)
        :Tampilkan error format;
    endif
    
case (Selesai)
endswitch

stop

@enduml
```

---

## 4. Activity Diagram - Assign Mahasiswa (Admin)

```plantuml
@startuml AD_Assign_Mahasiswa
title Activity Diagram: Assign Mahasiswa

start

:Admin login ke sistem;

:Pilih Mata Praktikum;

:Klik menu Assign Mahasiswa;

:Sistem menampilkan daftar semua mahasiswa;

if (Gunakan filter?) then (Ya)
    fork
        :Filter berdasarkan Angkatan;
    fork again
        :Search berdasarkan Nama/NIM;
    fork again
        :Filter berdasarkan Status;
    end fork
    :Tampilkan hasil filter;
else (Tidak)
endif

:Pilih mahasiswa dari daftar;

switch (Aksi?)
case (Tambahkan)
    if (Mahasiswa sudah terdaftar?) then (Ya)
        :Tampilkan info sudah terdaftar;
    else (Tidak)
        :Insert ke tabel mahasiswa_matkum;
        :Log aktivitas assign;
        :Tampilkan pesan sukses;
        :Refresh halaman;
    endif
    
case (Hapus)
    :Delete dari tabel mahasiswa_matkum;
    :Log aktivitas remove;
    :Tampilkan pesan sukses;
    :Refresh halaman;
    
case (Selesai)
    :Kembali ke detail Mata Praktikum;
endswitch

stop

@enduml
```

---

## 5. Activity Diagram - Assign Laboran (Admin)

```plantuml
@startuml AD_Assign_Laboran
title Activity Diagram: Assign Laboran

start

:Admin login ke sistem;

:Pilih Mata Praktikum;

:Klik menu Assign Laboran;

:Sistem menampilkan daftar semua laboran;

:Pilih laboran dari daftar;

switch (Aksi?)
case (Tugaskan)
    if (Laboran sudah ditugaskan?) then (Ya)
        :Tampilkan info sudah ditugaskan;
    else (Tidak)
        :Insert ke tabel laboran_matkul;
        :Log aktivitas assign;
        :Tampilkan pesan sukses;
        :Refresh halaman;
    endif
    
case (Hapus Penugasan)
    :Delete dari tabel laboran_matkul;
    :Log aktivitas remove;
    :Tampilkan pesan sukses;
    :Refresh halaman;
    
case (Selesai)
    :Kembali ke detail Mata Praktikum;
endswitch

stop

@enduml
```

---

## 6. Activity Diagram - CRUD Modul, RPS, Referensi (Admin)

```plantuml
@startuml AD_CRUD_Konten_Admin
title Activity Diagram: CRUD Modul, RPS, Referensi (Admin)

start

:Admin login ke sistem;

:Pilih Mata Praktikum;

:Lihat halaman detail Mata Praktikum;

switch (Pilih jenis konten?)
case (RPS)
    switch (Aksi RPS?)
    case (Upload)
        :Klik Upload RPS;
        :Isi judul RPS;
        :Pilih file PDF;
        :Klik Submit;
        if (Upload berhasil?) then (Ya)
            :Simpan ke database;
            :Log aktivitas;
            :Tampilkan sukses;
        else (Tidak)
            :Tampilkan error;
        endif
    case (Hapus)
        :Pilih RPS;
        :Klik Hapus;
        :Konfirmasi hapus;
        :Delete dari database;
        :Hapus file;
        :Tampilkan sukses;
    endswitch
    
case (Referensi)
    switch (Aksi Referensi?)
    case (Upload)
        :Klik Upload Referensi;
        :Isi judul dan deskripsi;
        if (Tipe?) then (File)
            :Upload file;
        else (Link)
            :Input URL eksternal;
        endif
        :Klik Submit;
        :Simpan ke database;
        :Log aktivitas;
        :Tampilkan sukses;
    case (Hapus)
        :Pilih Referensi;
        :Klik Hapus;
        :Delete dari database;
        :Tampilkan sukses;
    endswitch
    
case (Modul)
    switch (Aksi Modul?)
    case (Upload)
        :Klik Upload Modul;
        :Pilih slot pertemuan (1-16);
        if (Slot tersedia?) then (Ya)
            :Isi judul dan deskripsi;
            switch (Tipe file?)
            case (PDF)
                :Upload file PDF;
            case (Video)
                :Upload file video;
            case (Link)
                :Input URL eksternal;
            endswitch
            :Set visibilitas;
            :Klik Submit;
            :Simpan ke database;
            :Log aktivitas;
            :Tampilkan sukses;
        else (Tidak)
            :Tampilkan pesan slot terisi;
        endif
    case (Hapus)
        :Pilih Modul;
        :Klik Hapus;
        :Delete dari database;
        :Hapus file;
        :Tampilkan sukses;
    endswitch
    
case (Selesai)
endswitch

:Kembali ke detail Mata Praktikum;

stop

@enduml
```

---

## 7. Activity Diagram - CRUD Konten (Laboran)

```plantuml
@startuml AD_CRUD_Konten_Laboran
title Activity Diagram: CRUD Konten (Laboran)

start

:Laboran login ke sistem;

:Sistem menampilkan daftar Mata Praktikum yang ditugaskan;

:Pilih Mata Praktikum;

if (Laboran memiliki akses?) then (Ya)
    :Lihat halaman detail Mata Praktikum;
else (Tidak)
    :Redirect ke dashboard;
    stop
endif

switch (Pilih jenis konten?)
case (RPS)
    switch (Aksi?)
    case (Upload)
        :Klik Upload RPS;
        :Isi judul;
        :Upload file PDF;
        :Klik Submit;
        :Simpan ke database;
        :Log aktivitas;
        :Tampilkan sukses;
    case (Hapus)
        :Pilih RPS;
        :Konfirmasi hapus;
        :Delete dari database;
        :Tampilkan sukses;
    endswitch

case (Referensi)
    switch (Aksi?)
    case (Upload)
        :Klik Upload Referensi;
        :Isi judul dan deskripsi;
        :Pilih tipe (File/Link);
        if (File?) then (Ya)
            :Upload file;
        else (Tidak)
            :Input URL;
        endif
        :Simpan ke database;
        :Tampilkan sukses;
    case (Hapus)
        :Pilih Referensi;
        :Delete dari database;
        :Tampilkan sukses;
    endswitch

case (Modul)
    switch (Aksi?)
    case (Upload)
        :Pilih slot pertemuan;
        :Isi form modul;
        :Upload file atau input link;
        :Set visibilitas;
        :Simpan ke database;
        :Log aktivitas;
        :Tampilkan sukses;
    case (Edit)
        :Pilih modul;
        :Edit data modul;
        :Update database;
        :Tampilkan sukses;
    case (Toggle Visibilitas)
        :Pilih modul;
        :Ubah status visible/hidden;
        :Update database;
        :Refresh tampilan;
    case (Hapus)
        :Pilih modul;
        :Konfirmasi hapus;
        :Delete dari database;
        :Tampilkan sukses;
    endswitch

case (Selesai)
endswitch

:Kembali ke detail Mata Praktikum;

stop

@enduml
```

---

## 8. Activity Diagram - Lihat Konten (Mahasiswa)

```plantuml
@startuml AD_Lihat_Konten
title Activity Diagram: Lihat Konten (Mahasiswa)

start

:Mahasiswa login ke sistem;

:Sistem menampilkan daftar Mata Praktikum yang terdaftar;

:Pilih Mata Praktikum;

if (Mahasiswa terdaftar di Matkum ini?) then (Ya)
    :Tampilkan halaman detail Mata Praktikum;
else (Tidak)
    :Tampilkan error akses ditolak;
    :Redirect ke dashboard;
    stop
endif

:Lihat informasi Mata Praktikum;

switch (Pilih konten yang ingin dilihat?)
case (RPS)
    :Tampilkan daftar RPS;
    :Pilih RPS;
    if (Tipe akses?) then (View)
        :Buka PDF inline di browser;
    else (Download)
        :Download file RPS;
    endif

case (Referensi)
    :Tampilkan daftar Referensi;
    :Pilih Referensi;
    if (Tipe referensi?) then (File)
        :Download file referensi;
    else (Link)
        :Redirect ke URL eksternal;
    endif

case (Modul)
    :Tampilkan daftar Modul (slot 1-16);
    note right
      Hanya modul dengan
      is_visible = true
      yang ditampilkan
    end note
    :Pilih Modul;
    switch (Tipe modul?)
    case (PDF)
        :Buka PDF inline atau download;
    case (Video)
        :Stream atau download video;
    case (Link)
        :Redirect ke URL eksternal;
    endswitch
    :Increment download count;

case (Selesai)
endswitch

:Kembali ke daftar Mata Praktikum;

stop

@enduml
```

---

## 9. Activity Diagram - Download Konten (Mahasiswa)

```plantuml
@startuml AD_Download_Konten
title Activity Diagram: Download Konten (Mahasiswa)

start

:Mahasiswa login ke sistem;

:Pilih Mata Praktikum;

if (Mahasiswa terdaftar?) then (Ya)
    :Akses halaman detail Matkum;
else (Tidak)
    :Tampilkan error tidak punya akses;
    stop
endif

:Pilih konten yang ingin didownload;

switch (Jenis konten?)
case (RPS)
    :Pilih file RPS;
    :Klik tombol Download;
    :Sistem mengambil file dari server;
    :Force download file PDF;

case (Referensi)
    :Pilih referensi;
    if (Tipe?) then (File)
        :Klik tombol Download;
        :Force download file;
    else (Link)
        :Klik link;
        :Redirect ke URL eksternal;
    endif

case (Modul)
    :Pilih modul dari slot;
    if (Modul visible?) then (Ya)
        switch (Tipe file?)
        case (PDF)
            if (Aksi?) then (View)
                :Buka PDF inline;
                :Increment view count;
            else (Download)
                :Force download PDF;
                :Increment download count;
            endif
        case (Video)
            :Klik Download;
            :Force download video;
            :Increment download count;
        case (Link)
            :Klik link;
            :Redirect ke URL eksternal;
            :Increment access count;
        endswitch
    else (Tidak)
        :Modul tidak tersedia;
    endif
endswitch

:Download selesai;

:Log aktivitas akses konten;

stop

@enduml
```

---

## Cara Menggunakan PlantUML

### Online Editor
1. Buka [PlantUML Web Server](http://www.plantuml.com/plantuml/uml/)
2. Copy-paste kode diagram
3. Klik Submit untuk generate gambar
4. Download hasil dalam format PNG/SVG

### VS Code Extension
1. Install extension "PlantUML"
2. Buat file dengan ekstensi `.puml`
3. Paste kode diagram
4. Tekan `Alt+D` untuk preview

### Command Line
```bash
java -jar plantuml.jar diagram.puml
```

---

## Ringkasan

| No | Activity Diagram | Use Case | Aktor |
|----|-----------------|----------|-------|
| 1 | AD_Kelola_Log | Kelola Log | Admin |
| 2 | AD_Kelola_Matkum | Kelola Mata Praktikum | Admin |
| 3 | AD_Kelola_User | Kelola User | Admin |
| 4 | AD_Assign_Mahasiswa | Assign Mahasiswa | Admin |
| 5 | AD_Assign_Laboran | Assign Laboran | Admin |
| 6 | AD_CRUD_Konten_Admin | CRUD Modul, RPS, Referensi | Admin |
| 7 | AD_CRUD_Konten_Laboran | CRUD Konten | Laboran |
| 8 | AD_Lihat_Konten | Lihat Konten | Mahasiswa |
| 9 | AD_Download_Konten | Download Konten | Mahasiswa |
