-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 02 Août 2017 à 06:37
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdd_serious_game`
--

-- --------------------------------------------------------

--
-- Structure de la table `avatar`
--

CREATE TABLE `avatar` (
  `id_avt` int(10) NOT NULL,
  `nom_img` varchar(50) COLLATE utf8_bin NOT NULL,
  `taille_img` varchar(25) COLLATE utf8_bin NOT NULL,
  `type_img` int(25) NOT NULL,
  `blob_img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `a_repondue`
--

CREATE TABLE `a_repondue` (
  `id_util` int(10) NOT NULL,
  `id_q` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `a_un_score_de`
--

CREATE TABLE `a_un_score_de` (
  `id_util` int(10) NOT NULL,
  `id_mat` int(10) NOT NULL,
  `nb_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `demande_ami`
--

CREATE TABLE `demande_ami` (
  `id_dem` int(10) NOT NULL,
  `id_rec` int(10) NOT NULL,
  `date_envoie` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `demande_defi`
--

CREATE TABLE `demande_defi` (
  `id_dem` int(10) NOT NULL,
  `id_rec` int(10) NOT NULL,
  `date_envoie` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_q` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `id_fil` int(10) NOT NULL,
  `nom_fil` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `liste_ami`
--

CREATE TABLE `liste_ami` (
  `id_ami1` int(10) NOT NULL,
  `id_ami2` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id_mat` int(10) NOT NULL,
  `titre_mat` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id_q` int(10) NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `valeur` int(1) NOT NULL,
  `id_mat` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id_r` int(10) NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `type_rep` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_possible`
--

CREATE TABLE `reponse_possible` (
  `id_q` int(10) NOT NULL,
  `id_r` int(10) NOT NULL,
  `type_rep` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_util` int(10) NOT NULL,
  `nom` varchar(20) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `nom_util` varchar(20) COLLATE utf8_bin NOT NULL,
  `mot_de_passe` varchar(20) COLLATE utf8_bin NOT NULL,
  `titre` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'utilisateur',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `id_avt` int(10) DEFAULT NULL,
  `id_fil` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id_avt`);

--
-- Index pour la table `a_repondue`
--
ALTER TABLE `a_repondue`
  ADD PRIMARY KEY (`id_util`,`id_q`),
  ADD KEY `id_q` (`id_q`);

--
-- Index pour la table `a_un_score_de`
--
ALTER TABLE `a_un_score_de`
  ADD PRIMARY KEY (`id_util`,`id_mat`),
  ADD KEY `id_mat` (`id_mat`);

--
-- Index pour la table `demande_ami`
--
ALTER TABLE `demande_ami`
  ADD PRIMARY KEY (`id_dem`,`id_rec`),
  ADD KEY `id_rec` (`id_rec`);

--
-- Index pour la table `demande_defi`
--
ALTER TABLE `demande_defi`
  ADD PRIMARY KEY (`id_dem`,`id_rec`),
  ADD KEY `id_rec` (`id_rec`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`id_fil`);

--
-- Index pour la table `liste_ami`
--
ALTER TABLE `liste_ami`
  ADD PRIMARY KEY (`id_ami1`,`id_ami2`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id_mat`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_q`),
  ADD KEY `id_mat` (`id_mat`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id_r`);

--
-- Index pour la table `reponse_possible`
--
ALTER TABLE `reponse_possible`
  ADD PRIMARY KEY (`id_q`,`id_r`),
  ADD KEY `id_r` (`id_r`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_util`),
  ADD KEY `id_avt` (`id_avt`),
  ADD KEY `id_fil` (`id_fil`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id_avt` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `id_fil` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_mat` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id_q` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id_r` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_util` int(10) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `a_repondue`
--
ALTER TABLE `a_repondue`
  ADD CONSTRAINT `a_repondue_ibfk_1` FOREIGN KEY (`id_q`) REFERENCES `question` (`id_q`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `a_repondue_ibfk_2` FOREIGN KEY (`id_util`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `a_un_score_de`
--
ALTER TABLE `a_un_score_de`
  ADD CONSTRAINT `a_un_score_de_ibfk_1` FOREIGN KEY (`id_util`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `a_un_score_de_ibfk_2` FOREIGN KEY (`id_mat`) REFERENCES `matiere` (`id_mat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `demande_ami`
--
ALTER TABLE `demande_ami`
  ADD CONSTRAINT `demande_ami_ibfk_1` FOREIGN KEY (`id_dem`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `demande_ami_ibfk_2` FOREIGN KEY (`id_rec`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `demande_defi`
--
ALTER TABLE `demande_defi`
  ADD CONSTRAINT `demande_defi_ibfk_1` FOREIGN KEY (`id_dem`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `demande_defi_ibfk_2` FOREIGN KEY (`id_rec`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_mat`) REFERENCES `matiere` (`id_mat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reponse_possible`
--
ALTER TABLE `reponse_possible`
  ADD CONSTRAINT `reponse_possible_ibfk_1` FOREIGN KEY (`id_q`) REFERENCES `question` (`id_q`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reponse_possible_ibfk_2` FOREIGN KEY (`id_r`) REFERENCES `reponse` (`id_r`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_avt`) REFERENCES `avatar` (`id_avt`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_fil`) REFERENCES `filiere` (`id_fil`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
