<?php
$kinds   = ['all' => 'All', 'contact' => 'Contact', 'volunteer' => 'Volunteers', 'partner' => 'Partners', 'pledge' => 'Pledges', 'newsletter' => 'Newsletter'];
$kind    = array_key_exists(get('kind'), $kinds) ? get('kind') : 'all';
$perPage = 30;
$page    = max(1, (int) get('page', '1'));

$where = $kind === 'all' ? '' : ' WHERE kind = ?';
$args  = $kind === 'all' ? [] : [$kind];
$total = (int) scalar('SELECT COUNT(*) FROM submissions' . $where, $args, 0);
$pages = max(1, (int) ceil($total / $perPage));
$page  = min($page, $pages);
$rows  = all('SELECT * FROM submissions' . $where . ' ORDER BY created_at DESC LIMIT ' . $perPage . ' OFFSET ' . (($page - 1) * $perPage), $args);
?>

<div class="bar">
    <div class="tabs">
        <?php foreach ($kinds as $k => $label): ?>
        <a href="<?= e(url('admin/inbox')) ?>?kind=<?= e($k) ?>" class="<?= $kind === $k ? 'on' : '' ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
    </div>
    <span style="color:var(--ink-soft);font-size:14px"><?= (int) $total ?> submission<?= $total === 1 ? '' : 's' ?></span>
</div>

<div class="card card--pad0">
<?php if (!$rows): ?>
    <div class="empty"><i class="fa-solid fa-inbox"></i><p>Nothing here yet.</p></div>
<?php else: ?>
<div class="table-scroll">
<table>
    <thead><tr><th style="width:110px">Type</th><th>From</th><th>Subject</th><th style="width:140px">Received</th><th style="width:150px"></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
    <tr style="<?= $r['is_read'] ? '' : 'background:#FEFAFC' ?>">
        <td><span class="pill <?= $r['is_read'] ? 'pill--off' : 'pill--new' ?>"><?= e(ucfirst($r['kind'])) ?></span></td>
        <td>
            <strong><?= e($r['name'] ?: '—') ?></strong>
            <div style="font-size:13px;color:var(--ink-soft)"><?= e($r['email'] ?: $r['phone']) ?></div>
        </td>
        <td><?= e(excerpt($r['subject'] ?: $r['message'], 70)) ?></td>
        <td style="font-size:13px;color:var(--ink-soft)"><?= e(fmt_date($r['created_at'], 'j M Y, H:i')) ?></td>
        <td>
            <div class="actions">
                <a class="btn btn--ghost btn--sm" href="<?= e(url('admin/inbox/view')) ?>?id=<?= (int) $r['id'] ?>"><i class="fa-solid fa-eye"></i> Open</a>
                <form method="post" action="<?= e(url('admin/inbox/delete')) ?>" style="display:inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button class="btn btn--danger btn--sm" type="submit" data-confirm="Delete this submission?"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>
</div>

<?php if ($pages > 1): ?>
<div class="tabs" style="justify-content:center">
    <?php for ($p = 1; $p <= $pages; $p++): ?>
    <a href="<?= e(url('admin/inbox')) ?>?kind=<?= e($kind) ?>&page=<?= $p ?>" class="<?= $p === $page ? 'on' : '' ?>"><?= $p ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
