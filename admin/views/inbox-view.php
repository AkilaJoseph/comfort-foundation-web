<?php
/** @var array $row */
$payload = $row['payload'] ? json_decode((string) $row['payload'], true) : null;
?>
<div class="bar">
    <a class="btn btn--ghost" href="<?= e(url('admin/inbox')) ?>"><i class="fa-solid fa-arrow-left"></i> Back to inbox</a>
    <div style="display:flex;gap:10px">
        <?php if ($row['email']): ?>
        <a class="btn" href="mailto:<?= e($row['email']) ?>?subject=<?= rawurlencode('Re: ' . ($row['subject'] ?: 'Your message to Comfort Foundation')) ?>"><i class="fa-solid fa-reply"></i> Reply by email</a>
        <?php endif; ?>
        <?php if ($row['phone']): ?>
        <a class="btn btn--green" href="<?= e(fmt_phone_link($row['phone'])) ?>"><i class="fa-solid fa-phone"></i> Call</a>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom:18px"><?= e($row['subject'] ?: ucfirst($row['kind']) . ' submission') ?></h2>
    <dl class="kv">
        <dt>Type</dt>        <dd><span class="pill pill--new"><?= e(ucfirst($row['kind'])) ?></span></dd>
        <dt>Name</dt>        <dd><?= e($row['name'] ?: '—') ?></dd>
        <dt>Email</dt>       <dd><?= $row['email'] ? '<a href="mailto:' . e($row['email']) . '">' . e($row['email']) . '</a>' : '—' ?></dd>
        <dt>Phone</dt>       <dd><?= $row['phone'] ? '<a href="' . e(fmt_phone_link($row['phone'])) . '">' . e($row['phone']) . '</a>' : '—' ?></dd>
        <dt>Received</dt>    <dd><?= e(fmt_date($row['created_at'], 'l j F Y, H:i')) ?></dd>
        <dt>IP address</dt>  <dd style="color:var(--ink-soft)"><?= e($row['ip'] ?: '—') ?></dd>
    </dl>
</div>

<?php if (!empty($row['message'])): ?>
<div class="card">
    <h3>Message</h3>
    <p style="white-space:pre-wrap;margin:0"><?= e($row['message']) ?></p>
</div>
<?php endif; ?>

<?php if (is_array($payload) && $payload): ?>
<div class="card">
    <h3>Additional details</h3>
    <dl class="kv">
        <?php foreach ($payload as $k => $v): ?>
            <?php if ($v === '' || $v === null || $v === []) { continue; } ?>
            <dt><?= e(ucwords(str_replace('_', ' ', (string) $k))) ?></dt>
            <dd><?= e(is_array($v) ? implode(', ', $v) : (string) $v) ?></dd>
        <?php endforeach; ?>
    </dl>
</div>
<?php endif; ?>

<form method="post" action="<?= e(url('admin/inbox/delete')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
    <button class="btn btn--danger" type="submit" data-confirm="Delete this submission permanently?"><i class="fa-solid fa-trash"></i> Delete submission</button>
</form>
