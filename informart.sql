-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2022 at 09:45 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `informart`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `kodeUser` int(11) NOT NULL,
  `kodeItem` int(11) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `ukuran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `kodeUser`, `kodeItem`, `qty`, `warna`, `ukuran`) VALUES
(24, 1, 4, '1', 'Putih', 'S'),
(28, 1, 6, '1', 'Hitam', '-'),
(29, 1, 6, '1', 'Hitam', '-'),
(32, 1, 6, '1', 'Hitam', '-');

-- --------------------------------------------------------

--
-- Table structure for table `detailsproduct`
--

CREATE TABLE `detailsproduct` (
  `kodeItem` int(11) NOT NULL,
  `kodeProduk` int(11) NOT NULL,
  `ukuran` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailsproduct`
--

INSERT INTO `detailsproduct` (`kodeItem`, `kodeProduk`, `ukuran`, `warna`, `stok`) VALUES
(3, 8, 'S', 'Hitam', 0),
(4, 10, 'S', 'Putih', 1),
(5, 9, 'XL', 'Hitam', 10),
(6, 13, '-', 'Hitam', 13),
(7, 11, 'XL', 'Biru Dongker', 1),
(8, 12, '-', 'Hitam', 24),
(14, 10, 'M', 'Hitam', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `transaksiID` int(11) NOT NULL,
  `kodeUser` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tgl_beli` date NOT NULL,
  `tgl_sampai` date NOT NULL,
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderItemID` int(11) NOT NULL,
  `kodeItem` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `detailsPrice` int(11) NOT NULL,
  `transaksiID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `kodeProduk` int(11) NOT NULL,
  `namaProduk` varchar(255) NOT NULL,
  `berat` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `kodeUser` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `terjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`kodeProduk`, `namaProduk`, `berat`, `kategori`, `deskripsi`, `gambar`, `kodeUser`, `harga`, `rating`, `terjual`) VALUES
(8, 'Sepatu Vans', '0.2 ', 'Sepatu', 'sadada', 'sepatu.jpg', 1, 100000, 5, 0),
(9, 'Erigo Jacket', '0.5', 'Jaket', 'asdasda', 'erigo.jpg', 1, 120000, 3, 0),
(10, 'Baju Wanita Putih', '0.3', 'Baju Wanita', 'dsadada', 'kategori-baju-wanita.jpg', 1, 50000, 0, 0),
(11, 'Sweater Pria', '0.4', 'Baju Pria', 'afasa', 'kategori-baju-pria.jpg', 1, 70000, 0, 0),
(12, 'Tas Hitam Polos', '0.4', 'Tas', 'sadaas', 'tas.jpg', 1, 80000, 0, 0),
(13, 'Topi Hitam Polos', '0.15 ', 'Topi', 'asdaa', 'topi.jpg', 1, 30000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `kodeUser` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `transaksi` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kodeUser`, `username`, `email`, `password`, `foto`, `lokasi`, `transaksi`, `rating`, `saldo`) VALUES
(1, 'teguh', 'teguh@gmail.com', '123', 'teguh.jpg', 'Jawa Timur', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_ibfk_1` (`kodeItem`),
  ADD KEY `cart_ibfk_2` (`kodeUser`);

--
-- Indexes for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  ADD PRIMARY KEY (`kodeItem`),
  ADD KEY `kodeProduk` (`kodeProduk`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`transaksiID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `kodeItem` (`kodeItem`),
  ADD KEY `transaksiID` (`transaksiID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`kodeProduk`),
  ADD KEY `kodeUser` (`kodeUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`kodeUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  MODIFY `kodeItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `transaksiID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `kodeProduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `kodeUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`kodeItem`) REFERENCES `detailsproduct` (`kodeItem`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`kodeUser`) REFERENCES `user` (`kodeUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  ADD CONSTRAINT `detailsproduct_ibfk_1` FOREIGN KEY (`kodeProduk`) REFERENCES `product` (`kodeProduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`kodeItem`) REFERENCES `detailsproduct` (`kodeItem`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`transaksiID`) REFERENCES `order` (`transaksiID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`kodeUser`) REFERENCES `user` (`kodeUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
