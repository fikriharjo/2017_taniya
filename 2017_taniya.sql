-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2020 at 09:19 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2017_taniya`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` int(11) NOT NULL,
  `no_anggaran` varchar(30) DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `kd_jenis_anggaran` varchar(30) DEFAULT NULL,
  `kd_kegiatan` varchar(30) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `kode_akun` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`id`, `no_anggaran`, `periode`, `kd_jenis_anggaran`, `kd_kegiatan`, `nominal`, `kode_akun`) VALUES
(12, 'AGR-001', '2020-05-01', 'JGR-556', 'KGT-890', 50000000, ''),
(13, 'AGR-002', '2020-05-01', 'JGR-664', 'KGT-336', 1000000, ''),
(14, 'AGR-003', '2020-05-01', 'JGR-664', 'KGT-110', 750000, ''),
(15, 'AGR-004', '2020-05-01', 'JGR-664', 'KGT-995', 1500000, ''),
(16, 'AGR-005', '2020-05-01', 'JGR-664', 'KGT-155', 1250000, ''),
(17, 'AGR-006', '2020-05-01', 'JGR-664', 'KGT-698', 1000000, ''),
(18, 'AGR-007', '2020-05-01', 'JGR-664', 'KGT-211', 10000000, ''),
(20, 'AGR-008', '2020-05-01', 'JGR-664', 'KGT-272', 7000000, ''),
(21, 'AGR-009', '2020-05-01', 'JGR-664', 'KGT-284', 5000000, ''),
(22, 'AGR-010', '2020-05-01', 'JGR-664', 'KGT-839', 7500000, ''),
(23, 'AGR-011', '2020-05-01', 'JGR-664', 'KGT-771', 6000000, '');

-- --------------------------------------------------------

--
-- Table structure for table `coa`
--

