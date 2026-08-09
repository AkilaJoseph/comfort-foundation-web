-- ============================================================
--  Comfort Foundation — seed data
--  Content taken from the official organisational profile.
--  Import AFTER schema.sql.
--
--  DEFAULT ADMIN LOGIN
--    email:    infocomfort2024@gmail.com
--    password: ComfortAdmin2024!
--  >>> CHANGE THIS IMMEDIATELY AFTER YOUR FIRST LOGIN <<<
-- ============================================================

SET NAMES utf8mb4;

-- ---------- admin user ---------------------------------------
INSERT INTO `users` (`name`,`email`,`password_hash`,`role`) VALUES
('Comfort Foundation Admin','infocomfort2024@gmail.com',
 '$2y$10$UtDEWgZzarSSNQpjgBeE7ORdD.SbINtn34rgsiVv9HsOBBDCx5y3K','admin')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ---------- settings ------------------------------------------
INSERT INTO `settings` (`key_name`,`value`,`group_name`,`label`,`input_type`,`sort_order`) VALUES
('site_name','Comfort Foundation','general','Organisation name','text',1),
('site_tagline','To see better living for all people and obtain their rights','general','Tagline','text',2),
('site_short_intro','A community-rooted, women-centered Tanzanian NGO working at the intersection of economic empowerment, family resilience, and children''s mental health.','general','Short introduction','textarea',3),
('vision','A society where every girl, woman, and child thrives with dignity, wellbeing, and equal opportunity.','general','Vision statement','textarea',4),
('mission','Creating resilient families where girls, women, and children thrive.','general','Mission statement','textarea',5),

('contact_email','infocomfort2024@gmail.com','contact','Primary email','email',10),
('contact_phone','+255 759 085 931','contact','Primary phone','text',11),
('contact_phone_raw','+255759085931','contact','Phone (dial format)','text',12),
('contact_address','Nyamagana District, P.O. Box 504, Mwanza, Tanzania','contact','Postal address','textarea',13),
('contact_map_url','https://www.google.com/maps/search/?api=1&query=Nyamagana+District+Mwanza+Tanzania','contact','Google Maps link','url',14),
('contact_map_embed','https://www.google.com/maps?q=Nyamagana%20District%20Mwanza%20Tanzania&output=embed','contact','Google Maps embed URL','url',15),
('office_hours','Monday – Friday, 08:00 – 17:00 (EAT)','contact','Office hours','text',16),

('reg_number','00NGO/R/6025','legal','NGO registration number','text',20),
('established_year','2024','legal','Year established','text',21),
('coverage','Tanzania Mainland','legal','Geographic coverage','text',22),

('bank_name','CRDB Bank','giving','Bank name','text',30),
('bank_account_name','Comfort Foundation','giving','Account name','text',31),
('bank_account_number','0133970009200','giving','Account number','text',32),
('bank_branch','Mwanza, Tanzania','giving','Branch','text',33),
('mobile_money_number','0133970009200','giving','Mobile money number','text',34),
('mobile_money_name','Comfort Foundation','giving','Mobile money account name','text',35),

('social_facebook','','social','Facebook URL','url',40),
('social_twitter','','social','X / Twitter URL','url',41),
('social_instagram','','social','Instagram URL','url',42),
('social_linkedin','','social','LinkedIn URL','url',43),
('social_youtube','','social','YouTube URL','url',44),

('meta_description','Comfort Foundation is a registered Tanzanian NGO in Mwanza empowering women economically, strengthening families through positive parenting, and protecting children''s mental health.','seo','Default meta description','textarea',50),
('notification_email','infocomfort2024@gmail.com','system','Where form submissions are emailed','email',60)
ON DUPLICATE KEY UPDATE `label`=VALUES(`label`), `group_name`=VALUES(`group_name`), `input_type`=VALUES(`input_type`), `sort_order`=VALUES(`sort_order`);

