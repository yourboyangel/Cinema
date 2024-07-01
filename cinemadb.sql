-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 01:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinemadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `MovieID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Genre` varchar(100) DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `Rating` decimal(2,1) DEFAULT NULL,
  `ImageName` varchar(255) DEFAULT NULL,
  `TrailerLink` varchar(255) DEFAULT NULL,
  `CinemaRoom` enum('1','2','3','4','5','6','7') DEFAULT NULL,
  `Screening` datetime DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`MovieID`, `Title`, `Genre`, `Duration`, `Rating`, `ImageName`, `TrailerLink`, `CinemaRoom`, `Screening`, `Description`) VALUES
(7, 'Jujutsu Kaisen 0: The Movie', 'Animation', 105, 7.8, '664d9681ac986.jpg', 'https://www.youtube.com/watch?v=UPRqnFnnrr8', '4', '2024-05-26 22:55:00', 'The prequel to Jujutsu Kaisen (2020), where a high schooler gains control of an extremely powerful cursed spirit and gets enrolled in the Tokyo Prefectural Jujutsu High School by Jujutsu Sorcerers.'),
(8, 'Attack On Titan', 'Animation', 100, 9.1, '664d9a3349bda.jpg', 'https://www.youtube.com/watch?v=LV-nazLVmgo', '2', '2024-05-26 21:00:00', 'After his hometown is destroyed and is traumatized, young Eren Jaeger vows to cleanse the earth of the giant humanoid Titans that have brought humanity to the brink of extinction.'),
(9, 'Naruto Shippuden3: Inheritors of the Will of Fire', 'Animation', 95, 7.0, '664d9c22ed062.jpg', 'https://www.youtube.com/watch?v=tCW_TD7dy98', '3', '2024-05-27 22:30:00', 'Ninjas with bloodline limits begin disappearing in all the countries and blame points toward the fire nation. By Tsunades order, Kakashi is sacrificed to prevent an all out war. Naruto fights through friends and foes to prevent his death.'),
(10, 'Dragon Ball Super: Broly', 'Animation', 100, 7.7, '664d9cf171b35.jpg', 'https://www.youtube.com/watch?v=FHgm89hKpXU', '6', '2024-05-27 22:30:00', 'Goku and Vegeta encounter Broly, a Saiyan warrior unlike any fighter they have faced before.'),
(11, 'Ride Along', 'Action', 99, 6.1, '664d9ef300c4c.jpg', 'https://www.youtube.com/watch?v=5klp6rkHIks', '5', '2024-05-29 21:30:00', 'Security guard Ben must prove himself to his girlfriends brother, top police officer James. He rides along James on a 24-hour patrol of Atlanta.'),
(13, 'Ford VS Ferrari', 'Action', 152, 8.1, '664da178e840f.jpg', 'https://www.youtube.com/watch?v=4aY0dW3hpRc', '6', '2024-05-29 15:45:00', 'American car designer Carroll Shelby and driver Ken Miles battle corporate interference and the laws of physics to build a revolutionary race car for Ford in order to defeat Ferrari at the 24 Hours of Le Mans in 1966.'),
(14, 'Disturbia', 'Crime', 105, 6.8, '664da385bdd2e.jpg', 'https://www.youtube.com/watch?v=gZWjvseFptg', '5', '2024-05-30 14:50:00', 'When a teenager is placed under house arrest, he succumbs to despair and starts spying on his neighbors, hoping to spice up his life. This, however, leads him to witness a serial killer on the loose.'),
(17, 'Dune: Part 2', 'Action', 166, 8.0, '664de8af9bc35.jpg', 'https://www.youtube.com/watch?v=_YUzQa_1RCE', '7', '2024-06-01 20:50:00', 'Paul Atreides unites with Chani and the Fremen while seeking revenge against the conspirators who destroyed his family.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `UserType` enum('admin','customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Email`, `PasswordHash`, `FullName`, `PhoneNumber`, `UserType`) VALUES
(4, 'engjell.abazaj007@gmail.com', '$2y$10$PcvMAbxmEPSOF5dVqLFUne9VSLcG.iNIRBQG3MOvgwYb6Rg/g8FsO', 'Engjell Abazaj', '0692407540', 'admin'),
(8, 'iferati@gmail.com', '$2y$10$XdGnhBDox9ER5LHOHPnjAupaq4dVuFkcQcEP6qa9eBc6WgwA/KLzm', 'Indrit Ferati', '0692407540', 'customer'),
(9, 'jbitri@gmail.com', '$2y$10$yBpCwejX3vhKeOGpslTzbO3MkxufjSZKoynURnRYvuYaHD4OsS9t.', 'Joel Bitri', '0692407540', 'customer'),
(10, 'olsi@olsi.ols', '$2y$10$q6ax6rEF953l9fumkUSyG.Jwrq3Hq3revxp8OtnboexQTFJwcTTAa', 'Olsi Shehu', '0699999999', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MovieID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `MovieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
