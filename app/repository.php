<?php
/**
 * Comfort Foundation — content queries.
 * Every read the front end performs lives here.
 */

declare(strict_types=1);

// ---------------------------------------------------------------------
//  Settings
// ---------------------------------------------------------------------

/** All settings as key => value, loaded once per request. */
function settings(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $cache = [];
    if (db_ready()) {
        foreach (all('SELECT key_name, value FROM settings') as $r) {
            $cache[$r['key_name']] = $r['value'];
        }
    }
    return $cache;
}

/** A single setting with a fallback. */
function setting(string $key, string $default = ''): string
{
    $s = settings();
    $v = $s[$key] ?? '';
    return ($v === null || $v === '') ? $default : (string) $v;
}

function settings_grouped(): array
{
    $out = [];
    foreach (all('SELECT * FROM settings ORDER BY sort_order, key_name') as $r) {
        $out[$r['group_name']][] = $r;
    }
    return $out;
}

/** Social links that have actually been filled in. */
function social_links(): array
{
    $map = [
        'facebook'  => ['social_facebook',  'fa-brands fa-facebook-f', 'Facebook'],
        'twitter'   => ['social_twitter',   'fa-brands fa-twitter',    'X (Twitter)'],
        'instagram' => ['social_instagram', 'fa-brands fa-instagram',  'Instagram'],
        'linkedin'  => ['social_linkedin',  'fa-brands fa-linkedin-in','LinkedIn'],
        'youtube'   => ['social_youtube',   'fa-brands fa-youtube',    'YouTube'],
    ];
    $out = [];
    foreach ($map as $key => [$settingKey, $icon, $label]) {
        $url = setting($settingKey);
        if ($url !== '') {
            $out[] = ['url' => $url, 'icon' => $icon, 'label' => $label];
        }
    }
    return $out;
}

// ---------------------------------------------------------------------
//  Programmes
// ---------------------------------------------------------------------

function programs(int $limit = 0): array
{
    $sql = 'SELECT * FROM programs WHERE is_published = 1 ORDER BY sort_order, id';
    if ($limit > 0) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return all($sql);
}

function program_by_slug(string $slug): ?array
{
    return one('SELECT * FROM programs WHERE slug = ? AND is_published = 1 LIMIT 1', [$slug]);
}

// ---------------------------------------------------------------------
//  News / posts
// ---------------------------------------------------------------------

function posts(int $limit = 6, int $offset = 0, ?int $categoryId = null, string $search = ''): array
{
    $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug
              FROM posts p
         LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_published = 1';
    $params = [];
    if ($categoryId) {
        $sql     .= ' AND p.category_id = ?';
        $params[] = $categoryId;
    }
    if ($search !== '') {
        $sql     .= ' AND (p.title LIKE ? OR p.excerpt LIKE ? OR p.body LIKE ?)';
        $like     = '%' . $search . '%';
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }
    $sql .= ' ORDER BY p.published_at DESC, p.id DESC LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;
    return all($sql, $params);
}

function posts_count(?int $categoryId = null, string $search = ''): int
{
    $sql    = 'SELECT COUNT(*) FROM posts WHERE is_published = 1';
    $params = [];
    if ($categoryId) {
        $sql     .= ' AND category_id = ?';
        $params[] = $categoryId;
    }
    if ($search !== '') {
        $sql     .= ' AND (title LIKE ? OR excerpt LIKE ? OR body LIKE ?)';
        $like     = '%' . $search . '%';
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }
    return (int) scalar($sql, $params, 0);
}

function post_by_slug(string $slug): ?array
{
    return one(
        'SELECT p.*, c.name AS category_name, c.slug AS category_slug
           FROM posts p
      LEFT JOIN categories c ON c.id = p.category_id
          WHERE p.slug = ? AND p.is_published = 1
          LIMIT 1',
        [$slug]
    );
}

function post_neighbours(int $id, ?string $publishedAt): array
{
    $prev = one('SELECT slug, title FROM posts WHERE is_published = 1 AND id < ? ORDER BY id DESC LIMIT 1', [$id]);
    $next = one('SELECT slug, title FROM posts WHERE is_published = 1 AND id > ? ORDER BY id ASC  LIMIT 1', [$id]);
    return ['prev' => $prev, 'next' => $next];
}

function categories_with_counts(): array
{
    return all(
        'SELECT c.id, c.slug, c.name, COUNT(p.id) AS total
           FROM categories c
      LEFT JOIN posts p ON p.category_id = c.id AND p.is_published = 1
       GROUP BY c.id, c.slug, c.name
       ORDER BY c.name'
    );
}

