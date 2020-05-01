-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 28 Avril 2020 à 15:23
-- Version du serveur :  5.7.29-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `instantchat`
--

-- --------------------------------------------------------

--
-- Structure de la table `Connexion`
--

CREATE TABLE `Connexion` (
  `connexion_id` int(11) NOT NULL,
  `connexion_start` bigint(20) UNSIGNED NOT NULL,
  `connexion_end` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(100) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `connected_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `Posted_messages` (
  `message_id` int(11) NOT NULL,
  `message_body` text NOT NULL,
  `message_edit_at` bigint(20) UNSIGNED DEFAULT NULL,
  `message_read_at` bigint(20) UNSIGNED DEFAULT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
ALTER TABLE `Connexion`
  ADD PRIMARY KEY (`connexion_id`),
  ADD KEY `connected_user` (`connected_user`);

--
-- Index pour la table `Posted_messages`
--
ALTER TABLE `Posted_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `to_user_id` (`to_user_id`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Connexion`
--
ALTER TABLE `Connexion`
  MODIFY `connexion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `Posted_messages`
--
ALTER TABLE `Posted_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Connexion`
--
ALTER TABLE `Connexion`
  ADD CONSTRAINT `Connexion_ibfk_1` FOREIGN KEY (`connected_user`) REFERENCES `Users` (`user_id`);

--
-- Contraintes pour la table `Posted_messages`
--
ALTER TABLE `Posted_messages`
  ADD CONSTRAINT `Posted_messages_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `Posted_messages_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `Users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
