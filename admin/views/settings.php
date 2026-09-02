<?php
$groups = settings_grouped();
$titles = [
    'branding' => 'Logo',
    'home'    => 'Home page',
    'general' => 'Organisation',
    'contact' => 'Contact details',
    'legal'   => 'Registration',
    'giving'  => 'Bank &amp; mobile money',
    'social'  => 'Social media links',
    'seo'     => 'Search engines',
    'system'  => 'System',
];
// Home-page photos each sit in a differently-shaped frame on the page —
// give the cropper the same ratio so what the admin frames is what shows.
$aspects = [
    'home_who_photo_top'    => '237/228',
    'home_who_photo_lg'     => '462/544',
    'home_who_photo_bottom' => '230/219',
];
?>
<form method="post" action="<?= e(url('admin/settings')) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php foreach ($groups as $group => $items): ?>
    <div class="card">
        <h3><?= $titles[$group] ?? e(ucfirst($group)) ?></h3>
        <?php foreach ($items as $s): ?>
        <div class="field">
            <label for="s_<?= e($s['key_name']) ?>"><?= e($s['label'] ?: $s['key_name']) ?></label>
            <?php if ($s['input_type'] === 'textarea'): ?>
            <textarea name="settings[<?= e($s['key_name']) ?>]" id="s_<?= e($s['key_name']) ?>" style="min-height:90px"><?= e((string) $s['value']) ?></textarea>
            <?php elseif ($s['input_type'] === 'richtext'): ?>
            <textarea class="rich js-ckeditor" name="settings[<?= e($s['key_name']) ?>]" id="s_<?= e($s['key_name']) ?>"><?= e((string) $s['value']) ?></textarea>
            <div class="hint">Anything unsafe (scripts, embeds) is stripped when you save.</div>
            <?php elseif ($s['input_type'] === 'image'):
                $cur = (string) $s['value']; ?>
            <div class="imgprev" id="s_<?= e($s['key_name']) ?>_prev"<?= $cur === '' ? ' style="display:none"' : '' ?>>
                <img src="<?= $cur !== '' ? e(media($cur)) : '' ?>" alt="" id="s_<?= e($s['key_name']) ?>_prev_img">
                <div class="check" style="margin-top:10px">
                    <input type="checkbox" name="settings_image_remove[<?= e($s['key_name']) ?>]" id="s_<?= e($s['key_name']) ?>_rm" value="1">
                    <label for="s_<?= e($s['key_name']) ?>_rm">Remove this image</label>
                </div>
            </div>
            <input type="hidden" name="settings_image_existing[<?= e($s['key_name']) ?>]" value="<?= e($cur) ?>">
            <input type="file" class="js-crop-input" data-aspect="<?= e($aspects[$s['key_name']] ?? 'free') ?>" data-target="s_<?= e($s['key_name']) ?>_prev"
                   name="settings_image[<?= e($s['key_name']) ?>]" id="s_<?= e($s['key_name']) ?>" accept="image/jpeg,image/png,image/gif,image/webp">
            <div class="hint">Choosing a file opens the cropper so you can frame it before it uploads.</div>
            <?php else: ?>
            <input type="<?= e($s['input_type'] === 'email' ? 'email' : ($s['input_type'] === 'url' ? 'url' : 'text')) ?>"
                   name="settings[<?= e($s['key_name']) ?>]" id="s_<?= e($s['key_name']) ?>" value="<?= e((string) $s['value']) ?>">
            <?php endif; ?>
            <?php if ($group === 'social'): ?><div class="hint">Leave blank to hide this icon from the site.</div><?php endif; ?>
            <?php if ($s['key_name'] === 'site_logo'): ?><div class="hint">Shown in the header and mobile menu, on a white background. A transparent PNG or WebP looks best.</div><?php endif; ?>
            <?php if ($s['key_name'] === 'site_logo_footer'): ?><div class="hint">Shown in the footer, on a dark background — use a version with light/white text, or your mark on a transparent background.</div><?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

    <button class="btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save settings</button>
</form>
