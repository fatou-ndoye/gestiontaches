-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 01 jan. 2026 à 17:11
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_taches`
--

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

CREATE TABLE `taches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('en_cours','termine') COLLATE utf8mb4_unicode_ci DEFAULT 'en_cours',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `taches`
--

INSERT INTO `taches` (`id`, `user_id`, `titre`, `description`, `statut`, `created_at`, `updated_at`) VALUES
(1, 1, 'Corriger les copies', 'Vérifier les examens L2', 'en_cours', '2025-12-28 15:54:53', '2025-12-28 15:54:53'),
(2, 1, 'Préparer cours PHP', 'CRUD + sessions', 'en_cours', '2025-12-28 15:54:53', '2025-12-28 15:54:53'),
(3, 1, 'Réunion pédagogique', 'Mardi 10h', 'termine', '2025-12-28 15:54:53', '2025-12-28 15:54:53'),
(4, 1, 'Corriger les copies', 'Vérifier les examens L2', 'en_cours', '2025-12-28 15:54:54', '2025-12-28 15:54:54'),
(5, 1, 'Préparer cours PHP', 'CRUD + sessions', 'en_cours', '2025-12-28 15:54:54', '2025-12-28 15:54:54'),
(6, 1, 'Réunion pédagogique', 'Mardi 10h', 'termine', '2025-12-28 15:54:54', '2025-12-28 15:54:54'),
(7, 2, 'Rédiger rapport', 'Finir le mémoire de stage', 'en_cours', '2025-12-28 16:11:57', '2025-12-28 16:11:57'),
(8, 2, 'Réviser examen', 'Chapitre 5 à 8', 'termine', '2025-12-28 16:11:57', '2025-12-28 16:12:22'),
(9, 2, 'Envoyer CV', 'Postuler chez Orange', 'termine', '2025-12-28 16:11:57', '2025-12-28 16:11:57');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrateur', 'admin@gt.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'admin', '2025-12-28 14:41:29'),
(2, 'Test User', 'test@gt.com', '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'user', '2025-12-28 15:50:53');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `taches`
--
ALTER TABLE `taches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `taches`
--
ALTER TABLE `taches`
  ADD CONSTRAINT `taches_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
