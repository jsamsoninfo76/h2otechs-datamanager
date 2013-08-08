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
-- Structure de la table `data_cfc`
--

CREATE TABLE `data_cfc` (
  `id_cfc` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cfc`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1999028 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_cfl`
--

CREATE TABLE `data_cfl` (
  `id_cfl` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cfl`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1271752 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_cfp`
--

CREATE TABLE `data_cfp` (
  `id_cfp` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cfp`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1836631 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_cfpc`
--

CREATE TABLE `data_cfpc` (
  `id_cfpc` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cfpc`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1555017 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_cfpl`
--

CREATE TABLE `data_cfpl` (
  `id_cfpl` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cfpl`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1546081 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_fctl`
--

CREATE TABLE `data_fctl` (
  `id_fctl` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_fctl`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=707202 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_pc`
--

CREATE TABLE `data_pc` (
  `id_pc` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pc`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=750477 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_pfil1`
--

CREATE TABLE `data_pfil1` (
  `id_pfil1` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pfil1`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92570 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_pfil2`
--

CREATE TABLE `data_pfil2` (
  `id_pfil2` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pfil2`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77234 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_pfil3`
--

CREATE TABLE `data_pfil3` (
  `id_pfil3` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pfil3`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=268561 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_ph_c`
--

CREATE TABLE `data_ph_c` (
  `id_ph_c` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ph_c`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=205925 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_ph_l`
--

CREATE TABLE `data_ph_l` (
  `id_ph_l` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ph_l`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=271156 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_ph_r`
--

CREATE TABLE `data_ph_r` (
  `id_ph_r` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ph_r`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=273030 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_pl`
--

CREATE TABLE `data_pl` (
  `id_pl` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pl`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=776726 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_pp`
--

CREATE TABLE `data_pp` (
  `id_pp` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pp`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=438869 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_ppe`
--

CREATE TABLE `data_ppe` (
  `id_ppe` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ppe`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=589617 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_rendt_etage1`
--

CREATE TABLE `data_rendt_etage1` (
  `id_rendt_etage1` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rendt_etage1`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=580551 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_rendt_etage2`
--

CREATE TABLE `data_rendt_etage2` (
  `id_rendt_etage2` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rendt_etage2`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=482714 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_rendt_etage3`
--

CREATE TABLE `data_rendt_etage3` (
  `id_rendt_etage3` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rendt_etage3`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=305469 ;

-- --------------------------------------------------------

--
-- Structure de la table `data_rendt_etages`
--

CREATE TABLE `data_rendt_etages` (
  `id_rendt_etages` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rendt_etages`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=582034 ;

-- --------------------------------------------------------

--
-- Structure de la table `interventions`
--

CREATE TABLE `interventions` (
  `id_intervention` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `intervenant` varchar(255) NOT NULL,
  `observation` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_intervention`),
  UNIQUE KEY `id_intervention` (`id_intervention`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Structure de la table `maj`
--

CREATE TABLE `maj` (
  `filename` varchar(255) NOT NULL,
  `dirname` varchar(255) NOT NULL,
  `number_ligne_reached` int(11) NOT NULL,
  `done` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Structure de la table `version`
--

CREATE TABLE `version` (
  `id_version` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
