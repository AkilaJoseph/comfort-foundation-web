<?php
/**
 * Comfort Foundation — asset bundler.
 *
 * Concatenates and minifies the CSS and JS the site loads, producing:
 *   assets/dist/site.min.css
 *   assets/dist/site.min.js
 *
 * Run from the command line in the site folder:
 *     php tools/build-assets.php
 *
 * Then set 'use_bundle' => true in app/config.php.
 * Re-run this whenever you edit a CSS or JS file.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This script must be run from the command line.\n");
}

$root = dirname(__DIR__);
$dist = $root . '/assets/dist';
if (!is_dir($dist) && !mkdir($dist, 0775, true)) {
    exit("Could not create assets/dist\n");
}

$css = [
    'assets/css/bootstrap.min.css',
    'assets/fonts/css/all.min.css',
    'assets/fonts/css/charifund.css',
    'assets/css/swiper-bundle.min.css',
    'assets/css/aos.css',
    'assets/css/magnific-popup.css',
    'assets/css/nice-select.css',
    'assets/css/odometer.css',
    'assets/css/main.css',
    'assets/css/responsive.css',
    'assets/css/sticky-header.css',
    'assets/css/comfort-brand.css',
];

$js = [
    'assets/js/jquery-3.7.1.min.js',
    'assets/js/bootstrap.bundle.min.js',
    'assets/js/jquery.nice-select.min.js',
    'assets/js/jquery.magnific-popup.min.js',
    'assets/js/swiper-bundle.min.js',
    'assets/js/viewport.jquery.js',
    'assets/js/odometer.min.js',
    'assets/js/vanilla-tilt.min.js',
    'assets/js/aos.js',
    'assets/js/gsap.min.js',
    'assets/js/ScrollTrigger.min.js',
    'assets/js/ScrollToPlugin.min.js',
    'assets/js/SplitText.min.js',
    'assets/js/custom.js',
    'assets/js/comfort.js',
];

/** Minify CSS conservatively (safe for third-party stylesheets). */
function min_css(string $s): string
{
    // A UTF-8 BOM is legal at the start of a standalone file but becomes a
    // stray U+FEFF once the file is concatenated into a bundle. The CSS
    // parser then treats it as a token and drops the at-rule that follows,
    // which silently killed charifund's @font-face (icons rendered as tofu).
    $s = preg_replace('~^\xEF\xBB\xBF~', '', $s) ?? $s;

    // @charset and @import are only valid at the very top of a stylesheet,
    // so they are dead weight mid-bundle. Every @import target is already
    // listed in $css above and inlined in order; see the check below.
    $s = preg_replace('~@charset\s+["\'][^"\']*["\']\s*;~i', '', $s) ?? $s;
    $s = preg_replace('~@import\s+url\([^)]*\)\s*;~i', '', $s) ?? $s;

    $s = preg_replace('~/\*(?!!)[\s\S]*?\*/~', '', $s) ?? $s;   // comments (keep /*! */)
    $s = preg_replace('~\s+~', ' ', $s) ?? $s;                   // collapse whitespace
    // The '~' must be escaped: an unescaped delimiter inside a character
    // class still ends the pattern, so this step used to emit a warning,
    // return null, and silently skip minifying altogether.
    $s = preg_replace('~\s*([{}:;,>\~])\s*~', '$1', $s) ?? $s;
    $s = str_replace(';}', '}', $s);
    return trim($s);
}

/** Strip only full-line // comments and blank lines — safe for pre-minified files. */
function min_js(string $s): string
{
    $out = [];
    foreach (explode("\n", $s) as $line) {
        $t = trim($line);
        if ($t === '' || str_starts_with($t, '//')) {
            continue;
        }
        $out[] = $line;
    }
    return implode("\n", $out);
}

/** Collapse '.' and '..' segments into a clean root-relative path. */
function normalise_path(string $path): string
{
    $parts = [];
    foreach (explode('/', str_replace('\\', '/', $path)) as $p) {
        if ($p === '.' || $p === '') { continue; }
        if ($p === '..') { array_pop($parts); continue; }
        $parts[] = $p;
    }
    return implode('/', $parts);
}

/** Rewrite url(...) paths so they still resolve from assets/dist/. */
function rebase_css(string $css, string $fromDir): string
{
    return preg_replace_callback(
        '~url\(\s*([\'"]?)([^\'")]+)\1\s*\)~i',
        static function (array $m) use ($fromDir): string {
            $u = trim($m[2]);
            if ($u === '' || str_starts_with($u, 'data:') || str_starts_with($u, 'http') || str_starts_with($u, '//') || str_starts_with($u, '#')) {
                return $m[0];
            }
            return 'url("../../' . normalise_path($fromDir . '/' . $u) . '")';
        },
        $css
    ) ?? $css;
}

$bundle = "/*! Comfort Foundation bundle — built " . date('Y-m-d H:i') . " */\n";
$missing = [];
$dropped = [];
foreach ($css as $f) {
    $full = $root . '/' . $f;
    if (!is_file($full)) { $missing[] = $f; continue; }
    $raw = (string) file_get_contents($full);

    // Warn if a stylesheet @imports something the bundle does not already
    // inline — min_css() strips @import, so such a file would go missing.
    if (preg_match_all('~@import\s+url\(\s*[\'"]?([^\'")]+)~i', $raw, $m)) {
        foreach ($m[1] as $u) {
            $abs = normalise_path(dirname($f) . '/' . trim($u));
            if (!in_array($abs, $css, true)) { $dropped[] = "$f imports $abs"; }
        }
    }

    $bundle .= rebase_css(min_css($raw), dirname($f)) . "\n";
}
if ($dropped) {
    fwrite(STDERR, "WARNING: @import target not in the bundle list:\n  - "
        . implode("\n  - ", $dropped) . "\n");
}
file_put_contents($dist . '/site.min.css', $bundle);
printf("CSS  %s  (%.0f KB)\n", 'assets/dist/site.min.css', filesize($dist . '/site.min.css') / 1024);

$bundleJs = "/*! Comfort Foundation bundle — built " . date('Y-m-d H:i') . " */\n";
foreach ($js as $f) {
    $full = $root . '/' . $f;
    if (!is_file($full)) { $missing[] = $f; continue; }
    $bundleJs .= min_js((string) file_get_contents($full)) . "\n;\n";
}
file_put_contents($dist . '/site.min.js', $bundleJs);
printf("JS   %s  (%.0f KB)\n", 'assets/dist/site.min.js', filesize($dist . '/site.min.js') / 1024);

if ($missing) {
    echo "\nWarning — these files were not found and were skipped:\n";
    foreach ($missing as $m) { echo "  - $m\n"; }
}

echo "\nDone. Set 'use_bundle' => true in app/config.php to serve the bundles.\n";
