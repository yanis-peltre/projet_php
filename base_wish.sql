-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 23 jan. 2022 à 16:31
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wishlist`
--

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `liste_id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text DEFAULT NULL,
  `img` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `tarif` decimal(6,2) DEFAULT NULL,
  `cagnotte` int(11) DEFAULT NULL,
  `reserve` varchar(60) DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`, `cagnotte`, `reserve`, `message`) VALUES
(51, 27, 'bijou', 'précieux', '', NULL, '999.99', NULL, 'lambda', 'payé CASH'),
(52, 27, 'Hôtel', 'une nuit', '', NULL, '50.00', 20, NULL, NULL),
(53, 28, 'Restaurant', 'un dîner', '', NULL, '100.00', 0, 'alpha', 'on prend du homard'),
(54, 28, 'livre bricolage', '', '', NULL, '15.00', 15, NULL, NULL),
(55, 28, 'laser game', '', '', NULL, '25.00', NULL, 'alpha', '');

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

CREATE TABLE `liste` (
  `no` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token_partage` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publique` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valide` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `liste`
--

INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token`, `token_partage`, `publique`, `message`, `valide`) VALUES
(27, 5, 'liste_expirée', 'date passée', '2022-01-20', '31fd3eba08740436a9868a9b7de31302fb7575a6d0d4a6a07e1101d6088fac8b', '483d1bb297dde059c5c1ab81f822565f7a54dac2d7c515f1fd57352b7e5fcc32', 'x', 'Bijou et hôtel', 'x'),
(28, 4, 'liste_en_cours', 'date éloignée', '2022-03-10', 'ad4476919c84e23ece2765a116e5d6fbb68c12df86ec4ee882fbb354e54cd3dc', 'b236ded14ff970c9f14d0b9ddc5371d58b7b14685550865194e356e0d2adfd76', 'x', 'Donnez-moi\r\ndes trucs\r\ns\'il-vous-plaît', 'x');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `roleid` int(11) NOT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `auth_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`roleid`, `label`, `auth_level`) VALUES
(1, 'Utilisateur', 1),
(2, 'Createur', 5000),
(3, 'Admin', 10000);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `roleid` int(11) NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `roleid`, `email`) VALUES
(4, 'lambda', '$2y$10$LLzLu5HY5ZHqh5Ezy5e.Zu5.WNYMDRtm1vjN93NEY1k3fUdr64M8G', 2, 'lambda@gmail.com'),
(5, 'alpha', '$2y$10$d6igrQZZUmNRUegV0yIMZ.koM7kYE8yqq5V7M8q3XFRWQ634Ng9r.', 2, 'alpha@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liste`
--
ALTER TABLE `liste`
  ADD PRIMARY KEY (`no`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleid`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `liste`
--
ALTER TABLE `liste`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
