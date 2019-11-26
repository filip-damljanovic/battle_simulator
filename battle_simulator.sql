-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2019 at 04:08 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `battle_simulator`
--

-- --------------------------------------------------------

--
-- Table structure for table `armies`
--

CREATE TABLE `armies` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `units` int(3) NOT NULL,
  `attack_strategy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `armies`
--

INSERT INTO `armies` (`id`, `game_id`, `name`, `units`, `attack_strategy`) VALUES
(1, 1, 'Army 1', 86, 'random'),
(2, 1, 'Army 2', 82, 'strongest'),
(3, 1, 'Army 3', 82, 'strongest'),
(4, 1, 'Army 4', 82, 'random'),
(5, 1, 'Army 5', 93, 'weakest'),
(6, 1, 'Army 6', 88, 'random'),
(7, 1, 'Army 7', 94, 'random'),
(8, 1, 'Army 8', 98, 'strongest'),
(9, 1, 'Army 9', 98, 'random'),
(10, 1, 'Army 10', 92, 'random'),
(11, 2, 'Army 11', 92, 'random'),
(12, 2, 'Army 12', 86, 'strongest'),
(13, 2, 'Army 13', 86, 'strongest'),
(14, 2, 'Army 14', 96, 'weakest'),
(15, 2, 'Army 15', 83, 'random'),
(16, 2, 'Army 16', 89, 'strongest'),
(17, 2, 'Army 17', 86, 'random'),
(18, 2, 'Army 18', 92, 'random'),
(19, 2, 'Army 19', 85, 'strongest'),
(20, 2, 'Army 20', 99, 'weakest');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `game_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `game_name`, `game_status`) VALUES
(1, 'Battle 1', 'not started'),
(2, 'Battle 2', 'not started');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `armies`
--
ALTER TABLE `armies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `armies`
--
ALTER TABLE `armies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
