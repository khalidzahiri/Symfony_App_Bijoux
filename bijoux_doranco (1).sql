-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 07 juil. 2021 à 21:02
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bijoux_doranco`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE `achat` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `prix_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`id`, `commande_id`, `article_id`, `quantite`, `prix_total`) VALUES
(1, 1, 11, 1, 250),
(2, 1, 12, 1, 170),
(3, 1, 13, 1, 220),
(4, 1, 15, 1, 70),
(5, 1, 14, 1, 140),
(7, 4, 11, 1, 250),
(8, 4, 12, 1, 170),
(9, 4, 13, 1, 220),
(10, 5, 13, 1, 220),
(11, 5, 12, 1, 170),
(12, 6, 17, 1, 320),
(13, 7, 17, 1, 320);

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_crea` date NOT NULL,
  `prix` int(11) NOT NULL,
  `ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `nom`, `photo`, `date_crea`, `prix`, `ref`, `description`, `categorie_id`) VALUES
(11, 'bague', '20210617142223-60cb3e7f47e85-bague4.jpg', '2021-06-16', 250, 'refbague7', 'bague de ouff, trop belle. vraiment trop belle', 2),
(12, 'montre', '20210621115614-60d0623e1bf1e-montre1.jpg', '2021-06-21', 170, 'refmontre', 'super super montre. on adore', 1),
(13, 'montre2', '20210622103617-60d1a10103c88-montre5.jpg', '2021-06-22', 220, 'refmontre2', 'super super montre. on adore ddddddddddd', 1),
(14, 'bracelet1', '20210622103701-60d1a12dd7966-bracelet3.jpg', '2021-06-22', 140, 'refbracelet1', 'bracelet avec pierres précieuses', 5),
(15, 'Boucles d\'oreille1', '20210622104639-60d1a36fdfdce-boucle5.jpg', '2021-06-22', 70, 'refboucle1', 'Boucles de ouff, trop belle. vraiment trop belle', 4),
(16, 'Montre3', '20210623131821-60d3187daa8f0-montre2.jpg', '2021-06-23', 450, 'refmontre3', 'super super montre. on adore ddddddddddd', 1),
(17, 'Montre4', '20210623131858-60d318a2c76fb-montre3.jpg', '2021-06-23', 320, 'refmontre4', 'super super montre. on adore ddddddddddd', 1),
(18, 'Montre5', '20210623131931-60d318c3b4aef-montre4.jpg', '2021-06-23', 270, 'refmontre5', 'super super montre. on adore ddddddddddd', 1),
(19, 'Bague1', '20210623132016-60d318f0712ca-bague1.jpg', '2021-06-23', 420, 'refbague1', 'bague de ouff, trop belle. vraiment trop belle', 2),
(20, 'Bague2', '20210623132053-60d319158afe3-bague5.jpg', '2021-06-23', 500, 'refbague2', 'bague de ouff, trop belle. vraiment trop belle', 2),
(21, 'Bague3', '20210623132125-60d319357c058-bague2.jpg', '2021-06-23', 370, 'refbague3', 'bague de ouff, trop belle. vraiment trop belle', 2),
(22, 'Bague4', '20210623132240-60d31980b2769-bague3.jpg', '2021-06-23', 450, 'refbague4', 'bague de ouff, trop belle. vraiment trop belle', 2),
(23, 'Collier1', '20210623132415-60d319df2370d-collier5.jpg', '2021-06-23', 140, 'refcollier1', 'Collier de ouff, trop beau. vraiment trop beau', 3),
(24, 'Collier', '20210623132515-60d31a1bf06c6-collier2.jpg', '2021-06-23', 70, 'refcollier', 'Collier de ouff, trop beau. vraiment trop beau', 3),
(25, 'Collier2', '20210623132607-60d31a4f2de58-collier3.jpg', '2021-06-23', 110, 'refcollier2', 'Collier de ouff, trop beau. vraiment trop beau', 3),
(26, 'Collier4', '20210623132705-60d31a896548e-collier4.jpg', '2021-06-23', 170, 'refcollier4', 'Collier de ouff, trop beau. vraiment trop beau', 3),
(27, 'Boucles d\'oreille2', '20210623132800-60d31ac02348c-boucle1.jpg', '2021-06-23', 120, 'refboucle2', 'Boucles de ouff, trop belle. vraiment trop belle', 4),
(28, 'Boucles d\'oreille3', '20210623132832-60d31ae0d214e-boucle3.jpg', '2021-06-23', 250, 'refboucle3', 'Boucles de ouff, trop belle. vraiment trop belle', 4),
(29, 'Boucles d\'oreille4', '20210623132919-60d31b0fbfcc2-boucle2.jpg', '2021-06-23', 140, 'refboucle4', 'Boucles de ouff, trop belle. vraiment trop belle', 4),
(30, 'Boucles d\'oreille5', '20210623133034-60d31b5a7e05a-boucle4.jpg', '2021-06-23', 99, 'refboucle5', 'Boucles de ouff, trop belle. vraiment trop belle', 4),
(31, 'Bracelet', '20210623133139-60d31b9b3a61a-bracelet1.jpg', '2021-06-23', 170, 'refbracelet', 'bracelet avec pierres precieuse', 5),
(32, 'Bracelet2', '20210623133223-60d31bc7ef45b-bracelet2.jpg', '2021-06-23', 170, 'refbracelet2', 'bracelet avec pierres precieuse', 5),
(33, 'Bracelet3', '20210623133300-60d31becc2134-bracelet4.jpg', '2021-06-23', 85, 'refbracelet3', 'bracelet avec pierres precieuse', 5),
(34, 'Bracelet5', '20210623133457-60d31c61316c3-bracelet5.jpg', '2021-06-23', 140, 'refbracelet5', 'bracelet avec pierres precieuse', 5),
(35, 'Collier5', '20210623133646-60d31cce025e1-collier1.jpg', '2021-06-23', 190, 'refcollier5', 'Collier de ouff, trop beau. vraiment trop beau', 3);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Montres'),
(2, 'Bagues'),
(3, 'Colliers'),
(4, 'Boucles d\'oreilles'),
(5, 'Bracelets');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `montant_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `user_id`, `date`, `montant_total`) VALUES
(1, 1, '2021-06-22', 850),
(4, 1, '2021-06-22', 640),
(5, 1, '2021-06-22', 390),
(6, 1, '2021-06-25', 320),
(7, 1, '2021-06-25', 305);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210615102920', '2021-06-15 12:31:59', 251),
('DoctrineMigrations\\Version20210615131841', '2021-06-15 15:19:20', 726);

-- --------------------------------------------------------

--
-- Structure de la table `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remise` int(11) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `montantmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `promo`
--

