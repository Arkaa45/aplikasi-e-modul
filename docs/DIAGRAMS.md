# Diagram UML E-Modul Praktikum

Dokumen ini berisi diagram Use Case dan Activity dalam format Mermaid.

---

## 1. Use Case Diagram

### 1.1 Use Case Diagram - Keseluruhan Sistem

```mermaid
graph TB
    subgraph "E-Modul Praktikum System"
        
        subgraph "Autentikasi"
            UC1((Login))
            UC2((Logout))
        end
        
        subgraph "Manajemen User"
            UC3((Lihat Daftar User))
            UC4((Tambah User))
            UC5((Edit User))
            UC6((Hapus User))
            UC7((Import User CSV))
            UC8((Toggle Status User))
        end
        
        subgraph "Manajemen Mata Praktikum"
            UC9((Lihat Daftar Matkum))
            UC10((Tambah Matkum))
            UC11((Edit Matkum))
            UC12((Hapus Matkum))
            UC13((Lihat Detail Matkum))
        end
        
        subgraph "Manajemen Penugasan"
            UC14((Assign Laboran))
            UC15((Hapus Laboran))
            UC16((Assign Mahasiswa))
            UC17((Hapus Mahasiswa))
        end
        
        subgraph "Manajemen Konten"
            UC18((Upload RPS))
            UC19((Upload Referensi))
            UC20((Upload Modul))
            UC21((Edit Modul))
            UC22((Hapus Konten))
            UC23((Toggle Visibilitas))
        end
        
        subgraph "Akses Konten"
            UC24((Lihat RPS))
            UC25((Lihat Referensi))
            UC26((Lihat Modul))
            UC27((Download Konten))
        end
        
        UC28((Lihat Activity Log))
        UC29((Lihat Dashboard))
    end
    
    Admin[/"👤 Admin"/]
    Laboran[/"👤 Laboran"/]
    Mahasiswa[/"👤 Mahasiswa"/]
    
    Admin --- UC1 & UC2 & UC29
    Admin --- UC3 & UC4 & UC5 & UC6 & UC7 & UC8
    Admin --- UC9 & UC10 & UC11 & UC12 & UC13
    Admin --- UC14 & UC15 & UC16 & UC17
    Admin --- UC18 & UC19 & UC20 & UC22
    Admin --- UC28
    
    Laboran --- UC1 & UC2 & UC29
    Laboran --- UC13
    Laboran --- UC18 & UC19 & UC20 & UC21 & UC22 & UC23
    
    Mahasiswa --- UC1 & UC2 & UC29
    Mahasiswa --- UC13
    Mahasiswa --- UC24 & UC25 & UC26 & UC27
```

---

### 1.2 Use Case Diagram - Admin

```mermaid
graph LR
    Admin[/"👤 Admin"/]
    
    subgraph "Use Cases Admin"
        subgraph "Autentikasi"
            A1((Login))
            A2((Logout))
        end
        
        subgraph "Dashboard"
            A3((Lihat Dashboard))
            A4((Lihat Activity Log))
        end
        
        subgraph "Kelola User"
            A5((CRUD User))
            A6((Import CSV))
            A7((Toggle Status))
        end
        
        subgraph "Kelola Mata Praktikum"
            A8((CRUD Matkum))
            A9((Lihat Detail))
        end
        
        subgraph "Penugasan"
            A10((Assign Laboran))
            A11((Assign Mahasiswa))
        end
        
        subgraph "Upload Konten"
            A12((Upload RPS))
            A13((Upload Referensi))
            A14((Upload Modul))
            A15((Hapus Konten))
        end
    end
    
    Admin --> A1 & A2
    Admin --> A3 & A4
    Admin --> A5 & A6 & A7
    Admin --> A8 & A9
    Admin --> A10 & A11
    Admin --> A12 & A13 & A14 & A15
```

---

### 1.3 Use Case Diagram - Laboran

