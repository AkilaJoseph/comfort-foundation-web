<?php
/**
 * Comfort Foundation — DEMONSTRATION DATA
 * =====================================================================
 * Fills the tables that were empty so every page has something to show.
 *
 * !! EVERYTHING THIS SCRIPT WRITES IS PLACEHOLDER CONTENT !!
 * The staff members, photo captions, partner list, social links and the
 * impact figures are invented for layout purposes. Replace them in the
 * admin before this site goes public — the impact numbers in particular
 * are public claims about the organisation.
 *
 * Re-running is safe: every row it owns is tagged and cleared first.
 *
 *   php tools/seed-demo.php          seed (or re-seed)
 *   php tools/seed-demo.php --undo   remove only the demo rows
 */

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';
require CF_APP . '/cache.php';   // bootstrap does not load this; cache_clear() lives here

$undo = in_array('--undo', $argv, true);

/** Marker written into a column so the seeder can find its own rows again. */
const DEMO_TAG = '[demo]';

$pdo = db();

// ---------------------------------------------------------------------
//  Clear anything a previous run inserted
// ---------------------------------------------------------------------
$pdo->exec("DELETE FROM team_members WHERE slug LIKE 'demo-%'");
$pdo->exec("DELETE FROM gallery      WHERE title LIKE '%" . DEMO_TAG . "%'");
$pdo->exec("DELETE FROM events       WHERE slug  LIKE 'demo-%'");
$pdo->exec("DELETE FROM partners     WHERE name  LIKE '%" . DEMO_TAG . "%'");

if ($undo) {
    echo "Demo rows removed. Impact figures and social links were left as they are.\n";
    exit;
}

$ins = static function (string $table, array $row) use ($pdo): void {
    $cols = implode(', ', array_map(static fn($c) => "`$c`", array_keys($row)));
    $ph   = implode(', ', array_fill(0, count($row), '?'));
    $pdo->prepare("INSERT INTO `$table` ($cols) VALUES ($ph)")->execute(array_values($row));
};

// ---------------------------------------------------------------------
//  Team — fictional staff, for layout only
// ---------------------------------------------------------------------
$team = [
    ['Neema Joseph',    'Founder & Executive Director', 'one.webp',   'Leads strategy and partnerships, and has worked in community development across the Lake Zone for over a decade.'],
    ['Grace Mwakalinga','Programmes Manager',           'two.webp',   'Oversees delivery across all three programme areas and supports the district field teams.'],
    ['Daniel Shirima',  'Finance & Administration',     'three.webp', 'Manages budgeting, grant reporting and day-to-day operations at the Mwanza office.'],
    ['Amina Rashid',    'Womens Livelihoods Officer',   'four.webp',  'Trains and mentors village savings groups and runs the enterprise skills sessions.'],
    ['Peter Mahenge',   'Child Wellbeing Officer',      'five.webp',  'Runs school-based wellbeing sessions and coordinates referrals with local health facilities.'],
    ['Sarah Ndulu',     'Monitoring & Learning',        'six.webp',   'Tracks programme outcomes and turns field data into learning the team can act on.'],
];
foreach ($team as $i => [$name, $role, $img, $bio]) {
    $ins('team_members', [
        'slug'         => 'demo-' . slugify($name),
        'name'         => $name,
        'role_title'   => $role,
        'bio'          => $bio,
        'image'        => 'assets/images/team/' . $img,
        'email'        => '',
        'phone'        => '',
        'facebook'     => 'https://www.facebook.com/',
        'linkedin'     => 'https://www.linkedin.com/',
        'instagram'    => '',
        'twitter'      => '',
        'is_published' => 1,
        'sort_order'   => $i + 1,
    ]);
}

