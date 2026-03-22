-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Mar 2026 pada 08.09
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tubes-pabw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_menu` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id`, `id_pesanan`, `id_menu`, `jumlah`, `subtotal`) VALUES
(1, 1, 1, 2, 30000),
(2, 1, 3, 1, 15000),
(3, 2, 2, 1, 70000),
(4, 3, 1, 8, 200000),
(5, 4, 1, 3, 75000),
(6, 5, 1, 1, 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `feedback`
--

CREATE TABLE `feedback` (
  `id_feedback` int(11) NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `tgl_masukan` date DEFAULT NULL,
  `pesan_masukan` text DEFAULT NULL,
  `kategori_masukan` varchar(100) DEFAULT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `feedback`
--

INSERT INTO `feedback` (`id_feedback`, `id_user`, `tgl_masukan`, `pesan_masukan`, `kategori_masukan`, `bukti_foto`) VALUES
(6, 1, '2025-01-02', 'Pelayanan sangat baik dan cepat.', 'Pelayanan', 'bukti1.jpg'),
(7, 2, '2025-01-05', 'Menu kurang bervariasi, mohon ditambah.', 'Menu', 'bukti2.jpg'),
(8, 3, '2025-01-07', 'Ruangan agak panas, AC perlu dicek.', 'Fasilitas', 'bukti3.jpg'),
(9, 4, '2025-01-10', 'Harga terjangkau dan makanan enak.', 'Umum', 'bukti4.jpg'),
(11, 2, '2025-12-31', 'perluas tempat parkir', 'Fasilitas', NULL),
(12, 6, '2026-01-01', 'jam buka hingga 23.00', 'Umum', NULL),
(15, 2, '2026-01-02', 'terdapat lalat di sekitar meja', 'Umum', 'uploads/feedback/1767345131_scaled_5op4ipgs2dxi769.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `bahan` varchar(255) NOT NULL,
  `kalori` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'main course',
  `deskripsi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `nama`, `foto`, `harga`, `stok`, `bahan`, `kalori`, `kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Nasi Goreng Ayam', 'nasi-goreng.jpg', 25000, 25, 'Nasi, Telur, Kecap, Bawang, Ayam', 450, 'main course', 'Nasi goreng khas dengan bumbu rempah pilihan.', '2025-11-29 19:48:16', '2025-12-02 00:50:13'),
(2, 'Sate Ayam', 'sate-ayam.jpg', 30000, 40, 'Daging Ayam, Bumbu Kacang, Kecap, Bawang', 350, 'main course', 'Sate ayam dengan bumbu kacang yang gurih dan daging yang empuk.', '2025-11-29 19:48:16', '2025-11-29 19:48:16'),
(3, 'Sate Kambing', 'sate-kambing.jpg', 45000, 30, 'Daging Kambing, Bumbu Kacang, Kecap, Bawang', 500, 'main course', 'Sate kambing yang juicy disajikan dengan bumbu yang melimpah.', '2025-11-29 19:48:16', '2025-11-29 19:48:16'),
(4, 'Sate Sapi', 'sate-sapi.jpg', 40000, 35, 'Daging Sapi, Bumbu Kacang, Kecap, Bawang', 480, 'main course', 'Sate sapi yang juicy disajikan dengan bumbu yang kaya rasa.', '2025-11-29 19:48:16', '2025-11-29 19:48:16'),
(5, 'Tengkleng Kambing', 'tengkleng-kambing.jpg', 50000, 20, 'Tulang Kambing, Santan Cair, Kunyit, Cabai', 600, 'main course', 'Olahan tulang kambing segar dengan kuah gulai encer yang pedas.', '2025-11-29 19:48:16', '2025-11-29 19:48:16'),
(6, 'Tongseng Ayam', 'tongseng-ayam.jpg', 28000, 45, 'Daging Ayam, Kol, Tomat, Santan, Kecap', 400, 'main course', 'Tongseng ayam dengan kuah santan yang segar dan manis gurih.', '2025-11-29 19:48:16', '2025-11-29 19:48:16'),
(7, 'Tongseng Kambing', 'tongseng-kambing.jpg', 48000, 25, 'Daging Kambing, Kol, Tomat, Santan Kental', 550, 'main course', 'Tongseng kambing legendaris dengan daging empuk.', '2025-11-29 19:48:16', '2025-11-29 19:48:16'),
(8, 'Tongseng Kering Sapi', 'tongseng-kering-sapi.jpg', 42000, 30, 'Daging Sapi, Kecap, Merica, Kol', 420, 'main course', 'Varian tongseng tanpa kuah (nyemek) dengan daging sapi pilihan.', '2025-11-29 19:48:16', '2025-11-29 19:48:16'),
(9, 'Tongseng Sapi', 'tongseng-sapi.jpg', 42000, 30, 'Daging Sapi, Santan, Sayuran Segar', 470, 'main course', 'Tongseng sapi berkuah kental yang nikmat.', '2025-11-29 19:48:16', '2025-11-29 19:48:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_28_113435_create_menu_table', 1),
(5, '2025_11_29_072108_create_reservasi_table', 1),
(6, '2025_11_29_073837_create_pesanan_table', 1),
(7, '2025_11_29_073838_create_detail_pesanan_table', 1),
(8, '2025_11_29_080736_create_notification_table', 1),
(9, '2025_11_29_080742_create_feedback_table', 1),
(10, '2025_11_29_175205_add_role_and_foto_profile_to_users_table', 1),
(11, '2025_11_29_080742_create_feeddback_table', 2),
(12, '2025_12_14_122009_add_metode_pembayaran_to_pesanan_table', 3),
(13, '2025_12_16_072240_create_personal_access_tokens_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `judul_notifikasi` varchar(150) DEFAULT NULL,
  `pesan_notifikasi` text DEFAULT NULL,
  `gambar_notifikasi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `id_user`, `judul_notifikasi`, `pesan_notifikasi`, `gambar_notifikasi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Promo Awal Tahun', 'Dapatkan diskon 20% untuk semua menu!', 'notif1.jpg', '2025-12-11 07:40:05', '2025-12-11 07:40:05'),
(3, 3, 'Pesanan Selesai', 'Pesanan Anda telah selesai diproses.', 'notif3.jpg', '2025-12-11 07:40:05', '2025-12-11 07:40:05'),
(4, 4, 'Menu Baru Tersedia', 'Kami menambah 5 menu baru hari ini.', 'notif4.jpg', '2025-12-11 07:40:05', '2025-12-11 07:40:05'),
(5, 1, 'Pembayaran Berhasil', 'Pembayaran Anda telah diterima.', 'notif5.jpg', '2025-12-11 07:40:05', '2025-12-11 07:40:05'),
(7, 2, 'Weekend Live Music', 'Setiap Sabtu & Minggu kami menyediakan live music mulai pukul 18.30 hingga 21.30.', 'live_music.jpg', '2026-01-01 06:01:45', '2026-01-01 06:01:45'),
(8, 2, 'Penyemprotan Disinfektan', 'Restoran akan melakukan penyemprotan disinfektan rutin setiap Rabu pukul 16.00 untuk keamanan bersama.', 'disinfektan.jpg', '2026-01-01 06:01:45', '2026-01-01 06:01:45'),
(9, 2, 'Jadwal Sahur On The Go', 'Nikmati layanan Sahur On The Go, pesan sahur mulai pukul 03.00–04.30 setiap hari selama Ramadan.', 'sahur_onthego.jpg', '2026-01-01 06:01:45', '2026-01-01 06:01:45'),
(10, 2, 'Penyesuaian Layanan Buka Puasa', 'Selama Ramadan, layanan buka puasa aktif mulai pukul 16.30 hingga 22.00 setiap hari untuk mendukung momen berbuka Anda.', 'buka_puasa.jpg', '2026-01-01 06:01:45', '2026-01-01 06:01:45'),
(11, 2, 'Libur Nasional Idul Fitri', 'Restoran tutup pada tanggal 21 April 2025 untuk merayakan Hari Idul Fitri. Kami buka kembali tanggal 22 April 2025.', 'idul_fitri.jpg', '2026-01-01 06:01:45', '2026-01-01 06:01:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('pembeli1@example.com', 'i7X4GktJwuU2YTG1SiM3SjeBOhZxTnBZ1ivFjNYcoSlP0EA6sKcDBFbycNoo', '2025-12-31 05:00:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 4, 'auth_token', '90727c5f34427747c39b08a93eeddb37d80aaa35ab571e6b94dc8eb4e73e5552', '[\"*\"]', NULL, NULL, '2025-12-16 00:23:03', '2025-12-16 00:23:03'),
(2, 'App\\Models\\User', 4, 'auth_token', 'd281424c2b6dd47e8960047250c713ad714e738dcbc1a607dd790e5f33a9e483', '[\"*\"]', NULL, NULL, '2025-12-16 02:29:54', '2025-12-16 02:29:54'),
(3, 'App\\Models\\User', 5, 'auth_token', '2253bdba4b117b1742879190a02c9e645f73d9577264da1bcd70191110cc3631', '[\"*\"]', '2025-12-17 00:28:23', NULL, '2025-12-16 23:28:57', '2025-12-17 00:28:23'),
(4, 'App\\Models\\User', 5, 'auth_token', 'bf7a5138370a8c0291262b51e8b242c9a30a5348a5efc679185df2f1a53fc3b9', '[\"*\"]', NULL, NULL, '2025-12-17 01:16:07', '2025-12-17 01:16:07'),
(5, 'App\\Models\\User', 4, 'auth_token', 'c9e998ab71a027531e0eeb2c95582ceef9a86631a2204a40bae90ab609b4a265', '[\"*\"]', '2025-12-30 22:48:31', NULL, '2025-12-17 01:32:42', '2025-12-30 22:48:31'),
(6, 'App\\Models\\User', 4, 'auth_token', '7e7379b73c8d94923fe91319169f0e742e8cc0ac91e023b7dfb658262f97b0f2', '[\"*\"]', NULL, NULL, '2025-12-17 01:42:16', '2025-12-17 01:42:16'),
(7, 'App\\Models\\User', 4, 'auth_token', 'c45672f3c1ff20104ca053f4f58e1343553b798d89d711b01a85c2ef8214fab7', '[\"*\"]', NULL, NULL, '2025-12-30 06:27:59', '2025-12-30 06:27:59'),
(8, 'App\\Models\\User', 2, 'auth_token', 'b65c86970f40a0de869d08e641db57b77205235c85cd993928a9168eab51453b', '[\"*\"]', '2025-12-31 03:26:13', NULL, '2025-12-31 03:25:28', '2025-12-31 03:26:13'),
(11, 'App\\Models\\User', 6, 'auth_token', 'dea96f33de315d6c4806e56451591b2640cf5b1e4133981680d1475049bc7e99', '[\"*\"]', NULL, NULL, '2025-12-31 04:47:22', '2025-12-31 04:47:22'),
(13, 'App\\Models\\User', 6, 'auth_token', '3673038fccfca6358bc94d3d09a2b9d88830864f622ab30cfc0e083e7be2cac7', '[\"*\"]', '2025-12-31 05:17:12', NULL, '2025-12-31 05:16:48', '2025-12-31 05:17:12'),
(14, 'App\\Models\\User', 6, 'auth_token', 'b60c346453fd1ef3fd14ffd2fe8a7e7192215c0259d3cc9d2b2585f770842042', '[\"*\"]', '2025-12-31 05:47:22', NULL, '2025-12-31 05:47:18', '2025-12-31 05:47:22'),
(17, 'App\\Models\\User', 2, 'auth_token', '15d9b0af04a8aaabb2d9fbbad7079cfc400389c9a5900cb1ee1a67aa64627689', '[\"*\"]', '2025-12-31 06:52:43', NULL, '2025-12-31 06:37:02', '2025-12-31 06:52:43'),
(18, 'App\\Models\\User', 2, 'auth_token', 'bd13775f576cd4d8f028976d8abd551cbf451d61bebb6ed979b0685112d0847b', '[\"*\"]', '2025-12-31 07:35:16', NULL, '2025-12-31 07:04:24', '2025-12-31 07:35:16'),
(19, 'App\\Models\\User', 2, 'auth_token', 'f4486ec82a9888de26c5ed040d69d677337e4ae1bafadfc47e5d95d05a8eb8e2', '[\"*\"]', '2025-12-31 23:27:44', NULL, '2025-12-31 23:27:36', '2025-12-31 23:27:44'),
(20, 'App\\Models\\User', 7, 'auth_token', 'd7a3abc93edc718d1b57a1cf887db99a63960ccc5c49f763251b4b494a9cf751', '[\"*\"]', NULL, NULL, '2026-01-01 16:12:30', '2026-01-01 16:12:30'),
(22, 'App\\Models\\User', 6, 'auth_token', '232105c39e8c630395872538b76a05dc4374c226e3e2b6596168bddf455e7068', '[\"*\"]', '2026-01-01 16:58:11', NULL, '2026-01-01 16:52:03', '2026-01-01 16:58:11'),
(23, 'App\\Models\\User', 2, 'auth_token', 'f5b8ebee76be7cf5ebcaced2af92391afae7f01ba81293ae70036d0b5e245d85', '[\"*\"]', '2026-01-01 17:08:42', NULL, '2026-01-01 17:06:40', '2026-01-01 17:08:42'),
(24, 'App\\Models\\User', 8, 'auth_token', 'e886fd94637a133e46ff592b73035e2670a5dbe2f6aa5a0407469f7f333fc5d0', '[\"*\"]', NULL, NULL, '2026-01-01 21:04:37', '2026-01-01 21:04:37'),
(26, 'App\\Models\\User', 9, 'auth_token', '305e390465198be4921baa0369b30ccfe4500336629b4aeeee212e812f80edc9', '[\"*\"]', NULL, NULL, '2026-01-02 00:37:34', '2026-01-02 00:37:34'),
(28, 'App\\Models\\User', 10, 'auth_token', '15cb4cbdc6f27fc1a275a910d1b878e18cd91b81c9afc485e015183e60d2db4c', '[\"*\"]', NULL, NULL, '2026-01-02 02:08:16', '2026-01-02 02:08:16'),
(29, 'App\\Models\\User', 2, 'auth_token', 'cd246e232d32773158b37b815809f1db45a28b36366517337ad7815240a749d3', '[\"*\"]', '2026-01-02 02:12:11', NULL, '2026-01-02 02:09:55', '2026-01-02 02:12:11'),
(31, 'App\\Models\\User', 11, 'auth_token', '87f31b05ed41099c8c0d9beea44cc874d857f5fa23292c7d011c4f4ebcac7637', '[\"*\"]', NULL, NULL, '2026-01-07 20:51:16', '2026-01-07 20:51:16'),
(32, 'App\\Models\\User', 2, 'auth_token', '581a8f116dbe8385c8c2dc15ae170ea47e536dca18262ccedd48d3f66e38573d', '[\"*\"]', '2026-01-07 20:52:54', NULL, '2026-01-07 20:52:50', '2026-01-07 20:52:54'),
(34, 'App\\Models\\User', 12, 'auth_token', '5cb98d4cc34e50880f1408ca3ce4dcc15826bba79ad13bf4d592cfe9e3cb461a', '[\"*\"]', NULL, NULL, '2026-01-12 23:41:37', '2026-01-12 23:41:37'),
(36, 'App\\Models\\User', 6, 'auth_token', 'ba61c03e19739cac876843a0f0be5bd02c6121cbb4adc5f9d76e6e7bc368c59a', '[\"*\"]', NULL, NULL, '2026-01-22 17:13:48', '2026-01-22 17:13:48'),
(37, 'App\\Models\\User', 6, 'auth_token', 'e241ffa682b4f282fa96b805b8dc4fda6916b58d42b5a6882be21842ab0e0c00', '[\"*\"]', '2026-01-22 17:18:35', NULL, '2026-01-22 17:15:26', '2026-01-22 17:18:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_reservasi` int(11) DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_kasir` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `total_hrg` int(11) NOT NULL,
  `status_pesanan` varchar(255) NOT NULL DEFAULT 'diproses',
  `status_pembayaran` varchar(255) DEFAULT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_reservasi`, `id_user`, `id_kasir`, `tanggal`, `total_hrg`, `status_pesanan`, `status_pembayaran`, `metode_pembayaran`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, NULL, '2025-11-30', 45000, 'Selesai', NULL, NULL, '2025-11-29 12:48:16', '2025-11-29 12:48:16'),
(2, 1, 3, NULL, '2025-11-30', 70000, 'Menunggu Pembayaran', NULL, NULL, '2025-11-29 12:48:16', '2025-11-29 12:48:16'),
(3, NULL, 2, NULL, '2025-12-21', 200000, 'diproses', 'pending', 'cash', '2025-12-20 23:03:14', '2025-12-20 23:03:14'),
(4, NULL, 2, NULL, '2025-12-21', 75000, 'diproses', 'lunas', 'cash', '2025-12-20 23:03:41', '2025-12-20 23:03:51'),
(5, NULL, 2, NULL, '2025-12-21', 25000, 'diproses', 'pending', 'cash', '2025-12-21 00:46:18', '2025-12-21 00:46:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_pemesan` varchar(100) DEFAULT NULL,
  `jml_org` int(11) DEFAULT NULL,
  `tgl_reservasi` date DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status_reservasi` enum('pending','diterima','selesai','batal') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_user`, `nama_pemesan`, `jml_org`, `tgl_reservasi`, `jam_mulai`, `jam_selesai`, `status_reservasi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ahmad Zufar', 4, '2025-01-15', '18:00:00', '20:00:00', 'pending', '2025-12-11 07:39:43', '2025-12-11 07:39:43'),
(2, 2, 'Alif Taufik', 2, '2025-01-16', '19:00:00', '21:00:00', 'diterima', '2025-12-11 07:39:43', '2025-12-11 07:39:43'),
(3, 3, 'Fiandra', 6, '2025-01-17', '17:30:00', '19:30:00', 'selesai', '2025-12-11 07:39:43', '2025-12-11 07:39:43'),
(4, 4, 'Siti Nurhaliza', 10, '2025-01-18', '20:00:00', '22:00:00', 'batal', '2025-12-11 07:39:43', '2025-12-11 07:39:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aMBdAiouMUEIXWRwrZm0SIcRDVN8sbag7UHOoqF9', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSHcyREM2ajh2U1dQSG54NUtNQTBESHE4T0Y2VGlmSFlpV2FFVVJ5VCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ub3RpZmljYXRpb25zL2ZldGNoIjtzOjU6InJvdXRlIjtzOjExOiJub3RpZi5mZXRjaCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1765853315),
('ZrUv8wn4ZiGHSY3vJCFEPkHyefR2tBDhNjLsaxY2', NULL, '127.0.0.1', 'PostmanRuntime/7.51.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWJoTFJQMmFadVNXRkEwWG5kVncxUFo4YlpRQ1JWYWR0aGtKeUtUTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765878989);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'pembeli',
  `foto_profile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `foto_profile`) VALUES
(1, 'Kasir Demo', 'kasir@example.com', NULL, '$2y$12$nH5Px50/SXfpQ5oJgi02nOYf0bLa9ycy9CWyqttP9eykZ8OEVj00C', NULL, '2025-11-29 19:48:15', '2025-11-29 19:48:15', 'kasir', NULL),
(2, 'Diki Alif T', 'diki@gmail.com', NULL, '$2y$12$1X6qqK1JsJ9S6WKFeOZ/segdOg2IPVe.scocQxQja84OWHk9CCAYO', 'Vhfp3DRJbgiPgU3rA0ScIZxCF7Nhg8Lv0LviMGu0UIbA5tkwtLV4SFHanu9g', '2025-11-29 19:48:15', '2026-01-07 20:55:19', 'pembeli', NULL),
(3, 'Pembeli 2', 'pembeli2@example.com', NULL, '$2y$12$YEAiZ2GRXdOZM3PSxtdeLejC.x33MKg88BRGeDC0DlImbD0sALwve', NULL, '2025-11-29 19:48:16', '2025-11-29 19:48:16', 'pembeli', NULL),
(4, 'Admin Demo', 'admin@example.com', NULL, '$2y$12$I0hlhTGo25OqKNFXu/fmVOSEcZ4JW7TZzxmUsM53XU.eaRbp7sjNy', '3RQitRQ7BFVAHv9pawj87TQBgp73zCrKBgikAMnwIuWbmlLtPke7M8NaLith', '2025-11-29 19:48:16', '2025-11-29 19:48:16', 'admin', NULL),
(5, 'Super Admin', 'admin@komars.com', NULL, '$2y$12$jNBWa7uWewuxu.EHEPAL2uOCgjec8jDQRtfZMu4Gdro6CBy/CQ7ja', NULL, '2025-12-16 23:26:32', '2025-12-16 23:26:32', 'admin', NULL),
(6, 'Diki Alif T', 'diki13@gmail.com', NULL, '$2y$12$qtuAguLThr6wde5RuemP/u9DwCwhi5JefVHD1LkVBcPAYSA4lrA/y', NULL, '2025-12-31 04:47:22', '2026-01-22 17:18:33', 'pembeli', NULL),
(7, 'Pedro Xavier', 'pedro@gmail.com', NULL, '$2y$12$Rr4qytZexfrVLZPuG8OdRuTeQ.XAGcnItJqx.JeLJOrkj0lGi/TTS', NULL, '2026-01-01 16:12:30', '2026-01-01 16:23:37', 'pembeli', NULL),
(8, 'Garonx', 'garonx@gmail.com', NULL, '$2y$12$mN3Iyv2lBDJLI2zNCiECV.G9crQxKI7loYxisfnlGGRqjJE1wilPC', NULL, '2026-01-01 21:04:36', '2026-01-01 23:09:05', 'pembeli', 'profile_photos/X3G7yxDx5E0EaVerIlpaNWhovSdXKe5sGEgwStoT.jpg'),
(9, 'Budi Azhari', 'budi.a@gmail.com', NULL, '$2y$12$l0Yodext9EsOxWsMu9BIY./4FgTqstXFUGxzb0PQHrsHNvnlWc0fq', NULL, '2026-01-02 00:37:34', '2026-01-02 00:45:02', 'pembeli', NULL),
(10, 'Budiman', 'dibu@gmail.com', NULL, '$2y$12$lVvjjDJNxo44GlBmNAfUM.9nOPafCP30pJnbiDlO3lNHI7JKAWazW', NULL, '2026-01-02 02:08:16', '2026-01-02 02:09:37', 'pembeli', NULL),
(11, 'obet', 'obet@gmail.com', NULL, '$2y$12$uJNlTIvYIbuEsiLpzclR2ujlo/hDhN21viAqXy7miDqTF.C/km0Q2', NULL, '2026-01-07 20:51:16', '2026-01-07 20:51:53', 'pembeli', NULL),
(12, 'memen abd', 'memen@gmail.com', NULL, '$2y$12$SyKzelkUoN6umpfbwTmzfO3LfktXHAKoK8g2OWaw7vUHnNzNJn6uy', NULL, '2026-01-12 23:41:36', '2026-01-12 23:41:36', 'pembeli', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_detail_pesanan` (`id_pesanan`),
  ADD KEY `idx_detail_menu` (`id_menu`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id_feedback`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `idx_pesanan_user` (`id_user`),
  ADD KEY `idx_pesanan_kasir` (`id_kasir`),
  ADD KEY `idx_pesanan_reservasi` (`id_reservasi`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_kasir` FOREIGN KEY (`id_kasir`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_reservasi` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
