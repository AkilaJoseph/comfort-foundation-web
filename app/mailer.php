<?php
/**
 * Comfort Foundation — outbound notification mail.
 * Uses PHP mail(); failures are logged and never shown to the visitor,
 * because every submission is also stored in the database.
 */

declare(strict_types=1);

function notify_email(): string
{
    $s = setting('notification_email');
    return $s !== '' ? $s : (string) ($GLOBALS['cf_config']['mail_to'] ?? '');
}

function send_notification(string $subject, array $fields, string $replyTo = ''): bool
{
    $to = notify_email();
    if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $from = (string) ($GLOBALS['cf_config']['mail_from'] ?? $to);
    $site = setting('site_name', 'Comfort Foundation');

    $lines = ['New submission from the ' . $site . ' website.', str_repeat('-', 52), ''];
    foreach ($fields as $label => $value) {
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        $value = trim((string) $value);
        if ($value === '') {
            continue;
        }
        $lines[] = $label . ': ' . $value;
    }
    $lines[] = '';
    $lines[] = str_repeat('-', 52);
    $lines[] = 'Received ' . date('D, j M Y H:i') . ' (EAT)';
    $body    = implode("\r\n", $lines);

    $headers = [
        'From: ' . $site . ' <' . $from . '>',
        'Content-Type: text/plain; charset=UTF-8',
        'MIME-Version: 1.0',
        'X-Mailer: ComfortFoundation',
    ];
    if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $replyTo;
    }

    // Guard against header injection through the subject line.
    $subject = str_replace(["\r", "\n"], ' ', $subject);

    $ok = @mail($to, $subject, $body, implode("\r\n", $headers), '-f' . $from);
    if (!$ok) {
        error_log('[Comfort Foundation] mail() failed for: ' . $subject);
    }
    return (bool) $ok;
}
