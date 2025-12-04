-- Users Table untuk Admin dan Seniman
CREATE TABLE IF NOT EXISTS `users` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `role` enum('admin','seniman') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'seniman',
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Admin User
-- Email: admin@sumbawa.com
-- Password: Admin123!
-- Password Hash: $2y$10$DaQpWlKqVp.LqU0.EjH0Xu2qN2BNV.5Z3c1N5Z3c1N5Z3c1N5Z3c1
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_active`, `created_at`) VALUES
(1, 'Administrator', 'admin@sumbawa.com', '$2y$10$DaQpWlKqVp.LqU0.EjH0Xu2qN2BNV.5Z3c1N5Z3c1N5Z3c1N5Z3c1', 'admin', 1, NOW());

-- Sessions Table (untuk Laravel sessions)
CREATE TABLE IF NOT EXISTS `sessions` (
    `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id` bigint unsigned DEFAULT NULL,
    `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_agent` text COLLATE utf8mb4_unicode_ci,
    `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_activity` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DB_CONNECTION=mysql
-- DB_HOST=127.0.0.1
-- DB_PORT=3306
-- DB_DATABASE=gallery_sumbawa
-- DB_USERNAME=root
-- DB_PASSWORD=
