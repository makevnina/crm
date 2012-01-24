# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.15
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2012-01-24 20:56:05
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for crm
DROP DATABASE IF EXISTS `crm`;
CREATE DATABASE IF NOT EXISTS `crm` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `crm`;


# Dumping structure for table crm.clients
DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `surname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `father` varchar(50) CHARACTER SET utf8 NOT NULL,
  `position` varchar(50) CHARACTER SET utf8 NOT NULL,
  `address` varchar(150) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# Data exporting was unselected.


# Dumping structure for table crm.companies
DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `activity` varchar(100) CHARACTER SET utf8 NOT NULL,
  `address` varchar(150) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# Data exporting was unselected.


# Dumping structure for table crm.emails
DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `artifact_id` int(10) unsigned NOT NULL,
  `artifact_type` enum('client','company') NOT NULL,
  `address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table crm.phones
DROP TABLE IF EXISTS `phones`;
CREATE TABLE IF NOT EXISTS `phones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `artifact_id` int(10) unsigned NOT NULL,
  `artifact_type` enum('client','company') NOT NULL,
  `number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table crm.projects
DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `artifact_id` int(10) unsigned NOT NULL,
  `artifact_type` enum('client','company') NOT NULL,
  `start_date` date NOT NULL,
  `plan_date` date NOT NULL,
  `fact_date` date NOT NULL,
  `state` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table crm.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `father` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
