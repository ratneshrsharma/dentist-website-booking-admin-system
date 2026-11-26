-- =============================================================================
-- Acocks Green Dental Practice / Dental SaaS CRM - Incremental DB Migration
-- Target Database: u499464314_dental_crm (MySQL 8.0 / MariaDB 10.4+)
-- Purpose: Safely upgrade an existing live database to the latest schema
--          WITHOUT dropping or overwriting existing clinic, booking, or user data.
-- Usage:   In phpMyAdmin, select your existing database (u499464314_dental_crm),
--          open the "Import" tab, choose this file, and click "Go".
-- =============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- -----------------------------------------------------------------------------
-- 1. Safely add new columns to `users` (if they do not already exist)
-- -----------------------------------------------------------------------------
SET @db := DATABASE();

SET @col := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'users' AND COLUMN_NAME = 'doctor_id');
SET @sql := IF(@col = 0, 'ALTER TABLE `users` ADD COLUMN `doctor_id` INT DEFAULT NULL AFTER `role`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'users' AND COLUMN_NAME = 'use_custom_permissions');
SET @sql := IF(@col = 0, 'ALTER TABLE `users` ADD COLUMN `use_custom_permissions` TINYINT(1) NOT NULL DEFAULT 0 AFTER `doctor_id`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'users' AND COLUMN_NAME = 'custom_permissions_json');
SET @sql := IF(@col = 0, 'ALTER TABLE `users` ADD COLUMN `custom_permissions_json` LONGTEXT DEFAULT NULL AFTER `use_custom_permissions`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Link default Doctor demo user to doctor_id = 1 if present and unlinked
UPDATE `users` SET `doctor_id` = 1 WHERE `user_key` = 'USR_DOCTOR_005' AND `doctor_id` IS NULL;

-- Insert any missing default role users without overwriting existing live users
INSERT IGNORE INTO `users` (`user_key`, `clinic_id`, `name`, `email`, `mobile`, `password`, `role_key`, `role`, `doctor_id`, `is_active`) VALUES
('USR_SUPERADMIN_001', 1, 'Ratnesh Sharma', 'admin@example.com', '+919904379260', '$2y$10$R9kkYF0dBqZNK0QAEFUHsukgIyx0l4bUylqhdUObrfhbJzXABYjDe', 'super_admin', 'Super Admin', NULL, 1),
('USR_ADMIN_002', 1, 'Practice Admin (Demo)', 'admin.test@example.com', '+44 7700 900101', '$2y$10$Wo5jD0oS3SVaBwbsPdpHy./5u.hRkwMX1pYdARTyvj7OcOyH4viU.', 'admin', 'Admin', NULL, 1),
('USR_WEBMGR_003', 1, 'Website Manager (Demo)', 'webmanager.test@example.com', '+44 7700 900102', '$2y$10$Wo5jD0oS3SVaBwbsPdpHy./5u.hRkwMX1pYdARTyvj7OcOyH4viU.', 'website_manager', 'Website Manager', NULL, 1),
('USR_RECEPT_004', 1, 'Receptionist (Demo)', 'receptionist.test@example.com', '+44 7700 900103', '$2y$10$Wo5jD0oS3SVaBwbsPdpHy./5u.hRkwMX1pYdARTyvj7OcOyH4viU.', 'receptionist', 'Receptionist', NULL, 1),
('USR_DOCTOR_005', 1, 'Dr. Atandrilla Das (Demo)', 'doctor.test@example.com', '+44 7700 900104', '$2y$10$Wo5jD0oS3SVaBwbsPdpHy./5u.hRkwMX1pYdARTyvj7OcOyH4viU.', 'doctor', 'Doctor', 1, 1),
('USR_ACCOUNT_006', 1, 'Clinic Accountant (Demo)', 'accountant.test@example.com', '+44 7700 900105', '$2y$10$Wo5jD0oS3SVaBwbsPdpHy./5u.hRkwMX1pYdARTyvj7OcOyH4viU.', 'accountant', 'Accountant', NULL, 1);

-- -----------------------------------------------------------------------------
-- 2. Create `roles` table (Granular Role Management & RBAC Matrix)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles` (
  `role_key` VARCHAR(60) NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `is_system` TINYINT(1) NOT NULL DEFAULT 0,
  `permissions_json` LONGTEXT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `roles` (`role_key`, `label`, `is_system`, `permissions_json`) VALUES
('super_admin', 'Super Admin', 1, '{"bookings":{"view":true,"add":true,"edit":true,"delete":true},"doctors_availability":{"view":true,"add":true,"edit":true,"delete":true},"patients":{"view":true,"add":true,"edit":true,"delete":true},"accounts":{"view":true,"add":true,"edit":true,"delete":true},"cms_pages":{"view":true,"add":true,"edit":true,"delete":true},"cms_components":{"view":true,"add":true,"edit":true,"delete":true},"blog":{"view":true,"add":true,"edit":true,"delete":true},"contact_submissions":{"view":true,"add":true,"edit":true,"delete":true},"chat_logs":{"view":true,"add":true,"edit":true,"delete":true},"theme":{"view":true,"add":true,"edit":true,"delete":true},"settings":{"view":true,"add":true,"edit":true,"delete":true},"users":{"view":true,"add":true,"edit":true,"delete":true},"roles":{"view":true,"add":true,"edit":true,"delete":true}}'),
('admin', 'Admin', 1, '{"bookings":{"view":true,"add":true,"edit":true,"delete":true},"doctors_availability":{"view":true,"add":true,"edit":true,"delete":true},"patients":{"view":true,"add":true,"edit":true,"delete":true},"accounts":{"view":true,"add":true,"edit":true,"delete":true},"cms_pages":{"view":true,"add":true,"edit":true,"delete":true},"cms_components":{"view":true,"add":true,"edit":true,"delete":true},"blog":{"view":true,"add":true,"edit":true,"delete":true},"contact_submissions":{"view":true,"add":true,"edit":true,"delete":true},"chat_logs":{"view":true,"add":true,"edit":true,"delete":true},"theme":{"view":true,"add":true,"edit":true,"delete":true},"settings":{"view":true,"add":true,"edit":true,"delete":true},"users":{"view":true,"add":true,"edit":true,"delete":true},"roles":{"view":true,"add":false,"edit":true,"delete":false}}'),
('website_manager', 'Website Manager', 1, '{"cms_pages":{"view":true,"add":true,"edit":true,"delete":true},"cms_components":{"view":true,"add":true,"edit":true,"delete":true},"blog":{"view":true,"add":true,"edit":true,"delete":true},"contact_submissions":{"view":true,"add":false,"edit":true,"delete":true},"theme":{"view":true,"add":false,"edit":true,"delete":false}}'),
('receptionist', 'Receptionist', 1, '{"bookings":{"view":true,"add":true,"edit":true,"delete":false},"doctors_availability":{"view":true,"add":false,"edit":true,"delete":false},"patients":{"view":true,"add":true,"edit":true,"delete":false},"contact_submissions":{"view":true,"add":false,"edit":true,"delete":false},"chat_logs":{"view":true,"add":false,"edit":false,"delete":false}}'),
('doctor', 'Doctor', 1, '{"bookings":{"view":true,"add":false,"edit":true,"delete":false},"doctors_availability":{"view":true,"add":false,"edit":true,"delete":false}}'),
('accountant', 'Accountant', 1, '{"accounts":{"view":true,"add":true,"edit":true,"delete":true},"settings":{"view":true,"add":false,"edit":false,"delete":false}}');

-- -----------------------------------------------------------------------------
-- 3. Create `patients` table (Patients Management CRUD)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `patients` (
  `patient_key` VARCHAR(64) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(60) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `dob` VARCHAR(32) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `registration_status` VARCHAR(32) DEFAULT 'new',
  `clinical_notes` TEXT DEFAULT NULL,
  `treatment_records_json` LONGTEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`patient_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 4. Create `invoices` table (Accounts & Password-Protected Billing Web View)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` VARCHAR(64) NOT NULL,
  `invoice_no` VARCHAR(64) NOT NULL,
  `patient_key` VARCHAR(64) DEFAULT NULL,
  `patient_name` VARCHAR(255) NOT NULL,
  `patient_phone` VARCHAR(60) NOT NULL,
  `patient_email` VARCHAR(255) DEFAULT NULL,
  `treatment` VARCHAR(255) DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `paid_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` VARCHAR(60) DEFAULT 'Card',
  `payment_status` VARCHAR(40) DEFAULT 'Paid',
  `invoice_date` DATE DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `items_json` LONGTEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_no_unique` (`invoice_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `invoices` (`id`, `invoice_no`, `patient_key`, `patient_name`, `patient_phone`, `patient_email`, `treatment`, `total_amount`, `paid_amount`, `payment_method`, `payment_status`, `invoice_date`, `notes`, `items_json`) VALUES
('inv_seed_1001', 'INV-2026-1001', 'PAT_DEMO_001', 'Sarah Jenkins', '+44 7700 900123', 'sarah.jenkins@example.co.uk', 'Dental Hygiene & Airflow Polish', 65.00, 65.00, 'Card', 'Paid', '2026-11-19', 'Paid at reception desk.', '[{"description":"Dental Hygiene & Airflow Polish (45 mins)","amount":65}]'),
('inv_seed_1002', 'INV-2026-1002', 'PAT_DEMO_001', 'Sarah Jenkins', '+44 7700 900123', 'sarah.jenkins@example.co.uk', 'White Tooth Fillings (Composite)', 95.00, 45.00, 'Card', 'Partial', '2026-11-26', 'Deposit £45 paid; £50 remaining.', '[{"description":"White Composite Restoration (UR4)","amount":95}]');

-- -----------------------------------------------------------------------------
-- 5. Create `blog_categories`, `blog_tags`, `blog_posts` (if missing)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` VARCHAR(64) NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `slug` VARCHAR(191) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_cats_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog_tags` (
  `id` VARCHAR(64) NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `slug` VARCHAR(191) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` VARCHAR(64) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(191) NOT NULL,
  `status` VARCHAR(32) NOT NULL DEFAULT 'published',
  `published_at` VARCHAR(40) DEFAULT NULL,
  `author` VARCHAR(191) DEFAULT NULL,
  `featured_image` VARCHAR(500) DEFAULT NULL,
  `featured_image_alt` VARCHAR(255) DEFAULT NULL,
  `excerpt` TEXT DEFAULT NULL,
  `content` LONGTEXT DEFAULT NULL,
  `meta_json` LONGTEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 6. Create `contact_submissions`, `assistant_chat_logs`, `activity_logs` (if missing)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_submissions` (
  `id` VARCHAR(64) NOT NULL,
  `reference` VARCHAR(64) NOT NULL,
  `patient_status` VARCHAR(40) DEFAULT 'new',
  `full_name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(60) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `service_required` VARCHAR(255) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `status` VARCHAR(40) NOT NULL DEFAULT 'new',
  `raw_json` LONGTEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `assistant_chat_logs` (
  `session_id` VARCHAR(80) NOT NULL,
  `visitor_name` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(60) DEFAULT NULL,
  `service_interest` VARCHAR(255) DEFAULT NULL,
  `booking_reference` VARCHAR(64) DEFAULT NULL,
  `messages_json` LONGTEXT DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` VARCHAR(64) NOT NULL,
  `user_key` VARCHAR(64) NOT NULL,
  `user_name` VARCHAR(255) DEFAULT NULL,
  `role_key` VARCHAR(60) DEFAULT NULL,
  `module` VARCHAR(100) DEFAULT NULL,
  `action` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(32) DEFAULT 'Success',
  `details_json` LONGTEXT DEFAULT NULL,
  `ip` VARCHAR(64) DEFAULT NULL,
  `created_at` VARCHAR(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
