-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cdf
CREATE DATABASE IF NOT EXISTS `cdf` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cdf`;

-- Listage de la structure de table cdf. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.categorie : ~5 rows (environ)
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'Developpement logiciel'),
	(2, 'Developpement web'),
	(3, 'Administration système'),
	(4, 'Sécurité'),
	(5, 'Developpement mobile');

-- Listage de la structure de table cdf. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table cdf.doctrine_migration_versions : ~0 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230125083742', '2023-01-25 08:38:54', 1146);

-- Listage de la structure de table cdf. formateur
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.formateur : ~11 rows (environ)
INSERT INTO `formateur` (`id`, `nom`, `prenom`) VALUES
	(1, 'Doe', 'Jane'),
	(3, 'Johnson', 'Emily'),
	(4, 'Williams', 'Michael'),
	(6, 'Brown', 'David'),
	(8, 'Ahmed', 'Mohammed'),
	(9, 'Wang', 'Li'),
	(10, 'Kim', 'Jin-Soo'),
	(11, 'Garcia', 'Maria'),
	(12, 'Rodriguez', 'Juan'),
	(13, 'Lopez', 'Carlos'),
	(14, 'Gonzalez', 'Luis');

-- Listage de la structure de table cdf. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.formation : ~10 rows (environ)
INSERT INTO `formation` (`id`, `intitule`) VALUES
	(1, 'Développement de logiciels'),
	(2, 'Informatique de gestion'),
	(3, 'Programmation web'),
	(4, 'Administration de systèmes'),
	(5, 'Bases de données'),
	(6, 'Intelligence artificielle'),
	(7, 'Cybersécurité'),
	(8, 'Développement mobile'),
	(9, 'Cloud computing'),
	(10, 'Gestion de projet informatique');

-- Listage de la structure de table cdf. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table cdf. modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2EB743D7BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_2EB743D7BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.modules : ~18 rows (environ)
INSERT INTO `modules` (`id`, `categorie_id`, `nom`) VALUES
	(1, 1, 'Introduction à la programmation orientée objet en C++'),
	(2, 1, 'Développement d\'applications de bureau en Java'),
	(3, 3, 'Comptabilité informatisée avec SAP'),
	(4, 3, 'Business Intelligence avec Tableau'),
	(5, 2, 'Conception de sites web avec HTML, CSS et JavaScript'),
	(6, 2, 'Développement de sites web dynamiques avec PHP et MySQL'),
	(7, 3, 'Administration de serveurs Linux'),
	(8, 3, 'Virtualisation avec VMware'),
	(9, 2, 'Conception de bases de données avec SQL'),
	(10, 5, 'Administration de bases de données avec Oracle'),
	(11, 1, 'Apprentissage automatique avec Python'),
	(12, 1, 'Deep Learning avec TensorFlow'),
	(13, 4, 'Sécurité des réseaux informatiques'),
	(14, 4, 'Ethique de la cybersécurité'),
	(15, 5, 'Développement d\'applications Android avec Java'),
	(16, 5, 'Développement d\'applications iOS avec Swift'),
	(17, 3, 'Infrastructure as a Service avec AWS'),
	(18, 3, 'Platform as a Service avec Azure');

-- Listage de la structure de table cdf. programme
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int DEFAULT NULL,
  `session_id` int DEFAULT NULL,
  `duree` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.programme : ~0 rows (environ)

-- Listage de la structure de table cdf. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formateur_id` int DEFAULT NULL,
  `intitule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` int NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `formation_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4155D8F51` (`formateur_id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  CONSTRAINT `FK_D044D5D4155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.session : ~10 rows (environ)
INSERT INTO `session` (`id`, `formateur_id`, `intitule`, `place`, `date_debut`, `date_fin`, `formation_id`) VALUES
	(7, 1, 'Introduction à la programmation orientée objet en C++', 22, '2022-01-01 00:00:00', '2022-07-01 00:00:00', 1),
	(8, 1, 'Développement d\'applications de bureau en Java', 25, '2022-03-01 00:00:00', '2022-09-01 00:00:00', 1),
	(9, 3, 'Comptabilité informatisée avec SAP', 27, '2022-05-01 00:00:00', '2022-11-01 00:00:00', 2),
	(10, 4, 'Business Intelligence avec Tableau', 20, '2022-07-01 00:00:00', '2023-01-01 00:00:00', 2),
	(11, 4, 'Conception de sites web avec HTML, CSS et JavaScript', 23, '2022-09-01 00:00:00', '2023-03-01 00:00:00', 3),
	(12, 6, 'Administration de serveurs Linux', 20, '2023-01-01 00:00:00', '2023-07-01 00:00:00', 4),
	(13, 8, 'Virtualisation avec VMware', 22, '2023-03-01 00:00:00', '2023-09-01 00:00:00', 4),
	(14, 9, 'Conception de bases de données avec SQL', 28, '2023-05-01 00:00:00', '2023-11-01 00:00:00', 5),
	(15, 10, 'Administration de bases de données avec Oracle', 29, '2023-07-01 00:00:00', '2023-01-01 00:00:00', 5),
	(16, 11, 'Apprentissage automatique avec Python', 25, '2023-09-01 00:00:00', '2024-03-01 00:00:00', 6);

-- Listage de la structure de table cdf. session_stagiaire
CREATE TABLE IF NOT EXISTS `session_stagiaire` (
  `session_id` int NOT NULL,
  `stagiaire_id` int NOT NULL,
  PRIMARY KEY (`session_id`,`stagiaire_id`),
  KEY `IDX_C80B23B613FECDF` (`session_id`),
  KEY `IDX_C80B23BBBA93DD6` (`stagiaire_id`),
  CONSTRAINT `FK_C80B23B613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C80B23BBBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.session_stagiaire : ~0 rows (environ)

-- Listage de la structure de table cdf. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` datetime NOT NULL,
  `sexe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.stagiaire : ~17 rows (environ)
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `sexe`, `telephone`, `ville`) VALUES
	(1, 'Smith', 'John', 'johnsmith@gmail.com', '1995-02-01 00:00:00', 'M', '0312345678', 'Paris'),
	(2, 'Johnson', 'Emily', 'emilyj@yahoo.com', '1996-07-12 00:00:00', 'F', '0323456789', 'Lyon'),
	(3, 'Williams', 'Michael', 'mikew@gmail.com', '1997-03-20 00:00:00', 'M', '0334567890', 'Marseille'),
	(4, 'Jones', 'Jessica', 'jessjones@hotmail.com', '1998-09-15 00:00:00', 'F', '0345678901', 'Toulouse'),
	(5, 'Brown', 'David', 'davebrown@gmail.com', '1999-01-01 00:00:00', 'M', '0356789012', 'Nice'),
	(6, 'Davis', 'Ashley', 'ashdavis@yahoo.com', '2000-05-25 00:00:00', 'F', '0367890123', 'Nantes'),
	(7, 'Miller', 'Jacob', 'jakemiller@gmail.com', '2001-10-10 00:00:00', 'M', '0378901234', 'Strasbourg'),
	(8, 'Wilson', 'Samantha', 'samwilson@hotmail.com', '2002-02-22 00:00:00', 'F', '0389012345', 'Montpellier'),
	(9, 'Moore', 'Joshua', 'joshmoore@gmail.com', '2003-06-30 00:00:00', 'M', '0399012345', 'Rennes'),
	(10, 'Taylor', 'Emily', 'emilytaylor@yahoo.com', '2004-12-31 00:00:00', 'F', '0310012345', 'Bordeaux'),
	(11, 'Khan', 'Salman', 'salmankhan@gmail.com', '1995-02-01 00:00:00', 'M', '0312345678', 'Paris'),
	(12, 'Zhang', 'Wei', 'wei.zhang@yahoo.com', '1996-07-12 00:00:00', 'F', '0323456789', 'Lyon'),
	(13, 'Park', 'Sung', 'sung.park@gmail.com', '1997-03-20 00:00:00', 'M', '0334567890', 'Marseille'),
	(14, 'Hernandez', 'Juan', 'juan.hernandez@hotmail.com', '1998-09-15 00:00:00', 'F', '0345678901', 'Toulouse'),
	(15, 'Garcia', 'Carlos', 'carlos.garcia@gmail.com', '1999-01-01 00:00:00', 'M', '0356789012', 'Nice'),
	(16, 'Martin', 'Luis', 'luis.martin@yahoo.com', '2000-05-25 00:00:00', 'F', '0367890123', 'Nantes'),
	(17, 'Lee', 'Jae-Sung', 'jae-sung.lee@gmail.com', '2001-10-10 00:00:00', 'M', '0378901234', 'Strasbourg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
