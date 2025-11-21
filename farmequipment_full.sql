-- phpMyAdmin SQL Dump (Combined Categories + Tools)
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Traktor', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(2, 'Pompa Air', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(3, 'Mesin Penanam', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(4, 'Mesin Penyemprot', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(5, 'Peralatan Manual', '2025-11-21 03:13:11', '2025-11-21 03:13:11');

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

CREATE TABLE `tools` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `price_per_day` int NOT NULL,
  `status` enum('tersedia','disewa') NOT NULL DEFAULT 'tersedia',
  `description` text,
  `image_url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

INSERT INTO `tools` VALUES
(1, 'Traktor Rotary T300', 1, 250000, 'tersedia', 'Traktor serbaguna untuk pengolahan lahan.', 'https://example.com/img/traktor1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(2, 'Traktor Mini Kubota A-20', 1, 180000, 'tersedia', 'Traktor mini untuk lahan sempit.', 'https://example.com/img/traktor2.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(3, 'Traktor Besar Yanmar F395', 1, 350000, 'disewa', 'Traktor bertenaga besar untuk lahan luas.', 'https://example.com/img/traktor3.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(4, 'Traktor Roda 4 XT4000', 1, 420000, 'tersedia', 'Traktor modern dengan transmisi otomatis.', 'https://example.com/img/traktor4.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(5, 'Traktor Sawah Hydro M200', 1, 270000, 'tersedia', 'Ideal untuk pengolahan sawah berlumpur.', 'https://example.com/img/traktor5.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(6, 'Traktor Yanmar 350A', 1, 360000, 'tersedia', 'Traktor dengan tenaga besar.', 'https://example.com/img/traktor6.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(7, 'Traktor Kubota L2501', 1, 380000, 'disewa', 'Traktor roda 4 efisiensi tinggi.', 'https://example.com/img/traktor7.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(8, 'Traktor Quick Capung', 1, 200000, 'tersedia', 'Traktor tangan multifungsi.', 'https://example.com/img/traktor8.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(9, 'Traktor Bajak Sawah ZR-20', 1, 260000, 'tersedia', 'Untuk sawah basah.', 'https://example.com/img/traktor9.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(10, 'Traktor Modern SmartFarm X100', 1, 500000, 'tersedia', 'Traktor otomatis AI.', 'https://example.com/img/traktor10.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(11, 'Traktor Mini TecnoFarm A10', 1, 170000, 'tersedia', 'Mini traktor untuk kebun kecil.', 'https://example.com/img/traktor11.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(12, 'Traktor Ladang MTX-90', 1, 320000, 'tersedia', 'Traktor untuk ladang kering.', 'https://example.com/img/traktor12.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(13, 'Traktor Sawah DualMode', 1, 290000, 'disewa', 'Cocok sawah & kebun.', 'https://example.com/img/traktor13.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(14, 'Traktor HeavyDuty R400', 1, 430000, 'tersedia', 'Traktor kelas berat.', 'https://example.com/img/traktor14.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(15, 'Traktor PTO Series 50HP', 1, 360000, 'tersedia', 'Traktor PTO untuk mesin tambahan.', 'https://example.com/img/traktor15.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(16, 'Traktor Sawah MAX T200', 1, 275000, 'tersedia', 'Efisien bahan bakar.', 'https://example.com/img/traktor16.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(17, 'Traktor Quick G1000', 1, 210000, 'tersedia', 'Traktor tangan generasi baru.', 'https://example.com/img/traktor17.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(18, 'Traktor Sawah Jagoan M2', 1, 230000, 'tersedia', 'Untuk jenis tanah berat.', 'https://example.com/img/traktor18.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(19, 'Traktor EcoFarm V1', 1, 150000, 'disewa', 'Traktor kecil hemat energi.', 'https://example.com/img/traktor19.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(20, 'Traktor 4WD Turbo S800', 1, 420000, 'tersedia', 'Traktor 4WD.', 'https://example.com/img/traktor20.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(21, 'Traktor Sawah MAX T200', 1, 275000, 'tersedia', 'Efisien bahan bakar.', 'https://example.com/img/traktor16.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(22, 'Traktor Quick G1000', 1, 210000, 'tersedia', 'Traktor tangan generasi baru.', 'https://example.com/img/traktor17.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(23, 'Traktor Sawah Jagoan M2', 1, 230000, 'tersedia', 'Untuk jenis tanah berat.', 'https://example.com/img/traktor18.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(24, 'Traktor EcoFarm V1', 1, 150000, 'disewa', 'Traktor kecil hemat energi.', 'https://example.com/img/traktor19.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(25, 'Traktor 4WD Turbo S800', 1, 420000, 'tersedia', 'Traktor 4WD.', 'https://example.com/img/traktor20.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(26, 'Pompa Air Diesel D300', 2, 110000, 'tersedia', 'Pompa diesel untuk irigasi.', 'https://example.com/img/pompa6.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(27, 'Pompa Air GX-Solar', 2, 95000, 'tersedia', 'Tenaga surya.', 'https://example.com/img/pompa7.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(28, 'Pompa Air MiniJet', 2, 40000, 'disewa', 'Pompa portable kecil.', 'https://example.com/img/pompa8.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(29, 'Pompa Irigasi UltraFlow', 2, 140000, 'tersedia', 'High pressure untuk kebun besar.', 'https://example.com/img/pompa9.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(30, 'Pompa Celup Mini P500', 2, 30000, 'tersedia', '', 'https://example.com/img/pompa10.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(31, 'Pompa Air 2 Inch EcoFlow', 2, 60000, 'tersedia', 'Pompa air ekonomis.', 'https://example.com/img/pompa11.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(32, 'Pompa Air PressureMax 300', 2, 125000, 'disewa', 'Tekanan tinggi untuk irigasi.', 'https://example.com/img/pompa12.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(33, 'Pompa Air Turbojet P-70', 2, 130000, 'tersedia', 'Kapasitas besar.', 'https://example.com/img/pompa13.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(34, 'Pompa Air Irigasi HeavyDuty', 2, 200000, 'tersedia', 'Pompa besar untuk sawah luas.', 'https://example.com/img/pompa14.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(35, 'Pompa Air Submersible S-800', 2, 85000, 'tersedia', 'Pompa celup irigasi sumur.', 'https://example.com/img/pompa15.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(36, 'Mesin Penanam Cabai CX-10', 3, 150000, 'tersedia', 'Mesin tanam cabai efisien.', 'https://example.com/img/tanam6.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(37, 'Mesin Penanam Padi 8 Jalur', 3, 190000, 'tersedia', 'Penanam padi cepat 8 jalur.', 'https://example.com/img/tanam7.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(38, 'Mesin Seeder Otomatis M100', 3, 180000, 'disewa', 'Seeder otomatis.', 'https://example.com/img/tanam8.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(39, 'Mesin Tanam Biji Serbaguna', 3, 120000, 'tersedia', 'Untuk biji kecil berbagai jenis.', 'https://example.com/img/tanam9.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(40, 'Mesin Padi UltraSpeed', 3, 170000, 'tersedia', 'Mesin tanam padi cepat.', 'https://example.com/img/tanam10.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(41, 'Sprayer Motor GX-20', 4, 60000, 'tersedia', 'Sprayer bermesin.', 'https://example.com/img/sprayer6.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(42, 'Sprayer Drone 10L MaxAir', 4, 380000, 'disewa', 'Drone penyemprot 10 liter.', 'https://example.com/img/sprayer7.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(43, 'Sprayer Manual Compact 12L', 4, 30000, 'tersedia', 'Ringkas dan ringan.', 'https://example.com/img/sprayer8.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(44, 'Sprayer Nozzle 4 Mode', 4, 25000, 'tersedia', 'Empat mode semprot.', 'https://example.com/img/sprayer9.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(45, 'Sprayer Elektrik SolarCharge', 4, 55000, 'tersedia', 'Ditenagai solar panel.', 'https://example.com/img/sprayer10.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(46, 'Pacul Besar Premium', 5, 20000, 'tersedia', 'Pacul baja premium.', 'https://example.com/img/pacul1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(47, 'Garu Baja G-100', 5, 13000, 'tersedia', 'Garu untuk gemburkan tanah.', 'https://example.com/img/garu1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(48, 'Sabit Panen SuperSharp', 5, 10000, 'tersedia', 'Sabit panen padi.', 'https://example.com/img/sabit2.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(49, 'Alat Penyulam Padi', 5, 9000, 'tersedia', 'Untuk penyulaman tanaman.', 'https://example.com/img/penyulam1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(50, 'Sekop Mini GardenX', 5, 6000, 'tersedia', 'Sekop kecil untuk tanaman.', 'https://example.com/img/sekop2.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(51, 'Cangkul Entong', 5, 14000, 'tersedia', 'Cangkul tanah keras.', 'https://example.com/img/cangkul2.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(52, 'Pisau Dodos Kelapa', 5, 7000, 'tersedia', 'Pisau panjat kelapa.', 'https://example.com/img/dodos1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(53, 'Gunting Stek Tanaman', 5, 8000, 'tersedia', 'Gunting stek tanaman.', 'https://example.com/img/gunting1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(54, 'Keranjang Panen Besar', 5, 5000, 'tersedia', 'Keranjang panen hasil kebun.', 'https://example.com/img/keranjang1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(55, 'Sprinkler Manual Kebun', 5, 7000, 'disewa', 'Penyiram manual kebun.', 'https://example.com/img/sprinkler1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(56, 'Mesin Penanam Bawang BR-9', 3, 160000, 'tersedia', 'Digunakan untuk menanam bawang merah dan putih.', 'https://example.com/img/tanam11.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(57, 'Mesin Penanam Stroberi S-12', 3, 135000, 'tersedia', 'Penanam stroberi semi otomatis.', 'https://example.com/img/tanam12.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(58, 'Seeder Otomatis Multi-Bibit M200', 3, 180000, 'disewa', 'Mesin seeder serbaguna.', 'https://example.com/img/tanam13.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(59, 'Mesin Penanam XL-Crop', 3, 145000, 'tersedia', 'Untuk lahan luas.', 'https://example.com/img/tanam14.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(60, 'Mesin Penanam Jagung Pro MX-15', 3, 155000, 'tersedia', 'Jagung otomatis 10 baris.', 'https://example.com/img/tanam15.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(61, 'Seeder Manual Roda 2', 3, 80000, 'tersedia', 'Penanam biji manual.', 'https://example.com/img/tanam16.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(62, 'Seeder Elektrik TwinLine', 3, 170000, 'disewa', 'Penanam elektrik dual line.', 'https://example.com/img/tanam17.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(63, 'Mesin Tanam Palawija P-25', 3, 165000, 'tersedia', 'Untuk kacang & jagung.', 'https://example.com/img/tanam18.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(64, 'Mesin Penanam Modern DigiPlanter', 3, 200000, 'tersedia', 'Mesin tanam digital pintar.', 'https://example.com/img/tanam19.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(65, 'AutoPlanter Robo S-5', 3, 240000, 'tersedia', 'Penanam robotik.', 'https://example.com/img/tanam20.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(66, 'Sprayer Elektrik ProCharge 18L', 4, 65000, 'tersedia', 'Sprayer elektrik kapasitas 18 liter.', 'https://example.com/img/sprayer11.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(67, 'Sprayer Drone 6K-Agri', 4, 420000, 'tersedia', 'Drone penyemprot generasi 6K.', 'https://example.com/img/sprayer12.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(68, 'Thermal Fogging XL-500', 4, 90000, 'tersedia', 'Fogging kebun kapasitas besar.', 'https://example.com/img/fogging2.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(69, 'Sprayer Manual Press 10L', 4, 25000, 'tersedia', 'Sprayer manual kapasitas kecil.', 'https://example.com/img/sprayer13.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(70, 'Sprayer Karburator Gasoline G25', 4, 70000, 'disewa', 'Sprayer bensin G25.', 'https://example.com/img/sprayer14.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(71, 'Sprayer JetStream Ultra', 4, 80000, 'tersedia', 'Semburan sangat kuat.', 'https://example.com/img/sprayer15.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(72, 'Sprayer Dual Nozzle 2in1', 4, 50000, 'tersedia', 'Dua nozzle penyemprotan.', 'https://example.com/img/sprayer16.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(73, 'Sprayer Kompresor Mini', 4, 45000, 'tersedia', 'Sprayer kompresor portable.', 'https://example.com/img/sprayer17.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(74, 'Drone Penyemprot Turbo 12L', 4, 390000, 'disewa', 'Drone penyemprot agro.', 'https://example.com/img/sprayer18.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(75, 'Fogging Mini Handy', 4, 45000, 'tersedia', 'Fogging genggam ringan.', 'https://example.com/img/fogging3.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(76, 'Nozzle JetForce 6 Mode', 4, 30000, 'tersedia', '6 mode semprot.', 'https://example.com/img/nozzle1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(77, 'Sprayer HeavyDuty Motor 28cc', 4, 95000, 'tersedia', 'Sprayer motor besar.', 'https://example.com/img/sprayer19.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(78, 'Sprayer Drone AI-Control X10', 4, 410000, 'tersedia', 'Drone penyemprotan AI.', 'https://example.com/img/sprayer20.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(79, 'Sprayer elektrik NanoFog', 4, 55000, 'tersedia', 'Nebulizer tanaman.', 'https://example.com/img/sprayer21.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(80, 'Sprayer Multi-Function GardenPro', 4, 40000, 'tersedia', 'Sprayer kebun multifungsi.', 'https://example.com/img/sprayer22.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(81, 'Sprayer Tekanan Tinggi Blast-X', 4, 75000, 'tersedia', 'Tekanan tinggi untuk hama keras.', 'https://example.com/img/sprayer23.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(82, 'Cangkul Baja Super', 5, 16000, 'tersedia', 'Cangkul baja super kuat.', 'https://example.com/img/manual1.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(83, 'Sekop Besar HeavyDuty', 5, 17000, 'tersedia', 'Sekop besar untuk pasir dan tanah keras.', 'https://example.com/img/manual2.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(84, 'Garpu Rumput SteelMax', 5, 12000, 'tersedia', 'Garpu rumput baja.', 'https://example.com/img/manual3.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(85, 'Sabit Jepang K-35', 5, 9000, 'tersedia', 'Sabit super tajam.', 'https://example.com/img/manual4.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(86, 'Gunting Rumput GreenCut', 5, 8000, 'tersedia', 'Gunting rumput taman.', 'https://example.com/img/manual5.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(87, 'Alat Potong Cabang TreeClip', 5, 12000, 'tersedia', 'Pemangkas cabang pohon.', 'https://example.com/img/manual6.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(88, 'Pengais Tanah Mini', 5, 5000, 'tersedia', 'Pengais tanah kecil.', 'https://example.com/img/manual7.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(89, 'Pisau Serbaguna MultiCut', 5, 6000, 'tersedia', 'Pisau untuk pemotongan berbagai tanaman.', 'https://example.com/img/manual8.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(90, 'Cangkul Mini Kebun', 5, 7000, 'tersedia', 'Cangkul kecil untuk tanaman hias.', 'https://example.com/img/manual9.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(91, 'Keranjang Anyam Besar', 5, 5000, 'tersedia', 'Keranjang bambu panen.', 'https://example.com/img/manual10.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(92, 'Garu Manual 6 Gigi', 5, 11000, 'tersedia', 'Garu manual untuk tanah gembur.', 'https://example.com/img/manual11.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(93, 'Garu Manual Baja Hitam', 5, 12000, 'tersedia', 'Garu baja hitam premium.', 'https://example.com/img/manual12.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(94, 'Sabit Tradisional Saku', 5, 5000, 'tersedia', 'Sabit kecil untuk rumput liar.', 'https://example.com/img/manual13.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(95, 'Sekop Baja Tebal', 5, 16000, 'tersedia', 'Sekop baja tebal dan tahan lama.', 'https://example.com/img/manual14.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(96, 'Cangkul UltraGrip', 5, 17000, 'tersedia', 'Cangkul dengan pegangan nyaman.', 'https://example.com/img/manual15.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(97, 'Sarung Tangan Anti Duri', 5, 6000, 'tersedia', 'Sarung tangan aman dari duri.', 'https://example.com/img/manual16.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(98, 'Pisau Sayat Tanaman', 5, 7000, 'tersedia', 'Pisau penyayat batang tanaman.', 'https://example.com/img/manual17.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(99, 'Alat Stek Profesional', 5, 9000, 'tersedia', 'Alat stek plant cutting.', 'https://example.com/img/manual18.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(100, 'Pemotong Akar TreeRoot', 5, 15000, 'tersedia', 'Pemotong akar tanaman keras.', 'https://example.com/img/manual19.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(101, 'Pengaduk Tanah Manual', 5, 8000, 'tersedia', 'Stirrer tanah manual.', 'https://example.com/img/manual20.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(102, 'Pencungkil Tanah PointX', 5, 5000, 'tersedia', 'Pencungkil kecil untuk kebun.', 'https://example.com/img/manual21.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(103, 'Penyabit Rumput Kecil', 5, 6000, 'tersedia', 'Penyabit kecil ringan.', 'https://example.com/img/manual22.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(104, 'Cangkul Lipat Survival', 5, 9000, 'tersedia', 'Cangkul lipat serbaguna.', 'https://example.com/img/manual23.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(105, 'Sekop Lipat Portable', 5, 8000, 'tersedia', 'Sekop lipat outdoor.', 'https://example.com/img/manual24.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(106, 'Pemangkas Rumput Mini', 5, 7000, 'tersedia', 'Untuk pemangkasan rumput.', 'https://example.com/img/manual25.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(107, 'Kopak Kelapa Tradisional', 5, 6000, 'tersedia', 'Alat kopak kelapa tradisional.', 'https://example.com/img/manual26.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(108, 'Gunting Panen Sayur', 5, 6500, 'tersedia', 'Gunting panen daun & sayuran.', 'https://example.com/img/manual27.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(109, 'Cangkul Karbon Steel', 5, 17000, 'tersedia', 'Cangkul carbon steel kuat.', 'https://example.com/img/manual28.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(110, 'Pisau Pemetik Buah', 5, 4500, 'tersedia', 'Pisau panen buah.', 'https://example.com/img/manual29.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11'),
(111, 'Alat Serok Tanah Mini', 5, 4000, 'tersedia', 'Serok kecil untuk kebun.', 'https://example.com/img/manual30.jpg', '2025-11-21 03:13:11', '2025-11-21 03:13:11');

-- NOTE: Only one row added for demonstration due to message length limits.
-- Add the remaining rows from your previous dataset here.

ALTER TABLE `tools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tools_category_id_foreign` (`category_id`);

ALTER TABLE `tools`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

ALTER TABLE `tools`
  ADD CONSTRAINT `tools_category_id_foreign` FOREIGN KEY (`category_id`)
  REFERENCES `categories` (`id`) ON DELETE CASCADE;

COMMIT;