INSERT INTO `promo` (`id`, `nom`, `remise`, `date_debut`, `date_fin`, `statut`, `montantmin`) VALUES
(1, 'REGISTRATION-GIFT-2021-06', 15, NULL, NULL, 0, 100),
(5, 'PROMO-ETE-2021-06', 15, '2021-06-25', '2021-07-05', 0, 100);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `promo` int(11) NOT NULL,
  `date_inscription` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `username`, `email`, `password`, `roles`, `promo`, `date_inscription`) VALUES
(1, 'cesaire', 'desaulle', 'desaulle', 'cezdesaulle.evogue@gmail.com', '$2y$13$XyztgnSVfhU5wR5nF3dAGeRRmbFyIR6b3tAummUtuLHLQRhrI9OzC', '[\"ROLE_ADMIN\"]', 1, NULL),
(2, 'dupond', 'jean-paul', 'polopolo', 'cezdesaulle@gmail.com', '$2y$13$.xZeBR8olkQbYIze0hDHdeIiyU8pt55C5FftaQ9G3m7huPXbN8k/u', '[\"ROLE_USER\"]', 0, '2021-06-25');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_26A9845682EA2E54` (`commande_id`),
  ADD KEY `IDX_26A984567294869C` (`article_id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E66BCF5E72D` (`categorie_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67DA76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achat`
--
ALTER TABLE `achat`
  ADD CONSTRAINT `FK_26A984567294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `FK_26A9845682EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`);

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
