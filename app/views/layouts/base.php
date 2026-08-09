<?php
/** @var string $content */
$siteName = setting('site_name', 'Comfort Foundation');
$pageTitle = $title ?? $siteName;
$fullTitle = ($pageTitle === $siteName || str_contains($pageTitle, $siteName))
    ? $pageTitle
    : $pageTitle . ' | ' . $siteName;
$metaDesc  = $description ?? setting('meta_description');
$ogImage   = !empty($og_image) ? abs_url(ltrim(media($og_image), '/')) : abs_url('assets/images/logo/mark-512.png');
$bodyClass = $body_class ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($fullTitle) ?></title>
<meta name="description" content="<?= e(excerpt($metaDesc, 158, '')) ?>">
<?php if (!empty($noindex)): ?>
<meta name="robots" content="noindex, follow">
<?php else: ?>
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?= e(abs_url($GLOBALS['cf_route'] ?? '')) ?>">
<?php endif; ?>
<meta name="theme-color" content="#9E1F63">

<!-- Open Graph / social -->
<meta property="og:type"        content="<?= e($og_type ?? 'website') ?>">
<meta property="og:site_name"   content="<?= e($siteName) ?>">
<meta property="og:title"       content="<?= e($fullTitle) ?>">
<meta property="og:description" content="<?= e(excerpt($metaDesc, 158, '')) ?>">
<meta property="og:url"         content="<?= e(abs_url($GLOBALS['cf_route'] ?? '')) ?>">
<meta property="og:image"       content="<?= e($ogImage) ?>">
<meta name="twitter:card"       content="summary_large_image">

<!-- favicons -->
<link rel="icon" href="<?= e(asset('assets/images/logo/favicon.ico')) ?>" sizes="any">
<link rel="icon" type="image/png" href="<?= e(asset('assets/images/logo/mark-192.png')) ?>">
<link rel="apple-touch-icon" href="<?= e(asset('assets/images/logo/mark-180.png')) ?>">

<!-- preconnect + preload the fonts that render above the fold -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="image" href="<?= e(asset('assets/images/logo/logo.webp')) ?>">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300..900;1,300..900&family=Nunito+Sans:opsz,wght@6..12,300..900&family=Outfit:wght@300..800&display=swap" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300..900;1,300..900&family=Nunito+Sans:opsz,wght@6..12,300..900&family=Outfit:wght@300..800&display=swap"></noscript>

<?php
$useBundle = !empty($GLOBALS['cf_config']['use_bundle'])
          && is_file(CF_ROOT . '/assets/dist/site.min.css');
if ($useBundle): ?>
<link rel="stylesheet" href="<?= e(asset('assets/dist/site.min.css')) ?>">
<?php else: ?>
<link rel="stylesheet" href="<?= e(asset('assets/css/bootstrap.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/fonts/css/all.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/fonts/css/charifund.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/swiper-bundle.min.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/aos.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/magnific-popup.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/nice-select.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/odometer.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/main.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/responsive.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/sticky-header.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/comfort-brand.css')) ?>">
<?php endif; ?>

<script type="application/ld+json"><?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'NGO',
    'name'        => $siteName,
    'url'         => abs_url(),
    'logo'        => abs_url('assets/images/logo/logo.png'),
    'slogan'      => setting('site_tagline'),
    'foundingDate'=> setting('established_year'),
    'email'       => setting('contact_email'),
    'telephone'   => setting('contact_phone'),
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => setting('contact_address'),
        'addressLocality' => 'Mwanza',
        'addressCountry'  => 'TZ',
    ],
    'areaServed'  => setting('coverage'),
    'description' => setting('meta_description'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
</head>

<body class="<?= e($bodyClass) ?>">
<div class="page-wrapper">

<?php partial('topbar'); ?>
<?php partial('header'); ?>
<?php partial('mobile-menu'); ?>
<?php partial('search-popup'); ?>

<main>
<?= $content ?>
</main>

<?php partial('footer'); ?>

<div class="scroll-top">
    <button aria-label="scroll to top" title="scroll to top">
        <i class="fa-solid fa-angle-up"></i>
    </button>
</div>

</div><!-- /.page-wrapper -->

<?php partial('scripts'); ?>
</body>
</html>
