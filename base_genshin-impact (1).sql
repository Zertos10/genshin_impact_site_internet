-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 15 déc. 2020 à 11:26
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `base_genshin-impact`
--

-- --------------------------------------------------------

--
-- Structure de la table `arme`
--

DROP TABLE IF EXISTS `arme`;
CREATE TABLE IF NOT EXISTS `arme` (
  `ID_ARME` int NOT NULL,
  `ID_PERSONNAGE` int NOT NULL,
  `ID_STAT_PRINCIPALE` int NOT NULL,
  `NOM_ARME` text,
  `RARETE_ARME` int DEFAULT NULL,
  `NIVEAU_ARME` int DEFAULT NULL,
  `ATQ_BASE_ARME` int DEFAULT NULL,
  `RANG_DE_RAFFINEMENT` int DEFAULT NULL,
  PRIMARY KEY (`ID_ARME`),
  KEY `FK_ARME_A_UNE_STA_STATPRIN` (`ID_STAT_PRINCIPALE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `arme`
--

INSERT INTO `arme` (`ID_ARME`, `ID_PERSONNAGE`, `ID_STAT_PRINCIPALE`, `NOM_ARME`, `RARETE_ARME`, `NIVEAU_ARME`, `ATQ_BASE_ARME`, `RANG_DE_RAFFINEMENT`) VALUES
(518165, 748466, 156, 'Arc Rituel', 4, 20, 119, 1),
(523, 741, 985, 'Serment de l\'archer', 4, 20, 94, 3),
(874, 139, 625, 'Œil de la perception', 4, 20, 99, 1);

-- --------------------------------------------------------

--
-- Structure de la table `artefact`
--

DROP TABLE IF EXISTS `artefact`;
CREATE TABLE IF NOT EXISTS `artefact` (
  `ID_ARTEFACT` int NOT NULL,
  `ID_PERSONNAGE` int NOT NULL,
  `ID_STAT_PRINCIPALE` int NOT NULL,
  `ID_SET_ARTEFACT` int NOT NULL,
  `NIVEAU_ARTEFACT` int DEFAULT NULL,
  `TYPE_ARTEFACT` text,
  `RARETE_ARTEFACT` int DEFAULT NULL,
  PRIMARY KEY (`ID_ARTEFACT`),
  KEY `FK_ARTEFACT_A_UNE_STATPRIN` (`ID_STAT_PRINCIPALE`),
  KEY `FK_ARTEFACT_POSSEDE_U_SETARTEF` (`ID_SET_ARTEFACT`),
  KEY `fk_id_personnage_inArtefact` (`ID_PERSONNAGE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `artefact`
--

INSERT INTO `artefact` (`ID_ARTEFACT`, `ID_PERSONNAGE`, `ID_STAT_PRINCIPALE`, `ID_SET_ARTEFACT`, `NIVEAU_ARTEFACT`, `TYPE_ARTEFACT`, `RARETE_ARTEFACT`) VALUES
(145615, 748466, 155, 32, 1, 'Fleur', 3),
(485, 741, 232, 152, 0, 'Coupe', 3),
(32, 139, 412, 456, 0, 'Sables du temps ', 3);

-- --------------------------------------------------------

--
-- Structure de la table `a_comme`
--

DROP TABLE IF EXISTS `a_comme`;
CREATE TABLE IF NOT EXISTS `a_comme` (
  `ID_ARTEFACT` int NOT NULL,
  `ID_SUB_STAT` int NOT NULL,
  PRIMARY KEY (`ID_ARTEFACT`,`ID_SUB_STAT`),
  KEY `FK_A_COMME_A_COMME2_SUBSTATS` (`ID_SUB_STAT`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `a_comme`
--

INSERT INTO `a_comme` (`ID_ARTEFACT`, `ID_SUB_STAT`) VALUES
(32, 741),
(485, 160),
(145615, 153);

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
CREATE TABLE IF NOT EXISTS `inventaire` (
  `ID_INVENTAIRE` int NOT NULL,
  `QUANTITE_MORA` bigint DEFAULT NULL,
  `QUANTITE_PRIMO_GEMMES` bigint DEFAULT NULL,
  PRIMARY KEY (`ID_INVENTAIRE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `inventaire`
--

INSERT INTO `inventaire` (`ID_INVENTAIRE`, `QUANTITE_MORA`, `QUANTITE_PRIMO_GEMMES`) VALUES
(45610, 100000, 100000),
(369125, 114504, 53),
(162, 3000000, 2000000);

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `UID_JOUEUR` int NOT NULL,
  `ID_INVENTAIRE` int NOT NULL,
  `MAIL` text,
  `MOT_DE_PASSE` text,
  `PSEUDO` text,
  `COMMENTAIRE_PROFIL` text,
  `NIVEAU` int DEFAULT NULL,
  `EXP_ACTUELLE` int DEFAULT NULL,
  `NIVEAU_MONDE` int DEFAULT NULL,
  `ANNIVERSAIRE` date DEFAULT NULL,
  `AVATAR` text,
  `NIV_STATUE_ANEMO` int DEFAULT NULL,
  `NIV_STATUE_GEO` int DEFAULT NULL,
  PRIMARY KEY (`UID_JOUEUR`),
  KEY `FK_JOUEUR_POSSEDE_I_INVENTAI` (`ID_INVENTAIRE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`UID_JOUEUR`, `ID_INVENTAIRE`, `MAIL`, `MOT_DE_PASSE`, `PSEUDO`, `COMMENTAIRE_PROFIL`, `NIVEAU`, `EXP_ACTUELLE`, `NIVEAU_MONDE`, `ANNIVERSAIRE`, `AVATAR`, `NIV_STATUE_ANEMO`, `NIV_STATUE_GEO`) VALUES
(135415, 45610, 'guillaumesimon@gmail.com', '12345', 'Zertos10', 'je ne sais pas jouer', 4, 122, 10, '2020-10-17', 'lol', 8, 7),
(701493553, 369125, 'noah.caroux@gmail.com', 'bonjouraurevoir', 'Elitshadows', 'Je suis la tornade elle même!!', 16, 1885, 0, '2001-10-04', 'Venti', 3, 1),
(88887, 162, 'test', 'test', 'test', 'test', 0, 0, 0, '2020-12-04', '0', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `nourriture`
--

DROP TABLE IF EXISTS `nourriture`;
CREATE TABLE IF NOT EXISTS `nourriture` (
  `ID_NOURRITURE` int NOT NULL,
  `NOM_NOURRITURE` text,
  `EFFET_NOURRITURE` text,
  `QUANTITE_NOURRITURE` int DEFAULT NULL,
  PRIMARY KEY (`ID_NOURRITURE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `nourriture`
--

INSERT INTO `nourriture` (`ID_NOURRITURE`, `NOM_NOURRITURE`, `EFFET_NOURRITURE`, `QUANTITE_NOURRITURE`) VALUES
(632598, 'Aumônières de jade (délicieuses)', 'Augmente l\'attaque de tous les personnages de l\'équipe de 320 pts et leur taux CRIT de 10% pendant 300s. Ne s\'applique qu\'à votre personnage en mode multijoueur. ', 5);

-- --------------------------------------------------------

--
-- Structure de la table `nourriture2`
--

DROP TABLE IF EXISTS `nourriture2`;
CREATE TABLE IF NOT EXISTS `nourriture2` (
  `ID_INVENTAIRE` int NOT NULL,
  `ID_NOURRITURE` int NOT NULL,
  PRIMARY KEY (`ID_INVENTAIRE`,`ID_NOURRITURE`),
  KEY `FK_NOURRITU_NOURRITUR_NOURRITU` (`ID_NOURRITURE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `nourriture2`
--

INSERT INTO `nourriture2` (`ID_INVENTAIRE`, `ID_NOURRITURE`) VALUES
(369125, 632598);

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

DROP TABLE IF EXISTS `personnage`;
CREATE TABLE IF NOT EXISTS `personnage` (
  `ID_PERSONNAGE` int NOT NULL,
  `UID_JOUEUR` int DEFAULT NULL,
  `ID_ARME` int DEFAULT NULL,
  `NOM_PERSO` text,
  `RARETE` int DEFAULT NULL,
  `ELEMENT` text,
  `NIVEAU_CONSTELLATION` int DEFAULT NULL,
  `NIV_APTITUDE_1` int DEFAULT NULL,
  `NIV_APTITUDE_2` int DEFAULT NULL,
  `NIV_APTITUDE_3` int DEFAULT NULL,
  `NIVEAU_PERSO` int DEFAULT NULL,
  PRIMARY KEY (`ID_PERSONNAGE`),
  KEY `POSSEDE_PERSONNAGE_FK` (`UID_JOUEUR`),
  KEY `FK_PERSONNA_EST_EQUIP_ARME` (`ID_ARME`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `personnage`
--

INSERT INTO `personnage` (`ID_PERSONNAGE`, `UID_JOUEUR`, `ID_ARME`, `NOM_PERSO`, `RARETE`, `ELEMENT`, `NIVEAU_CONSTELLATION`, `NIV_APTITUDE_1`, `NIV_APTITUDE_2`, `NIV_APTITUDE_3`, `NIVEAU_PERSO`) VALUES
(748466, 701493553, 518165, 'Venti', 5, 'Anémo', 0, 1, 1, 1, 40),
(741, 701493553, 523, 'Fischl', 4, 'Electro', 0, 1, 1, 1, 40),
(139, 701493553, 874, 'Barbara', 4, 'Hydro', 0, 1, 1, 1, 26),
(122345, 135415, 54411, 'Velia', 4, 'Anémo', 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `setartefact`
--

DROP TABLE IF EXISTS `setartefact`;
CREATE TABLE IF NOT EXISTS `setartefact` (
  `ID_SET_ARTEFACT` int NOT NULL,
  `NOM_SET_ARTEFACT` text NOT NULL,
  `EFFET_SET1` text,
  `EFFET_SET2` text,
  PRIMARY KEY (`ID_SET_ARTEFACT`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `setartefact`
--

INSERT INTO `setartefact` (`ID_SET_ARTEFACT`, `NOM_SET_ARTEFACT`, `EFFET_SET1`, `EFFET_SET2`) VALUES
(32, 'Aventurier', 'Set de 2 pièces : \r\nAugmente les PV max de 1000 points.', 'Set de 4 pièces : \r\nRestaure 30% des PV pendant 5 secondes après l\'ouverture d\'un coffre.'),
(152, 'Chanceux ', 'Set de 2 pièces : \r\nAugmente la DEF de 100 pts. ', 'Set de 4 pièces :\r\nCollecter des moras restaure 300 PV.\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `statprincipale`
--

DROP TABLE IF EXISTS `statprincipale`;
CREATE TABLE IF NOT EXISTS `statprincipale` (
  `ID_STAT_PRINCIPALE` int NOT NULL,
  `NOM_STAT_PRINCIPALE` text,
  `QUANTITE_STAT_PRINCIPALE` float DEFAULT NULL,
  PRIMARY KEY (`ID_STAT_PRINCIPALE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `statprincipale`
--

INSERT INTO `statprincipale` (`ID_STAT_PRINCIPALE`, `NOM_STAT_PRINCIPALE`, `QUANTITE_STAT_PRINCIPALE`) VALUES
(156, 'Recharge d\'énergie', 11.8),
(155, 'PV', 430),
(985, 'Dégâts CRIT', 18),
(232, 'Bonus de dégâts Electro', 4.2),
(625, 'Recharge d\'énergie', 11.8),
(412, 'DEF', 6.6);

-- --------------------------------------------------------

--
-- Structure de la table `substatsartefacts`
--

DROP TABLE IF EXISTS `substatsartefacts`;
CREATE TABLE IF NOT EXISTS `substatsartefacts` (
  `ID_SUB_STAT` int NOT NULL,
  `NOM_SUB_STAT` text,
  `EFFET_SUB_STAT` text,
  PRIMARY KEY (`ID_SUB_STAT`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `substatsartefacts`
--

INSERT INTO `substatsartefacts` (`ID_SUB_STAT`, `NOM_SUB_STAT`, `EFFET_SUB_STAT`) VALUES
(153, 'PV', '+2.8%'),
(160, 'DEF : ', '+2.0%'),
(741, 'DEF ', '+10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
