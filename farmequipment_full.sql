-- Membuat database
CREATE DATABASE IF NOT EXISTS `alatdb`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `alatdb`;

CREATE TABLE IF NOT EXISTS `tools` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price_per_day` int NOT NULL,
  `status` enum('tersedia','disewa') NOT NULL DEFAULT 'tersedia',
  `description` text,
  `image_url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

