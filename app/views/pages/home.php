<?php
$progs   = programs();
$stats   = impact_stats();
$latest  = posts(3);
$crew    = team_members(4);
$quotes  = testimonials();
$prts    = partners();
$upcoming = events(3, 0, 'upcoming');
$slides   = home_slides();
?>

<!-- ==== hero ==== -->
<?php if ($slides): ?>
<section class="banner-two">
    <div class="banner-two__slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $idx => $s): ?>
            <div class="swiper-slide">
                <div class="banner-two__slider-single">
                    <div class="banner-two__slider-bg" data-background="<?= e(media($s['image'] ?? '', 'assets/images/banner/banner-one-bg.webp')) ?>"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-9 col-lg-8 col-xxl-7">
                                <div class="banner-two__slider-content">
                                    <span class="sub-title"><i class="icon-donation"></i><?= e($s['eyebrow']) ?></span>
                                    <h1><?= $s['title'] ?></h1>
                                    <div class="banner__content-cta cta">
                                        <a href="<?= e(url('programs')) ?>" class="btn--tertiary">Our Programmes <i class="fa-solid fa-arrow-right"></i></a>
                                        <a href="<?= e(url('donate')) ?>" class="btn--primary">Donate Now <i class="fa-solid fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="slider-navigation d-none d-md-flex">
        <button type="button" aria-label="previous slide" class="prev-banner slider-btn"><i class="fa-solid fa-arrow-left"></i></button>
        <button type="button" aria-label="next slide" class="next-banner slider-btn slider-btn-next"><i class="fa-solid fa-arrow-right"></i></button>
    </div>
    <div class="shape"><img src="<?= e(asset('assets/images/shape.webp')) ?>" alt="" aria-hidden="true"></div>
    <div class="sprade-shape"><img src="<?= e(asset('assets/images/sprade-base.webp')) ?>" alt="" class="base-img" aria-hidden="true"></div>
    <div class="unity"><img src="<?= e(asset('assets/images/unity.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
</section>
<?php endif; ?>

<!-- ==== flash messages ==== -->
<?php $fl = render_flash(); if ($fl): ?>
<div class="container" style="margin-top:34px;"><div class="row"><div class="col-12"><?= $fl ?></div></div></div>
<?php endif; ?>

<!-- ==== who we are ==== -->
<section class="help">
    <div class="container">
        <div class="row align-items-center gutter-40">
            <div class="col-12 col-lg-5 col-xxl-6 d-none d-lg-block">
                <div class="help__thumb">
                    <div class="help__thumb-inner">
                        <div class="thumb-top thumb"><img src="<?= e(media(setting('home_who_photo_top'), 'uploads/media/help-thumb-top.webp')) ?>" alt="Women in a community training session" loading="lazy" decoding="async"></div>
                        <div class="thumb-lg thumb" data-aos="fade-left" data-aos-duration="1000">
                            <img src="<?= e(media(setting('home_who_photo_lg'), 'uploads/media/help-thumb-lg.webp')) ?>" alt="Comfort Foundation programme participants" loading="lazy" decoding="async">
                        </div>
                        <div class="thumb thumb-bottom"><img src="<?= e(media(setting('home_who_photo_bottom'), 'uploads/media/help-thumb-bottom.webp')) ?>" alt="Children in a safe space" loading="lazy" decoding="async"></div>
                        <div class="line"><img src="<?= e(asset('assets/images/help/line.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
                        <div class="grid-line"><img src="<?= e(asset('assets/images/help/grid.webp')) ?>" alt="" class="base-img" loading="lazy" aria-hidden="true"></div>
                        <div class="vertical-text"><h5>Equip &middot; <span>Strengthen</span> &middot; Transform</h5></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7 col-xxl-6">
                <div class="help__content">
                    <span class="sub-title"><i class="icon-donation"></i>Who we are</span>
                    <h2 class="title-animation"><?= e(setting('home_who_heading', 'A women-centered NGO rooted in Mwanza')) ?></h2>
                    <p><?= e(setting('site_short_intro')) ?></p>
                    <div class="help__content-icon-group">
                        <div class="help__content-icon">
                            <div class="thumb"><i class="icon-donation"></i></div>
                            <div class="content">
                                <h6>Our Vision</h6>
                                <p><?= e(setting('vision')) ?></p>
                            </div>
                        </div>
                        <div class="help__content-icon">
                            <div class="thumb"><i class="icon-spread-love"></i></div>
                            <div class="content">
                                <h6>Our Mission</h6>
                                <p><?= e(setting('mission')) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="help__content-list">
                        <ul>
                            <li><i class="fa-solid fa-circle-check"></i> Registered Tanzanian NGO — Reg. No. <?= e(setting('reg_number')) ?></li>
                            <li><i class="fa-solid fa-circle-check"></i> Established <?= e(setting('established_year')) ?> in Nyamagana District, Mwanza</li>
                            <li><i class="fa-solid fa-circle-check"></i> Coverage across <?= e(setting('coverage')) ?></li>
                        </ul>
                    </div>
                    <div class="help__content-cta cta">
                        <a href="<?= e(url('about')) ?>" class="btn--primary">More About Us</a>
                        <div class="contact-btn">
                            <div class="contact-icon"><i class="icon-phone"></i></div>
                            <div class="contact-content">
                                <p>Phone</p>
                                <a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>"><?= e(setting('contact_phone')) ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hand"><img src="<?= e(asset('assets/images/help/hand.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
    <div class="spade"><img src="<?= e(asset('assets/images/help/spade.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
