-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jan 2025 pada 16.56
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_portal_iais`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_group`
--

CREATE TABLE `tbl_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(200) NOT NULL,
  `group_logo` varchar(100) NOT NULL,
  `group_email` varchar(200) DEFAULT NULL,
  `group_phone` varchar(20) DEFAULT NULL,
  `group_alamat` varchar(500) NOT NULL,
  `group_creaby` varchar(200) NOT NULL,
  `group_modiby` varchar(200) NOT NULL,
  `group_creadate` datetime NOT NULL,
  `group_modidate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_order`
--

CREATE TABLE `tbl_order` (
  `or_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `or_status` int(11) NOT NULL DEFAULT '0',
  `or_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `or_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_product`
--

CREATE TABLE `tbl_product` (
  `p_id` int(11) NOT NULL,
  `p_jenis` varchar(50) NOT NULL,
  `p_judul` text NOT NULL,
  `p_deskripsi` text,
  `p_img` varchar(200) DEFAULT NULL,
  `p_id_lms` text NOT NULL,
  `p_url_lms` text NOT NULL,
  `p_harga` int(11) DEFAULT NULL,
  `p_status` int(11) NOT NULL DEFAULT '0',
  `p_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `p_modified_date` timestamp NULL DEFAULT NULL,
  `p_start_date` timestamp NULL DEFAULT NULL,
  `p_end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_product`
--

INSERT INTO `tbl_product` (`p_id`, `p_jenis`, `p_judul`, `p_deskripsi`, `p_img`, `p_id_lms`, `p_url_lms`, `p_harga`, `p_status`, `p_created_date`, `p_modified_date`, `p_start_date`, `p_end_date`) VALUES
(1, 'course', 'Natural Language Processing (NLP) Basics', 'Learn the basics of NLP, including text processing, sentiment analysis, and language generation.', 'course1_1711803657.jpg', '4', 'https://ems.ai4talent.my.id/course/natural-language-processing-nlp-basics', 10000, 1, '2024-03-30 06:00:57', NULL, '2024-01-21 08:55:00', '2024-01-22 09:15:00'),
(2, 'course', 'AI and Robotics Integration', 'Explore the integration of AI and robotics, including robot control and perception.', 'course13_1711803683.jpg', '9', 'https://ems.ai4talent.my.id/course/ai-and-robotics-integration', 30000, 1, '2025-01-12 04:37:51', NULL, '2024-01-21 08:55:00', '2024-01-22 09:15:00'),
(3, 'course', 'AI for Finance', 'Analyze the application of AI in financial markets, risk assessment, and investment strategies.', 'course14_1711803699.jpg', '11', 'https://ems.ai4talent.my.id/course/ai-for-finance', 10000, 1, '2025-01-12 04:37:54', NULL, '2024-03-29 02:54:00', '2024-04-01 02:54:00'),
(4, 'course', 'AI for Marketing', 'Explore AI-driven marketing strategies, including customer segmentation and personalized campaigns.', 'course15_1711803710.jpg', '12', 'https://ems.ai4talent.my.id/course/ai-for-marketing', 20000, 1, '2025-01-12 04:37:57', NULL, '2024-03-30 02:55:00', '2024-04-06 02:55:00'),
(5, 'course', 'Computer Vision Fundamentals', 'An in-depth look at computer vision techniques, object detection, and image recognition.', 'course16_1711803721.jpg', '5', 'https://ems.ai4talent.my.id/course/computer-vision-fundamentals', 5000, 1, '2025-01-12 04:38:01', NULL, '2024-03-30 02:56:00', '2024-04-04 02:56:00'),
(6, 'course', 'AI Ethics and Responsible AI', 'Examine the ethical considerations and responsible practices in the field of AI.', 'course17_1711803733.jpg', '7', 'https://ems.ai4talent.my.id/course/ai-ethics-and-responsible-ai', 20000, 1, '2025-01-12 04:38:05', NULL, '2024-03-30 02:56:00', '2024-04-02 02:56:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `t_id` int(11) NOT NULL,
  `t_transaction_id` varchar(255) DEFAULT NULL,
  `t_code` varchar(255) DEFAULT NULL,
  `t_user_id` int(11) NOT NULL,
  `t_p_id` int(11) DEFAULT NULL,
  `t_type` enum('inflow','outflow') NOT NULL,
  `t_amount` int(11) NOT NULL,
  `t_status` enum('unpaid','waiting confirmation','paid') NOT NULL,
  `t_user_proof` text,
  `t_admin_proof` text,
  `t_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `t_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`t_id`, `t_transaction_id`, `t_code`, `t_user_id`, `t_p_id`, `t_type`, `t_amount`, `t_status`, `t_user_proof`, `t_admin_proof`, `t_created_date`, `t_modified_date`) VALUES
