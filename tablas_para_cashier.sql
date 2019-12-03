-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table fundasierra.payments_providers
DROP TABLE IF EXISTS `payments_providers`;
CREATE TABLE IF NOT EXISTS `payments_providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.payments_providers: ~0 rows (approximately)
/*!40000 ALTER TABLE `payments_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments_providers` ENABLE KEYS */;

-- Dumping structure for table fundasierra.stripes
DROP TABLE IF EXISTS `stripes`;
CREATE TABLE IF NOT EXISTS `stripes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `balance_transaction` varchar(250) DEFAULT NULL,
  `stripe_id` varchar(250) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `lastfour` varchar(50) DEFAULT NULL,
  `stripe_created` bigint(20) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `exp_year` varchar(50) DEFAULT NULL,
  `exp_month` varchar(50) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `funding` varchar(50) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table fundasierra.stripes: ~0 rows (approximately)
/*!40000 ALTER TABLE `stripes` DISABLE KEYS */;
/*!40000 ALTER TABLE `stripes` ENABLE KEYS */;

-- Dumping structure for table fundasierra.subscriptions
DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `stripe_id` varchar(50) NOT NULL,
  `stripe_plan` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_bt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_subscriptions_users` (`user_id`),
  CONSTRAINT `FK_subscriptions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.subscriptions: ~0 rows (approximately)
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;

-- Dumping structure for table fundasierra.transactions
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` varchar(50) NOT NULL,
  `payments_provider_id` int(10) unsigned NOT NULL,
  `stripe_id` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,
  `amount_less_commissions` decimal(10,2) unsigned NOT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_transactions_payments_providers` (`payments_provider_id`),
  KEY `FK_transactions_stripes` (`stripe_id`),
  CONSTRAINT `FK_transactions_payments_providers` FOREIGN KEY (`payments_provider_id`) REFERENCES `payments_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_transactions_stripes` FOREIGN KEY (`stripe_id`) REFERENCES `stripes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
