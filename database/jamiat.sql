-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 04:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jamiat`
--

-- --------------------------------------------------------

--
-- Table structure for table `appreciations`
--

CREATE TABLE `appreciations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appreciations`
--

INSERT INTO `appreciations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ممتاز', NULL, NULL),
(2, 'جید', '2024-11-05 01:13:09', '2024-11-05 01:13:09'),
(3, 'جید جدا', '2024-11-05 01:13:15', '2024-11-06 02:08:54'),
(4, 'مقبول', '2024-11-06 02:05:44', '2024-11-06 02:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `en_name` varchar(255) NOT NULL,
  `pa_name` varchar(255) NOT NULL,
  `da_name` varchar(255) NOT NULL,
  `ar_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `en_name`, `pa_name`, `da_name`, `ar_name`, `created_at`, `updated_at`) VALUES
(1, 'Pashto', 'پښتو', 'پشتو', 'البشتو', NULL, NULL),
(2, 'Dari', 'درِی', 'دری', 'الداري', NULL, NULL),
(3, 'Uzbek', 'اوزبکی', 'اوزبکي', 'الأوزبكية', NULL, NULL),
(4, 'Turkmen', 'ترکمنی', 'ترکمني', 'التركمانية', NULL, NULL),
(5, 'Balochi', 'بلوچی', 'بلوچي', 'البالوشية', NULL, NULL),
(6, 'Nuristani', 'نورستانی', 'نورستاني', 'النورستانية', NULL, NULL),
(7, 'Pashayi', 'پشه یی', 'پشه يي', 'الباشاية', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appreciations`
--
ALTER TABLE `appreciations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appreciations`
--
ALTER TABLE `appreciations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
