-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Des 2019 pada 15.30
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Struktur dari tabel `anggaran`
--

CREATE TABLE `anggaran` (
  `id` int(11) NOT NULL,
  `no_anggaran` varchar(30) DEFAULT NULL,
  `tgl_anggaran` date DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggaran`
--

INSERT INTO `anggaran` (`id`, `no_anggaran`, `tgl_anggaran`, `nominal`) VALUES
(14, 'AGR-001', '2019-12-01', 20120000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `coa`
--

CREATE TABLE `coa` (
  `id` int(11) NOT NULL,
  `kode_akun` varchar(30) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `header_akun` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `coa`
--

INSERT INTO `coa` (`id`, `kode_akun`, `nama`, `header_akun`) VALUES
(1, '111', 'kas', '1'),
(2, '112', 'piutang', '1'),
(3, '113', 'perlengkapan', '1'),
(4, '114', 'sewa dibayar dimuka', '1'),
(5, '121', 'peralatan', '1'),
(6, '211', 'utang', '2'),
(7, '411', 'pendapatan jasa', '4'),
(8, '511', 'beban air', '5'),
(9, '512', 'beban telpon dan internet', '5'),
(10, '513', 'beban listrik', '5'),
(11, '514', 'beban sewa', '5'),
(12, '515', 'beban gaji', '5'),
(13, '516', 'beban perbaikan', '5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_anggaran`
--

CREATE TABLE `detail_anggaran` (
  `id` int(11) NOT NULL,
  `no_anggaran` varchar(30) DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `kd_jenis_anggaran` varchar(30) DEFAULT NULL,
  `kd_kegiatan` varchar(30) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_anggaran`
--

INSERT INTO `detail_anggaran` (`id`, `no_anggaran`, `periode`, `kd_jenis_anggaran`, `kd_kegiatan`, `nominal`) VALUES
(48, 'AGR-001', '2019-12-01', 'JGR-664', 'KGT-338', 120000),
(50, 'AGR-001', '2019-12-01', 'JGR-664', 'KGT-974', 20000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_realisasi`
--

CREATE TABLE `detail_realisasi` (
  `id` int(11) NOT NULL,
  `kd_realisasi` varchar(30) DEFAULT NULL,
  `kd_kegiatan` varchar(30) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `kd_jenis_anggaran` varchar(30) DEFAULT NULL,
  `keterangan` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_realisasi`
--

INSERT INTO `detail_realisasi` (`id`, `kd_realisasi`, `kd_kegiatan`, `nominal`, `kd_jenis_anggaran`, `keterangan`) VALUES
(12, 'KRA-001', 'KGT-338', 20000000, 'JGR-664', 'hfgsdf'),
(13, 'KRA-001', 'KGT-974', 20000000, 'JGR-664', 'sdasd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_anggaran`
--

CREATE TABLE `jenis_anggaran` (
  `id` int(11) NOT NULL,
  `no_jenis_anggaran` varchar(30) DEFAULT NULL,
  `jenis_anggaran` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_anggaran`
--

INSERT INTO `jenis_anggaran` (`id`, `no_jenis_anggaran`, `jenis_anggaran`) VALUES
(1, 'JGR-556', 'pendapatan'),
(2, 'JGR-664', 'pengeluaran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kegiatan`
--

CREATE TABLE `jenis_kegiatan` (
  `id` int(11) NOT NULL,
  `kd_jenis_kegiatan` varchar(30) DEFAULT NULL,
  `jenis_kegiatan` varchar(30) DEFAULT NULL,
  `kd_jenis_anggaran` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_kegiatan`
--

INSERT INTO `jenis_kegiatan` (`id`, `kd_jenis_kegiatan`, `jenis_kegiatan`, `kd_jenis_anggaran`) VALUES
(1, 'JKGT-208', 'Pendidikan', 'JGR-556'),
(2, 'JKGT-216', 'Sarana', 'JGR-664'),
(3, 'JKGT-268', 'ATK', 'JGR-664');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id` int(11) NOT NULL,
  `kode_akun` varchar(30) DEFAULT NULL,
  `tgl_jurnal` date DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `posisi_dr_cr` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`id`, `kode_akun`, `tgl_jurnal`, `nominal`, `posisi_dr_cr`) VALUES
(10, '515', '2019-12-15', 20000000, 'debit'),
(11, '511', '2019-12-15', 20000000, 'debit'),
(12, '111', '2019-12-15', 40000000, 'kredit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(30) DEFAULT NULL,
  `nama_kegiatan` varchar(400) DEFAULT NULL,
  `kd_jenis_kegiatan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `unique_id`, `nama_kegiatan`, `kd_jenis_kegiatan`) VALUES
(6, 'KGT-643', 'Gaji Tenaga Pengajar Tingkat I', 'JKGT-208'),
(7, 'KGT-728', 'Gaji Tenaga Pengajar Tingkat II', 'JKGT-208'),
(8, 'KGT-338', 'Gaji Admin & Finance', 'JKGT-208'),
(9, 'KGT-642', 'Gaji OB dan Penjaga Malam', 'JKGT-208'),
(10, 'KGT-727', 'Gaji Manager', 'JKGT-208'),
(11, 'KGT-974', 'Beban Air', 'JKGT-216'),
(12, 'KGT-401', 'Beban Listrik', 'JKGT-216'),
(13, 'KGT-240', 'Beban Telepon dan Internet', 'JKGT-216'),
(14, 'KGT-270', 'Pembelian Aktiva Tetap', 'JKGT-216'),
(16, 'KGT-859', 'Beban Perbaikan', 'JKGT-268'),
(17, 'KGT-510', 'Beban Cetak Soal', 'JKGT-268'),
(18, 'KGT-288', 'Beban Pembelian ATK', 'JKGT-268');

-- --------------------------------------------------------

--
-- Struktur dari tabel `realisasi_anggaran`
--

CREATE TABLE `realisasi_anggaran` (
  `id` int(11) NOT NULL,
  `kd_realisasi` varchar(30) DEFAULT NULL,
  `tgl_realisasi` date DEFAULT NULL,
  `nominal_realisasi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `realisasi_anggaran`
--

INSERT INTO `realisasi_anggaran` (`id`, `kd_realisasi`, `tgl_realisasi`, `nominal_realisasi`) VALUES
(6, 'KRA-001', '2019-12-15', 40000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `id_user`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
('taniya', 23, 'Taniya Yulia', 'taniyayulia51@gmail.com', 'logistic1.jpg', '$2y$10$//DHiqJLnnHHes.UArG/AO8xk17pzQBJeZzC7yWBUf9gCka4O2AGm', 2, 1, 1568988820),
('admin', 24, 'admin', 'admin@gmail.com', 'dummy.jpg', '$2y$10$4UlXbXQSoI80xaXH4Hy9nOjEolXHzg8Jv40jiS9krbn6kK6FGn3w2', 1, 1, 1569166263);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_access_menu`
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
(28, 2, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'admin'),
(2, 'dashboard'),
(3, 'menu'),
(4, 'user'),
(5, 'master_data'),
(6, 'Transaksi'),
(7, 'Laporan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'pemilik'),
(3, 'keuangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
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
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Hak Akses', 'admin/role', 'fa fa-lock', 1),
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
(14, 7, 'Laporan Anggaran', 'laporan/LaporanAnggaran', 'fa fa-money', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(500) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(24, 'taniyayulia51@gmail.com', '2932817c630e75cd29cd68baa4a08ee5', 1568988820),
(25, 'admin@gmail.com', 'a1c3fb08e92241bfd56b7a1c5d796dd9', 1569166263);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `coa`
--
ALTER TABLE `coa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_anggaran`
--
ALTER TABLE `detail_anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_realisasi`
--
ALTER TABLE `detail_realisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_anggaran`
--
ALTER TABLE `jenis_anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `realisasi_anggaran`
--
ALTER TABLE `realisasi_anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `coa`
--
ALTER TABLE `coa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `detail_anggaran`
--
ALTER TABLE `detail_anggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `detail_realisasi`
--
ALTER TABLE `detail_realisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `jenis_anggaran`
--
ALTER TABLE `jenis_anggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `realisasi_anggaran`
--
ALTER TABLE `realisasi_anggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
