-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 22 août 2017 à 06:39
-- Version du serveur :  10.1.25-MariaDB
-- Version de PHP :  7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
  `type_img` varchar(25) COLLATE utf8_bin NOT NULL,
  `blob_img` blob NOT NULL,
  `id_util` int(10) DEFAULT NULL
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
  `nb_point` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `a_un_score_de`
--

INSERT INTO `a_un_score_de` (`id_util`, `id_mat`, `nb_point`) VALUES
(1, 1, 0),
(1, 2, 0),
(1, 3, 0),
(1, 4, 0),
(1, 5, 0),
(1, 6, 0),
(1, 7, 0),
(2, 1, 0),
(2, 2, 0),
(2, 3, 0),
(2, 4, 0),
(2, 5, 0),
(2, 6, 0),
(2, 7, 0),
(3, 1, 0),
(3, 2, 0),
(3, 3, 0),
(3, 4, 0),
(3, 5, 0),
(3, 6, 0),
(3, 7, 0);

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

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`id_fil`, `nom_fil`) VALUES
(1, 'informatique');

-- --------------------------------------------------------

--
-- Structure de la table `force_et_faiblesse`
--

CREATE TABLE `force_et_faiblesse` (
  `id_fil` int(10) NOT NULL,
  `id_mat` int(10) NOT NULL,
  `xp_recu` float NOT NULL,
  `temp_question` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `force_et_faiblesse`
--

INSERT INTO `force_et_faiblesse` (`id_fil`, `id_mat`, `xp_recu`, `temp_question`) VALUES
(1, 1, 1.5, 30),
(1, 2, 1, 30),
(1, 3, 1.5, 30),
(1, 4, 1.5, 30),
(1, 5, 1, 30),
(1, 6, 0.5, 15),
(1, 7, 1, 30);

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

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id_mat`, `titre_mat`) VALUES
(1, 'Arts et Littérature'),
(2, 'Sciences et Nature'),
(3, 'Histoire'),
(4, 'Géographie'),
(5, 'Mathématique'),
(6, 'Informatique'),
(7, 'Physique et Chimie');

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

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id_q`, `description`, `valeur`, `id_mat`) VALUES
(1, 'Qui a peint \"Le chat angora\" ?', 5, 1),
(2, 'Qui a peint \"Le plagiat\" ?', 5, 1),
(3, 'Qui a peint \"Le bal à Bougival\" ?', 5, 1),
(4, 'A quel écrivain doit-on le personnage de Boule-de-Suif ? ', 3, 1),
(5, 'Qu\'est-ce que la \"Licorne\" dont Tintin perce le secret ?', 1, 1),
(6, 'Grâce à quel minerai obtient-on l\'aluminium ?', 5, 2),
(7, 'Comment appelle-t-on le point souterrain où un séisme se déclenche ?', 2, 2),
(8, 'À quel scientifique doit-on l’œuvre « Canon de la médecine » ?', 5, 2),
(9, 'Comment nomme-t-on l’effet d’une glycémie trop élevée ?', 4, 2),
(10, 'Qu\'est-ce que le diaphragme ?', 2, 2),
(11, 'Quelles sont les dates de la guerre d\'Algérie?', 3, 3),
(12, 'Qu\'est ce que la \'La grande dépression\' ?', 5, 3),
(13, 'Comment les premières années après la première guerre mondiale sont-elles appelées en France ?', 2, 3),
(14, 'Quel nom avait la coalition qui gouverna la France entre 1919 et 1924 ?', 5, 3),
(15, 'Dans la Grèce antique, quelle divinité était la déesse de l\'amour et de la beauté ?', 1, 3),
(16, 'Quelle est la capitale de l’Inde ?', 1, 4),
(17, 'Quelle est la capitale du Honduras ?', 1, 4),
(18, 'Quelle est la capitale des Pays-Bas ?', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id_r` int(10) NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id_r`, `description`) VALUES
(1, 'Honoré Fragonard'),
(2, 'Gustave Courbet'),
(3, 'Henri Matisse'),
(4, 'Pablo Picasso'),
(5, 'Paul Cézanne'),
(6, 'René Magritte'),
(7, 'Auguste Renoir'),
(8, 'Guy de Maupassant\r\n'),
(9, 'Molière\r\n'),
(10, 'Victor Hugo\r\n'),
(11, 'Honoré de Balzac\r\n'),
(12, 'Charles Baudelaire\r\n'),
(13, 'Arthur Rimbaud\r\n'),
(14, 'Un bateau\r\n'),
(15, 'Un avion\r\n'),
(16, 'Un château\r\n'),
(17, 'Une île\r\n'),
(18, 'Un temple\r\n'),
(19, 'Une grotte\r\n'),
(20, 'La galène'),
(21, 'La sphalérite\r\n'),
(22, 'La bauxite'),
(23, 'La malachite\r\n'),
(24, 'La cryolithe\r\n'),
(25, 'La magnésite\r\n'),
(26, 'Un hypocentre'),
(27, 'Une faille'),
(28, 'Un épicentre'),
(29, 'Un hypercentre\r\n'),
(30, 'Une zone de rupture\r\n'),
(31, 'Une dorsale\r\n'),
(38, 'Hippocrate'),
(39, 'Averroès'),
(40, 'Aristote'),
(41, 'Avicenne\r\n'),
(42, 'Callippe'),
(43, 'Eudoxe\r\n'),
(44, 'L’hypoglycémie'),
(45, 'Les triglycérides'),
(46, 'L’hyperglycémie'),
(47, 'L’aérophagie'),
(48, 'La sur-glycémie'),
(49, 'La glycémie aigu\r\n'),
(50, 'Un os'),
(51, 'Un muscle'),
(52, 'Une vertèbre'),
(53, 'Un tendon'),
(54, 'Un cartilage'),
(55, 'Une Cellule\r\n'),
(56, '1954-1962'),
(57, '1939-1945'),
(58, '1950-1954'),
(59, '1914-1918'),
(60, '1956-1959'),
(61, '1960-1968\r\n'),
(62, 'La grande famine de l\'URSS (1931-1933)'),
(63, 'La crise de 1929'),
(64, 'La vague de chaleur au Royaume-Uni en 1976'),
(65, 'La crise de 1973'),
(66, 'La crise de 1993'),
(67, 'La crise mexicaine de 1994\r\n'),
(68, 'La belle époque'),
(69, 'Les 5 glorieuses'),
(70, 'Les années folles'),
(71, 'Les 30 glorieuses'),
(72, 'Les 5 fabuleuses'),
(73, 'Les 30 glorieuses\r\n'),
(74, 'Le Cartel des Gauches'),
(75, 'La Troisième Force'),
(76, 'Le Bloc National'),
(77, 'Le Front Populaire'),
(78, 'Le Front National'),
(79, 'La Quatrième Force'),
(80, 'Hébé'),
(81, 'Aphrodite'),
(82, 'Héra'),
(83, 'Héstia'),
(84, 'Artémis'),
(85, 'Athena'),
(86, 'New Delhi'),
(87, 'Calcutta\r\n'),
(88, 'Bombay'),
(89, 'Bangalore\r\n'),
(90, 'Pondichéry\r\n'),
(91, 'Varanasi\r\n'),
(92, 'Tegucigalpa'),
(93, 'San José\r\n'),
(94, 'La Paz'),
(98, 'Eindhoven\r\n'),
(99, 'Tilburg'),
(100, 'Amsterdam\r\n'),
(101, 'Rotterdam'),
(102, 'La Haye\r\n'),
(103, 'Utrecht');

