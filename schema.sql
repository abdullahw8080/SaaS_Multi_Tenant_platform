-- MySQL Database Schema for SaaS Multi-Tenant Portfolio Platform

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `site_references`;
DROP TABLE IF EXISTS `languages`;
DROP TABLE IF EXISTS `project_media`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `skills`;
DROP TABLE IF EXISTS `experiences`;
DROP TABLE IF EXISTS `education`;
DROP TABLE IF EXISTS `certificates`;
DROP TABLE IF EXISTS `social_links`;
DROP TABLE IF EXISTS `profiles`;
DROP TABLE IF EXISTS `section_items`;
DROP TABLE IF EXISTS `site_sections`;
DROP TABLE IF EXISTS `section_types`;
DROP TABLE IF EXISTS `sites`;
DROP TABLE IF EXISTS `templates`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Users Table
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `phone` VARCHAR(50) NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'client') NOT NULL DEFAULT 'client',
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Templates Table
CREATE TABLE `templates` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(100) NOT NULL, -- e.g. 'developer', 'doctor', 'company', 'engineer', 'teacher', 'manager', 'student'
    `preview_image` VARCHAR(255) NULL,
    `folder_name` VARCHAR(100) NOT NULL UNIQUE,
    `default_sections` JSON NULL,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Sites Table
