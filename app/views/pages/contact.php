<?php $socials = social_links(); ?>
<?php partial('page-banner', ['heading' => page_banner('contact', 'heading', 'Contact Us'), 'eyebrow' => page_banner('contact', 'eyebrow', 'Get in touch'), 'crumbs' => ['Contact' => null]]); ?>

<section class="contact-main volunteer" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row gutter-40">
            <div class="col-12 col-xl-6">
                <div class="contact__content">
                    <div class="section__content" data-aos="fade-up" data-aos-duration="1000">
                        <span class="sub-title"><i class="icon-donation"></i>We would like to hear from you</span>
                        <h2 class="title-animation">Talk to <span>Comfort Foundation</span></h2>
                        <p>Whether you want to support our work, partner with us, join as a volunteer, or you are a community member seeking help — reach us using any of the channels below.</p>
                    </div>

                    <div class="contact-main__inner cta">
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="content">
                                <h6>Head office</h6>
                                <p><a href="<?= e(setting('contact_map_url', '#')) ?>" target="_blank" rel="noopener"><?= e(setting('contact_address')) ?></a></p>
                            </div>
                        </div>
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-phone"></i></div>
                            <div class="content">
                                <h6>Phone</h6>
                                <p><a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>"><?= e(setting('contact_phone')) ?></a></p>
                            </div>
                        </div>
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-envelope"></i></div>
                            <div class="content">
                                <h6>Email</h6>
                                <p><a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a></p>
                            </div>
                        </div>
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-clock"></i></div>
                            <div class="content">
                                <h6>Office hours</h6>
                                <p><?= e(setting('office_hours')) ?></p>
                            </div>
                        </div>
                        <?php if ($socials): ?>
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-share-nodes"></i></div>
                            <div class="content">
                                <h6>Social</h6>
                                <div class="social">
                                    <?php foreach ($socials as $s): ?>
                                    <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>"><i class="<?= e($s['icon']) ?>"></i></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div style="margin-top:30px;padding:20px 24px;border-radius:14px;background:var(--cf-green-soft);">
                        <p style="margin:0;font-size:15px;"><strong>Registered NGO.</strong> Reg. No. <?= e(setting('reg_number')) ?> &middot; Established <?= e(setting('established_year')) ?> &middot; Coverage: <?= e(setting('coverage')) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="contact__form volunteer__form checkout__form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="volunteer__form-content">
                        <h4>Send us a message</h4>
                        <p>Fields marked * are required. We aim to respond within two working days.</p>
                    </div>
                    <form action="<?= e(url('contact')) ?>" method="post" class="cta">
                        <?= csrf_field() ?>
                        <input type="hidden" name="form" value="contact">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true">

                        <div class="input-single">
                            <input type="text" name="name" placeholder="Your name *" required value="<?= e(old('name')) ?>">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="input-single">
                            <input type="email" name="email" placeholder="Email address" value="<?= e(old('email')) ?>">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="input-single">
                            <input type="tel" name="phone" placeholder="Phone number" value="<?= e(old('phone')) ?>">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="input-single">
                            <select name="subject" aria-label="Subject">
                                <option value="General enquiry">General enquiry</option>
                                <option value="Donations">Donations</option>
                                <option value="Volunteering">Volunteering</option>
                                <option value="Partnership">Partnership</option>
                                <option value="Programme support">Programme support / referral</option>
                                <option value="Media">Media &amp; press</option>
                            </select>
                        </div>
                        <div class="input-single alter-input">
                            <textarea name="message" placeholder="Your message *" required><?= e(old('message')) ?></textarea>
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <div class="form-cta">
                            <button type="submit" class="btn--primary">Send Message <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $embed = setting('contact_map_embed'); if ($embed): ?>
<section style="padding:0 0 100px;">
    <div class="container">
        <div class="row"><div class="col-12">
            <div style="border-radius:20px;overflow:hidden;box-shadow:0 14px 40px rgba(35,31,32,.08);">
                <iframe src="<?= e($embed) ?>" width="100%" height="420" style="border:0;display:block;"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Comfort Foundation office location"></iframe>
            </div>
        </div></div>
    </div>
</section>
<?php endif; ?>
<?php clear_old(); ?>
