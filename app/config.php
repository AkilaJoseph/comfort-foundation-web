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
        'user'    => 'akila',
        'pass'    => '0020',
        'charset' => 'utf8mb4',
    ],

    // ---- site -----------------------------------------------------
    // Base URL path the site is served from.
    //   site at  https://example.org/          ->  ''
    //   site at  https://example.org/comfort/  ->  '/comfort'
    // 'auto' derives it from the front controller's location, so one config is
    // correct in the /comfort-foundation-web subfolder, on the port-8080
    // review vhost (served from root) and on the live domain. Set an explicit
    // path here only if you need to override that.
    'base_path' => 'auto',

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
    'debug'      => true,   // true = show PHP errors (development only)
    'cache'      => false,    // full-page HTML cache for anonymous visitors
    'cache_ttl'  => 900,     // seconds

    // Serve the concatenated+minified bundles from assets/dist instead of
    // ~14 separate CSS/JS files. Run `php tools/build-assets.php` first.
    'use_bundle' => true,
];