CREATE TABLE `coa` (
  `id` int(11) NOT NULL,
  `kode_akun` varchar(30) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coa`
--

INSERT INTO `coa` (`id`, `kode_akun`, `nama`, `nominal`) VALUES
(1, '111', 'Kas', 0),
(6, '112', 'Piutang Usaha', 0),
(7, '113', 'Perlengkapan ATK', 0),
(8, '121', 'Peralatan', 0),
(9, '122', 'Akumulasi Penyusutan Peralatan', 0),
(10, '211', 'Utang Usaha', 0),
(11, '212', 'Uang Gaji', 0),
(13, '311', 'Ekuitas Pemilik', 0),
(14, '312', 'Prive', 0),
(15, '411', 'Pendapatan Jasa', 0),
(16, '412', 'Pendapatan Lain-Lain', 0),
(17, '511', 'Beban Gaji', 0),
(18, '512', 'Beban Sewa Gedung', 0),
(19, '513', 'Beban Perlengkapan ATK', 0),
(20, '514', 'Beban Iklan', 0),
(21, '515', 'Beban Penyusutan Peralatan', 0),
(22, '516', 'Beban Air', 0),
(23, '517', 'Beban Listrik', 0),
(24, '518', 'Beban Telepon dan Internet', 0),
(25, '520', 'Beban Reparasi', 0),
(26, '521', 'Beban Cetak Soal', 0),
(27, '', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detail_realisasi`
--

CREATE TABLE `detail_realisasi` (
  `id` int(11) NOT NULL,
  `kd_realisasi` varchar(30) DEFAULT NULL,
  `no_anggaran` varchar(30) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `keterangan` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_realisasi`
--

INSERT INTO `detail_realisasi` (`id`, `kd_realisasi`, `no_anggaran`, `nominal`, `keterangan`) VALUES
(6, 'KRA-001', 'AGR-001', 41000000, 'Pendaftaran siswa tanggal 2 April'),
(7, 'KRA-002', 'AGR-002', 750000, 'Membeli ATK 5 April'),
(8, 'KRA-003', 'AGR-003', 500000, 'Membayar Cetak Soal Ujian'),
(9, 'KRA-004', 'AGR-006', 700000, 'Membayar beban air'),
(10, 'KRA-005', 'AGR-004', 1500000, 'Membayar listrik'),
(11, 'KRA-006', 'AGR-005', 1150000, 'Membayar Telpon dan Internet'),
(12, 'KRA-007', 'AGR-001', 9000000, 'Menerima uang dari pendaftaran siswa '),
(13, 'KRA-008', 'AGR-007', 10000000, 'Membayar Gaji Manager'),
(14, 'KRA-009', 'AGR-008', 7000000, 'Membayar Gaji Admin dan Finance'),
(15, 'KRA-010', 'AGR-009', 5000000, 'Membayar Gaji OB dan Penjaga Malam'),
(16, 'KRA-011', 'AGR-010', 7500000, 'Membayar Gaji Tenaga Pengajar Tingkat I'),
(17, 'KRA-012', 'AGR-011', 6000000, 'Membayar Gaji Tenaga Pengajar Tingkat II'),
(18, 'KRA-013', 'AGR-006', 300000, 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_anggaran`
--

CREATE TABLE `jenis_anggaran` (
  `id` int(11) NOT NULL,
  `no_jenis_anggaran` varchar(30) DEFAULT NULL,
  `jenis_anggaran` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_anggaran`
--

INSERT INTO `jenis_anggaran` (`id`, `no_jenis_anggaran`, `jenis_anggaran`) VALUES
(1, 'JGR-556', 'Pendapatan'),
(2, 'JGR-664', 'Pengeluaran');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kegiatan`
--

CREATE TABLE `jenis_kegiatan` (
  `id` int(11) NOT NULL,
  `kd_jenis_kegiatan` varchar(30) DEFAULT NULL,
  `jenis_kegiatan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_kegiatan`
--

INSERT INTO `jenis_kegiatan` (`id`, `kd_jenis_kegiatan`, `jenis_kegiatan`) VALUES
(1, 'JKGT-208', 'Pendidikan'),
(2, 'JKGT-216', 'Sarana dan Prasarana'),
(3, 'JKGT-268', 'Alat Tulis Kantor (ATK)');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(30) DEFAULT NULL,
  `nama_kegiatan` varchar(400) DEFAULT NULL,
  `kd_jenis_kegiatan` varchar(30) DEFAULT NULL,
  `kd_jenis_anggaran` varchar(30) NOT NULL,
  `coa1` varchar(3) NOT NULL,
  `coa2` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `unique_id`, `nama_kegiatan`, `kd_jenis_kegiatan`, `kd_jenis_anggaran`, `coa1`, `coa2`) VALUES
(5, 'KGT-839', 'Gaji Tenaga Pengajar Tingkat I', 'JKGT-208', 'JGR-664', '511', '111'),
(6, 'KGT-771', 'Gaji Tenaga Pengajar Tingkat II', 'JKGT-208', 'JGR-664', '511', '111'),
(7, 'KGT-272', 'Gaji Admin & Finance', 'JKGT-208', 'JGR-664', '511', '111'),
(8, 'KGT-284', 'Gaji OB dan Penjaga Malam', 'JKGT-208', 'JGR-664', '511', '111'),
(9, 'KGT-211', 'Gaji Manager', 'JKGT-208', 'JGR-664', '511', '111'),
(10, 'KGT-698', 'Beban Air', 'JKGT-216', 'JGR-664', '516', '111'),
(11, 'KGT-155', 'Beban Telepon dan Internet', 'JKGT-216', 'JGR-664', '518', '111'),
(12, 'KGT-995', 'Beban Listrik', 'JKGT-216', 'JGR-664', '517', '111'),
(13, 'KGT-336', 'Alat Tulis Kantor', 'JKGT-268', 'JGR-664', '513', '111'),
(14, 'KGT-110', 'Beban Cetak Soal', 'JKGT-268', 'JGR-664', '521', '111'),
(15, 'KGT-890', 'Pendapatan Jasa', 'JKGT-208', 'JGR-556', '111', '411');

-- --------------------------------------------------------

--
-- Table structure for table `realisasi`
--

CREATE TABLE `realisasi` (
  `id` int(11) NOT NULL,
  `kd_realisasi` varchar(30) DEFAULT NULL,
  `no_anggaran` varchar(30) NOT NULL,
  `tgl_realisasi` date DEFAULT NULL,
  `periode` date NOT NULL,
  `kd_jenis_anggaran` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `realisasi`
--

INSERT INTO `realisasi` (`id`, `kd_realisasi`, `no_anggaran`, `tgl_realisasi`, `periode`, `kd_jenis_anggaran`) VALUES
(8, 'KRA-001', 'AGR-001', '2020-05-01', '2020-05-01', 'JGR-556'),
(9, 'KRA-002', 'AGR-002', '2020-05-01', '2020-05-01', 'JGR-664'),
(10, 'KRA-003', 'AGR-003', '2020-05-01', '2020-05-01', 'JGR-664'),
(11, 'KRA-004', 'AGR-006', '2020-05-01', '2020-05-01', 'JGR-664'),
(12, 'KRA-005', 'AGR-004', '2020-05-01', '2020-05-01', 'JGR-664'),
(13, 'KRA-006', 'AGR-005', '2020-05-01', '2020-05-01', 'JGR-664'),
(14, 'KRA-007', 'AGR-001', '2020-05-01', '2020-05-01', 'JGR-556'),
(15, 'KRA-008', 'AGR-007', '2020-05-01', '2020-05-01', 'JGR-664'),
(16, 'KRA-009', 'AGR-008', '2020-05-01', '2020-05-01', 'JGR-664'),
(17, 'KRA-010', 'AGR-009', '2020-05-01', '2020-05-01', 'JGR-664'),
(18, 'KRA-011', 'AGR-010', '2020-05-01', '2020-05-01', 'JGR-664'),
(19, 'KRA-012', 'AGR-011', '2020-05-01', '2020-05-01', 'JGR-664'),
(20, 'KRA-013', 'AGR-006', '2020-05-01', '2020-05-01', 'JGR-664');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(30) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `id_user`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
('taniya', 23, 'Taniya Yulia', 'taniyayulia51@gmail.com', '4524991.jpg', '$2y$10$//DHiqJLnnHHes.UArG/AO8xk17pzQBJeZzC7yWBUf9gCka4O2AGm', 2, 1, 1568988820),
('admin', 24, 'admin', 'admin@gmail.com', 'dummy.jpg', '$2y$10$4UlXbXQSoI80xaXH4Hy9nOjEolXHzg8Jv40jiS9krbn6kK6FGn3w2', 1, 1, 1569166263),
('abc123', 25, 'abc', 'avhftgh@gmail.com', 'default.jpg', '$2y$10$Jxe64kk9vBIBax8yrwX2Ge4OcFSDkpta368Om7jYV5z1Iklsv.iAe', 3, 1, 1587909765),
('kokoy', 28, 'kokoy', 'harjofikri@gmail.com', 'WIN_20191220_22_05_51_Pro4.jpg', '$2y$10$zY2lBr0dRJdQrthOBW2qKu14fGtfRTU6L9WHYvT4CcECR72oASNkO', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(6, 1, 3),
(10, 1, 4),
(19, 1, 7),
(20, 1, 6),
(21, 2, 4),
(23, 2, 6),
(26, 2, 5),
(28, 2, 7),
(29, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'Dashboard'),
(3, 'Menu'),
(4, 'User'),
(5, 'Master_Data'),
(6, 'Transaksi'),
(7, 'Laporan');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'pemilik'),
(3, 'keuangan');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Hak Akses', 'admin/role', 'fa fa-lock', 1),
(2, 4, 'User', 'user/listUser', 'fa fa-users', 1),
(3, 4, 'Profil', 'user', 'fa fa-user', 1),
(4, 3, 'Manajemen menu', 'menu', 'fa fa-folder', 1),
(5, 3, 'Sub Menu Manajemen', 'menu/submenu', 'fa fa-folder-open', 1),
(6, 5, 'Chart Of Account', 'master_data/coa', 'fa fa-book', 1),
(8, 5, 'Kegiatan', 'master_data/kegiatan', 'fa fa-list', 1),
(9, 5, 'Jenis Kegiatan', 'master_data/jenis_kegiatan', 'fa fa-list', 1),
(10, 6, 'Anggaran', 'transaksi/anggaran', 'fa fa-money', 1),
(11, 6, 'Realisasi', 'transaksi/realisasi', 'fa fa-database', 1),
(12, 7, 'Jurnal', 'laporan/lihat_jurnal', 'fa fa-file', 1),
(13, 7, 'Buku Besar', 'laporan/bukuBesar', 'fa fa-book', 1),
(14, 7, 'Laporan Anggaran', 'laporan/laporanAnggaran', 'fa fa-money', 1),
(15, 6, 'Sisa Anggaran', 'transaksi/sisa_anggaran', 'fa fa-archive', 1),
(17, 7, 'Perbandingan Anggaran', 'laporan/bandingkanAnggaran', 'fa fa-credit-card', 1),
(18, 7, 'Perbandingan Pendapatan', 'laporan/bandingkanPendapatan', 'fa fa-envelope', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(500) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(24, 'taniyayulia51@gmail.com', '2932817c630e75cd29cd68baa4a08ee5', 1568988820),
(25, 'admin@gmail.com', 'a1c3fb08e92241bfd56b7a1c5d796dd9', 1569166263),
(26, 'avhftgh@gmail.com', '4573e93b6e48a5eed0a17c58c9806b64', 1587909765);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coa`
--
ALTER TABLE `coa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_realisasi`
--
ALTER TABLE `detail_realisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_anggaran`
--
ALTER TABLE `jenis_anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `realisasi`
--
ALTER TABLE `realisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `coa`
--
ALTER TABLE `coa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `detail_realisasi`
--
ALTER TABLE `detail_realisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `jenis_anggaran`
--
ALTER TABLE `jenis_anggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `realisasi`
--
ALTER TABLE `realisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
