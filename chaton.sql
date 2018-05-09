-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 09 Mai 2018 à 11:46
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `chaton`
--

-- --------------------------------------------------------

--
-- Structure de la table `autorisation`
--

CREATE TABLE IF NOT EXISTS `autorisation` (
  `id_autorisation` int(11) NOT NULL AUTO_INCREMENT,
  `id_chat` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_autorisation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `autorisation`
--

INSERT INTO `autorisation` (`id_autorisation`, `id_chat`, `id_utilisateur`) VALUES
(31, 1, 30),
(32, 2, 30),
(33, 1, 31),
(34, 3, 31),
(35, 3, 32),
(36, 2, 33);

-- --------------------------------------------------------

--
-- Structure de la table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id_chat` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_chat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `chat`
--

INSERT INTO `chat` (`id_chat`, `theme`) VALUES
(1, 'aleatoire'),
(2, 'musique'),
(3, 'sport');

-- --------------------------------------------------------

--
-- Structure de la table `historique_message`
--

CREATE TABLE IF NOT EXISTS `historique_message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `heure` datetime NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `historique_message`
--

INSERT INTO `historique_message` (`id_message`, `heure`, `message`, `id_utilisateur`, `id_chat`) VALUES
(17, '2018-05-09 11:31:44', 'Comment ca va?', 30, 1),
(18, '2018-05-09 11:32:46', 'ca va et toi?', 31, 1),
(19, '2018-05-09 11:33:12', 'ca va ', 30, 1),
(20, '2018-05-09 11:33:59', 'Rendez vous pour balade bord de mer??\r\nCa intéresse quelqu''un?', 31, 3),
(21, '2018-05-09 11:35:19', 'Ca marche pour moi', 32, 3),
(22, '2018-05-09 11:35:57', 'Quelqu''un pour composer une chanson avec moi?', 30, 2),
(23, '2018-05-09 11:36:56', 'pourquoi pas...où et quand?', 33, 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mail` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `pseudo`, `mail`) VALUES
(30, 'john', 'john@free.fr'),
(31, 'paul', 'paul@sfr.fr'),
(32, 'Arthur', 'arthur@free.fr'),
(33, 'lili', 'lili@free.fr');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
