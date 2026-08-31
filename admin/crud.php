<?php
/**
 * Comfort Foundation — generic admin CRUD.
 *
 * Each managed content type is described once in admin_entities();
 * listing, creating, editing and deleting are then handled generically.
 */

declare(strict_types=1);

/** Render an admin view inside the admin layout. */
function admin_view(string $name, array $data = []): void
{
    $file = __DIR__ . '/views/' . $name . '.php';
    if (!is_file($file)) {
        http_response_code(404);
        $file = __DIR__ . '/views/404.php';
    }
    extract($data, EXTR_SKIP);
    ob_start();
    include $file;
    $content = (string) ob_get_clean();

    if ($name === 'login') {
        include __DIR__ . '/views/layout-blank.php';
        return;
    }
    include __DIR__ . '/views/layout.php';
}

/**
 * Definition of every content type the admin can manage.
 *
 * field types: text, textarea, richtext, number, decimal, date, datetime,
 *              select, checkbox, image, slug
 */
function admin_entities(): array
{
    return [
        'home_slides' => [
            'label'    => 'Home Banner Slides',
            'singular' => 'Slide',
            'icon'     => 'fa-panorama',
            'table'    => 'home_slides',
            'order'    => 'sort_order, id',
            'columns'  => ['eyebrow' => 'Eyebrow', 'title' => 'Title', 'is_published' => 'Published', 'sort_order' => 'Order'],
            'fields'   => [
                'eyebrow'      => ['label' => 'Eyebrow', 'type' => 'text', 'hint' => 'Small label shown above the headline.'],
                'title'        => ['label' => 'Headline', 'type' => 'textarea', 'required' => true, 'hint' => 'Plain text, or wrap one word in &lt;span class="bottom-line"&gt;word&lt;/span&gt; to underline it like the others (this field is deliberately a plain box, not the rich editor, so that HTML still works).'],
                'image'        => ['label' => 'Background photo', 'type' => 'image', 'aspect' => '16/9'],
                'sort_order'   => ['label' => 'Sort order', 'type' => 'number'],
                'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'default' => 1],
            ],
        ],

        'core_values' => [
            'label'    => 'Core Values',
            'singular' => 'Value',
            'icon'     => 'fa-heart-circle-check',
            'table'    => 'core_values',
            'order'    => 'sort_order, id',
            'columns'  => ['title' => 'Title', 'icon' => 'Icon', 'sort_order' => 'Order'],
            'fields'   => [
                'title'      => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'icon'       => ['label' => 'Icon class', 'type' => 'text', 'default' => 'icon-donation', 'hint' => 'e.g. icon-spread-love, icon-support-heart, icon-fund, icon-health, icon-heart-hand'],
                'text'       => ['label' => 'Description', 'type' => 'textarea'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'approach_steps' => [
            'label'    => 'Our Approach Steps',
            'singular' => 'Step',
            'icon'     => 'fa-route',
            'table'    => 'approach_steps',
            'order'    => 'sort_order, id',
            'columns'  => ['title' => 'Title', 'sort_order' => 'Order'],
            'fields'   => [
                'title'      => ['label' => 'Title', 'type' => 'text', 'required' => true, 'hint' => 'The first three, in order, colour as Equip / Strengthen / Transform.'],
                'text'       => ['label' => 'Description', 'type' => 'textarea'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'programs' => [
            'label'    => 'Programmes',
            'singular' => 'Programme',
            'icon'     => 'fa-diagram-project',
            'table'    => 'programs',
            'order'    => 'sort_order, id',
            'columns'  => ['number' => 'No.', 'title' => 'Title', 'is_published' => 'Published', 'sort_order' => 'Order'],
            'slug_from'=> 'title',
            'fields'   => [
                'title'        => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'number'       => ['label' => 'Number', 'type' => 'text', 'hint' => 'e.g. 01'],
                'icon'         => ['label' => 'Icon class', 'type' => 'text', 'hint' => 'e.g. icon-fund, icon-health, icon-spread-love'],
                'summary'      => ['label' => 'Short summary', 'type' => 'textarea', 'hint' => 'Shown on cards and listings.'],
                'body'         => ['label' => 'Full description', 'type' => 'richtext'],
                'image'        => ['label' => 'Image', 'type' => 'image', 'aspect' => '4/3'],
                'sort_order'   => ['label' => 'Sort order', 'type' => 'number'],
                'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'default' => 1],
            ],
        ],

        'posts' => [
            'label'    => 'News & Stories',
            'singular' => 'Article',
            'icon'     => 'fa-newspaper',
            'table'    => 'posts',
            'order'    => 'published_at DESC, id DESC',
            'columns'  => ['title' => 'Title', 'published_at' => 'Published', 'is_published' => 'Live', 'views' => 'Views'],
            'slug_from'=> 'title',
            'fields'   => [
                'title'        => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'category_id'  => ['label' => 'Category', 'type' => 'select', 'options' => 'categories'],
                'author'       => ['label' => 'Author', 'type' => 'text', 'default' => 'Comfort Foundation'],
                'excerpt'      => ['label' => 'Summary', 'type' => 'textarea', 'hint' => 'One or two sentences, shown on listing cards.'],
                'body'         => ['label' => 'Article', 'type' => 'richtext'],
                'image'        => ['label' => 'Featured image', 'type' => 'image', 'aspect' => '16/9'],
                'published_at' => ['label' => 'Publish date', 'type' => 'date'],
                'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'default' => 1],
            ],
        ],

        'events' => [
            'label'    => 'Events',
            'singular' => 'Event',
            'icon'     => 'fa-calendar-days',
            'table'    => 'events',
            'order'    => 'starts_at DESC, id DESC',
            'columns'  => ['title' => 'Title', 'starts_at' => 'Starts', 'location' => 'Location', 'is_published' => 'Live'],
            'slug_from'=> 'title',
            'fields'   => [
                'title'        => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'starts_at'    => ['label' => 'Starts', 'type' => 'datetime'],
                'ends_at'      => ['label' => 'Ends', 'type' => 'datetime'],
                'location'     => ['label' => 'Location', 'type' => 'text'],
                'excerpt'      => ['label' => 'Summary', 'type' => 'textarea'],
                'body'         => ['label' => 'Details', 'type' => 'richtext'],
                'image'        => ['label' => 'Image', 'type' => 'image', 'aspect' => '16/9'],
                'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'default' => 1],
            ],
        ],

        'team' => [
            'label'    => 'Team',
            'singular' => 'Team member',
            'icon'     => 'fa-users',
            'table'    => 'team_members',
            'order'    => 'sort_order, id',
            'columns'  => ['name' => 'Name', 'role_title' => 'Role', 'is_published' => 'Published', 'sort_order' => 'Order'],
            'slug_from'=> 'name',
            'fields'   => [
                'name'         => ['label' => 'Full name', 'type' => 'text', 'required' => true],
                'role_title'   => ['label' => 'Role / title', 'type' => 'text'],
                'bio'          => ['label' => 'Biography', 'type' => 'richtext'],
                'image'        => ['label' => 'Photo', 'type' => 'image', 'aspect' => '3/4'],
                'email'        => ['label' => 'Email', 'type' => 'text'],
                'phone'        => ['label' => 'Phone', 'type' => 'text'],
                'facebook'     => ['label' => 'Facebook URL', 'type' => 'text'],
                'twitter'      => ['label' => 'X / Twitter URL', 'type' => 'text'],
                'instagram'    => ['label' => 'Instagram URL', 'type' => 'text'],
                'linkedin'     => ['label' => 'LinkedIn URL', 'type' => 'text'],
                'sort_order'   => ['label' => 'Sort order', 'type' => 'number'],
                'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'default' => 1],
            ],
        ],

        'gallery' => [
            'label'    => 'Gallery',
            'singular' => 'Photo',
            'icon'     => 'fa-images',
            'table'    => 'gallery',
            'order'    => 'sort_order, id DESC',
            'columns'  => ['title' => 'Title', 'category' => 'Category', 'sort_order' => 'Order'],
            'fields'   => [
                'title'      => ['label' => 'Caption', 'type' => 'text'],
                'image'      => ['label' => 'Photo', 'type' => 'image', 'required' => true],
                'category'   => ['label' => 'Category', 'type' => 'text', 'default' => 'General'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'categories' => [
            'label'    => 'Categories',
            'singular' => 'Category',
            'icon'     => 'fa-tags',
            'table'    => 'categories',
            'order'    => 'name',
            'columns'  => ['name' => 'Name', 'slug' => 'Slug'],
            'slug_from'=> 'name',
            'fields'   => [
                'name' => ['label' => 'Name', 'type' => 'text', 'required' => true],
            ],
        ],

        'impact' => [
            'label'    => 'Impact Numbers',
            'singular' => 'Statistic',
            'icon'     => 'fa-chart-simple',
            'table'    => 'impact_stats',
            'order'    => 'sort_order, id',
            'columns'  => ['label' => 'Label', 'value' => 'Value', 'suffix' => 'Suffix', 'sort_order' => 'Order'],
            'fields'   => [
                'label'      => ['label' => 'Label', 'type' => 'text', 'required' => true],
                'value'      => ['label' => 'Number', 'type' => 'number'],
                'suffix'     => ['label' => 'Suffix', 'type' => 'text', 'default' => '+', 'hint' => 'e.g. + or %'],
                'icon'       => ['label' => 'Icon class', 'type' => 'text', 'default' => 'icon-support-heart'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'partners' => [
            'label'    => 'Partners',
            'singular' => 'Partner',
            'icon'     => 'fa-handshake',
            'table'    => 'partners',
            'order'    => 'sort_order, id',
            'columns'  => ['name' => 'Name', 'website' => 'Website', 'sort_order' => 'Order'],
            'fields'   => [
                'name'       => ['label' => 'Name', 'type' => 'text', 'required' => true],
                'logo'       => ['label' => 'Logo', 'type' => 'image'],
                'website'    => ['label' => 'Website', 'type' => 'text'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'testimonials' => [
            'label'    => 'Testimonials',
            'singular' => 'Testimonial',
            'icon'     => 'fa-quote-left',
            'table'    => 'testimonials',
            'order'    => 'sort_order, id',
            'columns'  => ['author' => 'Author', 'role_title' => 'Role', 'rating' => 'Rating'],
            'fields'   => [
                'author'     => ['label' => 'Author', 'type' => 'text', 'required' => true],
                'role_title' => ['label' => 'Role / context', 'type' => 'text'],
                'quote'      => ['label' => 'Quote', 'type' => 'textarea', 'required' => true],
                'image'      => ['label' => 'Photo', 'type' => 'image', 'aspect' => '1/1'],
                'rating'     => ['label' => 'Stars (1–5)', 'type' => 'number', 'default' => 5],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'faqs' => [
            'label'    => 'FAQ',
            'singular' => 'Question',
            'icon'     => 'fa-circle-question',
            'table'    => 'faqs',
            'order'    => 'sort_order, id',
            'columns'  => ['question' => 'Question', 'sort_order' => 'Order'],
            'fields'   => [
                'question'   => ['label' => 'Question', 'type' => 'text', 'required' => true],
                'answer'     => ['label' => 'Answer', 'type' => 'textarea', 'required' => true],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'beneficiaries' => [
            'label'    => 'Who We Serve',
            'singular' => 'Beneficiary group',
            'icon'     => 'fa-people-group',
            'table'    => 'beneficiaries',
            'order'    => 'sort_order, id',
            'columns'  => ['text' => 'Description', 'sort_order' => 'Order'],
            'fields'   => [
                'text'       => ['label' => 'Description', 'type' => 'text', 'required' => true, 'hint' => 'Shown as one line on the About page — e.g. "Women and girls facing economic vulnerability".'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'partnership_types' => [
            'label'    => 'Partnership Types',
            'singular' => 'Partnership type',
            'icon'     => 'fa-handshake-angle',
            'table'    => 'partnership_types',
            'order'    => 'sort_order, id',
            'columns'  => ['title' => 'Title', 'sort_order' => 'Order'],
            'fields'   => [
                'title'      => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'text'       => ['label' => 'Description', 'type' => 'textarea', 'required' => true],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],

        'long_term_impact' => [
            'label'    => 'Long-Term Impact',
            'singular' => 'Impact statement',
            'icon'     => 'fa-seedling',
            'table'    => 'long_term_impact',
            'order'    => 'sort_order, id',
            'columns'  => ['text' => 'Statement', 'sort_order' => 'Order'],
            'fields'   => [
                'text'       => ['label' => 'Statement', 'type' => 'text', 'required' => true, 'hint' => 'Shown on the Impact page as one expected five-year outcome.'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
            ],
        ],
    ];
}

/** Options for a select field. */
function admin_options(string $source): array
{
    return match ($source) {
        'categories' => array_column(all('SELECT id, name FROM categories ORDER BY name'), 'name', 'id'),
        default      => [],
    };
}

/** Route an entity request to list / form / save / delete. */
function admin_handle_entity(string $section, array $def, string $action, string $method): void
{
    switch ($action) {

        case 'create':
        case 'edit':
            $id  = (int) get('id');
            $row = $id ? one('SELECT * FROM `' . $def['table'] . '` WHERE id = ?', [$id]) : null;
            if ($action === 'edit' && !$row) {
                flash('error', 'That item no longer exists.');
                redirect('admin/' . $section);
            }
            admin_view('form', [
                'title'   => ($row ? 'Edit ' : 'New ') . strtolower($def['singular']),
                'section' => $section,
                'def'     => $def,
                'row'     => $row ?? [],
            ]);
            break;

        case 'save':
            if ($method !== 'POST' || !csrf_ok()) {
                flash('error', 'Your session expired. Please try again.');
                redirect('admin/' . $section);
            }
            admin_save($section, $def);
            break;

        case 'delete':
            if ($method !== 'POST' || !csrf_ok()) {
                redirect('admin/' . $section);
            }
            $id  = post_int('id');
            $row = one('SELECT * FROM `' . $def['table'] . '` WHERE id = ?', [$id]);
            if ($row) {
                foreach ($def['fields'] as $name => $f) {
                    if ($f['type'] === 'image' && !empty($row[$name])) {
                        delete_upload($row[$name]);
                    }
                }
                delete_row($def['table'], $id);
                cache_clear();
                flash('success', $def['singular'] . ' deleted.');
            }
            redirect('admin/' . $section);
            break;

        default:
            admin_view('list', [
                'title'   => $def['label'],
                'section' => $section,
                'def'     => $def,
            ]);
    }
}

/** Validate and persist a submitted entity form. */
function admin_save(string $section, array $def): void
{
    $id     = post_int('id');
    $data   = [];
    $errors = [];
    $existing = $id ? one('SELECT * FROM `' . $def['table'] . '` WHERE id = ?', [$id]) : null;

    foreach ($def['fields'] as $name => $f) {
        $type = $f['type'];

        if ($type === 'image') {
            $keep = post($name . '_existing');
            $path = $keep;

            if (!empty($_FILES[$name]['name'])) {
                $res = handle_upload($_FILES[$name]);
                if ($res['ok']) {
                    if ($keep !== '' && $keep !== $res['path']) {
                        delete_upload($keep);
                    }
                    $path = $res['path'];
                } else {
                    $errors[] = $f['label'] . ': ' . $res['error'];
                }
            }
            if (post($name . '_remove') === '1' && $path !== '') {
                delete_upload($path);
                $path = '';
            }
            if (!empty($f['required']) && $path === '') {
                $errors[] = $f['label'] . ' is required.';
            }
            $data[$name] = $path;
            continue;
        }

        if ($type === 'checkbox') {
            $data[$name] = post($name) === '1' ? 1 : 0;
            continue;
        }

        $value = post($name);

        if (!empty($f['required']) && $value === '') {
            $errors[] = $f['label'] . ' is required.';
        }

        $data[$name] = match ($type) {
            'number'   => $value === '' ? (int) ($f['default'] ?? 0) : (int) $value,
            'decimal'  => $value === '' ? 0 : (float) str_replace(',', '', $value),
            'select'   => $value === '' ? null : (int) $value,
            'date'     => $value === '' ? null : $value,
            'datetime' => $value === '' ? null : str_replace('T', ' ', $value) . (strlen($value) === 16 ? ':00' : ''),
            'richtext' => safe_html($value),
            default    => $value,
        };
    }

    if ($errors) {
        flash('error', implode(' ', $errors));
        $_SESSION['old'] = $_POST;
        redirect('admin/' . $section . '/' . ($id ? 'edit?id=' . $id : 'create'));
    }

    // ---- slug ----
    if (!empty($def['slug_from'])) {
        $source = (string) ($data[$def['slug_from']] ?? '');
        $wanted = post('slug') !== '' ? slugify(post('slug')) : slugify($source);
        $data['slug'] = unique_slug($def['table'], $wanted, $id ?: null);
    }

    // ---- defaults for new rows ----
    if (!$id) {
        if (isset($def['fields']['published_at']) && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d');
        }
    }

    unset($_SESSION['old']);

    if ($id && $existing) {
        update_row($def['table'], $id, $data);
        flash('success', $def['singular'] . ' updated.');
    } else {
        $id = insert_row($def['table'], $data);
        flash('success', $def['singular'] . ' created.');
    }

    cache_clear();
    redirect('admin/' . $section . '/edit?id=' . $id);
}

/** Count unread inbox items, for the sidebar badge. */
function admin_unread_count(): int
{
    return (int) scalar('SELECT COUNT(*) FROM submissions WHERE is_read = 0', [], 0);
}
