-- Kyrgyzstan Tourism Platform Database Schema
-- Compatible with MySQL 8.0+ / MariaDB 10.6+
-- Character Set: utf8mb4 (Full Unicode support including Emoji)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `kg_tourism_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `kg_tourism_db`;

-- --------------------------------------------------------
-- 1. USERS & AUTHENTICATION
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('user', 'admin', 'manager') DEFAULT 'user',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 2. REGIONS & LOCATIONS
-- --------------------------------------------------------

CREATE TABLE `regions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ru` VARCHAR(100) NOT NULL,
  `name_en` VARCHAR(100) NOT NULL,
  `name_kg` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `description_ru` TEXT,
  `description_en` TEXT,
  `description_kg` TEXT,
  `cover_image` VARCHAR(255) DEFAULT NULL,
  `latitude` DECIMAL(10, 8) DEFAULT NULL,
  `longitude` DECIMAL(11, 8) DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 3. ATTRACTIONS (Points of Interest)
-- --------------------------------------------------------

CREATE TABLE `attractions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `region_id` INT UNSIGNED NOT NULL,
  `name_ru` VARCHAR(150) NOT NULL,
  `name_en` VARCHAR(150) NOT NULL,
  `name_kg` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `description_ru` TEXT,
  `description_en` TEXT,
  `description_kg` TEXT,
  `type` ENUM('nature', 'historical', 'cultural', 'activity') DEFAULT 'nature',
  `latitude` DECIMAL(10, 8) NOT NULL,
  `longitude` DECIMAL(11, 8) NOT NULL,
  `rating` DECIMAL(3, 2) DEFAULT 0.00,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`region_id`) REFERENCES `regions`(`id`) ON DELETE CASCADE,
  INDEX `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 4. TOURS SYSTEM
-- --------------------------------------------------------

CREATE TABLE `tours` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_ru` VARCHAR(200) NOT NULL,
  `title_en` VARCHAR(200) NOT NULL,
  `title_kg` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `short_description_ru` VARCHAR(255),
  `short_description_en` VARCHAR(255),
  `short_description_kg` VARCHAR(255),
  `full_description_ru` LONGTEXT,
  `full_description_en` LONGTEXT,
  `full_description_kg` LONGTEXT,
  `price_from` DECIMAL(10, 2) NOT NULL,
  `currency` CHAR(3) DEFAULT 'USD',
  `duration_days` SMALLINT UNSIGNED NOT NULL,
  `difficulty` ENUM('easy', 'moderate', 'hard', 'extreme') DEFAULT 'moderate',
  `category` ENUM('adventure', 'cultural', 'family', 'luxury', 'eco') DEFAULT 'adventure',
  `includes_info` TEXT COMMENT 'JSON or formatted text about what is included',
  `excludes_info` TEXT,
  `itinerary` LONGTEXT COMMENT 'JSON structure for day-by-day plan',
  `max_group_size` SMALLINT DEFAULT 10,
  `is_featured` TINYINT(1) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `views_count` INT UNSIGNED DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_category` (`category`),
  INDEX `idx_price` (`price_from`),
  INDEX `idx_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Связь туров с регионами (Many-to-Many)
CREATE TABLE `tour_regions` (
  `tour_id` INT UNSIGNED NOT NULL,
  `region_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`tour_id`, `region_id`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`region_id`) REFERENCES `regions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Галерея туров
CREATE TABLE `tour_images` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tour_id` INT UNSIGNED NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `alt_text` VARCHAR(255),
  `is_main` TINYINT(1) DEFAULT 0,
  `sort_order` INT DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. BOOKINGS
-- --------------------------------------------------------

CREATE TABLE `bookings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tour_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED DEFAULT NULL, -- Null for guest bookings
  `guest_name` VARCHAR(100) NOT NULL,
  `guest_email` VARCHAR(150) NOT NULL,
  `guest_phone` VARCHAR(20) NOT NULL,
  `travel_date` DATE NOT NULL,
  `participants_count` SMALLINT UNSIGNED NOT NULL,
  `total_price` DECIMAL(10, 2) NOT NULL,
  `status` ENUM('pending', 'confirmed', 'paid', 'cancelled', 'completed') DEFAULT 'pending',
  `special_requests` TEXT,
  `payment_intent_id` VARCHAR(100) DEFAULT NULL COMMENT 'For Stripe/Payment gateway integration',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  INDEX `idx_status` (`status`),
  INDEX `idx_date` (`travel_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 6. AUDIO GUIDES
-- --------------------------------------------------------

CREATE TABLE `audio_guides` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `attraction_id` INT UNSIGNED DEFAULT NULL, -- Optional link to attraction
  `title_ru` VARCHAR(150) NOT NULL,
  `title_en` VARCHAR(150) NOT NULL,
  `title_kg` VARCHAR(150) NOT NULL,
  `audio_file` VARCHAR(255) NOT NULL,
  `duration_seconds` INT UNSIGNED,
  `language` ENUM('ru', 'en', 'kg') NOT NULL,
  `transcript_ru` TEXT,
  `transcript_en` TEXT,
  `transcript_kg` TEXT,
  `download_count` INT UNSIGNED DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`attraction_id`) REFERENCES `attractions`(`id`) ON DELETE SET NULL,
  INDEX `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. REVIEWS
-- --------------------------------------------------------

CREATE TABLE `reviews` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tour_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `user_name` VARCHAR(100) NOT NULL, -- Stored if user is not registered
  `rating` TINYINT UNSIGNED NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `comment` TEXT NOT NULL,
  `photos` JSON DEFAULT NULL COMMENT 'Array of image paths',
  `is_approved` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE,
  INDEX `idx_approved` (`is_approved`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 8. FAVORITES
-- --------------------------------------------------------

CREATE TABLE `favorites` (
  `user_id` INT UNSIGNED NOT NULL,
  `tour_id` INT UNSIGNED NOT NULL,
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `tour_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 9. BLOG / STORIES
-- --------------------------------------------------------

CREATE TABLE `blog_posts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_ru` VARCHAR(200) NOT NULL,
  `title_en` VARCHAR(200) NOT NULL,
  `title_kg` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `content_ru` LONGTEXT,
  `content_en` LONGTEXT,
  `content_kg` LONGTEXT,
  `cover_image` VARCHAR(255),
  `author_id` INT UNSIGNED NOT NULL,
  `published_at` TIMESTAMP NULL DEFAULT NULL,
  `is_published` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_published` (`is_published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 10. SETTINGS & SLIDERS
-- --------------------------------------------------------

CREATE TABLE `settings` (
  `key_name` VARCHAR(50) NOT NULL,
  `value` TEXT,
  `type` ENUM('string', 'boolean', 'json', 'image') DEFAULT 'string',
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`key_name`, `value`, `type`) VALUES
('site_title', 'Discover Kyrgyzstan', 'string'),
('hero_video_url', '/assets/videos/hero-mountains.mp4', 'string'),
('contact_email', 'info@visitkg.com', 'string'),
('social_instagram', 'https://instagram.com/visitkg', 'string');

CREATE TABLE `sliders` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_ru` VARCHAR(100),
  `title_en` VARCHAR(100),
  `image_path` VARCHAR(255) NOT NULL,
  `link_url` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
