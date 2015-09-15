-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2013 at 10:46 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stsi_aset`
--
CREATE DATABASE `stsi_aset` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `stsi_aset`;

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE IF NOT EXISTS `fasilitas` (
  `fasilitas_id` int(11) NOT NULL AUTO_INCREMENT,
  `fasilitas_nama` varchar(50) COLLATE utf8_bin NOT NULL,
  `created_time` datetime NOT NULL,
  `edited_time` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`fasilitas_id`),
  KEY `user_id_FK` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`fasilitas_id`, `fasilitas_nama`, `created_time`, `edited_time`, `user_id`) VALUES
(1, 'Kantin', '2013-11-06 00:00:00', NULL, 1),
(2, 'Lift / Elevator', '2013-11-06 00:00:00', NULL, 1),
(3, 'Mushola', '2013-11-06 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fitur`
--

CREATE TABLE IF NOT EXISTS `fitur` (
  `fitur_id` int(11) NOT NULL AUTO_INCREMENT,
  `fitur_nama` varchar(50) COLLATE utf8_bin NOT NULL,
  `fitur_view_file` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`fitur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fitur`
--

INSERT INTO `fitur` (`fitur_id`, `fitur_nama`, `fitur_view_file`) VALUES
(1, 'Pengaturan Sistem', 'p_sistem'),
(2, 'Master Data', 'm_data'),
(3, 'Jadwal', 'jadwal'),
(4, 'Statistik', 'statistik');

-- --------------------------------------------------------

--
-- Table structure for table `gedung`
--

CREATE TABLE IF NOT EXISTS `gedung` (
  `gd_id` int(11) NOT NULL AUTO_INCREMENT,
  `gd_nama` varchar(50) COLLATE utf8_bin NOT NULL,
  `gd_luas` int(11) DEFAULT NULL,
  `gd_lantai` smallint(2) DEFAULT NULL,
  `gd_fasilitas` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `gd_foto` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `created_time` datetime NOT NULL,
  `edited_time` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`gd_id`),
  KEY `user_id_FK` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gedung`
--

INSERT INTO `gedung` (`gd_id`, `gd_nama`, `gd_luas`, `gd_lantai`, `gd_fasilitas`, `gd_foto`, `created_time`, `edited_time`, `user_id`) VALUES
(1, 'Lama', 400, 4, '1,3', 'gd_1_1383898086.jpg', '2013-11-04 00:00:00', '2013-11-11 20:15:17', 1),
(2, 'Baru', 0, 2, '3', '', '2013-11-19 15:34:12', '2013-11-19 15:34:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE IF NOT EXISTS `jadwal` (
  `jadwal_id` int(30) NOT NULL AUTO_INCREMENT,
  `jadwal_acara` varchar(200) COLLATE utf8_bin NOT NULL,
  `ruang_id` int(11) NOT NULL,
  `jadwal_rutin` tinyint(1) NOT NULL,
  `jadwal_hari` tinyint(1) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `jadwal_mulai` datetime DEFAULT NULL,
  `jadwal_selesai` datetime DEFAULT NULL,
  `jadwal_smt` tinyint(1) DEFAULT NULL,
  `jadwal_tahun` smallint(4) DEFAULT NULL,
  `created_time` datetime NOT NULL,
  `edited_time` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`jadwal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`jadwal_id`, `jadwal_acara`, `ruang_id`, `jadwal_rutin`, `jadwal_hari`, `jam_mulai`, `jam_selesai`, `jadwal_mulai`, `jadwal_selesai`, `jadwal_smt`, `jadwal_tahun`, `created_time`, `edited_time`, `user_id`) VALUES
