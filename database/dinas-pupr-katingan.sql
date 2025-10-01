-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 10:17 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinas-pupr-katingan`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_code` int DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `url`, `method`, `status_code`, `old_values`, `new_values`, `created_at`, `updated_at`, `deleted_at`) VALUES
(439, 4, 'view', 'App\\Models\\Struktur', NULL, 'Melihat Struktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/struktur', 'GET', 200, NULL, NULL, '2025-09-29 07:56:59', '2025-09-29 07:56:59', NULL),
(440, 4, 'view', 'App\\Models\\Struktur', NULL, 'Melihat Struktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/struktur', 'GET', 200, NULL, NULL, '2025-09-29 08:15:27', '2025-09-29 08:15:27', NULL),
(441, 4, 'get', 'App\\Models\\Struktur', NULL, 'Get Struktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/struktur/peta', 'GET', 200, NULL, NULL, '2025-09-29 08:15:35', '2025-09-29 08:15:35', NULL),
(442, 4, 'view', 'App\\Models\\Struktur', NULL, 'Melihat Struktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/struktur', 'GET', 200, NULL, NULL, '2025-09-29 08:15:45', '2025-09-29 08:15:45', NULL),
(443, 4, 'view', NULL, NULL, 'Melihat Public content', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/public-content', 'GET', 200, NULL, NULL, '2025-09-29 08:16:32', '2025-09-29 08:16:32', NULL),
(444, 4, 'view', NULL, NULL, 'Melihat Konten', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/konten', 'GET', 200, NULL, NULL, '2025-09-29 08:16:34', '2025-09-29 08:16:34', NULL),
(445, 4, 'view', NULL, NULL, 'Melihat Konten', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/konten/program', 'GET', 200, NULL, NULL, '2025-09-29 08:16:35', '2025-09-29 08:16:35', NULL),
(446, 4, 'view', NULL, NULL, 'Melihat Ulasan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/ulasan', 'GET', 200, NULL, NULL, '2025-09-29 08:16:36', '2025-09-29 08:16:36', NULL),
(447, 4, 'view', 'App\\Models\\Pengaduan', NULL, 'Melihat Pengaduan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/pengaduan', 'GET', 200, NULL, NULL, '2025-09-29 08:16:36', '2025-09-29 08:16:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `backup_foto_struktur`
--

CREATE TABLE `backup_foto_struktur` (
  `id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` enum('Kepala Dinas','Sekretaris Dinas','Kepala Bidang Bina Marga','Kepala Bidang Cipta Karya','Kepala Bidang Penataan Ruang','Kepala Bidang Sumber Daya Air','Kepala Sub Bagian Umum','Kepala Sub Bagian Keuangan','Kepala Sub Bagian Program','Kepala Seksi Jalan','Kepala Seksi Jembatan','Kepala Seksi Perumahan','Kepala Seksi Air Minum','Kepala Seksi Sanitasi','Kepala Seksi Perencanaan','Kepala Seksi Pengendalian','Kepala Seksi Irigasi','Kepala Seksi Sungai','Staff Ahli','Staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ringkasan` text COLLATE utf8mb4_unicode_ci,
  `kategori` enum('umum','infrastruktur','bina-marga','sumber-daya-air','cipta-karya','tata-ruang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT '2025-08-21',
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_publikasi` timestamp NULL DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `likes` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','published','archived','pending') COLLATE utf8mb4_unicode_ci DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('5c785c036466adea360111aa28563bfd556b5fba', 'i:2;', 1759128191),
('5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1759128191;', 1759128191);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `captcha_settings`
--

CREATE TABLE `captcha_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `captcha_settings`
--

INSERT INTO `captcha_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'nocaptcha_sitekey', '', '2025-09-23 02:26:02', '2025-09-23 02:26:02'),
(2, 'nocaptcha_secret', '', '2025-09-23 02:26:02', '2025-09-23 02:26:02'),
(3, 'captcha_required', '1', '2025-09-23 02:26:02', '2025-09-23 02:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','in_progress','resolved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `response` text COLLATE utf8mb4_unicode_ci,
  `responded_at` timestamp NULL DEFAULT NULL,
  `responded_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_downloads`
--

CREATE TABLE `file_downloads` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` enum('dokumen','formulir','peraturan','panduan','infrastruktur','perencanaan','pembangunan','pemeliharaan','monitoring','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dokumen',
  `status` enum('aktif','non-aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `download_count` int NOT NULL DEFAULT '0',
  `urutan` int NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeris`
--

CREATE TABLE `galeris` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tipe` enum('foto') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','non-aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri_news`
--

CREATE TABLE `galeri_news` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tipe` enum('foto','video') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'foto',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int DEFAULT NULL,
  `status` enum('aktif','non-aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_layanan` enum('Pengaduan','Izin Infrastruktur') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Baru','Diproses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_05_125909_create_berita_table', 2),
(5, '2025_08_05_125924_create_program_table', 2),
(6, '2025_08_05_125932_create_layanan_table', 2),
(7, '2025_08_07_071724_create_public_contents_table', 2),
(8, '2025_08_07_073019_remove_unique_constraint_from_public_contents_key', 2),
(9, '2025_08_07_074754_add_berita_id_to_public_contents_table', 2),
(10, '2025_08_07_100000_create_pengaduan_table', 2),
(11, '2025_08_07_143857_create_permohonan_layanans_table', 2),
(12, '2025_08_07_143913_create_ulasans_table', 2),
(13, '2025_08_07_171057_add_nik_deskripsi_to_permohonan_layanan_table', 2),
(14, '2025_08_09_110628_add_data_tambahan_to_permohonan_layanan_table', 2),
(15, '2025_08_10_000001_add_admin_role_to_users_table', 2),
(16, '2025_08_10_110236_update_user_roles_enum', 2),
(17, '2025_08_10_154845_add_role_index_to_users_table', 2),
(18, '2025_08_10_16_53_04_optimize_database_indexes', 2),
(19, '2025_08_11_073517_create_activity_logs_table', 2),
(20, '2025_08_11_073540_create_galeris_table', 2),
(21, '2025_08_11_073608_create_file_downloads_table', 2),
(22, '2025_08_12_032041_update_berita_table_for_konten_integration', 2),
(23, '2025_08_12_084228_add_status_author_tanggal_publikasi_to_berita_table', 2),
(24, '2025_08_13_072914_add_enhanced_fields_to_berita_table', 2),
(25, '2025_08_16_000001_implement_soft_deletes', 3),
(26, '2025_08_16_041929_update_users_table_add_admin_roles', 3),
(27, '2025_08_16_041938_update_users_table_add_admin_roles', 3),
(32, '2025_08_16_053128_create_sessions_table', 4),
(33, '2025_08_16_053223_update_sessions_table_add_role_support', 4),
(34, '2025_08_19_014806_add_soft_deletes_to_all_tables', 4),
(35, '2025_08_19_015318_add_deleted_at_to_berita_table', 4),
(36, '2025_08_20_000000_create_struktur_table', 5),
(37, '2025_08_19_020122_add_deleted_at_to_struktur_table', 6),
(38, '2025_08_19_023410_create_videos_table', 6),
(39, '2025_08_19_031230_update_videos_table_structure', 6),
(40, '2025_08_19_031655_add_youtube_fields_to_videos_table', 6),
(41, '2025_08_19_040038_fix_videos_table_schema', 6),
(42, '2025_08_20_031845_add_foto_to_users_table', 6),
(43, '2025_08_20_032124_add_foto_to_users_table', 6),
(44, '2025_08_20_120002_create_visi_misi_table', 7),
(45, '2025_08_25_152146_create_public_content_news_table', 8),
(46, '2025_08_26_021122_add_youtube_fields_to_public_content_news_table', 9),
(47, '2025_08_26_034640_modify_file_fields_nullable_in_public_content_news_table', 10),
(48, '0001_01_01_000000_create_dinas_pupr_database', 1),
(49, '2025_08_25_151200_create_profils_table', 11),
(50, '2025_08_26_084253_add_background_image_to_profils_table', 12),
(51, '2025_08_25_145910_create_ulasan_table', 10),
(52, '2025_08_25_150416_create_galeris_table', 10),
(53, '2025_08_25_150827_create_videos_table', 10),
(54, '2025_08_25_150628_create_galeri_news_table', 13),
(55, '2025_08_26_140446_add_views_to_galeris_table', 14),
(57, '2025_09_03_033433_create_settings_table', 15),
(58, '2025_08_26_072613_add_new_fields_to_permohonan_layanan_table', 16),
(59, '2025_08_26_072929_drop_permohonan_layanan_table', 16),
(60, '2025_08_26_103813_drop_pengaduan_table', 17),
(61, '2025_08_26_103856_create_new_pengaduan_table', 18),
(62, '2025_09_03_133351_create_complaints_table', 18),
(64, '2025_09_03_145849_update_struktur_unit_kerja_enum', 19),
(65, '2025_09_03_150407_update_struktur_jabatan_column_length', 20),
(66, '2025_09_03_160317_add_plt_fields_to_struktur_table', 21),
(67, '2025_09_03_145948_add_missing_columns_to_struktur_table', 22),
(68, '2025_09_05_213854_create_pengaduan_histories_table', 22),
(69, '2025_09_08_095220_add_plt_status_to_struktur_table', 22),
(70, '2025_09_08_100021_add_plt_columns_to_struktur_table', 22),
(71, '2025_09_08_100726_update_jabatan_column_length', 22),
(72, '2025_09_09_133947_add_nomor_tiket_to_pengaduan_table', 22),
(73, '2025_09_09_144514_add_status_code_to_activity_logs_table', 22),
(74, '2025_09_09_150950_make_file_path_nullable_in_public_content_news', 22),
(75, '2025_09_09_151124_remove_unused_fields_from_struktur_table', 22),
(76, '2025_09_09_153921_add_missing_columns_to_file_downloads_table', 22),
(77, '2025_09_09_204917_fix_file_downloads_column_lengths', 23),
(78, '2025_09_09_210608_convert_galeri_video_to_foto', 24),
(79, '2025_09_10_113008_create_captcha_settings_table', 25),
(80, '2025_09_10_113024_create_captcha_settings_table', 26),
(81, '2025_09_15_090400_simplify_captcha_settings_table', 27),
(82, '2025_09_22_000001_drop_permohonan_layanan_table', 27),
(83, '2025_09_23_000001_create_program_status_histories_table', 27),
(84, '2025_09_29_151145_update_struktur_nip_column_length', 28);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subjek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Baru','Diproses','Selesai','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baru',
  `tanggal_pengaduan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan_histories`
--

CREATE TABLE `pengaduan_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `pengaduan_id` bigint UNSIGNED NOT NULL,
  `status_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `admin_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profils`
--

CREATE TABLE `profils` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dinas Pekerjaan Umum dan Penataan Ruang',
  `visi` text COLLATE utf8mb4_unicode_ci,
  `misi` text COLLATE utf8mb4_unicode_ci,
  `tupoksi` text COLLATE utf8mb4_unicode_ci,
  `sejarah` text COLLATE utf8mb4_unicode_ci,
  `motto` text COLLATE utf8mb4_unicode_ci,
  `filosofi` text COLLATE utf8mb4_unicode_ci,
  `nilai_nilai` text COLLATE utf8mb4_unicode_ci,
  `sasaran` text COLLATE utf8mb4_unicode_ci,
  `tujuan` text COLLATE utf8mb4_unicode_ci,
  `kebijakan_mutu` text COLLATE utf8mb4_unicode_ci,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `jam_operasional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Berjalan','Selesai','Perencanaan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_status_histories`
--

CREATE TABLE `program_status_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `program_id` bigint UNSIGNED NOT NULL,
  `status_lama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_baru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'manual, auto_date, auto_scheduler',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tanggal_perubahan` timestamp NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `public_contents`
--

CREATE TABLE `public_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `public_content_news`
--

CREATE TABLE `public_content_news` (
  `id` bigint UNSIGNED NOT NULL,
  `tipe` enum('karousel','video','mitra') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karousel',
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` text COLLATE utf8mb4_unicode_ci,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `status` enum('aktif','non-aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `user_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `user_role`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7LtSB75b1icGsIvEqVxJGznDYg28I475HUifQ3xV', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiam93bnpQTUtkNUtISDhPWUNCaDNVOVprbWFzWkZNR29jWTlmanFzQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756177190),
('8yF5tkXChQoJJVhSq9aZa3b9xnMX1XyrYhroAjds', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2lCQ3BUVERtWW45UkNKclBkdGRYVnpMTHI4OEpndmVFMWp6U1lGYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756178147),
('COrxqGpjrcwtOz8QuraHPysn8fTAWFAjFTv8gOpj', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1I1a1NTYk9KU1J2NnZadDg1Y3JSZVA2Um41N04ybk5mbFFSTk5xYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756177864),
('d33IDN7bfboqaz4mFaUkkHDciVgJJ3daLPIyXVNK', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDJhdDZZejBVck1yU0pxS1hWaTlBY2RRTGRRRnFhWERuUEtvMVJsZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756176844),
('dQX9PtMlFpT6E0KFgWPdT51AugEI7McHO4wAusIb', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMzhabnhIZWkzdXJRdHh6UDVvOXJEN0EzNzc4b2tZZzNKc04xbmk1cCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03MWE4OTk5ZS0yZTliLTQzNDctYTk3Ny03MzM3ZmUyN2JlZjgmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzgxNDY0NjEiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03MWE4OTk5ZS0yZTliLTQzNDctYTk3Ny03MzM3ZmUyN2JlZjgmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzgxNDY0NjEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756178146),
('Fc4YC0iGPb2uuk06puEvPX9wOp2XiN6WFflhtmLn', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaXBIQmtObUZPRE9FSTd2WkZVeGhraDZtZ2ZteWlKREc0OVNkSEZEayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD01Nzg5OGI5NS02NTg1LTQ4ZGItYjFiMC0yYjBkOGQ1MmFhOWUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzc1NTg2NjciO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD01Nzg5OGI5NS02NTg1LTQ4ZGItYjFiMC0yYjBkOGQ1MmFhOWUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzc1NTg2NjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756177559),
('gs0DxGGXwU2EFjatL4dPJuH9CRsXt15Po7p0Xe1P', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEdpbXVEZnRHRkJZcGNETmhua3FBc1BMOUdnNFVZcDQzVFp5VFhBTyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0xZmMzMWM2MS0xMGUyLTQ1MjctOTlhMi1jYzMxMWM1NWJiNGImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzgwNDQ2OTIiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0xZmMzMWM2MS0xMGUyLTQ1MjctOTlhMi1jYzMxMWM1NWJiNGImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzgwNDQ2OTIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756178045),
('GvezuKze8Q9STIViGac2myuagcyU6Pu205xe6MEq', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjNuSVBDR25oUVVUMHNoT3JrUEhZMG5qVjljQ0xKbldQT2g3WnExaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756177559),
('hUSd02YNQQqkNyqz7q3gPmdbAH6gFenad3zUcrIw', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekZEdVdOeGNOdlFaWFF1Tnp5VHhXdjhMUEZpYmIyVTVDWDB3bVF2YSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756176050),
('i5zudmjx75hYe6b3GV93S0UFdYwiycdJElTY4ddO', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnJuM3NZazcwQXZyQmhORVZXMHg4VjRiZmJGMmRSbDAxVjhKQ0l2NyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03MDVmZGNhYy0wNzFiLTQxOTctODZmZi04YzgyODg5NzFkZDkmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzkxNTU0ODIiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03MDVmZGNhYy0wNzFiLTQxOTctODZmZi04YzgyODg5NzFkZDkmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzkxNTU0ODIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756179155),
('iR7quhpC2ImXA5JNlskjT9itQ4e6YCEnQ9Uagdmo', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaHY1NkFnS2JKNDdCbEp1Z0o1R2YzeXRtVU9jc3NTSnVkVXppT2cxTCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD01NThkMmI4ZC1iNTQ2LTRlYmEtOTVkMC0yODMzZjk3MmRkMDUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzczMjI3NTkiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD01NThkMmI4ZC1iNTQ2LTRlYmEtOTVkMC0yODMzZjk3MmRkMDUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzczMjI3NTkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756177323),
('Jc7WNPVu0AtKDZJQ8qDG0lteUlY1guskaIeXJt7S', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0c2UW1aaFpOYXZTS3RCNU9TN0NCTFkyOEN6VHhLV3V0OGwwR2dEciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9Y2IyNmM1YzQtMWIwNi00OGQwLWFhZGQtZjIwYWU4M2RiMTFmJnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2MTc5NzcwMzg4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756179771),
('jOvSgODexhVNaICKChYs5N7khdxI9Q2qYzuAnRzw', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibUFNUm1xdnJCWGNheGNBZ2E5ZG5Zb095dko5UEZqUGVBTWQ0OWxaTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756179783),
('nGJTmti9jxmyeQQVpmv4zpUt9RjwIfxSvW35voQa', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT003YkZ5NWVkdVIxSzFjUzVxU1JBbXphWk5lTWVTNWNoTFJDMDRwQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756179156),
('NxdXdcHE7Za3hCfDZAkHHl23BRmJbcS6hOJwvRxj', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRUhvekQwQVlvQno3V2xzQUsyRTlCU2hOTlMxWEJSY0lPNlhMS21rZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0wNTBmZWZiOC1iNzgxLTQwNWItYjhmNy05OTFiNzQyN2IwMWQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzcxODkwMTgiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0wNTBmZWZiOC1iNzgxLTQwNWItYjhmNy05OTFiNzQyN2IwMWQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzcxODkwMTgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756177189),
('O7nidm9cigiimogdG3MhW721xn8DLwMxFiL9h2DP', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSE41TW80M2NSeUVVMnVtdGxFR1k3VG96NTNBV1lBeEJ3aXBPWTRaQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756178045),
('PC9FmLywIvt24XAvlJj9MF5rcenwHcM5gDJbuzOx', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicVVBQlJKSHFRNml0V3RZUmVhYkQwclpBNDNoQnhweHZQd1NyUXZqZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0xMTc0MDRkZi1kNTg0LTQ5ZGYtODJkMS0zYTQ3ZmVjODQzZmImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzY4NDIwMTYiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0xMTc0MDRkZi1kNTg0LTQ5ZGYtODJkMS0zYTQ3ZmVjODQzZmImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzY4NDIwMTYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756176842),
('pJVZ1DDgg3E7v7hTLeJDxeaBYxdmZI7LU7zf3IPw', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUHlrVU5RTGZsVVZac25kN2QwN0JXdWlpWEtJQXpaSFd5bjVpT0JxYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756177323),
('pyJpv3zyg9vOaqDbENoVbAYbJd8yw0QDvd6iNISW', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic2Q3V05xQ1dhQVowQ2NlekIzZlZmN240cEYxaHR6QlRqR2NaWllMeSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD1kMmQyZTZhZC03NjllLTQ2N2ItODE5MS1jNTJkOWIxY2MyYTQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzYwNDg4MDkiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD1kMmQyZTZhZC03NjllLTQ2N2ItODE5MS1jNTJkOWIxY2MyYTQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzYwNDg4MDkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756176049),
('SjS4U16SYyqPKBrM9QPmPM66p9Ojem1UCJBlFcKc', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic1QzSXBDWTZlVFAxRllVNnlmb3o0ZUVSUm1PMTZZSnFDcHNydlRIcSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03NDcwMGIyYy01ZGFkLTRlMzktYjYxMi0zNjBlZjk0ZDEwZDMmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzc4NjM1ODEiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03NDcwMGIyYy01ZGFkLTRlMzktYjYxMi0zNjBlZjk0ZDEwZDMmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzc4NjM1ODEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756177864),
('sxcLrrJ6bTfdj2vis1PXuvci092KtqL3E5iDWicE', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHFzZzFVUDYwSml6eTVidzJWUlN5U0NiUjR1RDVteWduVmFSVXMybSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756178349),
('TuAazY3GSQAHBzWX3mHmAYMJ9FuOpxdQoBKL9TMq', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1ZHU01xVER6UkZFaW1BVFdkb1NsaXIwU045Wnd6d0hqb0M3RWl3WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC8/aWQ9M2FiMjlhNjgtMzBhOS00YjVhLWJmNTMtM2M3OThjMmEyYjExJnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2MTgwNTc4NTM1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756180578),
('tuCM0EBSsegfz0ocNMzF8M30sPCZW7UEwhrSgq2f', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGVHeVNNU3c2T0FGeG1lb1JNN3F1MEhITUFEU05JNnhwZnFHZkQySyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756177692),
('vncs3PL0s9xL6Ng3yDV3PZlb0UISMYUiOSFvURvf', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOVNDQVdibnFveVJ0Y3BYZ2taVXdqTVJNdU51UFhXTWV3dzFRVFQwNyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbj9pZD02MjU3YTY1Zi04YTgxLTRiM2YtYmFiYS1mMGU5ZTAwY2E3MTcmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzU4MTU2ODUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbj9pZD02MjU3YTY1Zi04YTgxLTRiM2YtYmFiYS1mMGU5ZTAwY2E3MTcmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzU4MTU2ODUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756175816),
('vsQXBaX6b0CynaaKOL7r6KsaipznWFREad9csAMH', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV1ZJZEhXc2x1aEZvcXl6OTEzU2lvR294eTRvVDY1ZHVzMlloWWlFcCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD05OGIxNGQ4Yi1iMDE4LTQyMjktYTY0ZS1kMzI5ODdlZDY2YWYmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzczNTkzMDYiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD05OGIxNGQ4Yi1iMDE4LTQyMjktYTY0ZS1kMzI5ODdlZDY2YWYmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzczNTkzMDYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756177359),
('WJvam4sXF5AYPmtEqs0vxwm0zxYwy9UmRKxD6EMT', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVZleUxkRFBOU1pLNElRUHJteTVHcFl1dldxNG43R2VXZ2NMQUd1VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756177360),
('xLBiD4bfIwA9utloxJRBAE8OlOohZmReZdebPpfC', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY2VzNHlQaExyckFBUlZBOWlGVFlNNE1nMkNzazY0UFBpUkY5M3h0SCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD1jYjI2YzVjNC0xYjA2LTQ4ZDAtYWFkZC1mMjBhZTgzZGIxMWYmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzk3ODMwMzQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD1jYjI2YzVjNC0xYjA2LTQ4ZDAtYWFkZC1mMjBhZTgzZGIxMWYmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzk3ODMwMzQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756179783),
('Y8dQSNRXbOvgbPadIH3B63KKXvNO2B7iNJTkb67L', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidUtmbTluTmZ0MWRqVnZHVXkzUmd3UGRBakl6MGUwSGxVZDRmRjVGeiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03NDcwMGIyYy01ZGFkLTRlMzktYjYxMi0zNjBlZjk0ZDEwZDMmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzc2OTIwNDEiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD03NDcwMGIyYy01ZGFkLTRlMzktYjYxMi0zNjBlZjk0ZDEwZDMmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzc2OTIwNDEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756177692),
('Y8fX2R0nKW9L6sFfBwbkWnEbmAtqGBiBVToHETj2', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVlpRTGdKUEpDOFhad0g4YjRFd21HQUFrbVRnWWpEY2FXZmIweGJrNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756175817),
('zmFQGPiuMhAdywhadvoA9tuNqqrTJSIZfN8o9lVM', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHRWMUdka0dDTWg3Mk1kcDJWdlVDZ0tYUml1TUJHbVcwcWVpWWxmNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0zOTVjZGNjNS0yZmRlLTRhYjQtYmEzMy05N2Y1NGQxNjVlMGImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzgzNDkwNzMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaWMtY29udGVudD9pZD0zOTVjZGNjNS0yZmRlLTRhYjQtYmEzMy05N2Y1NGQxNjVlMGImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTYxNzgzNDkwNzMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756178349),
('Zx7swo3EapsW18w4gLMdA3oyQLorZoqOV6sxiqsW', 2, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidGI0NTdtOTN3TzBEWVRtdXlYYnJvcm05SkQ5VFNCaHhaeTlEd3RaeCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjIxOiJvcmlnaW5hbF9zZXNzaW9uX25hbWUiO3M6Mjc6ImRpbmFzX3B1cHJfa2F0aW5nYW5fc2Vzc2lvbiI7czoxNzoibGFzdF9yZXF1ZXN0X3RpbWUiO2k6MTc1NjE3OTc5MztzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756181391);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `created_at`, `updated_at`) VALUES
(26, 'mail_mailer', 'smtp', 'string', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-03 05:56:41'),
(27, 'mail_host', 'smtp.gmail.com', 'string', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-03 05:56:41'),
(28, 'mail_port', '587', 'integer', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-03 05:56:41'),
(29, 'mail_username', 'budiaat2@gmail.com', 'string', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-03 05:56:41'),
(30, 'mail_password', 'mcujisjzukfkdxgu', 'string', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-09 13:04:25'),
(31, 'mail_encryption', 'tls', 'string', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-03 05:56:41'),
(32, 'mail_from_address', 'budiaat2@gmail.com', 'string', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-03 05:56:41'),
(33, 'mail_from_name', 'PUPR', 'string', 'mail', NULL, '2025-09-03 05:56:41', '2025-09-03 05:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `struktur`
--

CREATE TABLE `struktur` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `golongan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_kerja` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `status` enum('aktif','non-aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `status_keaktifan` enum('aktif','pensiun','mutasi','cuti_panjang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `memerlukan_plt` tinyint(1) NOT NULL DEFAULT '0',
  `plt_struktur_id` bigint UNSIGNED DEFAULT NULL,
  `plt_nama_manual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plt_jabatan_manual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plt_asal_instansi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plt_mulai` date DEFAULT NULL,
  `plt_selesai` date DEFAULT NULL,
  `plt_keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plt_status` enum('aktif','tidak_aktif','selesai') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `struktur`
--

INSERT INTO `struktur` (`id`, `nama`, `jabatan`, `nip`, `golongan`, `unit_kerja`, `urutan`, `status`, `status_keaktifan`, `memerlukan_plt`, `plt_struktur_id`, `plt_nama_manual`, `plt_jabatan_manual`, `plt_asal_instansi`, `plt_mulai`, `plt_selesai`, `plt_keterangan`, `created_at`, `updated_at`, `deleted_at`, `foto`, `plt_status`) VALUES
(1, 'Dr. Ir. CHRISTIAN RAIN, MT', 'KEPALA DINAS', '19681308 199503 1 004', 'PEMBINA UTAMA MUDA/IV.c', 'pimpinan', 1, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(2, 'DEWI UNTARI, ST., MT', 'SEKRETARIS', '19711212 199703 2 006', 'Pembina Tk. I/ IV.b', 'sekretariat', 2, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(3, 'KELOMPOK JABATAN FUNGSIONAL', 'KELOMPOK JABATAN FUNGSIONAL', '-', '-', 'pimpinan', 3, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(4, 'EVATRIANEKA JUNANDA, ST', 'KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN', '19740316 201406 1 002', 'PENATA Tk. I /III. d', 'sekretariat', 4, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(5, 'RENDY MONTE SIGARA, ST', 'KEPALA SUB BAGIAN KEUANGAN, PERENCANAAN, EVALUASI DAN PELAPORAN', '19860803 201001 1 004', 'PENATA Tk. I/ III.d', 'sekretariat', 5, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(6, 'HESRON, ST., MT', 'KEPALA BIDANG CIPTA KARYA', '19800108 201503 1 003', 'Penata Tk. I /III.d', 'cipta_karya', 6, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(7, 'FRANCO CHRISTALINO, ST., M.Si', 'KEPALA BIDANG SUMBER DAYA AIR', '19770528 199803 1 005', 'Penata Tk. I/III.d', 'sumber_daya_air', 7, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(8, 'FILADO, S.T.', 'KEPALA BIDANG BINA MARGA', '19780908 201001 1 006', 'Penata Tk. I/III.d', 'bina_marga', 8, 'aktif', 'aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, NULL),
(9, 'BENONG SUPRIADI, S.T.', 'PLT. KEPALA BIDANG TATA RUANG DAN BINA KONSTRUKSI', '19780829 201001 1 007', 'Penata Tingkat I /III.d', 'tata_ruang', 9, 'aktif', 'aktif', 1, NULL, 'BENONG SUPRIADI, S.T.', 'PLT. KEPALA BIDANG TATA RUANG DAN BINA KONSTRUKSI', NULL, NULL, NULL, 'Pelaksana Tugas Kepala Bidang', '2025-09-29 08:12:35', '2025-09-29 08:12:35', NULL, NULL, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int UNSIGNED NOT NULL,
  `ulasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Umum',
  `rating_detail` json DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `permissions` json DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `login_attempts` int NOT NULL DEFAULT '0',
  `locked_until` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `avatar`, `last_login_at`, `status`, `permissions`, `password_changed_at`, `login_attempts`, `locked_until`, `email_verified_at`, `password`, `role`, `foto`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Administrator Dinas PUPR', 'budiaat2@gmail.com', '082255850452', 'avatars/5Rwfug01SW62SBAWmaoXeApr8RoTgVhqzTkgsOxi.png', '2025-09-29 01:56:02', 'active', NULL, '2025-08-20 20:00:22', 0, NULL, '2025-08-20 19:58:44', '$2y$12$q/G7qQ7YYHp7Ey55vkzyAOxHSV1oWGeha.xyPQjhXwvYkbFaBx2YW', 'super_admin', NULL, 'YptuImFu4PoCGAlwcFxQZErLYzFFswpZWuxMLghtfPEbyGlfKB9sDVN6VErZ', '2025-08-20 19:58:44', '2025-09-29 01:56:02'),
(4, 'Admin PUPR Katingan', 'admin@gmail.com', NULL, 'avatars/qDc6UCvLDpiLsONZVdyP1SHh6lbxBkH7yCQgB4j5.jpg', '2025-09-29 06:43:10', 'active', NULL, '2025-09-22 03:11:35', 0, NULL, NULL, '$2y$12$LRV6JNr2Kd6l2VGLG8m2jumm.st2kKgePd8fN6Zx7o9DjMBk3NwEW', 'admin', NULL, NULL, '2025-09-08 09:25:40', '2025-09-29 06:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hero',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views` int NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visi_misi`
--

CREATE TABLE `visi_misi` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'visi, misi, atau tupoksi',
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_action_index` (`user_id`,`action`),
  ADD KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `activity_logs_created_at_index` (`created_at`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `captcha_settings`
--
ALTER TABLE `captcha_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `captcha_settings_key_unique` (`key`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_responded_by_foreign` (`responded_by`),
  ADD KEY `complaints_status_index` (`status`),
  ADD KEY `complaints_created_at_index` (`created_at`),
  ADD KEY `complaints_email_index` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `file_downloads`
--
ALTER TABLE `file_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_downloads_user_id_foreign` (`user_id`);

--
-- Indexes for table `galeris`
--
ALTER TABLE `galeris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galeris_user_id_foreign` (`user_id`);

--
-- Indexes for table `galeri_news`
--
ALTER TABLE `galeri_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galeri_news_user_id_foreign` (`user_id`),
  ADD KEY `galeri_news_status_tipe_index` (`status`,`tipe`),
  ADD KEY `galeri_news_kategori_urutan_index` (`kategori`,`urutan`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
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
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_status_tanggal_pengaduan_index` (`status`,`tanggal_pengaduan`),
  ADD KEY `pengaduan_email_index` (`email`),
  ADD KEY `pengaduan_nomor_tiket_index` (`nomor_tiket`);

--
-- Indexes for table `pengaduan_histories`
--
ALTER TABLE `pengaduan_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_histories_pengaduan_id_created_at_index` (`pengaduan_id`,`created_at`);

--
-- Indexes for table `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profils_user_id_foreign` (`user_id`),
  ADD KEY `profils_status_index` (`status`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_status_histories`
--
ALTER TABLE `program_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_status_histories_user_id_foreign` (`user_id`),
  ADD KEY `program_status_histories_program_id_tanggal_perubahan_index` (`program_id`,`tanggal_perubahan`);

--
-- Indexes for table `public_contents`
--
ALTER TABLE `public_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `public_contents_key_index` (`key`);

--
-- Indexes for table `public_content_news`
--
ALTER TABLE `public_content_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `public_content_news_user_id_foreign` (`user_id`),
  ADD KEY `public_content_news_tipe_status_urutan_index` (`tipe`,`status`,`urutan`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`),
  ADD KEY `sessions_user_id_user_role_index` (`user_id`,`user_role`),
  ADD KEY `sessions_user_role_index` (`user_role`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`),
  ADD KEY `settings_group_key_index` (`group`,`key`);

--
-- Indexes for table `struktur`
--
ALTER TABLE `struktur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `struktur_nip_unique` (`nip`),
  ADD KEY `struktur_jabatan_urutan_index` (`jabatan`,`urutan`),
  ADD KEY `struktur_status_index` (`status`),
  ADD KEY `struktur_plt_struktur_id_foreign` (`plt_struktur_id`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ulasan_rating_is_published_index` (`rating`,`is_published`),
  ADD KEY `ulasan_is_featured_index` (`is_featured`),
  ADD KEY `ulasan_kategori_index` (`kategori`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `idx_users_role_verified` (`role`,`email_verified_at`),
  ADD KEY `idx_users_updated` (`updated_at`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_user_id_foreign` (`user_id`);

--
-- Indexes for table `visi_misi`
--
ALTER TABLE `visi_misi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visi_misi_jenis_is_active_index` (`jenis`,`is_active`),
  ADD KEY `visi_misi_jenis_created_at_index` (`jenis`,`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=448;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `captcha_settings`
--
ALTER TABLE `captcha_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_downloads`
--
ALTER TABLE `file_downloads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `galeris`
--
ALTER TABLE `galeris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `galeri_news`
--
ALTER TABLE `galeri_news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pengaduan_histories`
--
ALTER TABLE `pengaduan_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profils`
--
ALTER TABLE `profils`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `program_status_histories`
--
ALTER TABLE `program_status_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `public_contents`
--
ALTER TABLE `public_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `public_content_news`
--
ALTER TABLE `public_content_news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `struktur`
--
ALTER TABLE `struktur`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visi_misi`
--
ALTER TABLE `visi_misi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_responded_by_foreign` FOREIGN KEY (`responded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `file_downloads`
--
ALTER TABLE `file_downloads`
  ADD CONSTRAINT `file_downloads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galeris`
--
ALTER TABLE `galeris`
  ADD CONSTRAINT `galeris_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galeri_news`
--
ALTER TABLE `galeri_news`
  ADD CONSTRAINT `galeri_news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan_histories`
--
ALTER TABLE `pengaduan_histories`
  ADD CONSTRAINT `pengaduan_histories_pengaduan_id_foreign` FOREIGN KEY (`pengaduan_id`) REFERENCES `pengaduan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profils`
--
ALTER TABLE `profils`
  ADD CONSTRAINT `profils_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `program_status_histories`
--
ALTER TABLE `program_status_histories`
  ADD CONSTRAINT `program_status_histories_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_status_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `public_content_news`
--
ALTER TABLE `public_content_news`
  ADD CONSTRAINT `public_content_news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `struktur`
--
ALTER TABLE `struktur`
  ADD CONSTRAINT `struktur_plt_struktur_id_foreign` FOREIGN KEY (`plt_struktur_id`) REFERENCES `struktur` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
