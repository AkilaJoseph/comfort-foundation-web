<div class="mobile-menu mobile-menu--primary d-block d-xxl-none">
    <nav class="mobile-menu__wrapper">
        <div class="mobile-menu__header nav-fade">
            <div class="logo">
                <a href="<?= e(url()) ?>" aria-label="home" title="<?= e(setting('site_name')) ?>">
                    <img src="<?= e(asset('assets/images/logo/logo.webp')) ?>" alt="<?= e(setting('site_name')) ?>" width="180" height="144" decoding="async">
                </a>
            </div>
            <button aria-label="close menu" class="close-mobile-menu"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="mobile-menu__list"></div>
        <div class="mobile-menu__cta nav-fade d-block d-md-none">
            <a href="<?= e(url('donate')) ?>" class="btn--primary">Donate Now <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <?php $socials = social_links(); if ($socials): ?>
        <div class="mobile-menu__social social nav-fade">
            <?php foreach ($socials as $s): ?>
            <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>" title="<?= e($s['label']) ?>"><i class="<?= e($s['icon']) ?>"></i></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </nav>
</div>
<div class="mobile-menu__backdrop"></div>
