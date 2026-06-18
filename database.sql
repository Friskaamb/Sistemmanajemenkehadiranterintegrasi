-- ============================================================================
-- DATABASE SCHEMA: SISTEM MANAJEMEN KEHADIRAN TERINTEGRASI
-- ============================================================================
-- Project: Sistem Manajemen Kehadiran Terintegrasi
-- Database Type: MySQL 8.0+
-- Created: 2026-06-17
-- ============================================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS `sistem_kehadiran_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistem_kehadiran_db`;

-- ============================================================================
-- 1. TABEL DEPARTMENTS (Divisi/Departemen)
-- ============================================================================
CREATE TABLE `departments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(100) NOT NULL,
    `deskripsi` TEXT NULL,
    `manager_id` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_nama` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 2. TABEL USERS (Pengguna/Karyawan)
-- ============================================================================
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `nik` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Nomor Identitas Karyawan',
    `role` ENUM('admin', 'karyawan', 'manager') NOT NULL DEFAULT 'karyawan',
    `department_id` BIGINT UNSIGNED NULL,
    `phone` VARCHAR(20) NULL,
    `address` TEXT NULL,
    `photo` VARCHAR(255) NULL COMMENT 'Path foto profil',
    `hire_date` DATE NULL COMMENT 'Tanggal bergabung',
    `status` ENUM('aktif', 'nonaktif', 'cuti', 'resign') NOT NULL DEFAULT 'aktif',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_email` (`email`),
    KEY `idx_nik` (`nik`),
    KEY `idx_role` (`role`),
    KEY `fk_department_id` (`department_id`),
    CONSTRAINT `fk_users_department` FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 3. TABEL ATTENDANCES (Absensi/Kehadiran)
-- ============================================================================
CREATE TABLE `attendances` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `nama` VARCHAR(255) NOT NULL,
    `tanggal` DATE NOT NULL,
    `jam_masuk` TIME NULL,
    `jam_pulang` TIME NULL,
    `foto_masuk` VARCHAR(255) NULL COMMENT 'Path foto absen masuk',
    `foto_pulang` VARCHAR(255) NULL COMMENT 'Path foto absen pulang',
    `status` ENUM('Hadir', 'Terlambat', 'Izin', 'Sakit', 'Cuti', 'Libur', 'Tidak Hadir') NOT NULL DEFAULT 'Hadir',
    `gps_status` VARCHAR(50) NULL COMMENT 'Verified, Unverified, Out of Range',
    `total_jam` DECIMAL(5,2) NULL COMMENT 'Total jam kerja',
    `catatan` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_tanggal` (`tanggal`),
    KEY `idx_status` (`status`),
    UNIQUE KEY `unique_user_tanggal` (`user_id`, `tanggal`),
    CONSTRAINT `fk_attendances_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 4. TABEL LEAVES (Izin/Cuti)
-- ============================================================================
CREATE TABLE `leaves` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `jenis_izin` ENUM('Cuti Tahunan', 'Sakit', 'Izin Pribadi', 'Izin Pernikahan', 'Kematian', 'Cuti Bersama') NOT NULL,
    `tgl_mulai` DATE NOT NULL,
    `tgl_selesai` DATE NOT NULL,
    `alasan` TEXT NOT NULL,
    `lampiran` VARCHAR(255) NULL COMMENT 'Path file lampiran (surat dokter, dll)',
    `status` ENUM('Pending', 'Disetujui', 'Ditolak', 'Dibatalkan') NOT NULL DEFAULT 'Pending',
    `approved_by` BIGINT UNSIGNED NULL COMMENT 'User ID yang approve',
    `approval_date` TIMESTAMP NULL,
    `catatan_persetujuan` TEXT NULL,
    `jumlah_hari` INT NOT NULL COMMENT 'Total hari izin',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_status` (`status`),
    KEY `idx_tgl_mulai` (`tgl_mulai`),
    KEY `idx_approved_by` (`approved_by`),
    CONSTRAINT `fk_leaves_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_leaves_approver` FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 5. TABEL LEAVE_QUOTAS (Kuota Cuti Tahunan)
