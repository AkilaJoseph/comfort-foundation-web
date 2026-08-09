<?php
$groups = settings_grouped();
$titles = [
    'general' => 'Organisation',
    'contact' => 'Contact details',
    'legal'   => 'Registration',
    'giving'  => 'Bank &amp; mobile money',
    'social'  => 'Social media links',
    'seo'     => 'Search engines',
    'system'  => 'System',
];
?>
<form method="post" action="<?= e(url('admin/settings')) ?>">
    <?= csrf_field() ?>
    <?php foreach ($groups as $group => $items): ?>
    <div class="card">
        <h3><?= $titles[$group] ?? e(ucfirst($group)) ?></h3>
        <?php foreach ($items as $s): ?>
        <div class="field">
            <label for="s_<?= e($s['key_name']) ?>"><?= e($s['label'] ?: $s['key_name']) ?></label>
            <?php if ($s['input_type'] === 'textarea'): ?>
            <textarea name="settings[<?= e($s['key_name']) ?>]" id="s_<?= e($s['key_name']) ?>" style="min-height:90px"><?= e((string) $s['value']) ?></textarea>
            <?php else: ?>
            <input type="<?= e($s['input_type'] === 'email' ? 'email' : ($s['input_type'] === 'url' ? 'url' : 'text')) ?>"
                   name="settings[<?= e($s['key_name']) ?>]" id="s_<?= e($s['key_name']) ?>" value="<?= e((string) $s['value']) ?>">
            <?php endif; ?>
            <?php if ($group === 'social'): ?><div class="hint">Leave blank to hide this icon from the site.</div><?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

    <button class="btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save settings</button>
</form>
