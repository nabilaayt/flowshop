-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 08:50 AM
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
(2, 'Fantasy Bloom', 'Decor Flower', 140000, 'uploads/1742846149_blossom.jpeg'),
(3, 'Sunshine Sun', 'Decor Flower', 710000, 'uploads/1742846212_shine.jpeg'),
(4, 'Elegance With U', 'Decor Flower', 899998, 'uploads/1742846277_decorFlower2.jpeg'),
(5, 'Red Flame Blossom', 'Decor Flower', 160000, 'uploads/1742846291_decorFlower4.jpeg'),
(6, 'Summer Mate', 'Decor Flower', 100000, 'uploads/1742846421_summer.jpeg'),
(7, 'Loewe Flower', 'Decor Flower', 400000, 'uploads/1742835010_loewe.jpeg'),
(8, 'Uniq Flowers', 'Hand Bouquet', 400000, 'uploads/1742888096_𝗽𝗹𝗮𝗻𝘁𝘀𝗰𝗼𝗹𝗹𝗲𝗰𝘁𝗶𝗼𝗻 𝗼𝘀𝗮𝗸𝗮 _ 𓈒𓏸….jpeg'),
(9, 'raditsgo flower', 'Fresh Flower', 379999, 'uploads/1742888178_c4422dd7-7668-44e2-a04e-75f225b0168e.jpeg'),
(10, 'sakuraqet', 'Hand Bouquet', 378000, 'uploads/1742888256_sakurachan.jpeg'),
(11, 'Mixed Bloom', 'Fresh Flower', 378900, 'uploads/1742888449_mixed bloom.jpeg'),
(12, 'Pinkies', 'Fresh Flower', 400000, 'uploads/1742888477_pinkes.jpeg'),
(13, 'Aurels Flowers', 'Hand Bouquet', 450000, 'uploads/1742888701_aurel boms.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
