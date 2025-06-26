-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 03:44 AM
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
-- Database: `db_archive4`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `post` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post`, `description`, `price`, `image`, `date`) VALUES
(1, 1, 'Kue Semprit Premium Original', 'Kue Semprit Original\n- 100% asli homemade\n- Tanpa pengawet/pewarna buatan -\n1 Bungkus isi 24 pcs', 30000, 'uploads/1749454039kue-semprit55.jpeg', '2025-06-09 09:27:19'),
(2, 2, 'Kue Nastar Keju Murah', 'Kue Nastar Murah - Dibuat dari keju asli - Tanpa bahan pengawet PLUS dijamin enak - 1 Bungkus 30 pcs', 45000, 'uploads/1749455551kue-nastar22.jpeg', '2025-06-09 09:52:31'),
(3, 4, 'KUE DONAT PAKET KOMBO ORIGINAL', 'KUE DONAT KOMBO ORIGINAL - 100% DIJAMIN ENAK TANPA PEMANIS BUATAN - 1 BUNGKUS ISI 4 DENGAN BERBAGAI RASA (COKLAT, VANILLA, STROBERI, DLL)', 25000, 'uploads/1749717459kue-donat.jpeg', '2025-06-12 10:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `image`, `email`, `password`, `date`) VALUES
(1, 'Jack', 'uploads/1749698697chimpanzee-wallpaper-funny.jpg', 'jack@email.com', '$2y$10$hqbM54BqYeXEC9Ek81hQluo0liamKG/pJPVekdFWKUTHrnzU1C4Ji', '2025-06-01 16:16:54'),
(2, 'Alex', 'uploads/1749160073simpanse-savanna_169.jpeg', 'alex@email.com', '$2y$10$WR4uTmsSD2.7Rc2RvpwrQu1Wx55LeqbzsVeOz2eNyJONTTxOd27di', '2025-06-05 23:16:28'),
(4, 'Jonathan', 'uploads/1749697713image.png', 'jonathan@email.com', '$2y$10$yqlJKyg.MenNwaCenx/hsOUGd76OMuV8k7AOyahPZZJil3APHTAWW', '2025-06-12 05:07:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
