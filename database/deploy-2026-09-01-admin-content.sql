-- ============================================================
--  Comfort Foundation — full admin content coverage.
--  Makes every remaining hardcoded page section, the header nav
--  and the footer link columns admin-manageable. Run this once
--  against the live database (same convention as the other
--  dated deploy-*.sql files in this folder).
-- ============================================================

SET NAMES utf8mb4;

-- ---------- settings: allow rich-text settings values -----------
ALTER TABLE `settings` MODIFY `input_type` ENUM('text','textarea','url','email','image','richtext') NOT NULL DEFAULT 'text';

-- ---------- home page: section eyebrow/heading pairs + CTA photo ----------
-- Titles that carry an inline <span> for the word-highlight style (matching
-- the existing home_slides.title convention) are rendered unescaped, so the
-- markup is preserved exactly as the page already shows it today.
INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('home_programs_eyebrow',      'Core business areas', 'home', 'Programmes section — eyebrow', 'text', 10),
('home_programs_title',        'Three focus areas, one <span>connected</span> model', 'home', 'Programmes section — heading', 'textarea', 11),
('home_approach_eyebrow',      'Our approach', 'home', 'Approach section — eyebrow', 'text', 12),
('home_approach_title',        'Equip &middot; Strengthen &middot; Transform', 'home', 'Approach section — heading', 'textarea', 13),
('home_values_eyebrow',        'What guides us', 'home', 'Core values section — eyebrow', 'text', 14),
('home_values_title',          'Our core <span>values</span>', 'home', 'Core values section — heading', 'textarea', 15),
('home_team_eyebrow',          'The people behind the work', 'home', 'Team section — eyebrow', 'text', 16),
('home_team_title',            'Meet our <span>team</span>', 'home', 'Team section — heading', 'textarea', 17),
('home_testimonials_eyebrow',  'In their words', 'home', 'Testimonials section — eyebrow', 'text', 18),
('home_testimonials_title',    'Voices from the <span>community</span>', 'home', 'Testimonials section — heading', 'textarea', 19),
('home_events_eyebrow',        'What''s coming up', 'home', 'Events section — eyebrow', 'text', 20),
('home_events_title',          'Upcoming <span>events</span>', 'home', 'Events section — heading', 'textarea', 21),
('home_news_eyebrow',          'From the field', 'home', 'News section — eyebrow', 'text', 22),
('home_news_title',            'Latest <span>news</span> &amp; stories', 'home', 'News section — heading', 'textarea', 23),
('home_partners_eyebrow',      'We work with', 'home', 'Partners section — eyebrow', 'text', 24),
('home_volunteer_cta_eyebrow', 'Give your skills and time', 'home', 'Volunteer CTA — eyebrow', 'text', 25),
('home_volunteer_cta_title',   'Become a volunteer', 'home', 'Volunteer CTA — heading', 'text', 26),
('home_donate_cta_eyebrow',    'Bank transfer or mobile money', 'home', 'Donate CTA — eyebrow', 'text', 27),
('home_donate_cta_title',      'Make a donation', 'home', 'Donate CTA — heading', 'text', 28),
('home_cta_photo',             'uploads/media/cf-tailoring-workshop-wide.webp', 'home', 'Donate CTA — photo', 'image', 29)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);

