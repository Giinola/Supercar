-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 31 mars 2025 à 13:14
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `supercar`
--

-- --------------------------------------------------------

--
-- Structure de la table `voitures`
--

DROP TABLE IF EXISTS `voitures`;
CREATE TABLE IF NOT EXISTS `voitures` (
  `Idvoiture` int NOT NULL AUTO_INCREMENT,
  `Marques` varchar(200) DEFAULT NULL,
  `Modeles` varchar(200) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Prix` int DEFAULT NULL,
  PRIMARY KEY (`Idvoiture`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `voitures`
--

INSERT INTO `voitures` (`Idvoiture`, `Marques`, `Modeles`, `Description`, `Prix`) VALUES
(1, 'Ford', 'Ford Ranger Raptor', 'Le Ford Ranger Raptor est un pick-up haute performance conçu pour le tout-terrain. Avec son moteur bi-turbo diesel de 213 chevaux et une suspension Fox Racing, il offre une conduite stable et puissante sur les terrains les plus accidentés', 550),
(2, 'Ford', 'Ford F-150', 'Le Ford F-150 est un pick-up légendaire reconnu pour sa robustesse et sa polyvalence. Il offre une capacité de remorquage impressionnante, un intérieur confortable et des technologies avancées, idéales pour le travail et les loisirs', 60),
(3, 'Ford', 'Ford Focus', 'La Ford Focus est une berline dynamique et moderne. Avec ses motorisations économiques, son design aérodynamique et ses équipements high-tech, elle allie performance, confort et sécurité pour une conduite agréable en ville comme sur route', 28),
(4, 'Ford', 'Ford Explorer', 'Le Ford Explorer est un SUV spacieux et puissant conçu pour les familles et les aventuriers. Doté d’un moteur V6 hybride de 457 chevaux, d’une transmission intégrale et d’un intérieur haut de gamme avec écran tactile et sièges chauffants, il garantit un confort et une sécurité optimaux', 65),
(5, 'Nissan', 'Nissan Magnite', 'Le nissan magnite est un SUV de famille confort et magniable pour plaire à une famille', 90),
(6, 'Nissan', 'Nissan Magnite', 'Le nissan magnite est un SUV de famille confort et magniable pour plaire à une famille', 90),
(7, 'Nissan', 'Nissan Gtr34', 'Le nissan nissan_gtr34 est un voiture de course à modèle unique, faite pour les compétitions', 300),
(8, 'Nissan', 'Nissan Xtrail', 'Le Nissan X-Trail est un SUV compact. Il est apprécié pour son côté pratique, sa fiabilité et ses capacités tout-terrain', 80),
(9, 'Nissan', 'Nissan Qashqai', 'Avec leur design innovant, Nissan Qashqai reflètent votre mode de vie et sont parfaits pour la ville comme pour vos escapades en famille', 32),
(10, 'Toyta', 'Toyota RAV4', 'Le Toyota RAV4 est un SUV hybride combinant puissance et efficacité énergétique. Son design audacieux et son intérieur spacieux en font un choix idéal pour toutes les aventures', 36),
(11, 'Toyta', 'Toyota Corolla', 'La Toyota Corolla est une berline économique et fiable. Elle offre un excellent rendement énergétique, un confort moderne et des technologies avancées pour une conduite agréable', 24),
(12, 'Toyta', 'Toyota Camry', 'La Toyota Camry est une berline élégante et performante. Elle propose un habitacle spacieux, des technologies de pointe et un moteur dynamique pour une conduite fluide et confortable', 35),
(13, 'Toyta', 'Toyota Land Cruiser V8', 'Le Toyota Land Cruiser V8 est un SUV robuste et puissant, conçu pour affronter tous les terrains. Son moteur performant et son intérieur haut de gamme garantissent une expérience unique', 130);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