```mermaid
graph LR
    Laboran[/"👤 Laboran"/]
    
    subgraph "Use Cases Laboran"
        subgraph "Autentikasi"
            L1((Login))
            L2((Logout))
        end
        
        subgraph "Dashboard"
            L3((Lihat Dashboard))
            L4((Lihat Matkum Saya))
        end
        
        subgraph "Detail Matkum"
            L5((Lihat Detail))
            L6((Lihat Modul))
        end
        
        subgraph "Kelola RPS"
            L7((Upload RPS))
            L8((Hapus RPS))
        end
        
        subgraph "Kelola Referensi"
            L9((Upload Referensi))
            L10((Hapus Referensi))
        end
        
        subgraph "Kelola Modul"
            L11((Upload Modul))
            L12((Edit Modul))
            L13((Hapus Modul))
            L14((Toggle Visibilitas))
        end
    end
    
    Laboran --> L1 & L2
    Laboran --> L3 & L4
    Laboran --> L5 & L6
    Laboran --> L7 & L8
    Laboran --> L9 & L10
    Laboran --> L11 & L12 & L13 & L14
```

---

### 1.4 Use Case Diagram - Mahasiswa

```mermaid
graph LR
    Mahasiswa[/"👤 Mahasiswa"/]
    
    subgraph "Use Cases Mahasiswa"
        subgraph "Autentikasi"
            M1((Login))
            M2((Logout))
        end
        
        subgraph "Dashboard"
            M3((Lihat Dashboard))
            M4((Lihat Matkum Saya))
        end
        
        subgraph "Akses Konten"
            M5((Lihat Detail Matkum))
            M6((Lihat RPS))
            M7((Lihat Referensi))
            M8((Lihat Modul))
        end
        
        subgraph "Download"
            M9((Download RPS))
            M10((Download Referensi))
            M11((Download Modul))
            M12((View PDF Inline))
        end
    end
    
    Mahasiswa --> M1 & M2
    Mahasiswa --> M3 & M4
    Mahasiswa --> M5 & M6 & M7 & M8
    Mahasiswa --> M9 & M10 & M11 & M12
```

---

## 2. Activity Diagram

### 2.1 Activity Diagram - Login

```mermaid
flowchart TD
    A([Start]) --> B[Buka Halaman Login]
    B --> C[Masukkan Email & Password]
    C --> D{Validasi Input}
    
    D -->|Kosong| E[Tampilkan Error: Field Wajib Diisi]
    E --> C
    
    D -->|Valid| F{Verifikasi Kredensial}
    
    F -->|Salah| G[Tampilkan Error: Email/Password Salah]
    G --> C
    
    F -->|Benar| H{Cek Status Akun}
    
    H -->|Nonaktif| I[Tampilkan Error: Akun Tidak Aktif]
    I --> C
    
    H -->|Aktif| J[Set Session User]
    J --> K[Log Aktivitas Login]
    K --> L{Cek Role User}
    
    L -->|Admin| M[Redirect Dashboard Admin]
    L -->|Laboran| N[Redirect Dashboard Laboran]
    L -->|Mahasiswa| O[Redirect Dashboard Mahasiswa]
    
    M --> P([End])
    N --> P
    O --> P
```

---

### 2.2 Activity Diagram - Upload Modul (Laboran)

```mermaid
flowchart TD
    A([Start]) --> B[Pilih Mata Praktikum]
    B --> C{Cek Akses Laboran}
    
    C -->|Tidak Punya Akses| D[Redirect ke Dashboard]
    D --> E([End])
    
    C -->|Punya Akses| F[Pilih Menu Upload Modul]
    F --> G[Pilih Slot Pertemuan]
    G --> H{Slot Tersedia?}
    
    H -->|Tidak| I[Tampilkan Pesan: Slot Terisi]
    I --> G
    
    H -->|Ya| J[Isi Form Upload]
    J --> K[Input Judul Modul]
    K --> L[Input Deskripsi]
    L --> M[Pilih Tipe File]
    
    M --> N{Tipe File?}
    
    N -->|PDF/Video| O[Upload File]
    O --> P{Validasi File}
    P -->|Gagal| Q[Tampilkan Error Upload]
    Q --> O
    P -->|Sukses| R[Simpan Path File]
    
    N -->|Link| S[Input URL Eksternal]
    S --> R
    
    R --> T[Set Visibilitas]
    T --> U[Simpan ke Database]
    U --> V[Log Aktivitas]
    V --> W[Tampilkan Pesan Sukses]
    W --> X[Redirect ke Detail Matkum]
    X --> E
```

