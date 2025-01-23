-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 23, 2025 at 03:39 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int NOT NULL,
  `id_user` int NOT NULL,
  `nama_tugas` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `status_tugas` enum('belum','selesai') COLLATE utf8mb4_general_ci DEFAULT 'belum',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_deadline` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `id_user`, `nama_tugas`, `deskripsi`, `status_tugas`, `tanggal_dibuat`, `tanggal_deadline`) VALUES
(11, 4, 'buat ppt', 'membuat ppt tentang perang dunia 1', 'selesai', '2025-12-26 04:30:23', '2025-12-27 10:00:00'),
(27, 4, 'Membuat makalah', 'makalah kewirausahaan', 'belum', '2025-12-27 21:20:13', '2025-12-28 10:00:00'),
(122, 701, 'Matematika', 'halaman 6 - 10 buku paket matematika semester 2', 'belum', '2025-01-13 01:58:39', '2025-01-22 01:58:39'),
(124, 7, 'matematika', 'membuat tugas video dan mengerjakan buku paket', 'selesai', '2025-01-21 04:36:32', '2025-01-22 17:00:00'),
(127, 8, 'Bahasa Indonesia', 'Menyelesaikan makalah tentang sejarah kemerdekaan Indonesia', 'belum', '2025-01-21 06:52:55', '2025-01-29 17:00:00'),
(129, 7, 'Sejarah Indonesia', 'Menyusun timeline peristiwa penting dalam Proklamasi Kemerdekaan Indonesia', 'selesai', '2025-01-21 06:55:30', '2025-02-03 17:00:00'),
(130, 7, 'Pendidkan Jasmani', 'Menjelaskan peraturan permainan bola voli dalam bentuk presentasi', 'selesai', '2025-01-21 06:56:11', '2025-01-23 17:00:00'),
(131, 7, 'TIK', 'Membuat desain poster digital dengan aplikasi grafis', 'selesai', '2025-01-21 06:56:46', '2025-02-07 17:00:00'),
(132, 7, 'Seni Budaya', 'Menghafalkan tarian yang ada di link wa digrup', 'belum', '2025-01-21 07:06:31', '2025-01-29 17:00:00'),
(133, 7, 'Bahasa Inggris', 'Membuat video tugas presentasi', 'belum', '2025-01-22 00:40:16', '2025-01-30 17:00:00'),
(134, 10, 'Sejarah Indonesia', 'AJSAGGSADAd', 'selesai', '2025-01-22 02:07:46', '2025-01-17 17:00:00'),
(135, 7, 'matematika', 'membuat video presentasi', 'selesai', '2025-01-22 06:00:19', '2025-01-23 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `email`, `password`, `tanggal_daftar`) VALUES
(7, 'hidayah ridho safitri', 'ridho', 'hidayahridho.safitri@gmail.com', '$2y$10$tdTouyOKK6fY.UAbdekkfehdfkO1U/gKDO9L2SZec79v8ylKRXnOy', '2025-01-21 04:31:01'),
(8, 'Noel Londok', 'noel', 'NoelLondok09@gmail.com', '$2y$10$2/0uxhJDaBYps3iUj9rWQepY4D1BvWvSXfSKKzyzA7iXqzutWUoFK', '2025-01-21 06:46:28'),
(9, 'Ana Jariyatun Khasanah', 'jariyatun', 'anajariyatun@gmail.com', '$2y$10$GBHqR5nM..tvE.XYu7O0o.ubUDh2uSkiC0xkGe/AsweXfj8/V17GS', '2025-01-21 07:11:54'),
(10, 'fustatul rizqi hidayat', 'tatul', 'fustatuk@gmail.com', '$2y$10$6L3t3UHu/BlTxSrvEgBaUehfIzFsjamVdR1hpHnDJbYSBBDD.IL.i', '2025-01-22 02:07:07'),
(11, 'rizky nurmitasari', 'rizky', 'rizkynurmita@gmail.com', '$2y$10$n2JTCIGG8kkDQmR90rQ2SejiMa8IhZdFOLnX3QLPRQnquaXw.rs/a', '2025-01-22 13:16:59'),
(12, 'Arvin Favian', 'aripin', 'arvin@gmail.com', '$2y$10$hjIurkcAxCUp9K8zWTXMQ..972/aJkTk8CLtLnOcsDYKSamFmbN0m', '2025-01-23 01:19:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