-- ---------- programmes ----------------------------------------
INSERT INTO `programs` (`slug`,`number`,`title`,`icon`,`summary`,`body`,`image`,`goal_amount`,`raised_amount`,`sort_order`) VALUES
('womens-economic-empowerment','01','Women''s Economic Empowerment','icon-fund',
 'Vocational skills training, financial literacy, savings groups (VICOBA/VSLA), micro-enterprise development, agricultural livelihoods, and market linkages for women and girls.',
 '<p>Many women in our communities work hard in agriculture and small enterprise, yet lack the skills, savings and networks needed to achieve lasting economic security. Comfort Foundation closes that gap.</p><h3>What we do</h3><ul><li>Vocational and practical skills training for women and adolescent girls aged 14–35</li><li>Financial literacy — budgeting, saving, record-keeping and credit readiness</li><li>Community savings groups (VICOBA / VSLA) that build capital from within</li><li>Micro-enterprise development and start-up mentoring</li><li>Agricultural livelihoods and climate-smart production support</li><li>Market linkages that connect women producers to reliable buyers</li></ul><h3>Why it matters</h3><p>When a woman earns, saves and grows a business, the return reaches her whole household — school fees are paid, meals improve, and shocks stop becoming crises. Economic power is the foundation everything else in our work rests on.</p>',
 'assets/images/cause/one.webp', 0, 0, 1),
('positive-parenting-family-resilience','02','Positive Parenting & Family Resilience','icon-spread-love',
 'Community-based parenting education, home visits, caregiver support groups, father engagement programs, and early childhood development awareness for families.',
 '<p>Many mothers parent under enormous stress without access to guidance or community support. We strengthen families from within, so homes become places of safety rather than pressure.</p><h3>What we do</h3><ul><li>Community-based parenting education sessions</li><li>Home visits for families needing individual follow-up</li><li>Caregiver support groups that reduce isolation</li><li>Father engagement programmes that bring men into caregiving</li><li>Early childhood development awareness for parents of young children</li></ul><h3>Why it matters</h3><p>Parenting knowledge is not instinctive — it is learned, and it can be taught. Families equipped with practical skills and a support network raise children who are safer, calmer and more likely to stay in school.</p>',
 'assets/images/cause/two.webp', 0, 0, 2),
('childrens-mental-health-wellbeing','03','Children''s Mental Health & Wellbeing','icon-health',
 'Psychosocial support services, safe spaces, school-based mental health awareness, community stigma-reduction campaigns, and referral linkages for children.',
 '<p>Children — particularly girls — often lack the emotional support, protection and safe spaces they need to thrive. We invest in their emotional futures.</p><h3>What we do</h3><ul><li>Psychosocial support services for children aged 0–18</li><li>Safe spaces where children can play, speak and be heard</li><li>School-based mental health awareness with teachers and pupils</li><li>Community campaigns that reduce the stigma around mental health</li><li>Referral linkages to health facilities and social welfare services</li></ul><h3>Why it matters</h3><p>Emotional health determines whether a child can learn, form relationships and grow into leadership. Addressing it early prevents a lifetime of avoidable harm.</p>',
 'assets/images/cause/three.webp', 0, 0, 3)
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- ---------- categories ----------------------------------------
INSERT INTO `categories` (`slug`,`name`) VALUES
('news','News'),
('women-empowerment','Women & Livelihoods'),
('parenting','Parenting & Family'),
('child-wellbeing','Child Wellbeing'),
('partnerships','Partnerships')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ---------- opening posts --------------------------------------
INSERT INTO `posts` (`slug`,`title`,`category_id`,`author`,`excerpt`,`body`,`image`,`published_at`) VALUES
('comfort-foundation-begins-work-in-nyamagana','Comfort Foundation begins work in Nyamagana District',
 (SELECT id FROM categories WHERE slug='news'),'Comfort Foundation',
 'Registered in 2024 and headquartered in Mwanza, Comfort Foundation opens its doors with a women-centered model for integrated community development.',
 '<p>Comfort Foundation was established in response to a clear and urgent reality: women and girls in Tanzania''s communities carry enormous potential, yet structural barriers, economic exclusion and inadequate family support systems prevent them from realising it.</p><p>From our head office in Nyamagana District, Mwanza, we begin work across three interconnected focus areas — women''s economic empowerment, positive parenting and family resilience, and children''s mental health and wellbeing.</p><p>We are not a conventional service provider. We are a partner to communities, walking alongside women, families and children with practical tools, genuine solidarity, and a long-term commitment to transformation.</p>',
 'assets/images/blog/one.webp', CURDATE()),