-- --------------------------------------------------------

--
-- Structure de la table `reponse_possible`
--

CREATE TABLE `reponse_possible` (
  `id_q` int(10) NOT NULL,
  `id_r` int(10) NOT NULL,
  `type_rep` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `reponse_possible`
--

INSERT INTO `reponse_possible` (`id_q`, `id_r`, `type_rep`) VALUES
(1, 1, 1),
(1, 2, 0),
(1, 3, 0),
(1, 4, 0),
(1, 5, 0),
(1, 6, 0),
(2, 1, 0),
(2, 2, 0),
(2, 3, 0),
(2, 4, 0),
(2, 5, 0),
(2, 6, 1),
(3, 1, 0),
(3, 3, 0),
(3, 4, 0),
(3, 5, 0),
(3, 6, 0),
(3, 7, 1),
(4, 5, 0),
(4, 8, 1),
(4, 10, 0),
(4, 11, 0),
(4, 12, 0),
(4, 13, 0),
(5, 14, 1),
(5, 15, 0),
(5, 16, 0),
(5, 17, 0),
(5, 18, 0),
(5, 19, 0),
(6, 20, 0),
(6, 21, 0),
(6, 22, 1),
(6, 23, 0),
(6, 24, 0),
(6, 25, 0),
(7, 26, 0),
(7, 27, 0),
(7, 28, 1),
(7, 29, 0),
(7, 30, 0),
(7, 31, 0),
(8, 38, 0),
(8, 39, 0),
(8, 40, 0),
(8, 41, 1),
(8, 42, 0),
(8, 43, 0),
(9, 44, 0),
(9, 45, 0),
(9, 46, 1),
(9, 47, 0),
(9, 48, 0),
(9, 49, 0),
(10, 50, 0),
(10, 51, 1),
(10, 52, 0),
(10, 53, 0),
(10, 54, 0),
(10, 55, 0),
(11, 56, 1),
(11, 57, 0),
(11, 58, 0),
(11, 59, 0),
(11, 60, 0),
(11, 61, 0),
(12, 62, 0),
(12, 63, 1),
(12, 64, 0),
(12, 65, 0),
(12, 66, 0),
(12, 67, 0),
(13, 68, 0),
(13, 69, 0),
(13, 70, 1),
(13, 71, 0),
(13, 72, 0),
(13, 73, 0),
(14, 74, 0),
(14, 75, 0),
(14, 76, 1),
(14, 77, 0),
(14, 78, 0),
(14, 79, 0),
(15, 80, 0),
(15, 81, 1),
(15, 82, 0),
(15, 83, 0),
(15, 84, 0),
(15, 85, 0),
(16, 86, 1),
(16, 87, 0),
(16, 88, 0),
(16, 89, 0),
(16, 90, 0),
(16, 91, 0),
(17, 87, 0),
(17, 90, 0),
(17, 91, 0),
(17, 92, 1),
(17, 93, 0),
(17, 94, 0),
(17, 103, 0),
(18, 98, 0),
(18, 99, 0),
(18, 100, 1),
(18, 101, 0),
(18, 102, 0);

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
  `mot_de_passe` varchar(40) COLLATE utf8_bin NOT NULL,
  `niveau` int(3) NOT NULL DEFAULT '0',
  `titre` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'utilisateur',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `id_fil` int(10) NOT NULL,
  `option_sport` tinyint(1) NOT NULL DEFAULT '0',
  `nom_univ` varchar(50) COLLATE utf8_bin NOT NULL,
  `banni` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_util`, `nom`, `prenom`, `email`, `nom_util`, `mot_de_passe`, `niveau`, `titre`, `admin`, `id_fil`, `option_sport`, `nom_univ`, `banni`) VALUES
(1, 'Guivarch', 'Yoann', 'yoann.guivarch@etudiant.univ-nc.nc', 'azerty', 'azerty', 0, 'utilisateur', 0, 1, 0, 'UNC', 0),
(2, 'Guerreschi', 'Christophe', 'christophe.guerreschi@etudiant.univ-nc.nc', 'qwerty', 'qwerty', 0, 'utilisateur', 0, 1, 1, 'UNC', 0),
(3, 'Laurent', 'Arnaud', 'arnaud.laurent1@etudiant.univ-nc.nc', 'theworld', 'theworld', 0, 'utilisateur', 0, 1, 0, 'UNC', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id_avt`),
  ADD KEY `id_util` (`id_util`);

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
-- Index pour la table `force_et_faiblesse`
--
ALTER TABLE `force_et_faiblesse`
  ADD PRIMARY KEY (`id_fil`,`id_mat`),
  ADD KEY `id_mat` (`id_mat`);

