-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2026 at 03:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_remedi_pbo_ti1c-geryputrasetiawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_reservasi`
--

CREATE TABLE `tabel_reservasi` (
  `id_reservasi` varchar(10) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `durasi_jam` int(11) NOT NULL,
  `tarif_dasar_per_jam` decimal(10,2) NOT NULL,
  `jenis_paket` enum('Reguler','Premium','Event') NOT NULL,
  `tipe_background` varchar(50) DEFAULT NULL,
  `cetak_foto_lembar` int(11) DEFAULT NULL,
  `kuota_talent_orang` int(11) DEFAULT NULL,
  `layanan_makeup` tinyint(1) DEFAULT NULL,
  `nama_lokasi_luar` varchar(100) DEFAULT NULL,
  `biaya_transportasi_tim` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_reservasi`
--

INSERT INTO `tabel_reservasi` (`id_reservasi`, `nama_pelanggan`, `tanggal_booking`, `durasi_jam`, `tarif_dasar_per_jam`, `jenis_paket`, `tipe_background`, `cetak_foto_lembar`, `kuota_talent_orang`, `layanan_makeup`, `nama_lokasi_luar`, `biaya_transportasi_tim`) VALUES
('RES-001', 'Budi Santoso', '2026-08-01', 2, 150000.00, 'Reguler', 'Polos Putih', 2, NULL, NULL, NULL, NULL),
('RES-002', 'Siti Aminah', '2026-08-01', 1, 150000.00, 'Reguler', 'Estetik Kayu', 0, NULL, NULL, NULL, NULL),
('RES-003', 'Ahmad Fauzi', '2026-08-02', 2, 150000.00, 'Reguler', 'Polos Hitam', 4, NULL, NULL, NULL, NULL),
('RES-004', 'Rina Wijaya', '2026-08-02', 3, 150000.00, 'Reguler', 'Gradasi Biru', 2, NULL, NULL, NULL, NULL),
('RES-005', 'Dewi Lestari', '2026-08-03', 2, 150000.00, 'Reguler', 'Polos Abu', 5, NULL, NULL, NULL, NULL),
('RES-006', 'Eko Prasetyo', '2026-08-03', 1, 150000.00, 'Reguler', 'Tema Natal', 2, NULL, NULL, NULL, NULL),
('RES-007', 'Andi Wijaya', '2026-08-04', 2, 150000.00, 'Reguler', 'Polos Putih', 1, NULL, NULL, NULL, NULL),
('RES-008', 'Citra Kirana', '2026-08-01', 3, 300000.00, 'Premium', 'Tema Klasik', 10, NULL, 1, NULL, NULL),
('RES-009', 'Dodi Hermawan', '2026-08-02', 4, 300000.00, 'Premium', 'Modern Minimalis', 15, NULL, 1, NULL, NULL),
('RES-010', 'Elen Kartika', '2026-08-03', 2, 300000.00, 'Premium', 'Vintage Kafe', 8, NULL, 0, NULL, NULL),
('RES-011', 'Fajar Nugroho', '2026-08-04', 3, 300000.00, 'Premium', 'Polos Mewah', 12, NULL, 1, NULL, NULL),
('RES-012', 'Giska Putri', '2026-08-05', 2, 300000.00, 'Premium', 'Neon Pop', 6, NULL, 0, NULL, NULL),
('RES-013', 'Hendi Pratama', '2026-08-05', 4, 300000.00, 'Premium', 'Tema Taman', 20, NULL, 1, NULL, NULL),
('RES-014', 'Indah Permata', '2026-08-06', 3, 300000.00, 'Premium', 'Polos Hitam', 10, NULL, 1, NULL, NULL),
('RES-015', 'Joko Susilo', '2026-08-10', 6, 750000.00, 'Event', NULL, NULL, 5, NULL, 'Gedung Agung', 500000.00),
('RES-016', 'Kiki Amelia', '2026-08-12', 8, 750000.00, 'Event', NULL, NULL, 10, NULL, 'Pantai Indah', 750000.00),
('RES-017', 'Lutfi Hakim', '2026-08-15', 5, 700000.00, 'Event', NULL, NULL, 3, NULL, 'Hutan Pinus', 400000.00),
('RES-018', 'Mega Utami', '2026-08-18', 7, 750000.00, 'Event', NULL, NULL, 8, NULL, 'Hotel Mulia', 300000.00),
('RES-019', 'Novianti', '2026-08-20', 10, 800000.00, 'Event', NULL, NULL, 12, NULL, 'Aula Serbaguna', 200000.00),
('RES-020', 'Oki Lukman', '2026-08-22', 6, 750000.00, 'Event', NULL, NULL, 4, NULL, 'Resto Kebon', 350000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_reservasi`
--
ALTER TABLE `tabel_reservasi`
  ADD PRIMARY KEY (`id_reservasi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
