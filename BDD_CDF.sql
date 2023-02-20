-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.31 - MySQL Community Server - GPL
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
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `portrait` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.formateur : ~12 rows (environ)
INSERT INTO `formateur` (`id`, `nom`, `prenom`, `email`, `portrait`) VALUES
	(1, 'Doe', 'Jane', 'doe.jane@mail.fr', 'portrait0.jpg'),
	(3, 'Johnson', 'Emily', 'johnson.emily@mail.fr', 'portrait1.jpg'),
	(4, 'Williams', 'Michael', 'williams.michael@mail.fr', 'portrait2.jpg'),
	(6, 'Brown', 'David', 'brown.david@mail.fr', 'portrait3.jpg'),
	(8, 'Ahmed', 'Mohammed', 'ahmed.Mohammed@mail.fr', 'portrait4.jpg'),
	(9, 'Wang', 'Li', 'wang.li@mail.fr', 'portrait5.jpg'),
	(10, 'Kim', 'Jin-Soo', 'kim.jin-soo@mail.fr', 'portrait6.jpg'),
	(11, 'Garcia', 'Maria', 'garcia.maria@mail.fr', 'portrait7.jpg'),
	(12, 'Rodriguez', 'Juan', 'rodriguez.juan@mail.fr', 'portrait8.jpg'),
	(13, 'Lopez', 'Carlos', 'lopez.carlos@mail.fr', 'portrait9.jpg'),
	(14, 'Gonzalez', 'Luis', 'gonzalez.luis@mail.fr', 'portrait10.jpg'),
	(15, 'Cedric', 'Strub', 'cedric@mail.fr', 'portrait11.jpg');

-- Listage de la structure de table cdf. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
	(4, 4, 'Business Intelligence avec Tableau'),
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.programme : ~34 rows (environ)
INSERT INTO `programme` (`id`, `module_id`, `session_id`, `duree`) VALUES
	(21, 1, 7, 4),
	(22, 2, 7, 5),
	(23, 3, 8, 3),
	(24, 4, 8, 4),
	(25, 5, 9, 5),
	(26, 6, 9, 6),
	(27, 7, 10, 7),
	(28, 8, 10, 8),
	(29, 9, 11, 9),
	(30, 10, 11, 10),
	(31, 1, 12, 2),
	(32, 2, 12, 3),
	(33, 3, 13, 4),
	(35, 5, 14, 6),
	(36, 6, 14, 7),
	(37, 7, 15, 8),
	(38, 8, 15, 9),
	(40, 10, 16, 11),
	(41, 6, 7, 5),
	(43, 2, 9, 7),
	(44, 9, 10, 2),
	(45, 4, 11, 3),
	(46, 8, 12, 4),
	(48, 7, 14, 6),
	(49, 6, 15, 7),
	(50, 10, 16, 8),
	(52, 2, 8, 10),
	(53, 3, 9, 11),
	(54, 4, 10, 12),
	(55, 5, 11, 13),
	(56, 6, 12, 14),
	(57, 7, 13, 15),
	(58, 8, 14, 16),
	(60, 10, 16, 18);

-- Listage de la structure de table cdf. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.reset_password_request : ~0 rows (environ)

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.session : ~20 rows (environ)
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
	(16, 11, 'Apprentissage automatique avec Python', 25, '2023-09-01 00:00:00', '2024-03-01 00:00:00', 6),
	(27, 1, 'Advanced Web Development', 22, '2022-07-01 00:00:00', '2023-01-01 00:00:00', 7),
	(28, 1, 'Data Structures and Algorithms', 25, '2022-07-15 00:00:00', '2023-01-15 00:00:00', 8),
	(29, 3, 'Database Management', 26, '2022-08-01 00:00:00', '2023-02-01 00:00:00', 9),
	(30, 4, 'Machine Learning with Python', 27, '2022-08-15 00:00:00', '2023-02-15 00:00:00', 10),
	(31, 4, 'Intro to Front-End Development', 24, '2022-09-01 00:00:00', '2023-03-01 00:00:00', 7),
	(32, 6, 'Object-Oriented Programming', 20, '2022-09-15 00:00:00', '2023-03-15 00:00:00', 8),
	(33, 6, 'Full Stack Development', 28, '2022-10-01 00:00:00', '2023-04-01 00:00:00', 9),
	(34, 8, 'Mobile App Development', 23, '2022-10-15 00:00:00', '2023-04-15 00:00:00', 10),
	(35, 9, 'Game Development with Unity', 21, '2022-11-01 00:00:00', '2023-05-01 00:00:00', 7),
	(36, 10, 'Artificial Intelligence', 29, '2022-11-15 00:00:00', '2023-05-15 00:00:00', 8);

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

