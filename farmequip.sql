-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 27, 2025 at 02:32 PM
-- Server version: 8.0.44
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmequip`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat_pertanian`
--

CREATE TABLE `alat_pertanian` (
  `id` int NOT NULL,
  `nama_alat` varchar(150) NOT NULL,
  `kategori_id` int NOT NULL,
  `deskripsi` text,
  `harga_per_hari` int NOT NULL,
  `harga_per_minggu` int NOT NULL,
  `harga_per_bulan` int NOT NULL,
  `gambar` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alat_pertanian`
--

INSERT INTO `alat_pertanian` (`id`, `nama_alat`, `kategori_id`, `deskripsi`, `harga_per_hari`, `harga_per_minggu`, `harga_per_bulan`, `gambar`) VALUES
(1, 'Traktor Kubota L5018', 1, 'Traktor serbaguna untuk lahan sedang hingga besar', 350000, 2000000, 7500000, NULL),
(2, 'Traktor Mini Yanmar EF393T', 1, 'Traktor kecil untuk lahan sempit dan kebun', 250000, 1500000, 5500000, NULL),
(3, 'Hand Sprayer 16L Manual', 2, 'Penyemprot manual kapasitas 16 liter', 30000, 150000, 500000, NULL),
(4, 'Hand Sprayer Elektrik 20L', 2, 'Sprayer elektrik hemat tenaga kapasitas 20 liter', 50000, 250000, 850000, NULL),
(5, 'Mesin Panen Padi Yanmar', 3, 'Mini combine harvester untuk padi', 500000, 3000000, 10000000, NULL),
(6, 'Mini Combine Kubota DC-35', 3, 'Mesin pemanen ideal untuk lahan 1–2 hektar', 600000, 3500000, 12000000, NULL),
(7, 'Pompa Air Irigasi Honda GP160', 4, 'Pompa air untuk kebutuhan irigasi lahan kecil–menengah', 80000, 450000, 1600000, NULL),
(8, 'Selang Irigasi 50 meter', 4, 'Selang irigasi serbaguna untuk berbagai kondisi lahan', 20000, 100000, 350000, NULL),
(9, 'Traktor Tangan', 1, 'Alat untuk membajak dan mengolah tanah pada lahan pertanian skala kecil hingga menengah.', 150000, 900000, 3500000, NULL),
(10, 'Mesin Pompa Air', 2, 'Digunakan untuk mengairi sawah dan mengalirkan air ke lahan pertanian.', 50000, 300000, 1200000, NULL),
(11, 'Cultivator Mini', 1, 'Alat pengolah tanah portabel untuk kebun dan lahan kecil.', 80000, 500000, 2000000, NULL),
(12, 'Sprayer Elektrik 16L', 3, 'Penyemprot hama berbasis baterai dengan kapasitas 16 liter.', 30000, 180000, 700000, NULL),
(13, 'Mesin Perontok Padi', 4, 'Mesin untuk merontokkan bulir padi dari jerami, mempercepat proses panen.', 120000, 750000, 2800000, NULL),
(14, 'Gergaji Mesin (Chainsaw)', 2, 'Digunakan untuk pemotongan kayu di kebun atau lahan pertanian.', 60000, 360000, 1400000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `slug`, `deskripsi`) VALUES
(1, 'Traktor', 'traktor', 'Alat berat untuk membajak dan mengolah tanah'),
(2, 'Hand Sprayer', 'hand-sprayer', 'Alat penyemprot manual untuk pupuk dan pestisida'),
(3, 'Mesin Panen', 'mesin-panen', 'Mesin untuk memanen hasil pertanian'),
(4, 'Irigasi', 'irigasi', 'Peralatan pendukung sistem pengairan lahan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat_pertanian`
--
ALTER TABLE `alat_pertanian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat_pertanian`
--
ALTER TABLE `alat_pertanian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alat_pertanian`
--
ALTER TABLE `alat_pertanian`
  ADD CONSTRAINT `alat_pertanian_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
