<?php
/** XML sitemap at /sitemap.xml (and /sitemap). */
declare(strict_types=1);

header('Content-Type: application/xml; charset=UTF-8');

$urls = [
    ['loc' => abs_url(),            'pri' => '1.0', 'freq' => 'weekly'],
    ['loc' => abs_url('about'),     'pri' => '0.9', 'freq' => 'monthly'],
    ['loc' => abs_url('programs'),  'pri' => '0.9', 'freq' => 'monthly'],
    ['loc' => abs_url('impact'),    'pri' => '0.8', 'freq' => 'monthly'],
    ['loc' => abs_url('team'),      'pri' => '0.7', 'freq' => 'monthly'],
    ['loc' => abs_url('news'),      'pri' => '0.9', 'freq' => 'weekly'],
    ['loc' => abs_url('events'),    'pri' => '0.8', 'freq' => 'weekly'],
    ['loc' => abs_url('gallery'),   'pri' => '0.6', 'freq' => 'monthly'],
    ['loc' => abs_url('donate'),    'pri' => '1.0', 'freq' => 'monthly'],
    ['loc' => abs_url('volunteer'), 'pri' => '0.8', 'freq' => 'monthly'],
    ['loc' => abs_url('partner'),   'pri' => '0.8', 'freq' => 'monthly'],
    ['loc' => abs_url('contact'),   'pri' => '0.8', 'freq' => 'monthly'],
    ['loc' => abs_url('faq'),       'pri' => '0.6', 'freq' => 'monthly'],
    ['loc' => abs_url('privacy'),   'pri' => '0.3', 'freq' => 'yearly'],
    ['loc' => abs_url('terms'),     'pri' => '0.3', 'freq' => 'yearly'],
];

if (db_ready()) {
    foreach (programs() as $p) {
        $urls[] = ['loc' => abs_url('programs/' . $p['slug']), 'pri' => '0.8', 'freq' => 'monthly', 'mod' => $p['updated_at']];
    }
    foreach (posts(500) as $p) {
        $urls[] = ['loc' => abs_url('news/' . $p['slug']), 'pri' => '0.7', 'freq' => 'monthly', 'mod' => $p['updated_at']];
    }
    foreach (events(500, 0, 'all') as $ev) {
        $urls[] = ['loc' => abs_url('events/' . $ev['slug']), 'pri' => '0.6', 'freq' => 'monthly', 'mod' => $ev['updated_at']];
    }
    foreach (team_members() as $m) {
        $urls[] = ['loc' => abs_url('team/' . $m['slug']), 'pri' => '0.5', 'freq' => 'yearly'];
    }
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    echo "  <url>\n";
    echo '    <loc>' . e($u['loc']) . "</loc>\n";
    if (!empty($u['mod'])) {
        echo '    <lastmod>' . e(fmt_date($u['mod'], 'Y-m-d')) . "</lastmod>\n";
    }
    echo '    <changefreq>' . e($u['freq']) . "</changefreq>\n";
    echo '    <priority>' . e($u['pri']) . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>';
