<?php
/**
 * Comfort Foundation — view and utility helpers.
 */

declare(strict_types=1);

// ---------------------------------------------------------------------
//  Escaping & text
// ---------------------------------------------------------------------

/** HTML-escape. Use for every value printed into markup. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Escape for use inside a URL segment or query value. */
function eu($value): string
{
    return rawurlencode((string) $value);
}

/** Trim a string to a word boundary. */
function excerpt(?string $text, int $limit = 140, string $tail = '…'): string
{
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $text)));
    if ($text === '' || mb_strlen($text) <= $limit) {
        return $text;
    }
    $cut = mb_substr($text, 0, $limit);
    $sp  = mb_strrpos($cut, ' ');
    if ($sp !== false && $sp > $limit * 0.6) {
        $cut = mb_substr($cut, 0, $sp);
    }
    return rtrim($cut, " ,.;:-") . $tail;
}

/** URL-safe slug. */
function slugify(string $text): string
{
    $text = trim($text);
    if (function_exists('iconv')) {
        $conv = @iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        if ($conv !== false) {
            $text = $conv;
        }
    }
    $text = strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $text) ?? '');
    $text = trim($text, '-');
    return $text !== '' ? $text : 'item';
}

/** Ensure a slug is unique within a table. */
function unique_slug(string $table, string $slug, ?int $ignoreId = null): string
{
    $base = $slug;
    $i    = 1;
    while (true) {
        $sql    = "SELECT id FROM `{$table}` WHERE slug = ?";
        $params = [$slug];
        if ($ignoreId) {
            $sql     .= ' AND id <> ?';
            $params[] = $ignoreId;
        }
        if (!one($sql . ' LIMIT 1', $params)) {
            return $slug;
        }
        $slug = $base . '-' . (++$i);
    }
}

/** Allow a safe subset of HTML from the admin rich-text fields. */
function safe_html(?string $html): string
{
    $allowed = '<p><br><strong><b><em><i><u><h2><h3><h4><h5><ul><ol><li>'
             . '<a><blockquote><img><figure><figcaption><hr><table><thead>'
             . '<tbody><tr><th><td><span>';
    $html = strip_tags((string) $html, $allowed);
    // strip inline event handlers and javascript: urls
    $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? '';
    $html = preg_replace('/(href|src)\s*=\s*("|\')\s*javascript:[^"\']*\2/i', '$1="#"', $html) ?? '';
    return $html;
}

// ---------------------------------------------------------------------
//  URLs & assets
// ---------------------------------------------------------------------

/**
 * Base path the site is mounted on, e.g. '' or '/comfort'.
 *
 * Set 'base_path' => 'auto' in config.php to derive it from the front
 * controller's own location. That keeps one codebase correct whether it is
 * served from a domain root or a subfolder, with no config edit on deploy.
 */
function base_path(): string
{
    $configured = (string) ($GLOBALS['cf_config']['base_path'] ?? '');
    if ($configured !== 'auto') {
        return rtrim($configured, '/');
    }

    static $auto = null;
    if ($auto === null) {
        // Pretty URLs all rewrite to index.php, so SCRIPT_NAME is the mount
        // point regardless of the requested route: /sub/index.php => /sub.
        $dir = rtrim(str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? ''))), '/');
        // admin/index.php and admin/crud.php sit one level deeper.
        if (str_ends_with($dir, '/admin')) {
            $dir = substr($dir, 0, -6);
        }
        $auto = ($dir === '/' || $dir === '.') ? '' : $dir;
    }
    return $auto;
}

/** Build a site URL: url('news/my-post') => '/news/my-post'. */
function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    return base_path() . '/' . $path;
}

/** Absolute URL, for canonical tags and share links. */
function abs_url(string $path = ''): string
{
    $site = rtrim((string) ($GLOBALS['cf_config']['site_url'] ?? ''), '/');
    if ($site === '') {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $site   = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    }
    return $site . url($path);
}

/**
 * Asset URL with a cache-busting fingerprint taken from the file mtime,
 * so browsers can cache assets for a year and still see updates.
 */
function asset(string $path): string
{
    $path = ltrim($path, '/');
    $file = CF_ROOT . '/' . $path;
    $v    = is_file($file) ? substr((string) filemtime($file), -6) : '1';
    return base_path() . '/' . $path . '?v=' . $v;
}

/** Path to an uploaded or bundled image, with a fallback when missing. */
function media(?string $path, string $fallback = 'assets/images/blog/one.webp'): string
{
    $path = trim((string) $path);
    if ($path === '' || !is_file(CF_ROOT . '/' . ltrim($path, '/'))) {
        $path = $fallback;
    }
    return base_path() . '/' . ltrim($path, '/');
}

/**
 * Render an <img>. All bundled artwork is already WebP; uploads are
 * converted to WebP on upload, so a <picture> fallback is unnecessary
 * and we keep the markup light.
 *
 * @param array $opts alt, class, width, height, lazy (bool), sizes
 */
