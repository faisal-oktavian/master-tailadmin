-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table master_tailadmin.karyawan
CREATE TABLE IF NOT EXISTS `karyawan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tgl_lahir` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `tgl_bergabung` datetime NOT NULL,
  `warna` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#465fff',
  `level_skill` tinyint unsigned NOT NULL DEFAULT '5',
  `departemen` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `bahasa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_karyawan_kode` (`kode`),
  UNIQUE KEY `uk_karyawan_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table master_tailadmin.karyawan: ~50 rows (approximately)
INSERT INTO `karyawan` (`id`, `kode`, `nama`, `email`, `password`, `telepon`, `website`, `gaji`, `tgl_lahir`, `jam_masuk`, `tgl_bergabung`, `warna`, `level_skill`, `departemen`, `jenis_kelamin`, `skills`, `bahasa`, `aktif`, `alamat`, `foto`, `created_at`, `updated_at`) VALUES
	(1, 'KRY-001', 'Budi Santoso', 'budi.santoso01@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '084642868828', NULL, 3650000.00, '1982-12-04', '07:15:00', '2025-02-02 09:00:00', '#06aed4', 9, 'IT', 'L', 'PHP,JavaScript,SQL', 'Indonesia', 1, 'Jl. Darmo No. 56, Sidoarjo', NULL, '2026-10-14 08:00:00', NULL),
	(2, 'KRY-002', 'Ayu Lestari', 'ayu.lestari02@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086889089901', NULL, 4000000.00, '1978-03-23', '09:00:00', '2023-06-05 08:00:00', '#f79009', 6, 'HRD', 'P', 'Manajemen,Rekrutmen', 'Indonesia,Inggris', 1, 'Jl. Ahmad Yani No. 27, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(3, 'KRY-003', 'Dewi Anggraini', 'dewi.anggraini03@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086981971316', NULL, 3000000.00, '1990-02-18', '08:30:00', '2021-11-19 08:00:00', '#465fff', 4, 'Keuangan', 'P', 'Akuntansi,Excel', 'Indonesia,Inggris', 1, 'Jl. Darmo No. 12, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(4, 'KRY-004', 'Dedi Irawan', 'dedi.irawan04@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '084670855700', 'https://pegawai04.example.com', 6300000.00, '1989-03-12', '08:15:00', '2022-04-23 08:00:00', '#7a5af8', 7, 'Operasional', 'L', 'Administrasi,Microsoft Office', 'Indonesia', 1, 'Jl. Kenanga No. 44, Mojokerto', NULL, '2026-10-14 08:00:00', NULL),
	(5, 'KRY-005', 'Riska Amelia', 'riska.amelia05@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '089984752529', NULL, 3650000.00, '1999-06-27', '08:30:00', '2017-04-26 07:00:00', '#12b76a', 8, 'Marketing', 'P', 'Desain Grafis,Photoshop', 'Indonesia,Inggris,Jepang', 1, 'Jl. Gajah Mada No. 69, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(6, 'KRY-006', 'Riska Amelia', 'riska.amelia06@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086929175900', NULL, 3900000.00, '1982-04-24', '08:15:00', '2025-09-24 08:00:00', '#f04438', 8, 'Pengadaan', 'P', 'Jaringan,Server', 'Indonesia,Inggris', 1, 'Jl. Kenanga No. 103, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(7, 'KRY-007', 'Iqbal Ramadhan', 'iqbal.ramadhan07@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '081724716857', NULL, 3200000.00, '1998-03-26', '08:00:00', '2023-10-13 07:00:00', '#06aed4', 2, 'Administrasi', 'L', 'Pengadaan,Negosiasi', 'Indonesia,Inggris', 1, 'Jl. Kenanga No. 120, Mojokerto', NULL, '2026-10-14 08:00:00', NULL),
	(8, 'KRY-008', 'Yuni Astuti', 'yuni.astuti08@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '089355657579', 'https://pegawai08.example.com', 2950000.00, '1987-07-06', '08:15:00', '2024-01-17 08:00:00', '#12b76a', 6, 'Logistik', 'P', 'Analisis Data,Excel', 'Indonesia,Inggris', 1, 'Jl. Melati No. 28, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(9, 'KRY-009', 'Aldi Firmansyah', 'aldi.firmansyah09@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '087810076758', NULL, 6050000.00, '1988-08-01', '07:45:00', '2018-06-08 08:00:00', '#ee46bc', 2, 'Penjualan', 'L', 'Database,SQL', 'Indonesia', 0, 'Jl. Diponegoro No. 146, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(10, 'KRY-010', 'Agus Setiawan', 'agus.setiawan10@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '089573791320', NULL, 5750000.00, '1983-05-17', '08:45:00', '2026-07-18 08:00:00', '#f04438', 8, 'Umum', 'L', 'Komunikasi,Presentasi', 'Indonesia,Inggris', 1, 'Jl. Pahlawan No. 103, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(11, 'KRY-011', 'Eko Kurniawan', 'eko.kurniawan11@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '083918593410', NULL, 4400000.00, '1978-10-18', '07:30:00', '2020-10-01 08:00:00', '#465fff', 9, 'IT', 'L', 'Inventaris,Logistik', 'Indonesia', 1, 'Jl. Pemuda No. 59, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(12, 'KRY-012', 'Arif Hidayat', 'arif.hidayat12@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '089675151231', 'https://pegawai12.example.com', 3600000.00, '1995-03-24', '07:45:00', '2026-10-08 09:00:00', '#f79009', 7, 'HRD', 'L', 'Python,SQL', 'Indonesia,Inggris', 1, 'Jl. Gajah Mada No. 49, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(13, 'KRY-013', 'Wulan Sari', 'wulan.sari13@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '081797705310', NULL, 6350000.00, '1981-01-13', '09:15:00', '2022-02-07 08:00:00', '#f79009', 8, 'Keuangan', 'P', 'UI/UX,Figma', 'Indonesia,Inggris', 1, 'Jl. Melati No. 115, Sidoarjo', NULL, '2026-10-14 08:00:00', NULL),
	(14, 'KRY-014', 'Rizky Ramadhan', 'rizky.ramadhan14@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086783863413', NULL, 2850000.00, '1979-11-18', '09:00:00', '2017-02-06 08:00:00', '#12b76a', 7, 'Operasional', 'L', 'Akuntansi,Audit', 'Indonesia,Inggris', 1, 'Jl. Mawar No. 124, Sidoarjo', NULL, '2026-10-14 08:00:00', NULL),
	(15, 'KRY-015', 'Dedi Irawan', 'dedi.irawan15@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '084471070189', NULL, 4050000.00, '1991-12-31', '07:30:00', '2025-11-05 09:00:00', '#465fff', 1, 'Marketing', 'L', 'Customer Service,CRM', 'Indonesia,Inggris', 1, 'Jl. Pahlawan No. 56, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(16, 'KRY-016', 'Nur Aisyah', 'nur.aisyah16@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '087831130263', 'https://pegawai16.example.com', 2600000.00, '1994-02-28', '08:00:00', '2019-02-22 07:00:00', '#f04438', 2, 'Pengadaan', 'P', 'PHP,JavaScript,SQL', 'Indonesia,Inggris', 1, 'Jl. Gajah Mada No. 31, Mojokerto', NULL, '2026-10-14 08:00:00', NULL),
	(17, 'KRY-017', 'Tika Pertiwi', 'tika.pertiwi17@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '088585863473', NULL, 5550000.00, '1988-05-07', '07:00:00', '2022-04-13 08:00:00', '#7a5af8', 10, 'Administrasi', 'P', 'Manajemen,Rekrutmen', 'Indonesia,Inggris', 1, 'Jl. Pahlawan No. 118, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(18, 'KRY-018', 'Rizky Ramadhan', 'rizky.ramadhan18@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '087938609087', NULL, 5450000.00, '1986-03-30', '08:00:00', '2022-02-12 08:00:00', '#06aed4', 9, 'Logistik', 'L', 'Akuntansi,Excel', 'Indonesia,Inggris,Jepang', 0, 'Jl. Rungkut No. 113, Mojokerto', NULL, '2026-10-14 08:00:00', NULL),
	(19, 'KRY-019', 'Tika Pertiwi', 'tika.pertiwi19@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '082428024248', NULL, 3900000.00, '1981-02-24', '08:45:00', '2025-03-10 08:00:00', '#f79009', 1, 'Penjualan', 'P', 'Administrasi,Microsoft Office', 'Indonesia,Inggris', 1, 'Jl. Ahmad Yani No. 53, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(20, 'KRY-020', 'Bagus Wicaksono', 'bagus.wicaksono20@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086547135391', 'https://pegawai20.example.com', 2500000.00, '1978-06-25', '07:00:00', '2019-11-06 08:00:00', '#465fff', 3, 'Umum', 'L', 'Desain Grafis,Photoshop', 'Indonesia,Inggris', 1, 'Jl. Melati No. 110, Mojokerto', NULL, '2026-10-14 08:00:00', NULL),
	(21, 'KRY-021', 'Yoga Firmansyah', 'yoga.firmansyah21@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '088584158663', '', 3150000.00, '1991-03-02', '09:15:00', '2021-06-12 07:00:00', '#12b76a', 3, 'IT', 'L', 'PHP', 'Indonesia,Inggris', 1, 'Jl. Diponegoro No. 27, Gresik', NULL, '2026-10-14 08:00:00', '2026-10-14 08:09:48'),
	(22, 'KRY-022', 'Teguh Prakoso', 'teguh.prakoso22@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '081434073380', NULL, 6950000.00, '1988-07-26', '08:15:00', '2020-05-26 08:00:00', '#ee46bc', 8, 'HRD', 'L', 'Pengadaan,Negosiasi', 'Indonesia', 1, 'Jl. Gajah Mada No. 10, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(23, 'KRY-023', 'Citra Maharani', 'citra.maharani23@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '084039920292', NULL, 2400000.00, '1999-04-13', '08:00:00', '2022-05-25 07:00:00', '#465fff', 5, 'Keuangan', 'P', 'Analisis Data,Excel', 'Indonesia,Inggris,Jepang', 1, 'Jl. Ahmad Yani No. 131, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(24, 'KRY-024', 'Galih Permana', 'galih.permana24@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '084415134794', 'https://pegawai24.example.com', 2900000.00, '1997-07-12', '09:00:00', '2022-07-13 07:00:00', '#f04438', 9, 'Operasional', 'L', 'Database,SQL', 'Indonesia,Inggris', 1, 'Jl. Pahlawan No. 12, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(25, 'KRY-025', 'Yoga Firmansyah', 'yoga.firmansyah25@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086619391725', NULL, 6500000.00, '1988-10-11', '08:15:00', '2018-12-17 08:00:00', '#12b76a', 7, 'Marketing', 'L', 'Komunikasi,Presentasi', 'Indonesia,Inggris,Jepang', 1, 'Jl. Gajah Mada No. 84, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(26, 'KRY-026', 'Tika Pertiwi', 'tika.pertiwi26@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '083392613013', NULL, 5850000.00, '1987-07-18', '09:45:00', '2017-05-07 08:00:00', '#06aed4', 4, 'Pengadaan', 'P', 'Inventaris,Logistik', 'Indonesia,Inggris', 1, 'Jl. Kenanga No. 83, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(27, 'KRY-027', 'Larasati Putri', 'larasati.putri27@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '083298429450', NULL, 2750000.00, '1987-09-22', '08:00:00', '2026-06-27 07:00:00', '#465fff', 4, 'Administrasi', 'P', 'Python,SQL', 'Indonesia,Inggris', 0, 'Jl. Pahlawan No. 58, Sidoarjo', NULL, '2026-10-14 08:00:00', NULL),
	(28, 'KRY-028', 'Desi Anggraini', 'desi.anggraini28@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '082071124923', 'https://pegawai28.example.com', 4900000.00, '1998-10-07', '08:15:00', '2023-08-08 09:00:00', '#ee46bc', 9, 'Logistik', 'P', 'UI/UX,Figma', 'Indonesia,Inggris', 1, 'Jl. Pemuda No. 28, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(29, 'KRY-029', 'Dewi Anggraini', 'dewi.anggraini29@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '088243446826', NULL, 3000000.00, '1992-03-26', '09:15:00', '2024-11-25 08:00:00', '#06aed4', 8, 'Penjualan', 'P', 'Akuntansi,Audit', 'Indonesia,Inggris', 1, 'Jl. Kenanga No. 130, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(30, 'KRY-030', 'Maya Puspitasari', 'maya.puspitasari30@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '084295585469', NULL, 4000000.00, '2002-09-16', '08:00:00', '2020-05-03 09:00:00', '#12b76a', 3, 'Umum', 'P', 'Customer Service,CRM', 'Indonesia,Inggris,Jepang', 1, 'Jl. Diponegoro No. 70, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(31, 'KRY-031', 'Dedi Irawan', 'dedi.irawan31@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '089930509175', NULL, 6750000.00, '1984-02-14', '07:45:00', '2023-06-14 09:00:00', '#7a5af8', 1, 'IT', 'L', 'PHP,JavaScript,SQL', 'Indonesia', 1, 'Jl. Diponegoro No. 108, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(32, 'KRY-032', 'Citra Maharani', 'citra.maharani32@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086066240084', 'https://pegawai32.example.com', 5650000.00, '2001-12-18', '09:30:00', '2026-04-08 09:00:00', '#06aed4', 7, 'HRD', 'P', 'Manajemen,Rekrutmen', 'Indonesia,Inggris,Jepang', 1, 'Jl. Gajah Mada No. 125, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(33, 'KRY-033', 'Ilham Maulana', 'ilham.maulana33@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '082793517915', NULL, 5650000.00, '1978-07-19', '07:30:00', '2026-11-03 07:00:00', '#7a5af8', 6, 'Keuangan', 'L', 'Akuntansi,Excel', 'Indonesia,Inggris', 1, 'Jl. Rungkut No. 119, Sidoarjo', NULL, '2026-10-14 08:00:00', NULL),
	(34, 'KRY-034', 'Ilham Maulana', 'ilham.maulana34@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '085255298556', NULL, 7100000.00, '1990-05-25', '08:00:00', '2023-05-16 07:00:00', '#ee46bc', 1, 'Operasional', 'L', 'Administrasi,Microsoft Office', 'Indonesia', 1, 'Jl. Melati No. 14, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(35, 'KRY-035', 'Eko Kurniawan', 'eko.kurniawan35@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '083612735359', NULL, 6200000.00, '1982-04-05', '08:00:00', '2024-11-19 07:00:00', '#ee46bc', 3, 'Marketing', 'L', 'Desain Grafis,Photoshop', 'Indonesia,Inggris', 1, 'Jl. Mawar No. 66, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(36, 'KRY-036', 'Putri Amelia', 'putri.amelia36@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '088513446499', 'https://pegawai36.example.com', 4200000.00, '1996-11-30', '07:00:00', '2023-07-03 08:00:00', '#f79009', 9, 'Pengadaan', 'P', 'Jaringan,Server', 'Indonesia,Inggris', 0, 'Jl. Darmo No. 78, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(37, 'KRY-037', 'Tika Pertiwi', 'tika.pertiwi37@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '085819255216', NULL, 5450000.00, '1998-06-01', '08:30:00', '2023-08-14 07:00:00', '#f04438', 9, 'Administrasi', 'P', 'Pengadaan,Negosiasi', 'Indonesia,Inggris,Jepang', 1, 'Jl. Mawar No. 40, Malang', NULL, '2026-10-14 08:00:00', NULL),
	(38, 'KRY-038', 'Wulan Sari', 'wulan.sari38@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086689520597', NULL, 3950000.00, '1988-04-27', '07:45:00', '2018-05-08 09:00:00', '#ee46bc', 6, 'Logistik', 'P', 'Analisis Data,Excel', 'Indonesia,Inggris', 1, 'Jl. Kenanga No. 98, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(39, 'KRY-039', 'Reza Pahlevi', 'reza.pahlevi39@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '083857623800', NULL, 7350000.00, '1986-06-09', '08:45:00', '2026-12-18 08:00:00', '#7a5af8', 9, 'Penjualan', 'L', 'Database,SQL', 'Indonesia', 1, 'Jl. Melati No. 49, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(40, 'KRY-040', 'Yusuf Maulana', 'yusuf.maulana40@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '087196691619', 'https://pegawai40.example.com', 6800000.00, '1993-08-26', '08:45:00', '2017-02-08 08:00:00', '#f04438', 9, 'Umum', 'L', 'Komunikasi,Presentasi', 'Indonesia,Inggris', 1, 'Jl. Diponegoro No. 79, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(41, 'KRY-041', 'Rani Kusuma', 'rani.kusuma41@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '088154398056', NULL, 4500000.00, '2000-08-09', '08:15:00', '2021-05-04 08:00:00', '#12b76a', 8, 'IT', 'P', 'Inventaris,Logistik', 'Indonesia,Inggris', 1, 'Jl. Ahmad Yani No. 31, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(42, 'KRY-042', 'Larasati Putri', 'larasati.putri42@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '088680415568', NULL, 6050000.00, '1987-02-27', '08:30:00', '2020-05-12 08:00:00', '#465fff', 1, 'HRD', 'P', 'Python,SQL', 'Indonesia,Inggris', 1, 'Jl. Pahlawan No. 4, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(43, 'KRY-043', 'Vina Melati', 'vina.melati43@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '082795613415', NULL, 7050000.00, '1993-02-28', '07:30:00', '2017-10-16 08:00:00', '#ee46bc', 8, 'Keuangan', 'P', 'UI/UX,Figma', 'Indonesia,Inggris', 1, 'Jl. Mawar No. 88, Sidoarjo', NULL, '2026-10-14 08:00:00', NULL),
	(44, 'KRY-044', 'Rizky Ramadhan', 'rizky.ramadhan44@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086276001106', 'https://pegawai44.example.com', 2700000.00, '1996-11-22', '09:15:00', '2017-03-26 08:00:00', '#ee46bc', 9, 'Operasional', 'L', 'Akuntansi,Audit', 'Indonesia,Inggris,Jepang', 1, 'Jl. Darmo No. 64, Surabaya', NULL, '2026-10-14 08:00:00', NULL),
	(45, 'KRY-045', 'Wulan Sari', 'wulan.sari45@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '086749910061', NULL, 6000000.00, '1991-05-19', '07:15:00', '2026-01-25 07:00:00', '#12b76a', 3, 'Marketing', 'P', 'Customer Service,CRM', 'Indonesia,Inggris', 0, 'Jl. Diponegoro No. 68, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(46, 'KRY-046', 'Fajar Nugroho', 'fajar.nugroho46@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '081164830300', NULL, 5100000.00, '2000-10-16', '08:30:00', '2021-01-10 08:00:00', '#ee46bc', 10, 'Pengadaan', 'L', 'PHP,JavaScript,SQL', 'Indonesia,Inggris,Jepang', 1, 'Jl. Mawar No. 19, Pasuruan', NULL, '2026-10-14 08:00:00', NULL),
	(47, 'KRY-047', 'Teguh Prakoso', 'teguh.prakoso47@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '082583089925', NULL, 3650000.00, '1998-03-30', '09:00:00', '2021-03-02 07:00:00', '#7a5af8', 5, 'Administrasi', 'L', 'Manajemen,Rekrutmen', 'Indonesia,Inggris', 1, 'Jl. Pahlawan No. 146, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(48, 'KRY-048', 'Maya Puspitasari', 'maya.puspitasari48@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '087582475098', 'https://pegawai48.example.com', 5400000.00, '1992-02-20', '07:30:00', '2017-07-20 08:00:00', '#f04438', 1, 'Logistik', 'P', 'Akuntansi,Excel', 'Indonesia,Inggris,Jepang', 1, 'Jl. Pemuda No. 24, Sidoarjo', NULL, '2026-10-14 08:00:00', NULL),
	(49, 'KRY-049', 'Reza Pahlevi', 'reza.pahlevi49@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '087797444123', NULL, 5050000.00, '1986-03-19', '08:00:00', '2023-11-03 09:00:00', '#ee46bc', 3, 'Penjualan', 'L', 'Administrasi,Microsoft Office', 'Indonesia,Inggris', 1, 'Jl. Ahmad Yani No. 105, Gresik', NULL, '2026-10-14 08:00:00', NULL),
	(50, 'KRY-050', 'Rani Kusuma', 'rani.kusuma50@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '089976500726', '', 4050000.00, '1999-07-27', '09:00:00', '2025-01-03 09:00:00', '#06aed4', 9, 'IT', 'P', 'PHP', 'Indonesia,Inggris,Jepang', 1, 'Jl. Pahlawan No. 83, Surabaya', NULL, '2026-10-14 08:00:00', '2026-10-14 08:10:16');

-- Dumping structure for table master_tailadmin.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_supplier_kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table master_tailadmin.supplier: ~13 rows (approximately)
INSERT INTO `supplier` (`id`, `kode`, `nama`, `email`, `telepon`, `kota`, `alamat`, `aktif`, `created_at`, `updated_at`) VALUES
	(1, 'SUP-001', 'PT Maju Jaya', 'sales@majujaya.example', '031555111', 'Surabaya', 'Jl. Margomulyo No. 21', 1, '2026-10-14 08:00:00', NULL),
	(2, 'SUP-002', 'CV Sumber Rejeki', 'info@sumberrejeki.example', '0274555222', 'Yogyakarta', 'Jl. Malioboro No. 99', 1, '2026-10-14 08:00:00', NULL),
	(3, 'SUP-003', 'UD Berkah Abadi', 'cs@berkahabadi.example', '0341555333', 'Malang', 'Jl. Ijen No. 3', 0, '2026-10-14 08:00:00', NULL),
	(4, 'SUP-004', 'PT Sentosa Teknologi', 'sales@sentosateknologi.example', '0315551004', 'Surabaya', 'Jl. Raya Darmo No. 44', 1, '2026-10-14 08:00:00', NULL),
	(5, 'SUP-005', 'CV Mitra Komputindo', 'info@mitrakomputindo.example', '0315551005', 'Sidoarjo', 'Jl. Pahlawan No. 18', 1, '2026-10-14 08:00:00', NULL),
	(6, 'SUP-006', 'PT Nusantara Logistik', 'layanan@nusantaralogistik.example', '0215551006', 'Jakarta', 'Jl. Gatot Subroto No. 70', 1, '2026-10-14 08:00:00', NULL),
	(7, 'SUP-007', 'CV Karya Mandiri', 'kontak@karyamandiri.example', '0341551007', 'Malang', 'Jl. Soekarno Hatta No. 12', 1, '2026-10-14 08:00:00', NULL),
	(8, 'SUP-008', 'PT Digital Solusi', 'support@digitalsolusi.example', '0315551008', 'Surabaya', 'Jl. Basuki Rahmat No. 35', 1, '2026-10-14 08:00:00', NULL),
	(9, 'SUP-009', 'UD Sinar Terang', 'sinar@sinarterang.example', '0351551009', 'Mojokerto', 'Jl. Majapahit No. 9', 0, '2026-10-14 08:00:00', NULL),
	(10, 'SUP-010', 'PT Cipta Sarana', 'info@ciptasarana.example', '0315551010', 'Gresik', 'Jl. Veteran No. 26', 1, '2026-10-14 08:00:00', NULL),
	(11, 'SUP-011', 'CV Berkah Teknik', 'berkah@berkahteknik.example', '0341551011', 'Pasuruan', 'Jl. Panglima Sudirman No. 14', 1, '2026-10-14 08:00:00', NULL),
	(12, 'SUP-012', 'PT Prima Office', 'sales@primaoffice.example', '0215551012', 'Jakarta', 'Jl. HR Rasuna Said No. 81', 1, '2026-10-14 08:00:00', NULL),
	(13, 'SUP-013', 'CV Arta Persada', 'admin@artapersada.example', '0315551013', 'Sidoarjo', 'Jl. Juanda No. 55', 1, '2026-10-14 08:00:00', NULL);

-- Dumping structure for table master_tailadmin.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_users_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table master_tailadmin.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `nama`, `email`, `password`, `created_at`) VALUES
	(1, 'Administrator', 'superadmin@gmail.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '2026-10-10 08:00:00'),
	(2, 'Operator Sistem', 'operator@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '2026-10-11 08:00:00'),
	(3, 'Manajer HRD', 'hrd@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '2026-10-12 08:00:00'),
	(4, 'Staf Keuangan', 'keuangan@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '2026-10-13 08:00:00'),
	(5, 'Supervisor Operasional', 'supervisor@example.com', '$2b$10$hkdBpIBGNBLHYhCbF9ffm.JXWQBJ5maOCSg/RFcbvkpqRWkAbFwRy', '2026-10-14 08:00:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
