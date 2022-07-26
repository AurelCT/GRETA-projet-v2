-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 26 juil. 2022 à 07:38
-- Version du serveur :  5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gretaInfoCo`
--

-- --------------------------------------------------------

--
-- Structure de la table `Candidat`
--

CREATE TABLE `Candidat` (
  `id_candidat` int(10) UNSIGNED NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `email` varchar(250) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `id_poleEmploi` varchar(20) DEFAULT 'non-renseigné',
  `conseillerPE` varchar(255) DEFAULT NULL,
  `codeRegion` varchar(50) DEFAULT NULL,
  `participation` varchar(20) DEFAULT 'NP',
  `bac` varchar(20) DEFAULT NULL,
  `commentairesReunion` varchar(500) DEFAULT NULL,
  `commentairesProfile` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Candidat`
--

INSERT INTO `Candidat` (`id_candidat`, `prenom`, `nom`, `email`, `telephone`, `adresse`, `id_poleEmploi`, `conseillerPE`, `codeRegion`, `participation`, `bac`, `commentairesReunion`, `commentairesProfile`) VALUES
(1, 'Doe', 'John', 'DoeJohn@john.com', '652753173', '', '', '', 'PACA', '', 'oui', '', NULL),
(3, 'Fabienne', 'Dupont', 'DupontFabienne@bibi.com', '652005200', NULL, 'non-renseigné', 'Monique Doux', 'PACA', 'NP', 'oui', 'Bon résultat aux test, en recherche d\'emploi depuis 6 mois.', NULL),
(5, 'Claude', 'Paquet', 'Paquetclaude@bibi.com', '687864351', NULL, '13453', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Surant', 'Loic', 'SuranLoic@gmail.com', '+33623425444', NULL, '', NULL, NULL, 'NP', NULL, NULL, NULL),
(13, 'Amandine', 'Leclerc', 'AmandineLe@bibi.com', '076455898099', NULL, 'non-renseigné', NULL, NULL, 'NP', NULL, NULL, NULL),
(14, 'Parmentier', 'Céline', 'ParmentierCeline@bibi.com', '+33653423342', '192 rue du mystère 13100 Aix en provence', 'non-renseigné', 'Monique Ledoux', 'PACA', 'NP', 'oui', 'veut faire une formation après septembre 2022', NULL),
(16, 'Annaelle', 'Gourit', 'AnnaGou@bibi.com', '+2287897742', NULL, 'non-renseigné', NULL, NULL, 'NP', NULL, NULL, NULL),
(20, 'Marc', 'Hulot', 'Hulot@bibi.com', '0511223312', '', '1324331B', 'Monique Ledoux', 'PACA', 'non', 'non', '', NULL),
(21, 'Dasilva', 'Benjamin', 'BenSilva@bibi.com', '+3365411231123', '', 'B192394', 'Monique Ledoux', 'PACA', '', 'oui', 'super profil, appeler pour plus d\'info', NULL),
(22, 'Lavelet', 'Nicolas', 'Nico@bibi.com', '+33412113312', '', '', '', 'PACA', '', '', '', NULL),
(25, 'Dubois', 'Paul', 'paulodubois@bibi.com', '', '', '', '', '', '', '', '', NULL),
(26, 'Federer', 'Roger', 'goatroger@bibi.com', '', '', '', '', '', '', '', '', NULL),
(28, 'Marie', 'Luilou', 'Marielulou@bibi.com', '', '', '', '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Document`
--

CREATE TABLE `Document` (
  `id_Document` int(10) UNSIGNED NOT NULL,
  `cv_nom` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Evenement`
--

CREATE TABLE `Evenement` (
  `id_event` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `id_formation` int(10) UNSIGNED NOT NULL,
  `meetingDate` datetime NOT NULL,
  `lieu_id` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Evenement`
--

INSERT INTO `Evenement` (`id_event`, `name`, `id_formation`, `meetingDate`, `lieu_id`, `createdAt`) VALUES
(1, 'Reunion Pertuis', 3, '2022-04-21 00:00:00', 3, '2022-04-07 15:35:49'),
(49, 'Réunion pour le titre RH ', 2, '2022-04-14 12:00:00', 1, '2022-04-07 15:35:49'),
(50, 'Compta pour Gardanne', 3, '2022-05-03 15:00:00', 1, '2022-04-07 20:13:22'),
(51, 'Pertuis InfoCo hotellerie', 4, '2022-05-02 13:00:00', 1, '2022-04-09 10:01:47'),
(53, 'Réunion dev web Aix', 1, '2022-08-10 00:00:00', 2, '2022-06-19 09:59:20');

-- --------------------------------------------------------

--
-- Structure de la table `Evenement_has_Candidat`
--

CREATE TABLE `Evenement_has_Candidat` (
  `Evenement_id_event` int(10) UNSIGNED NOT NULL,
  `Candidat_id_candidat` int(10) UNSIGNED NOT NULL,
  `present` varchar(3) DEFAULT NULL,
  `retenu` tinytext,
  `commentaires` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Evenement_has_Candidat`
--

INSERT INTO `Evenement_has_Candidat` (`Evenement_id_event`, `Candidat_id_candidat`, `present`, `retenu`, `commentaires`) VALUES
(1, 1, 'oui', 'oui', ''),
(1, 3, 'oui', 'non', ''),
(1, 5, 'oui', 'non', ''),
(1, 11, 'oui', 'oui', ''),
(1, 14, 'non', 'non', ''),
(1, 16, NULL, NULL, NULL),
(1, 20, 'oui', 'oui', ''),
(1, 21, NULL, NULL, NULL),
(49, 3, 'oui', 'oui', ''),
(49, 11, 'oui', 'non', ''),
(49, 13, 'oui', 'oui', 'en reconversion, dispo pour la prochaine session'),
(49, 14, 'non', 'non', ''),
(49, 16, 'oui', 'oui', ''),
(49, 20, 'oui', 'non', ''),
(49, 21, NULL, NULL, NULL),
(50, 3, 'oui', 'non', 'voilà'),
(50, 11, 'oui', 'non', 'mauvais résultats'),
(50, 13, 'non', 'oui', ''),
(50, 14, NULL, 'non', ''),
(50, 16, 'oui', 'non', ''),
(50, 21, NULL, NULL, NULL),
(50, 26, 'oui', 'non', ''),
(51, 3, 'oui', 'oui', ''),
(51, 5, 'oui', 'non', ''),
(51, 11, NULL, NULL, ''),
(51, 13, 'oui', 'oui', ''),
(51, 20, 'oui', 'non', 'mauvais test'),
(51, 21, NULL, NULL, ''),
(53, 1, NULL, NULL, NULL),
(53, 3, 'oui', 'non', ''),
(53, 5, 'oui', 'non', 'session pas compatible avec ses horaires'),
(53, 11, 'oui', 'non', 'mauvais résultats au test'),
(53, 13, 'oui', 'oui', ''),
(53, 14, 'oui', 'non', ''),
(53, 21, 'oui', 'non', ''),
(53, 22, 'oui', 'non', '');

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `id_formation` int(10) UNSIGNED NOT NULL,
  `titreFormation` varchar(45) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id_formation`, `titreFormation`, `image`) VALUES
(1, 'Developpement Web', 'devweb-background.jpg'),
(2, 'RH', 'RH-background.jpg'),
(3, 'Comptabilité', 'compta-background.jpg'),
(4, 'Hotellerie', 'hotellerie-background.jpg'),
(5, 'cuisinier', 'cuisinier-background.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `Place`
--

CREATE TABLE `Place` (
  `id_lieu` int(11) NOT NULL,
  `lieu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Place`
--

INSERT INTO `Place` (`id_lieu`, `lieu`) VALUES
(1, 'Pertuis'),
(2, 'Aix-en-provence'),
(3, 'Gardanne'),
(4, 'Venelles');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`id_user`, `prenom`, `nom`, `email`, `password`, `role`) VALUES
(1, 'Etienne', 'Dupont', 'EtienneDupont@gmail.com', '$2y$10$lcxmI/XrMs5Ojkc6OZz1culkQmIkIvtE4BAxBLHJehmXW3/zl6TkW', 'User'),
(2, 'Marc', 'Dupont', 'DupontMarc@gmail.com', '$2y$10$jXCJJeVtzby9iftJmPJFS.LJYstgFV6qU2EhZcvkuqr0LQpmb0Pea', 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `User_has_Evenement`
--

CREATE TABLE `User_has_Evenement` (
  `User_id_user` int(10) UNSIGNED NOT NULL,
  `Evenement_id_event` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Candidat`
--
ALTER TABLE `Candidat`
  ADD PRIMARY KEY (`id_candidat`);

--
-- Index pour la table `Document`
--
ALTER TABLE `Document`
  ADD PRIMARY KEY (`id_Document`);

--
-- Index pour la table `Evenement`
--
ALTER TABLE `Evenement`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `fk_Evenement_formation1_idx` (`id_formation`),
  ADD KEY `lieu_id` (`lieu_id`);

--
-- Index pour la table `Evenement_has_Candidat`
--
ALTER TABLE `Evenement_has_Candidat`
  ADD PRIMARY KEY (`Evenement_id_event`,`Candidat_id_candidat`),
  ADD KEY `fk_Evenement_has_Candidat_Candidat1_idx` (`Candidat_id_candidat`),
  ADD KEY `fk_Evenement_has_Candidat_Evenement_idx` (`Evenement_id_event`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`id_formation`);

--
-- Index pour la table `Place`
--
ALTER TABLE `Place`
  ADD PRIMARY KEY (`id_lieu`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `User_has_Evenement`
--
ALTER TABLE `User_has_Evenement`
  ADD PRIMARY KEY (`User_id_user`,`Evenement_id_event`),
  ADD KEY `fk_User_has_Evenement_Evenement1_idx` (`Evenement_id_event`),
  ADD KEY `fk_User_has_Evenement_User1_idx` (`User_id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Candidat`
--
ALTER TABLE `Candidat`
  MODIFY `id_candidat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `Document`
--
ALTER TABLE `Document`
  MODIFY `id_Document` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Evenement`
--
ALTER TABLE `Evenement`
  MODIFY `id_event` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `id_formation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Place`
--
ALTER TABLE `Place`
  MODIFY `id_lieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Evenement`
--
ALTER TABLE `Evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Evenement_has_Candidat`
--
ALTER TABLE `Evenement_has_Candidat`
  ADD CONSTRAINT `fk_Evenement_has_Candidat_Candidat1` FOREIGN KEY (`Candidat_id_candidat`) REFERENCES `candidat` (`id_candidat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Evenement_has_Candidat_Evenement` FOREIGN KEY (`Evenement_id_event`) REFERENCES `evenement` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `User_has_Evenement`
--
ALTER TABLE `User_has_Evenement`
  ADD CONSTRAINT `fk_User_has_Evenement_Evenement1` FOREIGN KEY (`Evenement_id_event`) REFERENCES `mydb`.`Evenement` (`id_event`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_has_Evenement_User1` FOREIGN KEY (`User_id_user`) REFERENCES `mydb`.`User` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
