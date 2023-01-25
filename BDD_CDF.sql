-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour cdf
CREATE DATABASE IF NOT EXISTS `cdf` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cdf`;

-- Listage de la structure de la table cdf. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.categorie : ~0 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table cdf. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table cdf.doctrine_migration_versions : ~1 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230125083742', '2023-01-25 08:38:54', 1146);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table cdf. formateur
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.formateur : ~0 rows (environ)
/*!40000 ALTER TABLE `formateur` DISABLE KEYS */;
/*!40000 ALTER TABLE `formateur` ENABLE KEYS */;

-- Listage de la structure de la table cdf. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.formation : ~0 rows (environ)
/*!40000 ALTER TABLE `formation` DISABLE KEYS */;
/*!40000 ALTER TABLE `formation` ENABLE KEYS */;

-- Listage de la structure de la table cdf. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.messenger_messages : ~0 rows (environ)
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

-- Listage de la structure de la table cdf. modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2EB743D7BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_2EB743D7BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.modules : ~0 rows (environ)
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;

-- Listage de la structure de la table cdf. programme
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `duree` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.programme : ~0 rows (environ)
/*!40000 ALTER TABLE `programme` DISABLE KEYS */;
/*!40000 ALTER TABLE `programme` ENABLE KEYS */;

-- Listage de la structure de la table cdf. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formateur_id` int(11) DEFAULT NULL,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4155D8F51` (`formateur_id`),
  CONSTRAINT `FK_D044D5D4155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.session : ~0 rows (environ)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Listage de la structure de la table cdf. session_stagiaire
CREATE TABLE IF NOT EXISTS `session_stagiaire` (
  `session_id` int(11) NOT NULL,
  `stagiaire_id` int(11) NOT NULL,
  PRIMARY KEY (`session_id`,`stagiaire_id`),
  KEY `IDX_C80B23B613FECDF` (`session_id`),
  KEY `IDX_C80B23BBBA93DD6` (`stagiaire_id`),
  CONSTRAINT `FK_C80B23B613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C80B23BBBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.session_stagiaire : ~0 rows (environ)
/*!40000 ALTER TABLE `session_stagiaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `session_stagiaire` ENABLE KEYS */;

-- Listage de la structure de la table cdf. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` datetime NOT NULL,
  `sexe` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.stagiaire : ~0 rows (environ)
/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
