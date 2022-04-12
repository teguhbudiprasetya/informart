-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2022 at 07:25 AM
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
  `ukuran` varchar(255) NOT NULL,
  `detailsOngkir` int(11) NOT NULL,
  `idEkspedisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `kodeUser`, `kodeItem`, `qty`, `warna`, `ukuran`, `detailsOngkir`, `idEkspedisi`) VALUES
(56, 1, 6, '1', 'Hitam', '-', 1500, 2),
(57, 1, 7, '1', 'Biru Dongker', 'XL', 3000, 1),
(58, 1, 5, '1', 'Hitam', 'XL', 16000, 1),
(64, 7, 8, '3', 'Hitam', '-', 12000, 1);

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
(5, 9, 'XL', 'Hitam', 9),
(6, 13, '-', 'Hitam', 8),
(7, 11, 'XL', 'Biru Dongker', 0),
(8, 12, '-', 'Hitam', 20),
(14, 10, 'M', 'Hitam', 0),
(15, 8, '38', 'Hitam', 55),
(16, 8, '39', 'Hitam', 9),
(17, 8, '42', 'Hitam', 20);

-- --------------------------------------------------------

--
-- Table structure for table `ekspedisi`
--

CREATE TABLE `ekspedisi` (
  `idEkspedisi` int(11) NOT NULL,
  `ekspedisiName` varchar(255) NOT NULL,
  `ekspedisiPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ekspedisi`
--

INSERT INTO `ekspedisi` (`idEkspedisi`, `ekspedisiName`, `ekspedisiPrice`) VALUES
(1, 'JNE Express', 1000),
(2, 'J&T Express', 500),
(3, 'Tiki', 700);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderItemID` int(11) NOT NULL,
  `kodeItem` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `transaksiID` int(11) NOT NULL,
  `detailsOngkir` int(11) NOT NULL,
  `idEkspedisi` int(11) NOT NULL,
  `kodePenjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderItemID`, `kodeItem`, `qty`, `harga`, `transaksiID`, `detailsOngkir`, `idEkspedisi`, `kodePenjual`) VALUES
(13, 6, 1, 30000, 18, 16000, 1, 1),
(14, 6, 1, 30000, 19, 16000, 1, 1),
(15, 8, 3, 80000, 20, 12000, 1, 7);

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
(12, 'Tas Hitam Polos', '0.4', 'Tas', 'sadaas', 'tas.jpg', 7, 80000, 0, 0),
(13, 'Topi Hitam Polos', '0.15 ', 'Topi', 'asdaa', 'topi.jpg', 1, 30000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `idProvinsi` int(11) NOT NULL,
  `namaProvinsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`idProvinsi`, `namaProvinsi`) VALUES
(1, 'Aceh'),
(2, 'Sumatera Utara'),
(3, 'Sumatera Barat'),
(4, 'Riau'),
(5, 'Jambi'),
(6, 'Kepulauan Riau'),
(7, 'Bengkulu'),
(8, 'Sumatra Selatan'),
(9, 'Kepulauan Bangka Belitung'),
(10, 'Lampung'),
(11, 'Banten'),
(12, 'DKI Jakarta'),
(13, 'Jawa Barat'),
(14, 'Jawa Tengah'),
(15, 'DI Yogyakarta'),
(16, 'Jawa Timur'),
(17, 'Bali'),
(18, 'Nusa Tenggara Barat'),
(19, 'Nusa Tenggara Timur'),
(20, 'Kalimantan Barat'),
(21, 'Kalimantan Tengah'),
(22, 'Kalimantan Selatan'),
(23, 'Kalimantan Timur'),
(24, 'Kalimantan Utara'),
(25, 'Sulawesi Barat'),
(26, 'Sulawesi Selatan'),
(27, 'Sulawesi Tenggara'),
(28, 'Sulawesi Tengah'),
(29, 'Gorontalo'),
(30, 'Sulawesi Utara'),
(31, 'Maluku Utara'),
(32, 'Maluku'),
(33, 'Papua Barat'),
(34, 'Papua');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `transaksiID` int(11) NOT NULL,
  `kodeUser` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tgl_beli` date NOT NULL,
  `tgl_sampai` date NOT NULL,
  `totalPrice` float NOT NULL,
  `totalOngkir` int(11) NOT NULL,
  `voucherID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`transaksiID`, `kodeUser`, `status`, `tgl_beli`, `tgl_sampai`, `totalPrice`, `totalOngkir`, `voucherID`) VALUES
(14, 1, 'bayar', '2022-04-09', '0000-00-00', 216450, 20500, 1),
(18, 7, 'bayar', '2022-04-09', '0000-00-00', 46000, 16000, 0),
(19, 7, 'bayar', '2022-04-09', '0000-00-00', 46000, 16000, 0),
(20, 7, 'bayar', '2022-04-09', '0000-00-00', 242000, 12000, 2);

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
  `transaksi` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `idProvinsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kodeUser`, `username`, `email`, `password`, `foto`, `transaksi`, `rating`, `saldo`, `idProvinsi`) VALUES
(1, 'teguh', 'teguh@gmail.com', '123', 'teguh.jpg', 3, 0, 240400, 16),
(7, 'aku', 'aku@gmail.com', '123', '', 2, 0, 1000000, 12);

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucherID` int(11) NOT NULL,
  `voucherName` varchar(255) NOT NULL,
  `potongan` float NOT NULL,
  `jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucherID`, `voucherName`, `potongan`, `jenis`) VALUES
(0, 'Tidak memakai voucher', 0, 'kurang'),
(1, 'DISKON10%', 0.1, 'bagi'),
(2, 'POTONGAN10K', 10000, 'kurang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_ibfk_1` (`kodeItem`),
  ADD KEY `cart_ibfk_2` (`kodeUser`),
  ADD KEY `cart_ibfk_3` (`idEkspedisi`);

--
-- Indexes for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  ADD PRIMARY KEY (`kodeItem`),
  ADD KEY `kodeProduk` (`kodeProduk`);

--
-- Indexes for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  ADD PRIMARY KEY (`idEkspedisi`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `kodeItem` (`kodeItem`),
  ADD KEY `transaksiID` (`transaksiID`),
  ADD KEY `idEkspedisi` (`idEkspedisi`),
  ADD KEY `kodePenjual` (`kodePenjual`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`kodeProduk`),
  ADD KEY `kodeUser` (`kodeUser`),
  ADD KEY `harga` (`harga`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`idProvinsi`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`transaksiID`),
  ADD KEY `voucherID` (`voucherID`),
  ADD KEY `tbl_order_ibfk_2` (`kodeUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`kodeUser`),
  ADD KEY `idProvinsi` (`idProvinsi`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucherID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  MODIFY `kodeItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  MODIFY `idEkspedisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `kodeProduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `idProvinsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `transaksiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `kodeUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`kodeItem`) REFERENCES `detailsproduct` (`kodeItem`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`kodeUser`) REFERENCES `user` (`kodeUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`idEkspedisi`) REFERENCES `ekspedisi` (`idEkspedisi`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`transaksiID`) REFERENCES `tbl_order` (`transaksiID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_3` FOREIGN KEY (`idEkspedisi`) REFERENCES `ekspedisi` (`idEkspedisi`),
  ADD CONSTRAINT `orderdetails_ibfk_4` FOREIGN KEY (`kodePenjual`) REFERENCES `product` (`kodeUser`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`kodeUser`) REFERENCES `user` (`kodeUser`);

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_3` FOREIGN KEY (`voucherID`) REFERENCES `voucher` (`voucherID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idProvinsi`) REFERENCES `provinsi` (`idProvinsi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
