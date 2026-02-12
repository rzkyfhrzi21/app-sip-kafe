-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 08:12 PM
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
(15, '2026-01-28_23-09-19_Clustering_SIP_Kafe_Balam.csv', 3, 194, '2026-01-28 23:09:19');

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
(1, 15, 5, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(2, 15, 143, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(3, 15, 124, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(4, 15, 154, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(5, 15, 126, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(6, 15, 127, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(7, 15, 128, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(8, 15, 131, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(9, 15, 159, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(10, 15, 136, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(11, 15, 135, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(12, 15, 161, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(13, 15, 140, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(14, 15, 163, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(15, 15, 92, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(16, 15, 95, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(17, 15, 96, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(18, 15, 118, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(19, 15, 116, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(20, 15, 114, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(21, 15, 113, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(22, 15, 119, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(23, 15, 109, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(24, 15, 122, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(25, 15, 90, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(26, 15, 105, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(27, 15, 106, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(28, 15, 107, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(29, 15, 108, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(30, 15, 177, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(31, 15, 110, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(32, 15, 112, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(33, 15, 183, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(34, 15, 184, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(35, 15, 115, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(36, 15, 189, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(37, 15, 187, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(38, 15, 117, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(39, 15, 186, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(40, 15, 104, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(41, 15, 87, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(42, 15, 102, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(43, 15, 101, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(44, 15, 100, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(45, 15, 99, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(46, 15, 98, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(47, 15, 97, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(48, 15, 190, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(49, 15, 181, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(50, 15, 94, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(51, 15, 93, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(52, 15, 91, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(53, 15, 121, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(54, 15, 89, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(55, 15, 88, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(56, 15, 111, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(57, 15, 120, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(58, 15, 132, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(59, 15, 178, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(60, 15, 137, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(61, 15, 139, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(62, 15, 148, 3, 0.072169, 1, 5, '2026-01-28 23:09:22'),
(63, 15, 145, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(64, 15, 144, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(65, 15, 193, 2, 0.472377, 2, 3, '2026-01-28 23:09:22'),
(66, 15, 176, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(67, 15, 141, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(68, 15, 138, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(69, 15, 147, 3, 0.072169, 1, 5, '2026-01-28 23:09:22'),
(70, 15, 175, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(71, 15, 134, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(72, 15, 133, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(73, 15, 130, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(74, 15, 129, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(75, 15, 125, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(76, 15, 171, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(77, 15, 170, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(78, 15, 123, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(79, 15, 169, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(80, 15, 142, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(81, 15, 146, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(82, 15, 103, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(83, 15, 166, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(84, 15, 85, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(85, 15, 44, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(86, 15, 168, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(87, 15, 26, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(88, 15, 27, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(89, 15, 152, 3, 0.072169, 1, 5, '2026-01-28 23:09:22'),
(90, 15, 28, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(91, 15, 29, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(92, 15, 30, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(93, 15, 198, 2, 1.04973, 3, 2, '2026-01-28 23:09:22'),
(94, 15, 172, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(95, 15, 173, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(96, 15, 31, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(97, 15, 180, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(98, 15, 174, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(99, 15, 33, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(100, 15, 191, 3, 0.505181, 2, 4, '2026-01-28 23:09:22'),
(101, 15, 153, 3, 0.072169, 1, 5, '2026-01-28 23:09:22'),
(102, 15, 34, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(103, 15, 35, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(104, 15, 192, 2, 0.472377, 2, 3, '2026-01-28 23:09:22'),
(105, 15, 36, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(106, 15, 37, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(107, 15, 38, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(108, 15, 39, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(109, 15, 48, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(110, 15, 40, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(111, 15, 41, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(112, 15, 42, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(113, 15, 25, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(114, 15, 167, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(115, 15, 24, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(116, 15, 23, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(117, 15, 13, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(118, 15, 6, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(119, 15, 7, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(120, 15, 8, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(121, 15, 9, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(122, 15, 10, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(123, 15, 11, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(124, 15, 179, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(125, 15, 12, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(126, 15, 185, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(127, 15, 14, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(128, 15, 22, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(129, 15, 16, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(130, 15, 15, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(131, 15, 17, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(132, 15, 18, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(133, 15, 19, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(134, 15, 20, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(135, 15, 21, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(136, 15, 43, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(137, 15, 45, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(138, 15, 150, 3, 0.072169, 1, 5, '2026-01-28 23:09:22'),
(139, 15, 84, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(140, 15, 188, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(141, 15, 46, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(142, 15, 67, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(143, 15, 68, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(144, 15, 69, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(145, 15, 70, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(146, 15, 71, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(147, 15, 72, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(148, 15, 194, 2, 0.472377, 2, 3, '2026-01-28 23:09:22'),
(149, 15, 195, 2, 0.472377, 2, 3, '2026-01-28 23:09:22'),
(150, 15, 182, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(151, 15, 197, 2, 0.472377, 2, 3, '2026-01-28 23:09:22'),
(152, 15, 73, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(153, 15, 74, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(154, 15, 75, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(155, 15, 76, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(156, 15, 151, 3, 0.072169, 1, 5, '2026-01-28 23:09:22'),
(157, 15, 77, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(158, 15, 78, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(159, 15, 149, 3, 0.072169, 1, 5, '2026-01-28 23:09:22'),
(160, 15, 79, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(161, 15, 80, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(162, 15, 81, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(163, 15, 82, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(164, 15, 83, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(165, 15, 156, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(166, 15, 157, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(167, 15, 158, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(168, 15, 66, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(169, 15, 65, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(170, 15, 64, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(171, 15, 54, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(172, 15, 165, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(173, 15, 160, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(174, 15, 47, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(175, 15, 49, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(176, 15, 50, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(177, 15, 155, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(178, 15, 51, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(179, 15, 162, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(180, 15, 52, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(181, 15, 53, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(182, 15, 55, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(183, 15, 63, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(184, 15, 56, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(185, 15, 57, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(186, 15, 58, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(187, 15, 59, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(188, 15, 164, 2, 0.104973, 1, 4, '2026-01-28 23:09:22'),
(189, 15, 60, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(190, 15, 61, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(191, 15, 62, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(192, 15, 196, 2, 0.472377, 2, 3, '2026-01-28 23:09:22'),
(193, 15, 32, 1, 0, 1, 5, '2026-01-28 23:09:22'),
(194, 15, 86, 1, 0, 1, 5, '2026-01-28 23:09:22');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_kuisioner`
--

INSERT INTO `hasil_kuisioner` (`id_kuisioner`, `id_kafe`, `rasa_kopi`, `pelayanan`, `fasilitas`, `suasana`, `harga`, `rating`, `created_at`) VALUES
(1, 5, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(2, 6, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(3, 7, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(4, 8, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(5, 9, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(6, 10, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(7, 11, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(8, 12, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(9, 13, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(10, 14, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(11, 15, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(12, 16, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(13, 17, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(14, 18, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(15, 19, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(16, 20, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(17, 21, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(18, 22, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(19, 23, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(20, 24, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(21, 25, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(22, 26, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(23, 27, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(24, 28, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(25, 29, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(26, 30, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(27, 31, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(28, 32, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(29, 33, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(30, 34, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(31, 35, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(32, 36, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(33, 37, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(34, 38, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(35, 39, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(36, 40, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(37, 41, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(38, 42, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(39, 43, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(40, 44, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(41, 45, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(42, 46, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(43, 47, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(44, 48, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(45, 49, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(46, 50, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(47, 51, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(48, 52, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(49, 53, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(50, 54, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(51, 55, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(52, 56, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(53, 57, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(54, 58, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(55, 59, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(56, 60, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(57, 61, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(58, 62, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(59, 63, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(60, 64, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(61, 65, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(62, 66, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(63, 67, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(64, 68, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(65, 69, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(66, 70, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(67, 71, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(68, 72, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(69, 73, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(70, 74, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(71, 75, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(72, 76, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(73, 77, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(74, 78, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(75, 79, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(76, 80, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(77, 81, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(78, 82, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(79, 83, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(80, 84, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(81, 85, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(82, 86, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(83, 87, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(84, 88, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(85, 89, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(86, 90, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(87, 91, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(88, 92, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(89, 93, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(90, 94, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(91, 95, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(92, 96, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(93, 97, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(94, 98, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(95, 99, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(96, 100, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(97, 101, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(98, 102, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(99, 103, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(100, 104, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(101, 105, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(102, 106, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(103, 107, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(104, 108, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(105, 109, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(106, 110, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(107, 111, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(108, 112, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(109, 113, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(110, 114, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(111, 115, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(112, 116, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(113, 117, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(114, 118, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(115, 119, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(116, 120, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(117, 121, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(118, 122, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(119, 123, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(120, 124, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(121, 125, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(122, 126, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(123, 127, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(124, 128, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(125, 129, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(126, 130, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(127, 131, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(128, 132, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(129, 133, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(130, 134, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(131, 135, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(132, 136, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(133, 137, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(134, 138, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(135, 139, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(136, 140, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(137, 141, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(138, 142, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(139, 143, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(140, 144, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(141, 145, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(142, 146, 5, 5, 5, 5, 3, 5, '2026-01-28 23:09:19'),
(143, 147, 5, 5, 4, 5, 3, 5, '2026-01-28 23:09:19'),
(144, 148, 5, 5, 4, 5, 3, 5, '2026-01-28 23:09:19'),
(145, 149, 5, 5, 4, 5, 3, 5, '2026-01-28 23:09:19'),
(146, 150, 5, 5, 4, 5, 3, 5, '2026-01-28 23:09:19'),
(147, 151, 5, 5, 4, 5, 3, 5, '2026-01-28 23:09:19'),
(148, 152, 5, 5, 4, 5, 3, 5, '2026-01-28 23:09:19'),
(149, 153, 5, 5, 4, 5, 3, 5, '2026-01-28 23:09:19'),
(150, 154, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(151, 155, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(152, 156, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(153, 157, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(154, 158, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(155, 159, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(156, 160, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(157, 161, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(158, 162, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(159, 163, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(160, 164, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(161, 165, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(162, 166, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(163, 167, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(164, 168, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(165, 169, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(166, 170, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(167, 171, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(168, 172, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(169, 173, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(170, 174, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(171, 175, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(172, 176, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(173, 177, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(174, 178, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(175, 179, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(176, 180, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(177, 181, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(178, 182, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(179, 183, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(180, 184, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(181, 185, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(182, 186, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(183, 187, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(184, 188, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(185, 189, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(186, 190, 4, 4, 5, 4, 3, 4, '2026-01-28 23:09:19'),
(187, 191, 4, 4, 4, 4, 3, 4, '2026-01-28 23:09:19'),
(188, 192, 3, 3, 5, 3, 3, 3, '2026-01-28 23:09:19'),
(189, 193, 3, 3, 5, 3, 3, 3, '2026-01-28 23:09:19'),
(190, 194, 3, 3, 5, 3, 3, 3, '2026-01-28 23:09:19'),
(191, 195, 3, 3, 5, 3, 3, 3, '2026-01-28 23:09:19'),
(192, 196, 3, 3, 5, 3, 3, 3, '2026-01-28 23:09:19'),
(193, 197, 3, 3, 5, 3, 3, 3, '2026-01-28 23:09:19'),
(194, 198, 2, 2, 5, 2, 3, 2, '2026-01-28 23:09:19');

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
(196, 'Yaba House', 'Belum diisi', 1, 1, 'default.jpg'),
(197, 'Rumah Kawan 4', 'Belum diisi', 1, 1, 'default.jpg'),
(198, 'Kopi Ketje Unila', 'Belum diisi', 1, 1, 'default.jpg');

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
  ADD KEY `id_kafe` (`id_kafe`);

--
-- Indexes for table `hasil_kuisioner`
--
ALTER TABLE `hasil_kuisioner`
  ADD PRIMARY KEY (`id_kuisioner`),
  ADD KEY `id_kafe` (`id_kafe`);

--
-- Indexes for table `kafe`
--
ALTER TABLE `kafe`
  ADD PRIMARY KEY (`id_kafe`);

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
  MODIFY `id_cluster` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id_kafe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
