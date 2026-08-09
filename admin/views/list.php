<?php
/** @var string $section */ /** @var array $def */
$perPage = 25;
$page    = max(1, (int) get('page', '1'));
$search  = get('q');

$where = '';
$params = [];
if ($search !== '') {
    $searchable = [];
    foreach (array_keys($def['columns']) as $c) {
        if (!in_array($c, ['is_published', 'sort_order', 'views', 'value', 'rating'], true)) {
            $searchable[] = "`{$c}` LIKE ?";
            $params[]     = '%' . $search . '%';
        }
    }
    if ($searchable) {
        $where = ' WHERE (' . implode(' OR ', $searchable) . ')';
    }
}

$total = (int) scalar('SELECT COUNT(*) FROM `' . $def['table'] . '`' . $where, $params, 0);
$pages = max(1, (int) ceil($total / $perPage));
$page  = min($page, $pages);
$rows  = all(
    'SELECT * FROM `' . $def['table'] . '`' . $where . ' ORDER BY ' . $def['order']
    . ' LIMIT ' . $perPage . ' OFFSET ' . (($page - 1) * $perPage),
    $params
);
$imageField = null;
foreach ($def['fields'] as $n => $f) {
    if ($f['type'] === 'image') { $imageField = $n; break; }
}
?>

<div class="bar">
    <form method="get" action="<?= e(url('admin/' . $section)) ?>" style="display:flex;gap:8px;max-width:360px;flex:1">
        <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search <?= e(strtolower($def['label'])) ?>…">
        <button class="btn btn--ghost" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
    <a class="btn" href="<?= e(url('admin/' . $section . '/create')) ?>"><i class="fa-solid fa-plus"></i> New <?= e(strtolower($def['singular'])) ?></a>
</div>

<div class="card card--pad0">
<?php if (!$rows): ?>
    <div class="empty">
        <i class="fa-solid <?= e($def['icon']) ?>"></i>
        <p><?= $search !== '' ? 'Nothing matched that search.' : 'No ' . strtolower($def['label']) . ' yet.' ?></p>
        <a class="btn" href="<?= e(url('admin/' . $section . '/create')) ?>" style="margin-top:14px"><i class="fa-solid fa-plus"></i> Add the first one</a>
    </div>
<?php else: ?>
<table>
    <thead>
        <tr>
            <?php if ($imageField): ?><th style="width:70px"></th><?php endif; ?>
            <?php foreach ($def['columns'] as $label): ?><th><?= e($label) ?></th><?php endforeach; ?>
            <th style="width:170px"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <?php if ($imageField): ?>
            <td>
                <?php if (!empty($r[$imageField])): ?>
                <img class="thumb" src="<?= e(media($r[$imageField])) ?>" alt="">
                <?php else: ?>
                <span class="thumb" style="display:flex;align-items:center;justify-content:center;color:#ccc"><i class="fa-regular fa-image"></i></span>
                <?php endif; ?>
            </td>
            <?php endif; ?>

            <?php foreach (array_keys($def['columns']) as $c): ?>
            <td>
                <?php
                $v = $r[$c] ?? '';
                if ($c === 'is_published') {
                    echo $v ? '<span class="pill pill--on">Live</span>' : '<span class="pill pill--off">Draft</span>';
                } elseif (in_array($c, ['published_at', 'starts_at', 'created_at'], true)) {
                    echo e($v ? fmt_date($v, 'j M Y') : '—');
                } elseif ($c === 'website' && $v) {
                    echo '<a href="' . e($v) . '" target="_blank" rel="noopener">' . e(excerpt($v, 34)) . '</a>';
                } else {
                    echo e(excerpt((string) $v, 68)) ?: '—';
                }
                ?>
            </td>
            <?php endforeach; ?>

            <td>
                <div class="actions">
                    <a class="btn btn--ghost btn--sm" href="<?= e(url('admin/' . $section . '/edit')) ?>?id=<?= (int) $r['id'] ?>"><i class="fa-solid fa-pen"></i> Edit</a>
                    <form method="post" action="<?= e(url('admin/' . $section . '/delete')) ?>" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                        <button class="btn btn--danger btn--sm" type="submit"
                                data-confirm="Delete this <?= e(strtolower($def['singular'])) ?>? This cannot be undone.">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
</div>

<?php if ($pages > 1): ?>
<div class="tabs" style="justify-content:center">
    <?php for ($p = 1; $p <= $pages; $p++): ?>
    <a href="<?= e(url('admin/' . $section)) ?>?<?= $search !== '' ? 'q=' . rawurlencode($search) . '&' : '' ?>page=<?= $p ?>" class="<?= $p === $page ? 'on' : '' ?>"><?= $p ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