('why-savings-groups-change-households','Why savings groups change households, not just incomes',
 (SELECT id FROM categories WHERE slug='women-empowerment'),'Comfort Foundation',
 'VICOBA and VSLA groups build more than capital. They build the confidence, discipline and networks that keep a family stable when shocks arrive.',
 '<p>A savings group is often described in financial terms — contributions in, loans out, interest shared at the end of a cycle. That description misses most of what actually happens in the room.</p><h3>Capital that belongs to the community</h3><p>Because the money is raised from members, it stays accountable to members. There is no external lender setting terms, and no repayment schedule disconnected from the rhythms of a farming season or a market stall.</p><h3>The network is the real asset</h3><p>Women who meet weekly to save also share market information, childcare, and warnings about risk. When one member faces a medical emergency, the group is the first responder.</p><p>This is why we pair every savings group with financial literacy and enterprise mentoring — the group is the platform, not the programme.</p>',
 'assets/images/blog/two.webp', CURDATE()),
('talking-to-children-about-feelings','Talking to children about feelings: a starting point for caregivers',
 (SELECT id FROM categories WHERE slug='child-wellbeing'),'Comfort Foundation',
 'Children who can name what they feel are better able to ask for help. Here is where caregivers can begin.',
 '<p>Emotional literacy is a skill, and like any skill it is built through practice. Caregivers do not need clinical training to make a meaningful difference — they need a few reliable habits.</p><h3>Start with naming, not solving</h3><p>When a child is upset, the instinct is to fix the problem. Naming the feeling first — "that sounds frustrating" — tells the child their experience is real and worth attention.</p><h3>Make space that is predictable</h3><p>A regular, unhurried moment each day matters more than a long conversation once a month. Predictability is what makes a child feel safe enough to speak.</p><h3>Know when to refer</h3><p>Persistent withdrawal, changes in sleeping or eating, or a loss of interest in play are signals worth acting on. Our teams work with schools and health facilities to make referral straightforward.</p>',
 'assets/images/blog/three.webp', CURDATE())
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- ---------- impact statistics ----------------------------------
INSERT INTO `impact_stats` (`label`,`value`,`suffix`,`icon`,`sort_order`) VALUES
('Women & girls reached',            0,'+','icon-support-heart',1),
('Savings groups supported',         0,'+','icon-fund',2),
('Families in parenting programmes', 0,'+','icon-spread-love',3),
('Children reached with support',    0,'+','icon-health',4);

-- ---------- FAQs ------------------------------------------------
INSERT INTO `faqs` (`question`,`answer`,`sort_order`) VALUES
('Is Comfort Foundation legally registered?','Yes. Comfort Foundation is a registered Tanzanian Non-Governmental Organisation, registration number 00NGO/R/6025, established in 2024 and headquartered in Nyamagana District, Mwanza.',1),
('Where do you work?','Our head office is in Mwanza and our registered coverage is Tanzania Mainland. Programmes are currently concentrated in Nyamagana District and surrounding communities.',2),
('Who do your programmes serve?','Women and girls are our primary focus, particularly those facing economic vulnerability. We also work with adolescent girls and young women aged 14–35, mothers and caregivers, children aged 0–18, and community leaders, teachers and local health workers as programme partners.',3),
('How can I donate?','You can give directly through our CRDB Bank account or by mobile money. Full details are on the Donate page, and you can also send us a pledge so our team can follow up and issue an acknowledgement.',4),
('Do you accept volunteers?','Yes. We welcome volunteers with skills in training and facilitation, financial literacy, psychosocial support, community mobilisation, communications and monitoring. Apply through the Become a Volunteer page.',5),
('How can my organisation partner with you?','We partner with government agencies, schools and health facilities, NGOs and civil society, international development partners, and the private sector. Tell us about your organisation through the Partner With Us page.',6);

-- ---------- testimonials ----------------------------------------
INSERT INTO `testimonials` (`author`,`role_title`,`quote`,`image`,`rating`,`sort_order`) VALUES
('Community member','Savings group participant, Nyamagana','Before the group, I had no way to save. Now I plan for school fees months ahead instead of borrowing at the last minute.','assets/images/author.webp',5,1),
('Caregiver','Parenting programme, Mwanza','I learned that discipline and love are not opposites. My home is calmer, and my children talk to me now.','assets/images/author.webp',5,2),
('Teacher','Primary school partner','Having somewhere to refer a struggling child changed how we respond. We are no longer guessing.','assets/images/author.webp',5,3);