function img(?string $path, array $opts = []): string
{
    $src    = media($path, $opts['fallback'] ?? 'assets/images/blog/one.webp');
    $alt    = e($opts['alt'] ?? '');
    $class  = isset($opts['class']) ? ' class="' . e($opts['class']) . '"' : '';
    $lazy   = ($opts['lazy'] ?? true) ? ' loading="lazy" decoding="async"' : ' decoding="async" fetchpriority="high"';
    $w      = isset($opts['width'])  ? ' width="'  . (int) $opts['width']  . '"' : '';
    $h      = isset($opts['height']) ? ' height="' . (int) $opts['height'] . '"' : '';
    return '<img src="' . e($src) . '" alt="' . $alt . '"' . $class . $w . $h . $lazy . '>';
}

/** Is the current request for this path? Used for nav highlighting. */
function is_route(string ...$routes): bool
{
    $current = $GLOBALS['cf_route'] ?? '';
    foreach ($routes as $r) {
        if ($current === trim($r, '/')) {
            return true;
        }
    }
    return false;
}

/** Is the current route inside this section? */
function in_section(string $prefix): bool
{
    $current = (string) ($GLOBALS['cf_route'] ?? '');
    $prefix  = trim($prefix, '/');
    return $current === $prefix || str_starts_with($current, $prefix . '/');
}

function redirect(string $path, int $code = 302): void
{
    header('Location: ' . (preg_match('~^https?://~i', $path) ? $path : url($path)), true, $code);
    exit;
}

// ---------------------------------------------------------------------
//  Formatting
// ---------------------------------------------------------------------

function fmt_date($date, string $format = 'F j, Y'): string
{
    if (!$date) {
        return '';
    }
    try {
        return (new DateTimeImmutable((string) $date))->format($format);
    } catch (Throwable $e) {
        return '';
    }
}

function fmt_money($amount, string $currency = 'TZS'): string
{
    return $currency . ' ' . number_format((float) $amount, 0, '.', ',');
}

function fmt_phone_link(string $phone): string
{
    return 'tel:' . preg_replace('/[^0-9+]/', '', $phone);
}

// ---------------------------------------------------------------------
//  CSRF
// ---------------------------------------------------------------------

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function csrf_ok(): bool
{
    $sent = (string) ($_POST['_token'] ?? '');
    return $sent !== '' && !empty($_SESSION['csrf']) && hash_equals((string) $_SESSION['csrf'], $sent);
}

// ---------------------------------------------------------------------
//  Flash messages
// ---------------------------------------------------------------------

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function take_flash(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

function render_flash(): string
{
    $out = '';
    foreach (take_flash() as $f) {
        $cls  = $f['type'] === 'error' ? 'cf-alert--err' : 'cf-alert--ok';
        $icon = $f['type'] === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check';
        $out .= '<div class="cf-alert ' . $cls . '"><i class="fa-solid ' . $icon . '"></i> '
              . e($f['message']) . '</div>';
    }
    return $out;
}

// ---------------------------------------------------------------------
//  Input
// ---------------------------------------------------------------------

function post(string $key, string $default = ''): string
{
    $v = $_POST[$key] ?? $default;
    return is_string($v) ? trim($v) : $default;
}

function get(string $key, string $default = ''): string
{
    $v = $_GET[$key] ?? $default;
    return is_string($v) ? trim($v) : $default;
}

function post_int(string $key, int $default = 0): int
{
    return isset($_POST[$key]) ? (int) $_POST[$key] : $default;
}

function client_ip(): string
{
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
}

/** Simple per-session throttle for public forms. */
function throttle_ok(string $bucket, int $seconds = 20): bool
{
    $key  = 'throttle_' . $bucket;
    $last = (int) ($_SESSION[$key] ?? 0);
    if (time() - $last < $seconds) {
        return false;
    }
    $_SESSION[$key] = time();
    return true;
}

// ---------------------------------------------------------------------
//  View rendering
// ---------------------------------------------------------------------

/** Render a view file into a string. */
function view(string $name, array $data = []): string
{
    $file = CF_APP . '/views/' . $name . '.php';
    if (!is_file($file)) {
        return '';
    }
    extract($data, EXTR_SKIP);
    ob_start();
    include $file;
    return (string) ob_get_clean();
}

/** Render a partial straight to output. */
function partial(string $name, array $data = []): void
{
    echo view('partials/' . $name, $data);
}

/** Render a page inside the site layout. */
function render(string $page, array $data = []): void
{
    $data['content'] = view('pages/' . $page, $data);
    echo view('layouts/base', $data);
}

/** Build a pagination link set. */
function paginate(int $total, int $perPage, int $current, string $basePath): array
{
    $pages = max(1, (int) ceil($total / max(1, $perPage)));
    $current = max(1, min($current, $pages));
    return [
        'total'   => $total,
        'pages'   => $pages,
        'current' => $current,
        'offset'  => ($current - 1) * $perPage,
        'base'    => $basePath,
    ];
}
