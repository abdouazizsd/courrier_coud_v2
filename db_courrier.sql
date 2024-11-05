-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 05 nov. 2024 à 12:21
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_courrier`
--

-- --------------------------------------------------------

--
-- Structure de la table `courrier`
--

CREATE TABLE `courrier` (
  `id_courrier` int(11) NOT NULL,
  `Numero_Courrier` varchar(255) NOT NULL,
  `Date` datetime NOT NULL,
  `Objet` text DEFAULT NULL,
  `pdf` varchar(255) NOT NULL,
  `Nature` text NOT NULL,
  `Type` text NOT NULL,
  `Expediteur` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id_departement` int(11) NOT NULL,
  `Nom_dept` enum('CSA','AC','DCH','DMG','DSAS','DRU','DCU','DACS','DE','DI','DST','DB','BAP','DA','CONSEILLER','A_P','A_I','C_C','C_C_I','CEL_S_C_Q','CELL_JURI','CELL_PASS_MAR','C_C','U_S','C_M','BAD','B_C') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id_departement`, `Nom_dept`) VALUES
(1, 'CSA'),
(2, 'AC'),
(3, 'DCH');

-- --------------------------------------------------------

--
-- Structure de la table `imputation`
--

CREATE TABLE `imputation` (
  `id_imputation` int(11) NOT NULL,
  `id_courrier` int(11) NOT NULL,
  `Instruction` enum('Accord','M''en parler','Etude et Avis','Pour réponse','Me voir avec','Pour suivi','Suite à donner','Transmission','Pour information','Pour traitement','Classement','Diffusion') DEFAULT NULL,
  `departement` varchar(255) DEFAULT NULL,
  `date_impu` date NOT NULL,
  `instruction_personnalisee` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivi`
--

CREATE TABLE `suivi` (
  `id_suivi` int(11) NOT NULL,
  `Instruction` varchar(255) DEFAULT NULL,
  `Statut` varchar(255) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_imputation` int(11) DEFAULT NULL,
  `date_suivi` date DEFAULT NULL,
  `pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Actif` tinyint(1) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Fonction` enum('bureau_courrier','direction','departement') DEFAULT NULL,
  `subrole` enum('AC','DI','DST','CELL_S_C_Q','AC','CELL_PASS_MAR','A_I','A_P','C_C_I','C_COOP','C_COM','CELL_JURI','U_S','B_C','BAD','BAP','DB','DE','DST','DACS','DCU','DRU','DSAS','DMG','DCH','CSA','CONSEILLER') NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `Matricule` varchar(255) DEFAULT NULL,
  `Tel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `Nom`, `Prenom`, `Username`, `Actif`, `Password`, `Fonction`, `subrole`, `email`, `Matricule`, `Tel`) VALUES
(1, 'diagne', 'penda', 'penda', 0, 'penda', 'bureau_courrier', '', 'pendadiagne944@gmail.com', '932030/K', '773501743'),
(2, 'diop', 'cheikh ibra', 'cheikhibra', 0, 'cheikhibra', 'departement', 'AC', 'cheikhibra@gmail.com', '932569/D', '784563214'),
(3, 'fall', 'magib', 'magibfall', 0, 'magibfall', 'direction', '', 'magibfall@gmail.com', '896574/K', '789653214'),
(4, 'fall', 'mage', 'gib', 0, 'gib', 'departement', 'DI', 'magib.fall42@gmail.com', '954784/O', '778452547'),
(5, 'bc', 'bc', 'bc', 0, 'bc', 'departement', 'B_C', 'bc', '43534', '454545'),
(6, 'de', 'de', 'de', 0, 'de', 'departement', 'DE', 'dededede@gmail.com', '658749/p', '475896532');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `courrier`
--
ALTER TABLE `courrier`
  ADD PRIMARY KEY (`id_courrier`),
  ADD UNIQUE KEY `unique_numero` (`Numero_Courrier`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id_departement`);

--
-- Index pour la table `imputation`
--
ALTER TABLE `imputation`
  ADD PRIMARY KEY (`id_imputation`),
  ADD UNIQUE KEY `id_imputation` (`id_imputation`),
  ADD KEY `id_courrier` (`id_courrier`);

--
-- Index pour la table `suivi`
--
ALTER TABLE `suivi`
  ADD PRIMARY KEY (`id_suivi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_imputation` (`id_imputation`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `Matricule` (`Matricule`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `courrier`
--
ALTER TABLE `courrier`
  MODIFY `id_courrier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id_departement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `imputation`
--
ALTER TABLE `imputation`
  MODIFY `id_imputation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT pour la table `suivi`
--
ALTER TABLE `suivi`
  MODIFY `id_suivi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `suivi`
--
ALTER TABLE `suivi`
  ADD CONSTRAINT `suivi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `suivi_ibfk_2` FOREIGN KEY (`id_imputation`) REFERENCES `imputation` (`id_imputation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
