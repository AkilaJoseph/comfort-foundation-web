<?php $items = gallery_items(); $cats = gallery_categories(); ?>
<?php partial('page-banner', ['heading' => 'Gallery', 'eyebrow' => 'Our work in pictures', 'crumbs' => ['Gallery' => null]]); ?>

<section style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <?php if (!$items): ?>
            <div class="cf-empty"><i class="fa-regular fa-image"></i><p>Photographs from our programmes will be published here soon.</p></div>
        <?php else: ?>
        <?php if (count($cats) > 1): ?>
        <div class="text-center" style="margin-bottom:40px;display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
            <button class="btn--primary cf-gallery-filter active" data-filter="*">All</button>
            <?php foreach ($cats as $c): ?>
            <button class="btn--tertiary cf-gallery-filter" data-filter="<?= e(slugify($c)) ?>"><?= e($c) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row gutter-30" id="cfGallery">
            <?php foreach ($items as $i => $g): ?>
            <div class="col-12 col-sm-6 col-lg-4 cf-gallery-item" data-category="<?= e(slugify($g['category'])) ?>" style="margin-bottom:30px;">
                <a href="<?= e(media($g['image'])) ?>" class="cf-lightbox" title="<?= e($g['title']) ?>" style="display:block;border-radius:16px;overflow:hidden;position:relative;">
                    <?= img($g['image'], ['alt' => $g['title'] ?: 'Comfort Foundation gallery image', 'class' => 'w-100']) ?>
                </a>
                <?php if (!empty($g['title'])): ?>
                <p style="margin-top:12px;font-weight:600;color:var(--cf-ink);"><?= e($g['title']) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
