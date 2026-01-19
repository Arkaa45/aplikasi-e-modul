-- =====================================================
-- E-MODUL PRAKTIKUM DATABASE MIGRATION
-- Restructuring: Remove pertemuan, add RPS/Referensi/Modul slots
-- =====================================================

-- Backup existing data first!
-- Run: mysqldump -u root e_modul_praktikum > backup_before_migration.sql

USE e_modul_praktikum;

-- =====================================================
-- 1. CREATE NEW TABLES
-- =====================================================

-- Semester - Matkum pivot table
CREATE TABLE IF NOT EXISTS semester_matkum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_semester INT NOT NULL,
    id_matkul INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_semester) REFERENCES semester(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    UNIQUE KEY unique_semester_matkul (id_semester, id_matkul)
) ENGINE=InnoDB;

-- Semester - Mahasiswa pivot table
CREATE TABLE IF NOT EXISTS semester_mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_semester INT NOT NULL,
    id_user INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_semester) REFERENCES semester(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_semester_mahasiswa (id_semester, id_user)
) ENGINE=InnoDB;

-- RPS files per matkum
CREATE TABLE IF NOT EXISTS matkum_rps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_matkul INT NOT NULL,
    judul VARCHAR(200) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
) ENGINE=InnoDB;

-- Reference files per matkum
CREATE TABLE IF NOT EXISTS matkum_referensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_matkul INT NOT NULL,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT NULL,
    tipe ENUM('file', 'link') DEFAULT 'file',
    file_path VARCHAR(255) NULL,
    link_external VARCHAR(500) NULL,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
) ENGINE=InnoDB;

-- =====================================================
-- 2. MIGRATE MODUL TABLE (pertemuan-based to matkum-based)
-- =====================================================

-- Create new modul table structure
CREATE TABLE IF NOT EXISTS modul_new (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_matkul INT NOT NULL,
    slot_number INT NOT NULL DEFAULT 1,
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
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id),
    UNIQUE KEY unique_matkul_slot (id_matkul, slot_number)
) ENGINE=InnoDB;

-- Migrate existing modul data (if any)
INSERT INTO modul_new (id_matkul, slot_number, judul_modul, deskripsi, tipe_file, file_modul, link_external, uploaded_by, is_visible, download_count, created_at)
SELECT 
    p.id_matkul,
    p.pertemuan_ke as slot_number,
    m.judul_modul,
    m.deskripsi,
    m.tipe_file,
    m.file_modul,
    m.link_external,
    m.uploaded_by,
    m.is_visible,
    m.download_count,
    m.created_at
FROM modul m
JOIN pertemuan p ON m.id_pertemuan = p.id
ON DUPLICATE KEY UPDATE judul_modul = VALUES(judul_modul);

-- Drop old tables and rename
DROP TABLE IF EXISTS modul;
RENAME TABLE modul_new TO modul;

-- Drop pertemuan table (no longer needed)
DROP TABLE IF EXISTS pertemuan;

-- Drop user_matkul table (replaced by semester_mahasiswa)
DROP TABLE IF EXISTS user_matkul;

-- =====================================================
-- 3. SAMPLE DATA FOR NEW STRUCTURE
-- =====================================================

-- Assign matkum to semester
INSERT INTO semester_matkum (id_semester, id_matkul) VALUES
(3, 1), (3, 2), (3, 3), (3, 4);

-- Assign mahasiswa to semester
INSERT INTO semester_mahasiswa (id_semester, id_user) 
SELECT 3, id FROM users WHERE role = 'mahasiswa';

-- Sample RPS
INSERT INTO matkum_rps (id_matkul, judul, file_path, uploaded_by) VALUES
(1, 'RPS Praktikum Basis Data 2025', 'rps_pbd_2025.pdf', 1),
(2, 'RPS Praktikum Web Development 2025', 'rps_pwd_2025.pdf', 1);

-- Sample Referensi
INSERT INTO matkum_referensi (id_matkul, judul, deskripsi, tipe, file_path, uploaded_by) VALUES
(1, 'Buku Database Systems', 'Referensi utama untuk mata praktikum', 'file', 'ebook_database.pdf', 1),
(1, 'MySQL Documentation', 'Dokumentasi resmi MySQL', 'link', NULL, 1),
(2, 'MDN Web Docs', 'Referensi lengkap web development', 'link', NULL, 1);

-- Update link for referensi
UPDATE matkum_referensi SET link_external = 'https://dev.mysql.com/doc/' WHERE judul = 'MySQL Documentation';
UPDATE matkum_referensi SET link_external = 'https://developer.mozilla.org/' WHERE judul = 'MDN Web Docs';

-- =====================================================
-- MIGRATION COMPLETE
-- =====================================================