// ---------------------------------------------------------------------
//  Gallery — captions are placeholders
// ---------------------------------------------------------------------
$gallery = [
    ['Savings group meeting, Nyamagana',     'one.webp',   'Women & Livelihoods'],
    ['Enterprise skills session',            'two.webp',   'Women & Livelihoods'],
    ['Positive parenting workshop',          'three.webp', 'Parenting & Family'],
    ['Caregiver support circle',             'four.webp',  'Parenting & Family'],
    ['School wellbeing session',             'five.webp',  'Child Wellbeing'],
    ['Community outreach day',               'six.webp',   'Child Wellbeing'],
];
foreach ($gallery as $i => [$title, $img, $cat]) {
    $ins('gallery', [
        'title'      => $title . ' ' . DEMO_TAG,
        'image'      => 'assets/images/gallery/' . $img,
        'category'   => $cat,
        'sort_order' => $i + 1,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}

// ---------------------------------------------------------------------
//  Events — two upcoming, one past, so both tabs demonstrate
// ---------------------------------------------------------------------
$events = [
    ['Community Savings Group Launch', '+12 days', '+12 days 4 hours', 'Nyamagana District, Mwanza',
     'Launching three new village savings groups with training on record keeping and group governance.', 'event-six-thumb1.webp'],
    ['Positive Parenting Workshop',    '+26 days', '+26 days 6 hours', 'Ilemela District, Mwanza',
     'A one-day workshop for caregivers on communication, routines and responding to difficult behaviour.', 'event-six-thumb2.webp'],
    ['Childrens Wellbeing Day',        '-21 days', '-21 days 5 hours', 'Bangwe Secondary School, Mwanza',
     'A school open day focused on emotional wellbeing, with sessions for pupils, teachers and parents.', 'event-six-thumb3.webp'],
];
foreach ($events as [$title, $start, $end, $loc, $excerpt, $img]) {
    $ins('events', [
        'slug'         => 'demo-' . slugify($title),
        'title'        => $title,
        'starts_at'    => date('Y-m-d H:i:s', strtotime($start . ' 10:00')),
        'ends_at'      => date('Y-m-d H:i:s', strtotime($end)),
        'location'     => $loc,
        'excerpt'      => $excerpt,
        'body'         => $excerpt . ' Full details and how to take part will be shared closer to the date.',
        'image'        => 'assets/images/event/' . $img,
        'is_published' => 1,
        'created_at'   => date('Y-m-d H:i:s'),
        'updated_at'   => date('Y-m-d H:i:s'),
    ]);
}

// ---------------------------------------------------------------------
//  Partners — placeholder list
// ---------------------------------------------------------------------
$partners = [
    ['Lake Zone Health Network', 'one.webp'],
    ['Mwanza City Council',      'two.webp'],
    ['Tanzania Youth Alliance',  'three.webp'],
    ['Nyamagana Womens Union',   'four.webp'],
];
foreach ($partners as $i => [$name, $logo]) {
    $ins('partners', [
        'name'       => $name . ' ' . DEMO_TAG,
        'logo'       => 'assets/images/sponsor/' . $logo,
        'website'    => 'https://example.org/',
        'sort_order' => $i + 2,
    ]);
}

// The one real partner row had "fghjk" typed into its website field, which
// would render as a broken link. Blank it rather than invent a URL.
$pdo->prepare("UPDATE partners SET website = '' WHERE website = ?")->execute(['fghjk']);

// ---------------------------------------------------------------------
//  Impact figures — INVENTED. Replace before publishing.
// ---------------------------------------------------------------------
$impact = [
    'Women & girls reached'            => 1250,
    'Savings groups supported'         => 34,
    'Families in parenting programmes' => 480,
    'Children reached with support'    => 2100,
];
$up = $pdo->prepare('UPDATE impact_stats SET value = ? WHERE label = ?');
foreach ($impact as $label => $value) {
    $up->execute([$value, $label]);
}

// ---------------------------------------------------------------------
//  Social links — placeholder handles
// ---------------------------------------------------------------------
$socials = [
    'social_facebook'  => 'https://www.facebook.com/comfortfoundation',
    'social_twitter'   => 'https://x.com/comfortfoundation',
    'social_instagram' => 'https://www.instagram.com/comfortfoundation',
    'social_linkedin'  => 'https://www.linkedin.com/company/comfortfoundation',
    'social_youtube'   => 'https://www.youtube.com/@comfortfoundation',
];
$us = $pdo->prepare('UPDATE settings SET value = ? WHERE key_name = ?');
foreach ($socials as $key => $url) {
    $us->execute([$url, $key]);
}

cache_clear();

printf(
    "Seeded: %d team, %d gallery, %d events, %d partners, %d impact figures, %d social links.\n",
    count($team), count($gallery), count($events), count($partners), count($impact), count($socials)
);
echo "All of it is placeholder content — replace it in the admin before launch.\n";
