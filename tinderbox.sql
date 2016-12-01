-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 01, 2016 at 11:36 PM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinderbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `a_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `content` text COLLATE utf8_danish_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`a_id`, `u_id`, `content`, `datetime`, `status`) VALUES
(1, 2, 'To all social media managers!!!\r\nRemember to share the tinderbox facebook page on all social media, and use the hashtag #tinderbox', '2016-11-28 11:36:20', 1),
(2, 3, 'Remember to use the official tinderbox hashtag: #tinderbox', '2016-11-21 13:18:38', 1),
(3, 3, 'Guys, i forgot the password to the tinderbox instagram account, PLS HALP!!', '2016-11-30 12:14:23', 0),
(4, 2, 'You really know nothing Jon Snow', '2016-11-30 12:17:26', 0),
(5, 3, 'Never mind, I found it again, had it written down somewhere.', '2016-11-30 12:19:10', 0),
(6, 1, 'To all other bartenders, remember to check if everyone you serve, is over 18', '2016-12-01 16:25:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `r_id` int(11) NOT NULL,
  `role` varchar(50) COLLATE utf8_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`r_id`, `role`) VALUES
(1, 'facebook manager'),
(2, 'instagram ambassador'),
(3, 'bartender');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `u_id` int(11) NOT NULL,
  `si_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`u_id`, `si_id`) VALUES
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_item`
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
-- Dumping data for table `schedule_item`
--

INSERT INTO `schedule_item` (`si_id`, `t_id`, `task`, `start`, `end`, `location`) VALUES
(1, 2, 'SCRUM meeting', '2016-12-01 06:00:00', '2016-12-01 23:59:00', 'social media office'),
(2, 2, 'SCRUM meeting', '2016-12-02 06:00:00', '2016-12-02 07:00:00', 'social media office'),
(3, 2, 'SCRUM meeting', '2016-12-03 06:00:00', '2016-12-03 07:00:00', 'social media office'),
(4, 2, 'SCRUM meeting', '2016-12-04 06:00:00', '2016-12-04 07:00:00', 'social media office'),
(5, 2, 'SCRUM meeting', '2016-12-05 06:00:00', '2016-12-05 07:00:00', 'social media office');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `t_id` int(11) NOT NULL,
  `team` varchar(50) COLLATE utf8_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`t_id`, `team`) VALUES
(1, 'service team'),
(2, 'social media team');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT '1',
  `r_id` int(11) NOT NULL DEFAULT '1',
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `t_id`, `r_id`, `fname`, `lname`, `email`, `password`, `birthdate`, `phone`, `shirt_size`, `shoe_size`) VALUES
(1, 1, 3, 'John', 'Doe', 'john@doe.com', '$2y$10$0X21pVdIxeol6Goh2lX/o.kDSHdIrPtMvb4SnZHnnqd2nXCfQB7Em', '1969-06-06', '12345678', 'l', '42'),
(2, 2, 1, 'Jane', 'Doe', 'jane@doe.com', '$2y$10$RhmjZSGObPyJkOY0xAAmuOsFP9s5eKjJ1iHwSuLje0c1A7nkBz9Hy', '1975-08-12', '87654321', 'm', '39'),
(3, 2, 2, 'Jon', 'Snow', 'jon@snow.com', '$2y$10$slz7mD9iyrQLoRU0aenwwO4yHFvHAtwHvetMrcORU.59VnW36GJiy', '1955-03-27', '12348765', 'xl', '45');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `token` varchar(35) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`token`, `u_id`) VALUES
('164940bd33bf209c0f99e82683e0ff08', 2),
('a21b1661dbd28b61d8b4c9631b0ce563', 1),
('c082f8ef7edb7975f89f6ab489b9caf9', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `schedule_item`
--
ALTER TABLE `schedule_item`
  ADD PRIMARY KEY (`si_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD UNIQUE KEY `tokens` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `schedule_item`
--
ALTER TABLE `schedule_item`
  MODIFY `si_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
