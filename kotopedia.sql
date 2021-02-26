-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jan 2021 pada 16.23
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kotopedia`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_kotas`
--

CREATE TABLE `daftar_kotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `code_provinsi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_provinsis`
--

CREATE TABLE `daftar_provinsis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `point`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Jaket', 32, 'jaket_kategori.jpg', NULL, '2021-01-08 14:48:49'),
(2, 'Pakaian Anak', 8, 'pakaiananak_kategori.jpg', NULL, '2020-12-29 06:22:45'),
(3, 'Pakaian Wanita', 10, 'pakaianwanita_kategori.jpg', NULL, '2020-12-07 08:31:42'),
(4, 'sepatu', 24, 'sepatu_kategori.jpg', NULL, '2021-01-08 15:18:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_11_29_094815_create_kategoris_table', 1),
(5, '2020_11_29_094905_create_products_table', 1),
(6, '2020_11_29_121435_create_orders_table', 1),
(7, '2020_11_29_121551_create_order_details_table', 1),
(8, '2020_11_29_122004_create_wishlists_table', 1),
(9, '2020_11_29_130200_create_daftar_kotas_table', 1),
(10, '2020_11_29_130226_create_daftar_provinsis_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kodeKosong',
  `status` int(11) NOT NULL DEFAULT 0,
  `total_harga` int(11) NOT NULL,
  `unik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unikKosong',
  `is_refund` int(11) DEFAULT 0,
  `bukti_refund` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_service_pengiriman` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_pay` int(11) DEFAULT 0,
  `no_resi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_delete_by_admin` int(11) NOT NULL DEFAULT 0,
  `is_delete_by_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `kode`, `status`, `total_harga`, `unik`, `is_refund`, `bukti_refund`, `user_id`, `pesan`, `jenis_service_pengiriman`, `is_pay`, `no_resi`, `catatan`, `is_delete_by_admin`, `is_delete_by_user`, `created_at`, `updated_at`) VALUES
