-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2022 at 04:32 AM
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
(101, 14, 49, '3', '-', '-', 12000, 1),
(102, 11, 46, '1', 'Putih', '40', 12000, 1);

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
(18, 14, '', '', 100),
(19, 15, '', '', 100),
(20, 16, '', '', 100),
(21, 17, '', '', 100),
(22, 18, '', '', 100),
(23, 19, '', '', 100),
(24, 20, '', '', 100),
(25, 21, '', '', 100),
(26, 22, '', '', 100),
(29, 24, 'S', 'Hitam', 32),
(30, 24, 'M', 'Hitam', 20),
(31, 24, 'XL', 'Hitam', 50),
(32, 25, 'XL', 'Hijau', 37),
(33, 26, 'XL', 'Kuning', 47),
(34, 27, 'M', 'Cream', 24),
(35, 28, 'XL', 'Navy', 21),
(36, 29, 'L', 'Navy', 42),
(37, 30, 'XL', 'Abu-abu', 75),
(38, 31, 'XL', 'Biru', 87),
(40, 33, '40', 'Abu-abu', 10),
(41, 34, '41', 'Hitam', 14),
(42, 35, '42', 'Abu-abu', 54),
(43, 36, '39', 'Putih', 40),
(44, 37, '37', 'Merah', 29),
(45, 38, '36', 'Cream', 25),
(46, 39, '40', 'Putih', 79),
(47, 40, '40', 'Colorfull', 40),
(48, 41, '36', 'Fushia', 38),
(49, 42, '-', '-', 17),
(50, 43, '-', '-', 45),
(51, 44, '-', '-', 49),
(52, 45, '-', '-', 28);

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
(0, 'admin', 0),
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
  `status` varchar(255) NOT NULL,
  `kodePenjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderItemID`, `kodeItem`, `qty`, `harga`, `transaksiID`, `detailsOngkir`, `idEkspedisi`, `status`, `kodePenjual`) VALUES
(77, 26, 1, 1000000, 94, 0, 0, 'selesai', 0),
(78, 50, 3, 200000, 95, 12000, 1, 'selesai', 15),
(79, 50, 1, 200000, 96, 12000, 1, 'selesai', 15),
(80, 50, 1, 200000, 97, 12000, 1, 'selesai', 15),
(81, 26, 1, 1000000, 98, 0, 0, 'selesai', 0),
(82, 49, 3, 200000, 99, 12000, 1, 'selesai', 15),
(83, 26, 1, 1000000, 100, 0, 0, 'selesai', 0),
(84, 46, 1, 129900, 101, 12000, 1, 'Sedang dikirim', 14);

--
-- Triggers `orderdetails`
--
DELIMITER $$
CREATE TRIGGER `UpdateRatingSeller` AFTER UPDATE ON `orderdetails` FOR EACH ROW IF (NEW.status = 'selesai' AND OLD.status != 'selesai') 
THEN
    UPDATE user SET rating = (SELECT SUM(product.rating)/ COUNT(product.kodeProduk) FROM product WHERE product.kodeUser = NEW.kodePenjual AND product.terjual > 0) 
   WHERE user.kodeUser = NEW.kodePenjual;
