-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2022 at 09:40 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kopim`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_trx_belanja`
--

CREATE TABLE `tb_trx_belanja` (
  `id_trx_belanja` varchar(100) NOT NULL,
  `tgl_trx` date NOT NULL,
  `no_barcode` varchar(15) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `nominal` int(11) NOT NULL,
  `kategori` varchar(10) NOT NULL,
  `inputor` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_trx_belanja`
--

INSERT INTO `tb_trx_belanja` (`id_trx_belanja`, `tgl_trx`, `no_barcode`, `nama`, `nominal`, `kategori`, `inputor`, `created_at`, `updated_at`) VALUES
('55f32b38-7549-4efc-b640-b2fe4b4769ee', '2022-11-20', '999999', 'Client Umum', 1500, 'Umum', 'Admin', '2022-11-20 08:13:47', '2022-11-20 08:13:47'),
('fe743d95-faca-4792-97a8-88355359e392', '2022-11-20', '2022110001', 'Kholilul Rohman', 5000, 'Anggota', 'Admin', '2022-11-20 08:14:30', '2022-11-20 08:14:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
