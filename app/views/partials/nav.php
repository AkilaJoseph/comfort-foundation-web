<?php
/** Shared navigation definition, used by the header and the mobile menu. */
function cf_nav(): array
{
    return [
        ['label' => 'Home',    'href' => ''],
        ['label' => 'About',   'href' => 'about'],
        ['label' => 'Programmes', 'href' => 'programs', 'children' => array_merge(
            [['label' => 'All Programmes', 'href' => 'programs']],
            array_map(
                static fn(array $p): array => ['label' => $p['title'], 'href' => 'programs/' . $p['slug']],
                programs()
            )
        )],
        ['label' => 'Get Involved', 'href' => 'donate', 'children' => [
            ['label' => 'Donate',            'href' => 'donate'],
            ['label' => 'Become a Volunteer','href' => 'volunteer'],
            ['label' => 'Partner With Us',   'href' => 'partner'],
        ]],
        ['label' => 'News & Events', 'href' => 'news', 'children' => [
            ['label' => 'News & Stories', 'href' => 'news'],
            ['label' => 'Events',         'href' => 'events'],
            ['label' => 'Gallery',        'href' => 'gallery'],
        ]],
        ['label' => 'About Us More', 'href' => 'impact', 'children' => [
            ['label' => 'Our Impact', 'href' => 'impact'],
            ['label' => 'Our Team',   'href' => 'team'],
            ['label' => 'FAQ',        'href' => 'faq'],
        ]],
        ['label' => 'Contact', 'href' => 'contact'],
    ];
}
