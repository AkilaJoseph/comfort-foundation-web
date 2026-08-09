<?php
/** @var string $heading   Page heading */
/** @var array  $crumbs    [label => href|null] */
$heading = $heading ?? ($title ?? '');
$crumbs  = $crumbs  ?? [];
?>
<section class="common-banner">
    <div class="container">
        <div class="row">
            <div class="common-banner__content text-center">
                <?php if (!empty($eyebrow)): ?>
                <span class="sub-title"><i class="icon-donation"></i><?= e($eyebrow) ?></span>
                <?php endif; ?>
                <h1 class="title-animation"><?= e($heading) ?></h1>
                <?php if ($crumbs): ?>
                <nav aria-label="Breadcrumb">
                    <ul class="common-banner__crumbs">
                        <li><a href="<?= e(url()) ?>">Home</a></li>
                        <?php foreach ($crumbs as $label => $href): ?>
                        <li aria-hidden="true" class="sep">/</li>
                        <li><?php if ($href): ?><a href="<?= e(url($href)) ?>"><?= e($label) ?></a><?php else: ?><span><?= e($label) ?></span><?php endif; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="banner-bg">
        <img src="<?= e(asset('assets/images/banner/banner-bg.webp')) ?>" alt="" loading="lazy" decoding="async" aria-hidden="true">
    </div>
    <div class="shape"><img src="<?= e(asset('assets/images/shape.webp')) ?>" alt="" loading="lazy" aria-hidden="true"></div>
    <div class="sprade"><img src="<?= e(asset('assets/images/sprade-base.webp')) ?>" alt="" class="base-img" loading="lazy" aria-hidden="true"></div>
</section>
