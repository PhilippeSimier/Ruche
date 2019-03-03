-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u4
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 03 Mars 2019 à 18:32
-- Version du serveur :  5.5.62-0+deb8u1
-- Version de PHP :  5.6.40-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `data`
--

-- --------------------------------------------------------

--
-- Structure de la table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `field1` varchar(50) NOT NULL,
  `field2` varchar(50) NOT NULL,
  `field3` varchar(50) NOT NULL,
  `field4` varchar(50) NOT NULL,
  `field5` varchar(50) NOT NULL,
  `field6` varchar(50) NOT NULL,
  `field7` varchar(50) NOT NULL,
  `field8` varchar(50) NOT NULL,
  `statut` varchar(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=566174 DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `channels`
--

INSERT INTO `channels` (`id`, `name`, `field1`, `field2`, `field3`, `field4`, `field5`, `field6`, `field7`, `field8`, `statut`) VALUES
(539387, 'Mesures', ' Weight (Kg)', 'Temperature (°C)', 'Pressure (hPa)', 'Humidity (%)', 'Illuminance (Lux)', 'Dew point (°C)', 'Corrected Weight (Kg)', '', ''),
(566173, 'Ruche Touchard 1', 'Weight (kg)', 'Temperature (°C)', 'Pressure (kPa)', 'Humidity (%)', 'Illuminance (lux)', 'Dew point (°C)', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `feeds`
--

CREATE TABLE IF NOT EXISTS `feeds` (
`id` int(11) NOT NULL,
  `id_channel` int(11) NOT NULL,
  `field1` float DEFAULT NULL,
  `field2` float DEFAULT NULL,
  `field3` float DEFAULT NULL,
  `field4` float DEFAULT NULL,
  `field5` float DEFAULT NULL,
  `field6` float DEFAULT NULL,
  `field7` float DEFAULT NULL,
  `field8` float DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `elevation` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8412 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `things`
--

CREATE TABLE IF NOT EXISTS `things` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `elevation` float NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `things`
--

INSERT INTO `things` (`id`, `user_id`, `latitude`, `longitude`, `elevation`, `name`) VALUES
(1, 1, 47.9957, 0.204413, 50, 'Ruche1'),
(2, 2, 48.0101, 0.206052, 70.2, 'Ruche2');

-- --------------------------------------------------------

--
-- Structure de la table `things_channels`
--

CREATE TABLE IF NOT EXISTS `things_channels` (
`id` int(11) NOT NULL,
  `thing_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `things_channels`
--

INSERT INTO `things_channels` (`id`, `thing_id`, `channel_id`) VALUES
(3, 1, 566173),
(4, 2, 539387);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login` varchar(25) NOT NULL,
  `encrypted_password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sign_in_count` int(11) NOT NULL DEFAULT '0',
  `last_sign_in_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `encrypted_password`, `created_at`, `sign_in_count`, `last_sign_in_at`) VALUES
(1, 'patrice', '21232f297a57a5a743894a0e4a801fc3', '2019-03-03 17:11:14', 0, '0000-00-00 00:00:00'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2018-09-03 08:15:17', 0, '2019-03-03 17:07:13');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `channels`
--
ALTER TABLE `channels`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `feeds`
--
ALTER TABLE `feeds`
 ADD PRIMARY KEY (`id`), ADD KEY `channel` (`id_channel`);

--
-- Index pour la table `things`
--
ALTER TABLE `things`
 ADD PRIMARY KEY (`id`), ADD KEY `id_user` (`user_id`);

--
-- Index pour la table `things_channels`
--
ALTER TABLE `things_channels`
 ADD PRIMARY KEY (`id`), ADD KEY `Thing` (`thing_id`), ADD KEY `Channel` (`channel_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `channels`
--
ALTER TABLE `channels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=566174;
--
-- AUTO_INCREMENT pour la table `feeds`
--
ALTER TABLE `feeds`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8412;
--
-- AUTO_INCREMENT pour la table `things`
--
ALTER TABLE `things`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `things_channels`
--
ALTER TABLE `things_channels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `feeds`
--
ALTER TABLE `feeds`
ADD CONSTRAINT `feeds_ibfk_1` FOREIGN KEY (`id_channel`) REFERENCES `channels` (`id`);

--
-- Contraintes pour la table `things_channels`
--
ALTER TABLE `things_channels`
ADD CONSTRAINT `things_channels_ibfk_2` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`id`),
ADD CONSTRAINT `things_channels_ibfk_1` FOREIGN KEY (`thing_id`) REFERENCES `things` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id`) REFERENCES `things` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