(1, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup1.jpg', 'Admin-Transaction-Topup1.jpg', '2024-03-27 21:58:38', '2024-03-27 21:58:37'),
(2, '101', '101', 2, NULL, 'inflow', 20000, 'paid', 'User-Transaction-Topup2.jpg', 'Admin-Transaction-Topup2.jpg', '2024-03-28 02:12:01', '2024-03-28 02:16:01'),
(3, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup3.jpg', 'Admin-Transaction-Topup3.jpg', '2024-03-28 02:15:06', '2024-03-28 02:20:32'),
(7, '101', '101', 2, NULL, 'inflow', 50000, 'paid', 'User-Transaction-Topup7.jpg', 'Admin-Transaction-Topup7.jpg', '2024-03-28 06:41:13', '2024-03-28 07:45:44'),
(8, '102', '102', 2, 6, 'outflow', 30000, 'paid', NULL, NULL, '2024-03-30 01:44:12', NULL),
(9, '102', '102', 2, 1, 'outflow', 10000, 'paid', NULL, NULL, '2024-03-30 01:46:58', NULL),
(11, '102', '102', 2, 2, 'outflow', 30000, 'paid', NULL, NULL, '2025-01-19 15:48:07', NULL),
(12, '102', '101', 2, NULL, 'inflow', 100000, 'waiting confirmation', 'User-Transaction-Topup12.png', NULL, '2025-01-19 15:49:10', '2025-01-19 15:49:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_trans_activities`
--

CREATE TABLE `tbl_trans_activities` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_trans_activities`
--

INSERT INTO `tbl_trans_activities` (`id`, `code`, `name`) VALUES
(1, '101', 'Top Up'),
(2, '102', 'Buying Course');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(23) NOT NULL DEFAULT '',
  `jk` varchar(10) NOT NULL,
  `tgl_lhr` date NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` text,
  `token_type` varchar(50) NOT NULL DEFAULT 'Bearer',
  `email` varchar(50) NOT NULL,
  `provinsi` varchar(200) DEFAULT NULL,
  `kelurahan` varchar(200) DEFAULT NULL,
  `kecamatan` varchar(200) DEFAULT NULL,
  `kota_kab` varchar(200) DEFAULT NULL,
  `pendidikan` varchar(200) DEFAULT NULL,
  `pekerjaan` varchar(200) DEFAULT NULL,
  `agama` varchar(200) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `nik`, `username`, `password`, `nama`, `alamat`, `no_hp`, `jk`, `tgl_lhr`, `role`, `created_at`, `updated_at`, `api_token`, `token_type`, `email`, `provinsi`, `kelurahan`, `kecamatan`, `kota_kab`, `pendidikan`, `pekerjaan`, `agama`, `group_id`, `saldo`, `level`) VALUES
(1, NULL, 'admin', 'admin', 'Administrator', 'SUkabumi', '0856224425', 'Perempuan', '1996-05-19', 'Admin', '2024-01-02 09:18:29', '2025-01-19 13:40:51', 'db47088093c289d7eeceaebb01b3dc80d36f51bba9fd83d60a1b673ebacba427', 'Bearer', 'ekoabdulgoffar129@gmail.com', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL),
(2, NULL, 'fatwa', 'fatwa', 'Fatwa Paramadhani', 'SUkabumi', '08562244255', 'Perempuan', '1996-05-19', 'Peserta', '2024-01-02 09:18:29', '2025-01-19 15:08:02', '31db8fd970eee6c4ca493459c68c170ce671b0ef0d330a6ef791cc0b9a9f7a96', 'Bearer', '', '32', '3202070002', '3202070', '3202', NULL, NULL, NULL, 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indeks untuk tabel `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`or_id`);

--
-- Indeks untuk tabel `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indeks untuk tabel `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `t_user_id` (`t_user_id`);

--
-- Indeks untuk tabel `tbl_trans_activities`
--
ALTER TABLE `tbl_trans_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbl_trans_activities`
--
ALTER TABLE `tbl_trans_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD CONSTRAINT `tbl_transaction_ibfk_1` FOREIGN KEY (`t_user_id`) REFERENCES `tbl_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
