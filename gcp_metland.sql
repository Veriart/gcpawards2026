-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 03:31 AM
-- Server version: 8.1.0
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gcp_metland`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `classroom` varchar(50) NOT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `rsvp_status` varchar(20) DEFAULT 'Pending',
  `companion_type` varchar(50) DEFAULT 'none',
  `checked_in` tinyint(1) DEFAULT '0',
  `checked_in_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `code`, `name`, `classroom`, `whatsapp`, `rsvp_status`, `companion_type`, `checked_in`, `checked_in_at`, `created_at`) VALUES
(1, 'GCP-BTAZW', 'NAYLA ZAHRATUSSHITA HERMAWAN', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(2, 'GCP-842H5', 'ANISA HERPIAH', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(3, 'GCP-TJZGQ', 'KALYCA SASHIKIRANA', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(4, 'GCP-NHZKL', 'ADE GUSTI PRIYATNA', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(5, 'GCP-DJWUQ', 'MICHELLE GRACELINA JESLIN', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(6, 'GCP-43MG8', 'REIVADISTY AZKIA FAIRUZ', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(7, 'GCP-FWLHK', 'Kenzie Lauwijaya', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(8, 'GCP-EX36Q', 'TIARA NUR FEBRIANA', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(9, 'GCP-3UXMM', 'Chelsea Viorenza', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(10, 'GCP-LYYGD', 'MELIANA GRACELLA', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(11, 'GCP-5G8K2', 'JENNIFER', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(12, 'GCP-8L4P9', 'MUHAMMAD RASYA ARAFI', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(13, 'GCP-P7DBL', 'ALISHA NURHIDAYAH', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(14, 'GCP-BFLQL', 'Abshar Nabil Kurniawan', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(15, 'GCP-D7HWU', 'Nadine Nakeisha Aurel Haloana\'a', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(16, 'GCP-WZZBR', 'NARENDRAPUTRA AKBAR MAULANA IBROHIM', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(17, 'GCP-4MDUP', 'YEREMIA DANIEL LIKUMAHUA', 'XII HOS 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(18, 'GCP-UASR4', 'SYAHLA SALWA NAFEEZA', 'XII HOS 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(19, 'GCP-RDT5W', 'Helceira Gracia Rhemrev', 'XII HOS 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(20, 'GCP-YDH5P', 'ABIGAEL JOCELYN NAINGGOLAN', 'XII HOS 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(21, 'GCP-82LEE', 'GAFFARA DIANDRA AL JERBI', 'XII HOS 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(22, 'GCP-F9RPW', 'Citra Putri Lestari', 'XII HOS 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(23, 'GCP-3GGV9', 'LOVELY PERMATA HALLATU', 'XII HOS 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(24, 'GCP-LGFH7', 'TATA BANGSA PUTRA VIDYA', 'XII HOS 3', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(25, 'GCP-38MSN', 'DEWI SETIANINGSIH', 'XII HOS 3', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(26, 'GCP-JCR6N', 'CALLISTA OCTAVIA ANGELINE', 'XII HOS 3', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(27, 'GCP-7FYQN', 'AFGAN SYAHREZA', 'XII HOS 3', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(28, 'GCP-V9PKU', 'Azra Ryan Setiansyah', 'XII HOS 3', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(29, 'GCP-RT8UN', 'Muhamad Alfarizi Singgih', 'XII HOS 3', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(30, 'GCP-CJG25', 'IGNASIUS JULIO ABIGEL AUDYANTORO', 'XII DKV 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(31, 'GCP-CMJ6P', 'NATHANAEL BAGAWANTA', 'XII DKV 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(32, 'GCP-ZDKTU', 'MUHAMMAD FADILLAH RASYID', 'XII DKV 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(33, 'GCP-Z6JNV', 'M DAFFA HABIBI HARAHAP', 'XII DKV 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(34, 'GCP-2JUDE', 'SYAFIQA NAILINA ZAHWA', 'XII DKV 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(35, 'GCP-WG6D5', 'KALINDA TUNGGA FENURA PRAKOSO', 'XII DKV 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(36, 'GCP-HDVAT', 'BILQIS NINDIRA SYAKILA', 'XII DKV 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(37, 'GCP-SAMR4', 'Clarissa Feodora Tanjaya', 'XII PPLG 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(38, 'GCP-3FQWR', 'ALIF NURHIDAYAT', 'XII PPLG 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(39, 'GCP-42NBA', 'BAMBANG WIJAYA PRINARI', 'XII PPLG 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(40, 'GCP-XQGAA', 'JONATHAN SAMUEL', 'XII PPLG 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(41, 'GCP-RG8MA', 'Jibril Nasrullah', 'XII PPLG 1', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(42, 'GCP-GZ2PC', 'BILLY IBRAHIM JOUAQIN', 'XII PPLG 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(43, 'GCP-3H6RQ', 'Valentino Setiawan', 'XII PPLG 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(44, 'GCP-2G9KJ', 'ARDENTA PRADA NIRVANA', 'XII PPLG 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(45, 'GCP-7LRB5', 'SAMAHITA YUMNA ACINTYA', 'XII PPLG 2', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 08:44:03'),
(46, 'GCP-5TGXZ', 'test', 'XII AKT', NULL, 'Pending', 'none', 0, NULL, '2026-06-15 09:00:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$12$emtmoPlIHZ4C9Ti9vgv2fe1Mkll8GPpXiXZkUVLAMS9MzP6t8FBzO', '2026-06-15 08:44:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