function category_by_slug(string $slug): ?array
{
    return one('SELECT * FROM categories WHERE slug = ? LIMIT 1', [$slug]);
}

// ---------------------------------------------------------------------
//  Events
// ---------------------------------------------------------------------

function events(int $limit = 6, int $offset = 0, string $when = 'all'): array
{
    $sql = 'SELECT * FROM events WHERE is_published = 1';
    if ($when === 'upcoming') {
        $sql .= ' AND (starts_at IS NULL OR starts_at >= NOW())';
    } elseif ($when === 'past') {
        $sql .= ' AND starts_at < NOW()';
    }
    $dir  = ($when === 'past') ? 'DESC' : 'ASC';
    $sql .= " ORDER BY starts_at {$dir}, id DESC LIMIT " . (int) $limit . ' OFFSET ' . (int) $offset;
    return all($sql);
}

function events_count(string $when = 'all'): int
{
    $sql = 'SELECT COUNT(*) FROM events WHERE is_published = 1';
    if ($when === 'upcoming') {
        $sql .= ' AND (starts_at IS NULL OR starts_at >= NOW())';
    } elseif ($when === 'past') {
        $sql .= ' AND starts_at < NOW()';
    }
    return (int) scalar($sql, [], 0);
}

function event_by_slug(string $slug): ?array
{
    return one('SELECT * FROM events WHERE slug = ? AND is_published = 1 LIMIT 1', [$slug]);
}

// ---------------------------------------------------------------------
//  Team
// ---------------------------------------------------------------------

function team_members(int $limit = 0): array
{
    $sql = 'SELECT * FROM team_members WHERE is_published = 1 ORDER BY sort_order, id';
    if ($limit > 0) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return all($sql);
}

function team_member_by_slug(string $slug): ?array
{
    return one('SELECT * FROM team_members WHERE slug = ? AND is_published = 1 LIMIT 1', [$slug]);
}

// ---------------------------------------------------------------------
//  Everything else
// ---------------------------------------------------------------------

function gallery_items(int $limit = 0): array
{
    $sql = 'SELECT * FROM gallery ORDER BY sort_order, id DESC';
    if ($limit > 0) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return all($sql);
}

function gallery_categories(): array
{
    return array_column(all('SELECT DISTINCT category FROM gallery ORDER BY category'), 'category');
}

function impact_stats(): array
{
    return all('SELECT * FROM impact_stats ORDER BY sort_order, id');
}

function partners(): array
{
    return all('SELECT * FROM partners ORDER BY sort_order, id');
}

function testimonials(): array
{
    return all('SELECT * FROM testimonials ORDER BY sort_order, id');
}

function faqs(): array
{
    return all('SELECT * FROM faqs ORDER BY sort_order, id');
}

/** The three-step approach model (EQUIP / STRENGTHEN / TRANSFORM), admin-managed. */
function approach_steps(): array
{
    $keys = ['equip', 'strengthen', 'transform'];
    $rows = all('SELECT * FROM approach_steps ORDER BY sort_order, id');
    foreach ($rows as $i => &$r) {
        $r['key'] = $keys[$i % 3];
    }
    unset($r);
    return $rows;
}

/** Core values, admin-managed. */
function core_values(): array
{
    return all('SELECT * FROM core_values ORDER BY sort_order, id');
}

/** Hero banner slides shown on the home page. */
function home_slides(): array
{
    return all('SELECT * FROM home_slides WHERE is_published = 1 ORDER BY sort_order, id');
}

/** Who our programmes are designed for and with. */
function beneficiaries(): array
{
    return array_column(all('SELECT text FROM beneficiaries ORDER BY sort_order, id'), 'text');
}

/** Partnership strategy, from the organisational profile. */
function partnership_types(): array
{
    return all('SELECT * FROM partnership_types ORDER BY sort_order, id');
}

/** Expected five-year impact, from the organisational profile. */
function long_term_impact(): array
{
    return array_column(all('SELECT text FROM long_term_impact ORDER BY sort_order, id'), 'text');
}

// ---------------------------------------------------------------------
//  Submissions
// ---------------------------------------------------------------------

function store_submission(string $kind, array $data): int
{
    return insert_row('submissions', [
        'kind'    => $kind,
        'name'    => mb_substr($data['name']    ?? '', 0, 190),
        'email'   => mb_substr($data['email']   ?? '', 0, 190),
        'phone'   => mb_substr($data['phone']   ?? '', 0, 60),
        'subject' => mb_substr($data['subject'] ?? '', 0, 220),
        'message' => $data['message'] ?? '',
        'payload' => isset($data['payload']) ? json_encode($data['payload'], JSON_UNESCAPED_UNICODE) : null,
        'ip'      => client_ip(),
    ]);
}
