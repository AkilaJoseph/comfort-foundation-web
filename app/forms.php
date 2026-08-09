<?php
/**
 * Comfort Foundation — public form handling.
 * Contact, volunteer, partner, pledge and newsletter submissions.
 * Every submission is stored in the database and emailed to the office.
 */

declare(strict_types=1);

function handle_form_post(string $route): void
{
    $form = post('form');
    if ($form === '') {
        return;
    }

    if (!csrf_ok()) {
        flash('error', 'Your session expired. Please try again.');
        redirect($route);
    }

    // Honeypot — real people never fill this in.
    if (post('website') !== '') {
        flash('success', 'Thank you. Your message has been received.');
        redirect($route);
    }

    if (!throttle_ok($form, 15)) {
        flash('error', 'Please wait a moment before sending another message.');
        redirect($route);
    }

    if (!db_ready()) {
        flash('error', 'The site is not fully configured yet. Please contact us by phone.');
        redirect($route);
    }

    switch ($form) {
        case 'contact':    handle_contact($route);    break;
        case 'volunteer':  handle_volunteer($route);  break;
        case 'partner':    handle_partner($route);    break;
        case 'pledge':     handle_pledge($route);     break;
        case 'newsletter': handle_newsletter($route); break;
        default:
            redirect($route);
    }
}

