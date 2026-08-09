<?php
/**
 * Comfort Foundation — full-page HTML cache.
 *
 * Anonymous GET requests to content pages are written to storage/cache
 * and replayed on the next hit. Any POST, any logged-in admin, and any
 * page carrying a flash message bypasses it. Writing content in the
 * admin clears the whole cache.
 */

declare(strict_types=1);

function cache_enabled(): bool
{
    if (empty($GLOBALS['cf_config']['cache'])) {
        return false;
    }
    if (!empty($_SESSION['admin_id'])) {
        return false;
    }
    if (!empty($_SESSION['flash'])) {
        return false;
    }
    if (!empty($_GET)) {
        return false;   // paginated / filtered views are not cached
    }
    return true;
}

function cache_dir(): string
{
    return CF_ROOT . '/storage/cache';
}

function cache_file(string $route): string
{
    return cache_dir() . '/page_' . sha1($route === '' ? 'home' : $route) . '.html';
}

/** Serve a fresh cached copy if one exists. Returns true when served. */
function cache_serve(string $route): bool
{
    if (!cache_enabled()) {
        return false;
    }
    $file = cache_file($route);
    if (!is_file($file)) {
        return false;
    }
    $ttl = (int) ($GLOBALS['cf_config']['cache_ttl'] ?? 900);
    if (time() - (int) filemtime($file) > $ttl) {
        @unlink($file);
        return false;
    }
    header('Content-Type: text/html; charset=UTF-8');
    header('X-CF-Cache: HIT');
    readfile($file);
    return true;
}

/** Begin buffering so the rendered page can be stored. */
function cache_start(string $route, string $method): void
{
    if ($method !== 'GET' || !cache_enabled()) {
        return;
    }
    $GLOBALS['cf_cache_active'] = true;
    header('X-CF-Cache: MISS');
    ob_start();
}

/** Discard the buffer without storing (used for 404s). */
function cache_abort(): void
{
    if (!empty($GLOBALS['cf_cache_active'])) {
        $GLOBALS['cf_cache_active'] = false;
        echo ob_get_clean();
    }
}

/** Flush the buffer to the browser and to disk. */
function cache_finish(string $route): void
{
    if (empty($GLOBALS['cf_cache_active'])) {
        return;
    }
    $GLOBALS['cf_cache_active'] = false;
    $html = (string) ob_get_clean();
    echo $html;

    if (http_response_code() !== 200 || strlen($html) < 500) {
        return;
    }
    $dir = cache_dir();
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    if (is_writable($dir)) {
        @file_put_contents(cache_file($route), $html, LOCK_EX);
    }
}

/** Remove every cached page. Called whenever content changes. */
function cache_clear(): int
{
    $n = 0;
    foreach (glob(cache_dir() . '/page_*.html') ?: [] as $f) {
        if (@unlink($f)) {
            $n++;
        }
    }
    return $n;
}
