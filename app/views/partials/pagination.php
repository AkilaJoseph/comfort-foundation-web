<?php
/** @var array $pg  from paginate() */
/** @var string $query  extra query string, already url-encoded, e.g. 'q=abc&' */
if (($pg['pages'] ?? 1) < 2) { return; }
$query = $query ?? '';
$link  = static function (int $p) use ($pg, $query): string {
    return url($pg['base']) . '?' . $query . 'page=' . $p;
};
?>
<div class="pagination-wrapper" data-aos="fade-up" data-aos-duration="1000">
    <ul class="pagination main-pagination">
        <?php if ($pg['current'] > 1): ?>
        <li><a href="<?= e($link($pg['current'] - 1)) ?>" aria-label="previous page"><i class="fa-solid fa-angles-left"></i></a></li>
        <?php else: ?>
        <li><button type="button" disabled aria-label="previous page"><i class="fa-solid fa-angles-left"></i></button></li>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $pg['pages']; $p++): ?>
            <?php if ($p === 1 || $p === $pg['pages'] || abs($p - $pg['current']) <= 2): ?>
            <li><a href="<?= e($link($p)) ?>"<?= $p === $pg['current'] ? ' class="active" aria-current="page"' : '' ?>><?= $p ?></a></li>
            <?php elseif (abs($p - $pg['current']) === 3): ?>
            <li><span style="padding:0 6px;opacity:.5">…</span></li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($pg['current'] < $pg['pages']): ?>
        <li><a href="<?= e($link($pg['current'] + 1)) ?>" aria-label="next page"><i class="fa-solid fa-angles-right"></i></a></li>
        <?php else: ?>
        <li><button type="button" disabled aria-label="next page"><i class="fa-solid fa-angles-right"></i></button></li>
        <?php endif; ?>
    </ul>
</div>