-- ============================================================================
CREATE TABLE `leave_quotas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `tahun` YEAR NOT NULL,
    `kuota_cuti_tahunan` INT NOT NULL DEFAULT 12 COMMENT 'Total hari cuti tahunan',
    `kuota_sakit` INT NOT NULL DEFAULT 12 COMMENT 'Total hari sakit',
    `kuota_izin_pribadi` INT NOT NULL DEFAULT 3 COMMENT 'Total hari izin pribadi',
    `sisa_cuti_tahunan` INT NOT NULL DEFAULT 12,
    `sisa_sakit` INT NOT NULL DEFAULT 12,
    `sisa_izin_pribadi` INT NOT NULL DEFAULT 3,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_user_tahun` (`user_id`, `tahun`),
    CONSTRAINT `fk_leave_quotas_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 6. TABEL SHIFTS (Jadwal Kerja/Shift)
-- ============================================================================
CREATE TABLE `shifts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(100) NOT NULL,
    `jam_masuk` TIME NOT NULL,
    `jam_pulang` TIME NOT NULL,
    `toleransi_terlambat` INT NOT NULL DEFAULT 15 COMMENT 'Menit toleransi keterlambatan',
    `aktif` BOOLEAN NOT NULL DEFAULT TRUE,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_nama` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 7. TABEL USER_SHIFTS (Penugasan Shift ke Karyawan)
-- ============================================================================
CREATE TABLE `user_shifts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `shift_id` BIGINT UNSIGNED NOT NULL,
    `tgl_berlaku` DATE NOT NULL,
    `tgl_berakhir` DATE NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_shift_id` (`shift_id`),
    CONSTRAINT `fk_user_shifts_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_shifts_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 8. TABEL ATTENDANCE_LOGS (Log Detail Absensi - Optional untuk tracking)
-- ============================================================================
CREATE TABLE `attendance_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `tanggal` DATE NOT NULL,
    `jam` TIME NOT NULL,
    `tipe` ENUM('masuk', 'pulang') NOT NULL,
    `latitude` DECIMAL(10,8) NULL COMMENT 'Koordinat GPS',
    `longitude` DECIMAL(11,8) NULL COMMENT 'Koordinat GPS',
    `accuracy` INT NULL COMMENT 'Akurasi GPS dalam meter',
    `foto` VARCHAR(255) NULL,
    `device_info` VARCHAR(255) NULL COMMENT 'Info device (browser, mobile, dll)',
    `ip_address` VARCHAR(45) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_tanggal` (`tanggal`),
    CONSTRAINT `fk_attendance_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 9. TABEL HOLIDAYS (Hari Libur)
-- ============================================================================
CREATE TABLE `holidays` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(255) NOT NULL,
    `tanggal` DATE NOT NULL UNIQUE,
    `tipe` ENUM('Nasional', 'Perusahaan', 'Regional') NOT NULL,
    `deskripsi` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_tanggal` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 10. TABEL AUDIT_LOGS (Audit Trail)
-- ============================================================================
CREATE TABLE `audit_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NULL,
    `aksi` VARCHAR(255) NOT NULL,
    `tabel` VARCHAR(100) NOT NULL,
    `data_lama` JSON NULL,
    `data_baru` JSON NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_tabel` (`tabel`),
    KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 11. TABEL PASSWORD_RESET_TOKENS
-- ============================================================================
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 12. TABEL SESSIONS
-- ============================================================================
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    KEY `idx_user_id` (`user_id`),
    KEY `idx_last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 13. TABEL CACHE
-- ============================================================================
CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    KEY `idx_expiration` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 14. TABEL JOBS (Queue Jobs)
-- ============================================================================
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_queue` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SAMPLE DATA / SEED DATA
-- ============================================================================

-- Insert Departments
INSERT INTO `departments` (`nama`, `deskripsi`) VALUES
('Engineering', 'Departemen Engineering/Teknis'),
('Marketing', 'Departemen Marketing/Pemasaran'),
('HR', 'Departemen Human Resources'),
('Finance', 'Departemen Keuangan'),
('Operations', 'Departemen Operasional');

-- Insert Shifts
INSERT INTO `shifts` (`nama`, `jam_masuk`, `jam_pulang`, `toleransi_terlambat`) VALUES
('Shift Pagi', '08:00:00', '17:00:00', 15),
('Shift Siang', '12:00:00', '21:00:00', 15),
('Shift Malam', '21:00:00', '06:00:00', 15);

-- Insert Admin User
INSERT INTO `users` (`name`, `email`, `password`, `nik`, `role`, `department_id`, `phone`, `hire_date`, `status`) VALUES
('Admin PT.DFL', 'admin@ptdfl.com', '$2y$12$j9Zl6GxGZQhZQhZQhZQhZeZj9Zl6GxGZQhZQhZQhZQhZQhZQhZQh0', 'ADM-2024-001', 'admin', 1, '081234567890', '2024-01-01', 'aktif');

