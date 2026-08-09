<?php
/**
 * Comfort Foundation — local configuration
 * -----------------------------------------------------------------
 * Copy this file to  app/config.php  and fill in your own values.
 * app/config.php is the only file you need to edit when deploying.
 */

return [
    // ---- database -------------------------------------------------
    'db' => [
        'host'    => 'localhost',
        'name'    => 'comfort_foundation',
        'user'    => 'root',
        'pass'    => '',
        'charset' => 'utf8mb4',
    ],

    // ---- site -----------------------------------------------------
    // Base URL path the site is served from.
    //   site at  https://example.org/          ->  ''
    //   site at  https://example.org/comfort/  ->  '/comfort'
    'base_path' => '',

    // Full canonical URL, used for share links, sitemap and og:url.
    'site_url'  => 'https://comfortfoundation.or.tz',

    // ---- mail -----------------------------------------------------
    // Address form notifications are sent to (falls back to the
    // notification_email setting in the database).
    'mail_to'   => 'infocomfort2024@gmail.com',
    // Envelope sender. Use an address on your own domain so mail is
    // not rejected by the receiving server.
    'mail_from' => 'website@comfortfoundation.or.tz',

    // ---- behaviour ------------------------------------------------
    'debug'      => false,   // true = show PHP errors (development only)
    'cache'      => true,    // full-page HTML cache for anonymous visitors
    'cache_ttl'  => 900,     // seconds

    // Serve the concatenated+minified bundles from assets/dist instead of
    // ~14 separate CSS/JS files. Run `php tools/build-assets.php` first.
    'use_bundle' => true,
];
