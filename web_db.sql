-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 10:28 PM
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
-- Database: `web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artistID` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `artistSlug` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artistID`, `name`, `artistSlug`) VALUES
(1, 'Red Leather', 'red-leather');

-- --------------------------------------------------------

--
-- Table structure for table `feats`
--

CREATE TABLE `feats` (
  `songID` int(11) NOT NULL,
  `artistID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genreID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genreID`, `name`) VALUES
(1, 'Rock');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `songID` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `artistID` int(11) NOT NULL,
  `genreID` int(11) NOT NULL,
  `styleID` int(11) NOT NULL,
  `songSlug` varchar(80) NOT NULL,
  `hasFeat` bit(1) NOT NULL DEFAULT b'0',
  `createdBy` int(11) NOT NULL,
  `creationTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`songID`, `title`, `artistID`, `genreID`, `styleID`, `songSlug`, `hasFeat`, `createdBy`, `creationTimestamp`) VALUES
(1, 'Bonnie And Clyde', 1, 1, 1, 'bonnie-and-clyde', b'0', 0, '2025-06-03 20:30:40'),
(2, 'Cant Get High', 1, 1, 1, 'cant-get-high', b'0', 0, '2025-06-03 20:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `styles`
--

CREATE TABLE `styles` (
  `styleID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `styles`
--

INSERT INTO `styles` (`styleID`, `name`) VALUES
(1, 'Alternative Rock');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(36) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1 COMMENT '1 - USER | 2 - MODERATOR | 3- ADMIN | 4 - OWNER | 5 - SYSTEM',
  `creationTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `username`, `passwordHash`, `role`, `creationTimestamp`) VALUES
(0, 'System', 'System', 'System', 5, '0000-00-00 00:00:00'),
(1, 'm.koncak.st@spseiostrava.cz', 'matias.koncak', '$2y$10$Xd4A6wUZwtMQRhfkRNjF8OSxFgJ2X52uyz5wS3sQ4PxbSlebxjdOu', 4, '2025-05-11 15:02:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artistID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`artistSlug`),
  ADD UNIQUE KEY `artistSlug` (`artistSlug`);

--
-- Indexes for table `feats`
--
ALTER TABLE `feats`
  ADD PRIMARY KEY (`songID`,`artistID`),
  ADD KEY `featsArtists` (`artistID`),
  ADD KEY `songID` (`songID`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genreID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`songID`),
  ADD UNIQUE KEY `songSlug` (`songSlug`),
  ADD KEY `songsGenres` (`genreID`),
  ADD KEY `songsStyles` (`styleID`),
  ADD KEY `songsArtists` (`artistID`),
  ADD KEY `songsUsers` (`createdBy`);

--
-- Indexes for table `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`styleID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `songID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `styles`
--
ALTER TABLE `styles`
  MODIFY `styleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feats`
--
ALTER TABLE `feats`
  ADD CONSTRAINT `featsArtists` FOREIGN KEY (`artistID`) REFERENCES `artists` (`artistID`),
  ADD CONSTRAINT `featsSongs` FOREIGN KEY (`songID`) REFERENCES `songs` (`songID`);

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songsArtists` FOREIGN KEY (`artistID`) REFERENCES `artists` (`artistID`),
  ADD CONSTRAINT `songsGenres` FOREIGN KEY (`genreID`) REFERENCES `genres` (`genreID`),
  ADD CONSTRAINT `songsStyles` FOREIGN KEY (`styleID`) REFERENCES `styles` (`styleID`),
  ADD CONSTRAINT `songsUsers` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
