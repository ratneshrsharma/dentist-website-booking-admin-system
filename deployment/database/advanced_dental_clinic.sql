-- ==============================================================================
-- Advanced Dental Clinic - Production Database SQL Dump (MySQL 8.0+)
-- Target Platform: Hostinger Shared Hosting (phpMyAdmin 1-Click Import)
-- Database Encoding: utf8mb4 / utf8mb4_unicode_ci
-- ==============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------------
-- Table structure for: clinics
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `clinics`;
CREATE TABLE `clinics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `clinics` (`id`, `name`, `slug`, `address`, `city`, `state`, `zip_code`, `phone`, `email`, `is_active`) VALUES
(1, 'Metro Dental Headquarters', 'metro-dental-hq', '100 Medical Center Parkway, Suite 400', 'New York', 'NY', '10001', '+1 (800) 555-DENT', 'hq@demo.ratneshsharma.com', 1),
(2, 'Downtown Smiles Surgical Suite', 'downtown-smiles-suite', '450 West 57th Street, Floor 12', 'New York', 'NY', '10019', '+1 (800) 555-3368', 'downtown@demo.ratneshsharma.com', 1),
(3, 'Westside Pediatric & Family Dental', 'westside-pediatric-family', '789 Amsterdam Avenue', 'New York', 'NY', '10025', '+1 (800) 555-0199', 'westside@demo.ratneshsharma.com', 1);

-- ------------------------------------------------------------------------------
-- Table structure for: users
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `clinic_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'patient',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default password is 'AdminPassword123!' (hashed with bcrypt)
INSERT INTO `users` (`id`, `clinic_id`, `name`, `email`, `password`, `role`, `is_active`) VALUES
(1, 1, 'Dr. Alexander Vance, DDS', 'admin@demo.ratneshsharma.com', '$2y$12$eU8QWzJ8R9L1sK3V5X7Z9eM3C5P7S9U1W3Y5A7C9E1G3I5K7M9O1Q', 'super_admin', 1),
(2, 1, 'Dr. Evelyn Vance, DMD', 'dr.vance@demo.ratneshsharma.com', '$2y$12$eU8QWzJ8R9L1sK3V5X7Z9eM3C5P7S9U1W3Y5A7C9E1G3I5K7M9O1Q', 'doctor', 1),
(3, 1, 'Dr. Marcus Sterling, DDS', 'dr.sterling@demo.ratneshsharma.com', '$2y$12$eU8QWzJ8R9L1sK3V5X7Z9eM3C5P7S9U1W3Y5A7C9E1G3I5K7M9O1Q', 'doctor', 1),
(4, 2, 'Dr. Sophia Reyes, DDS', 'dr.reyes@demo.ratneshsharma.com', '$2y$12$eU8QWzJ8R9L1sK3V5X7Z9eM3C5P7S9U1W3Y5A7C9E1G3I5K7M9O1Q', 'doctor', 1),
(5, 1, 'Clinical Front Desk Reception', 'reception@demo.ratneshsharma.com', '$2y$12$eU8QWzJ8R9L1sK3V5X7Z9eM3C5P7S9U1W3Y5A7C9E1G3I5K7M9O1Q', 'receptionist', 1);

