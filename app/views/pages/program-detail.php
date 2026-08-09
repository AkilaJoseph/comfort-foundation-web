<?php /** @var array $program */ $others = array_filter(programs(), static fn($p) => $p['id'] !== $program['id']); ?>
<?php partial('page-banner', ['heading' => $program['title'], 'eyebrow' => 'Programme ' . ($program['number'] ?: ''), 'crumbs' => ['Programmes' => 'programs', $program['title'] => null]]); ?>

<section style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row gutter-40">
            <div class="col-12 col-xl-8">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <?= img($program['image'], ['alt' => $program['title'], 'class' => 'w-100', 'fallback' => 'assets/images/cause/one.webp']) ?>
                </div>
                <div class="cf-prose" style="margin-top:34px;">
                    <p style="font-size:20px;color:var(--cf-ink);font-weight:600;"><?= e($program['summary']) ?></p>
                    <?= safe_html($program['body']) ?>
                </div>
                <div class="cta" style="margin-top:34px;display:flex;gap:14px;flex-wrap:wrap;">
                    <a href="<?= e(url('donate')) ?>" class="btn--primary">Support This Work <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="<?= e(url('volunteer')) ?>" class="btn--tertiary">Volunteer <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="cm-details__sidebar">
                    <?php if ($others): ?>
                    <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
                        <div class="intro"><h5>Other Programmes</h5></div>
                        <div class="cm-categories">
                            <?php foreach ($others as $o): ?>
                            <a href="<?= e(url('programs/' . $o['slug'])) ?>"><span><?= e($o['title']) ?></span><span><?= e($o['number']) ?></span></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
                        <div class="intro"><h5>Get In Touch</h5></div>
                        <p style="margin-bottom:16px;">Want to know more about this programme, or work with us on it?</p>
                        <ul style="list-style:none;padding:0;margin:0 0 18px;">
                            <li style="margin-bottom:10px;"><i class="fa-solid fa-phone" style="color:var(--cf-green);width:22px"></i> <a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>"><?= e(setting('contact_phone')) ?></a></li>
                            <li><i class="fa-regular fa-envelope" style="color:var(--cf-green);width:22px"></i> <a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a></li>
                        </ul>
                        <a href="<?= e(url('contact')) ?>" class="btn--primary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
