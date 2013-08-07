-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 06 Août 2013 à 17:46
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `h2otechs_datamanager_enky2`
--

-- --------------------------------------------------------

--
-- Structure de la table `variables`
--

CREATE TABLE `variables` (
  `id_variable` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `unite` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_variable`),
  UNIQUE KEY `label` (`label`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `variables`
--

INSERT INTO `variables` (`id_variable`, `label`, `unite`, `description`) VALUES
(1, 'CFC', 'cf', 'Sonde conductivité cuve concentrat'),
(2, 'CFL', 'cf', 'Sonde de conductivité de la cuve lixiviat'),
(3, 'CFP', 'cf', 'Sonde conductivité perméat'),
(4, 'CFPC', 'cf', 'Sonde conductivité perméat 2ème étage'),
(5, 'CFPL', 'cf', 'Sonde conductivité perméat 1er étage'),
(6, 'FCTL', 'm3', 'Débitmètre lixiviat'),
(7, 'PC', 'bar', 'Capteur de pression pompe CATC'),
(8, 'PFIL1', 'bar', 'Capteur de pression en sortie de la pompe Fil'),
(9, 'PFIL2', 'bar', 'Capteur de pression en sortie du filtre Arkal'),
(10, 'PFIL3', 'bar', 'Capteur de pression en sortie des filtres cartouches'),
(11, 'PH_C', 'PH', 'Sonde Ph cuve concentrat'),
(12, 'PH_L', 'PH', 'Sonde de conductivité perméat'),
(13, 'PH_R', 'PH', 'Sonde de PH '),
(14, 'PL', 'bar', 'Capteur de pression pompe CATL'),
(15, 'PP', 'bar', 'Capteur de pression en sortie du surpresseur perméat'),
(16, 'PPE', 'bar', 'Capteur de pression en entrée du surpresseur perméat'),
(17, 'RENDT_ETAGE1', '%', 'Rendement 1er étage'),
(18, 'RENDT_ETAGE2', '%', 'Rendement 2ème étage'),
(19, 'RENDT_ETAGE3', '%', 'Rendement 3ème étage'),
(20, 'RENDT_ETAGES', '%', 'Rendement Globlal');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
