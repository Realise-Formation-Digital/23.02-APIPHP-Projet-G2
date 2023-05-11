-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : maria_db:3306
-- Généré le : jeu. 11 mai 2023 à 07:17
-- Version du serveur : 10.11.2-MariaDB-1:10.11.2+maria~ubu2204
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `beers_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `beers`
--

CREATE TABLE `beers` (
  `id` int(255) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `tagline` varchar(50) NOT NULL,
  `first_brewed` text NOT NULL,
  `description` varchar(250) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `brewers_tips` varchar(500) NOT NULL,
  `contributed_by` varchar(50) NOT NULL,
  `food_pairing` varchar(50) DEFAULT NULL,
  `food_pairing2` varchar(50) DEFAULT NULL,
  `food_pairing3` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `beers`
--

INSERT INTO `beers` (`id`, `name`, `tagline`, `first_brewed`, `description`, `image_url`, `brewers_tips`, `contributed_by`, `food_pairing`, `food_pairing2`, `food_pairing3`) VALUES
(3, 'Trashy Blonde', 'You Know You Shouldn\'t', '04/2008', 'A titillating, neurotic, peroxide punk of a Pale Ale. ', 'https://images.punkapi.com/v2/2.png', 'Be careful not to collect too much wort from the mash. Once the sugars are all washed out there are some very unpleasant grainy tasting compounds that can be extracted into the wort.', 'Sam Mason <samjbmason>', 'Fresh crab with lemon', 'Goats cheese salad', 'Creamy lemon bar doused in powdered sugar'),
(7, 'Buzz', 'A Real Bitter Experience.', '09/2007', 'A light, crisp and bitter IPA brewed with English and American hops. A small batch brewed only once.', 'https://images.punkapi.com/v2/keg.png', 'The earthy and floral aromas from the hops can be overpowering. Drop a little Cascade in at the end of the boil to lift the profile with a bit of citrus.', 'Sam Mason <samjbmason>', 'Spicy chicken tikka masala', 'Grilled chicken quesadilla', 'Caramel toffee cake'),
(8, 'Trashy Blonde', 'You Know You Shouldn\'t', '04/2008', 'A titillating, neurotic, peroxide punk of a Pale Ale. ', 'https://images.punkapi.com/v2/2.png', 'Be careful not to collect too much wort from the mash. Once the sugars are all washed out there are some very unpleasant grainy tasting compounds that can be extracted into the wort.', 'Sam Mason <samjbmason>', 'Fresh crab with lemon', 'Goats cheese salad', 'Creamy lemon bar doused in powdered sugar');

-- --------------------------------------------------------

--
-- Structure de la table `beer_ingredient`
--

CREATE TABLE `beer_ingredient` (
  `beer_id` int(255) NOT NULL,
  `ingredient_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `beer_ingredient`
--

INSERT INTO `beer_ingredient` (`beer_id`, `ingredient_id`) VALUES
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(255) NOT NULL,
  `type` enum('malt','hops') NOT NULL,
  `name_ing` varchar(50) NOT NULL,
  `amount_value` float(255,1) NOT NULL,
  `amount_unit` varchar(15) NOT NULL,
  `amount_add` varchar(15) DEFAULT NULL,
  `amount_attribute` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id`, `type`, `name_ing`, `amount_value`, `amount_unit`, `amount_add`, `amount_attribute`) VALUES
(1, 'malt', 'Maris Otter Extra Pale', 3.3, 'kilograms', NULL, NULL),
(3, 'hops', 'Fuggles', 25.0, 'grams', NULL, NULL),
(4, 'hops', 'First Gold', 25.0, 'grams', NULL, NULL),
(5, 'malt', 'hoops<fkjhg', 3.3, 'kilograms', '', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `beers`
--
ALTER TABLE `beers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `beer_ingredient`
--
ALTER TABLE `beer_ingredient`
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `beer_id` (`beer_id`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `beers`
--
ALTER TABLE `beers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `beer_ingredient`
--
ALTER TABLE `beer_ingredient`
  ADD CONSTRAINT `beer_ingredient_ibfk_1` FOREIGN KEY (`beer_id`) REFERENCES `beers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beer_ingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;