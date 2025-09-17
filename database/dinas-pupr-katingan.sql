-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Sep 2025 pada 04.47
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
-- Database: `dinas-pupr-katingan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `status_code` int(11) DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `url`, `method`, `status_code`, `old_values`, `new_values`, `created_at`, `updated_at`) VALUES
(363, 1, 'view', NULL, NULL, 'Melihat Admin management', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/admin-management', 'GET', 200, NULL, NULL, '2025-09-15 02:16:53', '2025-09-15 02:16:53'),
(364, 1, 'update', NULL, 6, 'Mengubah Admin management', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/admin-management/6/edit', 'GET', 200, NULL, NULL, '2025-09-15 02:16:57', '2025-09-15 02:16:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `ringkasan` text DEFAULT NULL,
  `kategori` enum('umum','infrastruktur','bina-marga','sumber-daya-air','cipta-karya','tata-ruang') NOT NULL DEFAULT 'umum',
  `tags` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT '2025-08-19',
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `author` varchar(255) DEFAULT NULL,
  `tanggal_publikasi` timestamp NULL DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('captcha_setting_captcha_required', 'b:1;', 1757906028),
('captcha_setting_nocaptcha_enterprise', 'b:0;', 1757906036),
('captcha_setting_nocaptcha_secret', 's:40:\"6LffJ8QrAAAAANpsBaGKLRlye4AKv5gtEQSI0SwH\";', 1757906028),
('captcha_setting_nocaptcha_sitekey', 's:40:\"6LffJ8QrAAAAANWw0KNSZYvPaK3GiD6fx2i7iGxM\";', 1757906028);

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
-- Struktur dari tabel `captcha_settings`
--

CREATE TABLE `captcha_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `captcha_settings`
--

INSERT INTO `captcha_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'nocaptcha_sitekey', '6LffJ8QrAAAAANWw0KNSZYvPaK3GiD6fx2i7iGxM', '2025-09-15 02:06:50', '2025-09-15 02:06:50'),
(2, 'nocaptcha_secret', '6LffJ8QrAAAAANpsBaGKLRlye4AKv5gtEQSI0SwH', '2025-09-15 02:06:50', '2025-09-15 02:06:50'),
(3, 'captcha_required', '1', '2025-09-15 02:06:50', '2025-09-15 02:13:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','in_progress','resolved','rejected') NOT NULL DEFAULT 'pending',
  `response` text DEFAULT NULL,
  `responded_at` timestamp NULL DEFAULT NULL,
  `responded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Struktur dari tabel `file_downloads`
--

CREATE TABLE `file_downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `kategori` enum('dokumen','formulir','peraturan','panduan','infrastruktur','perencanaan','pembangunan','pemeliharaan','monitoring','lainnya') NOT NULL DEFAULT 'dokumen',
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `download_count` int(11) NOT NULL DEFAULT 0,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeris`
--

CREATE TABLE `galeris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe` enum('foto') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `kategori` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri_news`
--

CREATE TABLE `galeri_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe` enum('foto','video') NOT NULL DEFAULT 'foto',
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `kategori` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `konten_public`
--

CREATE TABLE `konten_public` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('karosel','video','mitra') NOT NULL COMMENT 'Tipe konten',
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL COMMENT 'URL tujuan untuk karosel/mitra',
  `gambar` varchar(255) DEFAULT NULL COMMENT 'File gambar untuk karosel/mitra',
  `video_url` varchar(255) DEFAULT NULL COMMENT 'URL video untuk video beranda',
  `urutan` int(11) NOT NULL DEFAULT 0 COMMENT 'Urutan tampil',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `pengaturan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Pengaturan tambahan' CHECK (json_valid(`pengaturan`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenis_layanan` enum('Pengaduan','Izin Infrastruktur') NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('Baru','Diproses','Selesai') NOT NULL DEFAULT 'Baru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_dinas_pupr_database', 1),
