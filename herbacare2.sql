-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 05:07 PM
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
-- Database: `herbacare2`
--

-- --------------------------------------------------------

--
-- Table structure for table `herbal`
--

CREATE TABLE `herbal` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `manfaat` text NOT NULL,
  `cara_penggunaan` text NOT NULL,
  `penyakit` varchar(100) DEFAULT NULL,
  `gambar` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `herbal`
--

INSERT INTO `herbal` (`id`, `nama`, `manfaat`, `cara_penggunaan`, `penyakit`, `gambar`) VALUES
(21, 'aaa', 'aa', 'aa', 'aa', 'e1ac816c-d65f-4c86-b3e2-5356bdafc140.jpg'),
(22, 'bbb', 'a', 'bb', 'bb', '4214rkiut0896m85 (1).png'),
(23, 'a', 'a', 'a', 'a', 'basil-flower-isolated-transparent-background.png');

-- --------------------------------------------------------

--
-- Table structure for table `komentar_herbal`
--

CREATE TABLE `komentar_herbal` (
  `id` int(11) NOT NULL,
  `herbal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentar_herbal`
--

INSERT INTO `komentar_herbal` (`id`, `herbal_id`, `user_id`, `isi`, `waktu`) VALUES
(6, 22, 3, 'aa', '2025-05-18 18:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(3, 'admin', 'admin', 'admin', 'admin@admin'),
(4, 'a', 'a', 'user', 'a@a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `herbal`
--
ALTER TABLE `herbal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentar_herbal`
--
ALTER TABLE `komentar_herbal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `herbal_id` (`herbal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `herbal`
--
ALTER TABLE `herbal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `komentar_herbal`
--
ALTER TABLE `komentar_herbal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar_herbal`
--
ALTER TABLE `komentar_herbal`
  ADD CONSTRAINT `komentar_herbal_ibfk_1` FOREIGN KEY (`herbal_id`) REFERENCES `herbal` (`id`),
  ADD CONSTRAINT `komentar_herbal_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