-- ---------- about page ----------
INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('about_intro', '<p>Comfort Foundation (CF) is a legally registered Tanzanian NGO headquartered in Nyamagana District, Mwanza. The Foundation was established in response to a clear and urgent reality: women and girls in Tanzania''s communities carry enormous potential, yet structural barriers, economic exclusion and inadequate family support systems prevent them from realising it.</p><p>CF was founded in response to the challenges faced by women, families and children in underserved communities. The organisation recognised that many women were working hard in agriculture and entrepreneurship but lacked the skills, savings and networks needed to achieve lasting economic security. Many mothers were parenting under stress without access to guidance or community support, while children — particularly girls — lacked the emotional support, protection and safe spaces needed to thrive.</p>', 'page_about', 'Organisational background — intro', 'richtext', 1),
('about_background_eyebrow', 'Organisational background', 'page_about', 'Background section — eyebrow', 'text', 2),
('about_background_title',   'A partner to communities, not a conventional <span>service provider</span>', 'page_about', 'Background section — heading', 'textarea', 3),
('about_values_eyebrow',     'What guides us', 'page_about', 'Core values section — eyebrow', 'text', 4),
('about_values_title',       'Our core <span>values</span>', 'page_about', 'Core values section — heading', 'textarea', 5),
('about_approach_eyebrow',   'Our approach', 'page_about', 'Approach section — eyebrow', 'text', 6),
('about_approach_title',     'Equip &middot; Strengthen &middot; Transform', 'page_about', 'Approach section — heading', 'textarea', 7),
('about_serve_eyebrow',      'Who we serve', 'page_about', 'Who-we-serve section — eyebrow', 'text', 8),
('about_serve_title',        'Designed <span>for</span> and <span>with</span> our communities', 'page_about', 'Who-we-serve section — heading', 'textarea', 9),
('about_partnership_eyebrow','Partnership strategy', 'page_about', 'Partnership section — eyebrow', 'text', 10),
('about_partnership_title',  'Transformation takes <span>coordination</span>', 'page_about', 'Partnership section — heading', 'textarea', 11),
('about_partnership_intro',  'CF believes that sustainable community transformation requires coordinated effort across systems. We actively build partnerships with:', 'page_about', 'Partnership section — intro line', 'textarea', 12),
('about_invitation_heading', 'An invitation', 'page_about', 'Closing section — heading', 'text', 13),
('about_invitation_body', '<p>We are not a conventional service provider. We are a partner to communities, walking alongside women, families and children with practical tools, genuine solidarity, and a long-term commitment to transformation.</p><p>We invite government institutions, development partners, donors and communities to join us in building a Tanzania where every woman has economic power, every family has the support it needs, and every child grows up safe, emotionally healthy and ready to thrive.</p>', 'page_about', 'Closing section — body', 'richtext', 14)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);

-- ---------- donate / volunteer / impact intros ----------
INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('donate_intro', 'Comfort Foundation is a registered Tanzanian NGO (Reg. No. 00NGO/R/6025). Give directly to our bank account or by mobile money — then let us know, so we can acknowledge your gift and keep you informed about what it made possible.', 'page_donate', 'Intro paragraph', 'textarea', 1),
('volunteer_intro', 'Volunteering with Comfort Foundation means real responsibility in real communities. You will work with our programme teams in Nyamagana District and surrounding areas — and you will learn as much as you give.', 'page_volunteer', 'Intro paragraph', 'textarea', 1),
('impact_measures_eyebrow', 'How we measure', 'page_impact', '"How we measure" section — eyebrow', 'text', 1),
('impact_measures_heading', 'Accountability is part of the programme', 'page_impact', '"How we measure" section — heading', 'text', 2)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);

