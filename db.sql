-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for fundasierra
DROP DATABASE IF EXISTS `fundasierra`;
CREATE DATABASE IF NOT EXISTS `fundasierra` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `fundasierra`;

-- Dumping structure for table fundasierra.authors
DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `imagen` varchar(191) DEFAULT NULL,
  `thumbnail` varchar(191) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.authors: ~4 rows (approximately)
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` (`id`, `name`, `imagen`, `thumbnail`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'USAID', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'GLASSWING', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'NUEVO TEST12', 'public/redactores/3/3_1.png', 'public/redactores/3/th_3_1.png', 1, '2018-09-18 11:33:16', '2018-09-18 13:06:47', NULL, 1, 1, NULL),
	(4, 'MARIANO PAZ FLORES', 'public/redactores/4/4.png', 'public/redactores/4/th_4.png', 1, '2018-09-18 13:07:04', '2018-09-18 13:09:35', NULL, 1, 1, NULL);
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;

-- Dumping structure for table fundasierra.authors_posts
DROP TABLE IF EXISTS `authors_posts`;
CREATE TABLE IF NOT EXISTS `authors_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned DEFAULT NULL,
  `author_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_authors_posts_posts` (`post_id`),
  KEY `FK_authors_posts_authors` (`author_id`),
  CONSTRAINT `FK_authors_posts_authors` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_authors_posts_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.authors_posts: ~2 rows (approximately)
