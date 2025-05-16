-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 07:18 PM
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
-- Database: `flowshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `harga`, `foto`) VALUES
(1, 'Passion in Bloom', 'Hand Bouquet', 600000, 'uploads/1742835531_𝐲𝐮𝐮𝐫𝐢 ｜ウェディングブーケ・オーダーメイド｜𝐅𝐥𝐨𝐰𝐞𝐫….jpeg'),
(2, 'Fantasy Bloom', 'Decor Flower', 200000, 'uploads/1742846149_blossom.jpeg'),
(3, 'Sunshine Sun', 'Decor Flower', 800000, 'uploads/1742846212_shine.jpeg'),
(4, 'Elegance With U', 'Decor Flower', 899998, 'uploads/1742846277_decorFlower2.jpeg'),
(5, 'Red Flame Blossom', 'Decor Flower', 260000, 'uploads/1742846291_decorFlower4.jpeg'),
(6, 'Summer Mate', 'Decor Flower', 300000, 'uploads/1742846421_summer.jpeg'),
(7, 'Loewe Flower', 'Decor Flower', 400000, 'uploads/1742835010_loewe.jpeg'),
(8, 'Uniq Flowers', 'Hand Bouquet', 400000, 'uploads/1742888096_𝗽𝗹𝗮𝗻𝘁𝘀𝗰𝗼𝗹𝗹𝗲𝗰𝘁𝗶𝗼𝗻 𝗼𝘀𝗮𝗸𝗮 _ 𓈒𓏸….jpeg'),
(9, 'raditsgo flower', 'Fresh Flower', 379999, 'uploads/1742888178_c4422dd7-7668-44e2-a04e-75f225b0168e.jpeg'),
(10, 'sakuraqet', 'Hand Bouquet', 378000, 'uploads/1742888256_sakurachan.jpeg'),
(11, 'Mixed Bloom', 'Fresh Flower', 378900, 'uploads/1742888449_mixed bloom.jpeg'),
(12, 'Pinkies', 'Fresh Flower', 400000, 'uploads/1742888477_pinkes.jpeg'),
(13, 'Aurels Flowers', 'Hand Bouquet', 450000, 'uploads/1742888701_aurel boms.jpeg'),
(15, 'Pinkies Flowers', 'Fresh Flower', 300000, 'uploads/8ca4c59446ad19e48116c8282ed5fc9559ecd2e47dac7ffccd43cc6c6cf7e908.jpeg'),
(17, 'randomm', 'Hand Bouquet', 200000, 'uploads/1743013337_f6f3f217cf2993cab57a8bd7dfd5ecf55def3e370cb5476acd346013ee56d891.jpeg'),
(19, 'White Flow Wedding', 'Wedding Flower', 200000, 'uploads/1744730393_d3800b743276934615ead4bd3be6ffc885567a5e315d43bc8e5481bf408fed7b.jpeg'),
(20, 'Flow Wedding', 'Wedding Flower', 500000, 'uploads/1744730454_5eac55dca84aaec7099c4ae57a5b1323260324ed2c17131679b840b5a41a3781.jpeg'),
(21, 'Flow Wedding2', 'Wedding Flower', 210000, 'uploads/1744730532_aebc3e35323f58e608a6e83999a7402bdb0b062bc2fdae00e76888d522ca7c85.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`) VALUES
(10, 'nabilaayu', 'nabilaayuu@gmail.com', '$2y$10$QWeUQ6u8KAsBjQj8vSucdujBN0ukuAi.w9ENsIaC2eEhVx10o76A6', 'user'),
(11, 'Admin', 'admin@flowshop.com', '$2y$10$hxzYFFCUOHZWRjDRExgciOTNSUqMaa6M6SIqnQUTkePAEqu4md/G2', 'admin'),
(12, 'nabila', 'nabila@gmail.com', '$2y$10$jLOOhxIaNklf.ULQF5FQC.k6sxa42LLbIMwkpMt5LRn9JOkAm0YV2', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
