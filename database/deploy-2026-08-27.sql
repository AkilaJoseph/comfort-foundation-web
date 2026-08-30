-- ============================================================
--  Comfort Foundation — combined deploy migration
--  Generated 2026-08-30 — import ONCE via phpMyAdmin,
--  after uploading the new files. Re-running this will
--  duplicate the home_slides/core_values/approach_steps rows
--  (safe to clean up afterwards from the admin panel if that
--  happens, just avoid doing it on purpose).
-- ============================================================

-- ============================================================
--  Comfort Foundation — swap AI-generated placeholders for the
--  organisation's own photos (received 2026-08-26).
--  Safe to import after schema.sql + seed.sql. Idempotent: re-running
--  will not duplicate gallery rows or overwrite a since-customised
--  programme image with anything other than the same real photo.
-- ============================================================

SET NAMES utf8mb4;

-- ---------- programme cover photos -----------------------------
UPDATE `programs` SET `image` = 'uploads/media/cf-market-vendor-card.webp'
  WHERE `slug` = 'womens-economic-empowerment';
UPDATE `programs` SET `image` = 'uploads/media/cf-savings-group-training-card.webp'
  WHERE `slug` = 'positive-parenting-family-resilience';
UPDATE `programs` SET `image` = 'uploads/media/cf-children-learning-circle-card.webp'
  WHERE `slug` = 'childrens-mental-health-wellbeing';

-- ---------- gallery: real field photos ---------------------------
INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Tailoring & vocational training' AS title, 'uploads/media/cf-tailoring-workshop-card.webp' AS image, 'Economic Empowerment' AS category, 10 AS sort_order) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-tailoring-workshop-card.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Community farming group', 'uploads/media/cf-agriculture-training-group.webp', 'Economic Empowerment', 20) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-agriculture-training-group.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Agricultural livelihoods support', 'uploads/media/cf-cassava-farming.webp', 'Economic Empowerment', 30) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-cassava-farming.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Mother and daughter farming together', 'uploads/media/cf-mother-daughter-farming.webp', 'Economic Empowerment', 40) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-mother-daughter-farming.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Programme participant', 'uploads/media/cf-livelihoods-participant.webp', 'Economic Empowerment', 50) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-livelihoods-participant.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Savings group meeting', 'uploads/media/cf-savings-group-meeting-card.webp', 'Family & Parenting', 60) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-savings-group-meeting-card.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Caregiver support session', 'uploads/media/cf-savings-group-training-card.webp', 'Family & Parenting', 70) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-savings-group-training-card.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Community session participant', 'uploads/media/cf-savings-participant-portrait.webp', 'Family & Parenting', 80) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-savings-participant-portrait.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Nursery class', 'uploads/media/cf-children-learning-circle-card.webp', 'Children', 90) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-children-learning-circle-card.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'School supplies distribution day', 'uploads/media/cf-school-supplies-distribution.webp', 'Children', 100) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-school-supplies-distribution.webp');

INSERT INTO `gallery` (`title`, `image`, `category`, `sort_order`)
SELECT * FROM (SELECT 'Teacher certification day', 'uploads/media/cf-teacher-certification-day.webp', 'Children', 110) t
WHERE NOT EXISTS (SELECT 1 FROM `gallery` WHERE `image` = 'uploads/media/cf-teacher-certification-day.webp');

-- ============================================================
--  Comfort Foundation — admin-manageable home page content
--  Import after schema.sql + seed.sql (+ real_photos_update.sql).
--  Adds: hero banner slides, core values, approach steps, and a
--  handful of new "home" settings (heading text + collage photos)
--  so the whole home page can be edited from the admin panel
--  instead of being hardcoded in app/views/pages/home.php.
-- ============================================================

SET NAMES utf8mb4;

-- `settings.input_type` needs an `image` option for the new photo
-- fields below (fresh installs already get this from schema.sql).
ALTER TABLE `settings` MODIFY `input_type` ENUM('text','textarea','url','email','image') NOT NULL DEFAULT 'text';

-- ---------- hero banner slides --------------------------------
CREATE TABLE IF NOT EXISTS `home_slides` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `eyebrow`      VARCHAR(160) NOT NULL DEFAULT '',
  `title`        VARCHAR(255) NOT NULL,
  `image`        VARCHAR(255) NULL,
  `sort_order`   INT          NOT NULL DEFAULT 0,
  `is_published` TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `ix_home_slides_pub` (`is_published`,`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `home_slides` (`eyebrow`,`title`,`image`,`sort_order`) VALUES
('Women-centered community development', 'Equipping women. Strengthening <span class="bottom-line">families</span>. Protecting children.', 'uploads/media/cf-savings-group-meeting-wide.webp', 1),
('Economic empowerment', 'When a woman <span class="bottom-line">earns</span>, a whole household rises with her.', 'uploads/media/cf-market-vendor-wide.webp', 2),
('Children''s mental health', 'Every child deserves to grow up <span class="bottom-line">safe</span> and emotionally healthy.', 'uploads/media/cf-children-learning-circle-wide.webp', 3);

-- ---------- core values ("what guides us") ----------------------
CREATE TABLE IF NOT EXISTS `core_values` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon`       VARCHAR(60)  NOT NULL DEFAULT 'icon-donation',
  `title`      VARCHAR(120) NOT NULL,
  `text`       TEXT         NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `core_values` (`icon`,`title`,`text`,`sort_order`) VALUES
('icon-spread-love',   'Dignity',        'We uphold the worth and rights of every woman, girl, and child we serve.', 1),
('icon-support-heart', 'Resilience',     'We build lasting strength in individuals and communities.', 2),
('icon-fund',          'Integrity',      'We act with transparency and accountability in all we do.', 3),
('icon-donation',      'Women-Centered', 'Women''s voices, needs, and leadership are at the heart of everything.', 4),
('icon-health',        'Protection',     'We create safe, trusted environments for children and families.', 5),
('icon-heart-hand',    'Partnership',    'We grow through honest, trust-based collaboration at every level.', 6);

-- ---------- approach steps (Equip / Strengthen / Transform) ------
CREATE TABLE IF NOT EXISTS `approach_steps` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`      VARCHAR(80)  NOT NULL,
  `text`       TEXT         NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `approach_steps` (`title`,`text`,`sort_order`) VALUES
('Equip', 'We build practical economic and life skills by giving women the tools they need for financial independence. Through hands-on training, savings groups, and enterprise support, we equip women to earn, save, and grow.', 1),
('Strengthen', 'We strengthen families from within. Through parenting education, caregiver support, and father engagement, we build the knowledge and bonds that make families safe, stable, and resilient.', 2),
('Transform', 'We invest in children''s emotional futures. Through safe spaces, psychosocial support, and community mental health awareness, we help children grow up emotionally healthy, protected, and ready to lead.', 3);

-- ---------- new home settings (heading text + collage photos) ----
INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('home_who_heading', 'A women-centered NGO rooted in Mwanza', 'home', 'Who-we-are heading', 'text', 1),
('home_who_photo_top', 'uploads/media/help-thumb-top.webp', 'home', 'Who-we-are photo (top)', 'image', 2),
('home_who_photo_lg', 'uploads/media/help-thumb-lg.webp', 'home', 'Who-we-are photo (large)', 'image', 3),
('home_who_photo_bottom', 'uploads/media/help-thumb-bottom.webp', 'home', 'Who-we-are photo (bottom)', 'image', 4)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);
