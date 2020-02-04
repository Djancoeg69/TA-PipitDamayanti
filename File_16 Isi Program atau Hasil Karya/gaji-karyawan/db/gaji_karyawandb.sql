-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 10 Nov 2014 pada 12.50
-- Versi Server: 5.5.27
-- Versi PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `gaji_karyawandb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bagian`
--

CREATE TABLE IF NOT EXISTS `bagian` (
  `kd_bagian` char(6) NOT NULL,
  `nm_bagian` varchar(50) NOT NULL,
  `gaji_pokok` int(10) NOT NULL,
  `uang_transport` int(10) NOT NULL,
  `uang_makan` int(10) NOT NULL,
  `uang_lembur` int(10) NOT NULL,
  PRIMARY KEY (`kd_bagian`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bagian`
--

INSERT INTO `bagian` (`kd_bagian`, `nm_bagian`, `gaji_pokok`, `uang_transport`, `uang_makan`, `uang_lembur`) VALUES
('B002', 'PENJUALAN', 800000, 20000, 100000, 30000),
('BAG004', 'SEWING', 950000, 20000, 30000, 10000),
('BAG008', 'CUTING', 800000, 20000, 30000, 10000),
('BAG007', 'BORDIR', 720000, 20000, 35000, 15000),
('BAG006', 'OBRAS', 650000, 20000, 30000, 17000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE IF NOT EXISTS `karyawan` (
  `nik` char(20) NOT NULL,
  `nm_karyawan` varchar(50) NOT NULL,
  `kd_bagian` char(6) NOT NULL,
  `kelamin` varchar(10) NOT NULL,
  `gol_darah` enum('','A','B','AB','O') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `alamat_tinggal` varchar(100) NOT NULL,
  `no_telepon` int(12) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `status_kawin` enum('Kawin','Belum Kawin') NOT NULL,
  `tanggal_masuk` date NOT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nm_karyawan`, `kd_bagian`, `kelamin`, `gol_darah`, `agama`, `alamat_tinggal`, `no_telepon`, `tempat_lahir`, `tanggal_lahir`, `status_kawin`, `tanggal_masuk`) VALUES
('140713003', 'SURYA PALOH', 'BAG006', 'LAKI-LAKI', 'A', 'Katolik', 'bogor', 2332, 'rs', '1973-03-14', 'Kawin', '2014-07-13'),
('140713006', 'BUNGA DINANTI', 'B002', 'PEREMPUAN', 'AB', 'Islam', 'bogor barat', 2147483647, 'bandung', '1988-09-15', 'Belum Kawin', '2014-07-13'),
('140713004', 'KIKI SUSANTI', 'BAG008', 'PEREMPUAN', 'AB', 'Islam', 'bogor indonesia', 2147483647, 'bogor', '1954-07-13', 'Kawin', '2014-07-13'),
('140713005', 'HENI KUMALASARI', 'BAG007', 'PEREMPUAN', 'B', 'Islam', 'kandang roda', 2147483647, 'jakarta', '1990-06-10', 'Belum Kawin', '2014-07-13'),
('140712001', 'pipit', 'B002', 'Perempuan', 'B', 'Islam', 'citeureup', 2147483647, 'bogor', '1992-07-18', 'Belum Kawin', '2014-07-12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lembur`
--

CREATE TABLE IF NOT EXISTS `lembur` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nik` char(20) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kd_user` char(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data untuk tabel `lembur`
--

INSERT INTO `lembur` (`id`, `nik`, `tanggal`, `keterangan`, `kd_user`) VALUES
(22, '140713003', '2014-07-13', 'LEMBUR', 'U002'),
(23, '140713004', '2014-07-13', 'LEMBUR', 'U002'),
(18, '140712001', '2014-07-11', 'lembur', 'U002'),
(24, '140713005', '2014-07-13', 'LEMBUR', 'U002'),
(20, '140712001', '2014-07-12', 'lembur', 'U002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggajian`
--

CREATE TABLE IF NOT EXISTS `penggajian` (
  `id_slip` char(6) NOT NULL,
  `periode_gaji` char(7) NOT NULL,
  `tanggal` date NOT NULL,
  `nik` char(20) NOT NULL,
  `gaji_pokok` int(10) NOT NULL,
  `tunj_transport` int(10) NOT NULL,
  `tunj_makan` int(10) NOT NULL,
  `total_lembur` int(10) NOT NULL,
  `total_potongan` int(10) NOT NULL,
  `kd_user` char(4) NOT NULL,
  PRIMARY KEY (`id_slip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penggajian`
--

INSERT INTO `penggajian` (`id_slip`, `periode_gaji`, `tanggal`, `nik`, `gaji_pokok`, `tunj_transport`, `tunj_makan`, `total_lembur`, `total_potongan`, `kd_user`) VALUES
('PGJ412', '07-2014', '2014-07-13', '140713005', 720000, 20000, 35000, 15000, 20000, 'U002'),
('PGJ410', '07-2014', '2014-07-13', '140713003', 650000, 20000, 30000, 17000, 5000, 'U002'),
('PGJ409', '06-2014', '2014-07-13', '140712001', 800000, 20000, 100000, 0, 2000, 'U002'),
('PGJ411', '07-2014', '2014-07-13', '140713004', 800000, 20000, 30000, 10000, 20000, 'U002'),
('PGJ413', '07-2014', '2014-07-13', '140713006', 800000, 20000, 100000, 0, 15000, 'U002'),
('PGJ414', '06-2014', '2014-07-21', '140712001', 800000, 20000, 100000, 0, 2000, 'U002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `potongan`
--

CREATE TABLE IF NOT EXISTS `potongan` (
  `id_potongan` int(4) NOT NULL AUTO_INCREMENT,
  `nik` char(20) NOT NULL,
  `tanggal` date NOT NULL,
  `besar_potongan` int(10) NOT NULL,
  `nama_potongan` varchar(50) NOT NULL,
  `kd_user` char(4) NOT NULL,
  PRIMARY KEY (`id_potongan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `potongan`
--

INSERT INTO `potongan` (`id_potongan`, `nik`, `tanggal`, `besar_potongan`, `nama_potongan`, `kd_user`) VALUES
(9, '140713005', '2014-07-13', 20000, 'KOPERASI', 'U002'),
(4, '140713003', '2014-07-11', 5000, 'jajan', 'U002'),
(8, '140713004', '2014-07-13', 20000, 'BOLOS', 'U002'),
(7, '140712001', '2014-07-13', 2000, 'ssss', 'U002'),
(10, '140713006', '2014-07-13', 15000, 'MAKAN', 'U002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `kd_user` char(4) NOT NULL,
  `nm_user` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`kd_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`kd_user`, `nm_user`, `no_telepon`, `username`, `password`) VALUES
('U001', 'Septi Suhesti', '0211111111111', 'admin', '698d51a19d8a121ce581499d7b701668'),
('U002', 'arif rahman', '085716208902', 'arif', '202cb962ac59075b964b07152d234b70');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
