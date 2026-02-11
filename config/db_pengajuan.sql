-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2026 at 02:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengajuan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '$2y$10$n6q07Fv1XD1O3HShgRLLH.MhA58OiZ8hU.Xm0z4pwi5.HD4RJPcCW');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int(5) NOT NULL,
  `id_pelaporan` int(5) NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') DEFAULT 'Menunggu',
  `id_kategori` int(5) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `id_pelaporan`, `status`, `id_kategori`, `feedback`, `created_at`, `updated_at`) VALUES
(1, 2147483647, 'Menunggu', 10, NULL, '2026-01-15 07:55:59', '2026-01-15 07:55:59'),
(2, 71195, 'Proses', 10, NULL, '2026-01-17 06:41:28', '2026-01-20 00:32:19'),
(5, 40884, 'Selesai', 1, 'zsdxcfgvbhjnkmk', '2026-01-17 13:40:48', '2026-01-19 01:02:12'),
(8, 123, 'Menunggu', 10, NULL, '2026-01-18 03:00:31', '2026-01-18 03:00:31'),
(9, 99082, 'Proses', 2, NULL, '2026-01-19 01:28:21', '2026-02-05 01:16:56'),
(10, 82687, 'Selesai', 2, 'dalam proses ya', '2026-01-19 01:33:45', '2026-02-05 01:17:23'),
(11, 17604, 'Selesai', 2, NULL, '2026-01-23 03:06:26', '2026-02-04 02:24:50'),
(12, 71461, 'Proses', 2, 'oke bentar ya di carikan', '2026-01-26 01:36:21', '2026-01-26 01:37:18'),
(13, 48743, 'Selesai', 5, 'ekkkkkkkkkmskws', '2026-01-29 06:47:26', '2026-02-06 06:26:05'),
(15, 52096, 'Proses', 5, 'qppppppppqpppppp', '2026-02-05 06:05:43', '2026-02-06 02:52:16'),
(17, 17866, 'Selesai', 2, 'iya kakakjcjccdj', '2026-02-06 06:29:45', '2026-02-06 07:19:32'),
(18, 77939, 'Menunggu', 5, NULL, '2026-02-09 04:41:22', '2026-02-09 04:41:22'),
(21, 66400, 'Proses', 1, 'dwafdewtewgrf', '2026-02-09 05:52:24', '2026-02-09 05:58:12'),
(23, 36097, 'Proses', 2, 'scewcwdcewdwed', '2026-02-09 06:03:08', '2026-02-09 06:18:46'),
(25, 31359, 'Menunggu', 1, NULL, '2026-02-09 06:25:13', '2026-02-09 06:25:13'),
(26, 40767, 'Menunggu', 1, NULL, '2026-02-09 06:26:47', '2026-02-09 06:26:47'),
(27, 50755, 'Menunggu', 2, NULL, '2026-02-09 06:28:27', '2026-02-09 06:28:27'),
(28, 82625, 'Menunggu', 1, NULL, '2026-02-09 06:33:49', '2026-02-09 06:33:49'),
(29, 83075, 'Menunggu', 1, NULL, '2026-02-09 06:33:51', '2026-02-09 06:33:51'),
(30, 83150, 'Menunggu', 1, NULL, '2026-02-09 06:33:52', '2026-02-09 06:33:52'),
(31, 83258, 'Menunggu', 1, NULL, '2026-02-09 06:33:52', '2026-02-09 06:33:52'),
(32, 83215, 'Menunggu', 1, NULL, '2026-02-09 06:33:52', '2026-02-09 06:33:52'),
(33, 91125, 'Menunggu', 1, NULL, '2026-02-09 06:35:11', '2026-02-09 06:35:11'),
(34, 98096, 'Menunggu', 1, NULL, '2026-02-09 06:36:20', '2026-02-09 06:36:20'),
(35, 98064, 'Menunggu', 1, NULL, '2026-02-09 06:36:21', '2026-02-09 06:36:21'),
(36, 98152, 'Menunggu', 1, NULL, '2026-02-09 06:36:21', '2026-02-09 06:36:21'),
(37, 79445, 'Menunggu', 2, NULL, '2026-02-09 06:49:55', '2026-02-09 06:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id_audit` int(10) NOT NULL,
  `id_pelaporan` int(5) NOT NULL,
  `action_type` enum('status_change','feedback_added','feedback_updated','created') NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `admin_username` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id_audit`, `id_pelaporan`, `action_type`, `old_value`, `new_value`, `admin_username`, `created_at`) VALUES
(1, 2147483647, 'created', NULL, 'Aspirasi dibuat (migrasi data)', NULL, '2026-01-17 04:20:15'),
(3, 2147483647, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-01-17 04:29:29'),
(4, 71195, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-17 06:41:28'),
(7, 40884, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-17 13:40:48'),
(8, 40884, 'feedback_added', NULL, 'zsdxcfgvbhjnkmk', 'admin', '2026-01-17 13:42:00'),
(9, 40884, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-01-17 13:43:39'),
(12, 123, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-18 03:00:31'),
(13, 40884, 'status_change', 'Proses', 'Selesai', 'admin', '2026-01-19 01:02:11'),
(14, 40884, 'status_change', 'Selesai', 'Selesai', 'admin', '2026-01-19 01:02:12'),
(15, 99082, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-19 01:28:21'),
(16, 82687, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-19 01:33:45'),
(17, 82687, 'feedback_added', NULL, 'dalam proses ya', 'admin', '2026-01-19 01:34:11'),
(18, 82687, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-01-19 01:34:19'),
(19, 71195, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-01-20 00:32:19'),
(20, 82687, 'status_change', 'Proses', 'Selesai', 'admin', '2026-01-21 09:15:06'),
(21, 82687, 'status_change', 'Selesai', 'Proses', 'admin', '2026-01-21 09:21:25'),
(22, 17604, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-23 03:06:26'),
(23, 71461, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-26 01:36:21'),
(24, 71461, 'feedback_added', NULL, 'oke bentar ya di carikan', 'admin', '2026-01-26 01:37:02'),
(25, 71461, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-01-26 01:37:18'),
(26, 48743, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-01-29 06:47:26'),
(27, 48743, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-01-29 06:48:33'),
(28, 48743, 'feedback_added', NULL, 'hfgehjgferhgfher', 'admin', '2026-01-29 06:48:40'),
(29, 17604, 'status_change', 'Menunggu', 'Selesai', 'admin', '2026-02-04 02:24:50'),
(30, 99082, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-02-05 01:16:56'),
(31, 82687, 'status_change', 'Proses', 'Selesai', 'admin', '2026-02-05 01:17:23'),
(33, 52096, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-02-05 06:05:43'),
(37, 52096, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-02-06 02:10:45'),
(43, 52096, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-02-06 02:47:52'),
(44, 52096, 'feedback_updated', 'Third feedback - FINAL - 2026-02-06 03:42:42', 'iya jdjiwhfiewuhr', 'admin', '2026-02-06 02:48:03'),
(45, 52096, 'feedback_updated', 'iya jdjiwhfiewuhr', 'qppppppppqpppppp', 'admin', '2026-02-06 02:52:16'),
(50, 48743, 'status_change', 'Proses', 'Selesai', 'admin', '2026-02-06 06:25:50'),
(51, 48743, 'feedback_updated', 'hfgehjgferhgfher', 'ekkkkkkkkkmskws', 'admin', '2026-02-06 06:26:05'),
(52, 17866, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-02-06 06:29:45'),
(53, 17866, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-02-06 07:18:36'),
(54, 17866, 'status_change', 'Proses', 'Selesai', 'admin', '2026-02-06 07:19:13'),
(55, 17866, 'feedback_added', NULL, 'iya kakakjcjccdj', 'admin', '2026-02-06 07:19:32'),
(56, 77939, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-02-09 04:41:22'),
(61, 66400, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-02-09 05:52:24'),
(62, 66400, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-02-09 05:57:55'),
(63, 66400, 'feedback_added', NULL, 'dwafdewtewgrf', 'admin', '2026-02-09 05:58:12'),
(65, 36097, 'created', NULL, 'Aspirasi dibuat dengan status: Menunggu', NULL, '2026-02-09 06:03:08'),
(66, 36097, 'feedback_added', NULL, 'dfsfdsgrtgt', 'admin', '2026-02-09 06:03:46'),
(67, 36097, 'status_change', 'Menunggu', 'Proses', 'admin', '2026-02-09 06:03:52'),
(68, 36097, 'feedback_updated', 'dfsfdsgrtgt', 'scewcwdcewdwed', 'admin', '2026-02-09 06:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `id_pelaporan` int(5) NOT NULL,
  `nis` varchar(10) DEFAULT NULL,
  `id_kategori` int(5) DEFAULT NULL,
  `id_lokasi` int(5) NOT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Menunggu','Proses','Selesai') DEFAULT 'Menunggu',
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `id_lokasi`, `lokasi`, `ket`, `created_at`, `status`, `feedback`) VALUES
(123, '6543217654', 10, 16, 'ghjk', 'fghjk', '2026-01-18 03:00:31', 'Menunggu', NULL),
(17604, '1112223334', 2, 18, 'ruang a 1.1', 'kekurangan bangku sama meja 2 biji', '2026-01-23 03:06:26', 'Menunggu', NULL),
(17866, '7766884499', 2, 7, NULL, 'kekukmmskllk', '2026-02-06 06:29:45', 'Menunggu', NULL),
(31359, '1234567890', 1, 7, NULL, 'Simple test aspiration', '2026-02-09 06:25:13', 'Menunggu', NULL),
(36097, '4444455555', 2, 8, NULL, 'gvfcxdcbgfvc', '2026-02-09 06:03:08', 'Menunggu', NULL),
(40767, '1234567891', 1, 7, NULL, 'Test controller submission', '2026-02-09 06:26:47', 'Menunggu', NULL),
(40884, '987654321', 1, 19, 'werfregtr', 't4gr5gh54htbrfgb', '2026-01-17 13:40:48', 'Menunggu', NULL),
(48743, '1112223334', 5, 18, 'ruang a 1.1', 'ssdfghwdeuifhkerjhferjhf', '2026-01-29 06:47:26', 'Menunggu', NULL),
(50755, '1111122222', 2, 25, NULL, 'csdcwderwegtregte', '2026-02-09 06:28:27', 'Menunggu', NULL),
(52096, '9996662221', 5, 27, NULL, 'kehilangan bangku', '2026-02-05 06:05:43', 'Menunggu', NULL),
(66400, '3333344444', 1, 13, NULL, 'hreejthnfgvbhttfrfbg', '2026-02-09 05:52:24', 'Menunggu', NULL),
(71195, '0', 10, 20, 'Test Location', 'Test Description', '2026-01-17 06:41:28', 'Menunggu', NULL),
(71461, '6677889900', 2, 21, 'ruang f 2.2', 'kekurangan meja saja 2', '2026-01-26 01:36:21', 'Menunggu', NULL),
(77939, '987654321', 5, 8, NULL, 'ewhrejetjtrj', '2026-02-09 04:41:22', 'Menunggu', NULL),
(79445, '1111122222', 2, 20, NULL, 'fewfewfwer', '2026-02-09 06:49:55', 'Menunggu', NULL),
(82625, '1234567890', 1, 7, NULL, 'Aspiration number 1', '2026-02-09 06:33:49', 'Menunggu', NULL),
(82687, '6543217890', 2, 22, 'lab bcf', 'kekurangan kamera', '2026-01-19 01:33:45', 'Menunggu', NULL),
(83075, '1234567890', 1, 7, NULL, 'Aspiration number 2', '2026-02-09 06:33:51', 'Menunggu', NULL),
(83150, '1234567890', 1, 7, NULL, 'Aspiration number 3', '2026-02-09 06:33:52', 'Menunggu', NULL),
(83215, '1234567890', 1, 7, NULL, 'Aspiration number 5', '2026-02-09 06:33:52', 'Menunggu', NULL),
(83258, '1234567890', 1, 7, NULL, 'Aspiration number 4', '2026-02-09 06:33:52', 'Menunggu', NULL),
(91125, '5555555555', 1, 7, NULL, 'First complaint about library', '2026-02-09 06:35:11', 'Menunggu', NULL),
(98064, '7777777777', 1, 7, NULL, 'Test aspiration number 2', '2026-02-09 06:36:20', 'Menunggu', NULL),
(98096, '7777777777', 1, 7, NULL, 'Test aspiration number 1', '2026-02-09 06:36:20', 'Menunggu', NULL),
(98152, '7777777777', 1, 7, NULL, 'Test aspiration number 3', '2026-02-09 06:36:21', 'Menunggu', NULL),
(99082, '1212121313', 2, 23, 'lab a', 'kurang pc', '2026-01-19 01:28:21', 'Menunggu', NULL),
(2147483647, '1234567890', 10, 24, 'tyguhui', 'huhuhubhbhjbhjb', '2026-01-15 06:06:21', 'Selesai', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `ket_kategori` varchar(30) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`, `deskripsi`) VALUES
(1, 'Kerusakan Sarana', 'Kategori ini digunakan untuk mengelompokkan aspirasi siswa berdasarkan jenis permasalahan atau kebutuhan fasilitas sekolah.'),
(2, 'Kekurangan Sarana', 'Kategori ini digunakan untuk mengelompokkan aspirasi siswa berdasarkan jenis permasalahan atau kebutuhan fasilitas sekolah.'),
(3, 'Penggantian Sarana', 'Kategori ini digunakan untuk mengelompokkan aspirasi siswa berdasarkan jenis permasalahan atau kebutuhan fasilitas sekolah.'),
(5, 'Keamanan & Keselamatan', 'Kategori ini digunakan untuk mengelompokkan aspirasi siswa berdasarkan jenis permasalahan atau kebutuhan fasilitas sekolah.,'),
(10, 'Lain-lain', 'Kategori ini digunakan untuk mengelompokkan aspirasi siswa berdasarkan jenis permasalahan atau kebutuhan fasilitas sekolah.');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(5) NOT NULL,
  `nama_lokasi` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`, `deskripsi`, `created_at`) VALUES
(7, 'Perpustakaan', 'Perpustakaan sekolah', '2026-02-01 03:25:04'),
(8, 'Toilet Lantai 1', 'Toilet untuk siswa di lantai 1', '2026-02-01 03:25:04'),
(13, 'Parkiran Motor', 'Area parkir sepeda motor', '2026-02-01 03:25:04'),
(16, 'ghjk', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:44'),
(17, 'Ruang Kelas XII RPL 1', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:44'),
(18, 'ruang a 1.1', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(19, 'werfregtr', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(20, 'Test Location', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(21, 'ruang f 2.2', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(22, 'lab bcf', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(23, 'lab a', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(24, 'tyguhui', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(25, 'Tidak Diketahui', 'Lokasi fasilitas sekolah yang dapat menjadi objek aspirasi atau keluhan dari siswa terkait kondisi, kebutuhan, atau perbaikan yang diperlukan.', '2026-02-04 03:39:45'),
(27, 'Bengkel', 'bengkel untuk anak jurusan tkr atau tbsm melakukan praktek', '2026-02-05 03:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(10) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `kelas`, `created_at`) VALUES
('0', 'Unknown', '2026-01-17 06:47:22'),
('000000', 'XII RPL 1', '2026-01-17 06:45:41'),
('0987654321', '11 dkv', '2026-01-17 06:50:42'),
('1111122222', 'kuliner', '2026-02-09 05:49:36'),
('1112223334', '11 akl', '2026-01-23 03:06:26'),
('1119992', '10 kuliner', '2026-02-05 03:50:45'),
('1122334455', '12 pplg 2', '2026-02-06 06:05:41'),
('1212121313', '12 pplg 2', '2026-01-19 01:28:21'),
('1234567890', '11 dkv', '2026-01-17 06:45:41'),
('1234567891', 'XII RPL 1', '2026-02-09 06:26:47'),
('3333344444', 'dkv', '2026-02-09 05:52:24'),
('4444455555', '12 pplg 2', '2026-02-09 06:03:08'),
('5555555555', 'XII RPL 2', '2026-02-09 06:35:11'),
('6543217654', 'bgfd', '2026-01-18 03:00:31'),
('6543217890', '10 bcf', '2026-01-19 01:33:45'),
('6677889900', '12 akl', '2026-01-26 01:36:21'),
('7766884499', '11 akl', '2026-02-06 06:29:45'),
('7777777777', 'XII RPL 3', '2026-02-09 06:36:20'),
('987654321', '11 dkv', '2026-01-17 06:45:41'),
('9996662221', '12 tkr', '2026-02-05 06:05:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `idx_aspirasi_kategori` (`id_kategori`),
  ADD KEY `idx_aspirasi_status` (`status`),
  ADD KEY `fk_aspirasi_pelaporan` (`id_pelaporan`),
  ADD KEY `idx_aspirasi_created` (`created_at`),
  ADD KEY `idx_aspirasi_updated` (`updated_at`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id_audit`),
  ADD KEY `admin_username` (`admin_username`),
  ADD KEY `idx_audit_trail_pelaporan` (`id_pelaporan`),
  ADD KEY `idx_audit_trail_action` (`action_type`),
  ADD KEY `idx_audit_trail_created` (`created_at`);

--
-- Indexes for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD KEY `fk_input_siswa` (`nis`),
  ADD KEY `idx_input_aspirasi_kategori` (`id_kategori`),
  ADD KEY `idx_input_aspirasi_lokasi` (`id_lokasi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`),
  ADD UNIQUE KEY `nama_lokasi` (`nama_lokasi`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id_audit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `id_pelaporan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `fk_aspirasi_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `fk_aspirasi_pelaporan` FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`) ON DELETE CASCADE;

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`) ON DELETE CASCADE,
  ADD CONSTRAINT `audit_trail_ibfk_2` FOREIGN KEY (`admin_username`) REFERENCES `admin` (`username`) ON DELETE SET NULL;

--
-- Constraints for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD CONSTRAINT `fk_input_aspirasi_lokasi` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`),
  ADD CONSTRAINT `fk_input_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `fk_input_siswa` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
