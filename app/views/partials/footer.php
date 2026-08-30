<?php $socials = social_links(); ?>
<footer class="footer-two">
    <div class="container">
        <div class="row align-items-center gutter-30">
            <div class="col-12 col-lg-7 col-xxl-6">
                <div class="footer-two__newsletter-content">
                    <h3>Stay close to the work</h3>
                    <p>Occasional updates on our programmes, results and opportunities to help.</p>
                </div>
            </div>
            <div class="col-12 col-lg-5 col-xxl-5 offset-xxl-1">
                <div class="footer-two__newsletter-form">
                    <form action="<?= e(url($GLOBALS['cf_route'] ?? '')) ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="form" value="newsletter">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true">
                        <input type="email" required name="email" id="subscribeEmail" placeholder="Enter your email" aria-label="Email address">
                        <button type="submit" aria-label="subscribe" title="Subscribe" class="btn--primary">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row"><div class="col-12"><hr class="divider"></div></div>

        <div class="row gutter-60">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="footer-two__widget">
                    <div class="footer-two__widget-logo">
                        <a href="<?= e(url()) ?>">
                            <img src="<?= e(media(setting('site_logo_footer'), 'assets/images/logo/logo-light.webp')) ?>" alt="<?= e(setting('site_name')) ?>" loading="lazy" decoding="async">
                        </a>
                    </div>
                    <div class="footer-two__widget-content">
                        <p><?= e(setting('site_short_intro')) ?></p>
                        <p style="margin-top:14px;opacity:.7;font-size:14px;">
                            Registered NGO &middot; Reg. No. <?= e(setting('reg_number')) ?><br>
                            Established <?= e(setting('established_year')) ?> &middot; <?= e(setting('coverage')) ?>
                        </p>
                        <?php if ($socials): ?>
                        <div class="social">
                            <?php foreach ($socials as $s): ?>
                            <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>" title="<?= e($s['label']) ?>"><i class="<?= e($s['icon']) ?>"></i></a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-2">
                <div class="footer-two__widget">
                    <div class="footer-two__widget-intro">
                        <h5>Explore</h5>
                        <div class="line"><span class="large-line"></span><span class="small-line"></span><span class="small-line"></span></div>
                    </div>
                    <div class="footer-two__widget-content">
                        <ul>
                            <li><a href="<?= e(url('about')) ?>"><i class="fa-solid fa-arrow-right"></i>About Us</a></li>
                            <li><a href="<?= e(url('programs')) ?>"><i class="fa-solid fa-arrow-right"></i>Our Programmes</a></li>
                            <li><a href="<?= e(url('impact')) ?>"><i class="fa-solid fa-arrow-right"></i>Our Impact</a></li>
                            <li><a href="<?= e(url('team')) ?>"><i class="fa-solid fa-arrow-right"></i>Our Team</a></li>
                            <li><a href="<?= e(url('news')) ?>"><i class="fa-solid fa-arrow-right"></i>News &amp; Stories</a></li>
                            <li><a href="<?= e(url('faq')) ?>"><i class="fa-solid fa-arrow-right"></i>FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="footer-two__widget footer-two__widget--alternate">
                    <div class="footer-two__widget-intro">
                        <h5>Get Involved</h5>
                        <div class="line"><span class="large-line"></span><span class="small-line"></span><span class="small-line"></span></div>
                    </div>
                    <div class="footer-two__widget-content">
                        <ul>
                            <li><a href="<?= e(url('donate')) ?>"><i class="fa-solid fa-arrow-right"></i>Donate</a></li>
                            <li><a href="<?= e(url('volunteer')) ?>"><i class="fa-solid fa-arrow-right"></i>Become a Volunteer</a></li>
                            <li><a href="<?= e(url('partner')) ?>"><i class="fa-solid fa-arrow-right"></i>Partner With Us</a></li>
                            <li><a href="<?= e(url('events')) ?>"><i class="fa-solid fa-arrow-right"></i>Events</a></li>
                            <li><a href="<?= e(url('gallery')) ?>"><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                            <li><a href="<?= e(url('contact')) ?>"><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="footer-two__widget footer-two__widget--alternate">
                    <div class="footer-two__widget-intro">
                        <h5>Get In Touch</h5>
                        <div class="line"><span class="large-line"></span><span class="small-line"></span><span class="small-line"></span></div>
                    </div>
                    <div class="footer-two__widget-content footer-two__widget-content--contact">
                        <ul>
                            <li><a href="<?= e(setting('contact_map_url', '#')) ?>" target="_blank" rel="noopener"><i class="fa-solid fa-location-dot"></i><?= e(setting('contact_address')) ?></a></li>
                            <li><a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>"><i class="fa-solid fa-phone"></i><?= e(setting('contact_phone')) ?></a></li>
                            <li><a href="mailto:<?= e(setting('contact_email')) ?>"><i class="fa-regular fa-envelope"></i><?= e(setting('contact_email')) ?></a></li>
                            <li><span><i class="fa-regular fa-clock"></i><?= e(setting('office_hours')) ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-two__copyright">
        <div class="container">
            <div class="row align-items-center gutter-12">
                <div class="col-12 col-lg-6">
                    <div class="footer-two__copyright-inner text-center text-lg-start">
                        <p>&copy; <?= date('Y') ?> <a href="<?= e(url()) ?>"><?= e(setting('site_name')) ?></a>. All rights reserved.</p>
                        <p class="cf-credit">Built by
                            <a href="https://akila.luotech.co.tz/" target="_blank" rel="noopener">Akila Body Joseph</a>
                            &middot;
                            <a href="https://www.kianvosoft.com/" target="_blank" rel="noopener">Kianvosoft</a>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="footer__bottom-left">
                        <ul class="footer__bottom-list justify-content-center justify-content-lg-end">
                            <li><a href="<?= e(url('terms')) ?>">Terms &amp; Conditions</a></li>
                            <li><a href="<?= e(url('privacy')) ?>">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sprade"><img src="<?= e(asset('assets/images/sprade.webp')) ?>" alt="" class="base-img" loading="lazy" decoding="async" aria-hidden="true"></div>
    <div class="sprade-light"><img src="<?= e(asset('assets/images/sprade-light.webp')) ?>" alt="" loading="lazy" decoding="async" aria-hidden="true"></div>
</footer>
