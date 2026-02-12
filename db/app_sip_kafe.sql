-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 12:29 AM
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
-- Database: `app_sip_kafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'ddyinnpalentin', 'delinpalentin02@gmail.com', '085840064684');

-- --------------------------------------------------------

--
-- Table structure for table `clustering`
--

CREATE TABLE `clustering` (
  `id_cluster` int(11) NOT NULL,
  `nama_file` varchar(100) DEFAULT NULL,
  `jumlah_cluster` int(11) DEFAULT NULL,
  `jumlah_data` int(11) DEFAULT NULL,
  `waktu_clustering` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clustering`
--

INSERT INTO `clustering` (`id_cluster`, `nama_file`, `jumlah_cluster`, `jumlah_data`, `waktu_clustering`) VALUES
(11, '2026-01-28_22-17-15_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-01-28 22:17:15'),
(12, '2026-01-28_22-38-35_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-01-28 22:38:35'),
(13, '2026-01-28_22-46-50_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-01-28 22:46:51'),
(14, '2026-01-28_22-52-25_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-01-28 22:52:25'),
(15, '2026-01-28_23-09-19_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-01-28 23:09:19'),
(16, '2026-02-10_12-21-06_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 12:21:06'),
(17, '2026-02-10_12-49-27_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 12:49:27'),
(18, '2026-02-10_12-57-11_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 12:57:11'),
(19, '2026-02-10_13-04-24_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 13:04:25'),
(20, '2026-02-10_13-15-11_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 13:15:12'),
(21, '2026-02-10_13-16-53_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 13:16:53'),
(22, '2026-02-10_13-17-25_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 13:17:25'),
(23, '2026-02-10_14-03-37_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 14:03:37'),
(24, '2026-02-10_14-08-42_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-10 14:08:42'),
(25, '2026-02-12_05-51-51_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-12 05:51:51'),
(26, '2026-02-12_06-16-27_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-12 06:16:27'),
(27, '2026-02-12_06-22-25_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-02-12 06:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_clustering`
--

CREATE TABLE `hasil_clustering` (
  `id_hasil` int(11) NOT NULL,
  `id_cluster` int(11) DEFAULT NULL,
  `id_kafe` int(11) DEFAULT NULL,
  `cluster` int(11) DEFAULT NULL,
  `jarak_centroid` float DEFAULT NULL,
  `peringkat_cluster` int(11) DEFAULT NULL,
  `rating_akhir` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_clustering`
--

INSERT INTO `hasil_clustering` (`id_hasil`, `id_cluster`, `id_kafe`, `cluster`, `jarak_centroid`, `peringkat_cluster`, `rating_akhir`, `created_at`) VALUES
(1, 27, 5, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(2, 27, 143, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(3, 27, 124, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(4, 27, 154, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(5, 27, 126, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(6, 27, 127, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(7, 27, 128, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(8, 27, 131, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(9, 27, 159, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(10, 27, 136, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(11, 27, 135, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(12, 27, 161, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(13, 27, 140, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(14, 27, 163, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(15, 27, 92, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(16, 27, 95, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(17, 27, 96, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(18, 27, 118, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(19, 27, 116, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(20, 27, 114, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(21, 27, 113, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(22, 27, 119, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(23, 27, 109, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(24, 27, 122, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(25, 27, 90, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(26, 27, 105, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(27, 27, 106, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(28, 27, 107, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(29, 27, 108, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(30, 27, 177, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(31, 27, 110, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(32, 27, 112, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(33, 27, 183, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(34, 27, 184, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(35, 27, 115, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(36, 27, 189, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(37, 27, 187, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(38, 27, 117, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(39, 27, 186, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(40, 27, 104, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(41, 27, 87, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(42, 27, 102, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(43, 27, 101, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(44, 27, 100, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(45, 27, 99, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(46, 27, 98, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(47, 27, 97, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(48, 27, 190, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(49, 27, 181, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(50, 27, 94, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(51, 27, 93, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(52, 27, 91, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(53, 27, 121, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(54, 27, 89, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(55, 27, 88, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(56, 27, 111, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(57, 27, 120, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(58, 27, 132, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(59, 27, 178, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(60, 27, 137, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(61, 27, 139, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(62, 27, 148, 3, 0.072169, 1, 5, '2026-02-12 06:22:29'),
(63, 27, 145, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(64, 27, 144, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(65, 27, 193, 2, 0.472377, 2, 3, '2026-02-12 06:22:29'),
(66, 27, 176, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(67, 27, 141, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(68, 27, 138, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(69, 27, 147, 3, 0.072169, 1, 5, '2026-02-12 06:22:29'),
(70, 27, 175, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(71, 27, 134, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(72, 27, 133, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(73, 27, 130, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(74, 27, 129, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(75, 27, 125, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(76, 27, 171, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(77, 27, 170, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(78, 27, 123, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(79, 27, 169, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(80, 27, 142, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(81, 27, 146, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(82, 27, 103, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(83, 27, 166, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(84, 27, 85, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(85, 27, 44, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(86, 27, 168, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(87, 27, 26, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(88, 27, 27, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(89, 27, 152, 3, 0.072169, 1, 5, '2026-02-12 06:22:29'),
(90, 27, 28, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(91, 27, 29, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(92, 27, 30, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(93, 27, 198, 2, 1.04973, 3, 2, '2026-02-12 06:22:29'),
(94, 27, 172, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(95, 27, 173, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(96, 27, 31, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(97, 27, 180, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(98, 27, 174, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(99, 27, 33, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(100, 27, 191, 3, 0.505181, 2, 4, '2026-02-12 06:22:29'),
(101, 27, 153, 3, 0.072169, 1, 5, '2026-02-12 06:22:29'),
(102, 27, 34, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(103, 27, 35, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(104, 27, 192, 2, 0.472377, 2, 3, '2026-02-12 06:22:29'),
(105, 27, 36, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(106, 27, 37, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(107, 27, 38, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(108, 27, 39, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(109, 27, 48, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(110, 27, 40, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(111, 27, 41, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(112, 27, 42, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(113, 27, 25, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(114, 27, 167, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(115, 27, 24, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(116, 27, 23, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(117, 27, 13, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(118, 27, 6, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(119, 27, 7, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(120, 27, 8, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(121, 27, 9, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(122, 27, 10, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(123, 27, 11, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(124, 27, 179, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(125, 27, 12, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(126, 27, 185, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(127, 27, 14, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(128, 27, 22, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(129, 27, 16, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(130, 27, 15, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(131, 27, 17, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(132, 27, 18, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(133, 27, 19, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(134, 27, 20, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(135, 27, 21, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(136, 27, 43, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(137, 27, 45, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(138, 27, 150, 3, 0.072169, 1, 5, '2026-02-12 06:22:29'),
(139, 27, 84, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(140, 27, 188, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(141, 27, 46, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(142, 27, 67, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(143, 27, 68, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(144, 27, 69, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(145, 27, 70, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(146, 27, 71, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(147, 27, 72, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(148, 27, 194, 2, 0.472377, 2, 3, '2026-02-12 06:22:29'),
(149, 27, 195, 2, 0.472377, 2, 3, '2026-02-12 06:22:29'),
(150, 27, 182, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(151, 27, 197, 2, 0.472377, 2, 3, '2026-02-12 06:22:29'),
(152, 27, 73, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(153, 27, 74, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(154, 27, 75, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(155, 27, 76, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(156, 27, 151, 3, 0.072169, 1, 5, '2026-02-12 06:22:29'),
(157, 27, 77, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(158, 27, 78, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(159, 27, 149, 3, 0.072169, 1, 5, '2026-02-12 06:22:29'),
(160, 27, 79, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(161, 27, 80, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(162, 27, 81, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(163, 27, 82, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(164, 27, 83, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(165, 27, 156, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(166, 27, 157, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(167, 27, 158, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(168, 27, 66, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(169, 27, 65, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(170, 27, 64, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(171, 27, 54, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(172, 27, 165, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(173, 27, 160, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(174, 27, 47, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(175, 27, 49, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(176, 27, 50, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(177, 27, 155, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(178, 27, 51, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(179, 27, 162, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(180, 27, 52, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(181, 27, 53, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(182, 27, 55, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(183, 27, 63, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(184, 27, 56, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(185, 27, 57, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(186, 27, 58, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(187, 27, 59, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(188, 27, 164, 2, 0.104973, 1, 4, '2026-02-12 06:22:29'),
(189, 27, 60, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(190, 27, 61, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(191, 27, 62, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(192, 27, 196, 2, 0.472377, 2, 3, '2026-02-12 06:22:29'),
(193, 27, 32, 1, 0, 1, 5, '2026-02-12 06:22:29'),
(194, 27, 86, 1, 0, 1, 5, '2026-02-12 06:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_kuisioner`
--

CREATE TABLE `hasil_kuisioner` (
  `id_kuisioner` int(11) NOT NULL,
  `id_kafe` int(11) DEFAULT NULL,
  `rasa_kopi` float DEFAULT NULL,
  `pelayanan` float DEFAULT NULL,
  `fasilitas` float DEFAULT NULL,
  `suasana` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `nilai_wsm` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_kuisioner`
--

INSERT INTO `hasil_kuisioner` (`id_kuisioner`, `id_kafe`, `rasa_kopi`, `pelayanan`, `fasilitas`, `suasana`, `harga`, `rating`, `nilai_wsm`, `created_at`) VALUES
(1, 5, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(2, 6, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(3, 7, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(4, 8, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(5, 9, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(6, 10, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(7, 11, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(8, 12, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(9, 13, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(10, 14, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(11, 15, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(12, 16, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(13, 17, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(14, 18, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(15, 19, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(16, 20, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(17, 21, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(18, 22, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(19, 23, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(20, 24, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(21, 25, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(22, 26, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(23, 27, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(24, 28, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(25, 29, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(26, 30, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(27, 31, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(28, 32, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(29, 33, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(30, 34, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(31, 35, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(32, 36, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(33, 37, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(34, 38, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(35, 39, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(36, 40, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(37, 41, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(38, 42, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(39, 43, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(40, 44, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(41, 45, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(42, 46, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(43, 47, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(44, 48, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(45, 49, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(46, 50, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(47, 51, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(48, 52, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(49, 53, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(50, 54, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(51, 55, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(52, 56, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(53, 57, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(54, 58, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(55, 59, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(56, 60, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(57, 61, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(58, 62, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(59, 63, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(60, 64, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(61, 65, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(62, 66, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(63, 67, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(64, 68, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(65, 69, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(66, 70, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(67, 71, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(68, 72, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(69, 73, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(70, 74, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(71, 75, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(72, 76, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(73, 77, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(74, 78, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(75, 79, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(76, 80, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(77, 81, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(78, 82, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(79, 83, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(80, 84, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(81, 85, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(82, 86, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(83, 87, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(84, 88, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(85, 89, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(86, 90, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(87, 91, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(88, 92, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(89, 93, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(90, 94, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(91, 95, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(92, 96, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(93, 97, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(94, 98, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(95, 99, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(96, 100, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(97, 101, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(98, 102, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(99, 103, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(100, 104, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(101, 105, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(102, 106, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(103, 107, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(104, 108, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(105, 109, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(106, 110, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(107, 111, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(108, 112, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(109, 113, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(110, 114, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(111, 115, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(112, 116, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(113, 117, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(114, 118, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(115, 119, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(116, 120, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(117, 121, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(118, 122, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(119, 123, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(120, 124, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(121, 125, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(122, 126, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(123, 127, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(124, 128, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(125, 129, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(126, 130, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(127, 131, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(128, 132, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(129, 133, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(130, 134, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(131, 135, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(132, 136, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(133, 137, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(134, 138, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(135, 139, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(136, 140, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(137, 141, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(138, 142, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(139, 143, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(140, 144, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(141, 145, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(142, 146, 5, 5, 5, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(143, 147, 5, 5, 4, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(144, 148, 5, 5, 4, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(145, 149, 5, 5, 4, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(146, 150, 5, 5, 4, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(147, 151, 5, 5, 4, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(148, 152, 5, 5, 4, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(149, 153, 5, 5, 4, 5, 3, 5, NULL, '2026-02-12 06:22:25'),
(150, 154, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(151, 155, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(152, 156, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(153, 157, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(154, 158, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(155, 159, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(156, 160, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(157, 161, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(158, 162, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(159, 163, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(160, 164, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(161, 165, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(162, 166, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(163, 167, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(164, 168, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(165, 169, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(166, 170, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(167, 171, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(168, 172, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(169, 173, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(170, 174, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(171, 175, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(172, 176, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(173, 177, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(174, 178, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(175, 179, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(176, 180, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(177, 181, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(178, 182, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(179, 183, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(180, 184, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(181, 185, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(182, 186, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(183, 187, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(184, 188, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(185, 189, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(186, 190, 4, 4, 5, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(187, 191, 4, 4, 4, 4, 3, 4, NULL, '2026-02-12 06:22:25'),
(188, 192, 3, 3, 5, 3, 3, 3, NULL, '2026-02-12 06:22:25'),
(189, 193, 3, 3, 5, 3, 3, 3, NULL, '2026-02-12 06:22:25'),
(190, 194, 3, 3, 5, 3, 3, 3, NULL, '2026-02-12 06:22:25'),
(191, 195, 3, 3, 5, 3, 3, 3, NULL, '2026-02-12 06:22:25'),
(192, 196, 3, 3, 5, 3, 3, 3, NULL, '2026-02-12 06:22:25'),
(193, 197, 3, 3, 5, 3, 3, 3, NULL, '2026-02-12 06:22:25'),
(194, 198, 2, 2, 5, 2, 3, 2, NULL, '2026-02-12 06:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `kafe`
--

CREATE TABLE `kafe` (
  `id_kafe` int(11) NOT NULL,
  `nama_kafe` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `harga_terendah` int(11) DEFAULT NULL,
  `harga_tertinggi` int(11) DEFAULT NULL,
  `foto_kafe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kafe`
--

INSERT INTO `kafe` (`id_kafe`, `nama_kafe`, `alamat`, `harga_terendah`, `harga_tertinggi`, `foto_kafe`) VALUES
(5, '20 Kopi Purnawirawan', 'Belum diisi', 1, 1, 'default.jpg'),
(6, 'Mizzyu Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(7, 'Moore Coffee & Pastry', 'Belum diisi', 1, 1, 'default.jpg'),
(8, 'Moro Loko', 'Belum diisi', 1, 1, 'default.jpg'),
(9, 'Muara Cafe & Sapace', 'Belum diisi', 1, 1, 'default.jpg'),
(10, 'Mujur Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(11, 'Nako Coffee Shop', 'Belum diisi', 1, 1, 'default.jpg'),
(12, 'Nopi Kopi Cafe', 'Belum diisi', 1, 1, 'default.jpg'),
(13, 'Mikano Kopi', 'Belum diisi', 1, 1, 'default.jpg'),
(14, 'Nuju Coffe Pahoman', 'Belum diisi', 1, 1, 'default.jpg'),
(15, 'Nuju Coffee Hq', 'Belum diisi', 1, 1, 'default.jpg'),
(16, 'Nuju Coffee Gedong Air', 'Belum diisi', 1, 1, 'default.jpg'),
(17, 'Nuju Coffee Kedaton', 'Belum diisi', 1, 1, 'default.jpg'),
(18, 'Nuju Coffee Kemiling', 'Belum diisi', 1, 1, 'default.jpg'),
(19, 'Nuju Coffee Rajabasa', 'Belum diisi', 1, 1, 'default.jpg'),
(20, 'Nuju Coffee Sudirman', 'Belum diisi', 1, 1, 'default.jpg'),
(21, 'Nuju Coffee Sukarame', 'Belum diisi', 1, 1, 'default.jpg'),
(22, 'Nuju Coffee & Space', 'Belum diisi', 1, 1, 'default.jpg'),
(23, 'Marley\'s Cafe Coffee& Resto', 'Belum diisi', 1, 1, 'default.jpg'),
(24, 'Manca Lite', 'Belum diisi', 1, 1, 'default.jpg'),
(25, 'Mahira Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(26, 'Kopi Ketje Experience', 'Belum diisi', 1, 1, 'default.jpg'),
(27, 'Kopi Ketje Korpri', 'Belum diisi', 1, 1, 'default.jpg'),
(28, 'Kopi Ketje Panglima Polim', 'Belum diisi', 1, 1, 'default.jpg'),
(29, 'Kopi Ketje Pramuka', 'Belum diisi', 1, 1, 'default.jpg'),
(30, 'Kopi Ketje Teluk', 'Belum diisi', 1, 1, 'default.jpg'),
(31, 'Kopi Sheo Pagar Alam', 'Belum diisi', 1, 1, 'default.jpg'),
(32, 'Zet Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(33, 'Kopi Sudut Bandar Lampung', 'Belum diisi', 1, 1, 'default.jpg'),
(34, 'Kopi Tujuan Kita Cafe & Working Space', 'Belum diisi', 1, 1, 'default.jpg'),
(35, 'Kopikorkanmu', 'Belum diisi', 1, 1, 'default.jpg'),
(36, 'Kowen Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(37, 'Kyafe', 'Belum diisi', 1, 1, 'default.jpg'),
(38, 'La Ko Pi Cafe & Hangout Spot', 'Belum diisi', 1, 1, 'default.jpg'),
(39, 'La Vissuon', 'Belum diisi', 1, 1, 'default.jpg'),
(40, 'Langit Kopi', 'Belum diisi', 1, 1, 'default.jpg'),
(41, 'Lex Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(42, 'Liqo', 'Belum diisi', 1, 1, 'default.jpg'),
(43, 'Oma Backyard', 'Belum diisi', 1, 1, 'default.jpg'),
(44, 'Kopi Kenangan Antasari', 'Belum diisi', 1, 1, 'default.jpg'),
(45, 'Oma Backyard Gatsu Coffee & Co', 'Belum diisi', 1, 1, 'default.jpg'),
(46, 'Panorama Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(47, 'Titik Balik', 'Belum diisi', 1, 1, 'default.jpg'),
(48, 'Laidback Café', 'Belum diisi', 1, 1, 'default.jpg'),
(49, 'Toko Mansure', 'Belum diisi', 1, 1, 'default.jpg'),
(50, 'Tokopi Leipe', 'Belum diisi', 1, 1, 'default.jpg'),
(51, 'Tomoro Coffee Kemiling', 'Belum diisi', 1, 1, 'default.jpg'),
(52, 'Tomoro Coffee Pramuka', 'Belum diisi', 1, 1, 'default.jpg'),
(53, 'Tomoro Coffee Raden Intan', 'Belum diisi', 1, 1, 'default.jpg'),
(54, 'The Palm', 'Belum diisi', 1, 1, 'default.jpg'),
(55, 'Tomoro Coffee Teuku Umar', 'Belum diisi', 1, 1, 'default.jpg'),
(56, 'Tonecoffee.id', 'Belum diisi', 1, 1, 'default.jpg'),
(57, 'Tukamu Coffee & Tea House No.1', 'Belum diisi', 1, 1, 'default.jpg'),
(58, 'Tukamu Coffee & Tea House No.2', 'Belum diisi', 1, 1, 'default.jpg'),
(59, 'Tukamu Coffee & Tea House No.3', 'Belum diisi', 1, 1, 'default.jpg'),
(60, 'Vezco Sultan Agung', 'Belum diisi', 1, 1, 'default.jpg'),
(61, 'Warkomunal', 'Belum diisi', 1, 1, 'default.jpg'),
(62, 'Warkop Jasund', 'Belum diisi', 1, 1, 'default.jpg'),
(63, 'Tomoro Coffee Unila', 'Belum diisi', 1, 1, 'default.jpg'),
(64, 'The Oliv', 'Belum diisi', 1, 1, 'default.jpg'),
(65, 'The Habits Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(66, 'The Gade Coffee & Gold Lampung', 'Belum diisi', 1, 1, 'default.jpg'),
(67, 'Peachy Keen Bar', 'Belum diisi', 1, 1, 'default.jpg'),
(68, 'Pm Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(69, 'Podcast Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(70, 'Point Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(71, 'Poyz Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(72, 'Qalu Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(73, 'Sakara Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(74, 'Se.ndja', 'Belum diisi', 1, 1, 'default.jpg'),
(75, 'Shots Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(76, 'Sinia Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(77, 'Starbucks Ahmad Yani', 'Belum diisi', 1, 1, 'default.jpg'),
(78, 'Starbucks Antasari', 'Belum diisi', 1, 1, 'default.jpg'),
(79, 'Stone Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(80, 'Stop One Cafe', 'Belum diisi', 1, 1, 'default.jpg'),
(81, 'Sugarnishe Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(82, 'Sure Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(83, 'Tarra Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(84, 'One Shoot Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(85, 'Kopi Kenangan Ahmad Yani', 'Belum diisi', 1, 1, 'default.jpg'),
(86, 'Zozo Garden', 'One Piece', 1, 1, '697a359c98de8.jpg'),
(87, 'Djawara', 'Belum diisi', 1, 1, 'default.jpg'),
(88, 'Faste Coffee Rajabasa', 'Belum diisi', 1, 1, 'default.jpg'),
(89, 'Faste Coffee Kedaton', 'Belum diisi', 1, 1, 'default.jpg'),
(90, 'Bun Kopi Pahoman', 'Belum diisi', 1, 1, 'default.jpg'),
(91, 'Faste Coffee Ahmad Yani', 'Belum diisi', 1, 1, 'default.jpg'),
(92, 'Aimo By Daja', 'Belum diisi', 1, 1, 'default.jpg'),
(93, 'Enpos Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(94, 'Els Coffee Roastery', 'Belum diisi', 1, 1, 'default.jpg'),
(95, 'Around The Eighty Eight', 'Belum diisi', 1, 1, 'default.jpg'),
(96, 'Backyard Milkbar', 'Belum diisi', 1, 1, 'default.jpg'),
(97, 'Els Coffee Lampung Walk', 'Belum diisi', 1, 1, 'default.jpg'),
(98, 'Els Coffee House', 'Belum diisi', 1, 1, 'default.jpg'),
(99, 'Dunno Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(100, 'Dr. Koffie Sukarame', 'Belum diisi', 1, 1, 'default.jpg'),
(101, 'Dotuku Kopi', 'Belum diisi', 1, 1, 'default.jpg'),
(102, 'Doesoen Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(103, 'Kongko Kopitiam', 'Belum diisi', 1, 1, 'default.jpg'),
(104, 'Dazzler Store & Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(105, 'Bun Kopi Rawa Laut', 'Belum diisi', 1, 1, 'default.jpg'),
(106, 'Bun Kopi Unila', 'Belum diisi', 1, 1, 'default.jpg'),
(107, 'Bun Kopi Wayhalim', 'Belum diisi', 1, 1, 'default.jpg'),
(108, 'Cabrio Coffee Itera', 'Belum diisi', 1, 1, 'default.jpg'),
(109, 'Bun Kopi Korpi', 'Belum diisi', 1, 1, 'default.jpg'),
(110, 'Cafe Janji Surga 2', 'Belum diisi', 1, 1, 'default.jpg'),
(111, 'Faste Coffee Signature', 'Belum diisi', 1, 1, 'default.jpg'),
(112, 'Cafe Kiyo', 'Belum diisi', 1, 1, 'default.jpg'),
(113, 'Boja Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(114, 'Bento Kopi', 'Belum diisi', 1, 1, 'default.jpg'),
(115, 'Coffee Shop Jangdoel', 'Belum diisi', 1, 1, 'default.jpg'),
(116, 'Benefit Coffee & Space', 'Belum diisi', 1, 1, 'default.jpg'),
(117, 'Daja', 'Belum diisi', 1, 1, 'default.jpg'),
(118, 'Benefit Coffee & Sapace Sukarame', 'Belum diisi', 1, 1, 'default.jpg'),
(119, 'Bun Kopi Kedaton', 'Belum diisi', 1, 1, 'default.jpg'),
(120, 'Faste Coffee Unila', 'Belum diisi', 1, 1, 'default.jpg'),
(121, 'Faste Coffee Enggal', 'Belum diisi', 1, 1, 'default.jpg'),
(122, 'Bun Kopi Marotai', 'Belum diisi', 1, 1, 'default.jpg'),
(123, 'Kiyo Pahoman', 'Belum diisi', 1, 1, 'default.jpg'),
(124, '20 Kopi Rawa Laut', 'Belum diisi', 1, 1, 'default.jpg'),
(125, 'Kedai Kopi Kini', 'Belum diisi', 1, 1, 'default.jpg'),
(126, '20 Kopi Teuku Umar', 'Belum diisi', 1, 1, 'default.jpg'),
(127, '20 Kopi Tritayasa', 'Belum diisi', 1, 1, 'default.jpg'),
(128, '20 Kopi Wolter Monginsidi', 'Belum diisi', 1, 1, 'default.jpg'),
(129, 'Kedai Atap', 'Belum diisi', 1, 1, 'default.jpg'),
(130, 'Katama Coffee & Space', 'Belum diisi', 1, 1, 'default.jpg'),
(131, '20+ Kopi Pramuka', 'Belum diisi', 1, 1, 'default.jpg'),
(132, 'Flambojan', 'Belum diisi', 1, 1, 'default.jpg'),
(133, 'Kali Cafe', 'Belum diisi', 1, 1, 'default.jpg'),
(134, 'Kala Coffee & Space', 'Belum diisi', 1, 1, 'default.jpg'),
(135, '52 Resonance', 'Belum diisi', 1, 1, 'default.jpg'),
(136, '411.foureleven', 'Belum diisi', 1, 1, 'default.jpg'),
(137, 'Fore Coffee Ahmad Yani', 'Belum diisi', 1, 1, 'default.jpg'),
(138, 'Jebe Coffee Express', 'Belum diisi', 1, 1, 'default.jpg'),
(139, 'Fore Coffee Antasari', 'Belum diisi', 1, 1, 'default.jpg'),
(140, 'Adiksi Coffee Korpri', 'Belum diisi', 1, 1, 'default.jpg'),
(141, 'Janji Jiwa Unila', 'Belum diisi', 1, 1, 'default.jpg'),
(142, 'Kl Coffee Indonesia', 'Belum diisi', 1, 1, 'default.jpg'),
(143, '20 Kopi Ratu Langi', 'Belum diisi', 1, 1, 'default.jpg'),
(144, 'Hum! Collaboration Space', 'Belum diisi', 1, 1, 'default.jpg'),
(145, 'Hoffmann Lane', 'Belum diisi', 1, 1, 'default.jpg'),
(146, 'Kolo Garden', 'Belum diisi', 1, 1, 'default.jpg'),
(147, 'Jenggala Coffee And Brew', 'Belum diisi', 1, 1, 'default.jpg'),
(148, 'Fore Coffee Mbk', 'Belum diisi', 1, 1, 'default.jpg'),
(149, 'Starbucks Mbk', 'Belum diisi', 1, 1, 'default.jpg'),
(150, 'One More Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(151, 'Small Block Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(152, 'Kopi Ketje Mall Kartini', 'Belum diisi', 1, 1, 'default.jpg'),
(153, 'Kopi Tempat Ketiga Sukarame', 'Belum diisi', 1, 1, 'default.jpg'),
(154, '20 Kopi Sultan Agung', 'Belum diisi', 1, 1, 'default.jpg'),
(155, 'Tomoro Coffee Antasari', 'Belum diisi', 1, 1, 'default.jpg'),
(156, 'Tazza Signature', 'Belum diisi', 1, 1, 'default.jpg'),
(157, 'Test Coffee17', 'Belum diisi', 1, 1, 'default.jpg'),
(158, 'Thamie Pahoman', 'Belum diisi', 1, 1, 'default.jpg'),
(159, '24 Degress', 'Belum diisi', 1, 1, 'default.jpg'),
(160, 'Theree Nine Coffee & Eatery', 'Belum diisi', 1, 1, 'default.jpg'),
(161, '9.1 Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(162, 'Tomoro Coffee Pahoman', 'Belum diisi', 1, 1, 'default.jpg'),
(163, 'Adiksi Coffee Purnawirawan', 'Belum diisi', 1, 1, 'default.jpg'),
(164, 'Vezco Gedong Air', 'Belum diisi', 1, 1, 'default.jpg'),
(165, 'The Pearl', 'Belum diisi', 1, 1, 'default.jpg'),
(166, 'Kopi Janji Jiwa Imam Bonjol', 'Belum diisi', 1, 1, 'default.jpg'),
(167, 'Manca Eatery', 'Belum diisi', 1, 1, 'default.jpg'),
(168, 'Kopi Kenangan Kedaton', 'Belum diisi', 1, 1, 'default.jpg'),
(169, 'Kiyo Time Pramuka', 'Belum diisi', 1, 1, 'default.jpg'),
(170, 'Kiyo Libare Korpri & 51 Carwash', 'Belum diisi', 1, 1, 'default.jpg'),
(171, 'Kiyo Libare', 'Belum diisi', 1, 1, 'default.jpg'),
(172, 'Kopi Koccok', 'Belum diisi', 1, 1, 'default.jpg'),
(173, 'Kopi Oey Lampung', 'Belum diisi', 1, 1, 'default.jpg'),
(174, 'Kopi Sheo X Donat Eo Antasari', 'Belum diisi', 1, 1, 'default.jpg'),
(175, 'Kafe Santurasi', 'Belum diisi', 1, 1, 'default.jpg'),
(176, 'Janji Jiwa & Jiwa Toast Sukarame', 'Belum diisi', 1, 1, 'default.jpg'),
(177, 'Cabrio Premier Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(178, 'Flipflop Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(179, 'Nnoko Café', 'Belum diisi', 1, 1, 'default.jpg'),
(180, 'Kopi Sheo X Dinat Eo Kemiling', 'Belum diisi', 1, 1, 'default.jpg'),
(181, 'Els Coffee Raden Inten Ii', 'Belum diisi', 1, 1, 'default.jpg'),
(182, 'Rumah Kawan 3', 'Belum diisi', 1, 1, 'default.jpg'),
(183, 'Cafe Kolo', 'Belum diisi', 1, 1, 'default.jpg'),
(184, 'Cafe Kopi Legend', 'Belum diisi', 1, 1, 'default.jpg'),
(185, 'Notiz Hut', 'Belum diisi', 1, 1, 'default.jpg'),
(186, 'Day One Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(187, 'Dahareun', 'Belum diisi', 1, 1, 'default.jpg'),
(188, 'Panacea Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(189, 'D\'jaya House', 'Belum diisi', 1, 1, 'default.jpg'),
(190, 'Els Coffee Mbk', 'Belum diisi', 1, 1, 'default.jpg'),
(191, 'Kopi Tempat Ketiga', 'Belum diisi', 1, 1, 'default.jpg'),
(192, 'Kopitiam Uncle', 'Belum diisi', 1, 1, 'default.jpg'),
(193, 'Ice & Coffee', 'Belum diisi', 1, 1, 'default.jpg'),
(194, 'Rumah Kawan', 'Belum diisi', 1, 1, 'default.jpg'),
(195, 'Rumah Kawan 2', 'Belum diisi', 1, 1, 'default.jpg'),
(196, 'Yaba House', 'Belum diisi', 20000, 50000, 'default.jpg'),
(197, 'Rumah Kawan 4', 'Belum diisi', 1, 1, 'default.jpg'),
(198, 'Kopi Ketje Unila', 'Belum diisi', 1, 1, 'default.jpg'),
(199, 'Marleys’s Cafe Coffee& Resto', 'Belum diisi', 1, 1, 'default.jpg'),
(200, 'D’jaya House', 'Belum diisi', 1, 1, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `clustering`
--
ALTER TABLE `clustering`
  ADD PRIMARY KEY (`id_cluster`);

--
-- Indexes for table `hasil_clustering`
--
ALTER TABLE `hasil_clustering`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_cluster` (`id_cluster`),
  ADD KEY `id_kafe` (`id_kafe`),
  ADD KEY `idx_hasil_clustering_kafe` (`id_kafe`),
  ADD KEY `idx_hasil_clustering_cluster` (`cluster`);

--
-- Indexes for table `hasil_kuisioner`
--
ALTER TABLE `hasil_kuisioner`
  ADD PRIMARY KEY (`id_kuisioner`),
  ADD KEY `id_kafe` (`id_kafe`),
  ADD KEY `idx_hasil_kuisioner_kafe` (`id_kafe`);

--
-- Indexes for table `kafe`
--
ALTER TABLE `kafe`
  ADD PRIMARY KEY (`id_kafe`),
  ADD KEY `idx_kafe_nama` (`nama_kafe`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clustering`
--
ALTER TABLE `clustering`
  MODIFY `id_cluster` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `hasil_clustering`
--
ALTER TABLE `hasil_clustering`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `hasil_kuisioner`
--
ALTER TABLE `hasil_kuisioner`
  MODIFY `id_kuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `kafe`
--
ALTER TABLE `kafe`
  MODIFY `id_kafe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_clustering`
--
ALTER TABLE `hasil_clustering`
  ADD CONSTRAINT `hasil_clustering_ibfk_1` FOREIGN KEY (`id_cluster`) REFERENCES `clustering` (`id_cluster`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_clustering_ibfk_2` FOREIGN KEY (`id_kafe`) REFERENCES `kafe` (`id_kafe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasil_kuisioner`
--
ALTER TABLE `hasil_kuisioner`
  ADD CONSTRAINT `hasil_kuisioner_ibfk_1` FOREIGN KEY (`id_kafe`) REFERENCES `kafe` (`id_kafe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