--
-- Index pour la table `liste_ami`
--
ALTER TABLE `liste_ami`
  ADD PRIMARY KEY (`id_ami1`,`id_ami2`),
  ADD KEY `id_ami2` (`id_ami2`);

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
  ADD KEY `id_fil` (`id_fil`);

--
-- AUTO_INCREMENT pour les tables déchargées
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
  MODIFY `id_fil` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_mat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id_q` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id_r` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_util` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avatar`
--
ALTER TABLE `avatar`
  ADD CONSTRAINT `avatar_ibfk_1` FOREIGN KEY (`id_util`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Contraintes pour la table `force_et_faiblesse`
--
ALTER TABLE `force_et_faiblesse`
  ADD CONSTRAINT `force_et_faiblesse_ibfk_1` FOREIGN KEY (`id_fil`) REFERENCES `filiere` (`id_fil`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `force_et_faiblesse_ibfk_2` FOREIGN KEY (`id_mat`) REFERENCES `matiere` (`id_mat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `liste_ami`
--
ALTER TABLE `liste_ami`
  ADD CONSTRAINT `liste_ami_ibfk_1` FOREIGN KEY (`id_ami1`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `liste_ami_ibfk_2` FOREIGN KEY (`id_ami2`) REFERENCES `utilisateur` (`id_util`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_fil`) REFERENCES `filiere` (`id_fil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
