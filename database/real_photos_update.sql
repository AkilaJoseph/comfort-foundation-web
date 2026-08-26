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
