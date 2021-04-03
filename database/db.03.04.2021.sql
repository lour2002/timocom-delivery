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

-- Dumping structure for table timo_delivery.tasks
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(150) NOT NULL,
  `status_job` tinyint(1) NOT NULL DEFAULT '0',
  `version_task` int(11) NOT NULL DEFAULT '1',
  `fromSelectOpt` varchar(250) NOT NULL,
  `as_country` varchar(100) NOT NULL,
  `as_zip` varchar(10) NOT NULL,
  `as_radius` int(11) NOT NULL DEFAULT '0',
  `toSelectOpt` varchar(250) NOT NULL,
  `toSelectOptArray` text NOT NULL,
  `freightSelectOpt` varchar(250) NOT NULL,
  `length_min` varchar(50) NOT NULL,
  `length_max` varchar(50) NOT NULL,
  `weight_min` varchar(50) NOT NULL,
  `weight_max` varchar(50) NOT NULL,
  `dateSelectOpt` varchar(250) NOT NULL,
  `individual_days` date NOT NULL,
  `period_start` date NOT NULL,
  `period_stop` date NOT NULL,
  `car_country` varchar(100) NOT NULL DEFAULT '',
  `car_zip` varchar(10) NOT NULL DEFAULT '',
  `car_city` varchar(100) NOT NULL DEFAULT '',
  `car_price_empty` double(10,2) NOT NULL DEFAULT '0.00',
  `car_price` double(10,2) NOT NULL DEFAULT '0.00',
  `car_price_extra_points` double(10,2) NOT NULL DEFAULT '0.00',
  `exchange_equipment` tinyint(1) NOT NULL DEFAULT '0',
  `minimal_price_order` double(10,2) NOT NULL DEFAULT '0.00',
  `percent_stop_value` int(11) NOT NULL DEFAULT '0',
  `tags` text NOT NULL,
  `email_template` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_job` (`status_job`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table timo_delivery.tasks: ~0 rows (approximately)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
