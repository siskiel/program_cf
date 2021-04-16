-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Apr 2021 pada 05.26
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(11) NOT NULL,
  `kode_gejala` varchar(50) NOT NULL,
  `nama_gejala` varchar(255) NOT NULL,
  `mb` double NOT NULL,
  `md` double NOT NULL,
  `nilai_bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`, `mb`, `md`, `nilai_bobot`) VALUES
(1, 'G01', 'Mual dan muntah', 0.95, 0.15, 0.8),
(2, 'G02', 'Pembengkakan pada kaki', 0.65, 0.15, 0.6),
(3, 'G03', 'Kehilangan nafsu makan', 0.75, 0, 0.7),
(4, 'G04', 'Nyeri dada', 0, 0, 0.5),
(5, 'G05', 'Sesak nafas', 0, 0, 0.7),
(6, 'G06', 'Gangguan tidur/ insomnia', 0, 0, 0.6),
(7, 'G07', 'Keram dan kejang otot', 0, 0, 0.8),
(8, 'G08', 'Lebih sering buang air kecil', 0, 0, 0.7),
(9, 'G09', 'Penurunan berat badan', 0, 0, 0.6),
(10, 'G10', 'Asam urat', 0, 0, 0.2),
(11, 'G11', 'Kolesterol ', 0, 0, 0.8),
(13, 'G13', 'Badan mudah lelah', 0, 0, 0.7),
(14, 'G14', 'Kulit gatal berkepanjangan', 0, 0, 0.5),
(16, 'G15', 'Terdapat darah dalam urine', 0, 0, 0.8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` enum('p','l') NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `tgl_konsul` date NOT NULL,
  `id_penyakit` longtext NOT NULL,
  `gejala` longtext DEFAULT NULL,
  `pilihan_user` longtext NOT NULL,
  `total_perhitungan` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama_pasien`, `tgl_lahir`, `jk`, `no_hp`, `alamat`, `tgl_konsul`, `id_penyakit`, `gejala`, `pilihan_user`, `total_perhitungan`) VALUES
(1, 'nama_pasien', '2020-06-26', 'l', '089908990899', 'Jl. Galang L. Pakam', '2020-06-26', '1', 'a:4:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:9;}', '', 0.94),
(2, 'nisa', '2020-06-26', 'l', '089908990899', 'Jl. Galang L. Pakam', '2020-06-26', '1', 'a:4:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:9;}', '', 0.94),
(3, 'zizah', '2020-06-26', 'l', '089908990899', 'Jl. Galang L. Pakam', '2020-06-26', '1', 'a:4:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:9;}', '', 0.94);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int(11) NOT NULL,
  `kode_penyakit` varchar(255) NOT NULL,
  `nama_penyakit` varchar(255) NOT NULL,
  `solusi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `kode_penyakit`, `nama_penyakit`, `solusi`) VALUES
(1, 'P01', 'Acute Kidney Disease (Penyakit Ginjal Akut)', 'Dokter akan melakukan pemeriksaan penunjang seperti USG, CT Scan . Jika ukuran nya kecil maka perbanyak minum air putih'),
(2, 'P02', 'Chronic Kidney Disease (Penyakit Ginjal Kronik)', 'Jika baru sudah membesar maka akan dilakukan operasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perhitungan`
--

CREATE TABLE `perhitungan` (
  `id_pehitungan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_gejala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihan_user`
--

CREATE TABLE `pilihan_user` (
  `id_pilihan_user` int(11) NOT NULL,
  `nama_pilihan` varchar(30) NOT NULL,
  `bobot_pilihan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pilihan_user`
--

INSERT INTO `pilihan_user` (`id_pilihan_user`, `nama_pilihan`, `bobot_pilihan`) VALUES
(1, 'Tidak Tau', 0),
(2, 'Tidak Yakin', 0.2),
(3, 'Sedikit Yakin', 0.4),
(4, 'Cukup Yakin ', 0.6),
(5, 'Yakin', 0.8),
(6, 'Sangat Yakin', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(11) NOT NULL,
  `id_gejala` int(11) NOT NULL DEFAULT 0,
  `id_penyakit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rule`
--

INSERT INTO `rule` (`id_rule`, `id_gejala`, `id_penyakit`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 1),
(5, 3, 2),
(6, 4, 1),
(7, 4, 2),
(8, 5, 2),
(9, 6, 2),
(10, 7, 1),
(11, 7, 2),
(12, 8, 2),
(13, 9, 1),
(14, 9, 2),
(15, 10, 2),
(16, 11, 2),
(19, 14, 1),
(20, 14, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `email`, `no_hp`, `password`) VALUES
(1, 'Rini Lestari Ritonga', 'rinilestari@gmail.com', '081238088878', 'rini'),
(2, 'nama pasiesn', 'emailpasien@gmail.com', '0978876762563', 'pasien');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indeks untuk tabel `perhitungan`
--
ALTER TABLE `perhitungan`
  ADD PRIMARY KEY (`id_pehitungan`);

--
-- Indeks untuk tabel `pilihan_user`
--
ALTER TABLE `pilihan_user`
  ADD PRIMARY KEY (`id_pilihan_user`);

--
-- Indeks untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `fk_rule_gejala` (`id_gejala`),
  ADD KEY `fk_rule_penyakit` (`id_penyakit`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `perhitungan`
--
ALTER TABLE `perhitungan`
  MODIFY `id_pehitungan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pilihan_user`
--
ALTER TABLE `pilihan_user`
  MODIFY `id_pilihan_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD CONSTRAINT `fk_rule_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rule_penyakit` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
