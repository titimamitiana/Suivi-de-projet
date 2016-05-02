-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 27 Avril 2016 à 14:04
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gestion_projet`
--
CREATE DATABASE IF NOT EXISTS `gestion_projet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gestion_projet`;

-- --------------------------------------------------------

--
-- Structure de la table `calendrier_tache`
--

CREATE TABLE IF NOT EXISTS `calendrier_tache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `duree` int(11) NOT NULL,
  `id_tache` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `calendrier_tache`
--

INSERT INTO `calendrier_tache` (`id`, `date`, `duree`, `id_tache`) VALUES
(32, '0000-00-00', 10, 2),
(33, '0000-00-00', 17, 2);

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `id_projet` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_projet` (`id_projet`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `module`
--

INSERT INTO `module` (`id`, `nom`, `id_projet`, `id_user`) VALUES
(1, 'Base de données', 1, 2),
(3, 'Interface', 2, 2),
(9, 'interface', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE IF NOT EXISTS `projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`id`, `nom`, `date_debut`, `date_fin`, `id_user`) VALUES
(1, 'Gestion personnel', '2016-04-03', '2016-04-26', 1),
(2, 'Gestion Etudiant', '2016-04-04', '2016-04-23', 1),
(3, 'Amelioration site Web\r\n', '2016-04-06', '2016-04-27', 2);

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

CREATE TABLE IF NOT EXISTS `taches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `estimation` int(11) NOT NULL,
  `temps_passe` int(11) NOT NULL,
  `reste_a_faire` int(11) NOT NULL,
  `date_fin` date NOT NULL,
  `id_module` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_user_2` (`id_user`),
  KEY `id_module` (`id_module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `taches`
--

INSERT INTO `taches` (`id`, `nom`, `estimation`, `temps_passe`, `reste_a_faire`, `date_fin`, `id_module`, `id_user`) VALUES
(1, 'TEST', 2, 1, 5, '2016-04-30', 1, 2),
(2, 'Insertion table', 1, 17, 1, '2016-04-05', 1, 1),
(3, 'Test unitaire', 2, 8, 1, '2016-04-06', 3, 1),
(6, 'css & js', 0, 0, 0, '2016-04-12', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `fonction` varchar(50) NOT NULL,
  `statut` int(11) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `fonction`, `statut`, `login`, `password`) VALUES
(1, 'Administrateur', 'Administrateur', 'Administrateur', 1, 'test', '4a7d1ed414474e4033ac29ccb8653d9b'),
(2, 'rabe', 'koto', 'dev', 2, 'koto', '4a7d1ed414474e4033ac29ccb8653d9b'),
(3, 'jean', 'theo', 'dev', 2, 'theo', '4a7d1ed414474e4033ac29ccb8653d9b');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_module`
--
CREATE TABLE IF NOT EXISTS `view_module` (
`id_module` int(11)
,`nom_module` varchar(100)
,`id_projet` int(11)
,`nom_projet` varchar(100)
,`avancement_module` varchar(63)
,`date_fin_module` date
,`id_responsable_module` int(11)
,`nom_responsable_module` varchar(50)
,`prenom_responsable_module` varchar(50)
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_projet`
--
CREATE TABLE IF NOT EXISTS `view_projet` (
`id_projet` int(11)
,`nom_projet` varchar(100)
,`avancement_projet` varchar(63)
,`date_debut_projet` date
,`date_fin_projet` date
,`id_responsable_projet` int(11)
,`nom_responsable_projet` varchar(50)
,`prenom_responsable_projet` varchar(50)
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_tache`
--
CREATE TABLE IF NOT EXISTS `view_tache` (
`id_tache` int(11)
,`nom_tache` varchar(100)
,`estimation` int(11)
,`temps_passe` int(11)
,`reste_a_faire` int(11)
,`id_module` int(11)
,`nom_module` varchar(100)
,`id_projet` int(11)
,`nom_projet` varchar(100)
,`id_responsable_tache` int(11)
,`nom_responsable_tache` varchar(50)
,`prenom_responsable_tache` varchar(50)
,`date_fin_tache` date
,`depassement` varchar(54)
,`avancement_tache` varchar(58)
);
-- --------------------------------------------------------

--
-- Structure de la vue `view_module`
--
DROP TABLE IF EXISTS `view_module`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_module` AS select `module`.`id` AS `id_module`,`module`.`nom` AS `nom_module`,`projet`.`id` AS `id_projet`,`projet`.`nom` AS `nom_projet`,format(avg((ifnull((`taches`.`temps_passe` / (`taches`.`temps_passe` + `taches`.`reste_a_faire`)),0) * 100)),2) AS `avancement_module`,max(`taches`.`date_fin`) AS `date_fin_module`,`user`.`id` AS `id_responsable_module`,`user`.`nom` AS `nom_responsable_module`,`user`.`prenom` AS `prenom_responsable_module` from (((`module` left join `taches` on((`module`.`id` = `taches`.`id_module`))) left join `projet` on((`module`.`id_projet` = `projet`.`id`))) left join `user` on((`user`.`id` = `module`.`id_user`))) group by `module`.`id`;

-- --------------------------------------------------------

--
-- Structure de la vue `view_projet`
--
DROP TABLE IF EXISTS `view_projet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_projet` AS select `projet`.`id` AS `id_projet`,`projet`.`nom` AS `nom_projet`,format(avg((ifnull((`taches`.`temps_passe` / (`taches`.`temps_passe` + `taches`.`reste_a_faire`)),0) * 100)),2) AS `avancement_projet`,`projet`.`date_debut` AS `date_debut_projet`,`projet`.`date_fin` AS `date_fin_projet`,`projet`.`id_user` AS `id_responsable_projet`,`user`.`nom` AS `nom_responsable_projet`,`user`.`prenom` AS `prenom_responsable_projet` from (((`projet` left join `module` on((`module`.`id_projet` = `projet`.`id`))) left join `taches` on((`taches`.`id_module` = `module`.`id`))) join `user` on((`user`.`id` = `projet`.`id_user`))) group by `projet`.`id`;

-- --------------------------------------------------------

--
-- Structure de la vue `view_tache`
--
DROP TABLE IF EXISTS `view_tache`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_tache` AS select `taches`.`id` AS `id_tache`,`taches`.`nom` AS `nom_tache`,`taches`.`estimation` AS `estimation`,`taches`.`temps_passe` AS `temps_passe`,`taches`.`reste_a_faire` AS `reste_a_faire`,`taches`.`id_module` AS `id_module`,`module`.`nom` AS `nom_module`,`projet`.`id` AS `id_projet`,`projet`.`nom` AS `nom_projet`,`taches`.`id_user` AS `id_responsable_tache`,`user`.`nom` AS `nom_responsable_tache`,`user`.`prenom` AS `prenom_responsable_tache`,`taches`.`date_fin` AS `date_fin_tache`,format((((`taches`.`temps_passe` + `taches`.`reste_a_faire`) - `taches`.`estimation`) * 100),2) AS `depassement`,format(((`taches`.`temps_passe` / (`taches`.`temps_passe` + `taches`.`reste_a_faire`)) * 100),2) AS `avancement_tache` from (((`taches` left join `user` on((`user`.`id` = `taches`.`id_user`))) left join `module` on((`module`.`id` = `taches`.`id_module`))) left join `projet` on((`projet`.`id` = `module`.`id_projet`)));

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `taches`
--
ALTER TABLE `taches`
  ADD CONSTRAINT `taches_ibfk_1` FOREIGN KEY (`id_module`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taches_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
