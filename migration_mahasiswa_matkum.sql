-- =====================================================
-- MIGRATION: Add mahasiswa_matkum table
-- Run this SQL in your MySQL/phpMyAdmin
-- =====================================================

CREATE TABLE IF NOT EXISTS mahasiswa_matkum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_matkul INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    UNIQUE KEY unique_mahasiswa_matkum (id_user, id_matkul)
) ENGINE=InnoDB;
