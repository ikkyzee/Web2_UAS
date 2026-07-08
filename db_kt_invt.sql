-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2026 at 08:10 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kt_invt`
--

-- --------------------------------------------------------

--
-- Table structure for table `armadas`
--

CREATE TABLE `armadas` (
  `id` bigint UNSIGNED NOT NULL,
  `plat_nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_supir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `armadas`
--

INSERT INTO `armadas` (`id`, `plat_nomor`, `jenis_kendaraan`, `nama_supir`, `created_at`, `updated_at`) VALUES
(1, 'D 3352 CD', 'Mobil Box', 'Om Andi', '2026-07-08 08:11:40', '2026-07-08 11:24:30'),
(2, 'D 5678 YZ', 'Mobil Box', 'Ardi Kurniawan', '2026-07-08 08:11:40', '2026-07-08 11:23:53'),
(3, 'D 2334 ZCY', 'Mobil Box', 'Rudiansyah', '2026-07-08 11:25:02', '2026-07-08 11:25:02'),
(4, 'D 3343 ZBA', 'VIAR', 'Akbar plenger', '2026-07-08 11:25:39', '2026-07-08 11:25:39'),
(5, 'D 5458 ACB', 'Motor', 'Entuy', '2026-07-08 11:26:12', '2026-07-08 11:26:12'),
(6, 'D 4155 ACD', 'Motor', 'Firman', '2026-07-08 11:26:43', '2026-07-08 11:26:43'),
(7, 'D 4555 ZK', 'Mobil Box', 'Pa Iqbal', '2026-07-08 11:27:28', '2026-07-08 11:27:28'),
(8, 'D 3645 AS', 'Mobil Box Kecil', 'Gungun', '2026-07-08 11:28:11', '2026-07-08 11:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint UNSIGNED NOT NULL,
  `penerimaan_id` bigint UNSIGNED NOT NULL,
  `penerimaan_roll_id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('di_gudang','dikirim') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'di_gudang',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `penerimaan_id`, `penerimaan_roll_id`, `kategori_id`, `kode_barang`, `warna`, `status`, `created_at`, `updated_at`) VALUES
(5, 12, 45, 9, '10244016', 'Navy', 'di_gudang', '2026-07-08 11:53:56', '2026-07-08 11:53:56'),
(6, 15, 59, 2, '20204019', 'Hitam', 'di_gudang', '2026-07-08 11:59:53', '2026-07-08 11:59:53'),
(7, 15, 60, 2, '20204019', 'Hitam', 'di_gudang', '2026-07-08 12:00:10', '2026-07-08 12:00:10'),
(8, 15, 61, 2, '20204019', 'Hitam', 'di_gudang', '2026-07-08 12:00:29', '2026-07-08 12:00:29'),
(9, 15, 63, 2, '20204019', 'Hitam', 'di_gudang', '2026-07-08 12:00:48', '2026-07-08 12:00:48'),
(10, 15, 62, 2, '20204019', 'Hitam', 'di_gudang', '2026-07-08 12:01:08', '2026-07-08 12:01:08'),
(11, 13, 50, 2, '202019', 'Hitam', 'di_gudang', '2026-07-08 12:01:55', '2026-07-08 12:01:55'),
(12, 12, 46, 9, '10241016', 'Navy', 'di_gudang', '2026-07-08 12:02:19', '2026-07-08 12:02:19'),
(13, 12, 47, 9, '10244016', 'Navy', 'di_gudang', '2026-07-08 12:02:35', '2026-07-08 12:02:35'),
(14, 12, 48, 9, '10244016', 'Navy', 'di_gudang', '2026-07-08 12:02:52', '2026-07-08 12:02:52'),
(15, 14, 57, 8, '702415', 'Benhur', 'dikirim', '2026-07-08 12:03:41', '2026-07-08 12:08:26'),
(16, 13, 51, 2, '202019', 'Hitam', 'di_gudang', '2026-07-08 12:03:58', '2026-07-08 12:03:58'),
(17, 14, 54, 8, '702415', 'Benhur', 'dikirim', '2026-07-08 12:04:21', '2026-07-08 12:08:26'),
(18, 14, 55, 8, '702415', 'Benhur', 'dikirim', '2026-07-08 12:04:36', '2026-07-08 12:08:26'),
(19, 13, 49, 2, '202019', 'Hitam', 'di_gudang', '2026-07-08 12:05:24', '2026-07-08 12:05:24'),
(20, 14, 56, 8, '702415', 'Benhur', 'di_gudang', '2026-07-08 12:05:42', '2026-07-08 12:05:42'),
(21, 14, 58, 8, '702415', 'Benhur', 'di_gudang', '2026-07-08 12:06:01', '2026-07-08 12:06:01'),
(22, 13, 52, 2, '202019', 'Hitam', 'di_gudang', '2026-07-08 12:06:28', '2026-07-08 12:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pengirimans`
--

CREATE TABLE `detail_pengirimans` (
  `id` bigint UNSIGNED NOT NULL,
  `pengiriman_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_pengirimans`
--

INSERT INTO `detail_pengirimans` (`id`, `pengiriman_id`, `barang_id`, `created_at`, `updated_at`) VALUES
(3, 3, 15, '2026-07-08 12:08:26', '2026-07-08 12:08:26'),
(4, 3, 17, '2026-07-08 12:08:26', '2026-07-08 12:08:26'),
(5, 3, 18, '2026-07-08 12:08:26', '2026-07-08 12:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Cotton Combed 30s', 'Bahan katun standar distro', '2026-07-08 08:11:40', '2026-07-08 08:11:40'),
(2, 'Fleece PE', 'Bahan jaket standar', '2026-07-08 08:11:40', '2026-07-08 08:11:40'),
(3, 'PE PIQE 20', 'kain piqe 20s dengan kualitas yang lembut dan menyerap keringat', '2026-07-08 10:39:51', '2026-07-08 10:39:51'),
(4, 'PE SOFT 24', 'kain polyester ukuran 24s dengan permukaan yang halus dan lembut sehingga nyaman saat dipakai', '2026-07-08 10:40:38', '2026-07-08 10:40:38'),
(5, 'PE SOFT 30', 'kain polyester ukuran 30s dengan permukaan yang halus dan lembut, tidak menerawang sehingga nyaman saat dipakai', '2026-07-08 10:41:24', '2026-07-08 10:41:24'),
(6, 'PE BABYTERRY HYDROSOFT 20', 'kain dengan permukaan kain yang halus dan memiliki motif lingkaran yang berulang', '2026-07-08 10:42:14', '2026-07-08 10:42:14'),
(7, 'PE BABYTERRY HYDROSOFT 30', 'kain dengan permukaan kain yang halus dan memiliki motif lingkaran yang berulang', '2026-07-08 10:42:41', '2026-07-08 10:42:41'),
(8, 'CTN SEMI COMBED 24', 'bahan kain katun yang awet dan tahan lama sekaligus menyerap keringat', '2026-07-08 11:31:04', '2026-07-08 11:31:04'),
(9, 'LOTTO SOFT HS 24', 'lotto premium dengan hydrosoft sehingga lebih lembut dan menyerap jkeringat', '2026-07-08 11:31:44', '2026-07-08 11:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_06_28_090659_create_tokos_table', 1),
(3, '2026_06_28_090700_add_toko_id_and_role_to_users_table', 1),
(4, '2026_06_28_090701_create_armadas_table', 1),
(5, '2026_06_28_090701_create_kategoris_table', 1),
(6, '2026_06_28_112925_create_suppliers_table', 1),
(7, '2026_06_28_112926_create_penerimaans_table', 1),
(8, '2026_06_28_112927_create_penerimaan_rolls_table', 1),
(9, '2026_06_28_112927_z_create_barangs_table', 1),
(10, '2026_06_28_112928_create_pengirimans_table', 1),
(11, '2026_06_28_112929_create_detail_pengirimans_table', 1),
(12, '2026_07_08_160836_add_photo_to_users_table', 2),
(13, '2026_07_08_171402_create_password_reset_tokens_table', 3),
(14, '2026_07_08_175407_drop_kode_barang_unique_from_barangs_table', 4),
(15, '2026_07_08_180201_rename_kode_batch_to_kode_oc_in_penerimaans_table', 5),
(16, '2026_07_08_181631_update_suppliers_table_add_kontak_person_and_no_telepon', 6),
(17, '2026_07_08_184827_add_kategori_and_warna_to_penerimaans_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@karuniatex.com', '$2y$12$Y.cBo/keaamKzker9LmYl.8e29lrmf3aXkZvs6oybqv.m72YDAnyy', '2026-07-08 10:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaans`
--

CREATE TABLE `penerimaans` (
  `id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED DEFAULT NULL,
  `warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `kode_oc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penerimaans`
--

INSERT INTO `penerimaans` (`id`, `supplier_id`, `kategori_id`, `warna`, `tanggal_masuk`, `kode_oc`, `created_at`, `updated_at`) VALUES
(7, 2, NULL, NULL, '2026-07-08', '007582', '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(12, 2, 9, 'Navy', '2026-07-08', '007022', '2026-07-08 11:53:14', '2026-07-08 11:53:14'),
(13, 1, 2, 'Hitam', '2026-07-08', '07502/06/26', '2026-07-08 11:56:51', '2026-07-08 11:56:51'),
(14, 3, 8, 'Benhur', '2026-07-08', 'BXCW', '2026-07-08 11:58:03', '2026-07-08 11:58:03'),
(15, 4, 2, 'Hitam', '2026-07-08', 'KT-11', '2026-07-08 11:59:09', '2026-07-08 11:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_rolls`
--

CREATE TABLE `penerimaan_rolls` (
  `id` bigint UNSIGNED NOT NULL,
  `penerimaan_id` bigint UNSIGNED NOT NULL,
  `nomor_roll` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kiloan` decimal(10,2) NOT NULL,
  `is_cataloged` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penerimaan_rolls`
--

INSERT INTO `penerimaan_rolls` (`id`, `penerimaan_id`, `nomor_roll`, `kiloan`, `is_cataloged`, `created_at`, `updated_at`) VALUES
(14, 7, '303', '25.00', 0, '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(15, 7, '304', '25.05', 0, '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(16, 7, '305', '24.65', 0, '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(17, 7, '306', '24.80', 0, '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(18, 7, '307', '24.50', 0, '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(19, 7, '308', '24.95', 0, '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(20, 7, '309', '24.75', 0, '2026-07-08 11:34:49', '2026-07-08 11:34:49'),
(45, 12, '247', '25.00', 1, '2026-07-08 11:53:14', '2026-07-08 11:53:56'),
(46, 12, '248', '24.75', 1, '2026-07-08 11:53:14', '2026-07-08 12:02:19'),
(47, 12, '249', '24.90', 1, '2026-07-08 11:53:14', '2026-07-08 12:02:35'),
(48, 12, '250', '24.95', 1, '2026-07-08 11:53:14', '2026-07-08 12:02:52'),
(49, 13, '1090', '25.60', 1, '2026-07-08 11:56:51', '2026-07-08 12:05:24'),
(50, 13, '1091', '25.35', 1, '2026-07-08 11:56:51', '2026-07-08 12:01:55'),
(51, 13, '1092', '25.80', 1, '2026-07-08 11:56:51', '2026-07-08 12:03:58'),
(52, 13, '1093', '27.00', 1, '2026-07-08 11:56:51', '2026-07-08 12:06:28'),
(53, 13, '1094', '25.45', 0, '2026-07-08 11:56:51', '2026-07-08 11:56:51'),
(54, 14, '25', '24.85', 1, '2026-07-08 11:58:03', '2026-07-08 12:04:21'),
(55, 14, '26', '24.80', 1, '2026-07-08 11:58:03', '2026-07-08 12:04:36'),
(56, 14, '27', '25.05', 1, '2026-07-08 11:58:03', '2026-07-08 12:05:42'),
(57, 14, '28', '25.15', 1, '2026-07-08 11:58:03', '2026-07-08 12:03:41'),
(58, 14, '29', '25.20', 1, '2026-07-08 11:58:03', '2026-07-08 12:06:01'),
(59, 15, '85', '25.30', 1, '2026-07-08 11:59:09', '2026-07-08 11:59:53'),
(60, 15, '86', '25.30', 1, '2026-07-08 11:59:09', '2026-07-08 12:00:10'),
(61, 15, '87', '25.25', 1, '2026-07-08 11:59:09', '2026-07-08 12:00:29'),
(62, 15, '88', '25.30', 1, '2026-07-08 11:59:09', '2026-07-08 12:01:08'),
(63, 15, '89', '25.35', 1, '2026-07-08 11:59:09', '2026-07-08 12:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `pengirimans`
--

CREATE TABLE `pengirimans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `toko_id` bigint UNSIGNED NOT NULL,
  `armada_id` bigint UNSIGNED NOT NULL,
  `tanggal_kirim` date NOT NULL,
  `status` enum('diproses','dikirim','diterima') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diproses',
  `tanggal_diterima` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengirimans`
--

INSERT INTO `pengirimans` (`id`, `user_id`, `toko_id`, `armada_id`, `tanggal_kirim`, `status`, `tanggal_diterima`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-07-06', 'diterima', '2026-07-08 12:09:44', '2026-07-08 08:11:40', '2026-07-08 12:09:44'),
(2, 1, 2, 2, '2026-07-08', 'dikirim', NULL, '2026-07-08 08:43:14', '2026-07-08 08:43:38'),
(3, 4, 3, 3, '2026-07-08', 'dikirim', NULL, '2026-07-08 12:08:26', '2026-07-08 12:09:06');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telepon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama_supplier`, `kontak_person`, `no_telepon`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'PT Gunajaya Santosa', 'Marketing Gunajaya', '0813xxxxxx45', 'Jl. Rancajigang No.110, Padamulya, Kec. Majalaya, Kabupaten Bandung, Jawa Barat 40382', '2026-07-08 08:11:40', '2026-07-08 11:18:45'),
(2, 'PT Safilindo Permata', 'Marketing Safilindo', '08125xxxxx80', 'Jl. Waas No.39, Sukasari, Kec. Pameungpeuk, Kabupaten Bandung, Jawa Barat 40376', '2026-07-08 11:19:44', '2026-07-08 11:19:44'),
(3, 'PT Tri Bintang Lokawarna', 'Marketing Tri Bintang', '0815xxxxxx91', 'Jl. Raya Laswi No.48, Padaulun, Kec. Majalaya, Kabupaten Bandung, Jawa Barat 40392', '2026-07-08 11:20:49', '2026-07-08 11:20:49'),
(4, 'PT Warna Indah Samajaya', 'Marketing WIS', '081257xxxxx9', 'Jl. Balekambang No.29, Sukamaju, Kec. Majalaya, Kabupaten Bandung, Jawa Barat 40391', '2026-07-08 11:21:49', '2026-07-08 11:21:49'),
(5, 'PT Kahatex', 'Marketing Kahatex', '08122xxx6549', 'Jl. Gempol Sari No.16, Cijerah, Kec. Bandung Kulon, Kota Bandung, Jawa Barat 40213', '2026-07-08 11:23:03', '2026-07-08 11:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `tokos`
--

CREATE TABLE `tokos` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_toko` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_toko` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokos`
--

INSERT INTO `tokos` (`id`, `nama_toko`, `alamat_toko`, `created_at`, `updated_at`) VALUES
(1, 'Toko Karunia Textile Otista', 'Jl. Otto Iskandar Dinata No.143 A, Braga, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40181', '2026-07-08 08:11:39', '2026-07-08 11:28:53'),
(2, 'Toko Karunia Textile Batununggal', 'Perumahan, Batununggal Indah Jl. Batununggal Indah Raya No.165, Batununggal, Bandung Kidul, Bandung City, West Java 40266', '2026-07-08 08:11:39', '2026-07-08 11:29:24'),
(3, 'Toko Karunia Textile Surabaya', 'Jl. Kapasan No.33, Kapasan, Kec. Simokerto, Surabaya, Jawa Timur 60141', '2026-07-08 11:29:52', '2026-07-08 11:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `toko_id` bigint UNSIGNED DEFAULT NULL,
  `role` enum('admin','admin_pusat','admin_toko') COLLATE utf8mb4_unicode_ci DEFAULT 'admin_pusat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `toko_id`, `role`) VALUES
(1, 'Administrator', 'admin@karuniatex.com', NULL, NULL, '$2y$12$Jzv26ldcVB/VdN6Ovo0TU.juKjrpFw9e9LElVlbmMhCLpZ9I4jsEK', NULL, '2026-07-08 08:11:39', '2026-07-08 10:15:09', NULL, 'admin'),
(2, 'Petugas Lapangan', 'petugas@karuniatex.com', NULL, NULL, '$2y$12$/m.Bq8PBR6s0KmCteRU9SOsnxAkH5JeCVtHEQHZIi0Twz39PdcVD.', NULL, '2026-07-08 08:11:40', '2026-07-08 08:11:40', NULL, 'admin_pusat'),
(3, 'Admin Toko Tanah Abang', 'toko1@karuniatex.com', NULL, NULL, '$2y$12$lyJrGR1c6hqoSEFm.s13rO5d6ylqU.nqdbUBOl.d3uivL5xZtYr/m', NULL, '2026-07-08 08:11:40', '2026-07-08 08:11:40', 1, 'admin_toko'),
(4, 'budi', 'budi@karuniatex.com', NULL, NULL, '$2y$12$fen99FP49IfqppQCgk5xP..oJueN0HPxiKR9QBgt783XWx7qo6sZ.', NULL, '2026-07-08 10:06:05', '2026-07-08 10:06:05', NULL, 'admin_pusat');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `armadas`
--
ALTER TABLE `armadas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `armadas_plat_nomor_unique` (`plat_nomor`);

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barangs_penerimaan_roll_id_unique` (`penerimaan_roll_id`),
  ADD KEY `barangs_penerimaan_id_foreign` (`penerimaan_id`),
  ADD KEY `barangs_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `detail_pengirimans`
--
ALTER TABLE `detail_pengirimans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pengirimans_pengiriman_id_foreign` (`pengiriman_id`),
  ADD KEY `detail_pengirimans_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penerimaans`
--
ALTER TABLE `penerimaans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penerimaans_kode_batch_unique` (`kode_oc`),
  ADD KEY `penerimaans_supplier_id_foreign` (`supplier_id`),
  ADD KEY `penerimaans_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `penerimaan_rolls`
--
ALTER TABLE `penerimaan_rolls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penerimaan_rolls_nomor_roll_unique` (`nomor_roll`),
  ADD KEY `penerimaan_rolls_penerimaan_id_foreign` (`penerimaan_id`);

--
-- Indexes for table `pengirimans`
--
ALTER TABLE `pengirimans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengirimans_user_id_foreign` (`user_id`),
  ADD KEY `pengirimans_toko_id_foreign` (`toko_id`),
  ADD KEY `pengirimans_armada_id_foreign` (`armada_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokos`
--
ALTER TABLE `tokos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_toko_id_foreign` (`toko_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `armadas`
--
ALTER TABLE `armadas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `detail_pengirimans`
--
ALTER TABLE `detail_pengirimans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `penerimaans`
--
ALTER TABLE `penerimaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `penerimaan_rolls`
--
ALTER TABLE `penerimaan_rolls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `pengirimans`
--
ALTER TABLE `pengirimans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tokos`
--
ALTER TABLE `tokos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barangs_penerimaan_id_foreign` FOREIGN KEY (`penerimaan_id`) REFERENCES `penerimaans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barangs_penerimaan_roll_id_foreign` FOREIGN KEY (`penerimaan_roll_id`) REFERENCES `penerimaan_rolls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_pengirimans`
--
ALTER TABLE `detail_pengirimans`
  ADD CONSTRAINT `detail_pengirimans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pengirimans_pengiriman_id_foreign` FOREIGN KEY (`pengiriman_id`) REFERENCES `pengirimans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penerimaans`
--
ALTER TABLE `penerimaans`
  ADD CONSTRAINT `penerimaans_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penerimaans_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penerimaan_rolls`
--
ALTER TABLE `penerimaan_rolls`
  ADD CONSTRAINT `penerimaan_rolls_penerimaan_id_foreign` FOREIGN KEY (`penerimaan_id`) REFERENCES `penerimaans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengirimans`
--
ALTER TABLE `pengirimans`
  ADD CONSTRAINT `pengirimans_armada_id_foreign` FOREIGN KEY (`armada_id`) REFERENCES `armadas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengirimans_toko_id_foreign` FOREIGN KEY (`toko_id`) REFERENCES `tokos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengirimans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_toko_id_foreign` FOREIGN KEY (`toko_id`) REFERENCES `tokos` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
