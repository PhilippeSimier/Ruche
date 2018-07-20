-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Ven 20 Juillet 2018 à 16:38
-- Version du serveur :  10.1.23-MariaDB-9+deb9u1
-- Version de PHP :  7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ruche`
--

-- --------------------------------------------------------

--
-- Structure de la table `mesures`
--

CREATE TABLE `mesures` (
  `id` int(11) NOT NULL,
  `eclairement` float NOT NULL,
  `pression` float NOT NULL,
  `temperature` float NOT NULL,
  `poids` float NOT NULL,
  `humidite` float NOT NULL,
  `tension` float NOT NULL,
  `courant` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_ruche` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mesures`
--

INSERT INTO `mesures` (`id`, `eclairement`, `pression`, `temperature`, `poids`, `humidite`, `tension`, `courant`, `date`, `id_ruche`) VALUES
(844, 0, 0, 0, -0.049774, 0, 0, 0, '2018-07-20 09:30:02', 539387),
(845, 0, 0, 0, -0.0528849, 0, 0, 0, '2018-07-20 10:00:02', 539387),
(846, 0, 0, 0, -0.0871045, 0, 0, 0, '2018-07-20 10:30:02', 539387),
(847, 0, 0, 0, 0.0559957, 0, 0, 0, '2018-07-20 11:00:03', 539387),
(848, 0, 0, 0, 0.0559957, 0, 0, 0, '2018-07-20 11:30:02', 539387),
(849, 0, 0, 0, 0.146211, 0, 0, 0, '2018-07-20 12:00:03', 539387),
(850, 0, 0, 0, 0.317309, 0, 0, 0, '2018-07-20 12:30:03', 539387),
(851, 0, 0, 0, 0.348418, 0, 0, 0, '2018-07-20 13:00:02', 539387),
(852, 0, 0, 0, 0.609731, 0, 0, 0, '2018-07-20 13:30:02', 539387),
(853, 0, 0, 0, 0.836825, 0, 0, 0, '2018-07-20 14:00:02', 539387),
(854, 0, 0, 0, 0.998591, 0, 0, 0, '2018-07-20 14:30:02', 539387);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `mesures`
--
ALTER TABLE `mesures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `mesures`
--
ALTER TABLE `mesures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=855;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
