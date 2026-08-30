-- ============================================================
--  Comfort Foundation — admin-manageable header/footer logo.
--  Import after schema.sql (needs the 'image' input_type already
--  added by home_content.sql / the updated schema.sql).
-- ============================================================

SET NAMES utf8mb4;

INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('site_logo', 'assets/images/logo/logo.webp', 'branding', 'Header logo', 'image', 1),
('site_logo_footer', 'assets/images/logo/logo-light.webp', 'branding', 'Footer logo', 'image', 2)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);
