<?php partial('page-banner', ['heading' => 'About Comfort Foundation', 'eyebrow' => 'Who we are', 'crumbs' => ['About' => null]]); ?>

<section class="help" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row align-items-center gutter-40">
            <div class="col-12 col-lg-6">
                <div class="help__thumb"><div class="help__thumb-inner">
                    <div class="thumb-lg thumb" data-aos="fade-right" data-aos-duration="1000">
                        <img src="<?= e(asset('assets/images/help/thumb-lg.webp')) ?>" alt="Comfort Foundation programme participants in Mwanza" loading="lazy" decoding="async">
                    </div>
                    <div class="thumb thumb-bottom"><img src="<?= e(asset('assets/images/help/thumb-bottom.webp')) ?>" alt="Community members at a Comfort Foundation session" loading="lazy" decoding="async"></div>
                    <div class="grid-line"><img src="<?= e(asset('assets/images/help/grid.webp')) ?>" alt="" class="base-img" loading="lazy" aria-hidden="true"></div>
                </div></div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="help__content">
                    <span class="sub-title"><i class="icon-donation"></i>Organisational background</span>
                    <h2 class="title-animation">A partner to communities, not a conventional <span>service provider</span></h2>
                    <div class="cf-prose">
                        <p>Comfort Foundation (CF) is a legally registered Tanzanian NGO headquartered in Nyamagana District, Mwanza. The Foundation was established in response to a clear and urgent reality: women and girls in Tanzania's communities carry enormous potential, yet structural barriers, economic exclusion and inadequate family support systems prevent them from realising it.</p>
                        <p>CF was founded in response to the challenges faced by women, families and children in underserved communities. The organisation recognised that many women were working hard in agriculture and entrepreneurship but lacked the skills, savings and networks needed to achieve lasting economic security. Many mothers were parenting under stress without access to guidance or community support, while children — particularly girls — lacked the emotional support, protection and safe spaces needed to thrive.</p>
                    </div>
                    <div class="help__content-list">
                        <ul>
                            <li><i class="fa-solid fa-circle-check"></i> Established <?= e(setting('established_year')) ?> &middot; Mwanza, Tanzania</li>
                            <li><i class="fa-solid fa-circle-check"></i> Reg. No. <?= e(setting('reg_number')) ?></li>
                            <li><i class="fa-solid fa-circle-check"></i> <?= e(setting('contact_address')) ?></li>
                            <li><i class="fa-solid fa-circle-check"></i> Coverage: <?= e(setting('coverage')) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- vision & mission -->
<section class="cf-approach" style="padding:90px 0;">
    <div class="container">
        <div class="row gutter-40">
            <div class="col-12 col-lg-6" style="margin-bottom:30px;">
                <div class="cf-approach__step cf-approach__step--equip" data-aos="fade-up" data-aos-duration="1000">
                    <h4>Our Vision</h4>
                    <p style="font-size:20px;line-height:1.6;color:#fff;"><?= e(setting('vision')) ?></p>
                </div>
            </div>
            <div class="col-12 col-lg-6" style="margin-bottom:30px;">
                <div class="cf-approach__step cf-approach__step--strengthen" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <h4>Our Mission</h4>
                    <p style="font-size:20px;line-height:1.6;color:#fff;"><?= e(setting('mission')) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- core values -->
<section style="padding:100px 0;">
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

<!-- approach -->
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

<!-- beneficiaries -->
<section style="padding:100px 0;">
    <div class="container">
        <div class="row gutter-40 align-items-center">
            <div class="col-12 col-lg-6">
                <div class="section__header" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>Who we serve</span>
                    <h2 class="title-animation">Designed <span>for</span> and <span>with</span> our communities</h2>
                </div>
                <div class="help__content-list">
                    <ul>
                        <?php foreach (beneficiaries() as $b): ?>
                        <li><i class="fa-solid fa-circle-check"></i> <?= e($b) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="section__header" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <span class="sub-title"><i class="icon-donation"></i>Partnership strategy</span>
                    <h2 class="title-animation">Transformation takes <span>coordination</span></h2>
                </div>
                <p style="margin-bottom:24px;">CF believes that sustainable community transformation requires coordinated effort across systems. We actively build partnerships with:</p>
                <?php foreach (partnership_types() as $i => $pt): ?>
                <div class="contact-main__single" style="margin-bottom:18px;">
                    <div class="thumb"><i class="fa-solid fa-handshake-angle"></i></div>
                    <div class="content">
                        <h6><?= e($pt['title']) ?></h6>
                        <p><?= e($pt['text']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <a href="<?= e(url('partner')) ?>" class="btn--primary" style="margin-top:10px;">Partner With Us <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- conclusion -->
<section class="community" style="padding:0 0 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="cf-give-card cf-prose" data-aos="fade-up" data-aos-duration="1000" style="text-align:center;padding:52px 40px;">
                    <h3 style="margin-bottom:20px;">An invitation</h3>
                    <p>We are not a conventional service provider. We are a partner to communities, walking alongside women, families and children with practical tools, genuine solidarity, and a long-term commitment to transformation.</p>
                    <p>We invite government institutions, development partners, donors and communities to join us in building a Tanzania where every woman has economic power, every family has the support it needs, and every child grows up safe, emotionally healthy and ready to thrive.</p>
                    <div class="cta" style="margin-top:28px;display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
                        <a href="<?= e(url('donate')) ?>" class="btn--primary">Donate Now <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="<?= e(url('contact')) ?>" class="btn--tertiary">Talk To Us <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
