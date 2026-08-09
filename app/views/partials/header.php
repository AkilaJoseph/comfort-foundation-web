<?php require_once __DIR__ . '/nav.php'; $nav = cf_nav(); ?>
<header class="header header-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="main-header__menu-box">
                    <nav class="navbar p-0">
                        <div class="navbar-logo">
                            <a href="<?= e(url()) ?>" aria-label="<?= e(setting('site_name')) ?> home">
                                <img src="<?= e(asset('assets/images/logo/logo.webp')) ?>"
                                     alt="<?= e(setting('site_name')) ?>" width="200" height="160" fetchpriority="high" decoding="async">
                            </a>
                        </div>
                        <div class="navbar__menu-wrapper">
                            <div class="navbar__menu d-none d-xl-block">
                                <ul class="navbar__list">
                                    <?php foreach ($nav as $item): ?>
                                        <?php $active = in_section($item['href']) ? ' active' : ''; ?>
                                        <?php if (!empty($item['children'])): ?>
                                        <li class="navbar__item navbar__item--has-children nav-fade<?= $active ?>">
                                            <a href="<?= e(url($item['href'])) ?>" aria-label="<?= e($item['label']) ?> menu"
                                               class="navbar__dropdown-label dropdown-label-alter"><?= e($item['label']) ?></a>
                                            <ul class="navbar__sub-menu">
                                                <?php foreach ($item['children'] as $child): ?>
                                                <li><a href="<?= e(url($child['href'])) ?>"><?= e($child['label']) ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                        <?php else: ?>
                                        <li class="navbar__item nav-fade<?= $active ?>">
                                            <a href="<?= e(url($item['href'])) ?>"><?= e($item['label']) ?></a>
                                        </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="contact-btn">
                                <div class="contact-icon"><i class="icon-support"></i></div>
                                <div class="contact-content">
                                    <p>Call us now</p>
                                    <a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>"><?= e(setting('contact_phone')) ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar__options">
                            <div class="navbar__mobile-options">
                                <div class="search-box">
                                    <button class="open-search" aria-label="open search" title="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                                <a href="<?= e(url('donate')) ?>" class="btn--primary d-none d-md-flex">
                                    Donate Now <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                            <button class="open-offcanvas-nav d-flex d-xl-none" aria-label="open menu" title="Menu">
                                <span class="icon-bar top-bar"></span>
                                <span class="icon-bar middle-bar"></span>
                                <span class="icon-bar bottom-bar"></span>
                            </button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
