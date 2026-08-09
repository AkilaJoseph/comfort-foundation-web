<?php $me = auth_user(); $unread = admin_unread_count(); $cur = $GLOBALS['cf_admin_section'] ?? ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($title ?? 'Admin') ?> — <?= e(setting('site_name', 'Comfort Foundation')) ?></title>
<link rel="icon" href="<?= e(asset('assets/images/logo/favicon.ico')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/fonts/css/all.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('admin/assets/admin.css')) ?>">
</head>
<body>
<div class="wrap">
    <aside class="side">
        <div class="side__brand">
            <img src="<?= e(asset('assets/images/logo/logo-light.webp')) ?>" alt="<?= e(setting('site_name')) ?>">
            <span>Content Manager</span>
        </div>
        <nav>
            <a href="<?= e(url('admin')) ?>" class="<?= $cur === '' ? 'on' : '' ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="<?= e(url('admin/inbox')) ?>" class="<?= $cur === 'inbox' ? 'on' : '' ?>">
                <i class="fa-solid fa-inbox"></i> Inbox
                <?php if ($unread): ?><span class="badge"><?= $unread ?></span><?php endif; ?>
            </a>

            <div class="sec">Content</div>
            <?php foreach (admin_entities() as $key => $def): ?>
            <a href="<?= e(url('admin/' . $key)) ?>" class="<?= $cur === $key ? 'on' : '' ?>">
                <i class="fa-solid <?= e($def['icon']) ?>"></i> <?= e($def['label']) ?>
            </a>
            <?php endforeach; ?>

            <div class="sec">Configuration</div>
            <a href="<?= e(url('admin/settings')) ?>" class="<?= $cur === 'settings' ? 'on' : '' ?>"><i class="fa-solid fa-sliders"></i> Site Settings</a>
            <a href="<?= e(url('admin/account')) ?>" class="<?= $cur === 'account' ? 'on' : '' ?>"><i class="fa-solid fa-user-gear"></i> My Account</a>
        </nav>
        <div class="side__foot">
            Signed in as<br><strong style="color:#fff"><?= e($me['name'] ?? '') ?></strong><br>
            <a href="<?= e(url('admin/logout')) ?>">Sign out</a>
        </div>
    </aside>

    <div class="main">
        <header class="top">
            <h1><?= e($title ?? 'Admin') ?></h1>
            <div class="top__right">
                <form method="post" action="<?= e(url('admin/cache')) ?>" style="display:inline">
                    <?= csrf_field() ?>
                    <button class="btn btn--ghost btn--sm" type="submit" title="Clear the cached pages so changes appear immediately">
                        <i class="fa-solid fa-rotate"></i> Clear cache
                    </button>
                </form>
                <a class="btn btn--ghost btn--sm" href="<?= e(url()) ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> View site</a>
            </div>
        </header>
        <div class="content">
            <?php foreach (take_flash() as $f): ?>
            <div class="alert alert--<?= $f['type'] === 'error' ? 'err' : 'ok' ?>">
                <i class="fa-solid <?= $f['type'] === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check' ?>"></i>
                <?= e($f['message']) ?>
            </div>
            <?php endforeach; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<script>
document.addEventListener('click', function (ev) {
  var btn = ev.target.closest('[data-confirm]');
  if (btn && !confirm(btn.getAttribute('data-confirm'))) { ev.preventDefault(); }
});
</script>
</body>
</html>