(1, 'Kuliah Siang - Sore', 2, 1, 2, '13:00:00', '18:00:00', NULL, NULL, 1, 2013, '2013-11-14 14:58:12', '2013-11-19 15:22:53', 1),
(2, 'Kuliah Umum', 1, 0, NULL, NULL, NULL, '2013-11-19 13:00:00', '2013-11-19 15:30:00', NULL, NULL, '2013-11-14 15:09:30', '2013-11-19 15:23:50', 1),
(3, 'Kuliah Siang', 1, 1, 4, '13:00:00', '15:30:00', NULL, NULL, 1, 2013, '2013-11-17 19:20:28', '2013-11-21 13:03:03', 1),
(4, 'Kuliah Sore', 1, 1, 2, '15:30:00', '18:00:00', NULL, NULL, 1, 2013, '2013-11-17 19:22:53', '2013-11-19 15:33:45', 1),
(5, 'Kuliah Bosen', 3, 1, 2, '15:30:00', '17:30:00', NULL, NULL, 1, 2013, '2013-11-19 15:46:26', '2013-11-19 15:47:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jenisruang`
--

CREATE TABLE IF NOT EXISTS `jenisruang` (
  `jenisruang_id` int(11) NOT NULL AUTO_INCREMENT,
  `jenisruang_nama` varchar(25) COLLATE utf8_bin NOT NULL,
  `jenisruang_jadwal` tinyint(1) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL,
  `edited_time` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`jenisruang_id`),
  KEY `user_id_FK` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jenisruang`
--

INSERT INTO `jenisruang` (`jenisruang_id`, `jenisruang_nama`, `jenisruang_jadwal`, `created_time`, `edited_time`, `user_id`) VALUES
(1, 'Ruang Kelas', 1, '2013-11-09 17:41:06', NULL, 1),
(2, 'Ruang Pertunjukan', 1, '2013-11-09 17:41:15', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_nama` varchar(25) COLLATE utf8_bin NOT NULL,
  `fitur_id` int(11) NOT NULL,
  PRIMARY KEY (`module_id`),
  KEY `fitur_id_FK` (`fitur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_nama`, `fitur_id`) VALUES
(1, 'statistik', 4),
(2, 'jadwal', 3),
(3, 'gedung', 2),
(4, 'fasilitas', 2),
(5, 'ruangan', 2),
(6, 'jenisruangan', 2),
(7, 'pengguna', 1),
(8, 'preferensi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `preferensi`
--

CREATE TABLE IF NOT EXISTS `preferensi` (
  `pref_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sistem` varchar(255) COLLATE utf8_bin NOT NULL,
  `satuan_luas` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'm<sup>2</sup>',
  `satuan_lantai` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'lantai',
  `footer_text` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `scroll_generate` tinyint(4) NOT NULL,
  `sess_exp` smallint(6) DEFAULT '3',
  `smt_ganjil_start` tinyint(4) NOT NULL DEFAULT '9',
  `smt_ganjil_end` tinyint(4) NOT NULL DEFAULT '2',
  `smt_genap_start` tinyint(4) NOT NULL DEFAULT '3',
  `smt_genap_end` tinyint(4) NOT NULL DEFAULT '8',
  PRIMARY KEY (`pref_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `preferensi`
--

INSERT INTO `preferensi` (`pref_id`, `nama_sistem`, `satuan_luas`, `satuan_lantai`, `footer_text`, `scroll_generate`, `sess_exp`, `smt_ganjil_start`, `smt_ganjil_end`, `smt_genap_start`, `smt_genap_end`) VALUES
(1, 'Sistem Informasi Aset STSI Bandung', 'm²', 'lantai', '. : STSI Bandung : .', 30, 3, 9, 2, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_nama` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_nama`) VALUES
(1, 'administrator'),
(2, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `rolefitur`
--

CREATE TABLE IF NOT EXISTS `rolefitur` (
  `rolefitur_id` int(11) NOT NULL AUTO_INCREMENT,
  `fitur_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`rolefitur_id`),
  KEY `fitur_id_FK` (`fitur_id`),
  KEY `role_id_FK` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rolefitur`
--

INSERT INTO `rolefitur` (`rolefitur_id`, `fitur_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE IF NOT EXISTS `ruangan` (
  `ruang_id` int(11) NOT NULL AUTO_INCREMENT,
  `ruang_nama` varchar(50) COLLATE utf8_bin NOT NULL,
  `ruang_luas` int(11) DEFAULT NULL,
  `ruang_foto` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `gd_id` int(11) NOT NULL,
  `gd_lantai` int(11) NOT NULL,
  `jenisruang_id` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `edited_time` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ruang_id`),
  KEY `gd_id_FK` (`gd_id`),
  KEY `jenisruang_id_FK` (`jenisruang_id`),
  KEY `user_id_FK` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`ruang_id`, `ruang_nama`, `ruang_luas`, `ruang_foto`, `gd_id`, `gd_lantai`, `jenisruang_id`, `created_time`, `edited_time`, `user_id`) VALUES
(1, 'Ruang 101', 0, 'ruang_1_1384175137.jpg', 1, 1, 1, '2013-11-11 20:05:37', '2013-11-11 20:41:35', 1),
(2, 'Ruang 201', 0, NULL, 1, 2, 1, '2013-11-11 21:21:54', '2013-11-14 12:57:51', 1),
(3, 'Ruang A', NULL, '', 2, 1, 1, '2013-11-19 15:44:48', NULL, 1),
(4, 'Ruang B', NULL, 'ruang_3_1384850711.jpg', 2, 1, 1, '2013-11-19 15:45:12', NULL, 1),
(5, 'Ruang C', NULL, '', 2, 2, 1, '2013-11-20 11:45:52', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `scrollbox`
--

CREATE TABLE IF NOT EXISTS `scrollbox` (
  `sb_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `sb_tgl` int(30) NOT NULL DEFAULT '1356973200',
  PRIMARY KEY (`sb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `scrollbox`
--

INSERT INTO `scrollbox` (`sb_id`, `sb_tgl`) VALUES
(1, 1385013791);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `nama` varchar(40) COLLATE utf8_bin NOT NULL,
  `kontak` varchar(14) COLLATE utf8_bin DEFAULT NULL,
  `reg_time` datetime NOT NULL,
  `login_terakhir` datetime DEFAULT NULL,
  `ip_terakhir` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_id_FK` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `role_id`, `email`, `password`, `nama`, `kontak`, `reg_time`, `login_terakhir`, `ip_terakhir`) VALUES
(1, 'admin', 1, '', '829b36babd21be519fa5f9353daf5dbdb796993e', 'Admin', '', '2013-11-06 00:00:00', '2013-11-21 12:32:32', '::1'),
(2, 'staff', 2, '', '829b36babd21be519fa5f9353daf5dbdb796993e', 'staf', '', '2013-11-07 00:00:00', '2013-11-11 21:56:03', '127.0.0.1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`fitur_id`) REFERENCES `fitur` (`fitur_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rolefitur`
--
ALTER TABLE `rolefitur`
  ADD CONSTRAINT `rolefitur_ibfk_1` FOREIGN KEY (`fitur_id`) REFERENCES `fitur` (`fitur_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `rolefitur_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `rolefitur` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
