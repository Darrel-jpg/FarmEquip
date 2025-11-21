SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `tools` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price_per_day` int NOT NULL,
  `status` enum('tersedia','disewa') NOT NULL DEFAULT 'tersedia',
  `description` text,
  `image_url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tools`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tools`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
  
COMMIT;
