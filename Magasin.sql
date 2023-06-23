-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 23 juin 2023 à 21:28
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Magasin`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `prix` varchar(10) NOT NULL,
  `quantite` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `prix`, `quantite`) VALUES
(2, '002', '1A.jpg', '100', '1');

-- --------------------------------------------------------

--
-- Structure de la table `Client`
--

CREATE TABLE `Client` (
  `ID` varchar(6) NOT NULL,
  `Nom` varchar(10) NOT NULL,
  `Tel` int(8) NOT NULL,
  `Ville` varchar(10) NOT NULL,
  `Adresse` varchar(30) NOT NULL,
  `type` int(6) NOT NULL,
  `Password` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Client`
--

INSERT INTO `Client` (`ID`, `Nom`, `Tel`, `Ville`, `Adresse`, `type`, `Password`) VALUES
('001', 'boucht', 659455322, 'Temara', 'hay al maghreb al arabi', 1, 1),
('002', 'masmoudi', 678956748, 'rabat', 'hay riad', 0, 0),
('003', 'boucht', 678576487, 'temara', 'hay al maghreb al arabi ', 0, 0),
('004', 'wijdane', 699887766, 'sale', 'hay salam', 1, 123),
('006', 'malak', 678564788, 'agadir', 'hay salam', 0, 444);

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

CREATE TABLE `Commande` (
  `Num` int(10) NOT NULL,
  `Date` varchar(25) NOT NULL,
  `Numclt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Commande`
--

INSERT INTO `Commande` (`Num`, `Date`, `Numclt`) VALUES
(21, '1683806022', '002');

-- --------------------------------------------------------

--
-- Structure de la table `Lignedecommande`
--

CREATE TABLE `Lignedecommande` (
  `Refprod` varchar(10) NOT NULL,
  `Numcmd` int(10) NOT NULL,
  `Quantité` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Lignedecommande`
--

INSERT INTO `Lignedecommande` (`Refprod`, `Numcmd`, `Quantité`) VALUES
('1A.jpg', 21, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Produit`
--

CREATE TABLE `Produit` (
  `Référence` varchar(6) NOT NULL,
  `Prix` int(5) NOT NULL,
  `Désignation` varchar(30) NOT NULL,
  `Catégorie` varchar(30) NOT NULL,
  `Prixacquisition` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Produit`
--

INSERT INTO `Produit` (`Référence`, `Prix`, `Désignation`, `Catégorie`, `Prixacquisition`) VALUES
('1A.jpg', 100, 'spinach', 'herb', 10),
('2A.jpg', 500, 'sunflower', 'flower', 2000),
('A3.jpg', 50, 'carotte', 'legume', 10),
('A4.jpg', 40, 'basil', 'herb', 20),
('A5.jpg', 123, 'tomate', 'legume', 12),
('A6.jpg', 190, 'cosmos', 'flower', 160),
('A7.jpg', 579, 'thyme', 'herb', 500),
('A8.jpg', 50, 'orangis', 'flower', 30),
('A9.jpg', 6, 'lettuce', 'legume', 1),
('c.jpg', 60, 'chia ', 'seed', 30),
('co.jpg', 30, 'coffee', 'seed', 10),
('cp.jpg', 40, 'test', 'meuble', 30),
('p.jpg', 40, 'pepita', 'seed', 30);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cle` (`product_id`),
  ADD KEY `cle2` (`user_id`);

--
-- Index pour la table `Client`
--
ALTER TABLE `Client`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD PRIMARY KEY (`Num`),
  ADD KEY `Numclt` (`Numclt`);

--
-- Index pour la table `Lignedecommande`
--
ALTER TABLE `Lignedecommande`
  ADD PRIMARY KEY (`Refprod`,`Numcmd`);

--
-- Index pour la table `Produit`
--
ALTER TABLE `Produit`
  ADD PRIMARY KEY (`Référence`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `Num` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cle` FOREIGN KEY (`product_id`) REFERENCES `Produit` (`Référence`),
  ADD CONSTRAINT `cle2` FOREIGN KEY (`user_id`) REFERENCES `Client` (`ID`);

--
-- Contraintes pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD CONSTRAINT `Numclt` FOREIGN KEY (`Numclt`) REFERENCES `Client` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
