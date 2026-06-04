-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2026 at 06:28 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `batman_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `animated series`
--

CREATE TABLE `animated series` (
  `series_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `start_year` year(4) NOT NULL,
  `end_year` year(4) NOT NULL,
  `description` varchar(100) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

CREATE TABLE `artworks` (
  `artwork_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quote` text NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artworks`
--

INSERT INTO `artworks` (`artwork_id`, `title`, `image`, `quote`, `last_updated_by`, `updated_at`) VALUES
(1, 'The Batman: Wounded', 'img/artwork3_1.jpg', 'N/A', 1, '2026-05-30 07:59:27'),
(2, 'Batman V1', 'img/Batman_Cv1_Variant_Tedesco.jpg', 'N/A', 1, '2026-05-30 08:02:25'),
(4, 'Batman by BlondTheColorist', 'img/Batman_BlondTheColorist_1.jpg', 'N/A', 1, '2026-05-30 08:24:13'),
(5, 'Batman (ArkhamVerse)', 'img/Batman_AO.jpg', 'N/A', 1, '2026-05-30 15:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `comics`
--

CREATE TABLE `comics` (
  `comic_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `release_year` year(4) NOT NULL,
  `writer` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `cover_image` varchar(100) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comics`
--

INSERT INTO `comics` (`comic_id`, `title`, `release_year`, `writer`, `description`, `cover_image`, `last_updated_by`, `updated_at`) VALUES
(1, 'Absolute Batman', 2024, 'Scott Snyder', 'The Batman (real name Bruce Wayne) is a vigilante who works as a blue-collar civil engineer in his civilian identity. Using an arsenal of personally-crafted weaponry and vehicles, combat expertise, and genius intellect, he works to protect Gotham City from crime and the wealthy interests seeking to exploit its people.', 'img/absolute_1.png', 1, '2026-05-30 07:31:31'),
(2, 'Batman: The Killing Joke', 1988, 'Alan Moore', 'Batman: The Killing Joke (1988) explores the psychological battle between Batman and Joker, focusing on the latter\'s attempt to drive Commissioner Gordon insane following a brutal attack on Barbara Gordon. The narrative contrasts a potential origin for the Joker with a present-day confrontation, culminating in a heavily debated ending where Batman and Joker share a moment of laughter. Watch a breakdown of the story at', 'img/killingjoke1_1.jpg', 1, '2026-05-30 07:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `live action movies`
--

CREATE TABLE `live action movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `release_year` year(4) NOT NULL,
  `director` varchar(50) NOT NULL,
  `actor` varchar(100) NOT NULL,
  `source_material` int(11) NOT NULL,
  `description` text NOT NULL,
  `poster` varchar(100) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `live action movies`
--

INSERT INTO `live action movies` (`movie_id`, `title`, `release_year`, `director`, `actor`, `source_material`, `description`, `poster`, `last_updated_by`, `updated_at`) VALUES
(1, 'The Dark Knight', 2008, 'Christopher Nolan', 'Christian Bale, Heath Ledger, Aaron Eckhart', 42, 'The Dark Knight is a 2008 superhero film directed by Christopher Nolan. It follows Batman (Christian Bale), police Lt. James Gordon (Gary Oldman), and District Attorney Harvey Dent (Aaron Eckhart) as they battle to dismantle Gotham City\'s mob, only to face total chaos unleashed by a sadistic, anarchic mastermind known as The Joker (Heath Ledger)', 'img/movie1_1.jpg', 1, '2026-05-30 08:19:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`) VALUES
(1, 'Vinciboi30', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user'),
(2, 'PaulAdarlo30', '472bbe83616e93d3c09a79103ae47d8f71e3d35a966d6e8b22f743218d04171d', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animated series`
--
ALTER TABLE `animated series`
  ADD PRIMARY KEY (`series_id`),
  ADD KEY `last_updated_by` (`last_updated_by`);

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`artwork_id`);

--
-- Indexes for table `comics`
--
ALTER TABLE `comics`
  ADD PRIMARY KEY (`comic_id`),
  ADD KEY `last_updated_by` (`last_updated_by`);

--
-- Indexes for table `live action movies`
--
ALTER TABLE `live action movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD KEY `last_updated_by` (`last_updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animated series`
--
ALTER TABLE `animated series`
  MODIFY `series_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `artwork_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comics`
--
ALTER TABLE `comics`
  MODIFY `comic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `live action movies`
--
ALTER TABLE `live action movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animated series`
--
ALTER TABLE `animated series`
  ADD CONSTRAINT `fk_user2_id` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comics`
--
ALTER TABLE `comics`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `live action movies`
--
ALTER TABLE `live action movies`
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
