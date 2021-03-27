-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.47-MariaDB-0ubuntu0.18.04.1 - Ubuntu 18.04
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for timo_delivery
DROP DATABASE IF EXISTS `timo_delivery`;
CREATE DATABASE IF NOT EXISTS `timo_delivery` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `timo_delivery`;

-- Dumping structure for table timo_delivery.company_settings
DROP TABLE IF EXISTS `company_settings`;
CREATE TABLE IF NOT EXISTS `company_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timocom_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table timo_delivery.company_settings: ~3 rows (approximately)
/*!40000 ALTER TABLE `company_settings` DISABLE KEYS */;
INSERT INTO `company_settings` (`id`, `timocom_id`, `name`, `contact_person`, `phone`, `email`, `created_at`, `updated_at`) VALUES
	(1, 12345, '1111111', '11111', '121212121212', '111@111.com', '2021-03-08 23:08:20', '2021-03-08 23:08:20'),
	(2, 12345, '1111111', '11111', '121212121212', '111@111.com', '2021-03-25 15:30:02', '2021-03-25 15:30:02'),
	(3, 12345, '1111111', '11111', '121212121212', '111@111.com', '2021-03-25 15:34:13', '2021-03-25 15:34:13');
/*!40000 ALTER TABLE `company_settings` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.coockies
DROP TABLE IF EXISTS `coockies`;
CREATE TABLE IF NOT EXISTS `coockies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_key` varchar(50) NOT NULL DEFAULT '0',
  `coockie` text NOT NULL,
  `hash` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `auth_key` (`auth_key`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table timo_delivery.coockies: ~0 rows (approximately)
/*!40000 ALTER TABLE `coockies` DISABLE KEYS */;
/*!40000 ALTER TABLE `coockies` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table timo_delivery.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.letter_templates
DROP TABLE IF EXISTS `letter_templates`;
CREATE TABLE IF NOT EXISTS `letter_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table timo_delivery.letter_templates: ~0 rows (approximately)
/*!40000 ALTER TABLE `letter_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `letter_templates` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table timo_delivery.migrations: ~3 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table timo_delivery.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.search_result
DROP TABLE IF EXISTS `search_result`;
CREATE TABLE IF NOT EXISTS `search_result` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table timo_delivery.search_result: ~0 rows (approximately)
/*!40000 ALTER TABLE `search_result` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_result` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.tasks
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `from` text NOT NULL,
  `to` text NOT NULL,
  `freight` text NOT NULL,
  `date` text NOT NULL,
  `truck_position` text NOT NULL,
  `exchange` tinyint(1) NOT NULL DEFAULT '0',
  `min_price` smallint(6) NOT NULL DEFAULT '0',
  `min_price_letter` int(11) DEFAULT NULL,
  `overweight` text,
  `extra_price` tinyint(2) NOT NULL DEFAULT '0',
  `extra_active` tinyint(1) NOT NULL DEFAULT '0',
  `stop_words` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table timo_delivery.tasks: ~0 rows (approximately)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Dumping structure for table timo_delivery.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table timo_delivery.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Sergey', 'triongroup@gmail.com', NULL, '$2y$10$qTvXS1uja8BZKp2J9oQ58O3gzAbS9Pl0WPLMdjp6V6YMMlYi9qS8C', NULL, '2021-03-08 22:09:57', '2021-03-08 22:09:57'),
	(2, 'Timokom', 'Timokom@mail.com', NULL, '$2y$10$JrAtUAr.g6GQLi4nc9wsSO.7rnehL90aNdAE0t88atDpWuPcaAO02', NULL, '2021-03-13 19:29:54', '2021-03-13 19:29:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