</section>

<!-- ==== core business areas ==== -->
<?php if ($progs): ?>
<section class="difference" style="padding-top:0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>Core business areas</span>
                    <h2 class="title-animation">Three focus areas, one <span>connected</span> model</h2>
                    <p>Comfort Foundation's work is structured around three interconnected focus areas, united by a shared commitment to women-led community transformation.</p>
                </div>
            </div>
        </div>
        <div class="row gutter-30">
            <?php foreach ($progs as $i => $p): ?>
            <div class="col-12 col-md-6 col-xl-4" style="margin-bottom:30px;">
                <?php partial('program-card', ['program' => $p, 'i' => $i, 'delay' => $i * 200]); ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ==== approach ==== -->
<section class="cf-approach" style="padding:100px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>Our approach</span>
                    <h2>Equip &middot; Strengthen &middot; Transform</h2>
                </div>
            </div>
        </div>
        <div class="row gutter-30">
            <?php foreach (approach_steps() as $i => $step): ?>
            <div class="col-12 col-lg-4" style="margin-bottom:30px;">
                <div class="cf-approach__step cf-approach__step--<?= e($step['key']) ?>" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= $i * 200 ?>">
                    <h4><?= e($step['title']) ?></h4>
                    <p><?= e($step['text']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==== impact numbers ==== -->
<?php if ($stats): ?>
<section style="padding:80px 0 0;">
    <div class="container">
        <div class="row"><div class="col-12">
            <div class="cf-facts" data-aos="fade-up" data-aos-duration="1000">
                <div class="row g-0">
                    <?php foreach ($stats as $s): ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="cf-facts__item">
                            <h3><span class="odometer" data-odometer-final="<?= (int) $s['value'] ?>">0</span><?= e($s['suffix']) ?></h3>
                            <p><?= e($s['label']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div></div>
    </div>
</section>
<?php endif; ?>

<!-- ==== give / get involved ==== -->
<section class="cta-section" style="padding:90px 0;">
    <div class="container-fluid">
        <div class="row gutter-40">
            <div class="col-12 col-xxl-4">
                <div class="cta-section__first cta-section__single">
                    <div class="cta-section__group" data-aos="fade-up" data-aos-duration="1000">
                        <div class="thumb"><i class="icon-spread-love"></i></div>
                        <div class="content">
                            <span>Give your skills and time</span>
                            <h3>Become a volunteer</h3>
                        </div>
                        <div class="cta-s"><a href="<?= e(url('volunteer')) ?>" class="btn--tertiary">Apply Now</a></div>
                    </div>
                    <div class="cta-img"><img src="<?= e(asset('assets/images/cta/one.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
                </div>
            </div>
            <div class="col-12 col-xxl-4">
                <div class="cta-section__center cta-section__single">
                    <div class="cta-img"><img src="<?= e(asset('uploads/media/cf-tailoring-workshop-wide.webp')) ?>" alt="Women at work in a Comfort Foundation tailoring group" class="parallax-image" loading="lazy"></div>
                </div>
            </div>
            <div class="col-12 col-xxl-4">
                <div class="cta-section__last cta-section__single">
                    <div class="cta-section__group" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="thumb"><i class="icon-donation-card"></i></div>
                        <div class="content">
                            <span>Bank transfer or mobile money</span>
                            <h3>Make a donation</h3>
                        </div>
                        <div class="cta-s"><a href="<?= e(url('donate')) ?>" class="btn--primary">Donate Now</a></div>
                    </div>
                    <div class="cta-img"><img src="<?= e(asset('assets/images/cta/three.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==== core values ==== -->
<section class="difference-two" style="padding:0 0 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-7">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>What guides us</span>
                    <h2 class="title-animation">Our core <span>values</span></h2>
                </div>
            </div>
        </div>
        <div class="row gutter-30">
            <?php foreach (core_values() as $i => $v): ?>
            <div class="col-12 col-md-6 col-xl-4" style="margin-bottom:30px;">
                <div class="cf-pillar<?= $i % 2 ? ' cf-pillar--green' : '' ?>" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= ($i % 3) * 150 ?>">
                    <span class="cf-pillar__num"><i class="<?= e($v['icon']) ?>"></i></span>
                    <h5><?= e($v['title']) ?></h5>
                    <p><?= e($v['text']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==== team ==== -->
<?php if ($crew): ?>
<section class="team">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-7">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>The people behind the work</span>
                    <h2 class="title-animation">Meet our <span>team</span></h2>
                </div>
            </div>
        </div>
        <div class="row gutter-40">
            <?php foreach ($crew as $i => $m): ?>
            <div class="col-12 col-sm-6 col-xl-3"><?php partial('team-card', ['member' => $m, 'delay' => $i * 200]); ?></div>
            <?php endforeach; ?>
        </div>
        <div class="row"><div class="col-12">
            <div class="section__cta cta text-center"><a href="<?= e(url('team')) ?>" class="btn--primary">View Full Team <i class="fa-solid fa-arrow-right"></i></a></div>
        </div></div>
    </div>
</section>
<?php endif; ?>

<!-- ==== testimonials ==== -->
<?php if ($quotes): ?>
<section class="testimonial" data-background="<?= e(media('assets/images/bg-one.webp', 'assets/images/pattern.webp')) ?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-xl-7">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>In their words</span>
                    <h2 class="title-animation">Voices from the <span>community</span></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial__inner">
        <div class="container">
            <div class="row"><div class="col-12">
                <div class="testimonial__slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($quotes as $t): ?>
                        <div class="swiper-slide">
                            <div class="testimonial__slider-single">
                                <div class="review"><?php for ($r = 0; $r < (int) $t['rating']; $r++): ?><i class="icon-star"></i><?php endfor; ?></div>
                                <div class="content"><blockquote><q><?= e($t['quote']) ?></q></blockquote></div>
                                <div class="author-info">
                                    <div class="author-thumb"><?= img($t['image'], ['alt' => $t['author'], 'fallback' => 'assets/images/author.webp', 'width' => 60, 'height' => 60]) ?></div>
                                    <div class="author-content">
                                        <h6><?= e($t['author']) ?></h6>
                                        <p><?= e($t['role_title']) ?></p>
                                    </div>
                                </div>
                                <div class="quote"><img src="<?= e(asset('assets/images/quote.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div></div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ==== upcoming events ==== -->
<?php if ($upcoming): ?>
<section class="event event-alt">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-xl-7">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>What's coming up</span>
                    <h2 class="title-animation">Upcoming <span>events</span></h2>
                </div>
            </div>
        </div>
        <div class="row gutter-30">
            <div class="col-12 col-lg-6 col-xl-7"><?php partial('event-card', ['event' => $upcoming[0]]); ?></div>
            <div class="col-12 col-lg-6 col-xl-5">
                <?php foreach (array_slice($upcoming, 1) as $i => $ev): ?>
                <?php partial('event-card', ['event' => $ev, 'alt' => true, 'delay' => $i * 300]); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ==== latest news ==== -->
<?php if ($latest): ?>
<section class="blog">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-xl-7">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>From the field</span>
                    <h2 class="title-animation">Latest <span>news</span> &amp; stories</h2>
                </div>
            </div>
        </div>
        <div class="row gutter-40">
            <?php foreach ($latest as $i => $p): ?>
            <div class="col-12 col-lg-6 col-xl-4"><?php partial('post-card', ['post' => $p, 'delay' => $i * 300]); ?></div>
            <?php endforeach; ?>
        </div>
        <div class="row"><div class="col-12">
            <div class="section__cta cta text-center"><a href="<?= e(url('news')) ?>" class="btn--primary">View All News <i class="fa-solid fa-arrow-right"></i></a></div>
        </div></div>
    </div>
    <div class="blog-bg"><img src="<?= e(asset('assets/images/blog/blog-bg.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
    <div class="spade"><img src="<?= e(asset('assets/images/blog/spade-base.webp')) ?>" alt="" class="base-img" loading="lazy" aria-hidden="true"></div>
</section>
<?php endif; ?>

<!-- ==== partners ==== -->
<?php if ($prts): ?>
<div class="partner" style="padding:40px 0 90px;">
    <div class="container">
        <div class="row"><div class="col-12">
            <div class="section__header text-center" style="margin-bottom:36px;"><span class="sub-title"><i class="icon-donation"></i>We work with</span></div>
            <div class="partner__slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($prts as $pt): ?>
                    <div class="swiper-slide">
                        <div class="partner__slider-single">
                            <?php if (!empty($pt['website'])): ?><a href="<?= e($pt['website']) ?>" target="_blank" rel="noopener"><?php endif; ?>
                            <?= img($pt['logo'], ['alt' => $pt['name'], 'fallback' => 'assets/images/sponsor/one.webp']) ?>
                            <?php if (!empty($pt['website'])): ?></a><?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div></div>
    </div>
</div>
<?php endif; ?>
