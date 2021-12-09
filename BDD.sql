-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 09 déc. 2021 à 13:57
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Veville`
--

-- --------------------------------------------------------

--
-- Structure de la table `agences`
--

CREATE TABLE `agences` (
  `id_agence` int(3) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `code_postal` int(5) UNSIGNED ZEROFILL NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `agences`
--

INSERT INTO `agences` (`id_agence`, `titre`, `adresse`, `ville`, `code_postal`, `description`, `photo`) VALUES
(1, 'Siege Social', '10 boulevard du Parc des Princes', 'Paris', 75000, 'Notre siege social', 'siegesocial.jpg'),
(2, 'Agence Marseille', '12 rue du vélodrome', 'Marseille', 13000, 'Pas de LDC Encore c\'est sur ', 'agencemarseille.jpg'),
(3, 'Agence de Lyon', '20 avenue du Groupama', 'Lyon', 69000, 'Y\'a Denayer la-bas et au migena\r\n', 'agencelyon.jpg'),
(4, 'Agence de Lille', '100 rue des chtis', 'Lille', 59000, 'Renato le boss LE SANG T', 'agencelille.jpg'),
(5, 'Agence de Nice', '104 rue de bas villiers', 'Nice', 06000, 'C\'est quand les vac', 'agencenice.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(3) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `vehicule_id` int(3) NOT NULL,
  `agence_id` int(3) NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_fin` datetime NOT NULL,
  `prix_total` int(6) NOT NULL,
  `date_heure_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `membre_id`, `vehicule_id`, `agence_id`, `date_heure_depart`, `date_heure_fin`, `prix_total`, `date_heure_enregistrement`) VALUES
(16, 5, 5, 3, '2021-12-10 20:00:00', '2021-12-17 20:00:00', 6993, '2021-12-04 18:34:25'),
(17, 5, 2, 1, '2021-12-20 19:15:00', '2021-12-26 19:15:00', 1200, '2021-12-04 18:35:14'),
(18, 5, 4, 5, '2021-12-27 18:35:00', '2021-12-31 18:35:00', 300, '2021-12-04 18:35:40'),
(19, 5, 6, 2, '2021-12-06 21:35:00', '2021-12-09 18:35:00', 1500, '2021-12-04 18:36:06'),
(20, 5, 4, 5, '2021-12-25 20:12:00', '2022-01-15 20:12:00', 1575, '2021-12-04 20:12:46'),
(21, 5, 7, 4, '2021-12-13 16:18:00', '2021-12-27 16:18:00', 1750, '2021-12-07 16:18:53');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sexe` enum('homme','femme') NOT NULL,
  `statut` enum('admin','user') NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `password`, `nom`, `prenom`, `email`, `sexe`, `statut`, `date_enregistrement`) VALUES
(2, 'ad', '$2y$10$grloYAAPQA4XbnLpedDMkOVCi4M/4T0WgU8NYKOkOrmHkGXLd0isq', 'ad', 'ad', 'ad@gmail.com', 'homme', 'admin', '2021-11-25 22:41:09'),
(5, 'admin', '$2y$10$Por.bizkOQ7xFl7UK8ZSZeGYoajOBerS9BjOvhhynxV3cC7zMJGVq', 'Law', 'Yassir', 'admin70@gmail.com', 'homme', 'admin', '2021-11-26 08:52:00'),
(6, 'Guillaume78', '$2y$10$N1w8E4edUWR0GhkEOp625OcI7c8O1gCUj8Q97rOg8wC0bi7HQ.WaO', 'Peixoto', 'Guillaume', 'test@gmail.com', 'homme', 'admin', '2021-11-26 09:00:55'),
(7, 'PL', '$2y$10$R.jJAYwGwdOM8jnfsiyLAOCVwuQGqx2o4vRz..OEErfAcGJ5uJfNW', 'pierre', 'loic', 'pl@gmail.com', 'femme', 'admin', '2021-11-26 09:09:40');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id_vehicule` int(3) NOT NULL,
  `agence_id` int(3) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `prix_journalier` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `agence_id`, `titre`, `marque`, `modele`, `description`, `photo`, `prix_journalier`) VALUES
(1, 2, 'Audi RS3 Sportback', 'audi', 'RS3', 'Essence, manuelle, 5 portes, GPS, Toit ouvrants, Forfait 1000km (0.2€ / km supplémentaires', 'RS3.jpg', 350),
(2, 1, 'Mercedes Classe A', 'mercedes', 'Classe A', 'Diesel, manuelle, 3 portes, GPS, Siège chauffant, Forfait 1000km (0.2€ / km supplémentaires', 'classeA.jpg', 200),
(4, 5, 'Renault Megane 4', 'renault', 'megane 4', 'Diesel, manuelle, 3 portes, GPS, Siège chauffant, Forfait 1000km (0.2€ / km supplémentaires', 'megane4.jpg', 75),
(5, 3, 'Aston Martin DB11', 'aston_martin', 'DB 11', 'Essence, automatique, 3 portes, Toit ouvrants, Forfait 1000km (2€ / km supplémentaires', 'db11.jpg', 999),
(6, 2, 'BMW M4 X-tronic', 'bmw', 'M4', 'Essence, automatique, 5 portes, GPS, Toit ouvrants, Forfait 1000km (0.2€ / km supplémentaires', 'm4.jpg', 500),
(7, 4, 'Volkswagen Arteon', 'volkswagen', 'arteon', 'Diesel, automatique, 5 portes, GPS, Toit ouvrants, Forfait 1000km (0.2€ / km supplémentaires', 'arteon.jpg', 125),
(8, 1, 'Peugeot 308 Feline', 'peugeot', '308', 'Diesel, manuelle, 3 portes, GPS, Toit ouvrants, Forfait 1000km (0.2€ / km supplémentaires', '308.jpg', 65),
(9, 1, 'Mercedes GLS AMG', 'mercedes', 'GLS', 'Diesel, automatique, 5 portes, GPS, Toit ouvrants, Siège massant, Hammam, Forfait 1000km (0.2€ / km supplémentaires', 'gls.jpg', 295);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agences`
--
ALTER TABLE `agences`
  ADD PRIMARY KEY (`id_agence`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `membre` (`membre_id`),
  ADD KEY `vehicule` (`vehicule_id`),
  ADD KEY `agence_id` (`agence_id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id_vehicule`),
  ADD KEY `agence` (`agence_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agences`
--
ALTER TABLE `agences`
  MODIFY `id_agence` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`agence_id`) REFERENCES `agences` (`id_agence`),
  ADD CONSTRAINT `membre` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicule` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id_vehicule`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
