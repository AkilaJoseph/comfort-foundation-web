<?php
// Dev-only router for PHP's built-in server. Not used in production
// (Apache serves via .htaccess + index.php there).
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false;
}
if (is_dir($file) && is_file(rtrim($file, '/') . '/index.php')) {
    require rtrim($file, '/') . '/index.php';
    return true;
}
if (preg_match('~^/admin(/|$)~', $path)) {
    require __DIR__ . '/admin/index.php';
    return true;
}
require __DIR__ . '/index.php';
