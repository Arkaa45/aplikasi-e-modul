-- =====================================================
-- E-MODUL PRAKTIKUM DATABASE SCHEMA
-- CodeIgniter 3 Application
-- =====================================================

-- Buat database
CREATE DATABASE IF NOT EXISTS e_modul_praktikum CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE e_modul_praktikum;

-- =====================================================
-- TABEL USERS
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'laboran', 'mahasiswa') NOT NULL DEFAULT 'mahasiswa',
    nim_nip VARCHAR(20) NULL,
    prodi VARCHAR(100) NULL,
    angkatan YEAR NULL,
    foto VARCHAR(255) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABEL SEMESTER
-- =====================================================
CREATE TABLE IF NOT EXISTS semester (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_semester VARCHAR(50) NOT NULL,
    tahun_ajaran VARCHAR(20) NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    is_active TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABEL MATA KULIAH
-- =====================================================
CREATE TABLE IF NOT EXISTS mata_kuliah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_matkul VARCHAR(20) NOT NULL UNIQUE,
    nama_matkul VARCHAR(100) NOT NULL,
    sks INT DEFAULT 1,
    deskripsi TEXT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABEL PERTEMUAN
-- =====================================================
CREATE TABLE IF NOT EXISTS pertemuan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_matkul INT NOT NULL,
    id_semester INT NOT NULL,
    pertemuan_ke INT NOT NULL,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT NULL,
    tanggal DATE NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    FOREIGN KEY (id_semester) REFERENCES semester(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABEL MODUL
-- =====================================================
CREATE TABLE IF NOT EXISTS modul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pertemuan INT NOT NULL,
    judul_modul VARCHAR(200) NOT NULL,
    deskripsi TEXT NULL,
    tipe_file ENUM('pdf', 'video', 'link', 'lainnya') DEFAULT 'pdf',
    file_modul VARCHAR(255) NULL,
    link_external VARCHAR(500) NULL,
    uploaded_by INT NOT NULL,
    is_visible TINYINT(1) DEFAULT 1,
    download_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pertemuan) REFERENCES pertemuan(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABEL USER_MATKUL (Relasi Mahasiswa - Mata Kuliah)
-- =====================================================
CREATE TABLE IF NOT EXISTS user_matkul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_matkul INT NOT NULL,
    id_semester INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    FOREIGN KEY (id_semester) REFERENCES semester(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (id_user, id_matkul, id_semester)
) ENGINE=InnoDB;

-- =====================================================
-- TABEL ACTIVITY LOG
-- =====================================================
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABEL LABORAN_MATKUL (Relasi Laboran - Mata Kuliah)
-- =====================================================
CREATE TABLE IF NOT EXISTS laboran_matkul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_matkul INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    UNIQUE KEY unique_assignment (id_user, id_matkul)
) ENGINE=InnoDB;

-- =====================================================
-- SAMPLE DATA
-- =====================================================

-- Insert Admin User (password: password)
INSERT INTO users (nama, email, password, role, nim_nip) VALUES
('Admin Kepala Lab', 'admin@lab.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '198501012010011001');

-- Insert Laboran User (password: password)  
INSERT INTO users (nama, email, password, role, nim_nip) VALUES
('Budi Santoso', 'laboran@lab.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'laboran', '199001152015041002');

-- Insert Mahasiswa Users (password: password)
INSERT INTO users (nama, email, password, role, nim_nip, prodi, angkatan) VALUES
('Ahmad Maulana', 'mhs@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mahasiswa', '2021001001', 'Teknik Informatika', 2021),
('Siti Nurhaliza', 'siti@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mahasiswa', '2021001002', 'Teknik Informatika', 2021),
('Rizki Pratama', 'rizki@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mahasiswa', '2022001001', 'Sistem Informasi', 2022);
-- Insert Semester
INSERT INTO semester (nama_semester, tahun_ajaran, tanggal_mulai, tanggal_selesai, is_active) VALUES
('Ganjil', '2024/2025', '2024-09-01', '2025-01-31', 0),
('Genap', '2024/2025', '2025-02-01', '2025-06-30', 0),
('Ganjil', '2025/2026', '2025-09-01', '2026-01-31', 1);

-- Insert Mata Kuliah
INSERT INTO mata_kuliah (kode_matkul, nama_matkul, sks, deskripsi) VALUES
('PBD01', 'Praktikum Basis Data', 1, 'Praktikum dasar-dasar basis data dan SQL'),
('PWD01', 'Praktikum Web Development', 1, 'Praktikum pengembangan web dengan HTML, CSS, JavaScript'),
('PALGO01', 'Praktikum Algoritma', 1, 'Praktikum dasar algoritma dan pemrograman'),
('PJARKOM01', 'Praktikum Jaringan Komputer', 1, 'Praktikum konfigurasi jaringan komputer');

-- Assign Laboran to Mata Kuliah
INSERT INTO laboran_matkul (id_user, id_matkul) VALUES
(2, 1), (2, 2), (2, 3), (2, 4);

-- Enroll Mahasiswa to Mata Kuliah
INSERT INTO user_matkul (id_user, id_matkul, id_semester) VALUES
(3, 1, 3), (3, 2, 3), (3, 3, 3),
(4, 1, 3), (4, 2, 3),
(5, 1, 3), (5, 4, 3);

-- Insert Pertemuan for Praktikum Basis Data (Semester Ganjil 2025/2026)
INSERT INTO pertemuan (id_matkul, id_semester, pertemuan_ke, judul, deskripsi, tanggal) VALUES
(1, 3, 1, 'Pengenalan DBMS dan MySQL', 'Instalasi dan konfigurasi MySQL', '2025-09-08'),
(1, 3, 2, 'DDL - Create Database dan Table', 'Membuat database dan tabel dengan DDL', '2025-09-15'),
(1, 3, 3, 'DML - Insert, Update, Delete', 'Manipulasi data dengan DML', '2025-09-22'),
(1, 3, 4, 'Query SELECT dan Operator', 'Query dasar dan penggunaan operator', '2025-09-29'),
(1, 3, 5, 'JOIN Tables', 'Menggabungkan data dari beberapa tabel', '2025-10-06');

-- Insert Pertemuan for Praktikum Web Development
INSERT INTO pertemuan (id_matkul, id_semester, pertemuan_ke, judul, deskripsi, tanggal) VALUES
(2, 3, 1, 'HTML Dasar', 'Struktur dokumen HTML dan tag-tag dasar', '2025-09-09'),
(2, 3, 2, 'CSS Styling', 'Styling halaman web dengan CSS', '2025-09-16'),
(2, 3, 3, 'CSS Flexbox & Grid', 'Layout modern dengan Flexbox dan Grid', '2025-09-23'),
(2, 3, 4, 'JavaScript Dasar', 'Pengenalan JavaScript dan DOM', '2025-09-30'),
(2, 3, 5, 'JavaScript Events', 'Menangani event di JavaScript', '2025-10-07');

-- Insert Sample Modul
INSERT INTO modul (id_pertemuan, judul_modul, deskripsi, tipe_file, file_modul, uploaded_by) VALUES
(1, 'Modul 1: Pengenalan MySQL', 'Panduan instalasi dan konfigurasi MySQL Server', 'pdf', 'modul_mysql_intro.pdf', 2),
(2, 'Modul 2: Data Definition Language', 'Cara membuat database, tabel, dan constraint', 'pdf', 'modul_ddl.pdf', 2),
(6, 'Modul 1: HTML Basics', 'Struktur HTML5 dan semantic tags', 'pdf', 'modul_html_basics.pdf', 2);