/*!40000 ALTER TABLE `authors_posts` DISABLE KEYS */;
INSERT INTO `authors_posts` (`id`, `post_id`, `author_id`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(4, 20, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 20, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `authors_posts` ENABLE KEYS */;

-- Dumping structure for table fundasierra.cities
DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria. Identificador único',
  `state_id` int(10) unsigned NOT NULL COMMENT 'Departamento o provincia',
  `name` varchar(250) NOT NULL COMMENT 'Definición de ciudad',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o Inactivo',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de creación',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de modificación',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'Usuario que crea el registro',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Usuario que modifica el registro',
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ciudades_departamentos` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=277 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Ciudades de los departamentos';

-- Dumping data for table fundasierra.cities: ~276 rows (approximately)
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (`id`, `state_id`, `name`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 1, 'Apaneca', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(2, 1, 'Atiquizaya', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(3, 1, 'Concepción de Ataco', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(4, 1, 'El Refugio', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(5, 1, 'Guaymango', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(6, 1, 'Jujutla', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(7, 1, 'San Francisco Menéndez', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(8, 1, 'San Lorenzo', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(9, 1, 'San Pedro Puxtla', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(10, 1, 'Tacuba', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(11, 1, 'Turín', 1, '2015-06-06 16:07:17', '2015-06-06 16:07:17', NULL, 1, 1, NULL),
	(12, 2, 'Acajutla', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(13, 2, 'Armenia', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(14, 2, 'Caluco', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(15, 2, 'Cuisnahuat', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(16, 2, 'Izalco', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(17, 2, 'Juayúa', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(18, 2, 'Nahuizalco', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(19, 2, 'Nahulingo', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(20, 2, 'Salcoatitán', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(21, 2, 'San Antonio del Monte', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(22, 2, 'San Julián', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(23, 2, 'Santa Catarina Masahuat', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(24, 2, 'Santa Isabel Ishuatán', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(25, 2, 'Santo Domingo de Guzmán', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(26, 2, 'Sonsonate', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(27, 2, 'Sonzacate', 1, '2015-06-06 16:13:08', '2015-06-06 16:13:08', NULL, 1, 1, NULL),
	(28, 3, 'Candelaria de la Frontera', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(29, 3, 'Chalchuapa', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(30, 3, 'Coatepeque', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(31, 3, 'El Congo', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(32, 3, 'El Porvenir', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(33, 3, 'Masahuat', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(34, 3, 'Metapán', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(35, 3, 'San Antonio Pajonal', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(36, 3, 'San Sebastián Salitrillo', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(37, 3, 'Santa Ana', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(38, 3, 'Santa Rosa Guachipilín', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(39, 3, 'Santiago de la Frontera', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(40, 3, 'Texistepeque', 1, '2015-06-06 16:15:38', '2015-06-06 16:15:38', NULL, 1, 1, NULL),
	(41, 4, 'Cinquera', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(42, 4, 'Dolores / Villa Dolores', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(43, 4, 'Guacotecti', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(44, 4, 'Ilobasco', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(45, 4, 'Jutiapa', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(46, 4, 'San Isidro', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(47, 4, 'Sensuntepeque', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(48, 4, 'Tejutepeque', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(49, 4, 'Victoria', 1, '2015-06-06 16:16:59', '2015-06-06 16:16:59', NULL, 1, 1, NULL),
	(50, 5, 'Agua Caliente', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(51, 5, 'Arcatao', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(52, 5, 'Azacualpa', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(53, 5, 'Chalatenango', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(54, 5, 'Citalá', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(55, 5, 'Comalapa', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(56, 5, 'Concepción Quezaltepeque', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(57, 5, 'Dulce Nombre de María', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(58, 5, 'El Carrizal', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(59, 5, 'El Paraíso', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(60, 5, 'La Laguna', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(61, 5, 'La Palma', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(62, 5, 'La Reina', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(63, 5, 'Las Vueltas', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(64, 5, 'Nombre de Jesús', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(65, 5, 'Nueva Concepción', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(66, 5, 'Nueva Trinidad', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(67, 5, 'Ojos de Agua', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(68, 5, 'Potonico', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(69, 5, 'San Antonio de la Cruz', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(70, 5, 'San Antonio Los Ranchos', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(71, 5, 'San Fernando', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(72, 5, 'San Francisco Lempa', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(73, 5, 'San Francisco Morazán', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(74, 5, 'San Ignacio', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(75, 5, 'San Isidro Labrador', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(76, 5, 'San José Cancasque / Cancasque', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(77, 5, 'San José Las Flores / Las Flores', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(78, 5, 'San Luis del Carmen', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(79, 5, 'San Miguel de Mercedes', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(80, 5, 'San Rafael', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(81, 5, 'Santa Rita', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(82, 5, 'Tejutla', 1, '2015-06-06 16:18:24', '2015-06-06 16:18:24', NULL, 1, 1, NULL),
	(83, 6, 'Candelaria', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(84, 6, 'Cojutepeque', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(85, 6, 'El Carmen', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(86, 6, 'El Rosario', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(87, 6, 'Monte San Juan', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(88, 6, 'Oratorio de Concepción', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(89, 6, 'San Bartolomé Perulapía', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(90, 6, 'San Cristóbal', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(91, 6, 'San José Guayabal', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(92, 6, 'San Pedro Perulapán', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(93, 6, 'San Rafael Cedros', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(94, 6, 'San Ramón', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(95, 6, 'Santa Cruz Analquito', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(96, 6, 'Santa Cruz Michapa', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(97, 6, 'Suchitoto', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(98, 6, 'Tenancingo', 1, '2015-06-06 16:21:10', '2015-06-06 16:21:10', NULL, 1, 1, NULL),
	(99, 7, 'Antiguo Cuscatlán', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(100, 7, 'Chiltiupán', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(101, 7, 'Ciudad Arce', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(102, 7, 'Colón', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(103, 7, 'Comasagua', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(104, 7, 'Huizúcar', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(105, 7, 'Jayaque', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(106, 7, 'Jicalapa', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(107, 7, 'La Libertad', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(108, 7, 'Santa Tecla', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(109, 7, 'Nueva San Salvador', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(110, 7, 'Nuevo Cuscatlán', 1, '2015-06-06 16:22:20', '2015-06-06 16:22:20', NULL, 1, 1, NULL),
	(111, 7, 'San Juan Opico', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(112, 7, 'Quezaltepeque', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(113, 7, 'Sacacoyo', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(114, 7, 'San José Villanueva', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(115, 7, 'San Matías', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(116, 7, 'San Pablo Tacachico', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(117, 7, 'Talnique', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(118, 7, 'Tamanique', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(119, 7, 'Teotepeque', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(120, 7, 'Tepecoyo', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(121, 7, 'Zaragoza', 1, '2015-06-06 16:22:21', '2015-06-06 16:22:21', NULL, 1, 1, NULL),
	(122, 8, 'Cuyultitán', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(123, 8, 'El Rosario / Rosario de La Paz', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(124, 8, 'Jerusalén', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(125, 8, 'Mercedes La Ceiba', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(126, 8, 'Olocuilta', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(127, 8, 'Paraíso de Osorio', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(128, 8, 'San Antonio Masahuat', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(129, 8, 'San Emigdio', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(130, 8, 'San Francisco Chinameca', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(131, 8, 'San Juan Nonualco', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(132, 8, 'San Juan Talpa', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(133, 8, 'San Juan Tepezontes', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(134, 8, 'San Luis La Herradura', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(135, 8, 'San Luis Talpa', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(136, 8, 'San Miguel Tepezontes', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(137, 8, 'San Pedro Masahuat', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(138, 8, 'San Pedro Nonualco', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(139, 8, 'San Rafael Obrajuelo', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(140, 8, 'Santa María Ostuma', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(141, 8, 'Santiago Nonualco', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(142, 8, 'Tapalhuaca', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(143, 8, 'Zacatecoluca', 1, '2015-06-06 16:23:40', '2015-06-06 16:23:40', NULL, 1, 1, NULL),
	(144, 9, 'Aguilares', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(145, 9, 'Apopa', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(146, 9, 'Ayutuxtepeque', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(147, 9, 'Delgado', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(148, 9, 'Cuscatancingo', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(149, 9, 'El Paisnal', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(150, 9, 'Guazapa', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(151, 9, 'Ilopango', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(152, 9, 'Mejicanos', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(153, 9, 'Nejapa', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(154, 9, 'Panchimalco', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(155, 9, 'Rosario de Mora', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(156, 9, 'San Marcos', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(157, 9, 'San Martín', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(158, 9, 'San Salvador', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(159, 9, 'Santiago Texacuangos', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(160, 9, 'Santo Tomás', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(161, 9, 'Soyapango', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(162, 9, 'Tonacatepeque', 1, '2015-06-06 16:24:49', '2015-06-06 16:24:49', NULL, 1, 1, NULL),
	(163, 10, 'Apastepeque', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(164, 10, 'Guadalupe', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(165, 10, 'San Cayetano Istepeque', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(166, 10, 'San Esteban Catarina', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(167, 10, 'San Ildefonso', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(168, 10, 'San Lorenzo', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(169, 10, 'San Sebastián', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(170, 10, 'San Vicente', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(171, 10, 'Santa Clara', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(172, 10, 'Santo Domingo', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(173, 10, 'Tecoluca', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(174, 10, 'Tepetitán', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(175, 10, 'Verapaz', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(176, 10, 'Apastepeque', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(177, 10, 'Guadalupe', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(178, 10, 'San Cayetano Istepeque', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(179, 10, 'San Esteban Catarina', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(180, 10, 'San Ildefonso', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(181, 10, 'San Lorenzo', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(182, 10, 'San Sebastián', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(183, 10, 'San Vicente', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(184, 10, 'Santa Clara', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(185, 10, 'Santo Domingo', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(186, 10, 'Tecoluca', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(187, 10, 'Tepetitán', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(188, 10, 'Verapaz', 1, '2015-06-06 16:27:23', '2015-06-06 16:27:23', NULL, 1, 1, NULL),
	(189, 11, 'Arambala', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(190, 11, 'Cacaopera', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(191, 11, 'Chilanga', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(192, 11, 'Corinto', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(193, 11, 'Delicias de Concepción', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(194, 11, 'El Divisadero', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(195, 11, 'El Rosario', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(196, 11, 'Gualococti', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(197, 11, 'Guatajiagua', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(198, 11, 'Joateca', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(199, 11, 'Jocoaitique', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(200, 11, 'Jocoro', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(201, 11, 'Lolotiquillo', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(202, 11, 'Meanguera', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(203, 11, 'Osicala', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(204, 11, 'Perquín', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(205, 11, 'San Carlos', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(206, 11, 'San Fernando', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(207, 11, 'San Francisco Gotera', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(208, 11, 'San Isidro', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(209, 11, 'San Simón', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(210, 11, 'Sensembra', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(211, 11, 'Sociedad', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(212, 11, 'Torola', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(213, 11, 'Yamabal', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(214, 11, 'Yoloaiquín', 1, '2015-06-06 16:30:03', '2015-06-06 16:30:03', NULL, 1, 1, NULL),
	(215, 12, 'Carolina', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(216, 12, 'Chapeltique', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(217, 12, 'Chinameca', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(218, 12, 'Chirilagua', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(219, 12, 'Ciudad Barrios', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(220, 12, 'Comacarán', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(221, 12, 'El Tránsito', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(222, 12, 'Lolotique', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(223, 12, 'Moncagua', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(224, 12, 'Nueva Guadalupe', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(225, 12, 'Nuevo Edén de San Juan', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(226, 12, 'Quelepa', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(227, 12, 'San Antonio del Mosco', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(228, 12, 'San Gerardo', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(229, 12, 'San Jorge', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(230, 12, 'San Luis de la Reina', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(231, 12, 'San Miguel', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(232, 12, 'San Rafael Oriente', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(233, 12, 'Sesori', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(234, 12, 'Uluazapa', 1, '2015-06-06 16:31:17', '2015-06-06 16:31:17', NULL, 1, 1, NULL),
	(235, 13, 'Alegría', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(236, 13, 'Berlín', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(237, 13, 'California', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(238, 13, 'Concepción Batres', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(239, 13, 'El Triunfo', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(240, 13, 'Ereguayquín', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(241, 13, 'Estanzuelas', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(242, 13, 'Jiquilisco', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(243, 13, 'Jucuapa', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(244, 13, 'Jucuarán', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(245, 13, 'Mercedes Umaña', 1, '2015-06-06 16:32:42', '2015-06-06 16:32:42', NULL, 1, 1, NULL),
	(246, 13, 'Nueva Granada', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(247, 13, 'Ozatlán', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(248, 13, 'Puerto El Triunfo', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(249, 13, 'San Agustín', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(250, 13, 'San Buenaventura', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(251, 13, 'San Dionisio', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(252, 13, 'San Francisco Javier', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(253, 13, 'Santa Elena', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(254, 13, 'Santa María', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(255, 13, 'Santiago de María', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(256, 13, 'Tecapán', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(257, 13, 'Usulután', 1, '2015-06-06 16:32:43', '2015-06-06 16:32:43', NULL, 1, 1, NULL),
	(258, 14, 'Anamorós', 1, '2015-06-06 16:33:48', '2015-06-27 18:00:11', NULL, 1, 1, NULL),
	(259, 14, 'Bolívar', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(260, 14, 'Concepción de Oriente', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(261, 14, 'Conchagua', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(262, 14, 'El Carmen', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(263, 14, 'El Sauce', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(264, 14, 'Intipucá', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(265, 14, 'La Unión', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(266, 14, 'Lilisque', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(267, 14, 'Meanguera del Golfo', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(268, 14, 'Nueva Esparta', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(269, 14, 'Pasaquina', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(270, 14, 'Polorós', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(271, 14, 'San Alejo', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(272, 14, 'San José', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(273, 14, 'Santa Rosa de Lima', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(274, 14, 'Yayantique', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(275, 14, 'Yucuaiquín', 1, '2015-06-06 16:33:48', '2015-06-06 16:33:48', NULL, 1, 1, NULL),
	(276, 1, 'Ahuachapán', 1, '2015-11-26 19:22:23', '2018-09-18 10:18:33', NULL, 1, 1, NULL);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;

-- Dumping structure for table fundasierra.commissions
DROP TABLE IF EXISTS `commissions`;
CREATE TABLE IF NOT EXISTS `commissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payments_provider_id` int(10) unsigned NOT NULL,
  `percentage` decimal(10,2) NOT NULL DEFAULT '0.00',
  `additional` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comissions_payments_providers` (`payments_provider_id`),
  CONSTRAINT `FK_comissions_payments_providers` FOREIGN KEY (`payments_provider_id`) REFERENCES `payments_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.commissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `commissions` DISABLE KEYS */;
INSERT INTO `commissions` (`id`, `payments_provider_id`, `percentage`, `additional`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 1, 2.74, 0.25, 1, '2018-09-03 14:11:02', '2018-09-03 14:12:12', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `commissions` ENABLE KEYS */;

-- Dumping structure for table fundasierra.commissions_transactions
DROP TABLE IF EXISTS `commissions_transactions`;
CREATE TABLE IF NOT EXISTS `commissions_transactions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `commission_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `comission` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_commissions_transactions_commissions` (`commission_id`),
  KEY `FK_commissions_transactions_transactions` (`transaction_id`),
  CONSTRAINT `FK_commissions_transactions_commissions` FOREIGN KEY (`commission_id`) REFERENCES `commissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_commissions_transactions_transactions` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.commissions_transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `commissions_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `commissions_transactions` ENABLE KEYS */;

-- Dumping structure for table fundasierra.countries
DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table fundasierra.countries: ~2 rows (approximately)
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` (`id`, `name`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'El Salvador', 1, '2017-11-09 20:33:03', '2017-11-10 02:49:33', NULL, NULL, 6, NULL),
	(2, 'Honduras', 1, '2017-11-10 02:56:41', '2018-09-18 08:54:17', NULL, 6, 1, NULL);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;

-- Dumping structure for table fundasierra.images
DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.images: ~12 rows (approximately)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` (`id`, `name`, `post_id`, `image`, `thumbnail`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'nUEVO', 12, 'public/posts/12/12_1.jpg', 'public/posts/12/th_12.jpg', 1, '2018-05-11 00:01:43', '2018-05-11 00:10:22', NULL, 1, 1, NULL),
	(2, 'nUEVO', 12, 'public/posts/12/12_2.png', 'public/posts/12/th_12_2.png', 1, '2018-05-11 00:06:12', '2018-05-11 00:10:23', NULL, 1, 1, NULL),
	(3, 'nUEVO', 12, 'public/posts/12/12_3.png', 'public/posts/12/th_12_3.png', 1, '2018-05-11 00:10:23', '2018-05-11 00:10:23', NULL, 1, 1, NULL),
	(4, 'nUEVO', 12, 'public/posts/12/12_4.jpeg', 'public/posts/12/th_12_4.jpeg', 1, '2018-05-11 00:10:23', '2018-05-11 00:10:23', NULL, 1, 1, NULL),
	(5, 'tasdfa1231', 16, 'public/posts/16/16_1.png', 'public/posts/16/th_16_1.png', 1, '2018-05-27 15:18:23', '2018-05-27 15:18:23', NULL, 1, 1, NULL),
	(6, 'tasdfa1231', 16, 'public/posts/16/16_2.jpg', 'public/posts/16/th_16_2.jpg', 1, '2018-05-27 15:18:23', '2018-05-27 15:18:36', NULL, 1, 1, NULL),
	(7, 'Post con video', 18, 'public/posts/18/18_1.png', 'public/posts/18/th_18_1.png', 1, '2018-09-17 12:04:50', '2018-09-17 12:04:50', NULL, 1, 1, NULL),
	(8, 'Post con video', 18, 'public/posts/18/18_2.PNG', 'public/posts/18/th_18_2.PNG', 1, '2018-09-17 12:04:50', '2018-09-17 12:04:50', NULL, 1, 1, NULL),
	(9, 'Nuevo Post', 19, 'public/posts/19/19_1.png', 'public/posts/19/th_19_1.png', 1, '2018-09-17 13:36:26', '2018-09-17 13:36:26', NULL, 1, 1, NULL),
	(10, 'Nuevo Post', 19, 'public/posts/19/19_2.PNG', 'public/posts/19/th_19_2.PNG', 1, '2018-09-17 13:36:26', '2018-09-17 13:36:26', NULL, 1, 1, NULL),
	(11, 'Nuevo Cuscatlan', 20, 'public/posts/20/20_1.PNG', 'public/posts/20/th_20_1.PNG', 1, '2018-09-17 14:00:48', '2018-09-17 14:00:48', NULL, 1, 1, NULL),
	(12, 'Nuevo Cuscatlan', 20, 'public/posts/20/20_2.png', 'public/posts/20/th_20_2.png', 1, '2018-09-17 14:00:48', '2018-09-17 14:00:48', NULL, 1, 1, NULL);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;

-- Dumping structure for table fundasierra.mentions
DROP TABLE IF EXISTS `mentions`;
CREATE TABLE IF NOT EXISTS `mentions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `start` decimal(10,2) NOT NULL DEFAULT '0.00',
  `end` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stars` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.mentions: ~0 rows (approximately)
/*!40000 ALTER TABLE `mentions` DISABLE KEYS */;
/*!40000 ALTER TABLE `mentions` ENABLE KEYS */;

-- Dumping structure for table fundasierra.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.migrations: ~8 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2018_01_14_015449_create_roles_table', 1),
	(4, '2018_01_14_015501_create_roles_users_table', 1),
	(5, '2018_01_14_015741_create_profiles_table', 1),
	(6, '2018_01_14_015816_create_images_table', 1),
	(7, '2018_02_11_164452_create_posts_types_table', 1),
	(8, '2018_02_11_164517_create_posts_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table fundasierra.oauth_access_tokens
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.oauth_access_tokens: ~9 rows (approximately)
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
	('03592cb0a38af245493fbf05e751e919d71d7d813c5a27e95d965efb4d75ada10cdf6a3e7b07b8d4', 1, 2, NULL, '[]', 0, '2018-02-15 03:31:49', '2018-02-15 03:31:49', '2018-03-02 03:31:49'),
	('08ac9de56de760e4efd1086d4d16ba8cafbd5f388b05ea14d346db39e327599bcc9c56bbaf7140c7', 5, 3, NULL, '[]', 0, '2018-04-10 01:27:54', '2018-04-10 01:27:54', '2018-04-25 01:27:53'),
	('5a92b0ed3a24ee4ece94544d8c6792d11a1877daf4c0e9e8e0e1910489b8d188d34bc44733c6a462', 1, 2, NULL, '[]', 0, '2018-02-15 03:30:58', '2018-02-15 03:30:58', '2018-03-02 03:30:58'),
	('6211fa65bef6a3c9fa0927e6b190070ef69304f6e82fb9413ed4f4c917cb7be993c6c8a60fc91c6f', 1, 3, NULL, '[]', 0, '2018-02-15 03:37:28', '2018-02-15 03:37:28', '2018-03-02 03:37:28'),
	('7dcbeccdbc265be787b994e978a28c7780441579f435b3417cd21e5e0a32098b6aab2f0255f42ca8', 1, 2, NULL, '[]', 0, '2018-02-15 03:30:34', '2018-02-15 03:30:34', '2018-03-02 03:30:34'),
	('96bfdcb338b6467764978f7e95a096281981bba8fd53b92552d3c59514fba943bd449f75ea3ce29e', 1, 2, NULL, '[]', 0, '2018-02-15 03:32:18', '2018-02-15 03:32:18', '2018-03-02 03:32:18'),
	('c4f97a5f6aa06276dc7195d34470bf971aeee5552859ac61b536fb4ec470c4647922517315acab61', 5, 3, NULL, '[]', 0, '2018-04-10 01:33:59', '2018-04-10 01:33:59', '2018-04-25 01:33:59'),
	('f0d3bbe1c1429a147132532bb85925b88e7edb5cb587d08e4c10cc9b6ef4267d2c9245033ff08c27', 1, 2, NULL, '[]', 0, '2018-04-10 01:09:00', '2018-04-10 01:09:00', '2018-04-25 01:08:58'),
	('f540eb4d41ca901448b21bf7a832f24601f741f8050518ba7d135940678180390a90a91400993f08', 1, 2, NULL, '[]', 0, '2018-02-15 03:30:18', '2018-02-15 03:30:18', '2018-03-02 03:30:18');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

-- Dumping structure for table fundasierra.oauth_auth_codes
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.oauth_auth_codes: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

-- Dumping structure for table fundasierra.oauth_clients
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.oauth_clients: ~3 rows (approximately)
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Laravel Personal Access Client', '3t86PPXm4zCcEp9JqAddad9SzKfHKZq8xYpi51C0', 'http://localhost', 1, 0, 0, '2018-02-15 02:07:51', '2018-02-15 02:07:51'),
	(2, NULL, 'Laravel Password Grant Client', '9D8HDblnAsOcGrp0cfgY1TXBTHO1mYRCX5ItMTl0', 'http://localhost', 0, 1, 0, '2018-02-15 02:07:51', '2018-02-15 02:07:51'),
	(3, NULL, 'password', 'MP7XWNIfIrtsHduKgxzu2bhpafxoQ5PHraX16m1G', 'http://localhost', 0, 1, 0, '2018-02-15 03:34:59', '2018-02-15 03:34:59');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

-- Dumping structure for table fundasierra.oauth_personal_access_clients
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.oauth_personal_access_clients: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2018-02-15 02:07:51', '2018-02-15 02:07:51');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

-- Dumping structure for table fundasierra.oauth_refresh_tokens
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.oauth_refresh_tokens: ~9 rows (approximately)
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
	('02070a560f02f0a5d180a6baf4ed67c089d0b9a3f6ba76fe826922f5e89f8102f9604c3d7da766da', '03592cb0a38af245493fbf05e751e919d71d7d813c5a27e95d965efb4d75ada10cdf6a3e7b07b8d4', 0, '2018-03-17 03:31:49'),
	('6fda8c32cc248c307aa59af16ee769f25cca9bdc6ceaf9a5025e9c1e35fe1346199f6f5cd6bce161', '7dcbeccdbc265be787b994e978a28c7780441579f435b3417cd21e5e0a32098b6aab2f0255f42ca8', 0, '2018-03-17 03:30:34'),
	('771a02eeb0e875ec36bb6f66653a63cab54d230131819a3cbe3b4465128ea1bec600e8b43f453409', '5a92b0ed3a24ee4ece94544d8c6792d11a1877daf4c0e9e8e0e1910489b8d188d34bc44733c6a462', 0, '2018-03-17 03:30:58'),
	('7b13e8e858d7df01152bf44c1a7e139ce61002aa716f071ba50fe16f6abc1a1da5a60a542188dbdb', 'f0d3bbe1c1429a147132532bb85925b88e7edb5cb587d08e4c10cc9b6ef4267d2c9245033ff08c27', 0, '2018-05-10 01:08:59'),
	('7d8c7e25fa4dc5b1f69b6fa3b462dcb8099cf05d764222c1d1f477d1e4d3449e9865b773c6d4689b', '6211fa65bef6a3c9fa0927e6b190070ef69304f6e82fb9413ed4f4c917cb7be993c6c8a60fc91c6f', 0, '2018-03-17 03:37:28'),
	('92cd0fd102546960be0a9aabdf557c089c78e90a497866a3703bc1298ebfaca6203605b00fc85b6c', 'c4f97a5f6aa06276dc7195d34470bf971aeee5552859ac61b536fb4ec470c4647922517315acab61', 0, '2018-05-10 01:33:59'),
	('a8462064c35e0fc90b36e5486e00333f015a38fb8058b95d73f46092a59ca63551000c4cac04055f', '96bfdcb338b6467764978f7e95a096281981bba8fd53b92552d3c59514fba943bd449f75ea3ce29e', 0, '2018-03-17 03:32:18'),
	('cb14ef44e2c1e4df6923acfce818be62ab6ef43408ba0755e22b90383c0ada706335ef5da688cfac', '08ac9de56de760e4efd1086d4d16ba8cafbd5f388b05ea14d346db39e327599bcc9c56bbaf7140c7', 0, '2018-05-10 01:27:53'),
	('e577c2f9a300bfd8c629bd25a9bdb2c1f24038e249c41bba2d0aad5edfc428d6e265aa61a9b95df9', 'f540eb4d41ca901448b21bf7a832f24601f741f8050518ba7d135940678180390a90a91400993f08', 0, '2018-03-17 03:30:18');
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

-- Dumping structure for table fundasierra.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.payments_providers: ~0 rows (approximately)
/*!40000 ALTER TABLE `payments_providers` DISABLE KEYS */;
INSERT INTO `payments_providers` (`id`, `name`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'Stripe', 1, '2018-09-03 14:27:55', '2018-09-03 14:27:55', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `payments_providers` ENABLE KEYS */;

-- Dumping structure for table fundasierra.plans
DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `plan_id` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.plans: ~2 rows (approximately)
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` (`id`, `name`, `amount`, `plan_id`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'Monthly Silver', 20.00, 'Monthly-Silver', 1, '2018-04-12 16:22:31', '2018-08-21 20:07:56', NULL, NULL, 1, NULL),
	(2, 'Nuevo Plan', 250.00, 'plan_EnfUb8PplZhX1X', 0, '2018-08-21 20:08:14', '2018-08-21 20:08:26', '2018-08-21 20:08:26', 1, 1, 1);
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;

-- Dumping structure for table fundasierra.plans_posts
DROP TABLE IF EXISTS `plans_posts`;
CREATE TABLE IF NOT EXISTS `plans_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `payments_provider_id` int(10) unsigned NOT NULL,
  `codigo` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_plans_posts_plans` (`plan_id`),
  KEY `FK_plans_posts_posts` (`post_id`),
  CONSTRAINT `FK_plans_posts_plans` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_plans_posts_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.plans_posts: ~2 rows (approximately)
/*!40000 ALTER TABLE `plans_posts` DISABLE KEYS */;
INSERT INTO `plans_posts` (`id`, `plan_id`, `post_id`, `payments_provider_id`, `codigo`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(5, 1, 20, 1, '123', 1, NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 1, 20, 1, 'plan_EnfUb8PplZhX1X', 1, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `plans_posts` ENABLE KEYS */;

-- Dumping structure for table fundasierra.posts
DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `goal` decimal(10,2) DEFAULT NULL,
  `video` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `city_id` int(10) unsigned DEFAULT NULL,
  `lat` float(12,6) DEFAULT NULL,
  `lng` float(12,6) DEFAULT NULL,
  `posts_type_id` int(10) unsigned NOT NULL,
  `image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_posts_type_id_index` (`posts_type_id`),
  CONSTRAINT `fk_posts_to_type_foreign` FOREIGN KEY (`posts_type_id`) REFERENCES `posts_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.posts: ~16 rows (approximately)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `name`, `comment`, `goal`, `video`, `end_date`, `city_id`, `lat`, `lng`, `posts_type_id`, `image`, `thumbnail`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'text 1', 'comentario del proyuecto', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2018-02-12 09:46:09', '2018-02-12 09:46:10', NULL, 1, 1, NULL),
	(2, 'text 2', 'comentario del proyuecto', NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 1, '2018-02-12 09:46:09', '2018-02-12 09:46:10', NULL, 1, 1, NULL),
	(3, 'text 3', 'comentario del proyuecto', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2018-02-12 09:46:09', '2018-02-12 09:46:10', NULL, 1, 1, NULL),
	(4, 'text 4', 'comentario del proyuecto', NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 1, '2018-02-12 09:46:09', '2018-02-12 09:46:10', NULL, 1, 1, NULL),
	(5, 'text 5', 'comentario del proyuecto', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2018-02-12 09:46:09', '2018-02-12 09:46:10', NULL, 1, 1, NULL),
	(6, 'text 6', 'comentario del proyecto', NULL, NULL, NULL, NULL, NULL, NULL, 2, 'public/posts/DJ3huu1z612uq4sx8r3sE2EPhb18w6cbi2SOs651.png', NULL, 1, '2018-02-12 09:46:09', '2018-02-27 02:56:02', NULL, 1, 1, NULL),
	(7, 'text 7', 'comentario del proyuecto', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2018-02-12 09:46:09', '2018-02-27 02:46:55', '2018-02-27 02:46:55', 1, 1, 1),
	(9, 'text 8', 'comentario del proyuecto', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2018-02-12 09:46:09', '2018-02-27 02:45:24', '2018-02-27 02:45:24', 1, 1, 1),
	(10, 'Prueba de post', 'Historia de post', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'public/posts/58x0p43a2yTYXHIk1ZwKEEBaclTgHObINBStFyEn.jpeg', NULL, 1, '2018-02-27 02:54:35', '2018-02-27 02:56:22', '2018-02-27 02:56:22', 1, 1, 1),
	(11, 'Mariano Paz', 'Prueba de mariano paz', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'public/defaults/1-proyectocacaco.png', NULL, 1, '2018-02-27 02:56:39', '2018-02-27 02:56:39', NULL, 1, 1, NULL),
	(12, 'nUEVO', 'MARIANO', NULL, NULL, NULL, NULL, NULL, NULL, 4, 'public/defaults/1-proyectocacaco.png', NULL, 1, '2018-02-27 02:57:27', '2018-02-27 02:57:27', NULL, 1, 1, NULL),
	(13, 'Test del proyecto', 'test', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2018-05-27 14:41:38', '2018-05-27 14:41:38', NULL, 1, 1, NULL),
	(14, 'tasdfa', 'asdfa', NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 1, '2018-05-27 15:13:47', '2018-05-27 15:13:47', NULL, 1, 1, NULL),
	(15, 'tasdfa123', 'asdfa', NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 1, '2018-05-27 15:15:22', '2018-05-27 15:15:22', NULL, 1, 1, NULL),
	(16, 'tasdfa1231', 'asdfa', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, '2018-05-27 15:18:23', '2018-05-27 15:18:23', NULL, 1, 1, NULL),
	(20, 'Nuevo Cuscatlan', '<p>Nuevo Cuscatlan</p>', 1600.00, 'public/videos/tgAqqXhEhD4lXsHqpQOziKt1tZZyh6wwwn8p38TP.mp4', '2018-09-17 16:59:00', 29, 13.649671, -89.268105, 1, NULL, NULL, 1, '2018-09-17 14:00:46', '2018-09-17 14:00:48', NULL, 1, 1, NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table fundasierra.posts_tags
DROP TABLE IF EXISTS `posts_tags`;
CREATE TABLE IF NOT EXISTS `posts_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned DEFAULT NULL,
  `tag_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.posts_tags: ~3 rows (approximately)
/*!40000 ALTER TABLE `posts_tags` DISABLE KEYS */;
INSERT INTO `posts_tags` (`id`, `post_id`, `tag_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 18, 4, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 20, 6, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 20, 9, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;

-- Dumping structure for table fundasierra.posts_types
DROP TABLE IF EXISTS `posts_types`;
CREATE TABLE IF NOT EXISTS `posts_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.posts_types: ~4 rows (approximately)
/*!40000 ALTER TABLE `posts_types` DISABLE KEYS */;
INSERT INTO `posts_types` (`id`, `name`, `color`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'Proyecto', '#2dc3e8', 1, '2018-02-11 11:08:17', '2018-02-11 11:08:18', NULL, NULL, NULL, NULL),
	(2, 'Campaña', '#C7263A', 1, '2018-02-11 11:08:16', '2018-02-11 11:08:19', NULL, NULL, NULL, NULL),
	(3, 'Evento', '#F27405', 1, '2018-02-11 11:08:10', '2018-02-11 11:08:11', NULL, NULL, NULL, NULL),
	(4, 'Seguimiento', '#15aa5b', 1, '2018-08-21 20:19:13', '2018-08-21 20:19:13', NULL, 1, 1, NULL);
/*!40000 ALTER TABLE `posts_types` ENABLE KEYS */;

-- Dumping structure for table fundasierra.profiles
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_profiles_users` (`user_id`),
  CONSTRAINT `FK_profiles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.profiles: ~0 rows (approximately)
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;

-- Dumping structure for table fundasierra.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.roles: ~2 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'User', 1, '2018-02-11 11:07:18', '2018-02-11 11:07:19', NULL, NULL, NULL, NULL),
	(2, 'Admin', 1, '2018-02-11 11:07:25', '2018-02-11 11:07:25', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table fundasierra.roles_users
DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_roles_users_roles` (`role_id`),
  KEY `FK_roles_users_users` (`user_id`),
  CONSTRAINT `FK_roles_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_roles_users_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.roles_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;
INSERT INTO `roles_users` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;

-- Dumping structure for table fundasierra.states
DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria',
  `country_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Id del país',
  `name` varchar(250) DEFAULT NULL COMMENT 'Nombre del departamento o provincia',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o Inactivo',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de modificación del registro',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'Usuario que crea el registro',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Usuario que modifica el registro',
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_departamentos_paises1_idx` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Departamentos o provicinas de un país';

-- Dumping data for table fundasierra.states: ~14 rows (approximately)
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` (`id`, `country_id`, `name`, `active`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 1, 'Ahuachapán', 1, '2015-06-06 15:53:58', '2015-06-27 17:44:17', NULL, 1, 1, NULL),
	(2, 1, 'Sonsonate', 1, '2015-06-06 15:53:58', '2015-06-06 15:53:58', NULL, 1, 1, NULL),
	(3, 1, 'Santa Ana', 1, '2015-06-06 15:53:58', '2015-06-06 15:53:58', NULL, 1, 1, NULL),
	(4, 1, 'Cabañas', 1, '2015-06-06 15:53:59', '2018-09-18 10:17:19', NULL, 1, 1, NULL),
	(5, 1, 'Chalatenango', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(6, 1, 'Cuscatlán', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(7, 1, 'La Libertad', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(8, 1, 'La Paz', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(9, 1, 'San Salvador', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(10, 1, 'San Vicente', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(11, 1, 'Morazán', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(12, 1, 'San Miguel', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(13, 1, 'Usulután', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL),
	(14, 1, 'La Unión', 1, '2015-06-06 15:53:59', '2015-06-06 15:53:59', NULL, 1, 1, NULL);
/*!40000 ALTER TABLE `states` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table fundasierra.stripes: ~0 rows (approximately)
/*!40000 ALTER TABLE `stripes` DISABLE KEYS */;
INSERT INTO `stripes` (`id`, `object`, `active`, `balance_transaction`, `stripe_id`, `amount`, `lastfour`, `stripe_created`, `brand`, `exp_year`, `exp_month`, `zip`, `funding`, `description`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, '1', 1, '1', '1', 1.00, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
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
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_subscriptions_users` (`user_id`),
  CONSTRAINT `FK_subscriptions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.subscriptions: ~11 rows (approximately)
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` (`id`, `user_id`, `name`, `stripe_id`, `stripe_plan`, `quantity`, `trial_ends_at`, `ends_at`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 2, 'main', 'sub_CdfF4pwicidor8', 'plan_Cdej0kmFIDUaAH', 1, NULL, '2018-04-07 21:46:23', '2018-04-07 20:45:35', '2018-04-07 21:46:23', NULL, NULL, NULL, NULL),
	(2, 2, 'main', 'sub_CdizZq1m15kcyf', 'plan_CdeX32iNKDB4Je', 1, NULL, NULL, '2018-04-08 00:37:51', '2018-04-08 00:37:51', NULL, NULL, NULL, NULL),
	(3, 2, 'main', 'sub_CdjMlLVwpLVck6', 'plan_CdeX32iNKDB4Je', 1, NULL, NULL, '2018-04-08 01:00:24', '2018-04-08 01:00:24', NULL, NULL, NULL, NULL),
	(4, 2, 'main', 'sub_CdjORmd5dBPo97', 'plan_CdeX32iNKDB4Je', 1, NULL, NULL, '2018-04-08 01:02:40', '2018-04-08 01:02:40', NULL, NULL, NULL, NULL),
	(5, 1, 'main2', 'sub_CeU2l3Q0kSO3Ha', 'Monthly', 1, NULL, NULL, '2018-04-10 01:14:28', '2018-04-10 01:14:28', NULL, NULL, NULL, NULL),
	(6, 4, 'main', 'sub_CeUCIxpy7LDBEx', 'Monthly', 1, NULL, NULL, '2018-04-10 01:24:54', '2018-08-26 16:53:21', NULL, NULL, 1, 1),
	(7, 5, 'main', 'sub_CeUULw3EuFwNjm', 'Monthly', 1, NULL, NULL, '2018-04-10 01:42:34', '2018-04-10 01:42:34', NULL, NULL, NULL, NULL),
	(8, 5, 'main', 'sub_CeUbtysPN29saS', 'Monthly', 1, NULL, NULL, '2018-04-10 01:49:35', '2018-04-10 01:49:35', NULL, NULL, NULL, NULL),
	(9, 5, 'main', 'sub_CeUekGDQ6VtLif', 'Monthly', 1, NULL, NULL, '2018-04-10 01:52:23', '2018-04-10 01:52:23', NULL, NULL, NULL, NULL),
	(10, 5, 'main', 'sub_CeUe0TjVJKx6Tu', 'Monthly', 1, NULL, NULL, '2018-04-10 01:52:45', '2018-04-10 01:52:45', NULL, NULL, NULL, NULL),
	(11, 5, 'main', 'sub_CeUhyBTDIsquAf', 'Monthly', 1, NULL, NULL, '2018-04-10 01:55:26', '2018-04-10 01:55:26', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;

-- Dumping structure for table fundasierra.tags
DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table fundasierra.tags: ~9 rows (approximately)
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'Tag 1', '2018-09-17 08:53:48', '2018-09-17 08:53:49', NULL, NULL, NULL, NULL),
	(2, '1', '2018-09-17 12:04:48', '2018-09-17 12:04:48', NULL, 1, 1, NULL),
	(3, 'Mariano Paz', '2018-09-17 12:04:48', '2018-09-17 12:04:48', NULL, 1, 1, NULL),
	(4, 'Nueva', '2018-09-17 12:04:48', '2018-09-17 12:04:48', NULL, 1, 1, NULL),
	(5, 'Nuevo', '2018-09-17 13:36:20', '2018-09-17 13:36:20', NULL, 1, 1, NULL),
	(6, 'Mariano', '2018-09-17 13:36:20', '2018-09-17 13:36:20', NULL, 1, 1, NULL),
	(7, '2', '2018-09-17 14:00:46', '2018-09-17 14:00:46', NULL, 1, 1, NULL),
	(8, '3', '2018-09-17 14:00:46', '2018-09-17 14:00:46', NULL, 1, 1, NULL),
	(9, '4', '2018-09-17 14:00:46', '2018-09-17 14:00:46', NULL, 1, 1, NULL);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Dumping structure for table fundasierra.transactions
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` varchar(50) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `payments_provider_id` int(10) unsigned NOT NULL,
  `stripe_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned DEFAULT NULL,
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
  KEY `FK_transactions_users` (`user_id`),
  CONSTRAINT `FK_transactions_payments_providers` FOREIGN KEY (`payments_provider_id`) REFERENCES `payments_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_transactions_stripes` FOREIGN KEY (`stripe_id`) REFERENCES `stripes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_transactions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table fundasierra.transactions: ~2 rows (approximately)
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` (`id`, `invoice`, `user_id`, `payments_provider_id`, `stripe_id`, `post_id`, `amount`, `amount_less_commissions`, `comment`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, '123', 4, 1, 1, 16, 16.00, 23.00, NULL, '2018-08-26 16:03:27', NULL, NULL, NULL, NULL, NULL),
	(2, '123', 4, 1, 1, 16, 16.00, 23.00, NULL, '2018-08-26 16:03:28', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

-- Dumping structure for table fundasierra.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fundasierra.users: ~5 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `active`, `remember_token`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'Mrs. Aimee Kuphal IV', 'alejandra.lind@example.org', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 1, 'RYDJPwV3CWn8GihKgun8wLgruueAAE6V2B8N50juAkdggK0brA2wCw0UhYFM', NULL, NULL, NULL, NULL, '2018-02-11 17:02:36', '2018-02-11 17:02:36', NULL, NULL, NULL, NULL),
	(2, 'Carolina Bayer', 'laila53@example.org', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 0, 'jTuTkWFLrS', 'cus_CdfDB5gzMC1xGp', 'Visa', '4242', NULL, '2018-02-11 17:02:36', '2018-04-07 20:44:14', NULL, NULL, NULL, NULL),
	(3, 'Jailyn Wehner', 'xjohnston@example.net', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 0, 'AxuuQJq6gS', NULL, NULL, NULL, NULL, '2018-02-11 17:02:36', '2018-02-11 17:02:36', NULL, NULL, NULL, NULL),
	(4, 'Mrs. Serenity Mraz MD', 'yaltenwerth@example.org', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 0, 'Gg4c5nxF3S', 'cus_CeU0FErPYsSBEB', 'Visa', '4242', NULL, '2018-02-11 17:02:36', '2018-04-10 01:14:25', NULL, NULL, NULL, NULL),
	(5, 'Kristina Bauch', 'eleanore92@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 1, 'wWRZWzY5Oe', 'cus_CfxyBwCEptV2mQ', 'Visa', '4242', NULL, '2018-02-11 17:02:36', '2018-08-26 16:50:57', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
