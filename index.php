<?php
/**
 * Comfort Foundation — public front controller.
 * Every public request enters here and is dispatched by path.
 */

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';
require CF_APP . '/cache.php';
require CF_APP . '/forms.php';

// ---------------------------------------------------------------------
//  Work out the requested route
// ---------------------------------------------------------------------
$uri  = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$base = base_path();
if ($base !== '' && str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}
$route  = trim(rawurldecode($uri), '/');
$route  = preg_replace('~[^a-zA-Z0-9/_.\-]~', '', $route) ?? '';
$route  = str_replace('..', '', $route);
if (str_ends_with($route, '.xml') || str_ends_with($route, '.php')) {
    $route = preg_replace('~\.(xml|php)$~', '', $route) ?? $route;
}
$parts  = $route === '' ? [] : explode('/', $route);
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

$GLOBALS['cf_route'] = $route;

// ---------------------------------------------------------------------
//  Serve from the page cache when we safely can
// ---------------------------------------------------------------------
if ($method === 'GET' && cache_serve($route)) {
    exit;
}

// ---------------------------------------------------------------------
//  Handle form posts before rendering anything
// ---------------------------------------------------------------------
if ($method === 'POST') {
    handle_form_post($route);
}

if (!db_ready()) {
    http_response_code(503);
    require CF_APP . '/views/setup-needed.php';
    exit;
}

cache_start($route, $method);

// ---------------------------------------------------------------------
//  Dispatch
// ---------------------------------------------------------------------
$head    = $parts[0] ?? '';
$sub     = $parts[1] ?? '';
$notFound = false;

switch ($head) {

    case '':
        render('home', [
            'title'       => setting('site_name', 'Comfort Foundation') . ' — ' . setting('site_tagline'),
            'description' => setting('meta_description'),
            'body_class'  => 'home',
        ]);
        break;

    case 'about':
        render('about', [
            'title'       => 'About Us',
            'description' => 'Comfort Foundation is a registered Tanzanian NGO in Mwanza working at the intersection of women\'s economic empowerment, family resilience and children\'s mental health.',
        ]);
        break;

    case 'programs':
        if ($sub === '') {
            render('programs', [
                'title'       => 'Our Programmes',
                'description' => 'Three interconnected focus areas: women\'s economic empowerment, positive parenting and family resilience, and children\'s mental health and wellbeing.',
            ]);
        } else {
            $program = program_by_slug($sub);
            if (!$program) {
                $notFound = true;
                break;
            }
            render('program-detail', [
                'title'       => $program['title'],
                'description' => excerpt($program['summary'], 155),
                'og_image'    => $program['image'],
                'program'     => $program,
            ]);
        }
        break;

    case 'impact':
        render('impact', [
            'title'       => 'Our Impact',
            'description' => 'What Comfort Foundation is working towards over the next five years, and how we measure progress.',
        ]);
        break;

    case 'team':
        if ($sub === '') {
            render('team', [
                'title'       => 'Our Team',
                'description' => 'The people leading Comfort Foundation\'s work with women, families and children in Mwanza.',
            ]);
        } else {
            $member = team_member_by_slug($sub);
            if (!$member) {
                $notFound = true;
                break;
            }
            render('team-detail', [
                'title'       => $member['name'],
                'description' => excerpt($member['bio'], 155) ?: $member['role_title'],
                'og_image'    => $member['image'],
                'member'      => $member,
            ]);
        }
        break;

    case 'news':
        if ($sub === '') {
            render('news', [
                'title'       => 'News & Stories',
                'description' => 'Updates, field stories and practical guidance from Comfort Foundation.',
            ]);
        } elseif ($sub === 'category' && isset($parts[2])) {
            $cat = category_by_slug($parts[2]);
            if (!$cat) {
                $notFound = true;
                break;
            }
            render('news', [
                'title'       => $cat['name'],
                'description' => 'News and stories filed under ' . $cat['name'] . '.',
                'category'    => $cat,
            ]);
        } else {
            $post = post_by_slug($sub);
            if (!$post) {
                $notFound = true;
                break;
            }
            q('UPDATE posts SET views = views + 1 WHERE id = ?', [$post['id']]);
            render('news-detail', [
                'title'       => $post['title'],
                'description' => excerpt($post['excerpt'] ?: $post['body'], 155),
                'og_image'    => $post['image'],
                'og_type'     => 'article',
                'post'        => $post,
            ]);
        }
        break;

    case 'events':
        if ($sub === '') {
            render('events', [
                'title'       => 'Events',
                'description' => 'Upcoming trainings, community sessions and Comfort Foundation gatherings.',
            ]);
        } else {
            $event = event_by_slug($sub);
            if (!$event) {
                $notFound = true;
                break;
            }
            render('event-detail', [
                'title'       => $event['title'],
                'description' => excerpt($event['excerpt'] ?: $event['body'], 155),
                'og_image'    => $event['image'],
                'event'       => $event,
            ]);
        }
        break;

    case 'gallery':
        render('gallery', [
            'title'       => 'Gallery',
            'description' => 'Photographs from Comfort Foundation programmes and community work.',
        ]);
        break;

    case 'donate':
        render('donate', [
            'title'       => 'Donate',
            'description' => 'Support women\'s livelihoods, family resilience and children\'s wellbeing in Mwanza. Give by bank transfer or mobile money.',
        ]);
        break;

    case 'volunteer':
        render('volunteer', [
            'title'       => 'Become a Volunteer',
            'description' => 'Give your skills and time to Comfort Foundation\'s work with women, families and children.',
        ]);
        break;

    case 'partner':
        render('partner', [
            'title'       => 'Partner With Us',
            'description' => 'Comfort Foundation partners with government, schools, health facilities, NGOs, development partners and the private sector.',
        ]);
        break;

    case 'contact':
        render('contact', [
            'title'       => 'Contact Us',
            'description' => 'Get in touch with Comfort Foundation in Nyamagana District, Mwanza, Tanzania.',
        ]);
        break;

    case 'faq':
        render('faq', [
            'title'       => 'Frequently Asked Questions',
            'description' => 'Common questions about Comfort Foundation, our programmes, giving and volunteering.',
        ]);
        break;

    case 'search':
        render('search', [
            'title'      => 'Search',
            'noindex'    => true,
        ]);
        break;

    case 'privacy':
        render('privacy', ['title' => 'Privacy Policy']);
        break;

    case 'terms':
        render('terms', ['title' => 'Terms & Conditions']);
        break;

    case 'sitemap':
        require CF_APP . '/sitemap.php';
        exit;

    default:
        $notFound = true;
}

if ($notFound) {
    cache_abort();
    http_response_code(404);
    render('404', ['title' => 'Page Not Found', 'noindex' => true]);
}

cache_finish($route);