-- ---------- legal page bodies ----------
INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('privacy_body', '<h2>Who we are</h2><p>Comfort Foundation is a registered Tanzanian Non-Governmental Organisation (Reg. No. 00NGO/R/6025) with its head office at Nyamagana District, P.O. Box 504, Mwanza, Tanzania. This policy explains what personal information we collect through this website, why we collect it, and what we do with it.</p><h2>Information we collect</h2><ul><li><strong>Information you give us.</strong> When you use our contact, volunteer, partnership, donation-pledge or newsletter forms, we collect the details you enter — typically your name, email address, phone number and message.</li><li><strong>Technical information.</strong> Our server records the IP address a submission came from, together with the date and time. This is used to prevent abuse of our forms.</li></ul><h2>Why we use it</h2><ul><li>To respond to your enquiry, application or pledge.</li><li>To acknowledge donations and, where you have asked for one, issue a receipt.</li><li>To send occasional updates about our work, if you subscribed to them.</li><li>To protect the website against spam and misuse.</li></ul><h2>What we do not do</h2><p>We do not sell your personal information. We do not share it with third parties for their own marketing. We do not collect payment card details on this website — donations are made directly to our bank or mobile money account.</p><h2>How long we keep it</h2><p>Submissions are retained for as long as they are needed for the purpose above, and for our own record-keeping and accountability obligations. You may ask us to delete your details at any time.</p><h2>Security</h2><p>Submissions are stored on our web host in a database that is not publicly accessible. Access is restricted to authorised Comfort Foundation staff. No system is perfectly secure, so please do not send sensitive personal information — particularly about children — through the website forms. Contact us by phone instead.</p><h2>Children''s information</h2><p>We work with children as programme participants, and we treat information about them with particular care. We do not knowingly collect personal information from children through this website. Enquiries about a child should be made by a parent, caregiver or referring professional.</p><h2>Cookies</h2><p>This website sets a single session cookie, which is required for our forms to work securely. It contains no personal information and expires when you close your browser. We do not use advertising or third-party tracking cookies. Where a page embeds a map, that service may set its own cookies.</p><h2>Your rights</h2><p>You may ask us what information we hold about you, ask us to correct it, or ask us to delete it. Write to <a href="mailto:infocomfort2024@gmail.com">infocomfort2024@gmail.com</a> or call <a href="tel:+255768011343">+255 768 011 343</a>.</p><h2>Changes to this policy</h2><p>If we change how we handle personal information, we will update this page and change the date at the top.</p>', 'legal', 'Privacy Policy — body', 'richtext', 23),
('terms_body', '<h2>Agreement</h2><p>By using this website you agree to these terms. If you do not agree with them, please do not use the site.</p><h2>About the organisation</h2><p>Comfort Foundation is a Non-Governmental Organisation registered in Tanzania under Reg. No. 00NGO/R/6025, established in 2024, with its head office at Nyamagana District, P.O. Box 504, Mwanza, Tanzania.</p><h2>Accuracy of information</h2><p>We take care to keep the information on this site accurate and current. Programme details, event dates and figures may change. Nothing on this site is a guarantee of a particular service, outcome or eligibility.</p><h2>Donations</h2><ul><li>Donations are made directly to the bank or mobile money account published on our Donate page. This website does not process payments and does not collect card details.</li><li>A pledge submitted through the website is a notification of intent, not a payment. Our team will follow up to confirm.</li><li>Unless you designate a specific programme, donations are applied where the need is greatest.</li><li>If you believe a donation was made in error, contact us as soon as possible and we will work with you in good faith.</li><li>Always verify our bank and mobile money details on this website or by calling our office before transferring funds. We will never ask you to send money to a personal account.</li></ul><h2>Volunteering and partnership</h2><p>Submitting an application or enquiry does not create an obligation on either side. Volunteer placements are subject to our selection process, available intakes, and any safeguarding checks required for work involving children.</p><h2>Acceptable use</h2><p>You agree not to use this site to submit unlawful, abusive or misleading content, to attempt to gain unauthorised access to any part of it, or to interfere with its operation.</p><h2>Intellectual property</h2><p>The Comfort Foundation name, logo, text and photographs on this site belong to the Foundation or are used with permission. You may quote or link to our content with attribution. Please contact us before reproducing photographs, particularly any showing programme participants.</p><h2>Links to other sites</h2><p>Where we link to another organisation''s website, we do so for convenience. We are not responsible for their content or their privacy practices.</p><h2>Liability</h2><p>This site is provided as it is. To the extent permitted by Tanzanian law, we are not liable for loss arising from your use of, or reliance on, this website.</p><h2>Governing law</h2><p>These terms are governed by the laws of the United Republic of Tanzania.</p><h2>Contact</h2><p>Questions about these terms: <a href="mailto:infocomfort2024@gmail.com">infocomfort2024@gmail.com</a> &middot; <a href="tel:+255768011343">+255 768 011 343</a>.</p>', 'legal', 'Terms & Conditions — body', 'richtext', 24)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);

