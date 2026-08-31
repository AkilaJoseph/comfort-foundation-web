<?php
/**
 * Comfort Foundation — admin front controller.
 * URLs:  /admin, /admin/posts, /admin/posts/edit?id=3 …
 */

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';
require CF_APP . '/auth.php';
require CF_APP . '/uploads.php';
require CF_APP . '/cache.php';
require __DIR__ . '/crud.php';

// ---- resolve the admin route ----------------------------------------
$uri  = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$base = base_path();
if ($base !== '' && str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}
$path  = trim(preg_replace('~[^a-zA-Z0-9/_\-]~', '', trim($uri, '/')) ?? '', '/');
$path  = preg_replace('~^admin/?~', '', $path) ?? '';
$parts = $path === '' ? [] : explode('/', $path);
$section = $parts[0] ?? '';
$action  = $parts[1] ?? 'list';
$method  = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

$GLOBALS['cf_admin_section'] = $section;

// ---- database must be ready -----------------------------------------
if (!db_ready()) {
    http_response_code(503);
    require CF_APP . '/views/setup-needed.php';
    exit;
}

// ---- login / logout --------------------------------------------------
if ($section === 'login') {
    if (auth_check()) {
        redirect('admin');
    }
    if ($method === 'POST') {
        if (!csrf_ok()) {
            flash('error', 'Your session expired. Please try again.');
        } elseif (login_locked()) {
            flash('error', 'Too many failed attempts. Please wait five minutes.');
        } elseif (auth_attempt(post('email'), (string) ($_POST['password'] ?? ''))) {
            login_succeeded();
            $next = $_SESSION['after_login'] ?? '';
            unset($_SESSION['after_login']);
            redirect($next && str_contains($next, '/admin') ? $next : 'admin');
        } else {
            login_failed();
            flash('error', 'Those details were not recognised.');
        }
        redirect('admin/login');
    }
    admin_view('login', ['title' => 'Sign in']);
    exit;
}

if ($section === 'logout') {
    auth_logout();
    flash('success', 'You have been signed out.');
    redirect('admin/login');
}

// ---- everything below requires a session ------------------------------
auth_require();

// ---- entity CRUD ------------------------------------------------------
$entities = admin_entities();

if (isset($entities[$section])) {
    admin_handle_entity($section, $entities[$section], $action, $method);
    exit;
}

