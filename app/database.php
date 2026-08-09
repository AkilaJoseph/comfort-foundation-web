<?php
/**
 * Comfort Foundation — thin PDO wrapper.
 * All queries in the application go through db(), q(), one() and all().
 */

declare(strict_types=1);

/** Shared PDO connection (lazily opened). */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfg = $GLOBALS['cf_config']['db'];

    // A full DSN may be supplied directly (some hosts require a socket
    // path or a non-standard port). Otherwise one is built from the
    // host / name / charset values.
    $dsn = trim((string) ($cfg['dsn'] ?? ''));
    if ($dsn === '') {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $cfg['host'],
            $cfg['name'],
            $cfg['charset'] ?? 'utf8mb4'
        );
    }

    try {
        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_STRINGIFY_FETCHES  => false,
        ]);
    } catch (PDOException $e) {
        error_log('[Comfort Foundation] DB connection failed: ' . $e->getMessage());
        if (!empty($GLOBALS['cf_config']['debug'])) {
            http_response_code(500);
            exit('Database connection failed: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
        }
        http_response_code(503);
        exit('The site is temporarily unavailable. Please try again shortly.');
    }

    return $pdo;
}

/** Run a prepared statement and return it. */
function q(string $sql, array $params = []): PDOStatement
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/** Fetch a single row, or null. */
function one(string $sql, array $params = []): ?array
{
    $row = q($sql, $params)->fetch();
    return $row === false ? null : $row;
}

/** Fetch all rows. */
function all(string $sql, array $params = []): array
{
    return q($sql, $params)->fetchAll();
}

/** Fetch a single scalar value. */
function scalar(string $sql, array $params = [], $default = null)
{
    $v = q($sql, $params)->fetchColumn();
    return $v === false ? $default : $v;
}

/** Insert a row into $table from an associative array; returns the new id. */
function insert_row(string $table, array $data): int
{
    $cols = array_keys($data);
    $sql  = sprintf(
        'INSERT INTO `%s` (%s) VALUES (%s)',
        $table,
        '`' . implode('`,`', $cols) . '`',
        implode(',', array_fill(0, count($cols), '?'))
    );
    q($sql, array_values($data));
    return (int) db()->lastInsertId();
}

/** Update a row by primary key id. */
function update_row(string $table, int $id, array $data): void
{
    if (!$data) {
        return;
    }
    $sets = [];
    foreach (array_keys($data) as $c) {
        $sets[] = "`{$c}` = ?";
    }
    $params   = array_values($data);
    $params[] = $id;
    q(sprintf('UPDATE `%s` SET %s WHERE `id` = ?', $table, implode(', ', $sets)), $params);
}

/** Delete a row by id. */
function delete_row(string $table, int $id): void
{
    q(sprintf('DELETE FROM `%s` WHERE `id` = ?', $table), [$id]);
}

/** True when the schema has been imported. */
function db_ready(): bool
{
    static $ready = null;
    if ($ready !== null) {
        return $ready;
    }
    try {
        db()->query('SELECT 1 FROM `settings` LIMIT 1');
        $ready = true;
    } catch (Throwable $e) {
        $ready = false;
    }
    return $ready;
}