-- Insert Sample Karyawan
INSERT INTO `users` (`name`, `email`, `password`, `nik`, `role`, `department_id`, `phone`, `hire_date`, `status`) VALUES
('Budi Santoso', 'budi@ptdfl.com', '$2y$12$j9Zl6GxGZQhZQhZQhZQhZeZj9Zl6GxGZQhZQhZQhZQhZQhZQhZQh0', 'EMP-2024-015', 'karyawan', 1, '081234567891', '2024-03-15', 'aktif'),
('Ani Wijaya', 'ani@ptdfl.com', '$2y$12$j9Zl6GxGZQhZQhZQhZQhZeZj9Zl6GxGZQhZQhZQhZQhZQhZQhZQh0', 'EMP-2024-032', 'karyawan', 2, '081234567892', '2024-02-20', 'aktif'),
('Rudi Hartono', 'rudi@ptdfl.com', '$2y$12$j9Zl6GxGZQhZQhZQhZQhZeZj9Zl6GxGZQhZQhZQhZQhZQhZQhZQh0', 'EMP-2024-048', 'karyawan', 3, '081234567893', '2024-04-10', 'aktif'),
('Sarah Johnson', 'sarah@ptdfl.com', '$2y$12$j9Zl6GxGZQhZQhZQhZQhZeZj9Zl6GxGZQhZQhZQhZQhZQhZQhZQh0', 'EMP-2024-001', 'karyawan', 1, '081234567894', '2024-01-15', 'aktif'),
('David Kim', 'david@ptdfl.com', '$2y$12$j9Zl6GxGZQhZQhZQhZQhZeZj9Zl6GxGZQhZQhZQhZQhZQhZQhZQh0', 'EMP-2024-002', 'karyawan', 2, '081234567895', '2024-01-20', 'aktif'),
('Michael Chen', 'michael@ptdfl.com', '$2y$12$j9Zl6GxGZQhZQhZQhZQhZeZj9Zl6GxGZQhZQhZQhZQhZQhZQhZQh0', 'EMP-2024-003', 'karyawan', 3, '081234567896', '2024-02-01', 'aktif');

-- Insert Leave Quotas for Sample Users
INSERT INTO `leave_quotas` (`user_id`, `tahun`, `kuota_cuti_tahunan`, `kuota_sakit`, `kuota_izin_pribadi`, `sisa_cuti_tahunan`, `sisa_sakit`, `sisa_izin_pribadi`) VALUES
(2, 2026, 12, 12, 3, 8, 11, 3),
(3, 2026, 12, 12, 3, 11, 12, 2),
(4, 2026, 12, 12, 3, 12, 12, 3),
(5, 2026, 12, 12, 3, 10, 10, 2),
(6, 2026, 12, 12, 3, 12, 11, 3),
(7, 2026, 12, 12, 3, 11, 12, 3);

-- Insert Sample Holidays
INSERT INTO `holidays` (`nama`, `tanggal`, `tipe`, `deskripsi`) VALUES
('Tahun Baru', '2026-01-01', 'Nasional', 'Hari Tahun Baru'),
('Isra dan Miraj', '2026-02-08', 'Nasional', 'Perayaan Isra dan Miraj'),
('Hari Raya Idul Fitri', '2026-04-10', 'Nasional', 'Hari Raya Idul Fitri'),
('Hari Raya Idul Adha', '2026-06-06', 'Nasional', 'Hari Raya Idul Adha'),
('Tahun Baru Hijriah', '2026-07-26', 'Nasional', 'Tahun Baru Hijriah'),
('Hari Kemerdekaan RI', '2026-08-17', 'Nasional', 'Hari Kemerdekaan Republik Indonesia'),
('Maulid Nabi Muhammad', '2026-09-04', 'Nasional', 'Maulid Nabi Muhammad SAW'),
('Hari Raya Nyepi', '2026-03-21', 'Nasional', 'Hari Raya Nyepi'),
('Hari Natal', '2026-12-25', 'Nasional', 'Hari Natal Kristus'),
('Cuti Bersama', '2026-04-24', 'Perusahaan', 'Cuti Bersama PT.DFL');

-- Insert Sample Attendances
INSERT INTO `attendances` (`user_id`, `nama`, `tanggal`, `jam_masuk`, `jam_pulang`, `status`, `gps_status`, `total_jam`) VALUES
(2, 'Budi Santoso', '2026-04-22', '08:30:00', '17:15:00', 'Hadir', 'Verified', 8.75),
(2, 'Budi Santoso', '2026-04-21', '08:45:00', '17:30:00', 'Hadir', 'Verified', 8.75),
(2, 'Budi Santoso', '2026-04-20', '09:15:00', '17:20:00', 'Terlambat', 'Verified', 8.08),
(3, 'Ani Wijaya', '2026-04-22', '08:00:00', '17:00:00', 'Hadir', 'Verified', 9.00),
(3, 'Ani Wijaya', '2026-04-21', '08:15:00', '17:15:00', 'Hadir', 'Verified', 9.00),
(4, 'Rudi Hartono', '2026-04-22', '08:45:00', '17:30:00', 'Hadir', 'Verified', 8.75),
(5, 'Sarah Johnson', '2026-04-22', '08:45:00', '17:30:00', 'Hadir', 'Verified', 8.75),
(6, 'David Kim', '2026-04-22', '09:30:00', '17:45:00', 'Terlambat', 'Verified', 8.25),
(7, 'Michael Chen', '2026-04-22', '09:15:00', '17:30:00', 'Terlambat', 'Verified', 8.25);