-- ---------- footer ----------
INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('footer_newsletter_heading', 'Stay close to the work', 'footer', 'Newsletter — heading', 'text', 1),
('footer_newsletter_text',    'Occasional updates on our programmes, results and opportunities to help.', 'footer', 'Newsletter — text', 'textarea', 2),
('footer_explore_heading',    'Explore', 'footer', 'Explore column — heading', 'text', 3),
('footer_involved_heading',   'Get Involved', 'footer', 'Get Involved column — heading', 'text', 4),
('footer_contact_heading',    'Get In Touch', 'footer', 'Get In Touch column — heading', 'text', 5)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);

-- ---------- donate: "where your gift goes" cards ----------
CREATE TABLE IF NOT EXISTS `donate_uses` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon`       VARCHAR(60)  NOT NULL DEFAULT 'icon-fund',
  `title`      VARCHAR(120) NOT NULL,
  `text`       TEXT         NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `donate_uses` (`icon`,`title`,`text`,`sort_order`) VALUES
('icon-fund',        'Livelihoods',     'Seed capital for savings groups, training materials and start-up support for women-led micro-enterprises.', 1),
('icon-spread-love',  'Family support',  'Parenting education sessions, caregiver support groups and home visits for families under pressure.', 2),
('icon-health',       'Child wellbeing', 'Safe spaces, psychosocial support and school-based mental health awareness for children.', 3);

-- ---------- impact: "how we measure" cards ----------
CREATE TABLE IF NOT EXISTS `impact_measures` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon`       VARCHAR(60)  NOT NULL DEFAULT '',
  `title`      VARCHAR(120) NOT NULL,
  `text`       TEXT         NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `impact_measures` (`title`,`text`,`sort_order`) VALUES
('Baseline first',       'Every programme begins with a community baseline, so change is measured against a real starting point rather than an assumption.', 1),
('Participant-verified', 'Results are reviewed with the women, caregivers and teachers we work alongside — not only with funders.', 2),
('Openly reported',      'Figures on this page are updated as programmes report. Where we have not yet measured something, we say so.', 3);

-- ---------- volunteer: interest areas & highlights ----------
CREATE TABLE IF NOT EXISTS `volunteer_areas` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`      VARCHAR(160) NOT NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `volunteer_areas` (`title`,`sort_order`) VALUES
('Training & facilitation', 1),
('Financial literacy & savings groups', 2),
('Psychosocial support / counselling', 3),
('Community mobilisation', 4),
('Communications & media', 5),
('Monitoring & evaluation', 6),
('Administration & finance', 7),
('Fundraising & grants', 8);

CREATE TABLE IF NOT EXISTS `volunteer_highlights` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `text`       VARCHAR(255) NOT NULL,
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `volunteer_highlights` (`text`,`sort_order`) VALUES
('Facilitate training sessions and savings-group meetings', 1),
('Support parenting education and caregiver groups', 2),
('Help run safe spaces and child wellbeing activities', 3),
('Contribute professional skills — finance, media, M&E, admin', 4);

-- ---------- page banners (eyebrow + heading above each static page) ----------
CREATE TABLE IF NOT EXISTS `page_banners` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_key`   VARCHAR(40)  NOT NULL,
  `eyebrow`    VARCHAR(160) NOT NULL DEFAULT '',
  `heading`    VARCHAR(160) NOT NULL DEFAULT '',
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_page_banners_key` (`page_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `page_banners` (`page_key`,`eyebrow`,`heading`,`sort_order`) VALUES
('about',      'Who we are',                       'About Comfort Foundation',      1),
('contact',    'Get in touch',                      'Contact Us',                    2),
('donate',     'Support the work',                  'Donate',                        3),
('events',     'Trainings, sessions & gatherings',  'Events',                        4),
('faq',        'Good to know',                       'Frequently Asked Questions',    5),
('gallery',    'Our work in pictures',              'Gallery',                       6),
('impact',     'Where we are heading',              'Our Impact',                    7),
('news',       'From the field',                     'News & Stories',                8),
('partner',    'Partnership strategy',              'Partner With Us',               9),
('privacy',    'How we handle your information',    'Privacy Policy',                10),
('programs',   'Core business areas',               'Our Programmes',                11),
('search',     'Find something',                     'Search',                        12),
('team',       'The people behind the work',        'Our Team',                      13),
('terms',      'Using this website',                 'Terms & Conditions',            14),
('volunteer',  'Give your skills and time',          'Become a Volunteer',            15)
ON DUPLICATE KEY UPDATE `eyebrow`=VALUES(`eyebrow`), `heading`=VALUES(`heading`), `sort_order`=VALUES(`sort_order`);

