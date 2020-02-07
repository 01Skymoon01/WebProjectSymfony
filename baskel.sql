-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 07, 2020 at 10:35 PM
-- Server version: 5.7.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baskel`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `ref_c` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ref_c`),
  KEY `libelle` (`libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ref_c`, `libelle`) VALUES
(123, 'Equipements');

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `ref_p` int(11) NOT NULL,
  `nom_p` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `genre_p` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `couleur_p` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantite_p` int(11) NOT NULL,
  `prix_p` double NOT NULL,
  `marque_p` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_c` int(11) NOT NULL,
  PRIMARY KEY (`ref_p`),
  KEY `IDX_BE2DDF8CEC0A8568` (`ref_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`ref_p`, `nom_p`, `genre_p`, `couleur_p`, `quantite_p`, `prix_p`, `marque_p`, `ref_c`) VALUES
(1552, 'Casque', 'Homme', 'Noir', 526, 35, 'Bern Union', 123),
(563210, 'dqsdqsd', 'qsfqsvdxc', 'dfhgdfh', 16, 18, 'azfazfqsqf', 123),
(15527777, 'dsfvsdg', 'sdvwsdbsd', 'bdsfbfwdcxbd', 45, 55, 'bfbsfb<', 123),
(53423415, 'fsdfsd', 'dsfsdf', 'sdfsf', 25, 120, 'qsfqsf', 123);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `FK_BE2DDF8CEC0A8568` FOREIGN KEY (`ref_c`) REFERENCES `categories` (`ref_c`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
