-- ============================================================
--  Comfort Foundation — database schema
--  MySQL 5.7+ / MariaDB 10.3+   utf8mb4
--  Import this file once via phpMyAdmin or:
--    mysql -u USER -p DBNAME < schema.sql
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------- admin users -------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(120)  NOT NULL,
  `email`         VARCHAR(190)  NOT NULL,
  `password_hash` VARCHAR(255)  NOT NULL,
  `role`          ENUM('admin','editor') NOT NULL DEFAULT 'editor',
  `last_login_at` DATETIME      NULL,
  `created_at`    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- editable site settings --------------------------
CREATE TABLE IF NOT EXISTS `settings` (
  `key_name`   VARCHAR(80)  NOT NULL,
  `value`      TEXT         NULL,
  `group_name` VARCHAR(40)  NOT NULL DEFAULT 'general',
  `label`      VARCHAR(160) NOT NULL DEFAULT '',
  `input_type` ENUM('text','textarea','url','email') NOT NULL DEFAULT 'text',
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- programmes (core business areas) ----------------
CREATE TABLE IF NOT EXISTS `programs` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug`       VARCHAR(160) NOT NULL,
  `number`     VARCHAR(8)   NOT NULL DEFAULT '',
  `title`      VARCHAR(190) NOT NULL,
  `icon`       VARCHAR(60)  NOT NULL DEFAULT 'icon-education',
  `summary`    TEXT         NULL,
  `body`       MEDIUMTEXT   NULL,
  `image`      VARCHAR(255) NULL,
  `goal_amount`   DECIMAL(12,2) NOT NULL DEFAULT 0,
  `raised_amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `is_published`  TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT          NOT NULL DEFAULT 0,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_programs_slug` (`slug`),
  KEY `ix_programs_pub` (`is_published`,`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- news / blog -------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(160) NOT NULL,
  `name` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `posts` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug`         VARCHAR(190) NOT NULL,
  `title`        VARCHAR(220) NOT NULL,
  `category_id`  INT UNSIGNED NULL,
  `author`       VARCHAR(120) NOT NULL DEFAULT 'Comfort Foundation',
  `excerpt`      TEXT         NULL,
  `body`         MEDIUMTEXT   NULL,
  `image`        VARCHAR(255) NULL,
  `published_at` DATE         NULL,
  `is_published` TINYINT(1)   NOT NULL DEFAULT 1,
  `views`        INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_posts_slug` (`slug`),
  KEY `ix_posts_pub` (`is_published`,`published_at`),
  KEY `ix_posts_cat` (`category_id`),
  CONSTRAINT `fk_posts_category` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- events ------------------------------------------
CREATE TABLE IF NOT EXISTS `events` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug`         VARCHAR(190) NOT NULL,
  `title`        VARCHAR(220) NOT NULL,
  `starts_at`    DATETIME     NULL,
  `ends_at`      DATETIME     NULL,
  `location`     VARCHAR(220) NULL,
  `excerpt`      TEXT         NULL,
  `body`         MEDIUMTEXT   NULL,
  `image`        VARCHAR(255) NULL,
  `is_published` TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_events_slug` (`slug`),
  KEY `ix_events_pub` (`is_published`,`starts_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- team --------------------------------------------
CREATE TABLE IF NOT EXISTS `team_members` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug`         VARCHAR(190) NOT NULL,
  `name`         VARCHAR(160) NOT NULL,
  `role_title`   VARCHAR(160) NOT NULL DEFAULT '',
  `bio`          MEDIUMTEXT   NULL,
  `image`        VARCHAR(255) NULL,
  `email`        VARCHAR(190) NULL,
  `phone`        VARCHAR(60)  NULL,
  `facebook`     VARCHAR(255) NULL,
  `twitter`      VARCHAR(255) NULL,
  `instagram`    VARCHAR(255) NULL,
  `linkedin`     VARCHAR(255) NULL,
  `is_published` TINYINT(1)   NOT NULL DEFAULT 1,
  `sort_order`   INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_team_slug` (`slug`),
  KEY `ix_team_pub` (`is_published`,`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- gallery -----------------------------------------
CREATE TABLE IF NOT EXISTS `gallery` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`      VARCHAR(190) NOT NULL DEFAULT '',
  `image`      VARCHAR(255) NOT NULL,
  `category`   VARCHAR(120) NOT NULL DEFAULT 'General',
  `sort_order` INT          NOT NULL DEFAULT 0,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ix_gallery_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- impact statistics -------------------------------
CREATE TABLE IF NOT EXISTS `impact_stats` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `label`      VARCHAR(160) NOT NULL,
  `value`      INT UNSIGNED NOT NULL DEFAULT 0,
  `suffix`     VARCHAR(12)  NOT NULL DEFAULT '+',
  `icon`       VARCHAR(60)  NOT NULL DEFAULT 'icon-support-heart',
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- partners / sponsors ------------------------------
CREATE TABLE IF NOT EXISTS `partners` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(190) NOT NULL,
  `logo`       VARCHAR(255) NULL,
  `website`    VARCHAR(255) NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- testimonials -------------------------------------
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author`     VARCHAR(160) NOT NULL,
  `role_title` VARCHAR(160) NOT NULL DEFAULT '',
  `quote`      TEXT         NOT NULL,
  `image`      VARCHAR(255) NULL,
  `rating`     TINYINT      NOT NULL DEFAULT 5,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- FAQ ----------------------------------------------
CREATE TABLE IF NOT EXISTS `faqs` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `question`   VARCHAR(255) NOT NULL,
  `answer`     TEXT         NOT NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- inbound submissions ------------------------------
CREATE TABLE IF NOT EXISTS `submissions` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kind`       ENUM('contact','volunteer','partner','pledge','newsletter') NOT NULL DEFAULT 'contact',
  `name`       VARCHAR(190) NOT NULL DEFAULT '',
  `email`      VARCHAR(190) NOT NULL DEFAULT '',
  `phone`      VARCHAR(60)  NOT NULL DEFAULT '',
  `subject`    VARCHAR(220) NOT NULL DEFAULT '',
  `message`    TEXT         NULL,
  `payload`    TEXT         NULL,
  `ip`         VARCHAR(45)  NOT NULL DEFAULT '',
  `is_read`    TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ix_sub_kind` (`kind`,`is_read`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
