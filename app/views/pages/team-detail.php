<?php /** @var array $member */ $others = array_slice(array_filter(team_members(), static fn($m) => $m['id'] !== $member['id']), 0, 3); ?>
<?php partial('page-banner', ['heading' => $member['name'], 'eyebrow' => $member['role_title'], 'crumbs' => ['Team' => 'team', $member['name'] => null]]); ?>

<section style="padding:100px 0;">
    <div class="container">
        <div class="row gutter-40">
            <div class="col-12 col-lg-5">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <?= img($member['image'], ['alt' => $member['name'], 'class' => 'w-100', 'fallback' => 'assets/images/team/one.webp']) ?>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="help__content" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i><?= e($member['role_title']) ?></span>
                    <h2 class="title-animation"><?= e($member['name']) ?></h2>
                    <div class="cf-prose"><?= safe_html($member['bio']) ?></div>

                    <div class="contact-main__inner cta" style="margin-top:30px;">
                        <?php if (!empty($member['email'])): ?>
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-envelope"></i></div>
                            <div class="content"><h6>Email</h6><p><a href="mailto:<?= e($member['email']) ?>"><?= e($member['email']) ?></a></p></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($member['phone'])): ?>
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-phone"></i></div>
                            <div class="content"><h6>Phone</h6><p><a href="<?= e(fmt_phone_link($member['phone'])) ?>"><?= e($member['phone']) ?></a></p></div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php
                    $links = array_filter([
                        'fa-brands fa-facebook-f'  => $member['facebook'],
                        'fa-brands fa-twitter'     => $member['twitter'],
                        'fa-brands fa-instagram'   => $member['instagram'],
                        'fa-brands fa-linkedin-in' => $member['linkedin'],
                    ]);
                    if ($links): ?>
                    <div class="social" style="margin-top:24px;">
                        <?php foreach ($links as $icon => $href): ?>
                        <a href="<?= e($href) ?>" target="_blank" rel="noopener" aria-label="social profile"><i class="<?= e($icon) ?>"></i></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($others): ?>
        <div class="row" style="margin-top:80px;"><div class="col-12">
            <div class="section__header"><h3>Other team members</h3></div>
        </div></div>
        <div class="row gutter-40">
            <?php foreach ($others as $i => $m): ?>
            <div class="col-12 col-sm-6 col-xl-4"><?php partial('team-card', ['member' => $m, 'delay' => $i * 150]); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