---

### 2.3 Activity Diagram - Assign Mahasiswa ke Mata Praktikum (Admin)

```mermaid
flowchart TD
    A([Start]) --> B[Buka Detail Mata Praktikum]
    B --> C[Klik Menu Assign Mahasiswa]
    C --> D[Tampilkan Daftar Mahasiswa]
    
    D --> E{Gunakan Filter?}
    
    E -->|Ya| F[Filter Angkatan / Search Nama]
    F --> G[Tampilkan Hasil Filter]
    G --> H{Pilih Aksi}
    
    E -->|Tidak| H
    
    H -->|Tambahkan| I{Sudah Terdaftar?}
    I -->|Ya| J[Tampilkan Info: Sudah Terdaftar]
    J --> H
    
    I -->|Tidak| K[Insert ke mahasiswa_matkum]
    K --> L[Log Aktivitas Assign]
    L --> M[Tampilkan Pesan Sukses]
    M --> N[Refresh Halaman]
    N --> H
    
    H -->|Hapus| O[Delete dari mahasiswa_matkum]
    O --> P[Log Aktivitas Remove]
    P --> Q[Tampilkan Pesan Sukses]
    Q --> N
    
    H -->|Selesai| R[Kembali ke Detail Matkum]
    R --> S([End])
```

---

### 2.4 Activity Diagram - Download/Akses Modul (Mahasiswa)

```mermaid
flowchart TD
    A([Start]) --> B[Buka Mata Praktikum]
    B --> C{Cek Akses Mahasiswa}
    
    C -->|Tidak Terdaftar| D[Tampilkan Error: Tidak Punya Akses]
    D --> E[Redirect ke Dashboard]
    E --> F([End])
    
    C -->|Terdaftar| G[Tampilkan Daftar Modul]
    G --> H[Pilih Modul]
    H --> I{Modul Visible?}
    
    I -->|Tidak| J[Modul Tidak Ditampilkan]
    J --> G
    
    I -->|Ya| K{Tipe Modul?}
    
    K -->|PDF| L{Aksi?}
    L -->|View| M[Buka PDF Inline]
    L -->|Download| N[Force Download File]
    
    K -->|Video| O[Force Download Video]
    
    K -->|Link| P[Redirect ke URL Eksternal]
    
    M --> Q[Increment Download Count]
    N --> Q
    O --> Q
    P --> Q
    
    Q --> R[Log Aktivitas Akses]
    R --> F
```

---

### 2.5 Activity Diagram - Import User CSV (Admin)

```mermaid
flowchart TD
    A([Start]) --> B[Buka Halaman Import]
    B --> C{Metode Input?}
    
    C -->|Upload File| D[Pilih File CSV]
    D --> E{Ekstensi Valid?}
    E -->|Bukan CSV| F[Error: File Harus CSV]
    F --> D
    E -->|CSV| G[Baca Konten File]
    
    C -->|Paste Data| H[Paste Data CSV]
    H --> I{Data Kosong?}
    I -->|Ya| J[Error: Data Kosong]
    J --> H
    I -->|Tidak| G
    
    G --> K[Parse CSV]
    K --> L{Header Valid?}
    L -->|Tidak| M[Error: Header Tidak Valid]
    M --> B
    
    L -->|Ya| N[Loop Setiap Baris]
    
    N --> O{Validasi Baris}
    
    O -->|Nama Kosong| P[Catat Error: Nama Wajib]
    O -->|Email Invalid| Q[Catat Error: Email Invalid]
    O -->|Email Duplikat| R[Catat Error: Email Sudah Ada]
    O -->|NIM Duplikat| S[Catat Error: NIM Sudah Ada]
    O -->|Valid| T[Insert User ke Database]
    
    P --> U{Baris Terakhir?}
    Q --> U
    R --> U
    S --> U
    T --> U
    
    U -->|Tidak| N
    U -->|Ya| V[Hitung Total Sukses/Error]
    
    V --> W{Ada Sukses?}
    W -->|Ya| X[Log Aktivitas Import]
    W -->|Tidak| Y[Tampilkan Hasil Import]
    X --> Y
    
    Y --> Z([End])
```