(64, 'Belanja-64-2', 0, 45000, '64-1356-2', 0, NULL, 2, NULL, NULL, 0, NULL, NULL, 0, 0, '2020-12-27 18:57:31', '2020-12-27 18:57:31'),
(77, 'Belanja-77-1', 4, 53000, '77-9009-1', 0, NULL, 1, NULL, 'Paket Kilat Khusus', 2, '087777', NULL, 1, 0, '2021-01-03 00:25:42', '2021-01-05 07:47:52'),
(80, 'Belanja-80-1', 4, 80000, '80-9954-1', 0, NULL, 1, NULL, 'Paket Kilat Khusus', 2, '08999', NULL, 1, 0, '2021-01-04 01:08:49', '2021-01-05 08:02:29'),
(81, 'Belanja-81-1', 3, 53000, '81-4670-1', 0, NULL, 1, NULL, 'Paket Kilat Khusus', 2, '123344', NULL, 0, 0, '2021-01-08 14:48:07', '2021-01-08 14:54:14'),
(82, 'Belanja-82-1', 1, 89000, '82-6244-1', 0, NULL, 1, NULL, 'Express Next Day Barang', 2, NULL, 'kirim bos', 0, 0, '2021-01-08 15:15:15', '2021-01-08 15:20:36'),
(83, 'Belanja-83-1', 2, 53000, '83-5885-1', 0, NULL, 1, NULL, 'Paket Kilat Khusus', 0, NULL, NULL, 0, 0, '2021-01-08 15:22:53', '2021-01-08 15:23:02'),
(87, 'Belanja-87-1', 0, 200000, '87-7477-1', 0, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, 0, '2021-01-10 13:13:15', '2021-01-10 13:13:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_pesanan` int(11) NOT NULL,
  `jumlah_harga` int(11) NOT NULL,
  `varian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_details`
--

INSERT INTO `order_details` (`id`, `jumlah_pesanan`, `jumlah_harga`, `varian`, `product_id`, `order_id`, `created_at`, `updated_at`) VALUES
(104, 2, 90000, '[\"null\"]', 5, 62, '2020-12-27 00:19:54', '2020-12-27 00:19:54'),
(108, 2, 84000, '[\"null\"]', 7, 62, '2020-12-27 01:07:27', '2020-12-27 01:07:27'),
(110, 2, 90000, '[\"null\"]', 5, 65, '2020-12-28 06:44:17', '2020-12-28 06:44:17'),
(119, 2, 90000, '[\"null\"]', 5, 71, '2020-12-29 06:12:55', '2020-12-29 06:12:55'),
(120, 1, 42000, '[\"null\"]', 7, 71, '2020-12-29 06:14:16', '2020-12-29 06:14:45'),
(121, 2, 90000, '[\"null\"]', 5, 73, '2020-12-30 06:25:51', '2020-12-30 06:25:51'),
(122, 1, 63000, '[\"null\"]', 3, 73, '2020-12-30 07:04:01', '2020-12-30 07:04:07'),
(123, 1, 45000, '[\"null\"]', 5, 75, '2020-12-31 08:21:42', '2020-12-31 08:21:42'),
(124, 1, 64000, '[\"null\"]', 1, 76, '2021-01-03 00:23:58', '2021-01-03 00:23:58'),
(125, 1, 45000, '[\"null\"]', 5, 77, '2021-01-03 00:25:42', '2021-01-03 00:25:42'),
(126, 1, 45000, '[\"null\"]', 5, 78, '2021-01-04 00:52:50', '2021-01-04 00:52:50'),
(127, 1, 63000, '[\"null\"]', 3, 79, '2021-01-04 00:59:52', '2021-01-04 00:59:52'),
(128, 1, 64000, '[\"null\"]', 1, 80, '2021-01-04 01:08:49', '2021-01-04 01:08:49'),
(129, 1, 45000, '[\"null\"]', 5, 81, '2021-01-08 14:48:07', '2021-01-08 14:48:07'),
(130, 1, 64000, '[\"null\"]', 1, 82, '2021-01-08 15:15:15', '2021-01-08 15:15:15'),
(131, 1, 45000, '[\"null\"]', 5, 83, '2021-01-08 15:22:53', '2021-01-08 15:22:53'),
(137, 1, 200000, 'merah, 1500', 61, 87, '2021-01-10 13:13:15', '2021-01-10 13:13:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_tokos`
--

CREATE TABLE `pengaturan_tokos` (
  `id` int(11) NOT NULL,
  `kota_id` int(11) NOT NULL DEFAULT 0,
  `provinsi_id` int(11) NOT NULL DEFAULT 0,
  `nama_kota` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(25) DEFAULT NULL,
  `nama_flashsale` varchar(255) NOT NULL DEFAULT 'BIG SALE CERIA!!!',
  `jasa_pengiriman` varchar(20) NOT NULL DEFAULT 'jne',
  `product_populer_update_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengaturan_tokos`
--

INSERT INTO `pengaturan_tokos` (`id`, `kota_id`, `provinsi_id`, `nama_kota`, `no_telepon`, `nama_flashsale`, `jasa_pengiriman`, `product_populer_update_at`, `created_at`, `updated_at`) VALUES
(1, 255, 11, 'Malang', '085886662305', 'BIG SALE CERIA!!!', 'pos', '2021-01-08 09:19:34', '2020-12-30 13:12:00', '2021-01-01 07:26:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `point` int(11) NOT NULL DEFAULT 0,
  `is_flashsale` tinyint(1) NOT NULL DEFAULT 0,
  `diskon` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list_warna` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_warna`)),
  `list_ukuran` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_ukuran`)),
  `varian_lainnya` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list_varian_lainnya` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_varian_lainnya`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `nama`, `harga`, `stok`, `berat`, `point`, `is_flashsale`, `diskon`, `gambar`, `kategori_id`, `tags`, `deskripsi`, `list_warna`, `list_ukuran`, `varian_lainnya`, `list_varian_lainnya`, `created_at`, `updated_at`) VALUES
(1, 'sepatu pria', 80000, 5, 200, 0, 1, 20, 'e66d4b70b7b9096fbda30cabd2aab311.jpeg', 4, 'sepatu pria olahraga hitam', 'sepatu bagus', '[\"null\"]', '[\"43\",\"44\"]', 'null', '[\"null\"]', NULL, '2021-01-09 13:43:40'),
(2, 'jaket pria hitam', 100000, 120, 1000, 0, 1, 5, '6650f441253f6cd621e01cea3729a619.jpeg', 1, 'jaket pria hitam murah', 'ini jaket', '[\"null\"]', '[\"null\"]', 'null', '[\"null\"]', '2020-12-04 00:25:51', '2021-01-08 15:39:17'),
(3, 'sepatu futsal specs mahal ', 90000, 15, 1000, 0, 1, 30, '7a0fdea348c2ae496d4dff4fcad4e5f8.jpeg', 4, 'sepatu futsal specs pria', 'ini adalah deskripsi dari sepatu futasl', '[\"null\"]', '[\"null\"]', 'null', '[\"null\"]', NULL, '2021-01-08 15:39:17'),
(5, 'Jaket pria jilid 2', 50000, 15, 50, 0, 1, 10, 'b1d9c5512de3d5bdfe5df160dc686872.jpeg', 1, 'Jaket pria kulit', 'ini adalah jaket ', '[\"null\"]', '[\"null\"]', 'null', '[\"null\"]', '2020-12-07 02:46:59', '2021-01-09 06:15:35'),
(7, 'Baju Anak-anak', 60000, 50, 500, 0, 0, 30, '675548617919aba4eb12da978bcbe3c2.jpeg', 2, 'baju anak lucu atasan', 'sepatu', '[\"null\"]', '[\"null\"]', 'null', '[\"null\"]', '2020-12-07 08:42:47', '2021-01-08 15:39:17'),
(8, 'sepatu futsal jilid 2', 3000000, 5, 2000, 0, 0, 20, 'c2c61813ffab3684fe482a0b248ce22e.jpeg', 4, 'sepatu futsal nike wanita', 'sepatu futsal nike ', '[\"null\"]', '[\"null\"]', 'null', '[\"null\"]', '2020-12-07 08:43:20', '2021-01-09 13:14:22'),
(9, 'Jaket pria jilid 3', 2000000, 3, 500, 0, 0, 10, '4f62061ff0b208a6c79a8d3411cd6c17.jpeg', 1, 'jaket motor', 'jaket motor keren', '[\"null\"]', '[\"null\"]', 'null', '[\"null\"]', '2020-12-07 08:44:27', '2021-01-08 15:39:17'),
(61, 'Mobil civic wonder', 250000, 2, 200, 0, 0, 20, '6e858304f70db70cdd4df43fe921bb25.jpeg', 3, 'mobil sedan ', 'ini adalah mobil', '[\"merah\",\"hijau\"]', '[\"null\"]', 'cc', '[\"1000\",\"1500\"]', '2021-01-09 09:45:11', '2021-01-09 09:45:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tags_points`
--

CREATE TABLE `tags_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(100) DEFAULT NULL,
  `tags_point` int(11) NOT NULL DEFAULT 0,
  `tags_point_temp` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tags_points`
--

INSERT INTO `tags_points` (`id`, `user_id`, `tags`, `tags_point`, `tags_point_temp`, `created_at`, `updated_at`) VALUES
(8, 1, 'sepatu', 33, 0, '2021-01-07 14:33:47', '2021-01-10 13:13:05'),
(9, 1, 'pria', 35, 0, '2021-01-07 14:33:47', '2021-01-10 12:41:13'),
(10, 1, 'olahraga', 4, 0, '2021-01-07 14:33:47', '2021-01-10 12:41:13'),
(11, 1, 'hitam', 13, 0, '2021-01-07 14:33:47', '2021-01-10 12:41:13'),
(12, 1, 'jaket', 23, 0, '2021-01-07 14:37:54', '2021-01-10 12:41:13'),
(13, 1, 'murah', 10, 0, '2021-01-07 14:37:54', '2021-01-10 12:41:13'),
(14, 2, 'Jaket', 0, 2, '2021-01-07 14:42:58', '2021-01-07 14:42:58'),
(15, 2, 'pria', 0, 2, '2021-01-07 14:42:58', '2021-01-07 14:42:58'),
(16, 2, 'kulit', 0, 2, '2021-01-07 14:42:58', '2021-01-07 14:42:58'),
(17, 1, 'kulit', 13, 0, '2021-01-07 21:57:18', '2021-01-10 12:41:13'),
(18, 1, 'futsal', 9, 0, '2021-01-07 21:59:08', '2021-01-10 12:41:13'),
(19, 1, 'specs', 9, 0, '2021-01-07 21:59:08', '2021-01-10 12:41:13'),
(20, 1, 'mobil', 20, 0, '2021-01-09 14:13:15', '2021-01-10 13:13:05'),
(21, 1, 'sedan', 20, 0, '2021-01-09 14:13:15', '2021-01-10 13:13:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telpon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rekening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi_id` int(11) NOT NULL DEFAULT 0,
  `kota_id` int(11) DEFAULT 0,
  `lengkap` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `alamat`, `alamat_lengkap`, `no_telpon`, `no_rekening`, `nama_bank`, `provinsi_id`, `kota_id`, `lengkap`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'alamin', 'alamin.ibad@gmail.com', NULL, '$2y$10$Jx.nko9u.EBnG7DlCc8gQetZAIo8eOam.i7Ywckoe55uzWH2XEdzO', 'Gresik', 'Manyar,Gresik', '085886662305', '98710001106769', 'MANDIRI', 11, 133, 1, 1, NULL, '2020-11-29 06:41:03', '2020-12-28 17:18:59'),
(2, 'Haris', 'haris@gmail.com', NULL, '$2y$10$UlM3e04Awtr0mvvjcbxFceBEAa/6u5bvMpBK4ZhEolTKq7sdLKjQi', 'Jombang', 'Jalan Jombang-Mojokerto 98', '08599810910', '987100011067999', 'MANDIRI', 11, 164, 1, 0, NULL, '2020-12-09 06:31:37', '2020-12-27 19:01:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `activity_point` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `activity_day` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_activities`
--

INSERT INTO `user_activities` (`id`, `user_id`, `activity_point`, `is_active`, `activity_day`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 1, 'Sun', '2021-01-05 23:42:42', '2021-01-10 12:41:13'),
(2, 2, 0, 0, 'Fri', '2021-01-07 14:42:45', '2021-01-08 09:08:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `nama_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `nama_product`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'sepatu pria', NULL, NULL),
(5, 2, 5, 'Jaket pria jilid 2', '2020-12-09 06:51:39', '2020-12-09 06:51:39'),
(6, 1, 2, 'jaket pria hitam', '2020-12-10 06:02:18', '2020-12-10 06:02:18'),
(10, 2, 3, 'sepatu futsal specs mahal ', '2020-12-27 00:51:01', '2020-12-27 00:51:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_kotas`
--
ALTER TABLE `daftar_kotas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_provinsis`
--
ALTER TABLE `daftar_provinsis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pengaturan_tokos`
--
ALTER TABLE `pengaturan_tokos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tags_points`
--
ALTER TABLE `tags_points`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_kotas`
--
ALTER TABLE `daftar_kotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `daftar_provinsis`
--
ALTER TABLE `daftar_provinsis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT untuk tabel `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_tokos`
--
ALTER TABLE `pengaturan_tokos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `tags_points`
--
ALTER TABLE `tags_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