/** Shared validation for name / email / phone. */
function validate_basics(array &$errors): array
{
    $name  = post('name');
    $email = post('email');
    $phone = post('phone');

    if (mb_strlen($name) < 2) {
        $errors[] = 'Please enter your name.';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if ($email === '' && $phone === '') {
        $errors[] = 'Please give us either an email address or a phone number so we can reply.';
    }
    if ($phone !== '' && !preg_match('/^[0-9+()\s\-]{7,25}$/', $phone)) {
        $errors[] = 'Please enter a valid phone number.';
    }

    return ['name' => $name, 'email' => $email, 'phone' => $phone];
}

function fail_with(array $errors, string $route): void
{
    flash('error', implode(' ', $errors));
    $_SESSION['old'] = $_POST;
    redirect($route);
}

// ---------------------------------------------------------------------

function handle_contact(string $route): void
{
    $errors = [];
    $b      = validate_basics($errors);
    $message = post('message');
    if (mb_strlen($message) < 10) {
        $errors[] = 'Please write a slightly longer message.';
    }
    if ($errors) {
        fail_with($errors, $route);
    }

    store_submission('contact', [
        'name'    => $b['name'],
        'email'   => $b['email'],
        'phone'   => $b['phone'],
        'subject' => post('subject', 'Website enquiry'),
        'message' => $message,
    ]);

    send_notification('Website enquiry — ' . $b['name'], [
        'Name'    => $b['name'],
        'Email'   => $b['email'],
        'Phone'   => $b['phone'],
        'Subject' => post('subject'),
        'Message' => $message,
    ], $b['email']);

    unset($_SESSION['old']);
    flash('success', 'Thank you for getting in touch. Our team will respond shortly.');
    redirect($route);
}

function handle_volunteer(string $route): void
{
    $errors = [];
    $b      = validate_basics($errors);
    $areas  = $_POST['areas'] ?? [];
    $areas  = is_array($areas) ? array_map('strval', $areas) : [];
    if (!$areas) {
        $errors[] = 'Please choose at least one area you would like to support.';
    }
    if ($errors) {
        fail_with($errors, $route);
    }

    $payload = [
        'age_group'     => post('age_group'),
        'location'      => post('location'),
        'occupation'    => post('occupation'),
        'availability'  => post('availability'),
        'areas'         => $areas,
        'experience'    => post('experience'),
    ];

    store_submission('volunteer', [
        'name'    => $b['name'],
        'email'   => $b['email'],
        'phone'   => $b['phone'],
        'subject' => 'Volunteer application',
        'message' => post('message'),
        'payload' => $payload,
    ]);

    send_notification('Volunteer application — ' . $b['name'], [
        'Name'          => $b['name'],
        'Email'         => $b['email'],
        'Phone'         => $b['phone'],
        'Age group'     => $payload['age_group'],
        'Location'      => $payload['location'],
        'Occupation'    => $payload['occupation'],
        'Availability'  => $payload['availability'],
        'Areas'         => $areas,
        'Experience'    => $payload['experience'],
        'Message'       => post('message'),
    ], $b['email']);

    unset($_SESSION['old']);
    flash('success', 'Thank you for offering your time. We will be in touch about the next volunteer intake.');
    redirect($route);
}

function handle_partner(string $route): void
{
    $errors = [];
    $b      = validate_basics($errors);
    $org    = post('organisation');
    if (mb_strlen($org) < 2) {
        $errors[] = 'Please tell us the name of your organisation.';
    }
    if ($errors) {
        fail_with($errors, $route);
    }

    $payload = [
        'organisation' => $org,
        'org_type'     => post('org_type'),
        'website'      => post('org_website'),
        'interest'     => post('interest'),
    ];

    store_submission('partner', [
        'name'    => $b['name'],
        'email'   => $b['email'],
        'phone'   => $b['phone'],
        'subject' => 'Partnership enquiry — ' . $org,
        'message' => post('message'),
        'payload' => $payload,
    ]);

    send_notification('Partnership enquiry — ' . $org, [
        'Contact'      => $b['name'],
        'Organisation' => $org,
        'Type'         => $payload['org_type'],
        'Website'      => $payload['website'],
        'Email'        => $b['email'],
        'Phone'        => $b['phone'],
        'Interest'     => $payload['interest'],
        'Message'      => post('message'),
    ], $b['email']);

    unset($_SESSION['old']);
    flash('success', 'Thank you. We will review your enquiry and respond with next steps.');
    redirect($route);
}

function handle_pledge(string $route): void
{
    $errors = [];
    $b      = validate_basics($errors);
    $amount = post('amount');
    if ($amount !== '' && !preg_match('/^[0-9][0-9,\.\s]*$/', $amount)) {
        $errors[] = 'Please enter the amount in numbers only.';
    }
    if ($errors) {
        fail_with($errors, $route);
    }

    $payload = [
        'amount'      => $amount,
        'currency'    => post('currency', 'TZS'),
        'method'      => post('method'),
        'designation' => post('designation'),
        'frequency'   => post('frequency'),
        'anonymous'   => post('anonymous') === '1' ? 'Yes' : 'No',
    ];

    store_submission('pledge', [
        'name'    => $b['name'],
        'email'   => $b['email'],
        'phone'   => $b['phone'],
        'subject' => 'Donation pledge',
        'message' => post('message'),
        'payload' => $payload,
    ]);

    send_notification('Donation pledge — ' . $b['name'], [
        'Name'        => $b['name'],
        'Email'       => $b['email'],
        'Phone'       => $b['phone'],
        'Amount'      => trim($payload['currency'] . ' ' . $amount),
        'Method'      => $payload['method'],
        'Designation' => $payload['designation'],
        'Frequency'   => $payload['frequency'],
        'Anonymous'   => $payload['anonymous'],
        'Note'        => post('message'),
    ], $b['email']);

    unset($_SESSION['old']);
    flash('success', 'Thank you for your pledge. Our team will contact you to confirm and issue an acknowledgement.');
    redirect($route);
}

function handle_newsletter(string $route): void
{
    $email = post('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('error', 'Please enter a valid email address.');
        redirect($route);
    }
    $exists = one('SELECT id FROM submissions WHERE kind = ? AND email = ? LIMIT 1', ['newsletter', $email]);
    if (!$exists) {
        store_submission('newsletter', ['email' => $email, 'subject' => 'Newsletter signup']);
        send_notification('Newsletter signup', ['Email' => $email]);
    }
    flash('success', 'You are subscribed. Thank you for following our work.');
    redirect($route);
}

/** Repopulate a form field after a validation failure. */
function old(string $key, string $default = ''): string
{
    $v = $_SESSION['old'][$key] ?? $default;
    return is_string($v) ? $v : $default;
}

/** Was this checkbox/select value previously chosen? */
function old_has(string $key, string $value): bool
{
    $v = $_SESSION['old'][$key] ?? null;
    if (is_array($v)) {
        return in_array($value, $v, true);
    }
    return (string) $v === $value;
}

function clear_old(): void
{
    unset($_SESSION['old']);
}