-- ------------------------------------------------------------------------------
-- Table structure for: doctor_profiles
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `doctor_profiles`;
CREATE TABLE `doctor_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `specialty` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consultation_fee` decimal(10,2) NOT NULL DEFAULT '150.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `doctor_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `doctor_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `doctor_profiles` (`id`, `user_id`, `specialty`, `license_number`, `bio`, `avatar_url`, `consultation_fee`) VALUES
(1, 2, 'Prosthodontist & Oral Surgeon', 'DDS-NY-90214', 'Specializing in Computer-Guided Dental Implants, Full-Mouth Restorations, and 3D Cone Beam Surgical Guides.', 'https://images.unsplash.com/photo-1594824813589-4b68e9f2a0b1?w=400&h=400&fit=crop&crop=face', 180.00),
(2, 3, 'Endodontist & Restorative Specialist', 'DDS-NY-84192', 'Pioneering Microscopic Painless Root Canal Therapy, Apex Locators, and Bio-Ceramic Restorations.', 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=400&h=400&fit=crop&crop=face', 160.00),
(3, 4, 'Orthodontist & Aesthetic Dentist', 'DMD-NY-77319', 'Diamond Provider for Clear Aligners, Porcelain Veneers, and Digital Smile Makeovers.', 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&h=400&fit=crop&crop=face', 150.00);

-- ------------------------------------------------------------------------------
-- Table structure for: service_categories
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`) VALUES
(1, 'Dental Implants & Surgery', 'implants-surgery', 'Permanent titanium tooth restorations and computer guided surgical guides', 1, 1),
(2, 'Cosmetic Dentistry & Orthodontics', 'cosmetic-orthodontics', 'Porcelain veneers, clear aligners, and aesthetic smile transformations', 2, 1),
(3, 'Gum Care & Periodontics', 'gum-care-periodontics', 'Deep laser gum treatments, scaling, and periodontal regenerative care', 3, 1),
(4, 'General & Restorative Dentistry', 'general-restorative', 'Painless single-visit root canals, zirconia crowns, and restorative care', 4, 1);

-- ------------------------------------------------------------------------------
-- Table structure for: cms_treatments
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `cms_treatments`;
CREATE TABLE `cms_treatments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hero_image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `benefits` json DEFAULT NULL,
  `procedure_steps` json DEFAULT NULL,
  `faqs` json DEFAULT NULL,
  `duration` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '45 - 60 mins',
  `recovery_time` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Immediate to 24 hrs',
  `cost_estimate` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'From $499',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cms_treatments` (`id`, `title`, `slug`, `category`, `overview`, `hero_image`, `duration`, `recovery_time`, `cost_estimate`, `sort_order`) VALUES
(1, 'Dental Implants Overview', 'dental-implants', 'Dental Implants & Surgery', 'Biocompatible titanium fixtures replacing missing teeth with lifetime stability, natural bite ergonomics, and bone density preservation.', 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&h=700&fit=crop', '45 - 75 mins', '24 - 48 hrs', 'From $899', 1),
(2, 'Computer Guided Implant Surgery', 'computer-guided-implant-surgery', 'Dental Implants & Surgery', 'Sub-millimeter accuracy using 3D CBCT imaging and custom 3D-printed surgical stent guides for keyhole, flapless tooth replacement.', 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=1200&h=700&fit=crop', '60 mins', '24 - 48 hrs', 'From $1,199', 2),
(3, 'All-on-4 / All-on-6 Implants', 'all-on-4-dental-implants', 'Dental Implants & Surgery', 'Full-arch teeth replacement in a single day utilizing 4 to 6 strategically tilted implants supporting an immediate fixed aesthetic bridge.', 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=1200&h=700&fit=crop', '2 - 3 hrs', '3 - 5 days', 'From $4,999', 3),
(4, 'Clear Aligners & Invisible Braces', 'clear-aligners', 'Cosmetic Dentistry & Orthodontics', 'Virtually invisible, removable medical polyurethane aligners delivering gradual tooth realignment with zero dietary restrictions.', 'https://images.unsplash.com/photo-1571772996211-2f02c9727629?w=1200&h=700&fit=crop', '30 mins visit', 'None', 'From $1,799', 4),
(5, 'Porcelain Veneers & Lumineers', 'porcelain-veneers', 'Cosmetic Dentistry & Orthodontics', 'Ultra-thin, custom-crafted porcelain shells bonded to the front teeth to permanently correct discoloration, chips, gaps, and shape.', 'https://images.unsplash.com/photo-1609840114035-3c981b782dfe?w=1200&h=700&fit=crop', '2 visits (60 mins)', 'Immediate', 'From $799 / tooth', 5),
(6, 'Professional Laser Teeth Whitening', 'teeth-whitening', 'Cosmetic Dentistry & Orthodontics', 'Advanced dual-wavelength dental laser accelerating clinical-grade peroxide gel to lift up to 8 shades of staining in one 45-minute visit.', 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=1200&h=700&fit=crop', '45 mins', 'Immediate', 'From $299', 6),
(7, 'Painless Root Canal Treatment', 'root-canal-treatment', 'General & Restorative Dentistry', 'Gentle single-visit endodontic therapy utilizing rotary titanium files and 3D apex locators to eliminate infection while saving your natural tooth.', 'https://images.unsplash.com/photo-1629909615184-74f495363b67?w=1200&h=700&fit=crop', '45 - 60 mins', '12 - 24 hrs', 'From $399', 7),
(8, 'Zirconia Crowns & Bridges', 'crowns-and-bridges', 'General & Restorative Dentistry', 'Cad/Cam milled, metal-free translucent zirconia crowns offering maximum strength, biocompatibility, and identical shade matching.', 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?w=1200&h=700&fit=crop', '2 visits', 'None', 'From $549', 8);

-- ------------------------------------------------------------------------------
-- Table structure for: theme_settings
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `theme_settings`;
CREATE TABLE `theme_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'colors',
  `value` json NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `theme_settings_key_group_unique` (`key`,`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `theme_settings` (`id`, `key`, `group`, `value`, `description`) VALUES
(1, 'primary', 'colors', '{\"hex\": \"#0D9488\", \"label\": \"Clinical Teal\"}', 'Primary Brand Color for buttons and icons'),
(2, 'secondary', 'colors', '{\"hex\": \"#14B8A6\", \"label\": \"Mint Accent\"}', 'Secondary Accent Color for pills and badges'),
(3, 'accent', 'colors', '{\"hex\": \"#0284C7\", \"label\": \"Sky Clinical\"}', 'Highlight Accent Color for banners'),
(4, 'surface', 'colors', '{\"hex\": \"#FFFFFF\", \"label\": \"Pure Surface\"}', 'Card and panel surface background'),
(5, 'h1', 'typography', '{\"fontSize\": \"2.5rem\", \"fontWeight\": \"700\", \"lineHeight\": \"1.2\", \"textTransform\": \"none\"}', 'Typography for H1 hero titles'),
(6, 'h2', 'typography', '{\"fontSize\": \"2rem\", \"fontWeight\": \"700\", \"lineHeight\": \"1.25\", \"textTransform\": \"none\"}', 'Typography for H2 section titles'),
(7, 'p', 'typography', '{\"fontSize\": \"1rem\", \"fontWeight\": \"400\", \"lineHeight\": \"1.6\", \"textTransform\": \"none\"}', 'Typography for body paragraphs');

-- ------------------------------------------------------------------------------
-- Table structure for: seo_metadata
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `seo_metadata`;
CREATE TABLE `seo_metadata` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `entity_slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `entity_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'page',
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_card` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'summary_large_image',
  `robots_index` tinyint(1) NOT NULL DEFAULT '1',
  `robots_follow` tinyint(1) NOT NULL DEFAULT '1',
  `schema_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MedicalBusiness',
  `schema_json` json DEFAULT NULL,
  `custom_css` text COLLATE utf8mb4_unicode_ci,
  `custom_js_head` text COLLATE utf8mb4_unicode_ci,
  `custom_js_footer` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `seo_metadata` (`id`, `entity_slug`, `entity_type`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `og_title`, `og_description`, `og_image_url`, `twitter_card`, `robots_index`, `robots_follow`, `schema_type`) VALUES
(1, 'home', 'page', 'Advanced Dental Clinic | Dental Implants, Invisalign & Cosmetic Dentistry', 'Painless, sub-millimeter dental surgery, clear aligners, and hospital-grade sterilization adhering strictly to American dental standards.', 'dental clinic, dental implants, invisalign, painless root canal, cosmetic dentist', 'https://demo.ratneshsharma.com/advanced-dental-clinic/', 'Advanced Dental Clinic | Dental Implants & Cosmetic Dentistry', 'Painless, sub-millimeter dental surgery and cosmetic smile makeovers.', 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&h=630&fit=crop', 'summary_large_image', 1, 1, 'MedicalBusiness'),
(2, 'treatments', 'page', 'Clinical Procedures & Dental Treatments | Advanced Dental Clinic', 'Comprehensive clinical treatments including computer-guided dental implants, porcelain veneers, laser gum therapy, and root canals.', 'dental procedures, dental treatments, oral surgery, teeth cleaning, crowns', 'https://demo.ratneshsharma.com/advanced-dental-clinic/treatments', 'Clinical Procedures & Dental Treatments', 'Explore our comprehensive range of specialized dental care procedures.', 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=1200&h=630&fit=crop', 'summary_large_image', 1, 1, 'MedicalBusiness');

-- ------------------------------------------------------------------------------
-- Table structure for: seo_redirects
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `seo_redirects`;
CREATE TABLE `seo_redirects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `source_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `target_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_code` int NOT NULL DEFAULT '301',
  `hit_count` bigint unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `seo_redirects` (`id`, `source_url`, `target_url`, `status_code`, `hit_count`, `is_active`) VALUES
(1, '/services/dental-implants', '/treatments/dental-implants', 301, 14, 1),
(2, '/old-booking', '/contact', 302, 5, 1),
(3, '/discontinued-service', '/treatments', 410, 0, 1);

SET FOREIGN_KEY_CHECKS = 1;
