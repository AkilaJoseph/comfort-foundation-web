<?php
// Dev-only router for PHP's built-in server. Not used in production
// (Apache serves via .htaccess + index.php there).
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false;
}
require __DIR__ . '/index.php';
