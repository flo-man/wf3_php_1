-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 08, 2020 at 12:28 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `immobilier`
--

-- --------------------------------------------------------

--
-- Table structure for table `logement`
--

CREATE TABLE `logement` (
  `id_logement` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `cp` int(11) NOT NULL,
  `surface` int(11) NOT NULL,
  `prix` float NOT NULL,
  `photo` varchar(250) NOT NULL,
  `type` enum('loc','vente') NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logement`
--

INSERT INTO `logement` (`id_logement`, `titre`, `adresse`, `ville`, `cp`, `surface`, `prix`, `photo`, `type`, `description`) VALUES
(7, 'Maison de vacances', '78 rue des batignolles', 'Aix-en-Provence', 13100, 75, 300000, 'photos/logement_08-09-2020_10:14:48.jpg.jpg', 'loc', 'Avec piscine'),
(8, 'Super Appart', '99 rue de rivoli', 'Paris', 75001, 80, 2500, 'photos/logement_08-09-2020_10:16:15.jpg.jpg', 'loc', 'Idéalement situé'),
(9, 'Super Maison', '49 rue de la liberté', 'Vincennes', 94300, 110, 1200000, 'photos/logement_08-09-2020_10:17:23.jpg.jpg', 'vente', 'À 2 pas'),
(10, 'Deuxième Appart', '100 rue de rome', 'Paris', 75009, 35, 1200, 'photos/logement_08-09-2020_10:56:43.png.png', 'loc', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos tempore dolores modi laborum et facilis ratione excepturi aut dolore assumenda placeat aliquam rem ducimus, quaerat quae omnis sit vel autem. Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae illo obcaecati ullam ab quo aut voluptatibus nesciunt accusantium praesentium fugit beatae tenetur, quia reiciendis culpa distinctio, ratione nulla perferendis dolore.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logement`
--
ALTER TABLE `logement`
  ADD PRIMARY KEY (`id_logement`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logement`
--
ALTER TABLE `logement`
  MODIFY `id_logement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