(3, '2025_08_25_145910_create_ulasan_table', 2),
(4, '2025_08_25_150416_create_galeris_table', 3),
(5, '2025_08_25_150628_create_galeri_news_table', 4),
(6, '2025_08_25_150827_create_videos_table', 5),
(7, '2025_08_25_151200_create_profils_table', 6),
(8, '2025_08_25_152146_create_public_content_news_table', 7),
(9, '2025_08_26_021122_add_youtube_fields_to_public_content_news_table', 8),
(10, '2025_08_26_072613_add_new_fields_to_permohonan_layanan_table', 9),
(11, '2025_08_26_072929_drop_permohonan_layanan_table', 10),
(12, '2025_08_26_084253_add_background_image_to_profils_table', 11),
(13, '2025_08_26_103813_drop_pengaduan_table', 12),
(14, '2025_08_26_103856_create_new_pengaduan_table', 12),
(17, '2025_08_26_140446_add_views_to_galeris_table', 13),
(18, '2025_09_03_033433_create_settings_table', 14),
(19, '2025_09_03_133351_create_complaints_table', 15),
(20, '2025_09_03_145849_update_struktur_unit_kerja_enum', 15),
(21, '2025_09_05_213854_create_pengaduan_histories_table', 16),
(22, '2025_09_08_095220_add_plt_status_to_struktur_table', 17),
(23, '2025_09_08_100021_add_plt_columns_to_struktur_table', 18),
(24, '2025_09_03_145948_add_missing_columns_to_struktur_table', 19),
(25, '2025_09_03_150407_update_struktur_jabatan_column_length', 19),
(26, '2025_09_03_160317_add_plt_fields_to_struktur_table', 19),
(27, '2025_09_08_100726_update_jabatan_column_length', 19),
(28, '2025_09_09_133947_add_nomor_tiket_to_pengaduan_table', 20),
(29, '2025_09_09_144514_add_status_code_to_activity_logs_table', 21),
(30, '2025_09_09_150950_make_file_path_nullable_in_public_content_news', 22),
(31, '2025_09_09_151124_remove_unused_fields_from_struktur_table', 23),
(33, '2025_09_09_153904_add_missing_columns_to_file_downloads_table', 24),
(34, '2025_09_09_153921_add_missing_columns_to_file_downloads_table', 24),
(35, '2025_09_09_204917_fix_file_downloads_column_lengths', 25),
(36, '2025_09_09_210608_convert_galeri_video_to_foto', 25),
(37, '2025_09_10_113024_create_captcha_settings_table', 25),
(38, '2025_09_15_090400_simplify_captcha_settings_table', 26);

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
('admin@pupr-katingan.go.id', '$2y$12$f9qUt9WjsP0xAh2fncYWYO1dC89twAkgsOe5zvVXs/nrSLaCscbJu', '2025-09-09 02:41:25'),
('budiaat25@gmail.com', '$2y$12$27k6VQb/RqUCq/28hBEMYOJ3Qef0VAh4V.Q2Drpe3ZLcSLfX5ihBy', '2025-09-15 01:58:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_tiket` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('Baru','Diproses','Selesai','Ditolak') NOT NULL DEFAULT 'Baru',
  `tanggal_pengaduan` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan_histories`
--

CREATE TABLE `pengaduan_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengaduan_id` bigint(20) UNSIGNED NOT NULL,
  `status_from` varchar(255) DEFAULT NULL,
  `status_to` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profils`
--

CREATE TABLE `profils` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_instansi` varchar(255) NOT NULL DEFAULT 'Dinas Pekerjaan Umum dan Penataan Ruang',
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `tupoksi` text DEFAULT NULL,
  `sejarah` text DEFAULT NULL,
  `motto` text DEFAULT NULL,
  `filosofi` text DEFAULT NULL,
  `nilai_nilai` text DEFAULT NULL,
  `sasaran` text DEFAULT NULL,
  `tujuan` text DEFAULT NULL,
  `kebijakan_mutu` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `jam_operasional` varchar(255) DEFAULT NULL,
  `status` enum('aktif','draft') NOT NULL DEFAULT 'aktif',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `program`
--

CREATE TABLE `program` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_program` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('Berjalan','Selesai','Perencanaan') NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `public_content_news`
--

CREATE TABLE `public_content_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('karousel','video','mitra') NOT NULL DEFAULT 'karousel',
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_role` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `user_role`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5yF3ixiV2u462uqAFIa7P5strtT2LIwhYFxeATuJ', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVh2VEFnRkU1cHFadThDT3g3ZnVSZURFdDhSc0VxTk95cjMyb3N5dyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD0yODhiYjM1Ny1mYmEzLTQ4OGEtOWE2My00NmI3Y2YxZWMyYjgmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDMwNzc3ODciO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD0yODhiYjM1Ny1mYmEzLTQ4OGEtOWE2My00NmI3Y2YxZWMyYjgmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDMwNzc3ODciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756803078),
('6jM8BgXvJ77QRLvzyES8yUBieD8LaFUWHHVnZfJa', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOU5YRXhOWVplZ1VrMzZ2OXhUQkhGcG1wRUk0Sm56bUF3UmJGUW9oUCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD0wNTE3MmRmZi04ZmM4LTQ3MTYtYjU1Yy00ZGFmYjUyNjI2YWUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDIyOTkyMzAiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD0wNTE3MmRmZi04ZmM4LTQ3MTYtYjU1Yy00ZGFmYjUyNjI2YWUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDIyOTkyMzAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756802299),
('8gIuOV9rRSXDxPAVU0ciYhPqehltt0q1I5tegNJZ', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM281REtkZjJPWXBxM3czbHV2N2d4U1ZhQkxZMjA4TGVEc01CR2tzbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAwOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbG9naW4/aWQ9NTU0YWFmMzAtYmFmOS00ZjY5LWJmNjAtZTE5ZDQ5ZmExZTQzJnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2ODAzMDMxODQ0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756803032),
('BTGj1nav9loDPNIlHFoKobVuL0DTrNBg63Xa2JzK', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWWZrYjdSeHRWVEJTblBYRlB6RGtZUmhNQXk4cmQxMWI5ZXRvbVdMQiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD0yYmEyNTNlOS1hZjEzLTQzM2EtYWI2My1mYzMzNjc4MzMyODgmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDE3OTM0MjMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD0yYmEyNTNlOS1hZjEzLTQzM2EtYWI2My1mYzMzNjc4MzMyODgmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDE3OTM0MjMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756801793),
('cQPPacGFxhFF0sELLikFNf15xjm0JiNhDK5LZUou', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXgxSzJ4QUtCMDRQUk9VV0R1U3NHbUpZbDd3bFMxUmRzbUZZcUNHdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756799755),
('Cw15cy83jzWqBHMxMRDdR6QuV3Q5qlgB1ZDGgS0x', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkxqMjhORmtXUlJJM3BTNWxhTlZmRGhCR3I2cE4wSVRBVHdjN054ciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756801436),
('dOWgNQarZIpzp27BWZhjamu8LEuWpY8ZxEjMg9fB', 1, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOXVIdVByYmUwV09nbHJ1YWUyTEgxTHA2V1Zkdlh0UjQ5VEc1MVJMUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZSI7fXM6MTc6Imxhc3RfcmVxdWVzdF90aW1lIjtpOjE3NTY4MDMxMzk7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1756803404),
('fhXFIQwxrVBMcRxd1rkgFZgKCBZyg0p6myHPbLFR', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekZRR2tGYnJMRnRRYVhCMGxSSkJ2VzVxaFJ1T0ljOVZ6TjF5VVJpNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756802620),
('Ghp4nSD08kcPzkz8kMZD8x0wdm5CQU392djrL0C3', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGE2cTN2WFlPclYyNUJMeHNZMGNnOU5JUWFXVWg2N0lMS05HRzZFViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05ZDRkNDVkMy0yNjI3LTRhN2MtOTA5Yi1kNzJkY2ViMjJhZjImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTg4NDEwMzgiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05ZDRkNDVkMy0yNjI3LTRhN2MtOTA5Yi1kNzJkY2ViMjJhZjImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTg4NDEwMzgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756798841),
('gvmdRJ7U2mVvpmI5q7AnhH1yoQErIsmQgdcg5d9Y', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3JxRlpvTGVIOGVZRnVNVkMweW02c0NZMVBTQm1mOHpIalA3MUo3UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTExOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvdGVzdC9iZXJpdGEtZm9ybT9pZD1iMzViNzhlMC02MjQxLTRjNzItOWRkYi04N2U4ZjY3YTVkNjUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDI5MTc4NTkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756802922),
('HAmRDkpDEEufbctbESd5qwUOr4jbrQkRAFawY7fU', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaHhLUmhwS3A2aVVnckJEMkMxY2FQYzc0QWIwc1M3MTNBUVBmaVdQMyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05ZDRkNDVkMy0yNjI3LTRhN2MtOTA5Yi1kNzJkY2ViMjJhZjImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTg3MjQyMjEiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05ZDRkNDVkMy0yNjI3LTRhN2MtOTA5Yi1kNzJkY2ViMjJhZjImdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTg3MjQyMjEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756798724),
('heyJBnTzm8pTY7NFTyk1flArVJBpMRGjavCyu7Sh', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMmh5YjdoblVOR25kR0cxN3V0bm5BRjRjZzU4eklmT1Z4M0kzSHVJTiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD01ODA5NTAyNS04OTVhLTRlNDktOTg3Yy0xNzllMGYyZjQ3MWQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDI2MTg2OTMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD01ODA5NTAyNS04OTVhLTRlNDktOTg3Yy0xNzllMGYyZjQ3MWQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDI2MTg2OTMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756802619),
('hWpeFoRlcK4uPEnC4txF30j6y96xQqLxWJq6ofGk', 2, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicVVEbE5aa0d4SG1NSnlJTDhpTnM0Zlhzb2k5OE9uNThEUDB5SVpsdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTc6Imxhc3RfcmVxdWVzdF90aW1lIjtpOjE3NTY4MDA2NTE7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1756803098),
('iyqryxTpXHpQ1QvtL6lsuNPrS5zYkg0Unyo030sL', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0w1ckQ3aFc4TlM3aEF4T1JlZFlpT2M1TGp0R095a3hkWThHalJ0SiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756802693),
('k1zngXvENQoWpsanH2nfJyk3D9InRgDrqUW9k70P', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaHp1VVFGdzVlZlRiZFc3Q2dlekxXWHVDQlJwcG0zQmFCZ1I2ckpNZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD03Y2U3OGIyMS1kODJjLTRjM2EtYjFmZi1hZjkwM2FmYmI5OWEmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDExMjk2MTgiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD03Y2U3OGIyMS1kODJjLTRjM2EtYjFmZi1hZjkwM2FmYmI5OWEmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDExMjk2MTgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756801130),
('mArC9D2iosEtxJeWV9BIE3XGspjmVSh4HwlzWDRp', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRERvV3llU3pDYUZRV1ptaE1lcm56dmZkdElJTWRZQnZkaTRVWkJESiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756798504),
('mji8Ad8uqD8DZqADPH1INt8Y656Xjg49fv33epIc', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicThkOXcwOE0zR3k1M1ZEUDk4Z0p2Q1hpanZEUU9RUnlMWlhlSHAyZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD1lOWM1YTljMi1jYzgxLTQyODEtOWViNy04NWZjYTkwNTQ5YjQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDI2OTI0NjYiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD1lOWM1YTljMi1jYzgxLTQyODEtOWViNy04NWZjYTkwNTQ5YjQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDI2OTI0NjYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756802692),
('ndYv98AY6Kw1KD2enbnkeFEQ9L3uFoWcrrZoRQV4', 1, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUmx4em16eUhQM2JUbmJFQmNJR3IwRXpzTGlwQmx3NG85YkFkdUZCViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNzoibGFzdF9yZXF1ZXN0X3RpbWUiO2k6MTc1NjgxNTA3ODtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4va29udGVuL2Jlcml0YS9jcmVhdGUiO319', 1756815837),
('NxMHtPySoaQVRVeandZm4z3LfjuYBTyb6toYJqbU', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNmhIcWZ0RFU0MTZYb3RGdUVwdWViekFiT0FjSGo4NWlQVFFVa015bCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756800956),
('p4SWc5xjMtyzUvQ6JlUHOahIbvPOoPgkuEQWHVcF', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWhsdzdzRksxaUhCWG9pb1Q5NmdWQktVWWliclpRQ2NSbFBQTjRKMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756803078),
('PpAwPnewn9xnAKzUEXTDuXxflt15qPfbgUFkFieI', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieVltUjR2aW4zTjM4U0w1SGdlMHFOdVJ0NElpUFZLYzlSdkRxdmQ3YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvbG9naW4/aWQ9NjIxNTJlN2QtM2UyYi00ZWIzLWEwZTUtNWQwY2I0M2M1MzJhJnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2ODAzMzIxMzAxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756803321),
('RkSVdtiDXzKSQAN26Qt2cwkHdSue08RE7kn74MMA', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamJDcDU3OWs5ODFhS2pid1lLeE84d3FoTmZ2ejdmTXA5endGV0g4eiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756801131),
('rULod7pFX0AxKNOqaSJlrXdHu0ZZjmVNRUFw25zH', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNFR6RlRFYWxycnRyRDBlVHdKZE1ubTR2UTRYT3pweVJXUE5iT0l6YSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05NzkxMTNlYS05NmYyLTQyNjctYWJhOC0xZWRiOGU3NWYxMjMmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTg0OTYzMDQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05NzkxMTNlYS05NmYyLTQyNjctYWJhOC0xZWRiOGU3NWYxMjMmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTg0OTYzMDQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756798500),
('Snoddm2KiBByv9tcPWrZc1Skpjyip1FBJUZz0Jcg', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazFDRzlPSGNVY29GcW1QdXJMVmJyY05JbXZRalVSeXcxdTF4VHVZeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756802301),
('VdhkfYNMHMsq6oL1d9HORXkIrh5FlioOIQQi5JmR', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidk1Yb2tLUVpDcHZzYzJIYWplMG81dFdNODE3SlFzcGdMdHhGaVd1bCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD1jMjEyNzYxOC00NTg5LTQ5NDgtOTNhNi1jMWY5NDY0MTU2MWYmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDA5NTQzMzciO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD1jMjEyNzYxOC00NTg5LTQ5NDgtOTNhNi1jMWY5NDY0MTU2MWYmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDA5NTQzMzciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756800954),
('vSNd3nW3lgk4TJSJvkWhhrcqKC2XlbDxfQLw8LlC', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHVSNXpIU21ZQVRwcTVGajluSlBvcDBXMkllYVlWNUFMcUl2em5QaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAwOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbG9naW4/aWQ9YjM1Yjc4ZTAtNjI0MS00YzcyLTlkZGItODdlOGY2N2E1ZDY1JnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2ODAyOTM5Mzg5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756802940),
('W75aHPMtlGtZjiHRSeEPaFwPaRU3UlT1tddK35xR', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieFZSVU1hVnNSVDBSaU5IbFF0dWcyNUpRTHFtN2d3UFZwd0NiSXp6ViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD02OWUxYTVkNy1iZjQwLTQ0ZjMtOWFlMS05ZDFkMTliNzU4NWUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDE0MzQ1OTciO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD02OWUxYTVkNy1iZjQwLTQ0ZjMtOWFlMS05ZDFkMTliNzU4NWUmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDE0MzQ1OTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756801435),
('WGadvheWKjo2AvCEGqtV7gTpsYIgSUfWDoFPx8rU', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUFhTDN4RldmWUNKUmlrV0o1U1hmcHRFS2t1TnZWd0MxMDZ6aFdRcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756798726),
('xkAzSb9ejy0wz92cpVFk6wajaYSBdQ16fiWmhuuE', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS1RFOEhtQWN6dkg0VGFhNnl6TlVBcktwQkJlNjA0b2xxdE05NkJKZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05Yzg0ZmFlNi0xN2QzLTQ4YjMtODliYi00NDE5ZmE2YzEwZTQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDIwNDMwMzUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD05Yzg0ZmFlNi0xN2QzLTQ4YjMtODliYi00NDE5ZmE2YzEwZTQmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY4MDIwNDMwMzUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756802043),
('xZfziEFbXM6zIOHYMRpVedn1ihanqX5mVEtmTltF', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMW4xbFgyM2FoNklFeWtDMFZzUWd5Zkp3T1ZGSXdob2ZSRmx4SFZrNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756798842),
('Y13dfNoa4Yy2DkEtnFdtbWMDYp4dzTNeLgJGGR6G', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYlplSm1EWWRoZlFXZHhieW1zRE1DZldaRWFGWEd5OUpvVWR5TERCeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD04ZjQ0OGQ3Ni0xYjk5LTQ4ZWItYTg1NC1mNDgyNDhlMGVhY2MmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTk3NTI2NzkiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxMjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rb250ZW4vYmVyaXRhL2NyZWF0ZT9pZD04ZjQ0OGQ3Ni0xYjk5LTQ4ZWItYTg1NC1mNDgyNDhlMGVhY2MmdnNjb2RlQnJvd3NlclJlcUlkPTE3NTY3OTk3NTI2NzkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756799753),
('yKH6DEAcC7Jq5XKP2gitPhvqROMAn63tvX2wBKYO', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlVtSm16NlljSk9rb3B0ZTZwZ1l2cHkxTjBKMHo3VWFvQnFBTEV6RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756801795),
('Z2gsQQMtjWkmPoSPZeeNNowYaZQ0vvS1MzF2lZNk', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3k5bDAxSVZ4SDdmNkJ6OXRpanJoOTlHWGg0djJ0QXFQVDZQekhQZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756802043);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `created_at`, `updated_at`) VALUES
(1, 'mail_mailer', 'smtp', 'string', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-02 20:41:23'),
(2, 'mail_host', 'smtp.gmail.com', 'string', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-02 20:41:23'),
(3, 'mail_port', '587', 'integer', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-09 06:38:19'),
(4, 'mail_username', 'budiaat2@gmail.com', 'string', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-09 06:48:20'),
(5, 'mail_password', 'mcujisjzukfkdxgu', 'string', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-09 06:57:58'),
(6, 'mail_encryption', 'tls', 'string', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-09 06:38:19'),
(7, 'mail_from_address', 'budiaat2@gmail.com', 'string', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-09 06:48:20'),
(8, 'mail_from_name', 'PUPR', 'string', 'mail', NULL, '2025-09-02 20:37:55', '2025-09-09 06:48:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur`
--

CREATE TABLE `struktur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(500) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `golongan` varchar(255) NOT NULL,
  `unit_kerja` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 99,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `status_keaktifan` enum('aktif','pensiun','mutasi','cuti_panjang') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `plt_status` enum('aktif','tidak_aktif','selesai') DEFAULT NULL,
  `memerlukan_plt` tinyint(1) NOT NULL DEFAULT 0,
  `plt_struktur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plt_nama_manual` varchar(255) DEFAULT NULL,
  `plt_jabatan_manual` varchar(255) DEFAULT NULL,
  `plt_asal_instansi` varchar(255) DEFAULT NULL,
  `plt_mulai` date DEFAULT NULL,
  `plt_selesai` date DEFAULT NULL,
  `plt_keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `instansi` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL COMMENT 'Rating 1-5',
  `ulasan` text NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `rating_detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rating_detail`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `avatar`, `last_login_at`, `status`, `permissions`, `password_changed_at`, `login_attempts`, `locked_until`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'budiaat25@gmail.com', NULL, 'avatars/aKigieSI7ko1b7nEabgJAf74wWqFuKklVeNMmB7H.jpg', '2025-09-15 01:59:01', 'active', '\"[\\\"manage_berita\\\",\\\"manage_program\\\",\\\"manage_layanan\\\",\\\"manage_pengaduan\\\",\\\"manage_galeri\\\",\\\"view_analytics\\\"]\"', '2025-09-15 01:58:28', 0, NULL, '2025-08-06 18:53:30', '$2y$12$IsIc1pbRA7ZNXAkO3HZimestuqGo5Oi5ZRjALyX.5.58BjmW9VPL6', 'super_admin', 'U0U5YWvPPeQfbXYbJJZachs1lymnwQXKa5HhAMu1JCGr53UDnbemTsccHTuO', '2025-08-06 18:53:30', '2025-09-15 01:59:01'),
(6, 'Admin PUPR Katingan', 'admin@pupr-katingan.go.id', NULL, 'avatars/0VJGKzLNwmrguPgXRaC6suWvQsNsbvmBUUGpqf55.png', '2025-09-09 07:25:17', 'active', NULL, '2025-09-09 02:13:01', 0, NULL, NULL, '$2y$12$B9CE7XHl4eRkQ8pIbimjHeCaLeuK2jNzJkt.If/27Sro2PGG79Rc6', 'admin', NULL, '2025-09-09 02:13:01', '2025-09-09 07:25:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `views` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_action_index` (`user_id`,`action`),
  ADD KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `activity_logs_created_at_index` (`created_at`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

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
-- Indeks untuk tabel `captcha_settings`
--
ALTER TABLE `captcha_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `captcha_settings_key_unique` (`key`);

--
-- Indeks untuk tabel `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_responded_by_foreign` (`responded_by`),
  ADD KEY `complaints_status_index` (`status`),
  ADD KEY `complaints_created_at_index` (`created_at`),
  ADD KEY `complaints_email_index` (`email`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `file_downloads`
--
ALTER TABLE `file_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_downloads_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `galeris`
--
ALTER TABLE `galeris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galeris_user_id_foreign` (`user_id`),
  ADD KEY `galeris_status_tipe_index` (`status`,`tipe`),
  ADD KEY `galeris_kategori_urutan_index` (`kategori`,`urutan`);

--
-- Indeks untuk tabel `galeri_news`
--
ALTER TABLE `galeri_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galeri_news_user_id_foreign` (`user_id`),
  ADD KEY `galeri_news_status_tipe_index` (`status`,`tipe`),
  ADD KEY `galeri_news_kategori_urutan_index` (`kategori`,`urutan`);

--
-- Indeks untuk tabel `konten_public`
--
ALTER TABLE `konten_public`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konten_public_tipe_status_index` (`tipe`,`status`),
  ADD KEY `konten_public_urutan_index` (`urutan`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_email_index` (`email`),
  ADD KEY `pengaduan_status_index` (`status`),
  ADD KEY `pengaduan_tanggal_pengaduan_index` (`tanggal_pengaduan`),
  ADD KEY `pengaduan_nomor_tiket_index` (`nomor_tiket`);

--
-- Indeks untuk tabel `pengaduan_histories`
--
ALTER TABLE `pengaduan_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_histories_pengaduan_id_created_at_index` (`pengaduan_id`,`created_at`);

--
-- Indeks untuk tabel `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profils_user_id_foreign` (`user_id`),
  ADD KEY `profils_status_index` (`status`);

--
-- Indeks untuk tabel `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `public_content_news`
--
ALTER TABLE `public_content_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `public_content_news_user_id_foreign` (`user_id`),
  ADD KEY `public_content_news_tipe_status_urutan_index` (`tipe`,`status`,`urutan`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`),
  ADD KEY `idx_sessions_user` (`user_id`),
  ADD KEY `idx_sessions_activity` (`last_activity`),
  ADD KEY `sessions_user_id_user_role_index` (`user_id`,`user_role`),
  ADD KEY `sessions_user_role_index` (`user_role`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `struktur`
--
ALTER TABLE `struktur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `struktur_jabatan_index` (`jabatan`),
  ADD KEY `struktur_unit_kerja_index` (`unit_kerja`),
  ADD KEY `struktur_urutan_index` (`urutan`),
  ADD KEY `struktur_status_index` (`status`),
  ADD KEY `struktur_plt_struktur_id_foreign` (`plt_struktur_id`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ulasan_rating_is_published_index` (`rating`,`is_published`),
  ADD KEY `ulasan_kategori_is_featured_index` (`kategori`,`is_featured`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `idx_users_role_verified` (`role`,`email_verified_at`),
  ADD KEY `idx_users_updated` (`updated_at`);

--
-- Indeks untuk tabel `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_user_id_foreign` (`user_id`),
  ADD KEY `videos_is_active_category_index` (`is_active`,`category`),
  ADD KEY `videos_views_created_at_index` (`views`,`created_at`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `captcha_settings`
--
ALTER TABLE `captcha_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `file_downloads`
--
ALTER TABLE `file_downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `galeris`
--
ALTER TABLE `galeris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `galeri_news`
--
ALTER TABLE `galeri_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `konten_public`
--
ALTER TABLE `konten_public`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `pengaduan_histories`
--
ALTER TABLE `pengaduan_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `profils`
--
ALTER TABLE `profils`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `program`
--
ALTER TABLE `program`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `public_content_news`
--
ALTER TABLE `public_content_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `struktur`
--
ALTER TABLE `struktur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_responded_by_foreign` FOREIGN KEY (`responded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `file_downloads`
--
ALTER TABLE `file_downloads`
  ADD CONSTRAINT `file_downloads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `galeris`
--
ALTER TABLE `galeris`
  ADD CONSTRAINT `galeris_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `galeri_news`
--
ALTER TABLE `galeri_news`
  ADD CONSTRAINT `galeri_news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengaduan_histories`
--
ALTER TABLE `pengaduan_histories`
  ADD CONSTRAINT `pengaduan_histories_pengaduan_id_foreign` FOREIGN KEY (`pengaduan_id`) REFERENCES `pengaduan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profils`
--
ALTER TABLE `profils`
  ADD CONSTRAINT `profils_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `public_content_news`
--
ALTER TABLE `public_content_news`
  ADD CONSTRAINT `public_content_news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `struktur`
--
ALTER TABLE `struktur`
  ADD CONSTRAINT `struktur_plt_struktur_id_foreign` FOREIGN KEY (`plt_struktur_id`) REFERENCES `struktur` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
