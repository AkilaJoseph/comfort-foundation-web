<?php
/**
 * Comfort Foundation — application bootstrap.
 * Loads configuration, sets up error handling, sessions and helpers.
 */

declare(strict_types=1);

define('CF_ROOT', dirname(__DIR__));
define('CF_APP',  CF_ROOT . '/app');

// ---- configuration ---------------------------------------------------
$configFile = CF_APP . '/config.php';
if (!is_file($configFile)) {
    http_response_code(500);
    exit('Configuration missing. Copy app/config.example.php to app/config.php and set your database details.');
}
$GLOBALS['cf_config'] = require $configFile;

// ---- error handling --------------------------------------------------
if (!empty($GLOBALS['cf_config']['debug'])) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
}
ini_set('log_errors', '1');

// ---- timezone --------------------------------------------------------
date_default_timezone_set('Africa/Dar_es_Salaam');

// ---- session ---------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'secure'   => $secure,
        'samesite' => 'Lax',
    ]);
    session_name('CFSESS');
    session_start();
}

require CF_APP . '/database.php';
require CF_APP . '/helpers.php';
require CF_APP . '/repository.php';
require CF_APP . '/mailer.php';
