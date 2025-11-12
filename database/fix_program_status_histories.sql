-- Fix untuk tabel program_status_histories yang hilang
-- Jalankan query ini di database hosting

-- Buat tabel program_status_histories
CREATE TABLE IF NOT EXISTS `program_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `status_lama` varchar(255) DEFAULT NULL,
  `status_baru` varchar(255) NOT NULL,
  `tanggal_perubahan` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `program_status_histories_program_id_foreign` (`program_id`),
  CONSTRAINT `program_status_histories_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tambahkan data history untuk program yang sudah ada
INSERT INTO `program_status_histories` (`program_id`, `status_lama`, `status_baru`, `tanggal_perubahan`, `keterangan`, `created_at`, `updated_at`)
SELECT
    `id` as program_id,
    NULL as status_lama,
    `status` as status_baru,
    COALESCE(`tanggal_mulai`, CURRENT_DATE) as tanggal_perubahan,
    'Status awal program' as keterangan,
    `created_at`,
    `updated_at`
FROM `programs`
WHERE NOT EXISTS (
    SELECT 1
    FROM `program_status_histories`
    WHERE `program_status_histories`.`program_id` = `programs`.`id`
);

-- Verifikasi data
SELECT COUNT(*) as total_histories FROM `program_status_histories`;
SELECT p.nama_program, psh.status_baru, psh.tanggal_perubahan
FROM `program_status_histories` psh
JOIN `programs` p ON p.id = psh.program_id
ORDER BY psh.tanggal_perubahan DESC
LIMIT 10;