---

### 2.6 Activity Diagram - Kelola Konten Mata Praktikum (Laboran)

```mermaid
flowchart TD
    A([Start]) --> B[Login sebagai Laboran]
    B --> C[Lihat Dashboard]
    C --> D[Pilih Mata Praktikum]
    D --> E{Cek Penugasan}
    
    E -->|Tidak Ditugaskan| F[Redirect ke Dashboard]
    F --> G([End])
    
    E -->|Ditugaskan| H[Lihat Detail Matkum]
    
    H --> I{Pilih Aksi}
    
    I -->|Upload RPS| J[Isi Form RPS]
    J --> K[Upload File PDF]
    K --> L[Simpan RPS]
    L --> M[Tampilkan Sukses]
    M --> H
    
    I -->|Upload Referensi| N[Isi Form Referensi]
    N --> O{Tipe?}
    O -->|File| P[Upload File]
    O -->|Link| Q[Input URL]
    P --> R[Simpan Referensi]
    Q --> R
    R --> M
    
    I -->|Upload Modul| S[Pilih Slot]
    S --> T[Isi Form Modul]
    T --> U[Upload/Input File]
    U --> V[Set Visibilitas]
    V --> W[Simpan Modul]
    W --> M
    
    I -->|Edit Modul| X[Pilih Modul]
    X --> Y[Edit Data]
    Y --> Z[Simpan Perubahan]
    Z --> M
    
    I -->|Toggle Visibilitas| AA[Pilih Modul]
    AA --> AB[Ubah Status]
    AB --> M
    
    I -->|Hapus Konten| AC[Pilih Konten]
    AC --> AD[Konfirmasi Hapus]
    AD --> AE[Delete dari DB]
    AE --> M
    
    I -->|Selesai| G
```

---

## 3. Ringkasan Diagram

| No | Diagram | Tipe | Deskripsi |
|----|---------|------|-----------|
| 1 | Use Case Keseluruhan | Use Case | Gambaran seluruh fitur sistem |
| 2 | Use Case Admin | Use Case | Fitur khusus role Admin |
| 3 | Use Case Laboran | Use Case | Fitur khusus role Laboran |
| 4 | Use Case Mahasiswa | Use Case | Fitur khusus role Mahasiswa |
| 5 | Login | Activity | Proses autentikasi pengguna |
| 6 | Upload Modul | Activity | Proses laboran upload modul |
| 7 | Assign Mahasiswa | Activity | Proses admin assign mahasiswa |
| 8 | Download Modul | Activity | Proses mahasiswa akses konten |
| 9 | Import CSV | Activity | Proses admin import user massal |
| 10 | Kelola Konten | Activity | Alur kerja laboran kelola konten |

---

## 4. Cara Menggunakan

### Render di Markdown Editor
Diagram Mermaid dapat dirender di:
- GitHub/GitLab Markdown
- VS Code dengan extension Mermaid
- Notion
- Obsidian
- [Mermaid Live Editor](https://mermaid.live/)

### Export ke Gambar
1. Buka [Mermaid Live Editor](https://mermaid.live/)
2. Copy-paste kode diagram
3. Klik tombol Export (PNG/SVG)
