<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($title ?? 'Sign in') ?> — <?= e(setting('site_name', 'Comfort Foundation')) ?></title>
<link rel="icon" href="<?= e(asset('assets/images/logo/favicon.ico')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/fonts/css/all.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('admin/assets/admin.css')) ?>">
</head>
<body><?= $content ?></body>
</html>