-- Insert Sample Leaves
INSERT INTO `leaves` (`user_id`, `jenis_izin`, `tgl_mulai`, `tgl_selesai`, `alasan`, `status`, `approved_by`, `approval_date`, `jumlah_hari`) VALUES
(2, 'Cuti Tahunan', '2026-04-25', '2026-04-27', 'Liburan keluarga', 'Pending', NULL, NULL, 3),
(3, 'Sakit', '2026-04-23', '2026-04-23', 'Demam dan flu', 'Disetujui', 1, '2026-04-23 09:00:00', 1),
(4, 'Izin Pribadi', '2026-04-24', '2026-04-24', 'Keperluan keluarga', 'Ditolak', 1, '2026-04-24 10:00:00', 1);

-- ============================================================================
-- VIEWS (Optional - untuk memudahkan reporting)
-- ============================================================================

-- View: Attendance Summary by Month
CREATE OR REPLACE VIEW `v_attendance_monthly_summary` AS
SELECT 
    u.id as user_id,
    u.name,
    u.nik,
    d.nama as department,
    YEAR(a.tanggal) as tahun,
    MONTH(a.tanggal) as bulan,
    COUNT(CASE WHEN a.status = 'Hadir' THEN 1 END) as hari_hadir,
    COUNT(CASE WHEN a.status = 'Terlambat' THEN 1 END) as hari_terlambat,
    COUNT(CASE WHEN a.status = 'Izin' THEN 1 END) as hari_izin,
    COUNT(CASE WHEN a.status = 'Sakit' THEN 1 END) as hari_sakit,
    COUNT(CASE WHEN a.status = 'Tidak Hadir' THEN 1 END) as hari_tidak_hadir,
    ROUND(AVG(a.total_jam), 2) as rata_rata_jam_kerja
FROM `users` u
LEFT JOIN `departments` d ON u.department_id = d.id
LEFT JOIN `attendances` a ON u.id = a.user_id
GROUP BY u.id, YEAR(a.tanggal), MONTH(a.tanggal);

-- View: Employee Leave Status
CREATE OR REPLACE VIEW `v_employee_leave_status` AS
SELECT 
    u.id as user_id,
    u.name,
    u.nik,
    lq.tahun,
    lq.sisa_cuti_tahunan,
    lq.sisa_sakit,
    lq.sisa_izin_pribadi,
    COUNT(CASE WHEN l.status = 'Pending' THEN 1 END) as pending_requests
FROM `users` u
LEFT JOIN `leave_quotas` lq ON u.id = lq.user_id
LEFT JOIN `leaves` l ON u.id = l.user_id AND l.status = 'Pending'
GROUP BY u.id, lq.tahun;

-- ============================================================================
-- INDEXES untuk Performance
-- ============================================================================

-- Additional indexes untuk query yang sering digunakan
CREATE INDEX idx_attendances_user_tanggal ON `attendances` (`user_id`, `tanggal` DESC);
CREATE INDEX idx_attendances_status_tanggal ON `attendances` (`status`, `tanggal` DESC);
CREATE INDEX idx_leaves_user_status ON `leaves` (`user_id`, `status`);
CREATE INDEX idx_users_department_status ON `users` (`department_id`, `status`);

-- ============================================================================
-- NOTES / DOKUMENTASI
-- ============================================================================
/*
PASSWORD SAMPLE DATA:
Semua password di-hash dengan bcrypt: password

User Admin:
- Email: admin@ptdfl.com
- Password: password

Sample Karyawan:
- Email: budi@ptdfl.com (pass: password)
- Email: ani@ptdfl.com (pass: password)
- Email: rudi@ptdfl.com (pass: password)
- Email: sarah@ptdfl.com (pass: password)
- Email: david@ptdfl.com (pass: password)
- Email: michael@ptdfl.com (pass: password)

TAHAPAN IMPLEMENTASI BACKEND:
1. Jalankan migrations untuk membuat struktur tabel
2. Seed data dengan sample data di atas
3. Buat model-model yang masih kurang: Leave, Department, Holiday, Shift, etc
4. Implementasi relationships antar model
5. Lengkapi controller methods yang masih return view/dummy data
6. Implementasi authentication & authorization
7. Tambah validation & error handling
8. Testing API endpoints

GPS FIELDS:
latitude, longitude, accuracy digunakan untuk verify lokasi absensi
Bisa diintegrasikan dengan Google Maps API untuk verifikasi

AUDIT LOGS:
Untuk tracking semua perubahan data di database

NEXT STEPS:
- Setup .env untuk database credentials
- php artisan migrate untuk membuat struktur tabel
- php artisan db:seed untuk memasukkan sample data
*/
