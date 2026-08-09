<?php
$perPage    = 6;
$page       = max(1, (int) get('page', '1'));
$categoryId = isset($category) ? (int) $category['id'] : null;
$total      = posts_count($categoryId);
$pg         = paginate($total, $perPage, $page, isset($category) ? 'news/category/' . $category['slug'] : 'news');
$items      = posts($perPage, $pg['offset'], $categoryId);
$heading    = $category['name'] ?? 'News & Stories';
?>
<?php partial('page-banner', [
    'heading' => $heading,
    'eyebrow' => 'From the field',
    'crumbs'  => isset($category) ? ['News' => 'news', $category['name'] => null] : ['News' => null],
]); ?>

<section class="blog blog-main cm-details" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row gutter-40">
            <div class="col-12 col-xl-8">
                <?php if (!$items): ?>
                    <div class="cf-empty"><i class="icon-message"></i><p>No articles have been published in this section yet.</p></div>
                <?php else: ?>
                <div class="row gutter-40">
                    <?php foreach ($items as $i => $p): ?>
                    <div class="col-12 col-md-6" style="margin-bottom:16px;">
                        <?php partial('post-card', ['post' => $p, 'delay' => ($i % 2) * 150]); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php partial('pagination', ['pg' => $pg]); ?>
                <?php endif; ?>
            </div>
            <div class="col-12 col-xl-4"><?php partial('news-sidebar'); ?></div>
        </div>
    </div>
</section>
