-- ============================================================
--  Comfort Foundation — the last hardcoded text lists, made
--  admin-manageable: who programmes serve, partnership types,
--  and expected long-term impact.
-- ============================================================

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `beneficiaries` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `text`       VARCHAR(255) NOT NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `beneficiaries` (`text`,`sort_order`) VALUES
('Women and girls (primary focus), particularly those facing economic vulnerability and limited access to opportunities', 1),
('Adolescent girls and young women aged 14–35 in vocational and leadership programmes', 2),
('Mothers and caregivers seeking parenting skills and family resilience support', 3),
('Children aged 0–18 receiving psychosocial and mental health support', 4),
('Community leaders, teachers, and local health workers as key programme partners', 5);

CREATE TABLE IF NOT EXISTS `partnership_types` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`      VARCHAR(160) NOT NULL,
  `text`       TEXT         NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `partnership_types` (`title`,`text`,`sort_order`) VALUES
('Government Agencies', 'Ministry of Health, Ministry of Community Development, Gender and Social Welfare, and local government authorities — aligning our programmes with national priorities.', 1),
('Schools & Health Facilities', 'Delivering programmes where communities already gather and already trust.', 2),
('NGOs & Civil Society', 'Collaborating to reduce duplication and amplify collective impact.', 3),
('International Development Partners', 'Seeking grants and technical support from aligned foundations and bilateral agencies.', 4),
('Private Sector', 'Engaging businesses in livelihood training, market linkages, and co-funding.', 5);

CREATE TABLE IF NOT EXISTS `long_term_impact` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `text`       VARCHAR(255) NOT NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `long_term_impact` (`text`,`sort_order`) VALUES
('Thousands of women and girls with sustainable livelihoods, income, and financial independence.', 1),
('Families equipped with parenting knowledge and support systems that reduce stress and strengthen bonds.', 2),
('Children growing up with access to emotional support, safe spaces, and positive mental health.', 3),
('Communities where women are recognised as economic leaders and agents of family and social change.', 4),
('A replicable, women-centered model for integrated community development across Tanzania.', 5);
