<?php
/** Shared navigation definition, used by the header and the mobile menu. */
function cf_nav(): array
{
    $rows = all('SELECT * FROM nav_items ORDER BY sort_order, id');

    $byParent = [];
    foreach ($rows as $r) {
        $byParent[(int) ($r['parent_id'] ?? 0)][] = $r;
    }

    $top = $byParent[0] ?? [];
    foreach ($top as &$item) {
        $children = $byParent[(int) $item['id']] ?? [];
        if (!empty($item['auto_programs'])) {
            $children = array_merge($children, array_map(
                static fn(array $p): array => ['label' => $p['title'], 'href' => 'programs/' . $p['slug']],
                programs()
            ));
        }
        if ($children) {
            $item['children'] = $children;
        }
    }
    unset($item);

    return $top;
}
