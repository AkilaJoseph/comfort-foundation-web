<?php
/** @var string $section */ /** @var array $def */ /** @var array $row */
$isEdit = !empty($row['id']);
$val = static function (string $name, $default = '') use ($row) {
    if (isset($_SESSION['old'][$name])) {
        $v = $_SESSION['old'][$name];
        return is_string($v) ? $v : $default;
    }
    return $row[$name] ?? $default;
};
$publicUrl = null;
if ($isEdit && !empty($row['slug'])) {
    $map = ['programs' => 'programs/', 'posts' => 'news/', 'events' => 'events/', 'team' => 'team/'];
    if (isset($map[$section])) {
        $publicUrl = url($map[$section] . $row['slug']);
    }
}
?>

<div class="bar">
    <a class="btn btn--ghost" href="<?= e(url('admin/' . $section)) ?>"><i class="fa-solid fa-arrow-left"></i> Back to <?= e(strtolower($def['label'])) ?></a>
    <?php if ($publicUrl): ?>
    <a class="btn btn--ghost" href="<?= e($publicUrl) ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> View on site</a>
    <?php endif; ?>
</div>

<form method="post" action="<?= e(url('admin/' . $section . '/save')) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) ($row['id'] ?? 0) ?>">

    <div class="card">
        <?php foreach ($def['fields'] as $name => $f): ?>
        <div class="field">
            <?php if ($f['type'] !== 'checkbox'): ?>
            <label for="f_<?= e($name) ?>"><?= e($f['label']) ?><?= !empty($f['required']) ? ' <span style="color:#B3261E">*</span>' : '' ?></label>
            <?php endif; ?>

            <?php switch ($f['type']):
                case 'textarea': ?>
                    <textarea name="<?= e($name) ?>" id="f_<?= e($name) ?>"<?= !empty($f['required']) ? ' required' : '' ?>><?= e($val($name, $f['default'] ?? '')) ?></textarea>
                <?php break;

                case 'richtext': ?>
                    <textarea class="rich js-ckeditor" name="<?= e($name) ?>" id="f_<?= e($name) ?>"><?= e($val($name)) ?></textarea>
                    <div class="hint">Anything unsafe (scripts, embeds) is stripped when you save. You can drag an image straight into the editor to upload it.</div>
                <?php break;

                case 'checkbox': ?>
                    <div class="check">
                        <input type="checkbox" name="<?= e($name) ?>" id="f_<?= e($name) ?>" value="1"
                            <?= ($isEdit ? !empty($row[$name]) : !empty($f['default'])) ? 'checked' : '' ?>>
                        <label for="f_<?= e($name) ?>"><?= e($f['label']) ?></label>
                    </div>
                <?php break;

                case 'select':
                    $options = admin_options((string) $f['options']); ?>
                    <select name="<?= e($name) ?>" id="f_<?= e($name) ?>">
                        <option value="">— none —</option>
                        <?php foreach ($options as $ov => $ol): ?>
                        <option value="<?= e((string) $ov) ?>" <?= (string) $val($name) === (string) $ov ? 'selected' : '' ?>><?= e($ol) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php break;

                case 'image':
                    $cur = (string) $val($name); ?>
                    <div class="imgprev" id="f_<?= e($name) ?>_prev"<?= $cur === '' ? ' style="display:none"' : '' ?>>
                        <img src="<?= $cur !== '' ? e(media($cur)) : '' ?>" alt="" id="f_<?= e($name) ?>_prev_img">
                        <div class="check" style="margin-top:10px">
                            <input type="checkbox" name="<?= e($name) ?>_remove" id="f_<?= e($name) ?>_rm" value="1">
                            <label for="f_<?= e($name) ?>_rm">Remove this image</label>
                        </div>
                    </div>
                    <input type="hidden" name="<?= e($name) ?>_existing" value="<?= e($cur) ?>">
                    <input type="file" class="js-crop-input" data-aspect="<?= e((string) ($f['aspect'] ?? 'free')) ?>" data-target="f_<?= e($name) ?>_prev" name="<?= e($name) ?>" id="f_<?= e($name) ?>" accept="image/jpeg,image/png,image/gif,image/webp">
                    <div class="hint">JPG, PNG, GIF or WebP, up to 8&nbsp;MB. Choosing a file opens the cropper so you can frame it before it uploads — images are then converted to WebP automatically.</div>
                <?php break;

                case 'number': ?>
                    <input type="number" name="<?= e($name) ?>" id="f_<?= e($name) ?>" value="<?= e((string) $val($name, $f['default'] ?? 0)) ?>">
                <?php break;

                case 'date': ?>
                    <input type="date" name="<?= e($name) ?>" id="f_<?= e($name) ?>" value="<?= e($val($name) ? fmt_date($val($name), 'Y-m-d') : '') ?>">
                <?php break;

                case 'datetime': ?>
                    <input type="datetime-local" name="<?= e($name) ?>" id="f_<?= e($name) ?>" value="<?= e($val($name) ? fmt_date($val($name), 'Y-m-d\TH:i') : '') ?>">
                <?php break;

                default: ?>
                    <input type="text" name="<?= e($name) ?>" id="f_<?= e($name) ?>" value="<?= e((string) $val($name, $f['default'] ?? '')) ?>"<?= !empty($f['required']) ? ' required' : '' ?>>
            <?php endswitch; ?>

            <?php if (!empty($f['hint']) && $f['type'] !== 'richtext' && $f['type'] !== 'image'): ?>
            <div class="hint"><?= e($f['hint']) ?></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <?php if (!empty($def['slug_from'])): ?>
        <div class="field">
            <label for="f_slug">URL slug</label>
            <input type="text" name="slug" id="f_slug" value="<?= e((string) ($row['slug'] ?? '')) ?>" placeholder="Generated from the title if left empty">
            <div class="hint">Lowercase words separated by hyphens. Changing this changes the page address.</div>
        </div>
        <?php endif; ?>
    </div>

    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
        <button class="btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> <?= $isEdit ? 'Save changes' : 'Create' ?></button>
        <a class="btn btn--ghost" href="<?= e(url('admin/' . $section)) ?>">Cancel</a>
        <?php if ($isEdit): ?>
        <span style="flex:1"></span>
        <form method="post" action="<?= e(url('admin/' . $section . '/delete')) ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
            <button class="btn btn--danger" type="submit" data-confirm="Delete this <?= e(strtolower($def['singular'])) ?>? This cannot be undone."><i class="fa-solid fa-trash"></i> Delete</button>
        </form>
        <?php endif; ?>
    </div>
</form>
<?php unset($_SESSION['old']); ?>
