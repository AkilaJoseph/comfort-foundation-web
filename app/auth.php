<?php
/** Comfort Foundation — admin authentication. */

declare(strict_types=1);

function auth_user(): ?array
{
    static $user = null;
    if ($user !== null) {
        return $user ?: null;
    }
    $id = (int) ($_SESSION['admin_id'] ?? 0);
    if ($id <= 0) {
        $user = false;
        return null;
    }
    $user = one('SELECT id, name, email, role FROM users WHERE id = ? LIMIT 1', [$id]) ?: false;
    if (!$user) {
        unset($_SESSION['admin_id']);
    }
    return $user ?: null;
}

function auth_check(): bool
{
    return auth_user() !== null;
}

function auth_require(): void
{
    if (!auth_check()) {
        // Store the target app-relative. REQUEST_URI still carries base_path,
        // and redirect() runs it through url(), which prepends base_path
        // again — on a subfolder install that produced /sub/sub/admin/... and
        // signing in dumped you on a 404 instead of the dashboard.
        $uri  = (string) ($_SERVER['REQUEST_URI'] ?? '');
        $base = base_path();
        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }
        $_SESSION['after_login'] = $uri;
        redirect('admin/login');
    }
}

function auth_attempt(string $email, string $password): bool
{
    $row = one('SELECT id, password_hash FROM users WHERE email = ? LIMIT 1', [$email]);
    if (!$row || !password_verify($password, (string) $row['password_hash'])) {
        // Constant-ish time even when the account does not exist.
        password_verify($password, '$2y$10$usesomesillystringfore7hnbRJHxXVLeakoG8K30M1MlGPL5F6');
        return false;
    }
    if (password_needs_rehash((string) $row['password_hash'], PASSWORD_DEFAULT)) {
        update_row('users', (int) $row['id'], ['password_hash' => password_hash($password, PASSWORD_DEFAULT)]);
    }
    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int) $row['id'];
    update_row('users', (int) $row['id'], ['last_login_at' => date('Y-m-d H:i:s')]);
    return true;
}

function auth_logout(): void
{
    unset($_SESSION['admin_id']);
    session_regenerate_id(true);
}

/** Throttle failed logins per session. */
function login_locked(): bool
{
    $fails = (int) ($_SESSION['login_fails'] ?? 0);
    $until = (int) ($_SESSION['login_until'] ?? 0);
    return $fails >= 5 && time() < $until;
}

function login_failed(): void
{
    $_SESSION['login_fails'] = (int) ($_SESSION['login_fails'] ?? 0) + 1;
    if ((int) $_SESSION['login_fails'] >= 5) {
        $_SESSION['login_until'] = time() + 300;
    }
}

function login_succeeded(): void
{
    unset($_SESSION['login_fails'], $_SESSION['login_until']);
}