CREATE TABLE `sites` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `template_id` INT NOT NULL,
    `custom_domain` VARCHAR(255) NULL,
    `theme_settings` JSON NULL,
    `is_published` TINYINT(1) DEFAULT 0,
    `approval_status` ENUM('pending', 'draft', 'under_review', 'approved', 'rejected') NOT NULL DEFAULT 'draft',
    `rejection_reason` TEXT NULL,
    `default_lang` ENUM('ar', 'en') DEFAULT 'ar',
    `is_bilingual` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_sites_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sites_templates` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Profiles Table (One profile per site)
CREATE TABLE `profiles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL UNIQUE,
    `full_name` VARCHAR(255) NOT NULL,
    `full_name_en` VARCHAR(255) NULL,
    `photo` VARCHAR(255) NULL,
    `bio` TEXT NULL,
    `bio_en` TEXT NULL,
    `title` VARCHAR(255) NULL,
    `title_en` VARCHAR(255) NULL,
    `cv_url` VARCHAR(255) NULL,
    `references_text` TEXT NULL,
    `references_text_en` TEXT NULL,
    CONSTRAINT `fk_profiles_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Social Links Table
CREATE TABLE `social_links` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `platform` VARCHAR(50) NOT NULL, -- e.g., 'facebook', 'twitter', 'github', 'linkedin', 'instagram', 'youtube', 'email', 'phone'
    `url` VARCHAR(255) NOT NULL,
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_social_links_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Section Types Table
CREATE TABLE `section_types` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(50) NOT NULL UNIQUE, -- e.g. 'skills', 'projects', 'experiences', 'education', 'certificates', 'services', 'team_members'
    `name` VARCHAR(100) NOT NULL,
    `icon` VARCHAR(50) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Site Sections Table
CREATE TABLE `site_sections` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `section_type_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL, -- Custom title in Arabic
    `title_en` VARCHAR(255) NULL, -- Custom title in English
    `sort_order` INT DEFAULT 0,
    `is_visible` TINYINT(1) DEFAULT 1,
    CONSTRAINT `fk_site_sections_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_site_sections_types` FOREIGN KEY (`section_type_id`) REFERENCES `section_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Section Items Table (Generic key-value storage for custom section details)
CREATE TABLE `section_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `section_id` INT NOT NULL,
    `field_key` VARCHAR(100) NOT NULL,
    `field_value` TEXT NULL,
    `field_value_en` TEXT NULL,
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_section_items_sections` FOREIGN KEY (`section_id`) REFERENCES `site_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Skills Table
CREATE TABLE `skills` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `name_en` VARCHAR(100) NULL,
    `level` INT NOT NULL DEFAULT 100, -- 1 to 100 percentage
    `type` ENUM('technical', 'personal') NOT NULL DEFAULT 'technical',
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_skills_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Projects Table
CREATE TABLE `projects` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `title_en` VARCHAR(255) NULL,
    `summary` TEXT NULL,
    `summary_en` TEXT NULL,
    `body` LONGTEXT NULL,
    `body_en` LONGTEXT NULL,
    `cover_image` VARCHAR(255) NULL,
    `link` VARCHAR(255) NULL,
    `github_link` VARCHAR(255) NULL,
    `type` ENUM('project', 'research', 'case_study') NOT NULL DEFAULT 'project',
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_projects_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `site_project_slug` (`site_id`, `slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Project Media Table (For gallery and document uploads per project)
CREATE TABLE `project_media` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_type` ENUM('image', 'pdf', 'video_url') NOT NULL DEFAULT 'image',
    `caption` VARCHAR(255) NULL,
    `caption_en` VARCHAR(255) NULL,
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_project_media_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Experiences Table
CREATE TABLE `experiences` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `position` VARCHAR(255) NOT NULL,
    `position_en` VARCHAR(255) NULL,
    `company` VARCHAR(255) NOT NULL,
    `company_en` VARCHAR(255) NULL,
    `start_date` VARCHAR(50) NULL,
    `end_date` VARCHAR(50) NULL,
    `description` TEXT NULL,
    `description_en` TEXT NULL,
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_experiences_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Education Table
CREATE TABLE `education` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `degree` VARCHAR(255) NOT NULL,
    `degree_en` VARCHAR(255) NULL,
    `institution` VARCHAR(255) NOT NULL,
    `institution_en` VARCHAR(255) NULL,
    `year` VARCHAR(50) NULL,
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_education_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Certificates Table
CREATE TABLE `certificates` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `title_en` VARCHAR(255) NULL,
    `issuer` VARCHAR(255) NOT NULL,
    `issuer_en` VARCHAR(255) NULL,
    `file_url` VARCHAR(255) NULL,
    `link` VARCHAR(500) NULL,
    `year` VARCHAR(50) NULL,
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_certificates_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Languages Table
CREATE TABLE `languages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `name_en` VARCHAR(100) NULL,
    `level` VARCHAR(100) NOT NULL, -- e.g. 'اللغة الأم', 'جيد جداً'
    `level_en` VARCHAR(100) NULL,
    `percentage` INT NOT NULL DEFAULT 100, -- e.g. 100, 75
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_languages_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Site References Table
CREATE TABLE `site_references` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `site_id` INT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `name_en` VARCHAR(255) NULL,
    `photo` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `description_en` TEXT NULL,
    `phone` VARCHAR(50) NULL,
    `email` VARCHAR(255) NULL,
    `sort_order` INT DEFAULT 0,
    CONSTRAINT `fk_site_references_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- SEED DATA
-- ==========================================

-- Seed Templates
INSERT INTO `templates` (`id`, `name`, `category`, `folder_name`, `default_sections`, `is_active`) VALUES
(1, 'Developer Dark', 'developer', 'template-developer', '["skills", "projects", "experiences", "education", "certificates", "languages"]', 1),
(2, 'Doctor Clean', 'doctor', 'template-doctor', '["services", "experiences", "education", "certificates"]', 1),
(3, 'Corporate Company', 'company', 'template-company', '["services", "projects", "team_members"]', 1);

-- Seed Section Types
INSERT INTO `section_types` (`id`, `key`, `name`, `icon`) VALUES
(1, 'skills', 'المهارات', 'fa-code'),
(2, 'projects', 'المشاريع والأعمال', 'fa-briefcase'),
(3, 'experiences', 'الخبرات المهنية', 'fa-history'),
(4, 'education', 'التعليم والمؤهلات', 'fa-graduation-cap'),
(5, 'certificates', 'الشهادات والاعتمادات', 'fa-certificate'),
(6, 'services', 'الخدمات', 'fa-cogs'),
(7, 'team_members', 'فريق العمل', 'fa-users'),
(8, 'languages', 'اللغات', 'fa-language');

-- Seed Admin User
-- Email: admin@portfolio.com
-- Password: admin123 (hashed with BCRYPT)
INSERT INTO `users` (`id`, `email`, `password_hash`, `role`, `status`) VALUES
(1, 'admin@portfolio.com', '$2y$10$HViaEUYnsteKjD2AxTjG/OWa84L/b4piobdSzZVH4NkZZrfoPLqZy', 'admin', 'active');

// ✅ CHECKPOINT: schema.sql — COMPLETE (المرحلة 1 من 8)
// التالي: app/Core/Database.php