-- Listage des données de la table cdf.session_stagiaire : ~56 rows (environ)
INSERT INTO `session_stagiaire` (`session_id`, `stagiaire_id`) VALUES
	(7, 8),
	(7, 11),
	(7, 14),
	(8, 1),
	(8, 2),
	(8, 3),
	(8, 4),
	(8, 5),
	(8, 6),
	(8, 7),
	(8, 8),
	(8, 9),
	(8, 10),
	(8, 11),
	(8, 12),
	(8, 13),
	(8, 14),
	(8, 15),
	(8, 16),
	(8, 17),
	(9, 3),
	(9, 4),
	(9, 10),
	(9, 13),
	(9, 15),
	(10, 2),
	(10, 4),
	(10, 9),
	(10, 11),
	(10, 14),
	(11, 5),
	(11, 7),
	(11, 12),
	(11, 15),
	(11, 17),
	(12, 5),
	(12, 13),
	(12, 16),
	(13, 6),
	(13, 7),
	(13, 13),
	(13, 14),
	(13, 17),
	(14, 1),
	(14, 8),
	(14, 15),
	(15, 2),
	(15, 3),
	(15, 9),
	(15, 10),
	(15, 16),
	(16, 3),
	(16, 4),
	(16, 10),
	(16, 11),
	(16, 17);

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
  `portrait` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.stagiaire : ~17 rows (environ)
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `sexe`, `telephone`, `ville`, `portrait`) VALUES
	(1, 'Smith', 'John', 'johnsmith@gmail.com', '1995-02-01 00:00:00', 'M', '0312345678', 'Paris', 'portrait0.jpg'),
	(2, 'Johnson', 'Emily', 'emilyj@yahoo.com', '1996-07-12 00:00:00', 'F', '0323456789', 'Lyon', 'portrait1.jpg'),
	(3, 'Williams', 'Michael', 'mikew@gmail.com', '1997-03-20 00:00:00', 'M', '0334567890', 'Marseille', 'portrait2.jpg'),
	(4, 'Jones', 'Jessica', 'jessjones@hotmail.com', '1998-09-15 00:00:00', 'F', '0345678901', 'Toulouse', 'portrait3.jpg'),
	(5, 'Brown', 'David', 'davebrown@gmail.com', '1999-01-01 00:00:00', 'M', '0356789012', 'Nice', 'portrait4.jpg'),
	(6, 'Davis', 'Ashley', 'ashdavis@yahoo.com', '2000-05-25 00:00:00', 'F', '0367890123', 'Nantes', 'portrait5.jpg'),
	(7, 'Miller', 'Jacob', 'jakemiller@gmail.com', '2001-10-10 00:00:00', 'M', '0378901234', 'Strasbourg', 'portrait6.jpg'),
	(8, 'Wilson', 'Samantha', 'samwilson@hotmail.com', '2002-02-22 00:00:00', 'F', '0389012345', 'Montpellier', 'portrait7.jpg'),
	(9, 'Moore', 'Joshua', 'joshmoore@gmail.com', '2003-06-30 00:00:00', 'M', '0399012345', 'Rennes', 'portrait8.jpg'),
	(10, 'Taylor', 'Emily', 'emilytaylor@yahoo.com', '2004-12-31 00:00:00', 'F', '0310012345', 'Bordeaux', 'portrait9.jpg'),
	(11, 'Khan', 'Salman', 'salmankhan@gmail.com', '1995-02-01 00:00:00', 'M', '0312345678', 'Paris', 'portrait10.jpg'),
	(12, 'Zhang', 'Wei', 'wei.zhang@yahoo.com', '1996-07-12 00:00:00', 'F', '0323456789', 'Lyon', 'portrait11.jpg'),
	(13, 'Park', 'Sung', 'sung.park@gmail.com', '1997-03-20 00:00:00', 'M', '0334567890', 'Marseille', 'portrait12.jpg'),
	(14, 'Hernandez', 'Juan', 'juan.hernandez@hotmail.com', '1998-09-15 00:00:00', 'F', '0345678901', 'Toulouse', 'portrait13.jpg'),
	(15, 'Garcia', 'Carlos', 'carlos.garcia@gmail.com', '1999-01-01 00:00:00', 'M', '0356789012', 'Nice', 'portrait14.jpg'),
	(16, 'Martin', 'Luis', 'luis.martin@yahoo.com', '2000-05-25 00:00:00', 'F', '0367890123', 'Nantes', 'portrait15.jpg'),
	(17, 'Lee', 'Jae-Sung', 'jae-sung.lee@gmail.com', '2001-10-10 00:00:00', 'M', '0378901234', 'Strasbourg', 'portrait16.jpg');

-- Listage de la structure de table cdf. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `formateur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649155D8F51` (`formateur_id`),
  CONSTRAINT `FK_8D93D649155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table cdf.user : ~0 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `formateur_id`) VALUES
	(1, 'cedric@mail.fr', '["ADMIN"]', '$2y$13$fj7xzcjSnTM6yenQ.CDEvOnOcq95fSEQBV19HAZGITavf0dudXnj6', 1, 15);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