-- ---------- header navigation ----------
-- parent_id = NULL means a top-level item (nullable so the admin's shared
-- `select` field — which stores a blank choice as NULL, same as every other
-- select field, e.g. posts.category_id — works here unmodified). auto_programs
-- = 1 appends every published programme after this item's own children
-- (reproducing the dynamic "All Programmes" + per-programme submenu the site
-- has today). This assumes the table is empty on first run, so the top-level
-- rows land on predictable auto-increment ids (1-7) that the child rows below
-- refer to.
CREATE TABLE IF NOT EXISTS `nav_items` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id`      INT UNSIGNED NULL DEFAULT NULL,
  `label`          VARCHAR(80)  NOT NULL,
  `href`           VARCHAR(190) NOT NULL DEFAULT '',
  `auto_programs`  TINYINT(1)   NOT NULL DEFAULT 0,
  `sort_order`     INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `ix_nav_items_parent` (`parent_id`,`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `nav_items` (`parent_id`,`label`,`href`,`auto_programs`,`sort_order`) VALUES
(NULL, 'Home',         '',         0, 1),
(NULL, 'About',        'about',    0, 2),
(NULL, 'Programmes',   'programs', 1, 3),
(NULL, 'Get Involved', 'donate',   0, 4),
(NULL, 'News & Events','news',     0, 5),
(NULL, 'About Us More','impact',   0, 6),
(NULL, 'Contact',      'contact',  0, 7);

INSERT INTO `nav_items` (`parent_id`,`label`,`href`,`sort_order`) VALUES
(3, 'All Programmes',        'programs',   1),
(4, 'Donate',                'donate',     1),
(4, 'Become a Volunteer',    'volunteer',  2),
(4, 'Partner With Us',       'partner',    3),
(5, 'News & Stories',        'news',       1),
(5, 'Events',                'events',     2),
(5, 'Gallery',                'gallery',    3),
(6, 'Our Impact',            'impact',     1),
(6, 'Our Team',              'team',       2),
(6, 'FAQ',                    'faq',        3);

-- ---------- footer link columns ----------
-- col: 0 = Explore, 1 = Get Involved (stored as an int so it reuses the
-- admin's existing integer-casting `select` field behaviour unchanged).
-- Nullable for the same reason as nav_items.parent_id: a blank `select`
-- choice is stored as NULL by the shared form handler; the repository read
-- treats NULL the same as 0 (Explore).
CREATE TABLE IF NOT EXISTS `footer_links` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `col`        TINYINT      NULL DEFAULT 0,
  `label`      VARCHAR(80)  NOT NULL,
  `href`       VARCHAR(190) NOT NULL DEFAULT '',
  `sort_order` INT          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `ix_footer_links_col` (`col`,`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `footer_links` (`col`,`label`,`href`,`sort_order`) VALUES
(0, 'About Us',          'about',    1),
(0, 'Our Programmes',    'programs', 2),
(0, 'Our Impact',        'impact',   3),
(0, 'Our Team',          'team',     4),
(0, 'News & Stories',    'news',     5),
(0, 'FAQ',                'faq',      6),
(1, 'Donate',                 'donate',    1),
(1, 'Become a Volunteer',     'volunteer', 2),
(1, 'Partner With Us',        'partner',   3),
(1, 'Events',                 'events',    4),
(1, 'Gallery',                 'gallery',   5),
(1, 'Contact Us',             'contact',   6);
