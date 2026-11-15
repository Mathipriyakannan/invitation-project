-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2026 at 10:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `athen_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `bags`
--

CREATE TABLE `bags` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `image_back` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bags`
--

INSERT INTO `bags` (`id`, `code`, `name`, `description`, `price`, `image`, `image_back`, `created_at`) VALUES
(1, 'T1', 'thambula pai', 'look like beatifull', 25.00, 'uploads/24fe72f0cb352908.jpg', NULL, '2026-10-19 11:21:08'),
(2, 'T2', 'Return bag', NULL, 0.00, 'uploads/830fdaf340c9ae07.jpg', NULL, '2026-10-21 11:09:04'),
(3, 'T3', 'Marrige return bag', NULL, 0.00, 'uploads/4e2e73c68667834f.jpg', NULL, '2026-10-21 11:09:32'),
(4, 'T4', 'Return bag', NULL, 0.00, 'uploads/b466285972d52492.jpg', NULL, '2026-10-21 11:09:59'),
(5, 'T5', 'Return bag', NULL, 0.00, 'uploads/cbd264121417fbde.jpg', NULL, '2026-10-21 11:10:25'),
(6, 'T6', 'gift bag', NULL, 0.00, 'uploads/721417f72b784eb5.jpg', NULL, '2026-10-21 11:10:47'),
(7, 'T7', 'gift return bag', NULL, 0.00, 'uploads/4592e21340204571.jpg', NULL, '2026-10-21 11:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `card_images` (extra photos for the View Book)
--

CREATE TABLE `card_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `card_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_no` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `type` varchar(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `image_back` varchar(255) DEFAULT NULL,
  `heading` varchar(200) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `code`, `type`, `name`, `description`, `price`, `image`, `image_back`, `created_at`) VALUES
(1, 'B1', 'birthday', 'Birthday card', '*\"Calling all little explorers! Help us wish [Child\'s Name] a happy **[Age]*th birthday! 🎈 Join us on [Date] from [Start Time] to [End Time] at [Venue/Home Address]. Cake, games, and snacks provided. Please RSVP to [Name/Number] by [Date]. (Let us know of any allergies!)\"', 20.00, 'uploads/cda3116012c6816d.jpg', NULL, '2026-10-19 10:44:30'),
(2, 'BS1', 'babyshower', 'Baby shower invitation', NULL, 0.00, 'uploads/d0448fb66bd9efb4.jpg', 'uploads/ecf441cbc66a7ef8.jpg', '2026-10-21 07:39:51'),
(3, 'S1', 'babyshower', 'Baby shower invitation', NULL, 0.00, 'uploads/c994627bbb44abac.jpg', NULL, '2026-10-21 10:16:20'),
(4, 'E1', 'earpiercing', 'Ear piercing', NULL, 0.00, 'uploads/da838beb708bb5b7.jpg', NULL, '2026-10-21 10:55:17'),
(5, 'W1', 'wedding', 'Marriage invitation', NULL, 0.00, 'uploads/7a2a7b1d115040a8.jpg', NULL, '2026-10-21 10:55:41'),
(6, 'W2', 'wedding', 'Marriage invitation', NULL, 0.00, 'uploads/91bbb236bae40532.jpg', NULL, '2026-10-21 10:56:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bags`
--
ALTER TABLE `bags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `card_images`
--
ALTER TABLE `card_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bags`
--
ALTER TABLE `bags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `card_images`
--
ALTER TABLE `card_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