switch ($section) {

    case '':
        admin_view('dashboard', ['title' => 'Dashboard']);
        break;

    case 'inbox':
        if ($action === 'view') {
            $id  = (int) get('id');
            $row = one('SELECT * FROM submissions WHERE id = ?', [$id]);
            if (!$row) {
                flash('error', 'That submission no longer exists.');
                redirect('admin/inbox');
            }
            if (!$row['is_read']) {
                update_row('submissions', $id, ['is_read' => 1]);
                $row['is_read'] = 1;
            }
            admin_view('inbox-view', ['title' => 'Submission', 'row' => $row]);
        } elseif ($action === 'delete' && $method === 'POST') {
            if (csrf_ok()) {
                delete_row('submissions', (int) post_int('id'));
                flash('success', 'Submission deleted.');
            }
            redirect('admin/inbox');
        } else {
            admin_view('inbox', ['title' => 'Inbox']);
        }
        break;

    case 'settings':
        if ($method === 'POST') {
            if (!csrf_ok()) {
                flash('error', 'Your session expired. Please try again.');
                redirect('admin/settings');
            }
            $values = $_POST['settings'] ?? [];
            if (is_array($values)) {
                foreach ($values as $key => $val) {
                    q('UPDATE settings SET value = ? WHERE key_name = ?', [is_string($val) ? trim($val) : '', (string) $key]);
                }
            }

            // Image-type settings: same upload/replace/remove flow as the
            // entity image fields, just keyed by settings.key_name instead
            // of a table column.
            $existing = $_POST['settings_image_existing'] ?? [];
            $removes  = $_POST['settings_image_remove'] ?? [];
            $files    = $_FILES['settings_image'] ?? [];
            if (is_array($existing)) {
                foreach ($existing as $key => $keep) {
                    $path = (string) $keep;
                    $hasFile = !empty($files['name'][$key] ?? '');
                    if ($hasFile) {
                        $file = [
                            'name'     => $files['name'][$key],
                            'type'     => $files['type'][$key],
                            'tmp_name' => $files['tmp_name'][$key],
                            'error'    => $files['error'][$key],
                            'size'     => $files['size'][$key],
                        ];
                        $res = handle_upload($file);
                        if ($res['ok']) {
                            if ($path !== '' && $path !== $res['path']) {
                                delete_upload($path);
                            }
                            $path = $res['path'];
                        }
                    } elseif (!empty($removes[$key])) {
                        delete_upload($path);
                        $path = '';
                    }
                    q('UPDATE settings SET value = ? WHERE key_name = ?', [$path, (string) $key]);
                }
            }

            cache_clear();
            flash('success', 'Settings saved.');
            redirect('admin/settings');
        }
        admin_view('settings', ['title' => 'Site Settings']);
        break;

    case 'account':
        if ($method === 'POST') {
            if (!csrf_ok()) {
                flash('error', 'Your session expired. Please try again.');
                redirect('admin/account');
            }
            $me      = auth_user();
            $name    = post('name');
            $email   = post('email');
            $current = (string) ($_POST['current_password'] ?? '');
            $new     = (string) ($_POST['new_password'] ?? '');
            $confirm = (string) ($_POST['confirm_password'] ?? '');

            $errors = [];
            if (mb_strlen($name) < 2) {
                $errors[] = 'Please enter your name.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            }
            $clash = one('SELECT id FROM users WHERE email = ? AND id <> ?', [$email, $me['id']]);
            if ($clash) {
                $errors[] = 'Another account already uses that email address.';
            }

            $data = ['name' => $name, 'email' => $email];

            if ($new !== '' || $confirm !== '' || $current !== '') {
                $row = one('SELECT password_hash FROM users WHERE id = ?', [$me['id']]);
                if (!$row || !password_verify($current, (string) $row['password_hash'])) {
                    $errors[] = 'Your current password is not correct.';
                } elseif (strlen($new) < 10) {
                    $errors[] = 'Choose a new password of at least 10 characters.';
                } elseif ($new !== $confirm) {
                    $errors[] = 'The new passwords do not match.';
                } else {
                    $data['password_hash'] = password_hash($new, PASSWORD_DEFAULT);
                }
            }

            if ($errors) {
                flash('error', implode(' ', $errors));
            } else {
                update_row('users', (int) $me['id'], $data);
                flash('success', 'Your account has been updated.');
            }
            redirect('admin/account');
        }
        admin_view('account', ['title' => 'My Account']);
        break;

    case 'cache':
        if ($method === 'POST' && csrf_ok()) {
            $n = cache_clear();
            flash('success', $n . ' cached page' . ($n === 1 ? '' : 's') . ' cleared.');
        }
        redirect('admin');
        break;

    // Image uploads made from inside the CKEditor toolbar (drag-drop or the
    // image button), not tied to any single entity's form submission.
    case 'editor-upload':
        header('Content-Type: application/json');
        if ($method !== 'POST' || !csrf_ok()) {
            http_response_code(419);
            echo json_encode(['error' => ['message' => 'Your session expired. Please reload the page and try again.']]);
            exit;
        }
        $res = handle_upload($_FILES['upload'] ?? []);
        if (!$res['ok']) {
            http_response_code(422);
            echo json_encode(['error' => ['message' => $res['error']]]);
            exit;
        }
        echo json_encode(['url' => media($res['path'])]);
        exit;

    default:
        http_response_code(404);
        admin_view('404', ['title' => 'Not found']);
}
