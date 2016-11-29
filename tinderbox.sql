-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Vært: localhost
-- Genereringstid: 23. 11 2016 kl. 15:45:06
-- Serverversion: 5.7.16-0ubuntu0.16.04.1
-- PHP-version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinderbox`
--
-- DROP DATABASE IF EXISTS 'tinderbox';
-- CREATE DATABASE IF NOT EXISTS DBName;
-- USE DBName - Creater DB såfremt denne ikke findes i forvejen
-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `announcements`
--

CREATE TABLE `announcements` (
  `a_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `content` text COLLATE utf8_danish_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `role`
--

CREATE TABLE `role` (
  `r_id` int(11) NOT NULL,
  `role` varchar(50) COLLATE utf8_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Data dump for tabellen `role`
--

INSERT INTO `role` (`r_id`, `role`) VALUES
(1, 'role1'),
(2, 'role2'),
(3, 'role1'),
(4, 'role2');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `schedule`
--

CREATE TABLE `schedule` (
  `u_id` int(11) NOT NULL,
  `si_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Data dump for tabellen `schedule`
--

INSERT INTO `schedule` (`u_id`, `si_id`) VALUES
(5, 1),
(6, 2),
(5, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `schedule_item`
--

CREATE TABLE `schedule_item` (
  `si_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `task` varchar(100) COLLATE utf8_danish_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `location` varchar(50) COLLATE utf8_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Data dump for tabellen `schedule_item`
--

INSERT INTO `schedule_item` (`si_id`, `t_id`, `task`, `start`, `end`, `location`) VALUES
(1, 1, 'Rake furiously', '2016-11-24 12:00:00', '2016-11-24 17:00:00', 'Rune\'s yard'),
(2, 1, 'rake leaves', '2016-11-25 09:00:00', '2016-11-26 06:00:00', 'Odense banegård'),
(3, 1, 'sweep streets', '2016-11-22 09:00:00', '2016-11-22 15:00:00', 'everywhere'),
(4, 1, 'Dance', '2016-11-25 07:00:00', '2016-11-25 16:00:00', 'everywhere');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `team`
--

CREATE TABLE `team` (
  `t_id` int(11) NOT NULL,
  `team` varchar(50) COLLATE utf8_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Data dump for tabellen `team`
--

INSERT INTO `team` (`t_id`, `team`) VALUES
(1, 'team1'),
(2, 'team2');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_danish_ci NOT NULL,
  `birthdate` date NOT NULL,
  `phone` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `shirt_size` varchar(10) COLLATE utf8_danish_ci NOT NULL,
  `shoe_size` varchar(10) COLLATE utf8_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`u_id`, `t_id`, `r_id`, `fname`, `lname`, `email`, `password`, `birthdate`, `phone`, `shirt_size`, `shoe_size`) VALUES
(5, 1, 1, 'John', 'McClane', 'notacop@awesome.org', '$2y$10$ecq2KPTOCBEZW8qr6N1b/OkQJYL0kYsD5NXt2YGwIsU2LIvqVRxK2', '1965-01-01', '88888888', 'XL', '90');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_tokens`
--

CREATE TABLE `user_tokens` (
  `token` varchar(35) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user_tokens`
--

INSERT INTO `user_tokens` (`token`, `u_id`) VALUES
('d77b729e9ca10e07a887ddb77de9e448', 5);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`a_id`);

--
-- Indeks for tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`r_id`);

--
-- Indeks for tabel `schedule_item`
--
ALTER TABLE `schedule_item`
  ADD PRIMARY KEY (`si_id`);

--
-- Indeks for tabel `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`t_id`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks for tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD UNIQUE KEY `tokens` (`token`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `role`
--
ALTER TABLE `role`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `schedule_item`
--
ALTER TABLE `schedule_item`
  MODIFY `si_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `team`
--
ALTER TABLE `team`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
