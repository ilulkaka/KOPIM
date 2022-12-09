-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2022 at 01:30 PM
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(14, 'App\\Models\\User', 2, 'auth_token', '3872eaaa9077e950ed438106fe511038d1e3aa179a00b1d7d7ea9ddde81417a2', '[\"*\"]', NULL, '2022-11-18 18:36:57', '2022-11-18 18:36:57'),
(15, 'App\\Models\\User', 2, 'auth_token', '467c7217b10fef2f576cae7ed5f7e2dc24da71083a2323340986d15bc7149404', '[\"*\"]', NULL, '2022-11-18 18:37:45', '2022-11-18 18:37:45'),
(18, 'App\\Models\\User', 2, 'auth_token', '91fb13655736ddf94b9e946b95a97d1bb7874bd472c13e5e5befc8655d2add67', '[\"*\"]', NULL, '2022-11-19 22:18:00', '2022-11-19 22:18:00'),
(38, 'App\\Models\\User', 1, 'auth_token', 'd14d70114c3a4d676a601116c299b26d3082d067e1c2ef187844b6d9abde6a7f', '[\"*\"]', NULL, '2022-12-09 12:25:56', '2022-12-09 12:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE `tb_anggota` (
  `id_anggota` varchar(100) NOT NULL,
  `nik` varchar(5) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `no_ktp` varchar(16) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` varchar(16) NOT NULL,
  `status` varchar(10) NOT NULL,
  `no_barcode` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_anggota`
--

INSERT INTO `tb_anggota` (`id_anggota`, `nik`, `nama`, `no_ktp`, `alamat`, `no_telp`, `status`, `no_barcode`, `created_at`, `updated_at`) VALUES
('1', '31', 'ilul', 'e', 's', 'f', 'g', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('6d28c585-2192-4a9b-aff8-839466d355de', '0031', 'Kholilul Rohman', '7627647879898', 'Rembang Pasuruan', '0972-6354-5223', 'Aktif', '2022110001', '2022-11-20 00:39:27', '2022-11-20 00:39:27'),
('4d111d71-8f2d-4504-ac87-b761713b447e', '0001', 'Coba test', '123456789', 'Ts Panjaitan', '98765421', 'Aktif', '2022110002', '2022-11-20 00:40:13', '2022-11-20 00:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` varchar(100) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `spesifikasi` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `kode`, `nama`, `spesifikasi`, `harga`, `supplier`, `created_at`, `updated_at`) VALUES
('cb9cdbc8-8410-49f4-8a49-18a1a72e6f72', '12345', 'Usus', 'Kering biasa', 2500, 'Angel Jaya', '2022-11-27 11:25:22', '2022-11-28 20:00:43'),
('df664a72-62f3-490b-bcdf-8a2e84295db0', '9090', 'Es teler', 'Cup Besar', 5000, 'Rina m', '2022-11-28 19:38:01', '2022-11-28 19:38:01'),
('f592209e-e127-4f48-b3d9-256051aa777e', '98765', 'Sinom', 'Botol 500 ml', 4500, 'Budi', '2022-11-30 19:52:58', '2022-11-30 19:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_in`
--

CREATE TABLE `tb_in` (
  `id_in` varchar(100) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `tgl_in` date NOT NULL,
  `qty_in` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_in`
--

INSERT INTO `tb_in` (`id_in`, `kode`, `tgl_in`, `qty_in`, `created_at`, `updated_at`) VALUES
('44302a96-904e-4969-b3be-8a73e39cc11f', '9090', '2022-11-30', 5, '2022-11-30 21:11:53', '2022-11-30 21:11:53'),
('062fb8f4-d263-4136-9293-0a8194dba7d7', '9090', '2022-11-30', 1, '2022-11-30 21:15:48', '2022-11-30 21:15:48'),
('d1e5758b-2aa0-4a8c-b293-5a66dedc954c', '12345', '2022-12-02', 2, '2022-12-02 20:52:08', '2022-12-02 20:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_out`
--

CREATE TABLE `tb_out` (
  `id_out` varchar(100) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `tgl_out` date NOT NULL,
  `qty_out` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_out`
--

INSERT INTO `tb_out` (`id_out`, `kode`, `tgl_out`, `qty_out`, `created_at`, `updated_at`) VALUES
('1ed12bf9-824a-4caa-87ae-7467ae336489', '9090', '2022-11-30', 1, '2022-11-30 21:28:02', '2022-11-30 21:28:02'),
('b81d604a-226d-44ec-b821-3a77f1fa2e4a', '12345', '2022-12-02', 1, '2022-12-02 21:19:46', '2022-12-02 21:19:46');

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
('fe743d95-faca-4792-97a8-88355359e392', '2022-11-20', '2022110001', 'Kholilul Rohman', 5000, 'Anggota', 'Admin', '2022-11-20 08:14:30', '2022-11-20 08:14:30'),
('2ee3450a-ead9-4b08-a859-238992161083', '2022-11-23', '999999', 'Client Umum', 5000, 'Umum', 'Admin', '2022-11-23 18:03:30', '2022-11-23 18:03:30'),
('b8f3d57a-89fd-4057-abf9-1b706f2d7348', '2022-11-23', '999999', 'Client Umum', 5000, 'Umum', 'Admin', '2022-11-23 18:03:31', '2022-11-23 18:03:31'),
('024d59fd-9fa9-484d-b02e-d87f05598444', '2022-11-23', '999999', 'Client Umum', 1200, 'Umum', 'Admin', '2022-11-23 18:06:40', '2022-11-23 18:06:40'),
('fed7b7a8-d42d-409c-b50e-1531af3e9806', '2022-11-23', '999999', 'Client Umum', 3500, 'Umum', 'Admin', '2022-11-23 18:11:12', '2022-11-23 18:11:12'),
('18cf4b30-08f5-4e5c-ad0d-899fd53a4846', '2022-11-23', '999999', 'Client Umum', 2300, 'Umum', 'Admin', '2022-11-23 18:11:50', '2022-11-23 18:11:50'),
('e1931d46-e160-4977-9aa4-1cf3204738ac', '2022-11-23', '2022110002', 'Coba test', 4500, 'Anggota', 'Admin', '2022-11-23 18:12:12', '2022-11-23 18:12:12'),
('92a38f06-905d-4855-8f29-0ac12ad73c39', '2022-11-23', '2022110001', 'Kholilul Rohman', 10000, 'Anggota', 'Admin', '2022-11-23 18:12:38', '2022-11-23 18:12:38'),
('ed79be41-909d-4903-a47e-5392c4dc6a3f', '2022-11-23', '2022110001', 'Kholilul Rohman', 10000, 'Anggota', 'Admin', '2022-11-23 18:12:39', '2022-11-23 18:12:39'),
('03a085bb-8a9f-4197-805b-7cc55697523c', '2022-11-23', '2022110001', 'Kholilul Rohman', 10000, 'Anggota', 'Admin', '2022-11-23 18:12:40', '2022-11-23 18:12:40'),
('6c5c039a-76ed-400a-b214-2a4f43474ca3', '2022-11-23', '999999', 'Client Umum', 3500, 'Umum', 'Admin', '2022-11-23 18:17:34', '2022-11-23 18:17:34'),
('7a394d58-35c2-4bec-808a-7b8810fc1ef9', '2022-11-23', '999999', 'Client Umum', 3500, 'Umum', 'Admin', '2022-11-23 18:17:35', '2022-11-23 18:17:35'),
('b6e48a57-9728-432e-9b92-59efbd00e0f9', '2022-11-23', '999999', 'Client Umum', 3500, 'Umum', 'Admin', '2022-11-23 18:17:35', '2022-11-23 18:17:35'),
('5d1df3d2-48c5-4a6e-b9b5-c256beab2031', '2022-11-27', '999999', 'Client Umum', 2000, 'Umum', 'Admin', '2022-11-27 08:37:57', '2022-11-27 08:37:57'),
('3001e1b4-2b7f-47d0-9acf-56aafff66f8f', '2022-11-27', '999999', 'Client Umum', 5000, 'Umum', 'Admin', '2022-11-27 08:41:22', '2022-11-27 08:41:22'),
('ad103396-1308-41d5-a786-4d043fe0f949', '2022-11-27', '2022110001', 'Kholilul Rohman', 6000, 'Anggota', 'Admin', '2022-11-27 08:47:21', '2022-11-27 08:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$vYCyMgghvSOaQbT0bA88qOvf/DpcpgxUyJObAiJD0Ua5LFPKmJFfa', 'Administrator', NULL, '', '2022-11-13 01:05:04', '2022-11-13 01:05:04'),
(2, 'Kasir', 'kasir@gmail.com', NULL, '$2y$10$6bD6I5omCdVErFq7/2LzRud7OluH7RfDoECrWLjFe4u0/wb9SQBC.', 'Kasir', NULL, 'Aktif', '2022-11-18 18:36:57', '2022-11-18 18:36:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
