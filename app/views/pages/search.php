<?php
$term    = get('q');
$perPage = 8;
$page    = max(1, (int) get('page', '1'));
$total   = $term !== '' ? posts_count(null, $term) : 0;
$pg      = paginate($total, $perPage, $page, 'search');
$items   = $term !== '' ? posts($perPage, $pg['offset'], null, $term) : [];
?>
<?php partial('page-banner', ['heading' => page_banner('search', 'heading', 'Search'), 'eyebrow' => page_banner('search', 'eyebrow', 'Find something'), 'crumbs' => ['Search' => null]]); ?>

<section style="padding:100px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">
                <form action="<?= e(url('search')) ?>" method="get" role="search" style="margin-bottom:40px;">
                    <div class="input-single">
                        <input type="search" name="q" value="<?= e($term) ?>" placeholder="Search news and stories…" aria-label="Search" required>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="form-cta" style="margin-top:16px;">
                        <button type="submit" class="btn--primary">Search <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </form>

                <?php if ($term === ''): ?>
                    <div class="cf-empty"><i class="fa-solid fa-magnifying-glass"></i><p>Enter a word or phrase to search our news and stories.</p></div>
                <?php elseif (!$items): ?>
                    <div class="cf-empty">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <p>No results for &ldquo;<?= e($term) ?>&rdquo;. Try a different word, or browse all our news.</p>
                        <a href="<?= e(url('news')) ?>" class="btn--primary" style="margin-top:18px;">Browse News</a>
                    </div>
                <?php else: ?>
                    <p style="margin-bottom:26px;"><strong><?= (int) $total ?></strong> result<?= $total === 1 ? '' : 's' ?> for &ldquo;<?= e($term) ?>&rdquo;</p>
                    <?php foreach ($items as $p): ?>
                    <a href="<?= e(url('news/' . $p['slug'])) ?>" class="cf-pillar" style="display:block;margin-bottom:18px;">
                        <span style="font-size:13px;font-weight:700;color:var(--cf-green);"><?= e(fmt_date($p['published_at'], 'j M Y')) ?><?= !empty($p['category_name']) ? ' · ' . e($p['category_name']) : '' ?></span>
                        <h5 style="margin:8px 0 10px;"><?= e($p['title']) ?></h5>
                        <p><?= e(excerpt($p['excerpt'] ?: $p['body'], 160)) ?></p>
                    </a>
                    <?php endforeach; ?>
                    <?php partial('pagination', ['pg' => $pg, 'query' => 'q=' . rawurlencode($term) . '&']); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