END IF
$$
DELIMITER ;

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
  `rating` decimal(11,2) NOT NULL,
  `terjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`kodeProduk`, `namaProduk`, `berat`, `kategori`, `deskripsi`, `gambar`, `kodeUser`, `harga`, `rating`, `terjual`) VALUES
(14, 'Pulsa10K', '0', 'payment', '', 'pulsa.jpg', 0, 10000, '0.00', 1),
(15, 'Pulsa15K', '0', 'payment', '', 'pulsa.jpg', 0, 15000, '0.00', 0),
(16, 'Pulsa20K', '', 'payment', '', 'pulsa.jpg', 0, 20000, '0.00', 1),
(17, 'PLN 50K', '', 'payment', '', 'pln.png', 0, 50000, '0.00', 0),
(18, 'PLN 100K', '', 'payment', '', 'pln.png', 0, 100000, '0.00', 0),
(19, 'E-Money 20K', '', 'payment', '', 'e-money.png', 0, 20000, '0.00', 0),
(20, 'E-Money 50K', '', 'payment', '', 'e-money.png', 0, 50000, '0.00', 1),
(21, 'Top Up Saldo 500K', '', 'payment-saldo', '', 'saldo.png', 0, 500000, '0.00', 5),
(22, 'Top Up Saldo 1 Juta', '', 'payment-saldo', '', 'saldo.png', 0, 1000000, '0.00', 4),
(24, 'Erigo Thompson', '0.3', 'Baju Pria', 'Graphic tee dengan oversized fit dan bahan yang nyaman untuk dipakai beraktivitas sehari-hari. Dengan kesan yang simpel dan elegan namun tetap casual dan stylish\r\n\r\nHIGHLIGHTS\r\n- Graphic details\r\n- Oversized fit\r\n- Light-weight', 'erigo thompson.jpg', 12, 65000, '0.00', 0),
(25, 'Erigo Bardy', '0.3', 'Baju Pria', 'T-shirt Oversize merupakan T-shirt berkualitas tinggi dengan design yang menarik dan fresh di antara Local Brand Indonesia. Dengan model oversize berlengan pendek tanpa tudung, list di lengan baju yang keren menjadikan ciri khas tersediri dari T-shirt Ove', 'erigo bardy.jpg', 12, 100000, '0.00', 0),
(26, 'Erigo Mustard', '0.3', 'Baju Pria', 'T-Shirt Erigo saat ini merupakan salah satu lini pakaian terbaik dan berkualitas tinggi di antara Local Brand Indonesia. Dibuat dengan bahan cotton yang nyaman untuk menemani harimu dan memiliki print desain yang unik. Dapatkan long lasting tee dengan war', 'erigo mustard.jpg', 12, 60000, '0.00', 0),
(27, 'Erigo Coast', '0.3', 'Baju Wanita', 'T-Shirt Erigo saat ini merupakan salah satu lini pakaian terbaik dan berkualitas tinggi di antara Local Brand Indonesia. Dibuat dengan bahan cotton yang nyaman untuk menemani harimu dan memiliki print desain yang unik. Dapatkan long lasting tee dengan war', 'erigo coast.jpg', 12, 65000, '0.00', 0),
(28, 'Erigo Como', '0.3', 'Baju Wanita', 'T-shirt Oversize merupakan T-shirt berkualitas tinggi dengan design yang menarik dan fresh di antara Local Brand Indonesia. Dengan model oversize berlengan pendek tanpa tudung, list di lengan baju yang keren menjadikan ciri khas tersediri dari T-shirt Ove', 'erigo como.jpg', 12, 100000, '0.00', 0),
(29, 'Erigo Over Power', '0.3', 'Baju Pria', 'T-Shirt Erigo saat ini merupakan salah satu lini pakaian terbaik dan berkualitas tinggi di antara Local Brand Indonesia. Dibuat dengan bahan cotton yang nyaman untuk menemani harimu dan memiliki print desain yang unik. Dapatkan long lasting tee dengan war', 'erigo overpower.jpg', 12, 60000, '0.00', 0),
(30, 'Erigo Coach Peace', '0.4', 'Jaket', 'Coach Jacket Erigo saat ini merupakan salah satu lini pakaian terbaik dan berkualitas tinggi di antara Local Brand Indonesia. Jaket berkerah dengan kancing jepret, saku fungsional, dan karet pada ujung lengan. Coach Jacket Erigo memiliki printed design ya', 'Erigo peace.jpg', 12, 100000, '0.00', 0),
(31, 'Erigo Axelle', '0.5', 'Jaket', 'Coach Jacket Erigo saat ini merupakan salah satu lini pakaian terbaik dan berkualitas tinggi di antara Local Brand Indonesia. Jaket berkerah dengan kancing jepret, saku fungsional, dan karet pada ujung lengan. Coach Jacket Erigo memiliki printed design ya', 'erigo axelle.jpg', 12, 100000, '0.00', 0),
(33, 'Prepstudio N.London', '0.3', 'Celana Pria', 'Deskripsi:\r\n- Bahan: Jeans Non-Stretch\r\n- Warna: Grey\r\n- Fit: Reguler Fit', 'Celana Jeans N.London.jpg', 13, 150000, '0.00', 0),
(34, 'Prepstudio Alaska', '0.3', 'Celana Pria', 'Deskripsi:\r\n- Bahan: Stretch Jeans\r\n- Warna: Hitam\r\n- Fit: Reguler Fit\r\n- Ketebalan Bahan : 11 oz', 'prep alaska.jpg', 13, 150000, '0.00', 0),
(35, 'Prep Skinny', '0.3', 'Celana Pria', 'Deskripsi:\r\n- Bahan: Stretch Jeans\r\n- Warna: Hitam\r\n- Fit: Reguler Fit\r\n- Ketebalan Bahan : 11 oz', 'prep skinny.jpg', 13, 200000, '0.00', 0),
(36, 'Prep Premium', '0.3', 'Celana Pria', 'Deskripsi:\r\n- Bahan: Stretch Jeans\r\n- Warna: Hitam\r\n- Fit: Reguler Fit\r\n- Ketebalan Bahan : 11 oz', 'prep premium.jpg', 13, 150000, '0.00', 0),
(37, 'Prep Kama Linen', '0.3', 'Celana Wanita', '- Fabric : Cotton Linen\r\n- Size : Free Size Fit to XL\r\n- Measurements : Waist 74-100cm; Length 89cm; Crotch 68cm; Thigh 60cm\r\n- Complete with side pocket, back rubber, and front zipper', 'Kama Linen.jpg', 13, 150000, '0.00', 0),
(38, 'Prep Beige', '0.3', 'Celana Wanita', '- Fabric : Cotton Linen\r\n- Size : Free Size Fit to XL\r\n- Measurements : Waist 74-100cm; Length 89cm; Crotch 68cm; Thigh 60cm\r\n- Complete with side pocket, back rubber, and front zipper', 'prep beige.jpg', 13, 150000, '0.00', 0),
(39, 'Aerostreet Tokyo', '0,6', 'Sepatu', 'TIDAK AKAN JEBOL setelah dicuci atau kehujanan karena menggunakan tekhnologi baru Shoes Injection Mould bahan sole dicairkan dengan tekanan tinggi menyatu sempurna dengan bahan kain dari sepatu tanpa menggunakan proses lem.\r\n\r\nBahan : Syntetis', 'aero tokyo.jpg', 14, 129900, '0.00', 1),
(40, 'Aerostreet Riku', '0.6', 'Sepatu', 'TIDAK AKAN JEBOL setelah dicuci atau kehujanan karena menggunakan tekhnologi baru Shoes Injection Mould bahan sole dicairkan dengan tekanan tinggi menyatu sempurna dengan bahan kain dari sepatu tanpa menggunakan proses lem.\r\n\r\nBahan : Syntetis', 'aero riku.jpg', 14, 149900, '0.00', 0),
(41, 'Aerostreet Fushia', '0,6', 'Sepatu', 'TIDAK AKAN JEBOL setelah dicuci atau kehujanan karena menggunakan tekhnologi baru Shoes Injection Mould bahan sole dicairkan dengan tekanan tinggi menyatu sempurna dengan bahan kain dari sepatu tanpa menggunakan proses lem.\r\n\r\nBahan : Syntetis', 'aero fushia.jpg', 14, 139900, '0.00', 0),
(42, 'Hamlin Drsh', '0.3', 'Topi', '- Item Type : Baseball Caps\r\n- Material : Cotton\r\n- Gender Unisex\r\n- Style : Kasual\r\n- Creative Design\r\n- Resizable Strap\r\n- Include Hard Box Exclusive Hamlin', 'hamlin drsh.jpg', 15, 200000, '5.00', 1),
(43, 'Hamlin Onds', '0.3', 'Topi', 'Hamlin Onds Topi Trucker Baseball', 'hamlin onds.png', 15, 200000, '4.67', 3),
(44, 'Arei Alcudia', '1', 'Tas', 'Tas Ransel Alcudia 20 Liter Arei Outdoorgear\r\nTas Ransel Alcudia 20 Liter Arei Outdoorgear cocok digunakan untuk kegiatan sehari-hari. Dilengkapi kompartement utama dan kompartement tambahan seperti saku depan, saku dalam.. Ransel Alcudia 20 Liter siap me', 'arei alcudia.jpg', 16, 200000, '0.00', 0),
(45, 'Tas Semi Carrier Toba', '1.2', 'Tas', 'Tas Semi Carrier Toba 35+5 Liter Arei Outdoorgear\r\n\r\nTas Semi Carrier Toba 35+5 Liter Arei dirancang untuk kegiatan hiking ringan selama 1-2 hari.Tas Semi Carrier Toba 35+5 Liter Arei dilengkapi kompartement utama dan kompartement tambahan seperti saku de', 'arei toba.jpg', 16, 250000, '0.00', 0);

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `UpdateStatustoSeller` BEFORE INSERT ON `product` FOR EACH ROW IF NOT EXISTS (SELECT * FROM product WHERE kodeUser = new.kodeUser) 
THEN
   UPDATE user SET status = 'seller' WHERE kodeUser = new.kodeUser;
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateStatustoSellertoUser` AFTER DELETE ON `product` FOR EACH ROW IF NOT EXISTS (SELECT * FROM product WHERE kodeUser = OLD.kodeUser) 
THEN
   UPDATE user SET status = '' WHERE kodeUser = OLD.kodeUser;
