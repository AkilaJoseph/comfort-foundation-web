-- ============================================================
--  Comfort Foundation — updated contact numbers
--  0768011343 becomes the main contact phone; 0656011343 becomes
--  the mobile money number (which was wrongly duplicated from the
--  bank account number before).
-- ============================================================

SET NAMES utf8mb4;

UPDATE `settings` SET `value` = '+255 768 011 343' WHERE `key_name` = 'contact_phone';
UPDATE `settings` SET `value` = '+255768011343'    WHERE `key_name` = 'contact_phone_raw';
UPDATE `settings` SET `value` = '0656011343'       WHERE `key_name` = 'mobile_money_number';
