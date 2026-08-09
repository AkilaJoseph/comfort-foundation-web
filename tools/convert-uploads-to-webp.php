<?php
/**
 * Comfort Foundation — convert any non-WebP images already sitting in
 * uploads/ into WebP, and update the database references.
 *
 * Run from the command line in the site folder:
 *     php tools/convert-uploads-to-webp.php
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This script must be run from the command line.\n");
}

require dirname(__DIR__) . '/app/bootstrap.php';
require CF_APP . '/uploads.php';

if (!webp_supported()) {
    exit("This server cannot write WebP files (GD without WebP support and no Imagick).\n");
}

$dir = CF_ROOT . '/uploads/media';
if (!is_dir($dir)) {
    exit("No uploads/media folder found.\n");
}

$fields = [
    'programs'     => ['image'],
    'posts'        => ['image'],
    'events'       => ['image'],
    'team_members' => ['image'],
    'gallery'      => ['image'],
    'partners'     => ['logo'],
    'testimonials' => ['image'],
];

$converted = 0;
$saved     = 0;

foreach (glob($dir . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE) ?: [] as $src) {
    $info = @getimagesize($src);
    if (!$info) { continue; }

    $dest = preg_replace('~\.[^.]+$~', '.webp', $src);
    if ($dest === null || is_file($dest)) { continue; }

    if (!convert_to_webp($src, $dest, $info[2])) {
        echo "  skipped (conversion failed): " . basename($src) . "\n";
        continue;
    }

    $oldRel = 'uploads/media/' . basename($src);
    $newRel = 'uploads/media/' . basename($dest);

    foreach ($fields as $table => $cols) {
        foreach ($cols as $col) {
            q("UPDATE `{$table}` SET `{$col}` = ? WHERE `{$col}` = ?", [$newRel, $oldRel]);
        }
    }

    $saved += filesize($src) - filesize($dest);
    unlink($src);
    $converted++;
    echo "  " . basename($src) . "  ->  " . basename($dest) . "\n";
}

printf("\nConverted %d file(s), saving %.0f KB.\n", $converted, max(0, $saved) / 1024);
echo "Remember to clear the page cache from the admin dashboard.\n";