END IF
$$
DELIMITER ;

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
(34, 'Papua'),
(35, 'Belum memilih');

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
(94, 14, 'selesai', '2022-06-24', '2022-06-24', 1000000, 0, 0),
(95, 14, 'selesai', '2022-06-24', '2022-06-24', 550800, 12000, 1),
(96, 14, 'selesai', '2022-06-24', '2022-06-24', 212000, 12000, 0),
(97, 14, 'selesai', '2022-06-24', '2022-06-24', 190800, 12000, 1),
(98, 14, 'selesai', '2022-06-24', '2022-06-24', 1000000, 0, 0),
(99, 14, 'selesai', '2022-06-24', '2022-06-24', 550800, 12000, 1),
(100, 11, 'selesai', '2022-06-28', '2022-06-28', 1000000, 0, 0),
(101, 11, 'proses', '2022-06-28', '0000-00-00', 127710, 12000, 1);

--
-- Triggers `tbl_order`
--
DELIMITER $$
CREATE TRIGGER `UpdateSaldoUser` AFTER INSERT ON `tbl_order` FOR EACH ROW UPDATE user SET saldo = saldo - new.totalPrice WHERE user.kodeUser = new.kodeUser
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `kodeUser` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `transaksi` int(11) NOT NULL,
  `penjualan` int(11) NOT NULL,
  `rating` float(11,2) NOT NULL,
  `saldo` int(11) NOT NULL,
  `idProvinsi` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kodeUser`, `username`, `fullname`, `email`, `telepon`, `password`, `foto`, `transaksi`, `penjualan`, `rating`, `saldo`, `idProvinsi`, `alamat`, `status`) VALUES
(0, 'adminmaster', 'adminmaster', 'adminmaster@gmail.com', '', '123', 'teguh.jpg', 0, 0, 0.00, 0, 16, '-', 'admin'),
(11, 'teguh', '', 'teguhdaftarkuliah@gmail.com', '', '12345678', 'profileblank.jpg', 1, 0, 0.00, 872290, 35, '', 'user'),
(12, 'Erigo', 'Erigo Apparel', 'ErigoApparel@gmail.com', '6231321423', '12345678', 'erigo.jpg', 0, 0, 0.00, 0, 12, 'Jl Daha II/15 A, DkI Jakarta 12110\r\n\r\n', 'seller'),
(13, 'Prepstudio', 'Prepstudio HQ', 'PrepstudioHQ@gmail.com', '6231321242', '12345678', 'prepstudio.jpg', 0, 0, 0.00, 0, 12, 'Jl Melayu Besar 68, DkI Jakarta 12110\r\n\r\n', 'seller'),
(14, 'Aerostreet', 'Aerostreet Official Shop', 'Aerostreet@gmail.com', '62313231321', '12345678', 'aero.jpg', 4, 1, 0.00, 495600, 12, 'Jl Mitra Sunter Boulevard Kompl Mitra Sunter Bl B-21, DkI Jakarta 12110\r\n\r\n', 'seller'),
(15, 'Hamlin', 'Hamlin Official Shop', 'hamlin@gmail.com', '62313236897', '12345678', 'hamlin.jpg', 0, 4, 4.84, 0, 12, 'Jl Pancoran 42 -A/5-6, DkI Jakarta 12110\r\n\r\n', 'seller'),
(16, 'Arei', 'Arei Outdoor Gear', 'arei@gmail.com', '62313236421', '12345678', 'arei.jpg', 0, 0, 0.00, 0, 12, 'Jl Gajah Mada 19-26 Gajah Mada Plaza Ground Fl 27 Petojo Utara JA, DkI Jakarta 12110\r\n\r\n', 'seller'),
(17, 'Teguh', 'Teguh Budi', 'teguh@gmail.com', '082338564527', '12345678', 'profileblank.jpg', 0, 0, 0.00, 99999999, 16, 'Perumnas Kamal Jl. Jeruk Raya No. 9', ''),
(18, 'Silvia', 'Silvia', 'silvia@gmail.com', '082335626088', '12345678', 'profileblank.jpg', 0, 0, 0.00, 99999999, 16, 'Telang Indah Jl. Jeruk Raya No. 9', ''),
(19, 'Dita', 'Dita', 'dita@gmail.com', '081259918783', '12345678', 'profileblank.jpg', 0, 0, 0.00, 99999999, 16, 'Telang Indah Jl. Jeruk Raya No. 9', ''),
(20, 'Astia', 'Astia', 'astia@gmail.com', '083893545155', '12345678', 'profileblank.jpg', 0, 0, 0.00, 99999999, 16, 'Telang Indah Jl. Jeruk Raya No. 9', '');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucherID` int(11) NOT NULL,
  `voucherName` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `potongan` float NOT NULL,
  `jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucherID`, `voucherName`, `keterangan`, `potongan`, `jenis`) VALUES
(0, 'Tidak memakai voucher', '', 0, 'kurang'),
(1, 'DISKON10%', 'Anda akan mendapatkan potongan 10% dari totol belanja anda TANPA minimal belanja.\r\nTidak termasuk produk payment', 0.1, 'bagi'),
(2, 'POTONGAN10K', 'Anda akan mendapatkan potongan 10 ribu dari totol belanja anda TANPA minimal belanja.\r\nTidak termasuk produk payment', 10000, 'kurang');

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
  ADD KEY `orderdetails_ibfk_4` (`kodePenjual`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `detailsproduct`
--
ALTER TABLE `detailsproduct`
  MODIFY `kodeItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  MODIFY `idEkspedisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `kodeProduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `idProvinsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `transaksiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `kodeUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  ADD CONSTRAINT `orderdetails_ibfk_4` FOREIGN KEY (`kodePenjual`) REFERENCES `product` (`kodeUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`kodeUser`) REFERENCES `user` (`kodeUser`) ON DELETE CASCADE ON UPDATE CASCADE;

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
