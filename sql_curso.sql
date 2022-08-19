-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla php_intermedio.complaints
CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `benefit` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tier` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `digits` int(8) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'No',
  `date` varchar(50) DEFAULT NULL,
  `state` int(11) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `state` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla php_intermedio.complaints: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `complaints` DISABLE KEYS */;
REPLACE INTO `complaints` (`id`, `email`, `country`, `benefit`, `tier`, `digits`, `description`, `attachment`, `date`, `state`) VALUES
	(11, 'contact@gmail.com', 'Afghanistan', 'Nike', 'Standard', 12312312, 'sadlfasdklfjas\r\n\r\nasjkflasdfj lask jlasfdk jflaskdfj', 'No', '15/08/2022', 3),
	(12, 'asdfasdfas@gmail.com', 'Ã…land Islands', 'Nike', 'Standard', 12312312, 'sdafasdlfas\r\nasdfjaskdjfasdjfaskdf', 'TITULO-XTZ.pdf', '15/08/2022', 1);
/*!40000 ALTER TABLE `complaints` ENABLE KEYS */;

-- Volcando estructura para tabla php_intermedio.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `name_rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rol`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla php_intermedio.rol: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
REPLACE INTO `rol` (`id_rol`, `name_rol`) VALUES
	(1, 'admin'),
	(2, 'user'),
	(3, 'customer'),
	(4, 'visitor');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;

-- Volcando estructura para tabla php_intermedio.state
CREATE TABLE IF NOT EXISTS `state` (
  `id_state` int(11) NOT NULL AUTO_INCREMENT,
  `name_state` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_state`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla php_intermedio.state: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
REPLACE INTO `state` (`id_state`, `name_state`) VALUES
	(1, 'pending'),
	(2, 'in process'),
	(3, 'resolved'),
	(4, 'cancelled');
/*!40000 ALTER TABLE `state` ENABLE KEYS */;

-- Volcando estructura para tabla php_intermedio.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_picture` mediumblob,
  `user_password` varchar(255) DEFAULT NULL,
  `user_registration_date` timestamp NULL DEFAULT NULL,
  `user_rol` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `USR_EMAIL` (`user_email`) USING BTREE,
  KEY `rol` (`user_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla php_intermedio.users: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `user_name`, `user_email`, `user_picture`, `user_password`, `user_registration_date`, `user_rol`) VALUES
	(4, 'sebamarin', 'sebbamarin@gmail.com', NULL, '$2y$10$.6k6UvhXDJ1B/Qv311XGKuKdooj0vsY.3nbE/y0ZkNf25/5uSZfQK', NULL, 1),
	(5, 'susan kaizen', 'susu@mail.com', NULL, '$2y$10$UetG8z.lOFSNk7YyohERLelOCbYA.j7p8yZYuEbrpAlX3w.YyeJNa', NULL, 2),
	(6, 'seba marin', 'seba@mail.com', NULL, '$2y$10$GlffE7Z49X3uwJkyO/63Dunm7fPBOhtg7E9yybuBeajS6L/Q1V1f.', NULL, 2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
