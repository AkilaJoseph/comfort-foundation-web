<div class="topbar topbar--secondary d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="topbar__inner">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-7 col-xxl-6">
                            <div class="topbar__list-wrapper">
                                <ul class="topbar__list">
                                    <li>
                                        <a href="mailto:<?= e(setting('contact_email')) ?>">
                                            <i class="fa-regular fa-envelope"></i><?= e(setting('contact_email')) ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>">
                                            <i class="fa-solid fa-phone"></i><?= e(setting('contact_phone')) ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5 col-xxl-6">
                            <div class="topbar__items justify-content-end">
                                <div class="topbar__extra d-none d-xxl-block">
                                    <p><i class="icon-heart-hand"></i> Reg. No. <?= e(setting('reg_number')) ?> &middot; <?= e(setting('coverage')) ?></p>
                                </div>
                                <?php $socials = social_links(); if ($socials): ?>
                                <div class="social">
                                    <?php foreach ($socials as $s): ?>
                                    <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener"
                                       aria-label="<?= e($s['label']) ?>" title="<?= e($s['label']) ?>">
                                        <i class="<?= e($s['icon']) ?>"></i>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
